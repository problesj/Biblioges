<?php
// Script para depurar la petición HTTP
echo "=== DEBUG REQUEST ===\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "PATH_INFO: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'no definido') . "\n";
echo "QUERY_STRING: " . $_SERVER['QUERY_STRING'] . "\n";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "\n";
echo "HTTP_REFERER: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'no definido') . "\n";
echo "HTTP_USER_AGENT: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
echo "=== FIN DEBUG ===\n";

// Verificar si la ruta existe
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/biblioges';

// Extraer la ruta relativa
$relativePath = str_replace($basePath, '', $requestUri);
$relativePath = parse_url($relativePath, PHP_URL_PATH);

echo "Ruta relativa extraída: " . $relativePath . "\n";

// Verificar si es una ruta de reportes
if (strpos($relativePath, '/reportes/') === 0) {
    echo "✅ Es una ruta de reportes\n";
    
    // Verificar si es cobertura-basica
    if (strpos($relativePath, '/reportes/cobertura-basica') === 0) {
        echo "✅ Es una ruta de cobertura-basica\n";
        
        // Verificar si tiene parámetros
        $pathParts = explode('/', trim($relativePath, '/'));
        echo "Partes de la ruta: " . print_r($pathParts, true) . "\n";
        
        if (count($pathParts) >= 3 && $pathParts[0] === 'reportes' && $pathParts[1] === 'cobertura-basica') {
            echo "✅ Ruta válida de cobertura-basica\n";
            
            if (count($pathParts) === 2) {
                echo "Ruta: /reportes/cobertura-basica (sin parámetros)\n";
            } elseif (count($pathParts) === 4) {
                echo "Ruta: /reportes/cobertura-basica/{sede_id}/{carrera_id}\n";
                echo "sede_id: " . $pathParts[2] . "\n";
                echo "carrera_id: " . $pathParts[3] . "\n";
            } elseif (count($pathParts) === 5) {
                echo "Ruta: /reportes/cobertura-basica/{sede_id}/{carrera_id}/{asignatura_codigo}\n";
                echo "sede_id: " . $pathParts[2] . "\n";
                echo "carrera_id: " . $pathParts[3] . "\n";
                echo "asignatura_codigo: " . $pathParts[4] . "\n";
            }
        }
    }
} else {
    echo "❌ No es una ruta de reportes\n";
}

// Verificar sesión
session_start();
echo "=== SESSION DATA ===\n";
echo "Session ID: " . session_id() . "\n";
echo "Session data: " . print_r($_SESSION, true) . "\n";
echo "=== FIN SESSION ===\n"; 