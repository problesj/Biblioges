<?php

namespace App\Controllers;

use src\Models\Facultad;
use src\Models\Sede;
use src\Models\Usuario;
use App\Core\Session;
use App\Core\Config;
use PDO;
use PDOException;
use App\Core\Response;

class FacultadController
{
    protected $session;
    protected $twig;
    protected $db;

    public function __construct()
    {
        $this->session = new Session();
        
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;

        // Configuración de la base de datos
        $dbConfig = [
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'dbname' => $_ENV['DB_DATABASE'] ?? 'biblioges',
            'user' => $_ENV['DB_USERNAME'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? ''
        ];

        try {
            $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset=utf8mb4";
            $this->db = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener filtros
            $estado = $_GET['estado'] ?? null;
            $sede_id = $_GET['sede_id'] ?? null;

            // Construir la consulta
            $query = Facultad::with('sede')
                ->join('sedes', 'facultades.sede_id', '=', 'sedes.id')
                ->select('facultades.*')
                ->orderBy('sedes.nombre', 'asc')
                ->orderBy('facultades.nombre', 'asc');

            if ($estado !== null && $estado !== '') {
                $query->where('facultades.estado', $estado);
            }

            if ($sede_id !== null && $sede_id !== '') {
                $query->where('facultades.sede_id', $sede_id);
            }

            $facultades = $query->get();

            // Obtener todas las sedes para el filtro
            $sedes = Sede::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Obtener mensajes de sesión
            $success = $this->session->get('success');
            $error = $this->session->get('error');

            // Renderizar la vista
            echo $this->twig->render('facultades/index.twig', [
                'facultades' => $facultades,
                'sedes' => $sedes,
                'filtros' => [
                    'estado' => $estado,
                    'sede_id' => $sede_id
                ],
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'facultades',
                'success' => $success,
                'error' => $error
            ]);
        } catch (\Exception $e) {
            error_log("Error en FacultadController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar las facultades');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        }
    }

    public function create()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener todas las sedes
            $sedes = Sede::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            echo $this->twig->render('facultades/create.twig', [
                'sedes' => $sedes,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'facultades'
            ]);
        } catch (\Exception $e) {
            error_log("Error en FacultadController@create: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de creación de facultad');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        }
    }

    public function store()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Validar datos
            $codigo = $_POST['codigo'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $sede_id = $_POST['sede_id'] ?? '';
            $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 0;

            if (empty($codigo) || empty($nombre) || empty($sede_id)) {
                $this->session->set('error', 'Todos los campos son obligatorios');
                header('Location: ' . Config::get('app_url') . 'facultades/create');
                exit;
            }

            // Crear nueva facultad
            $facultad = new Facultad();
            $facultad->codigo = $codigo;
            $facultad->nombre = $nombre;
            $facultad->sede_id = $sede_id;
            $facultad->estado = $estado;
            
            if (!$facultad->save()) {
                throw new \Exception("Error al guardar la facultad");
            }

            $this->session->set('success', 'Facultad creada correctamente');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        } catch (\Exception $e) {
            error_log("Error en FacultadController@store: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al crear la facultad: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'facultades/create');
            exit;
        }
    }

    public function edit($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener la facultad
            $facultad = Facultad::find($id);

            if (!$facultad) {
                $this->session->set('error', 'Facultad no encontrada');
                header('Location: ' . Config::get('app_url') . 'facultades');
                exit;
            }

            // Obtener todas las sedes
            $sedes = Sede::orderBy('nombre')->get();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            echo $this->twig->render('facultades/edit.twig', [
                'facultad' => $facultad,
                'sedes' => $sedes,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_path' => 'facultades'
            ]);
        } catch (\Exception $e) {
            error_log("Error en FacultadController@edit: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al cargar la facultad');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        }
    }

    public function update($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener la facultad
            $facultad = Facultad::find($id);
            if (!$facultad) {
                $this->session->set('error', 'Facultad no encontrada');
                header('Location: ' . Config::get('app_url') . 'facultades');
                exit;
            }

            // Validar datos
            $codigo = $_POST['codigo'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $sede_id = $_POST['sede_id'] ?? '';
            $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 0;

            if (empty($codigo) || empty($nombre) || empty($sede_id)) {
                $this->session->set('error', 'Todos los campos son obligatorios');
                header('Location: ' . Config::get('app_url') . "facultades/{$id}/edit");
                exit;
            }

            // Actualizar la facultad
            $facultad->codigo = $codigo;
            $facultad->nombre = $nombre;
            $facultad->sede_id = $sede_id;
            $facultad->estado = $estado;

            if (!$facultad->save()) {
                throw new \Exception("Error al guardar los cambios");
            }

            $this->session->set('success', 'Facultad actualizada correctamente');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        } catch (\Exception $e) {
            error_log("Error en FacultadController@update: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al actualizar la facultad: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . "facultades/{$id}/edit");
            exit;
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las facultades');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener la facultad
            $facultad = Facultad::find($id);
            if (!$facultad) {
                $this->session->set('error', 'Facultad no encontrada');
                header('Location: ' . Config::get('app_url') . 'facultades');
                exit;
            }

            // Verificar si la facultad tiene departamentos asociados
            $departamentosCount = $facultad->departamentos()->count();

            // Verificar si la facultad tiene carreras asociadas
            $carrerasCount = 0;
            try {
            $carrerasCount = $facultad->carreras()->count();
            } catch (\Exception $e) {
                error_log("Error al verificar carreras: " . $e->getMessage());
                // Si hay error al verificar carreras, asumimos que no hay carreras asociadas
            }

            if ($departamentosCount > 0 || $carrerasCount > 0) {
                $mensaje = "No se permite borrar la facultad {$facultad->nombre}, ya que tiene ";
                if ($departamentosCount > 0) {
                    $mensaje .= "{$departamentosCount} departamento" . ($departamentosCount > 1 ? 's' : '');
                }
                if ($departamentosCount > 0 && $carrerasCount > 0) {
                    $mensaje .= " y ";
                }
                if ($carrerasCount > 0) {
                    $mensaje .= "{$carrerasCount} carrera" . ($carrerasCount > 1 ? 's' : '');
                }
                $mensaje .= " vinculada" . (($departamentosCount + $carrerasCount) > 1 ? 's' : '') . ".";

                // Obtener datos necesarios para la vista
                $facultades = Facultad::with('sede')
                    ->join('sedes', 'facultades.sede_id', '=', 'sedes.id')
                    ->select('facultades.*')
                    ->orderBy('sedes.nombre', 'asc')
                    ->orderBy('facultades.nombre', 'asc')
                    ->get();

                $sedes = Sede::orderBy('nombre')->get();
                $usuarioModel = new Usuario();
                $user = $usuarioModel->find($this->session->get('user_id'));

                // Renderizar la vista directamente con el mensaje de error
                echo $this->twig->render('facultades/index.twig', [
                    'facultades' => $facultades,
                    'sedes' => $sedes,
                    'filtros' => [
                        'estado' => null,
                        'sede_id' => null
                    ],
                    'user' => $user,
                    'app_url' => Config::get('app_url'),
                    'session' => $_SESSION,
                    'current_path' => 'facultades',
                    'error' => $mensaje
                ]);
                exit;
            }

            // Eliminar la facultad
            $resultado = $facultad->delete();

            if (!$resultado) {
                throw new \Exception("Error al eliminar la facultad");
            }

            $this->session->set('success', 'Facultad eliminada correctamente');
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        } catch (\Exception $e) {
            error_log("Error en FacultadController@destroy: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('error', 'Error al eliminar la facultad: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'facultades');
            exit;
        }
    }

    public function getFacultadesBySede($sede_id)
    {
        try {
            // Verificar que el ID de la sede sea válido
            if (!is_numeric($sede_id)) {
                return Response::json([
                    'message' => 'ID de sede inválido',
                    'error' => 'El ID de la sede debe ser un número'
                ], 400);
            }

            // Consultar las facultades
            $stmt = $this->db->prepare("
                SELECT id, nombre 
                FROM facultades 
                WHERE sede_id = ? AND estado = 1 
                ORDER BY nombre
            ");
            $stmt->execute([$sede_id]);
            $facultades = $stmt->fetchAll();

            // Retornar directamente el array de facultades
            return Response::json($facultades);
        } catch (\Exception $e) {
            error_log("Error en FacultadController@getFacultadesBySede: " . $e->getMessage());
            return Response::json([
                'message' => 'Error al obtener las facultades',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 