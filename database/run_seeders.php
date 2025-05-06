<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Database\Seeders\SedeSeeder;
use Database\Seeders\FacultadSeeder;
use Database\Seeders\DepartamentoSeeder;
use Database\Seeders\CarreraSeeder;
use Database\Seeders\AsignaturaSeeder;
use Database\Seeders\BibliografiaDeclaradaSeeder;
use Database\Seeders\BibliografiaDisponibleSeeder;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar la conexión a la base de datos
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'],
    'host'      => $_ENV['DB_HOST'],
    'port'      => $_ENV['DB_PORT'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "Iniciando ejecución de seeders...\n";

$seeders = [
    new SedeSeeder(),
    new FacultadSeeder(),
    new DepartamentoSeeder(),
    new CarreraSeeder(),
    new AsignaturaSeeder(),
    new BibliografiaDeclaradaSeeder(),
    new BibliografiaDisponibleSeeder()
];

foreach ($seeders as $seeder) {
    try {
        echo "Ejecutando " . get_class($seeder) . "...\n";
        $seeder->run();
        echo "Completado " . get_class($seeder) . "\n";
    } catch (\Exception $e) {
        echo "Error en " . get_class($seeder) . ": " . $e->getMessage() . "\n";
    }
}

echo "Proceso de seeding completado.\n"; 