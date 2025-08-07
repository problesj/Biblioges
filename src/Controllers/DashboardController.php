<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use src\Models\Usuario;
use src\Models\BibliografiaDeclarada;
use src\Models\BibliografiaDisponible;
use src\Models\Asignatura;
use src\Models\Carrera;
use src\Models\Sede;
use PDO;
use PDOException;
use App\Core\Config;

class DashboardController extends BaseController
{
    protected $session;
    protected $userModel;
    protected $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->userModel = new Usuario();
        
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
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function index($request, $response, $args = [])
    {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Por favor inicie sesión para acceder al dashboard';
            return $response
                ->withHeader('Location', '/biblioges/login')
                ->withStatus(302);
        }

        // Obtener datos del usuario
        $user = $this->userModel->find($_SESSION['user_id']);
        
        if (!$user) {
            session_destroy();
            $_SESSION['error'] = 'Usuario no encontrado';
            return $response
                ->withHeader('Location', '/biblioges/login')
                ->withStatus(302);
        }

        // Obtener estadísticas
        $totalBibliografias = $this->pdo->query("SELECT COUNT(*) FROM bibliografias_declaradas")->fetchColumn();
        $totalDisponibles = $this->pdo->query("SELECT COUNT(*) FROM bibliografias_disponibles")->fetchColumn();
        $totalAsignaturas = $this->pdo->query("SELECT COUNT(*) FROM asignaturas")->fetchColumn();
        $totalCarreras = $this->pdo->query("SELECT COUNT(*) FROM carreras")->fetchColumn();

        // Obtener bibliografías recientes con sus autores
        $bibliografiasRecientes = $this->pdo->query("
            SELECT 
                b.titulo,
                b.tipo,
                b.formato,
                COALESCE(
                    GROUP_CONCAT(CONCAT(au.apellidos, ', ', au.nombres) SEPARATOR '; '),
                    'Sin información'
                ) as autores
            FROM bibliografias_declaradas b 
            LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
            LEFT JOIN autores au ON ba.autor_id = au.id
            GROUP BY b.id, b.titulo, b.tipo, b.formato
            ORDER BY b.id DESC 
            LIMIT 5
        ")->fetchAll();

        // Obtener asignaturas recientes
        $asignaturasRecientes = $this->pdo->query("
            SELECT 
                nombre,
                tipo,
                periodicidad
            FROM asignaturas
            ORDER BY id DESC
            LIMIT 5
        ")->fetchAll();

        // Obtener datos de cobertura básica por carrera usando las tablas de reportes guardados
        $anioActual = date('Y');
        
        // Obtener el año más reciente con datos disponibles
        $stmt = $this->pdo->query("SELECT MAX(YEAR(fecha_medicion)) as anio_mas_reciente FROM reporte_coberturas_carreras_basicas");
        $anioMasReciente = $stmt->fetchColumn();
        
        // Usar el año más reciente si no hay datos del año actual
        $anioConsulta = $anioMasReciente ?: $anioActual;
        
        // Log para depuración
        error_log("DashboardController: Obteniendo coberturas básicas para año {$anioConsulta}");
        
        $coberturaCarreras = $this->pdo->query("
            SELECT 
                c.nombre as carrera_nombre,
                rcb.codigo_carrera as carrera_codigo,
                ROUND(
                    LEAST(
                        COUNT(DISTINCT CASE WHEN rcb.no_bib_disponible_basica > 0 THEN rcb.id_bibliografia_declarada END) * 100.0 / 
                        NULLIF(COUNT(DISTINCT rcb.id_bibliografia_declarada), 0), 
                        100
                    ), 2
                ) as cobertura_basica
            FROM reporte_coberturas_carreras_basicas rcb
            INNER JOIN carreras c ON c.id = (
                SELECT ce.carrera_id 
                FROM carreras_espejos ce 
                WHERE ce.codigo_carrera = rcb.codigo_carrera 
                LIMIT 1
            )
            WHERE YEAR(rcb.fecha_medicion) = {$anioConsulta}
            AND c.estado = 1
            AND c.tipo_programa = 'P'
            GROUP BY rcb.codigo_carrera, c.nombre
            HAVING cobertura_basica > 0
            ORDER BY cobertura_basica DESC
            LIMIT 10
        ")->fetchAll();
        
        // Log para depuración
        error_log("DashboardController: Coberturas básicas encontradas: " . count($coberturaCarreras));
        foreach ($coberturaCarreras as $carrera) {
            error_log("DashboardController: {$carrera['carrera_nombre']} - {$carrera['cobertura_basica']}%");
        }

        // Renderizar la vista
        $body = $this->twig->render('dashboard/index.twig', [
            'session' => [
                'user' => $user,
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'user_nombre' => $user['nombre'],
                'user_rol' => $user['rol']
            ],
            'totalBibliografias' => $totalBibliografias,
            'totalDisponibles' => $totalDisponibles,
            'totalAsignaturas' => $totalAsignaturas,
            'totalCarreras' => $totalCarreras,
            'bibliografiasRecientes' => $bibliografiasRecientes,
            'asignaturasRecientes' => $asignaturasRecientes,
            'coberturaCarreras' => $coberturaCarreras,
            'app_url' => Config::get('app_url'),
            'current_path' => 'dashboard'
        ]);
        $response->getBody()->write($body);
        return $response;
    }
} 