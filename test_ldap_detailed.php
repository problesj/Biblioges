<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Core\LdapService;

echo "=== Prueba Detallada de Conexión LDAP ===\n\n";

// Mostrar configuración
echo "Configuración LDAP:\n";
echo "Host: " . $_ENV['LDAP_HOST'] . "\n";
echo "Puerto: " . $_ENV['LDAP_PORT'] . "\n";
echo "Bind DN: " . $_ENV['LDAP_BIND_DN'] . "\n";
echo "Base DN: " . $_ENV['LDAP_BASE_DN'] . "\n\n";

$ldapService = new LdapService();

// 1. Prueba de conectividad básica
echo "1. Prueba de conectividad básica...\n";
$connection = ldap_connect($_ENV['LDAP_HOST'], $_ENV['LDAP_PORT']);
if ($connection) {
    echo "✓ Conexión LDAP establecida\n";
    
    // Configurar opciones
    ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($connection, LDAP_OPT_NETWORK_TIMEOUT, 10);
    
    echo "✓ Opciones LDAP configuradas\n";
    
    // 2. Prueba de bind con credenciales de consulta
    echo "\n2. Prueba de bind con credenciales de consulta...\n";
    $bindResult = ldap_bind($connection, $_ENV['LDAP_BIND_DN'], $_ENV['LDAP_BIND_PASSWORD']);
    
    if ($bindResult) {
        echo "✓ Bind exitoso con credenciales de consulta\n";
        
        // 3. Prueba de búsqueda
        echo "\n3. Prueba de búsqueda en el directorio...\n";
        $filter = "(objectClass=*)";
        $searchResult = ldap_search($connection, $_ENV['LDAP_BASE_DN'], $filter, ['dn'], 1);
        
        if ($searchResult) {
            $entries = ldap_get_entries($connection, $searchResult);
            echo "✓ Búsqueda exitosa. Encontrados " . $entries['count'] . " objetos\n";
        } else {
            echo "✗ Error en búsqueda: " . ldap_error($connection) . "\n";
        }
        
    } else {
        echo "✗ Error en bind: " . ldap_error($connection) . "\n";
        echo "Código de error: " . ldap_errno($connection) . "\n";
    }
    
    ldap_unbind($connection);
} else {
    echo "✗ No se pudo establecer conexión LDAP\n";
}

echo "\n=== Fin de la prueba ===\n"; 