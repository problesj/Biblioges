<?php

namespace App\Controllers;

use App\Core\ApiRespuesta;
use App\Services\ConsultaBibliografiasApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * API de consulta v1 (JSON, solo lectura). La autenticación con API key, el límite por minuto y la
 * bitácora están en App\Middleware\ApiKeyMiddleware.
 * Documentación: docs/API.md y docs/openapi.yaml (Swagger UI en /biblioges/api/v1/docs).
 */
class ApiV1Controller
{
    private const PATRON_CODIGO = '/^[A-Za-z0-9._-]{1,20}$/';

    private ConsultaBibliografiasApi $consulta;

    public function __construct()
    {
        $this->consulta = new ConsultaBibliografiasApi();
    }

    /** GET /carreras */
    public function carreras(Request $request, Response $response): Response
    {
        $q = $request->getQueryParams();
        $tipo = $this->texto($q, 'tipo_programa');
        if ($tipo !== null) {
            $tipo = strtoupper($tipo);
            if (!in_array($tipo, ['P', 'G', 'O'], true)) {
                return $this->parametroInvalido('tipo_programa', 'Valores permitidos: P (pregrado), G (postgrado) u O (otro).');
            }
        }
        $sede = $this->texto($q, 'sede');
        if ($sede !== null && !preg_match('/^[A-Za-z0-9]{1,10}$/', $sede)) {
            return $this->parametroInvalido('sede', 'Indique el código de la sede, por ejemplo S001.');
        }
        $soloVigentes = $this->booleano($q, 'solo_vigentes');
        if ($soloVigentes === null) {
            return $this->parametroInvalido('solo_vigentes', 'Valores permitidos: true o false.');
        }

        $planes = $this->consulta->planes($tipo, $sede === null ? null : strtoupper($sede), $soloVigentes);

        return ApiRespuesta::json($response, ['total' => count($planes), 'carreras' => $planes]);
    }

    /** GET /carreras/{codigo}/bibliografias-declaradas */
    public function carreraDeclaradas(Request $request, Response $response, array $args): Response
    {
        return $this->carrera($request, $response, $args, false);
    }

    /** GET /carreras/{codigo}/bibliografias-disponibles */
    public function carreraDisponibles(Request $request, Response $response, array $args): Response
    {
        return $this->carrera($request, $response, $args, true);
    }

    /** GET /asignaturas/{codigo}/bibliografias-declaradas */
    public function asignaturaDeclaradas(Request $request, Response $response, array $args): Response
    {
        return $this->asignatura($request, $response, $args, false);
    }

    /** GET /asignaturas/{codigo}/bibliografias-disponibles */
    public function asignaturaDisponibles(Request $request, Response $response, array $args): Response
    {
        return $this->asignatura($request, $response, $args, true);
    }

    /** Rutas inexistentes dentro de /api/v1 (o métodos distintos de GET) */
    public function noEncontrada(Request $request, Response $response): Response
    {
        if (strtoupper($request->getMethod()) !== 'GET') {
            return ApiRespuesta::error(405, 'metodo_no_permitido', 'La API solo admite consultas GET.', [], $response)
                ->withHeader('Allow', 'GET');
        }

        return ApiRespuesta::error(404, 'ruta_no_encontrada', 'La ruta solicitada no existe. Vea la documentación en /biblioges/api/v1/docs.', [], $response);
    }

