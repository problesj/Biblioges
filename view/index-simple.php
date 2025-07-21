<?php
// Configuración básica
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');

date_default_timezone_set('America/Santiago');

// Cargar el autoloader de Composer
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

// Inicializar Eloquent
require_once __DIR__ . '/../src/config/eloquent.php';

// Crear la instancia de Slim
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Configurar el manejo de errores
$app->addErrorMiddleware(true, true, true);

// Configurar Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../cache/twig',
    'auto_reload' => true,
    'debug' => true
]);

// Variables globales para Twig
$baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://192.168.72.5', '/');
$twig->addGlobal('app_url', $baseUrl);
$twig->addGlobal('admin_url', $baseUrl . '/biblioges');

// Rutas simples
$app->get('/', function ($request, $response) use ($twig) {
    try {
        // Crear conexión PDO
        $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
        $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Obtener sedes
        $stmt = $pdo->query("SELECT id, nombre, codigo FROM sedes WHERE estado = 1 ORDER BY nombre");
        $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener carreras
        $stmt = $pdo->query("SELECT DISTINCT c.id, c.nombre, c.tipo_programa FROM carreras c INNER JOIN carreras_espejos ce ON c.id = ce.carrera_id WHERE c.estado = 1 ORDER BY c.nombre");
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $html = $twig->render('frontend/index.twig', [
            'sedes' => $sedes,
            'carreras' => $carreras
        ]);
        
        $response->getBody()->write($html);
        return $response;
    } catch (Exception $e) {
        $response->getBody()->write('Error: ' . $e->getMessage());
        return $response->withStatus(500);
    }
});

$app->get('/carrera/{sede_id}/{carrera_id}', function ($request, $response, $args) use ($twig) {
    try {
        $sedeId = $args['sede_id'];
        $carreraId = $args['carrera_id'];
        
        // Crear conexión PDO
        $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
        $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Obtener información de la carrera
        $stmt = $pdo->prepare("
            SELECT 
                s.id as sede_id,
                s.nombre as sede_nombre,
                c.id as carrera_id,
                c.nombre as carrera_nombre,
                c.tipo_programa
            FROM sedes s
            INNER JOIN carreras_espejos ce ON s.id = ce.sede_id
            INNER JOIN carreras c ON ce.carrera_id = c.id
            WHERE s.id = :sede_id AND c.id = :carrera_id AND s.estado = 1 AND c.estado = 1
        ");
        $stmt->execute([':sede_id' => $sedeId, ':carrera_id' => $carreraId]);
        $carrera = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$carrera) {
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }
        
        $html = $twig->render('frontend/carrera.twig', [
            'carrera' => $carrera,
            'asignaturas_por_semestre' => []
        ]);
        
        $response->getBody()->write($html);
        return $response;
    } catch (Exception $e) {
        $response->getBody()->write('Error: ' . $e->getMessage());
        return $response->withStatus(500);
    }
});

// Ejecutar la aplicación
try {
    $app->run();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} 