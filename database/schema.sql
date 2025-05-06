-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS bibliografia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bibliografia;

-- Tabla de sedes
CREATE TABLE IF NOT EXISTS sedes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(250) NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de facultades
CREATE TABLE IF NOT EXISTS facultades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(250) NOT NULL,
    sede_id INT NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla de departamentos
CREATE TABLE IF NOT EXISTS departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(250) NOT NULL,
    facultad_id INT NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (facultad_id) REFERENCES facultades(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla de carreras
CREATE TABLE IF NOT EXISTS carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(250) NOT NULL,
    tipo_programa ENUM('P', 'G', 'O') NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    url_libro VARCHAR(500),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Crear tabla CARRERAS_ESPEJOS
CREATE TABLE carreras_espejos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera_id INT NOT NULL,
    codigo_carrera VARCHAR(20) NOT NULL,
    vigencia_desde CHAR(6) NOT NULL,
    vigencia_hasta CHAR(6) NOT NULL DEFAULT '999999',
    facultad_id INT NOT NULL,
    sede_id INT NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    FOREIGN KEY (facultad_id) REFERENCES facultades(id) ON DELETE CASCADE,
    FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_carrera_espejo (carrera_id, codigo_carrera, facultad_id, sede_id)
);

-- Tabla de asignaturas
CREATE TABLE IF NOT EXISTS asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(250) NOT NULL,
    tipo ENUM(
        'REGULAR',
        'FORMACION_BASICA',
        'FORMACION_GENERAL',
        'FORMACION_IDIOMAS',
        'FORMACION_PROFESIONAL',
        'FORMACION_VALORES',
        'FORMACION_ESPECIALIDAD',
        'FORMACION_ELECTIVA',
        'FORMACION_ESPECIAL'
    ) NOT NULL,
    vigencia_desde VARCHAR(6) NOT NULL COMMENT 'Formato: AAAA-SS (Año-Secuencia)',
    vigencia_hasta VARCHAR(6) NOT NULL DEFAULT '999999' COMMENT 'Formato: AAAA-SS (Año-Secuencia), 999999 indica vigencia actual',
    estado TINYINT(1) DEFAULT 1,
    periodicidad ENUM('anual', 'semestral') NOT NULL,
    url_programa VARCHAR(500),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_vigencia_formato CHECK (
        (vigencia_desde REGEXP '^[0-9]{6}$') AND
        (vigencia_hasta REGEXP '^[0-9]{6}$') AND
        (vigencia_hasta = '999999' OR vigencia_hasta > vigencia_desde)
    )
) ENGINE=InnoDB;

-- Tabla de relación asignatura-padre-hijo
CREATE TABLE IF NOT EXISTS asignaturas_formacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asignatura_formacion_id INT NOT NULL COMMENT 'ID de la asignatura de formación (padre)',
    asignatura_regular_id INT NOT NULL COMMENT 'ID de la asignatura regular (hijo)',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (asignatura_formacion_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (asignatura_regular_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_formacion_regular (asignatura_formacion_id, asignatura_regular_id)
) ENGINE=InnoDB;

-- Tabla de mallas curriculares
CREATE TABLE IF NOT EXISTS mallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera_id INT NOT NULL,
    asignatura_id INT NOT NULL,
    semestre INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_carrera_asignatura_semestre (carrera_id, asignatura_id, semestre)
) ENGINE=InnoDB;

-- Tabla de relación asignaturas-departamentos
CREATE TABLE IF NOT EXISTS asignaturas_departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asignatura_id INT NOT NULL,
    departamento_id INT NOT NULL,
    codigo_asignatura VARCHAR(20) NOT NULL,
    cantidad_alumnos INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (departamento_id) REFERENCES departamentos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_asignatura_departamento (asignatura_id, departamento_id)
) ENGINE=InnoDB;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(250) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'docente', 'estudiante') NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de autores
CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apellidos VARCHAR(250) NOT NULL,
    nombres VARCHAR(250) NOT NULL,
    genero ENUM('Femenino', 'Masculino', 'Otro') NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de bibliografías declaradas
CREATE TABLE IF NOT EXISTS bibliografias_declaradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(250) NOT NULL,
    tipo ENUM('libro', 'articulo', 'tesis', 'software', 'sitio_web', 'otro') NOT NULL,
    anio_publicacion INT,
    editorial VARCHAR(250),
    edicion VARCHAR(50),
    url VARCHAR(500),
    nota TEXT,
    formato ENUM('impreso', 'electronico', 'ambos') NOT NULL,
    isbn VARCHAR(13),
    doi VARCHAR(100),
    asignatura_id INT,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de Libros