    /** GET /docs: Swagger UI (público) */
    public function docs(Request $request, Response $response): Response
    {
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API de consulta Biblioges v1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5.17.14/swagger-ui.css">
    <style>body { margin: 0; background: #fafafa; }</style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5.17.14/swagger-ui-bundle.js"></script>
    <script>
        window.addEventListener('load', function () {
            SwaggerUIBundle({ url: 'openapi.yaml', dom_id: '#swagger-ui', deepLinking: true, persistAuthorization: false });
        });
    </script>
</body>
</html>
HTML;
        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /** GET /openapi.yaml: especificación OpenAPI (público) */
    public function openapi(Request $request, Response $response): Response
    {
        $ruta = dirname(__DIR__, 2) . '/docs/openapi.yaml';
        if (!is_file($ruta)) {
            return ApiRespuesta::error(404, 'ruta_no_encontrada', 'La especificación no está disponible.', [], $response);
        }
        $response->getBody()->write((string) file_get_contents($ruta));

        return $response->withHeader('Content-Type', 'application/yaml; charset=utf-8');
    }

    private function carrera(Request $request, Response $response, array $args, bool $disponibles): Response
    {
        $q = $request->getQueryParams();
        $codigo = trim((string) ($args['codigo'] ?? ''));
        if (!preg_match(self::PATRON_CODIGO, $codigo)) {
            return $this->parametroInvalido('codigo', 'Código de carrera no válido.');
        }
        $vigencia = $this->texto($q, 'vigencia_desde');
        if ($vigencia !== null && !preg_match('/^\d{1,6}$/', $vigencia)) {
            return $this->parametroInvalido('vigencia_desde', 'Indique la vigencia con el formato AAAASS, por ejemplo 202610.');
        }
        [$tipoBibliografia, $tipos] = $this->tiposBibliografia($q);
        if ($tipos === null) {
            return $this->parametroInvalido('tipo_bibliografia', 'Valores permitidos: basica, complementaria, otro o todas.');
        }
        $formacion = $this->formacion($q);
        if ($formacion === null) {
            return $this->parametroInvalido('formacion', 'Valores permitidos: todas, ninguna, plan o una lista separada por comas de: '
                . implode(', ', array_keys(ConsultaBibliografiasApi::FORMACIONES)) . '.');
        }
        $ediciones = $disponibles ? $this->ediciones($q) : 'todas';
        if ($ediciones === null) {
            return $this->parametroInvalido('ediciones', 'Valores permitidos: todas o ultima.');
        }

        $busqueda = $this->consulta->buscarPlan($codigo, $vigencia);
        $plan = $busqueda['plan'];
        if ($plan === null) {
            if (!$busqueda['vigencias']) {
                return ApiRespuesta::error(404, 'carrera_no_encontrada', "No existe una carrera con el código {$codigo}.");
            }
            return ApiRespuesta::error(404, 'vigencia_no_encontrada',
                "La carrera {$codigo} no tiene un plan con vigencia desde {$vigencia}.",
                ['vigencias_disponibles' => $busqueda['vigencias']]);
        }

        $formacionesPlan = null;
        if ($formacion === 'plan') {
            $formacionesPlan = $this->consulta->formacionesGuardadas((int) $plan->id);
            $formaciones = $formacionesPlan ?? array_keys(ConsultaBibliografiasApi::FORMACIONES);
        } else {
            $formaciones = $formacion;
        }

        $asignaturas = $this->consulta->asignaturasPlan($plan, $formaciones);
        $bibliografias = $this->consulta->declaradasPorCodigos(array_column($asignaturas, 'codigo'), $tipos);
        [$asignaturas, $resumen] = $this->armar($asignaturas, $bibliografias, $tipos, $disponibles, $ediciones === 'ultima', (string) $plan->sede_codigo);

        $parametros = [
            'vigencia_desde' => $vigencia,
            'tipo_bibliografia' => $tipoBibliografia,
            'formacion' => $formaciones,
        ];
        if ($formacion === 'plan') {
            $parametros['formacion_origen'] = $formacionesPlan === null ? 'todas (el plan no tiene filtros guardados)' : 'filtros guardados del plan';
        }
        if ($disponibles) {
            $parametros['ediciones'] = $ediciones;
        }

        return ApiRespuesta::json($response, [
            'carrera' => $this->consulta->formatoPlan($plan),
            'parametros' => $parametros,
            'resumen' => ['asignaturas' => count($asignaturas)] + $resumen,
            'asignaturas' => $asignaturas,
        ]);
    }

    private function asignatura(Request $request, Response $response, array $args, bool $disponibles): Response
    {
        $q = $request->getQueryParams();
        $codigo = trim((string) ($args['codigo'] ?? ''));
        if (!preg_match(self::PATRON_CODIGO, $codigo)) {
            return $this->parametroInvalido('codigo', 'Código de asignatura no válido.');
        }
        [$tipoBibliografia, $tipos] = $this->tiposBibliografia($q);
        if ($tipos === null) {
            return $this->parametroInvalido('tipo_bibliografia', 'Valores permitidos: basica, complementaria, otro o todas.');
        }
        $ediciones = $disponibles ? $this->ediciones($q) : 'todas';
        if ($ediciones === null) {
            return $this->parametroInvalido('ediciones', 'Valores permitidos: todas o ultima.');
        }

        $a = $this->consulta->asignaturaPorCodigo($codigo);
        if ($a === null) {
            return ApiRespuesta::error(404, 'asignatura_no_encontrada', "No existe una asignatura con el código {$codigo}.");
        }
        $codigoReal = rtrim((string) $a->codigo_asignatura);
        $bibliografias = $this->consulta->declaradasPorCodigos([$codigoReal], $tipos);
        [$lista, $resumen] = $this->armar(
            [['codigo' => $codigoReal, 'nombre' => (string) $a->nombre, 'tipo' => (string) $a->tipo, 'asignaturas_malla' => []]],
            $bibliografias, $tipos, $disponibles, $ediciones === 'ultima', (string) $a->sede_codigo
        );

        $parametros = ['tipo_bibliografia' => $tipoBibliografia];
        if ($disponibles) {
            $parametros['ediciones'] = $ediciones;
        }

        return ApiRespuesta::json($response, [
            'asignatura' => [
                'codigo' => $codigoReal,
                'nombre' => (string) $a->nombre,
                'tipo' => (string) $a->tipo,
                'periodicidad' => (string) $a->periodicidad,
                'activa' => (int) $a->estado === 1,
                'unidad' => ['codigo' => (string) $a->unidad_codigo, 'nombre' => (string) $a->unidad_nombre],
                'sede' => ['codigo' => (string) $a->sede_codigo, 'nombre' => (string) $a->sede_nombre],
            ],
            'parametros' => $parametros,
            'resumen' => $resumen,
            'bibliografias' => $lista[0]['bibliografias'],
        ]);
    }

    /**
     * Agrega a cada asignatura sus bibliografías (y, si corresponde, sus disponibles) y calcula el resumen.
     * En la consulta de disponibles se omiten las bibliografías declaradas sin disponibles activas.
     *
     * @return array{0: array, 1: array} asignaturas y resumen
     */
    private function armar(array $asignaturas, array $bibliografias, array $tipos, bool $disponibles, bool $soloUltima, string $sedeCodigo): array
    {
        $ids = [];
        foreach ($bibliografias as $lista) {
            foreach ($lista as $b) {
                $ids[$b['id']] = true;
            }
        }
        $disponiblesPorDeclarada = $disponibles ? $this->consulta->disponibles(array_keys($ids), $soloUltima) : [];

        $porTipo = array_fill_keys($tipos, []);
        $declaradas = [];
        $conDisponibles = [];
        $idsDisponibles = [];
        foreach ($asignaturas as &$asignatura) {
            $lista = [];
            foreach ($bibliografias[ConsultaBibliografiasApi::normalizar($asignatura['codigo'])] ?? [] as $b) {
                $declaradas[$b['id']] = true;
                $porTipo[$b['tipo_bibliografia']][$b['id']] = true;
                if ($disponibles) {
                    $lista_disponibles = $disponiblesPorDeclarada[$b['id']] ?? [];
                    if (!$lista_disponibles) {
                        continue;
                    }
                    foreach ($lista_disponibles as &$d) {
                        $d['ejemplares_en_sede'] = 0;
                        foreach ($d['ejemplares'] as $e) {
                            if ($e['sede']['codigo'] === $sedeCodigo) {
                                $d['ejemplares_en_sede'] += $e['cantidad'];
                            }
                        }
                        $idsDisponibles[$d['id']] = true;
                    }
                    unset($d);
                    $b['disponibles'] = $lista_disponibles;
                    $conDisponibles[$b['id']] = true;
                }
                $lista[] = $b;
            }
            $asignatura['bibliografias'] = $lista;
        }
        unset($asignatura);

        $resumen = [
            'bibliografias_declaradas' => count($declaradas),
            'por_tipo' => array_map('count', $porTipo),
        ];
        if ($disponibles) {
            $resumen['declaradas_con_disponibles'] = count($conDisponibles);
            $resumen['disponibles'] = count($idsDisponibles);
        }

        return [$asignaturas, $resumen];
    }

    /** @return array{0: string, 1: ?array} valor del parámetro y tipos (null = valor no válido) */
    private function tiposBibliografia(array $q): array
    {
        $valor = strtolower($this->texto($q, 'tipo_bibliografia') ?? 'todas');
        if ($valor === 'todas') {
            return [$valor, ConsultaBibliografiasApi::TIPOS_BIBLIOGRAFIA];
        }

        return [$valor, in_array($valor, ConsultaBibliografiasApi::TIPOS_BIBLIOGRAFIA, true) ? [$valor] : null];
    }

    /** @return array|string|null lista de claves de formación, 'plan', o null si no es válido */
    private function formacion(array $q)
    {
        $valor = strtolower($this->texto($q, 'formacion') ?? 'todas');
        if ($valor === 'todas') {
            return array_keys(ConsultaBibliografiasApi::FORMACIONES);
        }
        if ($valor === 'ninguna') {
            return [];
        }
        if ($valor === 'plan') {
            return 'plan';
        }
        $lista = array_values(array_unique(array_filter(array_map('trim', explode(',', $valor)), 'strlen')));
        foreach ($lista as $clave) {
            if (!isset(ConsultaBibliografiasApi::FORMACIONES[$clave])) {
                return null;
            }
        }

        return $lista ?: null;
    }

    private function ediciones(array $q): ?string
    {
        $valor = strtolower($this->texto($q, 'ediciones') ?? 'todas');

        return in_array($valor, ['todas', 'ultima'], true) ? $valor : null;
    }

    private function texto(array $q, string $nombre): ?string
    {
        if (!isset($q[$nombre])) {
            return null;
        }
        if (!is_scalar($q[$nombre])) {
            return '[]';
        }
        $valor = trim((string) $q[$nombre]);

        return $valor === '' ? null : mb_substr($valor, 0, 200);
    }

    private function booleano(array $q, string $nombre): ?bool
    {
        $valor = strtolower($this->texto($q, $nombre) ?? 'false');
        if (in_array($valor, ['true', '1'], true)) {
            return true;
        }

        return in_array($valor, ['false', '0'], true) ? false : null;
    }

    private function parametroInvalido(string $parametro, string $mensaje): Response
    {
        return ApiRespuesta::error(400, 'parametro_invalido', $mensaje, ['parametro' => $parametro]);
    }
}
