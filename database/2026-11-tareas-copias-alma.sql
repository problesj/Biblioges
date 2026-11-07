-- =====================================================================
-- Biblioges - Tarea programada: actualizar copias impresas desde Alma
-- Aplicar UNA vez, en desarrollo y luego en producción, ANTES de
-- desplegar el código que usa estas columnas.
--   mysql -u <usuario> -p bibliografia < database/2026-11-tareas-copias-alma.sql
-- =====================================================================

-- 1) Tareas: nuevo tipo; sede y carrera opcionales (esta tarea no es por carrera);
--    modo simulación y avance de la ejecución en curso
ALTER TABLE tareas_programadas
  MODIFY tipo_reporte ENUM('cobertura_basica_expandido','cobertura_complementaria_expandido','cobertura_ambas_expandido','actualizar_copias_alma')
         COLLATE utf8mb4_unicode_ci NOT NULL,
  MODIFY sede_id INT NULL,
  MODIFY carrera_id INT NULL,
  ADD COLUMN simulacion TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = calcula y reporta sin modificar datos' AFTER frecuencia,
  ADD COLUMN accion_sin_copias ENUM('eliminar','mantener') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mantener' COMMENT 'Bibliografias impresas sin copias ni acceso electronico' AFTER simulacion,
  ADD COLUMN progreso_actual INT NULL AFTER ultima_ejecucion,
  ADD COLUMN progreso_total INT NULL AFTER progreso_actual;

-- 2) Historial: nuevo tipo, estado "detenida" (resguardo activado) y resumen de la ejecución
ALTER TABLE tareas_programadas_ejecuciones
  MODIFY tipo_reporte ENUM('basica','complementaria','copias_alma') COLLATE utf8mb4_unicode_ci NOT NULL,
  MODIFY estado ENUM('completada','error','detenida') COLLATE utf8mb4_unicode_ci NOT NULL,
  ADD COLUMN simulacion TINYINT(1) NOT NULL DEFAULT 0 AFTER manual,
  ADD COLUMN resumen JSON NULL AFTER registros;

-- 3) Detalle de cambios de cada ejecución. Sin clave foránea a bibliografias_disponibles,
--    porque debe conservar el registro de las filas eliminadas.
CREATE TABLE IF NOT EXISTS tareas_alma_detalle (
  id INT NOT NULL AUTO_INCREMENT,
  ejecucion_id INT NOT NULL,
  accion ENUM('actualizada','mms_discrepante','a_electronico','eliminada','sin_copias','duplicada','revisar','discrepancia') COLLATE utf8mb4_unicode_ci NOT NULL,
  bibliografia_disponible_id INT NOT NULL,
  bibliografia_declarada_id INT NULL,
  titulo VARCHAR(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  anio_edicion INT NULL,
  id_mms VARCHAR(50) COLLATE utf8mb4_unicode_ci NULL,
  id_mms_nuevo VARCHAR(50) COLLATE utf8mb4_unicode_ci NULL,
  copias_antes JSON NULL COMMENT 'Ejemplares por sede antes del cambio',
  copias_despues JSON NULL COMMENT 'Ejemplares por sede después del cambio',
  copia_fila JSON NULL COMMENT 'Copia completa de la fila eliminada, con sus sedes y autores',
  declarada_sin_disponibles TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = la declarada quedó sin disponibles activas',
  mensaje TEXT COLLATE utf8mb4_unicode_ci NULL,
  fecha_creacion TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_ejecucion_accion (ejecucion_id, accion),
  KEY idx_disponible (bibliografia_disponible_id),
  CONSTRAINT fk_tareas_alma_detalle_ejecucion FOREIGN KEY (ejecucion_id)
    REFERENCES tareas_programadas_ejecuciones (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
