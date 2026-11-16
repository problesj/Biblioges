<?php

namespace App\Services;

/**
 * Búsqueda de bibliografías en fuentes externas para "Buscar en Catálogo": Semantic Scholar, CrossRef,
 * OpenAlex y Google Books (solo lectura).
 *
 * Variables de .env (todas opcionales):
 *  - SEMANTIC_SCHOLAR_API_KEY: sin ella se usa la cuota anónima compartida, que suele estar agotada (HTTP 429).
 *  - OPENALEX_API_KEY: sin ella OpenAlex entrega una cuota diaria muy pequeña.
 *  - GOOGLE_API_KEY: key de un proyecto de Google Cloud con la Books API habilitada.
 *  - CROSSREF_MAILTO: correo de contacto institucional para el "polite pool" de CrossRef (CrossRef no usa key).
 * Las keys se envían en cabeceras, salvo la de OpenAlex, que su API recibe como parámetro. Nunca se registran.
 * Los errores de cada servicio se informan con ServicioExternoException y un mensaje para el usuario.
 */
class BusquedaExternaService
{
    public const FUENTES = [
        'semantic_scholar' => 'Semantic Scholar',
        'crossref' => 'CrossRef',
        'openalex' => 'OpenAlex',
        'google_books' => 'Google Books',
    ];

    private const MAX_RESULTADOS = 10;
    private const SEGUNDOS_CONEXION = 10;
    private const SEGUNDOS_TOTAL = 20;
    /** Pausa base antes de reintentar una consulta rechazada por límite (HTTP 429), en microsegundos; crece con cada intento */
    private const PAUSA_REINTENTO = 1500000;
    private const USER_AGENT = 'Biblioges/1.0 (Sistema de Bibliografias, Universidad Catolica del Norte)';

    /**
     * @return array<int, array> resultados con el formato que usa la vista "Buscar en Catálogo"
     * @throws ServicioExternoException si el servicio no responde, rechaza la consulta o supera su límite
     */
    public function buscar(string $fuente, string $titulo, string $autor, string $adicional): array
    {
        switch ($fuente) {
            case 'semantic_scholar':
                return $this->semanticScholar($titulo, $autor, $adicional);
            case 'crossref':
                return $this->crossref($titulo, $autor, $adicional);
            case 'openalex':
                return $this->openAlex($titulo, $autor, $adicional);
            case 'google_books':
                return $this->googleBooks($titulo, $autor, $adicional);
        }
        throw new \InvalidArgumentException('Fuente de búsqueda no válida: ' . $fuente);
    }

    private function semanticScholar(string $titulo, string $autor, string $adicional): array
    {
        $url = 'https://api.semanticscholar.org/graph/v1/paper/search?' . http_build_query([
            'query' => $this->consulta($titulo, $autor, $adicional, false),
            'limit' => self::MAX_RESULTADOS,
            'fields' => 'title,authors,year,abstract,venue,url,publicationVenue',
        ]);
        $cabeceras = ['Accept: application/json'];
        $clave = self::env('SEMANTIC_SCHOLAR_API_KEY');
        if ($clave !== '') {
            $cabeceras[] = 'x-api-key: ' . $clave;
        }
        // Con key, Semantic Scholar admite pocas consultas por segundo: un 429 se reintenta hasta dos veces (pausas de 1,5 y 3 s)
        $datos = $this->solicitarJson('Semantic Scholar', $url, $cabeceras, $clave === '' ? 'SEMANTIC_SCHOLAR_API_KEY' : null, $clave !== '' ? 2 : 0);

        $resultados = [];
        foreach ($datos['data'] ?? [] as $item) {
            $autores = [];
            foreach ($item['authors'] ?? [] as $a) {
                $nombre = trim((string) ($a['name'] ?? ''));
                if ($nombre !== '') {
                    $autores[] = $nombre;
                }
            }
            $venue = trim((string) ($item['venue'] ?? ''));
            if ($venue === '') {
                $venue = trim((string) ($item['publicationVenue']['name'] ?? ''));
            }
            $id = (string) ($item['paperId'] ?? '');
            $resultados[] = $this->resultado('semantic_scholar_' . md5($id), $id, $item['title'] ?? '', $autores,
                $this->anioValido($item['year'] ?? null), $venue, $item['url'] ?? '', 'Semantic Scholar', 'Artículo', $item['abstract'] ?? '');
        }

        return $resultados;
    }

