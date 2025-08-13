<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use App\Core\ListStateManager;
use PDO;
use PDOException;
use App\Core\Config;
use src\Models\BibliografiaDeclarada;
use src\Models\Autor;
use src\Models\Asignatura;
use App\Core\Request as AppRequest;
use App\Core\Response as AppResponse;
use Illuminate\Support\Facades\DB;
use src\Models\Libro;
use src\Models\Tesis;
use src\Models\Articulo;
use src\Models\Generico;
use src\Models\SitioWeb;
use src\Models\Software;
use src\Models\Carrera;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\Request as SlimRequest;

class BibliografiaDeclaradaController
{
    protected $session;
    protected $pdo;
    protected $twig;
    protected $flash;

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
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            
            // Establecer la codificación de la conexión
            $this->pdo->exec("SET CHARACTER SET utf8mb4");
            $this->pdo->exec("SET NAMES utf8mb4");
            $this->pdo->exec("SET collation_connection = 'utf8mb4_unicode_ci'");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;

        // Usar la instancia global de Flash
        global $flash;
        $this->flash = $flash;
    }

    public function index(Request $request = null, Response $response = null): Response
    {
        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

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

        try {
            // Inicializar el gestor de estado del listado
            $stateManager = new ListStateManager($this->session, 'bibliografias_declaradas');
            
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
            $allowedColumns = ['titulo', 'tipo', 'estado', 'autores', 'asignaturas', 'anio_publicacion'];
            
            $offset = ($page - 1) * $perPage;

            // Obtener filtros del estado
            $busqueda = $state['busqueda'] ?? null;
            $tipoBusqueda = $state['tipo_busqueda'] ?? null;
            $tipo = $state['tipo'] ?? null;
            $estado = $state['estado'] ?? null;

            // Construir la consulta base para contar total de registros
            $countSql = "SELECT COUNT(DISTINCT b.id) as total FROM bibliografias_declaradas b
                   LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
                   LEFT JOIN autores a ON ba.autor_id = a.id
                   LEFT JOIN asignaturas_bibliografias ab ON b.id = ab.bibliografia_id
                   LEFT JOIN asignaturas asig ON ab.asignatura_id = asig.id";

            // Construir la consulta principal
            $sql = "SELECT b.*, 
                   GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores,
                   GROUP_CONCAT(DISTINCT CONCAT(asig.nombre, ' (', ab.tipo_bibliografia, ')') SEPARATOR '; ') as asignaturas
                   FROM bibliografias_declaradas b
                   LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
                   LEFT JOIN autores a ON ba.autor_id = a.id
                   LEFT JOIN asignaturas_bibliografias ab ON b.id = ab.bibliografia_id
                   LEFT JOIN asignaturas asig ON ab.asignatura_id = asig.id";

            $params = [];
            $where = [];

            // Aplicar filtros de búsqueda
            if (!empty($busqueda)) {
                // Normalizar el texto de búsqueda: convertir a minúsculas y remover acentos
                $searchTerm = $this->normalizeSearchTerm($busqueda);
                
                // Dividir el término de búsqueda en palabras individuales
                $searchWords = array_filter(explode(' ', $searchTerm));
                
                if (!empty($searchWords)) {
                    switch ($tipoBusqueda) {
                        case 'titulo':
                            $conditions = [];
                            foreach ($searchWords as $word) {
                                if (!empty($word)) {
                                    $conditions[] = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(b.titulo, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ?";
                                    $params[] = '%' . $word . '%';
                                }
                            }
                            if (!empty($conditions)) {
                                $where[] = "(" . implode(' AND ', $conditions) . ")";
                            }
                            break;
                        case 'autor':
                            $conditions = [];
                            foreach ($searchWords as $word) {
                                if (!empty($word)) {
                                    $conditions[] = "(LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(a.nombres, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(a.apellidos, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ?)";
                                    $params[] = '%' . $word . '%';
                                    $params[] = '%' . $word . '%';
                                }
                            }
                            if (!empty($conditions)) {
                                $where[] = "(" . implode(' AND ', $conditions) . ")";
                            }
                            break;
                        case 'editorial':
                            $conditions = [];
                            foreach ($searchWords as $word) {
                                if (!empty($word)) {
                                    $conditions[] = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(b.editorial, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ?";
                                    $params[] = '%' . $word . '%';
                                }
                            }
                            if (!empty($conditions)) {
                                $where[] = "(" . implode(' AND ', $conditions) . ")";
                            }
                            break;
                        case 'asignatura':
                            $conditions = [];
                            foreach ($searchWords as $word) {
                                if (!empty($word)) {
                                    $conditions[] = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(asig.nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ?";
                                    $params[] = '%' . $word . '%';
                                }
                            }
                            if (!empty($conditions)) {
                                $where[] = "(" . implode(' AND ', $conditions) . ")";
                            }
                            break;
                        default: // 'todos'
                            $conditions = [];
                            foreach ($searchWords as $word) {
                                if (!empty($word)) {
                                    $conditions[] = "(LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(b.titulo, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(b.editorial, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(a.nombres, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(a.apellidos, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ? OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(asig.nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'), 'ñ', 'n')) LIKE ?)";
                                    $params[] = '%' . $word . '%';
                                    $params[] = '%' . $word . '%';
                                    $params[] = '%' . $word . '%';
                                    $params[] = '%' . $word . '%';
                                    $params[] = '%' . $word . '%';
                                }
                            }
                            if (!empty($conditions)) {
                                $where[] = "(" . implode(' AND ', $conditions) . ")";
                            }
                            break;
                    }
                }
            }

            // Aplicar otros filtros
            if (!empty($tipo)) {
                $where[] = "b.tipo = ?";
                $params[] = $tipo;
            }
            if ($estado !== null && $estado !== '') {
                $where[] = "b.estado = ?";
                $params[] = $estado === '1' ? 1 : 0;
            }

            // Agregar condiciones WHERE si existen
            if (!empty($where)) {
                $countSql .= " WHERE " . implode(" AND ", $where);
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            // Obtener total de registros
            $stmt = $this->pdo->prepare($countSql);
            $stmt->execute($params);
            $totalRecords = $stmt->fetch()['total'];
            
            // Calcular información de paginación
            $totalPages = ceil($totalRecords / $perPage);
            $currentPage = $page;
            
            // Agregar GROUP BY y ORDER BY a la consulta principal
            if ($sortColumn === 'autores') {
                $sql .= " GROUP BY b.id ORDER BY MIN(a.apellidos) {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            } elseif ($sortColumn === 'asignaturas') {
                $sql .= " GROUP BY b.id ORDER BY MIN(asig.nombre) {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            } else {
                $sql .= " GROUP BY b.id ORDER BY b.{$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
            }

            // Ejecutar la consulta final
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $bibliografias = $stmt->fetchAll();

            // Obtener las asignaturas para el filtro
            $stmt = $this->pdo->query("SELECT id, nombre FROM asignaturas WHERE estado = 1 ORDER BY nombre");
            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener datos del usuario
            $user = [
                'id' => $this->session->get('user_id'),
                'email' => $this->session->get('user_email'),
                'nombre' => $this->session->get('user_nombre'),
                'rol' => $this->session->get('user_rol')
            ];

            // Preparar datos para la vista
            $viewData = [
                'bibliografias' => $bibliografias,
                'asignaturas' => $asignaturas,
                'user' => $user,
                'current_page' => 'bibliografias_declaradas',
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'stateManager' => $stateManager,
                'filtros' => [
                    'busqueda' => $busqueda,
                    'tipo_busqueda' => $tipoBusqueda,
                    'tipo' => $tipo,
                    'estado' => $estado
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

            return $this->render($response, 'bibliografias_declaradas/index.twig', $viewData);
        } catch (\Exception $e) {
            //error_log('Error en index: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al listar las bibliografías: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function clearState(Request $request = null, Response $response = null): Response
    {
        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

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
            $stateManager = new ListStateManager($this->session, 'bibliografias_declaradas');
            $stateManager->clearState();

            return $response
                ->withHeader('Location', Config::get('app_url') . 'bibliografias-declaradas')
                ->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en BibliografiaDeclaradaController@clearState: " . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al limpiar los filtros: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    /**
     * Muestra el formulario para crear una nueva bibliografía declarada.
     */
    public function create(Request $request = null, Response $response = null): Response
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $_SESSION['error'] = 'Por favor inicie sesión para acceder a las bibliografías';
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Generar token de sesión
        $token = bin2hex(random_bytes(32));
        $this->session->set('form_token', $token);

        // Obtener editoriales
        $editoriales = $this->getEditoriales();
        
        // Obtener revistas
        $revistas = $this->getRevistas();
        
        // Obtener autores
        $autores = $this->getAutores();
        
        // Obtener carreras existentes en tesis
        $stmt = $this->pdo->query("
            SELECT DISTINCT nombre_carrera 
            FROM tesis 
            WHERE nombre_carrera IS NOT NULL AND nombre_carrera != ''
            ORDER BY nombre_carrera
        ");
        $carrerasExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Obtener todas las carreras del sistema
        $stmt = $this->pdo->query("
            SELECT id, nombre 
            FROM carreras 
            WHERE estado = 1 
            ORDER BY nombre
        ");
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener duplicados y datos del formulario si existen en sesión
        $duplicados = $this->session->get('duplicados');
        $datosFormulario = $this->session->get('datos_formulario');
        $error = $this->session->get('error');
        
        // Limpiar datos de sesión
        $this->session->remove('duplicados');
        $this->session->remove('datos_formulario');
        $this->session->remove('error');
        
        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'bibliografia' => $datosFormulario ? (object)$datosFormulario : new \stdClass(),
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'autores' => $autores,
            'carreras' => $carreras,
            'carrerasExistentes' => $carrerasExistentes,
            'app_url' => Config::get('app_url'),
            'session' => [
                'form_token' => $token
            ],
            'duplicados' => $duplicados,
            'error' => $error
        ]);
    }

    /**
     * Almacena una nueva bibliografía declarada.
     */
    public function store(Request $request = null, Response $response = null): Response
    {
        //error_log('=== INICIO MÉTODO STORE ===');
        
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

        // Verificar si es una petición AJAX
        $esAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        //error_log('Es petición AJAX: ' . ($esAjax ? 'Sí' : 'No'));
        
        // Obtener los datos según el tipo de petición
        if ($esAjax) {
            $datos = json_decode(file_get_contents('php://input'), true);
        } else {
            $datos = $_POST;
        }
        
        //error_log('Datos recibidos: ' . print_r($datos, true));
        
        // Verificar token de sesión para prevenir doble envío
        $token = $datos['_token'] ?? '';
        $sessionToken = $this->session->get('form_token');
        
        if (!$token || !$sessionToken || $token !== $sessionToken) {
            // Token inválido o no coincide
            if ($esAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Token de seguridad inválido'
                ]);
                return new Response();
            }
            
            $_SESSION['error'] = 'Token de seguridad inválido';
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            return new Response();
        }
        
        // Generar nuevo token para la siguiente solicitud
        $newToken = bin2hex(random_bytes(32));
        $this->session->set('form_token', $newToken);
        
        // Decodificar los autores
        $autores = json_decode($datos['autores'] ?? '[]', true);
        //error_log('Autores decodificados: ' . print_r($autores, true));
        
        try {
            // Verificar duplicados antes de proceder
            $titulo = $datos['titulo'] ?? '';
            if (!empty($titulo)) {
                $duplicados = $this->buscarDuplicados($titulo);
                
                if (!empty($duplicados)) {
                    // Si es AJAX, devolver los duplicados para que el frontend los muestre
                    if ($esAjax) {
                        return $this->jsonResponse([
                            'success' => false,
                            'duplicados' => true,
                            'message' => 'Se encontraron títulos similares en la base de datos',
                            'duplicados_list' => $duplicados
                        ]);
                    }
                    
                    // Si no es AJAX, guardar en sesión y redirigir
                    $_SESSION['duplicados'] = $duplicados;
                    $_SESSION['datos_formulario'] = $datos;
                    $_SESSION['error'] = 'Se encontraron títulos similares. Por favor revise la lista de duplicados.';
                    header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/create');
                    return new Response();
                }
            }
            
            $this->pdo->beginTransaction();
            
            // Insertar la bibliografía
                            $stmt = $this->pdo->prepare("
                INSERT INTO bibliografias_declaradas (
                    titulo, anio_publicacion, edicion, url, formato, 
                    nota, tipo, editorial, doi, estado
                ) VALUES (
                    :titulo, :anio_publicacion, :edicion, :url, :formato,
                    :nota, :tipo, :editorial, :doi, :estado
                )
                            ");
                            
                            $stmt->execute([
                ':titulo' => $datos['titulo'] ?? '',
                ':anio_publicacion' => $datos['anio_publicacion'] ?? null,
                ':edicion' => $datos['edicion'] ?? null,
                ':url' => $datos['url'] ?? null,
                ':formato' => $datos['formato'] ?? 'impreso',
                ':nota' => $datos['nota'] ?? null,
                ':tipo' => $datos['tipo'] ?? null,
                ':editorial' => ($datos['editorial'] ?? '') === 'otra' ? ($datos['nueva_editorial'] ?? '') : ($datos['editorial'] ?? ''),
                ':doi' => $datos['doi'] ?? null,
                ':estado' => $datos['estado'] ?? 1
            ]);
            
            $bibliografiaId = $this->pdo->lastInsertId();
            
            // Insertar datos específicos según el tipo
            switch ($datos['tipo'] ?? '') {
                case 'libro':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO libros (bibliografia_id, isbn)
                        VALUES (:bibliografia_id, :isbn)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':isbn' => $datos['isbn'] ?? null
                    ]);
                    break;

                case 'tesis':
                    $nombreCarrera = $datos['nombre_carrera'] ?? null;
                    if ($nombreCarrera === 'otra') {
                        $nombreCarrera = $datos['nueva_carrera'] ?? null;
                    }
                    $stmt = $this->pdo->prepare("
                        INSERT INTO tesis (bibliografia_id, nombre_carrera)
                        VALUES (:bibliografia_id, :nombre_carrera)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':nombre_carrera' => $nombreCarrera
                    ]);
                    break;

                case 'articulo':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO articulos (
                            bibliografia_id, issn, titulo_revista, cronologia
                        ) VALUES (
                            :bibliografia_id, :issn, :titulo_revista, :cronologia
                        )
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':issn' => $datos['issn'] ?? null,
                        ':titulo_revista' => ($datos['titulo_revista'] ?? '') === 'otra' ? ($datos['nueva_revista'] ?? '') : ($datos['titulo_revista'] ?? ''),
                        ':cronologia' => $datos['cronologia'] ?? null
                    ]);
                    break;

                case 'generico':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO genericos (bibliografia_id, descripcion)
                        VALUES (:bibliografia_id, :descripcion)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':descripcion' => $datos['descripcion'] ?? null
                    ]);
                    break;

                case 'sitio_web':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO sitios_web (bibliografia_id, fecha_consulta)
                        VALUES (:bibliografia_id, :fecha_consulta)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':fecha_consulta' => $datos['fecha_consulta'] ?? null
                    ]);
                    break;

                case 'software':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO software (bibliografia_id, version)
                        VALUES (:bibliografia_id, :version)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':version' => $datos['version'] ?? null
                    ]);
                    break;
            }

            // Procesar los autores
            if (!empty($autores)) {
                foreach ($autores as $autor) {
                    //error_log('Procesando autor en store: ' . print_r($autor, true));
                    
                    if ($autor['es_nuevo'] || strpos($autor['temp_id'] ?? '', 'temp_') === 0) {
                        // Es un autor nuevo
                        $stmt = $this->pdo->prepare("
                            INSERT INTO autores (apellidos, nombres, genero)
                            VALUES (?, ?, ?)
                        ");
                        $stmt->execute([
                            $autor['apellidos'],
                            $autor['nombres'],
                            $autor['genero']
                        ]);
                        $autorId = $this->pdo->lastInsertId();
                        //error_log('Nuevo autor insertado con ID: ' . $autorId);
                    } else {
                        // Es un autor existente
                        $autorId = $autor['id'];
                    }
                    
                    if ($autorId) {
                        // Vincular autor con la bibliografía
                        $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_autores (bibliografia_id, autor_id)
                            VALUES (?, ?)
                        ");
                        $stmt->execute([
                            $bibliografiaId,
                            $autorId
                        ]);
                        //error_log('Autor vinculado con ID: ' . $autorId);
                    }
                }
            }
            
            $this->pdo->commit();

            if ($esAjax) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Bibliografía creada exitosamente',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);
                return new Response();
            }

            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            return new Response();

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            //error_log('Error de base de datos en store: ' . $e->getMessage());
            
            // Mensajes específicos según el código de error
            $mensajeError = 'Error al crear la bibliografía: ';
            
            switch ($e->getCode()) {
                case '22001': // Error de truncamiento de datos
                    if (strpos($e->getMessage(), 'isbn') !== false) {
                        $mensajeError .= 'El ISBN ingresado es demasiado largo. Por favor, verifique el formato.';
                    } elseif (strpos($e->getMessage(), 'titulo') !== false) {
                        $mensajeError .= 'El título es demasiado largo. Máximo 250 caracteres permitidos.';
                    } elseif (strpos($e->getMessage(), 'editorial') !== false) {
                        $mensajeError .= 'El nombre de la editorial es demasiado largo. Máximo 250 caracteres permitidos.';
                    } else {
                        $mensajeError .= 'Uno de los campos excede el tamaño máximo permitido.';
                    }
                    break;
                    
                case '23000': // Error de integridad (duplicado, clave foránea, etc.)
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        $mensajeError .= 'Ya existe una bibliografía con los mismos datos.';
                    } elseif (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                        $mensajeError .= 'Error de referencia: uno de los datos relacionados no existe.';
                    } else {
                        $mensajeError .= 'Error de integridad en los datos.';
                    }
                    break;
                    
                case '42S02': // Tabla no existe
                    $mensajeError .= 'Error en la estructura de la base de datos.';
                    break;
                    
                case '42S22': // Columna no existe
                    $mensajeError .= 'Error en la estructura de la base de datos.';
                    break;
                    
                default:
                    $mensajeError .= 'Error en la base de datos: ' . $e->getMessage();
            }

            if ($esAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => $mensajeError
                ]);
                return new Response();
            }

            $_SESSION['error'] = $mensajeError;
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/create');
            return new Response();
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            //error_log('Error general en store: ' . $e->getMessage());

            if ($esAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear la bibliografía: ' . $e->getMessage()
                ]);
                return new Response();
            }

            $_SESSION['error'] = 'Error al crear la bibliografía: ' . $e->getMessage();
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/create');
            return new Response();
        }
    }

    /**
     * Muestra los detalles de una bibliografía declarada.
     */
    public function show(Request $request, Response $response, array $args = []): Response
    {
        try {
            $id = $args['id'] ?? null;
            
            // Obtener la bibliografía declarada
            $bibliografia = $this->obtenerBibliografiaCompleta($id);
            // Construir enlace de DOI si corresponde
            if (is_array($bibliografia) && !empty($bibliografia['doi'])) {
                $doiValue = trim((string) $bibliografia['doi']);
                // Normalizar por si viene con prefijo completo usando delimitador '#'
                $doiValue = preg_replace('#^https?://(?:dx\.)?doi\.org/#i', '', $doiValue);
                $bibliografia['doi_link'] = 'https://doi.org/' . $doiValue;
            } else {
                $bibliografia['doi_link'] = null;
            }
            
            // Obtener las asignaturas vinculadas
            $asignaturas = $this->obtenerAsignaturasVinculadas($id);
            
            // Obtener las bibliografías disponibles asociadas
        $stmt = $this->pdo->prepare("
                SELECT 
                    bd.id,
                    bd.id_mms,
                    bd.titulo,
                    bd.anio_edicion,
                    bd.editorial,
                    bd.url_acceso,
                    bd.url_catalogo,
                    bd.disponibilidad,
                    GROUP_CONCAT(CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores
                FROM bibliografias_disponibles bd
                LEFT JOIN bibliografias_disponibles_autores bda ON bd.id = bda.bibliografia_disponible_id
                LEFT JOIN autores a ON bda.autor_id = a.id
                WHERE bd.bibliografia_declarada_id = ?
                GROUP BY bd.id
                ORDER BY bd.id DESC
            ");
            $stmt->execute([$id]);
            $bibliografiasDisponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $this->render($response, 'bibliografias_declaradas/show.twig', [
                'bibliografia' => $bibliografia,
                'asignaturas' => $asignaturas,
                'bibliografias_disponibles' => $bibliografiasDisponibles
            ]);
            
        } catch (\Exception $e) {
            //error_log('Error en show: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al mostrar la bibliografía: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    /**
     * Muestra el formulario para editar una bibliografía declarada.
     */
    public function edit(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error de acceso',
                'text' => 'Por favor inicie sesión para acceder a las bibliografías'
            ]);
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            $bibliografia = $this->obtenerBibliografiaCompleta($id);

        if (!$bibliografia) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Bibliografía no encontrada'
                ]);
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

            $autores = Autor::orderBy('apellidos')->orderBy('nombres')->get();
            $editoriales = BibliografiaDeclarada::distinct()->pluck('editorial')->filter();
            $revistas = Articulo::distinct()->pluck('titulo_revista')->filter();
            $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();
            
            // Obtener carreras existentes en tesis
            $stmt = $this->pdo->query("
                SELECT DISTINCT nombre_carrera 
                FROM tesis 
                WHERE nombre_carrera IS NOT NULL AND nombre_carrera != ''
                ORDER BY nombre_carrera
            ");
            $carrerasExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'bibliografia' => $bibliografia,
                'autores' => $autores,
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'carreras' => $carreras,
            'carrerasExistentes' => $carrerasExistentes,
                'app_url' => Config::get('app_url'),
            'isEdit' => true,
                'swal' => $swal
            ]);
        } catch (\Exception $e) {
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al obtener los datos de la bibliografía: ' . $e->getMessage()
            ]);
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }
    }

    /**
     * Actualiza una bibliografía declarada.
     */
    public function update(Request $request, Response $response, array $args = []): Response
    {
        try {
            $id = $args['id'] ?? null;
            
            //error_log('=== INICIO MÉTODO UPDATE ===');
            //error_log('ID recibido: ' . $id);
            
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para acceder a las bibliografías',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
            }
        
            // Limpiar cualquier salida anterior
            while (ob_get_level()) {
                ob_end_clean();
            }
        
            // Verificar si es una petición AJAX
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
            //error_log('Es petición AJAX: ' . ($isAjax ? 'Sí' : 'No'));

            // Obtener los datos del cuerpo de la petición
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
            //error_log('Datos JSON recibidos: ' . print_r($data, true));

            if (!$data) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'No se recibieron datos válidos'
                ])->withStatus(400);
            }

            // Verificar que la bibliografía existe
            $stmt = $this->pdo->prepare("SELECT id FROM bibliografias_declaradas WHERE id = ?");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'La bibliografía no existe'
                ])->withStatus(404);
            }

            // Obtener los autores
            $autores = json_decode($data['autores'] ?? '[]', true);
            //error_log('Autores decodificados: ' . print_r($autores, true));

            // Iniciar transacción
            $this->pdo->beginTransaction();
            
            try {
                // Actualizar la bibliografía base
                $sql = "UPDATE bibliografias_declaradas SET 
                    titulo = ?, 
                    anio_publicacion = ?, 
                    edicion = ?, 
                    url = ?, 
                    formato = ?, 
                    nota = ?, 
                    tipo = ?, 
                    editorial = ?, 
                    doi = ?,
                    estado = ?,
                    fecha_actualizacion = CURRENT_TIMESTAMP
                    WHERE id = ?";
                
                $stmt = $this->pdo->prepare($sql);

                $params = [
                    $data['titulo'],
                    $data['anio_publicacion'],
                    $data['edicion'] ?? null,
                    $data['url'] ?? null,
                    $data['formato'],
                    $data['nota'] ?? null,
                    $data['tipo'],
                    $data['editorial'] === 'otra' ? $data['nueva_editorial'] : $data['editorial'],
                    $data['doi'] ?? null,
                    $data['estado'] ?? 1,
                    $id
                ];
                
                //error_log('Parámetros para actualización base: ' . print_r($params, true));
                $stmt->execute($params);

                // Eliminar todas las vinculaciones de autores existentes
                $stmt = $this->pdo->prepare("DELETE FROM bibliografias_autores WHERE bibliografia_id = ?");
                $stmt->execute([$id]);
                //error_log('Vinculaciones de autores eliminadas');

                // Procesar autores
                if (!empty($autores)) {
                    foreach ($autores as $autor) {
                        //error_log('Procesando autor: ' . print_r($autor, true));
                        
                        if ($autor['es_nuevo'] || strpos($autor['temp_id'] ?? '', 'temp_') === 0) {
                            // Es un autor nuevo
                $stmt = $this->pdo->prepare("
                                INSERT INTO autores (apellidos, nombres, genero)
                                VALUES (?, ?, ?)
                ");
                $stmt->execute([
                                $autor['apellidos'],
                                $autor['nombres'],
                                $autor['genero']
                            ]);
                            $autorId = $this->pdo->lastInsertId();
                            //error_log('Nuevo autor insertado con ID: ' . $autorId);
                        } else {
                            // Es un autor existente
                            $autorId = $autor['id'];
                        }

                        // Vincular el autor con la bibliografía
                $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_autores (bibliografia_id, autor_id)
                            VALUES (?, ?)
                        ");
                        $stmt->execute([$id, $autorId]);
                        //error_log('Autor vinculado con ID: ' . $autorId);
                    }
                }

                // Actualizar campos específicos según el tipo
                switch ($data['tipo']) {
                    case 'libro':
                        $stmt = $this->pdo->prepare("
                            UPDATE libros SET isbn = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['isbn'] ?? null, $id]);
                        break;

                    case 'tesis':
                            $stmt = $this->pdo->prepare("
                            UPDATE tesis SET nombre_carrera = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['nombre_carrera'] ?? null, $id]);
                        break;

                    case 'articulo':
                        $stmt = $this->pdo->prepare("
                            UPDATE articulos SET 
                                issn = ?, 
                                titulo_revista = ?, 
                                cronologia = ? 
                            WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([
                            $data['issn'] ?? null,
                            $data['titulo_revista'] === 'otra' ? $data['nueva_revista'] : $data['titulo_revista'],
                            $data['cronologia'] ?? null,
                            $id
                        ]);
                        break;

                    case 'generico':
                        $stmt = $this->pdo->prepare("
                            UPDATE genericos SET descripcion = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['descripcion'] ?? null, $id]);
                        break;

                    case 'sitio_web':
                        $stmt = $this->pdo->prepare("
                            UPDATE sitios_web SET fecha_consulta = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['fecha_consulta'] ?? null, $id]);
                        break;

                    case 'software':
                        $stmt = $this->pdo->prepare("
                            UPDATE software SET version = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['version'] ?? null, $id]);
                        break;
                }

                // Confirmar transacción
                $this->pdo->commit();

                // Enviar respuesta de éxito
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Bibliografía actualizada correctamente',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $this->pdo->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            //error_log('Error en BibliografiaDeclaradaController::update: ' . $e->getMessage());
            //error_log('Stack trace: ' . $e->getTraceAsString());
            
            // Enviar respuesta de error
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Ha ocurrido un error al actualizar la bibliografía: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    private function sendJsonResponse(bool $success, string $message, ?string $redirect = null): void
    {
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Preparar la respuesta
                $response = [
            'success' => $success,
            'message' => $message
        ];

        if ($redirect) {
            $response['redirect'] = $redirect;
        }

        // Enviar headers
        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');

        // Enviar respuesta
            echo json_encode($response);
            exit;
    }

    /**
     * Elimina una bibliografía declarada.
     */
    public function destroy(Request $request, Response $response, array $args = []): Response
    {
        try {
            $id = $args['id'] ?? null;
            
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'Error de acceso',
                    'text' => 'Por favor inicie sesión para acceder a las bibliografías'
                ]);
                header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

            // Verificar si la bibliografía tiene asignaturas vinculadas
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total 
                FROM asignaturas_bibliografias 
                WHERE bibliografia_id = ?
            ");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado['total'] > 0) {
                $this->session->set('swal', [
                    'icon' => 'error',
                    'title' => 'No se puede eliminar',
                    'text' => 'No es posible eliminar esta bibliografía porque tiene asignaturas vinculadas. Por favor, desvincule las asignaturas primero.'
                ]);
                header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
                exit;
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Eliminar relaciones primero
            $this->pdo->exec("DELETE FROM bibliografias_autores WHERE bibliografia_id = " . $id);

            // Eliminar detalles específicos según el tipo
            $this->pdo->exec("DELETE FROM libros WHERE bibliografia_id = " . $id);
            $this->pdo->exec("DELETE FROM tesis WHERE bibliografia_id = " . $id);
            $this->pdo->exec("DELETE FROM articulos WHERE bibliografia_id = " . $id);
            $this->pdo->exec("DELETE FROM genericos WHERE bibliografia_id = " . $id);
            $this->pdo->exec("DELETE FROM sitios_web WHERE bibliografia_id = " . $id);
            $this->pdo->exec("DELETE FROM software WHERE bibliografia_id = " . $id);

            // Finalmente, eliminar la bibliografía base
            $this->pdo->exec("DELETE FROM bibliografias_declaradas WHERE id = " . $id);

            // Confirmar transacción
            $this->pdo->commit();

            // Establecer mensaje de éxito
            $this->session->set('swal', [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Bibliografía eliminada correctamente'
            ]);

            // Redirigir al listado
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $this->pdo->rollBack();
            
            //error_log('Error en destroy: ' . $e->getMessage());
            //error_log('Stack trace: ' . $e->getTraceAsString());

            // Establecer mensaje de error
            $this->session->set('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error al eliminar la bibliografía: ' . $e->getMessage()
            ]);

            // Redirigir al listado
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }
    }

    /**
     * Muestra el formulario para vincular asignaturas.
     */
    public function vincular(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'] ?? null;
        
        //error_log('Iniciando método vincular con ID: ' . $id);
        //error_log('URL de la aplicación: ' . Config::get('app_url'));
        //error_log('Ruta base: ' . $_SERVER['REQUEST_URI']);
        
        // Limpiar mensajes de error anteriores
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
        
        if (!$id) {
            $id = $_GET['id'] ?? null;
            //error_log('ID obtenido de GET: ' . $id);
        }

        if (!$id) {
            //error_log('Error: ID de bibliografía no proporcionado');
            $_SESSION['error'] = 'ID de bibliografía no proporcionado';
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        try {
            //error_log('Obteniendo bibliografía completa para ID: ' . $id);
            // Obtener la bibliografía con sus datos específicos
            $bibliografia = $this->obtenerBibliografiaCompleta($id);
            if (!$bibliografia) {
                //error_log('Error: Bibliografía no encontrada para ID: ' . $id);
                throw new \Exception('Bibliografía no encontrada');
            }
            //error_log('Bibliografía obtenida: ' . print_r($bibliografia, true));

            // Obtener la estructura jerárquica de sedes, facultades y departamentos
            //error_log('Obteniendo estructura jerárquica');
            $stmt = $this->pdo->query("
                SELECT 
                    s.id as sede_id,
                    s.nombre as sede_nombre,
                    u.id as unidad_id,
                    u.nombre as unidad_nombre,
                    u.codigo as unidad_codigo
                FROM sedes s
                LEFT JOIN unidades u ON u.sede_id = s.id
                ORDER BY s.nombre, u.nombre
            ");
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Organizar los resultados en una estructura jerárquica
            $sedes = [];
            foreach ($resultados as $row) {
                if (!isset($sedes[$row['sede_id']])) {
                    $sedes[$row['sede_id']] = [
                        'id' => $row['sede_id'],
                        'nombre' => $row['sede_nombre'],
                        'unidades' => []
                    ];
                }
                
                if ($row['unidad_id'] && !isset($sedes[$row['sede_id']]['unidades'][$row['unidad_id']])) {
                    $sedes[$row['sede_id']]['unidades'][$row['unidad_id']] = [
                        'id' => $row['unidad_id'],
                        'nombre' => $row['unidad_nombre'],
                        'codigo' => $row['unidad_codigo']
                    ];
                }
            }
            
            // Convertir el array asociativo a array indexado
            $sedes = array_values($sedes);
            foreach ($sedes as &$sede) {
                $sede['unidades'] = array_values($sede['unidades']);
            }
            
            //error_log('Estructura jerárquica obtenida: ' . print_r($sedes, true));

            // Ordenar sedes por nombre
            usort($sedes, function($a, $b) {
                return strcmp($a['nombre'], $b['nombre']);
            });
            // Ordenar unidades por nombre en cada sede
            foreach ($sedes as &$sede) {
                if (isset($sede['unidades']) && is_array($sede['unidades'])) {
                    usort($sede['unidades'], function($a, $b) {
                        return strcmp($a['nombre'], $b['nombre']);
                    });
                }
            }

            // Obtener las asignaturas vinculadas
            //error_log('Obteniendo asignaturas vinculadas');
            $stmt = $this->pdo->prepare("
                SELECT 
                    ab.id as vinculacion_id,
                    a.id, 
                    a.nombre,
                    GROUP_CONCAT(DISTINCT TRIM(ad.codigo_asignatura) ORDER BY TRIM(ad.codigo_asignatura) SEPARATOR '\n') as codigos,
                    ab.tipo_bibliografia
                FROM asignaturas_bibliografias ab
                JOIN asignaturas a ON ab.asignatura_id = a.id
                LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                WHERE ab.bibliografia_id = ?
                GROUP BY ab.id, a.id, a.nombre, ab.tipo_bibliografia
                ORDER BY MIN(TRIM(ad.codigo_asignatura)), a.nombre
            ");
            $stmt->execute([$id]);
            $asignaturas_vinculadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //error_log('Asignaturas vinculadas obtenidas: ' . print_r($asignaturas_vinculadas, true));

            // Obtener los filtros de la URL
            $filtros = [
                'unidad' => $_GET['unidad'] ?? null,
                'tipo_asignatura' => $_GET['tipo_asignatura'] ?? null,
                'busqueda' => $_GET['busqueda'] ?? null
            ];
            //error_log('Filtros aplicados: ' . print_r($filtros, true));

            // Obtener las asignaturas disponibles
            error_log('Obteniendo asignaturas disponibles con filtros: ' . print_r($filtros, true));
            $asignaturas_disponibles = $this->obtenerAsignaturasDisponibles($id, $filtros);
            error_log('Asignaturas disponibles obtenidas: ' . count($asignaturas_disponibles) . ' registros');

            // Crear una nueva respuesta si no se proporciona una
            if (!$response) {
                //error_log('Creando nueva respuesta');
                $response = new Response();
            }

            //error_log('Renderizando vista vincular.twig');
            // Renderizar la vista
            $content = $this->twig->render('bibliografias_declaradas/vincular.twig', [
                'bibliografia' => $bibliografia,
                'sedes' => $sedes,
                'asignaturas_vinculadas' => $asignaturas_vinculadas,
                'asignaturas_disponibles' => $asignaturas_disponibles,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-declaradas'
            ]);

            // Establecer el contenido en la respuesta
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;

        } catch (\Exception $e) {
            error_log('Error en método vincular: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $_SESSION['error'] = 'Error al cargar la página: ' . $e->getMessage();
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }
    }

    /**
     * Endpoint AJAX para obtener asignaturas disponibles filtradas.
     */
    public function vincularAjax(Request $request, Response $response, array $args = []): Response
    {
        try {
            $id = $args['id'] ?? null;
            
            if (!$id) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'ID de bibliografía no proporcionado'
                ]);
            }

            // Obtener los filtros de la URL
            $filtros = [
                'unidad' => $_GET['unidad'] ?? null,
                'tipo_asignatura' => $_GET['tipo_asignatura'] ?? null,
                'busqueda' => $_GET['busqueda'] ?? null
            ];

            // Obtener las asignaturas disponibles
            $asignaturas_disponibles = $this->obtenerAsignaturasDisponibles($id, $filtros);

            return $this->jsonResponse([
                'success' => true,
                'asignaturas' => $asignaturas_disponibles
            ]);

        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al obtener asignaturas: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtiene las asignaturas disponibles para vincular.
     */
    private function obtenerAsignaturasDisponibles($bibliografiaId, $filtros = [])
    {
        $sql = "
            SELECT DISTINCT 
                a.id, 
                a.nombre,
                GROUP_CONCAT(DISTINCT TRIM(ad.codigo_asignatura) ORDER BY TRIM(ad.codigo_asignatura) SEPARATOR ', ') as codigos,
                ab.tipo_bibliografia
            FROM asignaturas a
            INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            INNER JOIN unidades u ON ad.id_unidad = u.id
            INNER JOIN sedes s ON u.sede_id = s.id
            LEFT JOIN asignaturas_bibliografias ab ON a.id = ab.asignatura_id AND ab.bibliografia_id = :bibliografia_id_1
            WHERE a.id NOT IN (
                SELECT asignatura_id 
                FROM asignaturas_bibliografias 
                WHERE bibliografia_id = :bibliografia_id_2
            )
            AND a.estado = 1
            AND a.tipo != 'FORMACION_ELECTIVA'
        ";

        $params = [
            ':bibliografia_id_1' => $bibliografiaId,
            ':bibliografia_id_2' => $bibliografiaId
        ];

        // Aplicar filtros
        if (!empty($filtros['unidad'])) {
            $sql .= " AND u.id = :unidad_id";
            $params[':unidad_id'] = $filtros['unidad'];
        }

        if (!empty($filtros['tipo_asignatura'])) {
            $sql .= " AND a.tipo = :tipo_asignatura";
            $params[':tipo_asignatura'] = $filtros['tipo_asignatura'];
        }

        // Aplicar filtro de búsqueda por nombre o código
        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (a.nombre LIKE :busqueda_nombre OR ad.codigo_asignatura LIKE :busqueda_codigo)";
            $params[':busqueda_nombre'] = '%' . trim($filtros['busqueda']) . '%';
            $params[':busqueda_codigo'] = '%' . trim($filtros['busqueda']) . '%';
        }

        $sql .= " GROUP BY a.id, a.nombre, ab.tipo_bibliografia";
        $sql .= " ORDER BY a.nombre";

        error_log('SQL Query: ' . $sql);
        error_log('SQL Params: ' . print_r($params, true));

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log('Resultado de la consulta: ' . count($result) . ' registros');
        return $result;
    }

    /**
     * Vincula una asignatura a la bibliografía.
     */
    public function vincularSingle(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'] ?? null;
        
        // Asegurar que la respuesta sea JSON
        $response = $response ?? new Response();
        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para continuar',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
            }

            // Verificar si es una petición AJAX
            $headers = $request->getHeaders();
            $isAjax = isset($headers['X-Requested-With'][0]) && 
                      strtolower($headers['X-Requested-With'][0]) === 'xmlhttprequest';
            
            if (!$isAjax) {
                throw new \Exception('Solo se permiten peticiones AJAX');
            }

            // Obtener los datos del cuerpo de la petición
            $data = json_decode($request->getBody()->getContents(), true);
            
            if (!$data) {
                throw new \Exception('No se recibieron datos válidos');
            }

            // Validar los datos requeridos
            if (empty($data['asignatura_id']) || empty($data['tipo_bibliografia'])) {
                throw new \Exception('Faltan datos requeridos');
            }

            // Validar el tipo de bibliografía
            $tiposValidos = ['basica', 'complementaria'];
            if (!in_array($data['tipo_bibliografia'], $tiposValidos)) {
                throw new \Exception('Tipo de bibliografía no válido');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            try {
                // Verificar si ya existe la vinculación
            $stmt = $this->pdo->prepare("
                    SELECT id FROM asignaturas_bibliografias 
                    WHERE asignatura_id = ? AND bibliografia_id = ? AND estado = 'activa'
                ");
                $stmt->execute([$data['asignatura_id'], $id]);
                $vinculacionExistente = $stmt->fetch();

                if ($vinculacionExistente) {
                    throw new \Exception('Esta asignatura ya está vinculada a esta bibliografía');
                }

                // Insertar la nueva vinculación
            $stmt = $this->pdo->prepare("
                INSERT INTO asignaturas_bibliografias 
                    (asignatura_id, bibliografia_id, tipo_bibliografia, estado) 
                    VALUES (?, ?, ?, 'activa')
            ");
            $stmt->execute([
                    $data['asignatura_id'],
                    $id,
                    $data['tipo_bibliografia']
                ]);

                // Confirmar transacción
                $this->pdo->commit();

            return $this->jsonResponse([
                'success' => true,
                    'message' => 'Asignatura vinculada correctamente'
            ]);

        } catch (\Exception $e) {
                // Revertir transacción en caso de error
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                throw $e;
            }

        } catch (\Exception $e) {
            //error_log('Error en vincularSingle: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al vincular la asignatura: ' . $e->getMessage()
            ]);
        }
    }

    private function jsonResponse($data): Response
    {
        try {
            //error_log('=== INICIO JSON RESPONSE ===');
            //error_log('Datos a enviar: ' . print_r($data, true));
        
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Asegurar que no haya salida antes de los headers
        if (headers_sent($file, $line)) {
            //error_log("Headers ya enviados en $file:$line");
                throw new \Exception("Headers ya enviados en $file:$line");
        }
        
        // Establecer headers
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
        
        // Asegurar que los datos sean un array
        if (!is_array($data)) {
            $data = ['success' => false, 'message' => 'Error interno: datos inválidos'];
        }
        
        // Convertir a JSON
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        if ($json === false) {
                //error_log('Error al codificar JSON: ' . json_last_error_msg());
                throw new \Exception('Error al codificar JSON: ' . json_last_error_msg());
            }
            
            //error_log('JSON a enviar: ' . $json);
            //error_log('=== FIN JSON RESPONSE ===');
            
            // Enviar la respuesta
            echo $json;
            exit;
            
        } catch (\Exception $e) {
            //error_log('Error en jsonResponse: ' . $e->getMessage());
            //error_log('Stack trace: ' . $e->getTraceAsString());
            
            $errorResponse = [
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ];
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($errorResponse);
            exit;
        }
    }

    /**
     * Desvincula una asignatura de la bibliografía.
     */
    public function desvincularSingle($id = null, $vinculacionId = null, Request $request = null, Response $response = null): Response
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Por favor inicie sesión para continuar',
                'redirect' => Config::get('app_url') . 'login'
            ]);
            exit;
        }

        try {
            $this->pdo->beginTransaction();

            // Eliminar la vinculación
            $stmt = $this->pdo->prepare("
                DELETE FROM bibliografias_asignaturas 
                WHERE id = ? AND bibliografia_id = ?
            ");
            $stmt->execute([$vinculacionId, $id]);

            $this->pdo->commit();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Asignatura desvinculada exitosamente'
            ]);
            exit;

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al desvincular la asignatura: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Vincula múltiples asignaturas a la bibliografía.
     */
    public function vincularMultiple(Request $request, Response $response, array $args)
    {
        //error_log('Iniciando vincularMultiple');
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                //error_log('Usuario no autenticado');
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para continuar',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
            }

            // Verificar si es una petición AJAX
            $headers = $request->getHeaders();
            $isAjax = isset($headers['X-Requested-With'][0]) && 
                      strtolower($headers['X-Requested-With'][0]) === 'xmlhttprequest';
            
            if (!$isAjax) {
                //error_log('No es una petición AJAX');
                throw new \Exception('Solo se permiten peticiones AJAX');
            }

            // Obtener el ID de la bibliografía de los argumentos
            $bibliografiaId = $args['id'] ?? null;
            if (!$bibliografiaId) {
                //error_log('ID de bibliografía no proporcionado');
                throw new \Exception('ID de bibliografía no proporcionado');
            }

            // Obtener y validar los datos JSON
            $jsonData = $request->getBody()->getContents();
            //error_log("Datos recibidos en vincularMultiple: " . $jsonData);
            
            if (empty($jsonData)) {
                //error_log('No se recibieron datos');
                throw new \Exception('No se recibieron datos');
            }

            $data = json_decode($jsonData, true);
            //error_log("Datos validados correctamente: " . print_r($data, true));
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                //error_log('Error al decodificar JSON: ' . json_last_error_msg());
                throw new \Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            if (!isset($data['asignaturas']) || !is_array($data['asignaturas'])) {
                //error_log('Formato de datos inválido');
                throw new \Exception('Formato de datos inválido');
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            $vinculacionesExitosas = 0;
            $errores = [];

            foreach ($data['asignaturas'] as $asignatura) {
                if (!isset($asignatura['asignatura_id']) || !isset($asignatura['tipo_bibliografia'])) {
                    $errores[] = "Datos incompletos para una asignatura";
                        continue;
                    }

                try {
                    // Verificar si ya existe la vinculación
                    $stmt = $this->pdo->prepare("
                        SELECT id FROM asignaturas_bibliografias 
                        WHERE bibliografia_id = :bibliografia_id 
                        AND asignatura_id = :asignatura_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':asignatura_id' => $asignatura['asignatura_id']
                    ]);

                    if ($stmt->fetch()) {
                        $errores[] = "La asignatura ya está vinculada";
                        continue;
                    }

                    // Insertar la nueva vinculación
                    $stmt = $this->pdo->prepare("
                        INSERT INTO asignaturas_bibliografias 
                        (bibliografia_id, asignatura_id, tipo_bibliografia) 
                        VALUES (:bibliografia_id, :asignatura_id, :tipo_bibliografia)
                    ");
                    
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':asignatura_id' => $asignatura['asignatura_id'],
                        ':tipo_bibliografia' => $asignatura['tipo_bibliografia']
                    ]);

                    $vinculacionesExitosas++;
                } catch (\PDOException $e) {
                    //error_log('Error PDO al vincular asignatura: ' . $e->getMessage());
                    $errores[] = "Error al vincular asignatura: " . $e->getMessage();
                }
            }

            //error_log("Vinculaciones exitosas: " . $vinculacionesExitosas);

            if ($vinculacionesExitosas > 0) {
                $this->pdo->commit();
                //error_log('Transacción completada exitosamente');
                $responseData = [
                    'success' => true,
                    'message' => "Se vincularon {$vinculacionesExitosas} asignaturas correctamente",
                    'redirect' => Config::get('app_url') . "bibliografias-declaradas/{$bibliografiaId}/vincular"
                ];
                //error_log('Enviando respuesta de éxito: ' . json_encode($responseData));
                header('Content-Type: application/json');
                echo json_encode($responseData);
                exit;
            } else {
                $this->pdo->rollBack();
                //error_log('No se pudo vincular ninguna asignatura');
                $responseData = [
                    'success' => false,
                    'message' => "No se pudo vincular ninguna asignatura. Errores: " . implode(", ", $errores)
                ];
                //error_log('Enviando respuesta de error: ' . json_encode($responseData));
                header('Content-Type: application/json');
                echo json_encode($responseData);
                exit;
            }

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            //error_log("Error en vincularMultiple: " . $e->getMessage());
            //error_log("Stack trace: " . $e->getTraceAsString());
            $responseData = [
                'success' => false,
                'message' => 'Error al vincular las asignaturas: ' . $e->getMessage()
            ];
            //error_log('Enviando respuesta de excepción: ' . json_encode($responseData));
            header('Content-Type: application/json');
            echo json_encode($responseData);
        exit;
        }
    }

    /**
     * Desvincula múltiples asignaturas de la bibliografía.
     */
    public function desvincularMultiple(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'] ?? null;
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Por favor inicie sesión para continuar',
                'redirect' => Config::get('app_url') . 'login'
            ]);
        }

        try {
            // Verificar si es una petición AJAX
            $headers = $request->getHeaders();
            $isAjax = isset($headers['X-Requested-With'][0]) && 
                      strtolower($headers['X-Requested-With'][0]) === 'xmlhttprequest';
            
            if (!$isAjax) {
                throw new \Exception('Solo se permiten peticiones AJAX');
            }

            $data = json_decode($request->getBody()->getContents(), true);
            
            if (!isset($data['vinculaciones']) || !is_array($data['vinculaciones'])) {
                throw new \Exception('Faltan datos requeridos');
            }

            $this->pdo->beginTransaction();

            // Eliminar las vinculaciones
            $stmt = $this->pdo->prepare("
                DELETE FROM asignaturas_bibliografias 
                WHERE id IN (" . implode(',', array_fill(0, count($data['vinculaciones']), '?')) . ")
                AND bibliografia_id = ?
            ");

            $params = $data['vinculaciones'];
            $params[] = $id;
            $stmt->execute($params);

            $this->pdo->commit();

            return $this->jsonResponse([
                'success' => true,
                'message' => 'Asignaturas desvinculadas exitosamente'
            ]);

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            //error_log('Error en desvincularMultiple: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al desvincular las asignaturas: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtiene los detalles completos de una bibliografía declarada.
     */
    private function obtenerBibliografiaCompleta($id)
    {
        // Obtener la bibliografía base
        $stmt = $this->pdo->prepare("
            SELECT * FROM bibliografias_declaradas WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
        $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bibliografia) {
            return null;
        }

        // Obtener datos específicos según el tipo
        switch ($bibliografia['tipo']) {
            case 'libro':
                $stmt = $this->pdo->prepare("
                    SELECT isbn 
                    FROM libros 
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;

            case 'articulo':
                $stmt = $this->pdo->prepare("
                    SELECT issn, titulo_revista, cronologia 
                    FROM articulos 
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;

            case 'tesis':
                $stmt = $this->pdo->prepare("
                    SELECT nombre_carrera
                    FROM tesis
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;

            case 'sitio_web':
                $stmt = $this->pdo->prepare("
                    SELECT fecha_consulta 
                    FROM sitios_web 
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;

            case 'software':
                $stmt = $this->pdo->prepare("
                    SELECT version 
                    FROM software 
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;

            case 'generico':
                $stmt = $this->pdo->prepare("
                    SELECT descripcion 
                    FROM genericos 
                    WHERE bibliografia_id = :id
                ");
                $stmt->execute([':id' => $id]);
                $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($datosEspecificos) {
                    $bibliografia = array_merge($bibliografia, $datosEspecificos);
                }
                break;
        }

        // Obtener los autores de la bibliografía
        $stmt = $this->pdo->prepare("
            SELECT 
                a.id,
                a.apellidos,
                a.nombres,
                a.genero
            FROM autores a
            JOIN bibliografias_autores ba ON a.id = ba.autor_id
            WHERE ba.bibliografia_id = :bibliografia_id
            ORDER BY a.apellidos, a.nombres
        ");
        $stmt->execute([':bibliografia_id' => $id]);
        $bibliografia['autores'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $bibliografia;
    }

    protected function render(Response $response = null, string $template, array $data = []): Response
    {
        try {
            //error_log('Renderizando plantilla: ' . $template);
            ////error_log('Datos pasados a la plantilla: ' . print_r($data, true));
            
            // Crear una nueva respuesta si no se proporciona una
            if (!$response) {
                $response = new Response();
            }
            
        // Agregar variables globales a la plantilla
        $data['app_url'] = Config::get('app_url');
        $data['session'] = $_SESSION;
        $data['current_page'] = 'bibliografias-declaradas';
            
            // Asegurar que todos los datos estén en UTF-8
            $data = $this->sanitizeDataForLog($data);
        
        // Renderizar la plantilla
        $content = $this->twig->render($template, $data);
            //error_log('Plantilla renderizada correctamente');
        
        // Establecer el contenido en la respuesta
        header('Content-Type: text/html; charset=utf-8');
        echo $content;
        
        return $response;
        } catch (\Exception $e) {
            //error_log('Error al renderizar la plantilla: ' . $e->getMessage());
            //error_log('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Sanitiza los datos para el log, evitando información sensible
     */
    private function sanitizeDataForLog(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeDataForLog($value);
            } else {
                // Evitar mostrar información sensible en logs
                if (in_array(strtolower($key), ['password', 'token', 'secret', 'key'])) {
                    $sanitized[$key] = '***HIDDEN***';
                } else {
                    $sanitized[$key] = $value;
                }
            }
        }
        return $sanitized;
    }

    /**
     * Obtiene la lista de editoriales disponibles.
     */
    private function getEditoriales(): array
    {
        try {
            $stmt = $this->pdo->query("
                SELECT DISTINCT editorial 
                FROM bibliografias_declaradas 
                WHERE editorial IS NOT NULL AND editorial != ''
                ORDER BY editorial
            ");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (\Exception $e) {
            //error_log('Error al obtener editoriales: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene la lista de revistas disponibles.
     */
    private function getRevistas(): array
    {
        try {
            $stmt = $this->pdo->query("
                SELECT DISTINCT titulo_revista 
                FROM articulos 
                WHERE titulo_revista IS NOT NULL AND titulo_revista != ''
                ORDER BY titulo_revista
            ");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (\Exception $e) {
            //error_log('Error al obtener revistas: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene la lista de autores disponibles.
     */
    private function getAutores(): array
    {
        try {
            $stmt = $this->pdo->query("
                SELECT id, apellidos, nombres, genero
                FROM autores
                ORDER BY apellidos, nombres
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            //error_log('Error al obtener autores: ' . $e->getMessage());
            return [];
        }
    }


    public function buscarCatalogo(Request $request, Response $response, array $args): Response
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $_SESSION['error'] = 'Por favor inicie sesión para acceder a las bibliografías';
                header('Location: ' . Config::get('app_url') . 'login');
        exit;
            }

            // Obtener la bibliografía base con sus autores
            $stmt = $this->pdo->prepare("
                SELECT b.*, 
                       GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores
                FROM bibliografias_declaradas b
                LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
                LEFT JOIN autores a ON ba.autor_id = a.id
                WHERE b.id = ?
                GROUP BY b.id
            ");
            $stmt->execute([$args['id']]);
            $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$bibliografia) {
                throw new \Exception('Bibliografía no encontrada');
            }

            // Obtener datos específicos según el tipo
            switch ($bibliografia['tipo']) {
                case 'libro':
                    $stmt = $this->pdo->prepare("SELECT isbn FROM libros WHERE bibliografia_id = ?");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;

                case 'articulo':
                    $stmt = $this->pdo->prepare("SELECT issn, titulo_revista, cronologia FROM articulos WHERE bibliografia_id = ?");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;

                case 'tesis':
                    $stmt = $this->pdo->prepare("
                        SELECT nombre_carrera
                        FROM tesis
                        WHERE bibliografia_id = ?
                    ");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;

                case 'sitio_web':
                    $stmt = $this->pdo->prepare("SELECT fecha_consulta FROM sitios_web WHERE bibliografia_id = ?");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;

                case 'software':
                    $stmt = $this->pdo->prepare("SELECT version FROM software WHERE bibliografia_id = ?");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;

                case 'generico':
                    $stmt = $this->pdo->prepare("SELECT descripcion FROM genericos WHERE bibliografia_id = ?");
                    $stmt->execute([$args['id']]);
                    $datosEspecificos = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($datosEspecificos) {
                        $bibliografia = array_merge($bibliografia, $datosEspecificos);
                    }
                    break;
            }

            //error_log('Datos de la bibliografía: ' . print_r($bibliografia, true));

            // Renderizar la vista
            return $this->render($response, 'bibliografias_declaradas/buscar_catalogo.twig', [
                'bibliografia' => $bibliografia,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-declaradas'
            ]);

        } catch (\Exception $e) {
            //error_log('Error en buscarCatalogo: ' . $e->getMessage());
            //error_log('Stack trace: ' . $e->getTraceAsString());
            
            $_SESSION['error'] = 'Error al cargar la página: ' . $e->getMessage();
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }
    }

    public function vincularCatalogo(Request $request, Response $response, array $args): Response
    {
        try {
            $data = json_decode($request->getBody()->getContents(), true);
            $bibliografiaDisponibleId = $data['bibliografia_id'] ?? null;

            if (!$bibliografiaDisponibleId) {
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
                    ->write(json_encode(['success' => false, 'message' => 'ID de bibliografía no proporcionado']));
            }

            // Obtener la bibliografía declarada
            $stmt = $this->pdo->prepare("SELECT * FROM bibliografias_declaradas WHERE id = ?");
            $stmt->execute([$args['id']]);
            $bibliografiaDeclarada = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$bibliografiaDeclarada) {
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
                    ->write(json_encode(['success' => false, 'message' => 'Bibliografía declarada no encontrada']));
            }

            // Obtener la bibliografía disponible
            $stmt = $this->pdo->prepare("SELECT * FROM bibliografias_disponibles WHERE id = ?");
            $stmt->execute([$bibliografiaDisponibleId]);
            $bibliografiaDisponible = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$bibliografiaDisponible) {
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
                    ->write(json_encode(['success' => false, 'message' => 'Bibliografía disponible no encontrada']));
            }

            // Iniciar transacción
            $this->pdo->beginTransaction();

            try {
                // Actualizar la bibliografía declarada con la URL del catálogo
                $stmt = $this->pdo->prepare("
                    UPDATE bibliografias_declaradas 
                    SET url_catalogo = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$bibliografiaDisponible['url_catalogo'], $args['id']]);

                // Crear la vinculación
                $stmt = $this->pdo->prepare("
                    INSERT INTO bibliografias_declaradas_disponibles 
                    (bibliografia_declarada_id, bibliografia_disponible_id) 
                    VALUES (?, ?)
                ");
                $stmt->execute([$args['id'], $bibliografiaDisponibleId]);

                $this->pdo->commit();

                return $response->withHeader('Content-Type', 'application/json')
                    ->write(json_encode([
                        'success' => true, 
                        'message' => 'Bibliografía vinculada exitosamente'
                    ]));
            } catch (\Exception $e) {
                $this->pdo->rollBack();
            throw $e;
            }
        } catch (\Exception $e) {
            //error_log('Error en vincularCatalogo: ' . $e->getMessage());
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['success' => false, 'message' => 'Error al vincular la bibliografía']));
        }
    }

    // Método para la API de búsqueda en el catálogo
    private function procesarCampoBusqueda(string $campo): string
    {
        // Eliminar puntuaciones
        // Convertir caracteres acentuados a sus equivalentes sin acento
        $unwanted_array = array(
            'á'=>'a', 'à'=>'a', 'ã'=>'a', 'â'=>'a', 'ä'=>'a',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e',
            'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i',
            'ó'=>'o', 'ò'=>'o', 'õ'=>'o', 'ô'=>'o', 'ö'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u',
            'ý'=>'y', 'ÿ'=>'y',
            'ñ'=>'n',
            'Á'=>'A', 'À'=>'A', 'Ã'=>'A', 'Â'=>'A', 'Ä'=>'A',
            'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E',
            'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I',
            'Ó'=>'O', 'Ò'=>'O', 'Õ'=>'O', 'Ô'=>'O', 'Ö'=>'O',
            'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U',
            'Ý'=>'Y',
            'Ñ'=>'N'
        );
        $campo = strtr($campo, $unwanted_array);
        $campo = str_replace([',', ';', '"', "'", '.', ':', ';', '¿', '?'], '', $campo);
        // Reemplazar espacios por +
        return str_replace(' ', '+', trim($campo));
    }

    private function obtenerRegistrosGrupoFRBR(string $titulo, string $frbrGroupId): array
    {
        $url = "https://api-na.hosted.exlibrisgroup.com/primo/v1/search?" .
               'vid=' . ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
               '&tab=ALL' .
               '&inst=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
               '&scope=MyInst_and_CI' .
               '&q=title,exact,' . urlencode($titulo) .
               '&qInclude=facet_frbrgroupid,exact,' . $frbrGroupId .
               '&mode=advanced' .
               '&offset=0' .
               '&limit=50' .
               '&sort=rank' .
               '&pcAvailability=false' .
               '&skipDelivery=true' .
               '&disableSplitFacets=false' .
               '&lang=es' .
               '&apikey=' . ($_ENV['PRIMO_API_KEY'] ?? '');

        //error_log('URL de búsqueda FRBR: ' . $url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            //error_log('Error en la petición cURL FRBR: ' . curl_error($ch));
            curl_close($ch);
            return [];
        }
        
        curl_close($ch);

        if ($httpCode !== 200) {
            //error_log('Error al consultar el catálogo FRBR: ' . $httpCode);
            return [];
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            //error_log('Error al decodificar la respuesta del catálogo FRBR: ' . json_last_error_msg());
            return [];
        }

        return $data['docs'] ?? [];
    }

    public function apiBuscarCatalogo(Request $request, Response $response, array $args): Response
    {
        try {
            // Obtener los datos del cuerpo de la petición
            $rawData = $request->getBody()->getContents();
            //error_log('Datos raw recibidos: ' . $rawData);
            
            $data = json_decode($rawData, true);
            //error_log('Datos decodificados: ' . json_encode($data, JSON_UNESCAPED_UNICODE));

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al decodificar los datos JSON: ' . json_last_error_msg()
                ])->withStatus(400);
            }

            // Procesar y limpiar los campos de búsqueda
            $titulo = $this->procesarCampoBusqueda($data['titulo'] ?? '');
            $autor = $this->procesarCampoBusqueda($data['autor'] ?? '');
            $busquedaAdicional = $this->procesarCampoBusqueda($data['busqueda_adicional'] ?? '');
            $tipoRecurso = $data['tipo_recurso'] ?? '';

            // Validar que al menos uno de los campos tenga contenido
            if (empty($titulo) && empty($autor)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Debe ingresar al menos un título o un autor para realizar la búsqueda'
                ])->withStatus(400);
            }

            // Construir la consulta
            $query = '';

            if (!empty($titulo)) {
                $query .= "title,exact," . $titulo;
            }

            if (!empty($autor)) {
                if (!empty($query)) {
                    $query .= ",AND;";
                }
                $query .= "creator,contains," . $autor;
            }

            if (!empty($busquedaAdicional)) {
                if (!empty($query)) {
                    $query .= ",AND;";
                }
                $query .= "any,contains," . $busquedaAdicional;
            }

            if (!empty($tipoRecurso)) {
                $query .= "&qInclude=facet_rtype,exact," . $tipoRecurso;
            }

            //error_log('Query construida: ' . $query);
            
            // Construir la URL
            $url = "https://api-na.hosted.exlibrisgroup.com/primo/v1/search?" .
                   'vid=' . ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                   '&tab=ALL' .
                   '&inst=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                   '&scope=MyInst_and_CI' .
                   '&q=' . $query .
                   '&mode=advanced' .
                   '&offset=0' .
                   '&limit=50' .
                   '&sort=rank' .
                   '&pcAvailability=false' .
                   '&skipDelivery=true' .
                   '&disableSplitFacets=false' .
                   '&lang=es' .
                   '&apikey=' . ($_ENV['PRIMO_API_KEY'] ?? '');

            //error_log('URL de búsqueda: ' . $url);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/json'
            ]);
            $catalogoResponse = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new \Exception('Error en la petición cURL: ' . curl_error($ch));
            }
            
            curl_close($ch);

            //error_log('Código de respuesta HTTP: ' . $httpCode);
            //error_log('Respuesta del catálogo (primeros 1000 caracteres): ' . substr($catalogoResponse, 0, 1000));

            if ($httpCode !== 200) {
                throw new \Exception('Error al consultar el catálogo: ' . $httpCode);
            }

            $data = json_decode($catalogoResponse, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al decodificar la respuesta del catálogo: ' . json_last_error_msg());
            }
            
            if (!isset($data['docs']) || !is_array($data['docs'])) {
                //error_log('Estructura de respuesta inesperada: ' . json_encode($data));
                throw new \Exception('La respuesta del catálogo no contiene documentos válidos');
            }
            
            $results = [];
            foreach ($data['docs'] as $doc) {
                try {
                    $context = $doc['context'] ?? '';
                    $adaptor = $doc['adaptor'] ?? '';
                    $autores = [];
                    
                    if ($context === 'L' && $adaptor === 'Local Search Engine') {
                        // Verificar si es parte de un grupo FRBR
                        $frbrType = $doc['pnx']['facets']['frbrtype'][0] ?? '';
                        $frbrGroupId = $doc['pnx']['facets']['frbrgroupid'][0] ?? '';
                        
                        if ($frbrType === '5' && !empty($frbrGroupId)) {
                            // Es parte de un grupo FRBR, obtener todos los registros del grupo
                            $titulo = $doc['pnx']['display']['title'][0] ?? '';
                            $registrosGrupo = $this->obtenerRegistrosGrupoFRBR($titulo, $frbrGroupId);
                            
                            foreach ($registrosGrupo as $registroGrupo) {
                                // Procesar cada registro del grupo
                                if (isset($registroGrupo['pnx']['addata']['addau']) && is_array($registroGrupo['pnx']['addata']['addau'])) {
                                    foreach ($registroGrupo['pnx']['addata']['addau'] as $autor) {
                                        if (!empty($autor)) {
                                            $autores[] = trim($autor);
                                        }
                                    }
                                }
                                
                                if (isset($registroGrupo['pnx']['addata']['au']) && is_array($registroGrupo['pnx']['addata']['au'])) {
                                    foreach ($registroGrupo['pnx']['addata']['au'] as $autor) {
                                        if (!empty($autor)) {
                                            $autores[] = trim($autor);
                                        }
                                    }
                                }
                                
                                $recordId = $registroGrupo['pnx']['control']['recordid'][0] ?? '';
                                $catalogoUrl = "https://ucn.primo.exlibrisgroup.com/discovery/fulldisplay?".
                                               "vid=". ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                               "&tab=ALL&search_scope=MyInst_and_CI&lang=es&context=L&adaptor=Local+Search+Engine&docid=" . $recordId;
                                
                                $result = [
                                    'catalogo_id' => $recordId,
                                    'sourcerecordid' => $registroGrupo['pnx']['control']['sourcerecordid'][0] ?? '',
                                    'titulo' => $registroGrupo['pnx']['display']['title'][0] ?? 'Sin título',
                                    'autores' => implode('; ', array_unique($autores)),
                                    'anio' => $registroGrupo['pnx']['display']['creationdate'][0] ?? $registroGrupo['pnx']['addata']['risdate'][0] ?? '',
                                    'editorial' => $registroGrupo['pnx']['addata']['pub'][0] ?? $registroGrupo['pnx']['display']['publisher'][0] ?? '',
                                    'url' => $catalogoUrl,
                                    'context' => $context,
                                    'adaptor' => $adaptor,
                                    'formato' => $registroGrupo['pnx']['display']['type'][0] ?? ''
                                ];
                                
                                //error_log('Documento FRBR procesado: ' . json_encode($result));
                                $results[] = $result;
                            }
                            continue; // Saltar al siguiente documento principal
                        }
                        
                        // Procesamiento normal para registros locales no FRBR
                        if (isset($doc['pnx']['addata']['addau']) && is_array($doc['pnx']['addata']['addau'])) {
                            foreach ($doc['pnx']['addata']['addau'] as $autor) {
                                if (!empty($autor)) {
                                    $autores[] = trim($autor);
                                }
                            }
                        }
                        
                        if (isset($doc['pnx']['addata']['au']) && is_array($doc['pnx']['addata']['au'])) {
                            foreach ($doc['pnx']['addata']['au'] as $autor) {
                                if (!empty($autor)) {
                                    $autores[] = trim($autor);
                                }
                            }
                        }
                    } elseif ($context === 'PC' && $adaptor === 'Primo Central') {
                        // ... existing code for Primo Central ...
                    }
                    
                    // Construir la URL según el origen del registro
                    $recordId = $doc['pnx']['control']['recordid'][0] ?? '';
                    $sourceRecordId = $doc['pnx']['control']['sourcerecordid'][0] ?? '';
                    $catalogoUrl = '';
                    
                    if ($context === 'L' && $adaptor === 'Local Search Engine') {
                        $catalogoUrl = "https://ucn.primo.exlibrisgroup.com/discovery/fulldisplay?".
                                       "vid=" . ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                       "&tab=ALL&search_scope=MyInst_and_CI&lang=es&context=L&adaptor=Local+Search+Engine&docid=" . $recordId;
                    } else {
                        $catalogoUrl = "https://ucn.primo.exlibrisgroup.com/discovery/fulldisplay?&context=PC&".
                                       "vid=". ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                       "&search_scope=MyInst_and_CI&tab=ALL&lang=es&adaptor=Primo+Central&docid=" . $recordId;
                    }
                    
                    $result = [
                        'catalogo_id' => $recordId,
                        'sourcerecordid' => $sourceRecordId,
                        'titulo' => $doc['pnx']['display']['title'][0] ?? 'Sin título',
                        'autores' => implode('; ', array_unique($autores)),
                        'anio' => $doc['pnx']['display']['creationdate'][0] ?? $doc['pnx']['addata']['risdate'][0] ?? '',
                        'editorial' => $doc['pnx']['display']['publisher'][0] ?? '',
                        'url' => $catalogoUrl,
                        'context' => $context,
                        'adaptor' => $adaptor,
                        'formato' => $doc['pnx']['display']['type'][0] ?? ''
                    ];
                    
                    //error_log('Documento procesado: ' . json_encode($result));
                    $results[] = $result;
                    
                } catch (\Exception $e) {
                    //error_log('Error procesando documento: ' . $e->getMessage());
                    continue;
                }
            }
            
            // Si no se encontraron resultados en el catálogo, devolver mensaje para mostrar botón de Google
            if (empty($results)) {
                return $this->jsonResponse([
                    'success' => true,
                    'results' => [],
                    'source' => 'catalogo',
                    'message' => 'No se encontraron resultados en el catálogo'
                ]);
            }
            
                        return $this->jsonResponse([
                'success' => true,
                'results' => $results,
                'source' => 'catalogo'
            ]);
        } catch (\Exception $e) {
            //error_log('Error en apiBuscarCatalogo: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al buscar en el catálogo: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function apiBuscarGoogle(Request $request, Response $response, array $args): Response
    {
        try {
            // Obtener los datos del cuerpo de la petición
            $rawData = $request->getBody()->getContents();
            $data = json_decode($rawData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al decodificar los datos JSON: ' . json_last_error_msg()
                ])->withStatus(400);
            }

            // Procesar y limpiar los campos de búsqueda
            $titulo = $this->procesarCampoBusqueda($data['titulo'] ?? '');
            $autor = $this->procesarCampoBusqueda($data['autor'] ?? '');
            $busquedaAdicional = $this->procesarCampoBusqueda($data['busqueda_adicional'] ?? '');
            $fuente = $data['fuente'] ?? '';

            // Validar que al menos uno de los campos tenga contenido
            if (empty($titulo) && empty($autor)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Debe ingresar al menos un título o un autor para realizar la búsqueda'
                ])->withStatus(400);
            }

            $googleResults = [];
            $source = '';
            $message = '';

            // Seguir la lógica: 1. Google Scholar, 2. Google Books, 3. Google tradicional
            if ($fuente === 'scholar' || $fuente === '') {
                // 1. Buscar en Google Scholar
                $googleResults = $this->buscarEnGoogleScholar($titulo, $autor, $busquedaAdicional);
                if (!empty($googleResults)) {
                    $source = 'google_scholar';
                    $message = 'Resultados obtenidos de Google Scholar';
                }
            }

            if (empty($googleResults) && ($fuente === 'books' || $fuente === '')) {
                // 2. Si no hay resultados en Scholar, buscar en Google Books
                $googleResults = $this->buscarEnGoogleBooks($titulo, $autor, $busquedaAdicional);
                if (!empty($googleResults)) {
                    $source = 'google_books';
                    $message = 'Resultados obtenidos de Google Books';
                }
            }

            if (empty($googleResults) && $fuente === '') {
                // 3. Si no hay resultados en Books, buscar en Google tradicional
                $googleResults = $this->buscarEnGoogleTradicional($titulo, $autor, $busquedaAdicional);
                if (!empty($googleResults)) {
                    $source = 'google_tradicional';
                    $message = 'Resultados obtenidos de Google';
                }
            }

            if (!empty($googleResults)) {
                return $this->jsonResponse([
                    'success' => true,
                    'results' => $googleResults,
                    'source' => $source,
                    'message' => $message
                ]);
            } else {
                return $this->jsonResponse([
                    'success' => true,
                    'results' => [],
                    'source' => 'google',
                    'message' => 'No se encontraron resultados en Google'
                ]);
            }
            

        } catch (\Exception $e) {
            //error_log('Error en apiBuscarCatalogo: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al buscar en el catálogo: ' . $e->getMessage()
            ])->withStatus(500);
        }
    }

    private function procesarAutorPrimo($autorString) {
        // Extraer apellidos y nombres usando expresiones regulares
        if (preg_match('/\$\$L([^\$]+)\$\$F([^\$]+)/', $autorString, $matches)) {
            $apellidos = trim($matches[1]);
            $nombres = trim($matches[2]);
            return $apellidos . ', ' . $nombres;
        }
        return null;
    }

    private function buscarEnGoogle($titulo, $autor, $busquedaAdicional) {
        try {
            // Construir la consulta de búsqueda para Google
            $query = '';
            $searchTerms = [];
            
            if (!empty($titulo)) {
                $searchTerms[] = '"' . $titulo . '"';
            }
            
            if (!empty($autor)) {
                $searchTerms[] = $autor;
            }
            
            if (!empty($busquedaAdicional)) {
                $searchTerms[] = $busquedaAdicional;
            }
            
            if (empty($searchTerms)) {
                return [];
            }
            
            $query = implode(' ', $searchTerms);
            
            // Primero intentar con Google Scholar
            $googleScholarResults = $this->buscarEnGoogleWeb($query);
            if (!empty($googleScholarResults)) {
                return $googleScholarResults;
            }
            
            // Si no hay resultados en Google Scholar, intentar con Google Books API
            $googleBooksResults = $this->buscarEnGoogleBooks($titulo, $autor, $busquedaAdicional);
            if (!empty($googleBooksResults)) {
                return $googleBooksResults;
            }
            
            return [];
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogle: ' . $e->getMessage());
            return [];
        }
    }
    
    private function buscarEnGoogleScholar($titulo, $autor, $busquedaAdicional) {
        try {
            // Construir la consulta de búsqueda para Google Scholar
            $query = '';
            $searchTerms = [];
            
            if (!empty($titulo)) {
                $searchTerms[] = '"' . $titulo . '"';
            }
            
            if (!empty($autor)) {
                $searchTerms[] = $autor;
            }
            
            if (!empty($busquedaAdicional)) {
                $searchTerms[] = $busquedaAdicional;
            }
            
            if (empty($searchTerms)) {
                return [];
            }
            
            $query = implode(' ', $searchTerms);
            
            // Búsqueda directa en Google Scholar
            return $this->buscarEnGoogleWeb($query);
            
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogleScholar: ' . $e->getMessage());
            return [];
        }
    }
    
    private function buscarEnGoogleBooks($titulo, $autor, $busquedaAdicional) {
        try {
            // Construir la consulta de búsqueda para Google Books
            $query = '';
            $searchTerms = [];
            
            if (!empty($titulo)) {
                $searchTerms[] = '"' . $titulo . '"';
            }
            
            if (!empty($autor)) {
                $searchTerms[] = $autor;
            }
            
            if (!empty($busquedaAdicional)) {
                $searchTerms[] = $busquedaAdicional;
            }
            
            if (empty($searchTerms)) {
                return [];
            }
            
            $query = implode(' ', $searchTerms);
            
            // Usar Google Books API (gratuita y más confiable)
            $url = "https://www.googleapis.com/books/v1/volumes?" .
                   "q=" . urlencode($query) .
                   "&langRestrict=es" .
                   "&maxResults=10" .
                   "&printType=books";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json'
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new \Exception('Error en la petición cURL a Google Books: ' . curl_error($ch));
            }
            
            curl_close($ch);
            
            if ($httpCode !== 200) {
                throw new \Exception('Error al consultar Google Books API: ' . $httpCode);
            }
            
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al decodificar la respuesta de Google Books: ' . json_last_error_msg());
            }
            
            $results = [];
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $volumeInfo = $item['volumeInfo'] ?? [];
                    $authors = isset($volumeInfo['authors']) ? implode('; ', $volumeInfo['authors']) : '';
                    $publishedDate = $volumeInfo['publishedDate'] ?? '';
                    $publisher = $volumeInfo['publisher'] ?? '';
                    $description = $volumeInfo['description'] ?? '';
                    $previewLink = $volumeInfo['previewLink'] ?? '';
                    
                    $results[] = [
                        'catalogo_id' => 'google_books_' . md5($item['id'] ?? ''),
                        'sourcerecordid' => '',
                        'titulo' => $volumeInfo['title'] ?? 'Sin título',
                        'autores' => $authors,
                        'anio' => $this->extraerAnioDeTexto($publishedDate),
                        'editorial' => $publisher,
                        'url' => $previewLink,
                        'context' => 'PC',
                        'adaptor' => 'Google Books',
                        'formato' => 'Libro',
                        'snippet' => $description
                    ];
                }
            }
            
            return $results;
            
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogleBooks: ' . $e->getMessage());
            return [];
        }
    }
    
    private function buscarEnGoogleTradicional($titulo, $autor, $busquedaAdicional) {
        try {
            // Construir la consulta de búsqueda para Google tradicional
            $query = '';
            $searchTerms = [];
            
            if (!empty($titulo)) {
                $searchTerms[] = '"' . $titulo . '"';
            }
            
            if (!empty($autor)) {
                $searchTerms[] = $autor;
            }
            
            if (!empty($busquedaAdicional)) {
                $searchTerms[] = $busquedaAdicional;
            }
            
            if (empty($searchTerms)) {
                return [];
            }
            
            $query = implode(' ', $searchTerms);
            
            // Usar Google Custom Search API si está configurada
            $apiKey = $_ENV['GOOGLE_API_KEY'] ?? '';
            $searchEngineId = $_ENV['GOOGLE_SEARCH_ENGINE_ID'] ?? '';
            
            if (!empty($apiKey) && !empty($searchEngineId)) {
                $url = "https://www.googleapis.com/customsearch/v1?" .
                       "key=" . urlencode($apiKey) .
                       "&cx=" . urlencode($searchEngineId) .
                       "&q=" . urlencode($query) .
                       "&num=10" .
                       "&lr=lang_es";
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/json'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                if (curl_errno($ch)) {
                    throw new \Exception('Error en la petición cURL a Google: ' . curl_error($ch));
                }
                
                curl_close($ch);
                
                if ($httpCode !== 200) {
                    throw new \Exception('Error al consultar Google API: ' . $httpCode);
                }
                
                $data = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Error al decodificar la respuesta de Google: ' . json_last_error_msg());
                }
                
                $results = [];
                if (isset($data['items']) && is_array($data['items'])) {
                    foreach ($data['items'] as $item) {
                        $results[] = [
                            'catalogo_id' => 'google_' . md5($item['link'] ?? ''),
                            'sourcerecordid' => '',
                            'titulo' => $item['title'] ?? 'Sin título',
                            'autores' => $this->extraerAutoresDeGoogle($item['snippet'] ?? ''),
                            'anio' => $this->extraerAnioDeGoogle($item['snippet'] ?? ''),
                            'editorial' => '',
                            'url' => $item['link'] ?? '',
                            'context' => 'PC',
                            'adaptor' => 'Google Search',
                            'formato' => 'Web',
                            'snippet' => $item['snippet'] ?? ''
                        ];
                    }
                }
                
                return $results;
            }
            
            return [];
            
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogleTradicional: ' . $e->getMessage());
            return [];
        }
    }
    
    private function buscarEnGoogleWeb($query) {
        try {
            // Intentar primero con Google Custom Search Engine configurado para Scholar
            $apiKey = $_ENV['GOOGLE_API_KEY'] ?? '';
            $searchEngineId = $_ENV['GOOGLE_SEARCH_ENGINE_ID'] ?? '';
            
            if (!empty($apiKey) && !empty($searchEngineId)) {
                // Usar Custom Search Engine que incluya Google Scholar
                $url = "https://www.googleapis.com/customsearch/v1?" .
                       "key=" . urlencode($apiKey) .
                       "&cx=" . urlencode($searchEngineId) .
                       "&q=" . urlencode($query) .
                       "&num=10" .
                       "&lr=lang_es";
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/json'
                ]);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                if (curl_errno($ch)) {
                    throw new \Exception('Error en la petición cURL a Google Custom Search: ' . curl_error($ch));
                }
                
                curl_close($ch);
                
                if ($httpCode === 200) {
                    $data = json_decode($response, true);
                    if (json_last_error() === JSON_ERROR_NONE && isset($data['items'])) {
                        $results = [];
                        foreach ($data['items'] as $item) {
                            $title = $item['title'] ?? '';
                            $snippet = $item['snippet'] ?? '';
                            $link = $item['link'] ?? '';
                            
                            // Filtrar solo documentos indexados (no citaciones)
                            // Filtrar solo documentos indexados (no citaciones)
                            $esIndexado = $this->esDocumentoIndexado($title, $snippet, $link);
                            if ($esIndexado) {
                                $results[] = [
                                    'catalogo_id' => 'google_scholar_' . md5($link),
                                    'sourcerecordid' => '',
                                    'titulo' => $title,
                                    'autores' => $this->extraerAutoresDeGoogle($snippet),
                                    'anio' => $this->extraerAnioDeGoogle($snippet),
                                    'editorial' => $this->extraerEditorialDeGoogle($snippet),
                                    'url' => $link,
                                    'context' => 'PC',
                                    'adaptor' => 'Google Scholar',
                                    'formato' => $this->determinarFormato($link, $title),
                                    'snippet' => $snippet
                                ];
                            }
                        }
                        return $results;
                    }
                }
            }
            
            // Si no funciona Custom Search, intentar búsqueda web directa
            $url = "https://scholar.google.com/scholar?" .
                   "q=" . urlencode($query) .
                   "&hl=es" .
                   "&num=10" .
                   "&as_sdt=0,5" . // Incluir tesis y libros
                   "&btnG="; // Botón de búsqueda
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'Cache-Control: no-cache',
                'Pragma: no-cache'
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new \Exception('Error en la petición cURL a Google Scholar: ' . curl_error($ch));
            }
            
            curl_close($ch);
            
            if ($httpCode !== 200) {
                throw new \Exception('Error al consultar Google Scholar: ' . $httpCode);
            }
            
            // Verificar si Google Scholar bloqueó la petición
            if (strpos($response, 'Our systems have detected unusual traffic') !== false || 
                strpos($response, 'captcha') !== false ||
                strpos($response, 'robot') !== false ||
                strpos($response, 'unusual traffic') !== false) {
                error_log('Google Scholar bloqueó la petición para query: ' . $query);
                return [];
            }
            
            // Verificar si hay resultados
            if (strpos($response, 'No se encontraron resultados') !== false || 
                strpos($response, 'No results found') !== false ||
                strpos($response, 'did not match any articles') !== false) {
                error_log('Google Scholar no encontró resultados para query: ' . $query);
                return [];
            }
            
            // Procesar la respuesta HTML para extraer resultados
            $results = $this->procesarRespuestaGoogleScholar($response, $query);
            
            // Si no se encontraron resultados con el procesamiento normal, intentar con un enfoque más simple
            if (empty($results)) {
                $results = $this->procesarRespuestaGoogleScholarSimple($response, $query);
            }
            
            return $results;
            
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogleWeb: ' . $e->getMessage());
            // Si Google Scholar falla, intentar con Google Books como respaldo
            return $this->buscarEnGoogleBooksComoRespaldo($query);
        }
    }
    
    private function buscarEnGoogleBooksComoRespaldo($query) {
        try {
            // Usar Google Books API como respaldo para búsquedas académicas
            $url = "https://www.googleapis.com/books/v1/volumes?" .
                   "q=" . urlencode($query) .
                   "&langRestrict=es" .
                   "&maxResults=10" .
                   "&printType=books" .
                   "&orderBy=relevance";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json'
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new \Exception('Error en la petición cURL a Google Books: ' . curl_error($ch));
            }
            
            curl_close($ch);
            
            if ($httpCode !== 200) {
                throw new \Exception('Error al consultar Google Books API: ' . $httpCode);
            }
            
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al decodificar la respuesta de Google Books: ' . json_last_error_msg());
            }
            
            $results = [];
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $volumeInfo = $item['volumeInfo'] ?? [];
                    $authors = isset($volumeInfo['authors']) ? implode('; ', $volumeInfo['authors']) : '';
                    $publishedDate = $volumeInfo['publishedDate'] ?? '';
                    $publisher = $volumeInfo['publisher'] ?? '';
                    $description = $volumeInfo['description'] ?? '';
                    $previewLink = $volumeInfo['previewLink'] ?? '';
                    
                    $results[] = [
                        'catalogo_id' => 'google_books_backup_' . md5($item['id'] ?? ''),
                        'sourcerecordid' => '',
                        'titulo' => $volumeInfo['title'] ?? 'Sin título',
                        'autores' => $authors,
                        'anio' => $this->extraerAnioDeTexto($publishedDate),
                        'editorial' => $publisher,
                        'url' => $previewLink,
                        'context' => 'PC',
                        'adaptor' => 'Google Books (Respaldo)',
                        'formato' => 'Libro',
                        'snippet' => $description
                    ];
                }
            }
            
            return $results;
            
        } catch (\Exception $e) {
            error_log('Error en buscarEnGoogleBooksComoRespaldo: ' . $e->getMessage());
            return [];
        }
    }
    
    private function procesarRespuestaGoogleScholar($html, $query) {
        $results = [];
        
        // Debug: Guardar HTML para análisis
        error_log('HTML de Google Scholar recibido: ' . substr($html, 0, 2000));
        
        // Extraer resultados usando expresiones regulares mejoradas
        // Buscar títulos en diferentes formatos posibles
        preg_match_all('/<h3[^>]*class="[^"]*gs_rt[^"]*"[^>]*>(.*?)<\/h3>/s', $html, $titles);
        if (empty($titles[1])) {
            // Intentar con formato alternativo
            preg_match_all('/<h3[^>]*>(.*?)<\/h3>/s', $html, $titles);
        }
        if (empty($titles[1])) {
            // Intentar con formato más genérico
            preg_match_all('/<h3[^>]*class="[^"]*"[^>]*>(.*?)<\/h3>/s', $html, $titles);
        }
        
        // Buscar autores y fuentes
        preg_match_all('/<div[^>]*class="[^"]*gs_a[^"]*"[^>]*>(.*?)<\/div>/s', $html, $authors);
        if (empty($authors[1])) {
            // Intentar con formato alternativo
            preg_match_all('/<div[^>]*class="[^"]*gs_a[^"]*"[^>]*>(.*?)<\/div>/s', $html, $authors);
        }
        
        // Buscar snippets/resúmenes
        preg_match_all('/<div[^>]*class="[^"]*gs_rs[^"]*"[^>]*>(.*?)<\/div>/s', $html, $snippets);
        if (empty($snippets[1])) {
            // Intentar con formato alternativo
            preg_match_all('/<div[^>]*class="[^"]*gs_rs[^"]*"[^>]*>(.*?)<\/div>/s', $html, $snippets);
        }
        
        // Buscar enlaces
        preg_match_all('/href="([^"]*)"[^>]*class="[^"]*gs_rt[^"]*"/s', $html, $links);
        if (empty($links[1])) {
            // Intentar con formato alternativo
            preg_match_all('/href="([^"]*)"[^>]*>/s', $html, $links);
        }
        
        // Si aún no encontramos resultados, usar un enfoque más genérico
        if (empty($titles[1])) {
            // Buscar cualquier enlace que contenga el título
            preg_match_all('/<a[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/s', $html, $genericLinks);
            if (!empty($genericLinks[1])) {
                for ($i = 0; $i < min(count($genericLinks[1]), 10); $i++) {
                    $link = $genericLinks[1][$i];
                    $title = strip_tags($genericLinks[2][$i]);
                    
                    // Filtrar solo enlaces que parezcan resultados académicos
                    if (!empty($title) && 
                        strlen($title) > 10 && 
                        !strpos($link, 'google.com') && 
                        !strpos($link, 'scholar.google.com') &&
                        !strpos($title, 'Google') &&
                        !strpos($title, 'Scholar')) {
                        $results[] = [
                            'catalogo_id' => 'google_scholar_' . md5($link),
                            'sourcerecordid' => '',
                            'titulo' => $title,
                            'autores' => $this->extraerAutoresDeHTML($html, $i),
                            'anio' => $this->extraerAnioDeTexto($title),
                            'editorial' => '',
                            'url' => $link,
                            'context' => 'PC',
                            'adaptor' => 'Google Scholar',
                            'formato' => 'Academic',
                            'snippet' => $this->extraerSnippetDeHTML($html, $i)
                        ];
                    }
                }
                return $results;
            }
        }
        
        $count = min(count($titles[1]), 10);
        
        for ($i = 0; $i < $count; $i++) {
            $title = strip_tags($titles[1][$i] ?? '');
            $author = strip_tags($authors[1][$i] ?? '');
            $snippet = strip_tags($snippets[1][$i] ?? '');
            $link = $links[1][$i] ?? '';
            
            if (!empty($title)) {
                $results[] = [
                    'catalogo_id' => 'google_scholar_' . md5($link),
                    'sourcerecordid' => '',
                    'titulo' => $title,
                    'autores' => $author,
                    'anio' => $this->extraerAnioDeTexto($author . ' ' . $snippet),
                    'editorial' => '',
                    'url' => $link,
                    'context' => 'PC',
                    'adaptor' => 'Google Scholar',
                    'formato' => 'Academic',
                    'snippet' => $snippet
                ];
            }
        }
        
        return $results;
    }
    
    private function extraerAutoresDeHTML($html, $index) {
        // Intentar extraer autores del HTML basado en el índice
        $pattern = '/<div[^>]*class="[^"]*gs_a[^"]*"[^>]*>(.*?)<\/div>/s';
        preg_match_all($pattern, $html, $matches);
        
        if (isset($matches[1][$index])) {
            return strip_tags($matches[1][$index]);
        }
        
        return '';
    }
    
    private function extraerSnippetDeHTML($html, $index) {
        // Intentar extraer snippet del HTML basado en el índice
        $pattern = '/<div[^>]*class="[^"]*gs_rs[^"]*"[^>]*>(.*?)<\/div>/s';
        preg_match_all($pattern, $html, $matches);
        
        if (isset($matches[1][$index])) {
            return strip_tags($matches[1][$index]);
        }
        
        return '';
    }
    
    private function procesarRespuestaGoogleScholarSimple($html, $query) {
        $results = [];
        
        // Enfoque más simple: buscar cualquier enlace que contenga texto relevante
        preg_match_all('/<a[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/s', $html, $matches);
        
        $count = 0;
        for ($i = 0; $i < count($matches[1]) && $count < 10; $i++) {
            $link = $matches[1][$i];
            $title = strip_tags($matches[2][$i]);
            
            // Filtrar enlaces relevantes
            if (!empty($title) && 
                strlen($title) > 10 && 
                !strpos($link, 'google.com') && 
                !strpos($link, 'scholar.google.com') &&
                !strpos($link, 'javascript:') &&
                !strpos($title, 'Google') &&
                !strpos($title, 'Scholar')) {
                
                // Extraer información básica del título
                $autores = $this->extraerAutoresDeTexto($title);
                $anio = $this->extraerAnioDeTexto($title);
                
                $results[] = [
                    'catalogo_id' => 'google_scholar_simple_' . md5($link),
                    'sourcerecordid' => '',
                    'titulo' => $title,
                    'autores' => $autores,
                    'anio' => $anio,
                    'editorial' => '',
                    'url' => $link,
                    'context' => 'PC',
                    'adaptor' => 'Google Scholar',
                    'formato' => 'Academic',
                    'snippet' => substr($title, 0, 200) . '...'
                ];
                
                $count++;
            }
        }
        
        return $results;
    }
    
    private function extraerAutoresDeTexto($texto) {
        // Intentar extraer autores del texto
        $autores = [];
        
        // Buscar patrones de nombres (mayúscula seguida de minúsculas)
        if (preg_match_all('/([A-Z][a-z]+ [A-Z][a-z]+)/', $texto, $matches)) {
            $autores = array_slice($matches[1], 0, 3);
        }
        
        return implode('; ', $autores);
    }
    
    private function extraerAutoresDeGoogle($snippet) {
        // Intentar extraer autores del snippet
        $autores = [];
        
        // Buscar patrones comunes de autores en el snippet
        if (preg_match_all('/([A-Z][a-z]+ [A-Z][a-z]+)/', $snippet, $matches)) {
            $autores = array_slice($matches[1], 0, 3); // Máximo 3 autores
        }
        
        return implode('; ', $autores);
    }
    
    private function extraerAnioDeGoogle($snippet) {
        // Extraer año del snippet
        if (preg_match('/(19|20)\d{2}/', $snippet, $matches)) {
            return $matches[0];
        }
        return '';
    }
    
    private function extraerAnioDeTexto($texto) {
        // Extraer año del texto
        if (preg_match('/(19|20)\d{2}/', $texto, $matches)) {
            return $matches[0];
        }
        return '';
    }
    
    private function esDocumentoIndexado($title, $snippet, $link) {
        // Excluir solo resultados claramente no deseados
        $exclusiones = [
            'facebook.com',
            'twitter.com',
            'linkedin.com',
            'youtube.com',
            'instagram.com',
            'tiktok.com',
            'snapchat.com',
            'pinterest.com'
        ];
        
        $textoCompleto = strtolower($title . ' ' . $snippet . ' ' . $link);
        
        foreach ($exclusiones as $exclusion) {
            if (strpos($textoCompleto, strtolower($exclusion)) !== false) {
                return false;
            }
        }
        
        // Incluir cualquier resultado que parezca académico o educativo
        $inclusiones = [
            '.pdf',
            '.doc',
            '.docx',
            'academia.edu',
            'researchgate.net',
            'sciencedirect.com',
            'springer.com',
            'wiley.com',
            'tandfonline.com',
            'sagepub.com',
            'jstor.org',
            'dialnet.unirioja.es',
            'redalyc.org',
            'scielo.org',
            'revistas.',
            'universidad',
            'university',
            'tesis',
            'thesis',
            'artículo',
            'article',
            'libro',
            'book',
            'capítulo',
            'chapter',
            'grupoblascabrera.org',
            'proquest.com',
            'revistascientificas.us.es',
            'mapa.org',
            'editorial',
            'editora',
            'publisher',
            'press',
            'didáctica',
            'didactic',
            'educación',
            'education',
            'pedagogía',
            'pedagogy',
            'enseñanza',
            'teaching',
            'aprendizaje',
            'learning'
        ];
        
        foreach ($inclusiones as $inclusion) {
            if (strpos($textoCompleto, strtolower($inclusion)) !== false) {
                return true;
            }
        }
        
        // Si no coincide con inclusiones específicas, incluir si no es claramente una citación
        return !$this->esCitacion($title, $snippet);
    }
    
    private function esCitacion($title, $snippet) {
        // Solo excluir si es claramente solo una citación sin contenido
        $patronesCitacion = [
            '/^citado\s*por\s*\d+$/i',
            '/^cited\s*by\s*\d+$/i',
            '/^versiones?\s*\d+$/i',
            '/^versions?\s*\d+$/i'
        ];
        
        $texto = trim($title . ' ' . $snippet);
        
        foreach ($patronesCitacion as $patron) {
            if (preg_match($patron, $texto)) {
                return true;
            }
        }
        
        // Si el título contiene información sustancial, no es solo una citación
        if (strlen($title) > 20) {
            return false;
        }
        
        return false;
    }
    
    private function extraerEditorialDeGoogle($snippet) {
        // Extraer editorial del snippet
        $patrones = [
            '/([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*\s+(?:Editorial|Editora|Publishers?|Press))/',
            '/([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*\s+(?:Universidad|University))/',
            '/([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*\s+(?:Revista|Journal))/'
        ];
        
        foreach ($patrones as $patron) {
            if (preg_match($patron, $snippet, $matches)) {
                return trim($matches[1]);
            }
        }
        
        return '';
    }
    
    private function determinarFormato($link, $title) {
        $texto = strtolower($link . ' ' . $title);
        
        if (strpos($texto, '.pdf') !== false) {
            return 'PDF';
        } elseif (strpos($texto, 'tesis') !== false || strpos($texto, 'thesis') !== false) {
            return 'Tesis';
        } elseif (strpos($texto, 'artículo') !== false || strpos($texto, 'article') !== false) {
            return 'Artículo';
        } elseif (strpos($texto, 'libro') !== false || strpos($texto, 'book') !== false) {
            return 'Libro';
        } elseif (strpos($texto, 'capítulo') !== false || strpos($texto, 'chapter') !== false) {
            return 'Capítulo';
        } else {
            return 'Documento';
        }
    }

    private function obtenerEjemplares($recordId) {
        try {
            // API key específica para holdings y ejemplares
            $apiKey = $_ENV['ALMA_API_KEY'] ?? '';
            $url = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{$recordId}/holdings?apikey={$apiKey}";
            //error_log('URL de holdings: ' . $url);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/json; charset=UTF-8'
            ]);
            
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                //error_log("Error al obtener holdings. Código HTTP: " . $httpCode);
                return [];
            }

            $data = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                //error_log("Error al decodificar respuesta de holdings: " . json_last_error_msg());
                return [];
            }

            $ejemplares = [];
            if (isset($data['holding']) && is_array($data['holding'])) {
                foreach ($data['holding'] as $holding) {
                    if (isset($holding['library'])) {
                        // Obtener la cantidad de ejemplares para este holding
                        $holdingId = $holding['holding_id'];
                        $itemsUrl = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{$recordId}/holdings/{$holdingId}/items?offset=0&order_by=none&direction=desc&view=brief&apikey={$apiKey}";
                        //error_log('URL de items: ' . $itemsUrl);
                        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $itemsUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Accept: application/json',
                            'Content-Type: application/json; charset=UTF-8'
                        ]);

                        $itemsResult = curl_exec($ch);
                        $itemsHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        $cantidadEjemplares = 0;
                        if ($itemsHttpCode === 200) {
                            $itemsData = json_decode($itemsResult, true);
                            if (isset($itemsData['total_record_count'])) {
                                $cantidadEjemplares = (int)$itemsData['total_record_count'];
                            }
                        }

                        $ejemplares[] = [
                            'biblioteca' => $holding['library']['desc'],
                            'codigo_biblioteca' => $holding['library']['value'],
                            'ubicacion' => $holding['location']['desc'] ?? '',
                            'codigo_ubicacion' => $holding['location']['value'] ?? '',
                            'signatura' => $holding['call_number'] ?? '',
                            'cantidad_ejemplares' => $cantidadEjemplares
                        ];
                    }
                }
            }

            return $ejemplares;
        } catch (\Exception $e) {
            //error_log("Error al obtener ejemplares: " . $e->getMessage());
            return [];
        }
    }

    private function procesarAutor($autor, $context, $adaptor) {
        //error_log('Procesando autor: ' . $autor . ' (Context: ' . $context . ', Adaptor: ' . $adaptor . ')');
        
        // Limpiar el nombre del autor
        $autor = trim($autor);
        if (empty($autor)) {
            //error_log('Autor vacío, saltando...');
            return null;
        }
        
        // Extraer apellido y nombre
        $apellidos = '';
        $nombres = '';
        
        if ($context === 'L' && $adaptor === 'Local Search Engine') {
            // Para registros locales, extraer del formato $$N
            if (preg_match('/\$\$N([^$]+)\$\$L([^$]+)\$\$F([^$]+)/', $autor, $matches)) {
                $apellidos = trim($matches[2]);
                $nombres = trim($matches[3]);
            } else {
                // Si no coincide el formato, intentar separar por coma
                $partes = explode(',', $autor);
                if (count($partes) >= 2) {
                    $apellidos = trim($partes[0]);
                    $nombres = trim($partes[1]);
                } else {
                    $nombres = $autor;
                }
            }
        } else if ($context === 'PC' && $adaptor === 'Primo Central') {
            // Para registros Primo Central, intentar separar por coma
            $partes = explode(',', $autor);
            if (count($partes) >= 2) {
                $apellidos = trim($partes[0]);
                $nombres = trim($partes[1]);
            } else {
                $nombres = $autor;
            }
        } else {
            // Para otros casos, intentar separar por coma
            $partes = explode(',', $autor);
            if (count($partes) >= 2) {
                $apellidos = trim($partes[0]);
                $nombres = trim($partes[1]);
            } else {
                $nombres = $autor;
            }
        }
        
        // Eliminar punto final si no es inicial
        $apellidos = preg_replace('/(?<!\b[A-Z])\.$/', '', $apellidos);
        $nombres = preg_replace('/(?<!\b[A-Z])\.$/', '', $nombres);
        // Si es una inicial (una letra y punto), conservar
        // (ya lo hace la expresión anterior)
        
        //error_log('Autor procesado - Apellidos: ' . $apellidos . ', Nombres: ' . $nombres);
        
        // Buscar si el autor ya existe en la tabla autores
        $stmt = $this->pdo->prepare("SELECT id FROM autores WHERE UPPER(apellidos) = UPPER(?) AND UPPER(nombres) = UPPER(?)");
        $stmt->execute([$apellidos, $nombres]);
        $autorExistente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($autorExistente) {
            //error_log('Autor encontrado en la base de datos con ID: ' . $autorExistente['id']);
            return [
                'id' => $autorExistente['id'],
                'apellidos' => $apellidos,
                'nombres' => $nombres
            ];
        }
        
        // Si no se encuentra en autores, buscar en alias_autores
        $nombreCompleto = trim($apellidos . ', ' . $nombres);
        $stmt = $this->pdo->prepare("
            SELECT a.id, a.apellidos, a.nombres 
            FROM autores a 
            INNER JOIN alias_autores aa ON a.id = aa.autor_id 
            WHERE UPPER(aa.nombre_variacion) = UPPER(?)
        ");
        $stmt->execute([$nombreCompleto]);
        $autorConAlias = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($autorConAlias) {
            //error_log('Autor encontrado en alias con ID: ' . $autorConAlias['id']);
            return [
                'id' => $autorConAlias['id'],
                'apellidos' => $autorConAlias['apellidos'],
                'nombres' => $autorConAlias['nombres']
            ];
        }
        
        // Si no existe, insertar nuevo autor
        $stmt = $this->pdo->prepare("INSERT INTO autores (apellidos, nombres, genero) VALUES (?, ?, ?)");
        $stmt->execute([$apellidos, $nombres, 'Otro']);
        $nuevoId = $this->pdo->lastInsertId();
        
        //error_log('Nuevo autor insertado con ID: ' . $nuevoId);
        return [
            'id' => $nuevoId,
            'apellidos' => $apellidos,
            'nombres' => $nombres
        ];
    }

    public function guardarBibliografiasSeleccionadas() {
        try {
            //error_log('Iniciando guardarBibliografiasSeleccionadas');
            
            // Obtener datos del POST
            $json = file_get_contents('php://input');
            error_log('Datos recibidos: ' . $json);
            
            $data = json_decode($json, true);
            if (!$data || !isset($data['bibliografias'])) {
                throw new \Exception('Datos inválidos');
            }
            
            $bibliografias = $data['bibliografias'];
            error_log('Número de bibliografías a procesar: ' . count($bibliografias));
            
            // Obtener ID de la bibliografía declarada de la URL
            $url = $_SERVER['REQUEST_URI'];
            preg_match('/\/bibliografias-declaradas\/(\d+)\/guardar-seleccionadas/', $url, $matches);
            $bibliografiaDeclaradaId = $matches[1] ?? null;
            
            error_log('URL: ' . $url);
            error_log('Valor de $bibliografiaDeclaradaId: ' . var_export($bibliografiaDeclaradaId, true));
            
            if (!$bibliografiaDeclaradaId) {
                throw new \Exception('ID de bibliografía declarada no encontrado en la URL');
            }
            
            error_log('Tipo de $this->pdo: ' . (is_object($this->pdo) ? get_class($this->pdo) : gettype($this->pdo)));
            
            error_log('Estructura de bibliografías: ' . json_encode($bibliografias, JSON_PRETTY_PRINT));
            
            // Verificar conexión a la base de datos
            if (!$this->pdo) {
                //error_log('Error: No hay conexión a la base de datos');
                throw new \Exception('Error de conexión a la base de datos');
            }
            
            // Iniciar transacción
            error_log('Iniciando transacción...');
            $this->pdo->beginTransaction();
            error_log('Transacción iniciada correctamente');
            
            error_log('Entrando al foreach de bibliografías...');
            $cont_duplicados = 0;
            $cont_procesados = 0;
            $cont_bibguardadas = 0;
            foreach ($bibliografias as $bibliografia) {
                error_log('Iniciando procesamiento de bibliografía: ' . json_encode($bibliografia));
                
                // Obtener ID MMS para registro local
                $idMms = $bibliografia['catalogo_id'];
                error_log('ID MMS para registro local: ' . $idMms);

                $stmt = $this->pdo->prepare("SELECT id, id_mms FROM bibliografias_disponibles WHERE id_mms = ?");
                $stmt->execute([$idMms]);
                $idMms_duplicado = $stmt->fetch(PDO::FETCH_ASSOC);

                $cont_procesados++;
                $esActualizacion = false;
                $bibliografiaDisponibleId = null;
                
                if ($idMms_duplicado) {
                    error_log('ID MMS duplicado encontrado, procediendo a actualizar información de la bibliografía ID: ' . $idMms_duplicado['id']);
                    $cont_duplicados++;
                    $esActualizacion = true;
                    $bibliografiaDisponibleId = $idMms_duplicado['id'];
                }

                //Se procesa la bibliografía (nueva o actualización)
                if (empty($idMms_duplicado) || $esActualizacion) {
                    $context = $bibliografia['context'];
                    $adaptor = $bibliografia['adaptor'];
                    
                    // Inicializar variables comunes
                    $ejemplares = [];
                    $tienePortafolios = false;
                    $tieneRepresentaciones = false;
                    $disponibilidad = 'impreso';
                    $url_catalogo = $bibliografia['url'];
                    $url_acceso = '';
                    
                    // Validar y limpiar datos
                    $titulo = trim($bibliografia['titulo'] ?? 'Sin título');
                    
                    // Validar y limpiar el año de edición
                    $anio = !empty($bibliografia['anio']) ? trim($bibliografia['anio']) : '';
                    if (!empty($anio)) {
                        // Extraer solo los dígitos del año
                        $anioNumerico = preg_replace('/[^0-9]/', '', $anio);
                        if (!empty($anioNumerico)) {
                            $anio = (int)$anioNumerico;
                        } else {
                            $anio = 0;
                        }
                    } else {
                        $anio = 0;
                    }
                    
                    $editorial = trim($bibliografia['editorial'] ?? '');
                    
                    if (empty($titulo)) {
                        error_log('Error: Título vacío en la bibliografía');
                        continue;
                    }
                    
                    // Procesar según el tipo de registro
                    if ($context === 'L' && $adaptor === 'Local Search Engine') {
                        try {
                            // Obtener ejemplares
                            error_log('Llamando a obtenerEjemplares...');
                            $ejemplares = $this->obtenerEjemplares($idMms);
                            error_log('Ejemplares obtenidos: ' . json_encode($ejemplares));
                            
                            // Verificar portafolios
                            $portfoliosUrl = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{$idMms}/portfolios?limit=10&offset=0&apikey=" . ($_ENV['ALMA_API_KEY'] ?? '');
                            error_log('Consultando portafolios: ' . $portfoliosUrl);
                            $portfoliosResponse = @file_get_contents($portfoliosUrl);
                            if ($portfoliosResponse !== false) {
                                $xml = @simplexml_load_string($portfoliosResponse);
                                if ($xml !== false) {
                                    $tienePortafolios = isset($xml['total_record_count']) && (int)$xml['total_record_count'] > 0;
                                    error_log('Tiene portafolios: ' . ($tienePortafolios ? 'Sí' : 'No'));
                                }
                            }
                            
                            // Verificar representaciones digitales
                            $representationsUrl = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/bibs/{$idMms}/representations?limit=10&offset=0&use_updated_terminology=false&apikey=" . ($_ENV['ALMA_API_KEY'] ?? '');
                            error_log('Consultando representaciones: ' . $representationsUrl);
                            $representationsResponse = @file_get_contents($representationsUrl);
                            if ($representationsResponse !== false) {
                                $xml = @simplexml_load_string($representationsResponse);
                                if ($xml !== false) {
                                    $tieneRepresentaciones = isset($xml['total_record_count']) && (int)$xml['total_record_count'] > 0;
                                    error_log('Tiene representaciones: ' . ($tieneRepresentaciones ? 'Sí' : 'No'));
                                }
                            }
                            
                            // Determinar disponibilidad para registros locales
                            if ($tienePortafolios && $tieneRepresentaciones && !empty($ejemplares)) {
                                $disponibilidad = 'ambos';
                                //$url_acceso = $bibliografia['url'];
                                $url_acceso = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?'.
                                              'institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                                              '&vid='. ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                              '&Force_direct=true&rft.mms_id='. $idMms;
                            } elseif ($tienePortafolios && !empty($ejemplares)) {
                                $disponibilidad = 'ambos';
                                $url_acceso = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?'.
                                              'institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                                              '&vid='. ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                              '&Force_direct=true&rft.mms_id='. $idMms;
                            } elseif ($tieneRepresentaciones && !empty($ejemplares)) {
                                $disponibilidad = 'ambos';
                                $url_acceso = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?'.
                                              'institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                                              '&vid='. ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                              '&Force_direct=true&rft.mms_id='. $idMms;
                            } elseif ($tienePortafolios && empty($ejemplares)) {
                                $disponibilidad = 'electronico';
                                $url_acceso = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?'.
                                              'institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                                              '&vid='. ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                              '&Force_direct=true&rft.mms_id='. $idMms;
                            } elseif ($tieneRepresentaciones && empty($ejemplares)) {
                                $disponibilidad = 'electronico';
                                $url_acceso = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?'.
                                              'institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST') .
                                              '&vid='. ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') .
                                              '&Force_direct=true&rft.mms_id='. $idMms;
                            }

                        } catch (\Exception $e) {
                            error_log('Error al procesar registro local: ' . $e->getMessage());
                            // Mantener valores por defecto en caso de error
                        }
                    } else if ($context === 'PC' && $adaptor === 'Primo Central') {
                        $disponibilidad = 'electronico';
                        $url_acceso = $bibliografia['url'];
                        $url_catalogo = '';
                    } else if ($adaptor === 'Google Scholar' || $adaptor === 'Google Books' || $adaptor === 'Google Books (Respaldo)') {
                        // Para resultados de Google, siempre marcar como electrónico y usar la URL del resultado
                        $disponibilidad = 'electronico';
                        $url_acceso = $bibliografia['url'];
                        $url_catalogo = '';
                        error_log('Resultado de Google procesado - Disponibilidad: electronico, URL: ' . $url_acceso);
                    }
                    
                    error_log('Disponibilidad determinada: ' . $disponibilidad);
                    
                    // Insertar o actualizar bibliografía
                    if ($esActualizacion) {
                        error_log('Actualizando bibliografía existente con ID: ' . $bibliografiaDisponibleId);
                        $stmt = $this->pdo->prepare("
                            UPDATE bibliografias_disponibles 
                            SET titulo = ?, anio_edicion = ?, editorial = ?,
                                url_catalogo = ?, url_acceso = ?, disponibilidad = ?, estado = ?
                            WHERE id = ?
                        ");
                        
                        $params = [
                            $titulo,
                            $anio,
                            $editorial,
                            $url_catalogo,
                            $url_acceso,
                            $disponibilidad,
                            1,
                            $bibliografiaDisponibleId
                        ];
                        
                        $stmt->execute($params);
                        $bibliografiaId = $bibliografiaDisponibleId;
                        error_log('Bibliografía actualizada con ID: ' . $bibliografiaId);
                        
                        // Limpiar autores y ejemplares existentes para reinsertarlos
                        $stmt = $this->pdo->prepare("DELETE FROM bibliografias_disponibles_autores WHERE bibliografia_disponible_id = ?");
                        $stmt->execute([$bibliografiaId]);
                        
                        $stmt = $this->pdo->prepare("DELETE FROM bibliografias_disponibles_sedes WHERE bibliografia_disponible_id = ?");
                        $stmt->execute([$bibliografiaId]);
                        
                    } else {
                        error_log('Insertando nueva bibliografía...');
                        $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_disponibles (
                                bibliografia_declarada_id, titulo, anio_edicion, editorial,
                                url_catalogo, url_acceso, disponibilidad, id_mms, estado
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        
                        $params = [
                            $bibliografiaDeclaradaId,
                            $titulo,
                            $anio,
                            $editorial,
                            $url_catalogo,
                            $url_acceso,
                            $disponibilidad,
                            $idMms,
                            1
                        ];
                        
                        $stmt->execute($params);
                        $bibliografiaId = $this->pdo->lastInsertId();
                        error_log('Nueva bibliografía insertada con ID: ' . $bibliografiaId);
                    }
                    
                    // Procesar autores
                    if (!empty($bibliografia['autores'])) {
                        error_log('Procesando autores: ' . $bibliografia['autores']);
                        $autores = explode(';', $bibliografia['autores']);
                        $autoresInsertados = [];
                        foreach ($autores as $autor) {
                            $autor = trim($autor);
                            if ($autor === '') continue;
                            error_log('Procesando autor individual: ' . $autor);
                            $autorData = $this->procesarAutor($autor, $bibliografia['context'], $bibliografia['adaptor']);
                            if ($autorData) {
                                error_log('Datos del autor procesados: ' . json_encode($autorData));
                                // Evitar duplicados en la misma bibliografía
                                $key = $bibliografiaId . '-' . $autorData['id'];
                                if (isset($autoresInsertados[$key])) {
                                    error_log('Relación autor-bibliografía ya insertada en esta transacción: ' . $key);
                                    continue;
                                }
                                $autoresInsertados[$key] = true;
                                // Insertar relación en bibliografias_disponibles_autores
                                $stmt = $this->pdo->prepare("
                                    INSERT INTO bibliografias_disponibles_autores 
                                    (bibliografia_disponible_id, autor_id) 
                                    VALUES (?, ?)
                                ");
                                $stmt->execute([$bibliografiaId, $autorData['id']]);
                                error_log('Relación autor-bibliografía guardada: ' . $autorData['id'] . ' -> ' . $bibliografiaId);
                            } else {
                                error_log('No se pudo procesar el autor: ' . $autor);
                            }
                        }
                    }
                    
                    // Procesar ejemplares de un registro local
                    if ($context === 'L' && $adaptor === 'Local Search Engine') {
                        // Procesar ejemplares
                        error_log('Procesando ejemplares de un registro local...');
                        $ejemplaresPorSede = [];
                        
                        // Mapeo de bibliotecas a sedes
                        $mapeoBibliotecasSedes = [
                            'Biblioteca Antofagasta' => 'Antofagasta',
                            'Biblioteca Coquimbo' => 'Coquimbo',
                            'Biblioteca San Pedro de Atacama' => 'San Pedro de Atacama'
                        ];
                        
                        foreach ($ejemplares as $ejemplar) {
                            error_log('Procesando ejemplar: ' . json_encode($ejemplar));
                            
                            
                            // Obtener ID de la sede correspondiente
                            $sedeNombre = $mapeoBibliotecasSedes[$ejemplar['biblioteca']] ?? null;
                            if ($sedeNombre) {
                                $stmt = $this->pdo->prepare("SELECT id FROM sedes WHERE nombre = ?");
                                $stmt->execute([$sedeNombre]);
                                $sede = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                if ($sede) {
                                    // Verificar si ya existe un registro para esta sede
                                    $stmt = $this->pdo->prepare("
                                        SELECT id, ejemplares 
                                        FROM bibliografias_disponibles_sedes 
                                        WHERE bibliografia_disponible_id = ? AND sede_id = ?
                                    ");
                                    $stmt->execute([$bibliografiaId, $sede['id']]);
                                    $registroExistente = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                                    if ($registroExistente) {
                                        // Actualizar ejemplares existentes
                                        $stmt = $this->pdo->prepare("
                                            UPDATE bibliografias_disponibles_sedes 
                                            SET ejemplares = ejemplares + ? 
                                            WHERE id = ?
                                        ");
                                        $stmt->execute([$ejemplar['cantidad_ejemplares'], $registroExistente['id']]);
                                    } else {
                                        // Insertar nuevo registro
                                        $stmt = $this->pdo->prepare("
                                            INSERT INTO bibliografias_disponibles_sedes 
                                            (bibliografia_disponible_id, sede_id, ejemplares) 
                                            VALUES (?, ?, ?)
                                        ");
                                        $stmt->execute([
                                            $bibliografiaId, 
                                            $sede['id'], 
                                            $ejemplar['cantidad_ejemplares']
                                        ]);
                                    }
                                    
                                    // Actualizar el contador para la respuesta
                                    if (!isset($ejemplaresPorSede[$sede['id']])) {
                                        $ejemplaresPorSede[$sede['id']] = 0;
                                    }
                                    $ejemplaresPorSede[$sede['id']] += $ejemplar['cantidad_ejemplares'];
                                }
                            }
                        }
                    }
                }
            }
            
            // Commit de la transacción
            error_log('Commit de la transacción...');
            $this->pdo->commit();
            error_log('Transacción completada exitosamente');
            
            // Preparar respuesta exitosa
            $cont_bibguardadas = $cont_procesados - $cont_duplicados;
            $cont_actualizadas = $cont_duplicados; // Los duplicados ahora son actualizaciones
            $response = [
                'success' => true,
                'message' => $cont_bibguardadas . ' Bibliografías guardadas correctamente. Se actualizaron ' . $cont_actualizadas . ' bibliografías existentes.',
                'ejemplares_por_sede' => $ejemplaresPorSede ?? []
            ];
            
            // Enviar respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        exit;
            
        } catch (\Exception $e) {
            // Rollback en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            error_log('Error al guardar bibliografías: ' . $e->getMessage());
            
            // Preparar respuesta de error
            $response = [
                'success' => false,
                'message' => 'Error al guardar las bibliografías: ' . $e->getMessage()
            ];
            
            // Enviar respuesta JSON de error
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    }

    private function obtenerAsignaturasVinculadas($bibliografiaId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                ab.id as vinculacion_id,
                a.id, 
                a.nombre,
                GROUP_CONCAT(DISTINCT TRIM(ad.codigo_asignatura) ORDER BY TRIM(ad.codigo_asignatura) SEPARATOR ', ') as codigos,
                ab.tipo_bibliografia
            FROM asignaturas_bibliografias ab
            JOIN asignaturas a ON ab.asignatura_id = a.id
            LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            WHERE ab.bibliografia_id = ?
            GROUP BY ab.id, a.id, a.nombre, ab.tipo_bibliografia
            ORDER BY MIN(TRIM(ad.codigo_asignatura)), a.nombre
        ");
        $stmt->execute([$bibliografiaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Normaliza un título eliminando acentos, caracteres especiales y espacios redundantes
     */
    private function normalizarTitulo(string $titulo): string
    {
        // Convertir a minúsculas
        $titulo = mb_strtolower($titulo, 'UTF-8');
        
        // Reemplazar caracteres acentuados
        $acentos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
            'â' => 'a', 'ê' => 'e', 'î' => 'i', 'ô' => 'o', 'û' => 'u',
            'ã' => 'a', 'ẽ' => 'e', 'ĩ' => 'i', 'õ' => 'o', 'ũ' => 'u',
            'ñ' => 'n', 'ç' => 'c'
        ];
        
        $titulo = strtr($titulo, $acentos);
        
        // Eliminar caracteres especiales excepto espacios, números y letras
        $titulo = preg_replace('/[^a-z0-9\s]/', '', $titulo);
        
        // Eliminar espacios múltiples y espacios al inicio/final
        $titulo = preg_replace('/\s+/', ' ', $titulo);
        $titulo = trim($titulo);
        
        return $titulo;
    }

    /**
     * Busca bibliografías duplicadas basándose en el título normalizado
     */
    private function buscarDuplicados(string $titulo): array
    {
        $tituloNormalizado = $this->normalizarTitulo($titulo);
        
        // Obtener todas las bibliografías y normalizar sus títulos para comparar
        $stmt = $this->pdo->prepare("
            SELECT 
                id,
                titulo,
                anio_publicacion,
                editorial,
                tipo
            FROM bibliografias_declaradas 
            ORDER BY anio_publicacion DESC, titulo ASC
        ");
        
        $stmt->execute();
        $todasLasBibliografias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $duplicados = [];
        foreach ($todasLasBibliografias as $bibliografia) {
            $tituloExistenteNormalizado = $this->normalizarTitulo($bibliografia['titulo']);
            if ($tituloExistenteNormalizado === $tituloNormalizado) {
                $duplicados[] = $bibliografia;
            }
        }
        
        return $duplicados;
    }

    /**
     * Fuerza la creación de una bibliografía ignorando duplicados
     */
    public function storeForzar(Request $request = null, Response $response = null): Response
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para acceder a las bibliografías',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
            }
            
            $_SESSION['error'] = 'Por favor inicie sesión para acceder a las bibliografías';
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Verificar si es una petición AJAX
        $esAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // Obtener los datos según el tipo de petición
        if ($esAjax) {
            $datos = json_decode(file_get_contents('php://input'), true);
        } else {
            $datos = $_POST;
        }
        
        // Verificar token de sesión
        $token = $datos['_token'] ?? '';
        $sessionToken = $this->session->get('form_token');
        
        if (!$token || !$sessionToken || $token !== $sessionToken) {
            if ($esAjax) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Token de seguridad inválido'
                ]);
            }
            
            $_SESSION['error'] = 'Token de seguridad inválido';
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            return new Response();
        }
        
        // Generar nuevo token para la siguiente solicitud
        $newToken = bin2hex(random_bytes(32));
        $this->session->set('form_token', $newToken);
        
        // Decodificar los autores
        $autores = json_decode($datos['autores'] ?? '[]', true);
        
        try {
            $this->pdo->beginTransaction();
            
            // Insertar la bibliografía (mismo código que en store)
            $stmt = $this->pdo->prepare("
                INSERT INTO bibliografias_declaradas (
                    titulo, anio_publicacion, edicion, url, formato, 
                    nota, tipo, editorial, doi, estado
                ) VALUES (
                    :titulo, :anio_publicacion, :edicion, :url, :formato,
                    :nota, :tipo, :editorial, :doi, :estado
                )
            ");
            
            $stmt->execute([
                ':titulo' => $datos['titulo'] ?? '',
                ':anio_publicacion' => $datos['anio_publicacion'] ?? null,
                ':edicion' => $datos['edicion'] ?? null,
                ':url' => $datos['url'] ?? null,
                ':formato' => $datos['formato'] ?? 'impreso',
                ':nota' => $datos['nota'] ?? null,
                ':tipo' => $datos['tipo'] ?? null,
                ':editorial' => ($datos['editorial'] ?? '') === 'otra' ? ($datos['nueva_editorial'] ?? '') : ($datos['editorial'] ?? ''),
                ':doi' => $datos['doi'] ?? null,
                ':estado' => $datos['estado'] ?? 1
            ]);
            
            $bibliografiaId = $this->pdo->lastInsertId();
            
            // Insertar datos específicos según el tipo (mismo código que en store)
            switch ($datos['tipo'] ?? '') {
                case 'libro':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO libros (bibliografia_id, isbn)
                        VALUES (:bibliografia_id, :isbn)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':isbn' => $datos['isbn'] ?? null
                    ]);
                    break;

                case 'tesis':
                    $nombreCarrera = $datos['nombre_carrera'] ?? null;
                    if ($nombreCarrera === 'otra') {
                        $nombreCarrera = $datos['nueva_carrera'] ?? null;
                    }
                    $stmt = $this->pdo->prepare("
                        INSERT INTO tesis (bibliografia_id, nombre_carrera)
                        VALUES (:bibliografia_id, :nombre_carrera)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':nombre_carrera' => $nombreCarrera
                    ]);
                    break;

                case 'articulo':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO articulos (
                            bibliografia_id, issn, titulo_revista, cronologia
                        ) VALUES (
                            :bibliografia_id, :issn, :titulo_revista, :cronologia
                        )
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':issn' => $datos['issn'] ?? null,
                        ':titulo_revista' => ($datos['titulo_revista'] ?? '') === 'otra' ? ($datos['nueva_revista'] ?? '') : ($datos['titulo_revista'] ?? ''),
                        ':cronologia' => $datos['cronologia'] ?? null
                    ]);
                    break;

                case 'generico':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO genericos (bibliografia_id, descripcion)
                        VALUES (:bibliografia_id, :descripcion)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':descripcion' => $datos['descripcion'] ?? null
                    ]);
                    break;

                case 'sitio_web':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO sitios_web (bibliografia_id, fecha_consulta)
                        VALUES (:bibliografia_id, :fecha_consulta)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':fecha_consulta' => $datos['fecha_consulta'] ?? null
                    ]);
                    break;

                case 'software':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO software (bibliografia_id, version)
                        VALUES (:bibliografia_id, :version)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':version' => $datos['version'] ?? null
                    ]);
                    break;
            }

            // Procesar los autores (mismo código que en store)
            if (!empty($autores)) {
                foreach ($autores as $autor) {
                    if ($autor['es_nuevo'] || strpos($autor['temp_id'] ?? '', 'temp_') === 0) {
                        // Es un autor nuevo
                        $stmt = $this->pdo->prepare("
                            INSERT INTO autores (apellidos, nombres, genero)
                            VALUES (?, ?, ?)
                        ");
                        $stmt->execute([
                            $autor['apellidos'],
                            $autor['nombres'],
                            $autor['genero']
                        ]);
                        $autorId = $this->pdo->lastInsertId();
                    } else {
                        // Es un autor existente
                        $autorId = $autor['id'];
                    }
                    
                    if ($autorId) {
                        // Vincular autor con la bibliografía
                        $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_autores (bibliografia_id, autor_id)
                            VALUES (?, ?)
                        ");
                        $stmt->execute([
                            $bibliografiaId,
                            $autorId
                        ]);
                    }
                }
            }
            
            $this->pdo->commit();

            if ($esAjax) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Bibliografía creada exitosamente (ignorando duplicados)',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);
            }

            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            return new Response();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            //error_log('Error en storeForzar: ' . $e->getMessage());

            if ($esAjax) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Error al crear la bibliografía: ' . $e->getMessage()
                ]);
            }

            $_SESSION['error'] = 'Error al crear la bibliografía: ' . $e->getMessage();
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/create');
            return new Response();
        }
    }

    /**
     * Obtiene las bibliografías disponibles de una bibliografía declarada específica
     * Endpoint: GET /api/bibliografias-declaradas/{id}/disponibles
     */
    public function getBibliografiasDisponibles(Request $request, Response $response, array $args = []): Response
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para acceder a esta información'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            $bibliografiaId = $args['id'] ?? null;
            
            if (!$bibliografiaId) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'ID de bibliografía no proporcionado'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            // Obtener bibliografías disponibles
            $stmt = $this->pdo->prepare("
                SELECT 
                    bd.id,
                    bd.titulo,
                    bd.anio_edicion,
                    bd.editorial,
                    bd.url_acceso,
                    bd.url_catalogo,
                    bd.disponibilidad,
                    bd.id_mms,
                    bd.ejemplares_digitales,
                    bd.estado,
                    bd.fecha_creacion
                FROM bibliografias_disponibles bd
                WHERE bd.bibliografia_declarada_id = ?
                ORDER BY bd.titulo, bd.anio_edicion DESC
            ");
            $stmt->execute([$bibliografiaId]);
            $bibliografias = $stmt->fetchAll();

            $response->getBody()->write(json_encode([
                'success' => true,
                'bibliografias' => $bibliografias,
                'total' => count($bibliografias)
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            error_log("Error en getBibliografiasDisponibles: " . $e->getMessage());
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Error al obtener las bibliografías disponibles: ' . $e->getMessage()
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