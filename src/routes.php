<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\{
    AuthController,
    CarreraController,
    AsignaturaController,
    BibliografiaController,
    BibliografiaDisponibleController,
    BibliografiaDeclaradaController,
    ReporteController,
    SedeController,
    FacultadController,
    DashboardController
};
use src\Controllers\DepartamentoController;

// Rutas públicas
$app->get('/biblioges/login', [AuthController::class, 'showLogin']);
$app->post('/biblioges/login', [AuthController::class, 'login']);
$app->get('/biblioges/logout', [AuthController::class, 'logout']);

// Rutas protegidas
$app->group('/biblioges', function (RouteCollectorProxy $group) {
    // Dashboard
    $group->get('/dashboard', [DashboardController::class, 'index']);

    // Carreras
    $group->get('/carreras', [CarreraController::class, 'index']);
    $group->get('/carreras/create', [CarreraController::class, 'create']);
    $group->post('/carreras/store', [CarreraController::class, 'store']);
    $group->get('/carreras/{id}', [CarreraController::class, 'show']);
    $group->get('/carreras/{id}/edit', [CarreraController::class, 'edit']);
    $group->post('/carreras/{id}/update', [CarreraController::class, 'update']);
    $group->delete('/carreras/{id}', [CarreraController::class, 'delete']);
    $group->get('/carreras/facultades', [CarreraController::class, 'getFacultadesBySede']);

    // Asignaturas - Rutas específicas primero
    $group->get('/asignaturas/vinculacion', [AsignaturaController::class, 'vinculacion'])->setName('asignaturas.vinculacion');
    $group->get('/asignaturas/vinculacion/{id}', [AsignaturaController::class, 'getVinculacion'])->setName('asignaturas.vinculacion.get');
    $group->post('/asignaturas/vinculacion/{id}/agregar', [AsignaturaController::class, 'agregarVinculacion'])->setName('asignaturas.vinculacion.agregar');
    $group->post('/asignaturas/vinculacion/{id}/quitar', [AsignaturaController::class, 'quitarVinculacion'])->setName('asignaturas.vinculacion.quitar');
    $group->get('/asignaturas/create', [AsignaturaController::class, 'create'])->setName('asignaturas.create');
    $group->get('/asignaturas/{id}/editar', [AsignaturaController::class, 'edit'])->setName('asignaturas.edit');
    $group->post('/asignaturas/{id}/actualizar', [AsignaturaController::class, 'update'])->setName('asignaturas.update');
    
    // Asignaturas - Rutas genéricas después
    $group->get('/asignaturas', [AsignaturaController::class, 'index'])->setName('asignaturas.index');
    $group->get('/asignaturas/{id}', [AsignaturaController::class, 'show'])->setName('asignaturas.show');
    $group->post('/asignaturas', [AsignaturaController::class, 'store'])->setName('asignaturas.store');
    $group->put('/asignaturas/{id}', [AsignaturaController::class, 'update'])->setName('asignaturas.update');
    $group->delete('/asignaturas/{id}', [AsignaturaController::class, 'destroy'])->setName('asignaturas.destroy');

    // Rutas API para Asignaturas
    $group->get('/api/asignaturas', [AsignaturaController::class, 'getAsignaturas']);
    $group->post('/api/asignaturas', [AsignaturaController::class, 'store']);
    $group->put('/api/asignaturas/{id}', [AsignaturaController::class, 'update']);
    $group->delete('/api/asignaturas/{id}', [AsignaturaController::class, 'destroy']);

    // Bibliografías
    $group->get('/bibliografias', [BibliografiaController::class, 'index']);
    $group->get('/bibliografias/{id}', [BibliografiaController::class, 'show']);
    $group->post('/bibliografias', [BibliografiaController::class, 'store']);
    $group->put('/bibliografias/{id}', [BibliografiaController::class, 'update']);
    $group->delete('/bibliografias/{id}', [BibliografiaController::class, 'delete']);

    // Bibliografías Disponibles
    $group->get('/bibliografias-disponibles', [BibliografiaDisponibleController::class, 'index'])->setName('bibliografias_disponibles.index');
    $group->get('/bibliografias-disponibles/create', [BibliografiaDisponibleController::class, 'create'])->setName('bibliografias_disponibles.create');
    $group->post('/bibliografias-disponibles', [BibliografiaDisponibleController::class, 'store'])->setName('bibliografias_disponibles.store');
    $group->get('/bibliografias-disponibles/{id}', [BibliografiaDisponibleController::class, 'show'])->setName('bibliografias_disponibles.show');
    $group->get('/bibliografias-disponibles/{id}/edit', [BibliografiaDisponibleController::class, 'edit'])->setName('bibliografias_disponibles.edit');
    $group->put('/bibliografias-disponibles/{id}', [BibliografiaDisponibleController::class, 'update'])->setName('bibliografias_disponibles.update');
    $group->delete('/bibliografias-disponibles/{id}', [BibliografiaDisponibleController::class, 'destroy'])->setName('bibliografias_disponibles.destroy');

    // Bibliografías Declaradas
    $group->get('/bibliografias-declaradas', [BibliografiaDeclaradaController::class, 'index'])->setName('bibliografias-declaradas.index');
    $group->get('/bibliografias-declaradas/create', [BibliografiaDeclaradaController::class, 'create'])->setName('bibliografias-declaradas.create');
    $group->post('/bibliografias-declaradas', [BibliografiaDeclaradaController::class, 'store'])->setName('bibliografias-declaradas.store');
    $group->get('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'show'])->setName('bibliografias-declaradas.show');
    $group->get('/bibliografias-declaradas/{id}/edit', [BibliografiaDeclaradaController::class, 'edit'])->setName('bibliografias-declaradas.edit');
    $group->put('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'update'])->setName('bibliografias-declaradas.update');
    $group->delete('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'destroy'])->setName('bibliografias-declaradas.destroy');

    // Reportes
    $group->get('/reportes/cobertura-asignatura/{codigo}', [ReporteController::class, 'coberturaAsignatura']);
    $group->get('/reportes/cobertura-carrera/{id}', [ReporteController::class, 'coberturaCarrera']);

    // Rutas para Sedes
    $group->get('/sedes', [SedeController::class, 'index']);
    $group->get('/sedes/create', [SedeController::class, 'create']);
    $group->post('/sedes', [SedeController::class, 'store']);
    $group->get('/sedes/{id}/edit', [SedeController::class, 'edit']);
    $group->put('/sedes/{id}', [SedeController::class, 'update']);
    $group->delete('/sedes/{id}', [SedeController::class, 'destroy']);

    // Rutas para Facultades
    $group->get('/facultades', [FacultadController::class, 'index']);
    $group->get('/facultades/create', [FacultadController::class, 'create']);
    $group->post('/facultades', [FacultadController::class, 'store']);
    $group->get('/facultades/{id}/edit', [FacultadController::class, 'edit']);
    $group->put('/facultades/{id}', [FacultadController::class, 'update']);
    $group->delete('/facultades/{id}', [FacultadController::class, 'destroy']);
    // Rutas para obtener facultades por sede
    $group->get('/facultades/sede/{sede_id}', [FacultadController::class, 'getFacultadesBySede'])->setName('facultades.by.sede');

    // Rutas para Departamentos
    $group->get('/departamentos', [DepartamentoController::class, 'index']);
    $group->get('/departamentos/create', [DepartamentoController::class, 'create']);
    $group->post('/departamentos', [DepartamentoController::class, 'store']);
    $group->get('/departamentos/{id}/edit', [DepartamentoController::class, 'edit']);
    $group->put('/departamentos/{id}', [DepartamentoController::class, 'update']);
    $group->delete('/departamentos/{id}', [DepartamentoController::class, 'destroy']);
    // Rutas para obtener departamentos por facultad
    $group->get('/departamentos/facultad/{facultad_id}', [DepartamentoController::class, 'getDepartamentosByFacultad'])->setName('departamentos.by.facultad');
})->add(new App\Middleware\AuthMiddleware()); 