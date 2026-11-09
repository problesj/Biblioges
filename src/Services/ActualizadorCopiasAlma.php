<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Tarea programada: actualiza las copias impresas de las bibliografías disponibles activas desde Alma.
 *
 * Trabaja en dos fases: primero calcula todos los cambios consultando Alma, sin escribir; luego los aplica.
 * Así, si la API falla o se activa un resguardo, no se modifica ningún dato.
 *  - Con ítems: se reemplazan las copias por sede (no cuentan los extraviados).
 *  - Sin ítems y con acceso electrónico (o disponibilidad "ambos"): pasa a "electronico".
 *  - Sin ítems y sin acceso electrónico: se elimina, guardando una copia de la fila en el reporte.
 *  - MMS inexistente o error de la API: no se toca ("revisar").
 *  - Discrepancia entre la fila y su registro de Alma (título o año): se reporta y el MMS no se modifica.
 *    Sus copias tampoco se tocan y la fila no se elimina: el MMS podría ser de otra edición.
 *  - El único cambio que se hace a un MMS es quitarle los espacios.
 *  - Varias filas de una declarada con el mismo MMS (registros agrupados en la migración): las copias van a la
 *    más antigua y las demás solo se reportan (acción "duplicada", mostrada como "MMS repetido").
 */
class ActualizadorCopiasAlma
{
    public const TIPO = 'actualizar_copias_alma';

    /** Si las eliminaciones superan esta proporción de las filas consideradas, no se aplica nada */
    public const UMBRAL_ELIMINACION = 0.20;

    /** Errores seguidos de la API tras los cuales se detiene el cálculo */
    private const MAX_ERRORES_SEGUIDOS = 20;

    private const CANDADO = 'biblioges_copias_alma';

    private const SIMILITUD_TITULO = 80.0;

    private AlmaCatalogoService $alma;

    /** @var callable */
    private $log;

    private array $autoresPorFila = [];

    private bool $huboEscrituras = false;

    private ?NotificadorTareas $notificador = null;

    /** Permite reemplazar el envío de avisos (pruebas). */
    public function usarNotificador(NotificadorTareas $notificador): self
    {
        $this->notificador = $notificador;

        return $this;
    }

    public function __construct(?AlmaCatalogoService $alma = null, ?callable $log = null)
    {
        $this->alma = $alma ?? new AlmaCatalogoService();
        $this->log = $log ?? static function (string $m): void {
        };
    }

    /** Lanza la ejecución como proceso independiente (dura más de una hora). */
    public static function lanzarEnSegundoPlano(?int $tareaId = null, bool $manual = false): bool
    {
        if (!function_exists('exec')) {
            return false;
        }
        $php = defined('PHP_BINDIR') ? PHP_BINDIR . '/php' : 'php';
        $script = dirname(__DIR__, 2) . '/cron_copias_alma.php';
        $args = ($tareaId !== null ? ' --tarea=' . (int) $tareaId : '') . ($manual ? ' --manual' : '');
        exec('nohup ' . escapeshellarg($php) . ' ' . escapeshellarg($script) . $args . ' > /dev/null 2>&1 &', $salida, $codigo);

        return $codigo === 0;
    }

    public static function hayPendientes(): bool
    {
        return DB::table('tareas_programadas')->where('tipo_reporte', self::TIPO)->where('estado', 'pendiente')
            ->where('fecha_programada', '<=', EjecutorTareas::ahora())->exists();
    }

    public static function hayEnProceso(): bool
    {
        return DB::table('tareas_programadas')->where('tipo_reporte', self::TIPO)->where('estado', 'en_proceso')->exists();
    }

    /** @return array<int, array> resumen por tarea */
    public function ejecutarPendientes(): array
    {
        $resultados = [];
        $ids = DB::table('tareas_programadas')->where('tipo_reporte', self::TIPO)->where('estado', 'pendiente')
            ->where('fecha_programada', '<=', EjecutorTareas::ahora())->orderBy('fecha_programada')->pluck('id');
        foreach ($ids as $id) {
            $r = $this->ejecutarTarea((int) $id, false);
            if ($r !== null) {
                $resultados[] = $r;
            }
        }

        return $resultados;
    }

