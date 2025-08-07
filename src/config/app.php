<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Crear contenedor DI
$container = new Container();
AppFactory::setContainer($container);

// Configurar contenedor
$container->set('settings', function() {
    return [
        'displayErrorDetails' => $_ENV['APP_DEBUG'] === 'true',
        'logErrorDetails' => true,
        'logErrors' => true,
    ];
});

// Configurar Twig
$container->set('view', require __DIR__ . '/twig.php');

// Configurar mensajes flash
$container->set('flash', function() {
    return new Messages();
});

// Configurar CSRF
$container->set('csrf', function() {
    return new Guard();
});

// Crear aplicación
$app = AppFactory::create();

// Agregar middleware de Twig
$app->add(TwigMiddleware::createFromContainer($app));

// Agregar middleware de CSRF
$app->add($container->get('csrf'));

// Agregar middleware de rutas
require __DIR__ . '/routes.php';

return $app; 