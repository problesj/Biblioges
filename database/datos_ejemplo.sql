-- =====================================================
-- DATOS DE EJEMPLO BIBLIOGES (solo desarrollo y pruebas)
-- =====================================================
-- NO cargar en producción.
-- Requiere haber cargado antes database/schema.sql en una base vacía:
-- los identificadores asumen autoincrementos que comienzan en 1.
-- Los usuarios de ejemplo tienen una contraseña de prueba conocida:
-- cámbiela o elimine esos usuarios antes de exponer el sistema.
-- =====================================================

SET NAMES utf8mb4;

INSERT INTO sedes (codigo, nombre) VALUES
('SEDE1', 'Sede Central'),
('SEDE2', 'Sede Norte'),
('SEDE3', 'Sede Sur');

INSERT INTO unidades (codigo, nombre, sede_id, id_unidad_padre) VALUES
('105', 'Departamento de Ingeniería', 1, NULL),
('106', 'Departamento de Informática', 1, NULL),
('107', 'Departamento de Matemática', 1, NULL),
('108', 'Departamento de Inglés', 1, NULL),
('109', 'Departamento de Ética Profesional', 1, NULL);

INSERT INTO carreras (nombre, tipo_programa, estado) VALUES
('Ingeniería en Sistemas', 'P', 1),
('Licenciatura en Informática', 'P', 1),
('Tecnicatura en Programación', 'P', 1);

-- Planes de estudio (código de carrera por sede)
INSERT INTO carreras_espejos (carrera_id, codigo_carrera, vigencia_desde, vigencia_hasta, sede_id, id_unidad, estado) VALUES
(1, '8001', '202010', '999999', 1, 1, 1),
(2, '8002', '202010', '999999', 1, 2, 1),
(3, '8003', '202010', '999999', 2, 2, 1);

