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
            // Obtener código de carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $tarea->sede_id)
                ->where('id_carrera', $tarea->carrera_id)
                ->select('codigo_carrera as codigo')
                ->first();
            
            if (!$carrera) {
                throw new Exception('Carrera no encontrada');
            }
            
            $codigoCarrera = $carrera->codigo;
            echo "Código de carrera: " . $codigoCarrera . "\n";
            
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
                ->whereYear('fecha_medicion', date('Y'))
                ->delete();
            
            echo "Registros borrados: " . $borrados . "\n";
            
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
            // Obtener código de carrera
            $carrera = DB::table('vw_mallas')
                ->where('id_sede', $tarea->sede_id)
                ->where('id_carrera', $tarea->carrera_id)
                ->select('codigo_carrera as codigo')
                ->first();
            
            if (!$carrera) {
                throw new Exception('Carrera no encontrada');
            }
            
            $codigoCarrera = $carrera->codigo;
            echo "Código de carrera: " . $codigoCarrera . "\n";
            
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
                ->whereYear('fecha_medicion', date('Y'))
                ->delete();
            
            echo "Registros borrados: " . $borrados . "\n";
            
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
 * Obtener detalles de cobertura básica para guardado
 */
function obtenerDetallesCoberturaBasica($sedeId, $carreraId) {
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

    // Generar detalles de cobertura básica
    $detalles = [];
    foreach ($asignaturas as $asignatura) {
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

/**
 * Obtener detalles de cobertura complementaria para guardado
 */
function obtenerDetallesCoberturaComplementaria($sedeId, $carreraId) {
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