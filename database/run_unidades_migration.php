<?php

/**
 * Script para ejecutar la migración de unidades
 * 
 * Este script ejecuta la migración que:
 * 1. Crea la tabla unidades
 * 2. Migra departamentos y facultades a unidades
 * 3. Actualiza las tablas relacionadas
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/migrations/2024_12_19_000001_create_unidades_table_and_migrate_departments.php';

try {
    // Crear conexión PDO
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );

    echo "=== MIGRACIÓN DE UNIDADES ===\n";
    echo "Fecha: " . date('Y-m-d H:i:s') . "\n\n";

    // Verificar si la migración ya se ejecutó
    $stmt = $pdo->query("SHOW TABLES LIKE 'unidades'");
    if ($stmt->rowCount() > 0) {
        echo "ADVERTENCIA: La tabla 'unidades' ya existe.\n";
        echo "¿Deseas continuar con la migración? (s/n): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        
        if (trim(strtolower($line)) !== 's') {
            echo "Migración cancelada.\n";
            exit(0);
        }
    }

    // Crear instancia de la migración
    $migration = new CreateUnidadesTableAndMigrateDepartments($pdo);

    // Ejecutar migración
    echo "Iniciando migración...\n";
    $migration->up();

    echo "\n=== MIGRACIÓN COMPLETADA ===\n";
    echo "La migración se ejecutó exitosamente.\n";
    echo "Se han realizado los siguientes cambios:\n";
    echo "- Creada tabla 'unidades'\n";
    echo "- Migrados departamentos a unidades\n";
    echo "- Migradas facultades a unidades\n";
    echo "- Actualizada tabla 'asignaturas_departamentos' (departamento_id -> id_unidad)\n";
    echo "- Actualizada tabla 'carreras_espejos' (facultad_id -> id_unidad)\n";
    echo "- Establecidas relaciones padre-hijo entre unidades\n";

} catch (Exception $e) {
    echo "\n=== ERROR EN LA MIGRACIÓN ===\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    exit(1);
} 