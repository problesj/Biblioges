<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuración de la base de datos
$dbConfig = [
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];

echo "=== Verificación de Base de Datos ===\n";

try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "✓ Conexión a la base de datos exitosa\n";

    // Verificar tabla de usuarios
    $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Tabla 'usuarios' existe\n";

        // Verificar estructura de la tabla
        $stmt = $pdo->query("DESCRIBE usuarios");
        $columns = $stmt->fetchAll();
        echo "Estructura de la tabla 'usuarios':\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }

        // Verificar usuarios existentes
        $stmt = $pdo->query("SELECT id, email, estado FROM usuarios");
        $usuarios = $stmt->fetchAll();
        echo "\nUsuarios en la base de datos:\n";
        foreach ($usuarios as $usuario) {
            echo "- ID: {$usuario['id']}, Email: {$usuario['email']}, Estado: {$usuario['estado']}\n";
        }
    } else {
        echo "✗ Tabla 'usuarios' no existe\n";
    }

} catch (PDOException $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "\n";
} 