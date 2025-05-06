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

    public function index()
    {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Por favor inicie sesión para acceder al dashboard';
            return $this->redirect('login');
        }

        // Obtener datos del usuario
        $user = $this->userModel->find($_SESSION['user_id']);
        
        if (!$user) {
            session_destroy();
            $_SESSION['error'] = 'Usuario no encontrado';
            return $this->redirect('login');
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

        // Renderizar la vista
        echo $this->twig->render('dashboard/index.twig', [
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
            'app_url' => Config::get('app_url'),
            'current_path' => 'dashboard'
        ]);
    }
} 