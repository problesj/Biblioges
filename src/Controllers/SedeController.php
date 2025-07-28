<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Config;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class SedeController
{
    protected $session;
    protected $twig;
    protected $pdo;

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
        
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;
    }

    public function index(Request $request, Response $response, array $args = [])
    {
        error_log('SedeController@index: Iniciando método');
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos de sesión
            $sessionData = [
                'user_id' => $this->session->get('user_id'),
                'user_email' => $this->session->get('user_email'),
                'user_nombre' => $this->session->get('user_nombre'),
                'user_rol' => $this->session->get('user_rol')
            ];

            // Parámetros de paginación y ordenamiento
            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = intval($_GET['per_page'] ?? 10);
            
            // Validar opciones de registros por página
            $allowedPerPage = [5, 10, 15, 20];
            if (!in_array($perPage, $allowedPerPage)) {
                $perPage = 10;
            }
            
            $offset = ($page - 1) * $perPage;
            
            // Parámetros de ordenamiento
            $sortColumn = $_GET['sort'] ?? 'nombre';
            $sortDirection = strtoupper($_GET['direction'] ?? 'ASC');
            
            // Validar columnas permitidas para ordenamiento
            $allowedColumns = ['codigo', 'nombre', 'estado'];
            if (!in_array($sortColumn, $allowedColumns)) {
                $sortColumn = 'nombre';
            }
            
            // Validar dirección de ordenamiento
            if (!in_array($sortDirection, ['ASC', 'DESC'])) {
                $sortDirection = 'ASC';
            }
            
            // Construir la consulta base para contar total de registros
            $countSql = "SELECT COUNT(*) as total FROM sedes WHERE 1=1";
            
            // Construir la consulta principal
            $sql = "SELECT * FROM sedes WHERE 1=1";
            
            $params = [];
            
            // Aplicar filtros si existen
            if (isset($_GET['estado']) && $_GET['estado'] !== '') {
                $sql .= " AND estado = ?";
                $countSql .= " AND estado = ?";
                $params[] = $_GET['estado'];
            }
            
            // Obtener total de registros
            $stmt = $this->pdo->prepare($countSql);
            $stmt->execute($params);
            $totalRecords = $stmt->fetch()['total'];
            
            // Calcular información de paginación
            $totalPages = ceil($totalRecords / $perPage);
            $currentPage = $page;
            
            // Agregar ORDER BY y LIMIT a la consulta principal
            $sql .= " ORDER BY {$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $sedes = $stmt->fetchAll(\PDO::FETCH_OBJ);
            
            error_log('SedeController@index: Total sedes encontradas: ' . count($sedes));

            // Obtener mensajes de sesión y limpiarlos
            $success = $this->session->get('success');
            $error = $this->session->get('error');
            
            // Limpiar mensajes de sesión después de obtenerlos
            $this->session->remove('success');
            $this->session->remove('error');

            // Renderizar la vista
            $html = $this->twig->render('sedes/index.twig', [
                'sedes' => $sedes,
                'session' => $sessionData,
                'app_url' => Config::get('app_url'),
                'current_page' => 'sedes',
                'filtros' => [
                    'estado' => $_GET['estado'] ?? ''
                ],
                'paginacion' => [
                    'current_page' => $currentPage,
                    'per_page' => $perPage,
                    'total_records' => $totalRecords,
                    'total_pages' => $totalPages,
                    'has_previous' => $currentPage > 1,
                    'has_next' => $currentPage < $totalPages,
                    'previous_page' => $currentPage - 1,
                    'next_page' => $currentPage + 1,
                    'allowed_per_page' => $allowedPerPage
                ],
                'ordenamiento' => [
                    'column' => $sortColumn,
                    'direction' => $sortDirection
                ],
                'success' => $success,
                'error' => $error
            ]);
            
            error_log('SedeController@index: Vista renderizada correctamente');
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en SedeController@index: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar las sedes'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
        }
    }

    public function create(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('sedes/create.twig', [
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'sedes'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en SedeController@create: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar el formulario de creación de sede'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
        }
    }

    public function store(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $codigo = trim($parsedBody['codigo'] ?? '');
            $nombre = trim($parsedBody['nombre'] ?? '');
            $estado = isset($parsedBody['estado']) ? (int)$parsedBody['estado'] : 0;

            if (empty($codigo) || empty($nombre)) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Campos Requeridos',
                    'text' => 'Todos los campos son obligatorios'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes/create')
                    ->withStatus(302);
            }

            // Verificar si ya existe una sede con el mismo código
            $sql_check = "SELECT COUNT(*) as count FROM sedes WHERE codigo = ?";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute([$codigo]);
            $exists = $stmt_check->fetch()['count'] > 0;

            if ($exists) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Código Duplicado',
                    'text' => 'Ya existe una sede con el código: ' . $codigo . '. Por favor, use un código diferente.'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes/create')
                    ->withStatus(302);
            }

            // Verificar si ya existe una sede con el mismo nombre
            $sql_check_nombre = "SELECT COUNT(*) as count FROM sedes WHERE nombre = ?";
            $stmt_check_nombre = $this->pdo->prepare($sql_check_nombre);
            $stmt_check_nombre->execute([$nombre]);
            $exists_nombre = $stmt_check_nombre->fetch()['count'] > 0;

            if ($exists_nombre) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Nombre Duplicado',
                    'text' => 'Ya existe una sede con el nombre: ' . $nombre . '. Por favor, use un nombre diferente.'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes/create')
                    ->withStatus(302);
            }

            // Crear nueva sede
            $sql = "INSERT INTO sedes (codigo, nombre, estado) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$codigo, $nombre, $estado]);

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'Sede creada correctamente'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
                
        } catch (\PDOException $e) {
            // error_log("Error en SedeController@store: " . $e->getMessage());
            
            // Detectar errores específicos de base de datos
            if ($e->getCode() == 23000) {
                // Error de integridad (duplicado)
                if (strpos($e->getMessage(), 'sedes.codigo') !== false) {
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Código Duplicado',
                        'text' => 'Ya existe una sede con este código. Por favor, use un código diferente.'
                    ]);
                } elseif (strpos($e->getMessage(), 'sedes.nombre') !== false) {
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Nombre Duplicado',
                        'text' => 'Ya existe una sede con este nombre. Por favor, use un nombre diferente.'
                    ]);
                } else {
                    $this->session->set('swal', [
                        'icon' => 'error',
                        'title' => 'Error de Duplicación',
                        'text' => 'Ya existe un registro con los mismos datos. Por favor, verifique la información.'
                    ]);
                }
            } else {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Base de Datos',
                    'text' => 'Error al crear la sede. Por favor, intente nuevamente.'
                ]);
            }
            
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes/create')
                ->withStatus(302);
                
        } catch (\Exception $e) {
            // error_log("Error en SedeController@store: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al crear la sede: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes/create')
                ->withStatus(302);
        }
    }

    public function edit(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener la sede
            $sql = "SELECT * FROM sedes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $sede = $stmt->fetch();
            
            if (!$sede) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Sede No Encontrada',
                    'text' => 'La sede que intentas editar no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes')
                    ->withStatus(302);
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('sedes/edit.twig', [
                'sede' => $sede,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'sedes'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en SedeController@edit: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar la sede'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
        }
    }

    public function update(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $codigo = trim($parsedBody['codigo'] ?? '');
            $nombre = trim($parsedBody['nombre'] ?? '');
            $estado = isset($parsedBody['estado']) ? (int)$parsedBody['estado'] : 0;

            // error_log("Datos recibidos - Código: $codigo, Nombre: $nombre, Estado: $estado");

            if (empty($codigo) || empty($nombre)) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Campos Requeridos',
                    'text' => 'Todos los campos son obligatorios'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . "sedes/{$id}/edit")
                    ->withStatus(302);
            }

            // Obtener la sede actual
            $sql = "SELECT * FROM sedes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $sede = $stmt->fetch();
            
            if (!$sede) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Sede No Encontrada',
                    'text' => 'La sede que intentas editar no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes')
                    ->withStatus(302);
            }

            // Verificar si ya existe otra sede con el mismo código (excluyendo la actual)
            $sql_check = "SELECT COUNT(*) as count FROM sedes WHERE codigo = ? AND id != ?";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute([$codigo, $id]);
            $exists = $stmt_check->fetch()['count'] > 0;

            if ($exists) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Código Duplicado',
                    'text' => 'Ya existe otra sede con el código: ' . $codigo . '. Por favor, use un código diferente.'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . "sedes/{$id}/edit")
                    ->withStatus(302);
            }

            // Verificar si ya existe otra sede con el mismo nombre (excluyendo la actual)
            $sql_check_nombre = "SELECT COUNT(*) as count FROM sedes WHERE nombre = ? AND id != ?";
            $stmt_check_nombre = $this->pdo->prepare($sql_check_nombre);
            $stmt_check_nombre->execute([$nombre, $id]);
            $exists_nombre = $stmt_check_nombre->fetch()['count'] > 0;

            if ($exists_nombre) {
                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'Nombre Duplicado',
                    'text' => 'Ya existe otra sede con el nombre: ' . $nombre . '. Por favor, use un nombre diferente.'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . "sedes/{$id}/edit")
                    ->withStatus(302);
            }

            // error_log("Sede encontrada - ID: {$sede['id']}, Código actual: {$sede['codigo']}, Nombre actual: {$sede['nombre']}, Estado actual: {$sede['estado']}");

            // Actualizar la sede
            $sql = "UPDATE sedes SET codigo = ?, nombre = ?, estado = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $resultado = $stmt->execute([$codigo, $nombre, $estado, $id]);

            // error_log("Resultado del guardado: " . ($resultado ? "éxito" : "fallo"));

            if (!$resultado) {
                throw new \Exception("Error al guardar los cambios");
            }

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'Sede actualizada correctamente'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);

        } catch (\PDOException $e) {
            // error_log("Error en SedeController@update: " . $e->getMessage());
            // error_log("Stack trace: " . $e->getTraceAsString());
            
            // Detectar errores específicos de base de datos
            if ($e->getCode() == 23000) {
                // Error de integridad (duplicado)
                if (strpos($e->getMessage(), 'sedes.codigo') !== false) {
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Código Duplicado',
                        'text' => 'Ya existe otra sede con este código. Por favor, use un código diferente.'
                    ]);
                } elseif (strpos($e->getMessage(), 'sedes.nombre') !== false) {
                    $this->session->set('swal', [
                        'icon' => 'warning',
                        'title' => 'Nombre Duplicado',
                        'text' => 'Ya existe otra sede con este nombre. Por favor, use un nombre diferente.'
                    ]);
                } else {
                    $this->session->set('swal', [
                        'icon' => 'error',
                        'title' => 'Error de Duplicación',
                        'text' => 'Ya existe un registro con los mismos datos. Por favor, verifique la información.'
                    ]);
                }
            } else {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Base de Datos',
                    'text' => 'Error al actualizar la sede. Por favor, intente nuevamente.'
                ]);
            }
            
            return $response
                ->withHeader('Location', Config::get('app_url') . "sedes/{$id}/edit")
                ->withStatus(302);
                
        } catch (\Exception $e) {
            // error_log("Error en SedeController@update: " . $e->getMessage());
            // error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al actualizar la sede: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . "sedes/{$id}/edit")
                ->withStatus(302);
        }
    }

    public function destroy(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener la sede
            $sql = "SELECT * FROM sedes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $sede = $stmt->fetch();
            
            if (!$sede) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Sede No Encontrada',
                    'text' => 'La sede que intentas eliminar no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes')
                    ->withStatus(302);
            }

            // Verificar si la sede tiene facultades asociadas
            $sql_facultades = "SELECT COUNT(*) as count FROM facultades WHERE sede_id = ?";
            $stmt = $this->pdo->prepare($sql_facultades);
            $stmt->execute([$id]);
            $facultadesCount = $stmt->fetch()['count'];

            // Verificar si la sede tiene carreras asociadas a través de carreras_espejos
            $sql_carreras = "SELECT COUNT(*) as count FROM carreras_espejos WHERE sede_id = ?";
            $stmt = $this->pdo->prepare($sql_carreras);
            $stmt->execute([$id]);
            $carrerasCount = $stmt->fetch()['count'];

            if ($facultadesCount > 0 || $carrerasCount > 0) {
                $mensaje = "No se permite borrar la sede {$sede['nombre']}, ya que tiene ";
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

                $this->session->set('swal', [
                    'icon' => 'warning',
                    'title' => 'No Se Puede Eliminar',
                    'text' => $mensaje
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes')
                    ->withStatus(302);
            }

            // Eliminar la sede
            $sql = "DELETE FROM sedes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $resultado = $stmt->execute([$id]);

            if (!$resultado) {
                throw new \Exception("Error al eliminar la sede");
            }

            $this->session->set('swal', [
                'icon' => 'success',
                'title' => '¡Eliminado!',
                'text' => 'Sede eliminada correctamente'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);

        } catch (\Exception $e) {
            // error_log("Error en SedeController@destroy: " . $e->getMessage());
            // error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al eliminar la sede: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
        }
    }

    public function show(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de Autenticación',
                    'text' => 'Por favor inicie sesión para acceder a las sedes'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener la sede
            $sql = "SELECT * FROM sedes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $sede = $stmt->fetch();

            if (!$sede) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Sede No Encontrada',
                    'text' => 'La sede que buscas no existe'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'sedes')
                    ->withStatus(302);
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener facultades asociadas
            $sql_facultades = "SELECT * FROM facultades WHERE sede_id = ? ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql_facultades);
            $stmt->execute([$id]);
            $facultades = $stmt->fetchAll();

            // Obtener carreras asociadas a través de carreras_espejos
            $sql_carreras = "SELECT ce.*, c.nombre as carrera_nombre 
                           FROM carreras_espejos ce 
                           INNER JOIN carreras c ON ce.carrera_id = c.id 
                           WHERE ce.sede_id = ? 
                           ORDER BY c.nombre";
            $stmt = $this->pdo->prepare($sql_carreras);
            $stmt->execute([$id]);
            $carreras = $stmt->fetchAll();

            // Renderizar la vista
            $html = $this->twig->render('sedes/show.twig', [
                'sede' => $sede,
                'facultades' => $facultades,
                'carreras' => $carreras,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'sedes'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            // error_log("Error en SedeController@show: " . $e->getMessage());
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al cargar la sede'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'sedes')
                ->withStatus(302);
        }
    }
} 