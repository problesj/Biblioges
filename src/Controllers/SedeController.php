<?php

namespace App\Controllers;

use src\Models\Sede;
use src\Models\Usuario;
use src\Models\CarreraEspejo;
use App\Core\Session;
use App\Core\Config;
use Illuminate\Support\Facades\DB;

class SedeController
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

    public function index()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener filtros
            $estado = $_GET['estado'] ?? null;

            // Construir la consulta
            $query = Sede::query();

            if ($estado !== null && $estado !== '') {
                $query->where('estado', $estado);
            }

            $sedes = $query->orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Obtener mensajes de sesión
            $success = $this->session->get('success');
            $error = $this->session->get('error');

            // Renderizar la vista
            echo $this->twig->render('sedes/index.twig', [
                'sedes' => $sedes,
                'filtros' => [
                    'estado' => $estado
                ],
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'sedes',
                'success' => $success,
                'error' => $error
            ]);
        } catch (\Exception $e) {
            error_log("Error en SedeController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar las sedes');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;
        }
    }

    public function create()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            echo $this->twig->render('sedes/create.twig', [
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'sedes'
            ]);
        } catch (\Exception $e) {
            error_log("Error en SedeController@create: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de creación de sede');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;
        }
    }

    public function store()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Validar datos
            $codigo = $_POST['codigo'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 0;

            if (empty($codigo) || empty($nombre)) {
                $this->session->set('error', 'Todos los campos son obligatorios');
                header('Location: ' . Config::get('app_url') . 'sedes/create');
                exit;
            }

            // Crear nueva sede
            $sede = new Sede();
            $sede->codigo = $codigo;
            $sede->nombre = $nombre;
            $sede->estado = $estado;
            $sede->save();

            $this->session->set('success', 'Sede creada correctamente');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;
        } catch (\Exception $e) {
            error_log("Error en SedeController@store: " . $e->getMessage());
            $this->session->set('error', 'Error al crear la sede');
            header('Location: ' . Config::get('app_url') . 'sedes/create');
            exit;
        }
    }

    public function edit($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener la sede
            $sede = Sede::find($id);

            if (!$sede) {
                $this->session->set('error', 'Sede no encontrada');
                header('Location: ' . Config::get('app_url') . 'sedes');
                exit;
            }

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            echo $this->twig->render('sedes/edit.twig', [
                'sede' => $sede,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'sedes'
            ]);
        } catch (\Exception $e) {
            error_log("Error en SedeController@edit: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar la sede');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;
        }
    }

    public function update($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Validar datos
            $codigo = $_POST['codigo'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 0;

            error_log("Datos recibidos - Código: $codigo, Nombre: $nombre, Estado: $estado");

            if (empty($codigo) || empty($nombre)) {
                $this->session->set('error', 'Todos los campos son obligatorios');
                header('Location: ' . Config::get('app_url') . "sedes/{$id}/edit");
                exit;
            }

            // Obtener la sede
            $sede = Sede::find($id);
            if (!$sede) {
                $this->session->set('error', 'Sede no encontrada');
                header('Location: ' . Config::get('app_url') . 'sedes');
                exit;
            }

            error_log("Sede encontrada - ID: {$sede->id}, Código actual: {$sede->codigo}, Nombre actual: {$sede->nombre}, Estado actual: {$sede->estado}");

            // Actualizar la sede
            $sede->codigo = $codigo;
            $sede->nombre = $nombre;
            $sede->estado = $estado;

            error_log("Intentando guardar cambios...");
            $resultado = $sede->save();
            error_log("Resultado del guardado: " . ($resultado ? "éxito" : "fallo"));
            error_log("Estado después del guardado: " . $sede->estado);

            if (!$resultado) {
                error_log("Error al guardar: " . print_r($sede->getErrors(), true));
                throw new \Exception("Error al guardar los cambios");
            }

            $this->session->set('success', 'Sede actualizada correctamente');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;

        } catch (\Exception $e) {
            error_log("Error en SedeController@update: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al actualizar la sede: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . "sedes/{$id}/edit");
            exit;
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las sedes');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener la sede
            $sede = Sede::find($id);
            if (!$sede) {
                $this->session->set('error', 'Sede no encontrada');
                header('Location: ' . Config::get('app_url') . 'sedes');
                exit;
            }

            // Verificar si la sede tiene facultades asociadas
            $facultadesCount = $sede->facultades()->count();

            // Verificar si la sede tiene carreras asociadas a través de carreras_espejos
            $carrerasCount = CarreraEspejo::where('sede_id', $id)->count();

            if ($facultadesCount > 0 || $carrerasCount > 0) {
                $mensaje = "No se permite borrar la sede {$sede->nombre}, ya que tiene ";
                if ($facultadesCount > 0) {
                    $mensaje .= "{$facultadesCount} facultad" . ($facultadesCount > 1 ? 'es' : '');
                }
                if ($facultadesCount > 0 && $carrerasCount > 0) {
                    $mensaje .= " y ";
                }
                if ($carrerasCount > 0) {
                    $mensaje .= "{$carrerasCount} carrera" . ($carrerasCount > 1 ? 's' : '');
                }
                $mensaje .= " vinculada" . (($facultadesCount + $carrerasCount) > 1 ? 's' : '') . ".";

                $this->session->set('error', $mensaje);
                header('Location: ' . Config::get('app_url') . 'sedes');
                exit;
            }

            // Eliminar la sede
            $resultado = $sede->delete();

            if (!$resultado) {
                throw new \Exception("Error al eliminar la sede");
            }

            $this->session->set('success', 'Sede eliminada correctamente');
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;

        } catch (\Exception $e) {
            error_log("Error en SedeController@destroy: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al eliminar la sede: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'sedes');
            exit;
        }
    }
} 