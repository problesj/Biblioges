-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS bibliografia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE bibliografia;

-- Crear usuario si no existe
-- Reemplazar CAMBIAR_ESTA_CLAVE por la clave definida en DB_PASSWORD (.env)
CREATE USER IF NOT EXISTS 'biblioges'@'localhost' IDENTIFIED BY 'CAMBIAR_ESTA_CLAVE';

-- Otorgar permisos
GRANT ALL PRIVILEGES ON bibliografia.* TO 'biblioges'@'localhost';
FLUSH PRIVILEGES;

-- Importar esquema
SOURCE database/schema.sql;

-- Importar datos iniciales
SOURCE database/seeders/DatabaseSeeder.sql; 