-- Historial de fusiones y eliminaciones de bibliografías declaradas duplicadas.
-- Sin claves foráneas a propósito: debe conservarse aunque las declaradas ya no existan.
CREATE TABLE IF NOT EXISTS bibliografias_declaradas_historial (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  accion ENUM('fusion','eliminacion') COLLATE utf8mb4_unicode_ci NOT NULL,
  bibliografia_id INT NOT NULL COMMENT 'Declarada eliminada',
  bibliografia_destino_id INT NULL COMMENT 'Declarada que se mantuvo, si fue una fusión',
  usuario_id INT NULL,
  copia JSON NOT NULL COMMENT 'Declarada, detalle, autores, asignaturas y disponibles antes del cambio',
  resumen JSON NULL COMMENT 'Asignaturas y disponibles traspasadas, tipos ajustados y disponibles eliminadas',
  fecha_creacion TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_bibliografia (bibliografia_id),
  KEY idx_destino (bibliografia_destino_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
