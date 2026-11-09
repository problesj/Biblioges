<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Ejecución de tareas programadas de coberturas (cron y "Ejecutar ahora").
 *
 * - Usa el mismo cálculo que los reportes y el botón "Guardar reporte"
 *   (ReporteController::detalleCoberturaPlan) sobre el plan vigente más reciente de la carrera en la sede.
 * - Cada tarea se reserva con un UPDATE condicional, de modo que nunca se ejecuta dos veces a la vez.
 * - Cada reporte ejecutado queda registrado en tareas_programadas_ejecuciones.
 * - Las tareas recurrentes se reprograman a la siguiente fecha (calculada desde fecha_inicio, sin desfase).
 */
class EjecutorTareas
{
    public const ZONA_HORARIA = 'America/Santiago';

    /** tipo_reporte de la tarea => tipos de cobertura que ejecuta */
    public const TIPOS = [
        'cobertura_basica_expandido' => ['basica'],
        'cobertura_complementaria_expandido' => ['complementaria'],
        'cobertura_ambas_expandido' => ['basica', 'complementaria'],
    ];

    public const FRECUENCIAS = [
        'unica' => 'Única',
        'diaria' => 'Diaria',
        'semanal' => 'Semanal',
        'mensual' => 'Mensual',
        'anual' => 'Anual',
    ];