    /**
     * @param array|null $soloMms limita el proceso a esos MMS (para pruebas)
     * @return array|null null si la tarea no existe, no se pudo reservar u otra ejecución sigue en curso
     */
    public function ejecutarTarea(int $id, bool $manual, ?array $soloMms = null): ?array
    {
        if ((int) DB::selectOne('SELECT GET_LOCK(?, 0) AS ok', [self::CANDADO])->ok !== 1) {
            return null;
        }
        try {
            // Con el candado tomado, una tarea "en proceso" solo puede venir de una ejecución interrumpida
            $this->liberarInterrumpidas();

            $tarea = DB::table('tareas_programadas')->where('id', $id)->where('tipo_reporte', self::TIPO)->first();
            if (!$tarea) {
                return null;
            }
            $estadoPrevio = $tarea->estado;
            $reserva = DB::table('tareas_programadas')->where('id', $id);
            if ($manual) {
                $reserva->where('estado', '!=', 'en_proceso');
            } else {
                $reserva->where('estado', 'pendiente')->where('fecha_programada', '<=', EjecutorTareas::ahora());
            }
            if ($reserva->update(['estado' => 'en_proceso', 'fecha_ejecucion' => EjecutorTareas::ahora(), 'progreso_actual' => 0, 'progreso_total' => null]) !== 1) {
                return null;
            }

            $simulacion = (int) $tarea->simulacion === 1;
            $inicio = EjecutorTareas::ahora();
            $ejecucionId = DB::table('tareas_programadas_ejecuciones')->insertGetId([
                'tarea_id' => $id, 'tipo_reporte' => 'copias_alma', 'manual' => $manual ? 1 : 0, 'simulacion' => $simulacion ? 1 : 0,
                'fecha_inicio' => $inicio, 'estado' => 'error', 'mensaje' => 'Ejecución en curso o interrumpida',
            ]);

            $estado = 'completada';
            $mensaje = null;
            $resumen = [];
            try {
                $plan = $this->calcularPlan($id, $soloMms);
                $resumen = $plan['resumen'];
                $consideradas = max(1, $resumen['consideradas']);
                $proporcion = $resumen['eliminadas'] / $consideradas;
                $resumen['umbral_superado'] = $proporcion > self::UMBRAL_ELIMINACION;

                if ($simulacion) {
                    $this->guardarDetalle($ejecucionId, $plan['cambios']);
                    $mensaje = 'Simulación: no se modificó ningún dato.' . ($resumen['umbral_superado'] ? ' Una ejecución real se detendría: se supera el umbral de eliminaciones.' : '');
                } elseif ($resumen['umbral_superado']) {
                    $this->guardarDetalle($ejecucionId, $plan['cambios']);
                    $estado = 'detenida';
                    $mensaje = sprintf('Detenida: las eliminaciones (%d de %d filas) superan el %d %%. No se modificó ningún dato.', $resumen['eliminadas'], $resumen['consideradas'], self::UMBRAL_ELIMINACION * 100);
                } else {
                    $this->aplicarPlan($ejecucionId, $plan['cambios'], $resumen);
                }
            } catch (\Throwable $e) {
                $estado = 'detenida';
                $mensaje = 'Detenida: ' . $e->getMessage() . ($this->huboEscrituras ? '. Parte de los cambios ya se aplicó; ver el detalle.' : '. No se modificó ningún dato.');
                error_log('ActualizadorCopiasAlma: tarea ' . $id . ': ' . $e->getMessage());
            }

            $resumen['llamadas_api'] = $this->alma->llamadas();
            $fin = EjecutorTareas::ahora();
            DB::table('tareas_programadas_ejecuciones')->where('id', $ejecucionId)->update([
                'fecha_fin' => $fin, 'estado' => $estado, 'registros' => $resumen['consideradas'] ?? null,
                'resumen' => json_encode($resumen, JSON_UNESCAPED_UNICODE), 'mensaje' => $mensaje,
            ]);

            $this->cerrarTarea($tarea, $estadoPrevio, $manual, $estado, $mensaje, $resumen, $fin);

            if (!empty($tarea->correo_notificacion)) {
                $actual = DB::table('tareas_programadas')->where('id', $id)->first(['estado', 'fecha_programada']);
                $this->notificador = $this->notificador ?? new NotificadorTareas();
                $this->notificador->copiasAlma($tarea, [
                    'manual' => $manual, 'simulacion' => $simulacion, 'inicio' => $inicio, 'fin' => $fin,
                    'estado' => $estado, 'mensaje' => $mensaje, 'resumen' => $resumen, 'ejecucion_id' => $ejecucionId,
                    'proxima' => $actual && $actual->estado === 'pendiente' ? $actual->fecha_programada : null,
                ]);
            }

            return ['id' => $id, 'ejecucion_id' => $ejecucionId, 'estado' => $estado, 'mensaje' => $mensaje, 'resumen' => $resumen];
        } finally {
            DB::selectOne('SELECT RELEASE_LOCK(?) AS ok', [self::CANDADO]);
        }
    }

