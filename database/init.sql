-- =====================================================
-- Instalación de la base de datos de Biblioges con el cliente mysql
-- =====================================================
-- Alternativa a "php database/init_db.php" (que toma los datos de .env).
-- 1. Reemplace CAMBIAR_ESTA_CLAVE por la clave definida en DB_PASSWORD (.env).
--    Si usa otros nombres de base de datos o usuario, ajústelos también aquí.
-- 2. Ejecute desde la raíz del proyecto, con una cuenta administradora de MySQL:
--      mysql -u root -p < database/init.sql
-- 3. Cree el primer administrador:  php database/crear_admin.php
-- =====================================================

CREATE DATABASE IF NOT EXISTS bibliografia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'biblioges'@'localhost' IDENTIFIED BY 'CAMBIAR_ESTA_CLAVE';
GRANT ALL PRIVILEGES ON bibliografia.* TO 'biblioges'@'localhost';

USE bibliografia;

-- Esquema: tablas, vistas, triggers y datos requeridos
SOURCE database/schema.sql;

-- Solo desarrollo o pruebas (NO en producción): datos de ejemplo
-- SOURCE database/datos_ejemplo.sql;
