<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Session;
use PDO;
use PDOException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiController
{
    private $pdo;
    private $session;

    public function __construct()
    {
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

        $this->session = new Session();
    }

    public function getUnidadesBySede(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $response->getBody()->write(json_encode(['error' => 'No autorizado']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        try {
            // Obtener el sede_id de los argumentos de la ruta
            $sedeId = $args['sedeId'] ?? null;
            
            // Si no está en los argumentos, intentar obtenerlo de los query parameters
            if (!$sedeId) {
                $queryParams = $request->getQueryParams();
                $sedeId = $queryParams['sede_id'] ?? null;
            }
            
            if (!$sedeId) {
                $response->getBody()->write(json_encode(['error' => 'ID de sede requerido']));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            // Log para depuración
            // error_log('Obteniendo unidades para sede ID: ' . $sedeId);

            // Consulta SQL para obtener todas las unidades de la sede
            $sql = "SELECT u.id, u.nombre 
                    FROM unidades u
                    WHERE u.sede_id = :sede_id AND u.estado = 1
                    ORDER BY u.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':sede_id', $sedeId, PDO::PARAM_INT);
            $stmt->execute();
            
            $unidades = $stmt->fetchAll();

            // Log para depuración
            // error_log('SQL ejecutada: ' . $sql);
            // error_log('Parámetros: sede_id = ' . $sedeId);
            // error_log('Unidades encontradas: ' . print_r($unidades, true));

            $response->getBody()->write(json_encode($unidades));
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            error_log('Error al obtener unidades: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $response->getBody()->write(json_encode(['error' => 'Error al obtener las unidades: ' . $e->getMessage()]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }

    public function getFacultadesBySede($sedeId)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        try {
            // Log para depuración
            // error_log('Obteniendo facultades para sede ID: ' . $sedeId);

            // Consulta SQL modificada para obtener todas las facultades de la sede
            $sql = "SELECT f.id, f.nombre 
                    FROM facultades f
                    WHERE f.sede_id = :sede_id AND f.estado = 1
                    ORDER BY f.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':sede_id', $sedeId, PDO::PARAM_INT);
            $stmt->execute();
            
            $facultades = $stmt->fetchAll();

            // Log para depuración
            // error_log('SQL ejecutada: ' . $sql);
            // error_log('Parámetros: sede_id = ' . $sedeId);
            // error_log('Facultades encontradas: ' . print_r($facultades, true));

            header('Content-Type: application/json');
            echo json_encode($facultades);
        } catch (\Exception $e) {
            error_log('Error al obtener facultades: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener las facultades: ' . $e->getMessage()]);
        }
    }

    public function getDepartamentos($sedeId, $facultadId)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        try {
            // Consulta SQL modificada para obtener todos los departamentos de la facultad
            $sql = "SELECT d.id, d.nombre 
                    FROM departamentos d
                    WHERE d.facultad_id = :facultad_id AND d.estado = 1
                    ORDER BY d.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':facultad_id', $facultadId, PDO::PARAM_INT);
            $stmt->execute();
            $departamentos = $stmt->fetchAll();

            header('Content-Type: application/json');
            echo json_encode($departamentos);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener los departamentos: ' . $e->getMessage()]);
        }
    }

    public function getAsignaturasDepartamento($departamentoId)
    {
        try {
            $sql = "SELECT DISTINCT 
                        a.*,
                        GROUP_CONCAT(DISTINCT ad.codigo_asignatura) as codigos
                    FROM asignaturas a
                    INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                    WHERE ad.departamento_id = ?
                    AND a.estado = 1
                    AND a.tipo IN ('REGULAR', 'FORMACION_ELECTIVA')
                    GROUP BY a.id, a.nombre, a.tipo, a.periodicidad, a.estado
                    ORDER BY a.nombre";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$departamentoId]);
            $asignaturas = $stmt->fetchAll();

            // Procesar los códigos de asignaturas
            foreach ($asignaturas as &$asignatura) {
                $asignatura['codigos'] = $asignatura['codigos'] ? explode(',', $asignatura['codigos']) : [];
            }

            header('Content-Type: application/json');
            echo json_encode($asignaturas);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getDetallesAsignatura($asignaturaId)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        try {
            // Consulta SQL para obtener detalles de la asignatura
            $sql = "SELECT 
                        ad.codigo_asignatura as codigo,
                        d.nombre as departamento,
                        a.vigencia_desde,
                        a.vigencia_hasta
                    FROM asignaturas a
                    INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                    INNER JOIN departamentos d ON ad.departamento_id = d.id
                    WHERE a.id = :asignatura_id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':asignatura_id', $asignaturaId, PDO::PARAM_INT);
            $stmt->execute();
            
            $detalles = $stmt->fetchAll();

            header('Content-Type: application/json');
            echo json_encode($detalles);
        } catch (\Exception $e) {
            error_log('Error al obtener detalles de asignatura: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener los detalles de la asignatura: ' . $e->getMessage()]);
        }
    }

    public function getAsignaturasVinculadas($asignaturaId)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        try {
            // Consulta SQL para obtener asignaturas vinculadas
            $sql = "SELECT 
                        a.id,
                        a.nombre,
                        a.estado,
                        a.periodicidad
                    FROM asignaturas_formacion af
                    JOIN asignaturas a ON af.asignatura_regular_id = a.id
                    WHERE af.asignatura_formacion_id = :asignatura_id
                    ORDER BY a.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':asignatura_id', $asignaturaId, PDO::PARAM_INT);
            $stmt->execute();
            
            $asignaturas = $stmt->fetchAll();

            header('Content-Type: application/json');
            echo json_encode($asignaturas);
        } catch (\Exception $e) {
            error_log('Error al obtener asignaturas vinculadas: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener las asignaturas vinculadas: ' . $e->getMessage()]);
        }
    }

    public function updateMalla($carreraId)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            http_response_code(401);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }

        try {
            // Obtener datos del POST
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['asignaturas'])) {
                throw new \Exception('No se proporcionaron asignaturas');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Eliminar asignaturas existentes
            $sql = "DELETE FROM mallas WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$carreraId]);

            // Insertar nuevas asignaturas
            $sql = "INSERT INTO mallas (carrera_id, asignatura_id, semestre) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data['asignaturas'] as $asignatura) {
                $stmt->execute([
                    $carreraId,
                    $asignatura['id'],
                    $asignatura['semestre']
                ]);
            }

            // Confirmar transacción
            $this->pdo->commit();

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Malla actualizada correctamente']);
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar la malla: ' . $e->getMessage()]);
        }
    }

    public function getUnidadesHijas(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $response->getBody()->write(json_encode(['error' => 'No autorizado']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        try {
            // Obtener el unidad_id de los argumentos de la ruta
            $unidadId = $args['unidadId'] ?? null;
            
            if (!$unidadId) {
                $response->getBody()->write(json_encode(['error' => 'ID de unidad requerido']));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            // Log para depuración
            // error_log('Obteniendo unidades hijas para unidad ID: ' . $unidadId);

            // Consulta SQL para obtener las unidades hijas
            $sql = "SELECT u.id, u.nombre 
                    FROM unidades u
                    WHERE u.id_unidad_padre = :unidad_id AND u.estado = 1
                    ORDER BY u.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':unidad_id', $unidadId, PDO::PARAM_INT);
            $stmt->execute();
            
            $unidadesHijas = $stmt->fetchAll();

            // Log para depuración
            // error_log('SQL ejecutada: ' . $sql);
            // error_log('Parámetros: unidad_id = ' . $unidadId);
            // error_log('Unidades hijas encontradas: ' . print_r($unidadesHijas, true));

            $response->getBody()->write(json_encode($unidadesHijas));
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            error_log('Error al obtener unidades hijas: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $response->getBody()->write(json_encode(['error' => 'Error al obtener las unidades hijas: ' . $e->getMessage()]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
} 