<?php
/**
 * Script de prueba para verificar el funcionamiento de los filtros de formación
 * Ejecutar desde la línea de comandos: php test_filtros.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Configurar la conexión a la base de datos
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'bibliografia',
    'username' => 'root',
    'password' => 'joyal2025$',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

use Illuminate\Database\Capsule\Manager as DB;

echo "=== PRUEBA DE FILTROS DE FORMACIÓN ===\n\n";

// Simular datos de prueba
$codigoCarrera = 'TEST001';
$filtrosPrueba = [
    'FORMACION_BASICA',
    'FORMACION_GENERAL',
    'FORMACION_PROFESIONAL'
];

echo "1. Insertando filtros de prueba para carrera: $codigoCarrera\n";
echo "   Filtros seleccionados: " . implode(', ', $filtrosPrueba) . "\n\n";

// Crear datos de filtros
$datosFiltros = [
    'codigo_carrera' => $codigoCarrera,
    'basica' => in_array('FORMACION_BASICA', $filtrosPrueba) ? 1 : 0,
    'general' => in_array('FORMACION_GENERAL', $filtrosPrueba) ? 1 : 0,
    'idioma' => in_array('FORMACION_IDIOMAS', $filtrosPrueba) ? 1 : 0,
    'profesional' => in_array('FORMACION_PROFESIONAL', $filtrosPrueba) ? 1 : 0,
    'valores' => in_array('FORMACION_VALORES', $filtrosPrueba) ? 1 : 0,
    'especialidad' => in_array('FORMACION_ESPECIALIDAD', $filtrosPrueba) ? 1 : 0,
    'especial' => in_array('FORMACION_ESPECIAL', $filtrosPrueba) ? 1 : 0
];

echo "2. Valores que se guardarán en la base de datos:\n";
foreach ($datosFiltros as $campo => $valor) {
    if ($campo !== 'codigo_carrera') {
        echo "   $campo: $valor\n";
    }
}
echo "\n";

// Insertar en la base de datos
try {
    // Eliminar registro existente si existe
    DB::table('filtros_formaciones')->where('codigo_carrera', $codigoCarrera)->delete();
    
    // Insertar nuevo registro
    DB::table('filtros_formaciones')->insert($datosFiltros);
    echo "3. ✅ Filtros insertados correctamente en la base de datos\n\n";
    
    // Verificar que se guardaron correctamente
    echo "4. Verificando datos guardados:\n";
    $filtrosGuardados = DB::table('filtros_formaciones')
        ->where('codigo_carrera', $codigoCarrera)
        ->first();
    
    if ($filtrosGuardados) {
        echo "   basica: $filtrosGuardados->basica\n";
        echo "   general: $filtrosGuardados->general\n";
        echo "   idioma: $filtrosGuardados->idioma\n";
        echo "   profesional: $filtrosGuardados->profesional\n";
        echo "   valores: $filtrosGuardados->valores\n";
        echo "   especialidad: $filtrosGuardados->especialidad\n";
        echo "   especial: $filtrosGuardados->especial\n\n";
        
        // Convertir de vuelta a array de filtros
        $filtrosRecuperados = [];
        if ($filtrosGuardados->basica) $filtrosRecuperados[] = 'FORMACION_BASICA';
        if ($filtrosGuardados->general) $filtrosRecuperados[] = 'FORMACION_GENERAL';
        if ($filtrosGuardados->idioma) $filtrosRecuperados[] = 'FORMACION_IDIOMAS';
        if ($filtrosGuardados->profesional) $filtrosRecuperados[] = 'FORMACION_PROFESIONAL';
        if ($filtrosGuardados->valores) $filtrosRecuperados[] = 'FORMACION_VALORES';
        if ($filtrosGuardados->especialidad) $filtrosRecuperados[] = 'FORMACION_ESPECIALIDAD';
        if ($filtrosGuardados->especial) $filtrosRecuperados[] = 'FORMACION_ESPECIAL';
        
        echo "5. Filtros recuperados: " . implode(', ', $filtrosRecuperados) . "\n";
        
        // Verificar que coinciden
        if (count(array_diff($filtrosPrueba, $filtrosRecuperados)) === 0 && 
            count(array_diff($filtrosRecuperados, $filtrosPrueba)) === 0) {
            echo "6. ✅ Los filtros coinciden perfectamente\n";
        } else {
            echo "6. ❌ Los filtros NO coinciden\n";
        }
        
    } else {
        echo "❌ No se encontraron filtros guardados\n";
    }
    
    // Limpiar datos de prueba
    DB::table('filtros_formaciones')->where('codigo_carrera', $codigoCarrera)->delete();
    echo "\n7. 🧹 Datos de prueba eliminados\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DE LA PRUEBA ===\n";
?> 