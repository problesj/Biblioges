<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
        }
    }
}

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'] ?? 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? 'localhost',
    'database'  => $_ENV['DB_DATABASE'] ?? 'bibliografia',
    'username'  => $_ENV['DB_USERNAME'] ?? 'biblioges',
    'password'  => $_ENV['DB_PASSWORD'] ?? 'joyal2025$',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Desactivar restricciones de clave foránea
Capsule::connection()->statement('SET FOREIGN_KEY_CHECKS=0');

// Obtener todas las tablas de la base de datos
$tables = Capsule::connection()->select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "Eliminando tabla: $tableName\n";
    try {
        Capsule::schema()->drop($tableName);
    } catch (Exception $e) {
        echo "No se pudo eliminar $tableName (puede que no exista o sea una vista): " . $e->getMessage() . "\n";
    }
}

// Reactivar restricciones de clave foránea
Capsule::connection()->statement('SET FOREIGN_KEY_CHECKS=1');

// Ejecutar migraciones
$migrations = glob(__DIR__ . '/migrations/*.php');
sort($migrations);

foreach ($migrations as $migration) {
    require_once $migration;
    $class = require $migration;
    $class->up();
    echo "Migración ejecutada: " . basename($migration) . "\n";
}

echo "Todas las migraciones ejecutadas correctamente.\n"; 