    private function cerrarTarea(object $tarea, string $estadoPrevio, bool $manual, string $estado, ?string $mensaje, array $resumen, string $fin): void
    {
        $exito = $estado === 'completada';
        $cambios = [
            'ultima_ejecucion' => $fin,
            'progreso_actual' => null,
            'progreso_total' => null,
            'resultado' => json_encode($resumen, JSON_UNESCAPED_UNICODE),
            'error_mensaje' => $exito ? null : $mensaje,
        ];
        if ($manual) {
            // Una ejecución manual no altera la programación
            $cambios['estado'] = $estadoPrevio;
        } else {
            $siguiente = EjecutorTareas::siguienteFecha($tarea->fecha_inicio ?: $tarea->fecha_programada, $tarea->fecha_programada, (string) $tarea->frecuencia, $tarea->fecha_fin ?? null, $fin, $tarea->dias_semana ?? null);
            if ($siguiente === null) {
                $cambios['estado'] = $exito ? 'completada' : 'error';
            } else {
                $cambios['estado'] = 'pendiente';
                $cambios['fecha_programada'] = $siguiente;
            }
        }
        DB::table('tareas_programadas')->where('id', $tarea->id)->update($cambios);
    }

    private function liberarInterrumpidas(): void
    {
        foreach (DB::table('tareas_programadas')->where('tipo_reporte', self::TIPO)->where('estado', 'en_proceso')->get() as $t) {
            DB::table('tareas_programadas')->where('id', $t->id)->update(['estado' => 'pendiente', 'progreso_actual' => null, 'progreso_total' => null, 'error_mensaje' => 'La ejecución anterior se interrumpió sin terminar']);
            DB::table('tareas_programadas_ejecuciones')->where('tarea_id', $t->id)->whereNull('fecha_fin')->update(['estado' => 'error', 'fecha_fin' => EjecutorTareas::ahora(), 'mensaje' => 'Ejecución interrumpida']);
            ($this->log)("Tarea {$t->id}: ejecución interrumpida liberada");
        }
    }

