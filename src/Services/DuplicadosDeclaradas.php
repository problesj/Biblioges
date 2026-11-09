<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * Detecta bibliografías declaradas duplicadas y resuelve cada grupo (fusionar o eliminar).
 *
 * Dos declaradas se agrupan si coinciden en título y año, y comparten al menos un apellido de autor.
 * Al fusionar, las asignaturas y disponibles pasan a la declarada que se mantiene:
 *  - Misma asignatura en ambas: queda un vínculo; es básica si alguna lo era y activa si alguna lo estaba.
 *  - Disponible con el mismo MMS y año que una de la que se mantiene: se elimina. Con otro año se traspasa,
 *    porque puede ser otra edición agrupada con ese MMS en la migración.
 * Cada resolución es una sola transacción y lo eliminado queda copiado en el historial.
 */
class DuplicadosDeclaradas
{
    public const ACCIONES = ['mantener', 'fusionar', 'eliminar', 'no_tocar'];

    private const DETALLE = ['libros', 'articulos', 'tesis', 'software', 'sitios_web', 'genericos'];

    /** @return array<int, array<int, array>> grupos de filas, ordenados por título */
    public function grupos(): array
    {
        $apellidos = [];
        $nombres = [];
        $filasAutores = DB::table('bibliografias_autores as x')->join('autores as a', 'a.id', '=', 'x.autor_id')
            ->orderBy('a.apellidos')->get(['x.bibliografia_id', 'a.apellidos', 'a.nombres']);
        foreach ($filasAutores as $a) {
            $id = (int) $a->bibliografia_id;
            foreach (explode(' ', AlmaCatalogoService::normalizarTexto($a->apellidos)) as $palabra) {
                if (strlen($palabra) >= 3) {
                    $apellidos[$id][$palabra] = true;
                }
            }
            $nombres[$id][] = trim($a->apellidos . (trim((string) $a->nombres) !== '' ? ', ' . $a->nombres : ''));
        }

        $candidatos = [];
        foreach (DB::table('bibliografias_declaradas')->get(['id', 'titulo', 'anio_publicacion', 'tipo']) as $d) {
            $titulo = AlmaCatalogoService::normalizarTexto(AlmaCatalogoService::tituloBase($d->titulo));
            if ($titulo !== '') {
                $candidatos[$titulo . '#' . (int) $d->anio_publicacion][] = $d;
            }
        }

        $grupos = [];
        foreach ($candidatos as $clave => $lista) {
            if (count($lista) < 2) {
                continue;
            }
            foreach ($this->unirPorApellido($lista, $apellidos) as $grupo) {
                $grupos[$clave . '#' . $grupo[0]->id] = $grupo;
            }
        }
        ksort($grupos);

        $ids = [];
        foreach ($grupos as $grupo) {
            foreach ($grupo as $d) {
                $ids[] = (int) $d->id;
            }
        }
        $asignaturas = [];
        $disponibles = [];
        foreach (array_chunk($ids, 500) as $lote) {
            $vinculos = DB::table('asignaturas_bibliografias as ab')->join('asignaturas as a', 'a.id', '=', 'ab.asignatura_id')
                ->whereIn('ab.bibliografia_id', $lote)->orderBy('a.nombre')->get(['ab.bibliografia_id', 'a.nombre', 'ab.tipo_bibliografia']);
            foreach ($vinculos as $v) {
                $asignaturas[(int) $v->bibliografia_id][] = ['nombre' => $v->nombre, 'tipo' => $v->tipo_bibliografia];
            }
            $conteos = DB::table('bibliografias_disponibles')->whereIn('bibliografia_declarada_id', $lote)
                ->selectRaw('bibliografia_declarada_id AS id, COUNT(*) AS n')->groupBy('bibliografia_declarada_id')->get();
            foreach ($conteos as $c) {
                $disponibles[(int) $c->id] = (int) $c->n;
            }
        }

        $resultado = [];
        foreach ($grupos as $grupo) {
            $filas = [];
            foreach ($grupo as $d) {
                $id = (int) $d->id;
                $filas[] = [
                    'id' => $id,
                    'titulo' => $d->titulo,
                    'anio' => (int) $d->anio_publicacion,
                    'tipo' => $d->tipo,
                    'autores' => $nombres[$id] ?? [],
                    'asignaturas' => $asignaturas[$id] ?? [],
                    'n_disponibles' => $disponibles[$id] ?? 0,
                ];
            }
            $resultado[] = $filas;
        }

        return $resultado;
    }

