<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use src\Controllers\BaseController;

class TareaProgramadaController extends BaseController
{
    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
    }

    /**
     * Mostrar la vista de programación de tareas
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        // Obtener sedes y carreras para el formulario usando la vista vw_mallas
        $sedes = DB::table('vw_mallas')
            ->select('id_sede as id', 'sede')
            ->distinct()
            ->orderBy('sede')
            ->get();
        // Obtener carreras con su sede asociada para el filtrado dinámico
        $carreras = DB::table('vw_mallas')
            ->select('id_carrera as id', 'carrera', 'codigo_carrera', 'id_sede')
            ->distinct()
            ->orderBy('carrera')
            ->get();
        
        // Obtener tareas programadas existentes
        $tareas = DB::table('tareas_programadas')
            ->join('sedes', 'tareas_programadas.sede_id', '=', 'sedes.id')
            ->join('carreras', 'tareas_programadas.carrera_id', '=', 'carreras.id')
            ->select(
                'tareas_programadas.*',
                'sedes.nombre as sede_nombre',
                'carreras.nombre as carrera_nombre'
            )
            ->orderBy('fecha_programada', 'desc')
            ->get();

        $view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates'));
        $template = $view->load('tareas_programadas/index.twig');
        
        $response->getBody()->write($template->render([
            'sedes' => $sedes,
            'carreras' => $carreras,
            'tareas' => $tareas,
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'current_page' => 'tareas_programadas'
        ]));
        
        return $response->withHeader('Content-Type', 'text/html');
    }

    /**
     * Crear una nueva tarea programada
     */
    public function crear(Request $request, Response $response, array $args): Response
    {
        try {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            // No se esperan filtros de formación

            error_log('Fecha recibida del frontend: ' . $data['fecha_programada']);

            // Convertir la fecha a la zona horaria local de Chile
            $fecha = new \DateTime($data['fecha_programada'], new \DateTimeZone('America/Santiago'));
            $fecha_db = $fecha->format('Y-m-d H:i:s');
            error_log('Fecha que se guardará en la base de datos: ' . $fecha_db);

            $ids = [];
            $carreras = is_array($data['carrera_id']) ? $data['carrera_id'] : [$data['carrera_id']];
            foreach ($carreras as $carreraId) {
                $tarea = [
                    'nombre' => $data['nombre'],
                    'tipo_reporte' => $data['tipo_reporte'],
                    'sede_id' => $data['sede_id'],
                    'carrera_id' => $carreraId,
                    'fecha_programada' => $fecha_db,
                    'filtros_formacion' => json_encode([])
                ];
                $ids[] = DB::table('tareas_programadas')->insertGetId($tarea);
            }
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tarea(s) programada(s) creada(s) correctamente',
                'ids' => $ids
            ]));
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Throwable $e) {
            error_log('Error en crear tarea programada: ' . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error al crear la tarea programada: ' . $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtener tareas programadas
     */
    public function listar(Request $request, Response $response, array $args): Response
    {
        try {
            $tareas = DB::table('tareas_programadas')
                ->join('sedes', 'tareas_programadas.sede_id', '=', 'sedes.id')
                ->join('carreras', 'tareas_programadas.carrera_id', '=', 'carreras.id')
                ->select(
                    'tareas_programadas.*',
                    'sedes.nombre as sede_nombre',
                    'carreras.nombre as carrera_nombre'
                )
                ->orderBy('fecha_programada', 'desc')
                ->get();

            $response->getBody()->write(json_encode([
                'success' => true,
                'tareas' => $tareas
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Throwable $e) {
            error_log('Error en listar tareas programadas: ' . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error al listar las tareas programadas: ' . $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Cancelar una tarea programada
     */
    public function cancelar(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'];
            
            $tarea = DB::table('tareas_programadas')->find($id);
            if (!$tarea) {
                $response->getBody()->write(json_encode(['error' => 'Tarea no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            if ($tarea->estado !== 'pendiente') {
                $response->getBody()->write(json_encode(['error' => 'Solo se pueden cancelar tareas pendientes']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            DB::table('tareas_programadas')
                ->where('id', $id)
                ->update(['estado' => 'cancelada']);

            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tarea cancelada correctamente'
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Throwable $e) {
            error_log('Error en cancelar tarea programada: ' . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error al cancelar la tarea: ' . $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Ejecutar tareas pendientes (para cron)
     */
    public function ejecutarTareasPendientes(Request $request, Response $response, array $args): Response
    {
        try {
            $tareasPendientes = DB::table('tareas_programadas')
                ->where('estado', 'pendiente')
                ->where('fecha_programada', '<=', now())
                ->get();

            $resultados = [];
            
            foreach ($tareasPendientes as $tarea) {
                try {
                    // Marcar como en proceso
                    DB::table('tareas_programadas')
                        ->where('id', $tarea->id)
                        ->update([
                            'estado' => 'en_proceso',
                            'fecha_ejecucion' => now()
                        ]);

                    // Ejecutar el reporte correspondiente
                    $reporteController = new \App\Controllers\ReporteController();
                    
                    if ($tarea->tipo_reporte === 'cobertura_basica_expandido') {
                        $resultado = $this->ejecutarReporteBasicoExpandido($tarea);
                    } elseif ($tarea->tipo_reporte === 'cobertura_complementaria_expandido') {
                        $resultado = $this->ejecutarReporteComplementarioExpandido($tarea);
                    } else {
                        throw new \Exception('Tipo de reporte no válido');
                    }

                    // Marcar como completada
                    DB::table('tareas_programadas')
                        ->where('id', $tarea->id)
                        ->update([
                            'estado' => 'completada',
                            'resultado' => json_encode($resultado)
                        ]);

                    $resultados[] = [
                        'id' => $tarea->id,
                        'estado' => 'completada',
                        'resultado' => $resultado
                    ];

                } catch (\Throwable $e) {
                    // Marcar como error
                    DB::table('tareas_programadas')
                        ->where('id', $tarea->id)
                        ->update([
                            'estado' => 'error',
                            'error_mensaje' => $e->getMessage()
                        ]);

                    $resultados[] = [
                        'id' => $tarea->id,
                        'estado' => 'error',
                        'error' => $e->getMessage()
                    ];
                }
            }

            $response->getBody()->write(json_encode([
                'success' => true,
                'tareas_ejecutadas' => count($tareasPendientes),
                'resultados' => $resultados
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Throwable $e) {
            error_log('Error en ejecutar tareas pendientes: ' . $e->getMessage());
            $response->getBody()->write(json_encode([
                'error' => 'Error al ejecutar las tareas: ' . $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Ejecutar reporte básico expandido
     */
    private function ejecutarReporteBasicoExpandido($tarea)
    {
        try {
            // Crear request y response mock para el reporte
            $request = new \Slim\Psr7\ServerRequest('GET', '/');
            $response = new \Slim\Psr7\Response();
            
            $reporteController = new \App\Controllers\ReporteController();
            
            // Ejecutar el reporte para obtener los datos
            $result = $reporteController->reporteBibliografiaBasicaExpandido(
                $request, 
                $response, 
                ['sede_id' => $tarea->sede_id, 'carrera_id' => $tarea->carrera_id]
            );
            
            // Obtener los detalles de cobertura básica
            $detalles = $this->obtenerDetallesCoberturaBasica($tarea->sede_id, $tarea->carrera_id);
            
            error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: Detalles obtenidos: ' . count($detalles));
            
            // Guardar la cobertura básica directamente en la base de datos
            if (!empty($detalles)) {
                try {
                    // Obtener código de carrera
                    $carrera = DB::table('vw_mallas')
                        ->where('id_sede', $tarea->sede_id)
                        ->where('id_carrera', $tarea->carrera_id)
                        ->select('codigo_carrera as codigo')
                        ->first();
                    
                    if (!$carrera) {
                        error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: No se encontró la carrera');
                        throw new \Exception('Carrera no encontrada');
                    }
                    
                    $codigoCarrera = $carrera->codigo;
                    
                    // Obtener ID del reporte
                    $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Básicas')->first();
                    if (!$reporte) {
                        error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: No existe el reporte de coberturas básicas');
                        throw new \Exception('No existe el reporte de coberturas básicas');
                    }
                    
                    $idReporte = $reporte->id;
                    $fechaMedicion = date('Y-m-d H:i:s');
                    
                    // Borrar registros existentes del año en curso para la carrera
                    $borrados = DB::table('reporte_coberturas_carreras_basicas')
                        ->where('id_reporte', $idReporte)
                        ->where('codigo_carrera', $codigoCarrera)
                        ->whereYear('fecha_medicion', date('Y'))
                        ->delete();
                    
                    error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: Registros borrados: ' . $borrados);
                    
                    // Insertar los nuevos detalles
                    $insertados = 0;
                    foreach ($detalles as $detalle) {
                        DB::table('reporte_coberturas_carreras_basicas')->insert([
                            'id_reporte' => $idReporte,
                            'codigo_carrera' => $codigoCarrera,
                            'codigo_asignatura' => $detalle['codigo_asignatura'],
                            'id_bibliografia_declarada' => $detalle['id_bibliografia_declarada'],
                            'fecha_medicion' => $fechaMedicion,
                            'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                            'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
                            'no_bib_disponible_basica' => $detalle['disponible'] ?? 0
                        ]);
                        $insertados++;
                    }
                    
                    error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: Registros insertados: ' . $insertados);
                    
                } catch (\Throwable $e) {
                    error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: Error al guardar: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                error_log('TareaProgramadaController@ejecutarReporteBasicoExpandido: No hay detalles para guardar');
            }
            
            return [
                'tipo' => 'cobertura_basica_expandido',
                'sede_id' => $tarea->sede_id,
                'carrera_id' => $tarea->carrera_id,
                'fecha_ejecucion' => now(),
                'detalles_guardados' => count($detalles)
            ];
        } catch (\Throwable $e) {
            error_log('Error en ejecutarReporteBasicoExpandido: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Ejecutar reporte complementario expandido
     */
    private function ejecutarReporteComplementarioExpandido($tarea)
    {
        try {
            // Crear request y response mock para el reporte
            $request = new \Slim\Psr7\ServerRequest('GET', '/');
            $response = new \Slim\Psr7\Response();
            
            $reporteController = new \App\Controllers\ReporteController();
            
            // Ejecutar el reporte para obtener los datos
            $result = $reporteController->reporteBibliografiaComplementariaExpandido(
                $request, 
                $response, 
                ['sede_id' => $tarea->sede_id, 'carrera_id' => $tarea->carrera_id]
            );
            
            // Obtener los detalles de cobertura complementaria
            $detalles = $this->obtenerDetallesCoberturaComplementaria($tarea->sede_id, $tarea->carrera_id);
            
            error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: Detalles obtenidos: ' . count($detalles));
            
            // Guardar la cobertura complementaria directamente en la base de datos
            if (!empty($detalles)) {
                try {
                    // Obtener código de carrera
                    $carrera = DB::table('vw_mallas')
                        ->where('id_sede', $tarea->sede_id)
                        ->where('id_carrera', $tarea->carrera_id)
                        ->select('codigo_carrera as codigo')
                        ->first();
                    
                    if (!$carrera) {
                        error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: No se encontró la carrera');
                        throw new \Exception('Carrera no encontrada');
                    }
                    
                    $codigoCarrera = $carrera->codigo;
                    
                    // Obtener ID del reporte
                    $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Complementarias')->first();
                    if (!$reporte) {
                        error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: No existe el reporte de coberturas complementarias');
                        throw new \Exception('No existe el reporte de coberturas complementarias');
                    }
                    
                    $idReporte = $reporte->id;
                    $fechaMedicion = date('Y-m-d H:i:s');
                    
                    // Borrar registros existentes del año en curso para la carrera
                    $borrados = DB::table('reporte_coberturas_carreras_complementarias')
                        ->where('id_reporte', $idReporte)
                        ->where('codigo_carrera', $codigoCarrera)
                        ->whereYear('fecha_medicion', date('Y'))
                        ->delete();
                    
                    error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: Registros borrados: ' . $borrados);
                    
                    // Insertar los nuevos detalles
                    $insertados = 0;
                    foreach ($detalles as $detalle) {
                        DB::table('reporte_coberturas_carreras_complementarias')->insert([
                            'id_reporte' => $idReporte,
                            'codigo_carrera' => $codigoCarrera,
                            'codigo_asignatura' => $detalle['codigo_asignatura'],
                            'id_bibliografia_declarada' => ($detalle['id_bibliografia_declarada'] === '' || is_null($detalle['id_bibliografia_declarada'])) ? null : $detalle['id_bibliografia_declarada'],
                            'fecha_medicion' => $fechaMedicion,
                            'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                            'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
                            'no_bib_disponible_complementaria' => $detalle['disponible'] ?? 0
                        ]);
                        $insertados++;
                    }
                    
                    error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: Registros insertados: ' . $insertados);
                    
                } catch (\Throwable $e) {
                    error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: Error al guardar: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                error_log('TareaProgramadaController@ejecutarReporteComplementarioExpandido: No hay detalles para guardar');
            }
            
            return [
                'tipo' => 'cobertura_complementaria_expandido',
                'sede_id' => $tarea->sede_id,
                'carrera_id' => $tarea->carrera_id,
                'fecha_ejecucion' => now(),
                'detalles_guardados' => count($detalles)
            ];
        } catch (\Throwable $e) {
            error_log('Error en ejecutarReporteComplementarioExpandido: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener detalles de cobertura básica para guardado
     */
    private function obtenerDetallesCoberturaBasica($sedeId, $carreraId)
    {
        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Iniciando para sede: ' . $sedeId . ', carrera: ' . $carreraId);
        
        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Asignaturas regulares encontradas: ' . count($regulares));

        // Obtener filtros guardados para la carrera
        $carreraTemp = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select('codigo_carrera as codigo')
            ->first();
            
        $tiposFormacionFiltro = [];
        if ($carreraTemp) {
            $filtrosGuardados = DB::table('filtros_formaciones')
                ->where('codigo_carrera', $carreraTemp->codigo)
                ->first();
                
            if ($filtrosGuardados) {
                if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
            }
        }

        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Filtros de formación: ' . print_r($tiposFormacionFiltro, true));

        // Obtener asignaturas de formación según filtros guardados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                ->distinct()
                ->get();
        }

        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Asignaturas de formación encontradas: ' . count($formaciones));

        // Unir ambos conjuntos
        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Total asignaturas a procesar: ' . count($asignaturas));

        // Generar detalles de cobertura básica
        $detalles = [];
        foreach ($asignaturas as $asignatura) {
            error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Procesando asignatura: ' . $asignatura->codigo);
            
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            
            if ($asignaturaId) {
                $bibliografias = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'basica')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select('bibliografias_declaradas.id')
                    ->get();
                
                error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Bibliografías básicas encontradas para ' . $asignatura->codigo . ': ' . count($bibliografias));
                
                foreach ($bibliografias as $bibliografia) {
                    // Ejemplares impresos
                    $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                        ->where('id_bib_declarada', $bibliografia->id)
                        ->where('id_sede', $sedeId)
                        ->value('no_ejem_imp_sede') ?? 0;
                        
                    // Ejemplares digitales
                    $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');
                    $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                    
                    // Disponibilidad
                    $disponible = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('estado', 1)
                        ->where(function ($query) use ($sedeId) {
                            $query->whereIn('disponibilidad', ['electronico', 'ambos'])
                                  ->orWhere(function ($q) use ($sedeId) {
                                      $q->where('disponibilidad', 'impreso')
                                        ->whereExists(function ($sub) use ($sedeId) {
                                            $sub->select(DB::raw(1))
                                                ->from('bibliografias_disponibles_sedes')
                                                ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                                ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                                ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                        });
                                  });
                        })
                        ->exists();
                    
                    $detalles[] = [
                        'codigo_asignatura' => $asignatura->codigo,
                        'id_bibliografia_declarada' => $bibliografia->id,
                        'ejemplares_impresos' => $ejemplaresImpresos,
                        'ejemplares_digitales' => $ejemplaresDigitales,
                        'disponible' => $disponible ? 1 : 0
                    ];
                }
            } else {
                error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: No se encontró asignatura_id para: ' . $asignatura->codigo);
            }
        }
        
        error_log('TareaProgramadaController@obtenerDetallesCoberturaBasica: Total detalles generados: ' . count($detalles));
        
        return $detalles;
    }

    /**
     * Obtener detalles de cobertura complementaria para guardado
     */
    private function obtenerDetallesCoberturaComplementaria($sedeId, $carreraId)
    {
        // Obtener asignaturas REGULARES (siempre incluidas)
        $regulares = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->where('tipo_asignatura', 'REGULAR')
            ->select('codigo_asignatura as codigo', 'asignatura as nombre', 'tipo_asignatura')
            ->distinct()
            ->get();

        // Obtener filtros guardados para la carrera
        $carreraTemp = DB::table('vw_mallas')
            ->where('id_sede', $sedeId)
            ->where('id_carrera', $carreraId)
            ->select('codigo_carrera as codigo')
            ->first();
            
        $tiposFormacionFiltro = [];
        if ($carreraTemp) {
            $filtrosGuardados = DB::table('filtros_formaciones')
                ->where('codigo_carrera', $carreraTemp->codigo)
                ->first();
                
            if ($filtrosGuardados) {
                if ($filtrosGuardados->basica) $tiposFormacionFiltro[] = 'FORMACION_BASICA';
                if ($filtrosGuardados->general) $tiposFormacionFiltro[] = 'FORMACION_GENERAL';
                if ($filtrosGuardados->idioma) $tiposFormacionFiltro[] = 'FORMACION_IDIOMAS';
                if ($filtrosGuardados->profesional) $tiposFormacionFiltro[] = 'FORMACION_PROFESIONAL';
                if ($filtrosGuardados->valores) $tiposFormacionFiltro[] = 'FORMACION_VALORES';
                if ($filtrosGuardados->especialidad) $tiposFormacionFiltro[] = 'FORMACION_ESPECIALIDAD';
                if ($filtrosGuardados->especial) $tiposFormacionFiltro[] = 'FORMACION_ESPECIAL';
            }
        }

        // Obtener asignaturas de formación según filtros guardados
        $formaciones = collect();
        if (!empty($tiposFormacionFiltro)) {
            $formaciones = DB::table('vw_mallas')
                ->where('id_sede', $sedeId)
                ->where('id_carrera', $carreraId)
                ->whereIn('tipo_asignatura', $tiposFormacionFiltro)
                ->whereNotNull('codigo_asignatura_formacion')
                ->select(
                    'codigo_asignatura_formacion as codigo', 
                    'asignatura_formacion as nombre', 
                    'tipo_asignatura'
                )
                ->distinct()
                ->get();
        }

        // Unir ambos conjuntos
        $asignaturas = $regulares->merge($formaciones)->unique('codigo')->values();

        // Generar detalles de cobertura complementaria
        $detalles = [];
        foreach ($asignaturas as $asignatura) {
            $asignaturaId = DB::table('asignaturas_departamentos')
                ->where('codigo_asignatura', $asignatura->codigo)
                ->value('asignatura_id');
            
            if ($asignaturaId) {
                $bibliografias = DB::table('asignaturas_bibliografias')
                    ->join('bibliografias_declaradas', 'asignaturas_bibliografias.bibliografia_id', '=', 'bibliografias_declaradas.id')
                    ->where('asignaturas_bibliografias.asignatura_id', $asignaturaId)
                    ->where('asignaturas_bibliografias.tipo_bibliografia', 'complementaria')
                    ->where('asignaturas_bibliografias.estado', 'activa')
                    ->select('bibliografias_declaradas.id')
                    ->get();
                
                foreach ($bibliografias as $bibliografia) {
                    // Ejemplares impresos
                    $ejemplaresImpresos = DB::table('vw_bib_declarada_sede_noejem')
                        ->where('id_bib_declarada', $bibliografia->id)
                        ->where('id_sede', $sedeId)
                        ->value('no_ejem_imp_sede') ?? 0;
                        
                    // Ejemplares digitales
                    $ejemplaresDigitales = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('disponibilidad', '!=', 'impreso')
                        ->pluck('ejemplares_digitales');
                    $ejemplaresDigitales = $ejemplaresDigitales->contains(0) ? 0 : $ejemplaresDigitales->sum();
                    
                    // Disponibilidad
                    $disponible = DB::table('bibliografias_disponibles')
                        ->where('bibliografia_declarada_id', $bibliografia->id)
                        ->where('estado', 1)
                        ->where(function ($query) use ($sedeId) {
                            $query->whereIn('disponibilidad', ['electronico', 'ambos'])
                                  ->orWhere(function ($q) use ($sedeId) {
                                      $q->where('disponibilidad', 'impreso')
                                        ->whereExists(function ($sub) use ($sedeId) {
                                            $sub->select(DB::raw(1))
                                                ->from('bibliografias_disponibles_sedes')
                                                ->whereRaw('bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id')
                                                ->where('bibliografias_disponibles_sedes.sede_id', $sedeId)
                                                ->where('bibliografias_disponibles_sedes.ejemplares', '>', 0);
                                        });
                                  });
                        })
                        ->exists();
                    
                    $detalles[] = [
                        'codigo_asignatura' => $asignatura->codigo,
                        'id_bibliografia_declarada' => $bibliografia->id,
                        'ejemplares_impresos' => $ejemplaresImpresos,
                        'ejemplares_digitales' => $ejemplaresDigitales,
                        'disponible' => $disponible ? 1 : 0
                    ];
                }
            }
        }
        
        return $detalles;
    }
} 