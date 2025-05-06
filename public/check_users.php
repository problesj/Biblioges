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

echo "=== Verificación de Usuarios ===\n";

try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Obtener todos los usuarios
    $stmt = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll();

    echo "Usuarios en la base de datos:\n";
    foreach ($usuarios as $usuario) {
        echo "\nUsuario ID: {$usuario['id']}\n";
        echo "Nombre: {$usuario['nombre']}\n";
        echo "Email: {$usuario['email']}\n";
        echo "Rol: {$usuario['rol']}\n";
        echo "Estado: " . ($usuario['estado'] ? 'Activo' : 'Inactivo') . "\n";
        echo "Password Hash: {$usuario['password']}\n";
        
        // Verificar si el hash es válido
        if (password_verify('password', $usuario['password'])) {
            echo "✓ La contraseña 'password' es válida para este usuario\n";
        } else {
            echo "✗ La contraseña 'password' no es válida para este usuario\n";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 