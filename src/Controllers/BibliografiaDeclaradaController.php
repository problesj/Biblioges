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
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las bibliografías');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

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
        $query = BibliografiaDeclarada::with([
            'autores',
            'asignaturas.departamentos.facultad.sede'
        ]);

        // Aplicar filtros de búsqueda
        if (!empty($filtros['busqueda'])) {
            $busqueda = '%' . $filtros['busqueda'] . '%';
            switch ($filtros['tipo_busqueda']) {
                case 'titulo':
                    $query->where('titulo', 'LIKE', $busqueda);
                    break;
                case 'autor':
                    $query->whereHas('autores', function($q) use ($busqueda) {
                        $q->where(function($q) use ($busqueda) {
                            $q->where('nombres', 'LIKE', $busqueda)
                              ->orWhere('apellidos', 'LIKE', $busqueda);
                        });
                    });
                    break;
                case 'editorial':
                    $query->where('editorial', 'LIKE', $busqueda);
                    break;
                default: // 'todos'
                    $query->where(function($q) use ($busqueda) {
                        $q->where('titulo', 'LIKE', $busqueda)
                          ->orWhere('editorial', 'LIKE', $busqueda)
                          ->orWhereHas('autores', function($q) use ($busqueda) {
                              $q->where(function($q) use ($busqueda) {
                                  $q->where('nombres', 'LIKE', $busqueda)
                                    ->orWhere('apellidos', 'LIKE', $busqueda);
                              });
                          });
                    });
                    break;
            }
        }

        // Aplicar otros filtros
        if (!empty($filtros['asignatura'])) {
            $query->whereHas('asignaturas', function($q) use ($filtros) {
                $q->where('asignaturas.id', $filtros['asignatura']);
            });
        }
        if (!empty($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }
        if (!empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado'] === 'A');
        }

        // Aplicar ordenamiento
        $query->orderBy($filtros['orden'], $filtros['direccion']);

        // Obtener resultados
        $bibliografias = $query->get();

        // Obtener todas las asignaturas para el filtro
        $asignaturas = Asignatura::where('estado', true)->orderBy('nombre')->get();

        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

        // Renderizar la vista
        return $this->render($response, 'bibliografias_declaradas/index.twig', [
            'bibliografias' => $bibliografias,
            'asignaturas' => $asignaturas,
            'filtros' => $filtros,
            'app_url' => Config::get('app_url')
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva bibliografía declarada.
     */
    public function create(Request $request = null, Response $response = null): Response
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las bibliografías');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        $autores = Autor::orderBy('apellidos')->get();
        $editoriales = BibliografiaDeclarada::distinct()->pluck('editorial')->filter();
        $revistas = Articulo::distinct()->pluck('titulo_revista')->filter();
        $carreras = Carrera::where('estado', true)->orderBy('nombre')->get();

        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

        // Renderizar la vista
        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'bibliografia' => new BibliografiaDeclarada(),
            'autores' => $autores,
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'carreras' => $carreras,
            'app_url' => Config::get('app_url')
        ]);
    }

    /**
     * Almacena una nueva bibliografía declarada.
     */
    public function store(Request $request = null, Response $response = null): Response
    {
        error_log('Iniciando método store()');
        
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            error_log('Usuario no autenticado');
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Por favor inicie sesión para continuar',
                    'redirect' => Config::get('app_url') . 'login'
                ]);
                exit;
            }
            $this->session->set('error', 'Por favor inicie sesión para acceder a las bibliografías');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        error_log('Usuario autenticado: ' . $this->session->get('user_id'));
        
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        error_log('Es petición AJAX: ' . ($isAjax ? 'Sí' : 'No'));
        
        try {
            error_log('Iniciando transacción');
            $this->pdo->beginTransaction();
            
            $data = $_POST;
            error_log('Datos recibidos: ' . print_r($data, true));
            
            // Verificar si ya existe una bibliografía con el mismo título
            $stmt = $this->pdo->prepare("SELECT id FROM bibliografias_declaradas WHERE titulo = :titulo");
            $stmt->execute([':titulo' => $data['titulo']]);
            if ($stmt->fetch()) {
                throw new \Exception('Ya existe una bibliografía con el mismo título.');
            }
            
            // Crear la bibliografía
            $stmt = $this->pdo->prepare("
                INSERT INTO bibliografias_declaradas (
                    titulo, tipo, anio_publicacion, editorial, edicion, 
                    url, nota, formato, estado
                ) VALUES (
                    :titulo, :tipo, :anio_publicacion, :editorial, :edicion,
                    :url, :nota, :formato, :estado
                )
            ");

            // Determinar el valor de la editorial
            $editorial = $data['editorial'];
            if ($editorial === 'otra' && !empty($data['nueva_editorial'])) {
                $editorial = $data['nueva_editorial'];
            }

            $params = [
                ':titulo' => $data['titulo'],
                ':tipo' => $data['tipo'],
                ':anio_publicacion' => $data['anio_publicacion'],
                ':editorial' => $editorial,
                ':edicion' => $data['edicion'] ?? null,
                ':url' => $data['url'] ?? null,
                ':nota' => $data['nota'] ?? null,
                ':formato' => $data['formato'] ?? null,
                ':estado' => true
            ];
            
            error_log('Ejecutando inserción con parámetros: ' . print_r($params, true));
            $stmt->execute($params);

            $bibliografiaId = $this->pdo->lastInsertId();
            error_log('ID de bibliografía creada: ' . $bibliografiaId);

            // Procesar autores
            if (isset($data['autores'])) {
                $autores = json_decode($data['autores'], true);
                error_log('Autores a guardar: ' . print_r($autores, true));
                
                if (is_array($autores)) {
                    foreach ($autores as $autor) {
                        // Verificar si el autor es nuevo (tiene ID temporal)
                        if (strpos($autor['id'], 'temp_') === 0) {
                            // Verificar si ya existe un autor con el mismo nombre y apellido
                            $stmt = $this->pdo->prepare("
                                SELECT id FROM autores 
                                WHERE apellidos = :apellidos 
                                AND nombres = :nombres
                            ");
                            
                            $stmt->execute([
                                ':apellidos' => $autor['apellidos'],
                                ':nombres' => $autor['nombres']
                            ]);
                            
                            $autorExistente = $stmt->fetch();
                            
                            if ($autorExistente) {
                                $autorId = $autorExistente['id'];
                            } else {
                                // Insertar nuevo autor
                                $stmt = $this->pdo->prepare("
                                    INSERT INTO autores (apellidos, nombres, genero)
                                    VALUES (:apellidos, :nombres, :genero)
                                ");
                                
                                $stmt->execute([
                                    ':apellidos' => $autor['apellidos'],
                                    ':nombres' => $autor['nombres'],
                                    ':genero' => ucfirst(strtolower($autor['genero']))
                                ]);
                                
                                $autorId = $this->pdo->lastInsertId();
                            }
                        } else {
                            $autorId = $autor['id'];
                        }

                        // Vincular autor con la bibliografía
                        $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_autores (bibliografia_id, autor_id)
                            VALUES (:bibliografia_id, :autor_id)
                        ");

                        $stmt->execute([
                            ':bibliografia_id' => $bibliografiaId,
                            ':autor_id' => $autorId
                        ]);
                    }
                }
            }

            // Procesar datos específicos según el tipo
            switch ($data['tipo']) {
                case 'libro':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO libros (bibliografia_id, isbn)
                        VALUES (:bibliografia_id, :isbn)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':isbn' => $data['isbn'] ?? null
                    ]);
                    break;

                case 'tesis':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO tesis (bibliografia_id, carrera_id)
                        VALUES (:bibliografia_id, :carrera_id)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':carrera_id' => $data['carrera_id'] ?? null
                    ]);
                    break;

                case 'articulo':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO articulos (bibliografia_id, issn, titulo_revista, cronologia)
                        VALUES (:bibliografia_id, :issn, :titulo_revista, :cronologia)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':issn' => $data['issn'] ?? null,
                        ':titulo_revista' => $data['titulo_revista'] === 'otra' ? $data['nueva_revista'] : $data['titulo_revista'],
                        ':cronologia' => $data['cronologia'] ?? null
                    ]);
                    break;

                case 'generico':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO genericos (bibliografia_id, descripcion)
                        VALUES (:bibliografia_id, :descripcion)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':descripcion' => $data['descripcion'] ?? null
                    ]);
                    break;

                case 'sitio_web':
                    error_log('Procesando sitio web. Datos recibidos: ' . print_r($data, true));
                    if (empty($data['fecha_consulta'])) {
                        error_log('Error: fecha_consulta está vacía');
                        throw new \Exception('La fecha de consulta es requerida para sitios web.');
                    }
                    error_log('Fecha de consulta: ' . $data['fecha_consulta']);
                    $stmt = $this->pdo->prepare("
                        INSERT INTO sitios_web (bibliografia_id, fecha_consulta)
                        VALUES (:bibliografia_id, :fecha_consulta)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':fecha_consulta' => $data['fecha_consulta']
                    ]);
                    error_log('Sitio web insertado correctamente');
                    break;

                case 'software':
                    $stmt = $this->pdo->prepare("
                        INSERT INTO software (bibliografia_id, version)
                        VALUES (:bibliografia_id, :version)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $bibliografiaId,
                        ':version' => $data['version'] ?? null
                    ]);
                    break;
            }

            error_log('Confirmando transacción');
            $this->pdo->commit();

            if ($isAjax) {
                error_log('Enviando respuesta AJAX');
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Bibliografía declarada creada exitosamente.',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);
                exit;
            }

            $this->flash->addMessage('success', 'Bibliografía declarada creada exitosamente.');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;

        } catch (\Exception $e) {
            error_log('Error en store(): ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            
            $this->pdo->rollBack();

            if ($isAjax) {
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear la bibliografía: ' . $e->getMessage()
                ]);
                exit;
            }

            $this->flash->addMessage('error', 'Error al crear la bibliografía: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/create');
            exit;
        }
    }

    /**
     * Muestra los detalles de una bibliografía declarada.
     */
    public function show($id = null, Request $request = null, Response $response = null): Response
    {
        if (!$id) {
            $id = $_GET['id'] ?? null;
        }
        
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        // Obtener la bibliografía con sus relaciones
        $stmt = $this->pdo->prepare("
            SELECT b.*, 
                   l.isbn,
                   t.carrera_id,
                   a.issn, a.titulo_revista, a.cronologia,
                   g.descripcion,
                   sw.fecha_consulta,
                   s.version,
                   c.nombre as carrera_nombre
            FROM bibliografias_declaradas b
            LEFT JOIN libros l ON b.id = l.bibliografia_id
            LEFT JOIN tesis t ON b.id = t.bibliografia_id
            LEFT JOIN articulos a ON b.id = a.bibliografia_id
            LEFT JOIN genericos g ON b.id = g.bibliografia_id
            LEFT JOIN sitios_web sw ON b.id = sw.bibliografia_id
            LEFT JOIN software s ON b.id = s.bibliografia_id
            LEFT JOIN carreras c ON t.carrera_id = c.id
            WHERE b.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bibliografia) {
            $this->flash->addMessage('error', 'Bibliografía no encontrada');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        // Obtener los autores de la bibliografía
        $stmt = $this->pdo->prepare("
            SELECT a.* 
            FROM autores a
            JOIN bibliografias_autores ba ON a.id = ba.autor_id
            WHERE ba.bibliografia_id = :bibliografia_id
            ORDER BY a.apellidos, a.nombres
        ");
        $stmt->execute([':bibliografia_id' => $id]);
        $bibliografia['autores'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

        // Renderizar la vista
            return $this->render($response, 'bibliografias_declaradas/show.twig', [
                'bibliografia' => $bibliografia,
                'app_url' => Config::get('app_url')
            ]);
    }

    /**
     * Muestra el formulario para editar una bibliografía declarada.
     */
    public function edit($id, Request $request = null, Response $response = null): Response
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las bibliografías');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Obtener la bibliografía con sus relaciones
        $stmt = $this->pdo->prepare("
            SELECT b.*, 
                   l.isbn,
                   t.carrera_id,
                   a.issn, a.titulo_revista, a.cronologia,
                   g.descripcion,
                   sw.fecha_consulta,
                   s.version
            FROM bibliografias_declaradas b
            LEFT JOIN libros l ON b.id = l.bibliografia_id
            LEFT JOIN tesis t ON b.id = t.bibliografia_id
            LEFT JOIN articulos a ON b.id = a.bibliografia_id
            LEFT JOIN genericos g ON b.id = g.bibliografia_id
            LEFT JOIN sitios_web sw ON b.id = sw.bibliografia_id
            LEFT JOIN software s ON b.id = s.bibliografia_id
            WHERE b.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bibliografia) {
            $this->flash->addMessage('error', 'Bibliografía no encontrada');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        // Obtener los autores de la bibliografía
        $stmt = $this->pdo->prepare("
            SELECT a.* 
            FROM autores a
            JOIN bibliografias_autores ba ON a.id = ba.autor_id
            WHERE ba.bibliografia_id = :bibliografia_id
        ");
        $stmt->execute([':bibliografia_id' => $id]);
        $autoresSeleccionados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener todos los autores para el selector
        $stmt = $this->pdo->prepare("SELECT * FROM autores ORDER BY apellidos, nombres");
        $stmt->execute();
        $todosAutores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener editoriales existentes
        $stmt = $this->pdo->prepare("SELECT DISTINCT editorial FROM bibliografias_declaradas WHERE editorial IS NOT NULL ORDER BY editorial");
        $stmt->execute();
        $editoriales = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Obtener revistas existentes
        $stmt = $this->pdo->prepare("SELECT DISTINCT titulo_revista FROM articulos WHERE titulo_revista IS NOT NULL ORDER BY titulo_revista");
        $stmt->execute();
        $revistas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Obtener carreras
        $stmt = $this->pdo->prepare("SELECT * FROM carreras WHERE estado = 1 ORDER BY nombre");
        $stmt->execute();
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

        // Renderizar la vista
            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'bibliografia' => $bibliografia,
            'autores' => $todosAutores,
            'autoresSeleccionados' => $autoresSeleccionados,
            'editoriales' => $editoriales,
            'revistas' => $revistas,
            'carreras' => $carreras,
            'isEdit' => true,
                'app_url' => Config::get('app_url')
            ]);
    }

    /**
     * Actualiza una bibliografía declarada.
     */
    public function update($id, Request $request = null, Response $response = null): Response
    {
        $data = $request ? $request->getParsedBody() : $_POST;
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        try {
            $this->pdo->beginTransaction();

            // Verificar si existe otra bibliografía con el mismo título (excluyendo la actual)
            $stmt = $this->pdo->prepare("
                SELECT id FROM bibliografias_declaradas 
                WHERE titulo = :titulo AND id != :id
            ");
            $stmt->execute([
                ':titulo' => $data['titulo'],
                ':id' => $id
            ]);
            
            if ($stmt->fetch()) {
                throw new \Exception('Ya existe una bibliografía con el mismo título.');
            }

            // Actualizar la bibliografía
            $stmt = $this->pdo->prepare("
                UPDATE bibliografias_declaradas 
                SET titulo = :titulo,
                    tipo = :tipo,
                    anio_publicacion = :anio_publicacion,
                    editorial = :editorial,
                    edicion = :edicion,
                    url = :url,
                    nota = :nota,
                    formato = :formato
                WHERE id = :id
            ");

            // Determinar el valor de la editorial
            $editorial = $data['editorial'];
            if ($editorial === 'otra' && !empty($data['nueva_editorial'])) {
                $editorial = $data['nueva_editorial'];
            }

            $params = [
                ':id' => $id,
                ':titulo' => $data['titulo'],
                ':tipo' => $data['tipo'],
                ':anio_publicacion' => $data['anio_publicacion'],
                ':editorial' => $editorial,
                ':edicion' => $data['edicion'] ?? null,
                ':url' => $data['url'] ?? null,
                ':nota' => $data['nota'] ?? null,
                ':formato' => $data['formato'] ?? null
            ];

            $stmt->execute($params);

            // Actualizar los detalles específicos según el tipo
            switch ($data['tipo']) {
                case 'libro':
                    $stmt = $this->pdo->prepare("
                        UPDATE libros 
                        SET isbn = :isbn
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':isbn' => $data['isbn'] ?? null
                    ]);
                    break;

                case 'tesis':
                    $stmt = $this->pdo->prepare("
                        UPDATE tesis 
                        SET carrera_id = :carrera_id
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':carrera_id' => $data['carrera_id'] ?? null
                    ]);
                    break;

                case 'articulo':
                    $stmt = $this->pdo->prepare("
                        UPDATE articulos 
                        SET issn = :issn,
                            titulo_revista = :titulo_revista,
                            cronologia = :cronologia
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':issn' => $data['issn'] ?? null,
                        ':titulo_revista' => $data['titulo_revista'] === 'otra' ? $data['nueva_revista'] : $data['titulo_revista'],
                        ':cronologia' => $data['cronologia'] ?? null
                    ]);
                    break;

                case 'generico':
                    $stmt = $this->pdo->prepare("
                        UPDATE genericos 
                        SET descripcion = :descripcion
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':descripcion' => $data['descripcion'] ?? null
                    ]);
                    break;

                case 'sitio_web':
                    if (empty($data['fecha_consulta'])) {
                        throw new \Exception('La fecha de consulta es requerida para sitios web.');
                    }
                    $stmt = $this->pdo->prepare("
                        UPDATE sitios_web 
                        SET fecha_consulta = :fecha_consulta
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':fecha_consulta' => $data['fecha_consulta']
                    ]);
                    break;

                case 'software':
                    $stmt = $this->pdo->prepare("
                        UPDATE software 
                        SET version = :version
                        WHERE bibliografia_id = :bibliografia_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':version' => $data['version'] ?? null
                    ]);
                    break;
            }

            // Actualizar autores
            if (isset($data['autores'])) {
                // Primero eliminar todas las relaciones existentes
                $stmt = $this->pdo->prepare("DELETE FROM bibliografias_autores WHERE bibliografia_id = :bibliografia_id");
                $stmt->execute([':bibliografia_id' => $id]);

                // Luego agregar las nuevas relaciones
                $autores = json_decode($data['autores'], true);
                if (is_array($autores)) {
                    foreach ($autores as $autor) {
                        // Verificar si el autor es nuevo (tiene ID temporal)
                        if (strpos($autor['id'], 'temp_') === 0) {
                            // Verificar si ya existe un autor con el mismo nombre y apellido
                            $stmt = $this->pdo->prepare("
                                SELECT id FROM autores 
                                WHERE apellidos = :apellidos 
                                AND nombres = :nombres
                            ");
                            
                            $stmt->execute([
                                ':apellidos' => $autor['apellidos'],
                                ':nombres' => $autor['nombres']
                            ]);
                            
                            $autorExistente = $stmt->fetch();
                            
                            if ($autorExistente) {
                                $autorId = $autorExistente['id'];
            } else {
                                // Insertar nuevo autor
                                $stmt = $this->pdo->prepare("
                                    INSERT INTO autores (apellidos, nombres, genero)
                                    VALUES (:apellidos, :nombres, :genero)
                                ");
                                
                                $stmt->execute([
                                    ':apellidos' => $autor['apellidos'],
                                    ':nombres' => $autor['nombres'],
                                    ':genero' => ucfirst(strtolower($autor['genero']))
                                ]);
                                
                                $autorId = $this->pdo->lastInsertId();
                            }
                        } else {
                            $autorId = $autor['id'];
                        }

                        // Vincular autor con la bibliografía
                        $stmt = $this->pdo->prepare("
                            INSERT INTO bibliografias_autores (bibliografia_id, autor_id)
                            VALUES (:bibliografia_id, :autor_id)
                        ");

                        $stmt->execute([
                            ':bibliografia_id' => $id,
                            ':autor_id' => $autorId
                        ]);
                    }
                }
            }

            $this->pdo->commit();

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Bibliografía actualizada exitosamente.',
                    'redirect' => Config::get('app_url') . 'bibliografias-declaradas'
                ]);
                exit;
            }

            $this->flash->addMessage('success', 'Bibliografía actualizada exitosamente.');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar la bibliografía: ' . $e->getMessage()
                ]);
                exit;
            }

            $this->flash->addMessage('error', 'Error al actualizar la bibliografía: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas/' . $id . '/edit');
            exit;
        }
    }

    /**
     * Elimina una bibliografía declarada.
     */
    public function destroy($id = null, Request $request = null, Response $response = null): Response
    {
        if (!$id) {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            $_SESSION['error'] = 'ID de bibliografía no proporcionado';
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        try {
            $this->pdo->beginTransaction();

            // Verificar si la bibliografía tiene asignaturas vinculadas
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total 
                FROM asignaturas_bibliografias 
                WHERE bibliografia_id = :id
            ");
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['total'] > 0) {
                throw new \Exception('No se puede eliminar la bibliografía porque está vinculada a una o más asignaturas.');
            }

            // Eliminar relaciones con autores (solo la relación, no los autores)
            $stmt = $this->pdo->prepare("DELETE FROM bibliografias_autores WHERE bibliografia_id = :id");
            $stmt->execute([':id' => $id]);

            // Eliminar datos específicos según el tipo
            $stmt = $this->pdo->prepare("SELECT tipo FROM bibliografias_declaradas WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($bibliografia) {
                switch ($bibliografia['tipo']) {
                    case 'libro':
                        $stmt = $this->pdo->prepare("DELETE FROM libros WHERE bibliografia_id = :id");
                        break;
                    case 'tesis':
                        $stmt = $this->pdo->prepare("DELETE FROM tesis WHERE bibliografia_id = :id");
                        break;
                    case 'articulo':
                        $stmt = $this->pdo->prepare("DELETE FROM articulos WHERE bibliografia_id = :id");
                        break;
                    case 'generico':
                        $stmt = $this->pdo->prepare("DELETE FROM genericos WHERE bibliografia_id = :id");
                        break;
                    case 'sitio_web':
                        $stmt = $this->pdo->prepare("DELETE FROM sitios_web WHERE bibliografia_id = :id");
                        break;
                    case 'software':
                        $stmt = $this->pdo->prepare("DELETE FROM software WHERE bibliografia_id = :id");
                        break;
                }
                if (isset($stmt)) {
                    $stmt->execute([':id' => $id]);
                }
            }

            // Finalmente, eliminar la bibliografía
            $stmt = $this->pdo->prepare("DELETE FROM bibliografias_declaradas WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $this->pdo->commit();
            $_SESSION['success'] = 'Bibliografía declarada eliminada exitosamente.';

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['error'] = 'Error al eliminar la bibliografía declarada: ' . $e->getMessage();
        }

        header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
        exit;
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
                    ab.id,
                    a.nombre,
                    GROUP_CONCAT(DISTINCT TRIM(ad.codigo_asignatura) ORDER BY TRIM(ad.codigo_asignatura) SEPARATOR '\n') as codigo_asignatura,
                    ab.tipo_bibliografia
                FROM asignaturas_bibliografias ab
                JOIN asignaturas a ON a.id = ab.asignatura_id
                LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
                WHERE ab.bibliografia_id = :id
                GROUP BY ab.id, a.nombre, ab.tipo_bibliografia
                ORDER BY MIN(TRIM(ad.codigo_asignatura)), a.nombre
            ");
            $stmt->execute([':id' => $id]);
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
        try {
            if (!$id) {
                return $this->jsonResponse(['success' => false, 'message' => 'ID de bibliografía no proporcionado']);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['asignatura_id']) || !isset($data['tipo_bibliografia'])) {
                return $this->jsonResponse(['success' => false, 'message' => 'Datos incompletos']);
            }

            // Verificar si la vinculación ya existe
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total 
                FROM asignaturas_bibliografias 
                WHERE bibliografia_id = :bibliografia_id 
                AND asignatura_id = :asignatura_id
            ");
            $stmt->execute([
                ':bibliografia_id' => $id,
                ':asignatura_id' => $data['asignatura_id']
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['total'] > 0) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'La asignatura ya está vinculada a esta bibliografía'
                ]);
            }

            // Crear la vinculación
            $stmt = $this->pdo->prepare("
                INSERT INTO asignaturas_bibliografias 
                (bibliografia_id, asignatura_id, tipo_bibliografia) 
                VALUES (:bibliografia_id, :asignatura_id, :tipo_bibliografia)
            ");
            $stmt->execute([
                ':bibliografia_id' => $id,
                ':asignatura_id' => $data['asignatura_id'],
                ':tipo_bibliografia' => $data['tipo_bibliografia']
            ]);

            return $this->jsonResponse([
                'success' => true,
                'message' => 'Asignatura vinculada exitosamente'
            ]);

        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error al vincular la asignatura: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Desvincula una asignatura de la bibliografía.
     */
    public function desvincularSingle($id = null, $vinculacionId = null, Request $request = null, Response $response = null): Response
    {
        if (!$id || !$vinculacionId) {
            return $this->jsonResponse(['success' => false, 'message' => 'Parámetros incompletos']);
        }

        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM asignaturas_bibliografias 
                WHERE id = :vinculacion_id 
                AND bibliografia_id = :bibliografia_id
            ");
            $stmt->execute([
                ':vinculacion_id' => $vinculacionId,
                ':bibliografia_id' => $id
            ]);

            if ($stmt->rowCount() === 0) {
                throw new \Exception('No se encontró la vinculación');
            }

            return $this->jsonResponse(['success' => true, 'message' => 'Asignatura desvinculada exitosamente']);

        } catch (\Exception $e) {
            return $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Vincula múltiples asignaturas a la bibliografía.
     */
    public function vincularMultiple($id = null, Request $request = null, Response $response = null): void
    {
        error_log('=== INICIO VINCULAR MULTIPLE ===');
        error_log('Método llamado con ID: ' . $id);
        error_log('Método HTTP: ' . $_SERVER['REQUEST_METHOD']);
        error_log('Headers recibidos: ' . print_r(getallheaders(), true));
        
        // Limpiar cualquier salida anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Asegurar que la respuesta sea JSON
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        
        try {
            if (!$id) {
                error_log('Error: ID no proporcionado');
                echo json_encode(['success' => false, 'message' => 'ID de bibliografía no proporcionado']);
                return;
            }

            // Obtener los datos JSON del cuerpo de la petición
            $rawInput = file_get_contents('php://input');
            error_log('Datos raw recibidos: ' . $rawInput);

            if (empty($rawInput)) {
                error_log('Error: No se recibieron datos en el cuerpo de la petición');
                echo json_encode(['success' => false, 'message' => 'No se recibieron datos en el cuerpo de la petición']);
                return;
            }

            // Decodificar el JSON
            $data = json_decode($rawInput, true);
            error_log('Datos decodificados: ' . print_r($data, true));
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('Error al decodificar JSON: ' . json_last_error_msg());
                echo json_encode(['success' => false, 'message' => 'Error al procesar los datos: ' . json_last_error_msg()]);
                return;
            }

            // Validar la estructura de los datos
            if (!isset($data['asignaturas']) || !is_array($data['asignaturas'])) {
                error_log('Error: No se encontraron asignaturas en los datos. Datos recibidos: ' . print_r($data, true));
                echo json_encode(['success' => false, 'message' => 'No se encontraron asignaturas para vincular']);
                return;
            }

            // Validar que cada asignatura tenga los campos requeridos
            foreach ($data['asignaturas'] as $index => $asignatura) {
                if (!isset($asignatura['asignatura_id']) || !isset($asignatura['tipo_bibliografia'])) {
                    error_log("Error: Datos incompletos en la asignatura {$index}: " . print_r($asignatura, true));
                    echo json_encode(['success' => false, 'message' => 'Datos incompletos en una o más asignaturas']);
                    return;
                }
            }

            if (empty($data['asignaturas'])) {
                error_log('Error: El array de asignaturas está vacío');
                echo json_encode(['success' => false, 'message' => 'No se proporcionaron asignaturas para vincular']);
                return;
            }

            // Verificar que la bibliografía existe
            $stmt = $this->pdo->prepare("SELECT id FROM bibliografias_declaradas WHERE id = :id");
            $stmt->execute([':id' => $id]);
            if (!$stmt->fetch()) {
                error_log('Error: Bibliografía no encontrada');
                echo json_encode(['success' => false, 'message' => 'Bibliografía no encontrada']);
                return;
            }

            // Procesar cada asignatura
            $vinculacionesExitosas = 0;
            $errores = [];

            foreach ($data['asignaturas'] as $asignatura) {
                error_log('Procesando asignatura: ' . print_r($asignatura, true));
                
                try {
                    // Verificar que la asignatura existe
                    $stmt = $this->pdo->prepare("SELECT id FROM asignaturas WHERE id = :id");
                    $stmt->execute([':id' => $asignatura['asignatura_id']]);
                    if (!$stmt->fetch()) {
                        $errores[] = "Asignatura {$asignatura['asignatura_id']} no encontrada";
                        continue;
                    }

                    // Verificar si la vinculación ya existe
                    $stmt = $this->pdo->prepare("
                        SELECT COUNT(*) as total 
                        FROM asignaturas_bibliografias 
                        WHERE bibliografia_id = :bibliografia_id 
                        AND asignatura_id = :asignatura_id
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':asignatura_id' => $asignatura['asignatura_id']
                    ]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result['total'] > 0) {
                        $errores[] = "La asignatura {$asignatura['asignatura_id']} ya está vinculada";
                        continue;
                    }

                    // Crear la vinculación
                    $stmt = $this->pdo->prepare("
                        INSERT INTO asignaturas_bibliografias 
                        (bibliografia_id, asignatura_id, tipo_bibliografia) 
                        VALUES (:bibliografia_id, :asignatura_id, :tipo_bibliografia)
                    ");
                    $stmt->execute([
                        ':bibliografia_id' => $id,
                        ':asignatura_id' => $asignatura['asignatura_id'],
                        ':tipo_bibliografia' => $asignatura['tipo_bibliografia']
                    ]);

                    $vinculacionesExitosas++;
                    error_log('Asignatura vinculada exitosamente: ' . $asignatura['asignatura_id']);
                } catch (\Exception $e) {
                    error_log('Error al vincular asignatura: ' . $e->getMessage());
                    $errores[] = "Error al vincular asignatura {$asignatura['asignatura_id']}: " . $e->getMessage();
                }
            }

            if ($vinculacionesExitosas > 0) {
                $mensaje = "Se vincularon {$vinculacionesExitosas} asignaturas correctamente.";
                if (!empty($errores)) {
                    $mensaje .= " Errores: " . implode(', ', $errores);
                }
                echo json_encode(['success' => true, 'message' => $mensaje]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo vincular ninguna asignatura. Errores: ' . implode(', ', $errores)]);
            }
        } catch (\Exception $e) {
            error_log('Error en vincularMultiple: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            echo json_encode(['success' => false, 'message' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
        exit;
    }

    /**
     * Desvincula múltiples asignaturas de la bibliografía.
     */
    public function desvincularMultiple($id = null, Request $request = null, Response $response = null): Response
    {
        if (!$id) {
            return $this->jsonResponse(['success' => false, 'message' => 'ID de bibliografía no proporcionado']);
        }

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['vinculaciones'])) {
                throw new \Exception('Datos incompletos');
            }

            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("
                DELETE FROM asignaturas_bibliografias 
                WHERE id = :vinculacion_id 
                AND bibliografia_id = :bibliografia_id
            ");

            foreach ($data['vinculaciones'] as $vinculacionId) {
                $stmt->execute([
                    ':vinculacion_id' => $vinculacionId,
                    ':bibliografia_id' => $id
                ]);
            }

            $this->pdo->commit();
            return $this->jsonResponse(['success' => true, 'message' => 'Asignaturas desvinculadas exitosamente']);

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtiene los detalles completos de una bibliografía declarada.
     */
    private function obtenerBibliografiaCompleta($id)
    {
        // Obtener la bibliografía con sus relaciones
        $stmt = $this->pdo->prepare("
            SELECT b.*, 
                   l.isbn,
                   t.carrera_id,
                   a.issn, a.titulo_revista, a.cronologia,
                   g.descripcion,
                   sw.fecha_consulta,
                   s.version,
                   c.nombre as carrera_nombre
            FROM bibliografias_declaradas b
            LEFT JOIN libros l ON b.id = l.bibliografia_id
            LEFT JOIN tesis t ON b.id = t.bibliografia_id
            LEFT JOIN articulos a ON b.id = a.bibliografia_id
            LEFT JOIN genericos g ON b.id = g.bibliografia_id
            LEFT JOIN sitios_web sw ON b.id = sw.bibliografia_id
            LEFT JOIN software s ON b.id = s.bibliografia_id
            LEFT JOIN carreras c ON t.carrera_id = c.id
            WHERE b.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $bibliografia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bibliografia) {
            return null;
        }

        // Obtener los autores de la bibliografía
        $stmt = $this->pdo->prepare("
            SELECT a.* 
            FROM autores a
            JOIN bibliografias_autores ba ON a.id = ba.autor_id
            WHERE ba.bibliografia_id = :bibliografia_id
            ORDER BY a.apellidos, a.nombres
        ");
        $stmt->execute([':bibliografia_id' => $id]);
        $bibliografia['autores'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $bibliografia;
    }

    protected function render(Response $response, string $template, array $data = []): Response
    {
        try {
            error_log('Renderizando plantilla: ' . $template);
            error_log('Datos pasados a la plantilla: ' . print_r($data, true));
            
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
        
        // Enviar la respuesta usando print
        print($json);
        error_log("=== FIN JSON RESPONSE ===");
        exit;
    }
} 