    private function crossref(string $titulo, string $autor, string $adicional): array
    {
        $parametros = [
            'rows' => self::MAX_RESULTADOS,
            'select' => 'DOI,title,author,issued,publisher,type,URL,container-title',
        ];
        $bibliografica = trim($titulo . ' ' . $adicional);
        if ($bibliografica !== '') {
            $parametros['query.bibliographic'] = $bibliografica;
        }
        if ($autor !== '') {
            $parametros['query.author'] = $autor;
        }
        $mailto = self::env('CROSSREF_MAILTO');
        if ($mailto !== '' && filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
            $parametros['mailto'] = $mailto;
        }
        $datos = $this->solicitarJson('CrossRef', 'https://api.crossref.org/works?' . http_build_query($parametros), ['Accept: application/json'], null);

        $resultados = [];
        foreach ($datos['message']['items'] ?? [] as $item) {
            $autores = [];
            foreach ($item['author'] ?? [] as $a) {
                $familia = trim((string) ($a['family'] ?? ''));
                $nombres = trim((string) ($a['given'] ?? ''));
                if ($familia !== '') {
                    $autores[] = $nombres !== '' ? $familia . ', ' . $nombres : $familia;
                } elseif (trim((string) ($a['name'] ?? '')) !== '') {
                    $autores[] = trim((string) $a['name']);
                }
            }
            $doi = trim((string) ($item['DOI'] ?? ''));
            $enlace = $doi !== '' ? 'https://doi.org/' . $doi : (string) ($item['URL'] ?? '');
            $resultados[] = $this->resultado('crossref_' . md5($doi !== '' ? $doi : $enlace), $doi, $item['title'][0] ?? '', $autores,
                $this->anioValido($item['issued']['date-parts'][0][0] ?? null), $item['publisher'] ?? '', $enlace, 'CrossRef',
                $this->formato((string) ($item['type'] ?? '')), $item['container-title'][0] ?? '');
        }

        return $resultados;
    }

    private function openAlex(string $titulo, string $autor, string $adicional): array
    {
        $parametros = [
            'search' => $this->consulta($titulo, $autor, $adicional, false),
            'per_page' => self::MAX_RESULTADOS,
            'select' => 'id,doi,display_name,publication_year,authorships,primary_location,type,open_access',
        ];
        $clave = self::env('OPENALEX_API_KEY');
        if ($clave !== '') {
            $parametros['api_key'] = $clave;
        }
        $datos = $this->solicitarJson('OpenAlex', 'https://api.openalex.org/works?' . http_build_query($parametros), ['Accept: application/json'],
            $clave === '' ? 'OPENALEX_API_KEY' : null);

        $resultados = [];
        foreach ($datos['results'] ?? [] as $item) {
            $autores = [];
            foreach ($item['authorships'] ?? [] as $a) {
                $nombre = trim((string) ($a['author']['display_name'] ?? ''));
                if ($nombre !== '') {
                    $autores[] = self::apellidoPrimero($nombre);
                }
            }
            $fuente = $item['primary_location']['source'] ?? [];
            $editorial = trim((string) ($fuente['host_organization_name'] ?? ''));
            if ($editorial === '') {
                $editorial = trim((string) ($fuente['display_name'] ?? ''));
            }
            $enlace = (string) ($item['doi'] ?? '');
            foreach ([$item['primary_location']['landing_page_url'] ?? '', $item['open_access']['oa_url'] ?? '', $item['id'] ?? ''] as $alternativa) {
                if ($enlace === '' && (string) $alternativa !== '') {
                    $enlace = (string) $alternativa;
                }
            }
            $id = (string) ($item['id'] ?? '');
            $resultados[] = $this->resultado('openalex_' . md5($id), $id, $item['display_name'] ?? '', $autores,
                $this->anioValido($item['publication_year'] ?? null), $editorial, $enlace, 'OpenAlex',
                $this->formato((string) ($item['type'] ?? '')), (string) ($fuente['display_name'] ?? ''));
        }

        return $resultados;
    }

