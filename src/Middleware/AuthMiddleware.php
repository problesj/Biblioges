<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    /**
     * Secciones permitidas por rol (prefijos de ruta relativos a /biblioges).
     * Debe coincidir con el menú lateral de templates/base.twig.
     * El rol 'admin' tiene acceso total.
     */
    private const PERMISOS = [
        'admin_bidoc' => [
            '/carreras',
            '/asignaturas',
            '/mallas',
            '/bibliografias-declaradas',
            '/bibliografias-disponibles',
            '/autores',
            '/reportes',
            '/api',
        ],
        'usuario' => [
            '/reportes',
        ],
    ];

    /**
     * Rutas disponibles para cualquier usuario autenticado.
     */
    private const RUTAS_COMUNES = [
        '/',
        '/dashboard',
        '/perfil',
        '/clear-session-messages',
    ];

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            $response = new Response();
            return $response
                ->withHeader('Location', '/biblioges/login')
                ->withStatus(302);
        }

        // Verificar si el rol tiene acceso a la ruta solicitada
        $rol = strtolower((string)($_SESSION['user_rol'] ?? ''));
        $ruta = $this->rutaRelativa($request->getUri()->getPath());

        if (!$this->tieneAcceso($rol, $ruta)) {
            error_log("AuthMiddleware: acceso denegado al rol '{$rol}' para {$ruta}");
            return $this->accesoDenegado($request);
        }

        return $handler->handle($request);
    }

    private function rutaRelativa(string $path): string
    {
        if (strpos($path, '/biblioges') === 0) {
            $path = substr($path, strlen('/biblioges'));
        }
        return '/' . trim($path, '/');
    }

    private function tieneAcceso(string $rol, string $ruta): bool
    {
        if ($rol === 'admin') {
            return true;
        }

        $permitidas = array_merge(self::RUTAS_COMUNES, self::PERMISOS[$rol] ?? []);
        foreach ($permitidas as $prefijo) {
            if ($prefijo === '/') {
                if ($ruta === '/') {
                    return true;
                }
                continue;
            }
            // Coincidencia por segmento completo: '/reportes' no habilita '/reportesX'
            if ($ruta === $prefijo || strpos($ruta, $prefijo . '/') === 0) {
                return true;
            }
        }
        return false;
    }

    private function accesoDenegado(Request $request): Response
    {
        $response = new Response();
        $esAjax = strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest'
            || strpos($request->getHeaderLine('Accept'), 'application/json') !== false
            || strpos($request->getHeaderLine('Content-Type'), 'application/json') !== false;

        if ($esAjax || strtoupper($request->getMethod()) !== 'GET') {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'No tiene permisos para realizar esta acción.',
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        }

        return $response
            ->withHeader('Location', '/biblioges/dashboard')
            ->withStatus(302);
    }
}
