# Sistema de Gestión de Bibliografías UCN

## Descripción General
Sistema web para la gestión de bibliografías universitarias, permitiendo la administración de usuarios, asignaturas, carreras, bibliografías declaradas y disponibles, reportes y autenticación integrada con Active Directory (LDAP).

## Características Principales

### Gestión de Datos
- **CRUD completo** para usuarios, carreras, asignaturas y bibliografías
- **Paginación avanzada** con navegación intuitiva y preservación de filtros
- **Ordenamiento dinámico** por múltiples columnas (ascendente/descendente)
- **Filtros de búsqueda** con múltiples criterios
- **Validación de datos** en tiempo real

### Autenticación y Seguridad
- **Integración con Active Directory** (LDAP)
- **Fallback a autenticación local**
- **Sesiones seguras** con configuración personalizable
- **Protección CSRF** en formularios
- **Control de acceso** basado en roles

### Reportes y Exportación
- **Reportes de cobertura** por carrera y asignatura
- **Exportación a Excel** con formato profesional
- **Estadísticas en tiempo real**
- **Generación de listados** personalizables

### Interfaz de Usuario
- **Diseño responsive** compatible con móviles y tablets
- **Navegación intuitiva** con breadcrumbs
- **Notificaciones en tiempo real** con SweetAlert2
- **Iconografía FontAwesome** para mejor UX
- **Temas personalizables** con Bootstrap 5

### Rendimiento y Optimización
- **Caché de consultas** para mejorar tiempos de respuesta
- **Compresión gzip** para archivos estáticos
- **Optimización de imágenes** automática
- **Lazy loading** para contenido pesado
- **Consultas SQL optimizadas** con índices apropiados

## Requerimientos del Sistema

### Servidor Web (Apache)
- **Apache 2.4** o superior
- **Módulos Apache requeridos:**
  - `mod_rewrite` - Para URLs amigables
  - `mod_ssl` - Para HTTPS
  - `mod_headers` - Para headers de seguridad
  - `mod_expires` - Para cache de archivos estáticos
  - `mod_deflate` - Para compresión gzip
  - `mod_php` - Para ejecución de PHP

### Base de Datos
- **MySQL 8.0** o **MariaDB 10.5** o superior
- **Usuario con permisos:** CREATE, SELECT, INSERT, UPDATE, DELETE, DROP, INDEX, ALTER

### PHP
- **PHP 8.0** o superior (recomendado PHP 8.3)
- **Extensiones PHP requeridas:**
  - `pdo` - Para conexión a base de datos
  - `pdo_mysql` - Driver MySQL para PDO
  - `mbstring` - Para manejo de caracteres UTF-8
  - `openssl` - Para encriptación y SSL
  - `ldap` - Para autenticación con Active Directory
  - `json` - Para manejo de JSON (incluida por defecto)
  - `zip` - Para generación de archivos Excel
  - `xml` - Para procesamiento XML
  - `curl` - Para llamadas a APIs externas
  - `gd` o `imagick` - Para procesamiento de imágenes
  - `fileinfo` - Para detección de tipos MIME

### Herramientas de Desarrollo
- **Composer** - Para gestión de dependencias PHP
- **Git** - Para control de versiones

## Instalación y Configuración

### 1. Preparación del Servidor

#### Instalar dependencias del sistema (Ubuntu/Debian):
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache y módulos
sudo apt install apache2 -y
sudo a2enmod rewrite ssl headers expires deflate

# Instalar PHP y extensiones
sudo apt install php8.3 php8.3-cli php8.3-common php8.3-mysql php8.3-mbstring \
php8.3-xml php8.3-curl php8.3-gd php8.3-zip php8.3-ldap php8.3-fileinfo -y

# Instalar MySQL/MariaDB
sudo apt install mysql-server -y

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### Instalar dependencias del sistema (CentOS/RHEL):
```bash
# Actualizar sistema
sudo yum update -y

# Instalar Apache y módulos
sudo yum install httpd mod_ssl -y
sudo systemctl enable httpd

# Instalar PHP y extensiones
sudo yum install php php-cli php-common php-mysqlnd php-mbstring \
php-xml php-curl php-gd php-zip php-ldap php-fileinfo -y

# Instalar MySQL/MariaDB
sudo yum install mysql-server -y

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Clonar e Instalar el Proyecto

```bash
# Clonar el repositorio
git clone https://github.com/problesj/Biblioges.git
cd Biblioges

# Instalar dependencias PHP
composer install --no-dev --optimize-autoloader

