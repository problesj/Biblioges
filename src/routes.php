<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\DashboardController;
use App\Controllers\FacultadController;
use App\Controllers\SedeController;
use App\Controllers\DepartamentoController;
use App\Controllers\AsignaturaController;
use App\Controllers\CarreraController;
use App\Controllers\BibliografiaDeclaradaController;
use App\Controllers\BibliografiaDisponibleController;
use App\Controllers\AutorController;
use App\Controllers\ReporteController;
use App\Controllers\CoberturaController;
use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\SessionController;
use App\Controllers\UsuarioController;
use App\Controllers\TareaProgramadaController;
use App\Middleware\AuthMiddleware;
use App\Controllers\MallaController;

/** @var App $app */

// Rutas públicas
$app->get('/biblioges/login', [AuthController::class, 'showLogin']);
$app->post('/biblioges/login', [AuthController::class, 'login']);
$app->get('/biblioges/logout', [AuthController::class, 'logout']);
$app->get('/login', [AuthController::class, 'showLogin']);
$app->post('/login', [AuthController::class, 'login']);

// Rutas protegidas con middleware de autenticación
$app->group('/biblioges', function (RouteCollectorProxy $group) {
    // Para /biblioges
    $group->get('', function ($request, $response) {
        return $response
            ->withHeader('Location', '/biblioges/login')
            ->withStatus(302);
    });
    // Para /biblioges/
    $group->get('/', function ($request, $response) {
        return $response
            ->withHeader('Location', '/biblioges/login')
            ->withStatus(302);
    });
    // Dashboard
    $group->get('/dashboard', [DashboardController::class, 'index']);

    // Ruta para limpiar mensajes de sesión
    $group->post('/clear-session-messages', [AuthController::class, 'clearSessionMessages']);

    // Sedes
    $group->get('/sedes', [SedeController::class, 'index']);
    $group->get('/sedes/create', [SedeController::class, 'create']);
    $group->post('/sedes/store', [SedeController::class, 'store']);
    $group->get('/sedes/{id}', [SedeController::class, 'show']);
    $group->get('/sedes/{id}/edit', [SedeController::class, 'edit']);
    $group->post('/sedes/{id}/update', [SedeController::class, 'update']);
    $group->post('/sedes/{id}/delete', [SedeController::class, 'destroy']);

    // Rutas de facultades (movidas dentro del grupo protegido)
    $group->get('/facultades', [FacultadController::class, 'index']);
    $group->get('/facultades/create', [FacultadController::class, 'create']);
    $group->post('/facultades/store', [FacultadController::class, 'store']);
    $group->post('/facultades/{id}/delete', [FacultadController::class, 'destroy']);
    $group->get('/facultades/{id}/edit', [FacultadController::class, 'edit']);
    $group->post('/facultades/{id}/update', [FacultadController::class, 'update']);
    $group->get('/facultades/{id}', [FacultadController::class, 'show']);

    // API para obtener facultades por sede (debe ir antes de las rutas CRUD de facultades)
    $group->get('/api/facultades/sede/{sedeId}', [CarreraController::class, 'getFacultadesBySede']);
    $group->get('/api/facultades', [CarreraController::class, 'getFacultadesBySede']);
    
    // API para obtener departamentos por sede y facultad
    $group->get('/api/departamentos/{sedeId}/{facultadId}', [DepartamentoController::class, 'getDepartamentosBySedeAndFacultad']);
    
    // API para obtener asignaturas por departamento
    $group->get('/api/asignaturas/departamento/{departamentoId}', [AsignaturaController::class, 'getAsignaturasByDepartamento']);

    // API para actualizar mallas
    $group->post('/api/mallas/{id}', [MallaController::class, 'update']);

    // Carreras - Rutas específicas primero
    $group->get('/carreras', [CarreraController::class, 'index']);
    $group->get('/carreras/create', [CarreraController::class, 'create']);
    $group->post('/carreras/store', [CarreraController::class, 'store']);
    $group->get('/carreras/{id}/edit', [CarreraController::class, 'edit']);
    $group->post('/carreras/{id}/update', [CarreraController::class, 'update']);
    $group->delete('/carreras/{id}', [CarreraController::class, 'delete']);
    $group->post('/carreras/{id}/delete', [CarreraController::class, 'delete']);
    // Rutas con parámetros al final
    $group->get('/carreras/{id}', [CarreraController::class, 'show']);

    // Mallas - Gestión de asignaturas por carrera
    $group->get('/mallas', [MallaController::class, 'index']);
    $group->get('/mallas/{id}', [MallaController::class, 'show']);
    $group->get('/mallas/{id}/edit', [MallaController::class, 'edit']);
    $group->post('/mallas/{id}/update', [MallaController::class, 'update']);
    $group->post('/mallas/{id}/delete', [MallaController::class, 'delete']);

    // Asignaturas - Rutas específicas primero
    $group->get('/asignaturas/vinculacion', [AsignaturaController::class, 'vinculacion'])->setName('asignaturas.vinculacion');
    $group->get('/asignaturas/vinculacion/{id}', [AsignaturaController::class, 'getVinculacion'])->setName('asignaturas.vinculacion.get');
    $group->post('/asignaturas/vinculacion/{id}/agregar', [AsignaturaController::class, 'agregarVinculacion'])->setName('asignaturas.vinculacion.agregar');
    $group->post('/asignaturas/vinculacion/{id}/quitar', [AsignaturaController::class, 'quitarVinculacion'])->setName('asignaturas.vinculacion.quitar');
    $group->get('/asignaturas/create', [AsignaturaController::class, 'create'])->setName('asignaturas.create');
    $group->post('/asignaturas', [AsignaturaController::class, 'store'])->setName('asignaturas.store');
    $group->get('/asignaturas/{id}/edit', [AsignaturaController::class, 'edit'])->setName('asignaturas.edit');
    $group->post('/asignaturas/{id}/update', [AsignaturaController::class, 'update'])->setName('asignaturas.update');
    $group->post('/asignaturas/{id}/delete', [AsignaturaController::class, 'destroy'])->setName('asignaturas.destroy');
    
    // Asignaturas - Rutas genéricas después
    $group->get('/asignaturas', [AsignaturaController::class, 'index'])->setName('asignaturas.index');
    $group->get('/asignaturas/{id}', [AsignaturaController::class, 'show'])->setName('asignaturas.show');

    // Rutas API para Asignaturas
    $group->get('/api/asignaturas', [AsignaturaController::class, 'getAsignaturas']);
    $group->post('/api/asignaturas', [AsignaturaController::class, 'store']);
    $group->put('/api/asignaturas/{id}', [AsignaturaController::class, 'update']);
    $group->delete('/api/asignaturas/{id}', [AsignaturaController::class, 'destroy']);

    // Rutas para Bibliografías Disponibles
    $group->group('/bibliografias-disponibles', function (RouteCollectorProxy $group) {
        $group->get('', [BibliografiaDisponibleController::class, 'index']);
        $group->get('/create', [BibliografiaDisponibleController::class, 'create']);
        $group->post('', [BibliografiaDisponibleController::class, 'store']);
        $group->get('/{id}', [BibliografiaDisponibleController::class, 'show']);
        $group->get('/{id}/edit', [BibliografiaDisponibleController::class, 'edit']);
        $group->put('/{id}', [BibliografiaDisponibleController::class, 'update']);
        $group->post('/{id}/update', [BibliografiaDisponibleController::class, 'update']);
        $group->delete('/{id}', [BibliografiaDisponibleController::class, 'destroy']);
        $group->post('/{id}/delete', [BibliografiaDisponibleController::class, 'destroy']);
        $group->post('/{id}/vincular', [BibliografiaDisponibleController::class, 'vincularBibliografiaDisponible']);
    });

    // Bibliografías Declaradas
    $group->get('/bibliografias-declaradas', [BibliografiaDeclaradaController::class, 'index'])->setName('bibliografias-declaradas.index');
    $group->get('/bibliografias-declaradas/create', [BibliografiaDeclaradaController::class, 'create'])->setName('bibliografias-declaradas.create');
    $group->post('/bibliografias-declaradas', [BibliografiaDeclaradaController::class, 'store'])->setName('bibliografias-declaradas.store');
    $group->post('/bibliografias-declaradas/forzar', [BibliografiaDeclaradaController::class, 'storeForzar'])->setName('bibliografias-declaradas.storeForzar');
    $group->get('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'show'])->setName('bibliografias-declaradas.show');
    $group->get('/bibliografias-declaradas/{id}/edit', [BibliografiaDeclaradaController::class, 'edit'])->setName('bibliografias-declaradas.edit');
    $group->put('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'update'])->setName('bibliografias-declaradas.update');
    $group->delete('/bibliografias-declaradas/{id}', [BibliografiaDeclaradaController::class, 'destroy'])->setName('bibliografias-declaradas.destroy');
    $group->post('/bibliografias-declaradas/{id}/delete', [BibliografiaDeclaradaController::class, 'destroy'])->setName('bibliografias-declaradas.destroy.post');

    // Rutas para vincular asignaturas
    $group->get('/bibliografias-declaradas/{id}/vincular', [BibliografiaDeclaradaController::class, 'vincular'])->setName('bibliografias-declaradas.vincular');
    $group->post('/bibliografias-declaradas/{id}/vincularMultiple', [BibliografiaDeclaradaController::class, 'vincularMultiple'])->setName('bibliografias-declaradas.vincularMultiple');
    $group->post('/bibliografias-declaradas/{id}/desvincularMultiple', [BibliografiaDeclaradaController::class, 'desvincularMultiple'])->setName('bibliografias-declaradas.desvincularMultiple');
    $group->post('/bibliografias-declaradas/{id}/vincularSingle', [BibliografiaDeclaradaController::class, 'vincularSingle'])->setName('bibliografias-declaradas.vincularSingle');
    $group->post('/bibliografias-declaradas/{id}/desvincularSingle/{vinculacionId}', [BibliografiaDeclaradaController::class, 'desvincularSingle'])->setName('bibliografias-declaradas.desvincularSingle');

    // Rutas para búsqueda en catálogo
    $group->get('/bibliografias-declaradas/{id}/buscarCatalogo', [BibliografiaDeclaradaController::class, 'buscarCatalogo']);
    $group->post('/bibliografias-declaradas/{id}/buscarCatalogo/api', [BibliografiaDeclaradaController::class, 'apiBuscarCatalogo']);
    $group->post('/bibliografias-declaradas/{id}/guardar-seleccionadas', [BibliografiaDeclaradaController::class, 'guardarBibliografiasSeleccionadas']);

    // Rutas para el módulo de autores
    $group->get('/autores', [src\Controllers\AutorController::class, 'index']);
    $group->get('/autores/create', [src\Controllers\AutorController::class, 'create']);
    $group->post('/autores/store', [src\Controllers\AutorController::class, 'store']);
    $group->get('/autores/{id}/duplicados', [src\Controllers\AutorController::class, 'duplicados']);
    $group->get('/autores/{id}/edit', [src\Controllers\AutorController::class, 'edit']);
    $group->put('/autores/{id}', [src\Controllers\AutorController::class, 'update']);
    $group->post('/autores/{id}/update', [src\Controllers\AutorController::class, 'update']);
    $group->delete('/autores/{id}', [src\Controllers\AutorController::class, 'destroy']);
    $group->post('/autores/{id}/delete', [src\Controllers\AutorController::class, 'destroy']);
    $group->post('/autores/{id}/fusionar', [src\Controllers\AutorController::class, 'fusionar']);
    $group->get('/autores/duplicados-globales', [src\Controllers\AutorController::class, 'buscarDuplicadosGlobales']);
    $group->post('/autores/fusionar-grupo', [src\Controllers\AutorController::class, 'fusionarGrupo']);
    $group->post('/autores/{id}/fusionar/{duplicado_id}', [src\Controllers\AutorController::class, 'fusionar']);

    // Rutas para Departamentos
    $group->get('/departamentos', [DepartamentoController::class, 'index']);
    $group->get('/departamentos/create', [DepartamentoController::class, 'create']);
    $group->post('/departamentos', [DepartamentoController::class, 'store']);
    $group->get('/departamentos/{id}', [DepartamentoController::class, 'show']);
    $group->get('/departamentos/{id}/edit', [DepartamentoController::class, 'edit']);
    $group->post('/departamentos/{id}/update', [DepartamentoController::class, 'update']);
    $group->post('/departamentos/{id}/delete', [DepartamentoController::class, 'destroy']);
    // Rutas para obtener departamentos por facultad
    $group->get('/departamentos/facultad/{facultad_id}', [DepartamentoController::class, 'getDepartamentosByFacultad'])->setName('departamentos.by.facultad');

    // Rutas para Usuarios
    $group->get('/usuarios', [UsuarioController::class, 'index']);
    $group->get('/usuarios/create', [UsuarioController::class, 'create']);
    $group->post('/usuarios', [UsuarioController::class, 'store']);
    $group->get('/usuarios/{id}', [UsuarioController::class, 'show']);
    $group->get('/usuarios/{id}/edit', [UsuarioController::class, 'edit']);
    $group->put('/usuarios/{id}', [UsuarioController::class, 'update']);
    $group->post('/usuarios/{id}/update', [UsuarioController::class, 'update']);
    $group->delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
    $group->post('/usuarios/{id}/delete', [UsuarioController::class, 'destroy']);
    $group->post('/usuarios/{id}/change-status', [UsuarioController::class, 'changeStatus']);

    // Rutas para Reportes
    $group->get('/reportes/bibliografias', [ReporteController::class, 'bibliografias']);
    $group->get('/reportes/listado-bibliografias', [ReporteController::class, 'bibliografiasDeclaradas']);
    $group->get('/reportes/listado-bibliografias/data', [ReporteController::class, 'getBibliografiasDeclaradas']);
    $group->get('/reportes/listado-bibliografias/exportar', [ReporteController::class, 'exportarBibliografiasDeclaradas']);
    
    // Ruta de prueba para debug
    $group->get('/test-reporte', function ($request, $response) {
        $response->getBody()->write("Test de reporte funcionando correctamente");
        return $response->withHeader('Content-Type', 'text/html');
    });
    $group->get('/reportes/ejemplares', [ReporteController::class, 'ejemplares']);
    $group->get('/reportes/estudiantes', [ReporteController::class, 'estudiantes']);
    $group->get('/reportes/profesores', [ReporteController::class, 'profesores']);
    $group->get('/reportes/asignaturas', [ReporteController::class, 'asignaturas']);
    $group->get('/reportes/carreras', [ReporteController::class, 'carreras']);
    $group->get('/reportes/autores', [ReporteController::class, 'autores']);
    $group->get('/reportes/editoriales', [ReporteController::class, 'editoriales']);
    $group->get('/reportes/cobertura', [ReporteController::class, 'cobertura']);
    $group->get('/reportes/cobertura/asignaturas-formacion/{carreraId}', [ReporteController::class, 'getAsignaturasFormacion']);
    $group->post('/reportes/cobertura/generar-reporte', [ReporteController::class, 'generarReporteCobertura']);
    $group->get('/reportes/cobertura/asignatura/{codigo}', [ReporteController::class, 'coberturaAsignatura']);
    $group->get('/reportes/cobertura/carrera/{id}', [ReporteController::class, 'coberturaCarrera']);
    $group->get('/reportes/coberturas', [ReporteController::class, 'coberturaBasica']);
    $group->get('/reportes/coberturas/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaBasica']);
    $group->get('/reportes/coberturas/{sede_id}/{carrera_id}/{asignatura_codigo}', [ReporteController::class, 'reporteTitulosBibliografiaBasica']);
    $group->get('/reportes/coberturas-expandido/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaBasicaExpandido']);
    $group->get('/reportes/coberturas-excel/{sede_id}/{carrera_id}', [ReporteController::class, 'exportarBibliografiaBasicaExcel']);
    $group->get('/reportes/coberturas-expandido-excel/{sede_id}/{carrera_id}', [ReporteController::class, 'exportarBibliografiaBasicaExpandidoExcel']);
    $group->post('/reportes/guardar-cobertura-basica/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarCoberturaBasica']);
    $group->post('/reportes/guardar-filtros-formacion/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarFiltrosFormacion']);
    $group->get('/reportes/cargar-filtros-formacion/{sede_id}/{carrera_id}', [ReporteController::class, 'cargarFiltrosFormacion']);

    // Rutas para Cobertura Complementaria
    $group->get('/reportes/coberturas-complementaria', [ReporteController::class, 'coberturaComplementaria']);
    $group->get('/reportes/coberturas-complementaria/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaComplementaria']);
    $group->get('/reportes/coberturas-complementaria/{sede_id}/{carrera_id}/{asignatura_codigo}', [ReporteController::class, 'reporteTitulosBibliografiaComplementaria']);
    $group->get('/reportes/coberturas-complementaria-expandido/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaComplementariaExpandido']);
    $group->get('/reportes/coberturas-complementaria-excel/{sede_id}/{carrera_id}', [ReporteController::class, 'exportarBibliografiaComplementariaExcel']);
    $group->get('/reportes/coberturas-complementaria-expandido-excel/{sede_id}/{carrera_id}', [ReporteController::class, 'exportarBibliografiaComplementariaExpandidoExcel']);
    $group->post('/reportes/guardar-cobertura-complementaria/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarCoberturaComplementaria']);

    // Rutas para Tareas Programadas
    $group->get('/tareas-programadas', [TareaProgramadaController::class, 'index']);
    $group->post('/tareas-programadas', [TareaProgramadaController::class, 'crear']);
    $group->get('/tareas-programadas/listar', [TareaProgramadaController::class, 'listar']);
    $group->post('/tareas-programadas/{id}/cancelar', [TareaProgramadaController::class, 'cancelar']);
    
    // Ruta para ejecutar tareas pendientes (para cron)
    $group->post('/tareas-programadas/ejecutar', [TareaProgramadaController::class, 'ejecutarTareasPendientes']);

    // Redirección para evitar error Not found en /reportes/login
    // $group->get('/reportes/login', function ($request, $response) {
    //     return $response
    //         ->withHeader('Location', '/biblioges/login')
    //         ->withStatus(302);
    // });
})->add(new AuthMiddleware()); 