<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Session;
use PDO;
use PDOException;

class MallaController
{
    private $pdo;
    private $twig;
    private $session;

    public function __construct()
    {
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

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $this->session = new Session();
    }

    public function index()
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        // Obtener filtros
        $filtros = [
            'tipo_programa' => $_GET['tipo_programa'] ?? '',
            'sede' => $_GET['sede'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'busqueda' => $_GET['busqueda'] ?? ''
        ];

        // Construir la consulta base
        $sql = "SELECT c.*, 
                GROUP_CONCAT(DISTINCT ce.codigo_carrera) as codigos_carrera,
                GROUP_CONCAT(DISTINCT s.nombre) as sedes,
                GROUP_CONCAT(DISTINCT f.nombre) as facultades
                FROM carreras c
                LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                LEFT JOIN sedes s ON ce.sede_id = s.id
                LEFT JOIN facultades f ON ce.facultad_id = f.id
                WHERE 1=1";

        $params = [];

        // Aplicar filtros
        if (!empty($filtros['tipo_programa'])) {
            $sql .= " AND c.tipo_programa = ?";
            $params[] = $filtros['tipo_programa'];
        }

        if (!empty($filtros['sede'])) {
            $sql .= " AND ce.sede_id = ?";
            $params[] = $filtros['sede'];
        }

        if ($filtros['estado'] !== '') {
            $sql .= " AND c.estado = ?";
            $params[] = $filtros['estado'];
        }

        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (c.nombre LIKE ? OR ce.codigo_carrera LIKE ?)";
            $params[] = "%{$filtros['busqueda']}%";
            $params[] = "%{$filtros['busqueda']}%";
        }

        $sql .= " GROUP BY c.id ORDER BY c.nombre";

        // Ejecutar la consulta
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar los resultados para asegurar el formato correcto
        foreach ($carreras as &$carrera) {
            // Asegurar que los campos sean arrays
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
        }

        // Obtener sedes para el filtro
        $stmt = $this->pdo->query("SELECT * FROM sedes ORDER BY nombre");
        $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener usuario actual
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$this->session->get('user_id')]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Renderizar la vista
        echo $this->twig->render('mallas/index.twig', [
            'carreras' => $carreras,
            'sedes' => $sedes,
            'filtros' => $filtros,
            'user' => $user,
            'app_url' => Config::get('app_url'),
            'current_page' => 'mallas',
            'session' => $_SESSION
        ]);
    }

    public function show($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Obtener datos de la carrera
            $sql = "SELECT 
                        c.*,
                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera,
                        GROUP_CONCAT(s.nombre) as sedes,
                        GROUP_CONCAT(f.nombre) as facultades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN facultades f ON ce.facultad_id = f.id
                    WHERE c.id = ?
                    GROUP BY c.id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                header('Location: ' . Config::get('app_url') . 'mallas');
                exit;
            }

            // Procesar los resultados para asegurar el formato correcto
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
            $carrera['vigencias_desde'] = $carrera['vigencias_desde'] ? explode(',', $carrera['vigencias_desde']) : [];
            $carrera['vigencias_hasta'] = $carrera['vigencias_hasta'] ? explode(',', $carrera['vigencias_hasta']) : [];

            // Obtener asignaturas vinculadas a través de la tabla mallas
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            WHERE m.carrera_id = ?
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$id]);
            $carrera['asignaturas'] = $stmt->fetchAll();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener mensajes de sesión y limpiarlos
            $success = $this->session->get('success');
            $error = $this->session->get('error');
            $this->session->remove('success');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('mallas/show.twig', [
                'carrera' => $carrera,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'success' => $success,
                'error' => $error,
                'current_page' => 'mallas',
                'session' => $_SESSION
            ]);
        } catch (\Exception $e) {
            $this->session->set('error', 'Error al obtener los datos de la malla: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'mallas');
            exit;
        }
    }

    public function edit($id)
    {
        // Verificar autenticación
        if (!$this->session->get('user_id')) {
            $this->session->set('error', 'Por favor inicie sesión para acceder a las mallas');
            header('Location: ' . Config::get('app_url') . 'login');
            exit;
        }

        try {
            // Obtener datos de la carrera
            $sql = "SELECT 
                        c.*,
                        GROUP_CONCAT(ce.codigo_carrera) as codigos_carrera,
                        GROUP_CONCAT(s.nombre) as sedes,
                        GROUP_CONCAT(f.nombre) as facultades,
                        GROUP_CONCAT(ce.vigencia_desde) as vigencias_desde,
                        GROUP_CONCAT(ce.vigencia_hasta) as vigencias_hasta
                    FROM carreras c
                    LEFT JOIN carreras_espejos ce ON c.id = ce.carrera_id
                    LEFT JOIN sedes s ON ce.sede_id = s.id
                    LEFT JOIN facultades f ON ce.facultad_id = f.id
                    WHERE c.id = ?
                    GROUP BY c.id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $carrera = $stmt->fetch();

            if (!$carrera) {
                $this->session->set('error', 'Carrera no encontrada');
                header('Location: ' . Config::get('app_url') . 'mallas');
                exit;
            }

            // Procesar los resultados para asegurar el formato correcto
            $carrera['sedes'] = $carrera['sedes'] ? explode(',', $carrera['sedes']) : [];
            $carrera['facultades'] = $carrera['facultades'] ? explode(',', $carrera['facultades']) : [];
            $carrera['codigos_carrera'] = $carrera['codigos_carrera'] ? explode(',', $carrera['codigos_carrera']) : [];
            $carrera['vigencias_desde'] = $carrera['vigencias_desde'] ? explode(',', $carrera['vigencias_desde']) : [];
            $carrera['vigencias_hasta'] = $carrera['vigencias_hasta'] ? explode(',', $carrera['vigencias_hasta']) : [];

            // Obtener asignaturas vinculadas a través de la tabla mallas
            $sql_asignaturas = "SELECT 
                                a.id,
                                a.nombre,
                                a.tipo,
                                a.periodicidad,
                                a.estado,
                                m.semestre
                            FROM asignaturas a
                            INNER JOIN mallas m ON a.id = m.asignatura_id
                            WHERE m.carrera_id = ?
                            ORDER BY m.semestre, a.nombre";

            $stmt = $this->pdo->prepare($sql_asignaturas);
            $stmt->execute([$id]);
            $carrera['asignaturas'] = $stmt->fetchAll();

            // Obtener todas las sedes para el selector
            $sql_sedes = "SELECT * FROM sedes ORDER BY nombre";
            $stmt = $this->pdo->prepare($sql_sedes);
            $stmt->execute();
            $sedes = $stmt->fetchAll();

            // Obtener datos del usuario
            $user_id = $this->session->get('user_id');
            $sql_user = "SELECT id, nombre, email FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql_user);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            // Obtener mensajes de sesión y limpiarlos
            $success = $this->session->get('success');
            $error = $this->session->get('error');
            $this->session->remove('success');
            $this->session->remove('error');

            // Renderizar la vista
            echo $this->twig->render('mallas/edit.twig', [
                'carrera' => $carrera,
                'sedes' => $sedes,
                'app_url' => Config::get('app_url'),
                'user' => $user,
                'success' => $success,
                'error' => $error,
                'current_page' => 'mallas',
                'session' => $_SESSION
            ]);
        } catch (\Exception $e) {
            $this->session->set('error', 'Error al obtener los datos de la malla: ' . $e->getMessage());
            header('Location: ' . Config::get('app_url') . 'mallas');
            exit;
        }
    }
} 