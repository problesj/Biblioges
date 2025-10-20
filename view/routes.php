<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\FrontendController;
use App\Controllers\ReporteController;

/** @var App $app */

// Rutas del frontend (públicas)
$app->get('/', [FrontendController::class, 'index'])->setName('frontend.index');
$app->get('/carrera/{sede_id}/{carrera_id}', [FrontendController::class, 'showCarrera'])->setName('frontend.carrera');
$app->get('/asignatura/{sede_id}/{carrera_id}/{asignatura_id}', [FrontendController::class, 'showAsignatura'])->setName('frontend.asignatura');
// Vista pública para solo bibliografía de una asignatura (URL compacta para compartir)
$app->get('/asignatura-biblio/{sede_id}/{asignatura_id}', [FrontendController::class, 'showAsignaturaBibliografia'])->setName('frontend.asignatura_biblio');

// API endpoints
$app->get('/api/bibliografias-disponibles/{bibliografia_id}', [FrontendController::class, 'apiGetBibliografiasDisponibles'])->setName('frontend.api.bibliografias');

// Ruta de prueba para debug
$app->get('/test', function ($request, $response) {
    $response->getBody()->write('Frontend funcionando correctamente');
    return $response;
})->setName('frontend.test');

 