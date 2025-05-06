<?php

namespace App\Core;

class Response
{
    /**
     * Devuelve una respuesta JSON.
     *
     * @param mixed $data
     * @param int $statusCode
     * @return void
     */
    public static function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 