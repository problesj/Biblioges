<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} else {
    fwrite(STDERR, "Falta el archivo .env: configure las credenciales de la base de datos\n");
    exit(1);
}

// Configuración de la base de datos ROOT (para crear usuario y base de datos)
$rootConfig = [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? '3306',
    'user' => 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '' // Se asume que el root usa la misma contraseña, ajustar si es necesario
];

// Datos de producción
$prodDbName = $_ENV['DB_DATABASE'] ?? 'bibliografia';
$prodUser = $_ENV['DB_USERNAME'] ?? 'biblioges';
$prodPassword = $_ENV['DB_PASSWORD'] ?? '';

try {
    // Conectar a MySQL como root sin seleccionar base de datos
    $pdo = new PDO(
        "mysql:host={$rootConfig['host']};port={$rootConfig['port']};charset=utf8mb4",
        $rootConfig['user'],
        $rootConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "Conectado como root. Creando base de datos de producción...\n";
    echo "Host: {$rootConfig['host']}:{$rootConfig['port']}\n";
    echo "Base de datos: {$prodDbName}\n";
    echo "Usuario: {$prodUser}\n";

    // Crear base de datos de producción si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$prodDbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de datos '{$prodDbName}' creada/verificada.\n";

    // Crear usuario de producción si no existe
    $pdo->exec("CREATE USER IF NOT EXISTS '{$prodUser}'@'%' IDENTIFIED BY '{$prodPassword}'");
    echo "Usuario '{$prodUser}' creado/verificado.\n";

    // Otorgar todos los privilegios al usuario sobre la base de datos de producción
    $pdo->exec("GRANT ALL PRIVILEGES ON {$prodDbName}.* TO '{$prodUser}'@'%'");
    $pdo->exec("FLUSH PRIVILEGES");
    echo "Privilegios otorgados a '{$prodUser}' sobre '{$prodDbName}'.\n";

    // Cambiar a la base de datos de producción
    $pdo->exec("USE {$prodDbName}");

    // Leer el esquema y dividirlo en sentencias (respeta DELIMITER, necesario para los triggers)
    require_once __DIR__ . '/lib/dividir_sql.php';
    $sentencias = dividirSentenciasSql(file_get_contents(__DIR__ . '/schema.sql'));
    $maxRetries = 3;

    for ($retryCount = 0; $retryCount <= $maxRetries && $sentencias; $retryCount++) {
        if ($retryCount > 0) {
            echo "\n🔄 Reintento #{$retryCount} de declaraciones con dependencias...\n";
        }
        $pendientes = [];
        foreach ($sentencias as $statement) {
            if (preg_match('/^(DROP DATABASE|CREATE DATABASE|USE)\s+/i', $statement)) {
                echo "Saltando comando de base de datos: " . substr($statement, 0, 50) . "...\n";
                continue;
            }
            try {
                $pdo->exec($statement);
                echo "Ejecutado: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                $errorMsg = $e->getMessage();
                if (strpos($errorMsg, 'already exists') !== false) {
                    echo "Ignorando (ya existe): " . substr($statement, 0, 50) . "...\n";
                } elseif (strpos($errorMsg, 'Failed to open the referenced table') !== false ||
                          strpos($errorMsg, "doesn't exist") !== false ||
                          strpos($errorMsg, 'Base table or view not found') !== false) {
                    echo "⚠️  Error de dependencia: " . substr($statement, 0, 50) . "... Se reintentará.\n";
                    $pendientes[] = $statement;
                } else {
                    echo "Error ejecutando: " . substr($statement, 0, 50) . "...\n";
                    echo "Error: " . $errorMsg . "\n";
                }
            }
        }
        $sentencias = $pendientes;
    }
    if ($sentencias) {
        echo "\n❌ Las siguientes declaraciones no se pudieron ejecutar después de {$maxRetries} reintentos:\n";
        foreach ($sentencias as $failedStatement) {
            echo "   - " . substr($failedStatement, 0, 80) . "...\n";
        }
    }
    echo "\n📊 Verificando tablas creadas...\n";
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "✅ Tablas creadas exitosamente (" . count($tables) . "):\n";
        foreach ($tables as $table) {
            echo "   - {$table}\n";
        }
        $expectedTables = ['reportes', 'reporte_coberturas_carreras_basicas', 'reporte_coberturas_carreras_complementarias'];
        echo "\n🔍 Verificando tablas críticas:\n";
        foreach ($expectedTables as $expectedTable) {
            if (in_array($expectedTable, $tables)) {
                echo "   ✅ {$expectedTable} - EXISTE\n";
            } else {
                echo "   ❌ {$expectedTable} - NO EXISTE\n";
            }
        }
    } catch (PDOException $e) {
        echo "Error verificando tablas: " . $e->getMessage() . "\n";
    }
    $seederFile = __DIR__ . '/seeders/DatabaseSeeder.php';
    if (file_exists($seederFile)) {
        require_once $seederFile;
        if (class_exists('DatabaseSeeder')) {
            $seeder = new DatabaseSeeder();
            $seeder->run();
        }
    }
    echo "\n=== RESUMEN ===\n";
    echo "Base de datos de producción: {$prodDbName}\n";
    echo "Usuario creado: {$prodUser}\n";
    echo "Host: {$rootConfig['host']}:{$rootConfig['port']}\n";
    echo "\nBase de datos de producción inicializada correctamente.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 