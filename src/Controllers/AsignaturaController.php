<?php

namespace App\Controllers;

use src\Models\Asignatura;
use src\Models\Carrera;
use src\Models\Departamento;
use App\Core\BaseController;
use App\Core\Response;
use App\Core\Session;
use App\Core\Config;
use PDO;
use PDOException;
use src\Models\Usuario;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class AsignaturaController extends BaseController
{
    protected $asignaturaModel;
    protected $carreraModel;
    protected $session;
    protected $db;
    protected $twig;

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->asignaturaModel = new Asignatura();
        $this->carreraModel = new Carrera();
        
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

        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;
    }

    public function index(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las asignaturas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener filtros de los query parameters
            $queryParams = $request->getQueryParams();
            $nombre = $queryParams['nombre'] ?? null;
            $tipo = $queryParams['tipo'] ?? null;
            $unidad = $queryParams['unidad'] ?? null;
            $estado = $queryParams['estado'] ?? null;

            // Construir la consulta base
            $query = "SELECT 
                a.id,
                a.nombre,
                a.tipo,
                a.vigencia_desde,
                a.vigencia_hasta,
                a.periodicidad,
                a.estado,
                GROUP_CONCAT(CONCAT(ad.codigo_asignatura, ' - ', u.nombre) SEPARATOR '\n') as unidades 
                FROM asignaturas a 
                LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id 
                LEFT JOIN unidades u ON ad.id_unidad = u.id";

            $params = [];
            $where = [];

            if ($nombre) {
                $where[] = "a.nombre LIKE ?";
                $params[] = "%{$nombre}%";
            }

            if ($tipo) {
                $where[] = "a.tipo = ?";
                $params[] = $tipo;
            }

            if ($unidad) {
                $where[] = "ad.id_unidad = ?";
                $params[] = $unidad;
            }

            if ($estado !== null && $estado !== '') {
                $where[] = "a.estado = ?";
                $params[] = $estado;
            }

            if (!empty($where)) {
                $query .= " WHERE " . implode(" AND ", $where);
            }

            $query .= " GROUP BY a.id, a.nombre, a.tipo, a.vigencia_desde, a.vigencia_hasta, a.periodicidad, a.estado ORDER BY a.nombre";

            // Ejecutar la consulta
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener unidades para el filtro
            $stmt = $this->db->query("SELECT * FROM unidades WHERE estado = 1 ORDER BY nombre");
            $unidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Renderizar la vista
            $html = $this->twig->render('asignaturas/index.twig', [
                'asignaturas' => $asignaturas,
                'unidades' => $unidades,
                'filtros' => [
                    'nombre' => $nombre,
                    'tipo' => $tipo,
                    'unidad' => $unidad,
                    'estado' => $estado
                ],
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar las asignaturas: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'dashboard')
                ->withStatus(302);
        }
    }

    public function show(Request $request, ResponseInterface $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para ver los detalles de la asignatura');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos básicos de la asignatura
            $stmt = $this->db->prepare("
                SELECT a.id, a.nombre, a.tipo, a.vigencia_desde, a.vigencia_hasta,
                       a.periodicidad, a.estado
                FROM asignaturas a
                WHERE a.id = ?
            ");
            $stmt->execute([$id]);
            $asignatura = $stmt->fetch();
        
            if (!$asignatura) {
                $this->session->set('error', 'Asignatura no encontrada');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);
            }

            // Si es una asignatura regular, obtener información de unidades
            if ($asignatura['tipo'] == 'REGULAR') {
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura as codigo_asignatura,
                        ad.id_unidad,
                        ad.cantidad_alumnos,
                        u.id as unidad_id,
                        u.nombre as unidad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN unidades u ON ad.id_unidad = u.id
                    JOIN sedes s ON u.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, u.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['unidades'] = $stmt->fetchAll();
            } else {
                // Si es una asignatura de formación, obtener información de unidades
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura,
                        ad.id_unidad,
                        ad.cantidad_alumnos,
                        u.id as unidad_id,
                        u.nombre as unidad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN unidades u ON ad.id_unidad = u.id
                    JOIN sedes s ON u.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, u.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['unidades'] = $stmt->fetchAll();

                // Si es una asignatura de formación electiva, obtener las asignaturas vinculadas
                if ($asignatura['tipo'] == 'FORMACION_ELECTIVA') {
                    $stmt = $this->db->prepare("
                        SELECT 
                            a.id,
                            a.nombre,
                            a.tipo,
                            a.estado,
                            a.periodicidad,
                            ad.codigo_asignatura
                        FROM asignaturas_formacion af
                        JOIN asignaturas a ON af.asignatura_regular_id = a.id
                        LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                        WHERE af.asignatura_formacion_id = ?
                        GROUP BY a.id, a.nombre, a.tipo, a.estado, a.periodicidad, ad.codigo_asignatura
                        ORDER BY a.nombre
                    ");
                    $stmt->execute([$id]);
                    $asignatura['vinculadas'] = $stmt->fetchAll();
                }
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Renderizar la vista
            $html = $this->twig->render('asignaturas/show.twig', [
                'asignatura' => $asignatura,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@show: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar los detalles de la asignatura');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                ->withStatus(302);
        }
    }

    public function store(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            error_log("=== AsignaturaController@store: INICIANDO ===");
            error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);
            error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
            error_log("URI de Slim: " . $request->getUri()->getPath());
            $isAjax = $this->isAjaxRequest();
            error_log("Es AJAX: " . ($isAjax ? 'Sí' : 'No'));

            // Obtener los datos SOLO UNA VEZ
            $contentType = $request->getHeaderLine('Content-Type');
            if (strpos($contentType, 'application/json') !== false) {
                $inputData = $request->getBody()->getContents();
                error_log("[LOG] Datos JSON recibidos: " . $inputData);
                $data = json_decode($inputData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log("[LOG] Error al decodificar JSON: " . json_last_error_msg());
                    if ($isAjax) {
                        $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al decodificar JSON: ' . json_last_error_msg()]));
                        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                    }
                }
            } else {
                $data = $request->getParsedBody();
                error_log("[LOG] Datos de formulario recibidos: " . print_r($data, true));
            }

            $nombre = trim($data['nombre'] ?? '');
            $tipo = $data['tipo'] ?? '';
            $vigencia_desde = $data['vigencia_desde'] ?? '';
            $vigencia_hasta = $data['vigencia_hasta'] ?? '';
            $periodicidad = $data['periodicidad'] ?? '';
            $estado = $data['estado'] ?? '1';
            $codigos = $data['codigos'] ?? [];

            error_log("[LOG] Antes de validación");
            $validationData = [
                'nombre' => $nombre,
                'tipo' => $tipo,
                'vigencia_desde' => $vigencia_desde,
                'vigencia_hasta' => $vigencia_hasta,
                'periodicidad' => $periodicidad,
                'estado' => $estado,
                'codigos' => $codigos
            ];
            $errors = $this->validateAsignaturaData($validationData, null);
            error_log("[LOG] Errores de validación: " . print_r($errors, true));

            if (!empty($errors)) {
                error_log("[LOG] Validación fallida");
                if ($isAjax) {
                    // Obtener el primer error específico para el mensaje
                    $firstError = reset($errors);
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $firstError, 'errors' => $errors]));
                    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                }
                $this->session->set('error', 'Por favor corrija los errores en el formulario');
                $this->session->set('form_data', $validationData);
                $this->session->set('form_errors', $errors);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas/create')
                    ->withStatus(302);
            }

            error_log("[LOG] Antes de iniciar transacción");
            $this->db->beginTransaction();
            try {
                error_log("[LOG] Insertando asignatura");
                
                // Usar el modelo Eloquent para crear la asignatura
                $asignatura = new \src\Models\Asignatura();
                $asignatura->nombre = $nombre;
                $asignatura->tipo = $tipo;
                $asignatura->vigencia_desde = $vigencia_desde;
                $asignatura->vigencia_hasta = $vigencia_hasta;
                $asignatura->periodicidad = $periodicidad;
                $asignatura->estado = $estado;
                $asignatura->save();
                
                $asignatura_id = $asignatura->id;
                error_log("[LOG] Asignatura insertada con ID: $asignatura_id");

                // Insertar códigos de unidad
                $stmt = $this->db->prepare("
                    INSERT INTO asignaturas_departamentos (
                        asignatura_id, id_unidad, codigo_asignatura, 
                        cantidad_alumnos, fecha_creacion, fecha_actualizacion
                    ) VALUES (?, ?, ?, ?, NOW(), NOW())
                ");
                
                // Si es Formación Electiva, usar valores por defecto
                if ($tipo === 'FORMACION_ELECTIVA') {
                    // Obtener el ID de la unidad "Sin unidad"
                    $stmtUnidad = $this->db->prepare("
                        SELECT id FROM unidades WHERE nombre = 'Sin unidad' LIMIT 1
                    ");
                    $stmtUnidad->execute();
                    $sinUnidad = $stmtUnidad->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$sinUnidad) {
                        // Si no existe "Sin unidad", crearla
                        $stmtCreateUnidad = $this->db->prepare("
                            INSERT INTO unidades (codigo, nombre, sede_id, estado) VALUES ('SIN_UNIDAD', 'Sin unidad', 1, 1)
                        ");
                        $stmtCreateUnidad->execute();
                        $sinUnidadId = $this->db->lastInsertId();
                    } else {
                        $sinUnidadId = $sinUnidad['id'];
                    }

                    // Insertar con valores por defecto para Formación Electiva
                    foreach ($codigos as $codigo) {
                        if (!empty($codigo['codigo'])) {
                            error_log("[LOG] Insertando código Formación Electiva: " . print_r($codigo, true));
                            $stmt->execute([
                                $asignatura_id,
                                $sinUnidadId,
                                $codigo['codigo'],
                                0  // Cantidad de alumnos = 0
                            ]);
                        }
                    }
                } else {
                    // Para otros tipos de asignatura, procesar normalmente
                    foreach ($codigos as $codigo) {
                        if (!empty($codigo['id_unidad']) && !empty($codigo['codigo'])) {
                            error_log("[LOG] Insertando código: " . print_r($codigo, true));
                            $stmt->execute([
                                $asignatura_id,
                                $codigo['id_unidad'],
                                $codigo['codigo'],
                                $codigo['cantidad_alumnos'] ?? 0
                            ]);
                        }
                    }
                }
                error_log("[LOG] Antes de commit");
                $this->db->commit();
                error_log("[LOG] Commit realizado correctamente");

                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => true, 'message' => 'Asignatura creada exitosamente']));
                    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                }
                $this->session->set('success', 'Asignatura creada exitosamente');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);
            } catch (\Exception $e) {
                error_log("[LOG] Excepción en la transacción: " . $e->getMessage());
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("[LOG] Excepción general: " . $e->getMessage());
            if ($isAjax ?? false) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al crear la asignatura: ' . $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
            }
            $this->session->set('error', 'Error al crear la asignatura: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas/create')
                ->withStatus(302);
        }
    }

    public function edit(Request $request, ResponseInterface $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para editar asignaturas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener datos básicos de la asignatura
            $stmt = $this->db->prepare("
                SELECT a.id, a.nombre, a.tipo, a.vigencia_desde, a.vigencia_hasta,
                       a.periodicidad, a.estado
                FROM asignaturas a
                WHERE a.id = ?
            ");
            $stmt->execute([$id]);
            $asignatura = $stmt->fetch();

            if (!$asignatura) {
                $this->session->set('error', 'Asignatura no encontrada');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);
            }

            // Obtener códigos de asignatura por unidad
            $stmt = $this->db->prepare("
                SELECT ad.codigo_asignatura, ad.id_unidad, ad.cantidad_alumnos,
                       COALESCE(u.nombre, 'Sin unidad') as unidad_nombre
                FROM asignaturas_departamentos ad
                LEFT JOIN unidades u ON ad.id_unidad = u.id
                WHERE ad.asignatura_id = ?
                ORDER BY COALESCE(u.nombre, 'Sin unidad')
            ");
            $stmt->execute([$id]);
            $asignatura['unidades'] = $stmt->fetchAll();
            
            // Log para depuración
            error_log("Asignatura ID: " . $id);
            error_log("Unidades encontradas: " . count($asignatura['unidades']));
            error_log("Datos de unidades: " . print_r($asignatura['unidades'], true));

            // Obtener asignaturas vinculadas si es formación electiva
            if ($asignatura['tipo'] == 'FORMACION_ELECTIVA') {
                $stmt = $this->db->prepare("
                    SELECT a.id, a.nombre, a.tipo, a.estado
                    FROM asignaturas a
                    JOIN asignaturas_formacion af ON a.id = af.asignatura_regular_id
                    WHERE af.asignatura_formacion_id = ?
                    ORDER BY a.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['vinculadas'] = $stmt->fetchAll();
            }

            // Obtener unidades con su jerarquía
            $stmt = $this->db->prepare("
                SELECT u.id, u.nombre as unidad_nombre,
                       COALESCE(s.nombre, 'Sin sede') as sede_nombre
                FROM unidades u
                LEFT JOIN sedes s ON u.sede_id = s.id
                WHERE u.estado = 1
                ORDER BY COALESCE(s.nombre, 'Sin sede') ASC, u.nombre ASC
            ");
            $stmt->execute();
            $unidades = $stmt->fetchAll();

            // Obtener datos del usuario
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$this->session->get('user_id')]);
            $user = $stmt->fetch();

            // Renderizar la vista
            $html = $this->twig->render('asignaturas/edit.twig', [
                'asignatura' => $asignatura,
                'unidades' => $unidades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@edit: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de edición');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                ->withStatus(302);
        }
    }

    public function update(Request $request, ResponseInterface $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar si es una solicitud AJAX
            $isAjax = $this->isAjaxRequest();
            
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => 'Por favor inicie sesión para actualizar asignaturas']));
                    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                }
                $this->session->set('error', 'Por favor inicie sesión para actualizar asignaturas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener los datos según el tipo de solicitud
            $parsedBody = $request->getParsedBody();
            $isJson = $isAjax || strpos($request->getHeaderLine('Content-Type'), 'application/json') !== false;
            
            if ($isJson) {
                $inputData = $request->getBody()->getContents();
                $data = json_decode($inputData, true);
                
                $nombre = trim($data['nombre'] ?? '');
                $tipo = $data['tipo'] ?? '';
                $vigencia_desde = $data['vigencia_desde'] ?? '';
                $vigencia_hasta = $data['vigencia_hasta'] ?? '';
                $periodicidad = $data['periodicidad'] ?? '';
                $estado = $data['estado'] ?? '1';
                $codigos = $data['codigos'] ?? [];
            } else {
                $nombre = trim($parsedBody['nombre'] ?? '');
                $tipo = $parsedBody['tipo'] ?? '';
                $vigencia_desde = $parsedBody['vigencia_desde'] ?? '';
                $vigencia_hasta = $parsedBody['vigencia_hasta'] ?? '';
                $periodicidad = $parsedBody['periodicidad'] ?? '';
                $estado = $parsedBody['estado'] ?? '1';
                $codigos = $parsedBody['codigos'] ?? [];
            }

            // Validar datos
            $validationData = [
                'nombre' => $nombre,
                'tipo' => $tipo,
                'vigencia_desde' => $vigencia_desde,
                'vigencia_hasta' => $vigencia_hasta,
                'periodicidad' => $periodicidad,
                'estado' => $estado,
                'codigos' => $codigos
            ];

            $errors = $this->validateAsignaturaData($validationData, $id);

            if (!empty($errors)) {
                if ($isAjax) {
                    // Obtener el primer error específico para el mensaje
                    $firstError = reset($errors);
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $firstError, 'errors' => $errors]));
                    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                }
                
                $this->session->set('error', 'Por favor corrija los errores en el formulario');
                $this->session->set('form_data', $validationData);
                $this->session->set('form_errors', $errors);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas/' . $id . '/edit')
                    ->withStatus(302);
            }

            // Iniciar transacción
            $this->db->beginTransaction();

            try {
                // Actualizar datos básicos de la asignatura
                $stmt = $this->db->prepare("
                    UPDATE asignaturas 
                    SET nombre = ?, tipo = ?, vigencia_desde = ?, 
                        vigencia_hasta = ?, periodicidad = ?, estado = ?
                    WHERE id = ?
                ");
                
                $stmt->execute([
                    $nombre,
                    $tipo,
                    $vigencia_desde,
                    $vigencia_hasta ?: null,
                    $periodicidad,
                    $estado,
                    $id
                ]);

                // Eliminar códigos existentes
                $stmt = $this->db->prepare("
                    DELETE FROM asignaturas_departamentos 
                    WHERE asignatura_id = ?
                ");
                $stmt->execute([$id]);

                // Procesar los códigos de asignatura
                $stmt = $this->db->prepare("
                    INSERT INTO asignaturas_departamentos (
                        asignatura_id, id_unidad, codigo_asignatura, cantidad_alumnos
                    ) VALUES (?, ?, ?, ?)
                ");

                // Si es Formación Electiva, usar valores por defecto
                if ($tipo === 'FORMACION_ELECTIVA') {
                    // Obtener el ID de la unidad "Sin unidad"
                    $stmtUnidad = $this->db->prepare("
                        SELECT id FROM unidades WHERE nombre = 'Sin unidad' LIMIT 1
                    ");
                    $stmtUnidad->execute();
                    $sinUnidad = $stmtUnidad->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$sinUnidad) {
                        // Si no existe "Sin unidad", crearla
                        $stmtCreateUnidad = $this->db->prepare("
                            INSERT INTO unidades (codigo, nombre, sede_id, estado) VALUES ('SIN_UNIDAD', 'Sin unidad', 1, 1)
                        ");
                        $stmtCreateUnidad->execute();
                        $sinUnidadId = $this->db->lastInsertId();
                    } else {
                        $sinUnidadId = $sinUnidad['id'];
                    }

                    // Insertar con valores por defecto para Formación Electiva
                    foreach ($codigos as $codigo) {
                        $stmt->execute([
                            $id,
                            $sinUnidadId,
                            $codigo['codigo'],
                            0  // Cantidad de alumnos = 0
                        ]);
                    }
                } else {
                    // Para otros tipos de asignatura, procesar normalmente
                    foreach ($codigos as $codigo) {
                        $stmt->execute([
                            $id,
                            $codigo['id_unidad'],
                            $codigo['codigo'],
                            $codigo['cantidad_alumnos']
                        ]);
                    }
                }

                $this->db->commit();

                if ($isAjax) {
                    $response->getBody()->write(json_encode(['success' => true, 'message' => 'Asignatura actualizada exitosamente']));
                    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                }

                $this->session->set('success', 'Asignatura actualizada exitosamente');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);

            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@update: " . $e->getMessage());
            
            if ($isAjax) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al actualizar la asignatura: ' . $e->getMessage()]));
                return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
            }

            $this->session->set('error', 'Error al actualizar la asignatura: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas/' . $id . '/edit')
                ->withStatus(302);
        }
    }

    public function destroy(Request $request, ResponseInterface $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', 'Por favor inicie sesión para eliminar asignaturas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Verificar si la asignatura existe
            $stmt = $this->db->prepare("SELECT id, nombre, tipo FROM asignaturas WHERE id = ?");
            $stmt->execute([$id]);
            $asignatura = $stmt->fetch();

            if (!$asignatura) {
                $mensaje = 'La asignatura no existe o ya fue eliminada.';
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);
            }

            // Verificar si la asignatura tiene bibliografías vinculadas
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as total 
                FROM asignaturas_bibliografias 
                WHERE asignatura_id = ? AND estado = 'activa'
            ");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch();
            
            if ($resultado['total'] > 0) {
                $mensaje = 'No se puede eliminar la asignatura "' . $asignatura['nombre'] . '" porque tiene bibliografías declaradas vinculadas. Debe desvincular las bibliografías antes de eliminar la asignatura.';
                
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode([
                        'success' => false, 
                        'message' => $mensaje,
                        'type' => 'warning'
                    ]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);
            }

            // Si es una asignatura de Formación Electiva, verificar que no tenga asignaturas vinculadas
            if ($asignatura['tipo'] === 'FORMACION_ELECTIVA') {
                $stmt = $this->db->prepare("
                    SELECT COUNT(*) as total 
                    FROM asignaturas_formacion 
                    WHERE asignatura_formacion_id = ?
                ");
                $stmt->execute([$id]);
                $resultadoVinculaciones = $stmt->fetch();
                
                if ($resultadoVinculaciones['total'] > 0) {
                    $mensaje = 'No se puede eliminar la asignatura de Formación Electiva "' . $asignatura['nombre'] . '" porque tiene asignaturas vinculadas. Debe desvincular las asignaturas antes de eliminar la asignatura de Formación Electiva.';
                    
                    if ($this->isAjaxRequest()) {
                        $response->getBody()->write(json_encode([
                            'success' => false, 
                            'message' => $mensaje,
                            'type' => 'warning'
                        ]));
                        return $response->withHeader('Content-Type', 'application/json');
                    }
                    
                    $this->session->set('error', $mensaje);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                        ->withStatus(302);
                }
            }

            // Iniciar transacción
            $this->db->beginTransaction();

            try {
                // Eliminar relaciones en asignaturas_departamentos
                $stmt = $this->db->prepare("DELETE FROM asignaturas_departamentos WHERE asignatura_id = ?");
                $stmt->execute([$id]);

                // Eliminar relaciones en asignaturas_formacion
                $stmt = $this->db->prepare("DELETE FROM asignaturas_formacion WHERE asignatura_formacion_id = ? OR asignatura_regular_id = ?");
                $stmt->execute([$id, $id]);

                // Eliminar relaciones en asignaturas_bibliografias (por si acaso hay registros inactivos)
                $stmt = $this->db->prepare("DELETE FROM asignaturas_bibliografias WHERE asignatura_id = ?");
                $stmt->execute([$id]);

                // Eliminar la asignatura
                $stmt = $this->db->prepare("DELETE FROM asignaturas WHERE id = ?");
                $stmt->execute([$id]);

                $this->db->commit();

                $mensajeExito = 'Asignatura "' . $asignatura['nombre'] . '" eliminada exitosamente';
                
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode([
                        'success' => true, 
                        'message' => $mensajeExito,
                        'type' => 'success'
                    ]));
                    return $response->withHeader('Content-Type', 'application/json');
                }

                $this->session->set('success', $mensajeExito);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                    ->withStatus(302);

            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@destroy: " . $e->getMessage());
            
            $mensajeError = 'Error al eliminar la asignatura: ' . $e->getMessage();
            
            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => $mensajeError,
                    'type' => 'error'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $this->session->set('error', $mensajeError);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                ->withStatus(302);
        }
    }

    public function getAsignaturas(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            $filters = $request->getQueryParams();
            $asignaturas = $this->asignaturaModel->getFiltered($filters);
            
            $response->getBody()->write(json_encode($asignaturas));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'message' => 'Error al obtener las asignaturas',
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function create(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para crear asignaturas');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener unidades con su jerarquía
            $stmt = $this->db->prepare("
                SELECT u.id, u.nombre as unidad_nombre,
                       COALESCE(s.nombre, 'Sin sede') as sede_nombre
                FROM unidades u
                LEFT JOIN sedes s ON u.sede_id = s.id
                WHERE u.estado = 1
                ORDER BY COALESCE(s.nombre, 'Sin sede') ASC, u.nombre ASC
            ");
            $stmt->execute();
            $unidades = $stmt->fetchAll();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            $html = $this->twig->render('asignaturas/create.twig', [
                'unidades' => $unidades,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@create: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de creación de asignatura');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                ->withStatus(302);
        }
    }

    private function validateAsignaturaData($data, $asignaturaId = null)
    {
        $errors = [];

        // Validación de datos básicos
        if (empty($data['nombre'])) {
            $errors['nombre'] = 'El nombre es requerido';
        }

        if (empty($data['tipo'])) {
            $errors['tipo'] = 'El tipo es requerido';
        }

        // Validación de vigencia_desde
        if (empty($data['vigencia_desde'])) {
            $errors['vigencia_desde'] = 'La vigencia desde es requerida';
        } else {
            if (!preg_match('/^\d{6}$/', $data['vigencia_desde'])) {
                $errors['vigencia_desde'] = 'La vigencia desde debe ser un número de 6 dígitos';
            } else {
                $anio = substr($data['vigencia_desde'], 0, 4);
                $secuencia = substr($data['vigencia_desde'], 4, 2);
                
                // Permitir el valor especial 999999 para vigencia indefinida
                if ($data['vigencia_desde'] === '999999') {
                    // Valor especial permitido, no validar año ni secuencia
                } else {
                    if ($anio < 1900 || $anio > date('Y')) {
                        $errors['vigencia_desde'] = 'El año debe estar entre 1900 y el año actual';
                    }
                    if ($secuencia < 1 || $secuencia > 99) {
                        $errors['vigencia_desde'] = 'La secuencia debe estar entre 01 y 99';
                    }
                }
            }
        }

        // Validación de vigencia_hasta
        if (!empty($data['vigencia_hasta'])) {
            if (!preg_match('/^\d{6}$/', $data['vigencia_hasta'])) {
                $errors['vigencia_hasta'] = 'La vigencia hasta debe ser un número de 6 dígitos';
            } else {
                $anio = substr($data['vigencia_hasta'], 0, 4);
                $secuencia = substr($data['vigencia_hasta'], 4, 2);
                
                // Permitir el valor especial 999999 para vigencia indefinida
                if ($data['vigencia_hasta'] === '999999') {
                    // Valor especial permitido, no validar año ni secuencia
                } else {
                    if ($anio < 1900 || $anio > date('Y')) {
                        $errors['vigencia_hasta'] = 'El año debe estar entre 1900 y el año actual';
                    }
                    if ($secuencia < 1 || $secuencia > 99) {
                        $errors['vigencia_hasta'] = 'La secuencia debe estar entre 01 y 99';
                    }
                }
                
                // Validar que vigencia_hasta sea mayor o igual a vigencia_desde
                if (isset($data['vigencia_desde']) && 
                    $data['vigencia_desde'] !== '999999' && 
                    $data['vigencia_hasta'] !== '999999' && 
                    $data['vigencia_hasta'] < $data['vigencia_desde']) {
                    $errors['vigencia_hasta'] = 'La vigencia hasta debe ser mayor o igual a la vigencia desde';
                }
            }
        }

        if (empty($data['periodicidad'])) {
            $errors['periodicidad'] = 'La periodicidad es requerida';
        }

        if (!isset($data['estado'])) {
            $errors['estado'] = 'El estado es requerido';
        }

        // Validación de códigos
        if (empty($data['codigos']) || !is_array($data['codigos'])) {
            $errors['codigos'] = 'Debe ingresar al menos un código de asignatura';
        } else {
            // Validar códigos duplicados
            $codigos = [];
            $codigosDuplicados = [];
            
            foreach ($data['codigos'] as $index => $codigo) {
                // Para Formación Electiva, no validar unidad ni cantidad de alumnos
                if ($data['tipo'] !== 'FORMACION_ELECTIVA') {
                    if (empty($codigo['id_unidad'])) {
                        $errors["codigos.{$index}.id_unidad"] = 'La unidad es requerida';
                    }
                    if (empty($codigo['cantidad_alumnos'])) {
                        $errors["codigos.{$index}.cantidad_alumnos"] = 'La cantidad de alumnos es requerida';
                    }
                }
                
                if (empty($codigo['codigo'])) {
                    $errors["codigos.{$index}.codigo"] = 'El código es requerido';
                } else {
                    // Verificar duplicados dentro del formulario
                    $codigoKey = $codigo['codigo'];
                    if (isset($codigos[$codigoKey])) {
                        $codigosDuplicados[] = $codigoKey;
                    } else {
                        $codigos[$codigoKey] = $index;
                    }
                }
            }
            
            // Mostrar error para códigos duplicados dentro del formulario
            if (!empty($codigosDuplicados)) {
                $codigosUnicos = array_unique($codigosDuplicados);
                $errors['codigos_duplicados_formulario'] = 'Los siguientes códigos están duplicados en el formulario: ' . implode(', ', $codigosUnicos);
            }
            
            // Validar códigos duplicados en la base de datos
            if (empty($errors)) {
                foreach ($data['codigos'] as $index => $codigo) {
                    if (!empty($codigo['codigo'])) {
                        $codigoDuplicado = $this->verificarCodigoDuplicado($codigo['codigo'], $asignaturaId);
                        if ($codigoDuplicado) {
                            $errors["codigos.{$index}.codigo"] = "El código '{$codigo['codigo']}' ya existe en la asignatura '{$codigoDuplicado['nombre_asignatura']}' de la unidad '{$codigoDuplicado['nombre_unidad']}'";
                        }
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * Verifica si un código de asignatura ya existe en la base de datos
     * @param string $codigo
     * @param int|null $asignaturaId (para excluir la asignatura actual en edición)
     * @return array|false Retorna información del duplicado o false si no existe
     */
    private function verificarCodigoDuplicado($codigo, $asignaturaId = null)
    {
        try {
            if ($asignaturaId) {
                // Para edición: excluir la asignatura actual
                $stmt = $this->db->prepare("
                    SELECT 
                        a.nombre as nombre_asignatura,
                        u.nombre as nombre_unidad,
                        ad.codigo_asignatura
                    FROM asignaturas_departamentos ad
                    JOIN asignaturas a ON ad.asignatura_id = a.id
                    JOIN unidades u ON ad.id_unidad = u.id
                    WHERE ad.codigo_asignatura = ? 
                    AND ad.asignatura_id != ?
                    AND a.estado = 1
                    LIMIT 1
                ");
                $stmt->execute([$codigo, $asignaturaId]);
            } else {
                // Para creación: verificar todos los códigos
                $stmt = $this->db->prepare("
                    SELECT 
                        a.nombre as nombre_asignatura,
                        u.nombre as nombre_unidad,
                        ad.codigo_asignatura
                    FROM asignaturas_departamentos ad
                    JOIN asignaturas a ON ad.asignatura_id = a.id
                    JOIN unidades u ON ad.id_unidad = u.id
                    WHERE ad.codigo_asignatura = ? 
                    AND a.estado = 1
                    LIMIT 1
                ");
                $stmt->execute([$codigo]);
            }
            
            $resultado = $stmt->fetch();
            return $resultado ? $resultado : false;
            
        } catch (\Exception $e) {
            error_log("Error en verificarCodigoDuplicado: " . $e->getMessage());
            return false;
        }
    }

    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function vinculacion(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a esta funcionalidad');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'login')
                    ->withStatus(302);
            }

            // Obtener asignaturas de tipo Formación Electiva
            $stmt = $this->db->prepare("
                SELECT DISTINCT a.id, a.nombre, a.tipo,
                       GROUP_CONCAT(DISTINCT CONCAT(ad.codigo_asignatura) ORDER BY ad.codigo_asignatura ASC SEPARATOR ', ') as codigos
                FROM asignaturas a
                LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                WHERE a.tipo = 'FORMACION_ELECTIVA'
                AND a.estado = 1 
                GROUP BY a.id, a.nombre, a.tipo
                ORDER BY a.nombre
            ");
            $stmt->execute();
            $asignaturas_electivas = $stmt->fetchAll();

            // Obtener tipos de asignaturas (excluyendo Formación Electiva)
            $tipos_asignaturas = [
                'REGULAR' => 'Regular',
                'FORMACION_BASICA' => 'Formación Básica',
                'FORMACION_GENERAL' => 'Formación General',
                'FORMACION_IDIOMAS' => 'Formación Idiomas',
                'FORMACION_PROFESIONAL' => 'Formación Profesional',
                'FORMACION_VALORES' => 'Formación Valores',
                'FORMACION_ESPECIALIDAD' => 'Formación Especialidad',
                'FORMACION_ESPECIAL' => 'Formación Especial'
            ];

            // Obtener datos del usuario
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$this->session->get('user_id')]);
            $user = $stmt->fetch();

            // Renderizar la vista usando la instancia de Twig del controlador
            $html = $this->twig->render('asignaturas/vinculacion.twig', [
                'asignaturas_electivas' => $asignaturas_electivas,
                'tipos_asignaturas' => $tipos_asignaturas,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@vinculacion: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar la página de vinculación: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'asignaturas')
                ->withStatus(302);
        }
    }

    public function getVinculacion(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $asignaturaFormacionId = $args['id'] ?? null;
            if (!$asignaturaFormacionId) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'ID de asignatura no proporcionado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Obtener el tipo de asignatura solicitado
            $queryParams = $request->getQueryParams();
            $tipo = $queryParams['tipo'] ?? 'REGULAR';

            // Obtener asignaturas vinculadas del tipo especificado
            $stmt = $this->db->prepare("
                SELECT DISTINCT a.id, a.nombre, a.tipo
                FROM asignaturas a
                JOIN asignaturas_formacion af ON a.id = af.asignatura_regular_id
                WHERE af.asignatura_formacion_id = ?
                AND a.tipo = ?
                AND a.estado = 1
                ORDER BY a.nombre
            ");
            $stmt->execute([$asignaturaFormacionId, $tipo]);
            $vinculadas = $stmt->fetchAll();

            // Obtener asignaturas no vinculadas del tipo especificado
            $stmt = $this->db->prepare("
                SELECT DISTINCT a.id, a.nombre, a.tipo
                FROM asignaturas a
                WHERE a.tipo = ?
                AND a.estado = 1
                AND a.id NOT IN (
                    SELECT asignatura_regular_id 
                    FROM asignaturas_formacion 
                    WHERE asignatura_formacion_id = ?
                )
                AND a.id != ?  -- Evitar que una asignatura se vincule a sí misma
                ORDER BY a.nombre
            ");
            $stmt->execute([$tipo, $asignaturaFormacionId, $asignaturaFormacionId]);
            $no_vinculadas = $stmt->fetchAll();

            $response->getBody()->write(json_encode([
                'success' => true,
                'vinculadas' => $vinculadas,
                'no_vinculadas' => $no_vinculadas
            ]));
            return $response->withHeader('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@getVinculacion: " . $e->getMessage());
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al obtener las asignaturas']));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function agregarVinculacion(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $asignaturaFormacionId = $args['id'] ?? null;
            if (!$asignaturaFormacionId) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'ID de asignatura no proporcionado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Obtener datos de la solicitud
            $inputData = $request->getBody()->getContents();
            $input = json_decode($inputData, true);
            $asignaturasIds = $input['asignaturas'] ?? [];

            if (empty($asignaturasIds)) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No se especificaron asignaturas']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Iniciar transacción
            $this->db->beginTransaction();

            try {
                // Verificar que la asignatura formacion existe y es de tipo FORMACION_ELECTIVA
                $stmt = $this->db->prepare("
                    SELECT id, tipo 
                    FROM asignaturas 
                    WHERE id = ? AND tipo = 'FORMACION_ELECTIVA' AND estado = 1
                ");
                $stmt->execute([$asignaturaFormacionId]);
                $asignaturaFormacion = $stmt->fetch();

                if (!$asignaturaFormacion) {
                    throw new \Exception('La asignatura electiva no existe o no está activa');
                }

                // Verificar que las asignaturas a vincular existen y están activas
                $placeholders = str_repeat('?,', count($asignaturasIds) - 1) . '?';
                $stmt = $this->db->prepare("
                    SELECT id, tipo 
                    FROM asignaturas 
                    WHERE id IN ($placeholders) AND estado = 1
                ");
                $stmt->execute($asignaturasIds);
                $asignaturas = $stmt->fetchAll();

                if (count($asignaturas) !== count($asignaturasIds)) {
                    throw new \Exception('Una o más asignaturas no existen o no están activas');
                }

                // Insertar las vinculaciones
                $stmt = $this->db->prepare("
                    INSERT INTO asignaturas_formacion 
                    (asignatura_formacion_id, asignatura_regular_id) 
                    VALUES (?, ?)
                ");

                foreach ($asignaturasIds as $asignaturaId) {
                    $stmt->execute([$asignaturaFormacionId, $asignaturaId]);
                }

                $this->db->commit();
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Asignaturas vinculadas exitosamente']));
                return $response->withHeader('Content-Type', 'application/json');
                
            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@agregarVinculacion: " . $e->getMessage());
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al vincular las asignaturas: ' . $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function quitarVinculacion(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $asignaturaFormacionId = $args['id'] ?? null;
            if (!$asignaturaFormacionId) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'ID de asignatura no proporcionado']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Obtener datos de la solicitud
            $inputData = $request->getBody()->getContents();
            $input = json_decode($inputData, true);
            $asignaturasIds = $input['asignaturas'] ?? [];

            if (empty($asignaturasIds)) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No se especificaron asignaturas']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Iniciar transacción
            $this->db->beginTransaction();

            try {
                $stmt = $this->db->prepare("
                    DELETE FROM asignaturas_formacion
                    WHERE asignatura_formacion_id = ?
                    AND asignatura_regular_id = ?
                ");

                foreach ($asignaturasIds as $asignaturaId) {
                    $stmt->execute([$asignaturaFormacionId, $asignaturaId]);
                }

                $this->db->commit();
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Asignaturas desvinculadas exitosamente']));
                return $response->withHeader('Content-Type', 'application/json');
                
            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@quitarVinculacion: " . $e->getMessage());
            $response->getBody()->write(json_encode(['success' => false, 'message' => 'Error al desvincular las asignaturas']));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtiene las asignaturas por unidad (para AJAX).
     */
    public function getAsignaturasByUnidad(Request $request, ResponseInterface $response, array $args = [])
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['error' => 'No autorizado'], JSON_UNESCAPED_UNICODE));
                return $response
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withStatus(401);
            }

            $unidadId = $args['unidadId'] ?? null;
            
            if (!$unidadId) {
                $response->getBody()->write(json_encode(['error' => 'ID de unidad requerido'], JSON_UNESCAPED_UNICODE));
                return $response
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withStatus(400);
            }

            // Obtener asignaturas de la unidad
            $stmt = $this->db->prepare("
                SELECT DISTINCT 
                    a.id,
                    a.nombre,
                    a.tipo,
                    a.periodicidad,
                    a.estado,
                    GROUP_CONCAT(ad.codigo_asignatura ORDER BY ad.codigo_asignatura ASC SEPARATOR ', ') as codigos
                FROM asignaturas a
                INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                WHERE ad.id_unidad = ?
                AND a.estado = 1
                AND a.tipo IN ('REGULAR', 'FORMACION_ELECTIVA')
                GROUP BY a.id, a.nombre, a.tipo, a.periodicidad, a.estado
                ORDER BY a.nombre
            ");
            $stmt->execute([$unidadId]);
            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar los códigos para que sean arrays
            foreach ($asignaturas as &$asignatura) {
                $asignatura['codigos'] = $asignatura['codigos'] ? explode(', ', $asignatura['codigos']) : [];
            }

            $response->getBody()->write(json_encode($asignaturas, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
            
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@getAsignaturasByUnidad: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al obtener asignaturas'], JSON_UNESCAPED_UNICODE));
            return $response
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(500);
        }
    }
} 