<?php
// Establecer el manejo de errores
ini_set('display_errors', 0);
error_reporting(E_ALL);

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

use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

// Registrar manejador de errores
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Error interno del servidor'
        ]);
        exit;
    }
    return false;
});

// Cargar el autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Cargar configuración
use App\Core\Config;
Config::load(__DIR__ . '/../config/app.php');

// Inicializar Eloquent
require_once __DIR__ . '/../src/config/eloquent.php';

// Verificar configuración de sesiones
error_log('PHP Session Support: ' . (function_exists('session_start') ? 'Enabled' : 'Disabled'));
error_log('Session Save Path: ' . ini_get('session.save_path'));
error_log('Session Save Handler: ' . ini_get('session.save_handler'));

// Obtener la URL solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$baseUrl = Config::get('app_url');

// Extraer la ruta base
$basePath = parse_url($baseUrl, PHP_URL_PATH);
$basePath = rtrim($basePath, '/');

// Obtener la ruta solicitada
$path = parse_url($requestUri, PHP_URL_PATH);

// Eliminar la ruta base si existe
if ($basePath && strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

// Eliminar barras iniciales y finales
$path = trim($path, '/');

// Si la ruta está vacía, redirigir al login
if (empty($path)) {
    header('Location: ' . $baseUrl . 'login');
    exit;
}

// Log para depuración de rutas
error_log('Ruta solicitada: ' . $requestUri);
error_log('Ruta base: ' . $basePath);
error_log('Ruta procesada: ' . $path);

// Verificar si es una solicitud AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Si es una petición AJAX, asegurar que la respuesta sea JSON
if ($isAjax) {
    header('Content-Type: application/json');
}

// Configurar Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../cache/twig',
    'auto_reload' => true,
    'debug' => true
]);

// Añadir la extensión de debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Variables globales para Twig
$twig->addGlobal('app_url', $baseUrl);
$twig->addGlobal('current_path', $path);
$twig->addGlobal('session', $_SESSION);

// Log para depuración
error_log('Variables de sesión pasadas a Twig: ' . print_r($_SESSION, true));

// Añadir la función de URL
$twig->addFunction(new \Twig\TwigFunction('url', function ($path) use ($baseUrl) {
    return $baseUrl . ltrim($path, '/');
}));

// Añadir la función de asset
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) use ($baseUrl) {
    return $baseUrl . 'assets/' . ltrim($path, '/');
}));

// Añadir script para limpiar mensajes de error
$twig->addFunction(new \Twig\TwigFunction('clean_error_message', function () use ($baseUrl) {
    return <<<HTML
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.addEventListener('close.bs.alert', function() {
                    fetch('{$baseUrl}clean-error', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error al limpiar el mensaje:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error al limpiar el mensaje:', error);
                    });
                });
            }
        });
    </script>
    HTML;
}));

// Verificar autenticación para rutas protegidas
$rutasProtegidas = ['dashboard', 'bibliografias', 'asignaturas', 'carreras', 'usuarios', 'sedes', 'facultades', 'departamentos'];
if (in_array($path, $rutasProtegidas) && !isset($_SESSION['user_id'])) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        exit;
    }
    header('Location: ' . $baseUrl . 'login');
    exit;
}

// Si es la ruta de login y ya está autenticado, redirigir al dashboard
if ($path === 'login' && isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . 'dashboard');
    exit;
}

// Verificar si la ruta es para el listado de carreras
if ($path === 'carreras' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\CarreraController();
    $controller->index();
    exit;
}

// Verificar si la ruta es para crear una carrera (formulario)
if ($path === 'carreras/create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\CarreraController();
    $controller->create();
    exit;
}

// Verificar si la ruta es para almacenar una carrera
if ($path === 'carreras/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \App\Controllers\CarreraController();
    $controller->store();
    exit;
}

