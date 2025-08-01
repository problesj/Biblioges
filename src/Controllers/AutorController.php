<?php

namespace src\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use PDO;
use PDOException;
use App\Core\Config;
use src\Models\Autor;
use src\Models\AliasAutor;
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

            // Eliminar alias asociados
            DB::table('alias_autores')->where('autor_id', $id)->delete();

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

            // Buscar el autor con sus alias
            $autor = Autor::with('alias')->find($id);
            if (!$autor) {
                error_log("Autor no encontrado con ID: " . $id);
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar posibles duplicados con sus alias
            $duplicados = Autor::with('alias')->where('id', '!=', $id)
                ->where('nombres', '!=', 'Sin nombre') // Excluir registros con "Sin nombre"
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
            $autores = Autor::where('nombres', '!=', 'Sin nombre') // Excluir registros con "Sin nombre"
                ->where(function($query) use ($busqueda) {
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

            // Obtener parámetros de paginación
            $pagina = (int)($request->getQueryParams()['pagina'] ?? 1);
            $porPagina = 50; // Procesar 50 grupos por página
            $offset = ($pagina - 1) * $porPagina;

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');

            // Calcular información de paginación
            $totalGrupos = $this->contarGruposDuplicados();
            $totalPaginas = ceil($totalGrupos / $porPagina);

            // Buscar duplicados usando consultas SQL optimizadas
            $gruposDuplicados = $this->buscarDuplicadosOptimizado($pagina, $porPagina);

            // Renderizar la vista
            $body = $this->twig->render('autores/duplicados_globales.twig', [
                'gruposDuplicados' => $gruposDuplicados,
                'paginacion' => [
                    'pagina' => $pagina,
                    'totalPaginas' => $totalPaginas,
                    'totalGrupos' => $totalGrupos,
                    'porPagina' => $porPagina
                ],
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
     * Inicia el proceso de búsqueda de duplicados globales de forma asíncrona
     */
    public function iniciarBusquedaDuplicados($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['error' => 'No autenticado']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            // Guardar estado de búsqueda en sesión
            $this->session->set('busqueda_duplicados_iniciada', true);
            $this->session->set('busqueda_duplicados_progreso', 0);
            $this->session->set('busqueda_duplicados_estado', 'Iniciando búsqueda...');

            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Búsqueda iniciada',
                'redirect_url' => Config::get('app_url') . 'autores/duplicados-globales'
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            error_log("Error en AutorController@iniciarBusquedaDuplicados: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al iniciar búsqueda']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    /**
     * Obtiene el progreso de la búsqueda de duplicados
     */
    public function obtenerProgresoDuplicados($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $response->getBody()->write(json_encode(['error' => 'No autenticado']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            // Verificar si hay una búsqueda en progreso
            $busquedaIniciada = $this->session->get('busqueda_duplicados_iniciada', false);
            
            if (!$busquedaIniciada) {
                $response->getBody()->write(json_encode([
                    'completado' => true,
                    'porcentaje' => 100,
                    'estado' => 'Búsqueda completada'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            // Obtener progreso actual
            $progreso = $this->session->get('busqueda_duplicados_progreso', 0);
            $estado = $this->session->get('busqueda_duplicados_estado', 'Procesando...');

            // Simular progreso incremental
            $nuevoProgreso = min(90, $progreso + rand(5, 15));
            
            // Actualizar estado en sesión
            $this->session->set('busqueda_duplicados_progreso', $nuevoProgreso);
            
            // Determinar mensaje de estado
            $mensajes = [
                'Iniciando búsqueda...',
                'Analizando estructura de datos...',
                'Buscando autores similares...',
                'Comparando nombres y apellidos...',
                'Agrupando duplicados encontrados...',
                'Finalizando búsqueda...'
            ];
            
            $indiceMensaje = min(floor($nuevoProgreso / 15), count($mensajes) - 1);
            $nuevoEstado = $mensajes[$indiceMensaje];
            $this->session->set('busqueda_duplicados_estado', $nuevoEstado);

            // Si llegó al 90%, marcar como completado
            if ($nuevoProgreso >= 90) {
                $this->session->set('busqueda_duplicados_iniciada', false);
                $this->session->set('busqueda_duplicados_progreso', 100);
                
                $response->getBody()->write(json_encode([
                    'completado' => true,
                    'porcentaje' => 100,
                    'estado' => 'Búsqueda completada'
                ]));
                return $response->withHeader('Content-Type', 'application/json');
            }

            $response->getBody()->write(json_encode([
                'completado' => false,
                'porcentaje' => $nuevoProgreso,
                'estado' => $nuevoEstado
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            error_log("Error en AutorController@obtenerProgresoDuplicados: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error al obtener progreso']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    /**
     * Busca variaciones de nombre para fusión de duplicados
     */
    public function buscarVariacionesFusion($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para buscar variaciones');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el término de búsqueda
            $parsedBody = $request->getParsedBody();
            $terminoBusqueda = trim($parsedBody['termino_busqueda'] ?? '');

            if (empty($terminoBusqueda)) {
                $this->session->setFlash('error', 'Debe ingresar un término de búsqueda');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar autores que coincidan con el término
            $autoresEncontrados = Autor::where('nombres', '!=', 'Sin nombre') // Excluir registros con "Sin nombre"
                ->where(function($query) use ($terminoBusqueda) {
                    $query->whereRaw('LOWER(apellidos) LIKE ?', ['%' . strtolower($terminoBusqueda) . '%'])
                          ->orWhereRaw('LOWER(nombres) LIKE ?', ['%' . strtolower($terminoBusqueda) . '%'])
                          ->orWhereRaw('LOWER(CONCAT(apellidos, ", ", nombres)) LIKE ?', ['%' . strtolower($terminoBusqueda) . '%']);
                })->get();

            // Buscar también en alias
            $aliasEncontrados = AliasAutor::where('nombre_variacion', 'LIKE', '%' . $terminoBusqueda . '%')
                ->with('autor')
                ->get();

            // Combinar resultados únicos
            $autoresUnicos = collect();
            
            // Agregar autores encontrados directamente
            foreach ($autoresEncontrados as $autor) {
                $autoresUnicos->put($autor->id, $autor);
            }
            
            // Agregar autores encontrados a través de alias
            foreach ($aliasEncontrados as $alias) {
                if ($alias->autor && !$autoresUnicos->has($alias->autor->id)) {
                    $autoresUnicos->put($alias->autor->id, $alias->autor);
                }
            }

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Renderizar la vista
            $body = $this->twig->render('autores/variaciones_fusion.twig', [
                'autores' => $autoresUnicos->values(),
                'terminoBusqueda' => $terminoBusqueda,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores'
            ]);
            
            $response->getBody()->write($body);
            return $response;

        } catch (\Exception $e) {
            error_log("Error en AutorController@buscarVariacionesFusion: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al buscar variaciones: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Fusiona un grupo de autores con selección de acciones
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
            if (!isset($parsedBody['autor_principal']) || !isset($parsedBody['acciones_autores'])) {
                $this->session->setFlash('error', 'No se seleccionaron los autores correctamente');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
            }

            // Convertir ID del autor principal
            $autorPrincipalId = (int)$parsedBody['autor_principal'];
            $accionesAutores = $parsedBody['acciones_autores'] ?? [];

            // Buscar el autor principal
            $autorPrincipal = Autor::find($autorPrincipalId);
            if (!$autorPrincipal) {
                $this->session->setFlash('error', 'No se encontró el autor principal');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/duplicados-globales')->withStatus(302);
            }

            // Iniciar transacción
            DB::beginTransaction();

            try {
                $autoresConvertirAlias = [];
                $autoresEliminar = [];
                $autoresMantener = [];

                // Procesar las acciones para cada autor
                foreach ($accionesAutores as $autorId => $accion) {
                    $autorId = (int)$autorId;
                    
                    if ($autorId === $autorPrincipalId) {
                        continue; // Saltar el autor principal
                    }

                    switch ($accion) {
                        case 'convertir_alias':
                            $autoresConvertirAlias[] = $autorId;
                            break;
                        case 'eliminar':
                            $autoresEliminar[] = $autorId;
                            break;
                        case 'mantener':
                            $autoresMantener[] = $autorId;
                            break;
                    }
                }

                // Procesar autores que se convertirán en alias
                if (!empty($autoresConvertirAlias)) {
                    $autoresParaAlias = Autor::whereIn('id', $autoresConvertirAlias)->get();
                    
                    foreach ($autoresParaAlias as $autor) {
                        // Crear alias con el nombre completo del autor
                        $autorPrincipal->crearAlias($autor->nombre_completo);
                        
                        // Transferir alias existentes
                        $aliasExistentes = $autor->obtenerVariaciones();
                        foreach ($aliasExistentes as $alias) {
                            $autorPrincipal->crearAlias($alias->nombre_variacion);
                        }

                        // Actualizar referencias en bibliografías
                        $this->actualizarReferenciasAutor($autor->id, $autorPrincipalId);

                        // Eliminar el autor
                        $autor->delete();
                    }
                }

                // Procesar autores que se eliminarán
                if (!empty($autoresEliminar)) {
                    $autoresParaEliminar = Autor::whereIn('id', $autoresEliminar)->get();
                    
                    foreach ($autoresParaEliminar as $autor) {
                        // Actualizar referencias en bibliografías
                        $this->actualizarReferenciasAutor($autor->id, $autorPrincipalId);
                        
                        // Eliminar el autor
                        $autor->delete();
                    }
                }

                // Confirmar transacción
                DB::commit();

                // Construir mensaje detallado
                $acciones = [];
                if (!empty($autoresConvertirAlias)) {
                    $acciones[] = count($autoresConvertirAlias) . ' autor(es) convertido(s) en alias';
                }
                if (!empty($autoresEliminar)) {
                    $acciones[] = count($autoresEliminar) . ' autor(es) eliminado(s)';
                }
                if (!empty($autoresMantener)) {
                    $acciones[] = count($autoresMantener) . ' autor(es) mantenido(s)';
                }
                
                $mensaje = '✅ Fusión de autores completada exitosamente. ';
                if (!empty($acciones)) {
                    $mensaje .= 'Acciones realizadas: ' . implode(', ', $acciones) . '. ';
                }
                $mensaje .= 'Todas las referencias han sido actualizadas al autor principal.';
                
                $this->session->setFlash('success', $mensaje);
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Error en AutorController@fusionarGrupo: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al fusionar autores: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Actualiza las referencias de un autor en las tablas relacionadas
     */
    private function actualizarReferenciasAutor($autorIdViejo, $autorIdNuevo)
    {
        // Actualizar referencias en bibliografías declaradas
        DB::table('bibliografias_autores')
            ->where('autor_id', $autorIdViejo)
            ->update(['autor_id' => $autorIdNuevo]);

        // Actualizar referencias en bibliografías disponibles
        DB::table('bibliografias_disponibles_autores')
            ->where('autor_id', $autorIdViejo)
            ->update(['autor_id' => $autorIdNuevo]);
    }

    /**
     * Muestra las variaciones de nombre de un autor
     */
    public function mostrarVariaciones($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para ver las variaciones');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener el ID del parámetro
            $id = (int)($args['id'] ?? 0);
            if (!$id) {
                $this->session->setFlash('error', 'ID de autor requerido');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar el autor
            $autor = Autor::with('alias')->find($id);
            if (!$autor) {
                $this->session->setFlash('error', 'Autor no encontrado');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Obtener mensajes de error si existen
            $error = $this->session->getFlash('error');
            $success = $this->session->getFlash('success');

            // Renderizar la vista
            $body = $this->twig->render('autores/variaciones.twig', [
                'autor' => $autor,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores',
                'error' => $error,
                'success' => $success
            ]);
            
            $response->getBody()->write($body);
            return $response;
        } catch (\Exception $e) {
            error_log("Error en AutorController@mostrarVariaciones: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al mostrar las variaciones: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Agrega una nueva variación de nombre para un autor
     */
    public function agregarVariacion($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para agregar variaciones');
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
            $nombreVariacion = trim($parsedBody['nombre_variacion'] ?? '');

            if (empty($nombreVariacion)) {
                $this->session->setFlash('error', 'El nombre de la variación es obligatorio');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/variaciones')->withStatus(302);
            }

            // Verificar si ya existe esta variación
            $variacionExistente = AliasAutor::where('autor_id', $id)
                ->where('nombre_variacion', $nombreVariacion)
                ->first();

            if ($variacionExistente) {
                $this->session->setFlash('error', 'Esta variación de nombre ya existe para este autor');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/variaciones')->withStatus(302);
            }

            // Crear la nueva variación
            $autor->crearAlias($nombreVariacion);

            $this->session->setFlash('success', 'Variación de nombre agregada exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/variaciones')->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en AutorController@agregarVariacion: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al agregar la variación: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $id . '/variaciones')->withStatus(302);
        }
    }

    /**
     * Elimina una variación de nombre de un autor
     */
    public function eliminarVariacion($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para eliminar variaciones');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener los IDs de los parámetros
            $autorId = (int)($args['autor_id'] ?? 0);
            $aliasId = (int)($args['alias_id'] ?? 0);

            if (!$autorId || !$aliasId) {
                $this->session->setFlash('error', 'IDs requeridos');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar el alias
            $alias = AliasAutor::where('id', $aliasId)
                ->where('autor_id', $autorId)
                ->first();

            if (!$alias) {
                $this->session->setFlash('error', 'Variación no encontrada');
                return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $autorId . '/variaciones')->withStatus(302);
            }

            // Eliminar el alias
            $alias->delete();

            $this->session->setFlash('success', 'Variación de nombre eliminada exitosamente');
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $autorId . '/variaciones')->withStatus(302);

        } catch (\Exception $e) {
            error_log("Error en AutorController@eliminarVariacion: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al eliminar la variación: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores/' . $args['autor_id'] . '/variaciones')->withStatus(302);
        }
    }

    /**
     * Busca autores por variación de nombre
     */
    public function buscarPorVariacion($request, $response, $args)
    {
        try {
            // Verificar autenticación
            if (!$this->session->get('user_id')) {
                $this->session->setFlash('error', 'Por favor inicie sesión para buscar por variación');
                return $response->withHeader('Location', Config::get('app_url') . 'login')->withStatus(302);
            }

            // Obtener parámetros de búsqueda
            $queryParams = $request->getQueryParams();
            $busqueda = trim($queryParams['busqueda'] ?? '');

            if (empty($busqueda)) {
                $this->session->setFlash('error', 'Debe proporcionar un término de búsqueda');
                return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
            }

            // Buscar por variación de nombre
            $alias = AliasAutor::where('nombre_variacion', 'LIKE', '%' . $busqueda . '%')
                ->with('autor')
                ->get();

            // Obtener datos del usuario
            $usuario = new Usuario();
            $user = $usuario->find($this->session->get('user_id'));

            // Renderizar la vista
            $body = $this->twig->render('autores/busqueda_variacion.twig', [
                'alias' => $alias,
                'busqueda' => $busqueda,
                'user' => $user,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'autores'
            ]);
            
            $response->getBody()->write($body);
            return $response;

        } catch (\Exception $e) {
            error_log("Error en AutorController@buscarPorVariacion: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->session->setFlash('error', 'Error al buscar por variación: ' . $e->getMessage());
            return $response->withHeader('Location', Config::get('app_url') . 'autores')->withStatus(302);
        }
    }

    /**
     * Busca duplicados usando algoritmo ultra-optimizado con indexación
     */
    private function buscarDuplicadosOptimizado($pagina = 1, $porPagina = 50)
    {
        $offset = ($pagina - 1) * $porPagina;
        
        // Paso 1: Obtener autores en lotes muy pequeños para evitar timeout
        $autores = Autor::where('nombres', '!=', 'Sin nombre')
            ->select('id', 'nombres', 'apellidos', 'genero')
            ->limit(500) // Reducir a 500 autores por vez
            ->get();
        
        // Paso 2: Crear índices de patrones para búsqueda rápida
        $indices = $this->crearIndicesPatrones($autores);
        
        // Paso 3: Encontrar grupos usando índices
        $grupos = $this->encontrarGruposConIndices($indices);
        
        // Paso 4: Aplicar paginación
        $gruposPaginados = array_slice($grupos, $offset, $porPagina, true);
        
        // Paso 5: Formatear resultados
        $gruposDuplicados = [];
        foreach ($gruposPaginados as $grupo) {
            $principal = $grupo[0];
            $duplicados = collect(array_slice($grupo, 1));
            
            $gruposDuplicados[] = [
                'principal' => $principal,
                'duplicados' => $duplicados
            ];
        }
        
        return $gruposDuplicados;
    }

    /**
     * Genera un hash para el nombre del autor
     */
    private function generarHashNombre($nombres)
    {
        // Normalizar nombres
        $nombres = strtolower(trim(str_replace(['.', ','], '', $nombres)));
        $palabras = explode(' ', $nombres);
        
        // Crear patrones de similitud
        $patrones = [];
        
        // Patrón 1: Primer nombre
        if (!empty($palabras[0])) {
            $patrones[] = 'p1:' . substr($palabras[0], 0, 3);
        }
        
        // Patrón 2: Primer nombre completo
        if (!empty($palabras[0])) {
            $patrones[] = 'p2:' . $palabras[0];
        }
        
        // Patrón 3: Nombres completos
        $patrones[] = 'p3:' . $nombres;
        
        // Patrón 4: Iniciales
        $iniciales = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $iniciales .= substr($palabra, 0, 1);
            }
        }
        if (!empty($iniciales)) {
            $patrones[] = 'p4:' . $iniciales;
        }
        
        return implode('|', $patrones);
    }
    
    /**
     * Genera un hash para el apellido del autor
     */
    private function generarHashApellido($apellidos)
    {
        // Normalizar apellidos
        $apellidos = strtolower(trim($apellidos));
        $palabras = explode(' ', $apellidos);
        
        // Crear patrones de similitud
        $patrones = [];
        
        // Patrón 1: Primer apellido
        if (!empty($palabras[0])) {
            $patrones[] = 'a1:' . substr($palabras[0], 0, 3);
        }
        
        // Patrón 2: Primer apellido completo
        if (!empty($palabras[0])) {
            $patrones[] = 'a2:' . $palabras[0];
        }
        
        // Patrón 3: Apellidos completos
        $patrones[] = 'a3:' . $apellidos;
        
        // Patrón 4: Iniciales de apellidos
        $iniciales = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $iniciales .= substr($palabra, 0, 1);
            }
        }
        if (!empty($iniciales)) {
            $patrones[] = 'a4:' . $iniciales;
        }
        
        return implode('|', $patrones);
    }
    
    /**
     * Genera un hash combinado de nombre y apellido
     */
    private function generarHashCombinado($nombres, $apellidos)
    {
        $hashNombre = $this->generarHashNombre($nombres);
        $hashApellido = $this->generarHashApellido($apellidos);
        
        // Combinar patrones más específicos
        $nombresLimpios = strtolower(trim(str_replace(['.', ','], '', $nombres)));
        $apellidosLimpios = strtolower(trim($apellidos));
        
        $primerNombre = explode(' ', $nombresLimpios)[0] ?? '';
        $primerApellido = explode(' ', $apellidosLimpios)[0] ?? '';
        
        $patronesCombinados = [];
        
        // Patrón: Primer nombre + Primer apellido
        if (!empty($primerNombre) && !empty($primerApellido)) {
            $patronesCombinados[] = 'c1:' . $primerNombre . '_' . $primerApellido;
        }
        
        // Patrón: Nombres completos + Apellidos completos
        $patronesCombinados[] = 'c2:' . $nombresLimpios . '_' . $apellidosLimpios;
        
        return implode('|', $patronesCombinados);
    }
    
    /**
     * Calcula un score de similitud entre nombres y apellidos
     */
    private function calcularSimilitud($nombres, $apellidos)
    {
        $nombresLimpios = strtolower(trim(str_replace(['.', ','], '', $nombres)));
        $apellidosLimpios = strtolower(trim($apellidos));
        
        $score = 0;
        
        // Score por longitud
        $score += strlen($nombresLimpios) * 0.1;
        $score += strlen($apellidosLimpios) * 0.1;
        
        // Score por palabras
        $palabrasNombres = explode(' ', $nombresLimpios);
        $palabrasApellidos = explode(' ', $apellidosLimpios);
        
        $score += count($palabrasNombres) * 0.2;
        $score += count($palabrasApellidos) * 0.2;
        
        return $score;
    }
    
    /**
     * Agrupa autores por patrones similares
     */
    private function agruparPorPatrones($patrones)
    {
        $grupos = [];
        $procesados = [];
        
        foreach ($patrones as $i => $patron) {
            if (in_array($i, $procesados)) continue;
            
            $grupo = [$patron];
            $procesados[] = $i;
            
            // Buscar patrones similares
            for ($j = $i + 1; $j < count($patrones); $j++) {
                if (in_array($j, $procesados)) continue;
                
                if ($this->sonPatronesSimilares($patron, $patrones[$j])) {
                    $grupo[] = $patrones[$j];
                    $procesados[] = $j;
                }
            }
            
            if (count($grupo) > 1) {
                $grupos[] = $grupo;
            }
        }
        
        return $grupos;
    }
    
    /**
     * Crea índices de patrones para búsqueda ultra-rápida
     */
    private function crearIndicesPatrones($autores)
    {
        $indices = [
            'primer_nombre' => [],
            'primer_apellido' => [],
            'nombre_completo' => [],
            'apellido_completo' => [],
            'iniciales' => [],
            'combinado' => []
        ];
        
        foreach ($autores as $autor) {
            $nombresLimpios = strtolower(trim(str_replace(['.', ','], '', $autor->nombres)));
            $apellidosLimpios = strtolower(trim($autor->apellidos));
            
            $palabrasNombres = explode(' ', $nombresLimpios);
            $palabrasApellidos = explode(' ', $apellidosLimpios);
            
            // Índice por primer nombre
            $primerNombre = $palabrasNombres[0] ?? '';
            if (!empty($primerNombre)) {
                $indices['primer_nombre'][$primerNombre][] = $autor;
            }
            
            // Índice por primer apellido
            $primerApellido = $palabrasApellidos[0] ?? '';
            if (!empty($primerApellido)) {
                $indices['primer_apellido'][$primerApellido][] = $autor;
            }
            
            // Índice por nombre completo
            $indices['nombre_completo'][$nombresLimpios][] = $autor;
            
            // Índice por apellido completo
            $indices['apellido_completo'][$apellidosLimpios][] = $autor;
            
            // Índice por iniciales
            $iniciales = '';
            foreach ($palabrasNombres as $palabra) {
                if (!empty($palabra)) {
                    $iniciales .= substr($palabra, 0, 1);
                }
            }
            if (!empty($iniciales)) {
                $indices['iniciales'][$iniciales][] = $autor;
            }
            
            // Índice combinado
            $combinado = $primerNombre . '_' . $primerApellido;
            if (!empty($primerNombre) && !empty($primerApellido)) {
                $indices['combinado'][$combinado][] = $autor;
            }
        }
        
        return $indices;
    }
    
    /**
     * Encuentra grupos de duplicados usando índices
     */
    private function encontrarGruposConIndices($indices)
    {
        $grupos = [];
        $procesados = [];
        
        // Buscar por primer nombre (más común)
        foreach ($indices['primer_nombre'] as $nombre => $autores) {
            if (count($autores) > 1) {
                $grupoId = 'nombre_' . $nombre;
                if (!in_array($grupoId, $procesados)) {
                    $grupos[] = $autores;
                    $procesados[] = $grupoId;
                    
                    // Marcar autores como procesados
                    foreach ($autores as $autor) {
                        $procesados[] = $autor->id;
                    }
                }
            }
        }
        
        // Buscar por primer apellido
        foreach ($indices['primer_apellido'] as $apellido => $autores) {
            if (count($autores) > 1) {
                $grupoId = 'apellido_' . $apellido;
                if (!in_array($grupoId, $procesados)) {
                    $grupos[] = $autores;
                    $procesados[] = $grupoId;
                    
                    foreach ($autores as $autor) {
                        $procesados[] = $autor->id;
                    }
                }
            }
        }
        
        // Buscar por combinación nombre+apellido
        foreach ($indices['combinado'] as $combinado => $autores) {
            if (count($autores) > 1) {
                $grupoId = 'combinado_' . $combinado;
                if (!in_array($grupoId, $procesados)) {
                    $grupos[] = $autores;
                    $procesados[] = $grupoId;
                    
                    foreach ($autores as $autor) {
                        $procesados[] = $autor->id;
                    }
                }
            }
        }
        
        // Ordenar por cantidad de duplicados
        usort($grupos, function($a, $b) {
            return count($b) - count($a);
        });
        
        return $grupos;
    }

    /**
     * Cuenta el total de grupos de duplicados usando el algoritmo ultra-optimizado
     */
    private function contarGruposDuplicados()
    {
        // Obtener solo una muestra para estimar el total
        $autores = Autor::where('nombres', '!=', 'Sin nombre')
            ->select('id', 'nombres', 'apellidos', 'genero')
            ->limit(1000) // Solo procesar 1000 para estimar
            ->get();
        
        // Crear índices de patrones
        $indices = $this->crearIndicesPatrones($autores);
        
        // Contar grupos
        $totalGrupos = 0;
        
        // Contar por primer nombre
        foreach ($indices['primer_nombre'] as $nombre => $autores) {
            if (count($autores) > 1) {
                $totalGrupos++;
            }
        }
        
        // Contar por primer apellido
        foreach ($indices['primer_apellido'] as $apellido => $autores) {
            if (count($autores) > 1) {
                $totalGrupos++;
            }
        }
        
        // Contar por combinación
        foreach ($indices['combinado'] as $combinado => $autores) {
            if (count($autores) > 1) {
                $totalGrupos++;
            }
        }
        
        // Estimar el total basado en la muestra
        $totalAutores = Autor::where('nombres', '!=', 'Sin nombre')->count();
        $factorEstimacion = $totalAutores / 1000;
        
        return (int)($totalGrupos * $factorEstimacion);
    }
}