# Configurar variables de entorno (OBLIGATORIO)
cp .env.example .env
# Editar .env con la configuración de tu servidor
# ⚠️ IMPORTANTE: Este archivo es requerido por init_db.php
```

### 3. Configuración de Base de Datos

#### Crear base de datos y usuario:
```sql
CREATE DATABASE bibliografia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'biblioges'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';
GRANT ALL PRIVILEGES ON bibliografia.* TO 'biblioges'@'localhost';
FLUSH PRIVILEGES;
```

#### Configurar archivo .env (OBLIGATORIO):
**⚠️ IMPORTANTE:** El archivo `.env` debe estar configurado ANTES de ejecutar `init_db.php`
```env
# Configuración de base de datos
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=bibliografia
DB_USERNAME=biblioges
DB_PASSWORD=tu_contraseña_segura

# Configuración de la aplicación
APP_URL=https://tu-dominio.com/biblioges/
APP_ENV=production
APP_DEBUG=false

# Configuración de sesiones
SESSION_DRIVER=files
SESSION_LIFETIME=120

# Configuración de LDAP (si aplica)
LDAP_HOST=tu-servidor-ldap.com
LDAP_PORT=389
LDAP_BIND_DN=admin
LDAP_BIND_PASSWORD=contraseña_ldap
LDAP_BASE_DN=DC=tu,DC=dominio,DC=com

# Configuración de APIs externas
ALMA_API_KEY=tu_api_key_alma
PRIMO_API_KEY=tu_api_key_primo
PRIMO_INST=tu_instancia_primo
PRIMO_VID=tu_vid_primo

# Configuración de APIs de Google
GOOGLE_API_KEY=tu_api_key_google
GOOGLE_SEARCH_ENGINE_ID=tu_search_engine_id
GOOGLE_SCHOLAR_ENABLED=true
GOOGLE_BOOKS_ENABLED=true
GOOGLE_CUSTOM_SEARCH_ENABLED=false
```

#### Inicializar la base de datos:
```bash
# Verificar que el archivo .env existe y está configurado
ls -la .env
cat .env | grep DB_

# El script init_db.php lee automáticamente la configuración del archivo .env
# Asegúrate de que el archivo .env esté configurado correctamente antes de ejecutar
php database/init_db.php
```

### 4. Configuración de Permisos

#### Crear directorios necesarios:
```bash
# Crear directorios de almacenamiento
sudo mkdir -p storage/framework/sessions
sudo mkdir -p storage/logs
sudo mkdir -p public/uploads/imagenes_carreras
sudo mkdir -p public/uploads/libros_carrera
sudo mkdir -p public/reportes
sudo mkdir -p public/exports
```

#### Establecer permisos correctos:
```bash
# Cambiar propietario a www-data (Apache)
sudo chown -R www-data:www-data /var/www/html/biblioges

# Establecer permisos para directorios de escritura
sudo chmod -R 755 /var/www/html/biblioges
sudo chmod -R 775 storage/
sudo chmod -R 775 public/uploads/
sudo chmod -R 775 public/reportes/
sudo chmod -R 775 public/exports/

# Permisos específicos para sesiones
sudo chmod -R 700 storage/framework/sessions/
```

### 5. Configuración de Apache

#### Configuración VirtualHost HTTP (puerto 80):
```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    ServerAdmin webmaster@tu-dominio.com
    Redirect permanent / https://tu-dominio.com/
    ErrorLog ${APACHE_LOG_DIR}/biblioges_error.log
    CustomLog ${APACHE_LOG_DIR}/biblioges_access.log combined
