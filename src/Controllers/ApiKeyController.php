<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Administración de las API keys de la API de consulta v1 (solo rol admin).
 * La key completa se muestra una sola vez al crearla; en la base de datos queda solo su SHA-256.
 */
class ApiKeyController
{
    private const PREFIJO = 'bg_';
    private const LARGO_PREFIJO_VISIBLE = 11;

    public function index(Request $request, Response $response): Response
    {
        if ($denegado = $this->soloAdmin($response, false)) {
            return $denegado;
        }
        $keys = DB::select(
            "SELECT k.id, k.nombre, k.descripcion, k.prefijo, k.limite_por_minuto, k.fecha_expiracion, k.estado,
                    k.ultimo_uso, k.fecha_creacion, k.fecha_revocacion, uc.nombre AS creado_por, ur.nombre AS revocado_por,
                    (SELECT COUNT(*) FROM api_keys_bitacora b
                      WHERE b.api_key_id = k.id AND b.fecha >= NOW() - INTERVAL 30 DAY) AS usos_30_dias
               FROM api_keys k
               LEFT JOIN usuarios uc ON uc.id = k.creado_por
               LEFT JOIN usuarios ur ON ur.id = k.revocado_por
              ORDER BY k.estado DESC, k.fecha_creacion DESC, k.id DESC"
        );
        $hoy = date('Y-m-d');
        foreach ($keys as $k) {
            $k->expirada = $k->fecha_expiracion !== null && (string) $k->fecha_expiracion < $hoy;
        }

        global $twig;
        $html = $twig->render('api_keys/index.twig', [
            'keys' => $keys,
            'csrf' => $this->tokenCsrf(),
            'hoy' => $hoy,
            'url_docs' => app_url('api/v1/docs'),
            'url_base_api' => app_url('api/v1'),
            'session' => [
                'user_id' => $_SESSION['user_id'] ?? null,
                'user_email' => $_SESSION['user_email'] ?? null,
                'user_nombre' => $_SESSION['user_nombre'] ?? null,
                'user_rol' => $_SESSION['user_rol'] ?? null,
            ],
            'app_url' => app_url(),
            'current_page' => 'api-keys',
        ]);
        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    public function crear(Request $request, Response $response): Response
    {
        if ($denegado = $this->soloAdmin($response, true)) {
            return $denegado;
        }
        if (!$this->csrfValido($request)) {
            return $this->json($response, ['success' => false, 'message' => 'La sesión cambió. Recargue la página e intente nuevamente.'], 403);
        }
        $datos = $this->datos($request);
        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $descripcion = trim((string) ($datos['descripcion'] ?? ''));
        $limite = filter_var($datos['limite_por_minuto'] ?? 60, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1000]]);
        $expiracion = trim((string) ($datos['fecha_expiracion'] ?? ''));

        $errores = [];
        if ($nombre === '' || mb_strlen($nombre) > 100) {
            $errores[] = 'El nombre es obligatorio (máximo 100 caracteres).';
        }
        if (mb_strlen($descripcion) > 255) {
            $errores[] = 'La descripción admite hasta 255 caracteres.';
        }
        if ($limite === false) {
            $errores[] = 'El límite por minuto debe ser un número entre 1 y 1000.';
        }
        if ($expiracion !== '') {
            $fecha = \DateTime::createFromFormat('!Y-m-d', $expiracion);
            if (!$fecha || $fecha->format('Y-m-d') !== $expiracion) {
                $errores[] = 'La fecha de expiración no es válida.';
            } elseif ($expiracion < date('Y-m-d')) {
                $errores[] = 'La fecha de expiración no puede ser anterior a hoy.';
            }
        }
        if ($errores) {
            return $this->json($response, ['success' => false, 'message' => implode(' ', $errores)], 422);
        }

        $key = self::PREFIJO . bin2hex(random_bytes(24));
        $prefijo = substr($key, 0, self::LARGO_PREFIJO_VISIBLE);
        $id = DB::table('api_keys')->insertGetId([
            'nombre' => $nombre,
            'descripcion' => $descripcion === '' ? null : $descripcion,
            'prefijo' => $prefijo,
            'hash_key' => hash('sha256', $key),
            'limite_por_minuto' => $limite,
            'fecha_expiracion' => $expiracion === '' ? null : $expiracion,
            'estado' => 1,
            'creado_por' => $this->usuarioId(),
        ]);
        error_log("API v1: API key #{$id} ({$prefijo}…) creada por el usuario #" . ($this->usuarioId() ?? '?'));