    /**
     * Fase 1: calcula los cambios consultando Alma, sin escribir en las bibliografías.
     *
     * @return array{cambios: array<int, array>, resumen: array}
     */
    public function calcularPlan(int $tareaId, ?array $soloMms = null): array
    {
        $filas = DB::table('bibliografias_disponibles')->where('estado', 1)->whereIn('disponibilidad', ['impreso', 'ambos'])
            ->orderBy('fecha_creacion')->orderBy('id')->get()->all();
        if ($soloMms !== null) {
            $filas = array_values(array_filter($filas, static fn ($f) => in_array(AlmaCatalogoService::normalizarMms($f->id_mms), $soloMms, true)));
        }
        $ids = array_map(static fn ($f) => (int) $f->id, $filas);
        $copiasLocales = [];
        foreach (array_chunk($ids, 1000) as $lote) {
            foreach (DB::table('bibliografias_disponibles_sedes')->whereIn('bibliografia_disponible_id', $lote)->where('ejemplares', '>', 0)->get() as $s) {
                $copiasLocales[(int) $s->bibliografia_disponible_id][(int) $s->sede_id] = (int) $s->ejemplares;
            }
            foreach (DB::table('bibliografias_disponibles_autores as da')->join('autores as a', 'a.id', '=', 'da.autor_id')->whereIn('da.bibliografia_disponible_id', $lote)->get(['da.bibliografia_disponible_id', 'a.apellidos', 'a.nombres']) as $au) {
                $this->autoresPorFila[(int) $au->bibliografia_disponible_id][] = $au->apellidos . ' ' . $au->nombres;
            }
        }
        $sedes = [];
        foreach (AlmaCatalogoService::BIBLIOTECAS as $codigo => $nombre) {
            $sedeId = DB::table('sedes')->where('nombre', $nombre)->value('id');
            if ($sedeId === null) {
                throw new \RuntimeException("No existe la sede {$nombre}");
            }
            $sedes[$codigo] = (int) $sedeId;
        }

        $resumen = ['consideradas' => count($filas), 'mms_consultados' => 0, 'sin_cambios' => 0, 'actualizada' => 0, 'mms_corregido' => 0, 'a_electronico' => 0, 'eliminadas' => 0, 'duplicada' => 0, 'revisar' => 0, 'discrepancia' => 0, 'declaradas_sin_disponibles' => 0];
        $cambios = [];
        $agregar = static function (string $accion, object $fila, array $extra = []) use (&$cambios, &$resumen, $copiasLocales): void {
            $cambios[] = array_merge(['accion' => $accion, 'fila' => $fila, 'mms_nuevo' => null, 'antes' => $copiasLocales[(int) $fila->id] ?? [], 'despues' => null, 'mensaje' => null], $extra);
            $resumen[$accion === 'eliminada' ? 'eliminadas' : $accion]++;
        };

        // Cada MMS se consulta tal como está en la fila (solo se le quitan los espacios)
        $grupos = [];
        foreach ($filas as $f) {
            $grupos[AlmaCatalogoService::normalizarMms($f->id_mms)][] = $f;
        }
        $total = count($grupos);
        DB::table('tareas_programadas')->where('id', $tareaId)->update(['progreso_total' => $total, 'progreso_actual' => 0]);
        $avance = 0;
        $erroresSeguidos = 0;
        $controlarError = function (\Throwable $e) use (&$erroresSeguidos): string {
            $erroresSeguidos++;
            if ($erroresSeguidos >= self::MAX_ERRORES_SEGUIDOS || in_array($e->getCode(), [401, 403], true)) {
                throw new \RuntimeException('La API de Alma no responde correctamente (' . $e->getMessage() . ')', 0, $e);
            }

            return $e->getMessage();
        };

        foreach ($grupos as $mms => $filasGrupo) {
            $mms = (string) $mms;
            if (++$avance % 10 === 0) {
                DB::table('tareas_programadas')->where('id', $tareaId)->update(['progreso_actual' => $avance]);
            }
            if (!AlmaCatalogoService::mmsValido($mms)) {
                foreach ($filasGrupo as $f) {
                    $agregar('revisar', $f, ['mensaje' => 'La fila no tiene un MMS válido']);
                }
                continue;
            }
            $resumen['mms_consultados']++;
            try {
                $registro = $this->alma->registro($mms);
                $items = $this->alma->itemsPorBiblioteca($mms);
                $erroresSeguidos = 0;
            } catch (\Throwable $e) {
                $motivo = $controlarError($e);
                foreach ($filasGrupo as $f) {
                    $agregar('revisar', $f, ['mensaje' => 'Error al consultar Alma: ' . $motivo]);
                }
                continue;
            }
            if (!$items['existe']) {
                foreach ($filasGrupo as $f) {
                    $agregar('revisar', $f, ['mensaje' => 'El MMS no existe en Alma']);
                }
                continue;
            }

            $despues = [];
            $otras = [];
            $extraviados = 0;
            foreach ($items['por_biblioteca'] as $codigo => $b) {
                $extraviados += $b['no_contables'];
                if (!isset($sedes[$codigo])) {
                    if ($b['contables'] > 0) {
                        $otras[] = $b['nombre'] . ': ' . $b['contables'];
                    }
                } elseif ($b['contables'] > 0) {
                    $despues[$sedes[$codigo]] = $b['contables'];
                }
            }
            ksort($despues);
            $nota = $extraviados > 0 ? "{$extraviados} ítem(s) extraviado(s) no contados" : null;

            // Las discrepancias se reportan y su MMS no se modifica. En cada declarada, las copias
            // van a la fila más antigua que coincide con el registro; las demás solo se reportan como MMS repetido.
            $principales = [];
            $ediciones = [];
            foreach ($filasGrupo as $f) {
                $discrepancia = $registro !== null ? $this->motivoDiscrepancia($f, $registro) : null;
                if ($discrepancia !== null) {
                    $sugerido = $this->sugerirMms($f, $mms, $ediciones);
                    $mismoMms = [];
                    foreach ($filasGrupo as $otra) {
                        if ($otra->id !== $f->id) {
                            $mismaDeclarada = $otra->bibliografia_declarada_id !== null && $otra->bibliografia_declarada_id === $f->bibliografia_declarada_id;
                            $mismoMms[] = '#' . $otra->id . ($mismaDeclarada ? ' (misma declarada)' : '');
                        }
                    }
                    $agregar('discrepancia', $f, ['mms_nuevo' => $sugerido, 'mensaje' => $discrepancia
                        . ($mismoMms ? '. Mismo MMS que: ' . implode(', ', $mismoMms) : '')
                        . ($sugerido !== null ? '. Registro posible en el catálogo: ' . $sugerido : '')
                        . '. Copias sin cambios.']);
                    continue;
                }
                $clave = (string) ($f->bibliografia_declarada_id ?? 'sin');
                if (isset($principales[$clave])) {
                    $agregar('duplicada', $f, ['mensaje' => 'Comparte el MMS con la disponible #' . $principales[$clave]->id . ' dentro de la misma declarada: registro posiblemente agrupado en la migración. Pendiente de corregir el MMS; no se modifica.']);
                } else {
                    $principales[$clave] = $f;
                }
            }

            foreach ($principales as $f) {
                if ($despues) {
                    $antes = $copiasLocales[(int) $f->id] ?? [];
                    ksort($antes);
                    if ((string) $f->id_mms !== $mms) {
                        $agregar('mms_corregido', $f, ['mms_nuevo' => $mms, 'despues' => $despues, 'mensaje' => $nota ?? 'Se quitan los espacios del MMS']);
                    } elseif ($antes != $despues) {
                        $agregar('actualizada', $f, ['despues' => $despues, 'mensaje' => $nota]);
                    } else {
                        $resumen['sin_cambios']++;
                    }
                    continue;
                }
                if ($otras) {
                    $agregar('revisar', $f, ['mensaje' => 'Solo tiene ítems en otras bibliotecas: ' . implode(', ', $otras)]);
                    continue;
                }
                $motivoSinCopias = $extraviados > 0 ? "todos sus ítems ({$extraviados}) están extraviados" : 'sin ítems en Alma';
                if ($f->disponibilidad === 'ambos') {
                    $agregar('a_electronico', $f, ['despues' => [], 'mensaje' => "Disponibilidad ambos, {$motivoSinCopias}"]);
                    continue;
                }
                try {
                    $acceso = $this->alma->accesoElectronico($mms);
                } catch (\Throwable $e) {
                    $agregar('revisar', $f, ['mensaje' => 'Error al consultar acceso electrónico: ' . $controlarError($e)]);
                    continue;
                }
                if ($acceso['portafolios'] || $acceso['representaciones']) {
                    $agregar('a_electronico', $f, ['despues' => [], 'mensaje' => ucfirst($motivoSinCopias) . ', pero tiene acceso electrónico']);
                } else {
                    $agregar('eliminada', $f, ['despues' => [], 'mensaje' => ucfirst($motivoSinCopias)]);
                }
            }
        }
        foreach ($cambios as &$c) {
            if (!in_array($c['accion'], ['mms_corregido', 'eliminada'], true) && $this->tieneEspacios($c['fila'])) {
                $c['mensaje'] = trim(($c['mensaje'] ?? '') . ' Se quitan los espacios del MMS.');
            }
        }
        unset($c);

        // Impacto: declaradas que quedarían sin disponibles activas
        $eliminadasPorDeclarada = [];
        foreach ($cambios as $c) {
            if ($c['accion'] === 'eliminada' && $c['fila']->bibliografia_declarada_id !== null) {
                $eliminadasPorDeclarada[(int) $c['fila']->bibliografia_declarada_id] = ($eliminadasPorDeclarada[(int) $c['fila']->bibliografia_declarada_id] ?? 0) + 1;
            }
        }
        $sinDisponibles = [];
        foreach ($eliminadasPorDeclarada as $declaradaId => $n) {
            $activas = DB::table('bibliografias_disponibles')->where('bibliografia_declarada_id', $declaradaId)->where('estado', 1)->count();
            if ($activas - $n <= 0) {
                $sinDisponibles[$declaradaId] = true;
            }
        }
        $resumen['declaradas_sin_disponibles'] = count($sinDisponibles);
        foreach ($cambios as &$c) {
            $c['declarada_sin_disponibles'] = $c['accion'] === 'eliminada' && isset($sinDisponibles[(int) $c['fila']->bibliografia_declarada_id]);
        }
        unset($c);
        DB::table('tareas_programadas')->where('id', $tareaId)->update(['progreso_actual' => $total]);

        return ['cambios' => $cambios, 'resumen' => $resumen];
    }

