<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Core\Config;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Log para depuración
        error_log('AuthMiddleware: Verificando autenticación');
        error_log('AuthMiddleware: URI actual: ' . $request->getUri()->getPath());
        error_log('AuthMiddleware: Session data: ' . print_r($_SESSION, true));
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            error_log('AuthMiddleware: Usuario no autenticado, redirigiendo a /biblioges/login');
            $response = new Response();
            $redirectUrl = '/biblioges/login';
            error_log('AuthMiddleware: URL de redirección: ' . $redirectUrl);
            return $response
                ->withHeader('Location', $redirectUrl)
                ->withStatus(302);
        }

        error_log('AuthMiddleware: Usuario autenticado, continuando');
        return $handler->handle($request);
    }

    public function handle($request, $next)
    {
        // Log para depuración
        error_log('AuthMiddleware handle: Verificando autenticación');
        error_log('AuthMiddleware handle: Session data: ' . print_r($_SESSION, true));
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            error_log('AuthMiddleware handle: Usuario no autenticado, redirigiendo a /biblioges/login');
            header('Location: /biblioges/login');
            exit;
        }

        error_log('AuthMiddleware handle: Usuario autenticado, continuando');
        return $next($request);
    }

    public function requireRole($roles)
    {
        return function($request, $next) use ($roles) {
            // Log para depuración
            error_log('AuthMiddleware requireRole: Verificando rol');
            error_log('AuthMiddleware requireRole: Session data: ' . print_r($_SESSION, true));
            error_log('AuthMiddleware requireRole: Required roles: ' . print_r($roles, true));
            
            if (!isset($_SESSION['user_id'])) {
                error_log('AuthMiddleware requireRole: Usuario no autenticado, redirigiendo a /biblioges/login');
                $response = new Response();
                return $response
                    ->withHeader('Location', '/biblioges/login')
                    ->withStatus(302);
            }

            if (!in_array($_SESSION['user_rol'], $roles)) {
                error_log('AuthMiddleware requireRole: Usuario sin permisos, redirigiendo a /biblioges/dashboard');
                $response = new Response();
                return $response
                    ->withHeader('Location', '/biblioges/dashboard')
                    ->withStatus(302);
            }

            error_log('AuthMiddleware requireRole: Usuario autenticado y con rol correcto, continuando');
            return $next($request);
        };
    }

    /**
     * Middleware para verificar permisos basados en roles
     */
    public function checkPermissions()
    {
        return function($request, $next) {
            $path = $request->getUri()->getPath();
            $userRole = $_SESSION['user_rol'] ?? '';
            
            // Definir permisos por rol
            $permissions = [
                'admin' => ['*'], // Acceso total
                'admin_bidoc' => [
                    '/biblioges/dashboard',
                    '/biblioges/bibliografias-declaradas',
                    '/biblioges/bibliografias-disponibles',
                    '/biblioges/reportes',
                    '/biblioges/autores',
                    '/biblioges/usuarios'
                ],
                'usuario' => [
                    '/biblioges/dashboard',
                    '/biblioges/reportes'
                ]
            ];
            
            // Si es admin, permitir todo
            if ($userRole === 'admin') {
                return $next($request);
            }
            
            // Verificar si el usuario tiene permisos para la ruta actual
            $allowedPaths = $permissions[$userRole] ?? [];
            $hasPermission = false;
            
            foreach ($allowedPaths as $allowedPath) {
                if (strpos($path, $allowedPath) === 0) {
                    $hasPermission = true;
                    break;
                }
            }
            
            if (!$hasPermission) {
                error_log("AuthMiddleware checkPermissions: Usuario sin permisos para {$path}");
                $response = new Response();
                return $response
                    ->withHeader('Location', '/biblioges/dashboard')
                    ->withStatus(302);
            }
            
            return $next($request);
        };
    }
} 