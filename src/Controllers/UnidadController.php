<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Config;
use App\Models\Unidad;
use App\Models\SedeSimple as Sede;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;
use PDOException;

/**
 * Controlador para manejar las operaciones de unidades
 */
class UnidadController
{
    protected $session;
    protected $twig;
    protected $pdo;
    private $unidadModel;
    private $sedeModel;

    public function __construct()
    {
        $this->session = new Session();
        
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
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
        
        $this->unidadModel = new Unidad($this->pdo);
        $this->sedeModel = new Sede($this->pdo);
        
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;
    }

    /**
     * Verificar si una unidad es la unidad "Sin Unidad" protegida
     */
    private function esUnidadProtegida($unidad)
    {
        return $unidad['codigo'] === 'SIN_UNIDAD' || $unidad['nombre'] === 'Sin unidad';
    }

    /**
     * Mostrar lista de unidades
     */
    public function index(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener filtros
            $queryParams = $request->getQueryParams();
            $sede = $queryParams['sede'] ?? null;
            $estado = $queryParams['estado'] ?? null;

            // Obtener unidades con información de sede y padre
            $unidades = $this->unidadModel->getAllWithPadre($estado);
            $sedes = $this->sedeModel->getAll();
            $stats = $this->unidadModel->getStats();

            // Mapear nombres de campos para la vista y obtener unidades hijas
            foreach ($unidades as &$unidad) {
                if (isset($unidad['nombre_sede'])) {
                    $unidad['sede_nombre'] = $unidad['nombre_sede'];
                }
                if (isset($unidad['nombre_unidad_padre'])) {
                    $unidad['unidad_padre_nombre'] = $unidad['nombre_unidad_padre'];
                } else {
                    $unidad['unidad_padre_nombre'] = null;
                }
                
                // Obtener unidades hijas para cada unidad
                $unidadesHijas = $this->unidadModel->getUnidadesHijas($unidad['codigo']);
                $unidad['unidades_hijas'] = $unidadesHijas;
                $unidad['cantidad_hijas'] = count($unidadesHijas);
            }
            unset($unidad);

            // Filtrar por sede si se especifica
            if ($sede) {
                $unidades = array_filter($unidades, function($unidad) use ($sede) {
                    return $unidad['sede_id'] == $sede;
                });
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('unidades/index.twig', [
                    'unidades' => $unidades,
                    'sedes' => $sedes,
                'stats' => $stats,
                'filtros' => [
                    'sede' => $sede,
                    'estado' => $estado
                ],
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'unidades'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@index: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar las unidades'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);
        }
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            $sedes = $this->sedeModel->getAll();
            $unidadesPadre = $this->unidadModel->getUnidadesPadre();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('unidades/create.twig', [
                    'sedes' => $sedes,
                'unidades_padre' => $unidadesPadre,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'unidades',
                'old' => $this->session->get('old') ?? []
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@create: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar el formulario de creación de unidad'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);
        }
    }

    /**
     * Guardar nueva unidad
     */
    public function store(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $data = [
                'codigo' => trim($parsedBody['codigo'] ?? ''),
                'nombre' => trim($parsedBody['nombre'] ?? ''),
                'sede_id' => $parsedBody['sede_id'] ?? '',
                'id_unidad_padre' => !empty($parsedBody['id_unidad_padre']) ? $parsedBody['id_unidad_padre'] : null,
                'descripcion' => trim($parsedBody['descripcion'] ?? ''),
                'estado' => isset($parsedBody['estado']) ? (int)$parsedBody['estado'] : 1
            ];

            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Campos Requeridos',
                    'text' => 'Los campos código, nombre y sede son obligatorios'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/create')
                    ->withStatus(302);
            }

            // Verificar si el código ya existe
            $unidadExistente = $this->unidadModel->getByCodigo($data['codigo']);
            if ($unidadExistente) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Código Duplicado',
                    'text' => 'El código de unidad ya existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/create')
                    ->withStatus(302);
            }

            // Validar que la sede existe
            $sede = $this->sedeModel->getById($data['sede_id']);
            if (!$sede) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Sede Inválida',
                    'text' => 'La sede seleccionada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/create')
                    ->withStatus(302);
            }

            // Validar unidad padre si se proporciona
            if (!empty($data['id_unidad_padre'])) {
                $unidadPadre = $this->unidadModel->getByCodigo($data['id_unidad_padre']);
                if (!$unidadPadre) {
                    $this->session->set('old', $data);
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Unidad Padre Inválida',
                        'text' => 'La unidad padre seleccionada no existe'
                    ]);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'unidades/create')
                        ->withStatus(302);
                }
            }

            // Crear la unidad
            $unidadId = $this->unidadModel->create($data);

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => 'Unidad Creada',
                'text' => 'La unidad ha sido creada exitosamente'
            ]);

            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);

        } catch (\Exception $e) {
            // error_log("Error en UnidadController@store: " . $e->getMessage());
            $this->session->set('old', $data ?? []);
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al crear la unidad: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades/create')
                ->withStatus(302);
        }
    }

    /**
     * Mostrar unidad específica
     */
    public function show(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'ID de unidad no proporcionado'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Unidad No Encontrada',
                    'text' => 'La unidad especificada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Obtener información adicional
            $sede = $this->sedeModel->getById($unidad['sede_id']);
            $unidad['sede_nombre'] = $sede['nombre'] ?? 'N/A';

            if ($unidad['id_unidad_padre']) {
                $unidadPadre = $this->unidadModel->getByCodigo($unidad['id_unidad_padre']);
                $unidad['unidad_padre_nombre'] = $unidadPadre['nombre'] ?? 'N/A';
            }

            // Obtener unidades hijas si las tiene
            $unidadesHijas = $this->unidadModel->getUnidadesHijas($unidad['codigo']);

            // Obtener jerarquía completa
            $jerarquia = $this->unidadModel->getJerarquia($id);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('unidades/show.twig', [
                    'unidad' => $unidad,
                    'unidades_hijas' => $unidadesHijas,
                'jerarquia' => $jerarquia,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'unidades'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@show: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar los detalles de la unidad'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'ID de unidad no proporcionado'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Unidad No Encontrada',
                    'text' => 'La unidad especificada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Verificar si es la unidad "Sin Unidad" protegida
            if ($this->esUnidadProtegida($unidad)) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Unidad Protegida',
                    'text' => 'La unidad "Sin Unidad" no puede ser editada'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            $sedes = $this->sedeModel->getAll();
            $unidadesPadre = $this->unidadModel->getUnidadesPadre();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('unidades/edit.twig', [
                    'unidad' => $unidad,
                    'sedes' => $sedes,
                'unidades_padre' => $unidadesPadre,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'unidades',
                'old' => $this->session->get('old') ?? []
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@edit: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar el formulario de edición de unidad'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);
        }
    }

    /**
     * Actualizar unidad
     */
    public function update(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'ID de unidad no proporcionado'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Verificar que la unidad existe
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Unidad No Encontrada',
                    'text' => 'La unidad especificada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Verificar si es la unidad "Sin Unidad" protegida
            if ($this->esUnidadProtegida($unidad)) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Unidad Protegida',
                    'text' => 'La unidad "Sin Unidad" no puede ser modificada'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $data = [
                'codigo' => trim($parsedBody['codigo'] ?? ''),
                'nombre' => trim($parsedBody['nombre'] ?? ''),
                'sede_id' => $parsedBody['sede_id'] ?? '',
                'id_unidad_padre' => !empty($parsedBody['id_unidad_padre']) ? $parsedBody['id_unidad_padre'] : null,
                'descripcion' => trim($parsedBody['descripcion'] ?? ''),
                'estado' => isset($parsedBody['estado']) ? (int)$parsedBody['estado'] : 1
                ];

            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Campos Requeridos',
                    'text' => 'Los campos código, nombre y sede son obligatorios'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                    ->withStatus(302);
            }

            // Verificar si el código ya existe (excluyendo la unidad actual)
            $unidadExistente = $this->unidadModel->getByCodigo($data['codigo']);
            if ($unidadExistente && $unidadExistente['id'] != $id) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Código Duplicado',
                    'text' => 'El código de unidad ya existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                    ->withStatus(302);
            }

            // Validar que la sede existe
            $sede = $this->sedeModel->getById($data['sede_id']);
            if (!$sede) {
                $this->session->set('old', $data);
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Sede Inválida',
                    'text' => 'La sede seleccionada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                    ->withStatus(302);
            }

            // Validar unidad padre si se proporciona
            if (!empty($data['id_unidad_padre'])) {
                $unidadPadre = $this->unidadModel->getByCodigo($data['id_unidad_padre']);
                if (!$unidadPadre) {
                    $this->session->set('old', $data);
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Unidad Padre Inválida',
                        'text' => 'La unidad padre seleccionada no existe'
                    ]);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                        ->withStatus(302);
                }

                // Evitar referencias circulares
                if ($data['id_unidad_padre'] == $unidad['codigo']) {
                    $this->session->set('old', $data);
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Referencia Circular',
                        'text' => 'Una unidad no puede ser padre de sí misma'
                    ]);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                        ->withStatus(302);
                }
            }

            // Actualizar la unidad
            $this->unidadModel->update($id, $data);

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => 'Unidad Actualizada',
                'text' => 'La unidad ha sido actualizada exitosamente'
            ]);

            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id)
                ->withStatus(302);

        } catch (\Exception $e) {
            // error_log("Error en UnidadController@update: " . $e->getMessage());
            $this->session->set('old', $data ?? []);
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al actualizar la unidad: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades/' . $id . '/edit')
                ->withStatus(302);
        }
    }

    /**
     * Eliminar unidad
     */
    public function destroy(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las unidades'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'ID de unidad no proporcionado'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Verificar que la unidad existe
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Unidad No Encontrada',
                    'text' => 'La unidad especificada no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Verificar si es la unidad "Sin Unidad" protegida
            if ($this->esUnidadProtegida($unidad)) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Unidad Protegida',
                    'text' => 'La unidad "Sin Unidad" no puede ser eliminada'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'unidades')
                    ->withStatus(302);
            }

            // Eliminar la unidad
            $this->unidadModel->delete($id);

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => 'Unidad Eliminada',
                'text' => 'La unidad "' . $unidad['nombre'] . '" ha sido eliminada exitosamente'
            ]);

            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);

        } catch (\Exception $e) {
            // error_log("Error en UnidadController@destroy: " . $e->getMessage());
            
            // Manejar errores específicos de validación
            $errorMessage = $e->getMessage();
            $icon = 'error';
            $title = 'Error al Eliminar';
            
            if (strpos($errorMessage, 'unidades hijas') !== false) {
                $icon = 'warning';
                $title = 'No se puede eliminar';
                $errorMessage = 'No se puede eliminar la unidad porque tiene unidades hijas asociadas. Primero debe eliminar o reasignar las unidades hijas.';
            } elseif (strpos($errorMessage, 'asociada a asignaturas') !== false) {
                $icon = 'warning';
                $title = 'No se puede eliminar';
                $errorMessage = 'No se puede eliminar la unidad porque está asociada a asignaturas. Primero debe desvincular las asignaturas de esta unidad.';
            } elseif (strpos($errorMessage, 'asociada a carreras') !== false) {
                $icon = 'warning';
                $title = 'No se puede eliminar';
                $errorMessage = 'No se puede eliminar la unidad porque está asociada a carreras. Primero debe desvincular las carreras de esta unidad.';
            }
            
            $this->session->set('swal', [
                'icon' => $icon,
                'title' => $title,
                'text' => $errorMessage
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'unidades')
                ->withStatus(302);
        }
    }

    /**
     * Buscar unidades
     */
    public function search($term)
    {
        try {
            $unidades = $this->unidadModel->search($term);

            return [
                'success' => true,
                'data' => $unidades
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al buscar unidades: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener unidades por sede
     */
    public function getBySede($sedeId)
    {
        try {
            $unidades = $this->unidadModel->getBySede($sedeId, 1); // Solo activas

            return [
                'success' => true,
                'data' => $unidades
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener unidades por sede: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener unidades padre (API)
     */
    public function getUnidadesPadre(Request $request, Response $response, array $args = [])
    {
        try {
            $sedeId = $args['sedeId'] ?? null;
            $unidadesPadre = $this->unidadModel->getUnidadesPadre($sedeId);

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => $unidadesPadre
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@getUnidadesPadre: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Error al obtener unidades padre: ' . $e->getMessage()
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtener unidades hijas
     */
    public function getUnidadesHijas($codigoUnidadPadre)
    {
        try {
            $unidadesHijas = $this->unidadModel->getUnidadesHijas($codigoUnidadPadre);

            return [
                'success' => true,
                'data' => $unidadesHijas
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener unidades hijas: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener estadísticas
     */
    public function getStats()
    {
        try {
            $stats = $this->unidadModel->getStats();

            return [
                'success' => true,
                'data' => $stats
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verificar relaciones de una unidad antes de eliminar (API)
     */
    public function verificarRelaciones(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Error de autenticación'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $id = $args['id'] ?? null;
            if (!$id) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'ID de unidad no proporcionado'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Verificar que la unidad existe
            $unidad = $this->unidadModel->getById($id);
            if (!$unidad) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Unidad no encontrada'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Obtener relaciones detalladas
            $relaciones = $this->unidadModel->getRelacionesDetalladas($id);

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => [
                    'unidad' => $unidad,
                    'relaciones' => $relaciones,
                    'puede_eliminar' => empty($relaciones['unidades_hijas']) && 
                                       empty($relaciones['asignaturas']) && 
                                       empty($relaciones['carreras'])
                ]
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            // error_log("Error en UnidadController@verificarRelaciones: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Error al verificar relaciones: ' . $e->getMessage()
            ]));
            
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
} 