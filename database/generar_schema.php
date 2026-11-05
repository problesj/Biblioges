<?php
/**
 * Regenera database/schema.sql a partir de la estructura de la base de datos configurada en .env
 * (tablas, vistas, triggers y datos requeridos). Ejecutar después de aplicar cambios de esquema:
 *   php database/generar_schema.php            # escribe database/schema.sql
 *   php database/generar_schema.php otra.sql   # escribe en otro archivo
 * Solo lee la base de datos; no la modifica.
 */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}
$raiz = dirname(__DIR__);
require $raiz . '/vendor/autoload.php';
Dotenv\Dotenv::createImmutable($raiz)->load();
$salida = $argv[1] ?? __DIR__ . '/schema.sql';
$db = $_ENV['DB_DATABASE'];
$pdo = new PDO("mysql:host={$_ENV['DB_HOST']};port=" . ($_ENV['DB_PORT'] ?? '3306') . ";dbname=$db;charset=utf8mb4",
    $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
function q(PDO $pdo, string $sql, array $p = []): array { $s = $pdo->prepare($sql); $s->execute($p); return $s->fetchAll(PDO::FETCH_NUM); }
function limpiarDb(string $s, string $db): string { return str_replace('`' . $db . '`.', '', $s); }

$descripciones = [
    'sedes' => 'Sedes de la universidad', 'unidades' => 'Unidades académicas (departamentos) por sede',
    'carreras' => 'Carreras', 'carreras_espejos' => 'Planes de estudio de cada carrera por sede (código y vigencia)',
    'asignaturas' => 'Asignaturas', 'asignaturas_formacion' => 'Relación asignatura de formación electiva -> asignaturas que la componen',
    'mallas' => 'Mallas curriculares (asignaturas por carrera y semestre)', 'asignaturas_departamentos' => 'Códigos de asignatura por unidad',
    'usuarios' => 'Usuarios del sistema', 'autores' => 'Autores', 'alias_autores' => 'Variaciones de nombre de autores',
    'bibliografias_declaradas' => 'Bibliografías declaradas en los programas', 'libros' => 'Detalle de bibliografías tipo libro',
    'articulos' => 'Detalle de bibliografías tipo artículo', 'tesis' => 'Detalle de bibliografías tipo tesis',
    'software' => 'Detalle de bibliografías tipo software', 'sitios_web' => 'Detalle de bibliografías tipo sitio web',
    'genericos' => 'Detalle de bibliografías genéricas', 'bibliografias_autores' => 'Autores de cada bibliografía declarada',
    'asignaturas_bibliografias' => 'Bibliografías (básica/complementaria) de cada asignatura',
    'bibliografias_disponibles' => 'Bibliografías disponibles en biblioteca (impresas/electrónicas)',
    'bibliografias_disponibles_sedes' => 'Ejemplares impresos disponibles por sede', 'bibliografias_disponibles_autores' => 'Autores de cada bibliografía disponible',
    'reportes' => 'Catálogo de reportes (requerido por el guardado de coberturas)',
    'reporte_coberturas_carreras_basicas' => 'Mediciones guardadas de cobertura básica por plan',
    'reporte_coberturas_carreras_complementarias' => 'Mediciones guardadas de cobertura complementaria por plan',
    'coberturas_asignaturas' => 'Coberturas por asignatura', 'filtros_formaciones' => 'Filtros de tipos de formación guardados por plan',
    'tareas_programadas' => 'Tareas programadas de reportes (únicas o recurrentes)',
    'tareas_programadas_ejecuciones' => 'Historial de ejecuciones de las tareas programadas',
];

$version = q($pdo, 'SELECT VERSION()')[0][0];
$o = [];
$o[] = "-- =====================================================";
$o[] = "-- ESQUEMA DE BASE DE DATOS BIBLIOGES";
$o[] = "-- =====================================================";
$o[] = "-- Generado a partir de la estructura en uso (" . date('Y-m-d') . ", MySQL $version).";
$o[] = "-- Instalación nueva (base de datos vacía):";
$o[] = "--   mysql -u <usuario> -p <base_de_datos> < database/schema.sql";
$o[] = "-- Datos de ejemplo, solo para desarrollo/pruebas (NO en producción):";
$o[] = "--   mysql -u <usuario> -p <base_de_datos> < database/datos_ejemplo.sql";
$o[] = "-- Para actualizar una base existente use los scripts de migración database/AAAA-MM-*.sql.";
$o[] = "-- Secciones: 1) Tablas  2) Vistas  3) Triggers  4) Datos requeridos";
$o[] = "-- =====================================================";
$o[] = "";
$o[] = "SET NAMES utf8mb4;";
$o[] = "SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;";
$o[] = "SET FOREIGN_KEY_CHECKS = 0;";
$o[] = "";

// ---- Tablas en orden de dependencias ----
$tablas = array_column(q($pdo, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME"), 0);
$deps = array_fill_keys($tablas, []);
foreach (q($pdo, "SELECT TABLE_NAME, REFERENCED_TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL") as [$t, $r]) {
    if ($t !== $r && isset($deps[$t])) { $deps[$t][$r] = true; }
}
$orden = []; $visit = [];
$visitar = function ($t) use (&$visitar, &$orden, &$visit, $deps) {
    if (isset($visit[$t])) { return; } $visit[$t] = true;
    foreach (array_keys($deps[$t] ?? []) as $r) { if (isset($deps[$r])) { $visitar($r); } }
    $orden[] = $t;
};
// Orden lógico: catálogos primero
foreach (array_merge(array_keys($descripciones), $tablas) as $t) { if (isset($deps[$t])) { $visitar($t); } }

$o[] = "-- =====================================================";
$o[] = "-- SECCIÓN 1: TABLAS";
$o[] = "-- =====================================================";
foreach ($orden as $t) {
    $create = q($pdo, "SHOW CREATE TABLE `$t`")[0][1];
    $create = preg_replace(['/ AUTO_INCREMENT=\d+/', '/ AVG_ROW_LENGTH=\d+/'], '', $create);
    $create = preg_replace('/^CREATE TABLE /', 'CREATE TABLE IF NOT EXISTS ', $create);
    $o[] = "";
    $o[] = "-- " . ($descripciones[$t] ?? "Tabla $t");
    $o[] = limpiarDb($create, $db) . ";";
}
$o[] = "";

// ---- Vistas en orden de dependencias ----
$vistas = array_column(q($pdo, "SELECT TABLE_NAME FROM information_schema.VIEWS WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME"), 0);
$defs = [];
foreach ($vistas as $v) {
    $c = q($pdo, "SHOW CREATE VIEW `$v`")[0][1];
    $c = preg_replace('/^CREATE\s+(ALGORITHM=\w+\s+)?(DEFINER=`[^`]*`@`[^`]*`\s+)?(SQL SECURITY \w+\s+)?VIEW\s+/', 'CREATE OR REPLACE VIEW ', $c);
    $defs[$v] = limpiarDb($c, $db);
}
$ordenV = []; $visV = [];
$visitarV = function ($v) use (&$visitarV, &$ordenV, &$visV, $defs) {
    if (isset($visV[$v])) { return; } $visV[$v] = true;
    foreach (array_keys($defs) as $w) { if ($w !== $v && strpos(substr($defs[$v], strpos($defs[$v], ' AS ')), '`' . $w . '`') !== false) { $visitarV($w); } }
    $ordenV[] = $v;
};
foreach ($vistas as $v) { $visitarV($v); }
$o[] = "-- =====================================================";
$o[] = "-- SECCIÓN 2: VISTAS";
$o[] = "-- =====================================================";
foreach ($ordenV as $v) { $o[] = ""; $o[] = "-- Vista $v"; $o[] = $defs[$v] . ";"; }
$o[] = "";

// ---- Triggers ----
$o[] = "-- =====================================================";
$o[] = "-- SECCIÓN 3: TRIGGERS";
$o[] = "-- =====================================================";
foreach (array_column(q($pdo, "SELECT TRIGGER_NAME FROM information_schema.TRIGGERS WHERE TRIGGER_SCHEMA = DATABASE() ORDER BY EVENT_OBJECT_TABLE, TRIGGER_NAME"), 0) as $tg) {
    $fila = $pdo->query("SHOW CREATE TRIGGER `$tg`")->fetch(PDO::FETCH_ASSOC);
    $sql = preg_replace('/^CREATE\s+DEFINER=`[^`]*`@`[^`]*`\s+/', 'CREATE ', $fila['SQL Original Statement']);
    $o[] = "";
    $o[] = "DROP TRIGGER IF EXISTS `$tg`;";
    $o[] = "DELIMITER $$";
    $o[] = limpiarDb($sql, $db) . "$$";
    $o[] = "DELIMITER ;";
}
$o[] = "";

// ---- Datos requeridos ----
$o[] = "-- =====================================================";
$o[] = "-- SECCIÓN 4: DATOS REQUERIDOS POR LA APLICACIÓN";
$o[] = "-- =====================================================";
$o[] = "SET @OLD_SQL_MODE = @@SQL_MODE;";
$o[] = "SET SESSION SQL_MODE = CONCAT(@@SQL_MODE, ',NO_AUTO_VALUE_ON_ZERO');";
$datos = [
    ['sedes', 'id = 0', 'Sede especial para registros sin sede'],
    ['unidades', 'id = 0', 'Unidad especial para registros sin unidad'],
    ['reportes', '1 = 1', 'Reportes de cobertura (el guardado de coberturas los busca por nombre)'],
];
foreach ($datos as [$t, $w, $desc]) {
    $st = $pdo->query("SELECT * FROM `$t` WHERE $w ORDER BY id");
    $filas = $st->fetchAll(PDO::FETCH_ASSOC);
    if (!$filas) { continue; }
    $cols = array_values(array_filter(array_keys($filas[0]), fn ($c) => !in_array($c, ['fecha_creacion', 'fecha_actualizacion'], true)));
    $o[] = "";
    $o[] = "-- $desc";
    $vals = [];
    foreach ($filas as $f) {
        $vals[] = '(' . implode(', ', array_map(fn ($c) => $f[$c] === null ? 'NULL' : $pdo->quote((string) $f[$c]), $cols)) . ')';
    }
    $o[] = "INSERT INTO `$t` (`" . implode('`, `', $cols) . "`) VALUES";
    $o[] = implode(",\n", $vals);
    $o[] = "ON DUPLICATE KEY UPDATE `id` = `id`;";
}
$o[] = "";
$o[] = "SET SESSION SQL_MODE = @OLD_SQL_MODE;";
$o[] = "SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;";
file_put_contents($salida, implode("\n", $o) . "\n");
echo "Escrito $salida: " . count($orden) . " tablas, " . count($ordenV) . " vistas\n";
