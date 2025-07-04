<?php
// Archivo de prueba para verificar el reporte de bibliografías declaradas

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Cargar variables de entorno
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    // Configuración por defecto si no existe .env
    $_ENV['DB_HOST'] = '127.0.0.1';
    $_ENV['DB_PORT'] = '3306';
    $_ENV['DB_DATABASE'] = 'bibliografia';
    $_ENV['DB_USERNAME'] = 'biblioges';
    $_ENV['DB_PASSWORD'] = 'joyal2025$';
    $_ENV['APP_URL'] = 'http://192.168.72.5/biblioges/';
    $_ENV['APP_DEBUG'] = 'true';
}

// Configurar la conexión a la base de datos usando la configuración del proyecto
require_once __DIR__ . '/src/config/eloquent.php';

// Probar la consulta del reporte
try {
    $query = DB::table('bibliografias_declaradas as bd')
        ->select([
            'bd.id',
            'bd.titulo',
            'bd.tipo',
            'bd.anio_publicacion',
            'bd.editorial',
            'bd.estado',
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ", ", a.nombres) SEPARATOR "; ") as autores'),
            DB::raw('COUNT(DISTINCT ab.asignatura_id) as num_asignaturas'),
            DB::raw('COUNT(DISTINCT bdis.id) as num_bibliografias_disponibles')
        ])
        ->leftJoin('bibliografias_autores as ba', 'bd.id', '=', 'ba.bibliografia_id')
        ->leftJoin('autores as a', 'ba.autor_id', '=', 'a.id')
        ->leftJoin('asignaturas_bibliografias as ab', 'bd.id', '=', 'ab.bibliografia_id')
        ->leftJoin('bibliografias_disponibles as bdis', 'bd.id', '=', 'bdis.bibliografia_declarada_id')
        ->groupBy('bd.id', 'bd.titulo', 'bd.tipo', 'bd.anio_publicacion', 'bd.editorial', 'bd.estado')
        ->limit(5);

    $result = $query->get();
    
    echo "=== PRUEBA DEL REPORTE DE BIBLIOGRAFÍAS DECLARADAS ===\n\n";
    echo "Consulta SQL generada:\n";
    echo $query->toSql() . "\n\n";
    
    echo "Parámetros:\n";
    print_r($query->getBindings());
    echo "\n";
    
    echo "Resultados (primeros 5 registros):\n";
    foreach ($result as $row) {
        echo "ID: {$row->id}\n";
        echo "Título: {$row->titulo}\n";
        echo "Tipo: {$row->tipo}\n";
        echo "Año: {$row->anio_publicacion}\n";
        echo "Editorial: {$row->editorial}\n";
        echo "Estado: " . ($row->estado ? 'Activo' : 'Inactivo') . "\n";
        echo "Autores: " . ($row->autores ?: 'Sin autores') . "\n";
        echo "Asignaturas: {$row->num_asignaturas}\n";
        echo "Disponibles: {$row->num_bibliografias_disponibles}\n";
        echo "---\n";
    }
    
    echo "\nTotal de registros: " . $result->count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
} 