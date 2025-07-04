<?php
// Script para debuggear la ruta del reporte

require_once 'vendor/autoload.php';

// Cargar variables de entorno
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Cargar configuración
use App\Core\Config;
Config::load(__DIR__ . '/config/app.php');

// Inicializar Eloquent
require_once __DIR__ . '/src/config/eloquent.php';

// Crear una instancia del controlador
use App\Controllers\ReporteController;

$controller = new ReporteController();

// Simular una petición HTTP con sesión autenticada
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_email'] = 'admin@example.com';
$_SESSION['user_nombre'] = 'Admin';
$_SESSION['user_rol'] = 'admin';

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\Uri;

echo "=== DEBUG DE LA RUTA ===\n\n";

// Crear una petición simulada para el reporte
$uri = new Uri('http', 'localhost', 80, '/biblioges/reportes/listado-bibliografias');
$request = new Request('GET', $uri);
$response = new Response();

try {
    echo "1. Probando método bibliografiasDeclaradas...\n";
    $result = $controller->bibliografiasDeclaradas($request, $response, []);
    echo "2. Código de respuesta: " . $result->getStatusCode() . "\n";
    
    $content = $result->getBody()->getContents();
    echo "3. Tamaño del contenido: " . strlen($content) . " bytes\n";
    
    if (strpos($content, 'Listado de Bibliografías') !== false) {
        echo "✅ ÉXITO: El reporte se cargó correctamente\n";
        echo "Contenido encontrado: Listado de Bibliografías\n";
    } elseif (strpos($content, 'dashboard') !== false) {
        echo "❌ ERROR: Se está mostrando el dashboard en lugar del reporte\n";
        echo "Contenido contiene: dashboard\n";
    } elseif (strpos($content, 'login') !== false) {
        echo "❌ ERROR: Se está redirigiendo al login\n";
        echo "Contenido contiene: login\n";
    } else {
        echo "❌ ERROR: Contenido inesperado\n";
        echo "Primeros 200 caracteres: " . substr($content, 0, 200) . "...\n";
    }
    
    // Verificar headers de respuesta
    echo "\n4. Headers de respuesta:\n";
    foreach ($result->getHeaders() as $name => $values) {
        echo "   $name: " . implode(', ', $values) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== FIN DEBUG ===\n"; 