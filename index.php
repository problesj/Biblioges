<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener estadísticas
$stats = [
    'bibliografias' => $pdo->query("SELECT COUNT(*) FROM bibliografias_declaradas")->fetchColumn(),
    'asignaturas' => $pdo->query("SELECT COUNT(*) FROM asignaturas WHERE estado = 1")->fetchColumn(),
    'carreras' => $pdo->query("SELECT COUNT(*) FROM carreras")->fetchColumn(),
    'usuarios' => $pdo->query("SELECT COUNT(*) FROM usuarios WHERE estado = 1")->fetchColumn()
];

// Obtener bibliografías recientes
$bibliografias = $pdo->query("
    SELECT b.*, a.nombre as asignatura_nombre 
    FROM bibliografias_declaradas b 
    LEFT JOIN asignaturas a ON b.asignatura_id = a.id 
    ORDER BY b.fecha_creacion DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Cargar la plantilla
require_once __DIR__ . '/templates/dashboard.twig'; 