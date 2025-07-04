<?php
// Script para probar la nueva URL del reporte

// Configurar para mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simular una petición HTTP al reporte con la nueva URL
$url = 'http://192.168.72.5/biblioges/reportes/listado-bibliografias';

echo "=== PRUEBA DE NUEVA URL ===\n";
echo "URL a probar: $url\n\n";

// Usar cURL para hacer la petición
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

// Simular cookies de sesión
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=test_session');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
$redirectCount = curl_getinfo($ch, CURLINFO_REDIRECT_COUNT);

curl_close($ch);

echo "Código HTTP: $httpCode\n";
echo "URL final: $finalUrl\n";
echo "Número de redirecciones: $redirectCount\n\n";

if ($httpCode == 200) {
    echo "=== CONTENIDO DE LA RESPUESTA ===\n";
    // Extraer solo el body de la respuesta
    $bodyStart = strpos($response, "\r\n\r\n");
    if ($bodyStart !== false) {
        $body = substr($response, $bodyStart + 4);
        if (strpos($body, 'Listado de Bibliografías') !== false) {
            echo "✅ ÉXITO: El reporte se cargó correctamente\n";
            echo "Contenido encontrado: Listado de Bibliografías\n";
        } else {
            echo "❌ ERROR: El reporte no se cargó correctamente\n";
            echo "Contenido: " . substr($body, 0, 500) . "...\n";
        }
    } else {
        echo "No se pudo extraer el body de la respuesta\n";
    }
} else {
    echo "Error: La petición no fue exitosa\n";
}

echo "\n=== FIN PRUEBA ===\n"; 