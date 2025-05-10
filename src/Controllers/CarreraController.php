<?php

namespace App\Controllers;

use App\Core\BaseController;
use src\Models\Carrera;
use src\Models\Facultad;
use src\Models\Sede;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Core\Session;
use PDO;
use App\Core\Config;

class CarreraController
{
    protected $session;
    protected $pdo;
    protected $twig;

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

    public function index()
    {
        // Log para depuración
        //error_log('CarreraController index: Iniciando');
        //error_log('Session data: ' . print_r($_SESSION, true));
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            //error_log('CarreraController index: Usuario no autenticado');
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            //error_log('CarreraController index: Usuario autenticado, obteniendo carreras');
            
            // Obtener todas las carreras con sus sedes y facultades
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

            // Aplicar filtro de tipo de programa
            if (!empty($_GET['tipo_programa'])) {
            $sql .= " AND c.tipo_programa = ?";
                $params[] = $_GET['tipo_programa'];
        }

            // Aplicar filtro de sede
            if (!empty($_GET['sede'])) {
            $sql .= " AND ce.sede_id = ?";
                $params[] = $_GET['sede'];
        }

            // Aplicar filtro de estado
            if (isset($_GET['estado']) && $_GET['estado'] !== '') {
            $sql .= " AND c.estado = ?";
                $params[] = $_GET['estado'];
            }

            $sql .= " GROUP BY c.id ORDER BY c.nombre ASC";
            
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
            $carreras = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            //error_log('CarreraController index: Carreras obtenidas: ' . count($carreras));
            //error_log('CarreraController index: Datos de carreras: ' . print_r($carreras, true));

        // Obtener datos del usuario
        $user_id = $this->session->get('user_id');
        $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql_user);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

            //error_log('CarreraController index: Datos de usuario: ' . print_r($user, true));

            // Obtener sedes para el filtro
            $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Preparar datos para la vista
            $viewData = [
            'carreras' => $carreras,
            'sedes' => $sedes,
                'user' => $user,
                'current_page' => 'carreras',
            'app_url' => Config::get('app_url'),
            'session' => $_SESSION,
                'filtros' => [
                    'tipo_programa' => $_GET['tipo_programa'] ?? '',
                    'sede' => $_GET['sede'] ?? '',
                    'estado' => $_GET['estado'] ?? ''
                ]
            ];

            //error_log('CarreraController index: Datos para la vista: ' . print_r($viewData, true));

