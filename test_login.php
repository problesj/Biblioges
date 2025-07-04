<?php
// Script para probar el login vía HTTP POST

$url = 'http://192.168.72.5/biblioges/login';
$email = 'probles@ucn.cl';
$password = 'Jp727483;';

$postFields = [
    'email' => $email,
    'password' => $password
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'X-Requested-With: XMLHttpRequest'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// Mostrar resultados

echo "=== Prueba de Login ===\n";
echo "URL: $url\n";
echo "Usuario: $email\n";
echo "Clave: $password\n";
echo "Código HTTP: $httpCode\n";
echo "Content-Type: $contentType\n";
echo "\n=== Respuesta Completa ===\n";
echo $response;
echo "\n=== Fin de la prueba ===\n"; 