<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Session;
use src\Models\Usuario;
use PDO;
use PDOException;
use App\Core\Config;

class DashboardController extends BaseController
{
    protected $session;
    protected $userModel;
    protected $pdo;

    /** Tipo de tarea programada => etiqueta */
    private const TIPOS_TAREA = [
        'cobertura_basica_expandido' => 'Cobertura básica',
        'cobertura_complementaria_expandido' => 'Cobertura complementaria',
        'cobertura_ambas_expandido' => 'Cobertura básica y complementaria',
        'actualizar_copias_alma' => 'Copias desde Alma',
    ];

    private const ETIQUETAS_DISPONIBILIDAD = [
        'impreso' => 'Impreso',
        'electronico' => 'Electrónico',
        'ambos' => 'Ambos',
    ];

    private const COLORES_DISPONIBILIDAD = [
        'impreso' => '#4e73df',
        'electronico' => '#36b9cc',
        'ambos' => '#6f42c1',
    ];

    /** Segundos que se reutilizan los indicadores calculados (gráficos) antes de recalcularlos */
    private const SEGUNDOS_CACHE_INDICADORES = 600;

    /** Errores al calcular los indicadores: si los hay, el resultado no se guarda en caché */
    private array $erroresIndicadores = [];

    /** Mismo orden y colores que el reporte de Antigüedad (verde, amarillo, rojo) */
    private const COLORES_ANTIGUEDAD = [
        'verde' => '#1cc88a',
        'amarillo' => '#f6c23e',
        'rojo' => '#e74a3b',
        'sin_info' => '#858796',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->userModel = new Usuario();

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

    public function index($request, $response, $args = [])
    {
        // Verificar autenticación
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Por favor inicie sesión para acceder al dashboard';
            return $response
                ->withHeader('Location', '/biblioges/login')
                ->withStatus(302);
        }

        // Obtener datos del usuario
        $user = $this->userModel->find($_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            $_SESSION['error'] = 'Usuario no encontrado';
            return $response
                ->withHeader('Location', '/biblioges/login')
                ->withStatus(302);
        }

        // Totales
        $totalBibliografias = (int) $this->pdo->query("SELECT COUNT(*) FROM bibliografias_declaradas")->fetchColumn();
        $totalDisponibles = (int) $this->pdo->query("SELECT COUNT(*) FROM bibliografias_disponibles")->fetchColumn();
        $totalAsignaturas = (int) $this->pdo->query("SELECT COUNT(*) FROM asignaturas")->fetchColumn();
        $totalCarreras = (int) $this->pdo->query("SELECT COUNT(*) FROM carreras")->fetchColumn();

        // Declaradas sin ninguna bibliografía disponible activa
        $sinDisponible = (int) $this->pdo->query("
            SELECT COUNT(*)
              FROM bibliografias_declaradas bd
             WHERE NOT EXISTS (SELECT 1 FROM bibliografias_disponibles d
                                WHERE d.bibliografia_declarada_id = bd.id AND d.estado = 1)
        ")->fetchColumn();
        $porcentajeSinDisponible = $totalBibliografias > 0 ? round($sinDisponible * 100 / $totalBibliografias, 1) : 0;

        // Obtener bibliografías recientes con sus autores
        $bibliografiasRecientes = $this->pdo->query("
            SELECT 
                b.titulo,
                b.tipo,
                b.formato,
                COALESCE(
                    GROUP_CONCAT(CONCAT(au.apellidos, ', ', au.nombres) SEPARATOR '; '),
                    'Sin información'
                ) as autores
            FROM bibliografias_declaradas b 
            LEFT JOIN bibliografias_autores ba ON b.id = ba.bibliografia_id
            LEFT JOIN autores au ON ba.autor_id = au.id
            GROUP BY b.id, b.titulo, b.tipo, b.formato
            ORDER BY b.id DESC 
            LIMIT 5
        ")->fetchAll();

        // Obtener asignaturas recientes
        $asignaturasRecientes = $this->pdo->query("
            SELECT 
                nombre,
                tipo,
                periodicidad
            FROM asignaturas
            ORDER BY id DESC
            LIMIT 5
        ")->fetchAll();

        // Los gráficos (cálculo de varios segundos) se cargan después por AJAX desde indicadores()
        $esAdmin = ($user['rol'] ?? '') === 'admin';

        // Renderizar la vista
        $body = $this->twig->render('dashboard/index.twig', [
            'session' => [
                'user' => $user,
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'user_nombre' => $user['nombre'],
                'user_rol' => $user['rol']
            ],
            'totalBibliografias' => $totalBibliografias,
            'totalDisponibles' => $totalDisponibles,
            'totalAsignaturas' => $totalAsignaturas,
            'totalCarreras' => $totalCarreras,
            'sinDisponible' => $sinDisponible,
            'porcentajeSinDisponible' => $porcentajeSinDisponible,
            'bibliografiasRecientes' => $bibliografiasRecientes,
            'asignaturasRecientes' => $asignaturasRecientes,
            'tareas' => $esAdmin ? $this->ultimasTareas() : [],
            'app_url' => Config::get('app_url'),
            'current_path' => 'dashboard'
        ]);
        $response->getBody()->write($body);
        return $response;
    }

    /**
     * Datos de los gráficos del Dashboard en JSON. Se reutilizan durante SEGUNDOS_CACHE_INDICADORES
     * (archivo en cache/) para no repetir el cálculo de coberturas en cada visita.
     */
    public function indicadores($request, $response, $args = [])
    {
        if (!isset($_SESSION['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Sesión expirada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $archivo = dirname(__DIR__, 2) . '/cache/dashboard_indicadores.json';
        $json = null;
        if (is_file($archivo) && time() - filemtime($archivo) < self::SEGUNDOS_CACHE_INDICADORES) {
            $json = @file_get_contents($archivo) ?: null;
        }
        if ($json === null) {
            $json = json_encode($this->calcularIndicadores(), JSON_UNESCAPED_UNICODE);
            if (!$this->erroresIndicadores) {
                $temporal = $archivo . '.' . getmypid() . '.tmp';
                if (@file_put_contents($temporal, $json) !== false) {
                    @rename($temporal, $archivo);
                }
            }
        }

        $response->getBody()->write($json);
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Cache-Control', 'no-store');
    }

    private function calcularIndicadores(): array
    {
        $this->erroresIndicadores = [];
        [$mayores, $menores, $planesEvaluados] = $this->rankingCobertura();
        $disponibilidad = $this->distribucionDisponibilidad();
        $antiguedad = $this->distribucionAntiguedad();

        return [
            'mayores' => $mayores,
            'menores' => $menores,
            'planes_evaluados' => $planesEvaluados,
            'disponibilidad' => $disponibilidad,
            'total_disponibles_activas' => array_sum(array_column($disponibilidad, 'cantidad')),
            'antiguedad' => $antiguedad,
            'total_antiguedad' => array_sum(array_column($antiguedad, 'cantidad')),
            'generado' => date('d/m/Y H:i'),
        ];
    }

    /**
     * Cobertura básica en tiempo real (misma regla que el reporte de Cobertura) de los planes vigentes de pregrado:
     * carrera activa, plan activo y con vigencia hasta el año en curso o posterior. Se excluyen los planes sin
     * títulos básicos declarados, que aparecerían con 0 % sin serlo realmente.
     *
     * @return array{0: array, 1: array, 2: int} 10 mayores, 10 menores y cantidad de planes evaluados
     */
    private function rankingCobertura(): array
    {
        try {
            $planes = $this->pdo->query("
                SELECT c.id AS carrera_id, c.nombre, s.id AS sede_id, s.nombre AS sede,
                       ce.codigo_carrera AS codigo, ce.vigencia_desde, ce.vigencia_hasta
                  FROM carreras c
                  JOIN carreras_espejos ce ON ce.carrera_id = c.id
                  JOIN sedes s ON s.id = ce.sede_id
                 WHERE c.estado = 1
                   AND c.tipo_programa = 'P'
                   AND ce.estado = 1
                   AND ce.vigencia_hasta >= CONCAT(YEAR(CURDATE()), '00')
                 ORDER BY c.nombre, s.nombre, ce.codigo_carrera
            ")->fetchAll(PDO::FETCH_OBJ);
            if (!$planes) {
                return [[], [], 0];
            }

            $reporte = new ReporteController();
            $coberturas = $reporte->coberturasTiempoRealLote($planes);
            $declarados = $reporte->declaradosLote;

            // Etiqueta "Carrera - Sede"; se agrega el código solo si hay más de un plan con la misma etiqueta
            $repetidas = [];
            foreach ($planes as $p) {
                $etiqueta = $p->nombre . ' - ' . $p->sede;
                $repetidas[$etiqueta] = ($repetidas[$etiqueta] ?? 0) + 1;
            }

            $filas = [];
            foreach ($planes as $p) {
                $clave = implode('|', [$p->carrera_id, $p->sede_id, $p->codigo, $p->vigencia_desde, $p->vigencia_hasta]);
                $valor = $coberturas[$clave]['basica'] ?? null;
                $total = (int) ($declarados[$clave]['basica'] ?? 0);
                if (!is_numeric($valor) || $total === 0) {
                    continue;
                }
                $etiqueta = $p->nombre . ' - ' . $p->sede;
                if ($repetidas[$etiqueta] > 1) {
                    $etiqueta .= ' (' . $p->codigo . ')';
                }
                $filas[] = [
                    'etiqueta' => $etiqueta,
                    'codigo' => (string) $p->codigo,
                    'cobertura' => (float) $valor,
                    'declarados' => $total,
                    'disponibles' => (int) round($valor * $total / 100),
                ];
            }

            $mayores = $filas;
            usort($mayores, static fn ($a, $b) => [$b['cobertura'], $a['etiqueta']] <=> [$a['cobertura'], $b['etiqueta']]);
            $menores = $filas;
            usort($menores, static fn ($a, $b) => [$a['cobertura'], $a['etiqueta']] <=> [$b['cobertura'], $b['etiqueta']]);

            return [array_slice($mayores, 0, 10), array_slice($menores, 0, 10), count($filas)];
        } catch (\Throwable $e) {
            $this->erroresIndicadores[] = $e->getMessage();
            error_log('DashboardController: error al calcular coberturas: ' . $e->getMessage());
            return [[], [], 0];
        }
    }

    /** Bibliografías disponibles activas por tipo de recurso. */
    private function distribucionDisponibilidad(): array
    {
        try {
            $conteos = $this->pdo->query("
                SELECT disponibilidad, COUNT(*) FROM bibliografias_disponibles WHERE estado = 1 GROUP BY disponibilidad
            ")->fetchAll(PDO::FETCH_KEY_PAIR);

            return $this->distribucion($conteos, self::ETIQUETAS_DISPONIBILIDAD, self::COLORES_DISPONIBILIDAD);
        } catch (\Throwable $e) {
            $this->erroresIndicadores[] = $e->getMessage();
            error_log('DashboardController: error en distribución por disponibilidad: ' . $e->getMessage());
            return [];
        }
    }

    /** Declaradas (básicas y complementarias) con disponibles activas, por antigüedad, igual que el reporte. */
    private function distribucionAntiguedad(): array
    {
        try {
            $conteos = (new AntiguedadBibliografiaController())->resumenGeneral();
            $etiquetas = [];
            foreach (array_keys(self::COLORES_ANTIGUEDAD) as $clave) {
                $etiquetas[$clave] = AntiguedadBibliografiaController::ANTIGUEDADES[$clave];
            }

            return $this->distribucion($conteos, $etiquetas, self::COLORES_ANTIGUEDAD);
        } catch (\Throwable $e) {
            $this->erroresIndicadores[] = $e->getMessage();
            error_log('DashboardController: error en distribución por antigüedad: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * @param array<string, int|string> $conteos   clave => cantidad
     * @param array<string, string>     $etiquetas clave => etiqueta (define el orden)
     * @return array<int, array{clave: string, etiqueta: string, cantidad: int, porcentaje: float, color: string}>
     */
    private function distribucion(array $conteos, array $etiquetas, array $colores): array
    {
        $total = 0;
        foreach ($etiquetas as $clave => $_) {
            $total += (int) ($conteos[$clave] ?? 0);
        }
        if ($total === 0) {
            return [];
        }
        $filas = [];
        foreach ($etiquetas as $clave => $etiqueta) {
            $cantidad = (int) ($conteos[$clave] ?? 0);
            $filas[] = [
                'clave' => $clave,
                'etiqueta' => $etiqueta,
                'cantidad' => $cantidad,
                'porcentaje' => round($cantidad * 100 / $total, 1),
                'color' => $colores[$clave],
            ];
        }

        return $filas;
    }

    /** Tareas programadas no canceladas con su última ejecución (solo administradores). */
    private function ultimasTareas(): array
    {
        try {
            $filas = $this->pdo->query("
                SELECT t.id, t.nombre, t.tipo_reporte, t.estado, t.fecha_programada,
                       e.id AS ejecucion_id, e.tipo_reporte AS ejecucion_tipo, e.fecha_inicio,
                       e.estado AS estado_ejecucion, e.simulacion
                  FROM tareas_programadas t
                  LEFT JOIN tareas_programadas_ejecuciones e
                         ON e.id = (SELECT MAX(e2.id) FROM tareas_programadas_ejecuciones e2 WHERE e2.tarea_id = t.id)
                 WHERE t.estado <> 'cancelada'
                 ORDER BY (e.fecha_inicio IS NULL), e.fecha_inicio DESC, t.id DESC
                 LIMIT 6
            ")->fetchAll();
        } catch (\Throwable $e) {
            error_log('DashboardController: error al leer tareas programadas: ' . $e->getMessage());
            return [];
        }

        foreach ($filas as &$fila) {
            $fila['tipo_etiqueta'] = self::TIPOS_TAREA[$fila['tipo_reporte']] ?? $fila['tipo_reporte'];
            // Las ejecuciones de copias Alma tienen su propio reporte; las de cobertura se ven en Tareas Programadas
            $fila['url'] = ($fila['ejecucion_tipo'] ?? '') === 'copias_alma'
                ? 'tareas-programadas/ejecuciones/' . (int) $fila['ejecucion_id']
                : 'tareas-programadas';
        }
        unset($fila);

        return $filas;
    }
}