    /** Motivo por el que la fila no coincide con su registro de Alma; null si coincide. */
    private function motivoDiscrepancia(object $fila, array $registro): ?string
    {
        $motivos = [];
        $anioFila = AlmaCatalogoService::extraerAnio($fila->anio_edicion);
        if ($anioFila === 0) {
            $motivos[] = 'la fila no tiene un año válido (' . $fila->anio_edicion . ')';
        } elseif ($registro['anio'] !== 0 && $registro['anio'] !== $anioFila) {
            $motivos[] = "año {$anioFila} en el sistema y {$registro['anio']} en Alma";
        }
        if ($registro['titulo'] !== '' && !$this->coincideTitulo($fila->titulo, $registro['titulo'])) {
            $motivos[] = 'título distinto en Alma: "' . mb_substr(AlmaCatalogoService::tituloBase($registro['titulo']), 0, 120) . '"';
        }

        return $motivos ? 'Discrepancia con el registro de Alma: ' . implode('; ', $motivos) : null;
    }

    /**
     * Registro del catálogo con el mismo título, año y autor, solo como dato para el reporte: nunca se aplica.
     * Una falla de la búsqueda no detiene el proceso; simplemente no hay sugerencia.
     */
    private function sugerirMms(object $fila, string $mmsActual, array &$cache): ?string
    {
        $clave = AlmaCatalogoService::normalizarTexto(AlmaCatalogoService::tituloBase($fila->titulo));
        try {
            $cache[$clave] = $cache[$clave] ?? $this->alma->buscarEdiciones($fila->titulo);
        } catch (\Throwable $e) {
            return null;
        }
        $candidatos = array_values(array_filter($cache[$clave], fn ($e) => $e['mms'] !== $mmsActual && $this->coincideEdicion($fila, $e['titulo'], $e['anio']) && $this->coincideAutor($fila, $e['autores'])));

        return count($candidatos) === 1 ? $candidatos[0]['mms'] : null;
    }

