<?php

namespace App\Services;

/**
 * Consultas de solo lectura a las API de Alma y Primo. No modifica nada en Alma.
 * Las claves se envían por cabecera y nunca en la URL.
 */
class AlmaCatalogoService
{
    private const BASE = 'https://api-na.hosted.exlibrisgroup.com';

    /** Código de biblioteca en Alma => nombre de la sede en el sistema */
    public const BIBLIOTECAS = [
        'BAN' => 'Antofagasta',
        'BCO' => 'Coquimbo',
        'BSP' => 'San Pedro de Atacama',
    ];

    /** Tipos de proceso de ítems que no cuentan como copias (extraviados) */
    public const PROCESOS_NO_CONTABLES = ['MISSING', 'LOST', 'LOST_LOAN', 'LOST_AND_PAID', 'LOST_LOAN_AND_PAID'];

    private const REINTENTOS = 3;

    private string $claveAlma;
    private string $clavePrimo;
    private int $llamadas = 0;

    public function __construct()
    {
        $this->claveAlma = (string) ($_ENV['ALMA_API_KEY'] ?? '');
        $this->clavePrimo = (string) ($_ENV['PRIMO_API_KEY'] ?? '');
    }

    public function llamadas(): int
    {
        return $this->llamadas;
    }

    public static function normalizarMms($valor): string
    {
        return preg_replace('/^alma/i', '', preg_replace('/\s+/', '', (string) $valor));
    }

    public static function mmsValido(string $mms): bool
    {
        return (bool) preg_match('/^\d+$/', $mms);
    }

    /** Primer año plausible de un texto ("1972 [1961]" => 1972); 0 si no hay. */
    public static function extraerAnio($valor): int
    {
        return preg_match('/(?<!\d)(1[4-9]\d{2}|20\d{2})(?!\d)/', (string) $valor, $m) ? (int) $m[1] : 0;
    }

    /** Minúsculas, sin acentos ni puntuación. */
    public static function normalizarTexto($texto): string
    {
        $t = mb_strtolower((string) $texto);
        $t = strtr($t, ['á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a', 'ã' => 'a', 'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e', 'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i', 'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o', 'õ' => 'o', 'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u', 'ñ' => 'n', 'ç' => 'c']);

        return trim(preg_replace('/[^a-z0-9]+/', ' ', $t));
    }

    /** Título sin la mención de responsabilidad ("Título / Autor" => "Título"). */
    public static function tituloBase($titulo): string
    {
        return trim(preg_replace('/\s+\/.*$/su', '', (string) $titulo));
    }

    /**
     * Ítems de un registro, agrupados por biblioteca.
     *
     * @return array{existe: bool, total: int, por_biblioteca: array<string, array{nombre: string, contables: int, no_contables: int}>}
     * @throws \RuntimeException ante errores de la API que no indican que el registro no existe
     */
    public function itemsPorBiblioteca(string $mms): array
    {
        $mms = self::normalizarMms($mms);
        $resultado = ['existe' => true, 'total' => 0, 'por_biblioteca' => []];
        $offset = 0;
        do {
            [$estado, $datos] = $this->alma("/almaws/v1/bibs/{$mms}/holdings/ALL/items?limit=100&offset={$offset}");
            if ($estado === 400 || $estado === 404) {
                $resultado['existe'] = false;

                return $resultado;
            }
            $total = (int) ($datos['total_record_count'] ?? 0);
            foreach ($datos['item'] ?? [] as $item) {
                $d = $item['item_data'] ?? [];
                $codigo = (string) ($d['library']['value'] ?? '?');
                if (!isset($resultado['por_biblioteca'][$codigo])) {
                    $resultado['por_biblioteca'][$codigo] = ['nombre' => (string) ($d['library']['desc'] ?? $codigo), 'contables' => 0, 'no_contables' => 0];
                }
                $noCuenta = in_array((string) ($d['process_type']['value'] ?? ''), self::PROCESOS_NO_CONTABLES, true);
                $resultado['por_biblioteca'][$codigo][$noCuenta ? 'no_contables' : 'contables']++;
                $resultado['total']++;
            }
            $offset += 100;
        } while ($offset < $total);

        return $resultado;
    }

    /**
     * @return array{portafolios: bool, representaciones: bool}
     */
    public function accesoElectronico(string $mms): array
    {
        $mms = self::normalizarMms($mms);
        [$e1, $p] = $this->alma("/almaws/v1/bibs/{$mms}/portfolios?limit=1&offset=0");
        [$e2, $r] = $this->alma("/almaws/v1/bibs/{$mms}/representations?limit=1&offset=0&use_updated_terminology=false");

        return [
            'portafolios' => $e1 === 200 && (int) ($p['total_record_count'] ?? 0) > 0,
            'representaciones' => $e2 === 200 && (int) ($r['total_record_count'] ?? 0) > 0,
        ];
    }

