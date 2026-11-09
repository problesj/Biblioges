<?php

namespace App\Controllers;

use App\Services\DuplicadosDeclaradas;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Controllers\BaseController;

/**
 * Detección y resolución de bibliografías declaradas duplicadas.
 */
class DeclaradasDuplicadasController extends BaseController
{
    public function __construct()
    {
        global $twig;
        parent::__construct($twig, new \Slim\Psr7\Response());
    }

    public function index(Request $request, Response $response): Response
    {
        try {
            $grupos = (new DuplicadosDeclaradas())->grupos();
        } catch (\Throwable $e) {
            error_log('DeclaradasDuplicadasController@index: ' . $e->getMessage());

            return $this->errorResponse($response, 'Error al buscar bibliografías duplicadas', 500);
        }

        return $this->render($response, 'bibliografias_declaradas/duplicadas.twig', [
            'grupos' => $grupos,
            'total_declaradas' => array_sum(array_map('count', $grupos)),
            'session' => $_SESSION ?? [],
            'app_url' => app_url(),
            'current_page' => 'bibliografias-declaradas',
        ]);
    }

    public function previsualizar(Request $request, Response $response): Response
    {
        return $this->ejecutar($response, fn () => ['success' => true, 'resumen' => (new DuplicadosDeclaradas())->previsualizar($this->leerAcciones($request))]);
    }

    public function resolver(Request $request, Response $response): Response
    {
        $usuario = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;

        return $this->ejecutar($response, fn () => ['success' => true, 'resumen' => (new DuplicadosDeclaradas())->resolver($this->leerAcciones($request), $usuario)]);
    }

    private function leerAcciones(Request $request): array
    {
        $datos = json_decode((string) $request->getBody(), true);
        if (!is_array($datos['acciones'] ?? null)) {
            throw new \InvalidArgumentException('No hay cambios para aplicar');
        }

        return $datos['acciones'];
    }

    private function ejecutar(Response $response, callable $accion): Response
    {
        try {
            return $this->json($response, $accion());
        } catch (\InvalidArgumentException $e) {
            return $this->json($response, ['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            error_log('DeclaradasDuplicadasController: ' . $e->getMessage());
            // Disparador que impide vincular asignaturas de formación electiva
            if (strpos($e->getMessage(), 'FORMACION_ELECTIVA') !== false) {
                return $this->json($response, ['success' => false, 'message' => 'No se aplicó ningún cambio: hay un vínculo con una asignatura de formación electiva, que el sistema no permite traspasar.'], 422);
            }

            return $this->json($response, ['success' => false, 'message' => 'No se aplicó ningún cambio: ocurrió un error al procesar el grupo.'], 500);
        }
    }

    private function json(Response $response, array $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
