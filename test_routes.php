<?php
// Script para probar las rutas del reporte

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

// Crear la instancia de Slim
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$app = AppFactory::create();

// Configurar el manejo de errores
$app->addErrorMiddleware(true, true, true);

// Middleware personalizado para establecer PATH_INFO correctamente
$app->add(function ($request, $handler) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    
    if (strpos($path, '/biblioges') === 0) {
        $pathInfo = substr($path, strlen('/biblioges'));
    } else {
        $pathInfo = $path;
    }
    
    $_SERVER['PATH_INFO'] = $pathInfo;
    
    return $handler->handle($request);
});

// Configurar el middleware de routing
$app->addRoutingMiddleware();

// Agregar middleware de método override
$app->add(new MethodOverrideMiddleware());

// Cargar las rutas
require_once __DIR__ . '/src/routes.php';

echo "=== PRUEBA DE RUTAS ===\n\n";

// Listar todas las rutas registradas
$routes = $app->getRouteCollector()->getRoutes();
echo "Total de rutas registradas: " . count($routes) . "\n\n";

echo "Rutas relacionadas con reportes:\n";
foreach ($routes as $route) {
    $pattern = $route->getPattern();
    $methods = implode(',', $route->getMethods());
    
    if (strpos($pattern, 'reportes') !== false) {
        echo "[$methods] $pattern\n";
    }
}

echo "\nRutas específicas del reporte de bibliografías declaradas:\n";
foreach ($routes as $route) {
    $pattern = $route->getPattern();
    $methods = implode(',', $route->getMethods());
    
    if (strpos($pattern, 'bibliografias-declaradas') !== false) {
        echo "[$methods] $pattern\n";
    }
}

echo "\n=== FIN PRUEBA ===\n"; 