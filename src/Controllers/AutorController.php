<?php

namespace src\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use PDO;
use PDOException;
use App\Core\Config;
use src\Models\Autor;
use src\Models\BibliografiaDeclarada;
use src\Models\BibliografiaDisponible;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Core\Response as AppResponse;
use src\Models\Usuario;
use Illuminate\Database\Capsule\Manager as DB;

class AutorController extends BaseController
{
    protected $twig;
    protected $flash;
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
        
        // Usar la instancia global de Twig
        global $twig;
        $this->twig = $twig;
        
        global $flash;
        $this->flash = $flash;
    }

    /**
     * Muestra la lista de autores
     */
    public function index($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para acceder a los autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // No limpiar mensajes flash automáticamente
            // Los mensajes flash se manejan correctamente por la clase Session
            // y se eliminan automáticamente después de ser leídos

            // Obtener parámetros de la solicitud
            $queryParams = $request->getQueryParams();
            $filtros = [
                'busqueda' => $queryParams['busqueda'] ?? '',
                'tipo_busqueda' => $queryParams['tipo_busqueda'] ?? 'todos',
                'genero' => $queryParams['genero'] ?? '',
                'orden' => $queryParams['orden'] ?? 'apellidos',
                'direccion' => $queryParams['direccion'] ?? 'asc',
                'pagina' => (int)($queryParams['pagina'] ?? 1)
            ];

            // Validar dirección de ordenamiento
            $filtros['direccion'] = in_array($filtros['direccion'], ['asc', 'desc']) ? $filtros['direccion'] : 'asc';

            // Validar campo de ordenamiento
            $camposOrdenamiento = ['id', 'apellidos', 'nombres', 'genero'];
            $filtros['orden'] = in_array($filtros['orden'], $camposOrdenamiento) ? $filtros['orden'] : 'apellidos';

            // Construir la consulta base
            $query = Autor::query();

            // Aplicar filtros de búsqueda
            if (!empty($filtros['busqueda'])) {
                $busqueda = '%' . $filtros['busqueda'] . '%';
                switch ($filtros['tipo_busqueda']) {
                    case 'apellidos':
                        $query->where('apellidos', 'LIKE', $busqueda);
                        break;
                    case 'nombres':
                        $query->where('nombres', 'LIKE', $busqueda);
                        break;
                    default: // 'todos'
                        $query->where(function($q) use ($busqueda) {
                            $q->where('apellidos', 'LIKE', $busqueda)
                              ->orWhere('nombres', 'LIKE', $busqueda);
                        });
                        break;
                }
            }

            // Aplicar filtro de género
            if (!empty($filtros['genero'])) {
                // Mapear la inicial a el valor completo
                $mapaGenero = [
                    'M' => 'Masculino',
                    'F' => 'Femenino',
                    'O' => 'Otro'
                ];
                
                $genero = $mapaGenero[$filtros['genero']] ?? $filtros['genero'];
                
                // Aplicar el filtro
                $query->where('genero', '=', $genero);
            }

            // Obtener el total de registros
            $total = $query->count();

            // Aplicar ordenamiento
            $query->orderBy($filtros['orden'], $filtros['direccion']);

            // Paginación
            $porPagina = 20;
            $totalPaginas = ceil($total / $porPagina);
            $filtros['pagina'] = max(1, min($filtros['pagina'], $totalPaginas));

            // Aplicar paginación
            $autores = $query->skip(($filtros['pagina'] - 1) * $porPagina)
                           ->take($porPagina)
                           ->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de sesión
            $success = $this->session->getFlash('success');
            $error = $this->session->getFlash('error');

            // Formatear mensajes para SweetAlert2
            $successMessage = null;
            $errorMessage = null;
            
            if ($success) {
                $successMessage = [
                    'title' => '¡Éxito!',
                    'text' => $success,
                    'icon' => 'success'
                ];
            }
            
            if ($error) {
                $errorMessage = [
                    'title' => 'Error',
                    'text' => $error,
                    'icon' => 'error'
                ];
            }

            // Renderizar la vista
            $body = $this->twig->render('autores/index.twig', [
                'autores' => $autores,
                'filtros' => array_merge($filtros, [
                    'total_registros' => $total,
                    'total_paginas' => $totalPaginas
                ]),
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'success' => $successMessage,
                'error' => $errorMessage
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en AutorController@index: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al cargar la lista de autores: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Muestra el formulario de creación
     */
    public function create($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para crear autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('autores/create.twig', [
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en AutorController@create: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Almacena un nuevo autor
     */
    public function store($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para crear autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $apellidos = trim($parsedBody['apellidos'] ?? '');
            $nombres = trim($parsedBody['nombres'] ?? '');
            $genero = trim($parsedBody['genero'] ?? '');

            if (empty($apellidos) || empty($nombres) || empty($genero)) {
                $this->session->setFlash('error', 'Todos los campos son obligatorios');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/create')->withStatus(302);
            }

            // Mapear el valor del género a los valores permitidos
            $generoMapeado = 'Otro'; // Valor por defecto
            if (!empty($genero)) {
                switch (strtoupper($genero)) {
                    case 'F':
                        $generoMapeado = 'Femenino';
                        break;
                    case 'M':
                        $generoMapeado = 'Masculino';
                        break;
                    case 'O':
                        $generoMapeado = 'Otro';
                        break;
                    default:
                        $generoMapeado = 'Otro';
                }
            }

            // Crear el autor
            $autor = new Autor();
            $autor->apellidos = $apellidos;
            $autor->nombres = $nombres;
            $autor->genero = $generoMapeado;
            $autor->save();

            $this->session->setFlash('success', 'El autor ha sido creado exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en AutorController@store: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al crear el autor: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/create')->withStatus(302);
        }
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para editar autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar el autor
            $autor = Autor::find($id);
            if (!$autor) {
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('autores/edit.twig', [
                'autor' => $autor,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en AutorController@edit: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Actualiza un autor existente
     */
    public function update($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para editar autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar el autor
            $autor = Autor::find($id);
            if (!$autor) {
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();
            $apellidos = trim($parsedBody['apellidos'] ?? '');
            $nombres = trim($parsedBody['nombres'] ?? '');
            $genero = trim($parsedBody['genero'] ?? '');

            if (empty($apellidos) || empty($nombres) || empty($genero)) {
                $this->session->setFlash('error', 'Todos los campos son obligatorios');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/edit')->withStatus(302);
            }

            // Mapear el valor del género a los valores permitidos
            $generoMapeado = 'Otro'; // Valor por defecto
            if (!empty($genero)) {
                switch (strtoupper($genero)) {
                    case 'F':
                        $generoMapeado = 'Femenino';
                        break;
                    case 'M':
                        $generoMapeado = 'Masculino';
                        break;
                    case 'O':
                        $generoMapeado = 'Otro';
                        break;
                    default:
                        $generoMapeado = 'Otro';
                }
            }

            // Actualizar el autor
            $autor->apellidos = $apellidos;
            $autor->nombres = $nombres;
            $autor->genero = $generoMapeado;
            $autor->save();

            $this->session->setFlash('success', 'El autor ha sido actualizado exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en AutorController@update: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al actualizar el autor: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/edit')->withStatus(302);
        }
    }

    /**
     * Elimina un autor
     */
    public function destroy($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para eliminar autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar el autor
            $autor = Autor::find($id);
            if (!$autor) {
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Verificar vinculaciones en bibliografias_autores
            $vinculadoDeclaradas = DB::table('bibliografias_autores')->where('autor_id', $id)->exists();
            // Verificar vinculaciones en bibliografias_disponibles_autores
            $vinculadoDisponibles = DB::table('bibliografias_disponibles_autores')->where('autor_id', $id)->exists();

            if ($vinculadoDeclaradas || $vinculadoDisponibles) {
                $this->session->setFlash('error', 'No se puede eliminar el autor porque está vinculado a una o más bibliografías.');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Eliminar el autor
            $autor->delete();

            $this->session->setFlash('success', 'El autor ha sido eliminado exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        } catch (\Exception $e) {
            error_log("Error en AutorController@destroy: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al eliminar el autor: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Busca autores duplicados
     */
    public function duplicados($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para buscar duplicados');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            error_log("Buscando duplicados para el autor con ID: " . $id);

            // Buscar el autor
            $autor = Autor::find($id);
            if (!$autor) {
                error_log("Autor no encontrado con ID: " . $id);
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar posibles duplicados
            $duplicados = Autor::where('id', '!=', $id)
                ->where(function($query) use ($autor) {
                    // Buscar por apellidos similares
                    $query->where(function($q) use ($autor) {
                        $apellidos = explode(' ', strtolower($autor->apellidos));
                        foreach ($apellidos as $apellido) {
                            if (strlen($apellido) > 2) { // Ignorar palabras muy cortas
                                $q->orWhereRaw('LOWER(apellidos) LIKE ?', ['%' . $apellido . '%']);
                            }
                        }
                    })
                    // Y nombres similares
                    ->where(function($q) use ($autor) {
                        $nombres = explode(' ', strtolower($autor->nombres));
                        foreach ($nombres as $nombre) {
                            if (strlen($nombre) > 2) { // Ignorar palabras muy cortas
                                $q->orWhereRaw('LOWER(nombres) LIKE ?', ['%' . $nombre . '%']);
                            }
                        }
                    });
                })
                ->get();

            error_log("Duplicados encontrados: " . $duplicados->count());

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('autores/duplicados.twig', [
                'autor' => $autor,
                'duplicados' => $duplicados,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en AutorController@duplicados: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al buscar duplicados: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Busca autores duplicados
     */
    public function buscarDuplicados(Request $request, Response $response): Response
    {
        try {
            $busqueda = $request->getQueryParams()['busqueda'] ?? '';
            
            if (empty($busqueda)) {
                throw new \Exception('Debe proporcionar un término de búsqueda');
            }

            // Buscar autores similares
            $autores = Autor::where(function($query) use ($busqueda) {
                $query->where('nombres', 'LIKE', "%{$busqueda}%")
                      ->orWhere('apellidos', 'LIKE', "%{$busqueda}%");
            })->get();

            $data = [
                'autores' => $autores,
                'busqueda' => $busqueda,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores'
            ];

            $content = $this->twig->render('autores/duplicados.twig', $data);
            
            header('Content-Type: text/html; charset=utf-8');
            echo $content;
            
            return $response;
        } catch (\Exception $e) {
            error_log('Error al buscar duplicados: ' . $e->getMessage());
            
            if (isset($_SESSION)) {
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => 'Error al buscar duplicados: ' . $e->getMessage()
                ];
            }

            header('Location: ' . Config::get('app_url') . 'autores');
            exit;
        }
    }

    /**
     * Fusiona autores duplicados
     */
    public function fusionar($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para fusionar autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();

            // Verificar que se hayan enviado duplicados
            if (!isset($parsedBody['duplicados']) || !is_array($parsedBody['duplicados'])) {
                $this->session->setFlash('error', 'No se seleccionaron autores para fusionar');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $args['id'] . '/duplicados')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            error_log("Fusionando autor con ID: " . $id);

            // Buscar el autor principal
            $autor = Autor::find($id);
            if (!$autor) {
                error_log("Autor principal no encontrado con ID: " . $id);
                $this->session->setFlash('error', 'Autor principal no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Iniciar transacción
            DB::beginTransaction();

            try {
                // Obtener los IDs de los duplicados
                $duplicadosIds = array_map('intval', $parsedBody['duplicados']);
                error_log("IDs de duplicados a fusionar: " . implode(', ', $duplicadosIds));

                // Buscar los duplicados
                $duplicados = Autor::whereIn('id', $duplicadosIds)->get();
                if ($duplicados->isEmpty()) {
                    throw new \Exception('No se encontraron los autores duplicados');
                }

                // Actualizar referencias en la tabla de relaciones
                foreach ($duplicados as $duplicado) {
                    // Actualizar referencias en la tabla de relaciones
                    DB::table('autor_bibliografia')
                        ->where('autor_id', $duplicado->id)
                        ->update(['autor_id' => $autor->id]);

                    // Eliminar el autor duplicado
                    $duplicado->delete();
                }

                // Confirmar transacción
                DB::commit();

                $this->session->setFlash('success', 'Los autores han sido fusionados correctamente');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Error en AutorController@fusionar: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al fusionar autores: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $args['id'] . '/duplicados')->withStatus(302);
        }
    }

    /**
     * Busca duplicados en todo el listado de autores
     */
    public function buscarDuplicadosGlobales($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para buscar duplicados');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener todos los autores
            $autores = Autor::all();
            $gruposDuplicados = [];

            // Para cada autor, buscar posibles duplicados
            foreach ($autores as $autor) {
                $duplicados = Autor::where('id', '!=', $autor->id)
                    ->where(function($query) use ($autor) {
                        // Buscar por apellidos similares
                        $query->where(function($q) use ($autor) {
                            $apellidos = explode(' ', strtolower($autor->apellidos));
                            foreach ($apellidos as $apellido) {
                                if (strlen($apellido) > 2) { // Ignorar palabras muy cortas
                                    $q->orWhereRaw('LOWER(apellidos) LIKE ?', ['%' . $apellido . '%']);
                                }
                            }
                        })
                        // Y nombres similares
                        ->where(function($q) use ($autor) {
                            $nombres = explode(' ', strtolower($autor->nombres));
                            foreach ($nombres as $nombre) {
                                if (strlen($nombre) > 2) { // Ignorar palabras muy cortas
                                    $q->orWhereRaw('LOWER(nombres) LIKE ?', ['%' . $nombre . '%']);
                                }
                            }
                        });
                    })
                    ->get();

                // Si se encontraron duplicados, agregar al grupo
                if ($duplicados->isNotEmpty()) {
                    $grupo = [
                        'principal' => $autor,
                        'duplicados' => $duplicados
                    ];
                    $gruposDuplicados[] = $grupo;
                }
            }

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Renderizar la vista
            $body = $this->twig->render('autores/duplicados_globales.twig', [
                'gruposDuplicados' => $gruposDuplicados,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'error' => $error
            ]);
            
            $response->getBody()->write($body);
            return $response;

        } catch (\Exception $e) {
            error_log("Error en AutorController@buscarDuplicadosGlobales: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al buscar duplicados: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Fusiona un grupo de autores
     */
    public function fusionarGrupo($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para fusionar autores');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener datos del formulario
            $parsedBody = $request->getParsedBody();

            // Verificar que se hayan enviado los datos necesarios
            if (!isset($parsedBody['autor_principal']) || !isset($parsedBody['autores_fusionar']) || !is_array($parsedBody['autores_fusionar'])) {
                $this->session->setFlash('error', 'No se seleccionaron los autores correctamente');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
            }

            // Convertir IDs a enteros
            $autorPrincipalId = (int)$parsedBody['autor_principal'];
            $autoresFusionarIds = array_map('intval', $parsedBody['autores_fusionar']);

            // Verificar que el autor principal no esté en la lista de autores a fusionar
            if (in_array($autorPrincipalId, $autoresFusionarIds)) {
                $this->session->setFlash('error', 'El autor principal no puede estar en la lista de autores a fusionar');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
            }

            // Buscar el autor principal
            $autorPrincipal = Autor::find($autorPrincipalId);
            if (!$autorPrincipal) {
                $this->session->setFlash('error', 'No se encontró el autor principal');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
            }

            // Iniciar transacción
            DB::beginTransaction();

            try {
                // Buscar los autores a fusionar
                $autoresFusionar = Autor::whereIn('id', $autoresFusionarIds)->get();
                if ($autoresFusionar->isEmpty()) {
                    throw new \Exception('No se encontraron los autores a fusionar');
                }

                // Actualizar referencias y eliminar duplicados
                foreach ($autoresFusionar as $autor) {
                    // Actualizar referencias en bibliografías declaradas
                    DB::table('bibliografias_autores')
                        ->where('autor_id', $autor->id)
                        ->update(['autor_id' => $autorPrincipalId]);

                    // Actualizar referencias en bibliografías disponibles
                    DB::table('bibliografias_disponibles_autores')
                        ->where('autor_id', $autor->id)
                        ->update(['autor_id' => $autorPrincipalId]);

                    // Eliminar el autor duplicado
                    $autor->delete();
                }

                // Confirmar transacción
                DB::commit();

                $this->session->setFlash('success', 'Los autores han sido fusionados correctamente');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Error en AutorController@fusionarGrupo: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al fusionar autores: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
        }
    }
} 