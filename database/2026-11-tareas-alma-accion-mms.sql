-- El reporte de copias desde Alma registra 'mms_corregido' cuando solo se quitan los espacios de un MMS.
-- El SQL original de la tarea no incluía ese valor (la fila se reportaba como 'revisar' sin cambios).
ALTER TABLE tareas_alma_detalle
  MODIFY accion ENUM('actualizada','mms_corregido','mms_discrepante','a_electronico','eliminada','sin_copias','duplicada','revisar','discrepancia') COLLATE utf8mb4_unicode_ci NOT NULL;
