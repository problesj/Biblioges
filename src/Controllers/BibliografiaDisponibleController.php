<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use App\Core\ListStateManager;
use PDO;
use PDOException;
use App\Core\Config;
use Illuminate\Support\Facades\DB;
use src\Models\BibliografiaDeclarada;
use src\Models\BibliografiaDisponible;
use src\Models\Sede;
use src\Models\Autor;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BibliografiaDisponibleController extends BaseController
{
    protected $twig;
    protected $flash;
    protected $pdo;
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;

        // Usar la instancia global de Flash
        global $flash;
        $this->flash = $flash;

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
    }

    /**
     * Muestra el listado de bibliografías disponibles
     */
    public function index(Request $request, Response $response): Response
    {
        try {
            // Inicializar el gestor de estado del listado
            $stateManager = new ListStateManager($this->session, 'bibliografias_disponibles');
            
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
            $allowedColumns = ['titulo', 'editorial', 'autores', 'estado'];
            
            $offset = ($page - 1) * $perPage;

            // Obtener filtros del estado
            $busqueda = $state['busqueda'] ?? null;
            $disponibilidad = $state['disponibilidad'] ?? null;
            $estado = $state['estado'] ?? null;
            $anioEdicion = $state['anio_edicion'] ?? null;

            // Construir consulta base
            $baseQuery = "
                SELECT DISTINCT bd.*, 
                       GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores_nombres
                FROM bibliografias_disponibles bd
                LEFT JOIN bibliografias_disponibles_autores bda ON bd.id = bda.bibliografia_disponible_id
                LEFT JOIN autores a ON bda.autor_id = a.id
                WHERE 1=1
            ";

            // Filtros
            $filters = [];
            $whereConditions = [];

            // Filtro por búsqueda
            if (!empty($busqueda)) {
                $whereConditions[] = "(bd.titulo LIKE ? OR bd.editorial LIKE ? OR a.nombres LIKE ? OR a.apellidos LIKE ?)";
                $filters[] = "%{$busqueda}%";
                $filters[] = "%{$busqueda}%";
                $filters[] = "%{$busqueda}%";
                $filters[] = "%{$busqueda}%";
            }

            // Filtro por disponibilidad
            if (!empty($disponibilidad)) {
                $whereConditions[] = "bd.disponibilidad = ?";
                $filters[] = $disponibilidad;
            }

            // Filtro por estado
            if ($estado !== null && $estado !== '') {
                $whereConditions[] = "bd.estado = ?";
                $filters[] = $estado;
            }

            // Filtro por año de edición
            if (!empty($anioEdicion)) {
                $whereConditions[] = "bd.anio_edicion = ?";
                $filters[] = $anioEdicion;
            }

            // Agregar condiciones WHERE
            if (!empty($whereConditions)) {
                $baseQuery .= " AND " . implode(" AND ", $whereConditions);
            }

            // Agregar GROUP BY
            $baseQuery .= " GROUP BY bd.id";

            // Ordenamiento
            switch ($sortColumn) {
                case 'titulo':
                    $baseQuery .= " ORDER BY bd.titulo " . $sortDirection;
                    break;
                case 'editorial':
                    $baseQuery .= " ORDER BY bd.editorial " . $sortDirection;
                    break;
                case 'autores':
                    $baseQuery .= " ORDER BY MIN(a.apellidos) " . $sortDirection . ", MIN(a.nombres) " . $sortDirection;
                    break;
                case 'estado':
                    $baseQuery .= " ORDER BY bd.estado " . $sortDirection;
                    break;
                default:
                    $baseQuery .= " ORDER BY bd.titulo ASC";
            }

            // Consulta para contar total de registros
            $countQuery = "
                SELECT COUNT(DISTINCT bd.id) as total
                FROM bibliografias_disponibles bd
                LEFT JOIN bibliografias_disponibles_autores bda ON bd.id = bda.bibliografia_disponible_id
                LEFT JOIN autores a ON bda.autor_id = a.id
                WHERE 1=1
            ";
            
            if (!empty($whereConditions)) {
                $countQuery .= " AND " . implode(" AND ", $whereConditions);
            }

            // Ejecutar consulta de conteo
            $stmt = $this->pdo->prepare($countQuery);
            $stmt->execute($filters);
            $totalRecords = $stmt->fetch()['total'];

            // Calcular total de páginas
            $totalPages = ceil($totalRecords / $perPage);
            $currentPage = max(1, min($page, $totalPages));

            // Consulta principal con LIMIT y OFFSET
            $mainQuery = $baseQuery . " LIMIT " . (int)$perPage . " OFFSET " . (int)$offset;
            
            // Ejecutar consulta principal
            $stmt = $this->pdo->prepare($mainQuery);
            $stmt->execute($filters);
            $bibliografias = $stmt->fetchAll();

            // Preparar datos para la vista
            $viewData = [
                'bibliografias' => $bibliografias,
                'stateManager' => $stateManager,
                'paginacion' => [
                    'current_page' => $currentPage,
                    'per_page' => $perPage,
                    'total_records' => $totalRecords,
                    'total_pages' => $totalPages,
                    'allowed_per_page' => $allowedPerPage
                ],
                'ordenamiento' => [
                    'column' => $sortColumn,
                    'direction' => $sortDirection
                ],
                'filtros' => [
                    'busqueda' => $busqueda,
                    'disponibilidad' => $disponibilidad,
                    'estado' => $estado,
                    'anio_edicion' => $anioEdicion
                ],
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];

            // Limpiar mensajes de sesión
            if (isset($_SESSION['success'])) {
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                unset($_SESSION['error']);
            }

            // Renderizar la plantilla
            $content = $this->twig->render('bibliografias_disponibles/index.twig', $viewData);
            
            // Establecer el contenido en la respuesta
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        } catch (\Exception $e) {
            error_log('Error al renderizar la plantilla: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function clearState(Request $request, Response $response): Response
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Por favor inicie sesión para acceder a las bibliografías',
                        'redirect' => Config::get('app_url') . 'login'
                    ]);
                    return $response;
                }
                
                $_SESSION['error'] = 'Por favor inicie sesión para acceder a las bibliografías';
                header('Location: ' . Config::get('app_url') . 'login');
                exit;
            }

            // Limpiar el estado del listado
            $stateManager = new ListStateManager($this->session, 'bibliografias_disponibles');
            $stateManager->clearState();

            return $response
                ->withHeader('Location', Config::get('app_url') . 'bibliografias-disponibles')
                ->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en BibliografiaDisponibleController@clearState: " . $e->getMessage());
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withBody($response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Error al limpiar los filtros: ' . $e->getMessage()
                ])));
        }
    }

    /**
     * Muestra el formulario de creación
     */
    public function create(Request $request, Response $response): Response
    {
        $bibliografiasDeclaradas = BibliografiaDeclarada::where('estado', true)->get();
        $sedes = Sede::where('estado', true)->get();
        $autores = Autor::orderBy('apellidos')->orderBy('nombres')->get();
        
        // Obtener editoriales únicas de ambas tablas
        $editorialesDeclaradas = BibliografiaDeclarada::whereNotNull('editorial')
            ->where('editorial', '!=', '')
            ->distinct()
            ->pluck('editorial')
            ->toArray();
            
        $editorialesDisponibles = BibliografiaDisponible::whereNotNull('editorial')
            ->where('editorial', '!=', '')
            ->distinct()
            ->pluck('editorial')
            ->toArray();
            
        $editoriales = array_unique(array_merge($editorialesDeclaradas, $editorialesDisponibles));
        sort($editoriales);
        
        // Agregar la opción "Otra" al final
        $editoriales[] = 'Otra';
        
        try {
            // error_log('Renderizando plantilla: bibliografias_disponibles/form.twig');
            
            $data = [
                'bibliografiasDeclaradas' => $bibliografiasDeclaradas,
                'sedes' => $sedes,
                'autores' => $autores,
                'editoriales' => $editoriales,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/form.twig', $data);
            // error_log('Plantilla renderizada correctamente');
            
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        } catch (\Exception $e) {
            error_log('Error al renderizar la plantilla: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Almacena una nueva bibliografía disponible
     */
    public function store(Request $request, Response $response): Response
    {
        // error_log('Iniciando método store()');
        
        try {
            $data = $_POST;
            // error_log('Datos recibidos: ' . print_r($data, true));
            
            // Validar datos básicos
            if (empty($data['titulo'])) {
                throw new \Exception('El título es requerido');
            }
            if (empty($data['anio_edicion'])) {
                throw new \Exception('El año de edición es requerido');
            }
            if (empty($data['disponibilidad'])) {
                throw new \Exception('La disponibilidad es requerida');
            }

            // Validar que el id_mms sea único si se proporciona
            if (!empty($data['id_mms'])) {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bibliografias_disponibles WHERE id_mms = :id_mms");
                $stmt->execute([':id_mms' => $data['id_mms']]);
                $count = $stmt->fetchColumn();
                
                if ($count > 0) {
                    // Si es una petición AJAX, devolver JSON con error
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => false,
                            'message' => 'El ID MMS ya existe en el sistema. Por favor, utilice otro valor.',
                            'formData' => $data
                        ]);
                        exit;
                    }
                    throw new \Exception('El ID MMS ya existe en el sistema. Por favor, utilice otro valor.');
                }
            }

            try {
                $this->pdo->beginTransaction();

                // Crear la bibliografía
                $stmt = $this->pdo->prepare("
                    INSERT INTO bibliografias_disponibles (
                        titulo, anio_edicion, disponibilidad, url_acceso, url_catalogo,
                        id_mms, ejemplares_digitales, editorial, bibliografia_declarada_id
                    ) VALUES (
                        :titulo, :anio_edicion, :disponibilidad, :url_acceso, :url_catalogo,
                        :id_mms, :ejemplares_digitales, :editorial, :bibliografia_declarada_id
                    )
                ");

                $stmt->execute([
                    ':titulo' => $data['titulo'],
                    ':anio_edicion' => $data['anio_edicion'],
                    ':disponibilidad' => $data['disponibilidad'],
                    ':url_acceso' => $data['url_acceso'] ?? null,
                    ':url_catalogo' => $data['url_catalogo'] ?? null,
                    ':id_mms' => $data['id_mms'] ?? null,
                    ':ejemplares_digitales' => !empty($data['ejemplares_digitales']) ? (int)$data['ejemplares_digitales'] : null,
                    ':editorial' => $data['editorial'] ?? null,
                    ':bibliografia_declarada_id' => !empty($data['bibliografia_declarada_id']) ? (int)$data['bibliografia_declarada_id'] : null
                ]);

                $bibliografiaId = $this->pdo->lastInsertId();

                // Procesar autores existentes
                $autoresIds = $data['autores'] ?? [];
                if (!empty($autoresIds)) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_autores (bibliografia_disponible_id, autor_id)
                        VALUES (:bibliografia_id, :autor_id)
                    ");
                    
                    foreach ($autoresIds as $autorId) {
                        // Solo procesar IDs que no sean temporales
                        if (!str_starts_with($autorId, 'temp_')) {
                        $stmt->execute([
                            ':bibliografia_id' => $bibliografiaId,
                            ':autor_id' => $autorId
                        ]);
                        }
                    }
                }

                // Procesar autores temporales
                $autoresTemp = json_decode($data['autores_temporales'] ?? '[]', true);
                if (!empty($autoresTemp)) {
                    $stmtAutor = $this->pdo->prepare("
                        INSERT INTO autores (nombres, apellidos, genero)
                        VALUES (:nombres, :apellidos, :genero)
                    ");

                    $stmtVinculacion = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_autores (bibliografia_disponible_id, autor_id)
                        VALUES (:bibliografia_id, :autor_id)
                    ");

                    foreach ($autoresTemp as $autorTemp) {
                        // Mapear el valor del género a los valores permitidos
                        $genero = 'Otro'; // Valor por defecto
                        if (!empty($autorTemp['genero'])) {
                            switch (strtolower($autorTemp['genero'])) {
                                case 'f':
                                case 'femenino':
                                    $genero = 'Femenino';
                                    break;
                                case 'm':
                                case 'masculino':
                                    $genero = 'Masculino';
                                    break;
                                default:
                                    $genero = 'Otro';
                            }
                        }

                        $stmtAutor->execute([
                            ':nombres' => $autorTemp['nombres'],
                            ':apellidos' => $autorTemp['apellidos'],
                            ':genero' => $genero
                        ]);

                        $autorId = $this->pdo->lastInsertId();
                        
                        $stmtVinculacion->execute([
                            ':bibliografia_id' => $bibliografiaId,
                            ':autor_id' => $autorId
                        ]);
                    }
                }

                // Procesar sedes y ejemplares si es necesario
                if (in_array($data['disponibilidad'], ['impreso', 'ambos'])) {
                    $sedes = $data['sedes'] ?? [];
                    $stmt = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_sedes (bibliografia_disponible_id, sede_id, ejemplares)
                        VALUES (:bibliografia_id, :sede_id, :ejemplares)
                    ");

                    foreach ($sedes as $sedeId => $sedeData) {
                        if (!empty($sedeData['ejemplares'])) {
                            $stmt->execute([
                                ':bibliografia_id' => $bibliografiaId,
                                ':sede_id' => $sedeId,
                                ':ejemplares' => (int)$sedeData['ejemplares']
                            ]);
                        }
                    }
                }

                $this->pdo->commit();

                // Si es una petición AJAX, devolver JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Bibliografía disponible creada exitosamente',
                        'redirect' => Config::get('app_url') . 'bibliografias-disponibles'
                    ]);
                    exit;
                }

                // Si no es AJAX, redirigir con mensaje flash
                if (isset($_SESSION)) {
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'message' => 'Bibliografía disponible creada exitosamente'
                    ];
                }
                header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
                exit;

            } catch (\Exception $e) {
                if (isset($this->pdo)) {
                    $this->pdo->rollBack();
                }
                throw $e;
            }

        } catch (\Exception $e) {
            error_log('Error al crear bibliografía disponible: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            // Si es una petición AJAX, devolver JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear la bibliografía disponible: ' . $e->getMessage(),
                    'formData' => $data
                ]);
                exit;
            }
            
            // Si no es AJAX, mostrar el formulario con el error
            $data = [
                'error' => 'Error al crear la bibliografía disponible: ' . $e->getMessage(),
                'bibliografiasDeclaradas' => BibliografiaDeclarada::where('estado', true)->get(),
                'sedes' => Sede::where('estado', true)->get(),
                'autores' => Autor::all(),
                'formData' => $data,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/form.twig', $data);
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        }
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        try {
            // Obtener la bibliografía con sus relaciones
            $bibliografia = BibliografiaDisponible::with(['sedes', 'autores'])->findOrFail($args['id']);
            
            // Obtener los ejemplares por sede
            $stmt = $this->pdo->prepare("
                SELECT sede_id, ejemplares 
                FROM bibliografias_disponibles_sedes 
                WHERE bibliografia_disponible_id = :id
            ");
            $stmt->execute([':id' => $args['id']]);
            $ejemplaresPorSede = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            // Crear un array asociativo de sedes con sus ejemplares
            $sedesConEjemplares = [];
            foreach ($bibliografia->sedes as $sede) {
                $sedesConEjemplares[$sede->id] = [
                    'id' => $sede->id,
                    'nombre' => $sede->nombre,
                    'ejemplares' => $ejemplaresPorSede[$sede->id] ?? 0
                ];
            }
            
            // Asignar el array de sedes con ejemplares a la bibliografía
            $bibliografia->sedes = $sedesConEjemplares;
            
            $bibliografiasDeclaradas = BibliografiaDeclarada::where('estado', true)->get();
            $autores = Autor::orderBy('apellidos')->orderBy('nombres')->get();

            // Obtener editoriales únicas de ambas tablas
            $editorialesDeclaradas = BibliografiaDeclarada::whereNotNull('editorial')
                ->where('editorial', '!=', '')
                ->distinct()
                ->pluck('editorial')
                ->toArray();
                
            $editorialesDisponibles = BibliografiaDisponible::whereNotNull('editorial')
                ->where('editorial', '!=', '')
                ->distinct()
                ->pluck('editorial')
                ->toArray();
                
            $editoriales = array_unique(array_merge($editorialesDeclaradas, $editorialesDisponibles));
            sort($editoriales);
            
            // Agregar la opción "Otra" al final
            $editoriales[] = 'Otra';

            // error_log('Renderizando plantilla: bibliografias_disponibles/form.twig');
            // error_log('Datos de sedes: ' . print_r($sedesConEjemplares, true));
            
            $data = [
                'bibliografia' => $bibliografia,
                'bibliografiasDeclaradas' => $bibliografiasDeclaradas,
                'sedes' => Sede::where('estado', true)->get(),
                'autores' => $autores,
                'editoriales' => $editoriales,
                'isEdit' => true,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/form.twig', $data);
            // error_log('Plantilla renderizada correctamente');
            
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        } catch (\Exception $e) {
            error_log('Error al renderizar la plantilla: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Actualiza una bibliografía disponible
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            
            // Obtener los datos del cuerpo de la petición
            $data = [];
            $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
            
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'), true);
            } else {
                parse_str(file_get_contents('php://input'), $data);
            }
            
            // Si no hay datos en el cuerpo, intentar obtenerlos de $_POST
            if (empty($data)) {
                $data = $_POST;
            }
            
            // error_log('Datos recibidos en update: ' . print_r($data, true));
            
            // Validar datos básicos
            if (empty($data['titulo'])) {
                throw new \Exception('El título es requerido');
            }
            if (empty($data['anio_edicion'])) {
                throw new \Exception('El año de edición es requerido');
            }
            if (empty($data['disponibilidad'])) {
                throw new \Exception('La disponibilidad es requerida');
            }

            // Validar que el id_mms sea único si se proporciona
            if (!empty($data['id_mms'])) {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bibliografias_disponibles WHERE id_mms = :id_mms AND id != :id");
                $stmt->execute([
                    ':id_mms' => $data['id_mms'],
                    ':id' => $args['id']
                ]);
                $count = $stmt->fetchColumn();
                
                if ($count > 0) {
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => false,
                            'message' => 'El ID MMS ya existe en el sistema. Por favor, utilice otro valor.',
                            'formData' => $data
                        ]);
                        exit;
                    }
                    throw new \Exception('El ID MMS ya existe en el sistema. Por favor, utilice otro valor.');
                }
            }

            try {
                $this->pdo->beginTransaction();

                // Actualizar la bibliografía
                $stmt = $this->pdo->prepare("
                    UPDATE bibliografias_disponibles SET
                        titulo = :titulo,
                        anio_edicion = :anio_edicion,
                        disponibilidad = :disponibilidad,
                        url_acceso = :url_acceso,
                        url_catalogo = :url_catalogo,
                        id_mms = :id_mms,
                        ejemplares_digitales = :ejemplares_digitales,
                        editorial = :editorial,
                        bibliografia_declarada_id = :bibliografia_declarada_id
                    WHERE id = :id
                ");

                $stmt->execute([
                    ':id' => $args['id'],
                    ':titulo' => $data['titulo'],
                    ':anio_edicion' => $data['anio_edicion'],
                    ':disponibilidad' => $data['disponibilidad'],
                    ':url_acceso' => $data['url_acceso'] ?? null,
                    ':url_catalogo' => $data['url_catalogo'] ?? null,
                    ':id_mms' => $data['id_mms'] ?? null,
                    ':ejemplares_digitales' => !empty($data['ejemplares_digitales']) ? (int)$data['ejemplares_digitales'] : null,
                    ':editorial' => $data['editorial'] ?? null,
                    ':bibliografia_declarada_id' => !empty($data['bibliografia_declarada_id']) ? (int)$data['bibliografia_declarada_id'] : null
                ]);

                // Actualizar autores existentes
                $stmt = $this->pdo->prepare("DELETE FROM bibliografias_disponibles_autores WHERE bibliografia_disponible_id = :id");
                $stmt->execute([':id' => $args['id']]);

                $autoresIds = $data['autores'] ?? [];
                if (!empty($autoresIds)) {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_autores (bibliografia_disponible_id, autor_id)
                        VALUES (:bibliografia_id, :autor_id)
                    ");
                    
                    foreach ($autoresIds as $autorId) {
                        // Solo procesar IDs que no sean temporales y no estén vacíos
                        if (!str_starts_with($autorId, 'temp_') && !empty($autorId) && is_numeric($autorId)) {
                        $stmt->execute([
                            ':bibliografia_id' => $args['id'],
                                ':autor_id' => (int)$autorId
                        ]);
                        }
                    }
                }

                // Procesar autores temporales
                $autoresTemp = json_decode($data['autores_temporales'] ?? '[]', true);
                if (!empty($autoresTemp)) {
                    $stmtAutor = $this->pdo->prepare("
                        INSERT INTO autores (nombres, apellidos, genero)
                        VALUES (:nombres, :apellidos, :genero)
                    ");

                    $stmtVinculacion = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_autores (bibliografia_disponible_id, autor_id)
                        VALUES (:bibliografia_id, :autor_id)
                    ");

                    foreach ($autoresTemp as $autorTemp) {
                        // Mapear el valor del género a los valores permitidos
                        $genero = 'Otro'; // Valor por defecto
                        if (!empty($autorTemp['genero'])) {
                            switch (strtolower($autorTemp['genero'])) {
                                case 'f':
                                case 'femenino':
                                    $genero = 'Femenino';
                                    break;
                                case 'm':
                                case 'masculino':
                                    $genero = 'Masculino';
                                    break;
                                default:
                                    $genero = 'Otro';
                            }
                        }

                        $stmtAutor->execute([
                            ':nombres' => $autorTemp['nombres'],
                            ':apellidos' => $autorTemp['apellidos'],
                            ':genero' => $genero
                        ]);

                        $autorId = $this->pdo->lastInsertId();
                        
                        $stmtVinculacion->execute([
                            ':bibliografia_id' => $args['id'],
                            ':autor_id' => $autorId
                        ]);
                    }
                }

                // Actualizar sedes y ejemplares
                $stmt = $this->pdo->prepare("DELETE FROM bibliografias_disponibles_sedes WHERE bibliografia_disponible_id = :id");
                $stmt->execute([':id' => $args['id']]);

                if (in_array($data['disponibilidad'], ['impreso', 'ambos'])) {
                    $sedes = $data['sedes'] ?? [];
                    $stmt = $this->pdo->prepare("
                        INSERT INTO bibliografias_disponibles_sedes (bibliografia_disponible_id, sede_id, ejemplares)
                        VALUES (:bibliografia_id, :sede_id, :ejemplares)
                    ");

                    foreach ($sedes as $sedeId => $sedeData) {
                        if (!empty($sedeData['ejemplares'])) {
                            $stmt->execute([
                                ':bibliografia_id' => $args['id'],
                                ':sede_id' => $sedeId,
                                ':ejemplares' => (int)$sedeData['ejemplares']
                            ]);
                        }
                    }
                }

                $this->pdo->commit();

                // Si es una petición AJAX, devolver JSON
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Bibliografía disponible actualizada exitosamente',
                        'redirect' => Config::get('app_url') . 'bibliografias-disponibles'
                    ]);
                    exit;
                }

                // Si no es AJAX, redirigir con mensaje flash
                if (isset($_SESSION)) {
                    $_SESSION['flash_message'] = [
                        'type' => 'success',
                        'message' => 'Bibliografía disponible actualizada exitosamente'
                    ];
                }
                header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
                exit;

            } catch (\Exception $e) {
                if (isset($this->pdo)) {
                    $this->pdo->rollBack();
                }
                throw $e;
            }

        } catch (\Exception $e) {
            error_log('Error al actualizar bibliografía disponible: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            // Si es una petición AJAX, devolver JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar la bibliografía disponible: ' . $e->getMessage(),
                    'formData' => $data
                ]);
                exit;
            }
            
            // Si no es AJAX, mostrar el formulario con el error
            $data = [
                'error' => 'Error al actualizar la bibliografía disponible: ' . $e->getMessage(),
                'bibliografia' => BibliografiaDisponible::find($args['id']),
                'bibliografiasDeclaradas' => BibliografiaDeclarada::where('estado', true)->get(),
                'sedes' => Sede::where('estado', true)->get(),
                'autores' => Autor::all(),
                'formData' => $data,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/form.twig', $data);
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        }
    }

    /**
     * Elimina una bibliografía disponible
     */
    public function destroy(Request $request, Response $response, array $args): Response
    {
        error_log('BibliografiaDisponibleController@destroy: Iniciando eliminación');
        error_log('ID recibido: ' . ($args['id'] ?? 'NO_ID'));
        error_log('Método HTTP: ' . $request->getMethod());
        error_log('URI: ' . $request->getUri()->getPath());
        
        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            error_log('Bibliografía encontrada: ' . $bibliografia->id);
            
            $bibliografia->delete();
            error_log('Bibliografía eliminada exitosamente');
            
            $_SESSION['success'] = 'Bibliografía disponible eliminada exitosamente';
            header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
            exit;
        } catch (\Exception $e) {
            error_log('Error al eliminar bibliografía: ' . $e->getMessage());
            $_SESSION['error'] = 'Error al eliminar la bibliografía disponible: ' . $e->getMessage();
            header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
            exit;
        }
    }

    /**
     * Vincula una bibliografía disponible con una bibliografía declarada
     */
    public function vincularBibliografiaDisponible(Request $request, Response $response, array $args): Response
    {
        $data = $this->validate([
            'bibliografia_declarada_id' => 'required|exists:bibliografias_declaradas,id'
        ]);

        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            $bibliografia->bibliografia_declarada_id = $data['bibliografia_declarada_id'];
            $bibliografia->save();

            return $response->withHeader('Location', '/bibliografias-disponibles')
                ->withStatus(302)
                ->with('success', 'Bibliografía disponible vinculada exitosamente');
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_disponibles/form.twig', [
                'error' => 'Error al vincular la bibliografía disponible: ' . $e->getMessage(),
                'bibliografia' => BibliografiaDisponible::find($args['id']),
                'bibliografiasDeclaradas' => BibliografiaDeclarada::where('estado', true)->get(),
                'sedes' => Sede::where('estado', true)->get(),
                'data' => $data
            ]);
        }
    }

    /**
     * Muestra los detalles de una bibliografía disponible
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        try {
            // Obtener la bibliografía con sus relaciones
            $bibliografia = BibliografiaDisponible::with([
                'sedes',
                'autores',
                'bibliografiaDeclarada' => function($query) {
                    $query->with('autores');
                }
            ])->findOrFail($args['id']);
            
            // error_log('Bibliografía encontrada: ' . print_r($bibliografia->toArray(), true));
            
            // Obtener los ejemplares por sede
            $stmt = $this->pdo->prepare("
                SELECT sede_id, ejemplares 
                FROM bibliografias_disponibles_sedes 
                WHERE bibliografia_disponible_id = :id
            ");
            $stmt->execute([':id' => $args['id']]);
            $ejemplaresPorSede = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            // error_log('Ejemplares por sede: ' . print_r($ejemplaresPorSede, true));
            
            // Crear un array asociativo de sedes con sus ejemplares
            $sedesConEjemplares = [];
            foreach ($bibliografia->sedes as $sede) {
                $sedesConEjemplares[$sede->id] = [
                    'id' => $sede->id,
                    'nombre' => $sede->nombre,
                    'ejemplares' => $ejemplaresPorSede[$sede->id] ?? 0
                ];
            }
            
            // error_log('Sedes con ejemplares: ' . print_r($sedesConEjemplares, true));
            
            // Asignar el array de sedes con ejemplares a la bibliografía
            $bibliografia->sedes = $sedesConEjemplares;
            
            // Convertir a array para asegurar que los datos se pasen correctamente
            $bibliografiaArray = $bibliografia->toArray();
            
            // error_log('Bibliografía array final: ' . print_r($bibliografiaArray, true));
            
            $data = [
                'bibliografia' => $bibliografiaArray,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/show.twig', $data);
            
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        } catch (\Exception $e) {
            error_log('Error al mostrar la bibliografía disponible: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            if (isset($_SESSION)) {
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => 'Error al mostrar la bibliografía disponible: ' . $e->getMessage()
                ];
            }
            
            header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
            exit;
        }
    }
} 