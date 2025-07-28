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
 * Obtiene la URL base de la aplicación
 */
function app_url($path = '')
{
    $baseUrl = $_ENV['APP_URL'] ?? 'https://biblioges.ucn.cl/biblioges/';
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

/**
 * Construye una URL con parámetros de consulta para ordenamiento y paginación
 */
function build_url_with_params($base_url, $params = [])
{
    $query = http_build_query($params);
    return $base_url . ($query ? '?' . $query : '');
}

/**
 * Construye una URL para ordenamiento de columnas
 */
function build_sort_url($column, $current_sort = '', $current_direction = 'ASC', $filters = [], $page = 1, $perPage = 10)
{
    $direction = ($current_sort === $column && $current_direction === 'ASC') ? 'DESC' : 'ASC';
    
    $params = array_merge($filters, [
        'sort' => $column,
        'direction' => $direction
    ]);
    
    if ($page > 1) {
        $params['page'] = $page;
    }
    
    if ($perPage != 10) {
        $params['per_page'] = $perPage;
    }
    
    // Detectar la sección actual basándose en la URL
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $pathWithoutQuery = strtok($currentPath, '?');
    $pathParts = explode('/', trim($pathWithoutQuery, '/'));
    $currentSection = end($pathParts);
    
    // Determinar la sección correcta
    if ($currentSection === 'asignaturas') {
        $section = 'asignaturas';
    } elseif ($currentSection === 'bibliografias-declaradas') {
        $section = 'bibliografias-declaradas';
    } elseif ($currentSection === 'mallas') {
        $section = 'mallas';
    } else {
        $section = 'carreras'; // Por defecto
    }
    
    return build_url_with_params(app_url($section), $params);
}

/**
 * Construye una URL para paginación
 */
function build_page_url($page, $sort = '', $direction = 'ASC', $filters = [], $perPage = 10)
{
    $params = $filters;
    
    if ($sort) {
        $params['sort'] = $sort;
    }
    
    if ($direction) {
        $params['direction'] = $direction;
    }
    
    if ($page > 1) {
        $params['page'] = $page;
    }
    
    if ($perPage != 10) {
        $params['per_page'] = $perPage;
    }
    
    // Detectar la sección actual basándose en la URL
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $pathWithoutQuery = strtok($currentPath, '?');
    $pathParts = explode('/', trim($pathWithoutQuery, '/'));
    $currentSection = end($pathParts);
    
    // Determinar la sección correcta
    if ($currentSection === 'asignaturas') {
        $section = 'asignaturas';
    } elseif ($currentSection === 'bibliografias-declaradas') {
        $section = 'bibliografias-declaradas';
    } elseif ($currentSection === 'mallas') {
        $section = 'mallas';
    } else {
        $section = 'carreras'; // Por defecto
    }
    
    return build_url_with_params(app_url($section), $params);
}

/**
 * Obtiene el ícono de ordenamiento para una columna
 */
function get_sort_icon($column, $current_sort, $current_direction)
{
    if ($current_sort === $column) {
        return $current_direction === 'ASC' ? 'fa-sort-up' : 'fa-sort-down';
    }
    return 'fa-sort';
}

/**
 * Construye una URL para cambiar el número de registros por página
 */
function build_per_page_url($perPage, $sort = '', $direction = 'ASC', $filters = [], $page = 1)
{
    $params = $filters;
    
    if ($sort) {
        $params['sort'] = $sort;
    }
    
    if ($direction) {
        $params['direction'] = $direction;
    }
    
    if ($perPage != 10) {
        $params['per_page'] = $perPage;
    }
    
    if ($page > 1) {
        $params['page'] = $page;
    }
    
    // Detectar la sección actual basándose en la URL
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $pathWithoutQuery = strtok($currentPath, '?');
    $pathParts = explode('/', trim($pathWithoutQuery, '/'));
    $currentSection = end($pathParts);
    
    // Determinar la sección correcta
    if ($currentSection === 'asignaturas') {
        $section = 'asignaturas';
    } elseif ($currentSection === 'bibliografias-declaradas') {
        $section = 'bibliografias-declaradas';
    } elseif ($currentSection === 'mallas') {
        $section = 'mallas';
    } else {
        $section = 'carreras'; // Por defecto
    }
    
    return build_url_with_params(app_url($section), $params);
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