</VirtualHost>
```

#### Configuración VirtualHost HTTPS (puerto 443):
```apache
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName tu-dominio.com
    ServerAdmin webmaster@tu-dominio.com

    DocumentRoot /var/www/html/biblioges/view

    <Directory /var/www/html/biblioges/view>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        AddDefaultCharset utf-8
        Require all granted
        AddHandler application/x-httpd-php .php
        DirectoryIndex index.php
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>

    Alias /biblioges /var/www/html/biblioges/public

    <Directory /var/www/html/biblioges/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        AddDefaultCharset utf-8
        Require all granted
        AddHandler application/x-httpd-php .php
        DirectoryIndex index.php
        RewriteEngine On
        RewriteBase /biblioges/
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>

    PHPIniDir /etc/php/8.3/apache2
    php_value session.save_handler files
    php_value session.save_path "/var/lib/php/sessions"
    php_value session.gc_probability 1
    php_value session.gc_divisor 100
    php_value session.gc_maxlifetime 1440

    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType text/css "access plus 1 month"
        ExpiresByType application/javascript "access plus 1 month"
        ExpiresByType image/png "access plus 1 month"
        ExpiresByType image/jpg "access plus 1 month"
        ExpiresByType image/jpeg "access plus 1 month"
        ExpiresByType image/gif "access plus 1 month"
        ExpiresByType image/ico "access plus 1 month"
    </IfModule>

    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/plain
        AddOutputFilterByType DEFLATE text/html
        AddOutputFilterByType DEFLATE text/xml
        AddOutputFilterByType DEFLATE text/css
        AddOutputFilterByType DEFLATE application/xml
        AddOutputFilterByType DEFLATE application/xhtml+xml
        AddOutputFilterByType DEFLATE application/rss+xml
        AddOutputFilterByType DEFLATE application/javascript
        AddOutputFilterByType DEFLATE application/x-javascript
    </IfModule>

    ErrorLog ${APACHE_LOG_DIR}/biblioges-error.log
    CustomLog ${APACHE_LOG_DIR}/biblioges-access.log combined

    # Configuración SSL (ajustar rutas según tu certificado)
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/tu-dominio.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/tu-dominio.com/privkey.pem
</VirtualHost>
</IfModule>
```

#### Habilitar el sitio:
```bash
sudo a2ensite tu-dominio.conf
sudo systemctl reload apache2
```

### 6. Configuración SSL (Opcional pero Recomendado)

#### Usando Certbot (Let's Encrypt):
```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-apache -y

# Obtener certificado
sudo certbot --apache -d tu-dominio.com

# Configurar renovación automática
sudo crontab -e
# Agregar: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 7. Configuración de Tareas Programadas (Cron)

#### Configurar crontab para tareas automáticas:
```bash
# Editar el crontab del usuario www-data
sudo crontab -u www-data -e

# Agregar la siguiente línea para ejecutar tareas cada 5 minutos:
*/5 * * * * /usr/bin/php /var/www/html/biblioges/cron_ejecutar_tareas.php >> /var/log/cron_tareas.log 2>&1
```

#### Verificar configuración de cron:
```bash
# Verificar que el servicio cron está activo
sudo systemctl status cron

# Verificar las tareas programadas
sudo crontab -u www-data -l

# Verificar logs de tareas programadas
tail -f /var/log/cron_tareas.log
```

#### Tareas que se ejecutan automáticamente:
- **Generación de reportes** periódicos
- **Limpieza de archivos** temporales
- **Sincronización de datos** con APIs externas
- **Backups automáticos** de configuración

### 8. Verificación de la Instalación

#### Verificar módulos Apache:
```bash
sudo apache2ctl -M | grep -E "(rewrite|ssl|headers|expires|deflate)"
```

#### Verificar extensiones PHP:
```bash
php -m | grep -E "(pdo|mbstring|openssl|ldap|json|zip|xml|curl|gd|fileinfo)"
```

#### Verificar permisos:
```bash
ls -la storage/framework/sessions/
ls -la public/uploads/
ls -la public/reportes/
ls -la public/exports/
```

#### Verificar acceso:
- Frontend: `https://tu-dominio.com/`
- Backend: `https://tu-dominio.com/biblioges/`

## Estructura de Directorios y Permisos

### Directorios de Escritura (775):
- `storage/` - Logs y sesiones
- `storage/framework/sessions/` - Archivos de sesión (700)
- `storage/logs/` - Logs de aplicación
- `public/uploads/` - Archivos subidos por usuarios
- `public/uploads/imagenes_carreras/` - Imágenes de carreras
- `public/uploads/libros_carrera/` - Libros de carreras
- `public/reportes/` - Reportes Excel generados
- `public/exports/` - Exportaciones de datos

### Directorios de Solo Lectura (755):
- `src/` - Código fuente PHP
- `view/` - Frontend de la aplicación
- `public/` - Archivos públicos
- `templates/` - Plantillas Twig
- `config/` - Archivos de configuración

## Dependencias PHP (composer.json)

### Dependencias Principales:
- `vlucas/phpdotenv` - Variables de entorno
- `slim/slim` - Framework web
- `slim/psr7` - PSR-7 HTTP messages
- `php-di/php-di` - Inyección de dependencias
- `illuminate/database` - ORM de base de datos
- `phpmailer/phpmailer` - Envío de emails
- `firebase/php-jwt` - JWT tokens
- `twig/twig` - Motor de plantillas
- `slim/twig-view` - Integración Twig con Slim
- `slim/csrf` - Protección CSRF
- `slim/flash` - Mensajes flash
- `respect/validation` - Validación de datos
- `phpoffice/phpspreadsheet` - Generación de archivos Excel

## Acceso Inicial

