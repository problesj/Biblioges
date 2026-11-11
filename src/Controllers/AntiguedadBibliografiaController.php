<?php

namespace App\Controllers;

use App\Core\ListStateManager;
use App\Core\Session;
use Illuminate\Database\Capsule\Manager as DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Reporte "Antigüedad de Bibliografías".
 *
 * Lista las bibliografías declaradas (básicas y/o complementarias) que tienen bibliografías disponibles
 * activas y compara el año de edición declarado con los años de las ediciones disponibles:
 *  - rojo:     el año declarado es mayor que todos los años disponibles;
 *  - amarillo: es mayor que solo algunos;
 *  - verde:    es menor o igual que todos;
 *  - sin_info: la declarada no tiene un año válido o ninguna disponible activa lo tiene.
 * Año válido: entre 1450 y el año siguiente al actual. Las disponibles sin año válido no cuentan
 * para el color y se muestran como "s/a".
 */
class AntiguedadBibliografiaController
{
    private const LISTADO = 'reporte_antiguedad';

    /** Valor del filtro => etiqueta */
    public const ANTIGUEDADES = [
        'rojo' => 'Desactualizada',
        'amarillo' => 'Parcial',
        'verde' => 'Vigente',
        'sin_info' => 'Sin información',
    ];

    public const DESCRIPCIONES = [
        'rojo' => 'El año declarado es mayor que todos los años de las ediciones disponibles',
        'amarillo' => 'El año declarado es mayor que solo algunos años de las ediciones disponibles',
        'verde' => 'El año declarado es menor o igual que todos los años de las ediciones disponibles',
        'sin_info' => 'La bibliografía declarada no tiene un año válido o ninguna edición disponible lo tiene',
    ];

    /** Filtro básica / complementaria => tipos de vínculo incluidos */
    private const TIPOS_BIBLIOGRAFIA = [
        'ambas' => ['basica', 'complementaria'],
        'basica' => ['basica'],
        'complementaria' => ['complementaria'],
    ];

    private const TIPOS = ['libro', 'articulo', 'tesis', 'software', 'sitio_web', 'generico'];

    /** Columna ordenable => expresión SQL sobre la consulta base (alias t) */
    private const COLUMNAS_ORDEN = [
        'titulo' => 't.titulo',
        'autores' => 't.autores',
        'anio_publicacion' => 't.anio_publicacion',
        'editorial' => 't.editorial',
        'estado' => 't.estado',
        'num_asignaturas' => 't.num_asignaturas',
        'anios_disponibles' => 't.max_anio',
        'antiguedad' => 'orden_antiguedad',
    ];

    /** Años fuera de [ANIO_MINIMO, año actual + 1] se consideran no válidos (sin año) */
    private const ANIO_MINIMO = 1450;

    private const ORDEN_ANTIGUEDAD = "CASE t.antiguedad WHEN 'rojo' THEN 1 WHEN 'amarillo' THEN 2 WHEN 'verde' THEN 3 ELSE 4 END";

