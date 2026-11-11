<?php

namespace App\Controllers;

use App\Core\ListStateManager;
use App\Core\Session;
use Illuminate\Database\Capsule\Manager as DB;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Reporte "Impresos en una sola sede".
 *
 * Lista las bibliografías declaradas que cumplen ambas condiciones:
 *  - tienen vínculos activos (básicos y/o complementarios) con asignaturas de dos o más sedes.
 *    La sede de una asignatura es la de la unidad de cada uno de sus códigos;
 *  - todas sus bibliografías disponibles activas son solo impresas (ninguna electrónica ni "ambos")
 *    y, en conjunto, tienen ejemplares en una única sede.
 * La sede especial "Sin Sede" (id 0) no se considera.
 */
class ImpresosUnaSedeController
{
    private const LISTADO = 'reporte_impresos_sede';

    /** Sede especial para registros sin sede: no cuenta como sede */
    private const SIN_SEDE = 0;

    /** Filtro básica / complementaria => tipos de vínculo incluidos */
    private const TIPOS_BIBLIOGRAFIA = [
        'ambas' => ['basica', 'complementaria'],
        'basica' => ['basica'],
        'complementaria' => ['complementaria'],
    ];

    private const ETIQUETAS_VINCULO = ['basica' => 'Básica', 'complementaria' => 'Complementaria'];

    private const TIPOS = ['libro', 'articulo', 'tesis', 'software', 'sitio_web', 'generico'];

    /** Columna ordenable => expresión SQL sobre la consulta base (alias t) */
    private const COLUMNAS_ORDEN = [
        'titulo' => 't.titulo',
        'autores' => 't.autores',
        'anio_publicacion' => 't.anio_publicacion',
        'editorial' => 't.editorial',
        'num_asignaturas' => 't.num_asignaturas',
        'num_sedes' => 't.num_sedes',
        'sede_ejemplares' => 't.sede_ejemplares',
        'ejemplares' => 't.ejemplares',
    ];

    public function index(Request $request, Response $response, array $args = []): Response
    {
        $stateManager = new ListStateManager(new Session(), self::LISTADO);
        $state = $stateManager->getState($request->getQueryParams());
        $stateManager->saveState($state);

        $sedes = $this->sedes();
        $filtros = $this->filtros($state, $sedes);
        $page = max(1, (int) $state['page']);
        $perPage = (int) $state['per_page'];
        [$sort, $direction] = $this->orden($state);

        [$base, $params] = $this->consultaBase($filtros);
        [$donde, $paramsFiltrados] = $this->filtroSedeEjemplares($filtros, $params);

        // Resumen por sede con ejemplares (sin aplicar ese filtro); de él sale el total
        $resumen = array_fill_keys(array_keys($sedes), 0);
        foreach (DB::select("SELECT t.sede_ejemplares_id, COUNT(*) AS n FROM ({$base}) t GROUP BY t.sede_ejemplares_id", $params) as $fila) {
            $resumen[(int) $fila->sede_ejemplares_id] = (int) $fila->n;
        }
        $total = $filtros['sede_ejemplares'] === '' ? array_sum($resumen) : ($resumen[(int) $filtros['sede_ejemplares']] ?? 0);

        $totalPages = (int) ceil($total / $perPage);
        if ($totalPages > 0 && $page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $perPage;

        $filas = DB::select(
            "SELECT t.* FROM ({$base}) t{$donde}
             ORDER BY " . self::COLUMNAS_ORDEN[$sort] . " {$direction}, t.titulo ASC, t.id ASC
             LIMIT {$perPage} OFFSET {$offset}",
            $paramsFiltrados
        );
        $bibliografias = $this->armarFilas($filas, self::TIPOS_BIBLIOGRAFIA[$filtros['tipo_bibliografia']], $sedes);
        $filtrosUrl = array_filter($filtros, static fn ($v) => $v !== '');

        global $twig;
        $html = $twig->render('reportes/impresos_una_sede/index.twig', [
            'bibliografias' => $bibliografias,
            'sedes' => $sedes,
            'filtros' => $filtros,
            'resumen' => $resumen,
            'total_sin_filtro_sede' => array_sum($resumen),
            'url_exportar' => app_url('reportes/impresos-una-sede/exportar') . ($filtrosUrl ? '?' . http_build_query($filtrosUrl) : ''),
            'session' => [
                'user_id' => $_SESSION['user_id'] ?? null,
                'user_email' => $_SESSION['user_email'] ?? null,
                'user_nombre' => $_SESSION['user_nombre'] ?? null,
                'user_rol' => $_SESSION['user_rol'] ?? null,
            ],
            'app_url' => app_url(),
            'current_page' => 'impresos-una-sede',
            'paginacion' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_records' => $total,
                'total_pages' => $totalPages,
                'has_previous' => $page > 1,
                'has_next' => $page < $totalPages,
                'previous_page' => $page - 1,
                'next_page' => $page + 1,
                'allowed_per_page' => [5, 10, 15, 20],
            ],
            'ordenamiento' => [
                'column' => $sort,
                'direction' => $direction,
            ],
        ]);
        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html');
    }

