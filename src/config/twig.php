<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

// Configuración de Twig
$loader = new FilesystemLoader(__DIR__ . '/../../templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../../cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Agregar extensión de depuración
$twig->addExtension(new DebugExtension());

// Agregar funciones globales
$twig->addGlobal('session', $_SESSION ?? []);
$twig->addGlobal('request', $_REQUEST ?? []);

// Funciones helper para manejo de estado de listados
$twig->addFunction(new \Twig\TwigFunction('build_sort_url', function($column, $currentSort, $currentDirection, $filtros, $currentPage = null, $perPage = null) {
    $params = array_merge($filtros, ['page' => 1]);
    
    if ($currentSort === $column) {
        $params['sort'] = $column;
        $params['direction'] = $currentDirection === 'ASC' ? 'DESC' : 'ASC';
    } else {
        $params['sort'] = $column;
        $params['direction'] = 'ASC';
    }
    
    if ($perPage !== null) {
        $params['per_page'] = $perPage;
    }
    
    return '?' . http_build_query(array_filter($params, function($value) {
        return $value !== '' && $value !== null;
    }));
}));

$twig->addFunction(new \Twig\TwigFunction('get_sort_icon', function($column, $currentSort, $currentDirection) {
    if ($currentSort !== $column) {
        return 'fa-sort';
    }
    return $currentDirection === 'ASC' ? 'fa-sort-up' : 'fa-sort-down';
}));

$twig->addFunction(new \Twig\TwigFunction('build_page_url', function($page, $currentSort, $currentDirection, $filtros, $perPage) {
    $params = array_merge($filtros, [
        'page' => $page,
        'sort' => $currentSort,
        'direction' => $currentDirection,
        'per_page' => $perPage
    ]);
    
    return '?' . http_build_query(array_filter($params, function($value) {
        return $value !== '' && $value !== null;
    }));
}));

$twig->addFunction(new \Twig\TwigFunction('build_per_page_url', function($perPage, $filtros, $currentSort, $currentDirection) {
    $params = array_merge($filtros, [
        'page' => 1,
        'sort' => $currentSort,
        'direction' => $currentDirection,
        'per_page' => $perPage
    ]);
    
    return '?' . http_build_query(array_filter($params, function($value) {
        return $value !== '' && $value !== null;
    }));
}));

// Función para generar token CSRF
$twig->addFunction(new \Twig\TwigFunction('csrf_token', function() {
    // Obtener el token CSRF del middleware de Slim
    if (isset($_SESSION['csrf'])) {
        return $_SESSION['csrf']['name'] . ':' . $_SESSION['csrf']['value'];
    }
    // Fallback si no hay token CSRF configurado
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}));

return $twig; 