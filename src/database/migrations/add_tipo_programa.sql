-- Agregar el campo tipo_programa a la tabla carreras
ALTER TABLE carreras
ADD COLUMN tipo_programa ENUM('P', 'G') NOT NULL DEFAULT 'P' COMMENT 'P: Pregrado, G: Postgrado'
AFTER nombre;

-- Actualizar los registros existentes (opcional)
-- UPDATE carreras SET tipo_programa = 'P' WHERE tipo_programa IS NULL; 