        return $this->json($response, ['success' => true, 'id' => (int) $id, 'prefijo' => $prefijo, 'key' => $key]);
    }

    public function revocar(Request $request, Response $response, array $args): Response
    {
        if ($denegado = $this->soloAdmin($response, true)) {
            return $denegado;
        }
        if (!$this->csrfValido($request)) {
            return $this->json($response, ['success' => false, 'message' => 'La sesión cambió. Recargue la página e intente nuevamente.'], 403);
        }
        $id = (int) ($args['id'] ?? 0);
        $filas = DB::table('api_keys')->where('id', $id)->where('estado', 1)->update([
            'estado' => 0,
            'fecha_revocacion' => DB::raw('NOW()'),
            'revocado_por' => $this->usuarioId(),
        ]);
        if (!$filas) {
            return $this->json($response, ['success' => false, 'message' => 'La API key no existe o ya estaba revocada.'], 404);
        }
        error_log("API v1: API key #{$id} revocada por el usuario #" . ($this->usuarioId() ?? '?'));

        return $this->json($response, ['success' => true]);
    }

    public function bitacora(Request $request, Response $response, array $args): Response
    {
        if ($denegado = $this->soloAdmin($response, true)) {
            return $denegado;
        }
        $id = (int) ($args['id'] ?? 0);
        $key = DB::table('api_keys')->where('id', $id)->first(['id', 'nombre', 'prefijo']);
        if (!$key) {
            return $this->json($response, ['success' => false, 'message' => 'La API key no existe.'], 404);
        }
        $ultimas = DB::select(
            'SELECT fecha, metodo, ruta, parametros, codigo_http, duracion_ms, ip
               FROM api_keys_bitacora WHERE api_key_id = ? ORDER BY id DESC LIMIT 100',
            [$id]
        );
        $porCodigo = DB::select(
            'SELECT codigo_http, COUNT(*) AS cantidad
               FROM api_keys_bitacora WHERE api_key_id = ? AND fecha >= NOW() - INTERVAL 30 DAY
              GROUP BY codigo_http ORDER BY codigo_http',
            [$id]
        );

        return $this->json($response, [
            'success' => true,
            'key' => ['id' => (int) $key->id, 'nombre' => $key->nombre, 'prefijo' => $key->prefijo],
            'resumen_30_dias' => $porCodigo,
            'ultimas' => $ultimas,
        ]);
    }

    private function soloAdmin(Response $response, bool $json): ?Response
    {
        if (($_SESSION['user_rol'] ?? '') === 'admin') {
            return null;
        }
        if ($json) {
            return $this->json($response, ['success' => false, 'message' => 'No tiene permisos para realizar esta acción.'], 403);
        }

        return $response->withHeader('Location', app_url('dashboard'))->withStatus(302);
    }

    private function tokenCsrf(): string
    {
        if (empty($_SESSION['api_keys_csrf'])) {
            $_SESSION['api_keys_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['api_keys_csrf'];
    }

    private function csrfValido(Request $request): bool
    {
        $token = $request->getHeaderLine('X-CSRF-Token');

        return !empty($_SESSION['api_keys_csrf']) && $token !== '' && hash_equals($_SESSION['api_keys_csrf'], $token);
    }

    private function datos(Request $request): array
    {
        if (stripos($request->getHeaderLine('Content-Type'), 'application/json') !== false) {
            $datos = json_decode((string) $request->getBody(), true);
            return is_array($datos) ? $datos : [];
        }
        $datos = $request->getParsedBody();

        return is_array($datos) ? $datos : [];
    }

    private function usuarioId(): ?int
    {
        $id = (int) ($_SESSION['user_id'] ?? 0);

        return $id > 0 ? $id : null;
    }

    private function json(Response $response, array $datos, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG));

        return $response->withStatus($status)->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
