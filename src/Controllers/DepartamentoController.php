<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Config;
use App\Core\Response as AppResponse;
use src\Models\Departamento;
use src\Models\Facultad;
use src\Models\Usuario;
use src\Models\Sede;

class DepartamentoController
{
    protected $session;
    protected $twig;

    public function __construct()
    {
        $this->session = new Session();
        
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;
    }

    /**
     * Muestra la lista de departamentos.
     */
    public function index($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener filtros
            $sede_id = $request->getQueryParams()['sede_id'] ?? null;
            $facultad_id = $request->getQueryParams()['facultad_id'] ?? null;
            $estado = $request->getQueryParams()['estado'] ?? null;

            // Construir la consulta
            $query = Departamento::with(['facultad.sede'])
                ->join('facultades', 'departamentos.facultad_id', '=', 'facultades.id')
                ->join('sedes', 'facultades.sede_id', '=', 'sedes.id')
                ->select('departamentos.*', 'facultades.nombre as facultad_nombre', 'sedes.nombre as sede_nombre');

            if ($sede_id !== null && $sede_id !== '') {
                $query->where('facultades.sede_id', $sede_id);
            }

            if ($facultad_id !== null && $facultad_id !== '') {
                $query->where('departamentos.facultad_id', $facultad_id);
            }

            if ($estado !== null && $estado !== '') {
                $query->where('departamentos.estado', $estado);
            }

            $departamentos = $query->orderBy('sedes.nombre', 'asc')
                ->orderBy('facultades.nombre', 'asc')
                ->orderBy('departamentos.nombre', 'asc')
                ->get();

            // Obtener facultades y sedes para los filtros
            $facultades = Facultad::orderBy('nombre')->get();
            $sedes = Sede::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de sesión
            $success = $this->session->getFlash('success');
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('departamentos/index.twig', [
                'departamentos' => $departamentos,
                'facultades' => $facultades,
                'sedes' => $sedes,
                'filtros' => [
                    'sede_id' => $sede_id,
                    'facultad_id' => $facultad_id,
                    'estado' => $estado
                ],
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'departamentos',
                'success' => $success,
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@index: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al cargar los departamentos');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        }
    }

    /**
     * Muestra el formulario de creación de departamento.
     */
    public function create($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para crear departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener facultades para el select
            $facultades = Facultad::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('departamentos/create.twig', [
                'facultades' => $facultades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'departamentos',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@create: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al cargar el formulario de creación');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        }
    }

    /**
     * Almacena un nuevo departamento.
     */
    public function store($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para crear departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $codigo = trim($parsedBody['codigo'] ?? '');
            $nombre = trim($parsedBody['nombre'] ?? '');
            $facultad_id = $parsedBody['facultad_id'] ?? null;
            $estado = $parsedBody['estado'] ?? '1';

            // Validaciones
            $errores = [];

            if (empty($codigo)) {
                $errores[] = 'El código del departamento es requerido';
            } elseif (!preg_match('/^[A-Za-z0-9]+$/', $codigo)) {
                $errores[] = 'El código solo puede contener letras y números';
            }

            if (empty($nombre)) {
                $errores[] = 'El nombre del departamento es requerido';
            }

            if (empty($facultad_id)) {
                $errores[] = 'La facultad es requerida';
            } else {
                // Verificar si la facultad existe
                $facultad = Facultad::find($facultad_id);
                if (!$facultad) {
                    $errores[] = 'La facultad seleccionada no existe';
                }
            }

            // Verificar si ya existe un departamento con el mismo código
            if (!empty($codigo)) {
                $existeCodigo = Departamento::where('codigo', $codigo)->exists();
                if ($existeCodigo) {
                    $errores[] = 'Ya existe un departamento con ese código';
                }
            }

            // Verificar si ya existe un departamento con el mismo nombre en la misma facultad
            if (!empty($nombre) && !empty($facultad_id)) {
                $existeNombre = Departamento::where('nombre', $nombre)
                    ->where('facultad_id', $facultad_id)
                    ->exists();
                if ($existeNombre) {
                    $errores[] = 'Ya existe un departamento con ese nombre en la facultad seleccionada';
                }
            }

            // Si hay errores, redirigir al formulario
            if (!empty($errores)) {
                $this->session->setFlash('error', implode('. ', $errores));
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos/create')->withStatus(302);
            }

            // Crear el departamento
            $departamento = new Departamento();
            $departamento->codigo = strtoupper($codigo); // Convertir a mayúsculas
            $departamento->nombre = ucfirst($nombre); // Primera letra en mayúscula
            $departamento->facultad_id = $facultad_id;
            $departamento->estado = $estado;
            $departamento->save();

            $this->session->setFlash('success', 'Departamento creado exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@store: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al crear el departamento');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos/create')->withStatus(302);
        }
    }

    /**
     * Muestra los detalles de un departamento.
     */
    public function show($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->setFlash('error', 'ID de departamento requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Obtener el departamento con sus relaciones
            $departamento = Departamento::with(['facultad.sede'])->find($id);
            if (!$departamento) {
                $this->session->setFlash('error', 'Departamento no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Renderizar la vista
            $body = $this->twig->render('departamentos/show.twig', [
                'departamento' => $departamento,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'departamentos'
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@show: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al cargar el departamento');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        }
    }

    /**
     * Muestra el formulario de edición de un departamento.
     */
    public function edit($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->setFlash('error', 'ID de departamento requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Obtener el departamento
            $departamento = Departamento::find($id);
        
            if (!$departamento) {
                $this->session->setFlash('error', 'Departamento no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Obtener facultades
            $facultades = Facultad::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('departamentos/edit.twig', [
                'departamento' => $departamento,
                'facultades' => $facultades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'departamentos',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@edit: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al cargar el formulario de edición');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        }
    }

    /**
     * Actualiza un departamento existente.
     */
    public function update($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->setFlash('error', 'ID de departamento requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $codigo = trim($parsedBody['codigo'] ?? '');
            $nombre = trim($parsedBody['nombre'] ?? '');
            $facultad_id = $parsedBody['facultad_id'] ?? null;
            $estado = $parsedBody['estado'] ?? '1';

            if (empty($codigo)) {
                throw new \Exception('El código del departamento es requerido');
            }

            if (empty($nombre)) {
                throw new \Exception('El nombre del departamento es requerido');
            }

            if (empty($facultad_id)) {
                throw new \Exception('La facultad es requerida');
            }

            // Obtener el departamento
            $departamento = Departamento::find($id);
            if (!$departamento) {
                $this->session->setFlash('error', 'Departamento no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Verificar si ya existe un departamento con el mismo código (excluyendo el actual)
            $existeCodigo = Departamento::where('codigo', $codigo)
                ->where('id', '!=', $id)
                ->exists();
            if ($existeCodigo) {
                throw new \Exception('Ya existe un departamento con ese código');
            }

            // Verificar si ya existe un departamento con el mismo nombre en la misma facultad (excluyendo el actual)
            $existeNombre = Departamento::where('nombre', $nombre)
                ->where('facultad_id', $facultad_id)
                ->where('id', '!=', $id)
                ->exists();
        
            if ($existeNombre) {
                throw new \Exception('Ya existe un departamento con ese nombre en la facultad seleccionada');
            }

            // Actualizar el departamento
            $departamento->codigo = $codigo;
            $departamento->nombre = $nombre;
            $departamento->facultad_id = $facultad_id;
            $departamento->estado = $estado;
            $departamento->save();

            $this->session->setFlash('success', 'Departamento actualizado exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@update: " . $e->getMessage());
            $this->session->setFlash('error', $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos/' . $id . '/edit')->withStatus(302);
        }
    }

    /**
     * Elimina un departamento.
     */
    public function destroy($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los departamentos');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->setFlash('error', 'ID de departamento requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Obtener el departamento
            $departamento = Departamento::find($id);
            if (!$departamento) {
                $this->session->setFlash('error', 'Departamento no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Verificar si el departamento tiene asignaturas o carreras asociadas
            $asignaturasCount = $departamento->asignaturas()->count();
            $carrerasCount = $departamento->carreras()->count();

            if ($asignaturasCount > 0 || $carrerasCount > 0) {
                $mensaje = "No se permite borrar el departamento {$departamento->nombre}, ya que tiene ";
                if ($asignaturasCount > 0) {
                    $mensaje .= "{$asignaturasCount} asignatura" . ($asignaturasCount > 1 ? 's' : '');
                }
                if ($asignaturasCount > 0 && $carrerasCount > 0) {
                    $mensaje .= " y ";
                }
                if ($carrerasCount > 0) {
                    $mensaje .= "{$carrerasCount} carrera" . ($carrerasCount > 1 ? 's' : '');
                }
                $mensaje .= " vinculada" . (($asignaturasCount + $carrerasCount) > 1 ? 's' : '') . ".";

                $this->session->setFlash('error', $mensaje);
                return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
            }

            // Eliminar el departamento
            $departamento->delete();

            $this->session->setFlash('success', 'Departamento eliminado correctamente');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@destroy: " . $e->getMessage());
            $this->session->setFlash('error', 'Error al eliminar el departamento');
            return $response->withHeader('Location', Config::get('app_url') . 'departamentos')->withStatus(302);
        }
    }

    /**
     * Obtiene los departamentos por facultad (para AJAX).
     */
    public function getDepartamentosByFacultad($request, $response, $args)
    {
        try {
            $facultad_id = $args['facultad_id'] ?? null;
            
            if (!$facultad_id) {
                return $response->withJson(['error' => 'ID de facultad requerido'], 400);
            }

            $departamentos = Departamento::where('facultad_id', $facultad_id)
                ->where('estado', 1)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'codigo']);

            return $response->withJson($departamentos);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@getDepartamentosByFacultad: " . $e->getMessage());
            return $response->withJson(['error' => 'Error al obtener departamentos'], 500);
        }
    }

    /**
     * Obtiene los departamentos por sede y facultad (para AJAX).
     */
    public function getDepartamentosBySedeAndFacultad($request, $response, $args)
    {
        try {
            $sede_id = $args['sedeId'] ?? null;
            $facultad_id = $args['facultadId'] ?? null;
            
            if (!$sede_id || !$facultad_id) {
                $response->getBody()->write(json_encode(['error' => 'ID de sede y facultad requeridos'], JSON_UNESCAPED_UNICODE));
                return $response
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withStatus(400);
            }

            // Verificar que la facultad pertenezca a la sede
            $facultad = Facultad::where('id', $facultad_id)
                ->where('sede_id', $sede_id)
                ->first();

            if (!$facultad) {
                $response->getBody()->write(json_encode(['error' => 'La facultad no pertenece a la sede especificada'], JSON_UNESCAPED_UNICODE));
                return $response
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withStatus(400);
            }

            $departamentos = Departamento::where('facultad_id', $facultad_id)
                ->where('estado', 1)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'codigo']);

            $response->getBody()->write(json_encode($departamentos, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
            
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@getDepartamentosBySedeAndFacultad: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al obtener departamentos'], JSON_UNESCAPED_UNICODE));
            return $response
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(500);
        }
    }
} 