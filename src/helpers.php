<?php

/**
 * Obtiene el valor de una variable de entorno
 * 
 * @param string $key La clave de la variable de entorno
 * @param mixed $default El valor por defecto si la variable no existe
 * @return mixed El valor de la variable de entorno o el valor por defecto
 */
if (!function_exists('env')) {
    function env($key, $default = null) {
        // Buscar en $_ENV primero
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        
        // Buscar en $_SERVER
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
        
        // Buscar usando getenv()
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
        
        return $default;
    }
}

/**
 * Obtiene la URL de la aplicación desde las variables de entorno
 * 
 * @return string La URL de la aplicación
 */
if (!function_exists('app_url')) {
    function app_url() {
        return env('APP_URL', 'https://biblioges.ucn.cl/biblioges/');
    }
}

/**
 * Obtiene el nombre de la aplicación desde las variables de entorno
 * 
 * @return string El nombre de la aplicación
 */
if (!function_exists('app_name')) {
    function app_name() {
        return env('APP_NAME', 'Biblioges');
    }
}

/**
 * Verifica si la aplicación está en modo debug
 * 
 * @return bool True si está en modo debug
 */
if (!function_exists('app_debug')) {
    function app_debug() {
        return env('APP_DEBUG', 'true') === 'true';
    }
} 