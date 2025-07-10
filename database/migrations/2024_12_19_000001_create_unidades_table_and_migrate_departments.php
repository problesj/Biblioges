<?php

/**
 * Migración para crear la tabla unidades y migrar departamentos y facultades
 * 
 * Esta migración:
 * 1. Crea la nueva tabla unidades
 * 2. Migra los datos de departamentos a unidades
 * 3. Migra los datos de facultades a unidades
 * 4. Actualiza asignaturas_departamentos para usar id_unidad en lugar de departamento_id
 * 5. Actualiza carreras_espejos para usar id_unidad en lugar de facultad_id
 */

class CreateUnidadesTableAndMigrateDepartments
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function up()
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Crear la tabla unidades
            $this->createUnidadesTable();

            // 2. Migrar departamentos a unidades
            $this->migrateDepartamentosToUnidades();

            // 3. Migrar facultades a unidades
            $this->migrateFacultadesToUnidades();

            // 4. Actualizar asignaturas_departamentos
            $this->updateAsignaturasDepartamentos();

            // 5. Actualizar carreras_espejos
            $this->updateCarrerasEspejos();

            $this->pdo->commit();
            echo "Migración completada exitosamente.\n";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en la migración: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    private function createUnidadesTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS unidades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(10) NOT NULL UNIQUE,
            nombre VARCHAR(250) NOT NULL,
            sede_id INT NOT NULL,
            id_unidad_padre VARCHAR(255) NULL,
            estado TINYINT(1) DEFAULT 1,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE CASCADE,
            FOREIGN KEY (id_unidad_padre) REFERENCES unidades(codigo) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $this->pdo->exec($sql);
        echo "Tabla unidades creada.\n";
    }

    private function migrateDepartamentosToUnidades()
    {
        // Migrar departamentos a unidades
        $sql = "
        INSERT INTO unidades (codigo, nombre, sede_id, estado, fecha_creacion, fecha_actualizacion)
        SELECT 
            CONCAT('DEPT_', LPAD(d.id, 4, '0')) as codigo,
            d.nombre,
            d.sede_id,
            d.estado,
            d.fecha_creacion,
            d.fecha_actualizacion
        FROM departamentos d
        ON DUPLICATE KEY UPDATE
            nombre = VALUES(nombre),
            sede_id = VALUES(sede_id),
            estado = VALUES(estado),
            fecha_actualizacion = CURRENT_TIMESTAMP
        ";

        $this->pdo->exec($sql);
        echo "Departamentos migrados a unidades.\n";
    }

    private function migrateFacultadesToUnidades()
    {
        // Migrar facultades a unidades
        $sql = "
        INSERT INTO unidades (codigo, nombre, sede_id, estado, fecha_creacion, fecha_actualizacion)
        SELECT 
            CONCAT('FAC_', LPAD(f.id, 4, '0')) as codigo,
            f.nombre,
            f.sede_id,
            f.estado,
            f.fecha_creacion,
            f.fecha_actualizacion
        FROM facultades f
        ON DUPLICATE KEY UPDATE
            nombre = VALUES(nombre),
            sede_id = VALUES(sede_id),
            estado = VALUES(estado),
            fecha_actualizacion = CURRENT_TIMESTAMP
        ";

        $this->pdo->exec($sql);
        echo "Facultades migradas a unidades.\n";

        // Actualizar las relaciones padre-hijo para departamentos
        $sql = "
        UPDATE unidades u
        INNER JOIN departamentos d ON u.codigo = CONCAT('DEPT_', LPAD(d.id, 4, '0'))
        INNER JOIN facultades f ON d.facultad_id = f.id
        SET u.id_unidad_padre = CONCAT('FAC_', LPAD(f.id, 4, '0'))
        WHERE u.codigo LIKE 'DEPT_%'
        ";

        $this->pdo->exec($sql);
        echo "Relaciones padre-hijo establecidas para departamentos.\n";
    }

    private function updateAsignaturasDepartamentos()
    {
        // Agregar la nueva columna id_unidad
        $sql = "ALTER TABLE asignaturas_departamentos ADD COLUMN id_unidad INT NULL AFTER departamento_id";
        $this->pdo->exec($sql);

        // Crear índice para la nueva columna
        $sql = "ALTER TABLE asignaturas_departamentos ADD INDEX idx_id_unidad (id_unidad)";
        $this->pdo->exec($sql);

        // Migrar los datos de departamento_id a id_unidad
        $sql = "
        UPDATE asignaturas_departamentos ad
        INNER JOIN departamentos d ON ad.departamento_id = d.id
        INNER JOIN unidades u ON u.codigo = CONCAT('DEPT_', LPAD(d.id, 4, '0'))
        SET ad.id_unidad = u.id
        ";
        $this->pdo->exec($sql);

        echo "Datos migrados de departamento_id a id_unidad en asignaturas_departamentos.\n";

        // Agregar la foreign key para id_unidad
        $sql = "
        ALTER TABLE asignaturas_departamentos 
        ADD CONSTRAINT fk_asignaturas_departamentos_unidad 
        FOREIGN KEY (id_unidad) REFERENCES unidades(id) ON DELETE CASCADE
        ";
        $this->pdo->exec($sql);

        // Eliminar la columna departamento_id y su foreign key
        $sql = "ALTER TABLE asignaturas_departamentos DROP FOREIGN KEY asignaturas_departamentos_ibfk_2";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE asignaturas_departamentos DROP COLUMN departamento_id";
        $this->pdo->exec($sql);

        // Actualizar el índice único
        $sql = "ALTER TABLE asignaturas_departamentos DROP INDEX unique_asignatura_departamento";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE asignaturas_departamentos ADD UNIQUE KEY unique_asignatura_unidad (asignatura_id, id_unidad)";
        $this->pdo->exec($sql);

        echo "Columna departamento_id eliminada y reemplazada por id_unidad.\n";
    }

    private function updateCarrerasEspejos()
    {
        // Agregar la nueva columna id_unidad
        $sql = "ALTER TABLE carreras_espejos ADD COLUMN id_unidad INT NULL AFTER facultad_id";
        $this->pdo->exec($sql);

        // Crear índice para la nueva columna
        $sql = "ALTER TABLE carreras_espejos ADD INDEX idx_id_unidad (id_unidad)";
        $this->pdo->exec($sql);

        // Migrar los datos de facultad_id a id_unidad
        $sql = "
        UPDATE carreras_espejos ce
        INNER JOIN facultades f ON ce.facultad_id = f.id
        INNER JOIN unidades u ON u.codigo = CONCAT('FAC_', LPAD(f.id, 4, '0'))
        SET ce.id_unidad = u.id
        ";
        $this->pdo->exec($sql);

        echo "Datos migrados de facultad_id a id_unidad en carreras_espejos.\n";

        // Agregar la foreign key para id_unidad
        $sql = "
        ALTER TABLE carreras_espejos 
        ADD CONSTRAINT fk_carreras_espejos_unidad 
        FOREIGN KEY (id_unidad) REFERENCES unidades(id) ON DELETE CASCADE
        ";
        $this->pdo->exec($sql);

        // Eliminar la columna facultad_id y su foreign key
        $sql = "ALTER TABLE carreras_espejos DROP FOREIGN KEY carreras_espejos_ibfk_2";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE carreras_espejos DROP COLUMN facultad_id";
        $this->pdo->exec($sql);

        // Actualizar el índice único
        $sql = "ALTER TABLE carreras_espejos DROP INDEX unique_carrera_espejo";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE carreras_espejos ADD UNIQUE KEY unique_carrera_espejo (carrera_id, codigo_carrera, id_unidad, sede_id)";
        $this->pdo->exec($sql);

        echo "Columna facultad_id eliminada y reemplazada por id_unidad.\n";
    }

    public function down()
    {
        try {
            $this->pdo->beginTransaction();

            // Revertir carreras_espejos
            $this->revertCarrerasEspejos();

            // Revertir asignaturas_departamentos
            $this->revertAsignaturasDepartamentos();

            // Eliminar tabla unidades
            $this->pdo->exec("DROP TABLE IF EXISTS unidades");

            $this->pdo->commit();
            echo "Rollback completado exitosamente.\n";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en el rollback: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    private function revertCarrerasEspejos()
    {
        // Agregar columna facultad_id
        $sql = "ALTER TABLE carreras_espejos ADD COLUMN facultad_id INT NULL AFTER id_unidad";
        $this->pdo->exec($sql);

        // Migrar datos de vuelta
        $sql = "
        UPDATE carreras_espejos ce
        INNER JOIN unidades u ON ce.id_unidad = u.id
        INNER JOIN facultades f ON f.id = SUBSTRING(u.codigo, 5)
        SET ce.facultad_id = f.id
        WHERE u.codigo LIKE 'FAC_%'
        ";
        $this->pdo->exec($sql);

        // Eliminar columna id_unidad
        $sql = "ALTER TABLE carreras_espejos DROP FOREIGN KEY fk_carreras_espejos_unidad";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE carreras_espejos DROP COLUMN id_unidad";
        $this->pdo->exec($sql);

        // Restaurar foreign key original
        $sql = "
        ALTER TABLE carreras_espejos 
        ADD CONSTRAINT carreras_espejos_ibfk_2 
        FOREIGN KEY (facultad_id) REFERENCES facultades(id) ON DELETE CASCADE
        ";
        $this->pdo->exec($sql);
    }

    private function revertAsignaturasDepartamentos()
    {
        // Agregar columna departamento_id
        $sql = "ALTER TABLE asignaturas_departamentos ADD COLUMN departamento_id INT NULL AFTER id_unidad";
        $this->pdo->exec($sql);

        // Migrar datos de vuelta
        $sql = "
        UPDATE asignaturas_departamentos ad
        INNER JOIN unidades u ON ad.id_unidad = u.id
        INNER JOIN departamentos d ON d.id = SUBSTRING(u.codigo, 6)
        SET ad.departamento_id = d.id
        WHERE u.codigo LIKE 'DEPT_%'
        ";
        $this->pdo->exec($sql);

        // Eliminar columna id_unidad
        $sql = "ALTER TABLE asignaturas_departamentos DROP FOREIGN KEY fk_asignaturas_departamentos_unidad";
        $this->pdo->exec($sql);

        $sql = "ALTER TABLE asignaturas_departamentos DROP COLUMN id_unidad";
        $this->pdo->exec($sql);

        // Restaurar foreign key original
        $sql = "
        ALTER TABLE asignaturas_departamentos 
        ADD CONSTRAINT asignaturas_departamentos_ibfk_2 
        FOREIGN KEY (departamento_id) REFERENCES departamentos(id) ON DELETE CASCADE
        ";
        $this->pdo->exec($sql);
    }
} 