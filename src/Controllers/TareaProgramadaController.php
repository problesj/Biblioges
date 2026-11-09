<?php

namespace App\Controllers;

use App\Services\ActualizadorCopiasAlma;
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
        ActualizadorCopiasAlma::TIPO => 'Copias desde Alma',
    ];

    private const ACCIONES_ALMA = [
        'actualizada' => 'Actualizada',
        'mms_corregido' => 'MMS corregido',
        'a_electronico' => 'Pasa a electrónico',
        'eliminada' => 'Eliminada',
        'duplicada' => 'MMS repetido',
        'revisar' => 'Revisar',
        'discrepancia' => 'Discrepancia',
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
                'dias_semana' => EjecutorTareas::DIAS_SEMANA,
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
            $entrada = $this->leerJson($request);
            if (($entrada['tipo_tarea'] ?? '') === 'copias_alma') {
                return $this->guardarTareaAlma($response, $entrada, null);
            }
            [$entrada, $dias] = $this->prepararSemanal($entrada);
            $datos = $this->validar($entrada, true);
            $datos['dias_semana'] = $dias;

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
                        'dias_semana' => $datos['dias_semana'] ?? null,
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
        $esAlma = $tarea->tipo_reporte === ActualizadorCopiasAlma::TIPO;
        $carrera = $esAlma ? null : DB::table('carreras')->where('id', $tarea->carrera_id)->first(['nombre', 'estado']);
        $plan = $esAlma ? null : EjecutorTareas::planVigente((int) $tarea->carrera_id, (int) $tarea->sede_id);

        return $this->json($response, ['success' => true, 'tarea' => [
            'id' => (int) $tarea->id,
            'nombre' => $tarea->nombre,
            'tipo_tarea' => $esAlma ? 'copias_alma' : 'coberturas',
            'simulacion' => (int) ($tarea->simulacion ?? 0) === 1,
            'sede_id' => (int) $tarea->sede_id,
            'carrera_id' => (int) $tarea->carrera_id,
            'carrera_nombre' => $carrera->nombre ?? '',
            'carrera_codigo' => $plan->codigo_carrera ?? '',
            'carrera_activa' => (int) ($carrera->estado ?? 0) === 1,
            'tipos' => $tipos,
            'frecuencia' => $tarea->frecuencia ?? 'unica',
            'fecha_programada' => date('Y-m-d\TH:i', strtotime($tarea->fecha_programada)),
            'dias_semana' => EjecutorTareas::diasSemana($tarea->dias_semana ?? null),
            'hora' => date('H:i', strtotime($tarea->fecha_inicio ?: $tarea->fecha_programada)),
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

            if ($tarea->tipo_reporte === ActualizadorCopiasAlma::TIPO) {
                return $this->guardarTareaAlma($response, $this->leerJson($request), $id);
            }
            [$entrada, $dias] = $this->prepararSemanal($this->leerJson($request));
            $datos = $this->validar($entrada, false, (int) $tarea->carrera_id);
            $datos['dias_semana'] = $dias;
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
                    'dias_semana' => $datos['dias_semana'] ?? null,
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
                ->get(['id', 'tipo_reporte', 'manual', 'simulacion', 'fecha_inicio', 'fecha_fin', 'estado', 'registros', 'resumen', 'mensaje']);

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
            if (DB::table('tareas_programadas')->where('id', $id)->value('tipo_reporte') === ActualizadorCopiasAlma::TIPO) {
                if (ActualizadorCopiasAlma::hayEnProceso()) {
                    return $this->json($response, ['success' => false, 'message' => 'Ya hay una actualización de copias en curso'], 409);
                }
                if (!ActualizadorCopiasAlma::lanzarEnSegundoPlano($id, true)) {
                    return $this->json($response, ['success' => false, 'message' => 'No se pudo iniciar el proceso en segundo plano'], 500);
                }

                return $this->json($response, ['success' => true, 'message' => 'Se inició en segundo plano. Puede tardar más de una hora; el avance se ve en el listado y el resultado en el historial.']);
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

    /**
     * Crea o edita la tarea de actualización de copias desde Alma (mensual o anual).
     */
    private function guardarTareaAlma(Response $response, array $data, ?int $id): Response
    {
        try {
            [$data, $dias] = $this->prepararSemanal($data);
            $frecuencia = (string) ($data['frecuencia'] ?? '');
            if (!in_array($frecuencia, ['semanal', 'mensual', 'anual'], true)) {
                throw new \InvalidArgumentException('Esta tarea solo se puede programar de forma semanal, mensual o anual');
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
            if (!empty($data['fecha_fin'])) {
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
            $simulacion = !empty($data['simulacion']);
            $nombre = trim((string) ($data['nombre'] ?? ''));
            if ($nombre === '') {
                $nombre = 'Copias desde Alma - ' . EjecutorTareas::FRECUENCIAS[$frecuencia] . ($simulacion ? ' (simulación)' : '');
            }
            if (mb_strlen($nombre) > 255) {
                throw new \InvalidArgumentException('El nombre no puede superar los 255 caracteres');
            }
            $valores = [
                'nombre' => $nombre,
                'tipo_reporte' => ActualizadorCopiasAlma::TIPO,
                'sede_id' => null,
                'carrera_id' => null,
                'fecha_programada' => $fecha->format('Y-m-d H:i:00'),
                'frecuencia' => $frecuencia,
                'dias_semana' => $dias,
                'simulacion' => $simulacion ? 1 : 0,
                'fecha_inicio' => $fecha->format('Y-m-d H:i:00'),
                'fecha_fin' => $fechaFin,
                'estado' => 'pendiente',
                'error_mensaje' => null,
            ];
            if ($id === null) {
                $valores['filtros_formacion'] = json_encode([]);
                $valores['creado_por'] = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
                DB::table('tareas_programadas')->insert($valores);

                return $this->json($response, ['success' => true, 'message' => 'Tarea programada creada correctamente']);
            }
            if (DB::table('tareas_programadas')->where('id', $id)->where('estado', '!=', 'en_proceso')->update($valores) !== 1) {
                return $this->json($response, ['success' => false, 'message' => 'La tarea se está ejecutando; intente más tarde'], 409);
            }

            return $this->json($response, ['success' => true, 'message' => 'Tarea actualizada y programada correctamente']);
        } catch (\InvalidArgumentException $e) {
            return $this->json($response, ['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            error_log('TareaProgramadaController@guardarTareaAlma: ' . $e->getMessage());

            return $this->json($response, ['success' => false, 'message' => 'Error al guardar la tarea'], 500);
        }
    }

    /**
     * Reporte de una ejecución de copias desde Alma.
     */
    public function detalleAlma(Request $request, Response $response, array $args): Response
    {
        $ejecucion = DB::table('tareas_programadas_ejecuciones')->where('id', (int) $args['id'])->where('tipo_reporte', 'copias_alma')->first();
        if (!$ejecucion) {
            return $this->errorResponse($response, 'Ejecución no encontrada', 404);
        }
        $q = $request->getQueryParams();
        $accion = array_key_exists($q['accion'] ?? '', self::ACCIONES_ALMA) ? $q['accion'] : '';
        $porPagina = 50;
        $conteos = DB::table('tareas_alma_detalle')->where('ejecucion_id', $ejecucion->id)->selectRaw('accion, COUNT(*) AS n')->groupBy('accion')->pluck('n', 'accion')->all();
        $total = $accion === '' ? array_sum($conteos) : (int) ($conteos[$accion] ?? 0);
        $totalPaginas = (int) ceil($total / $porPagina);
        $pagina = max(1, min(max(1, $totalPaginas), (int) ($q['pagina'] ?? 1)));

        $consulta = DB::table('tareas_alma_detalle')->where('ejecucion_id', $ejecucion->id);
        if ($accion !== '') {
            $consulta->where('accion', $accion);
        }
        $sedes = DB::table('sedes')->pluck('nombre', 'id')->all();
        $detalle = $consulta->orderByRaw("FIELD(accion, 'eliminada', 'discrepancia', 'revisar', 'a_electronico', 'mms_corregido', 'duplicada', 'actualizada')")->orderBy('id')
            ->offset(($pagina - 1) * $porPagina)->limit($porPagina)
            ->get(['accion', 'bibliografia_disponible_id', 'bibliografia_declarada_id', 'titulo', 'anio_edicion', 'id_mms', 'id_mms_nuevo', 'copias_antes', 'copias_despues', 'declarada_sin_disponibles', 'mensaje']);
        $existentes = $this->disponiblesExistentes($detalle);
        foreach ($detalle as $d) {
            $d->existe = isset($existentes[(int) $d->bibliografia_disponible_id]);
            $d->antes_texto = $this->textoCopias($d->copias_antes, $sedes);
            $d->despues_texto = $this->textoCopias($d->copias_despues, $sedes);
        }

        return $this->render($response, 'tareas_programadas/detalle_alma.twig', [
            'ejecucion' => $ejecucion,
            'tarea' => DB::table('tareas_programadas')->where('id', $ejecucion->tarea_id)->first(),
            'resumen' => json_decode((string) $ejecucion->resumen, true) ?: [],
            'detalle' => $detalle,
            'acciones' => self::ACCIONES_ALMA,
            'colores' => ['actualizada' => 'bg-success', 'mms_corregido' => 'bg-info text-dark', 'a_electronico' => 'bg-primary', 'eliminada' => 'bg-danger', 'duplicada' => 'bg-secondary', 'revisar' => 'bg-warning text-dark', 'discrepancia' => 'bg-dark'],
            'conteos' => $conteos,
            'total_detalle' => array_sum($conteos),
            'filtro_accion' => $accion,
            'pagina' => $pagina,
            'total_paginas' => $totalPaginas,
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'current_page' => 'tareas_programadas',
        ]);
    }

    public function exportarDetalleAlma(Request $request, Response $response, array $args): Response
    {
        $ejecucion = DB::table('tareas_programadas_ejecuciones')->where('id', (int) $args['id'])->where('tipo_reporte', 'copias_alma')->first();
        if (!$ejecucion) {
            return $this->errorResponse($response, 'Ejecución no encontrada', 404);
        }
        $accion = $request->getQueryParams()['accion'] ?? '';
        $consulta = DB::table('tareas_alma_detalle')->where('ejecucion_id', $ejecucion->id);
        if (array_key_exists($accion, self::ACCIONES_ALMA)) {
            $consulta->where('accion', $accion);
        }
        $sedes = DB::table('sedes')->pluck('nombre', 'id')->all();
        $libro = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setTitle('Cambios');
        $hoja->fromArray(['Acción', 'ID disponible', 'ID declarada', 'Título', 'Año', 'MMS', 'MMS corregido o sugerido', 'Copias antes', 'Copias después', 'Declarada sin disponibles', 'Observación', 'Copia de la fila eliminada'], null, 'A1');
        $hoja->getStyle('A1:L1')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']]]);
        $tipoTexto = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
        $n = 2;
        $filasDetalle = $consulta->orderBy('id')->get();
        $existentes = $this->disponiblesExistentes($filasDetalle);
        foreach ($filasDetalle as $d) {
            $hoja->setCellValue("A{$n}", self::ACCIONES_ALMA[$d->accion] ?? $d->accion);
            $hoja->setCellValue("B{$n}", (int) $d->bibliografia_disponible_id);
            if (isset($existentes[(int) $d->bibliografia_disponible_id])) {
                $hoja->getCell("B{$n}")->getHyperlink()->setUrl(app_url() . 'bibliografias-disponibles/' . (int) $d->bibliografia_disponible_id);
                $hoja->getStyle("B{$n}")->getFont()->setUnderline(true)->getColor()->setRGB('0563C1');
            }
            $hoja->setCellValue("C{$n}", $d->bibliografia_declarada_id);
            $hoja->setCellValueExplicit("D{$n}", (string) $d->titulo, $tipoTexto);
            $hoja->setCellValue("E{$n}", $d->anio_edicion);
            $hoja->setCellValueExplicit("F{$n}", (string) $d->id_mms, $tipoTexto);
            $hoja->setCellValueExplicit("G{$n}", (string) $d->id_mms_nuevo, $tipoTexto);
            $hoja->setCellValueExplicit("H{$n}", $this->textoCopias($d->copias_antes, $sedes), $tipoTexto);
            $hoja->setCellValueExplicit("I{$n}", $this->textoCopias($d->copias_despues, $sedes), $tipoTexto);
            $hoja->setCellValue("J{$n}", $d->declarada_sin_disponibles ? 'Sí' : '');
            $hoja->setCellValueExplicit("K{$n}", (string) $d->mensaje, $tipoTexto);
            $hoja->setCellValueExplicit("L{$n}", (string) $d->copia_fila, $tipoTexto);
            $n++;
        }
        foreach (['A' => 18, 'B' => 12, 'C' => 12, 'D' => 60, 'E' => 8, 'F' => 22, 'G' => 22, 'H' => 30, 'I' => 30, 'J' => 14, 'K' => 50, 'L' => 40] as $col => $ancho) {
            $hoja->getColumnDimension($col)->setWidth($ancho);
        }
        $hoja->setAutoFilter('A1:L' . max(1, $n - 1));
        $hoja->freezePane('A2');
        ob_start();
        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($libro))->save('php://output');
        $response->getBody()->write(ob_get_clean());

        return $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="copias_alma_' . (int) $ejecucion->id . '.xlsx"');
    }

    /** Disponibles del detalle que aún existen, indexadas por id (las eliminadas no tienen vista). */
    private function disponiblesExistentes($detalle): array
    {
        $existentes = [];
        foreach (array_chunk(array_unique(array_map(static fn ($d) => (int) $d->bibliografia_disponible_id, $detalle->all())), 1000) as $lote) {
            foreach (DB::table('bibliografias_disponibles')->whereIn('id', $lote)->pluck('id') as $id) {
                $existentes[(int) $id] = true;
            }
        }

        return $existentes;
    }

    /** "Antofagasta: 3; Coquimbo: 2" a partir del JSON de copias por sede. */
    private function textoCopias($json, array $sedes): string
    {
        if ($json === null) {
            return '—';
        }
        $copias = json_decode((string) $json, true);
        if (!$copias) {
            return 'Sin copias';
        }
        $partes = [];
        foreach ($copias as $sedeId => $n) {
            $partes[] = ($sedes[$sedeId] ?? "Sede {$sedeId}") . ': ' . $n;
        }

        return implode('; ', $partes);
    }

    /**
     * Frecuencia semanal: valida los días y la hora, y calcula la primera ejecución (fecha_programada).
     * Para otras frecuencias no cambia los datos y los días quedan vacíos.
     *
     * @return array{0: array, 1: ?string} datos y días como "1,3,6"
     */
    private function prepararSemanal(array $data): array
    {
        if (($data['frecuencia'] ?? '') !== 'semanal') {
            return [$data, null];
        }
        $dias = EjecutorTareas::diasSemana($data['dias_semana'] ?? []);
        if (!$dias) {
            throw new \InvalidArgumentException('Seleccione al menos un día de la semana');
        }
        $hora = (string) ($data['hora'] ?? '');
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $hora)) {
            throw new \InvalidArgumentException('Indique una hora válida');
        }
        $lista = implode(',', $dias);
        $ahora = EjecutorTareas::ahora();
        $primera = EjecutorTareas::siguienteFecha(substr($ahora, 0, 10) . ' ' . $hora . ':00', $ahora, 'semanal', null, $ahora, $lista);
        $data['fecha_programada'] = str_replace(' ', 'T', substr($primera, 0, 16));

        return [$data, $lista];
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
