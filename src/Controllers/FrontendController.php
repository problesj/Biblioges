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

        // Obtener solo carreras de pregrado activas
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT c.id, c.nombre, c.tipo_programa, c.imagen_url, c.cantidad_semestres
            FROM carreras c
            INNER JOIN carreras_espejos ce ON c.id = ce.carrera_id
            WHERE c.estado = 1 
            AND c.tipo_programa = 'P'
            ORDER BY c.nombre
        ");
        $stmt->execute();
        $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener la primera sede disponible para cada carrera (para las URLs)
        foreach ($carreras as &$carrera) {
            $stmt = $this->pdo->prepare("
                SELECT sede_id, codigo_carrera
                FROM carreras_espejos
                WHERE carrera_id = :carrera_id
                LIMIT 1
            ");
            $stmt->execute([':carrera_id' => $carrera['id']]);
            $carreraEspejo = $stmt->fetch(PDO::FETCH_ASSOC);
            $carrera['sede_id'] = $carreraEspejo['sede_id'] ?? null;
        }

        $html = $twig->render('frontend/index.twig', [
            'carreras' => $carreras
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
                c.cantidad_semestres
            FROM sedes s
            INNER JOIN carreras_espejos ce ON s.id = ce.sede_id
            INNER JOIN carreras c ON ce.carrera_id = c.id
            WHERE s.id = :sede_id AND c.id = :carrera_id AND s.estado = 1 AND c.estado = 1
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
                $asignatura['bibliografias'] = $this->getBibliografiasAsignatura($asignatura['asignatura_id']);
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
        $bibliografias = $this->getBibliografiasAsignatura($asignaturaId);

        $html = $twig->render('frontend/asignatura.twig', [
            'asignatura' => $asignatura,
            'bibliografias' => $bibliografias
        ]);

        $response->getBody()->write($html);
        return $response;
    }

    /**
     * Obtener bibliografías de una asignatura
     */
    private function getBibliografiasAsignatura($asignaturaId)
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
     * API endpoint para obtener bibliografías disponibles de una bibliografía declarada
     */
    public function apiGetBibliografiasDisponibles(Request $request, Response $response, array $args)
    {
        $bibliografiaId = $args['bibliografia_id'] ?? null;

        if (!$bibliografiaId) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID de bibliografía requerido'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    bd.id,
                    bd.titulo,
                    bd.anio_edicion,
                    bd.editorial,
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
            $stmt->execute([':bibliografia_declarada_id' => $bibliografiaId]);
            
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