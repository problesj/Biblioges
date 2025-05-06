<?php

namespace src\Controllers;

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
    public function index()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a los departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener filtros
            $sede_id = $_GET['sede_id'] ?? null;
            $facultad_id = $_GET['facultad_id'] ?? null;
            $estado = $_GET['estado'] ?? null;

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
            $success = $this->session->get('success');
            $error = $this->session->get('error');

            // Limpiar mensajes de sesión
            $this->session->remove('success');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('departamentos/index.twig', [
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
                'current_path' => 'departamentos',
                'success' => $success,
                'error' => $error
            ]);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar los departamentos');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        }
    }

    /**
     * Muestra el formulario de creación de departamento.
     */
    public function create()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para crear departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener facultades para el select
            $facultades = Facultad::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->get('error');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('departamentos/create.twig', [
                'facultades' => $facultades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'departamentos',
                'error' => $error
            ]);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@create: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de creación');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        }
    }

    /**
     * Almacena un nuevo departamento.
     */
    public function store()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para crear departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Validar datos
            $codigo = trim($_POST['codigo'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $facultad_id = $_POST['facultad_id'] ?? null;
            $estado = $_POST['estado'] ?? '1';

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
                $this->session->set('error', implode('. ', $errores));
                header('Location: ' . Config::get('app_url') . 'departamentos/create');
                exit;
            }

            // Crear el departamento
            $departamento = new Departamento();
            $departamento->codigo = strtoupper($codigo); // Convertir a mayúsculas
            $departamento->nombre = ucfirst($nombre); // Primera letra en mayúscula
            $departamento->facultad_id = $facultad_id;
            $departamento->estado = $estado;
            $departamento->save();

            $this->session->set('success', 'Departamento creado exitosamente');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@store: " . $e->getMessage());
            $this->session->set('error', 'Error al crear el departamento: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'departamentos/create');
            exit;
        }
    }

    /**
     * Muestra un departamento específico.
     */
    public function show($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a los departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            $departamento = Departamento::with('facultad')->find($id);
            
            if (!$departamento) {
                $this->session->set('error', 'Departamento no encontrado');
                header('Location: ' . Config::get('app_url') . 'departamentos');
                exit;
            }

            echo $this->twig->render('departamentos/show.twig', [
                'departamento' => $departamento,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'departamentos'
            ]);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@show: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el departamento');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        }
    }

    /**
     * Muestra el formulario de edición de un departamento.
     */
    public function edit($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a los departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener el departamento
            $departamento = Departamento::find($id);
        
            if (!$departamento) {
                $this->session->set('error', 'Departamento no encontrado');
                header('Location: ' . Config::get('app_url') . 'departamentos');
                exit;
            }

            // Obtener facultades
            $facultades = Facultad::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->get('error');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('departamentos/edit.twig', [
                'departamento' => $departamento,
                'facultades' => $facultades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'departamentos',
                'error' => $error
            ]);
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@edit: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de edición');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        }
    }

    /**
     * Actualiza un departamento existente.
     */
    public function update($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a los departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Validar datos
            $codigo = trim($_POST['codigo'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $facultad_id = $_POST['facultad_id'] ?? null;
            $estado = $_POST['estado'] ?? '1';

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
                $this->session->set('error', 'Departamento no encontrado');
                header('Location: ' . Config::get('app_url') . 'departamentos');
                exit;
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

            $this->session->set('success', 'Departamento actualizado exitosamente');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@update: " . $e->getMessage());
            $this->session->set('error', $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'departamentos/' . $id . '/edit');
            exit;
        }
    }

    /**
     * Elimina un departamento.
     */
    public function destroy($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a los departamentos');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener el departamento
            $departamento = Departamento::find($id);
            if (!$departamento) {
                $this->session->set('error', 'Departamento no encontrado');
                header('Location: ' . Config::get('app_url') . 'departamentos');
                exit;
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

                $this->session->set('error', $mensaje);
                header('Location: ' . Config::get('app_url') . 'departamentos');
                exit;
            }

            // Eliminar el departamento
            $departamento->delete();

            $this->session->set('success', 'Departamento eliminado correctamente');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        } catch (\Exception $e) {
            error_log("Error en DepartamentoController@destroy: " . $e->getMessage());
            $this->session->set('error', 'Error al eliminar el departamento');
            header('Location: ' . Config::get('app_url') . 'departamentos');
            exit;
        }
    }
} 