    public function index(Request $request, Response $response, array $args = []): Response
    {
        $stateManager = new ListStateManager(new Session(), self::LISTADO);
        $state = $stateManager->getState($request->getQueryParams());
        $stateManager->saveState($state);

        $filtros = $this->filtros($state);
        $page = max(1, (int) $state['page']);
        $perPage = (int) $state['per_page'];
        $sort = array_key_exists($state['sort'], self::COLUMNAS_ORDEN) ? $state['sort'] : 'titulo';
        $direction = strtoupper((string) $state['direction']) === 'DESC' ? 'DESC' : 'ASC';

        [$base, $params] = $this->consultaBase($filtros);
        [$donde, $paramsFiltrados] = $this->filtroAntiguedad($filtros, $params);

        // Resumen por color sobre el listado filtrado (sin aplicar el filtro de color); de él sale el total
        $resumen = array_fill_keys(array_keys(self::ANTIGUEDADES), 0);
        foreach (DB::select("SELECT t.antiguedad, COUNT(*) AS n FROM ({$base}) t GROUP BY t.antiguedad", $params) as $fila) {
            $resumen[$fila->antiguedad] = (int) $fila->n;
        }
        $total = $filtros['antiguedad'] === '' ? array_sum($resumen) : $resumen[$filtros['antiguedad']];

        $totalPages = (int) ceil($total / $perPage);
        if ($totalPages > 0 && $page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $perPage;

        $bibliografias = DB::select(
            "SELECT t.*, " . self::ORDEN_ANTIGUEDAD . " AS orden_antiguedad FROM ({$base}) t{$donde}
             ORDER BY " . self::COLUMNAS_ORDEN[$sort] . " {$direction}, t.titulo ASC, t.id ASC
             LIMIT {$perPage} OFFSET {$offset}",
            $paramsFiltrados
        );

        $carreras = DB::select('SELECT id, nombre FROM carreras WHERE estado = 1 ORDER BY nombre');
        $filtrosUrl = array_filter($filtros, static fn ($v) => $v !== '');

        global $twig;
        $html = $twig->render('reportes/antiguedad_bibliografias/index.twig', [
            'bibliografias' => $bibliografias,
            'carreras' => $carreras,
            'filtros' => $filtros,
            'resumen' => $resumen,
            'total_sin_filtro_color' => array_sum($resumen),
            'antiguedades' => self::ANTIGUEDADES,
            'descripciones' => self::DESCRIPCIONES,
            'url_exportar' => app_url('reportes/antiguedad-bibliografias/exportar') . ($filtrosUrl ? '?' . http_build_query($filtrosUrl) : ''),
            'session' => [
                'user_id' => $_SESSION['user_id'] ?? null,
                'user_email' => $_SESSION['user_email'] ?? null,
                'user_nombre' => $_SESSION['user_nombre'] ?? null,
                'user_rol' => $_SESSION['user_rol'] ?? null,
            ],
            'app_url' => app_url(),
            'current_page' => 'antiguedad-bibliografias',
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

        return $response->withHeader('Location', app_url('reportes/antiguedad-bibliografias'))->withStatus(302);
    }

    /**
     * Exporta a Excel el listado completo con los filtros y el orden actuales.
     */
    public function exportar(Request $request, Response $response, array $args = []): Response
    {
        $state = (new ListStateManager(new Session(), self::LISTADO))->getState($request->getQueryParams());
        $filtros = $this->filtros($state);
        $sort = array_key_exists($state['sort'], self::COLUMNAS_ORDEN) ? $state['sort'] : 'titulo';
        $direction = strtoupper((string) $state['direction']) === 'DESC' ? 'DESC' : 'ASC';

        [$base, $params] = $this->consultaBase($filtros);
        [$donde, $paramsFiltrados] = $this->filtroAntiguedad($filtros, $params);
        $filas = DB::select(
            "SELECT t.*, " . self::ORDEN_ANTIGUEDAD . " AS orden_antiguedad FROM ({$base}) t{$donde}
             ORDER BY " . self::COLUMNAS_ORDEN[$sort] . " {$direction}, t.titulo ASC, t.id ASC",
            $paramsFiltrados
        );

        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle('Antigüedad');
        $encabezados = ['Título', 'Autor(es)', 'Año Edición', 'Editorial', 'Tipo', 'Estado',
            'N° Asignaturas Vinculadas', 'Años Disponibles', 'Antigüedad'];
        $hoja->fromArray($encabezados, null, 'A1');
        $hoja->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ]);
        $colores = ['verde' => 'C6EFCE', 'amarillo' => 'FFEB9C', 'rojo' => 'FFC7CE', 'sin_info' => 'E7E6E6'];

        $fila = 2;
        foreach ($filas as $b) {
            $hoja->setCellValueExplicit('A' . $fila, (string) $b->titulo, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $hoja->setCellValueExplicit('B' . $fila, (string) ($b->autores ?: 'Sin autores'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if ((int) $b->anio_publicacion > 0) {
                $hoja->setCellValue('C' . $fila, (int) $b->anio_publicacion);
            } else {
                $hoja->setCellValue('C' . $fila, 'N/A');
            }
            $hoja->setCellValueExplicit('D' . $fila, (string) ($b->editorial ?: 'N/A'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $hoja->setCellValue('E' . $fila, ucfirst(str_replace('_', ' ', (string) $b->tipo)));
            $hoja->setCellValue('F' . $fila, (int) $b->estado === 1 ? 'Activo' : 'Inactivo');
            $hoja->setCellValue('G' . $fila, (int) $b->num_asignaturas);
            $hoja->setCellValueExplicit('H' . $fila, (string) $b->anios_disponibles, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $hoja->setCellValue('I' . $fila, self::ANTIGUEDADES[$b->antiguedad] ?? $b->antiguedad);
            $hoja->getStyle('I' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($colores[$b->antiguedad] ?? 'FFFFFF');
            $fila++;
        }
        $ultima = max(1, $fila - 1);
        $hoja->getStyle('A1:I' . $ultima)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFBFBF']]],
        ]);
        foreach (['A' => 60, 'B' => 40, 'C' => 12, 'D' => 30, 'E' => 12, 'F' => 10, 'G' => 14, 'H' => 30, 'I' => 18] as $col => $ancho) {
            $hoja->getColumnDimension($col)->setWidth($ancho);
        }
        $hoja->getStyle('C2:C' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->getStyle('E2:I' . $ultima)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->setAutoFilter('A1:I' . $ultima);
        $hoja->freezePane('A2');

        // Hoja con los criterios del semáforo
        $criterios = $spreadsheet->createSheet();
        $criterios->setTitle('Criterios');
        $criterios->fromArray(['Antigüedad', 'Criterio'], null, 'A1');
        $criterios->getStyle('A1:B1')->getFont()->setBold(true);
        $f = 2;
        foreach (self::ANTIGUEDADES as $clave => $etiqueta) {
            $criterios->setCellValue('A' . $f, $etiqueta);
            $criterios->getStyle('A' . $f)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($colores[$clave]);
            $criterios->setCellValue('B' . $f, self::DESCRIPCIONES[$clave]);
            $f++;
        }
        $criterios->setCellValue('A' . ($f + 1), 'Solo se consideran bibliografías disponibles activas. Año válido: entre ' . self::ANIO_MINIMO . ' y ' . ((int) date('Y') + 1) . '; las ediciones sin año válido ("s/a") no cuentan para el color.');
        $criterios->getColumnDimension('A')->setWidth(20);
        $criterios->getColumnDimension('B')->setWidth(90);
        $spreadsheet->setActiveSheetIndex(0);

        ob_start();
        (new Xlsx($spreadsheet))->save('php://output');
        $contenido = ob_get_clean();
        $response->getBody()->write($contenido);

        return $response
            ->withHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="antiguedad_bibliografias_' . date('Y-m-d_H-i') . '.xlsx"')
            ->withHeader('Cache-Control', 'max-age=0');
    }

    /**
     * Cantidad de bibliografías declaradas por antigüedad con los filtros por defecto del reporte
     * (básicas y complementarias, sin otros filtros). Lo usa el Dashboard.
     *
     * @return array<string, int> clave de self::ANTIGUEDADES => cantidad
     */
    public function resumenGeneral(): array
    {
        [$base, $params] = $this->consultaBase($this->filtros([]));
        $resumen = array_fill_keys(array_keys(self::ANTIGUEDADES), 0);
        foreach (DB::select("SELECT t.antiguedad, COUNT(*) AS n FROM ({$base}) t GROUP BY t.antiguedad", $params) as $fila) {
            $resumen[$fila->antiguedad] = (int) $fila->n;
        }

        return $resumen;
    }

    /**
     * Normaliza los filtros del estado del listado (todos como texto, '' = sin filtro).
     */
    private function filtros(array $state): array
    {
        $texto = static fn ($v) => mb_substr(trim((string) ($v ?? '')), 0, 200);
        $tipoBibliografia = (string) ($state['tipo_bibliografia'] ?? 'ambas');
        $carreraId = (int) ($state['carrera_id'] ?? 0);

        return [
            'titulo' => $texto($state['titulo'] ?? ''),
            'autor' => $texto($state['autor'] ?? ''),
            'editorial' => $texto($state['editorial'] ?? ''),
            'estado' => in_array((string) ($state['estado'] ?? ''), ['0', '1'], true) ? (string) $state['estado'] : '',
            'tipo' => in_array((string) ($state['tipo'] ?? ''), self::TIPOS, true) ? (string) $state['tipo'] : '',
            'tipo_bibliografia' => array_key_exists($tipoBibliografia, self::TIPOS_BIBLIOGRAFIA) ? $tipoBibliografia : 'ambas',
            'carrera_id' => $carreraId > 0 ? (string) $carreraId : '',
            'antiguedad' => array_key_exists((string) ($state['antiguedad'] ?? ''), self::ANTIGUEDADES) ? (string) $state['antiguedad'] : '',
        ];
    }

    /**
     * Consulta base: una fila por bibliografía declarada con disponibles activas, con su antigüedad calculada.
     *
     * @return array{0: string, 1: array} SQL y parámetros
     */
    private function consultaBase(array $f): array
    {
        $tipos = self::TIPOS_BIBLIOGRAFIA[$f['tipo_bibliografia']];
        $marcas = implode(', ', array_fill(0, count($tipos), '?'));
        // Año válido: entre 1450 y el año siguiente al actual (otros valores se tratan como sin año)
        $valido = 'BETWEEN ' . self::ANIO_MINIMO . ' AND YEAR(CURDATE()) + 1';

        $sql = "SELECT bd.id, bd.titulo, bd.tipo, bd.anio_publicacion, bd.editorial, bd.estado,
                    (SELECT GROUP_CONCAT(DISTINCT CONCAT(a.apellidos, ', ', a.nombres) ORDER BY a.apellidos, a.nombres SEPARATOR '; ')
                       FROM bibliografias_autores ba
                       JOIN autores a ON a.id = ba.autor_id
                      WHERE ba.bibliografia_id = bd.id) AS autores,
                    (SELECT COUNT(DISTINCT ab.asignatura_id)
                       FROM asignaturas_bibliografias ab
                      WHERE ab.bibliografia_id = bd.id AND ab.tipo_bibliografia IN ({$marcas})) AS num_asignaturas,
                    d.anios_disponibles, d.min_anio, d.max_anio, d.con_anio,
                    CASE
                        WHEN NOT (COALESCE(bd.anio_publicacion, 0) {$valido}) OR d.con_anio = 0 THEN 'sin_info'
                        WHEN bd.anio_publicacion > d.max_anio THEN 'rojo'
                        WHEN bd.anio_publicacion <= d.min_anio THEN 'verde'
                        ELSE 'amarillo'
                    END AS antiguedad
                FROM bibliografias_declaradas bd
                JOIN (
                    SELECT bdis.bibliografia_declarada_id AS id,
                           CONCAT_WS(' - ',
                               GROUP_CONCAT(DISTINCT CASE WHEN bdis.anio_edicion {$valido} THEN bdis.anio_edicion END
                                            ORDER BY bdis.anio_edicion SEPARATOR ' - '),
                               IF(SUM(NOT (COALESCE(bdis.anio_edicion, 0) {$valido})) > 0, 's/a', NULL)
                           ) AS anios_disponibles,
                           COALESCE(SUM(bdis.anio_edicion {$valido}), 0) AS con_anio,
                           MIN(CASE WHEN bdis.anio_edicion {$valido} THEN bdis.anio_edicion END) AS min_anio,
                           MAX(CASE WHEN bdis.anio_edicion {$valido} THEN bdis.anio_edicion END) AS max_anio
                      FROM bibliografias_disponibles bdis
                     WHERE bdis.estado = 1 AND bdis.bibliografia_declarada_id IS NOT NULL
                     GROUP BY bdis.bibliografia_declarada_id
                ) d ON d.id = bd.id
                WHERE EXISTS (SELECT 1 FROM asignaturas_bibliografias ab
                               WHERE ab.bibliografia_id = bd.id AND ab.tipo_bibliografia IN ({$marcas}))";
        $params = array_merge($tipos, $tipos);

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
        if ($f['editorial'] !== '') {
            $sql .= ' AND bd.editorial LIKE ?';
            $params[] = '%' . $f['editorial'] . '%';
        }
        if ($f['estado'] !== '') {
            $sql .= ' AND bd.estado = ?';
            $params[] = (int) $f['estado'];
        }
        if ($f['tipo'] !== '') {
            $sql .= ' AND bd.tipo = ?';
            $params[] = $f['tipo'];
        }
        if ($f['carrera_id'] !== '') {
            // Asignaturas de la malla de la carrera con la bibliografía del tipo seleccionado
            $sql .= " AND EXISTS (SELECT 1 FROM asignaturas_bibliografias ab3
                                   JOIN mallas m ON m.asignatura_id = ab3.asignatura_id
                                  WHERE ab3.bibliografia_id = bd.id
                                    AND ab3.tipo_bibliografia IN ({$marcas})
                                    AND m.carrera_id = ?)";
            $params = array_merge($params, $tipos, [(int) $f['carrera_id']]);
        }

        return [$sql, $params];
    }

    /**
     * @return array{0: string, 1: array} condición sobre la consulta base y parámetros
     */
    private function filtroAntiguedad(array $f, array $params): array
    {
        if ($f['antiguedad'] === '') {
            return ['', $params];
        }
        $params[] = $f['antiguedad'];

        return [' WHERE t.antiguedad = ?', $params];
    }
}
