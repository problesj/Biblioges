-- API de consulta v1: API keys y bitácora de uso
-- Aplicar ANTES de desplegar el código de la API (desarrollo y producción).
-- Uso: mysql -u <usuario_admin> -p bibliografia < database/2026-11-api-keys.sql

-- API keys para sistemas externos. La key nunca se guarda: solo su SHA-256 y un prefijo visible.
CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sistema o integración que usa la key',
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefijo` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Inicio visible de la key, para identificarla',
  `hash_key` char(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SHA-256 de la key completa',
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

-- Una fila por llamada autenticada a la API (también las rechazadas por límite). Sirve para el límite por minuto.
CREATE TABLE IF NOT EXISTS `api_keys_bitacora` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `api_key_id` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `metodo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parametros` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_http` smallint NOT NULL,
  `duracion_ms` int DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_api_bitacora_key_fecha` (`api_key_id`,`fecha`),
  CONSTRAINT `fk_api_bitacora_key` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
