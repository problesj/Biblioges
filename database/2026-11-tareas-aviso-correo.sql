-- Correo al que se avisa cada vez que se ejecuta una tarea programada (vacío = sin aviso).
ALTER TABLE tareas_programadas
  ADD COLUMN correo_notificacion VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL
  COMMENT 'Correo que recibe un aviso tras cada ejecución; NULL = sin aviso' AFTER nombre;
