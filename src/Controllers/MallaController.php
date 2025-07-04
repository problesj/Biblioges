<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Session;
use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MallaController
{
    private $pdo;
    private $twig;
    private $session;
    private $app_url;

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

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $this->session = new Session();
        $this->app_url = Config::get('app_url');
    }

    public function index(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error de acceso',
                'text' => 'Por favor inicie sesión para acceder a las mallas'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        // Obtener mensajes de sesión y limpiarlos
        $swal = $this->session->get('swal');
        $this->session->remove('swal');

        // Obtener filtros
        $filtros = [
            'tipo_programa' => $_GET['tipo_programa'] ?? '',
            'sede' => $_GET['sede'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'busqueda' => $_GET['busqueda'] ?? ''
        ];

        // Construir la consulta base
        $sql = "SELECT c.*, 
                GROUP_CONCAT(DISTINCT ce.codigo_carrera) as codigos_carrera,
                GROUP_CONCAT(DISTINCT s.nombre) as sedes,
                GROUP_CONCAT(DISTINCT f.nombre) as facultades
                FROM carreras c
                LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                LEFT JOIN sedes s ON ce.sede_id = s.id
                LEFT JOIN facultades f ON ce.facultad_id = f.id
                WHERE 1=1";

        $params = [];

        // Aplicar filtros
        if (!empty($filtros['tipo_programa'])) {
            $sql .= " AND c.tipo_programa = ?";
            $params[] = $filtros['tipo_programa'];
        }

        if (!empty($filtros['sede'])) {
            $sql .= " AND ce.sede_id = ?";
            $params[] = $filtros['sede'];
        }

        if ($filtros['estado'] !== '') {
            $sql .= " AND c.estado = ?";
            $params[] = $filtros['estado'];
        }

        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (c.nombre LIKE ? OR ce.codigo_carrera LIKE ?)";
            $params[] = "%{$filtros['busqueda']}%";
            $params[] = "%{$filtros['busqueda']}%";
        }

        $sql .= " GROUP BY c.id ORDER BY c.nombre";

        // Ejecutar la consulta
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar los resultados para asegurar el formato correcto
        foreach ($carreras as &$carrera) {
            // Asegurar que los campos sean arrays
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
        }

        // Obtener sedes para el filtro
        $stmt = $this->pdo->query("SELECT * FROM sedes ORDER BY nombre");
        $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener usuario actual
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$this->session->get('user_id')]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Renderizar la vista
        $html = $this->twig->render('mallas/index.twig', [
            'carreras' => $carreras,
            'sedes' => $sedes,
            'filtros' => $filtros,
            'user' => $user,
            'app_url' => Config::get('app_url'),
            'current_page' => 'mallas',
            'session' => $_SESSION,
            'swal' => $swal
        ]);
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    public function show(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error de acceso',
                'text' => 'Por favor inicie sesión para acceder a las mallas'
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Obtener datos de la carrera
            $sql = "SELECT 
                        c.*,
                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera,
                        GROUP_CONCAT(s.nombre) as sedes,
                        GROUP_CONCAT(f.nombre) as facultades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN facultades f ON ce.facultad_id = f.id
                    WHERE c.id = ?
                    GROUP BY c.id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Carrera no encontrada'
                ]);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'mallas')
                    ->withStatus(302);
            }

            // Procesar los resultados para asegurar el formato correcto
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
            $carrera['vigencias_desde'] = $carrera['vigencias_desde'] ? explode(',', $carrera['vigencias_desde']) : [];
            $carrera['vigencias_hasta'] = $carrera['vigencias_hasta'] ? explode(',', $carrera['vigencias_hasta']) : [];

            // Obtener asignaturas vinculadas a través de la tabla mallas
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre,
                                GROUP_CONCAT(DISTINCT ad.codigo_asignatura) as codigos
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                            WHERE m.carrera_id = ?
                            GROUP BY a.id, a.nombre, a.tipo, a.periodicidad, a.estado, m.semestre
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$id]);
            $carrera['asignaturas'] = $stmt->fetchAll();

            // Procesar los códigos de asignaturas
            foreach ($carrera['asignaturas'] as &$asignatura) {
                $asignatura['codigos'] = $asignatura['codigos'] ? explode(',', $asignatura['codigos']) : [];
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

            // Renderizar la vista
            $html = $this->twig->render('mallas/show.twig', [
                'carrera' => $carrera,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'swal' => $swal,
                'current_page' => 'mallas',
                'session' => $_SESSION
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al obtener los datos de la malla: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);
        }
    }

    public function edit(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Obtener datos de la carrera
            $sql = "SELECT 
                        c.*,
                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera,
                        GROUP_CONCAT(s.nombre) as sedes,
                        GROUP_CONCAT(f.nombre) as facultades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN facultades f ON ce.facultad_id = f.id
                    WHERE c.id = ?
                    GROUP BY c.id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'mallas')
                    ->withStatus(302);
            }

            // Procesar los resultados para asegurar el formato correcto
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
            $carrera['vigencias_desde'] = $carrera['vigencias_desde'] ? explode(',', $carrera['vigencias_desde']) : [];
            $carrera['vigencias_hasta'] = $carrera['vigencias_hasta'] ? explode(',', $carrera['vigencias_hasta']) : [];

            // Obtener asignaturas vinculadas a través de la tabla mallas
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre,
                                GROUP_CONCAT(DISTINCT ad.codigo_asignatura) as codigos
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                            WHERE m.carrera_id = ?
                            AND a.tipo IN ('REGULAR', 'FORMACION_ELECTIVA')
                            GROUP BY a.id, a.nombre, a.tipo, a.periodicidad, a.estado, m.semestre
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$id]);
            $carrera['asignaturas'] = $stmt->fetchAll();

            // Procesar los códigos de asignaturas
            foreach ($carrera['asignaturas'] as &$asignatura) {
                $asignatura['codigos'] = $asignatura['codigos'] ? explode(',', $asignatura['codigos']) : [];
            }

            // Obtener todas las sedes para el selector
            $sql_sedes = "SELECT * FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql_sedes);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

            // Renderizar la vista
            $html = $this->twig->render('mallas/edit.twig', [
                'carrera' => $carrera,
                'sedes' => $sedes,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'swal' => $swal,
                'current_page' => 'mallas',
                'session' => $_SESSION
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            $this->session->set('error', 'Error al obtener los datos de la malla: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);
        }
    }

    public function update(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar si es una petición AJAX
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', 'Por favor inicie sesión para actualizar mallas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos según el tipo de petición
            if ($isAjax) {
                $inputData = $request->getBody()->getContents();
                $data = json_decode($inputData, true);
                $asignaturas = $data['asignaturas'] ?? [];
                $carrera_id = $data['carrera_id'] ?? $id;
            } else {
                $parsedBody = $request->getParsedBody();
                $asignaturas = $parsedBody['asignaturas'] ?? [];
                $carrera_id = $id;
            }

            // Validar que haya asignaturas seleccionadas
            if (empty($asignaturas)) {
                $mensaje = 'Debe seleccionar al menos una asignatura';
                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'mallas/' . $id . '/edit')
                    ->withStatus(302);
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            try {
                // Eliminar asignaturas existentes
                $sql_delete = "DELETE FROM mallas WHERE carrera_id = ?";
                $stmt = $this->pdo->prepare($sql_delete);
                $stmt->execute([$carrera_id]);

                // Insertar nuevas asignaturas
                $sql_insert = "INSERT INTO mallas (carrera_id, asignatura_id, semestre) VALUES (?, ?, ?)";
                $stmt = $this->pdo->prepare($sql_insert);

                foreach ($asignaturas as $asignatura) {
                    $asignatura_id = $asignatura['id'];
                    $semestre = $asignatura['semestre'] ?? 1;
                    $stmt->execute([$carrera_id, $asignatura_id, $semestre]);
                }

                // Confirmar transacción
                $this->pdo->commit();

                $mensaje = 'Malla actualizada correctamente';
                
                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => true, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }

                $this->session->set('success', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'mallas')
                    ->withStatus(302);

            } catch (\Exception $e) {
                $this->pdo->rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            $mensaje = 'Error al actualizar la malla: ' . $e->getMessage();
            
            if ($isAjax) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                return $response->withHeader('Content-Type', 'application/json');
            }
            
            $this->session->set('error', $mensaje);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas/' . $id . '/edit')
                ->withStatus(302);
        }
    }

    public function delete(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Eliminar asignaturas de la malla
            $sql_delete = "DELETE FROM mallas WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql_delete);
            $stmt->execute([$id]);

            // Confirmar transacción
            $this->pdo->commit();

            $this->session->set('success', 'Malla eliminada correctamente');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            $this->session->set('error', 'Error al eliminar la malla: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);
        }
    }
} 