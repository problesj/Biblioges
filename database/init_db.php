<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar configuración de la base de datos de producción
$prodConfig = require __DIR__ . '/config/database.php';

// Configuración de la base de datos ROOT (para crear usuario y base de datos)
$rootConfig = [
    'host' => $prodConfig['host'],
    'port' => $prodConfig['port'],
    'user' => 'root',
    'password' => $prodConfig['password'] // Se asume que el root usa la misma contraseña, ajustar si es necesario
];

// Datos de producción
$prodDbName = $prodConfig['database'];
$prodUser = $prodConfig['username'];
$prodPassword = $prodConfig['password'];

try {
    // Conectar a MySQL como root sin seleccionar base de datos
    $pdo = new PDO(
        "mysql:host={$rootConfig['host']};port={$rootConfig['port']};charset=utf8mb4",
        $rootConfig['user'],
        $rootConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "Conectado como root. Creando base de datos de producción...\n";

    // Crear base de datos de producción si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$prodDbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de datos '{$prodDbName}' creada/verificada.\n";

    // Crear usuario de producción si no existe
    $pdo->exec("CREATE USER IF NOT EXISTS '{$prodUser}'@'%' IDENTIFIED BY '{$prodPassword}'");
    echo "Usuario '{$prodUser}' creado/verificado.\n";

    // Otorgar todos los privilegios al usuario sobre la base de datos de producción
    $pdo->exec("GRANT ALL PRIVILEGES ON {$prodDbName}.* TO '{$prodUser}'@'%'");
    $pdo->exec("FLUSH PRIVILEGES");
    echo "Privilegios otorgados a '{$prodUser}' sobre '{$prodDbName}'.\n";

    // Cambiar a la base de datos de producción
    $pdo->exec("USE {$prodDbName}");

    // Leer el esquema
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    
    // Eliminar líneas DELIMITER
    $schema = preg_replace('/^DELIMITER .+$/m', '', $schema);
    
    // NO reemplazar referencias de base de datos
    
    // Procesar el SQL línea por línea
    $lines = explode("\n", $schema);
    $statement = '';
    $inBlock = false;
    $blockStarters = ['CREATE TRIGGER', 'CREATE PROCEDURE', 'CREATE FUNCTION'];
    $retryStatements = [];
    $maxRetries = 3;
    
    for ($retryCount = 0; $retryCount <= $maxRetries; $retryCount++) {
        if ($retryCount > 0) {
            echo "\n🔄 Reintento #{$retryCount} de declaraciones con dependencias...\n";
            $lines = array_map(function($stmt) { return $stmt . "\n"; }, $retryStatements);
            $retryStatements = [];
        }
        
        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            if ($trimmedLine === '' || strpos($trimmedLine, '--') === 0) continue;
            
            if (!$inBlock) {
                foreach ($blockStarters as $starter) {
                    if (stripos($trimmedLine, $starter) === 0) {
                        $inBlock = true;
                        break;
                    }
                }
            }
            
            $statement .= $line . "\n";
            
            if ($inBlock) {
                if (preg_match('/END;\s*$/i', $trimmedLine)) {
                    try {
                        $pdo->exec($statement);
                        echo "Ejecutado bloque: " . substr($statement, 0, 50) . "...\n";
                    } catch (PDOException $e) {
                        echo "Error ejecutando bloque: " . substr($statement, 0, 50) . "...\n";
                        echo "Error: " . $e->getMessage() . "\n";
                    }
                    $statement = '';
                    $inBlock = false;
                }
            } else {
                if (preg_match('/;\s*$/', $trimmedLine)) {
                    if (preg_match('/^(DROP DATABASE|CREATE DATABASE|USE)\s+/i', $statement)) {
                        echo "Saltando comando de base de datos: " . substr($statement, 0, 50) . "...\n";
                        $statement = '';
                        continue;
                    }
                    try {
                        $pdo->exec($statement);
                        echo "Ejecutado: " . substr($statement, 0, 50) . "...\n";
                    } catch (PDOException $e) {
                        $errorMsg = $e->getMessage();
                        if (strpos($errorMsg, 'already exists') !== false) {
                            echo "Ignorando error (tabla ya existe): " . substr($statement, 0, 50) . "...\n";
                        } else if (strpos($errorMsg, 'Failed to open the referenced table') !== false ||
                                 strpos($errorMsg, "doesn't exist") !== false ||
                                 strpos($errorMsg, 'Base table or view not found') !== false) {
                            echo "⚠️  Error de dependencia: " . substr($statement, 0, 50) . "...\n";
                            echo "   La tabla/vista referenciada no existe aún. Se reintentará.\n";
                            $retryStatements[] = $statement;
                        } else if (strpos($errorMsg, 'foreign key') !== false || 
                                   strpos($errorMsg, 'Integrity constraint violation') !== false) {
                            echo "Ignorando error de foreign key: " . substr($statement, 0, 50) . "...\n";
                        } else {
                            echo "Error ejecutando: " . substr($statement, 0, 50) . "...\n";
                            echo "Error: " . $errorMsg . "\n";
                        }
                    }
                    $statement = '';
                }
            }
        }
        if (empty($retryStatements)) {
            break;
        }
    }
    if (!empty($retryStatements)) {
        echo "\n❌ Las siguientes declaraciones no se pudieron ejecutar después de {$maxRetries} reintentos:\n";
        foreach ($retryStatements as $failedStatement) {
            echo "   - " . substr($failedStatement, 0, 80) . "...\n";
        }
    }
    echo "\n📊 Verificando tablas creadas...\n";
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "✅ Tablas creadas exitosamente (" . count($tables) . "):\n";
        foreach ($tables as $table) {
            echo "   - {$table}\n";
        }
        $expectedTables = ['reportes', 'reporte_coberturas_carreras_basicas', 'reporte_coberturas_carreras_complementarias'];
        echo "\n🔍 Verificando tablas críticas:\n";
        foreach ($expectedTables as $expectedTable) {
            if (in_array($expectedTable, $tables)) {
                echo "   ✅ {$expectedTable} - EXISTE\n";
            } else {
                echo "   ❌ {$expectedTable} - NO EXISTE\n";
            }
        }
    } catch (PDOException $e) {
        echo "Error verificando tablas: " . $e->getMessage() . "\n";
    }
    $seederFile = __DIR__ . '/seeders/DatabaseSeeder.php';
    if (file_exists($seederFile)) {
        require_once $seederFile;
        if (class_exists('DatabaseSeeder')) {
            $seeder = new DatabaseSeeder();
            $seeder->run();
        }
    }
    echo "\n=== RESUMEN ===\n";
    echo "Base de datos de producción: {$prodDbName}\n";
    echo "Usuario creado: {$prodUser}\n";
    echo "Contraseña del usuario: {$prodPassword}\n";
    echo "Host: {$rootConfig['host']}:{$rootConfig['port']}\n";
    echo "\nBase de datos de producción inicializada correctamente.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 