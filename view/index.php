<?php
// Configuración de codificación
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('G');
mb_http_input('P');
mb_http_input('C');
mb_regex_encoding('UTF-8');

// Errores: siempre se registran; solo se muestran con APP_DEBUG=true (se ajusta tras cargar .env)
error_reporting(E_ALL);
ini_set('display_errors', '0');
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
    error_log('Falta el archivo .env: configure las credenciales de la base de datos');
    http_response_code(500);
    exit('Configuración no disponible.');
}
$appDebug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
ini_set('display_errors', $appDebug ? '1' : '0');

// Inicializar Eloquent
require_once __DIR__ . '/../src/config/eloquent.php';

// Crear la instancia de Slim
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$app = AppFactory::create();

// Configurar el middleware de routing
$app->addRoutingMiddleware();

// Agregar middleware de método override para soportar _method en formularios
$app->add(new MethodOverrideMiddleware());

// Middleware personalizado para establecer PATH_INFO correctamente
$app->add(function ($request, $handler) {
    // Obtener la URI de Slim
    $uri = $request->getUri();
    $path = $uri->getPath();
    
    // Si es una imagen o archivo estático, no procesar con Slim
    if (preg_match('/\.(jpg|jpeg|png|gif|css|js|ico|svg|woff|woff2|ttf|eot)$/i', $path)) {
        // Devolver 404 para archivos estáticos que no existen
        $response = new \Slim\Psr7\Response();
        return $response->withStatus(404);
    }
    
    // Si la ruta contiene uploads, redirigir
    if (strpos($path, '/biblioges/uploads/') === 0) {
        $response = new \Slim\Psr7\Response();
        return $response->withStatus(404);
    }
    
    // Limpiar la ruta base si existe
    $basePath = '/biblioges/view';
    if (strpos($path, $basePath) === 0) {
        $path = substr($path, strlen($basePath));
    }
    
    // Establecer PATH_INFO desde la URI de Slim
    $_SERVER['PATH_INFO'] = $path ?: '/';
    
    
    return $handler->handle($request);
});

// Configurar Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../cache/twig',
    'auto_reload' => true,
    'debug' => $appDebug
]);
if ($appDebug) {
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

// Hacer que $twig sea global
global $twig;

// Variables globales para Twig
$baseUrl = rtrim($_ENV['APP_URL'] ?? 'https://biblioges.ucn.cl', '/');
// Para el frontend, siempre usar la URL base sin /biblioges
$frontendUrl = rtrim($_ENV['APP_URL_FRONTEND'] ?? 'https://biblioges.ucn.cl', '/');
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

// Manejo de errores al final: envuelve a todos los middlewares (incluido el routing),
// así las rutas inexistentes responden 404 en lugar de un Fatal error
$errorMiddleware = $app->addErrorMiddleware($appDebug, true, true);
$errorMiddleware->getDefaultErrorHandler()->forceContentType('text/html');

// Ejecutar la aplicación Slim
try {
    $app->run();
} catch (Exception $e) {
    error_log('Error en Slim Frontend: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    throw $e;
} 