    private function googleBooks(string $titulo, string $autor, string $adicional): array
    {
        $url = 'https://www.googleapis.com/books/v1/volumes?' . http_build_query([
            'q' => $this->consulta($titulo, $autor, $adicional, true),
            'langRestrict' => 'es',
            'maxResults' => self::MAX_RESULTADOS,
            'printType' => 'books',
        ]);
        $cabeceras = ['Accept: application/json'];
        $clave = self::env('GOOGLE_API_KEY');
        if ($clave !== '') {
            $cabeceras[] = 'X-Goog-Api-Key: ' . $clave;
        }
        $datos = $this->solicitarJson('Google Books', $url, $cabeceras, $clave === '' ? 'GOOGLE_API_KEY' : null);

        $resultados = [];
        foreach ($datos['items'] ?? [] as $item) {
            $info = $item['volumeInfo'] ?? [];
            $anio = preg_match('/\b(\d{4})\b/', (string) ($info['publishedDate'] ?? ''), $m) ? $this->anioValido($m[1]) : '';
            $id = (string) ($item['id'] ?? '');
            $resultados[] = $this->resultado('google_books_' . md5($id), $id, $info['title'] ?? '', $info['authors'] ?? [], $anio,
                $info['publisher'] ?? '', preg_replace('#^http://#i', 'https://', (string) ($info['previewLink'] ?? ($info['infoLink'] ?? ''))),
                'Google Books', 'Libro', $info['description'] ?? '');
        }

        return $resultados;
    }

    /**
     * GET con verificación SSL, tiempos máximos y descompresión; devuelve el JSON decodificado.
     *
     * @param string|null $variableClave variable de .env sugerida cuando el servicio limita por falta de key
     * @param int         $reintentos429 reintentos tras una pausa breve si el servicio responde 429
     */
    private function solicitarJson(string $nombre, string $url, array $cabeceras, ?string $variableClave, int $reintentos429 = 0): array
    {
        for ($intento = 0; ; $intento++) {
            [$cuerpo, $codigoError, $error, $estado] = $this->get($url, $cabeceras);
            if ($estado !== 429 || $intento >= $reintentos429) {
                break;
            }
            usleep(self::PAUSA_REINTENTO * ($intento + 1));
        }

        // La URL nunca se registra: puede contener la key de OpenAlex
        if ($codigoError === CURLE_OPERATION_TIMEDOUT) {
            error_log("Búsqueda externa: {$nombre} no respondió en " . self::SEGUNDOS_TOTAL . ' s');
            throw new ServicioExternoException("{$nombre} no respondió a tiempo. Intente nuevamente en unos minutos.");
        }
        if ($codigoError !== 0) {
            error_log("Búsqueda externa: error de conexión con {$nombre} ({$codigoError}): {$error}");
            throw new ServicioExternoException("No fue posible conectar con {$nombre}. Intente nuevamente más tarde.");
        }
        if ($estado === 429) {
            error_log("Búsqueda externa: {$nombre} respondió 429 (límite de consultas)" . ($variableClave ? ", sin {$variableClave}" : ''));
            throw new ServicioExternoException("{$nombre} alcanzó su límite de consultas. Intente nuevamente en unos minutos."
                . ($variableClave ? " (Falta configurar {$variableClave} en el servidor.)" : ''));
        }
        if ($estado === 401 || $estado === 403) {
            error_log("Búsqueda externa: {$nombre} rechazó la consulta (HTTP {$estado})");
            throw new ServicioExternoException("{$nombre} rechazó la consulta (HTTP {$estado}). Revise la clave de API de este servicio en el servidor.");
        }
        if ($estado < 200 || $estado >= 300) {
            error_log("Búsqueda externa: {$nombre} respondió HTTP {$estado}");
            throw new ServicioExternoException("{$nombre} no está disponible en este momento (HTTP {$estado}).");
        }
        $datos = json_decode((string) $cuerpo, true);
        if (!is_array($datos)) {
            error_log("Búsqueda externa: {$nombre} devolvió una respuesta que no es JSON");
            throw new ServicioExternoException("{$nombre} devolvió una respuesta no válida.");
        }

        return $datos;
    }