CREATE TABLE IF NOT EXISTS libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_libro (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de Artículos
CREATE TABLE IF NOT EXISTS articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    issn VARCHAR(9) NOT NULL,
    titulo_revista VARCHAR(250) NOT NULL,
    cronologia VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_articulo (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de Tesis
CREATE TABLE IF NOT EXISTS tesis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    carrera_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_bibliografia_tesis (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de Software
CREATE TABLE IF NOT EXISTS software (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    version VARCHAR(50) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_software (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de Sitios Web
CREATE TABLE IF NOT EXISTS sitios_web (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    fecha_consulta DATE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_sitio (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de Genéricos
CREATE TABLE IF NOT EXISTS genericos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_generico (bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de relación bibliografías-autores
CREATE TABLE IF NOT EXISTS bibliografias_autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_id INT NOT NULL,
    autor_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_autor (bibliografia_id, autor_id)
) ENGINE=InnoDB;

-- Tabla de relación asignaturas-bibliografías
CREATE TABLE IF NOT EXISTS asignaturas_bibliografias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    asignatura_id INT NOT NULL,
    bibliografia_id INT NOT NULL,
    tipo_bibliografia ENUM('basica', 'complementaria') NOT NULL,
    estado ENUM('activa', 'no_activa') NOT NULL DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_asignatura_bibliografia (asignatura_id, bibliografia_id)
) ENGINE=InnoDB;

-- Tabla de bibliografías disponibles
CREATE TABLE IF NOT EXISTS bibliografias_disponibles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_declarada_id INT NOT NULL,
    sede_id INT NULL,
    titulo VARCHAR(250) NOT NULL,
    anio_edicion INT NOT NULL,
    url_acceso VARCHAR(500),
    disponibilidad ENUM('impreso', 'electronico', 'ambos') NOT NULL,
    id_mms VARCHAR(50) UNIQUE,
    ejemplares INT NULL COMMENT 'Cantidad de ejemplares físicos por sede',
    ejemplares_digitales INT NULL COMMENT 'Cantidad de copias digitales (NULL para ilimitadas)',
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_declarada_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    CONSTRAINT chk_disponibilidad_sede CHECK (
        (disponibilidad = 'electronico' AND sede_id IS NULL) OR
        (disponibilidad IN ('impreso', 'ambos') AND sede_id IS NOT NULL)
    )
) ENGINE=InnoDB;

-- Triggers para validación de tipos de asignaturas
DELIMITER //
CREATE TRIGGER before_insert_asignaturas_formacion
BEFORE INSERT ON asignaturas_formacion
FOR EACH ROW
BEGIN
    DECLARE tipo_formacion VARCHAR(20);
    DECLARE tipo_regular VARCHAR(20);
    
    -- Obtener tipos de las asignaturas
    SELECT tipo INTO tipo_formacion FROM asignaturas WHERE id = NEW.asignatura_formacion_id;
    SELECT tipo INTO tipo_regular FROM asignaturas WHERE id = NEW.asignatura_regular_id;
    
    -- Validar tipos
    IF tipo_formacion = 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación';
    END IF;
    
    IF tipo_regular == 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular';
    END IF;
END//

CREATE TRIGGER before_update_asignaturas_formacion
BEFORE UPDATE ON asignaturas_formacion
FOR EACH ROW
BEGIN
    DECLARE tipo_formacion VARCHAR(20);
    DECLARE tipo_regular VARCHAR(20);
    
    -- Obtener tipos de las asignaturas
    SELECT tipo INTO tipo_formacion FROM asignaturas WHERE id = NEW.asignatura_formacion_id;
    SELECT tipo INTO tipo_regular FROM asignaturas WHERE id = NEW.asignatura_regular_id;
    
    -- Validar tipos
    IF tipo_formacion = 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación';
    END IF;
    
    IF tipo_regular = 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular';
    END IF;
END//

CREATE TRIGGER before_insert_asignaturas_bibliografias
BEFORE INSERT ON asignaturas_bibliografias
FOR EACH ROW
BEGIN
    DECLARE tipo_asignatura VARCHAR(20);
    
    -- Obtener tipo de la asignatura
    SELECT tipo INTO tipo_asignatura FROM asignaturas WHERE id = NEW.asignatura_id;
    
    -- Validar tipo
    IF tipo_asignatura != 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Solo se pueden vincular bibliografías con asignaturas de tipo REGULAR';
    END IF;
END//

CREATE TRIGGER before_update_asignaturas_bibliografias
BEFORE UPDATE ON asignaturas_bibliografias
FOR EACH ROW
BEGIN
    DECLARE tipo_asignatura VARCHAR(20);
    
    -- Obtener tipo de la asignatura
    SELECT tipo INTO tipo_asignatura FROM asignaturas WHERE id = NEW.asignatura_id;
    
    -- Validar tipo
    IF tipo_asignatura != 'REGULAR' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Solo se pueden vincular bibliografías con asignaturas de tipo REGULAR';
    END IF;
END//
DELIMITER ;

-- Insertar datos de ejemplo
INSERT INTO sedes (codigo, nombre) VALUES 
('SEDE1', 'Sede Central'),
('SEDE2', 'Sede Norte'),
('SEDE3', 'Sede Sur');

INSERT INTO facultades (codigo, nombre, sede_id) VALUES 
('FAC1', 'Facultad de Ingeniería', 1),
('FAC2', 'Facultad de Ciencias', 1),
('FAC3', 'Facultad de Humanidades', 2);

INSERT INTO departamentos (codigo, nombre, facultad_id) VALUES 
('DEP1', 'Departamento de Sistemas', 1),
('DEP2', 'Departamento de Electrónica', 1),
('DEP3', 'Departamento de Matemáticas', 2);

INSERT INTO carreras (nombre, tipo_programa, estado) VALUES 
('Ingeniería en Sistemas', 'P', 1),
('Licenciatura en Informática', 'P', 1),
('Tecnicatura en Programación', 'P', 1);

-- Ejemplo de asignaturas
INSERT INTO asignaturas (nombre, tipo, vigencia_desde, vigencia_hasta, periodicidad) VALUES 
-- Asignaturas regulares
('Programación I', 'REGULAR', '201910', '999999', 'semestral'),
('Base de Datos', 'REGULAR', '201910', '999999', 'semestral'),
('Matemática I', 'REGULAR', '201910', '999999', 'anual'),
('Inglés I', 'REGULAR', '201910', '999999', 'semestral'),
('Ética Profesional', 'REGULAR', '201910', '999999', 'semestral'),
-- Asignaturas de formación
('Formación Básica en Programación', 'FORMACION_BASICA', '201910', '999999', 'semestral'),
('Formación General en Idiomas', 'FORMACION_IDIOMAS', '201910', '999999', 'semestral'),
('Formación en Valores', 'FORMACION_VALORES', '201910', '999999', 'semestral');

INSERT INTO asignaturas_departamentos (asignatura_id, departamento_id, cantidad_alumnos, codigo_asignatura) VALUES 
(1, 1, 50, 'PROG-00123'),
(1, 2, 30, 'PROG-00124'),
(2, 1, 45, 'BD-00123'),
(3, 3, 60, 'MAT-00123');

INSERT INTO usuarios (nombre, email, password, rol) VALUES 
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Docente', 'docente@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente');

-- Ejemplo de autores
INSERT INTO autores (apellidos, nombres, genero) VALUES 
('Pérez', 'Juan', 'Masculino'),
('García', 'María', 'Femenino'),
('López', 'Carlos', 'Masculino');

-- Ejemplo de bibliografías declaradas
INSERT INTO bibliografias_declaradas (titulo, tipo, anio_publicacion, editorial, edicion, formato) VALUES 
('Introducción a la Programación', 'libro', 2020, 'Editorial ABC', '1ra Edición', 'impreso'),
('Base de Datos Relacionales', 'libro', 2019, 'Editorial XYZ', '2da Edición', 'ambos'),
('Investigación en IA', 'articulo', 2021, 'Revista Científica', 'Vol. 5', 'impreso'),
('Tesis de Grado', 'tesis', 2022, NULL, NULL, 'impreso'),
('Sistema de Gestión', 'software', 2023, NULL, NULL, 'electronico'),
('Portal Educativo', 'sitio_web', 2023, NULL, NULL, 'electronico'),
('Documento Técnico', 'otro', 2023, NULL, NULL, 'impreso');

-- Ejemplo de libros
INSERT INTO libros (bibliografia_id, isbn) VALUES 
(1, '9781234567890'),
(2, '9780987654321');

-- Ejemplo de artículos
INSERT INTO articulos (bibliografia_id, issn, titulo_revista, cronologia) VALUES 
(3, '1234-5678', 'Revista de Ciencias de la Computación', 'Vol. 5, No. 2, 2021');

-- Ejemplo de tesis
INSERT INTO tesis (bibliografia_id, carrera_id) VALUES 
(4, 1);

-- Ejemplo de software
INSERT INTO software (bibliografia_id, version) VALUES 
(5, '1.0.0');

-- Ejemplo de sitios web
INSERT INTO sitios_web (bibliografia_id, fecha_consulta) VALUES 
(6, '2023-12-01');

-- Ejemplo de genéricos
INSERT INTO genericos (bibliografia_id, descripcion) VALUES 
(7, 'Documento técnico sobre metodologías de desarrollo');

-- Ejemplo de relación bibliografías-autores
INSERT INTO bibliografias_autores (bibliografia_id, autor_id) VALUES 
(1, 1),
(2, 2);

-- Ejemplo de relación asignatura-padre-hijo
INSERT INTO asignaturas_formacion (asignatura_formacion_id, asignatura_regular_id) VALUES 
(6, 1), -- Formación Básica en Programación -> Programación I
(6, 2), -- Formación Básica en Programación -> Base de Datos
(7, 4), -- Formación General en Idiomas -> Inglés I
(8, 5); -- Formación en Valores -> Ética Profesional

-- Ejemplo de mallas curriculares
INSERT INTO mallas (carrera_id, asignatura_id, semestre) VALUES 
(1, 1, 1), -- Ingeniería en Sistemas -> Programación I -> Semestre 1
(1, 2, 2), -- Ingeniería en Sistemas -> Base de Datos -> Semestre 2
(1, 3, 1), -- Ingeniería en Sistemas -> Matemática I -> Semestre 1
(1, 4, 1), -- Ingeniería en Sistemas -> Inglés I -> Semestre 1
(1, 5, 3); -- Ingeniería en Sistemas -> Ética Profesional -> Semestre 3

-- Ejemplo de relación asignaturas-bibliografías
INSERT INTO asignaturas_bibliografias (asignatura_id, bibliografia_id, tipo_bibliografia, estado) VALUES 
(1, 1, 'basica', 'activa'),      -- Programación I -> Introducción a la Programación (Básica)
(1, 2, 'complementaria', 'activa'), -- Programación I -> Base de Datos Relacionales (Complementaria)
(2, 2, 'basica', 'activa'),      -- Base de Datos -> Base de Datos Relacionales (Básica)
(3, 3, 'complementaria', 'activa'); -- Matemática I -> Investigación en IA (Complementaria)

-- Ejemplo de bibliografías disponibles
INSERT INTO bibliografias_disponibles (
    bibliografia_declarada_id,
    sede_id,
    titulo,
    anio_edicion,
    url_acceso,
    disponibilidad,
    id_mms,
    ejemplares,
    ejemplares_digitales
) VALUES 
-- Para "Introducción a la Programación"
(1, 1, 'Introducción a la Programación - Edición 2020', 2020, NULL, 'impreso', 'MMS001', 5, NULL),
(1, null, 'Introducción a la Programación - Edición Digital', 2020, 'https://ejemplo.com/libro1', 'electronico', 'MMS002', 1, 1),

-- Para "Base de Datos Relacionales"
(2, 1, 'Base de Datos Relacionales - Edición 2019', 2019, NULL, 'impreso', 'MMS003', 3, NULL),
(2, null, 'Base de Datos Relacionales - Edición Digital', 2019, 'https://ejemplo.com/libro2', 'electronico', 'MMS004', 1, 1),

-- Para "Investigación en IA"
(3, null, 'Investigación en IA - Revista Vol. 5', 2021, 'https://ejemplo.com/articulo1', 'electronico', 'MMS005', 1, NULL),

-- Ejemplares físicos en Sede Norte
(1, 2, 'Introducción a la Programación - Edición 2020', 2020, NULL, 'impreso', 'MMS006', 3, NULL),
(2, 2, 'Base de Datos Relacionales - Edición 2019', 2019, NULL, 'impreso', 'MMS007', 2, NULL),

-- Ejemplares físicos en Sede Sur
(1, 3, 'Introducción a la Programación - Edición 2020', 2020, NULL, 'impreso', 'MMS008', 4, NULL),
(2, 3, 'Base de Datos Relacionales - Edición 2019', 2019, NULL, 'impreso', 'MMS009', 3, NULL); 