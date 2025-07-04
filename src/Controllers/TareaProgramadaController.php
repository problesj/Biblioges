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
        // Obtener sedes y carreras para el formulario
        $sedes = DB::table('sedes')->get();
        $carreras = DB::table('carreras')->get();
        
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
            
            error_log('Fecha recibida del frontend: ' . $data['fecha_programada']);

            // Convertir la fecha a la zona horaria local de Chile
            $fecha = new \DateTime($data['fecha_programada'], new \DateTimeZone('America/Santiago'));
            $fecha_db = $fecha->format('Y-m-d H:i:s');
            error_log('Fecha que se guardará en la base de datos: ' . $fecha_db);

            $tarea = [
                'nombre' => $data['nombre'],
                'tipo_reporte' => $data['tipo_reporte'],
                'sede_id' => $data['sede_id'],
                'carrera_id' => $data['carrera_id'],
                'fecha_programada' => $fecha_db,
                'filtros_formacion' => json_encode($data['filtros_formacion'] ?? [])
            ];

            $id = DB::table('tareas_programadas')->insertGetId($tarea);
            
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tarea programada creada correctamente',
                'id' => $id
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
        // Crear request y response mock para el reporte
        $request = new \Slim\Psr7\ServerRequest('GET', '/');
        $response = new \Slim\Psr7\Response();
        
        $reporteController = new \App\Controllers\ReporteController();
        
        // Ejecutar el reporte
        $result = $reporteController->reporteBibliografiaBasicaExpandido(
            $request, 
            $response, 
            ['sede_id' => $tarea->sede_id, 'carrera_id' => $tarea->carrera_id]
        );
        
        return [
            'tipo' => 'cobertura_basica_expandido',
            'sede_id' => $tarea->sede_id,
            'carrera_id' => $tarea->carrera_id,
            'fecha_ejecucion' => now()
        ];
    }

    /**
     * Ejecutar reporte complementario expandido
     */
    private function ejecutarReporteComplementarioExpandido($tarea)
    {
        // Crear request y response mock para el reporte
        $request = new \Slim\Psr7\ServerRequest('GET', '/');
        $response = new \Slim\Psr7\Response();
        
        $reporteController = new \App\Controllers\ReporteController();
        
        // Ejecutar el reporte
        $result = $reporteController->reporteBibliografiaComplementariaExpandido(
            $request, 
            $response, 
            ['sede_id' => $tarea->sede_id, 'carrera_id' => $tarea->carrera_id]
        );
        
        return [
            'tipo' => 'cobertura_complementaria_expandido',
            'sede_id' => $tarea->sede_id,
            'carrera_id' => $tarea->carrera_id,
            'fecha_ejecucion' => now()
        ];
    }
} 