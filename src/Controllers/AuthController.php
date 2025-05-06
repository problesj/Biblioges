<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use src\Models\Usuario;
use PDO;
use App\Core\Config;

class AuthController extends BaseController
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
        } catch (\PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al conectar con el servidor. Por favor intente nuevamente.'
                ]);
            }
            die("Error de conexión a la base de datos");
        }
    }

    public function showLogin()
    {
        if ($this->session->get('user_id')) {
            header('Location: ' . Config::get('app_url') . 'dashboard');
            exit;
        }
        
        $error = $this->session->getFlash('error');
        $email = $this->session->getFlash('email');
        
        echo $this->twig->render('login.twig', [
            'session' => [
            'error' => $error,
                'email' => $email
            ],
            'app_url' => Config::get('app_url')
        ]);
    }

    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->session->setFlash('error', 'Por favor complete todos los campos');
                $this->session->setFlash('email', $email);
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            $user = $this->userModel->findByEmail($email);
            
            if (!$user) {
                $this->session->setFlash('error', 'Credenciales inválidas');
                $this->session->setFlash('email', $email);
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            if ($user && password_verify($password, $user['password'])) {
                // Verificar si la cuenta está activa
                error_log("Estado del usuario: " . print_r($user['estado'], true));
                error_log("Tipo de estado: " . gettype($user['estado']));
            if ($user['estado'] != 1) {
                    $this->session->setFlash('error', 'Tu cuenta está inactiva. Por favor, contacta al administrador.');
                    $this->session->setFlash('email', $email);
                    header('Location: ' . Config::get('app_url') . 'login');
                    exit;
            }

                // Establecer variables de sesión
                $this->session->set('user_id', $user['id']);
                $this->session->set('user_email', $user['email']);
                $this->session->set('user_nombre', $user['nombre']);
                $this->session->set('user_rol', $user['rol']);

            // Log para depuración
                error_log("Datos de sesión establecidos: " . print_r([
                    'user_id' => $this->session->get('user_id'),
                    'user_email' => $this->session->get('user_email'),
                    'user_nombre' => $this->session->get('user_nombre'),
                    'user_rol' => $this->session->get('user_rol')
                ], true));

                // Redirigir según el rol
                header('Location: ' . Config::get('app_url') . 'dashboard');
                exit;
            }

            $this->session->setFlash('error', 'Credenciales inválidas');
            $this->session->setFlash('email', $email);
            header('Location: ' . Config::get('app_url') . 'login');
            exit;

        } catch (\Exception $e) {
            error_log("Error en el login: " . $e->getMessage());
            $this->session->setFlash('error', 'Ocurrió un error al procesar su solicitud. Por favor intente nuevamente.');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }
    }

    public function logout()
    {
        $this->session->destroy();
        header('Location: ' . Config::get('app_url'));
        exit;
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 