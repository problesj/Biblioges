<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
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
            $query = BibliografiaDisponible::with(['bibliografiaDeclarada', 'sedes', 'autores']);

            // Filtro por búsqueda (título, autores o editorial)
            $busqueda = $request->getQueryParams()['busqueda'] ?? '';
            if (!empty($busqueda)) {
                $query->where(function($q) use ($busqueda) {
                    $q->where('titulo', 'LIKE', "%{$busqueda}%")
                      ->orWhere('editorial', 'LIKE', "%{$busqueda}%")
                      ->orWhereHas('autores', function($q) use ($busqueda) {
                          $q->where('nombres', 'LIKE', "%{$busqueda}%")
                            ->orWhere('apellidos', 'LIKE', "%{$busqueda}%");
                      });
                });
            }

            // Filtro por disponibilidad
            $disponibilidad = $request->getQueryParams()['disponibilidad'] ?? '';
            if (!empty($disponibilidad)) {
                $query->where('disponibilidad', $disponibilidad);
            }

            // Filtro por estado
            $estado = $request->getQueryParams()['estado'] ?? '';
            if ($estado !== '') {
                $query->where('estado', $estado);
            }

            // Filtro por año de edición
            $anioEdicion = $request->getQueryParams()['anio_edicion'] ?? '';
            if (!empty($anioEdicion)) {
                $query->where('anio_edicion', $anioEdicion);
            }

            // Ordenamiento
            $orden = $request->getQueryParams()['orden'] ?? 'titulo';
            $direccion = $request->getQueryParams()['direccion'] ?? 'asc';

            // Validar campo de ordenamiento
            $camposOrdenamiento = ['titulo', 'editorial', 'autores'];
            $orden = in_array($orden, $camposOrdenamiento) ? $orden : 'titulo';
            $direccion = in_array($direccion, ['asc', 'desc']) ? $direccion : 'asc';

            // Aplicar ordenamiento
            switch ($orden) {
                case 'titulo':
                    $query->orderBy('titulo', $direccion);
                    break;
                case 'editorial':
                    $query->orderBy('editorial', $direccion);
                    break;
                case 'autores':
                    $query->join('bibliografias_disponibles_autores', 'bibliografias_disponibles.id', '=', 'bibliografias_disponibles_autores.bibliografia_disponible_id')
                          ->join('autores', 'bibliografias_disponibles_autores.autor_id', '=', 'autores.id')
                          ->select([
                              'bibliografias_disponibles.*',
                              'autores.apellidos',
                              'autores.nombres'
                          ])
                          ->orderBy('autores.apellidos', $direccion)
                          ->orderBy('autores.nombres', $direccion)
                          ->distinct();
                    break;
            }

            // Paginación
            $pagina = (int)($request->getQueryParams()['pagina'] ?? 1);
            $porPagina = 20;
            $total = $query->count();
            $totalPaginas = ceil($total / $porPagina);
            $pagina = max(1, min($pagina, $totalPaginas)); // Asegurar que la página esté entre 1 y totalPaginas

            $bibliografias = $query->skip(($pagina - 1) * $porPagina)
                                 ->take($porPagina)
                                 ->get();

            error_log('Renderizando plantilla: bibliografias_disponibles/index.twig');
            error_log('Datos pasados a la plantilla: ' . print_r([
                'bibliografias' => $bibliografias,
                'filtros' => [
                    'busqueda' => $busqueda,
                    'disponibilidad' => $disponibilidad,
                    'estado' => $estado,
                    'anio_edicion' => $anioEdicion,
                    'orden' => $orden,
                    'direccion' => $direccion,
                    'pagina' => $pagina,
                    'total_paginas' => $totalPaginas,
                    'total_registros' => $total
                ]
            ], true));
            
            // Agregar variables globales a la plantilla
            $data = [
                'bibliografias' => $bibliografias,
                'filtros' => [
                    'busqueda' => $busqueda,
                    'disponibilidad' => $disponibilidad,
                    'estado' => $estado,
                    'anio_edicion' => $anioEdicion,
                    'orden' => $orden,
                    'direccion' => $direccion,
                    'pagina' => $pagina,
                    'total_paginas' => $totalPaginas,
                    'total_registros' => $total
                ],
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            // Limpiar mensajes de sesión después de pasarlos a la plantilla
            if (isset($_SESSION['success'])) {
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                unset($_SESSION['error']);
            }
            
            // Renderizar la plantilla
            $content = $this->twig->render('bibliografias_disponibles/index.twig', $data);
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

    /**
     * Muestra el formulario de creación
     */
    public function create(Request $request, Response $response): Response
    {
        $bibliografiasDeclaradas = BibliografiaDeclarada::where('estado', true)->get();
        $sedes = Sede::where('estado', true)->get();
        $autores = Autor::all();
        
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
            error_log('Renderizando plantilla: bibliografias_disponibles/form.twig');
            
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
            error_log('Plantilla renderizada correctamente');
            
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
        error_log('Iniciando método store()');
        
        try {
            $data = $_POST;
            error_log('Datos recibidos: ' . print_r($data, true));
            
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
        $sedes = Sede::where('estado', true)->get();
            $autores = Autor::all();

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

            error_log('Renderizando plantilla: bibliografias_disponibles/form.twig');
            error_log('Datos de sedes: ' . print_r($sedesConEjemplares, true));
            
            $data = [
            'bibliografia' => $bibliografia,
                'bibliografiasDeclaradas' => $bibliografiasDeclaradas,
                'sedes' => $sedes,
                'autores' => $autores,
                'editoriales' => $editoriales,
                'isEdit' => true,
                'app_url' => Config::get('app_url'),
                'session' => $_SESSION,
                'current_page' => 'bibliografias-disponibles'
            ];
            
            $content = $this->twig->render('bibliografias_disponibles/form.twig', $data);
            error_log('Plantilla renderizada correctamente');
            
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
            
            error_log('Datos recibidos en update: ' . print_r($data, true));
            
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
        try {
            $bibliografia = BibliografiaDisponible::findOrFail($args['id']);
            $bibliografia->delete();
            
            $_SESSION['success'] = 'Bibliografía disponible eliminada exitosamente';
            header('Location: ' . Config::get('app_url') . 'bibliografias-disponibles');
            exit;
        } catch (\Exception $e) {
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
            
            error_log('Bibliografía encontrada: ' . print_r($bibliografia->toArray(), true));
            
            // Obtener los ejemplares por sede
            $stmt = $this->pdo->prepare("
                SELECT sede_id, ejemplares 
                FROM bibliografias_disponibles_sedes 
                WHERE bibliografia_disponible_id = :id
            ");
            $stmt->execute([':id' => $args['id']]);
            $ejemplaresPorSede = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            error_log('Ejemplares por sede: ' . print_r($ejemplaresPorSede, true));
            
            // Crear un array asociativo de sedes con sus ejemplares
            $sedesConEjemplares = [];
            foreach ($bibliografia->sedes as $sede) {
                $sedesConEjemplares[$sede->id] = [
                    'id' => $sede->id,
                    'nombre' => $sede->nombre,
                    'ejemplares' => $ejemplaresPorSede[$sede->id] ?? 0
                ];
            }
            
            error_log('Sedes con ejemplares: ' . print_r($sedesConEjemplares, true));
            
            // Asignar el array de sedes con ejemplares a la bibliografía
            $bibliografia->sedes = $sedesConEjemplares;
            
            // Convertir a array para asegurar que los datos se pasen correctamente
            $bibliografiaArray = $bibliografia->toArray();
            
            error_log('Bibliografía array final: ' . print_r($bibliografiaArray, true));
            
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