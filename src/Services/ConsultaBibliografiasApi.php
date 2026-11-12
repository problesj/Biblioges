<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Consultas de la API de consulta v1 (solo lectura).
 *
 * Las asignaturas de un plan de carrera se obtienen con el mismo criterio que los reportes de cobertura
 * (vista vw_mallas), pero con consultas directas (la vista tarda varios segundos por carrera):
 *  - asignaturas REGULAR de la malla de la carrera del plan, con código en una unidad de la sede del plan;
 *  - según los tipos de formación pedidos, las asignaturas que componen las asignaturas de formación de la
 *    malla (asignaturas_formacion), con código en la misma unidad que la asignatura de la malla.
 * Solo se entregan bibliografías activas: vínculos activos (asignaturas_bibliografias.estado = 'activa'),
 * bibliografías declaradas activas (estado = 1) y, en disponibles, bibliografías disponibles activas.
 */
class ConsultaBibliografiasApi
{
    public const TIPOS_BIBLIOGRAFIA = ['basica', 'complementaria', 'otro'];

    /** Valor del parámetro formacion => tipo de asignatura */
    public const FORMACIONES = [
        'basica' => 'FORMACION_BASICA',
        'general' => 'FORMACION_GENERAL',
        'idiomas' => 'FORMACION_IDIOMAS',
        'profesional' => 'FORMACION_PROFESIONAL',
        'valores' => 'FORMACION_VALORES',
        'especialidad' => 'FORMACION_ESPECIALIDAD',
        'especial' => 'FORMACION_ESPECIAL',
    ];

    /** Columna de filtros_formaciones (filtros guardados en los reportes de cobertura) => valor de formacion */
    private const COLUMNAS_FILTROS = [
        'basica' => 'basica',
        'general' => 'general',
        'idioma' => 'idiomas',
        'profesional' => 'profesional',
        'valores' => 'valores',
        'especialidad' => 'especialidad',
        'especial' => 'especial',
    ];

    /** Plan vigente (misma regla que el Dashboard), sobre carreras c y carreras_espejos ce */
    private const VIGENTE = "(c.estado = 1 AND ce.estado = 1 AND ce.vigencia_hasta >= CONCAT(YEAR(CURDATE()), '00'))";

    private const LOTE = 1000;

    /**
     * Planes de estudio (código de carrera + vigencia + sede).
     */
    public function planes(?string $tipoPrograma, ?string $sedeCodigo, bool $soloVigentes): array
    {
        $sql = "SELECT ce.codigo_carrera, ce.vigencia_desde, ce.vigencia_hasta, c.nombre, c.tipo_programa,
                       s.codigo AS sede_codigo, s.nombre AS sede_nombre, " . self::VIGENTE . " AS vigente
                  FROM carreras_espejos ce
                  JOIN carreras c ON c.id = ce.carrera_id
                  JOIN sedes s ON s.id = ce.sede_id
                 WHERE 1 = 1";
        $params = [];
        if ($tipoPrograma !== null) {
            $sql .= ' AND c.tipo_programa = ?';
            $params[] = $tipoPrograma;
        }
        if ($sedeCodigo !== null) {
            $sql .= ' AND s.codigo = ?';
            $params[] = $sedeCodigo;
        }
        if ($soloVigentes) {
            $sql .= ' AND ' . self::VIGENTE;
        }
        $sql .= ' ORDER BY c.nombre, ce.codigo_carrera, ce.vigencia_desde DESC, ce.id DESC';

        return array_map([$this, 'formatoPlan'], DB::select($sql, $params));
    }

    public function formatoPlan(object $f): array
    {
        return [
            'codigo' => (string) $f->codigo_carrera,
            'nombre' => (string) $f->nombre,
            'tipo_programa' => (string) $f->tipo_programa,
            'sede' => ['codigo' => (string) $f->sede_codigo, 'nombre' => (string) $f->sede_nombre],
            'vigencia_desde' => (string) $f->vigencia_desde,
            'vigencia_hasta' => (string) $f->vigencia_hasta,
            'vigente' => (bool) $f->vigente,
        ];
    }

