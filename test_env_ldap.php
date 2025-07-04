<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Verificación de Variables de Entorno LDAP ===\n\n";

$ldapVars = [
    'LDAP_HOST',
    'LDAP_PORT', 
    'LDAP_BIND_DN',
    'LDAP_BIND_PASSWORD',
    'LDAP_BASE_DN',
    'LDAP_TIMEOUT',
    'LDAP_PROTOCOL_VERSION',
    'LDAP_REFERRALS',
    'LDAP_USER_FILTER'
];

echo "Usando getenv():\n";
foreach ($ldapVars as $var) {
    $value = getenv($var);
    if ($value !== false) {
        echo "✓ {$var}: {$value}\n";
    } else {
        echo "✗ {$var}: NO definida\n";
    }
}

echo "\nUsando \$_ENV:\n";
foreach ($ldapVars as $var) {
    $value = $_ENV[$var] ?? null;
    if ($value !== null) {
        echo "✓ {$var}: {$value}\n";
    } else {
        echo "✗ {$var}: NO definida\n";
    }
}

echo "\nUsando \$_SERVER:\n";
foreach ($ldapVars as $var) {
    $value = $_SERVER[$var] ?? null;
    if ($value !== null) {
        echo "✓ {$var}: {$value}\n";
    } else {
        echo "✗ {$var}: NO definida\n";
    }
}

echo "\n=== Verificación de Configuración LDAP ===\n";
$config = require __DIR__ . '/src/config/ldap.php';

echo "Host: " . $config['host'] . "\n";
echo "Puerto: " . $config['port'] . "\n";
echo "Bind DN: " . $config['bind_dn'] . "\n";
echo "Base DN: " . $config['base_dn'] . "\n";
echo "Timeout: " . $config['timeout'] . "\n";
echo "Protocol Version: " . $config['protocol_version'] . "\n";
echo "User Filter: " . $config['user_filter'] . "\n";

echo "\n=== Verificación Completada ===\n"; 