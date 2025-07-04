<?php
// Script para probar el controlador del reporte directamente

require_once 'vendor/autoload.php';

// Simular una sesión de usuario autenticado
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'admin';

// Cargar variables de entorno
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    // Configuración por defecto si no existe .env
    $_ENV['DB_HOST'] = '127.0.0.1';
    $_ENV['DB_PORT'] = '3306';
    $_ENV['DB_DATABASE'] = 'bibliografia';
    $_ENV['DB_USERNAME'] = 'biblioges';
    $_ENV['DB_PASSWORD'] = 'joyal2025$';
    $_ENV['APP_URL'] = 'http://192.168.72.5/biblioges/';
    $_ENV['APP_DEBUG'] = 'true';
}

// Cargar configuración
use App\Core\Config;
Config::load(__DIR__ . '/config/app.php');

// Inicializar Eloquent
require_once __DIR__ . '/src/config/eloquent.php';

// Crear una instancia del controlador
use App\Controllers\ReporteController;

$controller = new ReporteController();

// Simular una petición HTTP
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

// Crear una petición simulada
$uri = new \Slim\Psr7\Uri('http', 'localhost', 80, '/biblioges/reportes/bibliografias-declaradas');
$request = new Request('GET', $uri);
$response = new Response();

echo "=== PRUEBA DEL CONTROLADOR ===\n\n";

try {
    // Probar el método bibliografiasDeclaradas
    echo "Probando método bibliografiasDeclaradas...\n";
    $result = $controller->bibliografiasDeclaradas($request, $response, []);
    echo "Resultado: " . $result->getStatusCode() . "\n";
    echo "Contenido: " . substr($result->getBody()->getContents(), 0, 200) . "...\n\n";
    
} catch (Exception $e) {
    echo "Error en bibliografiasDeclaradas: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n\n";
}

try {
    // Probar el método getBibliografiasDeclaradas
    echo "Probando método getBibliografiasDeclaradas...\n";
    $uriData = new \Slim\Psr7\Uri('http', 'localhost', 80, '/biblioges/reportes/bibliografias-declaradas/data');
    $uriData = $uriData->withQuery('draw=1&start=0&length=10');
    $requestData = new Request('GET', $uriData);
    $result = $controller->getBibliografiasDeclaradas($requestData, $response, []);
    echo "Resultado: " . $result->getStatusCode() . "\n";
    echo "Contenido: " . $result->getBody()->getContents() . "\n\n";
    
} catch (Exception $e) {
    echo "Error en getBibliografiasDeclaradas: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n\n";
}

echo "=== FIN PRUEBA ===\n"; 