    /**
     * Plan de un código de carrera. Sin vigencia_desde se usa el plan vigente de vigencia_desde más reciente
     * (si ninguno está vigente, el de vigencia_desde más reciente).
     *
     * @return array{plan: ?object, vigencias: string[]} vigencias = valores de vigencia_desde del código
     */
    public function buscarPlan(string $codigo, ?string $vigenciaDesde): array
    {
        $filas = DB::select(
            "SELECT ce.id, ce.carrera_id, ce.sede_id, ce.codigo_carrera, ce.vigencia_desde, ce.vigencia_hasta,
                    c.nombre, c.tipo_programa, s.codigo AS sede_codigo, s.nombre AS sede_nombre, " . self::VIGENTE . " AS vigente
               FROM carreras_espejos ce
               JOIN carreras c ON c.id = ce.carrera_id
               JOIN sedes s ON s.id = ce.sede_id
              WHERE ce.codigo_carrera = ?
              ORDER BY vigente DESC, ce.vigencia_desde DESC, ce.estado DESC, ce.id DESC",
            [$codigo]
        );
        $vigencias = array_values(array_unique(array_map(static fn ($f) => (string) $f->vigencia_desde, $filas)));
        rsort($vigencias, SORT_STRING);

        $plan = null;
        foreach ($filas as $fila) {
            if ($vigenciaDesde === null || (string) $fila->vigencia_desde === $vigenciaDesde) {
                $plan = $fila;
                break;
            }
        }

        return ['plan' => $plan, 'vigencias' => $vigencias];
    }

    /**
     * Tipos de formación guardados para el plan en los reportes de cobertura (claves de FORMACIONES),
     * o null si el plan no tiene filtros guardados.
     */
    public function formacionesGuardadas(int $carreraEspejoId): ?array
    {
        $filtro = DB::table('filtros_formaciones')
            ->whereRaw('TRIM(id_carrera_espejo) = ?', [(string) $carreraEspejoId])
            ->first();
        if (!$filtro) {
            return null;
        }
        $formaciones = [];
        foreach (self::COLUMNAS_FILTROS as $columna => $valor) {
            if (!empty($filtro->$columna)) {
                $formaciones[] = $valor;
            }
        }

        return $formaciones;
    }