### Usuario Administrador por Defecto:
- **Email:** `admin@biblioges.cl`
- **Contraseña:** `admin123`
- **RUT:** `12345678-9`

**⚠️ IMPORTANTE:** Cambiar la contraseña del administrador después de la primera instalación.

## Módulos Principales

### Autenticación
- Login con Active Directory (LDAP)
- Fallback a contraseña local
- Gestión de sesiones seguras

### Gestión de Usuarios
- CRUD de usuarios, roles y permisos
- Integración con LDAP
- Gestión de perfiles

### Gestión Académica
- Administración de asignaturas
- Gestión de carreras y departamentos
- Configuración de facultades

### Gestión de Bibliografías
- Declaración de bibliografías
- Gestión de disponibilidad
- Autores, libros, artículos, tesis
- Software y sitios web
- **Nuevo:** Búsquedas integradas con Google Scholar y Google Books
- **Nuevo:** Detección automática de metadatos académicos

### Gestión de Autores Avanzada
- **Nuevo:** Algoritmo ultra-optimizado para detección de duplicados
- **Nuevo:** Sistema de variaciones y alias de autores
- **Nuevo:** Fusión automática de registros duplicados
- **Nuevo:** Preservación de referencias durante fusión

### APIs de Google Integradas
- **Google Scholar API:** Búsqueda académica avanzada
- **Google Books API:** Búsqueda de libros con metadatos completos
- **Google Custom Search API:** Búsqueda web personalizada (opcional)
- Extracción inteligente de metadatos
- Filtrado automático por relevancia académica

### Reportes y Exportaciones
- Reportes de cobertura
- Listados de bibliografías
- Exportación a Excel
- Reportes de ejemplares
- Estadísticas de estudiantes y profesores

### Tareas Programadas
- Ejecución automática vía cron
- Generación de reportes periódicos
- Limpieza de archivos temporales

## Seguridad y Buenas Prácticas

### Configuración de Seguridad:
1. **Cambiar contraseñas por defecto**
2. **Mantener .env fuera del control de versiones**
3. **Configurar HTTPS obligatorio**
4. **Revisar permisos de archivos regularmente**
5. **Mantener actualizado el sistema**

### Mantenimiento:
1. **Backups regulares de la base de datos**
2. **Monitoreo de logs de error**
3. **Actualización de dependencias**
4. **Limpieza de archivos temporales**

## Solución de Problemas

### Errores Comunes:

#### Error de permisos:
```bash
sudo chown -R www-data:www-data /var/www/html/biblioges
sudo chmod -R 775 storage/ public/uploads/ public/reportes/ public/exports/
```

#### Error de módulo Apache:
```bash
sudo a2enmod rewrite ssl headers expires deflate
sudo systemctl reload apache2
```

#### Error de extensión PHP:
```bash
sudo apt install php8.3-[extension-name]
sudo systemctl restart apache2
```

#### Error de base de datos:
```bash
# Verificar que el archivo .env existe y está configurado
ls -la .env
cat .env | grep DB_

# Verificar conexión (usa configuración del archivo .env)
php database/init_db.php
```

#### Error de tareas programadas:
```bash
# Verificar que el servicio cron está activo
sudo systemctl status cron

# Verificar que el crontab está configurado
sudo crontab -u www-data -l

# Verificar logs de tareas programadas
tail -f /var/log/cron_tareas.log

# Probar ejecución manual del script
sudo -u www-data php /var/www/html/biblioges/cron_ejecutar_tareas.php
```

## Documentación Adicional

### 📚 Índice de Documentación
Para una navegación completa de toda la documentación técnica:
- **Índice de Documentación:** `docs/INDICE_DOCUMENTACION.md`

### Documentación Técnica
- **APIs de Google y Mejoras en Duplicados:** `docs/APIS_GOOGLE_Y_MEJORAS_DUPLICADOS.md`
- **Paginación y Ordenamiento:** `docs/PAGINACION_ORDENAMIENTO.md`
- **Requerimientos del Sistema:** `docs/REQUERIMIENTOS_SISTEMA.md`
- **Configuración Apache:** `docs/APACHE_CONFIGURACION_ACTUAL.md`
- **Configuración HTTP/HTTPS:** `docs/APACHE_HTTP_HTTPS_CONFIGURATION.md`

## Contacto y Soporte

Para dudas o soporte técnico:
- **Equipo de desarrollo:** [contacto]
- **Repositorio:** https://github.com/problesj/Biblioges
- **Documentación adicional:** Ver carpeta `docs/`

## Licencia

Este proyecto está bajo la licencia [especificar licencia]. 