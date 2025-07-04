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
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;

class FacultadController
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

    public function index(Request $request, ResponseInterface $response): ResponseInterface
    {
        // Log para depuración
        error_log('FacultadController@index ejecutándose');
        
        try {
            $params = $request->getQueryParams();
            $where = [];
            $values = [];

            // Filtro por sede
            if (!empty($params['sede_id'])) {
                $where[] = 'f.sede_id = ?';
                $values[] = $params['sede_id'];
            }
            // Filtro por estado
            if (isset($params['estado']) && $params['estado'] !== '') {
                $where[] = 'f.estado = ?';
                $values[] = $params['estado'];
            }

            $sql = "SELECT f.id, f.codigo, f.nombre, f.estado, s.nombre as sede_nombre 
                    FROM facultades f 
                    LEFT JOIN sedes s ON f.sede_id = s.id";
            if ($where) {
                $sql .= ' WHERE ' . implode(' AND ', $where);
            }
            $sql .= ' ORDER BY f.nombre ASC';

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
            $facultades = $stmt->fetchAll();

            // Obtener todas las sedes para los filtros
            $stmt = $this->pdo->prepare("SELECT id, nombre FROM sedes ORDER BY nombre ASC");
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Log para depuración de mensajes de sesión
            error_log('Mensajes de sesión en index: ' . print_r($_SESSION, true));
            error_log('Mensaje flash de éxito: ' . ($this->session->getFlash('success') ?? 'No hay mensaje flash de éxito'));
            error_log('Mensaje flash de error: ' . ($this->session->getFlash('error') ?? 'No hay mensaje flash de error'));

            // Renderizar la vista
            $html = $this->twig->render('facultades/index.twig', [
                'facultades' => $facultades,
                'sedes' => $sedes,
                'filtros' => $params,
                'current_page' => 'facultades',
                'app_url' => $_ENV['APP_URL'] ?? 'http://localhost'
            ]);

            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al cargar las facultades: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
        }
    }

    public function create(Request $request, ResponseInterface $response): ResponseInterface
    {
        try {
            // Obtener todas las sedes para el formulario
            $stmt = $this->pdo->prepare("SELECT id, nombre FROM sedes ORDER BY nombre ASC");
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Renderizar la vista
            $html = $this->twig->render('facultades/form.twig', [
                'sedes' => $sedes,
                'current_page' => 'facultades',
                'app_url' => $_ENV['APP_URL'] ?? 'http://localhost'
            ]);

            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al cargar el formulario: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/create');
        }
    }

    public function store(Request $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();
            
            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                $this->session->setFlash('error', 'El código, nombre y la sede son obligatorios');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/create');
            }

            $codigo = trim($data['codigo']);
            $nombre = trim($data['nombre']);
            $sede_id = (int)$data['sede_id'];
            $estado = isset($data['estado']) ? (int)$data['estado'] : 1;

            // Verificar si ya existe una facultad con el mismo código
            $stmt = $this->pdo->prepare("SELECT id FROM facultades WHERE codigo = ?");
            $stmt->execute([$codigo]);
            
            if ($stmt->fetch()) {
                $this->session->setFlash('error', 'Ya existe una facultad con el código "' . $codigo . '"');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/create');
            }

            // Verificar si ya existe una facultad con el mismo nombre en la misma sede
            $stmt = $this->pdo->prepare("
                SELECT id FROM facultades 
                WHERE nombre = ? AND sede_id = ? AND id != ?
            ");
            $stmt->execute([$nombre, $sede_id, 0]);
            
            if ($stmt->fetch()) {
                $this->session->setFlash('error', 'Ya existe una facultad con el nombre "' . $nombre . '" en esta sede');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/create');
            }

            // Insertar la nueva facultad
            $stmt = $this->pdo->prepare("
                INSERT INTO facultades (codigo, nombre, sede_id, estado) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$codigo, $nombre, $sede_id, $estado]);

            $this->session->setFlash('success', 'Facultad creada exitosamente');
            
            // Log para depuración
            error_log('Mensaje flash de éxito guardado');
            error_log('Datos de sesión completos: ' . print_r($_SESSION, true));
            
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al crear la facultad: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/create');
        }
    }

    public function edit(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = (int)$args['id'];
            
            // Obtener la facultad
            $stmt = $this->pdo->prepare("SELECT * FROM facultades WHERE id = ?");
            $stmt->execute([$id]);
            $facultad = $stmt->fetch();
            
            if (!$facultad) {
                $this->session->setFlash('error', 'Facultad no encontrada');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            }

            // Obtener todas las sedes para el formulario
            $stmt = $this->pdo->prepare("SELECT id, nombre FROM sedes ORDER BY nombre ASC");
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Log para depuración de mensajes flash
            error_log('Mensajes flash en edit: ' . print_r($_SESSION, true));
            error_log('Mensaje flash de error: ' . ($this->session->getFlash('error') ?? 'No hay mensaje flash de error'));

            // Renderizar la vista
            $html = $this->twig->render('facultades/form.twig', [
                'facultad' => $facultad,
                'sedes' => $sedes,
                'current_page' => 'facultades',
                'app_url' => $_ENV['APP_URL'] ?? 'http://localhost'
            ]);

            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al cargar el formulario: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
        }
    }

    public function update(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = (int)$args['id'];
            $data = $request->getParsedBody();
            
            // Validar datos requeridos
            if (empty($data['codigo']) || empty($data['nombre']) || empty($data['sede_id'])) {
                $this->session->setFlash('error', 'El código, nombre y la sede son obligatorios');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/' . $id . '/edit');
            }

            $codigo = trim($data['codigo']);
            $nombre = trim($data['nombre']);
            $sede_id = (int)$data['sede_id'];
            $estado = isset($data['estado']) ? (int)$data['estado'] : 1;

            // Verificar si ya existe una facultad con el mismo código (excluyendo la actual)
            $stmt = $this->pdo->prepare("SELECT id FROM facultades WHERE codigo = ? AND id != ?");
            $stmt->execute([$codigo, $id]);
            
            if ($stmt->fetch()) {
                $this->session->setFlash('error', 'Ya existe una facultad con el código "' . $codigo . '"');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/' . $id . '/edit');
            }

            // Verificar si ya existe una facultad con el mismo nombre en la misma sede (excluyendo la actual)
            $stmt = $this->pdo->prepare("
                SELECT id FROM facultades 
                WHERE nombre = ? AND sede_id = ? AND id != ?
            ");
            $stmt->execute([$nombre, $sede_id, $id]);
            
            if ($stmt->fetch()) {
                $this->session->setFlash('error', 'Ya existe una facultad con el nombre "' . $nombre . '" en esta sede');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/' . $id . '/edit');
            }

            // Actualizar la facultad
            $stmt = $this->pdo->prepare("
                UPDATE facultades 
                SET codigo = ?, nombre = ?, sede_id = ?, estado = ? 
                WHERE id = ?
            ");
            $stmt->execute([$codigo, $nombre, $sede_id, $estado, $id]);

            $this->session->setFlash('success', 'Facultad actualizada exitosamente');
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al actualizar la facultad: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades/' . $id . '/edit');
        }
    }

    public function destroy(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Log para depuración
        error_log('FacultadController@destroy ejecutándose');
        error_log('ID recibido: ' . print_r($args, true));
        error_log('Método HTTP: ' . $request->getMethod());
        error_log('URI: ' . $request->getUri()->getPath());
        error_log('Query string: ' . $request->getUri()->getQuery());
        error_log('Body: ' . $request->getBody()->getContents());
        
        try {
            $id = (int)$args['id'];
            
            // Verificar si la facultad existe
            $stmt = $this->pdo->prepare("SELECT id, nombre FROM facultades WHERE id = ?");
            $stmt->execute([$id]);
            $facultad = $stmt->fetch();
            
            if (!$facultad) {
                $this->session->setFlash('error', 'Facultad no encontrada');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            }

            // Verificar si hay carreras espejo asociadas
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM carreras_espejos WHERE facultad_id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                $this->session->setFlash('error', 'No se puede eliminar la facultad "' . $facultad['nombre'] . '" porque tiene carreras asociadas');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            }

            // Eliminar la facultad
            $stmt = $this->pdo->prepare("DELETE FROM facultades WHERE id = ?");
            $stmt->execute([$id]);

            $this->session->setFlash('success', 'Facultad "' . $facultad['nombre'] . '" eliminada exitosamente');
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al eliminar la facultad: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
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
            $stmt = $this->pdo->prepare("
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

    public function show(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = (int)$args['id'];
            
            // Obtener la facultad con información de la sede
            $stmt = $this->pdo->prepare("
                SELECT f.*, s.nombre as sede_nombre 
                FROM facultades f 
                LEFT JOIN sedes s ON f.sede_id = s.id 
                WHERE f.id = ?
            ");
            $stmt->execute([$id]);
            $facultad = $stmt->fetch();
            
            if (!$facultad) {
                $this->session->setFlash('error', 'Facultad no encontrada');
                return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
            }

            // Renderizar la vista
            $html = $this->twig->render('facultades/show.twig', [
                'facultad' => $facultad,
                'current_page' => 'facultades',
                'app_url' => $_ENV['APP_URL'] ?? 'http://localhost'
            ]);

            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error al cargar la facultad: ' . $e->getMessage());
            return $response->withStatus(302)->withHeader('Location', '/biblioges/facultades');
        }
    }
} 