    public function clearState(Request $request, Response $response, array $args = []): Response
    {
        (new ListStateManager(new Session(), self::LISTADO))->clearState();

        return $response->withHeader('Location', app_url('reportes/impresos-una-sede'))->withStatus(302);
    }

    /**
     * Exporta a Excel el listado completo con los filtros y el orden actuales, más una hoja con
     * el detalle de asignaturas por sede.
     */
    public function exportar(Request $request, Response $response, array $args = []): Response
    {
        $state = (new ListStateManager(new Session(), self::LISTADO))->getState($request->getQueryParams());
        $sedes = $this->sedes();
        $filtros = $this->filtros($state, $sedes);
        [$sort, $direction] = $this->orden($state);

        [$base, $params] = $this->consultaBase($filtros);
        [$donde, $paramsFiltrados] = $this->filtroSedeEjemplares($filtros, $params);
        $filas = DB::select(
            "SELECT t.* FROM ({$base}) t{$donde}
             ORDER BY " . self::COLUMNAS_ORDEN[$sort] . " {$direction}, t.titulo ASC, t.id ASC",
            $paramsFiltrados
        );
        $bibliografias = $this->armarFilas($filas, self::TIPOS_BIBLIOGRAFIA[$filtros['tipo_bibliografia']], $sedes);

        $estiloEncabezado = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];
        $estiloBordes = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFBFBF']]]];
        $texto = static function ($hoja, string $celda, $valor): void {
            $hoja->setCellValueExplicit($celda, (string) $valor, DataType::TYPE_STRING);
        };

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle('Listado');
        $hoja->fromArray(['Título', 'Autor(es)', 'Año Edición', 'Editorial', 'Tipo', 'Estado', 'N° Asignaturas Vinculadas',
            'Sedes con asignaturas', 'Sede con ejemplares', 'Ejemplares', 'Sedes sin ejemplares'], null, 'A1');
        $hoja->getStyle('A1:K1')->applyFromArray($estiloEncabezado);