    /**
     * Asignaturas del plan (ver criterio en la descripción de la clase).
     *
     * @param string[] $formaciones claves de FORMACIONES
     * @return array<int, array{codigo: string, nombre: string, tipo: string, asignaturas_malla: array}>
     */
    public function asignaturasPlan(object $plan, array $formaciones): array
    {
        $sede = (int) $plan->sede_id;
        $carrera = (int) $plan->carrera_id;
        $asignaturas = [];

        $regulares = DB::select(
            "SELECT DISTINCT ad.codigo_asignatura AS codigo, a.nombre, a.tipo
               FROM mallas m
               JOIN asignaturas a ON a.id = m.asignatura_id
               JOIN asignaturas_departamentos ad ON ad.asignatura_id = a.id
               JOIN unidades u ON u.id = ad.id_unidad AND u.sede_id = ?
              WHERE m.carrera_id = ? AND a.tipo = 'REGULAR'",
            [$sede, $carrera]
        );
        foreach ($regulares as $fila) {
            $this->agregarAsignatura($asignaturas, (string) $fila->codigo, (string) $fila->nombre, 'REGULAR', null);
        }

        // Componentes de las asignaturas de formación de la malla. Igual que vw_mallas: la sede es la de la unidad
        // del código de la asignatura componente; el código de la asignatura de la malla puede estar en cualquier unidad.
        $compuestas = DB::select(
            "SELECT DISTINCT adp.codigo_asignatura AS codigo_malla, ap.nombre AS nombre_malla, ap.tipo AS tipo_malla,
                    up.sede_id AS sede_malla, adh.codigo_asignatura AS codigo, ah.nombre, ah.tipo
               FROM mallas m
               JOIN asignaturas ap ON ap.id = m.asignatura_id
               JOIN asignaturas_departamentos adp ON adp.asignatura_id = ap.id
               LEFT JOIN unidades up ON up.id = adp.id_unidad
               JOIN asignaturas_formacion af ON af.asignatura_formacion_id = ap.id
               JOIN asignaturas_departamentos adh ON adh.asignatura_id = af.asignatura_regular_id
               JOIN unidades u ON u.id = adh.id_unidad AND u.sede_id = ?
               JOIN asignaturas ah ON ah.id = adh.asignatura_id
              WHERE m.carrera_id = ?",
            [$sede, $carrera]
        );
        $tipos = array_map(static fn ($clave) => self::FORMACIONES[$clave], $formaciones);
        foreach ($compuestas as $fila) {
            if ($fila->tipo === 'REGULAR') {
                // Igual que los reportes de cobertura: una componente REGULAR aporta el código de la asignatura de la malla
                $this->agregarAsignatura($asignaturas, (string) $fila->codigo_malla, (string) $fila->nombre_malla, (string) $fila->tipo_malla, null);
            } elseif (in_array($fila->tipo, $tipos, true)) {
                $this->agregarAsignatura($asignaturas, (string) $fila->codigo, (string) $fila->nombre, (string) $fila->tipo, [
                    'codigo' => rtrim((string) $fila->codigo_malla),
                    'nombre' => (string) $fila->nombre_malla,
                    'en_sede' => (int) $fila->sede_malla === $sede,
                ]);
            }
        }

        $lista = [];
        foreach ($asignaturas as $a) {
            // Asignatura(s) de la malla de la que forma parte: de preferencia los códigos de la sede del plan
            $malla = array_values($a['asignaturas_malla']);
            $enSede = array_values(array_filter($malla, static fn ($m) => $m['en_sede']));
            $a['asignaturas_malla'] = array_map(static fn ($m) => ['codigo' => $m['codigo'], 'nombre' => $m['nombre']], $enSede ?: $malla);
            $lista[] = $a;
        }
        usort($lista, static fn ($a, $b) => [$a['tipo'] !== 'REGULAR', $a['nombre'], $a['codigo']] <=> [$b['tipo'] !== 'REGULAR', $b['nombre'], $b['codigo']]);

        return $lista;
    }

    private function agregarAsignatura(array &$asignaturas, string $codigo, string $nombre, string $tipo, ?array $malla): void
    {
        $clave = self::normalizar($codigo);
        if (!isset($asignaturas[$clave])) {
            $asignaturas[$clave] = ['codigo' => rtrim($codigo), 'nombre' => $nombre, 'tipo' => $tipo, 'asignaturas_malla' => []];
        }
        if ($malla !== null) {
            $asignaturas[$clave]['asignaturas_malla'][self::normalizar($malla['codigo'])] = $malla;
        }
    }

    public static function normalizar(string $codigo): string
    {
        return mb_strtolower(rtrim($codigo));
    }

    /**
     * Asignatura por código (código único en asignaturas_departamentos).
     */
    public function asignaturaPorCodigo(string $codigo): ?object
    {
        $filas = DB::select(
            "SELECT ad.codigo_asignatura, a.nombre, a.tipo, a.periodicidad, a.estado,
                    u.codigo AS unidad_codigo, u.nombre AS unidad_nombre, s.codigo AS sede_codigo, s.nombre AS sede_nombre
               FROM asignaturas_departamentos ad
               JOIN asignaturas a ON a.id = ad.asignatura_id
               JOIN unidades u ON u.id = ad.id_unidad
               JOIN sedes s ON s.id = u.sede_id
              WHERE ad.codigo_asignatura = ?
              LIMIT 1",
            [$codigo]
        );

        return $filas[0] ?? null;
    }

