-- Script para crear la tabla filtros_formaciones
-- Ejecutar este script en la base de datos bibliografia

USE bibliografia;

-- Tabla para almacenar filtros de formación por carrera
CREATE TABLE IF NOT EXISTS filtros_formaciones (
    codigo_carrera VARCHAR(20) NOT NULL,
    basica INT NOT NULL DEFAULT 0,
    general INT NOT NULL DEFAULT 0,
    idioma INT NOT NULL DEFAULT 0,
    profesional INT NOT NULL DEFAULT 0,
    valores INT NOT NULL DEFAULT 0,
    especialidad INT NOT NULL DEFAULT 0,
    especial INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (codigo_carrera),
    FOREIGN KEY (codigo_carrera) REFERENCES carreras_espejos(codigo_carrera) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Verificar que la tabla se creó correctamente
SHOW TABLES LIKE 'filtros_formaciones';
DESCRIBE filtros_formaciones; 