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
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;

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