    private function tieneEspacios(object $fila): bool
    {
        $limpio = AlmaCatalogoService::normalizarMms($fila->id_mms);

        return $limpio !== (string) $fila->id_mms && AlmaCatalogoService::mmsValido($limpio);
    }

    private function coincideEdicion(object $fila, string $titulo, int $anio): bool
    {
        $anioFila = AlmaCatalogoService::extraerAnio($fila->anio_edicion);

        return $anioFila !== 0 && $anio === $anioFila && $this->coincideTitulo($fila->titulo, $titulo);
    }

    private function coincideTitulo($tituloFila, string $titulo): bool
    {
        $a = AlmaCatalogoService::normalizarTexto(AlmaCatalogoService::tituloBase($tituloFila));
        $b = AlmaCatalogoService::normalizarTexto(AlmaCatalogoService::tituloBase($titulo));
        if ($a === '' || $b === '') {
            return false;
        }
        if ($a === $b || strpos($a, $b) === 0 || strpos($b, $a) === 0) {
            return true;
        }
        similar_text($a, $b, $porcentaje);

        return $porcentaje >= self::SIMILITUD_TITULO;
    }

    private function coincideAutor(object $fila, string $autoresCatalogo): bool
    {
        $propios = implode(' ', $this->autoresPorFila[(int) $fila->id] ?? []);
        if ($propios === '' && preg_match('/\s\/\s*(.+)$/su', (string) $fila->titulo, $m)) {
            $propios = $m[1]; // mención de responsabilidad del título
        }
        $palabras = static function (string $t): array {
            return array_filter(explode(' ', AlmaCatalogoService::normalizarTexto($t)), static fn ($p) => strlen($p) >= 4 && !preg_match('/^\d+$/', $p));
        };
        $a = $palabras($propios);
        $b = $palabras($autoresCatalogo);

        return $a && $b && array_intersect($a, $b);
    }

