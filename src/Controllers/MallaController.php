<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Session;
use App\Core\ListStateManager;
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
        // Inicializar sesión
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
        
        $this->app_url = Config::get('app_url');
    }

    public function index(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Inicializar el gestor de estado del listado
            $stateManager = new ListStateManager($this->session, 'mallas');
            
            // Obtener parámetros de la URL
            $urlParams = $_GET;
            
            // Obtener estado (combinando sesión y URL)
            $state = $stateManager->getState($urlParams);
            
            // Guardar estado en sesión
            $stateManager->saveState($state);
            
            // Extraer parámetros del estado
            $page = $state['page'];
            $perPage = $state['per_page'];
            $sortColumn = $state['sort'];
            $sortDirection = $state['direction'];
            $allowedPerPage = [5, 10, 15, 20];
            $allowedColumns = ['nombre', 'tipo_programa', 'estado', 'sede'];
            
            $offset = ($page - 1) * $perPage;

            // Obtener filtros del estado
            $tipoPrograma = $state['tipo_programa'] ?? null;
            $sede = $state['sede'] ?? null;
            $estado = $state['estado'] ?? null;
            $busqueda = $state['busqueda'] ?? null;

            // Construir la consulta base para contar total de registros
            $countSql = "SELECT COUNT(DISTINCT c.id) as total
            FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
                    WHERE 1=1";

            // Construir la consulta principal
            $sql = "SELECT c.*, 
                    GROUP_CONCAT(DISTINCT ce.codigo_carrera) as codigos_carrera,
                    GROUP_CONCAT(DISTINCT s.nombre) as sedes,
                    GROUP_CONCAT(DISTINCT u.nombre) as unidades
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
                    WHERE 1=1";

            $params = [];

            // Aplicar filtros (aplicados tanto a countSql como a sql)
            if (!empty($tipoPrograma)) {
                $sql .= " AND c.tipo_programa = ?";
                $countSql .= " AND c.tipo_programa = ?";
                $params[] = $tipoPrograma;
            }

            if (!empty($sede)) {
                $sql .= " AND ce.sede_id = ?";
                $countSql .= " AND ce.sede_id = ?";
                $params[] = $sede;
            }

            if ($estado !== null && $estado !== '') {
                $sql .= " AND c.estado = ?";
                $countSql .= " AND c.estado = ?";
                $params[] = $estado;
            }

            if (!empty($busqueda)) {
                // Normalizar el texto de búsqueda: convertir a minúsculas y remover acentos
                $searchTerm = $this->normalizeSearchTerm($busqueda);
                
                // Dividir el término de búsqueda en palabras individuales
                $searchWords = array_filter(explode(' ', $searchTerm));
                
                if (!empty($searchWords)) {
                    $sql .= " AND (";
                    $countSql .= " AND (";
                    
                    $conditions = [];
                    foreach ($searchWords as $word) {
                        if (!empty($word)) {
                            // Usar una función más simple y eficiente para MySQL
                            $conditions[] = "(LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR ce.codigo_carrera LIKE ?)";
                            $params[] = '%' . $word . '%';
                            $params[] = '%' . $word . '%';
                        }
                    }
                    
                    if (!empty($conditions)) {
                        $sql .= implode(' AND ', $conditions);
                        $countSql .= implode(' AND ', $conditions);
                    }
                    
                    $sql .= ")";
                    $countSql .= ")";
                }
            }

            // Obtener total de registros
            $stmt = $this->pdo->prepare($countSql);
            $stmt->execute($params);
            $totalRecords = $stmt->fetch()['total'];

            // Calcular información de paginación
            $totalPages = ceil($totalRecords / $perPage);
            $currentPage = $page;

            // Agregar GROUP BY y ORDER BY a la consulta principal
            if ($sortColumn === 'sede') {
                // Para ordenar por sede, usamos MIN() para obtener la primera sede de cada carrera
                $sql .= " GROUP BY c.id ORDER BY MIN(s.nombre) {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            } else {
                $sql .= " GROUP BY c.id ORDER BY c.{$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            }

            // Ejecutar la consulta principal
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar los resultados para asegurar el formato correcto
            foreach ($carreras as &$carrera) {
                // Asegurar que los campos sean arrays
                $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
                $carrera['unidades'] = $carrera['unidades'] ? explode(',', $carrera['unidades']) : [];
                $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
            }

            // Obtener sedes para el filtro
            $stmt = $this->pdo->query("SELECT * FROM sedes ORDER BY nombre");
            $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener usuario actual
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$this->session->get('user_id')]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Preparar datos para la vista
            $viewData = [
                'carreras' => $carreras,
                'sedes' => $sedes,
                'user' => $user,
                'current_page' => 'mallas',
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'stateManager' => $stateManager,
                'filtros' => [
                    'tipo_programa' => $tipoPrograma,
                    'sede' => $sede,
                    'estado' => $estado,
                    'busqueda' => $busqueda
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
                ]
            ];

            // Renderizar la vista
            $html = $this->twig->render('mallas/index.twig', $viewData);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en MallaController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar las mallas: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'dashboard')
                ->withStatus(302);
        }
    }

    public function clearState(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Limpiar el estado del listado
            $stateManager = new ListStateManager($this->session, 'mallas');
            $stateManager->clearState();

            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en MallaController@clearState: " . $e->getMessage());
            $this->session->set('error', 'Error al limpiar los filtros: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);
        }
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
                        GROUP_CONCAT(u.nombre) as unidades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
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
            $carrera['unidades'] = $carrera['unidades'] ? explode(',', $carrera['unidades']) : [];
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
                                GROUP_CONCAT(DISTINCT au.codigo_asignatura) as codigos
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            LEFT JOIN asignaturas_departamentos au ON a.id = au.asignatura_id
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
                        GROUP_CONCAT(u.nombre) as unidades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
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
            $carrera['unidades'] = $carrera['unidades'] ? explode(',', $carrera['unidades']) : [];
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
                                GROUP_CONCAT(DISTINCT au.codigo_asignatura) as codigos
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            LEFT JOIN asignaturas_departamentos au ON a.id = au.asignatura_id
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

    /**
     * Mostrar formulario de fusión de asignaturas
     */
    public function showFusionAsignaturas(Request $request, Response $response, array $args = [])
    {
        $carreraId = $args['carrera_id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error de acceso',
                'text' => 'Por favor inicie sesión para acceder a la fusión de asignaturas'
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
                        GROUP_CONCAT(u.nombre) as unidades
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
                    WHERE c.id = ?
                    GROUP BY c.id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$carreraId]);
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
            $carrera['unidades'] = $carrera['unidades'] ? explode(',', $carrera['unidades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];

            // Obtener asignaturas vinculadas a la carrera (solo REGULAR y FORMACION_ELECTIVA)
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre,
                                GROUP_CONCAT(DISTINCT au.codigo_asignatura) as codigos
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            LEFT JOIN asignaturas_departamentos au ON a.id = au.asignatura_id
                            WHERE m.carrera_id = ?
                            AND a.tipo IN ('REGULAR', 'FORMACION_ELECTIVA')
                            GROUP BY a.id, a.nombre, a.tipo, a.periodicidad, a.estado, m.semestre
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$carreraId]);
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
            $html = $this->twig->render('mallas/fusion_asignaturas.twig', [
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
                'text' => 'Error al obtener los datos para la fusión: ' . $e->getMessage()
            ]);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'mallas')
                ->withStatus(302);
        }
    }

    /**
     * Obtener bibliografías declaradas de dos asignaturas para comparar
     */
    public function getBibliografiasParaFusion(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'No autorizado'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            // Obtener datos de la petición
            $inputData = $request->getBody()->getContents();
            $data = json_decode($inputData, true);
            
            $asignaturaPrincipalId = $data['asignatura_principal_id'] ?? null;
            $asignaturaFusionarId = $data['asignatura_fusionar_id'] ?? null;

            if (!$asignaturaPrincipalId || !$asignaturaFusionarId) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'Se requieren ambas asignaturas'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            // Obtener bibliografías de la asignatura principal
            $sql_principal = "SELECT 
                                bd.id,
                                bd.titulo,
                                bd.tipo,
                                bd.anio_publicacion,
                                bd.editorial,
                                bd.formato,
                                ab.tipo_bibliografia,
                                ab.estado
                            FROM bibliografias_declaradas bd
                            INNER JOIN asignaturas_bibliografias ab ON bd.id = ab.bibliografia_id
                            WHERE ab.asignatura_id = ?
                            ORDER BY ab.tipo_bibliografia, bd.titulo";

            $stmt = $this->pdo->prepare($sql_principal);
            $stmt->execute([$asignaturaPrincipalId]);
            $bibliografiasPrincipal = $stmt->fetchAll();

            // Obtener bibliografías de la asignatura a fusionar
            $sql_fusionar = "SELECT 
                                bd.id,
                                bd.titulo,
                                bd.tipo,
                                bd.anio_publicacion,
                                bd.editorial,
                                bd.formato,
                                ab.tipo_bibliografia,
                                ab.estado
                            FROM bibliografias_declaradas bd
                            INNER JOIN asignaturas_bibliografias ab ON bd.id = ab.bibliografia_id
                            WHERE ab.asignatura_id = ?
                            ORDER BY ab.tipo_bibliografia, bd.titulo";

            $stmt = $this->pdo->prepare($sql_fusionar);
            $stmt->execute([$asignaturaFusionarId]);
            $bibliografiasFusionar = $stmt->fetchAll();

            // Identificar bibliografías duplicadas (mismo título)
            $titulosPrincipal = array_column($bibliografiasPrincipal, 'titulo');
            $bibliografiasDuplicadas = [];
            $bibliografiasUnicas = [];

            foreach ($bibliografiasFusionar as $bib) {
                if (in_array($bib['titulo'], $titulosPrincipal)) {
                    $bibliografiasDuplicadas[] = $bib;
                } else {
                    $bibliografiasUnicas[] = $bib;
                }
            }

            // Obtener información de mallas vinculadas para la asignatura principal
            $sql_mallas_principal = "SELECT 
                                        m.carrera_id,
                                        c.nombre as carrera_nombre,
                                        m.semestre,
                                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera
                                    FROM mallas m
                                    INNER JOIN carreras c ON m.carrera_id = c.id
                                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                                    WHERE m.asignatura_id = ?
                                    GROUP BY m.carrera_id, c.nombre, m.semestre";

            $stmt = $this->pdo->prepare($sql_mallas_principal);
            $stmt->execute([$asignaturaPrincipalId]);
            $mallasPrincipal = $stmt->fetchAll();

            // Obtener información de mallas vinculadas para la asignatura a fusionar
            $sql_mallas_fusionar = "SELECT 
                                        m.carrera_id,
                                        c.nombre as carrera_nombre,
                                        m.semestre,
                                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera
                                    FROM mallas m
                                    INNER JOIN carreras c ON m.carrera_id = c.id
                                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                                    WHERE m.asignatura_id = ?
                                    GROUP BY m.carrera_id, c.nombre, m.semestre";

            $stmt = $this->pdo->prepare($sql_mallas_fusionar);
            $stmt->execute([$asignaturaFusionarId]);
            $mallasFusionar = $stmt->fetchAll();

            // Identificar si la asignatura a fusionar está en otras mallas (además de la actual)
            $carreraId = $data['carrera_id'] ?? null;
            if ($carreraId) {
                $otrasMallas = array_filter($mallasFusionar, function($malla) use ($carreraId) {
                    return $malla['carrera_id'] != $carreraId;
                });
            } else {
                // Si no tenemos carrera_id, consideramos que todas las mallas son "otras"
                $otrasMallas = $mallasFusionar;
            }

            $response->getBody()->write(json_encode([
                'success' => true,
                'bibliografias_principal' => $bibliografiasPrincipal,
                'bibliografias_fusionar' => $bibliografiasFusionar,
                'bibliografias_duplicadas' => $bibliografiasDuplicadas,
                'bibliografias_unicas' => $bibliografiasUnicas,
                'mallas_principal' => $mallasPrincipal,
                'mallas_fusionar' => $mallasFusionar,
                'otras_mallas' => array_values($otrasMallas),
                'tiene_otras_mallas' => !empty($otrasMallas)
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'success' => false, 
                'message' => 'Error al obtener bibliografías: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    /**
     * Obtener mallas vinculadas a dos asignaturas para revisión
     */
    public function getMallasVinculadasParaFusion(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'No autorizado'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            // Obtener datos de la petición
            $inputData = $request->getBody()->getContents();
            $data = json_decode($inputData, true);
            
            $asignaturaPrincipalId = $data['asignatura_principal_id'] ?? null;
            $asignaturaFusionarId = $data['asignatura_fusionar_id'] ?? null;

            if (!$asignaturaPrincipalId || !$asignaturaFusionarId) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'Se requieren ambas asignaturas'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            // Obtener información de mallas vinculadas para la asignatura principal
            $sql_mallas_principal = "SELECT 
                                        m.carrera_id,
                                        c.nombre as carrera_nombre,
                                        m.semestre,
                                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera
                                    FROM mallas m
                                    INNER JOIN carreras c ON m.carrera_id = c.id
                                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                                    WHERE m.asignatura_id = ?
                                    GROUP BY m.carrera_id, c.nombre, m.semestre";

            $stmt = $this->pdo->prepare($sql_mallas_principal);
            $stmt->execute([$asignaturaPrincipalId]);
            $mallasPrincipal = $stmt->fetchAll();

            // Obtener información de mallas vinculadas para la asignatura a fusionar
            $sql_mallas_fusionar = "SELECT 
                                        m.carrera_id,
                                        c.nombre as carrera_nombre,
                                        m.semestre,
                                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera
                                    FROM mallas m
                                    INNER JOIN carreras c ON m.carrera_id = c.id
                                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                                    WHERE m.asignatura_id = ?
                                    GROUP BY m.carrera_id, c.nombre, m.semestre";

            $stmt = $this->pdo->prepare($sql_mallas_fusionar);
            $stmt->execute([$asignaturaFusionarId]);
            $mallasFusionar = $stmt->fetchAll();

            // Identificar si la asignatura a fusionar está en otras mallas (además de la actual)
            $carreraId = $data['carrera_id'] ?? null;
            if ($carreraId) {
                $otrasMallas = array_filter($mallasFusionar, function($malla) use ($carreraId) {
                    return $malla['carrera_id'] != $carreraId;
                });
            } else {
                // Si no tenemos carrera_id, consideramos que todas las mallas son "otras"
                $otrasMallas = $mallasFusionar;
            }

            $response->getBody()->write(json_encode([
                'success' => true,
                'mallas_vinculadas_principal' => $mallasPrincipal,
                'mallas_vinculadas_fusionar' => $mallasFusionar,
                'otras_mallas' => array_values($otrasMallas),
                'tiene_otras_mallas' => !empty($otrasMallas)
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'success' => false, 
                'message' => 'Error al obtener mallas vinculadas: ' . $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    /**
     * Procesar la fusión de asignaturas
     */
    public function procesarFusionAsignaturas(Request $request, Response $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'No autorizado'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            // Obtener datos de la petición
            $inputData = $request->getBody()->getContents();
            $data = json_decode($inputData, true);
            
            $asignaturaPrincipalId = $data['asignatura_principal_id'] ?? null;
            $asignaturaFusionarId = $data['asignatura_fusionar_id'] ?? null;
            $accionesBibliografias = $data['acciones_bibliografias'] ?? [];
            $carreraId = $data['carrera_id'] ?? null;
            $continuarConOtrasMallas = $data['continuar_con_otras_mallas'] ?? false;

            if (!$asignaturaPrincipalId || !$asignaturaFusionarId || !$carreraId) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'Datos incompletos para la fusión'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
            
            // Validar que las asignaturas sean diferentes
            if ($asignaturaPrincipalId === $asignaturaFusionarId) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'No se puede fusionar una asignatura consigo misma'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
            
            // Verificar si hay conflictos de duplicación antes de proceder
            $stmt = $this->pdo->prepare("
                SELECT m1.semestre, m1.carrera_id, c.nombre as carrera_nombre
                FROM mallas m1
                INNER JOIN mallas m2 ON m1.carrera_id = m2.carrera_id AND m1.semestre = m2.semestre
                INNER JOIN carreras c ON m1.carrera_id = c.id
                WHERE m1.asignatura_id = ? AND m2.asignatura_id = ?
            ");
            $stmt->execute([$asignaturaPrincipalId, $asignaturaFusionarId]);
            $conflictos = $stmt->fetchAll();
            
            // Obtener información de conflictos para logging y referencia
            $carrerasConflictivas = [];
            if (!empty($conflictos)) {
                $carrerasConflictivas = array_unique(array_column($conflictos, 'carrera_nombre'));
                // Log de conflictos detectados pero permitir continuar
                error_log("FUSIÓN: Conflictos detectados en carreras: " . implode(', ', $carrerasConflictivas));
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            try {
                // ========================================
                // PROCESO DE FUSIÓN DE ASIGNATURAS
                // ========================================
                
                // 1. Procesar bibliografías según las acciones definidas
                foreach ($accionesBibliografias as $bibliografiaId => $accion) {
                    switch ($accion) {
                        case 'fusionar':
                            // Vincular la bibliografía a la asignatura principal
                            $stmt = $this->pdo->prepare("
                                INSERT INTO asignaturas_bibliografias 
                                (asignatura_id, bibliografia_id, tipo_bibliografia, estado) 
                                SELECT ?, bibliografia_id, tipo_bibliografia, estado 
                                FROM asignaturas_bibliografias 
                                WHERE asignatura_id = ? AND bibliografia_id = ?
                                ON DUPLICATE KEY UPDATE 
                                tipo_bibliografia = VALUES(tipo_bibliografia),
                                estado = VALUES(estado)
                            ");
                            $stmt->execute([$asignaturaPrincipalId, $asignaturaFusionarId, $bibliografiaId]);
                            break;
                            
                        case 'mantener':
                            // No hacer nada, la bibliografía permanece solo en la asignatura a fusionar
                            break;
                            
                        case 'eliminar':
                            // Eliminar la vinculación de la bibliografía con la asignatura a fusionar
                            $stmt = $this->pdo->prepare("
                                DELETE FROM asignaturas_bibliografias 
                                WHERE asignatura_id = ? AND bibliografia_id = ?
                            ");
                            $stmt->execute([$asignaturaFusionarId, $bibliografiaId]);
                            break;
                    }
                }

                // 2. ACTUALIZAR asignaturas_departamentos
                //    - Cambiar asignatura_id de la asignatura a fusionar a la principal
                //    - Esto transferirá códigos, unidades y cantidades de alumnos
                $stmt = $this->pdo->prepare("
                    UPDATE asignaturas_departamentos 
                    SET asignatura_id = ?, 
                        fecha_actualizacion = CURRENT_TIMESTAMP
                    WHERE asignatura_id = ?
                ");
                $stmt->execute([$asignaturaPrincipalId, $asignaturaFusionarId]);
                $filasActualizadas = $stmt->rowCount();
                
                error_log("FUSIÓN: Actualizadas {$filasActualizadas} filas en asignaturas_departamentos");
                
                // Verificar si hay conflictos de unidades (misma unidad en ambas asignaturas)
                $stmt = $this->pdo->prepare("
                    SELECT ad1.id_unidad, ad1.codigo_asignatura as codigo_principal, ad2.codigo_asignatura as codigo_fusionar
                    FROM asignaturas_departamentos ad1
                    INNER JOIN asignaturas_departamentos ad2 ON ad1.id_unidad = ad2.id_unidad
                    WHERE ad1.asignatura_id = ? AND ad2.asignatura_id = ?
                ");
                $stmt->execute([$asignaturaPrincipalId, $asignaturaFusionarId]);
                $conflictosUnidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Resolver conflictos de unidades concatenando códigos
                foreach ($conflictosUnidades as $conflicto) {
                    $codigoPrincipal = $conflicto['codigo_principal'];
                    $codigoFusionar = $conflicto['codigo_fusionar'];
                    
                    // Concatenar códigos si son diferentes
                    if ($codigoPrincipal !== $codigoFusionar) {
                        $codigosConcatenados = $codigoPrincipal . ', ' . $codigoFusionar;
                        
                        // Actualizar el registro principal con códigos concatenados
                        $stmt = $this->pdo->prepare("
                            UPDATE asignaturas_departamentos 
                            SET codigo_asignatura = ?
                            WHERE asignatura_id = ? AND id_unidad = ?
                        ");
                        $stmt->execute([$codigosConcatenados, $asignaturaPrincipalId, $conflicto['id_unidad']]);
                        
                        error_log("FUSIÓN: Códigos concatenados para unidad {$conflicto['id_unidad']}: {$codigosConcatenados}");
                    }
                    
                    // Eliminar el registro duplicado de la asignatura fusionada
                    $stmt = $this->pdo->prepare("
                        DELETE FROM asignaturas_departamentos 
                        WHERE asignatura_id = ? AND id_unidad = ?
                    ");
                    $stmt->execute([$asignaturaFusionarId, $conflicto['id_unidad']]);
                }
                
                // Log del resultado final de la transferencia de códigos
                $stmt = $this->pdo->prepare("
                    SELECT id_unidad, codigo_asignatura, cantidad_alumnos
                    FROM asignaturas_departamentos 
                    WHERE asignatura_id = ?
                ");
                $stmt->execute([$asignaturaPrincipalId]);
                $codigosFinales = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("FUSIÓN: Códigos finales de asignatura principal {$asignaturaPrincipalId}: " . json_encode($codigosFinales));

                // 4. Fusionar bibliografías disponibles para las bibliografías que se fusionan
                //    - Obtener bibliografías disponibles de la asignatura a fusionar
                //    - Verificar duplicados por título, año y editorial
                //    - Crear nuevas entradas vinculadas a la bibliografía principal
                //    - Copiar información de sedes y autores
                foreach ($accionesBibliografias as $bibliografiaId => $accion) {
                    if ($accion === 'fusionar') {
                        // Obtener bibliografías disponibles de la bibliografía que se fusiona
                        $stmt = $this->pdo->prepare("
                            SELECT id, titulo, anio_edicion, editorial, url_acceso, url_catalogo, 
                                   disponibilidad, id_mms, ejemplares_digitales, estado
                            FROM bibliografias_disponibles 
                            WHERE bibliografia_declarada_id = ?
                        ");
                        $stmt->execute([$bibliografiaId]);
                        $bibliografiasDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Para cada bibliografía disponible, verificar si ya existe en la principal
                        foreach ($bibliografiasDisponibles as $bibDisponible) {
                            // Buscar si ya existe una bibliografía disponible similar en la principal
                            $stmt = $this->pdo->prepare("
                                SELECT bd.id 
                                FROM bibliografias_disponibles bd
                                INNER JOIN asignaturas_bibliografias ab ON bd.bibliografia_declarada_id = ab.bibliografia_id
                                WHERE ab.asignatura_id = ? 
                                AND bd.titulo = ? 
                                AND bd.anio_edicion = ?
                                AND bd.editorial = ?
                            ");
                            $stmt->execute([
                                $asignaturaPrincipalId, 
                                $bibDisponible['titulo'], 
                                $bibDisponible['anio_edicion'], 
                                $bibDisponible['editorial']
                            ]);
                            $existeSimilar = $stmt->fetch();

                            if (!$existeSimilar) {
                                // Si no existe similar, crear una nueva entrada vinculada a la bibliografía principal
                                // Primero encontrar la bibliografía principal correspondiente
                                $stmt = $this->pdo->prepare("
                                    SELECT ab.bibliografia_id 
                                    FROM asignaturas_bibliografias ab
                                    WHERE ab.asignatura_id = ? 
                                    AND EXISTS (
                                        SELECT 1 FROM bibliografias_declaradas bd 
                                        WHERE bd.id = ab.bibliografia_id 
                                        AND bd.titulo = (
                                            SELECT titulo FROM bibliografias_declaradas WHERE id = ?
                                        )
                                    )
                                    LIMIT 1
                                ");
                                $stmt->execute([$asignaturaPrincipalId, $bibliografiaId]);
                                $bibliografiaPrincipalId = $stmt->fetchColumn();

                                if ($bibliografiaPrincipalId) {
                                    // Crear nueva bibliografía disponible vinculada a la principal
                                    $stmt = $this->pdo->prepare("
                                        INSERT INTO bibliografias_disponibles 
                                        (bibliografia_declarada_id, titulo, anio_edicion, editorial, 
                                         url_acceso, url_catalogo, disponibilidad, id_mms, 
                                         ejemplares_digitales, estado)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                    ");
                                    $stmt->execute([
                                        $bibliografiaPrincipalId,
                                        $bibDisponible['titulo'],
                                        $bibDisponible['anio_edicion'],
                                        $bibDisponible['editorial'],
                                        $bibDisponible['url_acceso'],
                                        $bibDisponible['url_catalogo'],
                                        $bibDisponible['disponibilidad'],
                                        $bibDisponible['id_mms'],
                                        $bibDisponible['ejemplares_digitales'],
                                        $bibDisponible['estado']
                                    ]);

                                    $nuevaBibliografiaDisponibleId = $this->pdo->lastInsertId();

                                    // Copiar información de sedes si existe
                                    $stmt = $this->pdo->prepare("
                                        SELECT sede_id, ejemplares
                                        FROM bibliografias_disponibles_sedes
                                        WHERE bibliografia_disponible_id = ?
                                    ");
                                    $stmt->execute([$bibDisponible['id']]);
                                    $sedesInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($sedesInfo as $sedeInfo) {
                                        $stmt = $this->pdo->prepare("
                                            INSERT INTO bibliografias_disponibles_sedes
                                            (bibliografia_disponible_id, sede_id, ejemplares)
                                            VALUES (?, ?, ?)
                                        ");
                                        $stmt->execute([
                                            $nuevaBibliografiaDisponibleId,
                                            $sedeInfo['sede_id'],
                                            $sedeInfo['ejemplares']
                                        ]);
                                    }

                                    // Copiar información de autores si existe
                                    $stmt = $this->pdo->prepare("
                                        SELECT autor_id
                                        FROM bibliografias_disponibles_autores
                                        WHERE bibliografia_disponible_id = ?
                                    ");
                                    $stmt->execute([$bibDisponible['id']]);
                                    $autoresInfo = $stmt->fetchAll(PDO::FETCH_COLUMN);

                                    foreach ($autoresInfo as $autorId) {
                                        $stmt = $this->pdo->prepare("
                                            INSERT INTO bibliografias_disponibles_autores
                                            (bibliografia_disponible_id, autor_id)
                                            VALUES (?, ?)
                                        ");
                                        $stmt->execute([$nuevaBibliografiaDisponibleId, $autorId]);
                                    }
                                }
                            }
                        }
                    }
                }

                // 5. Manejar la actualización de mallas de manera segura
                //    - Actualizar mallas donde aparece la asignatura a fusionar
                //    - Reemplazar con la asignatura principal
                //    - Eliminar duplicados si es necesario
                
                // Obtener todas las mallas donde aparece la asignatura a fusionar
                $stmt = $this->pdo->prepare("
                    SELECT carrera_id, semestre 
                    FROM mallas 
                    WHERE asignatura_id = ?
                ");
                $stmt->execute([$asignaturaFusionarId]);
                $mallasFusionar = $stmt->fetchAll();
                
                // Contador para mallas procesadas
                $mallasProcesadas = 0;
                $mallasConConflictos = 0;
                
                foreach ($mallasFusionar as $malla) {
                    // Verificar si ya existe la asignatura principal en esta carrera y semestre
                    $stmt = $this->pdo->prepare("
                        SELECT id FROM mallas 
                        WHERE carrera_id = ? AND asignatura_id = ? AND semestre = ?
                    ");
                    $stmt->execute([$malla['carrera_id'], $asignaturaPrincipalId, $malla['semestre']]);
                    $existePrincipal = $stmt->fetch();
                    
                    if ($existePrincipal) {
                        // Si ya existe la principal, eliminar la asignatura a fusionar
                        $stmt = $this->pdo->prepare("
                            DELETE FROM mallas 
                            WHERE carrera_id = ? AND asignatura_id = ? AND semestre = ?
                        ");
                        $stmt->execute([$malla['carrera_id'], $asignaturaFusionarId, $malla['semestre']]);
                        $mallasConConflictos++;
                    } else {
                        // Si no existe, reemplazar la asignatura a fusionar con la principal
                        $stmt = $this->pdo->prepare("
                            UPDATE mallas 
                            SET asignatura_id = ? 
                            WHERE carrera_id = ? AND asignatura_id = ? AND semestre = ?
                        ");
                        $stmt->execute([$asignaturaPrincipalId, $malla['carrera_id'], $asignaturaFusionarId, $malla['semestre']]);
                    }
                    $mallasProcesadas++;
                }
                
                // Log de mallas procesadas
                error_log("FUSIÓN: Procesadas {$mallasProcesadas} mallas, {$mallasConConflictos} con conflictos resueltos");

                // 6. ELIMINAR la asignatura fusionada de la tabla asignaturas
                //    - Solo después de haber transferido todos los datos
                $stmt = $this->pdo->prepare("
                    DELETE FROM asignaturas 
                    WHERE id = ?
                ");
                $stmt->execute([$asignaturaFusionarId]);
                $asignaturaEliminada = $stmt->rowCount();
                
                error_log("FUSIÓN: Asignatura {$asignaturaFusionarId} eliminada: {$asignaturaEliminada} filas afectadas");

                // Confirmar transacción
                $this->pdo->commit();

                $mensaje = 'Fusión de asignaturas completada exitosamente. Se han transferido todos los códigos, unidades y cantidades de alumnos a la asignatura principal. Las bibliografías se han procesado según las acciones seleccionadas. La asignatura principal ahora está vinculada a todas las carreras donde aparecía la asignatura fusionada. La asignatura fusionada ha sido eliminada del sistema. Se procesaron ' . $mallasProcesadas . ' malla(s) y se resolvieron ' . $mallasConConflictos . ' conflicto(s) de duplicación.';

                $response->getBody()->write(json_encode([
                    'success' => true,
                    'message' => $mensaje,
                    'resumen_fusion' => [
                        'mallas_procesadas' => $mallasProcesadas,
                        'conflictos_resueltos' => $mallasConConflictos,
                        'carreras_afectadas' => array_unique(array_column($mallasFusionar, 'carrera_id')),
                        'carreras_conflictivas' => $carrerasConflictivas
                    ]
                ]));
                return $response->withHeader('Content-Type', 'application/json');

            } catch (\Exception $e) {
                $this->pdo->rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            // Proporcionar mensajes de error más claros
            $mensajeError = 'Error al procesar la fusión: ';
            
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $mensajeError .= 'Se detectó un conflicto de duplicación. La asignatura principal ya existe en la misma carrera y semestre. Esto puede ocurrir cuando ambas asignaturas están en el mismo semestre de la misma carrera. Por favor, verifica la selección de asignaturas.';
            } elseif (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
                $mensajeError .= 'Se detectó una violación de restricción de integridad en la base de datos. Esto puede ocurrir cuando hay conflictos entre las asignaturas seleccionadas. Por favor, verifica que las asignaturas sean diferentes y estén en carreras compatibles.';
            } else {
                $mensajeError .= $e->getMessage();
            }
            
            $response->getBody()->write(json_encode([
                'success' => false, 
                'message' => $mensajeError
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    /**
     * Normaliza el término de búsqueda para ignorar acentos, mayúsculas y caracteres especiales
     */
    private function normalizeSearchTerm(string $term): string
    {
        // Convertir a minúsculas
        $term = mb_strtolower($term, 'UTF-8');
        
        // Reemplazar acentos y caracteres especiales
        $replacements = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
            'â' => 'a', 'ê' => 'e', 'î' => 'i', 'ô' => 'o', 'û' => 'u',
            'ã' => 'a', 'õ' => 'o', 'ñ' => 'n',
            'ç' => 'c', 'ş' => 's', 'ţ' => 't'
        ];
        
        $term = strtr($term, $replacements);
        
        // Remover caracteres especiales y múltiples espacios
        $term = preg_replace('/[^a-z0-9\s]/', ' ', $term);
        $term = preg_replace('/\s+/', ' ', $term);
        
        return trim($term);
    }
} 