<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;

class SessionController extends BaseController
{
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
    }

    public function clearMessages()
    {
        if (!$this->isAjaxRequest()) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
            exit;
        }

        $this->session->remove('success');
        $this->session->remove('error');
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
} 