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
use App\Controllers\UnidadController;
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

    // Unidades
    $group->get('/unidades', [UnidadController::class, 'index']);
    $group->get('/unidades/create', [UnidadController::class, 'create']);
    $group->post('/unidades/store', [UnidadController::class, 'store']);
    $group->get('/unidades/{id}', [UnidadController::class, 'show']);
    $group->get('/unidades/{id}/edit', [UnidadController::class, 'edit']);
    $group->post('/unidades/{id}/update', [UnidadController::class, 'update']);
    $group->post('/unidades/{id}/delete', [UnidadController::class, 'destroy']);
    $group->get('/unidades/{id}/verificar-relaciones', [UnidadController::class, 'verificarRelaciones']);

    // API para obtener unidades por sede
    $group->get('/api/unidades/sede/{sedeId}', [ApiController::class, 'getUnidadesBySede']);
    $group->get('/api/unidades', [ApiController::class, 'getUnidadesBySede']);
    
    // API para obtener unidades hijas
    $group->get('/api/unidades/hijas/{unidadId}', [ApiController::class, 'getUnidadesHijas']);
    
    // API para obtener unidades padre por sede
    $group->get('/api/unidades/padre/{sedeId}', [UnidadController::class, 'getUnidadesPadre']);
    
    // API para obtener departamentos por sede y facultad
    $group->get('/api/departamentos/{sedeId}/{facultadId}', [DepartamentoController::class, 'getDepartamentosBySedeAndFacultad']);
    
    // API para obtener asignaturas por unidad
    $group->get('/api/asignaturas/unidad/{unidadId}', [AsignaturaController::class, 'getAsignaturasByUnidad']);

    // API para mallas - Rutas específicas primero (antes de las variables)
    $group->post('/api/mallas/bibliografias-fusion', [MallaController::class, 'getBibliografiasParaFusion']);
    $group->post('/api/mallas/mallas-vinculadas-fusion', [MallaController::class, 'getMallasVinculadasParaFusion']);
    $group->post('/api/mallas/procesar-fusion', [MallaController::class, 'procesarFusionAsignaturas']);
    
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
    $group->get('/carreras/clear-state', [CarreraController::class, 'clearState']);
    $group->delete('/carreras/{carrera_id}/codigos/{codigo_id}', [CarreraController::class, 'deleteCodigo']);
    $group->post('/carreras/{carrera_id}/codigos/{codigo_id}/delete', [CarreraController::class, 'deleteCodigo']);
    // Rutas con parámetros al final
    $group->get('/carreras/{id}', [CarreraController::class, 'show']);

    // Mallas - Gestión de asignaturas por carrera
    $group->get('/mallas', [MallaController::class, 'index']);
    $group->get('/mallas/clear-state', [MallaController::class, 'clearState']);
    $group->get('/mallas/{id}', [MallaController::class, 'show']);
    $group->get('/mallas/{id}/edit', [MallaController::class, 'edit']);
    $group->post('/mallas/{id}/update', [MallaController::class, 'update']);
    $group->post('/mallas/{id}/delete', [MallaController::class, 'delete']);
    
    // Fusión de asignaturas
    $group->get('/mallas/{carrera_id}/fusion-asignaturas', [MallaController::class, 'showFusionAsignaturas']);

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
    $group->get('/asignaturas/clear-state', [AsignaturaController::class, 'clearState'])->setName('asignaturas.clear-state');
    
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
        $group->get('/clear-state', [BibliografiaDisponibleController::class, 'clearState']);
        $group->get('/create', [BibliografiaDisponibleController::class, 'create']);
        $group->post('', [BibliografiaDisponibleController::class, 'store']);
        $group->post('/{id}/delete', [BibliografiaDisponibleController::class, 'destroy']);
        $group->post('/{id}/update', [BibliografiaDisponibleController::class, 'update']);
        $group->post('/{id}/vincular', [BibliografiaDisponibleController::class, 'vincularBibliografiaDisponible']);
        $group->get('/{id}/edit', [BibliografiaDisponibleController::class, 'edit']);
        $group->put('/{id}', [BibliografiaDisponibleController::class, 'update']);
        $group->delete('/{id}', [BibliografiaDisponibleController::class, 'destroy']);
        $group->post('/{id}', [BibliografiaDisponibleController::class, 'destroy']);
        $group->get('/{id}', [BibliografiaDisponibleController::class, 'show']);
    });

    // Bibliografías Declaradas
    $group->get('/bibliografias-declaradas', [BibliografiaDeclaradaController::class, 'index'])->setName('bibliografias-declaradas.index');
    $group->get('/bibliografias-declaradas/clear-state', [BibliografiaDeclaradaController::class, 'clearState'])->setName('bibliografias-declaradas.clear-state');
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
    $group->get('/bibliografias-declaradas/{id}/vincular/ajax', [BibliografiaDeclaradaController::class, 'vincularAjax'])->setName('bibliografias-declaradas.vincularAjax');
    $group->post('/bibliografias-declaradas/{id}/vincularMultiple', [BibliografiaDeclaradaController::class, 'vincularMultiple'])->setName('bibliografias-declaradas.vincularMultiple');
    $group->post('/bibliografias-declaradas/{id}/desvincularMultiple', [BibliografiaDeclaradaController::class, 'desvincularMultiple'])->setName('bibliografias-declaradas.desvincularMultiple');
    $group->post('/bibliografias-declaradas/{id}/vincularSingle', [BibliografiaDeclaradaController::class, 'vincularSingle'])->setName('bibliografias-declaradas.vincularSingle');
    $group->post('/bibliografias-declaradas/{id}/desvincularSingle/{vinculacionId}', [BibliografiaDeclaradaController::class, 'desvincularSingle'])->setName('bibliografias-declaradas.desvincularSingle');

    // Rutas para búsqueda en catálogo
    $group->get('/bibliografias-declaradas/{id}/buscarCatalogo', [BibliografiaDeclaradaController::class, 'buscarCatalogo']);
    $group->post('/bibliografias-declaradas/{id}/buscarCatalogo/api', [BibliografiaDeclaradaController::class, 'apiBuscarCatalogo']);
    $group->post('/bibliografias-declaradas/{id}/buscarGoogle/api', [BibliografiaDeclaradaController::class, 'apiBuscarGoogle']);
