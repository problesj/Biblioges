-- Crear tabla para tareas programadas de reportes
CREATE TABLE IF NOT EXISTS tareas_programadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo_reporte ENUM('cobertura_basica_expandido', 'cobertura_complementaria_expandido') NOT NULL,
    sede_id INT NOT NULL,
    carrera_id INT NOT NULL,
    fecha_programada DATETIME NOT NULL,
    estado ENUM('pendiente', 'en_proceso', 'completada', 'error', 'cancelada') DEFAULT 'pendiente',
    filtros_formacion JSON NULL,
    resultado TEXT NULL,
    error_mensaje TEXT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_ejecucion TIMESTAMP NULL,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_fecha_programada (fecha_programada),
    INDEX idx_estado (estado),
    INDEX idx_tipo_reporte (tipo_reporte),
    INDEX idx_sede_carrera (sede_id, carrera_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 