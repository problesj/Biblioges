<?php
/**
 * Divide un script SQL en sentencias individuales, igual que el cliente mysql:
 * respeta "DELIMITER" (necesario para triggers y procedimientos) y omite
 * comentarios de línea completa fuera de una sentencia.
 *
 * @return string[] sentencias sin el delimitador final
 */
function dividirSentenciasSql(string $sql): array
{
    $sentencias = [];
    $delimitador = ';';
    $actual = '';
    foreach (preg_split('/\R/', $sql) as $linea) {
        $recortada = trim($linea);
        if ($actual === '' && ($recortada === '' || strpos($recortada, '--') === 0 || strpos($recortada, '#') === 0)) {
            continue;
        }
        if (preg_match('/^DELIMITER\s+(\S+)$/i', $recortada, $m)) {
            $delimitador = $m[1];
            continue;
        }
        $actual .= $linea . "\n";
        $fin = rtrim($linea);
        if ($fin !== '' && substr($fin, -strlen($delimitador)) === $delimitador) {
            $sentencia = trim(substr(rtrim($actual), 0, -strlen($delimitador)));
            if ($sentencia !== '') {
                $sentencias[] = $sentencia;
            }
            $actual = '';
        }
    }
    if (trim($actual) !== '') {
        $sentencias[] = trim($actual);
    }

    return $sentencias;
}
