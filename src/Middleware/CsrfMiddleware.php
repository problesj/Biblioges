<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * Protección CSRF de las rutas con sesión: toda petición que modifica datos (POST, PUT, PATCH, DELETE)
 * debe traer el token de la sesión en la cabecera X-CSRF-Token o en el campo _csrf del formulario.
 * El token lo entrega csrf_token() (public/index.php) y base.twig lo agrega automáticamente a fetch,
 * XMLHttpRequest/jQuery y formularios.
 */
class CsrfMiddleware
{
    public const CAMPO = '_csrf';
    public const CABECERA = 'X-CSRF-Token';

    public static function token(): string
    {
        if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (in_array(strtoupper($request->getMethod()), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $handler->handle($request);
        }

        $enviado = $request->getHeaderLine(self::CABECERA);
        if ($enviado === '') {
            $cuerpo = $request->getParsedBody();
            if (is_array($cuerpo) && isset($cuerpo[self::CAMPO]) && is_string($cuerpo[self::CAMPO])) {
                $enviado = $cuerpo[self::CAMPO];
            }
        }
        $esperado = $_SESSION['csrf_token'] ?? '';
        if (is_string($esperado) && $esperado !== '' && $enviado !== '' && hash_equals($esperado, $enviado)) {
            return $handler->handle($request);
        }

        error_log('CSRF: solicitud rechazada ' . $request->getMethod() . ' ' . $request->getUri()->getPath());
        $mensaje = 'La solicitud no es válida o la sesión expiró. Recargue la página e intente nuevamente.';
        $response = new Response(403);
        $esJson = strtolower($request->getHeaderLine('X-Requested-With')) === 'xmlhttprequest'
            || stripos($request->getHeaderLine('Accept'), 'application/json') !== false
            || stripos($request->getHeaderLine('Content-Type'), 'application/json') !== false;
        if ($esJson) {
            $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje], JSON_UNESCAPED_UNICODE));

            return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
        }
        $response->getBody()->write('<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Solicitud no válida</title></head>'
            . '<body style="font-family:sans-serif;padding:2rem"><h1>Solicitud no válida</h1><p>' . htmlspecialchars($mensaje) . '</p>'
            . '<p><a href="javascript:history.back()">Volver</a></p></body></html>');

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }
}
