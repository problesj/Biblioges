<?php
/**
 * Instalación de la base de datos de Biblioges en un servidor nuevo.
 *
 * Crea la base de datos y el usuario de la aplicación definidos en .env, carga database/schema.sql
 * (tablas, vistas, triggers y datos requeridos) y, opcionalmente, los datos de ejemplo.
 *
 *   php database/init_db.php                  # base de datos + usuario + esquema
 *   php database/init_db.php --datos-ejemplo  # además carga database/datos_ejemplo.sql (solo desarrollo)
 *
 * Variables de .env usadas: DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD y una cuenta
 * de MySQL con permisos para crear bases de datos y usuarios: DB_ROOT_USERNAME / DB_ROOT_PASSWORD
 * (si no están definidas se usa "root" con DB_PASSWORD).
 *
 * Después cree el primer administrador con:  php database/crear_admin.php
 * Para actualizar una base existente use los scripts de migración database/AAAA-MM-*.sql.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

$raiz = dirname(__DIR__);
require_once $raiz . '/vendor/autoload.php';
require_once __DIR__ . '/lib/dividir_sql.php';

if (!is_file($raiz . '/.env')) {
    fwrite(STDERR, "Falta el archivo .env: configure las credenciales de la base de datos\n");
    exit(1);
}
Dotenv\Dotenv::createImmutable($raiz)->load();

function cfg(string $clave, string $porDefecto = ''): string
{
    $valor = $_ENV[$clave] ?? getenv($clave);

    return ($valor === false || $valor === null || $valor === '') ? $porDefecto : (string) $valor;
}

/**
 * Ejecuta un archivo SQL sentencia por sentencia. Reintenta las que fallan por dependencias
 * (vistas o tablas que aún no existen). Devuelve la cantidad de sentencias con error.
 */
function ejecutarArchivoSql(PDO $pdo, string $archivo, int $maxReintentos = 3): int
{
    $sentencias = dividirSentenciasSql(file_get_contents($archivo));
    $total = count($sentencias);
    $errores = [];
    for ($intento = 0; $intento <= $maxReintentos && $sentencias; $intento++) {
        $pendientes = [];
        $errores = [];
        foreach ($sentencias as $sentencia) {
            if (preg_match('/^(DROP DATABASE|CREATE DATABASE|USE)\s+/i', $sentencia)) {
                continue;
            }
            try {
                $pdo->exec($sentencia);
            } catch (PDOException $e) {
                $mensaje = $e->getMessage();
                if (strpos($mensaje, "doesn't exist") !== false
                    || strpos($mensaje, 'Failed to open the referenced table') !== false
                    || strpos($mensaje, 'Base table or view not found') !== false) {
                    $pendientes[] = $sentencia;
                }
                $errores[] = substr(preg_replace('/\s+/', ' ', $sentencia), 0, 70) . ' => ' . $mensaje;
            }
        }
        // Solo se reintentan los errores de dependencias; el resto se informa al final
        if (count($pendientes) === count($errores)) {
            $sentencias = $pendientes;
        } else {
            break;
        }
    }
    echo '  ' . basename($archivo) . ": $total sentencias, " . count($errores) . " con error\n";
    foreach ($errores as $error) {
        echo "  ✗ $error\n";
    }

    return count($errores);
}

$host = cfg('DB_HOST', 'localhost');
$puerto = cfg('DB_PORT', '3306');
$baseDatos = cfg('DB_DATABASE', 'bibliografia');
$usuarioApp = cfg('DB_USERNAME', 'biblioges');
$claveApp = cfg('DB_PASSWORD');
$usuarioRoot = cfg('DB_ROOT_USERNAME', 'root');
$claveRoot = cfg('DB_ROOT_PASSWORD', $claveApp);
$conDatosEjemplo = in_array('--datos-ejemplo', $argv, true);

foreach (['DB_DATABASE' => $baseDatos, 'DB_USERNAME' => $usuarioApp] as $clave => $valor) {
    if (!preg_match('/^[A-Za-z0-9_]{1,64}$/', $valor)) {
        fwrite(STDERR, "$clave solo puede contener letras, números y guion bajo\n");
        exit(1);
    }
}
if ($claveApp === '') {
    fwrite(STDERR, "DB_PASSWORD está vacío en .env\n");
    exit(1);
}

try {
    $pdo = new PDO("mysql:host=$host;port=$puerto;charset=utf8mb4", $usuarioRoot, $claveRoot, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Conectado a MySQL $host:$puerto como $usuarioRoot\n";

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$baseDatos` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de datos '$baseDatos' creada/verificada\n";

    $pdo->exec('CREATE USER IF NOT EXISTS ' . $pdo->quote($usuarioApp) . "@'%' IDENTIFIED BY " . $pdo->quote($claveApp));
    $pdo->exec("GRANT ALL PRIVILEGES ON `$baseDatos`.* TO " . $pdo->quote($usuarioApp) . "@'%'");
    echo "Usuario '$usuarioApp' creado/verificado con permisos sobre '$baseDatos'\n";

    $pdo->exec("USE `$baseDatos`");

    echo "Cargando esquema...\n";
    $errores = ejecutarArchivoSql($pdo, __DIR__ . '/schema.sql');

    $tablas = $pdo->query('SHOW FULL TABLES')->fetchAll(PDO::FETCH_NUM);
    $tipos = array_count_values(array_column($tablas, 1));
    echo 'Tablas: ' . ($tipos['BASE TABLE'] ?? 0) . ', vistas: ' . ($tipos['VIEW'] ?? 0) . "\n";

    if ($conDatosEjemplo) {
        $conDatos = (int) $pdo->query('SELECT COUNT(*) FROM sedes WHERE id <> 0')->fetchColumn();
        if ($conDatos > 0) {
            echo "Datos de ejemplo NO cargados: la base ya tiene sedes registradas\n";
        } else {
            echo "Cargando datos de ejemplo (solo desarrollo)...\n";
            $errores += ejecutarArchivoSql($pdo, __DIR__ . '/datos_ejemplo.sql');
        }
    }

    echo "\nBase de datos '$baseDatos' lista" . ($errores ? " con $errores error(es); revise los mensajes" : '') . ".\n";
    echo "Siguiente paso: crear el primer administrador con  php database/crear_admin.php\n";
    exit($errores ? 1 : 0);
} catch (PDOException $e) {
    fwrite(STDERR, 'Error: ' . $e->getMessage() . "\n");
    exit(1);
}