    /** Días de la semana según ISO-8601 (1 = lunes ... 7 = domingo) */
    public const DIAS_SEMANA = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];

    /** Minutos tras los cuales una tarea "en proceso" se considera interrumpida */
    private const MINUTOS_INTERRUMPIDA = 120;

    private const DESTINOS = [
        'basica' => [
            'reporte' => 'Reporte de Coberturas Básicas',
            'tabla' => 'reporte_coberturas_carreras_basicas',
            'columna' => 'no_bib_disponible_basica',
        ],
        'complementaria' => [
            'reporte' => 'Reporte de Coberturas Complementarias',
            'tabla' => 'reporte_coberturas_carreras_complementarias',
            'columna' => 'no_bib_disponible_complementaria',
        ],
    ];

    /** @var callable */
    private $log;
    private $reporteController = null;

    private ?NotificadorTareas $notificador = null;

    /** Permite reemplazar el envío de avisos (pruebas). */
    public function usarNotificador(NotificadorTareas $notificador): self
    {
        $this->notificador = $notificador;

        return $this;
    }

    public function __construct(?callable $log = null)
    {
        $this->log = $log ?? static function (string $mensaje): void {
        };
    }

    public static function ahora(): string
    {
        return (new \DateTime('now', new \DateTimeZone(self::ZONA_HORARIA)))->format('Y-m-d H:i:s');
    }

    /** Nombre sugerido: "CARRERA - Sede - Básica y Complementaria - Mensual" */
    public static function generarNombre(string $carrera, string $sede, string $tipoReporte, string $frecuencia): string
    {
        $tipos = self::TIPOS[$tipoReporte] ?? [];
        $etiquetaTipos = count($tipos) === 2 ? 'Básica y Complementaria' : (($tipos[0] ?? '') === 'complementaria' ? 'Complementaria' : 'Básica');
        $nombre = trim($carrera) . ' - ' . trim($sede) . ' - ' . $etiquetaTipos . ' - ' . (self::FRECUENCIAS[$frecuencia] ?? 'Única');

        return mb_substr($nombre, 0, 255);
    }

    /**
     * Plan de estudios (carreras_espejos) que usan las tareas para una carrera en una sede:
     * primero los planes activos, luego la vigencia más reciente y, ante empate, el registro más nuevo.
     */
    public static function planVigente(int $carreraId, int $sedeId): ?object
    {
        return DB::table('carreras_espejos')
            ->where('carrera_id', $carreraId)
            ->where('sede_id', $sedeId)
            ->orderByDesc('estado')
            ->orderByDesc('vigencia_desde')
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Carreras activas con malla, con el código del plan que usarán las tareas (misma regla que planVigente).
     *
     * @return array<int, array{id:int, carrera:string, codigo:string, id_sede:int}>
     */
    public static function carrerasActivasPorSede(): array
    {
        $conMalla = [];
        foreach (DB::table('vw_mallas')->select('id_carrera', 'id_sede')->distinct()->get() as $fila) {
            $conMalla[$fila->id_carrera . '-' . $fila->id_sede] = true;
        }

        $planes = DB::table('carreras_espejos as ce')
            ->join('carreras as c', 'c.id', '=', 'ce.carrera_id')
            ->where('c.estado', 1)
            ->select('ce.carrera_id', 'ce.sede_id', 'ce.codigo_carrera', 'c.nombre')
            ->orderBy('ce.carrera_id')
            ->orderBy('ce.sede_id')
            ->orderByDesc('ce.estado')
            ->orderByDesc('ce.vigencia_desde')
            ->orderByDesc('ce.id')
            ->get();

        $resultado = [];
        foreach ($planes as $plan) {
            $clave = $plan->carrera_id . '-' . $plan->sede_id;
            if (isset($resultado[$clave]) || !isset($conMalla[$clave])) {
                continue;
            }
            $resultado[$clave] = [
                'id' => (int) $plan->carrera_id,
                'carrera' => $plan->nombre,
                'codigo' => (string) $plan->codigo_carrera,
                'id_sede' => (int) $plan->sede_id,
            ];
        }
        $resultado = array_values($resultado);
        usort($resultado, static fn ($a, $b) => strcasecmp($a['carrera'], $b['carrera']) ?: strcmp($a['codigo'], $b['codigo']));

        return $resultado;
    }

    /**
     * Ejecuta todas las tareas pendientes cuya fecha ya llegó.
     *
     * @return array<int, array> resumen por tarea
     */
    public function ejecutarPendientes(): array
    {
        $this->liberarInterrumpidas();

        // Las tareas de copias desde Alma corren en su propio proceso (ActualizadorCopiasAlma)
        $ids = DB::table('tareas_programadas')
            ->where('estado', 'pendiente')
            ->where('tipo_reporte', '!=', ActualizadorCopiasAlma::TIPO)
            ->where('fecha_programada', '<=', self::ahora())
            ->orderBy('fecha_programada')
            ->pluck('id');

        $resumen = [];
        foreach ($ids as $id) {
            $resultado = $this->ejecutar((int) $id, false);
            if ($resultado !== null) {
                $resumen[] = $resultado;
            }
        }

        return $resumen;
    }

    /**
     * Ejecuta una tarea.
     *
     * Programada ($manual = false): solo si sigue pendiente y su fecha ya llegó; luego se reprograma o se completa.
     * Manual ("Ejecutar ahora"): en cualquier estado salvo "en proceso". No cambia la próxima fecha de una
     * tarea recurrente; una tarea única queda completada (o con error), salvo que estuviera cancelada.
     *
     * @return array|null null si la tarea no existe o no se pudo reservar (otra ejecución en curso)
     */
    public function ejecutar(int $id, bool $manual): ?array
    {
        $tarea = DB::table('tareas_programadas')->where('id', $id)->first();
        if (!$tarea) {
            return null;
        }
        $estadoPrevio = $tarea->estado;

        $reserva = DB::table('tareas_programadas')->where('id', $id);
        if ($manual) {
            $reserva->where('estado', '!=', 'en_proceso');
        } else {
            $reserva->where('estado', 'pendiente')->where('fecha_programada', '<=', self::ahora());
        }
        if ($reserva->update(['estado' => 'en_proceso', 'fecha_ejecucion' => self::ahora()]) !== 1) {
            return null;
        }

        $comienzo = self::ahora();
        $this->escribir("Tarea {$id} - {$tarea->nombre}" . ($manual ? ' (manual)' : ''));

        $tipos = self::TIPOS[$tarea->tipo_reporte] ?? [];
        $registros = [];
        $errores = [];
        if (!$tipos) {
            $errores[] = 'Tipo de reporte no válido: ' . $tarea->tipo_reporte;
        }

        foreach ($tipos as $tipo) {
            $inicio = self::ahora();
            try {
                $cantidad = $this->guardarCobertura($tarea, $tipo);
                $registros[$tipo] = $cantidad;
                $this->registrarEjecucion($id, $tipo, $manual, $inicio, 'completada', $cantidad, null);
                $this->escribir("  {$tipo}: {$cantidad} registros guardados");
            } catch (\Throwable $e) {
                $errores[] = ucfirst($tipo) . ': ' . $e->getMessage();
                $this->registrarEjecucion($id, $tipo, $manual, $inicio, 'error', null, $e->getMessage());
                $this->escribir("  {$tipo}: ERROR " . $e->getMessage());
                error_log("EjecutorTareas: tarea {$id} ({$tipo}): " . $e->getMessage());
            }
        }

        $exito = empty($errores);
        $fin = self::ahora();
        $cambios = [
            'ultima_ejecucion' => $fin,
            'resultado' => json_encode([
                'fecha_ejecucion' => $fin,
                'manual' => $manual,
                'registros' => $registros,
            ], JSON_UNESCAPED_UNICODE),
            'error_mensaje' => $exito ? null : implode(' | ', $errores),
        ];

        $frecuencia = $tarea->frecuencia ?? 'unica';
        if ($estadoPrevio === 'cancelada' && $manual) {
            $cambios['estado'] = 'cancelada';
        } elseif ($frecuencia === 'unica') {
            $cambios['estado'] = $exito ? 'completada' : 'error';
        } elseif ($manual) {
            // Una ejecución manual no altera la programación de una tarea recurrente
            $cambios['estado'] = in_array($estadoPrevio, ['pendiente', 'completada', 'error'], true) ? $estadoPrevio : 'pendiente';
        } else {
            $siguiente = self::siguienteFecha(
                $tarea->fecha_inicio ?: $tarea->fecha_programada,
                $tarea->fecha_programada,
                $frecuencia,
                $tarea->fecha_fin ?? null,
                $fin, $tarea->dias_semana ?? null
            );
            if ($siguiente === null) {
                $cambios['estado'] = 'completada';
            } else {
                $cambios['estado'] = 'pendiente';
                $cambios['fecha_programada'] = $siguiente;
            }
        }

        DB::table('tareas_programadas')->where('id', $id)->update($cambios);

        $this->escribir('  => ' . $cambios['estado'] . (isset($cambios['fecha_programada']) ? ', próxima: ' . $cambios['fecha_programada'] : ''));

        if (!empty($tarea->correo_notificacion)) {
            $this->notificador = $this->notificador ?? new NotificadorTareas();
            $enviado = $this->notificador->coberturas($tarea, [
                'manual' => $manual,
                'inicio' => $comienzo,
                'fin' => $fin,
                'exito' => $exito,
                'registros' => $registros,
                'errores' => $errores,
                'proxima' => $cambios['estado'] === 'pendiente' ? ($cambios['fecha_programada'] ?? $tarea->fecha_programada) : null,
            ]);
            $this->escribir('  aviso a ' . $tarea->correo_notificacion . ($enviado ? ': enviado' : ': NO se pudo enviar (ver registro de errores)'));
        }

        return [
            'id' => $id,
            'estado' => $cambios['estado'],
            'exito' => $exito,
            'registros' => $registros,
            'errores' => $errores,
            'proxima_ejecucion' => $cambios['fecha_programada'] ?? null,
        ];
    }

    /**
     * Siguiente fecha de una tarea recurrente, posterior a la fecha actual programada y al momento presente.
     * Se calcula desde la fecha de inicio para no acumular desfases (p. ej. día 31 en meses de 30 días).
     * Si el servidor estuvo detenido, salta directamente a la próxima fecha futura (no ejecuta las atrasadas).
     *
     * @return string|null null si la tarea es única o la siguiente fecha supera fecha_fin
     */
    public static function siguienteFecha(string $inicio, string $actual, string $frecuencia, ?string $fechaFin, ?string $ahora = null, ?string $diasSemana = null): ?string
    {
        if (!in_array($frecuencia, ['diaria', 'semanal', 'mensual', 'anual'], true)) {
            return null;
        }
        $zona = new \DateTimeZone(self::ZONA_HORARIA);
        $base = new \DateTime($inicio, $zona);
        $limite = max(new \DateTime($actual, $zona), new \DateTime($ahora ?? self::ahora(), $zona));

        // Semanal con días elegidos: el próximo de esos días, a la hora de la primera ejecución
        $diasElegidos = self::diasSemana($diasSemana);
        if ($frecuencia === 'semanal' && $diasElegidos) {
            $hora = (int) $base->format('H');
            $minuto = (int) $base->format('i');
            $candidata = (clone $limite)->setTime($hora, $minuto);
            for ($i = 0; $i < 8 && !($candidata > $limite && in_array((int) $candidata->format('N'), $diasElegidos, true)); $i++) {
                $candidata->modify('+1 day')->setTime($hora, $minuto);
            }
            if ($fechaFin !== null && $fechaFin !== '' && $candidata > new \DateTime($fechaFin, $zona)) {
                return null;
            }

            return $candidata->format('Y-m-d H:i:s');
        }

        // Estimación del número de periodos ya transcurridos para no iterar desde el inicio
        $dias = (int) floor(($limite->getTimestamp() - $base->getTimestamp()) / 86400);
        switch ($frecuencia) {
            case 'diaria':
                $k = max(1, $dias - 1);
                break;
            case 'semanal':
                $k = max(1, intdiv($dias, 7) - 1);
                break;
            case 'mensual':
                $k = max(1, intdiv($dias, 31) - 1);
                break;
            default:
                $k = max(1, intdiv($dias, 366) - 1);
        }

        for ($i = 0; $i < 10000; $i++, $k++) {
            $candidata = self::sumarPeriodos($base, $frecuencia, $k);
            if ($candidata > $limite) {
                break;
            }
        }

        if ($fechaFin !== null && $fechaFin !== '' && $candidata > new \DateTime($fechaFin, $zona)) {
            return null;
        }

        return $candidata->format('Y-m-d H:i:s');
    }

    /** Días ISO (1 = lunes ... 7 = domingo) de una lista como "1,3,6" o [1, 3, 6]; vacía si no hay ninguno válido. */
    public static function diasSemana($valor): array
    {
        $dias = [];
        foreach (is_array($valor) ? $valor : explode(',', (string) $valor) as $dia) {
            $dia = (int) trim((string) $dia);
            if ($dia >= 1 && $dia <= 7) {
                $dias[$dia] = $dia;
            }
        }
        ksort($dias);

        return array_values($dias);
    }

    private static function sumarPeriodos(\DateTime $base, string $frecuencia, int $k): \DateTime
    {
        $fecha = clone $base;
        $hora = (int) $base->format('H');
        $minuto = (int) $base->format('i');

        if ($frecuencia === 'diaria' || $frecuencia === 'semanal') {
            $fecha->modify('+' . ($frecuencia === 'diaria' ? $k : 7 * $k) . ' days');
            $fecha->setTime($hora, $minuto, 0);

            return $fecha;
        }

        $anio = (int) $base->format('Y');
        $mes = (int) $base->format('n');
        $dia = (int) $base->format('j');
        if ($frecuencia === 'mensual') {
            $total = $mes - 1 + $k;
            $anio += intdiv($total, 12);
            $mes = $total % 12 + 1;
        } else {
            $anio += $k;
        }
        $ultimoDia = (int) (new \DateTime(sprintf('%04d-%02d-01', $anio, $mes), $base->getTimezone()))->format('t');
        $fecha->setDate($anio, $mes, min($dia, $ultimoDia));
        $fecha->setTime($hora, $minuto, 0);

        return $fecha;
    }

    /** Tareas que quedaron "en proceso" por una ejecución interrumpida (caída del proceso o del servidor). */
    private function liberarInterrumpidas(): void
    {
        $limite = (new \DateTime('now', new \DateTimeZone(self::ZONA_HORARIA)))
            ->modify('-' . self::MINUTOS_INTERRUMPIDA . ' minutes')
            ->format('Y-m-d H:i:s');

        $tareas = DB::table('tareas_programadas')
            ->where('estado', 'en_proceso')
            ->where('tipo_reporte', '!=', ActualizadorCopiasAlma::TIPO)
            ->where('fecha_ejecucion', '<', $limite)
            ->get();

        foreach ($tareas as $tarea) {
            $recurrente = ($tarea->frecuencia ?? 'unica') !== 'unica';
            DB::table('tareas_programadas')
                ->where('id', $tarea->id)
                ->where('estado', 'en_proceso')
                ->update([
                    'estado' => $recurrente ? 'pendiente' : 'error',
                    'error_mensaje' => 'La ejecución anterior se interrumpió sin terminar',
                ]);
            $this->escribir("Tarea {$tarea->id}: ejecución interrumpida liberada");
        }
    }

    /**
     * Calcula y guarda la cobertura de la carrera (plan vigente más reciente en la sede).
     * Reemplaza las mediciones del año en curso de ese plan, igual que "Guardar reporte".
     */
    private function guardarCobertura(object $tarea, string $tipo): int
    {
        $destino = self::DESTINOS[$tipo];

        $plan = self::planVigente((int) $tarea->carrera_id, (int) $tarea->sede_id);
        if (!$plan) {
            throw new \RuntimeException('La carrera no tiene un plan de estudios registrado en esta sede');
        }

        $reporte = DB::table('reportes')->where('nombre', $destino['reporte'])->first();
        if (!$reporte) {
            throw new \RuntimeException('No existe "' . $destino['reporte'] . '" en la tabla reportes');
        }

        $detalles = $this->reporteController()->detalleCoberturaPlan($plan, $tipo, null);

        $fechaMedicion = self::ahora();
        $anio = substr($fechaMedicion, 0, 4);
        $filas = [];
        foreach ($detalles as $detalle) {
            $filas[] = [
                'id_reporte' => $reporte->id,
                'codigo_carrera' => $plan->codigo_carrera,
                'id_carrera_espejo' => (int) $plan->id,
                'codigo_asignatura' => $detalle['codigo_asignatura'],
                'id_bibliografia_declarada' => $detalle['id_bibliografia_declarada'],
                'fecha_medicion' => $fechaMedicion,
                'no_ejem_imp' => (int) ($detalle['ejemplares_impresos'] ?? 0),
                'no_ejem_dig' => (int) ($detalle['ejemplares_digitales'] ?? 0),
                $destino['columna'] => (int) ($detalle['disponible'] ?? 0),
            ];
        }

        DB::connection()->transaction(function () use ($destino, $reporte, $plan, $anio, $filas) {
            DB::table($destino['tabla'])
                ->where('id_reporte', $reporte->id)
                ->where('id_carrera_espejo', (int) $plan->id)
                ->whereYear('fecha_medicion', $anio)
                ->delete();
            foreach (array_chunk($filas, 500) as $lote) {
                DB::table($destino['tabla'])->insert($lote);
            }
        });

        return count($filas);
    }

    private function reporteController(): \App\Controllers\ReporteController
    {
        if ($this->reporteController === null) {
            if (!isset($GLOBALS['twig'])) {
                $GLOBALS['twig'] = new \Twig\Environment(
                    new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates')
                );
            }
            $this->reporteController = new \App\Controllers\ReporteController();
        }

        return $this->reporteController;
    }

    private function registrarEjecucion(int $tareaId, string $tipo, bool $manual, string $inicio, string $estado, ?int $registros, ?string $mensaje): void
    {
        try {
            DB::table('tareas_programadas_ejecuciones')->insert([
                'tarea_id' => $tareaId,
                'tipo_reporte' => $tipo,
                'manual' => $manual ? 1 : 0,
                'fecha_inicio' => $inicio,
                'fecha_fin' => self::ahora(),
                'estado' => $estado,
                'registros' => $registros,
                'mensaje' => $mensaje !== null ? mb_substr($mensaje, 0, 2000) : null,
            ]);
        } catch (\Throwable $e) {
            error_log('EjecutorTareas: no se pudo registrar el historial: ' . $e->getMessage());
        }
    }

    private function escribir(string $mensaje): void
    {
        ($this->log)($mensaje);
    }
}
