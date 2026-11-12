<?php

namespace App\Core;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

/**
 * Respuestas JSON de la API de consulta v1.
 */
final class ApiRespuesta
{
    private const FLAGS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE;

    public static function json(ResponseInterface $response, array $datos, int $status = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($datos, self::FLAGS));

        return $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Cache-Control', 'no-store');
    }

    /**
     * Error con el formato {"error": {"codigo": ..., "mensaje": ...}}.
     */
    public static function error(int $status, string $codigo, string $mensaje, array $extra = [], ?ResponseInterface $response = null): ResponseInterface
    {
        return self::json($response ?? new Response(), ['error' => ['codigo' => $codigo, 'mensaje' => $mensaje] + $extra], $status);
    }
}
