<?php

namespace App\Middleware;

use App\Core\ApiRespuesta;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Autenticación de la API de consulta v1 con API key (cabecera X-API-Key o Authorization: Bearer).
 * Aplica el límite de solicitudes por minuto de cada key y registra cada llamada autenticada en
 * api_keys_bitacora (incluidas las rechazadas por límite). La key nunca se guarda ni se registra:
 * se busca por su SHA-256.
 */
class ApiKeyMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $inicio = microtime(true);
        $key = self::extraerKey($request);
        if ($key === '') {
            return ApiRespuesta::error(401, 'no_autorizado', 'Falta la API key. Envíela en la cabecera X-API-Key.')
                ->withHeader('WWW-Authenticate', 'ApiKey');
        }

        try {
            $apiKey = DB::table('api_keys')->where('hash_key', hash('sha256', $key))->first();
        } catch (\Throwable $e) {
            error_log('API v1: error al validar la API key: ' . $e->getMessage());
            return ApiRespuesta::error(500, 'error_interno', 'No fue posible validar la API key.');
        }
        if (!$apiKey || (int) $apiKey->estado !== 1
            || ($apiKey->fecha_expiracion !== null && (string) $apiKey->fecha_expiracion < date('Y-m-d'))) {
            return ApiRespuesta::error(401, 'no_autorizado', 'La API key no es válida, fue revocada o expiró.')
                ->withHeader('WWW-Authenticate', 'ApiKey');
        }

        // Límite por minuto: llamadas registradas en los últimos 60 segundos (reloj de la base de datos)
        $limite = max(1, (int) $apiKey->limite_por_minuto);
        $usadas = (int) DB::table('api_keys_bitacora')
            ->where('api_key_id', $apiKey->id)
            ->whereRaw('fecha > NOW() - INTERVAL 60 SECOND')
            ->count();

        if ($usadas >= $limite) {
            $response = ApiRespuesta::error(429, 'limite_excedido', "Se superó el límite de {$limite} solicitudes por minuto. Intente nuevamente en un minuto.")
                ->withHeader('Retry-After', '60');
        } else {
            try {
                $response = $handler->handle($request->withAttribute('api_key', $apiKey));
            } catch (\Throwable $e) {
                error_log('API v1: ' . get_class($e) . ': ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
                $response = ApiRespuesta::error(500, 'error_interno', 'Error interno al procesar la consulta.');
            }
        }

        $response = $response
            ->withHeader('X-RateLimit-Limit', (string) $limite)
            ->withHeader('X-RateLimit-Remaining', (string) max(0, $limite - $usadas - 1));
        $this->registrar($apiKey, $request, $response->getStatusCode(), $inicio);

        return $response;
    }

    /**
     * API key enviada en X-API-Key o en Authorization: Bearer (no se acepta en la URL).
     */
    public static function extraerKey(Request $request): string
    {
        $key = trim($request->getHeaderLine('X-API-Key'));
        if ($key === '' && preg_match('/^Bearer\s+(\S+)$/i', trim($request->getHeaderLine('Authorization')), $m)) {
            $key = $m[1];
        }

        return strlen($key) <= 200 ? $key : '';
    }

    private function registrar(object $apiKey, Request $request, int $status, float $inicio): void
    {
        try {
            // Por si alguien envía la key en la URL: no se guarda ningún parámetro cuyo nombre contenga "key"
            $parametros = array_filter(
                $request->getQueryParams(),
                static fn ($nombre) => stripos((string) $nombre, 'key') === false,
                ARRAY_FILTER_USE_KEY
            );
            $query = http_build_query($parametros);
            $ip = (string) ($request->getServerParams()['REMOTE_ADDR'] ?? '');
            DB::table('api_keys_bitacora')->insert([
                'api_key_id' => $apiKey->id,
                'fecha' => DB::raw('NOW()'),
                'metodo' => substr($request->getMethod(), 0, 10),
                'ruta' => mb_substr($request->getUri()->getPath(), 0, 255),
                'parametros' => $query === '' ? null : mb_substr($query, 0, 500),
                'codigo_http' => $status,
                'duracion_ms' => (int) round((microtime(true) - $inicio) * 1000),
                'ip' => $ip === '' ? null : substr($ip, 0, 45),
            ]);
            DB::table('api_keys')->where('id', $apiKey->id)->update(['ultimo_uso' => DB::raw('NOW()')]);
        } catch (\Throwable $e) {
            error_log('API v1: no se pudo registrar la llamada en la bitácora: ' . $e->getMessage());
        }
    }
}
