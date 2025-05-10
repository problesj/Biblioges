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

        // Aplicar filtros
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
        $asignaturas = Asignatura::where('estado', true)->orderBy('nombre')->get();

        // Crear una nueva respuesta si no se proporciona una
        if (!$response) {
            $response = new Response();
        }

        // Renderizar la vista
        return $this->render($response, 'bibliografias_declaradas/form.twig', [
            'bibliografia' => new BibliografiaDeclarada(),
            'autores' => $autores,
            'asignaturas' => $asignaturas,
            'app_url' => Config::get('app_url')
        ]);
    }

    /**
     * Almacena una nueva bibliografía declarada.
     */
    public function store(Request $request = null, Response $response = null): Response
    {
        $data = $request ? $request->getParsedBody() : $_POST;

        try {
            $bibliografia = new BibliografiaDeclarada();
            $bibliografia->titulo = $data['titulo'];
            $bibliografia->tipo = $data['tipo'];
            $bibliografia->anio_publicacion = $data['anio_publicacion'];
            $bibliografia->editorial = $data['editorial'] ?? null;
            $bibliografia->isbn = $data['isbn'] ?? null;
            $bibliografia->doi = $data['doi'] ?? null;
            $bibliografia->url = $data['url'] ?? null;
            $bibliografia->formato = $data['formato'] ?? 'impreso';
            $bibliografia->asignatura_id = $data['asignatura_id'];
            $bibliografia->estado = true;
            $bibliografia->save();

            // Asociar autores
            if (isset($data['autores']) && is_array($data['autores'])) {
                $bibliografia->autores()->attach($data['autores']);
            }

            $this->flash->addMessage('success', 'Bibliografía declarada creada exitosamente.');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        } catch (\Exception $e) {
            $this->flash->addMessage('error', 'Error al crear la bibliografía declarada: ' . $e->getMessage());
            if ($response) {
                return $this->render($response, 'bibliografias_declaradas/form.twig', [
                    'bibliografia' => new BibliografiaDeclarada($data),
                    'autores' => Autor::orderBy('apellidos')->get(),
                    'asignaturas' => Asignatura::where('estado', true)->orderBy('nombre')->get(),
                    'error' => $e->getMessage()
                ]);
            } else {
                echo $this->twig->render('bibliografias_declaradas/form.twig', [
                    'bibliografia' => new BibliografiaDeclarada($data),
                    'autores' => Autor::orderBy('apellidos')->get(),
                    'asignaturas' => Asignatura::where('estado', true)->orderBy('nombre')->get(),
                    'error' => $e->getMessage(),
                    'app_url' => Config::get('app_url')
                ]);
                return null;
            }
        }
    }

    /**
     * Muestra los detalles de una bibliografía declarada.
     */
    public function show(Request $request = null, Response $response = null, array $args = []): Response
    {
        $id = $args['id'] ?? $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        $bibliografia = BibliografiaDeclarada::with(['autores', 'asignatura.departamento.facultad.sede'])
            ->findOrFail($id);

        if ($response) {
            return $this->render($response, 'bibliografias_declaradas/show.twig', [
                'bibliografia' => $bibliografia
            ]);
        } else {
            echo $this->twig->render('bibliografias_declaradas/show.twig', [
                'bibliografia' => $bibliografia,
                'app_url' => Config::get('app_url')
            ]);
            return null;
        }
    }

    /**
     * Muestra el formulario para editar una bibliografía declarada.
     */
    public function edit(Request $request = null, Response $response = null, array $args = []): Response
    {
        $id = $args['id'] ?? $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        $bibliografia = BibliografiaDeclarada::with('autores')->findOrFail($id);
        $autores = Autor::where('estado', true)->orderBy('nombre')->get();
        $asignaturas = Asignatura::where('estado', true)->orderBy('nombre')->get();

        if ($response) {
            return $this->render($response, 'bibliografias_declaradas/form.twig', [
                'bibliografia' => $bibliografia,
                'autores' => $autores,
                'asignaturas' => $asignaturas
            ]);
        } else {
            echo $this->twig->render('bibliografias_declaradas/form.twig', [
                'bibliografia' => $bibliografia,
                'autores' => $autores,
                'asignaturas' => $asignaturas,
                'app_url' => Config::get('app_url')
            ]);
            return null;
        }
    }

    /**
     * Actualiza una bibliografía declarada existente.
     */
    public function update(Request $request = null, Response $response = null, array $args = []): Response
    {
        $id = $args['id'] ?? $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        $data = $request ? $request->getParsedBody() : $_POST;

        try {
            $bibliografia = BibliografiaDeclarada::findOrFail($id);
            $bibliografia->titulo = $data['titulo'];
            $bibliografia->tipo = $data['tipo'];
            $bibliografia->anio_publicacion = $data['anio_publicacion'];
            $bibliografia->editorial = $data['editorial'] ?? null;
            $bibliografia->isbn = $data['isbn'] ?? null;
            $bibliografia->doi = $data['doi'] ?? null;
            $bibliografia->url = $data['url'] ?? null;
            $bibliografia->asignatura_id = $data['asignatura_id'];
            $bibliografia->estado = isset($data['estado']);
            $bibliografia->save();

            // Actualizar autores
            if (isset($data['autores']) && is_array($data['autores'])) {
                $bibliografia->autores()->sync($data['autores']);
            } else {
                $bibliografia->autores()->detach();
            }

            $this->flash->addMessage('success', 'Bibliografía declarada actualizada exitosamente.');
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        } catch (\Exception $e) {
            $this->flash->addMessage('error', 'Error al actualizar la bibliografía declarada: ' . $e->getMessage());
            if ($response) {
                return $this->render($response, 'bibliografias_declaradas/form.twig', [
                    'bibliografia' => BibliografiaDeclarada::find($id),
                    'autores' => Autor::where('estado', true)->get(),
                    'asignaturas' => Asignatura::where('estado', true)->get(),
                    'error' => $e->getMessage()
                ]);
            } else {
                echo $this->twig->render('bibliografias_declaradas/form.twig', [
                    'bibliografia' => BibliografiaDeclarada::find($id),
                    'autores' => Autor::where('estado', true)->get(),
                    'asignaturas' => Asignatura::where('estado', true)->get(),
                    'error' => $e->getMessage(),
                    'app_url' => Config::get('app_url')
                ]);
                return null;
            }
        }
    }

    /**
     * Elimina una bibliografía declarada.
     */
    public function destroy(Request $request = null, Response $response = null, array $args = []): Response
    {
        $id = $args['id'] ?? $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
            exit;
        }

        try {
            $bibliografia = BibliografiaDeclarada::findOrFail($id);
            
            // Verificar si hay bibliografías disponibles asociadas
            if ($bibliografia->disponibles()->count() > 0) {
                throw new \Exception('No se puede eliminar la bibliografía porque tiene ejemplares disponibles asociados.');
            }

            // Eliminar relaciones con autores
            $bibliografia->autores()->detach();
            
            // Eliminar la bibliografía
            $bibliografia->delete();

            $this->flash->addMessage('success', 'Bibliografía declarada eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->flash->addMessage('error', 'Error al eliminar la bibliografía declarada: ' . $e->getMessage());
        }

        header('Location: ' . Config::get('app_url') . 'bibliografias-declaradas');
        exit;
    }

    protected function render(Response $response, string $template, array $data = []): Response
    {
        // Agregar variables globales a la plantilla
        $data['app_url'] = Config::get('app_url');
        $data['session'] = $_SESSION;
        $data['current_page'] = 'bibliografias-declaradas';
        
        // Renderizar la plantilla
        $content = $this->twig->render($template, $data);
        
        // Establecer el contenido en la respuesta
        header('Content-Type: text/html; charset=utf-8');
        echo $content;
        
        return $response;
    }
} 