    /**
     * Fase 2: aplica los cambios. Cada fila y su línea del reporte se guardan en la misma transacción,
     * de modo que ningún cambio queda sin reportar aunque el proceso se interrumpa.
     */
    private function aplicarPlan(int $ejecucionId, array $cambios, array &$resumen): void
    {
        $aplicables = [];
        $soloReporte = [];
        foreach ($cambios as $c) {
            $escribe = in_array($c['accion'], ['actualizada', 'mms_corregido', 'a_electronico', 'eliminada'], true)
                || $this->tieneEspacios($c['fila']);
            if ($escribe) {
                $aplicables[] = $c;
            } else {
                $soloReporte[] = $c;
            }
        }
        $this->guardarDetalle($ejecucionId, $soloReporte);

        foreach ($aplicables as $c) {
            $f = $c['fila'];
            try {
                $actual = DB::table('bibliografias_disponibles')->where('id', $f->id)->first();
                if (!$actual || (int) $actual->estado !== 1 || (string) $actual->id_mms !== (string) $f->id_mms) {
                    throw new \RuntimeException('La fila cambió durante la ejecución; no se modificó');
                }
                DB::connection()->transaction(function () use (&$c, $actual, $ejecucionId) {
                    $this->aplicarCambio($c, $actual);
                    $this->guardarDetalle($ejecucionId, [$c]);
                });
                $this->huboEscrituras = true;
            } catch (\Throwable $e) {
                $resumen[$c['accion'] === 'eliminada' ? 'eliminadas' : $c['accion']]--;
                $resumen['revisar']++;
                $c['accion'] = 'revisar';
                $c['mensaje'] = 'No se pudo aplicar: ' . $e->getMessage();
                $c['despues'] = null;
                unset($c['copia_fila']);
                error_log('ActualizadorCopiasAlma: disponible ' . $f->id . ': ' . $e->getMessage());
                $this->guardarDetalle($ejecucionId, [$c]);
            }
        }
    }