    /** Une las declaradas de una lista que comparten algún apellido, directa o indirectamente. */
    private function unirPorApellido(array $lista, array $apellidos): array
    {
        usort($lista, static fn ($a, $b) => $a->id <=> $b->id);
        $padre = [];
        foreach ($lista as $d) {
            $padre[$d->id] = $d->id;
        }
        $raiz = static function ($x) use (&$padre, &$raiz) {
            return $padre[$x] === $x ? $x : ($padre[$x] = $raiz($padre[$x]));
        };
        foreach ($lista as $i => $a) {
            foreach ($lista as $j => $b) {
                if ($j > $i && array_intersect_key($apellidos[$a->id] ?? [], $apellidos[$b->id] ?? [])) {
                    $padre[$raiz($a->id)] = $raiz($b->id);
                }
            }
        }
        $componentes = [];
        foreach ($lista as $d) {
            $componentes[$raiz($d->id)][] = $d;
        }

        return array_values(array_filter($componentes, static fn ($c) => count($c) > 1));
    }

    /**
     * Describe lo que haría la resolución, sin modificar nada.
     *
     * @return string[] líneas para mostrar
     */
    public function previsualizar(array $acciones): array
    {
        return $this->describir($this->calcular($this->validar($acciones)));
    }

    /** @return string[] líneas con lo realizado */
    public function resolver(array $acciones, ?int $usuarioId): array
    {
        return DB::connection()->transaction(function () use ($acciones, $usuarioId) {
            $ops = $this->validar($acciones);
            $todas = array_merge($ops['fusionar'], $ops['eliminar'], $ops['mantener'] !== null ? [$ops['mantener']] : []);
            DB::table('bibliografias_declaradas')->whereIn('id', $todas)->lockForUpdate()->get(['id']);
            $plan = $this->calcular($ops);

            foreach ($plan['fusiones'] as $f) {
                $copia = $this->copiar($f['id']);
                foreach ($f['traspasadas'] as $v) {
                    DB::table('asignaturas_bibliografias')->where('id', $v['id'])->update(['bibliografia_id' => $ops['mantener']]);
                }
                foreach ($f['ajustadas'] as $v) {
                    DB::table('asignaturas_bibliografias')->where('id', $v['id'])->update(['tipo_bibliografia' => $v['tipo'], 'estado' => $v['estado']]);
                }
                if ($f['disponibles_traspasadas']) {
                    DB::table('bibliografias_disponibles')->whereIn('id', $f['disponibles_traspasadas'])->update(['bibliografia_declarada_id' => $ops['mantener']]);
                }
                if ($f['disponibles_eliminadas']) {
                    DB::table('bibliografias_disponibles')->whereIn('id', $f['disponibles_eliminadas'])->delete();
                }
                $this->registrar('fusion', $f['id'], $ops['mantener'], $usuarioId, $copia, $f);
                DB::table('bibliografias_declaradas')->where('id', $f['id'])->delete();
            }
            foreach ($ops['eliminar'] as $id) {
                $this->registrar('eliminacion', $id, null, $usuarioId, $this->copiar($id), null);
                DB::table('bibliografias_declaradas')->where('id', $id)->delete();
            }

            return $this->describir($plan);
        });
    }