    /**
     * GET con verificación SSL (por defecto de cURL), tiempos máximos y descompresión.
     *
     * @return array{0: string|false, 1: int, 2: string, 3: int} cuerpo, código de error cURL, mensaje y estado HTTP
     */
    private function get(string $url, array $cabeceras): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => self::SEGUNDOS_CONEXION,
            CURLOPT_TIMEOUT => self::SEGUNDOS_TOTAL,
            CURLOPT_HTTPHEADER => $cabeceras,
            CURLOPT_USERAGENT => self::USER_AGENT,
            CURLOPT_ENCODING => '',
        ]);
        $cuerpo = curl_exec($ch);
        $resultado = [$cuerpo, curl_errno($ch), curl_error($ch), (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE)];
        curl_close($ch);

        return $resultado;
    }

    private function resultado(string $catalogoId, string $idFuente, $titulo, array $autores, $anio, $editorial, $url, string $adaptor, string $formato, $resumen): array
    {
        $titulo = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $titulo)));
        $resumen = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $resumen)));
        $url = trim((string) $url);

        return [
            'catalogo_id' => $catalogoId,
            'sourcerecordid' => $idFuente,
            'titulo' => $titulo !== '' ? $titulo : 'Sin título',
            'autores' => implode('; ', array_values(array_filter(array_map(static fn ($a) => trim(strip_tags((string) $a)), $autores), 'strlen'))),
            'anio' => $anio,
            'editorial' => trim(strip_tags((string) $editorial)),
            'url' => preg_match('#^https?://#i', $url) ? $url : '',
            'context' => 'PC',
            'adaptor' => $adaptor,
            'formato' => $formato,
            'disponibilidad' => 'electronico',
            'snippet' => mb_strlen($resumen) > 600 ? mb_substr($resumen, 0, 600) . '…' : $resumen,
        ];
    }

    /** Términos de búsqueda; con $comillas el título va entre comillas (frase exacta). */
    private function consulta(string $titulo, string $autor, string $adicional, bool $comillas): string
    {
        $terminos = [];
        if ($titulo !== '') {
            $terminos[] = $comillas ? '"' . str_replace('"', '', $titulo) . '"' : $titulo;
        }
        foreach ([$autor, $adicional] as $termino) {
            if ($termino !== '') {
                $terminos[] = $termino;
            }
        }

        return implode(' ', $terminos);
    }

    /** @return int|string año entre 1450 y el próximo año, o '' */
    private function anioValido($valor)
    {
        $anio = is_numeric($valor) ? (int) $valor : 0;

        return ($anio >= 1450 && $anio <= (int) date('Y') + 1) ? $anio : '';
    }

    private function formato(string $tipo): string
    {
        $tipo = strtolower($tipo);
        if (in_array($tipo, ['book', 'monograph', 'edited-book', 'reference-book', 'book-chapter', 'book-section', 'book-part', 'book-set', 'book-series'], true)) {
            return 'Libro';
        }
        if (in_array($tipo, ['journal-article', 'article', 'proceedings-article', 'review', 'preprint', 'posted-content', 'letter', 'editorial'], true)) {
            return 'Artículo';
        }
        if (in_array($tipo, ['dissertation', 'thesis'], true)) {
            return 'Tesis';
        }

        return $tipo !== '' ? ucfirst(str_replace(['-', '_'], ' ', $tipo)) : 'Otro';
    }

    /** "Nombre Segundo Apellido" => "Apellido, Nombre Segundo" (para separar apellidos y nombres al guardar) */
    private static function apellidoPrimero(string $nombre): string
    {
        if (strpos($nombre, ',') !== false) {
            return $nombre;
        }
        $partes = preg_split('/\s+/u', $nombre);
        if (count($partes) < 2) {
            return $nombre;
        }
        $apellido = array_pop($partes);

        return $apellido . ', ' . implode(' ', $partes);
    }

    private static function env(string $nombre): string
    {
        return trim((string) ($_ENV[$nombre] ?? ''));
    }
}
