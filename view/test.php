<?php
/**
 * Script de prueba para verificar el funcionamiento del frontend
 * Este archivo puede ser eliminado después de las pruebas
 */

// Configuración básica
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Prueba del Frontend - Sistema de Bibliografías UCN</h1>";

// Verificar que el autoloader existe
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("<p style='color: red;'>❌ Error: No se encontró el autoloader de Composer</p>");
}

echo "<p style='color: green;'>✅ Autoloader encontrado</p>";

// Verificar que el controlador existe
if (!file_exists(__DIR__ . '/../src/Controllers/FrontendController.php')) {
    die("<p style='color: red;'>❌ Error: No se encontró el FrontendController</p>");
}

echo "<p style='color: green;'>✅ FrontendController encontrado</p>";

// Verificar que las plantillas existen
$templates = [
    'base.twig',
    'index.twig',
    'carrera.twig',
    'asignatura.twig'
];

foreach ($templates as $template) {
    $path = __DIR__ . '/../templates/frontend/' . $template;
    if (!file_exists($path)) {
        echo "<p style='color: red;'>❌ Error: No se encontró la plantilla {$template}</p>";
    } else {
        echo "<p style='color: green;'>✅ Plantilla {$template} encontrada</p>";
    }
}

// Verificar configuración de base de datos
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    // Cargar variables de entorno
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    } else {
        // Configuración por defecto
        $_ENV['DB_HOST'] = '127.0.0.1';
        $_ENV['DB_PORT'] = '3306';
        $_ENV['DB_DATABASE'] = 'bibliografia';
        $_ENV['DB_USERNAME'] = 'biblioges';
        $_ENV['DB_PASSWORD'] = 'joyal2025$';
    }
    
    // Intentar conexión a la base de datos
    $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Conexión a base de datos exitosa</p>";
    
    // Verificar que las tablas principales existen
    $tables = ['sedes', 'carreras', 'carreras_espejos', 'asignaturas', 'mallas', 'bibliografias_declaradas'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Tabla {$table} existe</p>";
        } else {
            echo "<p style='color: red;'>❌ Error: Tabla {$table} no existe</p>";
        }
    }
    
    // Verificar datos básicos
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM sedes WHERE estado = 1");
    $sedesCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p style='color: blue;'>📊 Sedes activas: {$sedesCount}</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM carreras WHERE estado = 1");
    $carrerasCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p style='color: blue;'>📊 Carreras activas: {$carrerasCount}</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de base de datos: " . $e->getMessage() . "</p>";
}

// Verificar que el .htaccess existe
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<p style='color: green;'>✅ Archivo .htaccess encontrado</p>";
} else {
    echo "<p style='color: red;'>❌ Error: No se encontró el archivo .htaccess</p>";
}

// Verificar permisos de directorios
$directories = [
    '../storage/logs',
    '../cache/twig'
];

foreach ($directories as $dir) {
    if (is_dir($dir) && is_writable($dir)) {
        echo "<p style='color: green;'>✅ Directorio {$dir} es escribible</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Directorio {$dir} no es escribible o no existe</p>";
    }
}

echo "<hr>";
echo "<h2>Próximos pasos:</h2>";
echo "<ol>";
echo "<li>Configurar el servidor web para que apunte a la carpeta 'view' como DocumentRoot</li>";
echo "<li>Verificar que mod_rewrite esté habilitado en Apache</li>";
echo "<li>Acceder a <a href='http://localhost/'>http://localhost/</a> para probar el frontend</li>";
echo "<li>El backend seguirá disponible en <a href='http://localhost/biblioges/'>http://localhost/biblioges/</a></li>";
echo "</ol>";

echo "<p><strong>Nota:</strong> Este archivo de prueba puede ser eliminado después de verificar que todo funciona correctamente.</p>";
?> 