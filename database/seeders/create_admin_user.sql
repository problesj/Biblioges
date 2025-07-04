-- Script para crear un usuario administrador por defecto
-- Contraseña: admin123 (hasheada con password_hash)

INSERT INTO usuarios (rut, nombre, email, password, rol, estado, fecha_creacion, fecha_actualizacion) 
VALUES (
    '12345678-9',
    'Administrador del Sistema',
    'admin@biblioges.cl',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- admin123
    'admin',
    1,
    NOW(),
    NOW()
) ON DUPLICATE KEY UPDATE 
    nombre = VALUES(nombre),
    email = VALUES(email),
    password = VALUES(password),
    rol = VALUES(rol),
    estado = VALUES(estado),
    fecha_actualizacion = NOW(); 