    private function aplicarCambio(array &$c, object $actual): void
    {
        $id = (int) $actual->id;
        if ($c['accion'] === 'eliminada') {
            $c['copia_fila'] = [
                'fila' => (array) $actual,
                'sedes' => DB::table('bibliografias_disponibles_sedes')->where('bibliografia_disponible_id', $id)->get()->all(),
                'autores' => DB::table('bibliografias_disponibles_autores')->where('bibliografia_disponible_id', $id)->pluck('autor_id')->all(),
            ];
            DB::table('bibliografias_disponibles')->where('id', $id)->delete(); // sedes y autores en cascada

            return;
        }
        // El único cambio posible del MMS es quitarle los espacios
        $datos = [];
        $limpio = AlmaCatalogoService::normalizarMms($actual->id_mms);
        if ($this->tieneEspacios($actual)) {
            $datos['id_mms'] = $limpio;
            foreach (['url_catalogo', 'url_acceso'] as $campo) {
                if (!empty($actual->$campo)) {
                    $datos[$campo] = str_replace((string) $actual->id_mms, $limpio, $actual->$campo);
                }
            }
        }
        if ($c['accion'] === 'a_electronico') {
            $datos['disponibilidad'] = 'electronico';
            if (empty($actual->url_acceso)) {
                $datos['url_acceso'] = 'https://ucn.primo.exlibrisgroup.com/discovery/openurl?institution=' . ($_ENV['PRIMO_INST'] ?? '56UCN_INST')
                    . '&vid=' . ($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN') . '&Force_direct=true&rft.mms_id=' . $limpio;
            }
            if ($actual->ejemplares_digitales === null) {
                $datos['ejemplares_digitales'] = 0;
            }
        }
        if ($datos) {
            DB::table('bibliografias_disponibles')->where('id', $id)->update($datos);
        }
        if ($c['despues'] !== null) {
            DB::table('bibliografias_disponibles_sedes')->where('bibliografia_disponible_id', $id)->delete();
            foreach ($c['despues'] as $sedeId => $n) {
                DB::table('bibliografias_disponibles_sedes')->insert(['bibliografia_disponible_id' => $id, 'sede_id' => (int) $sedeId, 'ejemplares' => (int) $n]);
            }
        }
    }

    private function guardarDetalle(int $ejecucionId, array $cambios): void
    {
        $filas = [];
        foreach ($cambios as $c) {
            $f = $c['fila'];
            $copia = $c['copia_fila'] ?? ($c['accion'] === 'eliminada' ? ['fila' => (array) $f] : null);
            $filas[] = [
                'ejecucion_id' => $ejecucionId,
                'accion' => $c['accion'],
                'bibliografia_disponible_id' => (int) $f->id,
                'bibliografia_declarada_id' => $f->bibliografia_declarada_id,
                'titulo' => mb_substr((string) $f->titulo, 0, 250),
                'anio_edicion' => $f->anio_edicion,
                'id_mms' => $f->id_mms,
                'id_mms_nuevo' => $c['mms_nuevo'],
                'copias_antes' => json_encode((object) $c['antes']),
                'copias_despues' => $c['despues'] === null ? null : json_encode((object) $c['despues']),
                'copia_fila' => $copia === null ? null : json_encode($copia, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE),
                'declarada_sin_disponibles' => !empty($c['declarada_sin_disponibles']) ? 1 : 0,
                'mensaje' => $c['mensaje'],
            ];
        }
        foreach (array_chunk($filas, 300) as $lote) {
            DB::table('tareas_alma_detalle')->insert($lote);
        }
    }
}
