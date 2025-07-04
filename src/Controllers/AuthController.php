<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use App\Core\LdapService;
use src\Models\Usuario;
use PDO;
use App\Core\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends BaseController
{
    protected $session;
    protected $userModel;
    protected $pdo;
    protected $ldapService;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->userModel = new Usuario();
        $this->ldapService = new LdapService();
        
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
                $this->slimJsonResponse([
                    'success' => false,
                    'message' => 'Error al conectar con el servidor. Por favor intente nuevamente.'
                ]);
            }
            die("Error de conexión a la base de datos");
        }
    }

    public function showLogin(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        error_log('AuthController::showLogin - Iniciando método');
        if ($this->session->get('user_id')) {
            error_log('AuthController::showLogin - Usuario ya autenticado, redirigiendo a dashboard');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'dashboard')
                ->withStatus(302);
        }
        $error = $this->session->getFlash('error');
        $email = $this->session->getFlash('email');
        error_log('AuthController::showLogin - Renderizando template login.twig');
        error_log('AuthController::showLogin - app_url: ' . Config::get('app_url'));
        $body = $this->twig->render('login.twig', [
            'session' => [
                'error' => $error,
                'email' => $email
            ],
            'app_url' => Config::get('app_url')
        ]);
        $response->getBody()->write($body);
        error_log('AuthController::showLogin - Template renderizado exitosamente');
        return $response;
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        try {
            $isAjax = !empty($request->getHeaderLine('X-Requested-With')) && strtolower($request->getHeaderLine('X-Requested-With')) == 'xmlhttprequest';
            $method = $request->getMethod();
            $parsedBody = $request->getParsedBody();
            $email = $parsedBody['email'] ?? '';
            $password = $parsedBody['password'] ?? '';

            if ($method !== 'POST') {
                if ($isAjax) {
                    return $this->slimJsonResponse($response, [
                        'success' => false,
                        'message' => 'Método no permitido'
                    ], 405);
                } else {
                    return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
                }
            }

            if (empty($email) || empty($password)) {
                if ($isAjax) {
                    return $this->slimJsonResponse($response, [
                        'success' => false,
                        'message' => 'Por favor complete todos los campos'
                    ]);
                } else {
                    $this->session->setFlash('error', 'Por favor complete todos los campos');
                    $this->session->setFlash('email', $email);
                    return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
                }
            }

            // Buscar usuario por email en la base de datos local
            $user = $this->userModel->findByEmail($email);
            
            if (!$user) {
                if ($isAjax) {
                    return $this->slimJsonResponse($response, [
                        'success' => false,
                        'message' => 'Usuario no encontrado en el sistema'
                    ]);
                } else {
                    $this->session->setFlash('error', 'Usuario no encontrado en el sistema');
                    $this->session->setFlash('email', $email);
                    return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
                }
            }

            // Verificar si el usuario está activo
            if ($user['estado'] != 1) {
                if ($isAjax) {
                    return $this->slimJsonResponse($response, [
                        'success' => false,
                        'message' => 'Tu cuenta está inactiva. Por favor, contacta al administrador.'
                    ]);
                } else {
                    $this->session->setFlash('error', 'Tu cuenta está inactiva. Por favor, contacta al administrador.');
                    $this->session->setFlash('email', $email);
                    return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
                }
            }

            // Intentar autenticación LDAP primero
            $ldapAuthenticated = false;
            $ldapUserInfo = null;

            try {
                // Verificar si el servidor LDAP está disponible
                if ($this->ldapService->isServerAvailable()) {
                    error_log("LDAP: Servidor disponible, intentando autenticación LDAP para RUT: {$user['rut']}");
                    
                    // Intentar autenticación LDAP con el RUT del usuario
                    $ldapResult = $this->ldapService->authenticate($user['rut'], $password);
                    
                    if ($ldapResult && $ldapResult['success']) {
                        $ldapAuthenticated = true;
                        $ldapUserInfo = $ldapResult['user'];
                        error_log("LDAP: Autenticación exitosa para RUT: {$user['rut']}");
                    } else {
                        error_log("LDAP: Autenticación fallida para RUT: {$user['rut']}");
                    }
                } else {
                    error_log("LDAP: Servidor no disponible, usando autenticación local");
                }
            } catch (\Exception $e) {
                error_log("LDAP: Error durante la autenticación LDAP: " . $e->getMessage());
            }

            // Si la autenticación LDAP falló o no está disponible, intentar con la contraseña local
            if (!$ldapAuthenticated) {
                if (password_verify($password, $user['password'])) {
                    error_log("Autenticación local exitosa para usuario: {$user['email']}");
                    $ldapAuthenticated = true; // Usar la misma variable para consistencia
                } else {
                    error_log("Autenticación local fallida para usuario: {$user['email']}");
                }
            }

            // Si la autenticación fue exitosa (LDAP o local)
            if ($ldapAuthenticated) {
                // Si la autenticación fue por LDAP, actualizar información del usuario si es necesario
                if ($ldapUserInfo) {
                    $this->updateUserInfoFromLdap($user['id'], $ldapUserInfo);
                }

                // Establecer datos de sesión
                $this->session->set('user_id', $user['id']);
                $this->session->set('user_email', $user['email']);
                $this->session->set('user_nombre', $user['nombre']);
                $this->session->set('user_rol', $user['rol']);
                
                error_log("Datos de sesión establecidos: " . print_r([
                    'user_id' => $this->session->get('user_id'),
                    'user_email' => $this->session->get('user_email'),
                    'user_nombre' => $this->session->get('user_nombre'),
                    'user_rol' => $this->session->get('user_rol')
                ], true));

                if ($isAjax) {
                    return $this->slimJsonResponse($response, [
                        'success' => true,
                        'redirect' => Config::get('app_url') . 'dashboard'
                    ]);
                } else {
                    return $response->withHeader('Location', Config::get('app_url') . 'dashboard')->withStatus(302);
                }
            }

            // Si llegamos aquí, la autenticación falló
            if ($isAjax) {
                return $this->slimJsonResponse($response, [
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ]);
            } else {
                $this->session->setFlash('error', 'Credenciales inválidas');
                $this->session->setFlash('email', $email);
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

        } catch (\Exception $e) {
            error_log("Error en el login: " . $e->getMessage());
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                return $this->slimJsonResponse($response, [
                    'success' => false,
                    'message' => 'Ocurrió un error al procesar su solicitud. Por favor intente nuevamente.'
                ]);
            } else {
                $this->session->setFlash('error', 'Ocurrió un error al procesar su solicitud. Por favor intente nuevamente.');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }
        }
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        $this->session->destroy();
        return $response->withHeader('Location', Config::get('app_url'))->withStatus(302);
    }

    public function clearSessionMessages(ServerRequestInterface $request, ResponseInterface $response, $args = []): ResponseInterface
    {
        // Limpiar mensajes de sesión
        $this->session->remove('swal');
        $this->session->remove('success');
        $this->session->remove('error');
        
        return $this->slimJsonResponse($response, [
            'success' => true,
            'message' => 'Mensajes de sesión limpiados'
        ]);
    }

    /**
     * Actualiza la información del usuario desde LDAP si es necesario
     */
    private function updateUserInfoFromLdap($userId, $ldapUserInfo)
    {
        try {
            // Solo actualizar si hay información nueva disponible
            $updateData = [];
            
            if (!empty($ldapUserInfo['nombre']) && $ldapUserInfo['nombre'] !== $this->userModel->find($userId)['nombre']) {
                $updateData['nombre'] = $ldapUserInfo['nombre'];
            }
            
            if (!empty($ldapUserInfo['email']) && $ldapUserInfo['email'] !== $this->userModel->find($userId)['email']) {
                $updateData['email'] = $ldapUserInfo['email'];
            }
            
            if (!empty($updateData)) {
                $this->userModel->update($userId, $updateData);
                error_log("LDAP: Información del usuario actualizada desde Active Directory");
            }
        } catch (\Exception $e) {
            error_log("LDAP: Error actualizando información del usuario: " . $e->getMessage());
        }
    }

    protected function slimJsonResponse(ResponseInterface $response, $data, $statusCode = 200): ResponseInterface
    {
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
} 