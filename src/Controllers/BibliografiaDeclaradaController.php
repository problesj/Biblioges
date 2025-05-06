<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use PDO;
use PDOException;
use App\Core\Config;

class BibliografiaDeclaradaController
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
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las bibliografías');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Obtener filtros de la URL
        $filtros = [
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

        // Obtener todas las asignaturas para el filtro
        $asignaturas = $this->pdo->query("
            SELECT id, nombre 
            FROM asignaturas 
            ORDER BY nombre
        ")->fetchAll();

        // Construir la consulta base
        $sql = "
            SELECT 
                b.id,
                b.titulo,
                b.tipo,
                b.anio_publicacion,
                b.estado as estado_bibliografia,
                COALESCE(
                    GROUP_CONCAT(
                        DISTINCT CONCAT(a.nombre, ' (', a.tipo, ')')
                        SEPARATOR '; '
                    ),
                    'Sin asignaturas'
                ) as asignaturas_vinculadas,
                COALESCE(
                    GROUP_CONCAT(CONCAT(au.apellidos, ', ', au.nombres) SEPARATOR '; '),
                    'Sin información'
                ) as autores
            FROM bibliografias_declaradas b 
            LEFT JOIN asignaturas_bibliografias ab ON b.id = ab.bibliografia_id
            LEFT JOIN asignaturas a ON ab.asignatura_id = a.id 
            LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
            LEFT JOIN autores au ON ba.autor_id = au.id
        ";

        // Agregar condiciones de filtro
        $where = [];
        $params = [];

        if (!empty($filtros['asignatura'])) {
            $where[] = "a.id = :asignatura_id";
            $params[':asignatura_id'] = $filtros['asignatura'];
        }

        if (!empty($filtros['tipo'])) {
            $where[] = "b.tipo = :tipo";
            $params[':tipo'] = $filtros['tipo'];
        }

        if ($filtros['estado'] !== '') {
            $where[] = "b.estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }

        // Agregar condiciones WHERE si existen
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        // Agregar GROUP BY
        $sql .= " GROUP BY b.id, b.titulo, b.tipo, b.anio_publicacion, b.estado";

        // Agregar ORDER BY con ordenamiento por defecto
        if (empty($_GET['orden'])) {
            $sql .= " ORDER BY b.titulo ASC, autores ASC, b.anio_publicacion DESC";
        } else {
            $sql .= " ORDER BY b." . $filtros['orden'] . " " . $filtros['direccion'];
        }

        // Preparar y ejecutar la consulta
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $bibliografias = $stmt->fetchAll();

        // Obtener datos del usuario
        $user_id = $this->session->get('user_id');
        $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql_user);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        // Renderizar la vista
        echo $this->twig->render('bibliografias/index.twig', [
            'bibliografias' => $bibliografias,
            'asignaturas' => $asignaturas,
            'filtros' => $filtros,
            'app_url' => Config::get('app_url'),
            'user' => $user,
            'session' => $_SESSION
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva bibliografía declarada.
     */
    public function create(Request $request, Response $response): Response
    {
        $autores = Autor::where('estado', true)->get();
        $asignaturas = Asignatura::where('estado', true)->get();

        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'autores' => $autores,
            'asignaturas' => $asignaturas
        ]);
    }

    /**
     * Almacena una nueva bibliografía declarada.
     */
    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try {
            $bibliografia = new BibliografiaDeclarada();
            $bibliografia->titulo = $data['titulo'];
            $bibliografia->tipo = $data['tipo'];
            $bibliografia->anio_publicacion = $data['anio_publicacion'];
            $bibliografia->editorial = $data['editorial'];
            $bibliografia->isbn = $data['isbn'];
            $bibliografia->doi = $data['doi'];
            $bibliografia->url = $data['url'];
            $bibliografia->asignatura_id = $data['asignatura_id'];
            $bibliografia->estado = true;
            $bibliografia->save();

            // Asociar autores
            if (isset($data['autores']) && is_array($data['autores'])) {
                $bibliografia->autores()->attach($data['autores']);
            }

            return $response->withHeader('Location', '/bibliografias-declaradas')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'error' => 'Error al crear la bibliografía declarada: ' . $e->getMessage(),
                'autores' => Autor::where('estado', true)->get(),
                'asignaturas' => Asignatura::where('estado', true)->get(),
                'data' => $data
            ]);
        }
    }

    /**
     * Muestra los detalles de una bibliografía declarada.
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $bibliografia = BibliografiaDeclarada::with(['autores', 'asignatura'])
            ->findOrFail($args['id']);

        return $this->render($response, 'bibliografias_declaradas/show.twig', [
            'bibliografia' => $bibliografia
        ]);
    }

    /**
     * Muestra el formulario para editar una bibliografía declarada.
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $bibliografia = BibliografiaDeclarada::with('autores')->findOrFail($args['id']);
        $autores = Autor::where('estado', true)->get();
        $asignaturas = Asignatura::where('estado', true)->get();

        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'bibliografia' => $bibliografia,
            'autores' => $autores,
            'asignaturas' => $asignaturas
        ]);
    }

    /**
     * Actualiza una bibliografía declarada existente.
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        try {
            $bibliografia = BibliografiaDeclarada::findOrFail($args['id']);
            $bibliografia->titulo = $data['titulo'];
            $bibliografia->tipo = $data['tipo'];
            $bibliografia->anio_publicacion = $data['anio_publicacion'];
            $bibliografia->editorial = $data['editorial'];
            $bibliografia->isbn = $data['isbn'];
            $bibliografia->doi = $data['doi'];
            $bibliografia->url = $data['url'];
            $bibliografia->asignatura_id = $data['asignatura_id'];
            $bibliografia->estado = isset($data['estado']);
            $bibliografia->save();

            // Actualizar autores
            if (isset($data['autores']) && is_array($data['autores'])) {
                $bibliografia->autores()->sync($data['autores']);
            }

            return $response->withHeader('Location', '/bibliografias-declaradas')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'error' => 'Error al actualizar la bibliografía declarada: ' . $e->getMessage(),
                'bibliografia' => BibliografiaDeclarada::find($args['id']),
                'autores' => Autor::where('estado', true)->get(),
                'asignaturas' => Asignatura::where('estado', true)->get(),
                'data' => $data
            ]);
        }
    }

    /**
     * Elimina una bibliografía declarada.
     */
    public function destroy(Request $request, Response $response, array $args): Response
    {
        try {
            $bibliografia = BibliografiaDeclarada::findOrFail($args['id']);
            $bibliografia->delete();

            return $response->withHeader('Location', '/bibliografias-declaradas')
                ->withStatus(302);
        } catch (\Exception $e) {
            return $this->render($response, 'bibliografias_declaradas/index.twig', [
                'error' => 'Error al eliminar la bibliografía declarada: ' . $e->getMessage(),
                'bibliografias' => BibliografiaDeclarada::with(['autores', 'asignatura'])->get()
            ]);
        }
    }
} 