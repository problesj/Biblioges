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

return $twig; 