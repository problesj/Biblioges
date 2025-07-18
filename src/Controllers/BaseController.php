<?php

namespace src\Controllers;

use App\Core\Config;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

class BaseController
{
    protected $twig;
    protected $response;

    public function __construct(Environment $twig, Response $response)
    {
        $this->twig = $twig;
        $this->response = $response;
    }

    /**
     * Redirige a una URL específica.
     *
     * @param Response $response
     * @param string $url
     * @return Response
     */
    protected function redirect(Response $response, string $url): Response
    {
        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Renderiza una vista Twig.
     *
     * @param Response $response
     * @param string $template
     * @param array $data
     * @return Response
     */
    protected function render(Response $response, string $template, array $data = []): Response
    {
        global $twig;
        try {
            // error_log('Renderizando plantilla: ' . $template);
            // error_log('Datos pasados a la plantilla: ' . print_r($data, true));
            
            $content = $twig->render($template, $data);
            // error_log('Plantilla renderizada correctamente');
            
            $response->getBody()->write($content);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
        } catch (\Exception $e) {
            error_log('Error al renderizar la plantilla: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Devuelve una respuesta JSON.
     *
     * @param Response $response
     * @param array $data
     * @return Response
     */
    protected function jsonResponse(Response $response, array $data): Response
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Devuelve una respuesta de error.
     *
     * @param Response $response
     * @param string $message
     * @param int $status
     * @return Response
     */
    protected function errorResponse(Response $response, string $message, int $status = 400): Response
    {
        $response->getBody()->write(json_encode([
            'success' => false,
            'message' => $message
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
} 