    /**
     * Bibliografías declaradas activas con vínculo activo de cada código de asignatura.
     *
     * @param string[] $codigos
     * @param string[] $tiposBibliografia valores de TIPOS_BIBLIOGRAFIA
     * @return array<string, array<int, array>> código normalizado => bibliografías (básicas, complementarias, otras; por título)
     */
    public function declaradasPorCodigos(array $codigos, array $tiposBibliografia): array
    {
        $codigos = array_values(array_unique(array_map('strval', $codigos)));
        if (!$codigos || !$tiposBibliografia) {
            return [];
        }
        $marcasTipos = implode(', ', array_fill(0, count($tiposBibliografia), '?'));
        $filas = [];
        foreach (array_chunk($codigos, self::LOTE) as $lote) {
            $marcas = implode(', ', array_fill(0, count($lote), '?'));
            $filas = array_merge($filas, DB::select(
                "SELECT ad.codigo_asignatura, ab.tipo_bibliografia, bd.id, bd.titulo, bd.tipo, bd.anio_publicacion,
                        bd.editorial, bd.edicion, bd.formato, COALESCE(NULLIF(bd.isbn, ''), l.isbn) AS isbn,
                        bd.doi, bd.url
                   FROM asignaturas_departamentos ad
                   JOIN asignaturas_bibliografias ab ON ab.asignatura_id = ad.asignatura_id AND ab.estado = 'activa'
                   JOIN bibliografias_declaradas bd ON bd.id = ab.bibliografia_id
                   LEFT JOIN libros l ON l.bibliografia_id = bd.id
                  WHERE ad.codigo_asignatura IN ({$marcas}) AND ab.tipo_bibliografia IN ({$marcasTipos}) AND bd.estado = 1
                  ORDER BY FIELD(ab.tipo_bibliografia, 'basica', 'complementaria', 'otro'), bd.titulo, bd.id",
                array_merge($lote, $tiposBibliografia)
            ));
        }
        $autores = $this->autores('bibliografias_autores', 'bibliografia_id', array_map(static fn ($f) => (int) $f->id, $filas));

        $resultado = [];
        foreach ($filas as $f) {
            $resultado[self::normalizar((string) $f->codigo_asignatura)][] = [
                'id' => (int) $f->id,
                'tipo_bibliografia' => (string) $f->tipo_bibliografia,
                'titulo' => trim((string) $f->titulo),
                'tipo' => $f->tipo === null ? null : (string) $f->tipo,
                'autores' => $autores[(int) $f->id] ?? [],
                'anio_publicacion' => (int) $f->anio_publicacion > 0 ? (int) $f->anio_publicacion : null,
                'editorial' => self::textoONulo($f->editorial),
                'edicion' => self::textoONulo($f->edicion),
                'formato' => (string) $f->formato,
                'isbn' => self::textoONulo($f->isbn),
                'doi' => self::textoONulo($f->doi),
                'url' => self::textoONulo($f->url),
            ];
        }

        return $resultado;
    }