// Verificar si la ruta es para ver una carrera específica
if (preg_match('/^carreras\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\CarreraController();
    $controller->show($matches[1]);
    exit;
}

// Verificar si la ruta es para eliminar una carrera
if (preg_match('/^carreras\/(\d+)$/', $path, $matches) && 
    ($_SERVER['REQUEST_METHOD'] === 'DELETE' || 
     ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE'))) {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\CarreraController();
    $controller->delete($matches[1]);
    exit;
}

// Verificar si la ruta es para editar una carrera
if (preg_match('/^carreras\/(\d+)\/edit$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\CarreraController();
    $controller->edit($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar una carrera
if (preg_match('/^carreras\/(\d+)\/update$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \App\Controllers\CarreraController();
    $controller->update($matches[1]);
    exit;
}

// Verificar si la ruta es para obtener facultades por sede
if ($path === 'carreras/facultades' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\CarreraController();
    $sede_id = $_GET['sede_id'] ?? 0;
    $controller->getFacultadesBySede($sede_id);
    exit;
}

// Verificar si la ruta es para editar una sede
if (preg_match('/^sedes\/(\d+)\/edit$/', $path, $matches)) {
    $controller = new \App\Controllers\SedeController();
    $controller->edit($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar o eliminar una sede
if (preg_match('/^sedes\/(\d+)$/', $path, $matches)) {
    $controller = new \App\Controllers\SedeController();
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT')) {
        $controller->update($matches[1]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
        $controller->destroy($matches[1]);
    }
    exit;
}

// Verificar si la ruta es para editar una facultad
if (preg_match('/^facultades\/(\d+)\/edit$/', $path, $matches)) {
    $controller = new \App\Controllers\FacultadController();
    $controller->edit($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar una facultad
if (preg_match('/^facultades\/(\d+)\/update$/', $path, $matches)) {
    $controller = new \App\Controllers\FacultadController();
    $controller->update($matches[1]);
    exit;
}

// Verificar si la ruta es para eliminar una facultad
if (preg_match('/^facultades\/(\d+)\/delete$/', $path, $matches)) {
    $controller = new \App\Controllers\FacultadController();
    $controller->destroy($matches[1]);
    exit;
}

// Verificar si la ruta es para editar un departamento
if (preg_match('/^departamentos\/(\d+)\/edit$/', $path, $matches)) {
    $controller = new \src\Controllers\DepartamentoController();
    $controller->edit($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar o eliminar un departamento
if (preg_match('/^departamentos\/(\d+)$/', $path, $matches)) {
    $controller = new \src\Controllers\DepartamentoController();
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT')) {
        $controller->update($matches[1]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
        $controller->destroy($matches[1]);
    }
    exit;
}

// Verificar si la ruta es para limpiar el mensaje de error
if ($path === 'clean-error' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['warning'])) {
        unset($_SESSION['warning']);
    }
    if (isset($_SESSION['info'])) {
        unset($_SESSION['info']);
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// Verificar si la ruta es para crear una asignatura
if ($path === 'asignaturas' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\AsignaturaController();
    $controller->store();
    exit;
}

// Verificar si la ruta es para crear una asignatura (formulario)
if ($path === 'asignaturas/create') {
    $controller = new \App\Controllers\AsignaturaController();
    $controller->create();
    exit;
}

// Verificar si la ruta es para editar una asignatura
if (preg_match('/^asignaturas\/(\d+)\/editar$/', $path, $matches)) {
    $controller = new \App\Controllers\AsignaturaController();
    $controller->edit($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar una asignatura
if (preg_match('/^asignaturas\/(\d+)\/actualizar$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \App\Controllers\AsignaturaController();
    $controller->update($matches[1]);
    exit;
}

// Verificar si la ruta es para actualizar o eliminar una asignatura
if (preg_match('/^asignaturas\/(\d+)$/', $path, $matches)) {
    $controller = new \App\Controllers\AsignaturaController();
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT')) {
        $controller->update($matches[1]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
        $controller->destroy($matches[1]);
    } else {
        $controller->show($matches[1]);
    }
    exit;
}

// Verificar si la ruta es para el listado de asignaturas
if ($path === 'asignaturas') {
    $controller = new \App\Controllers\AsignaturaController();
    $controller->index();
    exit;
}

// Verificar si la ruta es para crear un departamento
if ($path === 'departamentos/create') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \src\Controllers\DepartamentoController();
    $controller->create();
    exit;
}

// Verificar si la ruta es para almacenar un departamento
if ($path === 'departamentos/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \src\Controllers\DepartamentoController();
    $controller->store();
    exit;
}

// Verificar si la ruta es para la vinculación de asignaturas
if ($path === 'asignaturas/vinculacion') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\AsignaturaController();
    $controller->vinculacion();
    exit;
}

// Verificar si la ruta es para obtener vinculaciones de asignaturas
if (preg_match('/^asignaturas\/vinculacion\/(\d+)$/', $path, $matches)) {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\AsignaturaController();
    $controller->getVinculacion($matches[1]);
    exit;
}

// Verificar si la ruta es para agregar vinculaciones
if (preg_match('/^asignaturas\/vinculacion\/(\d+)\/agregar$/', $path, $matches)) {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\AsignaturaController();
    $controller->agregarVinculacion($matches[1]);
    exit;
}

// Verificar si la ruta es para quitar vinculaciones
if (preg_match('/^asignaturas\/vinculacion\/(\d+)\/quitar$/', $path, $matches)) {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\AsignaturaController();
    $controller->quitarVinculacion($matches[1]);
    exit;
}

// Verificar si la ruta es para crear una sede
if ($path === 'sedes/create') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\SedeController();
    $controller->create();
    exit;
}

// Verificar si la ruta es para almacenar una sede
if ($path === 'sedes/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\SedeController();
    $controller->store();
    exit;
}

// Verificar si la ruta es para crear una facultad
if ($path === 'facultades/create') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\FacultadController();
    $controller->create();
    exit;
}

// Verificar si la ruta es para almacenar una facultad
if ($path === 'facultades/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }
        header('Location: ' . $baseUrl . 'login');
        exit;
    }
    $controller = new \App\Controllers\FacultadController();
    $controller->store();
    exit;
}

// Verificar si la ruta es para limpiar mensajes de sesión
if ($path === 'clear-session-messages') {
    $session = new \App\Core\Session();
    $session->set('error', '');
    $session->set('success', '');
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
    exit;
}

// Verificar si la ruta es para el dashboard
if ($path === 'dashboard') {
    $controller = new \App\Controllers\DashboardController();
    $controller->index();
    exit;
}

// Verificar si la ruta es para el listado de mallas
if ($path === 'mallas' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\MallaController();
    $controller->index();
    exit;
}

// Verificar si la ruta es para ver una malla específica
if (preg_match('/^mallas\/(\d+)$/', $path, $matches) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new \App\Controllers\MallaController();
    $controller->show($matches[1]);
    exit;
}

// Dividir la ruta en segmentos para el enrutamiento
$pathSegments = explode('/', $path);

// Cargar el controlador correspondiente
$controller = null;
$request = ServerRequestFactory::createFromGlobals();
$response = new Response();

switch ($pathSegments[0]) {
    case 'login':
        $controller = new \App\Controllers\AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
            exit;
        }
        $controller->showLogin();
        break;
    case 'logout':
        $controller = new \App\Controllers\AuthController();
        $controller->logout();
        break;
    case 'dashboard':
        $controller = new \App\Controllers\DashboardController();
        $controller->index();
        break;
    case 'admin':
        $controller = new \App\Controllers\AdminController();
        $controller->index();
        break;
    case 'bibliografias-declaradas':
        $controller = new \App\Controllers\BibliografiaDeclaradaController();
        $controller->index();
        break;
    case 'carreras':
        $controller = new \App\Controllers\CarreraController();
        $controller->index();
        break;
    case 'carreras/create':
        $controller = new \App\Controllers\CarreraController();
        $controller->create();
        break;
    case 'carreras/store':
        $controller = new \App\Controllers\CarreraController();
        $controller->store();
        break;
    case 'facultades':
        $controller = new \App\Controllers\FacultadController();
        if (isset($pathSegments[1]) && $pathSegments[1] === 'sede' && isset($pathSegments[2]) && is_numeric($pathSegments[2])) {
            $controller->getFacultadesBySede($pathSegments[2]);
            exit;
        } else if (isset($pathSegments[1]) && is_numeric($pathSegments[1])) {
            if (isset($pathSegments[2]) && $pathSegments[2] === 'edit') {
                $controller->edit($pathSegments[1]);
            } else {
                $controller->update($pathSegments[1]);
            }
        } else {
            $controller->index();
        }
        break;
    case 'facultades/create':
        $controller = new \App\Controllers\FacultadController();
        $controller->create();
        break;
    case 'facultades/store':
        $controller = new \App\Controllers\FacultadController();
        $controller->store();
        break;
    case 'sedes':
        $controller = new \App\Controllers\SedeController();
        $controller->index();
        break;
    case 'sedes/create':
        $controller = new \App\Controllers\SedeController();
        $controller->create();
        break;
    case 'sedes/store':
        $controller = new \App\Controllers\SedeController();
        $controller->store();
        break;
    case 'departamentos':
        $controller = new \src\Controllers\DepartamentoController();
        if (isset($pathSegments[1]) && $pathSegments[1] === 'facultad' && isset($pathSegments[2]) && is_numeric($pathSegments[2])) {
            $controller->getDepartamentosByFacultad($pathSegments[2]);
            exit;
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case 'departamentos/create':
        $controller = new \src\Controllers\DepartamentoController();
        $controller->create();
        break;
    default:
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'Ruta no encontrada']);
            exit;
        }
        http_response_code(404);
        echo $twig->render('404.twig', ['app_url' => $baseUrl]);
        break;
}

// Configuración de la base de datos
$dbConfig = [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? '3306',
    'dbname' => $_ENV['DB_DATABASE'] ?? 'biblioges',
    'user' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? ''
];

try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
} catch (PDOException $e) {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
        exit;
    }
    die("Error de conexión: " . $e->getMessage());
}

// Obtener estadísticas
$stats = [
    'bibliografias' => $pdo->query("SELECT COUNT(*) FROM bibliografias_declaradas")->fetchColumn(),
    'asignaturas' => $pdo->query("SELECT COUNT(*) FROM asignaturas")->fetchColumn(),
    'carreras' => $pdo->query("SELECT COUNT(*) FROM carreras")->fetchColumn(),
    'usuarios' => $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn()
];

// Obtener bibliografías recientes
$bibliografias = $pdo->query("
    SELECT b.*, a.nombre as asignatura_nombre 
    FROM bibliografias_declaradas b 
    LEFT JOIN asignaturas a ON b.asignatura_id = a.id 
    ORDER BY b.id DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Variables disponibles en todas las plantillas
$context = [
    'stats' => $stats ?? [],
    'bibliografias' => $bibliografias ?? [],
    'current_path' => $path,
    'app_url' => $baseUrl,
    'error' => $_SESSION['error'] ?? null,
    'session' => $_SESSION
];

// Si el controlador ya ha renderizado la vista, no renderizar de nuevo
if (!headers_sent() && !isset($controller)) {
    try {
        // Renderizar la plantilla
        echo $twig->render($path . '.twig', $context);
        
        // Limpiar mensajes de sesión después de renderizar la vista
        if (isset($_SESSION['success'])) {
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
    } catch (\Twig\Error\LoaderError $e) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'Plantilla no encontrada']);
            exit;
        }
        header("HTTP/1.0 404 Not Found");
        echo $twig->render('404.twig', ['error' => 'Página no encontrada']);
    } catch (\Exception $e) {
        if ($isAjax) {
            echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
            exit;
        }
        die("Error: " . $e->getMessage());
    }
} 