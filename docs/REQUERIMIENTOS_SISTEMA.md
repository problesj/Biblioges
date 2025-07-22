# Requerimientos Detallados del Sistema - Biblioges

## Resumen Ejecutivo

Este documento detalla todos los requerimientos técnicos necesarios para la instalación y funcionamiento del Sistema de Gestión de Bibliografías UCN en un servidor de producción.

## Requerimientos de Servidor

### Sistema Operativo
- **Ubuntu 20.04 LTS** o superior
- **Debian 11** o superior
- **CentOS 8** o superior
- **RHEL 8** o superior

### Recursos Mínimos Recomendados
- **CPU:** 2 cores
- **RAM:** 4 GB
- **Almacenamiento:** 20 GB (SSD recomendado)
- **Red:** Conexión a internet estable

## Servidor Web (Apache)

### Versión Requerida
- **Apache 2.4** o superior

### Módulos Apache Obligatorios

#### 1. mod_rewrite
- **Propósito:** URLs amigables y redirecciones
- **Comando de instalación:** `sudo a2enmod rewrite`
- **Verificación:** `apache2ctl -M | grep rewrite`

#### 2. mod_ssl
- **Propósito:** Soporte HTTPS/SSL
- **Comando de instalación:** `sudo a2enmod ssl`
- **Verificación:** `apache2ctl -M | grep ssl`

#### 3. mod_headers
- **Propósito:** Headers de seguridad y control
- **Comando de instalación:** `sudo a2enmod headers`
- **Verificación:** `apache2ctl -M | grep headers`

#### 4. mod_expires
- **Propósito:** Cache de archivos estáticos
- **Comando de instalación:** `sudo a2enmod expires`
- **Verificación:** `apache2ctl -M | grep expires`

#### 5. mod_deflate
- **Propósito:** Compresión gzip
- **Comando de instalación:** `sudo a2enmod deflate`
- **Verificación:** `apache2ctl -M | grep deflate`

#### 6. mod_php
- **Propósito:** Ejecución de PHP
- **Comando de instalación:** `sudo apt install libapache2-mod-php8.3`
- **Verificación:** `apache2ctl -M | grep php`

### Comando de Instalación Completa (Ubuntu/Debian)
```bash
sudo apt update
sudo apt install apache2 libapache2-mod-php8.3 -y
sudo a2enmod rewrite ssl headers expires deflate
sudo systemctl restart apache2
```

## PHP

### Versión Requerida
- **PHP 8.0** o superior (recomendado PHP 8.3)

### Extensiones PHP Obligatorias

#### 1. pdo
- **Propósito:** Conexión a base de datos
- **Paquete:** `php8.3-pdo`
- **Verificación:** `php -m | grep pdo`

#### 2. pdo_mysql
- **Propósito:** Driver MySQL para PDO
- **Paquete:** `php8.3-mysql`
- **Verificación:** `php -m | grep pdo_mysql`

#### 3. mbstring
- **Propósito:** Manejo de caracteres UTF-8
- **Paquete:** `php8.3-mbstring`
- **Verificación:** `php -m | grep mbstring`

#### 4. openssl
- **Propósito:** Encriptación y SSL
- **Paquete:** `php8.3-openssl`
- **Verificación:** `php -m | grep openssl`

#### 5. ldap
- **Propósito:** Autenticación con Active Directory
- **Paquete:** `php8.3-ldap`
- **Verificación:** `php -m | grep ldap`

#### 6. json
- **Propósito:** Manejo de JSON
- **Paquete:** Incluida por defecto
- **Verificación:** `php -m | grep json`

#### 7. zip
- **Propósito:** Generación de archivos Excel
- **Paquete:** `php8.3-zip`
- **Verificación:** `php -m | grep zip`

#### 8. xml
- **Propósito:** Procesamiento XML
- **Paquete:** `php8.3-xml`
- **Verificación:** `php -m | grep xml`

#### 9. curl
- **Propósito:** Llamadas a APIs externas
- **Paquete:** `php8.3-curl`
- **Verificación:** `php -m | grep curl`