    /**
     * Datos básicos del registro bibliográfico; null si no existe.
     *
     * @return array{titulo: string, anio: int}|null
     */
    public function registro(string $mms): ?array
    {
        $mms = self::normalizarMms($mms);
        [$estado, $datos] = $this->alma("/almaws/v1/bibs/{$mms}?view=brief");
        if ($estado !== 200) {
            return null;
        }

        return ['titulo' => (string) ($datos['title'] ?? ''), 'anio' => self::extraerAnio($datos['date_of_publication'] ?? '')];
    }

    /**
     * Registros locales del catálogo con ese título, incluidas las ediciones de su grupo FRBR
     * (misma búsqueda que "Buscar en catálogo").
     *
     * @return array<string, array{mms: string, anio: int, titulo: string, autores: string}> indexado por MMS
     */
    public function buscarEdiciones(string $titulo): array
    {
        $consulta = self::normalizarTexto(self::tituloBase($titulo));
        if ($consulta === '') {
            return [];
        }
        $encontrados = [];
        $grupos = [];
        foreach ($this->primo('title,exact,' . $consulta) as $doc) {
            if (($doc['context'] ?? '') !== 'L') {
                continue;
            }
            $this->agregarRegistroPrimo($encontrados, $doc);
            $grupo = (string) ($doc['pnx']['facets']['frbrgroupid'][0] ?? '');
            if (($doc['pnx']['facets']['frbrtype'][0] ?? '') === '5' && $grupo !== '') {
                $grupos[$grupo] = (string) ($doc['pnx']['display']['title'][0] ?? $titulo);
            }
        }
        foreach ($grupos as $grupo => $tituloGrupo) {
            $q = 'title,exact,' . self::normalizarTexto(self::tituloBase($tituloGrupo));
            foreach ($this->primo($q, '&qInclude=' . rawurlencode('facet_frbrgroupid,exact,' . $grupo)) as $doc) {
                $this->agregarRegistroPrimo($encontrados, $doc);
            }
        }

        return $encontrados;
    }

    private function agregarRegistroPrimo(array &$lista, array $doc): void
    {
        $pnx = $doc['pnx'] ?? [];
        $mms = self::normalizarMms($pnx['control']['sourcerecordid'][0] ?? ($pnx['control']['recordid'][0] ?? ''));
        if (!self::mmsValido($mms)) {
            return;
        }
        $autores = array_merge($pnx['addata']['au'] ?? [], $pnx['addata']['addau'] ?? [], $pnx['display']['creator'] ?? [], $pnx['display']['contributor'] ?? []);
        $lista[$mms] = [
            'mms' => $mms,
            'anio' => self::extraerAnio($pnx['display']['creationdate'][0] ?? ($pnx['addata']['risdate'][0] ?? '')),
            'titulo' => (string) ($pnx['display']['title'][0] ?? ''),
            'autores' => implode(' ; ', array_map('strval', $autores)),
        ];
    }

    /** @return array<int, array> documentos */
    private function primo(string $q, string $extra = ''): array
    {
        $url = '/primo/v1/search?vid=' . rawurlencode($_ENV['PRIMO_VID'] ?? '56UCN_INST:UCN')
            . '&tab=ALL&inst=' . rawurlencode($_ENV['PRIMO_INST'] ?? '56UCN_INST')
            . '&scope=MyInst_and_CI&q=' . rawurlencode($q) . $extra
            . '&mode=advanced&offset=0&limit=50&sort=rank&pcAvailability=false&skipDelivery=true&disableSplitFacets=false&lang=es';
        [$estado, $datos] = $this->solicitar($url, $this->clavePrimo);
        if ($estado !== 200) {
            throw new \RuntimeException("Primo respondió HTTP {$estado}", $estado);
        }

        return $datos['docs'] ?? [];
    }

    /** @return array{0: int, 1: array} estado 200, 400 o 404; otros estados lanzan excepción */
    private function alma(string $ruta): array
    {
        [$estado, $datos] = $this->solicitar($ruta, $this->claveAlma);
        if (!in_array($estado, [200, 400, 404], true)) {
            throw new \RuntimeException("Alma respondió HTTP {$estado}", $estado);
        }

        return [$estado, $datos];
    }

    private function solicitar(string $ruta, string $clave): array
    {
        for ($intento = 1; ; $intento++) {
            $this->llamadas++;
            $ch = curl_init(self::BASE . $ruta);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 40,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_HTTPHEADER => ['Authorization: apikey ' . $clave, 'Accept: application/json'],
            ]);
            $cuerpo = curl_exec($ch);
            $estado = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errorRed = curl_errno($ch);
            curl_close($ch);

            $reintentar = $errorRed !== 0 || $estado === 429 || $estado >= 500;
            if (!$reintentar) {
                $datos = json_decode((string) $cuerpo, true);

                return [$estado, is_array($datos) ? $datos : []];
            }
            if ($intento >= self::REINTENTOS) {
                throw new \RuntimeException($errorRed !== 0 ? "Error de red ({$errorRed}) al consultar la API" : "La API respondió HTTP {$estado}", $estado);
            }
            sleep(2 ** $intento);
        }
    }
}