    /**
     * Comprueba las acciones contra los grupos actuales de la base.
     *
     * @return array{mantener: ?int, fusionar: int[], eliminar: int[]}
     * @throws \InvalidArgumentException con un mensaje para el usuario
     */
    private function validar(array $acciones): array
    {
        $ops = ['mantener' => null, 'fusionar' => [], 'eliminar' => []];
        $ids = [];
        foreach ($acciones as $id => $accion) {
            if (!in_array($accion, self::ACCIONES, true) || (int) $id <= 0) {
                throw new \InvalidArgumentException('Acción no válida');
            }
            $id = (int) $id;
            $ids[] = $id;
            if ($accion === 'mantener') {
                if ($ops['mantener'] !== null) {
                    throw new \InvalidArgumentException('Solo se puede mantener una bibliografía por grupo');
                }
                $ops['mantener'] = $id;
            } elseif ($accion !== 'no_tocar') {
                $ops[$accion][] = $id;
            }
        }
        if ($ops['fusionar'] && $ops['mantener'] === null) {
            throw new \InvalidArgumentException('Para fusionar debe elegir la bibliografía que se mantiene');
        }
        if (!$ops['fusionar'] && !$ops['eliminar']) {
            throw new \InvalidArgumentException($ops['mantener'] !== null ? 'Indique al menos una bibliografía para fusionar o eliminar' : 'No hay cambios para aplicar');
        }

        $grupo = null;
        foreach ($this->grupos() as $filas) {
            if (in_array($ids[0], array_column($filas, 'id'), true)) {
                $grupo = $filas;
                break;
            }
        }
        if ($grupo === null || array_diff($ids, array_column($grupo, 'id'))) {
            throw new \InvalidArgumentException('El grupo cambió desde que se cargó la página. Recárguela e intente de nuevo.');
        }
        foreach ($grupo as $fila) {
            if (in_array($fila['id'], $ops['eliminar'], true) && ($fila['asignaturas'] || $fila['n_disponibles'] > 0)) {
                throw new \InvalidArgumentException("La bibliografía #{$fila['id']} tiene asignaturas o disponibles vinculadas; no se puede eliminar");
            }
        }

        return $ops;
    }

    private function calcular(array $ops): array
    {
        $plan = ['mantener' => $ops['mantener'], 'fusiones' => [], 'eliminar' => $ops['eliminar']];
        if ($ops['mantener'] === null) {
            return $plan;
        }
        $destino = [];
        foreach (DB::table('asignaturas_bibliografias')->where('bibliografia_id', $ops['mantener'])->get() as $v) {
            $destino[(int) $v->asignatura_id] = ['id' => (int) $v->id, 'tipo' => $v->tipo_bibliografia, 'estado' => $v->estado];
        }
        $claves = [];
        foreach (DB::table('bibliografias_disponibles')->where('bibliografia_declarada_id', $ops['mantener'])->get() as $d) {
            if (($clave = $this->claveEdicion($d)) !== null) {
                $claves[$clave] = (int) $d->id;
            }
        }

        foreach ($ops['fusionar'] as $id) {
            $f = ['id' => $id, 'traspasadas' => [], 'ajustadas' => [], 'descartadas' => [], 'disponibles_traspasadas' => [], 'disponibles_eliminadas' => []];
            foreach (DB::table('asignaturas_bibliografias')->where('bibliografia_id', $id)->orderBy('id')->get() as $v) {
                $asignatura = (int) $v->asignatura_id;
                if (!isset($destino[$asignatura])) {
                    $f['traspasadas'][] = ['id' => (int) $v->id, 'asignatura_id' => $asignatura];
                    $destino[$asignatura] = ['id' => (int) $v->id, 'tipo' => $v->tipo_bibliografia, 'estado' => $v->estado];
                    continue;
                }
                $f['descartadas'][] = $asignatura;
                $tipo = $v->tipo_bibliografia === 'basica' ? 'basica' : $destino[$asignatura]['tipo'];
                $estado = $v->estado === 'activa' ? 'activa' : $destino[$asignatura]['estado'];
                if ($tipo !== $destino[$asignatura]['tipo'] || $estado !== $destino[$asignatura]['estado']) {
                    $destino[$asignatura]['tipo'] = $tipo;
                    $destino[$asignatura]['estado'] = $estado;
                    $f['ajustadas'][] = ['id' => $destino[$asignatura]['id'], 'asignatura_id' => $asignatura, 'tipo' => $tipo, 'estado' => $estado];
                }
            }
            // Las filas de una misma declarada no se comparan entre sí: su MMS repetido solo se reporta en la tarea de Alma
            $nuevas = [];
            foreach (DB::table('bibliografias_disponibles')->where('bibliografia_declarada_id', $id)->orderBy('id')->get() as $d) {
                $clave = $this->claveEdicion($d);
                if ($clave !== null && isset($claves[$clave])) {
                    $f['disponibles_eliminadas'][] = (int) $d->id;
                } else {
                    $f['disponibles_traspasadas'][] = (int) $d->id;
                    if ($clave !== null) {
                        $nuevas[$clave] = (int) $d->id;
                    }
                }
            }
            $claves += $nuevas;
            $plan['fusiones'][] = $f;
        }

        return $plan;
    }