$group->post('/bibliografias-declaradas/{id}/guardar-seleccionadas', [BibliografiaDeclaradaController::class, 'guardarBibliografiasSeleccionadas']);

// API para obtener bibliografías disponibles de una bibliografía declarada
$group->get('/api/bibliografias-declaradas/{id}/disponibles', [BibliografiaDeclaradaController::class, 'getBibliografiasDisponibles']);

    // Rutas para el módulo de autores
    $group->get('/autores', [src\Controllers\AutorController::class, 'index']);
    $group->get('/autores/create', [src\Controllers\AutorController::class, 'create']);
    $group->post('/autores/store', [src\Controllers\AutorController::class, 'store']);
    $group->get('/autores/{id}/duplicados', [src\Controllers\AutorController::class, 'duplicados']);
    $group->get('/autores/{id}/edit', [src\Controllers\AutorController::class, 'edit']);
    $group->put('/autores/{id}', [src\Controllers\AutorController::class, 'update']);
    $group->post('/autores/{id}/update', [src\Controllers\AutorController::class, 'update']);
    
    // Rutas para alias de autores
    $group->get('/autores/{id}/variaciones', [src\Controllers\AutorController::class, 'mostrarVariaciones']);
    $group->post('/autores/{id}/variaciones', [src\Controllers\AutorController::class, 'agregarVariacion']);
    $group->delete('/autores/{autor_id}/variaciones/{alias_id}', [src\Controllers\AutorController::class, 'eliminarVariacion']);
    $group->post('/autores/{autor_id}/variaciones/{alias_id}/delete', [src\Controllers\AutorController::class, 'eliminarVariacion']);
    $group->get('/autores/buscar-variacion', [src\Controllers\AutorController::class, 'buscarPorVariacion']);
    
    // Rutas para fusión mejorada de duplicados
    $group->post('/autores/buscar-variaciones-fusion', [src\Controllers\AutorController::class, 'buscarVariacionesFusion']);
    $group->delete('/autores/{id}', [src\Controllers\AutorController::class, 'destroy']);
    $group->post('/autores/{id}/delete', [src\Controllers\AutorController::class, 'destroy']);
    $group->post('/autores/{id}/fusionar', [src\Controllers\AutorController::class, 'fusionar']);
    $group->get('/autores/duplicados-globales', [src\Controllers\AutorController::class, 'buscarDuplicadosGlobales']);
    $group->post('/autores/fusionar-grupo', [src\Controllers\AutorController::class, 'fusionarGrupo']);
    $group->post('/autores/{id}/fusionar/{duplicado_id}', [src\Controllers\AutorController::class, 'fusionar']);
    
    // API para obtener progreso de búsqueda de duplicados
    $group->get('/autores/progreso-duplicados', [src\Controllers\AutorController::class, 'obtenerProgresoDuplicados']);
    
    // API para iniciar búsqueda de duplicados globales
    $group->post('/autores/iniciar-busqueda-duplicados', [src\Controllers\AutorController::class, 'iniciarBusquedaDuplicados']);

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
    $group->get('/reportes/listado-bibliografias/clear-state', [ReporteController::class, 'clearStateBibliografias']);
    $group->get('/reportes/listado-bibliografias/data', [ReporteController::class, 'getBibliografiasDeclaradas']);
    $group->get('/reportes/listado-bibliografias/exportar', [ReporteController::class, 'exportarBibliografiasDeclaradas']);
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
    $group->get('/reportes/coberturas/clear-state', [ReporteController::class, 'clearState']);
    $group->get('/reportes/coberturas-excel', [ReporteController::class, 'exportarCoberturasExcel']);
    $group->get('/reportes/coberturas/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaBasica']);
    $group->get('/reportes/coberturas/{sede_id}/{carrera_id}/{asignatura_codigo}', [ReporteController::class, 'reporteTitulosBibliografiaBasica']);
    $group->get('/reportes/coberturas-expandido/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaBasicaExpandido']);
    $group->get('/reportes/coberturas-excel/{sede_id}/{carrera_id}', function ($request, $response, $args) {
        global $twig;
        $controller = new \App\Controllers\ReporteController();
        return $controller->exportarBibliografiaBasicaExcel($request, $response, $args);
    });
    $group->get('/reportes/coberturas-expandido-excel/{sede_id}/{carrera_id}', function ($request, $response, $args) {
        global $twig;
        $controller = new \App\Controllers\ReporteController();
        return $controller->exportarBibliografiaBasicaExpandidoExcel($request, $response, $args);
    });
    $group->post('/reportes/guardar-cobertura-basica/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarCoberturaBasica']);
    $group->post('/reportes/guardar-filtros-formacion/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarFiltrosFormacion']);
    $group->get('/reportes/cargar-filtros-formacion/{sede_id}/{carrera_id}', [ReporteController::class, 'cargarFiltrosFormacion']);

    // Rutas para Cobertura Complementaria
    $group->get('/reportes/coberturas-complementaria', [ReporteController::class, 'coberturaComplementaria']);
    $group->get('/reportes/coberturas-complementaria/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaComplementaria']);
    $group->get('/reportes/coberturas-complementaria/{sede_id}/{carrera_id}/{asignatura_codigo}', [ReporteController::class, 'reporteTitulosBibliografiaComplementaria']);
    $group->get('/reportes/coberturas-complementaria-expandido/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteBibliografiaComplementariaExpandido']);
    $group->get('/reportes/coberturas-complementaria-excel/{sede_id}/{carrera_id}', function ($request, $response, $args) {
        global $twig;
        $controller = new \App\Controllers\ReporteController();
        return $controller->exportarBibliografiaComplementariaExcel($request, $response, $args);
    });
    $group->get('/reportes/coberturas-complementaria-expandido-excel/{sede_id}/{carrera_id}', function ($request, $response, $args) {
        global $twig;
        $controller = new \App\Controllers\ReporteController();
        return $controller->exportarBibliografiaComplementariaExpandidoExcel($request, $response, $args);
    });
    $group->post('/reportes/guardar-cobertura-complementaria/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarCoberturaComplementaria']);

    // Rutas para Reporte Fusionado de Coberturas
    $group->get('/reportes/coberturas-fusionado/{sede_id}/{carrera_id}', [ReporteController::class, 'reporteCoberturasFusionado']);
    $group->get('/reportes/coberturas-fusionado-excel/{sede_id}/{carrera_id}', [ReporteController::class, 'exportarCoberturasFusionadoExcel']);
    $group->post('/reportes/guardar-cobertura-fusionado/{sede_id}/{carrera_id}', [ReporteController::class, 'guardarCoberturaFusionado']);

    // Rutas para Tareas Programadas
    $group->get('/tareas-programadas', [TareaProgramadaController::class, 'index']);
    $group->post('/tareas-programadas', [TareaProgramadaController::class, 'crear']);
    $group->get('/tareas-programadas/listar', [TareaProgramadaController::class, 'listar']);
    $group->post('/tareas-programadas/{id}/cancelar', [TareaProgramadaController::class, 'cancelar']);
    
    // Ruta para ejecutar tareas pendientes (para cron)
    $group->post('/tareas-programadas/ejecutar', [TareaProgramadaController::class, 'ejecutarTareasPendientes']);

    // API para actualizar el perfil del usuario autenticado
    $group->post('/perfil/actualizar', [UsuarioController::class, 'actualizarPerfil']);

    // API para cambiar la contraseña del usuario autenticado
    $group->post('/perfil/cambiar-password', [UsuarioController::class, 'actualizarPassword']);

    // Ruta para el perfil de usuario autenticado (debe ir al final para evitar conflictos)
    $group->get('/perfil', [UsuarioController::class, 'perfil']);
})->add(new AuthMiddleware()); 