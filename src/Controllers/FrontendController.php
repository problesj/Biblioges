<?php

namespace App\Controllers;

use PDO;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FrontendController
{
    private $pdo;

    public function __construct()
    {
        // Crear conexión PDO directamente
        $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Página principal del frontend
     */
    public function index(Request $request, Response $response)
    {
        global $twig;

        // Obtener parámetro de filtro por sede
        $sedeFiltro = $request->getQueryParams()['sede'] ?? null;

        // Obtener todas las sedes disponibles
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT s.id, s.nombre, s.codigo
            FROM sedes s
            INNER JOIN carreras_espejos ce ON s.id = ce.sede_id
            INNER JOIN carreras c ON ce.carrera_id = c.id
            WHERE s.estado = 1 AND c.estado = 1 AND c.tipo_programa = 'P'
            ORDER BY s.nombre
        ");
        $stmt->execute();
        $sedes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir consulta base para carreras
        $sqlCarreras = "
            SELECT DISTINCT 
                c.id, 
                c.nombre, 
                c.tipo_programa, 
                c.imagen_url, 
                c.cantidad_semestres,
                GROUP_CONCAT(DISTINCT s.nombre) as sedes_nombres,
                GROUP_CONCAT(DISTINCT s.id) as sedes_ids
            FROM carreras c
            INNER JOIN carreras_espejos ce ON c.id = ce.carrera_id
            INNER JOIN sedes s ON ce.sede_id = s.id
            WHERE c.estado = 1 AND c.tipo_programa = 'P' AND s.estado = 1
        ";

        $params = [];

        // Aplicar filtro por sede si se especifica
        if ($sedeFiltro && $sedeFiltro !== 'todas') {
            $sqlCarreras .= " AND s.id = :sede_id";
            $params[':sede_id'] = $sedeFiltro;
        }

        $sqlCarreras .= " GROUP BY c.id ORDER BY c.nombre";

        $stmt = $this->pdo->prepare($sqlCarreras);
        $stmt->execute($params);
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Procesar carreras para incluir información de sedes
        foreach ($carreras as &$carrera) {
            $carrera['sedes_nombres'] = explode(',', $carrera['sedes_nombres']);
            $carrera['sedes_ids'] = explode(',', $carrera['sedes_ids']);
            
            // Obtener la primera sede disponible para las URLs
            $carrera['sede_id'] = $carrera['sedes_ids'][0] ?? null;
            $carrera['sede_nombre'] = $carrera['sedes_nombres'][0] ?? null;
        }

        // Debug: log de datos
        error_log("Frontend - Total sedes: " . count($sedes));
        error_log("Frontend - Total carreras: " . count($carreras));
        error_log("Frontend - Sede filtro: " . ($sedeFiltro ?? 'ninguno'));
        
        $html = $twig->render('frontend/index.twig', [
            'carreras' => $carreras,
            'sedes' => $sedes,
            'sede_filtro' => $sedeFiltro
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Mostrar bibliografías de una carrera específica
     */
    public function showCarrera(Request $request, Response $response, array $args)
    {
        global $twig;

        $sedeId = $args['sede_id'] ?? null;
        $carreraId = $args['carrera_id'] ?? null;

        if (!$sedeId || !$carreraId) {
            $response->getBody()->write('Parámetros requeridos no proporcionados');
            return $response->withStatus(400);
        }

        // Obtener información de la sede y carrera
        $stmt = $this->pdo->prepare("
            SELECT 
                s.id as sede_id,
                s.nombre as sede_nombre,
                c.id as carrera_id,
                c.nombre as carrera_nombre,
                c.tipo_programa,
                c.imagen_url,
                c.cantidad_semestres,
                GROUP_CONCAT(DISTINCT s2.nombre) as todas_las_sedes,
                GROUP_CONCAT(DISTINCT s2.id) as todas_las_sedes_ids
            FROM sedes s
            INNER JOIN carreras_espejos ce ON s.id = ce.sede_id
            INNER JOIN carreras c ON ce.carrera_id = c.id
            LEFT JOIN carreras_espejos ce2 ON c.id = ce2.carrera_id
            LEFT JOIN sedes s2 ON ce2.sede_id = s2.id AND s2.estado = 1
            WHERE s.id = :sede_id AND c.id = :carrera_id AND s.estado = 1 AND c.estado = 1
            GROUP BY s.id, c.id
        ");
        $stmt->execute([
            ':sede_id' => $sedeId,
            ':carrera_id' => $carreraId
        ]);
        $carrera = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$carrera) {
            $response->getBody()->write('Carrera no encontrada');
            return $response->withStatus(404);
        }

        // Debug: log de información de la carrera
        error_log("Frontend - Carrera: " . $carrera['carrera_nombre']);
        error_log("Frontend - Sede: " . $carrera['sede_nombre']);
        error_log("Frontend - Sede ID: " . $carrera['sede_id']);

        // Obtener asignaturas de la carrera con sus bibliografías
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT
                m.semestre,
                a.id as asignatura_id,
                a.nombre as asignatura_nombre,
                a.tipo as tipo_asignatura,
                ad.codigo_asignatura
            FROM mallas m
            INNER JOIN asignaturas a ON m.asignatura_id = a.id
            LEFT JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            LEFT JOIN unidades u ON ad.id_unidad = u.id
            WHERE m.carrera_id = :carrera_id 
            AND a.estado = 1
            AND (
                (u.sede_id = :sede_id) OR 
                (a.tipo = 'FORMACION_ELECTIVA')
            )
            ORDER BY m.semestre, a.nombre
        ");
        $stmt->execute([
            ':carrera_id' => $carreraId,
            ':sede_id' => $sedeId
        ]);
        $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar asignaturas por semestre
        $asignaturasPorSemestre = [];
        foreach ($asignaturas as $asignatura) {
            $semestre = $asignatura['semestre'];
            if (!isset($asignaturasPorSemestre[$semestre])) {
                $asignaturasPorSemestre[$semestre] = [];
            }
            $asignaturasPorSemestre[$semestre][] = $asignatura;
        }
        
        // Ordenar semestres numéricamente de menor a mayor
        ksort($asignaturasPorSemestre, SORT_NUMERIC);

        // Obtener bibliografías para cada asignatura
        foreach ($asignaturasPorSemestre as $semestre => &$asignaturasSemestre) {
            foreach ($asignaturasSemestre as &$asignatura) {
                $asignatura['bibliografias'] = $this->getBibliografiasAsignatura($asignatura['asignatura_id'], $sedeId);
                
                // Verificar disponibilidad de bibliografías para cada bibliografía
                foreach ($asignatura['bibliografias'] as &$bibliografia) {
                    $bibliografia['tiene_disponibles'] = $this->tieneBibliografiasDisponibles($bibliografia['id'], $sedeId);
                }
            }
        }

        $html = $twig->render('frontend/carrera.twig', [
            'carrera' => $carrera,
            'asignaturas_por_semestre' => $asignaturasPorSemestre
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Mostrar bibliografías de una asignatura específica
     */
    public function showAsignatura(Request $request, Response $response, array $args)
    {
        global $twig;

        $sedeId = $args['sede_id'] ?? null;
        $carreraId = $args['carrera_id'] ?? null;
        $asignaturaId = $args['asignatura_id'] ?? null;

        if (!$sedeId || !$carreraId || !$asignaturaId) {
            $response->getBody()->write('Parámetros requeridos no proporcionados');
            return $response->withStatus(400);
        }

        // Obtener información de la asignatura
        $stmt = $this->pdo->prepare("
            SELECT 
                s.id as sede_id,
                s.nombre as sede_nombre,
                c.id as carrera_id,
                c.nombre as carrera_nombre,
                a.id as asignatura_id,
                a.nombre as asignatura_nombre,
                a.tipo as tipo_asignatura,
                ad.codigo_asignatura,
                m.semestre
            FROM asignaturas a
            INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            INNER JOIN unidades u ON ad.id_unidad = u.id
            INNER JOIN sedes s ON u.sede_id = s.id
            INNER JOIN mallas m ON a.id = m.asignatura_id
            INNER JOIN carreras c ON m.carrera_id = c.id
            WHERE s.id = :sede_id 
            AND c.id = :carrera_id 
            AND a.id = :asignatura_id
            AND a.estado = 1
        ");
        $stmt->execute([
            ':sede_id' => $sedeId,
            ':carrera_id' => $carreraId,
            ':asignatura_id' => $asignaturaId
        ]);
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$asignatura) {
            $response->getBody()->write('Asignatura no encontrada');
            return $response->withStatus(404);
        }

        // Obtener bibliografías de la asignatura
        $bibliografias = $this->getBibliografiasAsignatura($asignaturaId, $sedeId);

        $html = $twig->render('frontend/asignatura.twig', [
            'asignatura' => $asignatura,
            'bibliografias' => $bibliografias
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Vista pública simplificada: solo bibliografía de una asignatura
     */
    public function showAsignaturaBibliografia(Request $request, Response $response, array $args)
    {
        global $twig;

        $sedeId = $args['sede_id'] ?? null;
        $asignaturaId = $args['asignatura_id'] ?? null;

        if (!$sedeId || !$asignaturaId) {
            $response->getBody()->write('Parámetros requeridos no proporcionados');
            return $response->withStatus(400);
        }

        // Datos mínimos de asignatura y carrera para cabecera
        $stmt = $this->pdo->prepare("
            SELECT 
                s.id as sede_id, s.nombre as sede_nombre,
                c.id as carrera_id, c.nombre as carrera_nombre, c.imagen_url as imagen_url,
                a.id as asignatura_id, a.nombre as asignatura_nombre, 
                COALESCE(a.tipo, 'No especificado') as tipo_asignatura
            FROM asignaturas a
            INNER JOIN asignaturas_departamentos ad ON a.id = ad.asignatura_id
            INNER JOIN unidades u ON ad.id_unidad = u.id
            INNER JOIN sedes s ON u.sede_id = s.id
            INNER JOIN mallas m ON a.id = m.asignatura_id
            INNER JOIN carreras c ON m.carrera_id = c.id
            WHERE s.id = :sede_id AND a.id = :asignatura_id AND a.estado = 1
            LIMIT 1
        ");
        $stmt->execute([':sede_id' => $sedeId, ':asignatura_id' => $asignaturaId]);
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$asignatura) {
            $response->getBody()->write('Asignatura no encontrada');
            return $response->withStatus(404);
        }

        // Debug: asegurar que tipo_asignatura no sea null
        if (!isset($asignatura['tipo_asignatura']) || $asignatura['tipo_asignatura'] === null) {
            $asignatura['tipo_asignatura'] = 'No especificado';
        }

        // Obtener bibliografías (reuse)
        $bibliografias = $this->getBibliografiasAsignatura($asignaturaId, $sedeId);

        // Verificar disponibilidad de bibliografías para cada bibliografía
        foreach ($bibliografias as &$bibliografia) {
            $bibliografia['tiene_disponibles'] = $this->tieneBibliografiasDisponibles($bibliografia['id'], $sedeId);
        }

        $html = $twig->render('frontend/asignatura_biblio.twig', [
            'asignatura' => $asignatura,
            'bibliografias' => $bibliografias
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Obtener bibliografías de una asignatura
     */
    private function getBibliografiasAsignatura($asignaturaId, $sedeId = null)
    {
        // Primero verificar si es una asignatura electiva
        $stmt = $this->pdo->prepare("SELECT tipo FROM asignaturas WHERE id = ?");
        $stmt->execute([$asignaturaId]);
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($asignatura && $asignatura['tipo'] === 'FORMACION_ELECTIVA') {
            // Para asignaturas electivas, obtener bibliografías de las asignaturas vinculadas
            $stmt = $this->pdo->prepare("
                SELECT 
                    bd.id,
                    bd.titulo,
                    bd.tipo,
                    bd.anio_publicacion,
                    bd.editorial,
                    bd.edicion,
                    bd.url,
                    bd.formato,
                    ab.tipo_bibliografia,
                    GROUP_CONCAT(CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores
                FROM asignaturas_formacion af
                INNER JOIN asignaturas_bibliografias ab ON af.asignatura_regular_id = ab.asignatura_id
                INNER JOIN bibliografias_declaradas bd ON ab.bibliografia_id = bd.id
                LEFT JOIN bibliografias_autores ba ON bd.id = ba.bibliografia_id
                LEFT JOIN autores a ON ba.autor_id = a.id
                WHERE af.asignatura_formacion_id = :asignatura_id
                AND ab.estado = 'activa'
                AND bd.estado = 1
                GROUP BY bd.id, ab.tipo_bibliografia
                ORDER BY ab.tipo_bibliografia, bd.titulo
            ");
        } else {
            // Para asignaturas regulares, obtener bibliografías directamente
            $stmt = $this->pdo->prepare("
                SELECT 
                    bd.id,
                    bd.titulo,
                    bd.tipo,
                    bd.anio_publicacion,
                    bd.editorial,
                    bd.edicion,
                    bd.url,
                    bd.formato,
                    ab.tipo_bibliografia,
                    GROUP_CONCAT(CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores
                FROM asignaturas_bibliografias ab
                INNER JOIN bibliografias_declaradas bd ON ab.bibliografia_id = bd.id
                LEFT JOIN bibliografias_autores ba ON bd.id = ba.bibliografia_id
                LEFT JOIN autores a ON ba.autor_id = a.id
                WHERE ab.asignatura_id = :asignatura_id
                AND ab.estado = 'activa'
                AND bd.estado = 1
                GROUP BY bd.id, ab.tipo_bibliografia
                ORDER BY ab.tipo_bibliografia, bd.titulo
            ");
        }
        
        $stmt->execute([':asignatura_id' => $asignaturaId]);
        $bibliografias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener información específica según el tipo
        foreach ($bibliografias as &$bibliografia) {
            $bibliografia['detalles'] = $this->getDetallesBibliografia($bibliografia['id'], $bibliografia['tipo']);
            $bibliografia['disponibles'] = $this->getBibliografiasDisponibles($bibliografia['id']);
        }

        return $bibliografias;
    }

    /**
     * Obtener detalles específicos de una bibliografía según su tipo
     */
    private function getDetallesBibliografia($bibliografiaId, $tipo)
    {
        switch ($tipo) {
            case 'libro':
                $stmt = $this->pdo->prepare("SELECT isbn FROM libros WHERE bibliografia_id = :id");
                break;
            case 'articulo':
                $stmt = $this->pdo->prepare("SELECT issn, titulo_revista, cronologia FROM articulos WHERE bibliografia_id = :id");
                break;
            case 'tesis':
                $stmt = $this->pdo->prepare("
                    SELECT t.nombre_carrera as carrera_nombre 
                    FROM tesis t 
                    WHERE t.bibliografia_id = :id
                ");
                break;
            default:
                return null;
        }

        $stmt->execute([':id' => $bibliografiaId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener bibliografías disponibles de una bibliografía declarada
     */
    private function getBibliografiasDisponibles($bibliografiaDeclaradaId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                bd.id,
                bd.titulo,
                bd.editorial,
                bd.anio_edicion,
                bd.url_acceso,
                bd.url_catalogo,
                bd.disponibilidad,
                bd.ejemplares_digitales,
                GROUP_CONCAT(CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores
            FROM bibliografias_disponibles bd
            LEFT JOIN bibliografias_disponibles_autores bda ON bd.id = bda.bibliografia_disponible_id
            LEFT JOIN autores a ON bda.autor_id = a.id
            WHERE bd.bibliografia_declarada_id = :bibliografia_declarada_id
            AND bd.estado = 1
            GROUP BY bd.id
            ORDER BY bd.titulo
        ");
        $stmt->execute([':bibliografia_declarada_id' => $bibliografiaDeclaradaId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si una bibliografía declarada tiene bibliografías disponibles en una sede
     * Se muestra el botón si hay:
     * - Bibliografías electrónicas (cualquier sede)
     * - Bibliografías "ambos" (cualquier sede) 
     * - Bibliografías impresas con ejemplares en la sede específica
     */
    private function tieneBibliografiasDisponibles($bibliografiaDeclaradaId, $sedeId)
    {
        $sql = "
            SELECT COUNT(*) as count
            FROM bibliografias_disponibles bd
            LEFT JOIN bibliografias_disponibles_sedes bds ON bd.id = bds.bibliografia_disponible_id
            WHERE bd.bibliografia_declarada_id = :bibliografia_declarada_id
            AND bd.estado = 1
            AND (
                bd.disponibilidad = 'electronico'
                OR 
                bd.disponibilidad = 'ambos'
                OR 
                (bd.disponibilidad = 'impreso' AND bds.sede_id = :sede_id AND bds.ejemplares > 0)
            )
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':bibliografia_declarada_id' => $bibliografiaDeclaradaId,
            ':sede_id' => $sedeId
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /**
     * API endpoint para obtener bibliografías disponibles de una bibliografía declarada
     */
    public function apiGetBibliografiasDisponibles(Request $request, Response $response, array $args)
    {
        $bibliografiaId = $args['bibliografia_id'] ?? null;
        $sedeId = $request->getQueryParams()['sede_id'] ?? null;
        
        

        if (!$bibliografiaId) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID de bibliografía requerido'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            // Construir consulta base con lógica de sede:
            // - electrónicos y 'ambos': siempre aparecen (independiente de sede)
            // - impresos: sólo aparecen si hay registros para la sede indicada (si se envía sede)
            $params = [':bibliografia_declarada_id' => $bibliografiaId];
            $ejemplaresExpr = "COALESCE(SUM(bds.ejemplares), 0)";
            $sedeFilterExpr = "1=1";
            if ($sedeId) {
                $params[':sede_id'] = $sedeId;
                $ejemplaresExpr = "COALESCE(SUM(CASE WHEN bds.sede_id = :sede_id THEN bds.ejemplares ELSE 0 END), 0)";
                $sedeFilterExpr = "(bd.disponibilidad IN ('electronico','ambos') OR (bd.disponibilidad = 'impreso' AND bds.sede_id = :sede_id))";
            }

            $sql = "
                SELECT 
                    bd.id,
                    bd.titulo,
                    bd.anio_edicion,
                    bd.editorial,
                    bd.url_acceso,
                    bd.url_catalogo,
                    bd.disponibilidad,
                    bd.ejemplares_digitales,
                    GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) SEPARATOR '; ') as autores,
                    $ejemplaresExpr as ejemplares_fisicos
                FROM bibliografias_disponibles bd
                LEFT JOIN bibliografias_disponibles_autores bda ON bd.id = bda.bibliografia_disponible_id
                LEFT JOIN autores a ON bda.autor_id = a.id
                LEFT JOIN bibliografias_disponibles_sedes bds ON bd.id = bds.bibliografia_disponible_id
                WHERE bd.bibliografia_declarada_id = :bibliografia_declarada_id
                AND bd.estado = 1
                AND $sedeFilterExpr
                GROUP BY bd.id, bd.titulo, bd.anio_edicion, bd.editorial, bd.url_acceso, bd.url_catalogo, bd.disponibilidad, bd.ejemplares_digitales
                ORDER BY bd.titulo";
            
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            $bibliografias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response->getBody()->write(json_encode([
                'success' => true,
                'bibliografias' => $bibliografias
            ]));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Error al obtener bibliografías disponibles: ' . $e->getMessage()
            ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
}

} 