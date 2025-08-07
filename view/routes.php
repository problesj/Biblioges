<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\FrontendController;
use App\Controllers\ReporteController;

/** @var App $app */

// Rutas del frontend (públicas)
$app->get('/', [FrontendController::class, 'index']);
$app->get('/carrera/{sede_id}/{carrera_id}', [FrontendController::class, 'showCarrera']);
$app->get('/asignatura/{sede_id}/{carrera_id}/{asignatura_id}', [FrontendController::class, 'showAsignatura']);

// API endpoints
$app->get('/api/bibliografias-disponibles/{bibliografia_id}', [FrontendController::class, 'apiGetBibliografiasDisponibles']);

 