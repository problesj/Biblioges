<?php
/**
 * Crea un usuario del sistema (por defecto administrador) pidiendo los datos por consola.
 * La contraseña no se muestra al escribirla ni queda en el historial del shell.
 *
 *   php database/crear_admin.php               # crear un usuario nuevo
 *   php database/crear_admin.php --actualizar  # cambiar contraseña/rol de un correo existente
 *
 * Usa la conexión de la aplicación definida en .env (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

$raiz = dirname(__DIR__);
require_once $raiz . '/vendor/autoload.php';
if (is_file($raiz . '/.env')) {
    Dotenv\Dotenv::createImmutable($raiz)->load();
}

const ROLES = ['admin', 'admin_bidoc', 'usuario'];
const LARGO_MINIMO_CLAVE = 8;

function cfg(string $clave, string $porDefecto = ''): string
{
    $valor = $_ENV[$clave] ?? getenv($clave);

    return ($valor === false || $valor === null || $valor === '') ? $porDefecto : (string) $valor;
}

function salir(string $mensaje): void
{
    fwrite(STDERR, $mensaje . "\n");
    exit(1);
}

function preguntar(string $texto, string $porDefecto = ''): string
{
    echo $texto . ($porDefecto !== '' ? " [$porDefecto]" : '') . ': ';
    $linea = fgets(STDIN);
    if ($linea === false) {
        salir("\nEntrada cancelada");
    }
    $linea = trim($linea);

    return $linea === '' ? $porDefecto : $linea;
}

function preguntarOculto(string $texto): string
{
    echo $texto . ': ';
    $esTerminal = function_exists('posix_isatty') ? posix_isatty(STDIN) : true;
    if ($esTerminal) {
        shell_exec('stty -echo 2>/dev/null');
    }
    $linea = fgets(STDIN);
    if ($esTerminal) {
        shell_exec('stty echo 2>/dev/null');
        echo "\n";
    }
    if ($linea === false) {
        salir('Entrada cancelada');
    }

    return rtrim($linea, "\r\n");
}

$actualizar = in_array('--actualizar', $argv, true);

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', cfg('DB_HOST', 'localhost'), cfg('DB_PORT', '3306'), cfg('DB_DATABASE', 'bibliografia')),
        cfg('DB_USERNAME', 'biblioges'),
        cfg('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    salir('No se pudo conectar a la base de datos: ' . $e->getMessage());
}

echo ($actualizar ? 'Actualizar' : 'Crear') . ' usuario en la base de datos ' . cfg('DB_DATABASE', 'bibliografia') . "\n";

$email = mb_strtolower(preguntar('Correo'));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    salir('Correo no válido');
}
$consulta = $pdo->prepare('SELECT id, rol FROM usuarios WHERE email = ?');
$consulta->execute([$email]);
$existente = $consulta->fetch();

if ($existente && !$actualizar) {
    salir("Ya existe un usuario con el correo $email. Para cambiar su contraseña use --actualizar");
}
if (!$existente && $actualizar) {
    salir("No existe un usuario con el correo $email");
}

$rut = $nombre = '';
if (!$existente) {
    $rut = strtoupper(str_replace('.', '', preguntar('RUT (ej. 12345678-9)')));
    if (!preg_match('/^\d{7,8}-[\dK]$/', $rut)) {
        salir('RUT no válido: use el formato 12345678-9, sin puntos');
    }
    $nombre = preguntar('Nombre completo');
    if ($nombre === '' || mb_strlen($nombre) > 250) {
        salir('El nombre es obligatorio (máximo 250 caracteres)');
    }
}

$rol = preguntar('Rol (' . implode(', ', ROLES) . ')', $existente['rol'] ?? 'admin');
if (!in_array($rol, ROLES, true)) {
    salir('Rol no válido');
}

$clave = preguntarOculto('Contraseña (mínimo ' . LARGO_MINIMO_CLAVE . ' caracteres)');
if (mb_strlen($clave) < LARGO_MINIMO_CLAVE) {
    salir('La contraseña debe tener al menos ' . LARGO_MINIMO_CLAVE . ' caracteres');
}
if (!hash_equals($clave, preguntarOculto('Repita la contraseña'))) {
    salir('Las contraseñas no coinciden');
}
$hash = password_hash($clave, PASSWORD_DEFAULT);

if ($existente) {
    $pdo->prepare('UPDATE usuarios SET password = ?, rol = ?, estado = 1 WHERE id = ?')
        ->execute([$hash, $rol, $existente['id']]);
    echo "Usuario $email actualizado (rol $rol).\n";
} else {
    $pdo->prepare('INSERT INTO usuarios (rut, nombre, email, password, rol, estado) VALUES (?, ?, ?, ?, ?, 1)')
        ->execute([$rut, $nombre, $email, $hash, $rol]);
    echo "Usuario $email creado (rol $rol).\n";
}