    /**
     * Bibliografías disponibles activas de cada bibliografía declarada, de la edición más reciente a la más antigua.
     *
     * @param int[] $declaradaIds
     * @param bool  $soloUltima   solo la de mayor año de edición (a igual año, la registrada más recientemente)
     * @return array<int, array<int, array>> id declarada => disponibles
     */
    public function disponibles(array $declaradaIds, bool $soloUltima): array
    {
        $declaradaIds = array_values(array_unique(array_map('intval', $declaradaIds)));
        if (!$declaradaIds) {
            return [];
        }
        $filas = [];
        foreach (array_chunk($declaradaIds, self::LOTE) as $lote) {
            $marcas = implode(', ', array_fill(0, count($lote), '?'));
            $filas = array_merge($filas, DB::select(
                "SELECT id, bibliografia_declarada_id, titulo, anio_edicion, editorial, disponibilidad, id_mms,
                        url_acceso, url_catalogo, ejemplares_digitales
                   FROM bibliografias_disponibles
                  WHERE estado = 1 AND bibliografia_declarada_id IN ({$marcas})
                  ORDER BY bibliografia_declarada_id, anio_edicion DESC, id DESC",
                $lote
            ));
        }
        $elegidas = [];
        $porDeclarada = [];
        foreach ($filas as $f) {
            $declarada = (int) $f->bibliografia_declarada_id;
            if ($soloUltima && isset($porDeclarada[$declarada])) {
                continue;
            }
            $porDeclarada[$declarada][] = $f;
            $elegidas[] = (int) $f->id;
        }
        $autores = $this->autores('bibliografias_disponibles_autores', 'bibliografia_disponible_id', $elegidas);
        $ejemplares = $this->ejemplares($elegidas);

        $resultado = [];
        foreach ($porDeclarada as $declarada => $lista) {
            foreach ($lista as $f) {
                $porSede = $ejemplares[(int) $f->id] ?? [];
                $resultado[$declarada][] = [
                    'id' => (int) $f->id,
                    'titulo' => trim((string) $f->titulo),
                    'autores' => $autores[(int) $f->id] ?? [],
                    'anio_edicion' => (int) $f->anio_edicion > 0 ? (int) $f->anio_edicion : null,
                    'editorial' => self::textoONulo($f->editorial),
                    'disponibilidad' => (string) $f->disponibilidad,
                    'id_mms' => self::textoONulo($f->id_mms),
                    'url_acceso' => self::textoONulo($f->url_acceso),
                    'url_catalogo' => self::textoONulo($f->url_catalogo),
                    'ejemplares_digitales' => $f->ejemplares_digitales === null ? null : (int) $f->ejemplares_digitales,
                    'ejemplares' => $porSede,
                    'total_ejemplares' => array_sum(array_column($porSede, 'cantidad')),
                ];
            }
        }

        return $resultado;
    }

    /**
     * @return array<int, array<int, array{sede: array, cantidad: int}>> id disponible => ejemplares impresos por sede
     */
    private function ejemplares(array $disponibleIds): array
    {
        $resultado = [];
        foreach (array_chunk($disponibleIds, self::LOTE) as $lote) {
            $marcas = implode(', ', array_fill(0, count($lote), '?'));
            $filas = DB::select(
                "SELECT bds.bibliografia_disponible_id, s.codigo, s.nombre, bds.ejemplares
                   FROM bibliografias_disponibles_sedes bds
                   JOIN sedes s ON s.id = bds.sede_id
                  WHERE bds.ejemplares > 0 AND bds.bibliografia_disponible_id IN ({$marcas})
                  ORDER BY s.nombre",
                $lote
            );
            foreach ($filas as $f) {
                $resultado[(int) $f->bibliografia_disponible_id][] = [
                    'sede' => ['codigo' => (string) $f->codigo, 'nombre' => (string) $f->nombre],
                    'cantidad' => (int) $f->ejemplares,
                ];
            }
        }

        return $resultado;
    }

    /**
     * @return array<int, string[]> id => autores "Apellidos, Nombres" en el orden registrado
     */
    private function autores(string $tabla, string $columna, array $ids): array
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $resultado = [];
        foreach (array_chunk($ids, self::LOTE) as $lote) {
            $marcas = implode(', ', array_fill(0, count($lote), '?'));
            $filas = DB::select(
                "SELECT t.{$columna} AS id, a.apellidos, a.nombres
                   FROM {$tabla} t
                   JOIN autores a ON a.id = t.autor_id
                  WHERE t.{$columna} IN ({$marcas})
                  ORDER BY t.id",
                $lote
            );
            foreach ($filas as $f) {
                $nombre = trim((string) $f->apellidos);
                $nombres = trim((string) $f->nombres);
                $resultado[(int) $f->id][] = $nombres === '' ? $nombre : ($nombre === '' ? $nombres : $nombre . ', ' . $nombres);
            }
        }

        return $resultado;
    }

    private static function textoONulo($valor): ?string
    {
        $valor = trim((string) ($valor ?? ''));

        return $valor === '' ? null : $valor;
    }
}
