<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Database\Seeders\DepartamentoSeeder;
use Database\Seeders\FacultadSeeder;
use Database\Seeders\SedeSeeder;
use Database\Seeders\CarreraSeeder;
use Database\Seeders\AsignaturaSeeder;
use Database\Seeders\AutorSeeder;
use Database\Seeders\BibliografiaDeclaradaSeeder;
use Database\Seeders\LibroSeeder;
use Database\Seeders\ArticuloSeeder;
use Database\Seeders\SoftwareSeeder;
use Database\Seeders\SitioWebSeeder;
use Database\Seeders\BibliografiaDisponibleSeeder;

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

// Ejecutar seeders en orden
try {
    $seeders = [
        new SedeSeeder(),
        new FacultadSeeder(),
        new DepartamentoSeeder(),
        new CarreraSeeder(),
        new AsignaturaSeeder(),
        new AutorSeeder(),
        new BibliografiaDeclaradaSeeder(),
        new LibroSeeder(),
        new ArticuloSeeder(),
        new SoftwareSeeder(),
        new SitioWebSeeder(),
        new BibliografiaDisponibleSeeder()
    ];

    foreach ($seeders as $seeder) {
        echo "Ejecutando " . get_class($seeder) . "...\n";
        try {
            $seeder->run();
            echo "Completado.\n";
        } catch (Exception $e) {
            echo "Error al ejecutar " . get_class($seeder) . ": " . $e->getMessage() . "\n";
            echo "Archivo: " . $e->getFile() . "\n";
            echo "Línea: " . $e->getLine() . "\n";
            echo "Traza:\n" . $e->getTraceAsString() . "\n";
        }
    }

    echo "Todos los seeders han sido ejecutados exitosamente.\n";
} catch (Exception $e) {
    echo "Error general: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Traza:\n" . $e->getTraceAsString() . "\n";
} 