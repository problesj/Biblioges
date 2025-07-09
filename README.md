# Sistema de Gestión de Bibliografías UCN

## Descripción General
Sistema web para la gestión de bibliografías universitarias, permitiendo la administración de usuarios, asignaturas, carreras, bibliografías declaradas y disponibles, reportes y autenticación integrada con Active Directory (LDAP).

## Requerimientos para Producción
- PHP 8.0 o superior
- Composer
- MySQL/MariaDB
- Servidor web Apache/Nginx
- Extensiones PHP: pdo, pdo_mysql, mbstring, openssl, ldap
- Node.js y npm (para assets frontend)

## Pasos para Instalación y Puesta en Marcha
1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/problesj/Biblioges.git
   cd Biblioges
   ```
2. **Instalar dependencias backend:**
   ```bash
   composer install
   ```
3. **Instalar dependencias frontend:**
   ```bash
   npm install && npm run prod
   ```
4. **Configurar variables de entorno:**
   Copiar el archivo `.env.example` a `.env` y editar los valores según tu entorno (base de datos, correo, LDAP, etc).
   ```bash
   cp .env.example .env
   ```
5. **Inicializar la base de datos:**
   - Edita la configuración de conexión en `.env`.
   - Ejecuta el script de inicialización:
     ```bash
     php database/init_db.php
     ```
6. **Configurar el servidor web:**
   - Apunta el DocumentRoot a la carpeta `public/`.
   - Asegúrate de que los permisos de las carpetas `storage/`, `logs/` y `cache/` permitan escritura.

7. **Acceso inicial:**
   - Usuario administrador por defecto:
     - Email: `admin@biblioges.cl`
     - Contraseña: `admin123`
     - RUT: `12345678-9`

## Descripción de Módulos Principales
- **Autenticación:**
  - Login con Active Directory (LDAP) y fallback a contraseña local.
- **Gestión de Usuarios:**
  - CRUD de usuarios, roles y permisos.
- **Gestión de Asignaturas y Carreras:**
  - Administración de asignaturas, carreras, departamentos y facultades.
- **Gestión de Bibliografías:**
  - Declaración y disponibilidad de bibliografías, autores, libros, artículos, tesis, software y sitios web.
- **Reportes:**
  - Cobertura, listado de bibliografías, ejemplares, estudiantes, profesores, asignaturas y carreras.
- **Tareas Programadas:**
  - Ejecución de tareas automáticas vía cron.

## Notas de Seguridad y Buenas Prácticas
- Cambia la contraseña del administrador tras la primera instalación.
- Mantén el archivo `.env` fuera del control de versiones.
- Revisa y ajusta los permisos de carpetas sensibles.
- Elimina scripts de prueba y archivos temporales antes de pasar a producción (ya realizado).

## Contacto y Soporte
Para dudas o soporte, contacta al equipo de desarrollo o abre un issue en el repositorio. 