        $fila = 2;
        foreach ($bibliografias as $b) {
            $texto($hoja, 'A' . $fila, $b['titulo']);
            $texto($hoja, 'B' . $fila, $b['autores'] ?: 'Sin autores');
            $hoja->setCellValue('C' . $fila, (int) $b['anio_publicacion'] > 0 ? (int) $b['anio_publicacion'] : 'N/A');
            $texto($hoja, 'D' . $fila, $b['editorial'] ?: 'N/A');
            $hoja->setCellValue('E' . $fila, ucfirst(str_replace('_', ' ', (string) $b['tipo'])));
            $hoja->setCellValue('F' . $fila, (int) $b['estado'] === 1 ? 'Activo' : 'Inactivo');
            $hoja->setCellValue('G' . $fila, (int) $b['num_asignaturas']);
            $texto($hoja, 'H' . $fila, implode('; ', array_map(
                static fn ($s) => $s['nombre'] . ' (' . count($s['asignaturas']) . ')',
                $b['sedes']
            )));
            $texto($hoja, 'I' . $fila, $b['sede_ejemplares']);
            $hoja->setCellValue('J' . $fila, (int) $b['ejemplares']);
            $texto($hoja, 'K' . $fila, implode('; ', $b['sedes_sin_ejemplares']));
            $hoja->getStyle('K' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFC7CE');
            $fila++;
        }
        $ultima = max(1, $fila - 1);
        $hoja->getStyle('A1:K' . $ultima)->applyFromArray($estiloBordes);
        foreach (['A' => 60, 'B' => 40, 'C' => 12, 'D' => 30, 'E' => 12, 'F' => 10, 'G' => 14, 'H' => 34, 'I' => 20, 'J' => 12, 'K' => 30] as $col => $ancho) {
            $hoja->getColumnDimension($col)->setWidth($ancho);
        }
        $hoja->getStyle('C2:C' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->getStyle('E2:G' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->getStyle('J2:J' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->setAutoFilter('A1:K' . $ultima);
        $hoja->freezePane('A2');

        // Detalle: una fila por asignatura vinculada y sede
        $detalle = $spreadsheet->createSheet();
        $detalle->setTitle('Asignaturas por sede');
        $detalle->fromArray(['Título', 'Sede', 'Código Asignatura', 'Asignatura', 'Bibliografía', 'Ejemplares en la sede'], null, 'A1');
        $detalle->getStyle('A1:F1')->applyFromArray($estiloEncabezado);
        $fila = 2;
        foreach ($bibliografias as $b) {
            foreach ($b['sedes'] as $sede) {
                foreach ($sede['asignaturas'] as $asignatura) {
                    $texto($detalle, 'A' . $fila, $b['titulo']);
                    $texto($detalle, 'B' . $fila, $sede['nombre']);
                    $texto($detalle, 'C' . $fila, $asignatura['codigo']);
                    $texto($detalle, 'D' . $fila, $asignatura['nombre']);
                    $detalle->setCellValue('E' . $fila, $asignatura['tipo']);
                    $detalle->setCellValue('F' . $fila, $sede['con_ejemplares'] ? 'Sí' : 'No');
                    $detalle->getStyle('F' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($sede['con_ejemplares'] ? 'C6EFCE' : 'FFC7CE');
                    $fila++;
                }
            }
        }
        $ultima = max(1, $fila - 1);
        $detalle->getStyle('A1:F' . $ultima)->applyFromArray($estiloBordes);
        foreach (['A' => 60, 'B' => 20, 'C' => 18, 'D' => 50, 'E' => 16, 'F' => 14] as $col => $ancho) {
            $detalle->getColumnDimension($col)->setWidth($ancho);
        }
        $detalle->getStyle('E2:F' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $detalle->setAutoFilter('A1:F' . $ultima);
        $detalle->freezePane('A2');

        // Criterios del reporte
        $criterios = $spreadsheet->createSheet();
        $criterios->setTitle('Criterios');
        $lineas = [
            'Bibliografías declaradas con vínculos activos a asignaturas de dos o más sedes (sede de la unidad de cada código de asignatura).',
            'Todas sus bibliografías disponibles activas son solo impresas (ninguna electrónica ni "ambos") y en conjunto tienen ejemplares en una única sede.',
            'Bibliografía considerada: ' . ['ambas' => 'básica y complementaria', 'basica' => 'solo básica', 'complementaria' => 'solo complementaria'][$filtros['tipo_bibliografia']] . '.',
            'No se considera la sede "Sin Sede". Generado el ' . date('d-m-Y H:i') . '.',
        ];
        foreach ($lineas as $i => $linea) {
            $criterios->setCellValue('A' . ($i + 1), $linea);
        }
        $criterios->getColumnDimension('A')->setWidth(140);
        $spreadsheet->setActiveSheetIndex(0);

        ob_start();
        (new Xlsx($spreadsheet))->save('php://output');
        $contenido = ob_get_clean();
        $response->getBody()->write($contenido);

        return $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="impresos_una_sede_' . date('Y-m-d_H-i') . '.xlsx"')
            ->withHeader('Cache-Control', 'max-age=0');
    }

    /**
     * @return array<int, string> id => nombre de las sedes reales (sin "Sin Sede"), por nombre
     */
    private function sedes(): array
    {
        $sedes = [];
        foreach (DB::select('SELECT id, nombre FROM sedes WHERE id <> ? ORDER BY nombre', [self::SIN_SEDE]) as $sede) {
            $sedes[(int) $sede->id] = (string) $sede->nombre;
        }

        return $sedes;
    }

    /**
     * Normaliza los filtros del estado del listado (todos como texto, '' = sin filtro).
     */
    private function filtros(array $state, array $sedes): array
    {
        $texto = static fn ($v) => mb_substr(trim((string) ($v ?? '')), 0, 200);
        $sede = static function ($v) use ($sedes): string {
            $v = (string) ($v ?? '');
            return (ctype_digit($v) && isset($sedes[(int) $v])) ? (string) (int) $v : '';
        };
        $tipoBibliografia = (string) ($state['tipo_bibliografia'] ?? 'ambas');

        return [
            'titulo' => $texto($state['titulo'] ?? ''),
            'autor' => $texto($state['autor'] ?? ''),
            'estado' => in_array((string) ($state['estado'] ?? ''), ['0', '1'], true) ? (string) $state['estado'] : '',
            'tipo' => in_array((string) ($state['tipo'] ?? ''), self::TIPOS, true) ? (string) $state['tipo'] : '',
            'tipo_bibliografia' => array_key_exists($tipoBibliografia, self::TIPOS_BIBLIOGRAFIA) ? $tipoBibliografia : 'ambas',
            'sede_ejemplares' => $sede($state['sede_ejemplares'] ?? ''),
            'sede_faltante' => $sede($state['sede_faltante'] ?? ''),
        ];
    }

    /**
     * @return array{0: string, 1: string} columna de orden válida y dirección
     */
    private function orden(array $state): array
    {
        $sort = array_key_exists((string) $state['sort'], self::COLUMNAS_ORDEN) ? (string) $state['sort'] : 'titulo';
        $direction = strtoupper((string) $state['direction']) === 'DESC' ? 'DESC' : 'ASC';

        return [$sort, $direction];
    }

    /**
     * Consulta base: una fila por bibliografía declarada que cumple las condiciones del reporte.
     *
     * @return array{0: string, 1: array} SQL y parámetros
     */
    private function consultaBase(array $f): array
    {
        $tipos = self::TIPOS_BIBLIOGRAFIA[$f['tipo_bibliografia']];
        $marcas = implode(', ', array_fill(0, count($tipos), '?'));

        $sql = "SELECT bd.id, bd.titulo, bd.tipo, bd.anio_publicacion, bd.editorial, bd.estado,
                    (SELECT GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) ORDER BY a.apellidos, a.nombres SEPARATOR '; ')
                       FROM bibliografias_autores ba
                       JOIN autores a ON a.id = ba.autor_id
                      WHERE ba.bibliografia_id = bd.id) AS autores,
                    sa.num_sedes, sa.sedes_ids, sa.num_asignaturas,
                    ej.sede_id AS sede_ejemplares_id, se.nombre AS sede_ejemplares, ej.ejemplares, ej.num_disponibles
                FROM bibliografias_declaradas bd
                JOIN (
                    -- Sedes de las asignaturas con vínculo activo (sede de la unidad de cada código)
                    SELECT ab.bibliografia_id AS id,
                           COUNT(DISTINCT u.sede_id) AS num_sedes,
                           GROUP_CONCAT(DISTINCT u.sede_id ORDER BY u.sede_id) AS sedes_ids,
                           COUNT(DISTINCT ab.asignatura_id) AS num_asignaturas
                      FROM asignaturas_bibliografias ab
                      JOIN asignaturas_departamentos ad ON ad.asignatura_id = ab.asignatura_id
                      JOIN unidades u ON u.id = ad.id_unidad
                     WHERE ab.estado = 'activa' AND ab.tipo_bibliografia IN ({$marcas}) AND u.sede_id <> " . self::SIN_SEDE . "
                     GROUP BY ab.bibliografia_id
                    HAVING COUNT(DISTINCT u.sede_id) >= 2
                ) sa ON sa.id = bd.id
                JOIN (
                    -- Disponibles activas: todas solo impresas y con ejemplares en una única sede
                    SELECT bdis.bibliografia_declarada_id AS id,
                           MIN(s.sede_id) AS sede_id,
                           COALESCE(SUM(s.ejemplares), 0) AS ejemplares,
                           COUNT(DISTINCT bdis.id) AS num_disponibles
                      FROM bibliografias_disponibles bdis
                      LEFT JOIN bibliografias_disponibles_sedes s
                             ON s.bibliografia_disponible_id = bdis.id AND s.ejemplares > 0 AND s.sede_id <> " . self::SIN_SEDE . "
                     WHERE bdis.estado = 1 AND bdis.bibliografia_declarada_id IS NOT NULL
                     GROUP BY bdis.bibliografia_declarada_id
                    HAVING SUM(bdis.disponibilidad <> 'impreso') = 0 AND COUNT(DISTINCT s.sede_id) = 1
                ) ej ON ej.id = bd.id
                JOIN sedes se ON se.id = ej.sede_id
                WHERE 1 = 1";
        $params = $tipos;

        if ($f['titulo'] !== '') {
            $sql .= ' AND bd.titulo LIKE ?';
            $params[] = '%' . $f['titulo'] . '%';
        }
        if ($f['autor'] !== '') {
            $sql .= " AND EXISTS (SELECT 1 FROM bibliografias_autores ba2 JOIN autores a2 ON a2.id = ba2.autor_id
                                   WHERE ba2.bibliografia_id = bd.id
                                     AND (CONCAT(a2.apellidos, ', ', a2.nombres) LIKE ? OR CONCAT(a2.nombres, ' ', a2.apellidos) LIKE ?))";
            $params[] = '%' . $f['autor'] . '%';
            $params[] = '%' . $f['autor'] . '%';
        }
        if ($f['estado'] !== '') {
            $sql .= ' AND bd.estado = ?';
            $params[] = (int) $f['estado'];
        }
        if ($f['tipo'] !== '') {
            $sql .= ' AND bd.tipo = ?';
            $params[] = $f['tipo'];
        }
        if ($f['sede_faltante'] !== '') {
            // La sede tiene asignaturas vinculadas pero no ejemplares
            $sql .= ' AND FIND_IN_SET(?, sa.sedes_ids) > 0 AND ej.sede_id <> ?';
            $params[] = $f['sede_faltante'];
            $params[] = (int) $f['sede_faltante'];
        }

        return [$sql, $params];
    }

    /**
     * @return array{0: string, 1: array} condición sobre la consulta base y parámetros
     */
    private function filtroSedeEjemplares(array $f, array $params): array
    {
        if ($f['sede_ejemplares'] === '') {
            return ['', $params];
        }
        $params[] = (int) $f['sede_ejemplares'];

        return [' WHERE t.sede_ejemplares_id = ?', $params];
    }

    /**
     * Convierte las filas de la consulta en arreglos con el detalle de asignaturas por sede.
     */
    private function armarFilas(array $filas, array $tipos, array $sedes): array
    {
        $detalle = $this->detalleAsignaturas(array_map(static fn ($f) => (int) $f->id, $filas), $tipos);
        $resultado = [];
        foreach ($filas as $f) {
            $sedeEjemplares = (int) $f->sede_ejemplares_id;
            $porSede = [];
            foreach ($detalle[(int) $f->id] ?? [] as $sedeId => $asignaturas) {
                $porSede[] = [
                    'id' => $sedeId,
                    'nombre' => $sedes[$sedeId] ?? ('Sede ' . $sedeId),
                    'con_ejemplares' => $sedeId === $sedeEjemplares,
                    'asignaturas' => $asignaturas,
                ];
            }
            // Primero la sede con ejemplares, luego por nombre
            usort($porSede, static fn ($a, $b) => [$b['con_ejemplares'], $a['nombre']] <=> [$a['con_ejemplares'], $b['nombre']]);

            $resultado[] = [
                'id' => (int) $f->id,
                'titulo' => (string) $f->titulo,
                'tipo' => (string) $f->tipo,
                'anio_publicacion' => $f->anio_publicacion,
                'editorial' => (string) $f->editorial,
                'estado' => (int) $f->estado,
                'autores' => (string) $f->autores,
                'num_asignaturas' => (int) $f->num_asignaturas,
                'num_sedes' => (int) $f->num_sedes,
                'sede_ejemplares' => (string) $f->sede_ejemplares,
                'ejemplares' => (int) $f->ejemplares,
                'num_disponibles' => (int) $f->num_disponibles,
                'sedes' => $porSede,
                'sedes_sin_ejemplares' => array_values(array_map(
                    static fn ($s) => $s['nombre'],
                    array_filter($porSede, static fn ($s) => !$s['con_ejemplares'])
                )),
            ];
        }

        return $resultado;
    }

    /**
     * @return array<int, array<int, array<int, array{codigo: string, nombre: string, tipo: string}>>>
     *         id declarada => id sede => asignaturas vinculadas en esa sede
     */
    private function detalleAsignaturas(array $ids, array $tipos): array
    {
        $detalle = [];
        foreach (array_chunk(array_values(array_unique($ids)), 500) as $lote) {
            $marcasIds = implode(', ', array_fill(0, count($lote), '?'));
            $marcasTipos = implode(', ', array_fill(0, count($tipos), '?'));
            $filas = DB::select(
                "SELECT DISTINCT ab.bibliografia_id, u.sede_id, ad.codigo_asignatura, a.nombre, ab.tipo_bibliografia
                   FROM asignaturas_bibliografias ab
                   JOIN asignaturas a ON a.id = ab.asignatura_id
                   JOIN asignaturas_departamentos ad ON ad.asignatura_id = ab.asignatura_id
                   JOIN unidades u ON u.id = ad.id_unidad
                  WHERE ab.bibliografia_id IN ({$marcasIds})
                    AND ab.estado = 'activa' AND ab.tipo_bibliografia IN ({$marcasTipos})
                    AND u.sede_id <> " . self::SIN_SEDE . "
                  ORDER BY ab.bibliografia_id, u.sede_id, ad.codigo_asignatura",
                array_merge($lote, $tipos)
            );
            foreach ($filas as $fila) {
                $detalle[(int) $fila->bibliografia_id][(int) $fila->sede_id][] = [
                    'codigo' => (string) $fila->codigo_asignatura,
                    'nombre' => (string) $fila->nombre,
                    'tipo' => self::ETIQUETAS_VINCULO[$fila->tipo_bibliografia] ?? (string) $fila->tipo_bibliografia,
                ];
            }
        }

        return $detalle;
    }
}
