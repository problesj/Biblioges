<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class BaseController
{
    protected $twig;
    protected $session;

    public function __construct()
    {
        // Configurar Twig
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../../cache',
            'auto_reload' => true
        ]);

        // Agregar función url a Twig
        $this->twig->addFunction(new TwigFunction('url', function ($path) {
            return Config::get('app_url') . ltrim($path, '/');
        }));

        // Agregar variable global app_url
        $this->twig->addGlobal('app_url', Config::get('app_url'));

        // Inicializar la sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->session = new Session();
    }

    protected function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect($url)
    {
        $baseUrl = Config::get('app_url');
        $fullUrl = $baseUrl . ltrim($url, '/');
        header("Location: $fullUrl");
        exit;
    }
} 