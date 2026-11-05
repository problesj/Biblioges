<?php

namespace App\Controllers;

use App\Services\EjecutorTareas;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Controllers\BaseController;

class TareaProgramadaController extends BaseController
{
    private const TIPOS_REPORTE = [
        'cobertura_basica_expandido' => 'Cobertura Básica',
        'cobertura_complementaria_expandido' => 'Cobertura Complementaria',
        'cobertura_ambas_expandido' => 'Básica y Complementaria',
    ];

    private const ESTADOS = [
        'pendiente' => 'Pendiente',
        'en_proceso' => 'En Proceso',
        'completada' => 'Completada',
        'error' => 'Error',
        'cancelada' => 'Cancelada',
    ];

    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
    }

    /**
     * Listado con filtros, paginación y ordenamiento
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        try {
            $q = $request->getQueryParams();
            $page = max(1, (int) ($q['page'] ?? 1));
            $allowedPerPage = [5, 10, 15, 20];
            $perPage = (int) ($q['per_page'] ?? 10);
            if (!in_array($perPage, $allowedPerPage, true)) {
                $perPage = 10;
            }

            $allowedColumns = ['id', 'nombre', 'tipo_reporte', 'sede_nombre', 'carrera_nombre', 'frecuencia',
                'fecha_programada', 'estado', 'ultima_ejecucion', 'fecha_creacion'];
            $sortColumn = in_array($q['sort'] ?? '', $allowedColumns, true) ? $q['sort'] : 'fecha_programada';
            $sortDirection = strtoupper($q['direction'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';

            $search = trim((string) ($q['search'] ?? ''));
            $tipoReporte = array_key_exists($q['tipo_reporte'] ?? '', self::TIPOS_REPORTE) ? $q['tipo_reporte'] : '';
            $estado = array_key_exists($q['estado'] ?? '', self::ESTADOS) ? $q['estado'] : '';
            $frecuencia = array_key_exists($q['frecuencia'] ?? '', EjecutorTareas::FRECUENCIAS) ? $q['frecuencia'] : '';

            $consulta = DB::table('tareas_programadas as tp')
                ->leftJoin('sedes as s', 'tp.sede_id', '=', 's.id')
                ->leftJoin('carreras as c', 'tp.carrera_id', '=', 'c.id');
            if ($search !== '') {
                $like = '%' . $search . '%';
                $consulta->where(function ($w) use ($like) {
                    $w->where('tp.nombre', 'like', $like)
                        ->orWhere('s.nombre', 'like', $like)
                        ->orWhere('c.nombre', 'like', $like);
                });
            }
            if ($tipoReporte !== '') {
                $consulta->where('tp.tipo_reporte', $tipoReporte);
            }
            if ($estado !== '') {
                $consulta->where('tp.estado', $estado);
            }
            if ($frecuencia !== '') {
                $consulta->where('tp.frecuencia', $frecuencia);
            }

            $totalRecords = (clone $consulta)->count();
            $totalPages = (int) ceil($totalRecords / $perPage);

            $ordenSql = in_array($sortColumn, ['sede_nombre', 'carrera_nombre'], true) ? $sortColumn : 'tp.' . $sortColumn;
            $tareas = $consulta
                ->select('tp.*', 's.nombre as sede_nombre', 'c.nombre as carrera_nombre')
                ->orderBy($ordenSql, $sortDirection)
                ->orderBy('tp.id', 'DESC')
                ->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->get();

            $sedes = DB::table('vw_mallas')->select('id_sede as id', 'sede')->distinct()->orderBy('sede')->get();
            $carreras = EjecutorTareas::carrerasActivasPorSede();

            return $this->render($response, 'tareas_programadas/index.twig', [
                'tareas' => $tareas,
                'sedes' => $sedes,
                'carreras' => $carreras,
                'tiposReporte' => self::TIPOS_REPORTE,
                'estados' => self::ESTADOS,
                'frecuencias' => EjecutorTareas::FRECUENCIAS,
                'ahora' => EjecutorTareas::ahora(),
                'session' => $_SESSION ?? [],
                'app_url' => app_url(),
                'current_page' => 'tareas_programadas',
                'filtros' => [
                    'search' => $search,
                    'tipo_reporte' => $tipoReporte,
                    'estado' => $estado,
                    'frecuencia' => $frecuencia,
                ],
                'paginacion' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_records' => $totalRecords,
                    'total_pages' => $totalPages,
                    'has_previous' => $page > 1,
                    'has_next' => $page < $totalPages,
                    'previous_page' => $page - 1,
                    'next_page' => $page + 1,
                    'allowed_per_page' => $allowedPerPage,
                ],
                'ordenamiento' => [
                    'column' => $sortColumn,
                    'direction' => $sortDirection,
                ],
            ]);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@index: ' . $e->getMessage());

            return $this->errorResponse($response, 'Error al cargar el listado de tareas programadas', 500);
        }
    }

    /**
     * Crear una o varias tareas (una por carrera seleccionada)
     */
    public function crear(Request $request, Response $response, array $args): Response
    {
        try {
            $datos = $this->validar($this->leerJson($request), true);

            $ids = [];
            DB::connection()->transaction(function () use ($datos, &$ids) {
                foreach ($datos['carreras'] as $carrera) {
                    $ids[] = DB::table('tareas_programadas')->insertGetId([
                        'nombre' => $datos['nombre_manual'] ?? EjecutorTareas::generarNombre(
                            $carrera['nombre'], $datos['sede_nombre'], $datos['tipo_reporte'], $datos['frecuencia']
                        ),
                        'tipo_reporte' => $datos['tipo_reporte'],
                        'sede_id' => $datos['sede_id'],
                        'carrera_id' => $carrera['id'],
                        'fecha_programada' => $datos['fecha_programada'],
                        'frecuencia' => $datos['frecuencia'],
                        'fecha_inicio' => $datos['fecha_programada'],
                        'fecha_fin' => $datos['fecha_fin'],
                        'estado' => 'pendiente',
                        'filtros_formacion' => json_encode([]),
                        'creado_por' => isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null,
                    ]);
                }
            });

            $mensaje = count($ids) === 1 ? 'Tarea programada creada correctamente' : count($ids) . ' tareas programadas creadas correctamente';

            return $this->json($response, ['success' => true, 'message' => $mensaje, 'ids' => $ids]);
        } catch (\InvalidArgumentException $e) {
            return $this->json($response, ['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@crear: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al crear la tarea programada'], 500);
        }
    }

    /**
     * Datos de una tarea para el formulario de edición
     */
    public function obtener(Request $request, Response $response, array $args): Response
    {
        $tarea = DB::table('tareas_programadas')->where('id', (int) $args['id'])->first();
        if (!$tarea) {
            return $this->json($response, ['success' => false, 'message' => 'Tarea no encontrada'], 404);
        }
        $tipos = EjecutorTareas::TIPOS[$tarea->tipo_reporte] ?? [];
        $carrera = DB::table('carreras')->where('id', $tarea->carrera_id)->first(['nombre', 'estado']);
        $plan = EjecutorTareas::planVigente((int) $tarea->carrera_id, (int) $tarea->sede_id);

        return $this->json($response, ['success' => true, 'tarea' => [
            'id' => (int) $tarea->id,
            'nombre' => $tarea->nombre,
            'sede_id' => (int) $tarea->sede_id,
            'carrera_id' => (int) $tarea->carrera_id,
            'carrera_nombre' => $carrera->nombre ?? '',
            'carrera_codigo' => $plan->codigo_carrera ?? '',
            'carrera_activa' => (int) ($carrera->estado ?? 0) === 1,
            'tipos' => $tipos,
            'frecuencia' => $tarea->frecuencia ?? 'unica',
            'fecha_programada' => date('Y-m-d\TH:i', strtotime($tarea->fecha_programada)),
            'fecha_fin' => $tarea->fecha_fin ? date('Y-m-d', strtotime($tarea->fecha_fin)) : '',
            'estado' => $tarea->estado,
        ]]);
    }

    /**
     * Editar una tarea (pendiente, completada, cancelada o con error). Queda pendiente con la nueva fecha.
     */
    public function actualizar(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];
            $tarea = DB::table('tareas_programadas')->where('id', $id)->first();
            if (!$tarea) {
                return $this->json($response, ['success' => false, 'message' => 'Tarea no encontrada'], 404);
            }
            if ($tarea->estado === 'en_proceso') {
                return $this->json($response, ['success' => false, 'message' => 'La tarea se está ejecutando; espere a que termine para editarla'], 409);
            }

            $datos = $this->validar($this->leerJson($request), false, (int) $tarea->carrera_id);
            $carrera = $datos['carreras'][0];

            $actualizadas = DB::table('tareas_programadas')
                ->where('id', $id)
                ->where('estado', '!=', 'en_proceso')
                ->update([
                    'nombre' => $datos['nombre_manual'] ?? EjecutorTareas::generarNombre(
                        $carrera['nombre'], $datos['sede_nombre'], $datos['tipo_reporte'], $datos['frecuencia']
                    ),
                    'tipo_reporte' => $datos['tipo_reporte'],
                    'sede_id' => $datos['sede_id'],
                    'carrera_id' => $carrera['id'],
                    'fecha_programada' => $datos['fecha_programada'],
                    'frecuencia' => $datos['frecuencia'],
                    'fecha_inicio' => $datos['fecha_programada'],
                    'fecha_fin' => $datos['fecha_fin'],
                    'estado' => 'pendiente',
                    'error_mensaje' => null,
                ]);
            if ($actualizadas !== 1) {
                return $this->json($response, ['success' => false, 'message' => 'La tarea comenzó a ejecutarse; intente nuevamente en unos minutos'], 409);
            }

            return $this->json($response, ['success' => true, 'message' => 'Tarea actualizada y programada correctamente']);
        } catch (\InvalidArgumentException $e) {
            return $this->json($response, ['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@actualizar: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al actualizar la tarea programada'], 500);
        }
    }

    /**
     * Listado JSON (compatibilidad)
     */
    public function listar(Request $request, Response $response, array $args): Response
    {
        try {
            $tareas = DB::table('tareas_programadas as tp')
                ->leftJoin('sedes as s', 'tp.sede_id', '=', 's.id')
                ->leftJoin('carreras as c', 'tp.carrera_id', '=', 'c.id')
                ->select('tp.*', 's.nombre as sede_nombre', 'c.nombre as carrera_nombre')
                ->orderBy('tp.fecha_programada', 'desc')
                ->get();

            return $this->json($response, ['success' => true, 'tareas' => $tareas]);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@listar: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al listar las tareas programadas'], 500);
        }
    }

    /**
     * Cancelar una tarea pendiente
     */
    public function cancelar(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];
            if (!DB::table('tareas_programadas')->where('id', $id)->exists()) {
                return $this->json($response, ['success' => false, 'message' => 'Tarea no encontrada'], 404);
            }
            $actualizadas = DB::table('tareas_programadas')
                ->where('id', $id)
                ->where('estado', 'pendiente')
                ->update(['estado' => 'cancelada']);
            if ($actualizadas !== 1) {
                return $this->json($response, ['success' => false, 'message' => 'Solo se pueden cancelar tareas pendientes'], 400);
            }

            return $this->json($response, ['success' => true, 'message' => 'Tarea cancelada correctamente']);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@cancelar: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al cancelar la tarea'], 500);
        }
    }

    /**
     * Historial de ejecuciones de una tarea
     */
    public function historial(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];
            $tarea = DB::table('tareas_programadas')->where('id', $id)->first();
            if (!$tarea) {
                return $this->json($response, ['success' => false, 'message' => 'Tarea no encontrada'], 404);
            }
            $ejecuciones = DB::table('tareas_programadas_ejecuciones')
                ->where('tarea_id', $id)
                ->orderByDesc('fecha_inicio')
                ->orderByDesc('id')
                ->limit(200)
                ->get(['tipo_reporte', 'manual', 'fecha_inicio', 'fecha_fin', 'estado', 'registros', 'mensaje']);

            return $this->json($response, [
                'success' => true,
                'tarea' => [
                    'id' => (int) $tarea->id,
                    'nombre' => $tarea->nombre,
                    'estado' => $tarea->estado,
                    'frecuencia' => $tarea->frecuencia ?? 'unica',
                    'fecha_programada' => $tarea->fecha_programada,
                    'ultima_ejecucion' => $tarea->ultima_ejecucion ?? $tarea->fecha_ejecucion,
                    'error_mensaje' => $tarea->error_mensaje,
                ],
                'ejecuciones' => $ejecuciones,
            ]);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@historial: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al obtener el historial'], 500);
        }
    }

    /**
     * "Ejecutar ahora": ejecuta la tarea inmediatamente sin cambiar su programación
     */
    public function ejecutarAhora(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];
            if (!DB::table('tareas_programadas')->where('id', $id)->exists()) {
                return $this->json($response, ['success' => false, 'message' => 'Tarea no encontrada'], 404);
            }
            @set_time_limit(900);
            ignore_user_abort(true);

            $resultado = (new EjecutorTareas())->ejecutar($id, true);
            if ($resultado === null) {
                return $this->json($response, ['success' => false, 'message' => 'La tarea ya se está ejecutando'], 409);
            }

            $partes = [];
            foreach ($resultado['registros'] as $tipo => $cantidad) {
                $partes[] = ucfirst($tipo) . ': ' . $cantidad . ' registros';
            }
            if ($resultado['exito']) {
                return $this->json($response, ['success' => true, 'message' => 'Reporte guardado. ' . implode('; ', $partes)]);
            }

            return $this->json($response, [
                'success' => false,
                'message' => 'La ejecución terminó con errores: ' . implode(' | ', $resultado['errores']),
            ], 500);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@ejecutarAhora: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al ejecutar la tarea'], 500);
        }
    }

    /**
     * Ejecutar todas las tareas pendientes vencidas (misma lógica que el cron)
     */
    public function ejecutarTareasPendientes(Request $request, Response $response, array $args): Response
    {
        try {
            @set_time_limit(1800);
            ignore_user_abort(true);
            $resultados = (new EjecutorTareas())->ejecutarPendientes();

            return $this->json($response, [
                'success' => true,
                'tareas_ejecutadas' => count($resultados),
                'resultados' => $resultados,
            ]);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@ejecutarTareasPendientes: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al ejecutar las tareas'], 500);
        }
    }

    /**
     * Valida los datos del formulario.
     *
     * @return array{sede_id:int, sede_nombre:string, carreras:array, tipo_reporte:string, frecuencia:string,
     *               fecha_programada:string, fecha_fin:?string, nombre_manual:?string}
     */
    private function validar(array $data, bool $permitirVarias, ?int $carreraActual = null): array
    {
        $sedeId = (int) ($data['sede_id'] ?? 0);
        if ($sedeId <= 0) {
            throw new \InvalidArgumentException('Seleccione una sede');
        }

        $carreraIds = $data['carrera_ids'] ?? ($data['carrera_id'] ?? []);
        $carreraIds = array_values(array_unique(array_filter(array_map('intval', (array) $carreraIds), static fn ($v) => $v > 0)));
        if (!$carreraIds) {
            throw new \InvalidArgumentException('Seleccione al menos una carrera');
        }
        if (!$permitirVarias && count($carreraIds) > 1) {
            throw new \InvalidArgumentException('Al editar solo se puede indicar una carrera');
        }
        if (count($carreraIds) > 200) {
            throw new \InvalidArgumentException('Puede programar como máximo 200 carreras a la vez');
        }

        $filas = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->whereIn('id_carrera', $carreraIds)
            ->select('id_carrera', 'carrera', 'sede')
            ->distinct()
            ->get();
        $porId = [];
        $sedeNombre = '';
        foreach ($filas as $fila) {
            $porId[(int) $fila->id_carrera] = $fila->carrera;
            $sedeNombre = $fila->sede;
        }
        $activas = array_map('intval', DB::table('carreras')->whereIn('id', $carreraIds)->where('estado', 1)->pluck('id')->all());
        $carreras = [];
        foreach ($carreraIds as $cid) {
            if (!isset($porId[$cid])) {
                throw new \InvalidArgumentException('Una de las carreras seleccionadas no pertenece a la sede indicada');
            }
            // Una tarea existente puede conservar su carrera aunque ya no esté activa
            if (!in_array($cid, $activas, true) && $cid !== $carreraActual) {
                throw new \InvalidArgumentException('La carrera "' . $porId[$cid] . '" no está activa');
            }
            $carreras[] = ['id' => $cid, 'nombre' => $porId[$cid]];
        }

        $tipos = array_values(array_intersect(['basica', 'complementaria'], (array) ($data['tipos'] ?? [])));
        if (!$tipos) {
            throw new \InvalidArgumentException('Seleccione al menos un tipo de reporte');
        }
        $tipoReporte = count($tipos) === 2 ? 'cobertura_ambas_expandido' : 'cobertura_' . $tipos[0] . '_expandido';

        $frecuencia = (string) ($data['frecuencia'] ?? 'unica');
        if (!array_key_exists($frecuencia, EjecutorTareas::FRECUENCIAS)) {
            throw new \InvalidArgumentException('Frecuencia no válida');
        }

        $zona = new \DateTimeZone(EjecutorTareas::ZONA_HORARIA);
        $fecha = \DateTime::createFromFormat('Y-m-d\TH:i', (string) ($data['fecha_programada'] ?? ''), $zona);
        if (!$fecha) {
            throw new \InvalidArgumentException('Indique una fecha y hora válidas');
        }
        if ($fecha <= new \DateTime('now', $zona)) {
            throw new \InvalidArgumentException('La fecha y hora deben ser posteriores al momento actual');
        }

        $fechaFin = null;
        if ($frecuencia !== 'unica' && !empty($data['fecha_fin'])) {
            $fin = \DateTime::createFromFormat('!Y-m-d', (string) $data['fecha_fin'], $zona);
            if (!$fin) {
                throw new \InvalidArgumentException('La fecha "Repetir hasta" no es válida');
            }
            $fin->setTime(23, 59, 59);
            if ($fin < $fecha) {
                throw new \InvalidArgumentException('"Repetir hasta" debe ser igual o posterior a la primera ejecución');
            }
            $fechaFin = $fin->format('Y-m-d H:i:s');
        }

        // Nombre: si se programan varias carreras, o viene vacío, se genera uno por carrera
        $nombre = trim((string) ($data['nombre'] ?? ''));
        $nombreManual = null;
        if ($nombre !== '' && count($carreras) === 1) {
            if (mb_strlen($nombre) > 255) {
                throw new \InvalidArgumentException('El nombre no puede superar los 255 caracteres');
            }
            $nombreManual = $nombre;
        }

        return [
            'sede_id' => $sedeId,
            'sede_nombre' => $sedeNombre,
            'carreras' => $carreras,
            'tipo_reporte' => $tipoReporte,
            'frecuencia' => $frecuencia,
            'fecha_programada' => $fecha->format('Y-m-d H:i:00'),
            'fecha_fin' => $fechaFin,
            'nombre_manual' => $nombreManual,
        ];
    }

    private function leerJson(Request $request): array
    {
        $data = json_decode((string) $request->getBody(), true);

        return is_array($data) ? $data : [];
    }

    private function json(Response $response, array $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