            // Renderizar la vista
            echo $this->twig->render('carreras/index.twig', $viewData);
            
        } catch (\Exception $e) {
            error_log('CarreraController index: Error: ' . $e->getMessage());
            error_log('CarreraController index: Stack trace: ' . $e->getTraceAsString());
            $this->session->set('error', 'Error al cargar las carreras: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'dashboard');
            exit;
        }
    }

    /**
     * Muestra el formulario para crear una nueva carrera.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create()
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Obtener sedes y facultades
        $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $sedes = $stmt->fetchAll();

        $sql = "SELECT id, nombre FROM facultades ORDER BY nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $facultades = $stmt->fetchAll();

        // Obtener datos del usuario
        $user_id = $this->session->get('user_id');
        $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql_user);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        // Renderizar la vista
        echo $this->twig->render('carreras/create.twig', [
            'sedes' => $sedes,
            'facultades' => $facultades,
            'app_url' => Config::get('app_url'),
            'user' => $user,
            'session' => $_SESSION,
            'current_path' => 'carreras'
        ]);
    }

    /**
     * Almacena una nueva carrera.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store()
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Obtener datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $tipo_programa = $_POST['tipo_programa'] ?? '';
            $estado = $_POST['estado'] ?? 1;
            $codigos = $_POST['codigos'] ?? [];
            $sedes = $_POST['sedes'] ?? [];
            $facultades = $_POST['facultades'] ?? [];
            $vigencias_desde = $_POST['vigencias_desde'] ?? [];
            $vigencias_hasta = $_POST['vigencias_hasta'] ?? [];

            // Validar datos básicos
            if (empty($nombre) || empty($tipo_programa)) {
                throw new \Exception('El nombre y tipo de programa son obligatorios');
            }

            // Validar códigos de carrera
            if (empty($codigos) || !is_array($codigos)) {
                throw new \Exception('Debe ingresar al menos un código de carrera');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Insertar carrera
            $sql = "INSERT INTO carreras (nombre, tipo_programa, estado) 
                    VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $tipo_programa, $estado]);
            $carrera_id = $this->pdo->lastInsertId();

            // Insertar códigos de carrera
            $sql = "INSERT INTO carreras_espejos (carrera_id, codigo_carrera, vigencia_desde, vigencia_hasta, facultad_id, sede_id, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            $codigosInsertados = 0;
            foreach ($codigos as $index => $codigo) {
                if (empty($codigo) || empty($sedes[$index]) || empty($facultades[$index])) {
                    continue;
                }

                // Validar formato de vigencia_desde (6 dígitos)
                if (!preg_match('/^\d{6}$/', $vigencias_desde[$index])) {
                    throw new \Exception('El formato de vigencia desde debe ser de 6 dígitos (AAAAMM)');
                }

                $stmt->execute([
                    $carrera_id,
                    $codigo,
                    $vigencias_desde[$index],
                    $vigencias_hasta[$index] ?? '999999',
                    $facultades[$index],
                    $sedes[$index],
                    1 // estado activo por defecto
                ]);
                
                $codigosInsertados++;
            }

            if ($codigosInsertados === 0) {
                throw new \Exception('No se insertó ningún código de carrera válido');
            }

            $this->pdo->commit();
            
            // Limpiar mensajes anteriores
            $this->session->remove('error');
            $this->session->set('success', 'Carrera creada exitosamente');
            
            header('Location: ' . Config::get('app_url') . 'carreras');
            exit;
        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            // Limpiar mensajes anteriores
            $this->session->remove('success');
            $this->session->set('error', 'Error al crear la carrera: ' . $e->getMessage());
            
            // Obtener sedes y facultades para el formulario
            $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            $sql = "SELECT id, nombre FROM facultades ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $facultades = $stmt->fetchAll();

            // Renderizar la vista con los datos del formulario
            echo $this->twig->render('carreras/create.twig', [
                'sedes' => $sedes,
                'facultades' => $facultades,
                'app_url' => Config::get('app_url'),
                'form_data' => $_POST
            ]);
        }
    }

    /**
     * Muestra una carrera específica.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function show($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
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
                header('Location: ' . Config::get('app_url') . 'carreras');
                exit;
            }

            // Log para debug
            error_log('Datos de carrera antes de procesar: ' . print_r($carrera, true));

            // Procesar los resultados para asegurar el formato correcto
            //$carrera['sedes'] = [];
            //$carrera['facultades'] = [];
            //$carrera['codigos_carrera'] = [];
            //$carrera['vigencias_desde'] = [];
            //$carrera['vigencias_hasta'] = [];

            // Procesar cada campo solo si existe y es una cadena
            if (isset($carrera['sedes']) && is_string($carrera['sedes'])) {
                $carrera['sedes'] = array_filter(explode(',', $carrera['sedes']));
            }
            if (isset($carrera['facultades']) && is_string($carrera['facultades'])) {
                $carrera['facultades'] = array_filter(explode(',', $carrera['facultades']));
            }
            if (isset($carrera['codigos_carrera']) && is_string($carrera['codigos_carrera'])) {
                $carrera['codigos_carrera'] = array_filter(explode(',', $carrera['codigos_carrera']));
            }
            if (isset($carrera['vigencias_desde']) && is_string($carrera['vigencias_desde'])) {
                $carrera['vigencias_desde'] = array_filter(explode(',', $carrera['vigencias_desde']));
            }
            if (isset($carrera['vigencias_hasta']) && is_string($carrera['vigencias_hasta'])) {
                $carrera['vigencias_hasta'] = array_filter(explode(',', $carrera['vigencias_hasta']));
            }

            // Log para debug después de procesar
            error_log('Datos de carrera después de procesar: ' . print_r($carrera, true));

            // Obtener asignaturas vinculadas a través de la tabla mallas
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            WHERE m.carrera_id = ?
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$id]);
            $carrera['asignaturas'] = $stmt->fetchAll();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener mensajes de sesión y limpiarlos
            $success = $this->session->get('success');
            $error = $this->session->get('error');
            $this->session->remove('success');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('carreras/show.twig', [
                'carrera' => $carrera,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'success' => $success,
                'error' => $error,
                'current_page' => 'carreras',
                'session' => $_SESSION
            ]);
        } catch (\Exception $e) {
            error_log('Error en CarreraController::show: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $this->session->set('error', 'Error al obtener los datos de la carrera: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'carreras');
            exit;
        }
    }

    /**
     * Muestra el formulario para editar una carrera.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function edit($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Obtener carrera
            $sql = "SELECT 
                        c.id,
                        c.nombre,
                        c.tipo_programa,
                        c.estado,
                        c.url_libro,
                        GROUP_CONCAT(
                            ce.codigo_carrera
                            SEPARATOR '|'
                        ) as codigos,
                        GROUP_CONCAT(
                            ce.vigencia_desde
                            SEPARATOR '|'
                        ) as vigencias_desde,
                        GROUP_CONCAT(
                            ce.vigencia_hasta
                            SEPARATOR '|'
                        ) as vigencias_hasta,
                        GROUP_CONCAT(
                            ce.sede_id
                            SEPARATOR '|'
                        ) as sedes_ids,
                        GROUP_CONCAT(
                            ce.facultad_id
                            SEPARATOR '|'
                        ) as facultades_ids
                    FROM carreras c 
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id 
                    WHERE c.id = ? 
                    GROUP BY c.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();
            
            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                header('Location: ' . Config::get('app_url') . 'carreras');
                exit;
            }

            // Convertir los IDs de sedes y facultades a arrays
            $carrera['sedes_ids'] = $carrera['sedes_ids'] ? explode('|', $carrera['sedes_ids']) : [];
            $carrera['facultades_ids'] = $carrera['facultades_ids'] ? explode('|', $carrera['facultades_ids']) : [];

            error_log('CarreraController edit: sedes_ids: ' . print_r($carrera['sedes_ids'], true));
            error_log('CarreraController edit: facultades_ids: ' . print_r($carrera['facultades_ids'], true));

            // Obtener sedes y facultades
            $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            $sql = "SELECT id, nombre FROM facultades ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $facultades = $stmt->fetchAll();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            echo $this->twig->render('carreras/edit.twig', [
                'carrera' => $carrera,
                'sedes' => $sedes,
                'facultades' => $facultades,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'current_page' => 'carreras',
                'session' => $_SESSION
            ]);
        } catch (\Exception $e) {
            $this->session->set('error', 'Error al obtener los datos de la carrera: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'carreras');
            exit;
        }
    }

    /**
     * Actualiza una carrera existente.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function update($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Obtener datos del formulario
            $nombre = $_POST['nombre'] ?? '';
            $tipo_programa = $_POST['tipo_programa'] ?? '';
            $estado = $_POST['estado'] ?? 1;
            $url_libro = $_POST['url_libro'] ?? null;
            $codigos = $_POST['codigos'] ?? [];
            $sedes = $_POST['sedes'] ?? [];
            $facultades = $_POST['facultades'] ?? [];
            $vigencias_desde = $_POST['vigencias_desde'] ?? [];
            $vigencias_hasta = $_POST['vigencias_hasta'] ?? [];

            // Validar datos básicos
            if (empty($nombre) || empty($tipo_programa)) {
                throw new \Exception('El nombre y tipo de programa son obligatorios');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Actualizar carrera
            $sql = "UPDATE carreras 
                    SET nombre = ?, tipo_programa = ?, estado = ?, url_libro = ? 
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $tipo_programa, $estado, $url_libro, $id]);

            // Eliminar códigos existentes
            $sql = "DELETE FROM carreras_espejos WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Insertar nuevos códigos
            if (!empty($codigos) && is_array($codigos)) {
                $sql = "INSERT INTO carreras_espejos (carrera_id, codigo_carrera, vigencia_desde, vigencia_hasta, facultad_id, sede_id, estado) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);

                foreach ($codigos as $index => $codigo) {
                    // Validar que existan todos los datos necesarios
                    if (empty($codigo) || empty($sedes[$index]) || empty($facultades[$index])) {
                        continue;
                    }

                    // Validar formato de vigencia_desde (6 dígitos)
                    if (!preg_match('/^\d{6}$/', $vigencias_desde[$index])) {
                        throw new \Exception('El formato de vigencia desde debe ser de 6 dígitos (AAAAMM)');
                    }

                    // Validar que la facultad pertenezca a la sede
                    $sql_check = "SELECT COUNT(*) as count FROM facultades WHERE id = ? AND sede_id = ?";
                    $check_stmt = $this->pdo->prepare($sql_check);
                    $check_stmt->execute([$facultades[$index], $sedes[$index]]);
                    $result = $check_stmt->fetch();

                    if ($result['count'] == 0) {
                        throw new \Exception('La facultad seleccionada no pertenece a la sede seleccionada');
                    }

                    // Insertar el registro
                    $stmt->execute([
                        $id,
                        $codigo,
                        $vigencias_desde[$index],
                        $vigencias_hasta[$index] ?? '999999',
                        $facultades[$index],
                        $sedes[$index],
                        1 // estado activo por defecto
                    ]);
                }
            }

            // Confirmar transacción
            $this->pdo->commit();
            
            // Establecer mensaje de éxito
            $this->session->set('success', 'Carrera actualizada exitosamente');
            
            // Redirigir a la lista de carreras
            header('Location: ' . Config::get('app_url') . 'carreras');
            exit;
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            // Establecer mensaje de error
            $this->session->set('error', 'Error al actualizar la carrera: ' . $e->getMessage());
            
            // Redirigir al formulario de edición
            header('Location: ' . Config::get('app_url') . 'carreras/' . $id . '/edit');
            exit;
        }
    }

    /**
     * Elimina una carrera.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Verificar si la carrera tiene asignaturas vinculadas
            $sql = "SELECT COUNT(*) as total FROM mallas WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            
            if ($result['total'] > 0) {
                $this->session->set('error', 'No se puede eliminar la carrera porque tiene asignaturas vinculadas. Primero debe eliminar las asignaturas asociadas.');
                header('Location: ' . Config::get('app_url') . 'carreras');
                exit;
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Eliminar registros relacionados en carreras_espejos
            $sql = "DELETE FROM carreras_espejos WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Eliminar la carrera
            $sql = "DELETE FROM carreras WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Confirmar transacción
            $this->pdo->commit();

            // Establecer mensaje de éxito
            $this->session->set('success', 'Carrera eliminada correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
            }
            
            // Establecer mensaje de error
            $this->session->set('error', 'Error al eliminar la carrera: ' . $e->getMessage());
        }

        // Redirigir a la lista de carreras
        header('Location: ' . Config::get('app_url') . 'carreras');
        exit;
    }

    public function getFacultadesBySede($sede_id)
    {
        try {
            $sql = "SELECT id, nombre FROM facultades WHERE sede_id = ? ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$sede_id]);
            $facultades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($facultades, JSON_UNESCAPED_UNICODE);
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener las facultades']);
            exit;
        }
    }
} 