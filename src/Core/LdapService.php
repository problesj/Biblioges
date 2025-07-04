<?php

namespace App\Core;

class LdapService
{
    private $ldapHost;
    private $ldapPort;
    private $ldapBindDn;
    private $ldapBindPassword;
    private $ldapBaseDn;
    private $connection;

    public function __construct()
    {
        // Cargar configuración LDAP
        $config = require __DIR__ . '/../config/ldap.php';
        
        $this->ldapHost = $config['host'];
        $this->ldapPort = $config['port'];
        $this->ldapBindDn = $config['bind_dn'];
        $this->ldapBindPassword = $config['bind_password'];
        $this->ldapBaseDn = $config['base_dn'];
    }

    /**
     * Conecta al servidor LDAP
     */
    private function connect()
    {
        try {
            $config = require __DIR__ . '/../config/ldap.php';
            
            $this->connection = ldap_connect($this->ldapHost, $this->ldapPort);
            
            if (!$this->connection) {
                error_log("LDAP: No se pudo conectar al servidor {$this->ldapHost}:{$this->ldapPort}");
                return false;
            }

            // Configurar opciones LDAP desde la configuración
            ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, $config['protocol_version']);
            ldap_set_option($this->connection, LDAP_OPT_REFERRALS, $config['referrals']);
            ldap_set_option($this->connection, LDAP_OPT_NETWORK_TIMEOUT, $config['timeout']);

            return true;
        } catch (\Exception $e) {
            error_log("LDAP: Error de conexión: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Autentica un usuario usando RUT y contraseña
     */
    public function authenticate($rut, $password)
    {
        if (!$this->connect()) {
            error_log("LDAP: No se pudo establecer conexión con el servidor");
            return false;
        }

        try {
            // Primero, hacer bind con las credenciales de consulta
            $bindResult = ldap_bind($this->connection, $this->ldapBindDn, $this->ldapBindPassword);
            
            if (!$bindResult) {
                error_log("LDAP: Error en bind con credenciales de consulta");
                return false;
            }

            // Buscar el usuario por RUT
            $config = require __DIR__ . '/../config/ldap.php';
            $filter = str_replace('{rut}', $rut, $config['user_filter']);
            $searchResult = ldap_search($this->connection, $this->ldapBaseDn, $filter, $config['attributes']);
            
            if (!$searchResult) {
                error_log("LDAP: Error en búsqueda de usuario con RUT: {$rut}");
                return false;
            }

            $entries = ldap_get_entries($this->connection, $searchResult);
            
            if ($entries['count'] == 0) {
                error_log("LDAP: Usuario con RUT {$rut} no encontrado en Active Directory");
                return false;
            }

            $userDn = $entries[0]['dn'];

            // Intentar autenticar al usuario con su contraseña
            $authResult = ldap_bind($this->connection, $userDn, $password);
            
            if ($authResult) {
                error_log("LDAP: Autenticación exitosa para RUT: {$rut}");
                return [
                    'success' => true,
                    'user' => [
                        'rut' => $rut,
                        'nombre' => $entries[0]['displayname'][0] ?? $entries[0]['cn'][0] ?? '',
                        'email' => $entries[0]['mail'][0] ?? '',
                        'dn' => $userDn
                    ]
                ];
            } else {
                error_log("LDAP: Contraseña incorrecta para RUT: {$rut}");
                return false;
            }

        } catch (\Exception $e) {
            error_log("LDAP: Error durante la autenticación: " . $e->getMessage());
            return false;
        } finally {
            if ($this->connection) {
                ldap_unbind($this->connection);
            }
        }
    }

    /**
     * Verifica si el servidor LDAP está disponible
     */
    public function isServerAvailable()
    {
        if (!$this->connect()) {
            return false;
        }

        try {
            $bindResult = ldap_bind($this->connection, $this->ldapBindDn, $this->ldapBindPassword);
            ldap_unbind($this->connection);
            return $bindResult;
        } catch (\Exception $e) {
            error_log("LDAP: Error verificando disponibilidad del servidor: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene información del usuario desde LDAP
     */
    public function getUserInfo($rut)
    {
        if (!$this->connect()) {
            return false;
        }

        try {
            $bindResult = ldap_bind($this->connection, $this->ldapBindDn, $this->ldapBindPassword);
            
            if (!$bindResult) {
                return false;
            }

            $config = require __DIR__ . '/../config/ldap.php';
            $filter = str_replace('{rut}', $rut, $config['user_filter']);
            $searchResult = ldap_search($this->connection, $this->ldapBaseDn, $filter, $config['attributes']);
            
            if (!$searchResult) {
                return false;
            }

            $entries = ldap_get_entries($this->connection, $searchResult);
            
            if ($entries['count'] == 0) {
                return false;
            }

            return [
                'rut' => $rut,
                'nombre' => $entries[0]['displayname'][0] ?? $entries[0]['cn'][0] ?? '',
                'email' => $entries[0]['mail'][0] ?? '',
                'dn' => $entries[0]['dn']
            ];

        } catch (\Exception $e) {
            error_log("LDAP: Error obteniendo información del usuario: " . $e->getMessage());
            return false;
        } finally {
            if ($this->connection) {
                ldap_unbind($this->connection);
            }
        }
    }
} 