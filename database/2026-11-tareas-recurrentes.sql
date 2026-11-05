-- =====================================================================
-- Biblioges - Tareas programadas recurrentes (noviembre 2026)
-- Aplicar UNA vez, en desarrollo y luego en producción, ANTES de
-- desplegar el código que usa estas columnas.
--   mysql -u <usuario> -p bibliografia < database/2026-11-tareas-recurrentes.sql
-- =====================================================================

-- 1) Nuevas columnas y tipo "ambos" en tareas_programadas
ALTER TABLE tareas_programadas
  MODIFY tipo_reporte ENUM('cobertura_basica_expandido','cobertura_complementaria_expandido','cobertura_ambas_expandido')
         COLLATE utf8mb4_unicode_ci NOT NULL,
  ADD COLUMN frecuencia ENUM('unica','diaria','semanal','mensual','anual')
         COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unica' AFTER fecha_programada,
  ADD COLUMN fecha_inicio DATETIME NULL COMMENT 'Primera ejecución; base para calcular las repeticiones' AFTER frecuencia,
  ADD COLUMN fecha_fin DATETIME NULL COMMENT 'Opcional: no repetir después de esta fecha' AFTER fecha_inicio,
  ADD COLUMN ultima_ejecucion DATETIME NULL AFTER fecha_ejecucion,
  ADD COLUMN creado_por INT NULL AFTER ultima_ejecucion,
  ADD KEY idx_estado_fecha (estado, fecha_programada);

-- Las tareas existentes quedan como ejecución única
UPDATE tareas_programadas
   SET fecha_inicio = fecha_programada
 WHERE fecha_inicio IS NULL;

UPDATE tareas_programadas
   SET ultima_ejecucion = fecha_ejecucion
 WHERE ultima_ejecucion IS NULL AND fecha_ejecucion IS NOT NULL;

-- 2) Historial de ejecuciones (una fila por tipo de reporte ejecutado)
CREATE TABLE IF NOT EXISTS tareas_programadas_ejecuciones (
  id INT NOT NULL AUTO_INCREMENT,
  tarea_id INT NOT NULL,
  tipo_reporte ENUM('basica','complementaria') COLLATE utf8mb4_unicode_ci NOT NULL,
  manual TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = lanzada con "Ejecutar ahora"',
  fecha_inicio DATETIME NOT NULL,
  fecha_fin DATETIME NULL,
  estado ENUM('completada','error') COLLATE utf8mb4_unicode_ci NOT NULL,
  registros INT NULL,
  mensaje TEXT COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (id),
  KEY idx_tarea_fecha (tarea_id, fecha_inicio),
  CONSTRAINT fk_tareas_ejecuciones_tarea FOREIGN KEY (tarea_id)
    REFERENCES tareas_programadas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
