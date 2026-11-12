-- =====================================================
-- ESQUEMA DE BASE DE DATOS BIBLIOGES
-- =====================================================
-- Generado a partir de la estructura en uso (2026-11-12, MySQL 8.0.46-0ubuntu0.24.04.4).
-- Instalación nueva (base de datos vacía):
--   mysql -u <usuario> -p <base_de_datos> < database/schema.sql
-- Datos de ejemplo, solo para desarrollo/pruebas (NO en producción):
--   mysql -u <usuario> -p <base_de_datos> < database/datos_ejemplo.sql
-- Para actualizar una base existente use los scripts de migración database/AAAA-MM-*.sql.
-- Secciones: 1) Tablas  2) Vistas  3) Triggers  4) Datos requeridos
-- =====================================================

SET NAMES utf8mb4;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- SECCIÓN 1: TABLAS
-- =====================================================

-- Sedes de la universidad
CREATE TABLE IF NOT EXISTS `sedes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Unidades académicas (departamentos) por sede
CREATE TABLE IF NOT EXISTS `unidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sede_id` int NOT NULL,
  `id_unidad_padre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `unidades_ibfk_1` (`sede_id`),
  CONSTRAINT `unidades_ibfk_1` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Carreras
CREATE TABLE IF NOT EXISTS `carreras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_programa` enum('P','G','O') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_semestres` int DEFAULT '10',
  `estado` tinyint(1) DEFAULT '1',
  `url_libro` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Planes de estudio de cada carrera por sede (código y vigencia)
CREATE TABLE IF NOT EXISTS `carreras_espejos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `carrera_id` int NOT NULL,
  `codigo_carrera` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vigencia_desde` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vigencia_hasta` char(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '999999',
  `sede_id` int NOT NULL,
  `id_unidad` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`codigo_carrera`,`carrera_id`,`sede_id`),
  UNIQUE KEY `unique_carrera_espejo` (`carrera_id`,`codigo_carrera`,`sede_id`),
  KEY `idx_id_unidad` (`id_unidad`),
  KEY `carreras_espejos_ibfk_3` (`sede_id`),
  CONSTRAINT `carreras_espejos_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carreras_espejos_ibfk_3` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_carreras_espejos_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Asignaturas
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('REGULAR','FORMACION_BASICA','FORMACION_GENERAL','FORMACION_IDIOMAS','FORMACION_PROFESIONAL','FORMACION_VALORES','FORMACION_ESPECIALIDAD','FORMACION_ELECTIVA','FORMACION_ESPECIAL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `vigencia_desde` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Formato: AAAA-SS (Año-Secuencia)',
  `vigencia_hasta` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '999999' COMMENT 'Formato: AAAA-SS (Año-Secuencia), 999999 indica vigencia actual',
  `estado` tinyint(1) DEFAULT '1',
  `periodicidad` enum('anual','semestral') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_programa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_vigencia_formato` CHECK ((regexp_like(`vigencia_desde`,_utf8mb4'^[0-9]{6}$') and regexp_like(`vigencia_hasta`,_utf8mb4'^[0-9]{6}$') and ((`vigencia_hasta` = _utf8mb4'999999') or (`vigencia_hasta` > `vigencia_desde`))))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Relación asignatura de formación electiva -> asignaturas que la componen
CREATE TABLE IF NOT EXISTS `asignaturas_formacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asignatura_formacion_id` int NOT NULL COMMENT 'ID de la asignatura de formación (padre)',
  `asignatura_regular_id` int NOT NULL COMMENT 'ID de la asignatura formacion (hijo)',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_formacion_regular` (`asignatura_formacion_id`,`asignatura_regular_id`),
  KEY `asignaturas_formacion_ibfk_2` (`asignatura_regular_id`),
  CONSTRAINT `asignaturas_formacion_ibfk_1` FOREIGN KEY (`asignatura_formacion_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignaturas_formacion_ibfk_2` FOREIGN KEY (`asignatura_regular_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Mallas curriculares (asignaturas por carrera y semestre)
CREATE TABLE IF NOT EXISTS `mallas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `carrera_id` int NOT NULL,
  `asignatura_id` int NOT NULL,
  `semestre` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_carrera_asignatura_semestre` (`carrera_id`,`asignatura_id`,`semestre`),
  KEY `mallas_ibfk_2` (`asignatura_id`),
  CONSTRAINT `FK_mallas_asignaturas_id` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`),
  CONSTRAINT `mallas_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mallas_ibfk_2` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Códigos de asignatura por unidad
CREATE TABLE IF NOT EXISTS `asignaturas_departamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asignatura_id` int NOT NULL,
  `codigo_asignatura` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_alumnos` int NOT NULL DEFAULT '0',
  `id_unidad` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_asignatura` (`codigo_asignatura`),
  UNIQUE KEY `unique_asignatura_unidad_codigo` (`asignatura_id`,`id_unidad`,`codigo_asignatura`),
  KEY `idx_id_unidad` (`id_unidad`),
  CONSTRAINT `FK_asignaturas_departamentos_asignaturas_id` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`),
  CONSTRAINT `fk_asignaturas_departamentos_unidad` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Usuarios del sistema
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rut` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','admin_bidoc','usuario') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Autores
CREATE TABLE IF NOT EXISTS `autores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `apellidos` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('Femenino','Masculino','Otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Variaciones de nombre de autores
CREATE TABLE IF NOT EXISTS `alias_autores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor_id` int NOT NULL,
  `nombre_variacion` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_alias_autores_autores_id` (`autor_id`),
  CONSTRAINT `FK_alias_autores_autores_id` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Bibliografías declaradas en los programas
CREATE TABLE IF NOT EXISTS `bibliografias_declaradas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('libro','articulo','tesis','software','sitio_web','otro','generico') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio_publicacion` int DEFAULT NULL,
  `editorial` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edicion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `formato` enum('impreso','electronico','ambos') COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asignatura_id` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `asignatura_id` (`asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías tipo libro
CREATE TABLE IF NOT EXISTS `libros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_libro` (`bibliografia_id`),
  CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías tipo artículo
CREATE TABLE IF NOT EXISTS `articulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `issn` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo_revista` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cronologia` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_articulo` (`bibliografia_id`),
  CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías tipo tesis
CREATE TABLE IF NOT EXISTS `tesis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `nombre_carrera` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_tesis` (`bibliografia_id`),
  CONSTRAINT `tesis_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías tipo software
CREATE TABLE IF NOT EXISTS `software` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_software` (`bibliografia_id`),
  CONSTRAINT `software_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías tipo sitio web
CREATE TABLE IF NOT EXISTS `sitios_web` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `fecha_consulta` date NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_sitio` (`bibliografia_id`),
  CONSTRAINT `sitios_web_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Detalle de bibliografías genéricas
CREATE TABLE IF NOT EXISTS `genericos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_generico` (`bibliografia_id`),
  CONSTRAINT `genericos_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Autores de cada bibliografía declarada
CREATE TABLE IF NOT EXISTS `bibliografias_autores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_id` int NOT NULL,
  `autor_id` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_autor` (`bibliografia_id`,`autor_id`),
  KEY `bibliografias_autores_ibfk_2` (`autor_id`),
  CONSTRAINT `bibliografias_autores_ibfk_1` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bibliografias_autores_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Bibliografías (básica/complementaria) de cada asignatura
CREATE TABLE IF NOT EXISTS `asignaturas_bibliografias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asignatura_id` int NOT NULL,
  `bibliografia_id` int NOT NULL,
  `tipo_bibliografia` enum('basica','complementaria','otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activa','no_activa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activa',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_asignatura_bibliografia` (`asignatura_id`,`bibliografia_id`),
  KEY `asignaturas_bibliografias_ibfk_2` (`bibliografia_id`),
  CONSTRAINT `asignaturas_bibliografias_ibfk_1` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignaturas_bibliografias_ibfk_2` FOREIGN KEY (`bibliografia_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Bibliografías disponibles en biblioteca (impresas/electrónicas)
CREATE TABLE IF NOT EXISTS `bibliografias_disponibles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_declarada_id` int DEFAULT NULL,
  `titulo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anio_edicion` int NOT NULL,
  `editorial` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_acceso` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_catalogo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disponibilidad` enum('impreso','electronico','ambos') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_mms` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ejemplares_digitales` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_mms` (`id_mms`),
  KEY `bibliografias_disponibles_ibfk_1` (`bibliografia_declarada_id`),
  CONSTRAINT `bibliografias_disponibles_ibfk_1` FOREIGN KEY (`bibliografia_declarada_id`) REFERENCES `bibliografias_declaradas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Ejemplares impresos disponibles por sede
CREATE TABLE IF NOT EXISTS `bibliografias_disponibles_sedes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_disponible_id` int NOT NULL,
  `sede_id` int NOT NULL,
  `ejemplares` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_sede` (`bibliografia_disponible_id`,`sede_id`),
  KEY `bibliografias_disponibles_sedes_ibfk_2` (`sede_id`),
  CONSTRAINT `bibliografias_disponibles_sedes_ibfk_1` FOREIGN KEY (`bibliografia_disponible_id`) REFERENCES `bibliografias_disponibles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bibliografias_disponibles_sedes_ibfk_2` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Autores de cada bibliografía disponible
CREATE TABLE IF NOT EXISTS `bibliografias_disponibles_autores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliografia_disponible_id` int NOT NULL,
  `autor_id` int NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_bibliografia_autor` (`bibliografia_disponible_id`,`autor_id`),
  KEY `fk_bda_autor` (`autor_id`),
  CONSTRAINT `fk_bda_autor` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bda_bibliografia` FOREIGN KEY (`bibliografia_disponible_id`) REFERENCES `bibliografias_disponibles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Catálogo de reportes (requerido por el guardado de coberturas)
CREATE TABLE IF NOT EXISTS `reportes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Mediciones guardadas de cobertura básica por plan
CREATE TABLE IF NOT EXISTS `reporte_coberturas_carreras_basicas` (
  `id_reporte` int NOT NULL,
  `codigo_carrera` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_carrera_espejo` int DEFAULT NULL,
  `codigo_asignatura` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bibliografia_declarada` int NOT NULL,
  `fecha_medicion` datetime NOT NULL,
  `no_ejem_imp` int DEFAULT NULL,
  `no_ejem_dig` int DEFAULT NULL,
  `no_bib_disponible_basica` int DEFAULT NULL,
  PRIMARY KEY (`id_reporte`,`fecha_medicion`,`codigo_carrera`,`codigo_asignatura`,`id_bibliografia_declarada`),
  KEY `FK_coberturas_carreras_basicas_asig_depto_codigo_asig` (`codigo_asignatura`),
  KEY `idx_id_carrera_espejo_basica` (`id_carrera_espejo`),
  KEY `idx_plan_anio_basica` (`id_carrera_espejo`,`fecha_medicion`),
  CONSTRAINT `FK_coberturas_carreras_basicas_reportes_id` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Mediciones guardadas de cobertura complementaria por plan
CREATE TABLE IF NOT EXISTS `reporte_coberturas_carreras_complementarias` (
  `id_reporte` int NOT NULL,
  `codigo_carrera` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_carrera_espejo` int DEFAULT NULL,
  `codigo_asignatura` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bibliografia_declarada` int NOT NULL,
  `fecha_medicion` datetime NOT NULL,
  `no_ejem_imp` int DEFAULT NULL,
  `no_ejem_dig` int DEFAULT NULL,
  `no_bib_disponible_complementaria` int DEFAULT NULL,
  PRIMARY KEY (`id_reporte`,`fecha_medicion`,`codigo_carrera`,`codigo_asignatura`,`id_bibliografia_declarada`),
  KEY `FK_coberturas_carreras_basicas_asig_depto_codigo_asig` (`codigo_asignatura`),
  KEY `idx_id_carrera_espejo_compl` (`id_carrera_espejo`),
  KEY `idx_plan_anio_compl` (`id_carrera_espejo`,`fecha_medicion`),
  CONSTRAINT `FK_reporte_coberturas_carreras_complementarias_reportes_id` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Coberturas por asignatura
CREATE TABLE IF NOT EXISTS `coberturas_asignaturas` (
  `id` int NOT NULL,
  `id_reporte` int NOT NULL,
  `codigo_asignatura` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_medicion` datetime NOT NULL,
  `cobertura_basica` int DEFAULT NULL,
  `cobertura_complementaria` int DEFAULT NULL,
  PRIMARY KEY (`fecha_medicion`,`id_reporte`,`codigo_asignatura`,`id`),
  KEY `FK_coberturas_asig_asig_depto_codigo_asignatura` (`codigo_asignatura`),
  KEY `FK_coberturas_asignaturas_reportes_id` (`id_reporte`),
  CONSTRAINT `FK_coberturas_asignaturas_reportes_id` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Filtros de tipos de formación guardados por plan
CREATE TABLE IF NOT EXISTS `filtros_formaciones` (
  `id_carrera_espejo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basica` int NOT NULL,
  `general` int NOT NULL,
  `idioma` int NOT NULL,
  `profesional` int NOT NULL,
  `valores` int NOT NULL,
  `especialidad` int NOT NULL,
  `especial` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Tareas programadas de reportes (únicas o recurrentes)
CREATE TABLE IF NOT EXISTS `tareas_programadas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_notificacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Correo que recibe un aviso tras cada ejecución; NULL = sin aviso',
  `tipo_reporte` enum('cobertura_basica_expandido','cobertura_complementaria_expandido','cobertura_ambas_expandido','actualizar_copias_alma') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sede_id` int DEFAULT NULL,
  `carrera_id` int DEFAULT NULL,
  `fecha_programada` datetime NOT NULL,
  `frecuencia` enum('unica','diaria','semanal','mensual','anual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unica',
  `dias_semana` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Solo frecuencia semanal: días ISO (1 = lunes ... 7 = domingo) separados por coma',
  `simulacion` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = calcula y reporta sin modificar datos',
  `accion_sin_copias` enum('eliminar','mantener') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mantener' COMMENT 'Bibliografias impresas sin copias ni acceso electronico',
  `fecha_inicio` datetime DEFAULT NULL COMMENT 'Primera ejecución; base para calcular las repeticiones',
  `fecha_fin` datetime DEFAULT NULL,
  `estado` enum('pendiente','en_proceso','completada','error','cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `filtros_formacion` json DEFAULT NULL,
  `resultado` text COLLATE utf8mb4_unicode_ci,
  `error_mensaje` text COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_ejecucion` timestamp NULL DEFAULT NULL,
  `ultima_ejecucion` datetime DEFAULT NULL,
  `progreso_actual` int DEFAULT NULL,
  `progreso_total` int DEFAULT NULL,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creado_por` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_programada` (`fecha_programada`),
  KEY `idx_sede_carrera` (`sede_id`,`carrera_id`),
  KEY `idx_tipo_reporte` (`tipo_reporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Historial de ejecuciones de las tareas programadas
CREATE TABLE IF NOT EXISTS `tareas_programadas_ejecuciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tarea_id` int NOT NULL,
  `tipo_reporte` enum('basica','complementaria','copias_alma') COLLATE utf8mb4_unicode_ci NOT NULL,
  `manual` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = lanzada con Ejecutar ahora',
  `simulacion` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `estado` enum('completada','error','detenida') COLLATE utf8mb4_unicode_ci NOT NULL,
  `registros` int DEFAULT NULL,
  `resumen` json DEFAULT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `idx_tarea` (`tarea_id`,`fecha_inicio`),
  CONSTRAINT `fk_ejec_tarea` FOREIGN KEY (`tarea_id`) REFERENCES `tareas_programadas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Tabla api_keys
CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sistema o integración que usa la key',
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefijo` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Inicio visible de la key, para identificarla',
  `hash_key` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SHA-256 de la key completa',
  `limite_por_minuto` int NOT NULL DEFAULT '60' COMMENT 'Solicitudes permitidas por minuto',
  `fecha_expiracion` date DEFAULT NULL COMMENT 'Último día válido; NULL = no expira',
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = activa, 0 = revocada',
  `creado_por` int DEFAULT NULL,
  `revocado_por` int DEFAULT NULL,
  `fecha_revocacion` datetime DEFAULT NULL,
  `ultimo_uso` datetime DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_api_keys_hash` (`hash_key`),
  KEY `fk_api_keys_creado_por` (`creado_por`),
  KEY `fk_api_keys_revocado_por` (`revocado_por`),
  CONSTRAINT `fk_api_keys_creado_por` FOREIGN KEY (`creado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_api_keys_revocado_por` FOREIGN KEY (`revocado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla api_keys_bitacora
CREATE TABLE IF NOT EXISTS `api_keys_bitacora` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `api_key_id` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `metodo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parametros` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_http` smallint NOT NULL,
  `duracion_ms` int DEFAULT NULL,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_api_bitacora_key_fecha` (`api_key_id`,`fecha`),
  CONSTRAINT `fk_api_bitacora_key` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla bibliografias_declaradas_historial
CREATE TABLE IF NOT EXISTS `bibliografias_declaradas_historial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accion` enum('fusion','eliminacion') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bibliografia_id` int NOT NULL COMMENT 'Declarada eliminada',
  `bibliografia_destino_id` int DEFAULT NULL COMMENT 'Declarada que se mantuvo, si fue una fusión',
  `usuario_id` int DEFAULT NULL,
  `copia` json NOT NULL COMMENT 'Declarada, detalle, autores, asignaturas y disponibles antes del cambio',
  `resumen` json DEFAULT NULL COMMENT 'Asignaturas y disponibles traspasadas, tipos ajustados y disponibles eliminadas',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_bibliografia` (`bibliografia_id`),
  KEY `idx_destino` (`bibliografia_destino_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Tabla tareas_alma_detalle
CREATE TABLE IF NOT EXISTS `tareas_alma_detalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ejecucion_id` int NOT NULL,
  `accion` enum('actualizada','mms_corregido','mms_discrepante','a_electronico','eliminada','sin_copias','duplicada','revisar','discrepancia') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bibliografia_disponible_id` int NOT NULL,
  `bibliografia_declarada_id` int DEFAULT NULL,
  `titulo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anio_edicion` int DEFAULT NULL,
  `id_mms` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mms_nuevo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copias_antes` json DEFAULT NULL COMMENT 'Ejemplares por sede antes del cambio',
  `copias_despues` json DEFAULT NULL COMMENT 'Ejemplares por sede después del cambio',
  `copia_fila` json DEFAULT NULL COMMENT 'Copia completa de la fila eliminada, con sus sedes y autores',
  `declarada_sin_disponibles` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = la declarada quedó sin disponibles activas',
  `mensaje` text COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_disponible` (`bibliografia_disponible_id`),
  KEY `idx_ejecucion_accion` (`ejecucion_id`,`accion`),
  CONSTRAINT `fk_tareas_alma_detalle_ejecucion` FOREIGN KEY (`ejecucion_id`) REFERENCES `tareas_programadas_ejecuciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- =====================================================
-- SECCIÓN 2: VISTAS
-- =====================================================

-- Vista vw_asig_bib_declarada
CREATE OR REPLACE VIEW `vw_asig_bib_declarada` AS select `asignaturas`.`id` AS `id_asignatura`,`asignaturas_bibliografias`.`bibliografia_id` AS `id_bib_declarada`,`asignaturas_bibliografias`.`tipo_bibliografia` AS `tipo_bibliografia`,`bibliografias_declaradas`.`titulo` AS `titulo`,`bibliografias_declaradas`.`tipo` AS `tipo`,`bibliografias_declaradas`.`anio_publicacion` AS `anio_publicacion`,`bibliografias_declaradas`.`editorial` AS `editorial`,`bibliografias_declaradas`.`formato` AS `formato` from ((`asignaturas_bibliografias` join `asignaturas` on((`asignaturas_bibliografias`.`asignatura_id` = `asignaturas`.`id`))) join `bibliografias_declaradas` on((`asignaturas_bibliografias`.`bibliografia_id` = `bibliografias_declaradas`.`id`))) order by `asignaturas`.`id`,`asignaturas_bibliografias`.`tipo_bibliografia`,`bibliografias_declaradas`.`titulo`;

-- Vista vw_bib_declarada_sede_noejem
CREATE OR REPLACE VIEW `vw_bib_declarada_sede_noejem` AS select `bibliografias_declaradas`.`id` AS `id_bib_declarada`,`bibliografias_disponibles_sedes`.`sede_id` AS `id_sede`,sum(`bibliografias_disponibles_sedes`.`ejemplares`) AS `no_ejem_imp_sede` from ((`bibliografias_disponibles_sedes` join `bibliografias_disponibles` on((`bibliografias_disponibles_sedes`.`bibliografia_disponible_id` = `bibliografias_disponibles`.`id`))) join `bibliografias_declaradas` on((`bibliografias_disponibles`.`bibliografia_declarada_id` = `bibliografias_declaradas`.`id`))) where (`bibliografias_disponibles`.`disponibilidad` in ('impreso','ambos')) group by `bibliografias_disponibles_sedes`.`sede_id`,`bibliografias_declaradas`.`id` order by `id_bib_declarada`,`id_sede`;

-- Vista vw_car_basica_bib_declarada
CREATE OR REPLACE VIEW `vw_car_basica_bib_declarada` AS select `rb`.`id_carrera_espejo` AS `id_carrera_espejo`,`rb`.`codigo_carrera` AS `codigo_carrera`,year(`rb`.`fecha_medicion`) AS `anho`,count(distinct `rb`.`id_bibliografia_declarada`) AS `no_bib_declarada` from `reporte_coberturas_carreras_basicas` `rb` group by `rb`.`id_carrera_espejo`,`rb`.`codigo_carrera`,year(`rb`.`fecha_medicion`);

-- Vista vw_car_basica_bib_disponible
CREATE OR REPLACE VIEW `vw_car_basica_bib_disponible` AS select `rb`.`id_carrera_espejo` AS `id_carrera_espejo`,`rb`.`codigo_carrera` AS `codigo_carrera`,year(`rb`.`fecha_medicion`) AS `anho`,sum(`rb`.`no_bib_disponible_basica`) AS `no_bib_disp` from `reporte_coberturas_carreras_basicas` `rb` group by `rb`.`id_carrera_espejo`,`rb`.`codigo_carrera`,year(`rb`.`fecha_medicion`);

-- Vista vw_car_cobertura_basica
CREATE OR REPLACE VIEW `vw_car_cobertura_basica` AS select `d`.`id_carrera_espejo` AS `id_carrera_espejo`,`d`.`codigo_carrera` AS `codigo_carrera`,`d`.`anho` AS `anho`,`d`.`no_bib_declarada` AS `no_bib_declarada`,`s`.`no_bib_disp` AS `no_bib_disp`,((`s`.`no_bib_disp` / nullif(`d`.`no_bib_declarada`,0)) * 100) AS `cobertura_basica` from (`vw_car_basica_bib_declarada` `d` join `vw_car_basica_bib_disponible` `s` on(((`d`.`codigo_carrera` = `s`.`codigo_carrera`) and (`d`.`anho` = `s`.`anho`) and (`d`.`id_carrera_espejo` <=> `s`.`id_carrera_espejo`))));

-- Vista vw_car_compl_bib_declarada
CREATE OR REPLACE VIEW `vw_car_compl_bib_declarada` AS select `rc`.`id_carrera_espejo` AS `id_carrera_espejo`,`rc`.`codigo_carrera` AS `codigo_carrera`,year(`rc`.`fecha_medicion`) AS `anho`,count(distinct `rc`.`id_bibliografia_declarada`) AS `no_bib_declaradas` from `reporte_coberturas_carreras_complementarias` `rc` group by `rc`.`id_carrera_espejo`,`rc`.`codigo_carrera`,year(`rc`.`fecha_medicion`);

-- Vista vw_car_compl_bib_disponible
CREATE OR REPLACE VIEW `vw_car_compl_bib_disponible` AS select `rc`.`id_carrera_espejo` AS `id_carrera_espejo`,`rc`.`codigo_carrera` AS `codigo_carrera`,year(`rc`.`fecha_medicion`) AS `anho`,sum(`rc`.`no_bib_disponible_complementaria`) AS `no_bib_disponible` from `reporte_coberturas_carreras_complementarias` `rc` group by `rc`.`id_carrera_espejo`,`rc`.`codigo_carrera`,year(`rc`.`fecha_medicion`);

-- Vista vw_car_cobertura_complementaria
CREATE OR REPLACE VIEW `vw_car_cobertura_complementaria` AS select `d`.`id_carrera_espejo` AS `id_carrera_espejo`,`d`.`codigo_carrera` AS `codigo_carrera`,`d`.`anho` AS `anho`,`d`.`no_bib_declaradas` AS `no_bib_declaradas`,`s`.`no_bib_disponible` AS `no_bib_disponible`,((`s`.`no_bib_disponible` / nullif(`d`.`no_bib_declaradas`,0)) * 100) AS `cobertura_complementaria` from (`vw_car_compl_bib_declarada` `d` join `vw_car_compl_bib_disponible` `s` on(((`d`.`codigo_carrera` = `s`.`codigo_carrera`) and (`d`.`anho` = `s`.`anho`) and (`d`.`id_carrera_espejo` <=> `s`.`id_carrera_espejo`))));

-- Vista vw_mallas
CREATE OR REPLACE VIEW `vw_mallas` AS select `sedes`.`id` AS `id_sede`,`sedes`.`nombre` AS `sede`,`unidades`.`id` AS `id_unidad`,`unidades`.`nombre` AS `unidad`,`carreras_espejos`.`codigo_carrera` AS `codigo_carrera`,`carreras`.`id` AS `id_carrera`,`carreras`.`nombre` AS `carrera`,`asignaturas_departamentos`.`codigo_asignatura` AS `codigo_asignatura`,`asignaturas`.`id` AS `id_asignatura`,`asignaturas`.`nombre` AS `asignatura`,`asignaturas`.`tipo` AS `tipo_asignatura`,NULL AS `codigo_asignatura_formacion`,NULL AS `id_asignatura_formacion`,NULL AS `asignatura_formacion` from ((((((`mallas` join `asignaturas` on((`mallas`.`asignatura_id` = `asignaturas`.`id`))) join `carreras_espejos` on((`mallas`.`carrera_id` = `carreras_espejos`.`carrera_id`))) join `carreras` on((`mallas`.`carrera_id` = `carreras`.`id`))) join `asignaturas_departamentos` on((`asignaturas_departamentos`.`asignatura_id` = `asignaturas`.`id`))) join `sedes` on((`carreras_espejos`.`sede_id` = `sedes`.`id`))) join `unidades` on(((`asignaturas_departamentos`.`id_unidad` = `unidades`.`id`) and (`unidades`.`sede_id` = `sedes`.`id`)))) union select `sedes`.`id` AS `id_sede`,`sedes`.`nombre` AS `sede`,`unidades`.`id` AS `id_unidad`,`unidades`.`nombre` AS `unidad`,`carreras_espejos`.`codigo_carrera` AS `codigo_carrera`,`carreras_espejos`.`carrera_id` AS `id_carrera`,`carreras`.`nombre` AS `carrera`,`asignaturas_departamentos`.`codigo_asignatura` AS `codigo_asignatura`,`asignaturas_departamentos`.`asignatura_id` AS `id_asignatura`,`asignaturas`.`nombre` AS `asignatura`,`asignaturas_1`.`tipo` AS `tipo_asignatura`,`asignaturas_departamentos_1`.`codigo_asignatura` AS `codigo_asignatura_formacion`,`asignaturas_1`.`id` AS `id_asignatura_formacion`,`asignaturas_1`.`nombre` AS `asignatura_formacion` from (((((((((`unidades` join `sedes` on((`unidades`.`sede_id` = `sedes`.`id`))) join `asignaturas_departamentos`) join `asignaturas` on((`asignaturas`.`id` = `asignaturas_departamentos`.`asignatura_id`))) join `asignaturas_formacion` on((`asignaturas_formacion`.`asignatura_formacion_id` = `asignaturas`.`id`))) join `asignaturas_departamentos` `asignaturas_departamentos_1` on(((`asignaturas_formacion`.`asignatura_regular_id` = `asignaturas_departamentos_1`.`asignatura_id`) and (`asignaturas_departamentos_1`.`id_unidad` = `unidades`.`id`)))) join `asignaturas` `asignaturas_1` on((`asignaturas_departamentos_1`.`asignatura_id` = `asignaturas_1`.`id`))) join `carreras_espejos`) join `carreras` on(((`carreras_espejos`.`carrera_id` = `carreras`.`id`) and (`carreras_espejos`.`sede_id` = `sedes`.`id`)))) join `mallas` on(((`mallas`.`carrera_id` = `carreras`.`id`) and (`mallas`.`asignatura_id` = `asignaturas_departamentos`.`asignatura_id`)))) order by `codigo_carrera`,`sede`,`asignatura`;

-- =====================================================
-- SECCIÓN 3: TRIGGERS
-- =====================================================

DROP TRIGGER IF EXISTS `before_insert_asignaturas_bibliografias`;
DELIMITER $$
CREATE TRIGGER `before_insert_asignaturas_bibliografias` BEFORE INSERT ON `asignaturas_bibliografias` FOR EACH ROW BEGIN
  DECLARE tipo_asignatura varchar(50);


  SELECT
    tipo INTO tipo_asignatura
  FROM asignaturas
  WHERE id = NEW.asignatura_id;


  IF tipo_asignatura = 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'No se puede vincular bibliografías con asignaturas de tipo FORMACION_ELECTIVA';
  END IF;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS `before_update_asignaturas_bibliografias`;
DELIMITER $$
CREATE TRIGGER `before_update_asignaturas_bibliografias` BEFORE UPDATE ON `asignaturas_bibliografias` FOR EACH ROW BEGIN
  DECLARE tipo_asignatura varchar(50);


  SELECT
    tipo INTO tipo_asignatura
  FROM asignaturas
  WHERE id = NEW.asignatura_id;


  IF tipo_asignatura = 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'No se puede vincular bibliografías con asignaturas de tipo FORMACION_ELECTIVA';
  END IF;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS `before_insert_asignaturas_formacion`;
DELIMITER $$
CREATE TRIGGER `before_insert_asignaturas_formacion` BEFORE INSERT ON `asignaturas_formacion` FOR EACH ROW BEGIN
  DECLARE tipo_formacion varchar(50);
  DECLARE tipo_regular varchar(50);


  SELECT
    tipo INTO tipo_formacion
  FROM asignaturas
  WHERE id = NEW.asignatura_formacion_id;
  SELECT
    tipo INTO tipo_regular
  FROM asignaturas
  WHERE id = NEW.asignatura_regular_id;


  IF tipo_formacion != 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación electiva';
  END IF;

  IF tipo_regular = 'REGULAR'
    || tipo_regular = 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular o formación electiva';
  END IF;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS `before_update_asignaturas_formacion`;
DELIMITER $$
CREATE TRIGGER `before_update_asignaturas_formacion` BEFORE UPDATE ON `asignaturas_formacion` FOR EACH ROW BEGIN
  DECLARE tipo_formacion varchar(50);
  DECLARE tipo_regular varchar(50);


  SELECT
    tipo INTO tipo_formacion
  FROM asignaturas
  WHERE id = NEW.asignatura_formacion_id;
  SELECT
    tipo INTO tipo_regular
  FROM asignaturas
  WHERE id = NEW.asignatura_regular_id;


  IF tipo_formacion != 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'La asignatura padre debe ser de tipo formación electiva';
  END IF;

  IF tipo_regular = 'REGULAR'
    || tipo_regular = 'FORMACION_ELECTIVA' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'La asignatura hijo debe ser distinta de tipo regular o formación electiva';
  END IF;
END$$
DELIMITER ;

-- =====================================================
-- SECCIÓN 4: DATOS REQUERIDOS POR LA APLICACIÓN
-- =====================================================
SET @OLD_SQL_MODE = @@SQL_MODE;
SET SESSION SQL_MODE = CONCAT(@@SQL_MODE, ',NO_AUTO_VALUE_ON_ZERO');

-- Sede especial para registros sin sede
INSERT INTO `sedes` (`id`, `codigo`, `nombre`, `estado`) VALUES
('0', 'S000', 'Sin Sede', '1')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- Unidad especial para registros sin unidad
INSERT INTO `unidades` (`id`, `codigo`, `nombre`, `sede_id`, `id_unidad_padre`, `estado`) VALUES
('0', 'SIN_UNIDAD', 'Sin Unidad', '0', NULL, '1')
ON DUPLICATE KEY UPDATE `id` = `id`;

-- Reportes de cobertura (el guardado de coberturas los busca por nombre)
INSERT INTO `reportes` (`id`, `nombre`, `descripcion`) VALUES
('1', 'Reporte de Coberturas Básicas', 'Este reporte genera un listado de las carreras con las coberuras de bibliografia basica'),
('2', 'Reporte de Coberturas Complementarias', 'Este reporte genera un listado de las carreras con las coberuras de bibliografía complementaria')
ON DUPLICATE KEY UPDATE `id` = `id`;

SET SESSION SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