    /** MMS y año de una disponible; null si no tiene MMS, en cuyo caso nunca se considera repetida. */
    private function claveEdicion(object $disponible): ?string
    {
        $mms = AlmaCatalogoService::normalizarMms($disponible->id_mms);

        return $mms === '' ? null : $mms . '|' . (int) $disponible->anio_edicion;
    }

    /** @return string[] */
    private function describir(array $plan): array
    {
        $lineas = [];
        foreach ($plan['fusiones'] as $f) {
            $partes = [count($f['traspasadas']) . ' asignatura(s) traspasada(s)'];
            if ($f['descartadas']) {
                $partes[] = count($f['descartadas']) . ' ya vinculada(s)';
            }
            if ($f['ajustadas']) {
                $partes[] = count($f['ajustadas']) . ' vínculo(s) ajustado(s)';
            }
            $partes[] = count($f['disponibles_traspasadas']) . ' disponible(s) traspasada(s)';
            if ($f['disponibles_eliminadas']) {
                $partes[] = count($f['disponibles_eliminadas']) . ' disponible(s) eliminada(s) por repetir MMS y año (#' . implode(', #', $f['disponibles_eliminadas']) . ')';
            }
            $lineas[] = "Fusionar #{$f['id']} en #{$plan['mantener']} y eliminarla: " . implode('; ', $partes) . '.';
        }
        foreach ($plan['eliminar'] as $id) {
            $lineas[] = "Eliminar #{$id}, que no tiene asignaturas ni disponibles.";
        }

        return $lineas;
    }

    /** Copia completa de una declarada y sus vínculos, antes de cualquier cambio. */
    private function copiar(int $id): array
    {
        $copia = [
            'declarada' => (array) DB::table('bibliografias_declaradas')->where('id', $id)->first(),
            'detalle' => [],
            'autores' => DB::table('bibliografias_autores')->where('bibliografia_id', $id)->get()->all(),
            'asignaturas' => DB::table('asignaturas_bibliografias')->where('bibliografia_id', $id)->get()->all(),
            'disponibles' => [],
        ];
        foreach (self::DETALLE as $tabla) {
            $filas = DB::table($tabla)->where('bibliografia_id', $id)->get()->all();
            if ($filas) {
                $copia['detalle'][$tabla] = $filas;
            }
        }
        foreach (DB::table('bibliografias_disponibles')->where('bibliografia_declarada_id', $id)->get() as $d) {
            $copia['disponibles'][] = [
                'fila' => (array) $d,
                'sedes' => DB::table('bibliografias_disponibles_sedes')->where('bibliografia_disponible_id', $d->id)->get()->all(),
                'autores' => DB::table('bibliografias_disponibles_autores')->where('bibliografia_disponible_id', $d->id)->pluck('autor_id')->all(),
            ];
        }

        return $copia;
    }

    private function registrar(string $accion, int $id, ?int $destino, ?int $usuarioId, array $copia, ?array $resumen): void
    {
        $flags = JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE;
        DB::table('bibliografias_declaradas_historial')->insert([
            'accion' => $accion,
            'bibliografia_id' => $id,
            'bibliografia_destino_id' => $destino,
            'usuario_id' => $usuarioId,
            'copia' => json_encode($copia, $flags),
            'resumen' => $resumen === null ? null : json_encode($resumen, $flags),
        ]);
    }
}
