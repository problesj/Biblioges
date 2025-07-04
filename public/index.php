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

// Configurar la cookie de sesión antes de iniciar la sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
ini_set('session.use_strict_mode', 1);
ini_set('session.save_path', __DIR__ . '/../storage/framework/sessions');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Log para depuración de sesión
error_log('Estado de la sesión: ' . session_status());
error_log('ID de sesión: ' . session_id());
error_log('Datos de sesión: ' . print_r($_SESSION, true));
error_log('Cookie de sesión: ' . print_r($_COOKIE, true));
error_log('Save path: ' . session_save_path());

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
    $_ENV['APP_URL'] = 'http://192.168.72.5/biblioges/';
    $_ENV['APP_DEBUG'] = 'true';
}

// Cargar configuración
use App\Core\Config;
Config::load(__DIR__ . '/../config/app.php');

// Log para verificar configuración
error_log('Configuración cargada: ' . print_r(Config::get('app_url'), true));

// Inicializar Eloquent
require_once __DIR__ . '/../src/config/eloquent.php';

// Crear la instancia de Slim
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

$app = AppFactory::create();

// Configurar el manejo de errores
$app->addErrorMiddleware(true, true, true);

// Middleware personalizado para establecer PATH_INFO correctamente (debe ir antes del routing)
$app->add(function ($request, $handler) {
    // Obtener la URI de Slim
    $uri = $request->getUri();
    $path = $uri->getPath();
    
    // Log para depuración
    error_log('Middleware PATH_INFO: URI original: ' . $path);
    
    // Establecer PATH_INFO desde la URI de Slim
    if (strpos($path, '/biblioges') === 0) {
        $pathInfo = substr($path, strlen('/biblioges'));
        // Limpiar múltiples slashes y asegurar que empiece con /
        $pathInfo = '/' . ltrim($pathInfo, '/');
        // Si solo queda /, mantenerlo
        if ($pathInfo === '/') {
            $pathInfo = '/';
        }
    } else {
        $pathInfo = $path;
    }
    
    $_SERVER['PATH_INFO'] = $pathInfo;
    error_log('Middleware PATH_INFO: PATH_INFO establecido: ' . $pathInfo);
    
    return $handler->handle($request);
});

// Configurar el middleware de routing
$app->addRoutingMiddleware();

// Agregar middleware de método override para soportar _method en formularios
$app->add(new MethodOverrideMiddleware());

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
$baseUrl = Config::get('app_url');
$twig->addGlobal('app_url', $baseUrl);
$twig->addGlobal('session', $_SESSION);

// Añadir funciones útiles a Twig
$twig->addFunction(new \Twig\TwigFunction('url', function ($path) use ($baseUrl) {
    return $baseUrl . ltrim($path, '/');
}));
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) use ($baseUrl) {
    return $baseUrl . 'assets/' . ltrim($path, '/');
}));
$twig->addFunction(new \Twig\TwigFunction('clean_error_message', function () {
    // Limpiar mensajes de sesión
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    return '';
}));

// Log para depuración de rutas
error_log('Antes de cargar rutas');
error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
error_log('SCRIPT_NAME: ' . $_SERVER['SCRIPT_NAME']);
error_log('PATH_INFO: ' . ($_SERVER['PATH_INFO'] ?? 'no definido'));
error_log('REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD']);
error_log('QUERY_STRING: ' . ($_SERVER['QUERY_STRING'] ?? 'no definido'));
error_log('HTTP_HOST: ' . ($_SERVER['HTTP_HOST'] ?? 'no definido'));

// Cargar las rutas de Slim
require_once __DIR__ . '/../src/routes.php';

// Log para depuración de rutas
error_log('Después de cargar rutas');

// Ejecutar la aplicación Slim
try {
    error_log('Ejecutando aplicación Slim');
    error_log('Rutas registradas: ' . count($app->getRouteCollector()->getRoutes()));
    
    // Log detallado de todas las rutas registradas (solo en modo debug)
    if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true') {
        error_log('=== RUTAS REGISTRADAS ===');
        foreach ($app->getRouteCollector()->getRoutes() as $route) {
            $methods = implode(',', $route->getMethods());
            $pattern = $route->getPattern();
            error_log("[RUTA] $pattern [$methods]");
        }
        error_log('=== FIN RUTAS ===');
    }
    
    // Log de la petición que está llegando (solo en modo debug)
    if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true') {
        error_log('=== PETICIÓN ENTRANTE ===');
        error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
        error_log('REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD']);
        error_log('PATH_INFO: ' . ($_SERVER['PATH_INFO'] ?? 'no definido'));
        error_log('=== FIN PETICIÓN ===');
    }
    
    $app->run();
} catch (Exception $e) {
    error_log('Error en Slim: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    throw $e;
} 