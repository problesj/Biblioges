# Módulo de Gestión de Usuarios - Biblioges

## Descripción

El módulo de usuarios permite gestionar los usuarios del sistema con diferentes niveles de acceso según su rol.

## Características

### Funcionalidades CRUD
- ✅ **Crear** usuarios nuevos
- ✅ **Leer** listado de usuarios con filtros
- ✅ **Actualizar** información de usuarios
- ✅ **Eliminar** usuarios (excepto el propio)
- ✅ **Activar/Desactivar** usuarios

### Validaciones
- ✅ Validación de RUT chileno
- ✅ Validación de email único
- ✅ Validación de contraseña (mínimo 6 caracteres)
- ✅ Validación de campos obligatorios
- ✅ Prevención de duplicados

### Roles de Usuario

#### 1. **Administrador (admin)**
- Acceso completo a todas las funcionalidades del sistema
- Puede gestionar usuarios, sedes, facultades, departamentos
- Acceso a todos los módulos y reportes

#### 2. **Administrador Biblioteca (admin_bidoc)**
- Acceso a módulos específicos:
  - Dashboard
  - Bibliografía Declarada
  - Bibliografía Disponible
  - Reportes (Cobertura, Listado de bibliografías)
  - Gestión de Usuarios
  - Autores

#### 3. **Usuario (usuario)**
- Acceso limitado:
  - Dashboard
  - Reportes
  - Cobertura
  - Listado de bibliografías

## Instalación

### 1. Ejecutar el script de usuario administrador

```sql
-- Ejecutar el archivo: database/seeders/create_admin_user.sql
-- Esto creará un usuario administrador con las siguientes credenciales:
-- Email: admin@biblioges.cl
-- Contraseña: admin123
-- RUT: 12345678-9
```

### 2. Verificar la estructura de la tabla

La tabla `usuarios` debe tener la siguiente estructura:

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rut VARCHAR(10) NOT NULL,
    nombre VARCHAR(250) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'admin_bidoc', 'usuario') NOT NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Uso

### Acceso al módulo

1. Iniciar sesión con un usuario administrador
2. Navegar a "Administración" > "Usuarios" en el menú lateral
3. El módulo estará disponible en: `/biblioges/usuarios`

### Funcionalidades disponibles

#### Listado de Usuarios
- **Filtros**: Por nombre, email, RUT, rol y estado
- **Paginación**: 10 usuarios por página
- **Acciones**: Ver, editar, activar/desactivar, eliminar

#### Crear Usuario
- Formulario con validaciones en tiempo real
- Campos obligatorios: RUT, nombre, email, contraseña, rol
- Estado por defecto: Activo

#### Editar Usuario
- Modificar información del usuario
- Cambio opcional de contraseña
- Validaciones de duplicados

#### Ver Usuario
- Información detallada del usuario
- Descripción de permisos según el rol
- Fechas de creación y actualización

#### Gestión de Estado
- Activar/desactivar usuarios
- Prevención de desactivación del propio usuario
- Confirmación con SweetAlert2

#### Eliminar Usuario
- Eliminación permanente
- Prevención de eliminación del propio usuario
- Confirmación con SweetAlert2

## Seguridad

### Validaciones implementadas
- **RUT**: Formato chileno válido (12345678-9)
- **Email**: Formato válido y único en el sistema
- **Contraseña**: Mínimo 6 caracteres, hasheada con `password_hash()`
- **Rol**: Solo valores permitidos (admin, admin_bidoc, usuario)
- **Estado**: Valores booleanos (0 o 1)

### Protecciones
- No se puede eliminar el usuario actual
- No se puede desactivar el usuario actual
- Validación de sesión en todas las rutas
- Verificación de permisos por rol

## Archivos del módulo

### Controladores
- `src/Controllers/UsuarioController.php` - Lógica de negocio

### Modelos
- `src/Models/Usuario.php` - Acceso a datos y validaciones

### Vistas (Templates)
- `templates/usuarios/index.twig` - Listado de usuarios
- `templates/usuarios/create.twig` - Formulario de creación
- `templates/usuarios/edit.twig` - Formulario de edición
- `templates/usuarios/show.twig` - Vista detallada

### Rutas
- Agregadas en `src/routes.php` dentro del grupo protegido

### Base de datos
- `database/seeders/create_admin_user.sql` - Usuario administrador por defecto

## Notas técnicas

### Tecnologías utilizadas
- **Backend**: PHP 8+ con Slim Framework
- **Frontend**: Bootstrap 5, jQuery, SweetAlert2
- **Base de datos**: MySQL/MariaDB
- **Templates**: Twig

### Dependencias
- El módulo utiliza las mismas dependencias del proyecto principal
- SweetAlert2 para confirmaciones y alertas
- Bootstrap para el diseño responsive

### Compatibilidad
- Compatible con la estructura existente del proyecto
- Sigue las convenciones de nomenclatura establecidas
- Integrado con el sistema de autenticación existente

## Credenciales por defecto

**Usuario Administrador:**
- Email: `admin@biblioges.cl`
- Contraseña: `admin123`
- RUT: `12345678-9`
- Rol: `admin`

**Importante**: Cambiar la contraseña del administrador después de la primera instalación. 