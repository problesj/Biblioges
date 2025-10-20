<?php
// Archivo de debug para verificar configuración
echo "<h1>Debug Frontend</h1>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'no definido') . "</p>";
echo "<p><strong>PATH_INFO:</strong> " . ($_SERVER['PATH_INFO'] ?? 'no definido') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'no definido') . "</p>";
echo "<p><strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'no definido') . "</p>";

// Verificar si las rutas están funcionando
echo "<h2>Pruebas de Rutas</h2>";
echo "<p><a href='test'>Probar ruta /test</a></p>";
echo "<p><a href='?sede=1'>Probar filtro por sede</a></p>";
echo "<p><a href='carrera/1/1'>Probar ruta de carrera</a></p>";

// Verificar configuración de Slim
echo "<h2>Configuración Slim</h2>";
echo "<p>Base URL: " . ($_ENV['APP_URL'] ?? 'no definido') . "</p>";
echo "<p>Frontend URL: " . ($_ENV['APP_URL_FRONTEND'] ?? 'no definido') . "</p>";
?>
