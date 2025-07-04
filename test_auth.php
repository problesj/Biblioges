<?php
// Script para probar la autenticación y el reporte

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

echo "=== PRUEBA DE AUTENTICACIÓN Y REPORTE ===\n\n";

// Crear una petición simulada para el reporte
$uri = new Uri('http', 'localhost', 80, '/biblioges/reportes/bibliografias-declaradas');
$request = new Request('GET', $uri);
$response = new Response();

try {
    echo "Probando método bibliografiasDeclaradas con sesión autenticada...\n";
    $result = $controller->bibliografiasDeclaradas($request, $response, []);
    echo "Resultado: " . $result->getStatusCode() . "\n";
    
    $content = $result->getBody()->getContents();
    if (strpos($content, 'Reporte de Bibliografías Declaradas') !== false) {
        echo "✅ ÉXITO: El reporte se cargó correctamente\n";
        echo "Contenido encontrado: Reporte de Bibliografías Declaradas\n";
    } else {
        echo "❌ ERROR: El reporte no se cargó correctamente\n";
        echo "Contenido: " . substr($content, 0, 200) . "...\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}

echo "\n=== FIN PRUEBA ===\n"; 