<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use PDO;
use PDOException;
use App\Core\Config;
use src\Models\BibliografiaDeclarada;
use src\Models\Autor;
use src\Models\Asignatura;
use App\Core\Request;
use App\Core\Response;
use Illuminate\Support\Facades\DB;
use src\Models\Libro;
use src\Models\Tesis;
use src\Models\Articulo;
use src\Models\Generico;
use src\Models\SitioWeb;
use src\Models\Software;
use src\Models\Carrera;

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
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);
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
            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

        // Obtener filtros de la URL
        $filtros = [
            'busqueda' => $_GET['busqueda'] ?? '',
            'tipo_busqueda' => $_GET['tipo_busqueda'] ?? 'todos',
            'asignatura' => $_GET['asignatura'] ?? '',
            'tipo' => $_GET['tipo'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'orden' => $_GET['orden'] ?? 'titulo',
            'direccion' => $_GET['direccion'] ?? 'asc'
        ];

        // Validar dirección de ordenamiento
        $filtros['direccion'] = in_array($filtros['direccion'], ['asc', 'desc']) ? $filtros['direccion'] : 'asc';

        // Validar campo de ordenamiento
        $camposOrdenamiento = ['id', 'titulo', 'tipo', 'anio_publicacion', 'estado'];
        $filtros['orden'] = in_array($filtros['orden'], $camposOrdenamiento) ? $filtros['orden'] : 'titulo';

        // Construir la consulta base
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
        if (!empty($filtros['busqueda'])) {
            $busqueda = '%' . $filtros['busqueda'] . '%';
            switch ($filtros['tipo_busqueda']) {
                case 'titulo':
                        $where[] = "b.titulo LIKE ?";
                        $params[] = $busqueda;
                    break;
                case 'autor':
                        $where[] = "(a.nombres LIKE ? OR a.apellidos LIKE ?)";
                        $params[] = $busqueda;
                        $params[] = $busqueda;
                    break;
                case 'editorial':
                        $where[] = "b.editorial LIKE ?";
                        $params[] = $busqueda;
                        break;
                    case 'asignatura':
                        $where[] = "asig.nombre LIKE ?";
                        $params[] = $busqueda;
                    break;
                default: // 'todos'
                        $where[] = "(b.titulo LIKE ? OR b.editorial LIKE ? OR a.nombres LIKE ? OR a.apellidos LIKE ? OR asig.nombre LIKE ?)";
                        $params[] = $busqueda;
                        $params[] = $busqueda;
                        $params[] = $busqueda;
                        $params[] = $busqueda;
                        $params[] = $busqueda;
                    break;
            }
        }

        // Aplicar otros filtros
        if (!empty($filtros['tipo'])) {
                $where[] = "b.tipo = ?";
                $params[] = $filtros['tipo'];
        }
        if (!empty($filtros['estado'])) {
                $where[] = "b.estado = ?";
                $params[] = $filtros['estado'] === 'A' ? 1 : 0;
            }
            if (!empty($filtros['asignatura'])) {
                $where[] = "ab.asignatura_id = ?";
                $params[] = $filtros['asignatura'];
            }

            // Agregar condiciones WHERE si existen
            if (!empty($where)) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            // Agregar GROUP BY
            $sql .= " GROUP BY b.id";

            // Agregar ORDER BY
            $sql .= " ORDER BY b." . $filtros['orden'] . " " . $filtros['direccion'];

            // Ejecutar la consulta
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $bibliografias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener todas las asignaturas para el filtro
            $stmt = $this->pdo->query("SELECT id, nombre FROM asignaturas WHERE estado = 1 ORDER BY nombre");
            $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renderizar la vista
        return $this->render($response, 'bibliografias_declaradas/index.twig', [
            'bibliografias' => $bibliografias,
            'asignaturas' => $asignaturas,
            'filtros' => $filtros,
                'app_url' => Config::get('app_url'),
                'swal' => $swal
            ]);
        } catch (\Exception $e) {
            error_log('Error en index: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al cargar las bibliografías: ' . $e->getMessage()
                ]);
            } else {
                $_SESSION['error'] = 'Error al cargar las bibliografías: ' . $e->getMessage();
                header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            }
            return $response;
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
        
        // Obtener carreras
        $stmt = $this->pdo->query("
            SELECT id, nombre 
            FROM carreras 
            WHERE estado = 1 
            ORDER BY nombre
        ");
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'bibliografia' => new \stdClass(),
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'autores' => $autores,
            'carreras' => $carreras,
            'app_url' => Config::get('app_url'),
            'session' => [
                'form_token' => $token
            ]
        ]);
    }

    /**
     * Almacena una nueva bibliografía declarada.
     */
    public function store(Request $request = null, Response $response = null): Response
    {
        error_log('=== INICIO MÉTODO STORE ===');
        
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
        error_log('Es petición AJAX: ' . ($esAjax ? 'Sí' : 'No'));
        
        // Obtener los datos según el tipo de petición
        if ($esAjax) {
            $datos = json_decode(file_get_contents('php://input'), true);
        } else {
            $datos = $_POST;
        }
        
        error_log('Datos recibidos: ' . print_r($datos, true));
        
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
        error_log('Autores decodificados: ' . print_r($autores, true));
        
        try {
            $this->pdo->beginTransaction();
            
            // Insertar la bibliografía
                            $stmt = $this->pdo->prepare("
                INSERT INTO bibliografias_declaradas (
                    titulo, anio_publicacion, edicion, url, formato, 
                    nota, tipo, editorial, estado
                ) VALUES (
                    :titulo, :anio_publicacion, :edicion, :url, :formato,
                    :nota, :tipo, :editorial, :estado
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
                    $stmt = $this->pdo->prepare("
                        INSERT INTO tesis (bibliografia_id, carrera_id)
                        VALUES (:bibliografia_id, :carrera_id)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':carrera_id' => $datos['carrera_id'] ?? null
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
                    error_log('Procesando autor en store: ' . print_r($autor, true));
                    
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
                        error_log('Nuevo autor insertado con ID: ' . $autorId);
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
                        error_log('Autor vinculado con ID: ' . $autorId);
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

        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log('Error en store: ' . $e->getMessage());

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
    public function show($id = null, Request $request = null, Response $response = null): Response
    {
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

        if (!$id) {
            $id = $_GET['id'] ?? null;
        }
        
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        try {
            // Obtener la bibliografía completa con sus datos específicos
            $bibliografia = $this->obtenerBibliografiaCompleta($id);

        if (!$bibliografia) {
                throw new \Exception('Bibliografía no encontrada');
        }

            // Obtener las asignaturas vinculadas
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

            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

            // Debug: Imprimir datos de la bibliografía
            error_log('Datos de la bibliografía: ' . print_r($bibliografia, true));

            return $this->render($response, 'bibliografias_declaradas/show.twig', [
                'bibliografia' => $bibliografia,
                'asignaturas_vinculadas' => $asignaturas_vinculadas,
                'app_url' => Config::get('app_url'),
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
     * Muestra el formulario para editar una bibliografía declarada.
     */
    public function edit($id, Request $request = null, Response $response = null): Response
    {
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

            $autores = Autor::orderBy('apellidos')->get();
            $editoriales = BibliografiaDeclarada::distinct()->pluck('editorial')->filter();
            $revistas = Articulo::distinct()->pluck('titulo_revista')->filter();
            $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();

            // Obtener mensajes de sesión y limpiarlos
            $swal = $this->session->get('swal');
            $this->session->remove('swal');

            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'bibliografia' => $bibliografia,
                'autores' => $autores,
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'carreras' => $carreras,
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
    public function update($id, Request $request = null, Response $response = null): Response
    {
        try {
            error_log('=== INICIO MÉTODO UPDATE ===');
        error_log('ID recibido: ' . $id);
            
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para acceder a las bibliografías',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
                return $response;
            }
        
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        
            // Verificar si es una petición AJAX
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
            error_log('Es petición AJAX: ' . ($isAjax ? 'Sí' : 'No'));

            // Obtener los datos del cuerpo de la petición
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
            error_log('Datos JSON recibidos: ' . print_r($data, true));

            if (!$data) {
                throw new \Exception('No se recibieron datos válidos');
            }

            // Verificar que la bibliografía existe
            $stmt = $this->pdo->prepare("SELECT id FROM bibliografias_declaradas WHERE id = ?");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                throw new \Exception('La bibliografía no existe');
            }

            // Obtener los autores
            $autores = json_decode($data['autores'] ?? '[]', true);
            error_log('Autores decodificados: ' . print_r($autores, true));

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
                    $data['estado'] ?? 1,
                    $id
                ];
                
                error_log('Parámetros para actualización base: ' . print_r($params, true));
                $stmt->execute($params);

                // Eliminar todas las vinculaciones de autores existentes
                $stmt = $this->pdo->prepare("DELETE FROM bibliografias_autores WHERE bibliografia_id = ?");
                $stmt->execute([$id]);
                error_log('Vinculaciones de autores eliminadas');

                // Procesar autores
                if (!empty($autores)) {
                    foreach ($autores as $autor) {
                        error_log('Procesando autor: ' . print_r($autor, true));
                        
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
                            error_log('Nuevo autor insertado con ID: ' . $autorId);
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
                        error_log('Autor vinculado con ID: ' . $autorId);
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
                            UPDATE tesis SET carrera_id = ? WHERE bibliografia_id = ?
                        ");
                        $stmt->execute([$data['carrera_id'] ?? null, $id]);
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
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Bibliografía actualizada correctamente',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);
                return $response;

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                $this->pdo->rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            error_log('Error en BibliografiaDeclaradaController::update: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            // Enviar respuesta de error
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Ha ocurrido un error al actualizar la bibliografía: ' . $e->getMessage()
            ]);
            return $response;
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
    public function destroy($id = null, Request $request = null, Response $response = null): Response
    {
        try {
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
            
            error_log('Error en destroy: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());

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
    public function vincular($id = null, Request $request = null, Response $response = null): Response
    {
        error_log('Iniciando método vincular con ID: ' . $id);
        error_log('URL de la aplicación: ' . Config::get('app_url'));
        error_log('Ruta base: ' . $_SERVER['REQUEST_URI']);
        
        // Limpiar mensajes de error anteriores
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
        
        if (!$id) {
            $id = $_GET['id'] ?? null;
            error_log('ID obtenido de GET: ' . $id);
        }

        if (!$id) {
            error_log('Error: ID de bibliografía no proporcionado');
            $_SESSION['error'] = 'ID de bibliografía no proporcionado';
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        try {
            error_log('Obteniendo bibliografía completa para ID: ' . $id);
            // Obtener la bibliografía con sus datos específicos
            $bibliografia = $this->obtenerBibliografiaCompleta($id);
            if (!$bibliografia) {
                error_log('Error: Bibliografía no encontrada para ID: ' . $id);
                throw new \Exception('Bibliografía no encontrada');
            }
            error_log('Bibliografía obtenida: ' . print_r($bibliografia, true));

            // Obtener la estructura jerárquica de sedes, facultades y departamentos
            error_log('Obteniendo estructura jerárquica');
            $stmt = $this->pdo->query("
                SELECT 
                    s.id as sede_id,
                    s.nombre as sede_nombre,
                    f.id as facultad_id,
                    f.nombre as facultad_nombre,
                    d.id as departamento_id,
                    d.nombre as departamento_nombre
                FROM sedes s
                LEFT JOIN facultades f ON f.sede_id = s.id
                LEFT JOIN departamentos d ON d.facultad_id = f.id
                ORDER BY s.nombre, f.nombre, d.nombre
            ");
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Organizar los resultados en una estructura jerárquica
            $sedes = [];
            foreach ($resultados as $row) {
                if (!isset($sedes[$row['sede_id']])) {
                    $sedes[$row['sede_id']] = [
                        'id' => $row['sede_id'],
                        'nombre' => $row['sede_nombre'],
                        'facultades' => []
                    ];
                }
                
                if ($row['facultad_id'] && !isset($sedes[$row['sede_id']]['facultades'][$row['facultad_id']])) {
                    $sedes[$row['sede_id']]['facultades'][$row['facultad_id']] = [
                        'id' => $row['facultad_id'],
                        'nombre' => $row['facultad_nombre'],
                        'departamentos' => []
                    ];
                }
                
                if ($row['departamento_id']) {
                    $sedes[$row['sede_id']]['facultades'][$row['facultad_id']]['departamentos'][] = [
                        'id' => $row['departamento_id'],
                        'nombre' => $row['departamento_nombre']
                    ];
                }
            }
            
            // Convertir el array asociativo a array indexado
            $sedes = array_values($sedes);
            foreach ($sedes as &$sede) {
                $sede['facultades'] = array_values($sede['facultades']);
            }
            
            error_log('Estructura jerárquica obtenida: ' . print_r($sedes, true));

            // Obtener las asignaturas vinculadas
            error_log('Obteniendo asignaturas vinculadas');
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
            error_log('Asignaturas vinculadas obtenidas: ' . print_r($asignaturas_vinculadas, true));

            // Obtener los filtros de la URL
            $filtros = [
                'departamento' => $_GET['departamento'] ?? null,
                'tipo_asignatura' => $_GET['tipo_asignatura'] ?? null
            ];
            error_log('Filtros aplicados: ' . print_r($filtros, true));

            // Obtener las asignaturas disponibles
            error_log('Obteniendo asignaturas disponibles');
            $asignaturas_disponibles = $this->obtenerAsignaturasDisponibles($id, $filtros);
            error_log('Asignaturas disponibles obtenidas: ' . print_r($asignaturas_disponibles, true));

            // Crear una nueva respuesta si no se proporciona una
            if (!$response) {
                error_log('Creando nueva respuesta');
                $response = new Response();
            }

            error_log('Renderizando vista vincular.twig');
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
     * Obtiene las asignaturas disponibles para vincular.
     */
    private function obtenerAsignaturasDisponibles($bibliografiaId, $filtros = [])
    {
        $sql = "
            SELECT DISTINCT 
                a.id, 
                a.nombre,
                GROUP_CONCAT(DISTINCT TRIM(ad.codigo_asignatura) ORDER BY TRIM(ad.codigo_asignatura) SEPARATOR ', ') as codigos
            FROM asignaturas a
            INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            INNER JOIN departamentos d ON ad.departamento_id = d.id
            INNER JOIN facultades f ON d.facultad_id = f.id
            INNER JOIN sedes s ON f.sede_id = s.id
            WHERE a.id NOT IN (
                SELECT asignatura_id 
                FROM asignaturas_bibliografias 
                WHERE bibliografia_id = :bibliografia_id
            )
            AND a.tipo != 'formacion_electiva'
        ";

        $params = [':bibliografia_id' => $bibliografiaId];

        // Aplicar filtros
        if (!empty($filtros['departamento'])) {
            $sql .= " AND ad.departamento_id = :departamento_id";
            $params[':departamento_id'] = $filtros['departamento'];
        }
        if (!empty($filtros['tipo_asignatura'])) {
            $sql .= " AND a.tipo = :tipo_asignatura";
            $params[':tipo_asignatura'] = $filtros['tipo_asignatura'];
        }

        $sql .= " GROUP BY a.id, a.nombre";
        $sql .= " ORDER BY MIN(TRIM(ad.codigo_asignatura)), a.nombre";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vincula una asignatura a la bibliografía.
     */
    public function vincularSingle($id = null, Request $request = null, Response $response = null): Response
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
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['asignatura_id']) || !isset($data['tipo_bibliografia'])) {
                throw new \Exception('Faltan datos requeridos');
            }

            $this->pdo->beginTransaction();

            // Verificar si ya existe la vinculación
            $stmt = $this->pdo->prepare("
                SELECT id FROM bibliografias_asignaturas 
                WHERE bibliografia_id = ? AND asignatura_id = ?
            ");
            $stmt->execute([$id, $data['asignatura_id']]);
            
            if ($stmt->fetch()) {
                throw new \Exception('La asignatura ya está vinculada a esta bibliografía');
            }

            // Insertar la vinculación
            $stmt = $this->pdo->prepare("
                INSERT INTO bibliografias_asignaturas (bibliografia_id, asignatura_id, tipo_bibliografia)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $id,
                $data['asignatura_id'],
                $data['tipo_bibliografia']
            ]);

            $this->pdo->commit();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Asignatura vinculada exitosamente'
            ]);
            exit;

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al vincular la asignatura: ' . $e->getMessage()
            ]);
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
    public function vincularMultiple($id)
    {
        try {
            // Obtener los datos del cuerpo de la petición
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!isset($data['asignaturas']) || !is_array($data['asignaturas'])) {
                throw new Exception('Datos de asignaturas no válidos');
            }

            $this->pdo->beginTransaction();
            
            $vinculadas = 0;
            $errores = [];

            foreach ($data['asignaturas'] as $asignatura) {
                try {
                    // Verificar si ya existe la vinculación
                    $stmt = $this->pdo->prepare("
                        SELECT COUNT(*) 
                        FROM asignaturas_bibliografias 
                        WHERE bibliografia_id = ? AND asignatura_id = ?
                    ");
                    $stmt->execute([$id, $asignatura['asignatura_id']]);
                    
                    if ($stmt->fetchColumn() > 0) {
                        $errores[] = "La asignatura {$asignatura['asignatura_id']} ya está vinculada";
                        continue;
                    }

                    // Insertar la vinculación
                    $stmt = $this->pdo->prepare("
                        INSERT INTO asignaturas_bibliografias 
                        (bibliografia_id, asignatura_id, tipo_bibliografia) 
                        VALUES (?, ?, ?)
                    ");
                    $stmt->execute([
                        $id,
                        $asignatura['asignatura_id'],
                        $asignatura['tipo_bibliografia']
                    ]);
                    
                    $vinculadas++;
                } catch (Exception $e) {
                    $errores[] = "Error al vincular asignatura {$asignatura['asignatura_id']}: " . $e->getMessage();
                }
            }

            $this->pdo->commit();
            
            $mensaje = "Se vincularon {$vinculadas} asignaturas exitosamente.";
                if (!empty($errores)) {
                $mensaje .= " Errores: " . implode(", ", $errores);
            }
            
            echo json_encode([
                'success' => true,
                'message' => $mensaje
            ]);
            
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo json_encode([
                'success' => false,
                'message' => 'Error al vincular las asignaturas: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Desvincula múltiples asignaturas de la bibliografía.
     */
    public function desvincularMultiple($id = null, Request $request = null, Response $response = null): Response
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
            $data = json_decode(file_get_contents('php://input'), true);
            
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

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Asignaturas desvinculadas exitosamente'
            ]);
            exit;

        } catch (\Exception $e) {
            if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al desvincular las asignaturas: ' . $e->getMessage()
            ]);
            exit;
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
                    SELECT t.carrera_id, c.nombre as carrera_nombre
                    FROM tesis t
                    LEFT JOIN carreras c ON t.carrera_id = c.id
                    WHERE t.bibliografia_id = :id
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
            error_log('Renderizando plantilla: ' . $template);
            error_log('Datos pasados a la plantilla: ' . print_r($data, true));
            
            // Crear una nueva respuesta si no se proporciona una
            if (!$response) {
                $response = new Response();
            }
            
        // Agregar variables globales a la plantilla
        $data['app_url'] = Config::get('app_url');
        $data['session'] = $_SESSION;
        $data['current_page'] = 'bibliografias-declaradas';
        
        // Renderizar la plantilla
        $content = $this->twig->render($template, $data);
            error_log('Plantilla renderizada correctamente');
        
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

    protected function jsonResponse($data)
    {
        error_log("=== INICIO JSON RESPONSE ===");
        error_log("Datos a enviar: " . print_r($data, true));
        
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Asegurar que no haya salida antes de los headers
        if (headers_sent($file, $line)) {
            error_log("Headers ya enviados en $file:$line");
            return;
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
            error_log("Error al codificar JSON: " . json_last_error_msg());
            $json = json_encode([
                'success' => false,
                'message' => 'Error al procesar la respuesta: ' . json_last_error_msg()
            ]);
        }
        
        error_log("JSON a enviar: " . $json);
        
        // Enviar la respuesta
        echo $json;
        error_log("=== FIN JSON RESPONSE ===");
        exit;
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
            error_log('Error al obtener editoriales: ' . $e->getMessage());
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
            error_log('Error al obtener revistas: ' . $e->getMessage());
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
            error_log('Error al obtener autores: ' . $e->getMessage());
            return [];
        }
    }
} 