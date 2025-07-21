<?php
/**
 * Script de prueba simple para el frontend
 */

// Configuración básica
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Prueba Simple del Frontend</h1>";

// Verificar autoloader
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("<p style='color: red;'>❌ Error: No se encontró el autoloader</p>");
}

echo "<p style='color: green;'>✅ Autoloader encontrado</p>";

// Cargar autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} else {
    $_ENV['DB_HOST'] = '127.0.0.1';
    $_ENV['DB_PORT'] = '3306';
    $_ENV['DB_DATABASE'] = 'bibliografia';
    $_ENV['DB_USERNAME'] = 'biblioges';
    $_ENV['DB_PASSWORD'] = 'joyal2025$';
    $_ENV['APP_URL'] = 'http://192.168.72.5';
}

// Probar conexión a base de datos
try {
    $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Conexión a base de datos exitosa</p>";
    
    // Probar consulta simple
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM sedes WHERE estado = 1");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p style='color: blue;'>📊 Sedes activas: {$count}</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de base de datos: " . $e->getMessage() . "</p>";
}

// Probar controlador
try {
    $controller = new App\Controllers\FrontendController();
    echo "<p style='color: green;'>✅ Controlador creado exitosamente</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al crear controlador: " . $e->getMessage() . "</p>";
}

// Probar Twig
try {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/../cache/twig',
        'auto_reload' => true,
        'debug' => true
    ]);
    
    echo "<p style='color: green;'>✅ Twig configurado exitosamente</p>";
    
    // Probar renderizado simple
    $template = $twig->load('frontend/base.twig');
    echo "<p style='color: green;'>✅ Plantilla base cargada exitosamente</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error con Twig: " . $e->getMessage() . "</p>";
}

// Probar Slim
try {
    $app = \Slim\Factory\AppFactory::create();
    echo "<p style='color: green;'>✅ Aplicación Slim creada exitosamente</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error con Slim: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Próximo paso:</h2>";
echo "<p>Si todas las verificaciones pasaron, intenta acceder a: <a href='index.php'>index.php</a></p>";
?> 