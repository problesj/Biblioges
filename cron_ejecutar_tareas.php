<?php
/**
 * Script para ejecutar tareas programadas desde cron
 * Uso: php cron_ejecutar_tareas.php
 */

// Incluir el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Configurar variables de entorno para la base de datos
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_DATABASE'] = 'bibliografia';
$_ENV['DB_USERNAME'] = 'biblioges';
$_ENV['DB_PASSWORD'] = 'joyal2025$';

// Inicializar la base de datos
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Obtener tareas pendientes
    $tareasPendientes = $capsule::table('tareas_programadas')
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
            $capsule::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->update([
                    'estado' => 'en_proceso',
                    'fecha_ejecucion' => date('Y-m-d H:i:s')
                ]);

            // Ejecutar el reporte correspondiente
            if ($tarea->tipo_reporte === 'cobertura_basica_expandido') {
                ejecutarReporteBasicoExpandido($tarea);
            } elseif ($tarea->tipo_reporte === 'cobertura_complementaria_expandido') {
                ejecutarReporteComplementarioExpandido($tarea);
            } else {
                throw new Exception('Tipo de reporte no válido: ' . $tarea->tipo_reporte);
            }

            // Marcar como completada
            $capsule::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->update([
                    'estado' => 'completada',
                    'resultado' => json_encode([
                        'tipo' => $tarea->tipo_reporte,
                        'sede_id' => $tarea->sede_id,
                        'carrera_id' => $tarea->carrera_id,
                        'fecha_ejecucion' => date('Y-m-d H:i:s')
                    ])
                ]);

            echo "Tarea ID: " . $tarea->id . " completada exitosamente.\n";

        } catch (Exception $e) {
            // Marcar como error
            $capsule::table('tareas_programadas')
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
    // Aquí puedes implementar la lógica específica del reporte
    // Por ahora solo simulamos la ejecución
    echo "Ejecutando reporte básico expandido para sede: " . $tarea->sede_id . ", carrera: " . $tarea->carrera_id . "\n";
    
    // Simular tiempo de procesamiento
    sleep(2);
}

/**
 * Ejecutar reporte complementario expandido
 */
function ejecutarReporteComplementarioExpandido($tarea) {
    // Aquí puedes implementar la lógica específica del reporte
    // Por ahora solo simulamos la ejecución
    echo "Ejecutando reporte complementario expandido para sede: " . $tarea->sede_id . ", carrera: " . $tarea->carrera_id . "\n";
    
    // Simular tiempo de procesamiento
    sleep(2);
} 