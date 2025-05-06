<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use App\Core\Config;

class AdminController extends BaseController
{
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
    }

    public function index()
    {
        // Verificar autenticación y rol
        if (!$this->session->get('user_id') || $this->session->get('user_rol') !== 'admin') {
            $this->session->setFlash('error', 'No tienes permisos para acceder a esta sección');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Obtener datos del usuario
        $user = [
            'id' => $this->session->get('user_id'),
            'email' => $this->session->get('user_email'),
            'nombre' => $this->session->get('user_nombre'),
            'rol' => $this->session->get('user_rol')
        ];

        // Renderizar la vista
        echo $this->twig->render('admin/index.twig', [
            'user' => $user,
            'app_url' => Config::get('app_url'),
            'session' => $_SESSION,
            'current_path' => 'admin'
        ]);
    }
} 