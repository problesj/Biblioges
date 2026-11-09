<?php
/**
 * Ejecuta la tarea de actualización de copias desde Alma como proceso independiente.
 * Lo lanzan cron_ejecutar_tareas.php (tareas vencidas) y "Ejecutar ahora" (--tarea=ID --manual).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helpers.php';
date_default_timezone_set('America/Santiago');
set_time_limit(0);

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'],
    'port'      => $_ENV['DB_PORT'] ?? '3306',
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$opciones = getopt('', ['tarea:', 'manual']);
$actualizador = new App\Services\ActualizadorCopiasAlma();
try {
    if (isset($opciones['tarea'])) {
        $actualizador->ejecutarTarea((int) $opciones['tarea'], isset($opciones['manual']));
    } else {
        $actualizador->ejecutarPendientes();
    }
    exit(0);
} catch (\Throwable $e) {
    error_log('cron_copias_alma: ' . $e->getMessage());
    exit(1);
}
