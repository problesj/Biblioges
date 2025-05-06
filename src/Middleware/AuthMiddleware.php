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
        error_log('Session data: ' . print_r($_SESSION, true));
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            error_log('AuthMiddleware: Usuario no autenticado, redirigiendo a login');
            $response = new Response();
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        error_log('AuthMiddleware: Usuario autenticado, continuando');
        return $handler->handle($request);
    }

    public function handle($request, $next)
    {
        // Log para depuración
        error_log('AuthMiddleware handle: Verificando autenticación');
        error_log('Session data: ' . print_r($_SESSION, true));
        
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            error_log('AuthMiddleware handle: Usuario no autenticado, redirigiendo a login');
            header('Location: ' . Config::get('app_url') . 'login');
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
            error_log('Session data: ' . print_r($_SESSION, true));
            error_log('Required roles: ' . print_r($roles, true));
            
            if (!isset($_SESSION['user_id'])) {
                error_log('AuthMiddleware requireRole: Usuario no autenticado, redirigiendo a login');
                $response = new Response();
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            if (!in_array($_SESSION['user_role'], $roles)) {
                error_log('AuthMiddleware requireRole: Usuario sin permisos, redirigiendo a dashboard');
                $response = new Response();
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'dashboard')
                    ->withStatus(302);
            }

            error_log('AuthMiddleware requireRole: Usuario autenticado y con rol correcto, continuando');
            return $next($request);
        };
    }
} 