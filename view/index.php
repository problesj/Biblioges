<?php
// Configuración de codificación
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('G');
mb_http_input('P');
mb_http_input('C');
mb_regex_encoding('UTF-8');

// Asegurar que los errores se muestren en UTF-8
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');

// Configuración adicional de codificación
ini_set('mbstring.encoding_translation', 'On');
ini_set('mbstring.func_overload', '7');
ini_set('mbstring.language', 'Spanish');
ini_set('mbstring.detect_order', 'UTF-8,ISO-8859-1');

date_default_timezone_set('America/Santiago');

// Establecer el locale
setlocale(LC_ALL, 'es_ES.UTF-8');

// Configurar el manejo de errores para usar UTF-8
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../storage/logs/php-error.log');
ini_set('error_log_charset', 'UTF-8');

// Cargar el autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar helpers
require_once __DIR__ . '/../src/helpers.php';

// Cargar variables de entorno
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} else {
    // Configuración por defecto si no existe .env
    $_ENV['DB_HOST'] = '127.0.0.1';
    $_ENV['DB_PORT'] = '3306';
    $_ENV['DB_DATABASE'] = 'bibliografia';
    $_ENV['DB_USERNAME'] = 'biblioges';
    $_ENV['DB_PASSWORD'] = 'joyal2025$';
    $_ENV['APP_URL'] = 'http://192.168.72.5/';
    $_ENV['APP_DEBUG'] = 'true';
}

// Inicializar Eloquent
require_once __DIR__ . '/../src/config/eloquent.php';

// Crear la instancia de Slim
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$app = AppFactory::create();

// Configurar el manejo de errores
$app->addErrorMiddleware(true, true, true);

// Configurar el middleware de routing
$app->addRoutingMiddleware();

// Agregar middleware de método override para soportar _method en formularios
$app->add(new MethodOverrideMiddleware());

// Configurar el middleware de manejo de errores personalizado
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('text/html');

// Middleware personalizado para establecer PATH_INFO correctamente
$app->add(function ($request, $handler) {
    // Obtener la URI de Slim
    $uri = $request->getUri();
    $path = $uri->getPath();
    
    // Establecer PATH_INFO desde la URI de Slim
    $_SERVER['PATH_INFO'] = $path;
    
    return $handler->handle($request);
});

// Configurar Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../cache/twig',
    'auto_reload' => true,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Hacer que $twig sea global
global $twig;

// Variables globales para Twig
$baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://192.168.72.5', '/');
// Para el frontend, siempre usar la URL base sin /biblioges
$frontendUrl = 'http://192.168.72.5';
$twig->addGlobal('app_url', $frontendUrl);
$twig->addGlobal('admin_url', $frontendUrl . '/biblioges');
$twig->addGlobal('assets_url', $frontendUrl . '/assets');

// Añadir funciones útiles a Twig
$twig->addFunction(new \Twig\TwigFunction('url', function ($path) use ($baseUrl) {
    return $baseUrl . '/' . ltrim($path, '/');
}));
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) use ($baseUrl) {
    return $baseUrl . '/assets/' . ltrim($path, '/');
}));

// Cargar las rutas del frontend
require_once __DIR__ . '/routes.php';

// Ejecutar la aplicación Slim
try {
    $app->run();
} catch (Exception $e) {
    error_log('Error en Slim Frontend: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    throw $e;
} 