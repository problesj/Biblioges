<?php

echo "=== Verificación de Extensión LDAP ===\n\n";

// Verificar si la extensión LDAP está cargada
if (extension_loaded('ldap')) {
    echo "✓ Extensión LDAP está cargada\n";
    echo "Versión: " . phpversion('ldap') . "\n\n";
} else {
    echo "✗ Extensión LDAP NO está cargada\n";
    echo "Para habilitar LDAP en Ubuntu/Debian:\n";
    echo "sudo apt-get install php-ldap\n";
    echo "sudo systemctl restart apache2\n\n";
    exit(1);
}

// Verificar funciones LDAP disponibles
$requiredFunctions = [
    'ldap_connect',
    'ldap_bind',
    'ldap_search',
    'ldap_get_entries',
    'ldap_set_option',
    'ldap_unbind'
];

echo "Verificando funciones LDAP requeridas:\n";
foreach ($requiredFunctions as $function) {
    if (function_exists($function)) {
        echo "✓ {$function}\n";
    } else {
        echo "✗ {$function} - NO disponible\n";
    }
}

echo "\n=== Verificación Completada ===\n"; 