INSERT INTO asignaturas (nombre, tipo, vigencia_desde, vigencia_hasta, periodicidad) VALUES
-- Asignaturas regulares y de formación
('Programación I', 'FORMACION_PROFESIONAL', '201910', '999999', 'semestral'),
('Base de Datos', 'FORMACION_PROFESIONAL', '201910', '999999', 'semestral'),
('Matemática I', 'REGULAR', '201910', '999999', 'anual'),
('Inglés I', 'FORMACION_IDIOMAS', '201910', '999999', 'semestral'),
('Ética Profesional', 'FORMACION_VALORES', '201910', '999999', 'semestral'),
-- Asignaturas de formación electiva (agrupan a otras)
('Formación Básica en Programación', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral'),
('Formación General en Idiomas', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral'),
('Formación en Valores', 'FORMACION_ELECTIVA', '201910', '999999', 'semestral');

INSERT INTO asignaturas_departamentos (asignatura_id, id_unidad, cantidad_alumnos, codigo_asignatura) VALUES
(1, 1, 50, 'PROG-00123'),
(1, 2, 30, 'PROG-00124'),
(2, 1, 45, 'BD-00123'),
(3, 3, 60, 'MAT-00123'),
(4, 4, 40, 'ING-00123'),
(5, 5, 40, 'ETI-00123'),
(6, 2, 0, 'FBP-00100'),
(7, 4, 0, 'FGI-00100'),
(8, 5, 0, 'FVA-00100');

INSERT INTO usuarios (rut, nombre, email, password, rol) VALUES
('12345678-9', 'Administrador del Sistema', 'admin@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('23456789-0', 'Administrador Biblioteca', 'admin_bidoc@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_bidoc'),
('34567890-1', 'Usuario Ejemplo', 'usuario@biblioges.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario');

INSERT INTO autores (apellidos, nombres, genero) VALUES
('Pérez', 'Juan', 'Masculino'),
('García', 'María', 'Femenino'),
('López', 'Carlos', 'Masculino');

INSERT INTO bibliografias_declaradas (titulo, tipo, anio_publicacion, editorial, edicion, formato) VALUES
('Introducción a la Programación', 'libro', 2020, 'Editorial ABC', '1ra Edición', 'impreso'),
('Base de Datos Relacionales', 'libro', 2019, 'Editorial XYZ', '2da Edición', 'ambos'),
('Investigación en IA', 'articulo', 2021, 'Revista Científica', 'Vol. 5', 'impreso'),
('Tesis de Grado', 'tesis', 2022, NULL, NULL, 'impreso'),
('Sistema de Gestión', 'software', 2023, NULL, NULL, 'electronico'),
('Portal Educativo', 'sitio_web', 2023, NULL, NULL, 'electronico'),
('Documento Técnico', 'generico', 2023, NULL, NULL, 'impreso');

INSERT INTO libros (bibliografia_id, isbn) VALUES
(1, '9781234567890'),
(2, '9780987654321');

INSERT INTO articulos (bibliografia_id, issn, titulo_revista, cronologia) VALUES
(3, '1234-5678', 'Revista de Ciencias de la Computación', 'Vol. 5, No. 2, 2021');

INSERT INTO tesis (bibliografia_id, nombre_carrera) VALUES
(4, 'Ingeniería en Sistemas');

INSERT INTO software (bibliografia_id, version) VALUES
(5, '1.0.0');

INSERT INTO sitios_web (bibliografia_id, fecha_consulta) VALUES
(6, '2023-12-01');

INSERT INTO genericos (bibliografia_id, descripcion) VALUES
(7, 'Documento técnico sobre metodologías de desarrollo');

INSERT INTO bibliografias_autores (bibliografia_id, autor_id) VALUES
(1, 1),
(2, 2);

-- Formación electiva -> asignaturas que la componen
INSERT INTO asignaturas_formacion (asignatura_formacion_id, asignatura_regular_id) VALUES
(6, 1),
(6, 2),
(7, 4),
(8, 5);

-- Mallas curriculares (carrera, asignatura, semestre)
INSERT INTO mallas (carrera_id, asignatura_id, semestre) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 1),
(1, 4, 1),
(1, 5, 3);

INSERT INTO asignaturas_bibliografias (asignatura_id, bibliografia_id, tipo_bibliografia, estado) VALUES
(1, 1, 'basica', 'activa'),
(1, 2, 'complementaria', 'activa'),
(2, 2, 'basica', 'activa'),
(3, 3, 'complementaria', 'activa');

INSERT INTO bibliografias_disponibles (bibliografia_declarada_id, titulo, anio_edicion, editorial, url_acceso, url_catalogo, disponibilidad, id_mms, ejemplares_digitales) VALUES
(1, 'Introducción a la Programación - Edición 2020', 2020, 'Editorial ABC', NULL, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS001', NULL),
(1, 'Introducción a la Programación - Edición Digital', 2020, 'Editorial ABC', 'https://ejemplo.com/libro1', NULL, 'electronico', NULL, 0),
(2, 'Base de Datos Relacionales - Edición 2019', 2019, 'Editorial XYZ', NULL, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS003', NULL),
(2, 'Base de Datos Relacionales - Edición Digital', 2019, 'Editorial XYZ', 'https://ejemplo.com/libro2', NULL, 'electronico', NULL, 0),
(3, 'Investigación en IA - Revista Vol. 5', 2021, 'Revista Científica', NULL, 'https://ucn.primo.exlibrisgroup.com/permalink/56UCN_INST/ia6i7p/alma990000172070107936', 'impreso', 'MMS004', NULL),
(3, 'Investigación en IA - Revista Vol. 5', 2021, 'Revista Científica', 'https://ejemplo.com/articulo1', NULL, 'electronico', NULL, 0);

-- Ejemplares impresos por sede
INSERT INTO bibliografias_disponibles_sedes (bibliografia_disponible_id, sede_id, ejemplares) VALUES
(1, 1, 5),
(3, 1, 3),
(1, 2, 3),
(3, 2, 2),
(1, 3, 4),
(3, 3, 3);
