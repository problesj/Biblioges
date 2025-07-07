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

        // Obtener datos de cobertura básica por carrera usando la misma lógica del reporte
        $coberturaCarreras = $this->pdo->query("
            SELECT 
                c.nombre as carrera_nombre,
                ce.codigo_carrera as carrera_codigo,
                ROUND(
                    CASE 
                        WHEN COUNT(DISTINCT ab.bibliografia_id) > 0 THEN
                            (COUNT(DISTINCT CASE WHEN bd.id IS NOT NULL THEN ab.bibliografia_id END) / 
                             COUNT(DISTINCT ab.bibliografia_id)) * 100
                        ELSE 0 
                    END, 1
                ) as cobertura_basica
            FROM carreras_espejos ce
            INNER JOIN carreras c ON c.id = ce.carrera_id
            INNER JOIN mallas m ON m.carrera_id = c.id
            INNER JOIN asignaturas_departamentos ad ON ad.asignatura_id = m.asignatura_id
            INNER JOIN asignaturas_bibliografias ab ON ab.asignatura_id = ad.asignatura_id
            LEFT JOIN bibliografias_disponibles bd ON bd.bibliografia_declarada_id = ab.bibliografia_id 
                AND bd.estado = 1
                AND (
                    bd.disponibilidad IN ('electronico', 'ambos')
                    OR (bd.disponibilidad = 'impreso' AND EXISTS (
                        SELECT 1 FROM bibliografias_disponibles_sedes bds 
                        WHERE bds.bibliografia_disponible_id = bd.id 
                        AND bds.ejemplares > 0
                    ))
                )
            WHERE c.tipo_programa = 'P'
            AND ab.tipo_bibliografia = 'basica'
            AND c.estado = 1
            GROUP BY ce.codigo_carrera, c.nombre
            HAVING cobertura_basica > 0
            ORDER BY cobertura_basica DESC
            LIMIT 10
        ")->fetchAll();

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