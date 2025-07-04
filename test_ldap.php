<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Core\LdapService;

echo "=== Prueba de Conexión LDAP ===\n\n";

$ldapService = new LdapService();

// 1. Verificar disponibilidad del servidor
echo "1. Verificando disponibilidad del servidor LDAP...\n";
if ($ldapService->isServerAvailable()) {
    echo "✓ Servidor LDAP disponible\n\n";
} else {
    echo "✗ Servidor LDAP no disponible\n\n";
    exit(1);
}

// 2. Probar autenticación con credenciales de ejemplo
echo "2. Probando autenticación LDAP...\n";
echo "Ingrese el RUT del usuario a probar: ";
$rut = trim(fgets(STDIN));

echo "Ingrese la contraseña: ";
$password = trim(fgets(STDIN));

$result = $ldapService->authenticate($rut, $password);

if ($result && $result['success']) {
    echo "✓ Autenticación LDAP exitosa\n";
    echo "Información del usuario:\n";
    echo "- RUT: " . $result['user']['rut'] . "\n";
    echo "- Nombre: " . $result['user']['nombre'] . "\n";
    echo "- Email: " . $result['user']['email'] . "\n";
    echo "- DN: " . $result['user']['dn'] . "\n";
} else {
    echo "✗ Autenticación LDAP fallida\n";
}

echo "\n=== Fin de la prueba ===\n"; 