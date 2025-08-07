<?php

namespace App\Controllers;

use App\Core\BaseController;
use src\Models\Carrera;
use src\Models\Facultad;
use src\Models\Sede;
use App\Models\Unidad;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Core\Session;
use App\Core\ListStateManager;
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

    public function index(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'biblioges/login')
                ->withStatus(302);
        }

        try {
            // Inicializar el gestor de estado del listado
            $stateManager = new ListStateManager($this->session, 'carreras');
            
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
            $allowedColumns = ['nombre', 'tipo_programa', 'estado', 'cantidad_semestres', 'sede'];
            
            $offset = ($page - 1) * $perPage;

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

            // Aplicar filtros desde el estado
            if (!empty($state['nombre'])) {
                $sql .= " AND c.nombre LIKE ?";
                $countSql .= " AND c.nombre LIKE ?";
                $params[] = '%' . $state['nombre'] . '%';
            }

            // Aplicar filtro de tipo de programa
            if (!empty($state['tipo_programa'])) {
                $sql .= " AND c.tipo_programa = ?";
                $countSql .= " AND c.tipo_programa = ?";
                $params[] = $state['tipo_programa'];
            }

            // Aplicar filtro de sede
            if (!empty($state['sede'])) {
                $sql .= " AND ce.sede_id = ?";
                $countSql .= " AND ce.sede_id = ?";
                $params[] = $state['sede'];
            }

            // Aplicar filtro de estado
            if (isset($state['estado']) && $state['estado'] !== '') {
                $sql .= " AND c.estado = ?";
                $countSql .= " AND c.estado = ?";
                $params[] = $state['estado'];
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
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $carreras = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

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
                'stateManager' => $stateManager,
                'filtros' => [
                    'nombre' => $state['nombre'],
                    'tipo_programa' => $state['tipo_programa'],
                    'sede' => $state['sede'],
                    'estado' => $state['estado']
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
            $html = $this->twig->render('carreras/index.twig', $viewData);
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log('CarreraController index: Error: ' . $e->getMessage());
            error_log('CarreraController index: Stack trace: ' . $e->getTraceAsString());
            $this->session->set('error', 'Error al cargar las carreras: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'dashboard')
                ->withStatus(302);
        }
    }

    /**
     * Muestra el formulario para crear una nueva carrera.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'biblioges/login')
                ->withStatus(302);
        }

        // Obtener sedes y unidades
        $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $sedes = $stmt->fetchAll();

        // Usar el modelo Unidad para obtener todas las unidades activas
        $unidadModel = new Unidad($this->pdo);
        $unidades = $unidadModel->getAll(1);

        // Obtener datos del usuario
        $user_id = $this->session->get('user_id');
        $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql_user);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        // Renderizar la vista
        $html = $this->twig->render('carreras/create.twig', [
            'sedes' => $sedes,
            'unidades' => $unidades,
            'app_url' => Config::get('app_url'),
            'user' => $user,
            'session' => $_SESSION,
            'current_page' => 'carreras'
        ]);
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Almacena una nueva carrera.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'biblioges/login')
                ->withStatus(302);
        }

        try {
            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $nombre = $parsedBody['nombre'] ?? '';
            $tipo_programa = $parsedBody['tipo_programa'] ?? '';
            $estado = $parsedBody['estado'] ?? 1;
            $codigos = $parsedBody['codigos'] ?? [];
            $sedes = $parsedBody['sedes'] ?? [];
            $unidades = $parsedBody['unidades'] ?? [];
            $vigencias_desde = $parsedBody['vigencias_desde'] ?? [];
            $vigencias_hasta = $parsedBody['vigencias_hasta'] ?? [];
            $cantidad_semestres = $parsedBody['cantidad_semestres'] ?? 10;
            $imagen_url = null;
            // Procesar imagen de la carrera
            // LOG: Inicio procesamiento de imagen
            error_log('[CARRERA] Procesando imagen_carrera...');
            if (isset($_FILES['imagen_carrera'])) {
                error_log('[CARRERA] imagen_carrera recibido. Error code: ' . $_FILES['imagen_carrera']['error']);
            } else {
                error_log('[CARRERA] imagen_carrera NO recibido.');
            }
            if (isset($_FILES['imagen_carrera']) && $_FILES['imagen_carrera']['error'] === UPLOAD_ERR_OK) {
                $imgFile = $_FILES['imagen_carrera'];
                $allowedImgTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $imgMimeType = finfo_file($finfo, $imgFile['tmp_name']);
                finfo_close($finfo);
                error_log('[CARRERA] Tipo MIME imagen: ' . $imgMimeType);
                if (!in_array($imgMimeType, $allowedImgTypes)) {
                    error_log('[CARRERA] Tipo de imagen no permitido: ' . $imgMimeType);
                    throw new \Exception('Solo se permiten imágenes JPG, PNG o GIF');
                }
                $imgSize = getimagesize($imgFile['tmp_name']);
                error_log('[CARRERA] Dimensiones imagen: ' . print_r($imgSize, true));
                if (!$imgSize || $imgSize[0] != 1440 || $imgSize[1] != 700) {
                    error_log('[CARRERA] Dimensiones incorrectas: ' . print_r($imgSize, true));
                    throw new \Exception('La imagen debe tener exactamente 1440x700 píxeles');
                }
                $imgDir = __DIR__ . '/../../public/uploads/imagenes_carreras/';
                if (!is_dir($imgDir)) {
                    mkdir($imgDir, 0755, true);
                    error_log('[CARRERA] Carpeta creada: ' . $imgDir);
                }
                $imgExt = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
                $imgName = 'carrera_' . time() . '_' . uniqid() . '.' . $imgExt;
                $imgPath = $imgDir . $imgName;
                move_uploaded_file($imgFile['tmp_name'], $imgPath);
                error_log('[CARRERA] Imagen guardada en: ' . $imgPath);
                $imagen_url = 'uploads/imagenes_carreras/' . $imgName;
            }

            // Procesar archivo PDF del libro de carrera
            $url_libro = null;
            error_log('[CARRERA] Procesando libro_carrera...');
            if (isset($_FILES['libro_carrera'])) {
                error_log('[CARRERA] libro_carrera recibido. Error code: ' . $_FILES['libro_carrera']['error']);
            } else {
                error_log('[CARRERA] libro_carrera NO recibido.');
            }
            if (isset($_FILES['libro_carrera']) && $_FILES['libro_carrera']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['libro_carrera'];
                // Validar tipo de archivo
                $allowedTypes = ['application/pdf'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                error_log('[CARRERA] Tipo MIME libro: ' . $mimeType);
                if (!in_array($mimeType, $allowedTypes)) {
                    error_log('[CARRERA] Tipo de libro no permitido: ' . $mimeType);
                    throw new \Exception('Solo se permiten archivos PDF');
                }
                // Validar tamaño (máximo 10MB)
                if ($file['size'] > 10 * 1024 * 1024) {
                    error_log('[CARRERA] El archivo PDF supera el tamaño permitido.');
                    throw new \Exception('El archivo no puede superar los 10MB');
                }
                // Crear directorio si no existe
                $uploadDir = __DIR__ . '/../../public/uploads/libros_carrera/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                    error_log('[CARRERA] Carpeta creada: ' . $uploadDir);
                }
                // Generar nombre único para el archivo
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'libro_carrera_' . time() . '_' . uniqid() . '.' . $extension;
                $filepath = $uploadDir . $filename;
                // Mover archivo
                move_uploaded_file($file['tmp_name'], $filepath);
                error_log('[CARRERA] PDF guardado en: ' . $filepath);
                // Guardar URL relativa
                $url_libro = 'uploads/libros_carrera/' . $filename;
            }

            // Validar datos básicos
            if (empty($nombre) || empty($tipo_programa)) {
                throw new \Exception('El nombre y tipo de programa son obligatorios');
            }

            // Validar códigos de carrera
            if (empty($codigos) || !is_array($codigos)) {
                throw new \Exception('Debe ingresar al menos un código de carrera');
            }

            // Validar que no haya códigos duplicados por sede y unidad
            $codigosValidos = [];
            $duplicados = [];
            
            foreach ($codigos as $index => $codigo) {
                if (empty($codigo) || empty($sedes[$index]) || empty($unidades[$index])) {
                    continue;
                }

                $codigoKey = $codigo . '_' . $sedes[$index] . '_' . $unidades[$index];
                
                // Verificar duplicados en el formulario actual
                if (in_array($codigoKey, $codigosValidos)) {
                    $duplicados[] = $codigo;
                } else {
                    $codigosValidos[] = $codigoKey;
                }
            }

            if (!empty($duplicados)) {
                throw new \Exception('No se permiten códigos duplicados por sede y unidad. Códigos duplicados: ' . implode(', ', array_unique($duplicados)));
            }

            // Verificar duplicados en la base de datos
            foreach ($codigos as $index => $codigo) {
                if (empty($codigo) || empty($sedes[$index]) || empty($unidades[$index])) {
                    continue;
                }

                // Verificar si ya existe un código con la misma sede y unidad
                $sql = "SELECT ce.codigo_carrera, c.nombre as carrera_nombre, s.nombre as sede_nombre, u.nombre as unidad_nombre
                        FROM carreras_espejos ce
                        INNER JOIN carreras c ON ce.carrera_id = c.id
                        INNER JOIN sedes s ON ce.sede_id = s.id
                        INNER JOIN unidades u ON ce.id_unidad = u.id
                        WHERE ce.codigo_carrera = ? AND ce.sede_id = ? AND ce.id_unidad = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$codigo, $sedes[$index], $unidades[$index]]);
                $existe = $stmt->fetch();

                if ($existe) {
                    throw new \Exception("El código '{$codigo}' ya existe para la sede '{$existe['sede_nombre']}' y unidad '{$existe['unidad_nombre']}' en la carrera '{$existe['carrera_nombre']}'");
                }
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Insertar carrera
            $sql = "INSERT INTO carreras (nombre, tipo_programa, estado, url_libro, imagen_url, cantidad_semestres) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $tipo_programa, $estado, $url_libro, $imagen_url, $cantidad_semestres]);
            $carrera_id = $this->pdo->lastInsertId();

            // Insertar códigos de carrera
            $sql = "INSERT INTO carreras_espejos (carrera_id, codigo_carrera, sede_id, id_unidad, vigencia_desde, vigencia_hasta, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            $codigosInsertados = 0;
            for ($i = 0; $i < count($codigos); $i++) {
                $codigo = $codigos[$i] ?? null;
                $sede_id = $sedes[$i] ?? null;
                $id_unidad = $unidades[$i] ?? null;
                $vigencia_desde = $vigencias_desde[$i] ?? null;
                $vigencia_hasta = $vigencias_hasta[$i] ?? null;

                if ($codigo && $sede_id && $id_unidad && $vigencia_desde) {
                    // Validar formato de vigencia_desde (6 dígitos)
                    if (!preg_match('/^\d{6}$/', $vigencia_desde)) {
                        throw new \Exception('El formato de vigencia desde debe ser de 6 dígitos (AAAAMM)');
                    }

                    $stmt->execute([
                        $carrera_id,
                        $codigo,
                        $sede_id,
                        $id_unidad,
                        $vigencia_desde,
                        $vigencia_hasta ?? '999999',
                        1 // estado activo por defecto
                    ]);
                    
                    $codigosInsertados++;
                }
            }

            if ($codigosInsertados === 0) {
                throw new \Exception('No se insertó ningún código de carrera válido');
            }

            $this->pdo->commit();
            
            // Limpiar mensajes anteriores
            $this->session->remove('error');
            $this->session->set('success', 'Carrera creada exitosamente');
            
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            // Limpiar mensajes anteriores
            $this->session->remove('success');
            $this->session->set('error', 'Error al crear la carrera: ' . $e->getMessage());
            
            // Obtener sedes y unidades para el formulario
            $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            $unidadModel = new Unidad($this->pdo);
            $unidades = $unidadModel->getAll(1);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Renderizar la vista con los datos del formulario
            $html = $this->twig->render('carreras/create.twig', [
                'sedes' => $sedes,
                'unidades' => $unidades,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'session' => $_SESSION,
                'current_page' => 'carreras',
                'form_data' => $parsedBody
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
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
    public function show(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Obtener datos básicos de la carrera
            $sql = "SELECT c.* FROM carreras c WHERE c.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras')
                    ->withStatus(302);
            }

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener códigos de carrera con detalles
            $sql = "SELECT ce.*, s.nombre as sede_nombre, u.nombre as unidad_nombre
                    FROM carreras_espejos ce
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN unidades u ON ce.id_unidad = u.id
                    WHERE ce.carrera_id = ?
                    ORDER BY ce.codigo_carrera";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $codigos_carrera = $stmt->fetchAll();

            // Preparar arrays para el template (para compatibilidad con el template actual)
            $codigos = [];
            $vigencias_desde = [];
            $vigencias_hasta = [];
            $unidades = [];
            $sedes = [];

            foreach ($codigos_carrera as $codigo) {
                $codigos[] = $codigo['codigo_carrera'];
                $vigencias_desde[] = $codigo['vigencia_desde'];
                $vigencias_hasta[] = $codigo['vigencia_hasta'];
                $unidades[] = $codigo['unidad_nombre'];
                $sedes[] = $codigo['sede_nombre'];
            }

            // Agregar los arrays a la carrera
            $carrera['codigos_carrera'] = $codigos;
            $carrera['vigencias_desde'] = $vigencias_desde;
            $carrera['vigencias_hasta'] = $vigencias_hasta;
            $carrera['unidades'] = $unidades;
            $carrera['sedes'] = $sedes;

            // Obtener asignaturas vinculadas desde la tabla mallas
            $sql = "SELECT m.semestre, a.nombre, a.tipo, a.periodicidad, a.estado
                    FROM mallas m
                    INNER JOIN asignaturas a ON m.asignatura_id = a.id
                    WHERE m.carrera_id = ?
                    ORDER BY m.semestre ASC, a.nombre ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $asignaturas_vinculadas = $stmt->fetchAll();

            // Preparar datos para la vista
            $viewData = [
                'carrera' => $carrera,
                'codigos_carrera' => $codigos_carrera,
                'asignaturas_vinculadas' => $asignaturas_vinculadas,
                'user' => $user,
                'current_page' => 'carreras',
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION
            ];

            // Renderizar la vista
            $html = $this->twig->render('carreras/show.twig', $viewData);
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            error_log('CarreraController show: Error: ' . $e->getMessage());
            $this->session->set('error', 'Error al cargar la carrera: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
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
    public function edit(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Obtener carrera
            $sql = "SELECT 
                        c.id,
                        c.nombre,
                        c.tipo_programa,
                        c.estado,
                        c.url_libro,
                        c.imagen_url,
                        c.cantidad_semestres,
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
                            ce.id_unidad
                            SEPARATOR '|'
                        ) as unidades_ids,
                        GROUP_CONCAT(
                            ce.id
                            SEPARATOR '|'
                        ) as codigos_ids
                    FROM carreras c 
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id 
                    WHERE c.id = ? 
                    GROUP BY c.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();
            
            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras')
                    ->withStatus(302);
            }

            // Convertir los IDs de sedes, unidades y códigos a arrays
            $carrera['sedes_ids'] = $carrera['sedes_ids'] ? explode('|', $carrera['sedes_ids']) : [];
            $carrera['unidades_ids'] = $carrera['unidades_ids'] ? explode('|', $carrera['unidades_ids']) : [];
            $carrera['codigos_ids'] = $carrera['codigos_ids'] ? explode('|', $carrera['codigos_ids']) : [];

            // Obtener sedes y unidades
            $sql = "SELECT id, nombre FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            $unidadModel = new Unidad($this->pdo);
            $unidades = $unidadModel->getAll(1);

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            $html = $this->twig->render('carreras/edit.twig', [
                'carrera' => $carrera,
                'sedes' => $sedes,
                'unidades' => $unidades,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'current_page' => 'carreras',
                'session' => $_SESSION
            ]);
            
            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
            
        } catch (\Exception $e) {
            $this->session->set('error', 'Error al obtener los datos de la carrera: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
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
    public function update(Request $request, Response $response, array $args = [])
    {
        error_log('[CARRERA] Método HTTP: ' . ($_SERVER['REQUEST_METHOD'] ?? 'N/A'));
        error_log('[CARRERA] _POST: ' . print_r($_POST, true));
        error_log('[CARRERA] _FILES: ' . print_r($_FILES, true));
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $nombre = $parsedBody['nombre'] ?? '';
            $tipo_programa = $parsedBody['tipo_programa'] ?? '';
            $estado = $parsedBody['estado'] ?? 1;
            $codigos = $parsedBody['codigos'] ?? [];
            $sedes = $parsedBody['sedes'] ?? [];
            $unidades = $parsedBody['unidades'] ?? [];
            $vigencias_desde = $parsedBody['vigencias_desde'] ?? [];
            $vigencias_hasta = $parsedBody['vigencias_hasta'] ?? [];
            $cantidad_semestres = $parsedBody['cantidad_semestres'] ?? 10;
            $imagen_url = null;
            // Procesar imagen de la carrera
            // LOG: Inicio procesamiento de imagen
            error_log('[CARRERA] Procesando imagen_carrera...');
            if (isset($_FILES['imagen_carrera'])) {
                error_log('[CARRERA] imagen_carrera recibido. Error code: ' . $_FILES['imagen_carrera']['error']);
            } else {
                error_log('[CARRERA] imagen_carrera NO recibido.');
            }
            if (isset($_FILES['imagen_carrera']) && $_FILES['imagen_carrera']['error'] === UPLOAD_ERR_OK) {
                $imgFile = $_FILES['imagen_carrera'];
                $allowedImgTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $imgMimeType = finfo_file($finfo, $imgFile['tmp_name']);
                finfo_close($finfo);
                error_log('[CARRERA] Tipo MIME imagen: ' . $imgMimeType);
                if (!in_array($imgMimeType, $allowedImgTypes)) {
                    error_log('[CARRERA] Tipo de imagen no permitido: ' . $imgMimeType);
                    throw new \Exception('Solo se permiten imágenes JPG, PNG o GIF');
                }
                $imgSize = getimagesize($imgFile['tmp_name']);
                error_log('[CARRERA] Dimensiones imagen: ' . print_r($imgSize, true));
                if (!$imgSize || $imgSize[0] != 1440 || $imgSize[1] != 700) {
                    error_log('[CARRERA] Dimensiones incorrectas: ' . print_r($imgSize, true));
                    throw new \Exception('La imagen debe tener exactamente 1440x700 píxeles');
                }
                $imgDir = __DIR__ . '/../../public/uploads/imagenes_carreras/';
                if (!is_dir($imgDir)) {
                    mkdir($imgDir, 0755, true);
                    error_log('[CARRERA] Carpeta creada: ' . $imgDir);
                }
                $imgExt = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
                $imgName = 'carrera_' . time() . '_' . uniqid() . '.' . $imgExt;
                $imgPath = $imgDir . $imgName;
                move_uploaded_file($imgFile['tmp_name'], $imgPath);
                error_log('[CARRERA] Imagen guardada en: ' . $imgPath);
                $imagen_url = 'uploads/imagenes_carreras/' . $imgName;
            } else {
                // Si no se sube nueva imagen, mantener la actual
                $sql = "SELECT imagen_url FROM carreras WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                $row = $stmt->fetch();
                $imagen_url = $row['imagen_url'] ?? null;
            }
            
            // En el UPDATE de la carrera, asegúrate de usar $url_libro
            error_log('[CARRERA] INICIO procesamiento PDF en update');
            $url_libro = null;
            if (isset($_FILES['libro_carrera'])) {
                error_log('[CARRERA] libro_carrera recibido. Error code: ' . $_FILES['libro_carrera']['error']);
            } else {
                error_log('[CARRERA] libro_carrera NO recibido.');
            }
            if (isset($_FILES['libro_carrera']) && $_FILES['libro_carrera']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['libro_carrera'];
                $allowedTypes = ['application/pdf'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                error_log('[CARRERA] Tipo MIME libro: ' . $mimeType);
                if (!in_array($mimeType, $allowedTypes)) {
                    error_log('[CARRERA] Tipo de libro no permitido: ' . $mimeType);
                    throw new \Exception('Solo se permiten archivos PDF');
                }
                if ($file['size'] > 10 * 1024 * 1024) {
                    error_log('[CARRERA] El archivo PDF supera el tamaño permitido.');
                    throw new \Exception('El archivo no puede superar los 10MB');
                }
                $uploadDir = __DIR__ . '/../../public/uploads/libros_carrera/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                    error_log('[CARRERA] Carpeta creada: ' . $uploadDir);
                }
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'libro_carrera_' . time() . '_' . uniqid() . '.' . $extension;
                $filepath = $uploadDir . $filename;
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    error_log('[CARRERA] PDF guardado en: ' . $filepath);
                    $url_libro = 'uploads/libros_carrera/' . $filename;
                } else {
                    error_log('[CARRERA] ERROR al guardar el PDF en: ' . $filepath);
                }
            } else {
                // Si no se sube nuevo PDF, mantener el actual
                if (isset($id)) {
                    $sql = "SELECT url_libro FROM carreras WHERE id = ?";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$id]);
                    $row = $stmt->fetch();
                    $url_libro = $row['url_libro'] ?? null;
                }
            }
            error_log('[CARRERA] FIN procesamiento PDF en update');

            // Verificar si se debe eliminar la imagen actual
            $eliminar_imagen = $parsedBody['eliminar_imagen'] ?? false;
            if ($eliminar_imagen) {
                // Obtener la URL del archivo actual para eliminarlo
                $sql = "SELECT imagen_url FROM carreras WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                $carrera_actual = $stmt->fetch();
                if ($carrera_actual && $carrera_actual['imagen_url']) {
                    $archivo_actual = __DIR__ . '/../../public/' . $carrera_actual['imagen_url'];
                    if (file_exists($archivo_actual)) {
                        unlink($archivo_actual);
                        error_log('[CARRERA] Imagen eliminada: ' . $archivo_actual);
                    }
                }
                $imagen_url = null;
            }

            // Validar datos básicos
            if (empty($nombre) || empty($tipo_programa)) {
                throw new \Exception('El nombre y tipo de programa son obligatorios');
            }

            // Validar que al menos un código esté completo
            $codigosCompletos = false;
            for ($i = 0; $i < count($codigos); $i++) {
                $codigo = $codigos[$i] ?? null;
                $sede_id = $sedes[$i] ?? null;
                $id_unidad = $unidades[$i] ?? null;
                $vigencia_desde = $vigencias_desde[$i] ?? null;
                
                if ($codigo && $sede_id && $id_unidad && $vigencia_desde) {
                    $codigosCompletos = true;
                    break;
                }
            }
            
            if (!$codigosCompletos) {
                throw new \Exception('Debe completar al menos un código de carrera con todos sus datos');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Actualizar carrera
            $sql = "UPDATE carreras 
                    SET nombre = ?, tipo_programa = ?, estado = ?, url_libro = ?, imagen_url = ?, cantidad_semestres = ? 
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $tipo_programa, $estado, $url_libro, $imagen_url, $cantidad_semestres, $id]);

            // Eliminar códigos existentes
            $sql = "DELETE FROM carreras_espejos WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Insertar los nuevos códigos de carrera
            for ($i = 0; $i < count($codigos); $i++) {
                $codigo = $codigos[$i] ?? null;
                $sede_id = $sedes[$i] ?? null;
                $id_unidad = $unidades[$i] ?? null;
                $vigencia_desde = $vigencias_desde[$i] ?? null;
                $vigencia_hasta = $vigencias_hasta[$i] ?? null;
                if ($codigo && $sede_id && $id_unidad && $vigencia_desde) {
                    $sql = "INSERT INTO carreras_espejos (carrera_id, codigo_carrera, sede_id, id_unidad, vigencia_desde, vigencia_hasta, estado) VALUES (?, ?, ?, ?, ?, ?, 1)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        $id,
                        $codigo,
                        $sede_id,
                        $id_unidad,
                        $vigencia_desde,
                        $vigencia_hasta ?? '999999'
                    ]);
                }
            }

            // Confirmar transacción
            $this->pdo->commit();
            
            // Establecer mensaje de éxito
            $this->session->set('success', 'Carrera actualizada exitosamente');
            
            // Redirigir a la lista de carreras
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            // Establecer mensaje de error
            $this->session->set('error', 'Error al actualizar la carrera: ' . $e->getMessage());
            
            // Redirigir al formulario de edición
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras/' . $id . '/edit')
                ->withStatus(302);
        }
    }

    /**
     * Elimina un código específico de carrera.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function deleteCodigo(Request $request, Response $response, array $args = [])
    {
        $carreraId = $args['carrera_id'] ?? null;
        $codigoId = $args['codigo_id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                return $response->withHeader('Content-Type', 'application/json');
            }
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'login')
                ->withStatus(302);
        }

        try {
            // Verificar si el código existe y pertenece a la carrera
            $sql = "SELECT ce.codigo_carrera, c.nombre as carrera_nombre 
                    FROM carreras_espejos ce 
                    INNER JOIN carreras c ON ce.carrera_id = c.id 
                    WHERE ce.id = ? AND ce.carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$codigoId, $carreraId]);
            $codigo = $stmt->fetch();

            if (!$codigo) {
                $mensaje = 'El código de carrera no existe o no pertenece a esta carrera.';
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                    ->withStatus(302);
            }

            // NOTA: Las mallas se vinculan con el id de carreras, no con códigos específicos
            // Por lo tanto, no es necesario verificar mallas para eliminar códigos de carrera
            // Solo se verifica que el código no esté en reportes de cobertura

            // Verificar que no esté vinculado a reporte_coberturas_carreras_basicas
            // Primero obtener el código de carrera para verificar en los reportes
            $sql = "SELECT codigo_carrera FROM carreras_espejos WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$codigoId]);
            $codigoCarrera = $stmt->fetchColumn();

            if ($codigoCarrera) {
                // Verificar reportes de cobertura básica
                $sql = "SELECT COUNT(*) as total FROM reporte_coberturas_carreras_basicas 
                        WHERE codigo_carrera = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$codigoCarrera]);
                $result = $stmt->fetch();

                if ($result['total'] > 0) {
                    $mensaje = 'No se puede eliminar el código porque está vinculado a reportes de cobertura básica.';
                    if ($this->isAjaxRequest()) {
                        $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                        return $response->withHeader('Content-Type', 'application/json');
                    }
                    $this->session->set('error', $mensaje);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                        ->withStatus(302);
                }

                // Verificar reportes de cobertura complementaria
                $sql = "SELECT COUNT(*) as total FROM reporte_coberturas_carreras_complementarias 
                        WHERE codigo_carrera = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$codigoCarrera]);
                $result = $stmt->fetch();

                if ($result['total'] > 0) {
                    $mensaje = 'No se puede eliminar el código porque está vinculado a reportes de cobertura complementaria.';
                    if ($this->isAjaxRequest()) {
                        $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                        return $response->withHeader('Content-Type', 'application/json');
                    }
                    $this->session->set('error', $mensaje);
                    return $response
                        ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                        ->withStatus(302);
                }
            }

            // Verificar que exista al menos un código adicional después de la eliminación
            $sql = "SELECT COUNT(*) as total FROM carreras_espejos WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$carreraId]);
            $result = $stmt->fetch();

            if ($result['total'] <= 1) {
                $mensaje = 'No se puede eliminar el código porque debe existir al menos un código de carrera.';
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                    ->withStatus(302);
            }

            // Eliminar el código
            $sql = "DELETE FROM carreras_espejos WHERE id = ? AND carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$codigoId, $carreraId]);

            $mensaje = 'Código "' . $codigo['codigo_carrera'] . '" eliminado exitosamente de la carrera "' . $codigo['carrera_nombre'] . '"';
            
            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => true, 'message' => $mensaje]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $this->session->set('success', $mensaje);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                ->withStatus(302);

        } catch (\Exception $e) {
            $mensaje = 'Error al eliminar el código de carrera: ' . $e->getMessage();
            
            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                return $response->withHeader('Content-Type', 'application/json');
            }
            
            $this->session->set('error', $mensaje);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras/' . $carreraId . '/edit')
                ->withStatus(302);
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
    public function delete(Request $request, Response $response, array $args = [])
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => 'No autorizado']));
                return $response->withHeader('Content-Type', 'application/json');
            }
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'biblioges/login')
                ->withStatus(302);
        }

        try {
            // Verificar si la carrera tiene asignaturas vinculadas
            $sql = "SELECT COUNT(*) as total FROM mallas WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch();

            if ($result['total'] > 0) {
                $mensaje = 'No se puede eliminar la carrera porque tiene asignaturas vinculadas. Primero debe eliminar las asignaturas asociadas desde la gestión de mallas.';
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras')
                    ->withStatus(302);
            }

            // Verificar si la carrera existe
            $sql = "SELECT nombre FROM carreras WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $mensaje = 'La carrera no existe o ya fue eliminada.';
                if ($this->isAjaxRequest()) {
                    $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                    return $response->withHeader('Content-Type', 'application/json');
                }
                $this->session->set('error', $mensaje);
                return $response
                    ->withHeader('Location', Config::get('app_url') . 'carreras')
                    ->withStatus(302);
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Eliminar códigos de carrera primero
            $sql = "DELETE FROM carreras_espejos WHERE carrera_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Eliminar la carrera
            $sql = "DELETE FROM carreras WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            // Confirmar transacción
            $this->pdo->commit();

            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Carrera "' . $carrera['nombre'] . '" eliminada exitosamente']));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $this->session->set('success', 'Carrera "' . $carrera['nombre'] . '" eliminada exitosamente');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            // Detectar errores de restricción de clave foránea
            $mensaje = 'Error al eliminar la carrera';
            
            if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
                if (strpos($e->getMessage(), 'tesis_ibfk_2') !== false) {
                    $mensaje = 'No se puede eliminar la carrera porque está vinculada a tesis en bibliografías declaradas. Primero debe eliminar o cambiar las tesis asociadas.';
                } elseif (strpos($e->getMessage(), 'mallas_ibfk_1') !== false) {
                    $mensaje = 'No se puede eliminar la carrera porque tiene asignaturas vinculadas en la malla curricular. Primero debe eliminar las asignaturas asociadas.';
                } elseif (strpos($e->getMessage(), 'bibliografias_declaradas_ibfk') !== false) {
                    $mensaje = 'No se puede eliminar la carrera porque está vinculada a bibliografías declaradas. Primero debe eliminar o cambiar las bibliografías asociadas.';
                } elseif (strpos($e->getMessage(), 'bibliografias_disponibles_ibfk') !== false) {
                    $mensaje = 'No se puede eliminar la carrera porque está vinculada a bibliografías disponibles. Primero debe eliminar o cambiar las bibliografías asociadas.';
                } elseif (strpos($e->getMessage(), 'carreras_espejos_ibfk') !== false) {
                    $mensaje = 'No se puede eliminar la carrera porque tiene códigos de carrera asociados.';
                } elseif (strpos($e->getMessage(), 'FOREIGN KEY constraint fails') !== false) {
                    // Mensaje genérico para cualquier restricción de clave foránea
                    $mensaje = 'No se puede eliminar la carrera porque está siendo utilizada en otras partes del sistema. Verifique que no tenga datos asociados en bibliografías, mallas curriculares o tesis.';
                } else {
                    $mensaje = 'No se puede eliminar la carrera porque está siendo utilizada en otras partes del sistema. Verifique que no tenga datos asociados.';
                }
            } else {
                $mensaje .= ': ' . $e->getMessage();
            }

            if ($this->isAjaxRequest()) {
                $response->getBody()->write(json_encode(['success' => false, 'message' => $mensaje]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $this->session->set('error', $mensaje);
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
        }
    }

    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Limpia el estado guardado en sesión y redirige al listado
     */
    public function clearState(Request $request, Response $response, array $args = [])
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las carreras');
            return $response
                ->withHeader('Location', Config::get('app_url') . 'biblioges/login')
                ->withStatus(302);
        }

        try {
            // Limpiar el estado guardado en sesión
            $stateManager = new ListStateManager($this->session, 'carreras');
            $stateManager->clearState();
            
            // Redirigir al listado sin parámetros
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
                
        } catch (\Exception $e) {
            error_log('CarreraController clearState: Error: ' . $e->getMessage());
            $this->session->set('error', 'Error al limpiar los filtros: ' . $e->getMessage());
            return $response
                ->withHeader('Location', Config::get('app_url') . 'carreras')
                ->withStatus(302);
        }
    }
} 