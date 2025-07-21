<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuración de la base de datos
$dbConfig = [
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];

try {
    // Conectar a MySQL sin seleccionar base de datos
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset=utf8mb4",
        $dbConfig['user'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Crear base de datos si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$dbConfig['dbname']} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE {$dbConfig['dbname']}");

    // Leer el esquema
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    
    // Separar el contenido en bloques por DELIMITER
    $blocks = preg_split('/DELIMITER\s+[^;]+/', $schema);
    $delimiters = [];
    preg_match_all('/DELIMITER\s+([^;\s]+)/', $schema, $delimiters);
    
    $currentDelimiter = ';';
    $blockIndex = 0;
    
    foreach ($blocks as $block) {
        $block = trim($block);
        if (empty($block)) continue;
        
        // Determinar el delimitador actual
        if (isset($delimiters[1][$blockIndex - 1])) {
            $currentDelimiter = $delimiters[1][$blockIndex - 1];
        }
        
        // Dividir por el delimitador actual
        $statements = array_filter(array_map('trim', explode($currentDelimiter, $block)));
        
        foreach ($statements as $statement) {
            if (empty($statement)) continue;
            
            // Filtrar comandos problemáticos
            if (preg_match('/^(DROP DATABASE|CREATE DATABASE|USE)/i', $statement)) {
                echo "Saltando comando: " . substr($statement, 0, 50) . "...\n";
                continue;
            }
            
            try {
                $pdo->exec($statement);
                echo "Ejecutado: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                // Ignorar errores de tablas que ya existen o foreign keys
                if (strpos($e->getMessage(), 'already exists') !== false || 
                    strpos($e->getMessage(), 'foreign key') !== false ||
                    strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
                    echo "Ignorando error (esperado): " . substr($statement, 0, 50) . "...\n";
                } else {
                    echo "Error ejecutando: " . substr($statement, 0, 50) . "...\n";
                    echo "Error: " . $e->getMessage() . "\n";
                }
            }
        }
        
        $blockIndex++;
    }

    // Ejecutar seeders si existe
    $seederFile = __DIR__ . '/seeders/DatabaseSeeder.php';
    if (file_exists($seederFile)) {
        require_once $seederFile;
        if (class_exists('DatabaseSeeder')) {
            $seeder = new DatabaseSeeder();
            $seeder->run();
        }
    }

    echo "Base de datos inicializada correctamente.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 