#### 10. gd
- **Propósito:** Procesamiento de imágenes
- **Paquete:** `php8.3-gd`
- **Verificación:** `php -m | grep gd`

#### 11. fileinfo
- **Propósito:** Detección de tipos MIME
- **Paquete:** `php8.3-fileinfo`
- **Verificación:** `php -m | grep fileinfo`

### Comando de Instalación Completa (Ubuntu/Debian)
```bash
sudo apt install php8.3 php8.3-cli php8.3-common php8.3-mysql \
php8.3-mbstring php8.3-xml php8.3-curl php8.3-gd php8.3-zip \
php8.3-ldap php8.3-fileinfo php8.3-openssl -y
```

### Comando de Instalación Completa (CentOS/RHEL)
```bash
sudo yum install php php-cli php-common php-mysqlnd php-mbstring \
php-xml php-curl php-gd php-zip php-ldap php-fileinfo -y
```

## Base de Datos (MySQL/MariaDB)

### Versión Requerida
- **MySQL 8.0** o superior
- **MariaDB 10.5** o superior

### Configuración Mínima
- **Charset:** utf8mb4
- **Collation:** utf8mb4_unicode_ci
- **Usuario con permisos:** CREATE, SELECT, INSERT, UPDATE, DELETE, DROP, INDEX, ALTER

### Comando de Instalación (Ubuntu/Debian)
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

### Comando de Instalación (CentOS/RHEL)
```bash
sudo yum install mysql-server -y
sudo systemctl enable mysqld
sudo systemctl start mysqld
sudo mysql_secure_installation
```

## Herramientas de Desarrollo

### Composer
- **Versión:** 2.0 o superior
- **Propósito:** Gestión de dependencias PHP
- **Instalación:**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Git
- **Versión:** 2.0 o superior
- **Propósito:** Control de versiones
- **Instalación:** `sudo apt install git -y`

## Estructura de Directorios y Permisos

### Directorios de Escritura (775)
```
storage/
├── framework/
│   └── sessions/          # 700 (permisos especiales)
└── logs/                  # 775

public/
├── uploads/
│   ├── imagenes_carreras/ # 775
│   └── libros_carrera/    # 775
├── reportes/              # 775
└── exports/               # 775
```

### Directorios de Solo Lectura (755)
```
src/                       # Código fuente PHP
view/                      # Frontend de la aplicación
public/                    # Archivos públicos
templates/                 # Plantillas Twig
config/                    # Archivos de configuración
```

### Comandos de Configuración de Permisos
```bash
# Crear directorios necesarios
sudo mkdir -p storage/framework/sessions
sudo mkdir -p storage/logs
sudo mkdir -p public/uploads/imagenes_carreras
sudo mkdir -p public/uploads/libros_carrera
sudo mkdir -p public/reportes
sudo mkdir -p public/exports

# Establecer propietario
sudo chown -R www-data:www-data /var/www/html/biblioges

# Establecer permisos generales
sudo chmod -R 755 /var/www/html/biblioges

# Establecer permisos de escritura
sudo chmod -R 775 storage/
sudo chmod -R 775 public/uploads/
sudo chmod -R 775 public/reportes/
sudo chmod -R 775 public/exports/

# Permisos específicos para sesiones
sudo chmod -R 700 storage/framework/sessions/
```

## Verificación de Instalación

### Script de Verificación
```bash
#!/bin/bash
echo "=== VERIFICACIÓN DE REQUERIMIENTOS DEL SISTEMA ==="

echo -e "\n1. Verificando Apache y módulos..."
apache2ctl -M | grep -E "(rewrite|ssl|headers|expires|deflate|php)" || echo "❌ Faltan módulos Apache"

echo -e "\n2. Verificando PHP y extensiones..."
php -m | grep -E "(pdo|mbstring|openssl|ldap|json|zip|xml|curl|gd|fileinfo)" || echo "❌ Faltan extensiones PHP"

echo -e "\n3. Verificando MySQL..."
mysql --version || echo "❌ MySQL no está instalado"

echo -e "\n4. Verificando Composer..."
composer --version || echo "❌ Composer no está instalado"

echo -e "\n5. Verificando permisos de directorios..."
ls -la storage/framework/sessions/ | head -1 | grep "drwx------" || echo "❌ Permisos incorrectos en sessions"
ls -la public/uploads/ | head -1 | grep "drwxrwxr-x" || echo "❌ Permisos incorrectos en uploads"

echo -e "\n=== VERIFICACIÓN COMPLETADA ==="
```

