<?php
// Archivo de prueba para verificar información de carrera

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar PDO
$dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
$pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Simular parámetros de una carrera
$sedeId = 2; // Coquimbo
$carreraId = 28; // ID de la carrera de la imagen

echo "<h1>Test de Información de Carrera</h1>";
echo "<p><strong>Sede ID:</strong> $sedeId</p>";
echo "<p><strong>Carrera ID:</strong> $carreraId</p>";

try {
    // Obtener información de la sede y carrera
    $stmt = $pdo->prepare("
        SELECT 
            s.id as sede_id,
            s.nombre as sede_nombre,
            c.id as carrera_id,
            c.nombre as carrera_nombre,
            c.tipo_programa,
            c.imagen_url,
            c.cantidad_semestres
        FROM sedes s
        INNER JOIN carreras_espejos ce ON s.id = ce.sede_id
        INNER JOIN carreras c ON ce.carrera_id = c.id
        WHERE s.id = :sede_id AND c.id = :carrera_id AND s.estado = 1 AND c.estado = 1
    ");
    $stmt->execute([
        ':sede_id' => $sedeId,
        ':carrera_id' => $carreraId
    ]);
    $carrera = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($carrera) {
        echo "<h2>Información de la Carrera:</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Campo</th><th>Valor</th></tr>";
        foreach ($carrera as $key => $value) {
            echo "<tr><td>$key</td><td>" . htmlspecialchars($value) . "</td></tr>";
        }
        echo "</table>";
        
        echo "<h2>Verificación de Sede:</h2>";
        echo "<p><strong>sede_id:</strong> " . ($carrera['sede_id'] ?? 'NO DEFINIDO') . "</p>";
        echo "<p><strong>sede_nombre:</strong> " . ($carrera['sede_nombre'] ?? 'NO DEFINIDO') . "</p>";
        echo "<p><strong>carrera_nombre:</strong> " . ($carrera['carrera_nombre'] ?? 'NO DEFINIDO') . "</p>";
        
        if ($carrera['sede_nombre']) {
            echo "<div style='background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "<strong>✅ Sede encontrada:</strong> " . $carrera['sede_nombre'];
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
            echo "<strong>❌ Problema:</strong> No se encontró información de la sede";
            echo "</div>";
        }
    } else {
        echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "<strong>❌ Error:</strong> No se encontró la carrera con sede ID $sedeId y carrera ID $carreraId";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
    echo "<strong>❌ Error de base de datos:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "<h2>Prueba de Enlace:</h2>";
echo "<p><a href='/biblioges/view/carrera/$sedeId/$carreraId' target='_blank'>Probar enlace a la carrera</a></p>";
?>

