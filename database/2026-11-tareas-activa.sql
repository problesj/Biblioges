-- Tareas programadas: activar / desactivar (pausar) sin perder su programación ni su estado.
-- El cron solo ejecuta tareas activas; "Ejecutar ahora" sigue disponible para las inactivas.
-- Aplicar ANTES de desplegar el código (desarrollo y producción).
ALTER TABLE `tareas_programadas`
  ADD COLUMN `activa` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = el cron la ejecuta; 0 = pausada' AFTER `estado`,
  ADD KEY `idx_activa_estado_fecha` (`activa`, `estado`, `fecha_programada`);
