<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configurar conexión a la base de datos
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => $_ENV['DB_CONNECTION'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Desactivar restricciones de clave foránea
Capsule::connection()->statement('SET FOREIGN_KEY_CHECKS=0');

// Eliminar todas las tablas
$tables = [
    'bibliografias_disponibles',
    'sitios_web',
    'software',
    'articulos',
    'libros',
    'bibliografia_autor',
    'bibliografias_declaradas',
    'autores',
    'asignaturas',
    'carreras_espejos',
    'carreras',
    'sedes',
    'facultades',
    'departamentos'
];

foreach ($tables as $table) {
    try {
        Capsule::schema()->dropIfExists($table);
        echo "Tabla {$table} eliminada.\n";
    } catch (Exception $e) {
        echo "Error al eliminar la tabla {$table}: " . $e->getMessage() . "\n";
    }
}

// Reactivar restricciones de clave foránea
Capsule::connection()->statement('SET FOREIGN_KEY_CHECKS=1');

echo "Todas las tablas han sido eliminadas.\n"; 