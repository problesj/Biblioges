-- Programación semanal por días: días ISO (1 = lunes ... 7 = domingo) separados por coma.
-- Solo se usa con frecuencia 'semanal'; la hora se toma de fecha_inicio.
ALTER TABLE tareas_programadas
  ADD COLUMN dias_semana VARCHAR(13) COLLATE utf8mb4_unicode_ci NULL
  COMMENT 'Solo frecuencia semanal: días ISO (1 = lunes ... 7 = domingo) separados por coma' AFTER frecuencia;
