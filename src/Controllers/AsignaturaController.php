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

class AsignaturaController extends BaseController
{
    protected $asignaturaModel;
    protected $carreraModel;
    protected $session;
    protected $db;

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
    }

    public function index()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a las asignaturas');
                header('Location: '. Config::get('app_url') . 'login');
                exit;
            }

            // Obtener filtros directamente de $_GET
            $tipo = $_GET['tipo'] ?? null;
            $departamento = $_GET['departamento'] ?? null;
            $estado = $_GET['estado'] ?? null;

            // Construir la consulta base
            $query = "SELECT 
                a.id,
                a.nombre,
                a.tipo,
                a.vigencia_desde,
                a.vigencia_hasta,
                a.periodicidad,
                a.estado,
                GROUP_CONCAT(CONCAT(ad.codigo_asignatura, ' - ', d.nombre) SEPARATOR '\n') as departamentos 
                FROM asignaturas a 
                LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id 
                LEFT JOIN departamentos d ON ad.departamento_id = d.id";

            $params = [];
            $where = [];

            if ($tipo) {
                $where[] = "a.tipo = :tipo";
                $params[':tipo'] = $tipo;
            }

            if ($departamento) {
                $where[] = "ad.departamento_id = :departamento";
                $params[':departamento'] = $departamento;
            }

            if ($estado !== null && $estado !== '') {
                $where[] = "a.estado = :estado";
                $params[':estado'] = $estado;
            }

            if (!empty($where)) {
                $query .= " WHERE " . implode(" AND ", $where);
            }

            $query .= " GROUP BY a.id, a.nombre, a.tipo, a.vigencia_desde, a.vigencia_hasta, a.periodicidad, a.estado ORDER BY a.nombre";

            // Ejecutar la consulta
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener departamentos para el filtro
            $stmt = $this->db->query("SELECT * FROM departamentos ORDER BY nombre");
            $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Usar la instancia global de Twig
            global $twig;
            echo $twig->render('asignaturas/index.twig', [
                'asignaturas' => $asignaturas,
                'departamentos' => $departamentos,
                'filtros' => [
                    'tipo' => $tipo,
                    'departamento' => $departamento,
                    'estado' => $estado
                ],
                'user' => $user,
                'app_url' => '/biblioges/',
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@index: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar las asignaturas: ' . $e->getMessage());
            header('Location: /biblioges/');
            exit;
        }
    }

    public function show($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para ver los detalles de la asignatura');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
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
                header('Location: ' . Config::get('app_url') . 'asignaturas');
                exit;
            }

            // Si es una asignatura regular, obtener información de departamentos
            if ($asignatura['tipo'] == 'REGULAR') {
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura as codigo_asignatura,
                        ad.departamento_id,
                        ad.cantidad_alumnos,
                        d.id as departamento_id,
                        d.nombre as departamento_nombre,
                        f.nombre as facultad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN departamentos d ON ad.departamento_id = d.id
                    JOIN facultades f ON d.facultad_id = f.id
                    JOIN sedes s ON f.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, d.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['departamentos'] = $stmt->fetchAll();
            } else {
                // Si es una asignatura de formación, obtener información de departamentos
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura as codigo_asignatura,
                        ad.departamento_id,
                        ad.cantidad_alumnos,
                        d.id as departamento_id,
                        d.nombre as departamento_nombre,
                        f.nombre as facultad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN departamentos d ON ad.departamento_id = d.id
                    JOIN facultades f ON d.facultad_id = f.id
                    JOIN sedes s ON f.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, d.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['departamentos'] = $stmt->fetchAll();

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
            echo $this->twig->render('asignaturas/show.twig', [
                'asignatura' => $asignatura,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@show: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar los detalles de la asignatura');
            header('Location: ' . Config::get('app_url') . 'asignaturas');
            exit;
        }
    }

    public function store()
    {
        try {
            // Verificar si es una solicitud AJAX
            $isAjax = $this->isAjaxRequest();
            
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['success' => false, 'message' => 'Por favor inicie sesión para crear asignaturas']);
                    exit;
                }
                $this->session->set('error', 'Por favor inicie sesión para crear asignaturas');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener los datos según el tipo de solicitud
            $isJson = $isAjax || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
            
            if ($isJson) {
                $inputData = file_get_contents('php://input');
                error_log("Datos recibidos: " . $inputData); // Log para depuración
                
                $data = json_decode($inputData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    if ($isAjax) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(['success' => false, 'message' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
                        exit;
                    }
                }
                
                $nombre = trim($data['nombre'] ?? '');
                $tipo = $data['tipo'] ?? '';
                $vigencia_desde = $data['vigencia_desde'] ?? '';
                $vigencia_hasta = $data['vigencia_hasta'] ?? '';
                $periodicidad = $data['periodicidad'] ?? '';
                $estado = $data['estado'] ?? '1';
                $codigos = $data['codigos'] ?? [];
            } else {
                $nombre = trim($_POST['nombre'] ?? '');
                $tipo = $_POST['tipo'] ?? '';
                $vigencia_desde = $_POST['vigencia_desde'] ?? '';
                $vigencia_hasta = $_POST['vigencia_hasta'] ?? '';
                $periodicidad = $_POST['periodicidad'] ?? '';
                $estado = $_POST['estado'] ?? '1';
                $codigos = $_POST['codigos'] ?? [];
            }

            // Validaciones
            $errores = [];

            if (empty($nombre)) {
                $errores[] = 'El nombre de la asignatura es requerido';
            }

            if (empty($tipo)) {
                $errores[] = 'El tipo de asignatura es requerido';
            }

            if (empty($vigencia_desde)) {
                $errores[] = 'La fecha de inicio de vigencia es requerida';
            }

            if (empty($periodicidad)) {
                $errores[] = 'La periodicidad es requerida';
            }

            // Validar códigos para todos los tipos de asignatura
            if (empty($codigos) || !is_array($codigos)) {
                $errores[] = 'Debe ingresar al menos un código de asignatura';
            } else {
                foreach ($codigos as $index => $codigo) {
                    if (empty($codigo['codigo'])) {
                        $errores[] = 'El código de asignatura es requerido';
                        break;
                    }
                    if ($tipo !== 'FORMACION_ELECTIVA') {
                        if (empty($codigo['departamento_id'])) {
                            $errores[] = 'El departamento es requerido';
                            break;
                        }
                        if (empty($codigo['cantidad_alumnos'])) {
                            $errores[] = 'La cantidad de alumnos es requerida';
                            break;
                        }
                    }
                }
            }

            // Si hay errores, devolver respuesta según el tipo de solicitud
            if (!empty($errores)) {
                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['success' => false, 'errors' => $errores]);
                    exit;
                } else {
                    $this->session->set('error', implode('. ', $errores));
                    header('Location: ' . Config::get('app_url') . 'asignaturas/create');
                    exit;
                }
            }

            // Iniciar transacción
            $this->db->beginTransaction();

            try {
            // Crear la asignatura principal
            $stmt = $this->db->prepare("
                INSERT INTO asignaturas (
                    nombre, tipo, vigencia_desde, vigencia_hasta, 
                    periodicidad, estado, fecha_creacion
                ) VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                    $nombre,
                    $tipo,
                    $vigencia_desde,
                    $vigencia_hasta,
                    $periodicidad,
                    $estado
            ]);

            $asignaturaId = $this->db->lastInsertId();

            // Procesar los códigos de asignatura
                $stmt = $this->db->prepare("
                    INSERT INTO asignaturas_departamentos (
                        asignatura_id, departamento_id, codigo_asignatura, cantidad_alumnos
                    ) VALUES (?, ?, ?, ?)
                ");

                // Si es Formación Electiva, usar valores por defecto
                if ($tipo === 'FORMACION_ELECTIVA') {
                    // Obtener el ID del departamento "Sin departamento"
                    $stmtDep = $this->db->prepare("
                        SELECT id FROM departamentos WHERE nombre = 'Sin departamento' LIMIT 1
                    ");
                    $stmtDep->execute();
                    $sinDepartamento = $stmtDep->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$sinDepartamento) {
                        // Si no existe "Sin departamento", crearlo
                        $stmtCreateDep = $this->db->prepare("
                            INSERT INTO departamentos (nombre, estado) VALUES ('Sin departamento', 1)
                        ");
                        $stmtCreateDep->execute();
                        $sinDepartamentoId = $this->db->lastInsertId();
                    } else {
                        $sinDepartamentoId = $sinDepartamento['id'];
                    }

                    // Insertar con valores por defecto para Formación Electiva
                    foreach ($codigos as $codigo) {
                        $stmt->execute([
                            $asignaturaId,
                            $sinDepartamentoId,
                            $codigo['codigo'],
                            0  // Cantidad de alumnos = 0
                        ]);
                    }
                } else {
                    // Para otros tipos de asignatura, procesar normalmente
                    foreach ($codigos as $codigo) {
                    $stmt->execute([
                        $asignaturaId,
                        $codigo['departamento_id'],
                        $codigo['codigo'],
                        $codigo['cantidad_alumnos']
                    ]);
                }
            }

                // Confirmar la transacción
            $this->db->commit();

                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['success' => true, 'message' => 'Asignatura creada exitosamente']);
                    exit;
                } else {
                    $this->session->set('success', 'Asignatura creada exitosamente');
                    header('Location: ' . Config::get('app_url') . 'asignaturas');
                    exit;
                }

            } catch (\Exception $e) {
                // Revertir la transacción en caso de error
                $this->db->rollBack();
                error_log("Error en AsignaturaController@store: " . $e->getMessage());
                
                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['success' => false, 'message' => 'Error al crear la asignatura: ' . $e->getMessage()]);
                    exit;
                } else {
                    $this->session->set('error', 'Error al crear la asignatura: ' . $e->getMessage());
                    header('Location: ' . Config::get('app_url') . 'asignaturas/create');
                    exit;
                }
            }
        } catch (\Exception $e) {
            error_log("Error general en AsignaturaController@store: " . $e->getMessage());
            
            if ($isAjax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'message' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
                exit;
            } else {
                $this->session->set('error', 'Error al procesar la solicitud: ' . $e->getMessage());
                header('Location: ' . Config::get('app_url') . 'asignaturas/create');
                exit;
            }
        }
    }

    public function edit($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para editar asignaturas');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
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
                header('Location: ' . Config::get('app_url') . 'asignaturas');
                exit;
            }

            // Si es una asignatura regular, obtener información de departamentos
            if ($asignatura['tipo'] == 'REGULAR') {
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura,
                        ad.departamento_id,
                        ad.cantidad_alumnos,
                        d.id as departamento_id,
                        d.nombre as departamento_nombre,
                        f.nombre as facultad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN departamentos d ON ad.departamento_id = d.id
                    JOIN facultades f ON d.facultad_id = f.id
                    JOIN sedes s ON f.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, d.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['departamentos'] = $stmt->fetchAll();
            } else {
                // Si es una asignatura de formación, obtener información de departamentos
                $stmt = $this->db->prepare("
                    SELECT 
                        ad.codigo_asignatura,
                        ad.departamento_id,
                        ad.cantidad_alumnos,
                        d.id as departamento_id,
                        d.nombre as departamento_nombre,
                        f.nombre as facultad_nombre,
                        s.nombre as sede_nombre
                    FROM asignaturas_departamentos ad
                    JOIN departamentos d ON ad.departamento_id = d.id
                    JOIN facultades f ON d.facultad_id = f.id
                    JOIN sedes s ON f.sede_id = s.id
                    WHERE ad.asignatura_id = ?
                    ORDER BY s.nombre, d.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['departamentos'] = $stmt->fetchAll();

                // Obtener asignaturas vinculadas
                $stmt = $this->db->prepare("
                    SELECT a.nombre, a.vigencia_desde, a.vigencia_hasta,
                           a.estado, a.periodicidad
                    FROM asignaturas a
                    JOIN asignaturas_formacion af ON a.id = af.asignatura_regular_id
                    WHERE af.asignatura_formacion_id = ?
                    ORDER BY a.nombre
                ");
                $stmt->execute([$id]);
                $asignatura['vinculadas'] = $stmt->fetchAll();
            }

            // Obtener lista de departamentos para el selector
            $stmt = $this->db->prepare("
                SELECT d.id, d.nombre as departamento_nombre,
                       f.nombre as facultad_nombre,
                       s.nombre as sede_nombre
                FROM departamentos d
                JOIN facultades f ON d.facultad_id = f.id
                JOIN sedes s ON f.sede_id = s.id
                WHERE d.estado = 1
                ORDER BY s.nombre ASC, f.nombre ASC, d.nombre ASC
            ");
            $stmt->execute();
            $departamentos = $stmt->fetchAll();

            // Obtener datos del usuario
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$this->session->get('user_id')]);
            $user = $stmt->fetch();

            // Renderizar la vista
            echo $this->twig->render('asignaturas/edit.twig', [
                'asignatura' => $asignatura,
                'departamentos' => $departamentos,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@edit: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de edición');
            header('Location: ' . Config::get('app_url') . 'asignaturas');
            exit;
        }
    }

    public function update($id)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para actualizar asignaturas');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Verificar si es una solicitud AJAX
            $isAjax = $this->isAjaxRequest();
            
            // Obtener datos según el tipo de solicitud
            $isJson = $isAjax || strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
            
            if ($isJson) {
                $inputData = file_get_contents('php://input');
                $data = json_decode($inputData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
                        exit;
                    }
                }
                
                $nombre = trim($data['nombre'] ?? '');
                $tipo = $data['tipo'] ?? '';
                $vigencia_desde = $data['vigencia_desde'] ?? '';
                $vigencia_hasta = $data['vigencia_hasta'] ?? '';
                $periodicidad = $data['periodicidad'] ?? '';
                $estado = $data['estado'] ?? '1';
                $codigos = $data['codigos'] ?? [];
            } else {
                $nombre = trim($_POST['nombre'] ?? '');
                $tipo = $_POST['tipo'] ?? '';
                $vigencia_desde = $_POST['vigencia_desde'] ?? '';
                $vigencia_hasta = $_POST['vigencia_hasta'] ?? '';
                $periodicidad = $_POST['periodicidad'] ?? '';
                $estado = $_POST['estado'] ?? '1';
                $codigos = $_POST['codigos'] ?? [];
            }

            // Validaciones
            $errores = [];

            if (empty($nombre)) {
                $errores[] = 'El nombre de la asignatura es requerido';
            }

            if (empty($tipo)) {
                $errores[] = 'El tipo de asignatura es requerido';
            }

            if (empty($vigencia_desde)) {
                $errores[] = 'La fecha de inicio de vigencia es requerida';
            }

            if (empty($periodicidad)) {
                $errores[] = 'La periodicidad es requerida';
            }

            // Validar códigos para todos los tipos de asignatura
            if (empty($codigos) || !is_array($codigos)) {
                $errores[] = 'Debe ingresar al menos un código de asignatura';
            } else {
                foreach ($codigos as $index => $codigo) {
                    if (empty($codigo['codigo'])) {
                        $errores[] = 'El código de asignatura es requerido';
                        break;
                    }
                    if ($tipo !== 'FORMACION_ELECTIVA') {
                        if (empty($codigo['departamento_id'])) {
                            $errores[] = 'El departamento es requerido';
                            break;
                        }
                        if (empty($codigo['cantidad_alumnos']) || $codigo['cantidad_alumnos'] < 1) {
                            $errores[] = 'La cantidad de alumnos debe ser mayor a 0';
                            break;
                        }
                    }
                }
            }

            if (!empty($errores)) {
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'errors' => $errores]);
                    exit;
                } else {
                    $this->session->set('error', implode('. ', $errores));
                    header('Location: ' . Config::get('app_url') . 'asignaturas/' . $id . '/editar');
                    exit;
                }
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
                        asignatura_id, departamento_id, codigo_asignatura, cantidad_alumnos
                    ) VALUES (?, ?, ?, ?)
                ");

                // Si es Formación Electiva, usar valores por defecto
                if ($tipo === 'FORMACION_ELECTIVA') {
                    // Obtener el ID del departamento "Sin departamento"
                    $stmtDep = $this->db->prepare("
                        SELECT id FROM departamentos WHERE nombre = 'Sin departamento' LIMIT 1
                    ");
                    $stmtDep->execute();
                    $sinDepartamento = $stmtDep->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$sinDepartamento) {
                        // Si no existe "Sin departamento", crearlo
                        $stmtCreateDep = $this->db->prepare("
                            INSERT INTO departamentos (nombre, estado) VALUES ('Sin departamento', 1)
                        ");
                        $stmtCreateDep->execute();
                        $sinDepartamentoId = $this->db->lastInsertId();
                    } else {
                        $sinDepartamentoId = $sinDepartamento['id'];
                    }

                    // Insertar con valores por defecto para Formación Electiva
                    foreach ($codigos as $codigo) {
                        $stmt->execute([
                            $id,
                            $sinDepartamentoId,
                            $codigo['codigo'],
                            0  // Cantidad de alumnos = 0
                        ]);
                    }
                } else {
                    // Para otros tipos de asignatura, procesar normalmente
                    foreach ($codigos as $codigo) {
                        $stmt->execute([
                            $id,
                            $codigo['departamento_id'],
                            $codigo['codigo'],
                            $codigo['cantidad_alumnos']
                        ]);
                    }
                }

                $this->db->commit();

                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Asignatura actualizada exitosamente']);
                    exit;
                } else {
                    $this->session->set('success', 'Asignatura actualizada exitosamente');
                    header('Location: ' . Config::get('app_url') . 'asignaturas');
                    exit;
                }

            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@update: " . $e->getMessage());
            
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la asignatura: ' . $e->getMessage()]);
                exit;
            } else {
                $this->session->set('error', 'Error al actualizar la asignatura: ' . $e->getMessage());
                header('Location: ' . Config::get('app_url') . 'asignaturas/' . $id . '/editar');
                exit;
            }
        }
    }

    public function destroy($id)
    {
        try {
            $this->asignaturaModel->delete($id);
            return Response::json([
                'message' => 'Asignatura eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'message' => 'Error al eliminar la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAsignaturas()
    {
        $filters = $this->request->getQueryParams();
        
        try {
            $asignaturas = $this->asignaturaModel->getFiltered($filters);
            return Response::json($asignaturas);
        } catch (\Exception $e) {
            return Response::json([
                'message' => 'Error al obtener las asignaturas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para crear asignaturas');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Obtener departamentos con su jerarquía
            $stmt = $this->db->prepare("
                SELECT d.id, d.nombre as departamento_nombre,
                       f.nombre as facultad_nombre,
                       s.nombre as sede_nombre
                FROM departamentos d
                JOIN facultades f ON d.facultad_id = f.id
                JOIN sedes s ON f.sede_id = s.id
                WHERE d.estado = 1
                ORDER BY s.nombre ASC, f.nombre ASC, d.nombre ASC
            ");
            $stmt->execute();
            $departamentos = $stmt->fetchAll();

            // Obtener datos del usuario
            $usuarioModel = new Usuario();
            $user = $usuarioModel->find($this->session->get('user_id'));

            // Renderizar la vista
            echo $this->twig->render('asignaturas/create.twig', [
                'departamentos' => $departamentos,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@create: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar el formulario de creación de asignatura');
            header('Location: ' . Config::get('app_url') . 'asignaturas');
            exit;
        }
    }

    private function validateAsignaturaData($data)
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
                if ($anio < 1900 || $anio > date('Y')) {
                    $errors['vigencia_desde'] = 'El año debe estar entre 1900 y el año actual';
                }
                if ($secuencia < 1 || $secuencia > 99) {
                    $errors['vigencia_desde'] = 'La secuencia debe estar entre 01 y 99';
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
                if ($anio < 1900 || $anio > date('Y')) {
                    $errors['vigencia_hasta'] = 'El año debe estar entre 1900 y el año actual';
                }
                if ($secuencia < 1 || $secuencia > 99) {
                    $errors['vigencia_hasta'] = 'La secuencia debe estar entre 01 y 99';
                }
                
                // Validar que vigencia_hasta sea mayor o igual a vigencia_desde
                if (isset($data['vigencia_desde']) && $data['vigencia_hasta'] < $data['vigencia_desde']) {
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
            foreach ($data['codigos'] as $index => $codigo) {
                if (empty($codigo['departamento_id'])) {
                    $errors["codigos.{$index}.departamento_id"] = 'El departamento es requerido';
                }
                if (empty($codigo['codigo'])) {
                    $errors["codigos.{$index}.codigo"] = 'El código es requerido';
                }
                if (empty($codigo['cantidad_alumnos'])) {
                    $errors["codigos.{$index}.cantidad_alumnos"] = 'La cantidad de alumnos es requerida';
                }
            }
        }

        return $errors;
    }

    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function vinculacion()
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('error', 'Por favor inicie sesión para acceder a esta funcionalidad');
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
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
            echo $this->twig->render('asignaturas/vinculacion.twig', [
                'asignaturas_electivas' => $asignaturas_electivas,
                'tipos_asignaturas' => $tipos_asignaturas,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'asignaturas'
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@vinculacion: " . $e->getMessage());
            $this->session->set('error', 'Error al cargar la página de vinculación: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'asignaturas');
            exit;
        }
    }

    public function getVinculacion($asignaturaFormacionId)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                exit;
            }

            // Obtener el tipo de asignatura solicitado
            $tipo = $_GET['tipo'] ?? 'REGULAR';

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

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'vinculadas' => $vinculadas,
                'no_vinculadas' => $no_vinculadas
            ]);
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@getVinculacion: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al obtener las asignaturas']);
        }
    }

    public function agregarVinculacion($asignaturaFormacionId)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                exit;
            }

            // Obtener datos de la solicitud
            $input = json_decode(file_get_contents('php://input'), true);
            $asignaturasIds = $input['asignaturas'] ?? [];

            if (empty($asignaturasIds)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No se especificaron asignaturas']);
                exit;
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Asignaturas vinculadas exitosamente']);
            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@agregarVinculacion: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al vincular las asignaturas: ' . $e->getMessage()]);
        }
    }

    public function quitarVinculacion($asignaturaFormacionId)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                exit;
            }

            // Obtener datos de la solicitud
            $input = json_decode(file_get_contents('php://input'), true);
            $asignaturasIds = $input['asignaturas'] ?? [];

            if (empty($asignaturasIds)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No se especificaron asignaturas']);
                exit;
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Asignaturas desvinculadas exitosamente']);
            } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log("Error en AsignaturaController@quitarVinculacion: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al desvincular las asignaturas']);
        }
    }
} 