## Configuración de PHP (php.ini)

### Configuraciones Recomendadas
```ini
; Configuración de memoria
memory_limit = 256M
max_execution_time = 300
max_input_time = 300

; Configuración de carga de archivos
upload_max_filesize = 10M
post_max_size = 10M

; Configuración de sesiones
session.save_handler = files
session.save_path = "/var/lib/php/sessions"
session.gc_probability = 1
session.gc_divisor = 100
session.gc_maxlifetime = 1440

; Configuración de errores (producción)
error_reporting = E_ALL
display_errors = Off
log_errors = On
error_log = "/var/log/apache2/php_errors.log"

; Configuración de zona horaria
date.timezone = "America/Santiago"

; Configuración de caracteres
default_charset = "UTF-8"
mbstring.internal_encoding = "UTF-8"
mbstring.http_input = "UTF-8"
mbstring.http_output = "UTF-8"
```

## Configuración de MySQL

### Configuraciones Recomendadas (my.cnf)
```ini
[mysqld]
# Configuración de caracteres
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Configuración de conexiones
max_connections = 200
max_allowed_packet = 16M

# Configuración de logs
log_error = /var/log/mysql/error.log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

# Configuración de rendimiento
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
```

## Dependencias PHP (composer.json)

### Dependencias Principales
```json
{
    "require": {
        "php": ">=7.4",
        "vlucas/phpdotenv": "^5.5",
        "ext-pdo": "*",
        "slim/slim": "^4.11",
        "slim/psr7": "^1.6",
        "php-di/php-di": "^7.0",
        "illuminate/database": "^10.0",
        "phpmailer/phpmailer": "^6.8",
        "firebase/php-jwt": "^6.4",
        "twig/twig": "^3.0",
        "slim/twig-view": "^3.3",
        "slim/csrf": "^1.3",
        "slim/flash": "^0.4.0",
        "respect/validation": "^2.2",
        "phpoffice/phpspreadsheet": "^4.4"
    }
}
```

## Verificación de Funcionamiento

### Comandos de Verificación
```bash
# Verificar Apache
sudo systemctl status apache2

# Verificar PHP
php -v

# Verificar MySQL
sudo systemctl status mysql

# Verificar módulos Apache
apache2ctl -M

# Verificar extensiones PHP
php -m

# Verificar permisos
ls -la storage/framework/sessions/
ls -la public/uploads/

# Verificar acceso web
curl -I http://localhost/
curl -I https://localhost/ (si SSL está configurado)
```

## Solución de Problemas Comunes

### Error: "mod_rewrite not found"
```bash
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### Error: "PHP extension missing"
```bash
sudo apt install php8.3-[extension-name]
sudo systemctl restart apache2
```

### Error: "Permission denied"
```bash
sudo chown -R www-data:www-data /var/www/html/biblioges
sudo chmod -R 775 storage/ public/uploads/ public/reportes/ public/exports/
```

### Error: "Database connection failed"
```bash
# Verificar servicio MySQL
sudo systemctl status mysql

# Verificar credenciales en .env
cat .env | grep DB_

# Probar conexión
php database/init_db.php
```

## Notas Importantes

1. **Seguridad:** Siempre cambiar las contraseñas por defecto
2. **Backups:** Configurar backups regulares de la base de datos
3. **Logs:** Monitorear logs de Apache y PHP regularmente
4. **Actualizaciones:** Mantener el sistema actualizado
5. **SSL:** Usar HTTPS en producción
6. **Permisos:** Revisar permisos de archivos regularmente

## Contacto

Para soporte técnico o consultas sobre requerimientos:
- **Equipo de desarrollo:** [contacto]
- **Documentación:** Ver carpeta `docs/`
- **Repositorio:** https://github.com/problesj/Biblioges 