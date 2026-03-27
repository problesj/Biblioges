<?php

namespace App\Services;

use PDO;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Parseo y aplicación de archivos Excel de malla (formato tipo SIGEBI).
 */
class CarreraExcelImportService
{
    private const SESSION_KEY = 'carrera_importacion_pendiente';

    private string $uploadDir;
    /** @var array<int,array<string,string>> */
    private array $unidadesEquivalencias = [];

    public function __construct(?string $uploadDir = null)
    {
        $this->uploadDir = $uploadDir ?? dirname(__DIR__, 2) . '/upload';
        $equivalenciasPath = dirname(__DIR__) . '/config/unidades_equivalencias.php';
        if (is_file($equivalenciasPath)) {
            $loaded = require $equivalenciasPath;
            if (is_array($loaded)) {
                $this->unidadesEquivalencias = $loaded;
            }
        }
    }

    public static function sessionKey(): string
    {
        return self::SESSION_KEY;
    }

    /**
     * @return array{path: string, stored_name: string, original_name: string}
     */
    public function guardarArchivoSubido(array $file): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('No se recibió un archivo válido o hubo un error en la subida.');
        }
        $allowedMime = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/octet-stream',
            'application/zip',
            '',
        ];
        $tmp = $file['tmp_name'] ?? '';
        if ($tmp === '' || !is_uploaded_file($tmp)) {
            throw new \RuntimeException('Archivo temporal inválido (subida PHP incompleta o sesión expirada).');
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmp) ?: '';
        finfo_close($finfo);
        $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
        if ($ext !== 'xlsx') {
            throw new \RuntimeException('Solo se permiten archivos Excel (.xlsx).');
        }
        if ($mime !== '' && !in_array($mime, $allowedMime, true)) {
            throw new \RuntimeException('Tipo de archivo no reconocido como Excel (.xlsx). MIME detectado: ' . $mime);
        }
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0775, true) && !is_dir($this->uploadDir)) {
                throw new \RuntimeException('No se pudo crear el directorio de carga: ' . $this->uploadDir);
            }
        }
        if (!is_writable($this->uploadDir)) {
            throw new \RuntimeException(
                'El directorio de carga no tiene permisos de escritura para el usuario del servidor web: '
                . $this->uploadDir
                . ' (ajuste propietario/grupo p. ej. www-data o chmod).'
            );
        }
        $base = pathinfo($file['name'], PATHINFO_FILENAME);
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base) ?: 'import';
        $stamp = date('Y-m-d_His');
        $destName = $base . '_' . $stamp . '.xlsx';
        $destPath = $this->uploadDir . '/' . $destName;
        if (!move_uploaded_file($tmp, $destPath)) {
            $err = error_get_last();
            $det = $err && isset($err['message']) ? ' ' . $err['message'] : '';
            throw new \RuntimeException(
                'No se pudo guardar el archivo en el servidor: ' . $destPath . '.' . $det
            );
        }
        return ['path' => $destPath, 'stored_name' => $destName, 'original_name' => $file['name'] ?? $destName];
    }

    /**
     * @return array{rows: array<int,array<string,mixed>>, headers: array<string,int>}
     */
    public function leerFilas(string $absolutePath): array
    {
        $spreadsheet = IOFactory::load($absolutePath);
        $sheet = $spreadsheet->getActiveSheet();
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = (int) $sheet->getHighestRow();
        $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];
        $headers = [];
        foreach ($headerRow as $idx => $name) {
            $key = $this->normalizarCabecera($name);
            if ($key !== '') {
                $headers[$key] = $idx;
            }
        }
        $required = [
            'CODIGO_PROGRAMA', 'NOMBRE_PROGRAMA', 'NIVEL', 'INICIO_VIGENCIA', 'TERMINO_VIGENCIA',
            'SEDE', 'COD_UNIDAD_CARRERA', 'UNIDAD_CARRERA', 'SEMESTRE',
            'CODIGO_ASIGNATURA', 'NOMBRE_ASIGNATURA', 'TIPO',
            'COD_UNIDAD_ASIGNATURA', 'UNIDAD_ASIGNATURA',
        ];
        foreach ($required as $r) {
            if (!isset($headers[$r])) {
                throw new \RuntimeException('Falta la columna obligatoria en el Excel: ' . $r);
            }
        }
        $idxHijo = $headers['CODIGO_ASIGNATURA_1'] ?? null;
        $idxNomHijo = $headers['NOMBRE_ASIGNATURA_1'] ?? null;
        $idxCodForm = $headers['COD_UNIDAD_FORMACION'] ?? null;
        $idxUniForm = $headers['UNIDAD_FORMACION'] ?? null;

        $rows = [];
        for ($r = 2; $r <= $highestRow; $r++) {
            $line = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, null, true, false)[0];
            $codigoProg = trim((string) ($line[$headers['CODIGO_PROGRAMA']] ?? ''));
            if ($codigoProg === '') {
                continue;
            }
            $semRaw = trim((string) ($line[$headers['SEMESTRE']] ?? ''));
            $rows[] = [
                'codigo_programa' => $codigoProg,
                'nombre_programa' => trim((string) ($line[$headers['NOMBRE_PROGRAMA']] ?? '')),
                'nivel' => trim((string) ($line[$headers['NIVEL']] ?? '')),
                'inicio_vigencia' => trim((string) ($line[$headers['INICIO_VIGENCIA']] ?? '')),
                'termino_vigencia' => trim((string) ($line[$headers['TERMINO_VIGENCIA']] ?? '')),
                'sede' => trim((string) ($line[$headers['SEDE']] ?? '')),
                'cod_unidad_carrera' => trim((string) ($line[$headers['COD_UNIDAD_CARRERA']] ?? '')),
                'unidad_carrera' => trim((string) ($line[$headers['UNIDAD_CARRERA']] ?? '')),
                'semestre_raw' => $semRaw,
                'semestre' => $this->parseSemestre($semRaw),
                'codigo_asignatura' => strtoupper(trim((string) ($line[$headers['CODIGO_ASIGNATURA']] ?? ''))),
                'nombre_asignatura' => trim((string) ($line[$headers['NOMBRE_ASIGNATURA']] ?? '')),
                'tipo_excel' => trim((string) ($line[$headers['TIPO']] ?? '')),
                'cod_unidad_asignatura' => trim((string) ($line[$headers['COD_UNIDAD_ASIGNATURA']] ?? '')),
                'unidad_asignatura' => trim((string) ($line[$headers['UNIDAD_ASIGNATURA']] ?? '')),
                'codigo_asignatura_hijo' => $idxHijo !== null ? strtoupper(trim((string) ($line[$idxHijo] ?? ''))) : '',
                'nombre_asignatura_hijo' => $idxNomHijo !== null ? trim((string) ($line[$idxNomHijo] ?? '')) : '',
                'cod_unidad_formacion' => $idxCodForm !== null ? trim((string) ($line[$idxCodForm] ?? '')) : '',
                'unidad_formacion' => $idxUniForm !== null ? trim((string) ($line[$idxUniForm] ?? '')) : '',
                '_fila_excel' => $r,
            ];
        }
        if ($rows === []) {
            throw new \RuntimeException('El archivo no contiene filas de datos con código de programa.');
        }
        return ['rows' => $rows, 'headers' => $headers];
    }

    /**
     * @return array{
     *   errores: list<string>,
     *   errores_detalle: list<array<string,mixed>>,
     *   advertencias: list<string>,
     *   unidades_por_crear: list<array<string,mixed>>,
     *   equivalencias_unidades: list<array<string,mixed>>,
     *   resumen: array<string,mixed>,
     *   informe_malla: list<array<string,mixed>>,
     *   recomendaciones_fusion: list<array<string,mixed>>,
     *   puede_ejecutar: bool,
     *   payload: array<string,mixed>
     * }
     */
    public function previsualizar(PDO $pdo, array $rows, string $modo, ?int $carreraEspejoId): array
    {
        $errores = [];
        $erroresDetalle = [];
        $advertencias = [];
        $unidadesPorCrear = [];
        $mapeosUnidadesAplicados = [];
        $first = $rows[0];
        $codProg = $first['codigo_programa'];
        $inicio = $first['inicio_vigencia'];
        $termino = $first['termino_vigencia'];
        $sedeNombre = $first['sede'];
        $nombreProg = $first['nombre_programa'];

        foreach ($rows as $row) {
            if ($row['codigo_programa'] !== $codProg) {
                $errores[] = 'Hay más de un código de programa en el archivo (no permitido).';
                break;
            }
            if ($row['inicio_vigencia'] !== $inicio || $row['termino_vigencia'] !== $termino) {
                $errores[] = 'Las vigencias deben ser consistentes en todas las filas.';
                break;
            }
            if ($row['sede'] !== $sedeNombre) {
                $errores[] = 'La sede debe ser la misma en todas las filas.';
                break;
            }
        }
        if (!preg_match('/^\d{6}$/', $inicio) || !preg_match('/^\d{6}$/', $termino)) {
            $errores[] = 'INICIO_VIGENCIA y TERMINO_VIGENCIA deben ser 6 dígitos (AAAAMM).';
        }

        $tipoPrograma = $this->mapNivelPrograma($first['nivel']);
        $sedeId = $this->resolverSedeId($pdo, $sedeNombre);
        if ($sedeId === null) {
            $errores[] = 'No se encontró la sede en la base de datos: ' . $sedeNombre;
        }

        $idUnidadCarrera = null;
        if ($sedeId !== null) {
            [$codEqCarr, $nomEqCarr, $aplicoEqCarr] = $this->mapearUnidadEquivalenteDetallado(
                $first['cod_unidad_carrera'],
                $first['unidad_carrera']
            );
            if ($aplicoEqCarr) {
                $mapeosUnidadesAplicados[$sedeId . '|CARRERA|' . $codEqCarr . '|' . $nomEqCarr] = [
                    'tipo' => 'unidad_carrera',
                    'fila' => 1,
                    'sede_id' => $sedeId,
                    'excel_codigo' => (string) $first['cod_unidad_carrera'],
                    'excel_nombre' => (string) $first['unidad_carrera'],
                    'equiv_codigo' => $codEqCarr,
                    'equiv_nombre' => $nomEqCarr,
                    'codigo_asignatura' => '—',
                ];
            }
            $idUnidadCarrera = $this->resolverUnidadIdConEquivalencia(
                $pdo,
                $sedeId,
                (string) $first['cod_unidad_carrera'],
                (string) $first['unidad_carrera']
            );
            if ($idUnidadCarrera === null) {
                $advertencias[] = 'No se encontró la unidad de carrera; se creará al confirmar importación.';
                $kUnidadCarrera = $sedeId . '|CARRERA|' . strtoupper(trim((string) $first['cod_unidad_carrera'])) . '|' . trim((string) $first['unidad_carrera']);
                $unidadesPorCrear[$kUnidadCarrera] = [
                    'tipo' => 'unidad_carrera',
                    'fila' => 1,
                    'sede_id' => $sedeId,
                    'codigo_unidad' => trim((string) $first['cod_unidad_carrera']),
                    'nombre_unidad' => trim((string) $first['unidad_carrera']),
                    'codigo_asignatura' => '—',
                ];
            }
        }

        $maxSem = 0;
        foreach ($rows as $row) {
            if ($row['semestre'] === null) {
                $erroresDetalle[] = [
                    'fila' => $row['_fila_excel'],
                    'codigo' => $row['codigo_asignatura'] ?: '—',
                    'motivo' => 'Semestre inválido: ' . $row['semestre_raw'],
                    'tipo' => 'fila',
                ];
                continue;
            }
            $maxSem = max($maxSem, (int) $row['semestre']);
        }

        $padresConHijos = $this->codigosPadreConHijos($rows);
        foreach ($rows as $row) {
            if ($row['semestre'] === null || $sedeId === null) {
                continue;
            }
            $esPadre = isset($padresConHijos[$row['codigo_asignatura']]);
            $usaSinUnidad = $this->debeUsarSinUnidadPorCodigoFormacion(
                $row['codigo_asignatura'],
                $row['tipo_excel'],
                $esPadre
            );
            if ($usaSinUnidad) {
                continue;
            }
            $uid = $this->resolverUnidadId($pdo, $sedeId, $row['cod_unidad_asignatura'], $row['unidad_asignatura']);
            if ($uid === null) {
                $advertencias[] = 'Fila ' . $row['_fila_excel'] . ' (' . ($row['codigo_asignatura'] ?: '—') . '): unidad no existe y será creada al confirmar.';
                $k = $sedeId . '|ASIGNATURA|' . strtoupper(trim((string) $row['cod_unidad_asignatura'])) . '|' . trim((string) $row['unidad_asignatura']);
                $unidadesPorCrear[$k] = [
                    'tipo' => 'unidad_asignatura',
                    'fila' => $row['_fila_excel'],
                    'sede_id' => $sedeId,
                    'codigo_unidad' => trim((string) $row['cod_unidad_asignatura']),
                    'nombre_unidad' => trim((string) $row['unidad_asignatura']),
                    'codigo_asignatura' => $row['codigo_asignatura'] ?: '—',
                ];
            }
            if ($row['codigo_asignatura_hijo'] !== '') {
                $esHijoSinUnidad = $this->debeUsarSinUnidadPorCodigoFormacion(
                    $row['codigo_asignatura_hijo'],
                    $this->inferirTipoHijo($row),
                    false
                );
                if (!$esHijoSinUnidad) {
                    $uidHijo = $this->resolverUnidadId($pdo, $sedeId, $row['cod_unidad_formacion'], $row['unidad_formacion']);
                    if ($uidHijo === null && ($row['cod_unidad_formacion'] !== '' || $row['unidad_formacion'] !== '')) {
                        $advertencias[] = 'Fila ' . $row['_fila_excel'] . ' (hijo ' . $row['codigo_asignatura_hijo'] . '): unidad de formación no existe y será creada.';
                        $kh = $sedeId . '|FORMACION|' . strtoupper(trim((string) $row['cod_unidad_formacion'])) . '|' . trim((string) $row['unidad_formacion']);
                        $unidadesPorCrear[$kh] = [
                            'tipo' => 'unidad_formacion',
                            'fila' => $row['_fila_excel'],
                            'sede_id' => $sedeId,
                            'codigo_unidad' => trim((string) $row['cod_unidad_formacion']),
                            'nombre_unidad' => trim((string) $row['unidad_formacion']),
                            'codigo_asignatura' => $row['codigo_asignatura_hijo'] ?: '—',
                        ];
                    }
                }
            }
        }

        if ($padresConHijos !== []) {
            $advertencias[] = 'Las asignaturas con opciones de formación (columna CODIGO_ASIGNATURA_1) se registrarán con tipo FORMACION_ELECTIVA cuando corresponda, para cumplir las reglas de la base de datos.';
        }

        if ($modo === 'nueva') {
            if ($sedeId !== null && $idUnidadCarrera !== null) {
                $st = $pdo->prepare(
                    'SELECT c.nombre FROM carreras_espejos ce INNER JOIN carreras c ON c.id = ce.carrera_id
                     WHERE ce.codigo_carrera = ? AND ce.sede_id = ? AND ce.id_unidad = ? LIMIT 1'
                );
                $st->execute([$codProg, $sedeId, $idUnidadCarrera]);
                if ($st->fetch()) {
                    $advertencias[] = "Ya existe el código de programa {$codProg} en esa sede/unidad; se tratará como continuidad de plan nuevo y se cerrará vigencia anterior activa.";
                }
            }
        }

        $vigentesPrevias = 0;
        $carrerasPreviasRelacionadas = [];
        if ($modo === 'nueva' && $sedeId !== null) {
            // Detectar carrera(s) vigente(s) por código+sede y cerrar vigencia en todos sus espejos.
            $stCarrerasPrev = $pdo->prepare(
                'SELECT DISTINCT carrera_id
                 FROM carreras_espejos
                 WHERE codigo_carrera = ? AND sede_id = ? AND vigencia_hasta = \'999999\''
            );
            $stCarrerasPrev->execute([$codProg, $sedeId]);
            $carrerasPreviasRelacionadas = array_map('intval', $stCarrerasPrev->fetchAll(PDO::FETCH_COLUMN));

            if (!empty($carrerasPreviasRelacionadas)) {
                $placeholders = implode(',', array_fill(0, count($carrerasPreviasRelacionadas), '?'));
                $sqlCountPrev = "SELECT COUNT(*) FROM carreras_espejos
                                 WHERE carrera_id IN ($placeholders) AND vigencia_hasta = '999999'";
                $stPrev = $pdo->prepare($sqlCountPrev);
                $stPrev->execute($carrerasPreviasRelacionadas);
                $vigentesPrevias = (int) $stPrev->fetchColumn();
            }
            if ($vigentesPrevias > 0) {
                $advertencias[] = 'Se detectó(n) ' . $vigentesPrevias . ' carrera(s) espejo vigente(s) (vigencia_hasta=999999) asociadas al plan anterior; se actualizarán todas a vigencia_hasta=' . $inicio . '.';
            }
        }

        $carreraRefNombre = null;
        if ($modo === 'espejo') {
            if ($carreraEspejoId === null || $carreraEspejoId < 1) {
                $errores[] = 'Debe seleccionar la carrera vigente a la que se asociará el espejo.';
            } else {
                $st = $pdo->prepare('SELECT id, nombre FROM carreras WHERE id = ?');
                $st->execute([$carreraEspejoId]);
                $ref = $st->fetch(PDO::FETCH_ASSOC);
                if (!$ref) {
                    $errores[] = 'La carrera de referencia no existe.';
                } else {
                    $carreraRefNombre = $ref['nombre'];
                    $advertencias[] = 'Modo espejo: la equivalencia con la malla de referencia es por nombre y semestre; el código de asignatura del Excel corresponde a la sede importada y no se compara con el de la referencia.';
                }
            }
            if ($carreraEspejoId !== null && (int) $carreraEspejoId >= 1 && $sedeId !== null) {
                $stDup = $pdo->prepare(
                    'SELECT id FROM carreras_espejos WHERE carrera_id = ? AND codigo_carrera = ? AND sede_id = ? LIMIT 1'
                );
                $stDup->execute([(int) $carreraEspejoId, $codProg, $sedeId]);
                if ($stDup->fetch()) {
                    $errores[] = 'Ya existe este código de programa para la carrera de referencia en la sede indicada (carreras espejo).';
                }
            }
        }

        $mallaClaves = [];
        foreach ($rows as $row) {
            if ($row['semestre'] === null || $row['codigo_asignatura'] === '') {
                continue;
            }
            $k = $row['codigo_asignatura'] . '|' . $row['semestre'];
            $mallaClaves[$k] = $row;
        }

        $informeMalla = [];
        $recomendacionesFusion = [];
        $equivOk = 0;
        $equivFail = 0;
        $filasCodigoYaEnSede = 0;
        $filasFusionRecomendada = 0;
        $avisosMultidepartamentoCodigo = [];

        $equivalenciasPorClave = [];
        if ($modo === 'espejo' && $carreraEspejoId !== null && (int) $carreraEspejoId >= 1 && $errores === []) {
            $refMalla = $this->cargarMallaReferencia($pdo, (int) $carreraEspejoId);
            foreach ($mallaClaves as $k => $row) {
                $match = $this->buscarEquivalenciaEnReferencia($row, $refMalla, $padresConHijos);
                if ($match) {
                    $equivOk++;
                    $equivalenciasPorClave[$k] = (int) $match['id'];
                    $lineaInforme = [
                        'fila' => $row['_fila_excel'],
                        'codigo_excel' => $row['codigo_asignatura'],
                        'semestre' => $row['semestre'],
                        'equivalente_id' => $match['id'],
                        'equivalente_nombre' => $match['nombre'],
                        'metodo' => $match['metodo'],
                        'codigo_ya_en_sede' => false,
                        'malla_usara_asignatura_id' => (int) $match['id'],
                        'fusion_recomendada' => false,
                        'nota_malla' => null,
                    ];
                    $deptExistente = $this->buscarPrimerDepartamentoPorCodigo($pdo, $row['codigo_asignatura']);
                    if ($deptExistente !== null) {
                        $filasCodigoYaEnSede++;
                        $idRef = (int) $match['id'];
                        $idDept = (int) $deptExistente['asignatura_id'];
                        $lineaInforme['codigo_ya_en_sede'] = true;
                        $lineaInforme['codigo_en_misma_sede'] = (
                            $sedeId !== null && $sedeId > 0
                            && (int) ($deptExistente['unidad_sede_id'] ?? -1) === (int) $sedeId
                        );
                        $lineaInforme['malla_usara_asignatura_id'] = $idDept;
                        if ($idRef !== $idDept) {
                            $filasFusionRecomendada++;
                            $lineaInforme['fusion_recomendada'] = true;
                            $lineaInforme['nota_malla'] = 'El código ya existe en asignaturas_departamentos; la malla usará ese asignatura_id. '
                                . 'Si difiere del id obtenido por nombre en la referencia, conviene fusionar asignaturas al editar la malla.';
                            $recomendacionesFusion[] = [
                                'fila' => $row['_fila_excel'],
                                'codigo_excel' => $row['codigo_asignatura'],
                                'nombre_excel' => $row['nombre_asignatura'],
                                'semestre' => $row['semestre'],
                                'asignatura_id_por_nombre_referencia' => $idRef,
                                'nombre_por_referencia' => (string) $match['nombre'],
                                'asignatura_id_codigo_en_sede' => $idDept,
                                'nombre_en_bd_sede' => (string) $deptExistente['nombre_asignatura'],
                            ];
                        } else {
                            $lineaInforme['nota_malla'] = 'Código ya registrado en departamentos con el mismo asignatura_id que la referencia; solo se asegura la fila en la malla.';
                        }
                        if (!empty($deptExistente['varias_filas_departamento'])) {
                            $ck = $row['codigo_asignatura'];
                            if (!isset($avisosMultidepartamentoCodigo[$ck])) {
                                $avisosMultidepartamentoCodigo[$ck] = true;
                                $advertencias[] = 'Hay más de un registro en asignaturas_departamentos para el código '
                                    . $row['codigo_asignatura'] . '; se usará el de id interno más bajo.';
                            }
                        }
                    }
                    $informeMalla[] = $lineaInforme;
                } else {
                    $equivFail++;
                    $erroresDetalle[] = [
                        'fila' => $row['_fila_excel'],
                        'codigo' => $row['codigo_asignatura'] ?: '—',
                        'motivo' => 'No se encontró en la carrera de referencia una asignatura con el mismo nombre (y semestre ' . $row['semestre'] . '); el código del Excel es propio de la sede y no se usa para emparejar.',
                        'tipo' => 'equivalencia',
                    ];
                    $informeMalla[] = [
                        'fila' => $row['_fila_excel'],
                        'codigo_excel' => $row['codigo_asignatura'],
                        'semestre' => $row['semestre'],
                        'equivalente_id' => null,
                        'equivalente_nombre' => null,
                        'metodo' => 'sin coincidencia',
                    ];
                }
            }
            if ($equivFail > 0) {
                $advertencias[] = "Se omitirá(n) {$equivFail} asignatura(s) sin equivalencia en carrera espejo.";
            }
            if ($filasCodigoYaEnSede > 0) {
                $advertencias[] = "{$filasCodigoYaEnSede} asignatura(s) tienen el código del Excel ya presente en asignaturas_departamentos (la base exige códigos únicos): no se inserta otro departamento; se agregan a la malla con el asignatura_id ya vinculado a ese código. Si ese id no coincide con el de la referencia por nombre, en edición de malla conviene fusionar asignaturas.";
            }
        }

        if ($modo === 'nueva') {
            $existentes = 0;
            $nuevas = 0;
            $codesU = $this->todosCodigosAsignatura($rows);
            foreach ($codesU as $c) {
                if ($c === '') {
                    continue;
                }
                if ($this->obtenerAsignaturaIdPorCodigo($pdo, $c) !== null) {
                    $existentes++;
                } else {
                    $nuevas++;
                }
            }
            foreach ($mallaClaves as $row) {
                $cod = $row['codigo_asignatura'];
                $idExistente = $cod !== '' ? $this->obtenerAsignaturaIdPorCodigo($pdo, $cod) : null;
                $informeMalla[] = [
                    'fila' => $row['_fila_excel'],
                    'codigo' => $cod,
                    'semestre' => $row['semestre'],
                    'nombre' => $row['nombre_asignatura'],
                    'asignatura_en_bd' => $idExistente !== null,
                    'asignatura_id_existente' => $idExistente,
                ];
            }
            $resumen['asignaturas_codigos_unicos'] = count($codesU);
            $resumen['asignaturas_existentes_bd'] = $existentes;
            $resumen['asignaturas_nuevas'] = $nuevas;
        }

        $clavesConError = [];
        foreach ($erroresDetalle as $det) {
            if (!isset($det['fila']) || !is_numeric($det['fila'])) {
                continue;
            }
            $fila = (int) $det['fila'];
            foreach ($rows as $row) {
                if ((int) $row['_fila_excel'] === $fila && $row['semestre'] !== null && $row['codigo_asignatura'] !== '') {
                    $clavesConError[$row['codigo_asignatura'] . '|' . $row['semestre']] = true;
                }
            }
        }

        $mallaImportable = [];
        foreach ($mallaClaves as $k => $row) {
            if (isset($clavesConError[$k])) {
                continue;
            }
            if ($modo === 'espejo') {
                if (!isset($equivalenciasPorClave[$k])) {
                    continue;
                }
            }
            $mallaImportable[$k] = $row;
        }

        $resumen['modo'] = $modo;
        $resumen['codigo_programa'] = $codProg;
        $resumen['nombre_programa'] = $nombreProg;
        $resumen['tipo_programa'] = $tipoPrograma;
        $resumen['inicio_vigencia'] = $inicio;
        $resumen['termino_vigencia'] = $termino;
        $resumen['sede'] = $sedeNombre;
        $resumen['sede_id'] = $sedeId;
        $resumen['unidad_carrera_id'] = $idUnidadCarrera;
        $resumen['filas_excel'] = count($rows);
        $resumen['filas_malla_distintas'] = count($mallaClaves);
        $resumen['filas_importables'] = count($mallaImportable);
        $resumen['filas_con_conflicto'] = count($mallaClaves) - count($mallaImportable);
        $resumen['unidades_por_crear_total'] = count($unidadesPorCrear);
        $resumen['equivalencias_unidades_total'] = count($mapeosUnidadesAplicados);
        $resumen['vigencias_previas_a_cerrar'] = $vigentesPrevias;
        $resumen['carreras_previas_relacionadas'] = count($carrerasPreviasRelacionadas);
        $resumen['max_semestre'] = $maxSem;
        $resumen['carrera_referencia'] = $carreraRefNombre;
        $resumen['carrera_referencia_id'] = $carreraEspejoId;
        $resumen['espejo_filas_codigo_ya_en_sede'] = $filasCodigoYaEnSede;
        $resumen['espejo_filas_fusion_recomendada'] = $filasFusionRecomendada;

        $enlacesFormacion = 0;
        foreach ($rows as $row) {
            if ($row['codigo_asignatura_hijo'] !== '') {
                $enlacesFormacion++;
            }
        }
        $resumen['filas_relacion_formacion'] = $enlacesFormacion;

        $puedeEjecutar = ($errores === []) && (count($mallaImportable) > 0);

        $rowsImportables = [];
        foreach ($rows as $row) {
            if ($row['semestre'] === null || $row['codigo_asignatura'] === '') {
                continue;
            }
            $k = $row['codigo_asignatura'] . '|' . $row['semestre'];
            if (isset($mallaImportable[$k])) {
                $rowsImportables[] = $row;
            }
        }

        $payload = [
            'modo' => $modo,
            'carrera_espejo_id' => $carreraEspejoId,
            'rows' => $rowsImportables,
            'equivalencias_por_clave' => $equivalenciasPorClave,
            'unidades_por_crear' => array_values($unidadesPorCrear),
            'meta' => [
                'codigo_programa' => $codProg,
                'nombre_programa' => $this->normalizarNombreCarrera($nombreProg),
                'tipo_programa' => $tipoPrograma,
                'inicio_vigencia' => $inicio,
                'termino_vigencia' => $termino,
                'sede_id' => $sedeId,
                'id_unidad_carrera' => $idUnidadCarrera,
                'cod_unidad_carrera' => $first['cod_unidad_carrera'],
                'unidad_carrera' => $first['unidad_carrera'],
                'max_semestre' => $maxSem ?: 10,
                'padres_con_hijos' => array_keys($padresConHijos),
                'carreras_previas_relacionadas' => $carrerasPreviasRelacionadas,
            ],
        ];

        return [
            'errores' => $errores,
            'errores_detalle' => $erroresDetalle,
            'advertencias' => $advertencias,
            'unidades_por_crear' => array_values($unidadesPorCrear),
            'equivalencias_unidades' => array_values($mapeosUnidadesAplicados),
            'resumen' => $resumen,
            'informe_malla' => $informeMalla,
            'recomendaciones_fusion' => $recomendacionesFusion,
            'puede_ejecutar' => $puedeEjecutar,
            'payload' => $payload,
        ];
    }

    /**
     * @param array<string,mixed> $payload
     */
    public function ejecutar(PDO $pdo, array $payload): array
    {
        $modo = $payload['modo'] ?? '';
        $rows = $payload['rows'] ?? [];
        $meta = $payload['meta'] ?? [];
        if (!in_array($modo, ['nueva', 'espejo'], true) || $rows === []) {
            throw new \RuntimeException('Datos de importación inválidos o expirados. Vuelva a cargar el archivo.');
        }

        $pdo->beginTransaction();
        try {
            if ($modo === 'nueva') {
                $carreraId = $this->ejecutarCarreraNueva($pdo, $rows, $meta);
            } else {
                $carreraId = $this->ejecutarCarreraEspejo(
                    $pdo,
                    $rows,
                    $meta,
                    (int) ($payload['carrera_espejo_id'] ?? 0),
                    $payload['equivalencias_por_clave'] ?? []
                );
            }
            $pdo->commit();
            return [
                'carrera_id' => $carreraId,
                'filas_importadas' => count($rows),
            ];
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     * @param array<string,mixed> $meta
     */
    private function ejecutarCarreraNueva(PDO $pdo, array $rows, array $meta): int
    {
        $nombre = $meta['nombre_programa'];
        $tipo = $meta['tipo_programa'];
        $sem = (int) ($meta['max_semestre'] ?? 10);
        $sedeId = (int) ($meta['sede_id'] ?? 0);
        $unidadCarreraId = $meta['id_unidad_carrera'] ?? null;
        if ($unidadCarreraId === null || (int) $unidadCarreraId <= 0) {
            $unidadCarreraId = $this->asegurarUnidadId(
                $pdo,
                $sedeId,
                (string) ($meta['cod_unidad_carrera'] ?? ''),
                (string) ($meta['unidad_carrera'] ?? 'UNIDAD IMPORTADA'),
                true
            );
        }
        $st = $pdo->prepare(
            'INSERT INTO carreras (nombre, tipo_programa, cantidad_semestres, estado, url_libro, imagen_url)
             VALUES (?, ?, ?, 1, NULL, NULL)'
        );
        $st->execute([$nombre, $tipo, $sem]);
        $carreraId = (int) $pdo->lastInsertId();

        $insCe = $pdo->prepare(
            'INSERT INTO carreras_espejos (carrera_id, codigo_carrera, vigencia_desde, vigencia_hasta, sede_id, id_unidad, estado)
             VALUES (?, ?, ?, ?, ?, ?, 1)'
        );

        // Cerrar vigencia de planes previos activos (999999) en TODOS los espejos de las carreras relacionadas.
        $carrerasPreviasRelacionadas = $meta['carreras_previas_relacionadas'] ?? [];
        if (is_array($carrerasPreviasRelacionadas) && !empty($carrerasPreviasRelacionadas)) {
            $ids = array_values(array_unique(array_map('intval', $carrerasPreviasRelacionadas)));
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sqlCerrar = "UPDATE carreras_espejos
                          SET vigencia_hasta = ?
                          WHERE carrera_id IN ($placeholders) AND vigencia_hasta = '999999'";
            $stCerrar = $pdo->prepare($sqlCerrar);
            $stCerrar->execute(array_merge([$meta['inicio_vigencia']], $ids));
        } else {
            // Fallback: comportamiento original por código+sede.
            $stCerrar = $pdo->prepare(
                'UPDATE carreras_espejos
                 SET vigencia_hasta = ?
                 WHERE codigo_carrera = ? AND sede_id = ? AND vigencia_hasta = \'999999\''
            );
            $stCerrar->execute([
                $meta['inicio_vigencia'],
                $meta['codigo_programa'],
                $sedeId,
            ]);
        }

        $insCe->execute([
            $carreraId,
            $meta['codigo_programa'],
            $meta['inicio_vigencia'],
            $meta['termino_vigencia'],
            $sedeId,
            $unidadCarreraId,
        ]);

        $padresConHijos = $this->codigosPadreConHijos($rows);
        $todosCodigos = $this->todosCodigosAsignatura($rows);

        $metaPorCodigo = [];
        foreach ($rows as $row) {
            $c = $row['codigo_asignatura'];
            if ($c === '') {
                continue;
            }
            if (!isset($metaPorCodigo[$c])) {
                $metaPorCodigo[$c] = $row;
            }
            $h = $row['codigo_asignatura_hijo'];
            if ($h !== '' && !isset($metaPorCodigo[$h])) {
                $mh = $row;
                $mh['codigo_asignatura'] = $h;
                $mh['nombre_asignatura'] = $row['nombre_asignatura_hijo'] ?: $h;
                $mh['tipo_excel'] = $this->inferirTipoHijo($row);
                $mh['cod_unidad_asignatura'] = $row['cod_unidad_formacion'] ?: $row['cod_unidad_asignatura'];
                $mh['unidad_asignatura'] = $row['unidad_formacion'] ?: $row['unidad_asignatura'];
                $metaPorCodigo[$h] = $mh;
            }
        }

        $idsPorCodigo = [];
        foreach ($todosCodigos as $cod) {
            $ex = $this->obtenerAsignaturaIdPorCodigo($pdo, $cod);
            $rowMeta = $metaPorCodigo[$cod] ?? null;
            if (!$rowMeta) {
                continue;
            }
            if ($ex !== null) {
                $idsPorCodigo[$cod] = $ex;
                continue;
            }
            $tipoDb = $this->mapTipoAsignatura(
                $rowMeta['tipo_excel'],
                isset($padresConHijos[$cod])
            );
            $uid = $this->resolverUnidadId(
                $pdo,
                $sedeId,
                $rowMeta['cod_unidad_asignatura'],
                $rowMeta['unidad_asignatura']
            );
            $esSinUnidad = $this->debeUsarSinUnidadPorCodigoFormacion(
                $cod,
                (string) $rowMeta['tipo_excel'],
                isset($padresConHijos[$cod])
            );
            if ($esSinUnidad) {
                $uid = 0;
            }
            if ($uid === null) {
                $uid = $this->asegurarUnidadId(
                    $pdo,
                    $sedeId,
                    (string) $rowMeta['cod_unidad_asignatura'],
                    (string) $rowMeta['unidad_asignatura'],
                    false
                );
            }
            $stA = $pdo->prepare(
                'INSERT INTO asignaturas (nombre, tipo, vigencia_desde, vigencia_hasta, estado, periodicidad, url_programa)
                 VALUES (?, ?, ?, ?, 1, \'semestral\', NULL)'
            );
            $stA->execute([
                $this->normalizarNombreAsignatura($rowMeta['nombre_asignatura']),
                $tipoDb,
                $meta['inicio_vigencia'],
                $meta['termino_vigencia'],
            ]);
            $aid = (int) $pdo->lastInsertId();
            $stAd = $pdo->prepare(
                'INSERT INTO asignaturas_departamentos (asignatura_id, codigo_asignatura, cantidad_alumnos, id_unidad)
                 VALUES (?, ?, 0, ?)'
            );
            $stAd->execute([$aid, $cod, $uid]);
            $idsPorCodigo[$cod] = $aid;
        }

        $insM = $pdo->prepare('INSERT INTO mallas (carrera_id, asignatura_id, semestre) VALUES (?, ?, ?)');
        $vistos = [];
        foreach ($rows as $row) {
            if ($row['semestre'] === null || $row['codigo_asignatura'] === '') {
                continue;
            }
            $c = $row['codigo_asignatura'];
            $s = (int) $row['semestre'];
            $k = $c . '|' . $s;
            if (isset($vistos[$k])) {
                continue;
            }
            $vistos[$k] = true;
            if (!isset($idsPorCodigo[$c])) {
                throw new \RuntimeException('No se pudo resolver asignatura para malla: ' . $c);
            }
            $insM->execute([$carreraId, $idsPorCodigo[$c], $s]);

            // Si la fila trae asignatura hija de formación, también se agrega a malla para habilitar su vinculación.
            if (($row['codigo_asignatura_hijo'] ?? '') !== '') {
                $h = $row['codigo_asignatura_hijo'];
                $kh = $h . '|' . $s;
                if (!isset($vistos[$kh]) && isset($idsPorCodigo[$h])) {
                    $vistos[$kh] = true;
                    $insM->execute([$carreraId, $idsPorCodigo[$h], $s]);
                }
            }
        }

        $insF = $pdo->prepare(
            'INSERT IGNORE INTO asignaturas_formacion (asignatura_formacion_id, asignatura_regular_id) VALUES (?, ?)'
        );
        $tipoAsigStmt = $pdo->prepare('SELECT tipo FROM asignaturas WHERE id = ? LIMIT 1');
        foreach ($rows as $row) {
            if ($row['codigo_asignatura_hijo'] === '') {
                continue;
            }
            $pa = $row['codigo_asignatura'];
            $hi = $row['codigo_asignatura_hijo'];
            if (!isset($idsPorCodigo[$pa], $idsPorCodigo[$hi])) {
                throw new \RuntimeException("Enlace formación no resuelto: {$pa} -> {$hi}");
            }

            // Respetar restricciones del trigger en BD:
            // padre debe ser FORMACION_ELECTIVA, hijo no puede ser REGULAR ni FORMACION_ELECTIVA.
            $tipoAsigStmt->execute([$idsPorCodigo[$pa]]);
            $tipoPadre = (string) ($tipoAsigStmt->fetchColumn() ?: '');
            $tipoAsigStmt->execute([$idsPorCodigo[$hi]]);
            $tipoHijo = (string) ($tipoAsigStmt->fetchColumn() ?: '');

            if ($tipoPadre !== 'FORMACION_ELECTIVA') {
                continue;
            }
            if ($tipoHijo === 'REGULAR' || $tipoHijo === 'FORMACION_ELECTIVA') {
                continue;
            }

            $insF->execute([$idsPorCodigo[$pa], $idsPorCodigo[$hi]]);
        }

        return $carreraId;
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     * @param array<string,mixed> $meta
     */
    private function ejecutarCarreraEspejo(
        PDO $pdo,
        array $rows,
        array $meta,
        int $carreraRefId,
        array $equivalenciasPorClave = []
    ): int
    {
        $insCe = $pdo->prepare(
            'INSERT INTO carreras_espejos (carrera_id, codigo_carrera, vigencia_desde, vigencia_hasta, sede_id, id_unidad, estado)
             VALUES (?, ?, ?, ?, ?, ?, 1)'
        );
        $sedeId = (int) ($meta['sede_id'] ?? 0);
        $unidadCarreraId = $meta['id_unidad_carrera'] ?? null;
        if ($unidadCarreraId === null || (int) $unidadCarreraId <= 0) {
            $unidadCarreraId = $this->asegurarUnidadId(
                $pdo,
                $sedeId,
                (string) ($meta['cod_unidad_carrera'] ?? ''),
                (string) ($meta['unidad_carrera'] ?? 'UNIDAD IMPORTADA'),
                true
            );
        }
        $insCe->execute([
            $carreraRefId,
            $meta['codigo_programa'],
            $meta['inicio_vigencia'],
            $meta['termino_vigencia'],
            $sedeId,
            $unidadCarreraId,
        ]);

        $refMalla = $this->cargarMallaReferencia($pdo, $carreraRefId);
        $padresConHijos = $this->codigosPadreConHijos($rows);
        $mallaClaves = [];
        foreach ($rows as $row) {
            if ($row['semestre'] === null || $row['codigo_asignatura'] === '') {
                continue;
            }
            $k = $row['codigo_asignatura'] . '|' . $row['semestre'];
            $mallaClaves[$k] = $row;
        }

        $stAd = $pdo->prepare(
            'INSERT INTO asignaturas_departamentos (asignatura_id, codigo_asignatura, cantidad_alumnos, id_unidad)
             VALUES (?, ?, 0, ?)'
        );
        $insMalla = $pdo->prepare(
            'INSERT IGNORE INTO mallas (carrera_id, asignatura_id, semestre) VALUES (?, ?, ?)'
        );

        foreach ($mallaClaves as $row) {
            $key = $row['codigo_asignatura'] . '|' . $row['semestre'];
            $match = null;
            if (isset($equivalenciasPorClave[$key])) {
                $match = ['id' => (int) $equivalenciasPorClave[$key]];
            } else {
                $match = $this->buscarEquivalenciaEnReferencia($row, $refMalla, $padresConHijos);
            }
            if (!$match) {
                throw new \RuntimeException('Falló equivalencia (no debería ejecutarse): ' . $row['codigo_asignatura']);
            }
            $codNuevo = $row['codigo_asignatura'];
            $existenteDept = $this->buscarPrimerDepartamentoPorCodigo($pdo, $codNuevo);

            if ($existenteDept !== null) {
                $asidFinal = (int) $existenteDept['asignatura_id'];
            } else {
                $uid = $this->resolverUnidadId(
                    $pdo,
                    $sedeId,
                    $row['cod_unidad_asignatura'],
                    $row['unidad_asignatura']
                );
                $esSinUnidad = $this->debeUsarSinUnidadPorCodigoFormacion(
                    $row['codigo_asignatura'],
                    (string) $row['tipo_excel'],
                    isset($padresConHijos[$row['codigo_asignatura']])
                );
                if ($esSinUnidad) {
                    $uid = 0;
                }
                if ($uid === null) {
                    $uid = $this->asegurarUnidadId(
                        $pdo,
                        $sedeId,
                        (string) $row['cod_unidad_asignatura'],
                        (string) $row['unidad_asignatura'],
                        false
                    );
                }
                $stAd->execute([(int) $match['id'], $codNuevo, $uid]);
                $asidFinal = (int) $match['id'];
            }

            $insMalla->execute([$carreraRefId, $asidFinal, (int) $row['semestre']]);
        }

        return $carreraRefId;
    }

    /** @return array<int,array<string,mixed>> */
    private function cargarMallaReferencia(PDO $pdo, int $carreraId): array
    {
        $sql = 'SELECT m.semestre, a.id, a.nombre, a.tipo
                FROM mallas m
                INNER JOIN asignaturas a ON a.id = m.asignatura_id
                WHERE m.carrera_id = ?';
        $st = $pdo->prepare($sql);
        $st->execute([$carreraId]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array<string,mixed> $rowExcel
     * @param array<int,array<string,mixed>> $refMalla
     * @param array<string,bool> $padresConHijos
     * @return array{id:int,nombre:string,tipo:string,metodo:string}|null
     */
    private function buscarEquivalenciaEnReferencia(array $rowExcel, array $refMalla, array $padresConHijos): ?array
    {
        $sem = (int) $rowExcel['semestre'];
        $nomN = $this->normalizeNombreBusqueda($rowExcel['nombre_asignatura']);
        if ($nomN === '') {
            return null;
        }
        $esPadre = isset($padresConHijos[$rowExcel['codigo_asignatura']]);
        $tipoMap = $this->mapTipoAsignatura($rowExcel['tipo_excel'], $esPadre);

        $refsSem = [];
        foreach ($refMalla as $ref) {
            if ((int) $ref['semestre'] === $sem) {
                $refsSem[] = $ref;
            }
        }
        if ($refsSem === []) {
            return null;
        }

        // Espejo: mismo nombre de asignatura y semestre; el código en Excel corresponde a la sede y no se compara con la referencia.
        $exact = [];
        foreach ($refsSem as $ref) {
            $nomR = $this->normalizeNombreBusqueda((string) $ref['nombre']);
            if ($nomR !== '' && $nomN === $nomR) {
                $exact[] = $ref;
            }
        }
        $elegido = $this->elegirReferenciaEspejoPorTipo($exact, $tipoMap);
        if ($elegido !== null) {
            return [
                'id' => (int) $elegido['id'],
                'nombre' => (string) $elegido['nombre'],
                'tipo' => (string) $elegido['tipo'],
                'metodo' => $elegido['tipo'] === $tipoMap
                    ? 'nombre_exacto+semestre+tipo'
                    : 'nombre_exacto+semestre(tipo Excel distinto; referencia prioritaria)',
            ];
        }
        if (count($exact) > 1) {
            return null;
        }

        $compat = [];
        foreach ($refsSem as $ref) {
            $nomR = $this->normalizeNombreBusqueda((string) $ref['nombre']);
            if ($nomR === '') {
                continue;
            }
            if ($this->nombresAsignaturaCompatiblesEspejo($nomN, $nomR)) {
                $compat[] = $ref;
            }
        }
        $elegido = $this->elegirReferenciaEspejoPorTipo($compat, $tipoMap);
        if ($elegido !== null) {
            return [
                'id' => (int) $elegido['id'],
                'nombre' => (string) $elegido['nombre'],
                'tipo' => (string) $elegido['tipo'],
                'metodo' => $elegido['tipo'] === $tipoMap
                    ? 'nombre_compat+semestre+tipo'
                    : 'nombre_compat+semestre(tipo Excel distinto; referencia prioritaria)',
            ];
        }

        return null;
    }

    /**
     * Nombres ya normalizados. Permite subcadena solo si la parte más corta tiene longitud mínima (evita falsos positivos).
     */
    private function nombresAsignaturaCompatiblesEspejo(string $nomN, string $nomR): bool
    {
        if ($nomN === '' || $nomR === '') {
            return false;
        }
        if ($nomN === $nomR) {
            return true;
        }
        $short = mb_strlen($nomN) <= mb_strlen($nomR) ? $nomN : $nomR;
        $long = mb_strlen($nomN) <= mb_strlen($nomR) ? $nomR : $nomN;
        if (mb_strlen($short) < 8) {
            return false;
        }
        return str_contains($long, $short);
    }

    /**
     * @param array<int,array<string,mixed>> $candidatos
     * @return array<string,mixed>|null
     */
    private function elegirReferenciaEspejoPorTipo(array $candidatos, string $tipoMap): ?array
    {
        if ($candidatos === []) {
            return null;
        }
        $conTipo = [];
        foreach ($candidatos as $ref) {
            if (($ref['tipo'] ?? '') === $tipoMap) {
                $conTipo[] = $ref;
            }
        }
        if (count($conTipo) === 1) {
            return $conTipo[0];
        }
        if (count($conTipo) > 1) {
            return null;
        }
        if (count($candidatos) === 1) {
            return $candidatos[0];
        }

        return null;
    }

    /** @return array<string,bool> */
    private function codigosPadreConHijos(array $rows): array
    {
        $p = [];
        foreach ($rows as $row) {
            $codigoPadre = strtoupper(trim((string) ($row['codigo_asignatura'] ?? '')));
            $tipoExcel = mb_strtolower(trim((string) ($row['tipo_excel'] ?? '')), 'UTF-8');

            // Regla de negocio:
            // Toda asignatura de formación cuyo código comience con "UN"
            // se considera electiva padre y sus hijas se toman de columnas *_1.
            $esPadreUNFormacion = str_starts_with($codigoPadre, 'UN') && str_contains($tipoExcel, 'formacion');

            if (($row['codigo_asignatura_hijo'] ?? '') !== '' || $esPadreUNFormacion) {
                $p[$row['codigo_asignatura']] = true;
            }
        }
        return $p;
    }

    /** @return list<string> */
    private function todosCodigosAsignatura(array $rows): array
    {
        $s = [];
        foreach ($rows as $row) {
            if ($row['codigo_asignatura'] !== '') {
                $s[$row['codigo_asignatura']] = true;
            }
            if (($row['codigo_asignatura_hijo'] ?? '') !== '') {
                $s[$row['codigo_asignatura_hijo']] = true;
            }
        }
        return array_keys($s);
    }

    private function inferirTipoHijo(array $row): string
    {
        if (($row['nombre_asignatura_hijo'] ?? '') !== '') {
            return 'REGULAR';
        }
        return $row['tipo_excel'] ?: 'REGULAR';
    }

    private function obtenerAsignaturaIdPorCodigo(PDO $pdo, string $codigo): ?int
    {
        $st = $pdo->prepare('SELECT asignatura_id FROM asignaturas_departamentos WHERE codigo_asignatura = ? LIMIT 1');
        $st->execute([$codigo]);
        $id = $st->fetchColumn();
        return $id !== false ? (int) $id : null;
    }

    /**
     * Primer registro departamental para un código (en BD suele existir UNIQUE en codigo_asignatura).
     *
     * @return array{asignatura_id:int,id_unidad:int,nombre_asignatura:string,unidad_sede_id:int,varias_filas_departamento?:bool}|null
     */
    private function buscarPrimerDepartamentoPorCodigo(PDO $pdo, string $codigo): ?array
    {
        $codigo = strtoupper(trim($codigo));
        if ($codigo === '') {
            return null;
        }
        $st = $pdo->prepare(
            'SELECT ad.asignatura_id, ad.id_unidad, a.nombre AS nombre_asignatura, u.sede_id AS unidad_sede_id
             FROM asignaturas_departamentos ad
             INNER JOIN unidades u ON u.id = ad.id_unidad
             INNER JOIN asignaturas a ON a.id = ad.asignatura_id
             WHERE ad.codigo_asignatura = ?
             ORDER BY ad.id ASC
             LIMIT 3'
        );
        $st->execute([$codigo]);
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        if ($rows === []) {
            return null;
        }
        $out = [
            'asignatura_id' => (int) $rows[0]['asignatura_id'],
            'id_unidad' => (int) $rows[0]['id_unidad'],
            'nombre_asignatura' => (string) $rows[0]['nombre_asignatura'],
            'unidad_sede_id' => (int) $rows[0]['unidad_sede_id'],
        ];
        if (count($rows) > 1) {
            $out['varias_filas_departamento'] = true;
        }
        return $out;
    }

    private function resolverSedeId(PDO $pdo, string $nombre): ?int
    {
        $nombre = trim($nombre);
        $st = $pdo->prepare('SELECT id FROM sedes WHERE nombre = ? AND id > 0 LIMIT 1');
        $st->execute([$nombre]);
        $id = $st->fetchColumn();
        if ($id !== false) {
            return (int) $id;
        }
        $st = $pdo->prepare('SELECT id FROM sedes WHERE nombre LIKE ? AND id > 0 LIMIT 1');
        $st->execute(['%' . $nombre . '%']);
        $id = $st->fetchColumn();
        return $id !== false ? (int) $id : null;
    }

    private function resolverUnidadId(PDO $pdo, int $sedeId, string $codigo, string $nombre): ?int
    {
        $codigo = trim($codigo);
        $nombre = trim($nombre);

        if ($codigo !== '') {
            $st = $pdo->prepare('SELECT id FROM unidades WHERE sede_id = ? AND codigo = ? LIMIT 1');
            $st->execute([$sedeId, $codigo]);
            $id = $st->fetchColumn();
            if ($id !== false) {
                return (int) $id;
            }
        }
        if ($nombre !== '') {
            $st = $pdo->prepare('SELECT id FROM unidades WHERE sede_id = ? AND nombre = ? LIMIT 1');
            $st->execute([$sedeId, $nombre]);
            $id = $st->fetchColumn();
            if ($id !== false) {
                return (int) $id;
            }
            $st = $pdo->prepare('SELECT id FROM unidades WHERE sede_id = ? AND nombre LIKE ? LIMIT 1');
            $st->execute([$sedeId, '%' . $nombre . '%']);
            $id = $st->fetchColumn();
            if ($id !== false) {
                return (int) $id;
            }
        }
        return null;
    }

    private function resolverUnidadIdConEquivalencia(PDO $pdo, int $sedeId, string $codigo, string $nombre): ?int
    {
        [$codigoEq, $nombreEq] = $this->mapearUnidadEquivalente($codigo, $nombre);
        $id = $this->resolverUnidadId($pdo, $sedeId, $codigoEq, $nombreEq);
        if ($id !== null) {
            return $id;
        }
        return $this->resolverUnidadId($pdo, $sedeId, $codigo, $nombre);
    }

    private function asegurarUnidadId(PDO $pdo, int $sedeId, string $codigo, string $nombre, bool $aplicarEquivalencia = false): int
    {
        if ($aplicarEquivalencia) {
            [$codigo, $nombre] = $this->mapearUnidadEquivalente($codigo, $nombre);
        }
        $existente = $this->resolverUnidadId($pdo, $sedeId, $codigo, $nombre);
        if ($existente !== null) {
            return $existente;
        }
        $codigo = strtoupper(trim($codigo));
        $nombre = trim($nombre) !== '' ? trim($nombre) : 'UNIDAD IMPORTADA';
        if ($codigo === '') {
            $codigo = 'IMP' . $sedeId . substr((string) time(), -4);
        }

        $codigoBase = substr(preg_replace('/[^A-Z0-9_-]/', '', $codigo), 0, 10);
        if ($codigoBase === '') {
            $codigoBase = 'IMP' . $sedeId;
        }
        $codigoFinal = $codigoBase;
        $i = 1;
        while (true) {
            $st = $pdo->prepare('SELECT id, sede_id FROM unidades WHERE codigo = ? LIMIT 1');
            $st->execute([$codigoFinal]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                break;
            }
            if ((int) $row['sede_id'] === $sedeId) {
                return (int) $row['id'];
            }
            $suf = '_' . $i;
            $codigoFinal = substr($codigoBase, 0, max(1, 10 - strlen($suf))) . $suf;
            $i++;
        }

        $ins = $pdo->prepare(
            'INSERT INTO unidades (codigo, nombre, sede_id, id_unidad_padre, estado) VALUES (?, ?, ?, NULL, 1)'
        );
        $ins->execute([$codigoFinal, $nombre, $sedeId]);
        return (int) $pdo->lastInsertId();
    }

    /**
     * Aplica equivalencias COD_UNIDAD_CARRERA/UNIDAD_CARRERA (Excel) -> codigo/nombre tabla unidades.
     *
     * @return array{0:string,1:string}
     */
    private function mapearUnidadEquivalente(string $codigoExcel, string $nombreExcel): array
    {
        [$cod, $nom] = $this->mapearUnidadEquivalenteDetallado($codigoExcel, $nombreExcel);
        return [$cod, $nom];
    }

    /**
     * @return array{0:string,1:string,2:bool}
     */
    private function mapearUnidadEquivalenteDetallado(string $codigoExcel, string $nombreExcel): array
    {
        $codigoNorm = $this->normalizarClaveUnidad($codigoExcel);
        $nombreNorm = $this->normalizarClaveUnidad($nombreExcel);

        foreach ($this->unidadesEquivalencias as $eq) {
            $eqCod = $this->normalizarClaveUnidad((string) ($eq['excel_codigo_unidad'] ?? ''));
            $eqNom = $this->normalizarClaveUnidad((string) ($eq['excel_nombre_unidad'] ?? ''));
            if ($eqCod === '' && $eqNom === '') {
                continue;
            }
            $matchCodigo = ($eqCod !== '' && $eqCod === $codigoNorm);
            $matchNombre = ($eqNom !== '' && $eqNom === $nombreNorm);
            if ($matchCodigo || $matchNombre) {
                return [
                    trim((string) ($eq['unidades_codigo'] ?? $codigoExcel)),
                    trim((string) ($eq['unidades_nombre'] ?? $nombreExcel)),
                    true,
                ];
            }
        }
        return [trim($codigoExcel), trim($nombreExcel), false];
    }

    private function normalizarClaveUnidad(string $valor): string
    {
        $valor = mb_strtoupper(trim($valor), 'UTF-8');
        if ($valor === '') {
            return '';
        }
        $replacements = [
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
            'Ä' => 'A', 'Ë' => 'E', 'Ï' => 'I', 'Ö' => 'O', 'Ü' => 'U',
            'Ñ' => 'N',
        ];
        $valor = strtr($valor, $replacements);
        $valor = preg_replace('/[^A-Z0-9\s._-]/', '', $valor);
        $valor = preg_replace('/\s+/', ' ', $valor);
        return trim((string) $valor);
    }

    private function debeUsarSinUnidadPorCodigoFormacion(string $codigoAsignatura, string $tipoExcel, bool $esPadreConHijos): bool
    {
        $codigo = strtoupper(trim($codigoAsignatura));
        if (!str_starts_with($codigo, 'UN')) {
            return false;
        }
        $tipoMap = $this->mapTipoAsignatura($tipoExcel, $esPadreConHijos);
        return str_starts_with($tipoMap, 'FORMACION_');
    }

    private function parseSemestre(?string $raw): ?int
    {
        $raw = trim((string) $raw);
        if (preg_match('/^S(\d{1,2})$/i', $raw, $m)) {
            return (int) $m[1];
        }
        if (preg_match('/^(\d{1,2})$/', $raw, $m)) {
            return (int) $m[1];
        }
        return null;
    }

    private function mapNivelPrograma(string $nivel): string
    {
        $n = strtoupper(trim($nivel));
        if ($n === 'PR' || $n === 'P') {
            return 'P';
        }
        if ($n === 'PG' || $n === 'G') {
            return 'G';
        }
        return 'O';
    }

    private function mapTipoAsignatura(string $tipoExcel, bool $esPadreConHijos): string
    {
        if ($esPadreConHijos) {
            return 'FORMACION_ELECTIVA';
        }
        $t = mb_strtolower(trim($tipoExcel), 'UTF-8');
        if ($t === 'regular') {
            return 'REGULAR';
        }
        if (str_contains($t, 'profesional')) {
            return 'FORMACION_PROFESIONAL';
        }
        if (str_contains($t, 'general')) {
            return 'FORMACION_GENERAL';
        }
        if (str_contains($t, 'basica') || str_contains($t, 'básica')) {
            return 'FORMACION_BASICA';
        }
        if (str_contains($t, 'idioma')) {
            return 'FORMACION_IDIOMAS';
        }
        if (str_contains($t, 'valor')) {
            return 'FORMACION_VALORES';
        }
        if (str_contains($t, 'especialidad')) {
            return 'FORMACION_ESPECIALIDAD';
        }
        if (str_contains($t, 'electiva')) {
            return 'FORMACION_ELECTIVA';
        }
        return 'REGULAR';
    }

    private function normalizarCabecera($name): string
    {
        $name = trim((string) $name);
        $name = strtoupper(preg_replace('/\s+/', '_', $name));
        return $name;
    }

    private function normalizarNombreCarrera(string $nombre): string
    {
        $nombre = mb_strtoupper($nombre, 'UTF-8');
        $replacements = [
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
            'Ñ' => 'N',
        ];
        $nombre = strtr($nombre, $replacements);
        $nombre = preg_replace('/[^A-Z0-9\s]/', ' ', $nombre);
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        return trim($nombre);
    }

    private function normalizarNombreAsignatura(string $nombre): string
    {
        return $this->normalizarNombreCarrera($nombre);
    }

    private function normalizeNombreBusqueda(string $nombre): string
    {
        $nombre = mb_strtolower(trim($nombre), 'UTF-8');
        $replacements = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n',
        ];
        $nombre = strtr($nombre, $replacements);
        $nombre = preg_replace('/[^a-z0-9\s]/', ' ', $nombre);
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        return trim($nombre);
    }
}
