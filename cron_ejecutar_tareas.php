<?php
/**
 * Ejecuta las tareas programadas vencidas (coberturas básica / complementaria).
 * Uso: en el crontab de webadm, cada 5 minutos:
 *   /usr/bin/php /var/www/html/biblioges/cron_ejecutar_tareas.php >> /var/log/cron_tareas.log 2>&1
 *
 * La lógica está en App\Services\EjecutorTareas (la misma que usa "Ejecutar ahora" en la web).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

// El PHP de línea de comandos puede venir en UTC; las fechas de las tareas están en hora de Chile.
date_default_timezone_set('America/Santiago');

// Evita que dos ejecuciones del cron se solapen
$candado = fopen(sys_get_temp_dir() . '/biblioges_cron_tareas.lock', 'c');
if ($candado === false || !flock($candado, LOCK_EX | LOCK_NB)) {
    echo '[' . date('Y-m-d H:i:s') . "] Otra ejecución del cron sigue en curso; se omite.\n";
    exit(0);
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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

$log = static function (string $mensaje): void {
    echo '[' . date('Y-m-d H:i:s') . '] ' . $mensaje . "\n";
};

try {
    $resultados = (new App\Services\EjecutorTareas($log))->ejecutarPendientes();
    if ($resultados) {
        $errores = count(array_filter($resultados, static fn ($r) => !$r['exito']));
        $log('Proceso completado: ' . count($resultados) . ' tarea(s), ' . $errores . ' con errores.');
    }
    // Las copias desde Alma tardan más de una hora: corren en un proceso aparte
    if (App\Services\ActualizadorCopiasAlma::hayPendientes() && !App\Services\ActualizadorCopiasAlma::hayEnProceso()) {
        $log('Iniciando actualización de copias desde Alma en segundo plano.');
        App\Services\ActualizadorCopiasAlma::lanzarEnSegundoPlano();
    }
    exit(0);
} catch (\Throwable $e) {
    $log('Error general: ' . $e->getMessage());
    exit(1);
}
// El candado se libera automáticamente al terminar el proceso.
