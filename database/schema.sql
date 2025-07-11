DROP DATABASE IF EXISTS bibliografia;
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
    asignatura_regular_id INT NOT NULL COMMENT 'ID de la asignatura formacion (hijo)',
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
    rut VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(250) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'admin_bidoc', 'usuario') NOT NULL,
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
    tipo ENUM('libro', 'articulo', 'tesis', 'software', 'sitio_web', 'generico') NOT NULL,
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
    isbn VARCHAR(20) NOT NULL,
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
    tipo_bibliografia ENUM('basica', 'complementaria', 'otro') NOT NULL,
    estado ENUM('activa', 'no_activa') NOT NULL DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (bibliografia_id) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_asignatura_bibliografia (asignatura_id, bibliografia_id)
) ENGINE=InnoDB;

-- Eliminar tablas existentes si existen
DROP TABLE IF EXISTS bibliografias_disponibles_sedes;
DROP TABLE IF EXISTS bibliografias_disponibles;

-- Crear tabla bibliografias_disponibles
CREATE TABLE bibliografias_disponibles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_declarada_id INT,
    titulo VARCHAR(250) NOT NULL,
    anio_edicion INT NOT NULL,
    editorial VARCHAR(250),
    url_acceso VARCHAR(500),
    url_catalogo VARCHAR(500),
    disponibilidad ENUM('impreso', 'electronico', 'ambos') NOT NULL,
    id_mms VARCHAR(50),
    ejemplares_digitales INT,
    estado BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_declarada_id) REFERENCES bibliografias_declaradas(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla bibliografias_disponibles_sedes
CREATE TABLE bibliografias_disponibles_sedes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bibliografia_disponible_id INT NOT NULL,
    sede_id INT NOT NULL,
    ejemplares INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bibliografia_disponible_id) REFERENCES bibliografias_disponibles(id) ON DELETE CASCADE,
    FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bibliografia_sede (bibliografia_disponible_id, sede_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de relación entre bibliografías disponibles y autores
CREATE TABLE IF NOT EXISTS `bibliografias_disponibles_autores` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `bibliografia_disponible_id` INT NOT NULL,
    `autor_id` INT NOT NULL,
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `fecha_actualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_bibliografia_autor` (`bibliografia_disponible_id`, `autor_id`),
    KEY `fk_bda_autor` (`autor_id`),
    CONSTRAINT `fk_bda_bibliografia` FOREIGN KEY (`bibliografia_disponible_id`) REFERENCES `bibliografias_disponibles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_bda_autor` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Triggers para validación de tipos de asignaturas
DELIMITER //
CREATE TRIGGER before_insert_asignaturas_formacion
BEFORE INSERT ON asignaturas_formacion
FOR EACH ROW
BEGIN
    DECLARE tipo_formacion VARCHAR(50);
    DECLARE tipo_regular VARCHAR(50);
    
    -- Obtener tipos de las asignaturas
    SELECT tipo INTO tipo_formacion FROM asignaturas WHERE id = NEW.asignatura_formacion_id;
    SELECT tipo INTO tipo_regular FROM asignaturas WHERE id = NEW.asignatura_regular_id;
    
    -- Validar tipos
    IF tipo_formacion != 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación electiva';
    END IF;
    
    IF tipo_regular = 'REGULAR' || tipo_regular = 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular o formación electiva';
    END IF;
END//

CREATE TRIGGER before_update_asignaturas_formacion
BEFORE UPDATE ON asignaturas_formacion
FOR EACH ROW
BEGIN
    DECLARE tipo_formacion VARCHAR(50);
    DECLARE tipo_regular VARCHAR(50);
    
    -- Obtener tipos de las asignaturas
    SELECT tipo INTO tipo_formacion FROM asignaturas WHERE id = NEW.asignatura_formacion_id;
    SELECT tipo INTO tipo_regular FROM asignaturas WHERE id = NEW.asignatura_regular_id;
    
    -- Validar tipos
    IF tipo_formacion != 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación electiva';
    END IF;
    
    IF tipo_regular = 'REGULAR' || tipo_regular = 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular o formación electiva';
    END IF;
END//

CREATE TRIGGER before_insert_asignaturas_bibliografias
BEFORE INSERT ON asignaturas_bibliografias
FOR EACH ROW
BEGIN
    DECLARE tipo_asignatura VARCHAR(50);
    
    -- Obtener tipo de la asignatura
    SELECT tipo INTO tipo_asignatura FROM asignaturas WHERE id = NEW.asignatura_id;
    
    -- Validar tipo
    IF tipo_asignatura = 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede vincular bibliografías con asignaturas de tipo FORMACION_ELECTIVA';
    END IF;
END//

CREATE TRIGGER before_update_asignaturas_bibliografias
BEFORE UPDATE ON asignaturas_bibliografias
FOR EACH ROW
BEGIN
    DECLARE tipo_asignatura VARCHAR(50);
    
    -- Obtener tipo de la asignatura
    SELECT tipo INTO tipo_asignatura FROM asignaturas WHERE id = NEW.asignatura_id;
    
    -- Validar tipo
    IF tipo_asignatura = 'FORMACION_ELECTIVA' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se puede vincular bibliografías con asignaturas de tipo FORMACION_ELECTIVA';
    END IF;
END//
DELIMITER ;

-- Insertar datos de ejemplo
INSERT INTO sedes (codigo, nombre) VALUES 
('SEDE1', 'Sede Central'),
('SEDE2', 'Sede Norte'),
('SEDE3', 'Sede Sur');

-- Sede especial para casos sin sede
INSERT INTO sedes (id, codigo, nombre) VALUES (0, 'S000', 'Sin sede')
    ON DUPLICATE KEY UPDATE nombre = 'Sin sede';

-- Unidad especial para casos sin unidad, vinculada a 'Sin sede'
INSERT INTO unidades (id, codigo, nombre, sede_id, id_unidad_padre) VALUES (0, 'SIN_UNIDAD', 'Sin unidad', 0, NULL)
    ON DUPLICATE KEY UPDATE nombre = 'Sin unidad', sede_id = 0, id_unidad_padre = NULL;

INSERT INTO carreras (nombre, tipo_programa, estado) VALUES 
('Ingeniería en Sistemas', 'P', 1),
('Licenciatura en Informática', 'P', 1),
('Tecnicatura en Programación', 'P', 1);

-- Ejemplo de asignaturas
INSERT INTO asignaturas (nombre, tipo, vigencia_desde, vigencia_hasta, periodicidad) VALUES 
-- Asignaturas regulares
('Programación I', 'FORMACION_PROFESIONAL', '201910', '999999', 'semestral'),
('Base de Datos', 'FORMACION_PROFESIONAL', '201910', '999999', 'semestral'),
('Matemática I', 'REGULAR', '201910', '999999', 'anual'),
('Inglés I', 'FORMACION_IDIOMAS', '201910', '999999', 'semestral'),
('Ética Profesional', 'FORMACION_VALORES', '201910', '999999', 'semestral'),
-- Asignaturas de formación
('Formación Básica en Programación', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral'),
('Formación General en Idiomas', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral'),
('Formación en Valores', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral');

INSERT INTO asignaturas_departamentos (asignatura_id, departamento_id, cantidad_alumnos, codigo_asignatura) VALUES 
(1, 1, 50, 'PROG-00123'),
(1, 2, 30, 'PROG-00124'),
(2, 1, 45, 'BD-00123'),
(3, 3, 60, 'MAT-00123');

INSERT INTO usuarios (rut, nombre, email, password, rol) VALUES 
('12345678-9', 'Administrador del Sistema', 'admin@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('23456789-0', 'Administrador Biblioteca', 'admin_bidoc@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_bidoc'),
('34567890-1', 'Usuario Ejemplo', 'usuario@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario');

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
    titulo,
    anio_edicion,
    editorial,
    url_acceso,
    url_catalogo,
    disponibilidad,
    id_mms,
    ejemplares_digitales
) VALUES 
-- Para "Introducción a la Programación"
(1, 'Introducción a la Programación - Edición 2020', 2020,'Editorial ABC', NULL, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS001', null),
(1, 'Introducción a la Programación - Edición Digital', 2020, 'Editorial ABC', 'https://ejemplo.com/libro1', NULL, 'electronico', null, 0),

-- Para "Base de Datos Relacionales"
(2, 'Base de Datos Relacionales - Edición 2019', 2019, 'Editorial XYZ', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS003', NULL),
(2, 'Base de Datos Relacionales - Edición Digital', 2019, 'Editorial XYZ', 'https://ejemplo.com/libro2', NULL, 'electronico', null, 0),

-- Para "Investigación en IA"
(3, 'Investigación en IA - Revista Vol. 5', 2021, 'Revista Científica', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS004', NULL),
(3, 'Investigación en IA - Revista Vol. 5', 2021, 'Revista Científica', 'https://ejemplo.com/articulo1', NULL, 'electronico', null, 0),

-- Ejemplares físicos en Sede Norte
(1, 'Introducción a la Programación - Edición 2020', 2020, 'Editorial ABC', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS006', NULL),
(2, 'Base de Datos Relacionales - Edición 2019', 2019, 'Editorial XYZ', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS007', NULL),

-- Ejemplares físicos en Sede Sur
(1, 'Introducción a la Programación - Edición 2020', 2020, 'Editorial ABC', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS008', NULL),
(2, 'Base de Datos Relacionales - Edición 2019', 2019, 'Editorial XYZ', null, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS009', NULL);

-- Insertar datos de ejemplo en bibliografias_disponibles_sedes
INSERT INTO bibliografias_disponibles_sedes (
    bibliografia_disponible_id,
    sede_id,
    ejemplares
) VALUES 
-- Ejemplares en Sede Norte (id: 1)
(1, 1, 5), -- Introducción a la Programación
(3, 1, 3), -- Base de Datos Relacionales

-- Ejemplares en Sede Sur (id: 2)
(1, 2, 3), -- Introducción a la Programación
(3, 2, 2), -- Base de Datos Relacionales

-- Ejemplares en Sede Este (id: 3)
(1, 3, 4), -- Introducción a la Programación
(3, 3, 3); -- Base de Datos Relacionales 

-- =====================================================
-- VISTAS Y TABLAS DE REPORTES
-- =====================================================

-- Tabla de reportes
CREATE TABLE IF NOT EXISTS reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(250) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reporte de coberturas básicas por carrera
CREATE TABLE IF NOT EXISTS reporte_coberturas_carreras_basicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reporte INT NOT NULL,
    codigo_carrera VARCHAR(20) NOT NULL,
    codigo_asignatura VARCHAR(20) NOT NULL,
    id_bibliografia_declarada INT NOT NULL,
    fecha_medicion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    no_ejem_imp INT DEFAULT 0,
    no_ejem_dig INT DEFAULT 0,
    no_bib_disponible_basica TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_reporte) REFERENCES reportes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_bibliografia_declarada) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    INDEX idx_carrera_asignatura (codigo_carrera, codigo_asignatura),
    INDEX idx_fecha_medicion (fecha_medicion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de reporte de coberturas complementarias por carrera
CREATE TABLE IF NOT EXISTS reporte_coberturas_carreras_complementarias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reporte INT NOT NULL,
    codigo_carrera VARCHAR(20) NOT NULL,
    codigo_asignatura VARCHAR(20) NOT NULL,
    id_bibliografia_declarada INT NOT NULL,
    fecha_medicion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    no_ejem_imp INT DEFAULT 0,
    no_ejem_dig INT DEFAULT 0,
    no_bib_disponible_complementaria TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_reporte) REFERENCES reportes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_bibliografia_declarada) REFERENCES bibliografias_declaradas(id) ON DELETE CASCADE,
    INDEX idx_carrera_asignatura (codigo_carrera, codigo_asignatura),
    INDEX idx_fecha_medicion (fecha_medicion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vista actualizada de mallas basada en unidades
CREATE OR REPLACE VIEW vw_mallas AS
SELECT
  sedes.id AS id_sede,
  sedes.nombre AS sede,
  unidades.id AS id_unidad,
  unidades.nombre AS unidad,
  carreras_espejos.codigo_carrera AS codigo_carrera,
  carreras.id AS id_carrera,
  carreras.nombre AS carrera,
  asignaturas_departamentos.codigo_asignatura AS codigo_asignatura,
  asignaturas.id AS id_asignatura,
  asignaturas.nombre AS asignatura,
  asignaturas.tipo AS tipo_asignatura,
  NULL AS codigo_asignatura_formacion,
  NULL AS id_asignatura_formacion,
  NULL AS asignatura_formacion
FROM mallas
JOIN asignaturas ON mallas.asignatura_id = asignaturas.id
JOIN carreras_espejos ON mallas.carrera_id = carreras_espejos.carrera_id
JOIN carreras ON mallas.carrera_id = carreras.id
JOIN asignaturas_departamentos ON asignaturas_departamentos.asignatura_id = asignaturas.id
JOIN sedes ON carreras_espejos.sede_id = sedes.id
JOIN unidades ON asignaturas_departamentos.id_unidad = unidades.id

UNION

SELECT DISTINCT
  sedes.id AS id_sede,
  sedes.nombre AS sede,
  unidades.id AS id_unidad,
  unidades.nombre AS unidad,
  carreras_espejos.codigo_carrera AS codigo_carrera,
  mallas.carrera_id AS id_carrera,
  carreras.nombre AS carrera,
  asignaturas_departamentos.codigo_asignatura AS codigo_asignatura,
  asignaturas_departamentos.asignatura_id AS id_asignatura,
  asignaturas.nombre AS asignatura,
  asignaturas_formacion.tipo AS tipo_asignatura,
  asignaturas_departamentos_formacion.codigo_asignatura AS codigo_asignatura_formacion,
  asignaturas_formacion.id AS id_asignatura_formacion,
  asignaturas_formacion.nombre AS asignatura_formacion
FROM asignaturas
JOIN asignaturas_formacion ON asignaturas_formacion.asignatura_formacion_id = asignaturas.id
JOIN asignaturas AS asignaturas_formacion ON asignaturas_formacion.id = asignaturas_formacion.asignatura_regular_id
JOIN mallas ON asignaturas.id = mallas.asignatura_id
JOIN asignaturas_departamentos ON mallas.asignatura_id = asignaturas_departamentos.asignatura_id
JOIN unidades ON asignaturas_departamentos.id_unidad = unidades.id
JOIN sedes ON unidades.sede_id = sedes.id
JOIN carreras_espejos ON mallas.carrera_id = carreras_espejos.carrera_id
JOIN carreras ON mallas.carrera_id = carreras.id
JOIN asignaturas_departamentos AS asignaturas_departamentos_formacion ON asignaturas_formacion.id = asignaturas_departamentos_formacion.asignatura_id
WHERE (sedes.id = 0)
ORDER BY codigo_carrera, sede, asignatura;

-- Vista de asignaturas con bibliografías declaradas
CREATE OR REPLACE VIEW vw_asig_bib_declarada AS
SELECT 
    asignaturas.id AS id_asignatura,
    asignaturas_bibliografias.bibliografia_id AS id_bib_declarada,
    asignaturas_bibliografias.tipo_bibliografia AS tipo_bibliografia,
    bibliografias_declaradas.titulo AS titulo,
    bibliografias_declaradas.tipo AS tipo,
    bibliografias_declaradas.anio_publicacion AS anio_publicacion,
    bibliografias_declaradas.editorial AS editorial,
    bibliografias_declaradas.formato AS formato
FROM asignaturas_bibliografias 
JOIN asignaturas ON asignaturas_bibliografias.asignatura_id = asignaturas.id
JOIN bibliografias_declaradas ON asignaturas_bibliografias.bibliografia_id = bibliografias_declaradas.id
ORDER BY asignaturas.id, asignaturas_bibliografias.tipo_bibliografia, bibliografias_declaradas.titulo;

-- Vista de bibliografías declaradas por sede y ejemplares
CREATE OR REPLACE VIEW vw_bib_declarada_sede_noejem AS
SELECT 
    bibliografias_declaradas.id AS id_bib_declarada,
    bibliografias_disponibles_sedes.sede_id AS id_sede,
    SUM(bibliografias_disponibles_sedes.ejemplares) AS no_ejem_imp_sede
FROM bibliografias_disponibles_sedes 
JOIN bibliografias_disponibles ON bibliografias_disponibles_sedes.bibliografia_disponible_id = bibliografias_disponibles.id
JOIN bibliografias_declaradas ON bibliografias_disponibles.bibliografia_declarada_id = bibliografias_declaradas.id
GROUP BY bibliografias_disponibles_sedes.sede_id, bibliografias_declaradas.id
ORDER BY id_bib_declarada, id_sede;

-- Vista de carreras con bibliografías básicas declaradas
CREATE OR REPLACE VIEW vw_car_basica_bib_declarada AS
SELECT 
    reporte_coberturas_carreras_basicas.codigo_carrera AS codigo_carrera,
    YEAR(reporte_coberturas_carreras_basicas.fecha_medicion) AS anho,
    COUNT(DISTINCT reporte_coberturas_carreras_basicas.id_bibliografia_declarada) AS no_bib_declarada
FROM reporte_coberturas_carreras_basicas 
GROUP BY reporte_coberturas_carreras_basicas.codigo_carrera, YEAR(reporte_coberturas_carreras_basicas.fecha_medicion);

-- Vista de carreras con bibliografías básicas disponibles
CREATE OR REPLACE VIEW vw_car_basica_bib_disponible AS
SELECT 
    reporte_coberturas_carreras_basicas.codigo_carrera AS codigo_carrera,
    YEAR(reporte_coberturas_carreras_basicas.fecha_medicion) AS anho,
    SUM(reporte_coberturas_carreras_basicas.no_bib_disponible_basica) AS no_bib_disp
FROM reporte_coberturas_carreras_basicas 
GROUP BY reporte_coberturas_carreras_basicas.codigo_carrera, YEAR(reporte_coberturas_carreras_basicas.fecha_medicion);

-- Vista de carreras con bibliografías complementarias declaradas
CREATE OR REPLACE VIEW vw_car_compl_bib_declarada AS
SELECT 
    reporte_coberturas_carreras_complementarias.codigo_carrera AS codigo_carrera,
    YEAR(reporte_coberturas_carreras_complementarias.fecha_medicion) AS anho,
    COUNT(DISTINCT reporte_coberturas_carreras_complementarias.id_bibliografia_declarada) AS no_bib_declaradas
FROM reporte_coberturas_carreras_complementarias 
GROUP BY reporte_coberturas_carreras_complementarias.codigo_carrera, YEAR(reporte_coberturas_carreras_complementarias.fecha_medicion);

-- Vista de carreras con bibliografías complementarias disponibles
CREATE OR REPLACE VIEW vw_car_compl_bib_disponible AS
SELECT 
    reporte_coberturas_carreras_complementarias.codigo_carrera AS codigo_carrera,
    YEAR(reporte_coberturas_carreras_complementarias.fecha_medicion) AS anho,
    SUM(reporte_coberturas_carreras_complementarias.no_bib_disponible_complementaria) AS no_bib_disponible
FROM reporte_coberturas_carreras_complementarias 
GROUP BY reporte_coberturas_carreras_complementarias.codigo_carrera, YEAR(reporte_coberturas_carreras_complementarias.fecha_medicion);

-- Vista de cobertura básica por carrera
CREATE OR REPLACE VIEW vw_car_cobertura_basica AS
SELECT 
    vw_car_basica_bib_declarada.codigo_carrera AS codigo_carrera,
    vw_car_basica_bib_declarada.anho AS anho,
    vw_car_basica_bib_declarada.no_bib_declarada AS no_bib_declarada,
    vw_car_basica_bib_disponible.no_bib_disp AS no_bib_disp,
    ((vw_car_basica_bib_disponible.no_bib_disp / vw_car_basica_bib_declarada.no_bib_declarada) * 100) AS cobertura_basica
FROM vw_car_basica_bib_declarada 
JOIN vw_car_basica_bib_disponible ON vw_car_basica_bib_declarada.codigo_carrera = vw_car_basica_bib_disponible.codigo_carrera AND vw_car_basica_bib_declarada.anho = vw_car_basica_bib_disponible.anho;

-- Vista de cobertura complementaria por carrera
CREATE OR REPLACE VIEW vw_car_cobertura_complementaria AS
SELECT 
    vw_car_compl_bib_declarada.codigo_carrera AS codigo_carrera,
    vw_car_compl_bib_declarada.anho AS anho,
    vw_car_compl_bib_declarada.no_bib_declaradas AS no_bib_declaradas,
    vw_car_compl_bib_disponible.no_bib_disponible AS no_bib_disponible,
    ((vw_car_compl_bib_disponible.no_bib_disponible / vw_car_compl_bib_declarada.no_bib_declaradas) * 100) AS cobertura_complementaria
FROM vw_car_compl_bib_declarada 
JOIN vw_car_compl_bib_disponible ON vw_car_compl_bib_declarada.codigo_carrera = vw_car_compl_bib_disponible.codigo_carrera AND vw_car_compl_bib_declarada.anho = vw_car_compl_bib_disponible.anho;

-- Insertar datos de ejemplo para reportes
INSERT INTO reportes (nombre, descripcion) VALUES 
('Reporte de Coberturas Básicas', 'Reporte de cobertura de bibliografía básica por carrera y asignatura'),
('Reporte de Coberturas Complementarias', 'Reporte de cobertura de bibliografía complementaria por carrera y asignatura');

-- =====================================================
-- TABLAS DE COMPATIBILIDAD (ESTRUCTURA ANTERIOR)
-- =====================================================

-- Tabla de tipos de asignaturas (para compatibilidad)
CREATE TABLE IF NOT EXISTS tipos_asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de relación carrera-asignatura (para compatibilidad)
CREATE TABLE IF NOT EXISTS carrera_asignatura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera_id INT NOT NULL,
    asignatura_codigo VARCHAR(20) NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    UNIQUE KEY unique_carrera_asignatura (carrera_id, asignatura_codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar tipos de asignaturas básicos
INSERT INTO tipos_asignaturas (nombre, descripcion) VALUES 
('REGULAR', 'Asignatura regular del plan de estudios'),
('FORMACION_BASICA', 'Asignatura de formación básica'),
('FORMACION_GENERAL', 'Asignatura de formación general'),
('FORMACION_IDIOMAS', 'Asignatura de formación en idiomas'),
('FORMACION_PROFESIONAL', 'Asignatura de formación profesional'),
('FORMACION_VALORES', 'Asignatura de formación en valores'),
('FORMACION_ESPECIALIDAD', 'Asignatura de formación en especialidad'),
('FORMACION_ELECTIVA', 'Asignatura de formación electiva'),
('FORMACION_ESPECIAL', 'Asignatura de formación especial');

-- Insertar algunas relaciones carrera-asignatura de ejemplo
INSERT INTO carrera_asignatura (carrera_id, asignatura_codigo) VALUES 
(1, 'PROG-00123'),
(1, 'PROG-00124'),
(1, 'BD-00123'),
(2, 'PROG-00123'),
(2, 'BD-00123'); 

-- Tabla para almacenar filtros de formación por carrera
CREATE TABLE IF NOT EXISTS filtros_formaciones (
    codigo_carrera VARCHAR(20) NOT NULL,
    basica INT NOT NULL DEFAULT 0,
    general INT NOT NULL DEFAULT 0,
    idioma INT NOT NULL DEFAULT 0,
    profesional INT NOT NULL DEFAULT 0,
    valores INT NOT NULL DEFAULT 0,
    especialidad INT NOT NULL DEFAULT 0,
    especial INT NOT NULL DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (codigo_carrera),
    FOREIGN KEY (codigo_carrera) REFERENCES carreras_espejos(codigo_carrera) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 