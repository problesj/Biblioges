<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Diagnóstico de Conexión LDAP ===\n\n";

$host = $_ENV['LDAP_HOST'];
$port = $_ENV['LDAP_PORT'];

echo "Configuración:\n";
echo "Host: $host\n";
echo "Puerto: $port\n\n";

// Probar diferentes formatos de conexión
$connectionMethods = [
    "ldap://$host:$port",
    "ldap://$host",
    "ldaps://$host:636",
    "ldap://$host:3268"
];

foreach ($connectionMethods as $method) {
    echo "Probando: $method\n";
    
    $connection = ldap_connect($method);
    if ($connection) {
        echo "✓ Conexión establecida\n";
        
        // Configurar opciones
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($connection, LDAP_OPT_NETWORK_TIMEOUT, 5);
        
        // Intentar bind simple
        $bindResult = @ldap_bind($connection, $_ENV['LDAP_BIND_DN'], $_ENV['LDAP_BIND_PASSWORD']);
        
        if ($bindResult) {
            echo "✓ Bind exitoso\n";
            ldap_unbind($connection);
            break;
        } else {
            echo "✗ Bind fallido: " . ldap_error($connection) . "\n";
            ldap_unbind($connection);
        }
    } else {
        echo "✗ No se pudo conectar\n";
    }
    echo "\n";
}

echo "=== Fin del diagnóstico ===\n"; 