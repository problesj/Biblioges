<?php
/**
 * Script para probar el reporte de cobertura básica y identificar el problema
 */

require_once 'vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuración de la base de datos
$dbConfig = [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? '3306',
    'dbname' => $_ENV['DB_DATABASE'] ?? 'biblioges',
    'user' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? ''
];

try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    echo "=== PRUEBA DE REPORTE DE COBERTURA BÁSICA ===\n\n";

    // Parámetros de prueba (Enfermería en sede 4)
    $sedeId = 4;
    $carreraId = 9; // Enfermería
    
    // Primero verificar qué carreras existen
    echo "0. Verificando carreras disponibles...\n";
    $carreras = $pdo->query("
        SELECT c.id, c.nombre, ce.codigo_carrera, s.id as sede_id, s.nombre as sede_nombre
        FROM carreras c
        JOIN carreras_espejos ce ON c.id = ce.carrera_id
        JOIN sedes s ON ce.sede_id = s.id
        WHERE c.nombre LIKE '%Enfermería%'
        ORDER BY s.nombre, c.nombre
    ")->fetchAll();
    
    echo "Carreras de Enfermería encontradas: " . count($carreras) . "\n";
    foreach ($carreras as $carr) {
        echo "- ID: {$carr['id']}, Nombre: {$carr['nombre']}, Código: {$carr['codigo_carrera']}, Sede: {$carr['sede_nombre']} (ID: {$carr['sede_id']})\n";
    }
    
    if (empty($carreras)) {
        echo "No se encontraron carreras de Enfermería\n";
        exit;
    }
    
    // Usar la primera carrera encontrada
    $carreraId = $carreras[0]['id'];
    $sedeId = $carreras[0]['sede_id'];
    echo "\nUsando carrera ID: $carreraId, Sede ID: $sedeId\n\n";

    echo "1. Verificando datos de la carrera Enfermería...\n";
    
    // Obtener información de la carrera
    $carrera = $pdo->query("
        SELECT c.nombre, ce.codigo_carrera, s.nombre as sede_nombre
        FROM carreras c
        JOIN carreras_espejos ce ON c.id = ce.carrera_id
        JOIN sedes s ON ce.sede_id = s.id
        WHERE c.id = $carreraId AND ce.sede_id = $sedeId
    ")->fetch();
    
    if ($carrera) {
        echo "Carrera: {$carrera['nombre']} ({$carrera['codigo_carrera']})\n";
        echo "Sede: {$carrera['sede_nombre']}\n\n";
    } else {
        echo "Carrera no encontrada\n";
        exit;
    }

    echo "2. Verificando asignaturas en vw_mallas...\n";
    
    // Obtener todas las asignaturas de la carrera (sin filtrar por sede)
    $asignaturas = $pdo->query("
        SELECT * FROM vw_mallas 
        WHERE id_carrera = $carreraId
        ORDER BY id_sede, tipo_asignatura, asignatura
    ")->fetchAll();
    
    echo "Total de asignaturas encontradas: " . count($asignaturas) . "\n\n";
    
    foreach ($asignaturas as $asignatura) {
        echo "- {$asignatura['asignatura']} ({$asignatura['codigo_asignatura']})\n";
        echo "  Sede: {$asignatura['sede']} (ID: {$asignatura['id_sede']})\n";
        echo "  Tipo: {$asignatura['tipo_asignatura']}\n";
        if ($asignatura['codigo_asignatura_formacion']) {
            echo "  Formación: {$asignatura['asignatura_formacion']} ({$asignatura['codigo_asignatura_formacion']})\n";
        }
        echo "\n";
    }

    echo "3. Verificando asignaturas de formación específicas...\n";
    
    // Buscar específicamente las asignaturas mencionadas
    $formacionProfesional = $pdo->query("
        SELECT * FROM vw_mallas 
        WHERE id_sede = $sedeId AND id_carrera = $carreraId
        AND asignatura LIKE '%Formación Profesional%'
    ")->fetchAll();
    
    echo "Asignaturas de Formación Profesional encontradas: " . count($formacionProfesional) . "\n";
    foreach ($formacionProfesional as $asignatura) {
        echo "- {$asignatura['asignatura']} ({$asignatura['codigo_asignatura']})\n";
        echo "  Tipo: {$asignatura['tipo_asignatura']}\n";
        if ($asignatura['codigo_asignatura_formacion']) {
            echo "  Formación: {$asignatura['asignatura_formacion']} ({$asignatura['codigo_asignatura_formacion']})\n";
        }
        echo "\n";
    }

    echo "4. Verificando bibliografía de la asignatura de especialidad...\n";
    
    // Verificar si la asignatura de especialidad tiene bibliografía
    $asignaturaEspecialidad = $pdo->query("
        SELECT * FROM asignaturas 
        WHERE nombre LIKE '%Cuidados de Enf Mat, Inf y Adolecente%'
    ")->fetch();
    
    if ($asignaturaEspecialidad) {
        echo "Asignatura de especialidad encontrada: {$asignaturaEspecialidad['nombre']} (ID: {$asignaturaEspecialidad['id']})\n";
        
        // Verificar bibliografía básica
        $bibliografiaBasica = $pdo->query("
            SELECT ab.*, bd.titulo, bd.anio_publicacion
            FROM asignaturas_bibliografias ab
            JOIN bibliografias_declaradas bd ON ab.bibliografia_id = bd.id
            WHERE ab.asignatura_id = {$asignaturaEspecialidad['id']}
            AND ab.tipo_bibliografia = 'basica'
        ")->fetchAll();
        
        echo "Bibliografías básicas encontradas: " . count($bibliografiaBasica) . "\n";
        foreach ($bibliografiaBasica as $bib) {
            echo "- {$bib['titulo']} ({$bib['anio_publicacion']})\n";
        }
        
        // Verificar bibliografías disponibles
        if (!empty($bibliografiaBasica)) {
            echo "\nVerificando disponibilidad de bibliografías...\n";
            foreach ($bibliografiaBasica as $bib) {
                $disponibles = $pdo->query("
                    SELECT COUNT(*) as count
                    FROM bibliografias_disponibles
                    WHERE bibliografia_declarada_id = {$bib['bibliografia_id']}
                    AND estado = 1
                ")->fetch();
                
                echo "- {$bib['titulo']}: " . ($disponibles['count'] > 0 ? "Disponible" : "No disponible") . "\n";
            }
        }
    } else {
        echo "Asignatura de especialidad no encontrada\n";
    }

    echo "\n5. Simulando el filtro del reporte...\n";
    
    // Simular la lógica del reporte
    $tiposFormacionFiltro = ['FORMACION_PROFESIONAL']; // Solo formación profesional
    
    // Obtener asignaturas regulares
    $regulares = $pdo->query("
        SELECT codigo_asignatura as codigo, asignatura as nombre, tipo_asignatura
        FROM vw_mallas
        WHERE id_sede = $sedeId AND id_carrera = $carreraId
        AND tipo_asignatura = 'REGULAR'
    ")->fetchAll();
    
    echo "Asignaturas regulares encontradas: " . count($regulares) . "\n";
    
    // Obtener asignaturas de formación según filtro (CORREGIDO: sin filtrar por sede)
    $formaciones = $pdo->query("
        SELECT codigo_asignatura_formacion as codigo, asignatura_formacion as nombre, tipo_asignatura
        FROM vw_mallas
        WHERE id_carrera = $carreraId
        AND tipo_asignatura IN ('" . implode("','", $tiposFormacionFiltro) . "')
        AND codigo_asignatura_formacion IS NOT NULL
    ")->fetchAll();
    
    echo "Asignaturas de formación encontradas: " . count($formaciones) . "\n";
    foreach ($formaciones as $formacion) {
        echo "- {$formacion['nombre']} ({$formacion['codigo']})\n";
    }
    
    // Unir y mostrar total
    $totalAsignaturas = count($regulares) + count($formaciones);
    echo "\nTotal de asignaturas que aparecerían en el reporte: $totalAsignaturas\n";

    echo "\n=== PRUEBA COMPLETADA ===\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 