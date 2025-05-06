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

// Crear el esquema si no existe
$capsule->getConnection()->statement('CREATE DATABASE IF NOT EXISTS ' . $_ENV['DB_DATABASE']);
$capsule->getConnection()->statement('USE ' . $_ENV['DB_DATABASE']);

// Ejecutar migraciones
require_once __DIR__ . '/database/migrations/2024_04_17_000000_create_all_tables.php';

$migration = new class extends Illuminate\Database\Migrations\Migration {
    public function up(): void
    {
        $migration = require __DIR__ . '/database/migrations/2024_04_17_000000_create_all_tables.php';
        $migration->up();
        echo "Migraciones ejecutadas exitosamente.\n";
    }
};

$migration->up(); 