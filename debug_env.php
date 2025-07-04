<?php
echo "=== Debug de Variables de Entorno ===\n\n";

// Verificar si el archivo .env existe
if (file_exists('.env')) {
    echo "✓ Archivo .env existe\n";
    echo "Contenido del archivo .env:\n";
    echo file_get_contents('.env') . "\n";
} else {
    echo "✗ Archivo .env NO existe\n";
    exit(1);
}

// Intentar cargar con dotenv
try {
    require_once 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable('.');
    $dotenv->load();
    echo "✓ Dotenv cargado exitosamente\n";
} catch (Exception $e) {
    echo "✗ Error cargando dotenv: " . $e->getMessage() . "\n";
}

// Verificar variables específicas
echo "\nVerificando variables LDAP:\n";
$vars = ['LDAP_HOST', 'LDAP_PORT', 'LDAP_BIND_DN', 'LDAP_BIND_PASSWORD'];
foreach ($vars as $var) {
    $value = getenv($var);
    echo "{$var}: " . ($value ?: 'NO definida') . "\n";
}

echo "\n=== Fin Debug ===\n"; 