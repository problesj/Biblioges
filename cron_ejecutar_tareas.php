<?php
/**
 * Script para ejecutar tareas programadas desde cron
 * Uso: php cron_ejecutar_tareas.php
 */

// Incluir el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno (credenciales de la base de datos) desde .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Inicializar la base de datos
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

use Illuminate\Database\Capsule\Manager as DB;

try {
    // Obtener tareas pendientes
    $tareasPendientes = DB::table('tareas_programadas')
        ->where('estado', 'pendiente')
        ->where('fecha_programada', '<=', date('Y-m-d H:i:s'))
        ->get();

    if ($tareasPendientes->isEmpty()) {
        echo "No hay tareas pendientes para ejecutar.\n";
        exit(0);
    }

    echo "Ejecutando " . count($tareasPendientes) . " tareas pendientes...\n";

    foreach ($tareasPendientes as $tarea) {
        try {
            echo "Procesando tarea ID: " . $tarea->id . " - " . $tarea->nombre . "\n";

            // Marcar como en proceso
            DB::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->update([
                    'estado' => 'en_proceso',
                    'fecha_ejecucion' => date('Y-m-d H:i:s')
                ]);

            // Ejecutar el reporte correspondiente
            if ($tarea->tipo_reporte === 'cobertura_basica_expandido') {
                $resultado = ejecutarReporteBasicoExpandido($tarea);
            } elseif ($tarea->tipo_reporte === 'cobertura_complementaria_expandido') {
                $resultado = ejecutarReporteComplementarioExpandido($tarea);
            } else {
                throw new Exception('Tipo de reporte no válido: ' . $tarea->tipo_reporte);
            }

            // Marcar como completada
            DB::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->update([
                    'estado' => 'completada',
                    'resultado' => json_encode($resultado)
                ]);

            echo "Tarea ID: " . $tarea->id . " completada exitosamente.\n";
            echo "Resultado: " . json_encode($resultado) . "\n";

        } catch (Exception $e) {
            // Marcar como error
            DB::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->update([
                    'estado' => 'error',
                    'error_mensaje' => $e->getMessage()
                ]);

            echo "Error en tarea ID: " . $tarea->id . " - " . $e->getMessage() . "\n";
        }
    }

    echo "Proceso completado.\n";
    exit(0);

} catch (Exception $e) {
    echo "Error general: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Ejecutar reporte básico expandido
 */
function ejecutarReporteBasicoExpandido($tarea) {
    echo "Ejecutando reporte básico expandido para sede: " . $tarea->sede_id . ", carrera: " . $tarea->carrera_id . "\n";
    
    try {
        // Obtener los detalles de cobertura básica
        $detalles = obtenerDetallesCoberturaBasica($tarea->sede_id, $tarea->carrera_id);
        
        echo "Detalles obtenidos: " . count($detalles) . "\n";
        
        // Guardar la cobertura básica directamente en la base de datos
        if (!empty($detalles)) {
            $planEspejo = DB::table('carreras_espejos')
                ->where('carrera_id', $tarea->carrera_id)
                ->where('sede_id', $tarea->sede_id)
                ->orderByDesc('vigencia_desde')
                ->first();
            if (!$planEspejo) {
                throw new Exception('Carrera no encontrada');
            }
            $codigoCarrera = $planEspejo->codigo_carrera;
            $idCarreraEspejo = (int) $planEspejo->id;
            echo "Código de carrera: " . $codigoCarrera . " (plan id " . $idCarreraEspejo . ")\n";
            
            // Obtener ID del reporte
            $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Básicas')->first();
            if (!$reporte) {
                throw new Exception('No existe el reporte de coberturas básicas');
            }
            
            $idReporte = $reporte->id;
            $fechaMedicion = date('Y-m-d H:i:s');
            
            // Borrar registros existentes del año en curso para la carrera
            $borrados = DB::table('reporte_coberturas_carreras_basicas')
                ->where('id_reporte', $idReporte)
                ->where('codigo_carrera', $codigoCarrera)
                ->where('id_carrera_espejo', $idCarreraEspejo)
                ->whereYear('fecha_medicion', date('Y'))
                ->delete();
            
            echo "Registros borrados: " . $borrados . "\n";
            
            // Insertar los nuevos detalles
            $insertados = 0;
            foreach ($detalles as $detalle) {
                DB::table('reporte_coberturas_carreras_basicas')->insert([
                    'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'id_carrera_espejo' => $idCarreraEspejo,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => $detalle['id_bibliografia_declarada'],
                    'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                    'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
                    'no_bib_disponible_basica' => $detalle['disponible'] ?? 0
                ]);
                $insertados++;
            }
            
            echo "Registros insertados: " . $insertados . "\n";
        } else {
            echo "No hay detalles para guardar\n";
        }
        
        return [
            'tipo' => 'cobertura_basica_expandido',
            'sede_id' => $tarea->sede_id,
            'carrera_id' => $tarea->carrera_id,
            'fecha_ejecucion' => date('Y-m-d H:i:s'),
            'detalles_guardados' => count($detalles)
        ];
        
    } catch (Exception $e) {
        echo "Error en ejecutarReporteBasicoExpandido: " . $e->getMessage() . "\n";
        throw $e;
    }
}

/**
 * Ejecutar reporte complementario expandido
 */
function ejecutarReporteComplementarioExpandido($tarea) {
    echo "Ejecutando reporte complementario expandido para sede: " . $tarea->sede_id . ", carrera: " . $tarea->carrera_id . "\n";
    
    try {
        // Obtener los detalles de cobertura complementaria
        $detalles = obtenerDetallesCoberturaComplementaria($tarea->sede_id, $tarea->carrera_id);
        
        echo "Detalles obtenidos: " . count($detalles) . "\n";
        
        // Guardar la cobertura complementaria directamente en la base de datos
        if (!empty($detalles)) {
            $planEspejo = DB::table('carreras_espejos')
                ->where('carrera_id', $tarea->carrera_id)
                ->where('sede_id', $tarea->sede_id)
                ->orderByDesc('vigencia_desde')
                ->first();
            if (!$planEspejo) {
                throw new Exception('Carrera no encontrada');
            }
            $codigoCarrera = $planEspejo->codigo_carrera;
            $idCarreraEspejo = (int) $planEspejo->id;
            echo "Código de carrera: " . $codigoCarrera . " (plan id " . $idCarreraEspejo . ")\n";
            
            // Obtener ID del reporte
            $reporte = DB::table('reportes')->where('nombre', 'Reporte de Coberturas Complementarias')->first();
            if (!$reporte) {
                throw new Exception('No existe el reporte de coberturas complementarias');
            }
            
            $idReporte = $reporte->id;
            $fechaMedicion = date('Y-m-d H:i:s');
            
            // Borrar registros existentes del año en curso para la carrera
            $borrados = DB::table('reporte_coberturas_carreras_complementarias')
                ->where('id_reporte', $idReporte)
                ->where('codigo_carrera', $codigoCarrera)
                ->where('id_carrera_espejo', $idCarreraEspejo)
                ->whereYear('fecha_medicion', date('Y'))
                ->delete();
            
            echo "Registros borrados: " . $borrados . "\n";
            
            // Insertar los nuevos detalles
            $insertados = 0;
            foreach ($detalles as $detalle) {
                DB::table('reporte_coberturas_carreras_complementarias')->insert([
                    'id_reporte' => $idReporte,
                    'codigo_carrera' => $codigoCarrera,
                    'id_carrera_espejo' => $idCarreraEspejo,
                    'codigo_asignatura' => $detalle['codigo_asignatura'],
                    'id_bibliografia_declarada' => ($detalle['id_bibliografia_declarada'] === '' || is_null($detalle['id_bibliografia_declarada'])) ? null : $detalle['id_bibliografia_declarada'],
                    'fecha_medicion' => $fechaMedicion,
                    'no_ejem_imp' => $detalle['ejemplares_impresos'] ?? 0,
                    'no_ejem_dig' => $detalle['ejemplares_digitales'] ?? 0,
                    'no_bib_disponible_complementaria' => $detalle['disponible'] ?? 0
                ]);
                $insertados++;
            }
            
            echo "Registros insertados: " . $insertados . "\n";
        } else {
            echo "No hay detalles para guardar\n";
        }
        
        return [
            'tipo' => 'cobertura_complementaria_expandido',
            'sede_id' => $tarea->sede_id,
            'carrera_id' => $tarea->carrera_id,
            'fecha_ejecucion' => date('Y-m-d H:i:s'),
            'detalles_guardados' => count($detalles)
        ];
        
    } catch (Exception $e) {
        echo "Error en ejecutarReporteComplementarioExpandido: " . $e->getMessage() . "\n";
        throw $e;
    }
}

/**
 * Detalle de cobertura del plan más reciente de la carrera en la sede, calculado con la misma lógica que los
 * reportes (ReporteController::detalleCoberturaPlan): mismas asignaturas, filtros de formación del plan
 * (o todos por defecto) y la misma regla de disponibilidad.
 */
function obtenerDetallesCoberturaPlan($sedeId, $carreraId, $tipo) {
    $plan = DB::table('carreras_espejos')
        ->where('carrera_id', $carreraId)
        ->where('sede_id', $sedeId)
        ->orderByDesc('vigencia_desde')
        ->first();
    if (!$plan) {
        return [];
    }
    static $controlador = null;
    if ($controlador === null) {
        if (!isset($GLOBALS['twig'])) {
            $GLOBALS['twig'] = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates'));
        }
        $controlador = new \App\Controllers\ReporteController();
    }
    return $controlador->detalleCoberturaPlan($plan, $tipo, null);
}

/**
 * Obtener detalles de cobertura básica para guardado
 */
function obtenerDetallesCoberturaBasica($sedeId, $carreraId) {
    return obtenerDetallesCoberturaPlan($sedeId, $carreraId, 'basica');
}

/**
 * Obtener detalles de cobertura complementaria para guardado
 */
function obtenerDetallesCoberturaComplementaria($sedeId, $carreraId) {
    return obtenerDetallesCoberturaPlan($sedeId, $carreraId, 'complementaria');
}
