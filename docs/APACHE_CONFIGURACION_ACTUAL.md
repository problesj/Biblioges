# Configuración Actual de Apache - biblioges.ucn.cl

## Configuración Real del Servidor

Este documento describe la configuración actual del servidor `biblioges.ucn.cl` como ejemplo práctico de implementación de HTTP y HTTPS.

---

## Estructura del Proyecto

```
/var/www/html/biblioges/
├── view/                    # Frontend (raíz del sitio)
│   ├── index.php           # Punto de entrada del frontend
│   └── assets/             # Archivos estáticos (CSS, JS, imágenes)
├── public/                 # Backend (accesible en /biblioges/)
│   ├── index.php           # Punto de entrada del backend
│   └── .htaccess           # Configuración de reescritura
└── templates/              # Plantillas Twig
```

---

## Configuración HTTP (Puerto 80)

### Archivo: `/etc/apache2/sites-enabled/000-default.conf`

```apache
<VirtualHost *:80>
    ServerName biblioges.ucn.cl
    ServerAdmin webmaster@localhost
    
    # Redirección automática a HTTPS
    Redirect permanent / https://biblioges.ucn.cl/
    
    # Logs
    ErrorLog ${APACHE_LOG_DIR}/biblioges_error.log
    CustomLog ${APACHE_LOG_DIR}/biblioges_access.log combined
</VirtualHost>
```

**Propósito:** Redirige todo el tráfico HTTP a HTTPS de forma automática.

---

## Configuración HTTPS (Puerto 443)

### Archivo: `/etc/apache2/sites-enabled/biblioges.conf`

```apache
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName biblioges.ucn.cl
    ServerAdmin webmaster@tu-dominio.com

    # Frontend en la raíz
    DocumentRoot /var/www/html/biblioges/view

    # Configuración del frontend (raíz)
    <Directory /var/www/html/biblioges/view>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        AddDefaultCharset utf-8
        Require all granted

        AddHandler application/x-httpd-php .php
        DirectoryIndex index.php

        # Configuración de mod_rewrite para el frontend
        RewriteEngine On
        RewriteBase /

        # Si la solicitud no es para un archivo existente
        RewriteCond %{REQUEST_FILENAME} !-f
        # Si la solicitud no es para un directorio existente
        RewriteCond %{REQUEST_FILENAME} !-d
        # Redirigir todo a index.php
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>

    # Backend en /biblioges/
    Alias /biblioges /var/www/html/biblioges/public

    <Directory /var/www/html/biblioges/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        AddDefaultCharset utf-8
        Require all granted

        AddHandler application/x-httpd-php .php
        DirectoryIndex index.php

        # Configuración de mod_rewrite para el backend
        RewriteEngine On
        RewriteBase /biblioges/

        # Si la solicitud no es para un archivo existente
        RewriteCond %{REQUEST_FILENAME} !-f
        # Si la solicitud no es para un directorio existente
        RewriteCond %{REQUEST_FILENAME} !-d
        # Redirigir todo a index.php
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>

    # Configuración de PHP
    PHPIniDir /etc/php/8.3/apache2

    # Configuración de sesiones
    php_value session.save_handler files
    php_value session.save_path "/var/lib/php/sessions"
    php_value session.gc_probability 1
    php_value session.gc_divisor 100
    php_value session.gc_maxlifetime 1440

    # Configuración de caché para archivos estáticos
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

    # Compresión GZIP
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

    # Logs
    ErrorLog ${APACHE_LOG_DIR}/biblioges-error.log
    CustomLog ${APACHE_LOG_DIR}/biblioges-access.log combined

    # Configuración SSL
    Include /etc/letsencrypt/options-ssl-apache.conf
    SSLCertificateFile /etc/letsencrypt/live/biblioges.ucn.cl/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/biblioges.ucn.cl/privkey.pem
</VirtualHost>
</IfModule>
```

---

## Certificados SSL

### Ubicación de Certificados
- **Certificado:** `/etc/letsencrypt/live/biblioges.ucn.cl/fullchain.pem`
- **Clave privada:** `/etc/letsencrypt/live/biblioges.ucn.cl/privkey.pem`

### Renovación Automática
```bash
# Verificar certificados actuales
sudo certbot certificates

# Verificar renovación automática
sudo certbot renew --dry-run

# Configurar renovación automática en crontab
sudo crontab -e
# Agregar: 0 12 * * * /usr/bin/certbot renew --quiet
```

---

## Módulos Apache Habilitados

### Verificar Módulos
```bash
# Listar módulos habilitados
apache2ctl -M | grep -E "(ssl|rewrite|headers|expires|deflate)"

# Módulos necesarios para esta configuración:
# - ssl (para HTTPS)
# - rewrite (para reescritura de URLs)
# - headers (para headers de seguridad)
# - expires (para caché de archivos estáticos)
# - deflate (para compresión GZIP)
```

### Habilitar Módulos si Faltan
```bash
sudo a2enmod ssl
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod expires
sudo a2enmod deflate
sudo systemctl reload apache2
```

---

## URLs de Acceso

### Frontend (Público)
- **URL:** `https://biblioges.ucn.cl/`
- **Directorio:** `/var/www/html/biblioges/view/`
- **Archivo principal:** `index.php`

### Backend (Administración)
- **URL:** `https://biblioges.ucn.cl/biblioges/`
- **Directorio:** `/var/www/html/biblioges/public/`
- **Archivo principal:** `index.php`

### Redirección HTTP → HTTPS
- **HTTP:** `http://biblioges.ucn.cl/` → **Redirige automáticamente a** → `https://biblioges.ucn.cl/`

---

## Verificación de la Configuración

### 1. Verificar Sintaxis
```bash
sudo apache2ctl configtest
# Debe mostrar: Syntax OK
```

### 2. Verificar VirtualHosts
```bash
sudo apache2ctl -S
# Debe mostrar:
# *:80                   biblioges.ucn.cl (/etc/apache2/sites-enabled/000-default.conf:1)
# *:443                  biblioges.ucn.cl (/etc/apache2/sites-enabled/biblioges.conf:2)
```

### 3. Verificar Estado del Servicio
```bash
sudo systemctl status apache2
# Debe mostrar: active (running)
```

### 4. Verificar Certificados SSL
```bash
sudo certbot certificates
# Debe mostrar certificados válidos para biblioges.ucn.cl
```

---

## Logs del Sistema

### Ubicación de Logs
- **Error log:** `/var/log/apache2/biblioges-error.log`
- **Access log:** `/var/log/apache2/biblioges-access.log`

### Comandos Útiles
```bash
# Ver logs en tiempo real
sudo tail -f /var/log/apache2/biblioges-error.log
sudo tail -f /var/log/apache2/biblioges-access.log

# Ver últimos 50 errores
sudo tail -n 50 /var/log/apache2/biblioges-error.log

# Buscar errores específicos
sudo grep -i error /var/log/apache2/biblioges-error.log
```

---

## Permisos de Archivos

### Establecer Permisos Correctos
```bash
# Propietario y grupo
sudo chown -R www-data:www-data /var/www/html/biblioges/

# Permisos de directorios
sudo find /var/www/html/biblioges/ -type d -exec chmod 755 {} \;

# Permisos de archivos
sudo find /var/www/html/biblioges/ -type f -exec chmod 644 {} \;

# Permisos especiales para archivos ejecutables
sudo chmod +x /var/www/html/biblioges/view/index.php
sudo chmod +x /var/www/html/biblioges/public/index.php
```

---

## Pruebas de Funcionamiento

### 1. Prueba de Redirección HTTP → HTTPS
```bash
curl -I http://biblioges.ucn.cl
# Debe mostrar: HTTP/1.1 301 Moved Permanently
# Location: https://biblioges.ucn.cl/
```

### 2. Prueba de Acceso HTTPS
```bash
curl -I https://biblioges.ucn.cl
# Debe mostrar: HTTP/1.1 200 OK
```

### 3. Prueba de Backend
```bash
curl -I https://biblioges.ucn.cl/biblioges/
# Debe mostrar: HTTP/1.1 200 OK
```

### 4. Verificar Headers de Seguridad
```bash
curl -I https://biblioges.ucn.cl | grep -E "(Strict-Transport-Security|X-Content-Type-Options|X-Frame-Options)"
```

---

## Solución de Problemas Comunes

### 1. Error de Certificado SSL
```bash
# Verificar permisos de certificados
sudo chmod 644 /etc/letsencrypt/live/biblioges.ucn.cl/fullchain.pem
sudo chmod 600 /etc/letsencrypt/live/biblioges.ucn.cl/privkey.pem

# Verificar que Apache puede leer los certificados
sudo -u www-data test -r /etc/letsencrypt/live/biblioges.ucn.cl/fullchain.pem && echo "OK" || echo "Error"
```

### 2. Error de Redirección
```bash
# Verificar que mod_rewrite está habilitado
sudo a2enmod rewrite
sudo systemctl reload apache2

# Verificar logs de error
sudo tail -f /var/log/apache2/biblioges_error.log
```

### 3. Error de Permisos
```bash
# Establecer permisos correctos
sudo chown -R www-data:www-data /var/www/html/biblioges/
sudo chmod -R 755 /var/www/html/biblioges/
```

### 4. Error de Módulos
```bash
# Verificar módulos habilitados
apache2ctl -M

# Habilitar módulos faltantes
sudo a2enmod ssl
sudo a2enmod headers
sudo a2enmod expires
sudo a2enmod deflate
sudo systemctl reload apache2
```

---

## Comandos de Mantenimiento

### Reiniciar Apache
```bash
sudo systemctl restart apache2
```

### Recargar Configuración
```bash
sudo systemctl reload apache2
```

### Verificar Estado
```bash
sudo systemctl status apache2
```

### Verificar Puertos
```bash
sudo netstat -tlnp | grep :80
sudo netstat -tlnp | grep :443
```

---

## Backup de Configuración

### Crear Backup
```bash
# Backup de configuración de Apache
sudo tar -czf /backup/apache-config-$(date +%Y%m%d).tar.gz /etc/apache2/

# Backup de certificados SSL
sudo tar -czf /backup/ssl-certificates-$(date +%Y%m%d).tar.gz /etc/letsencrypt/
```

### Restaurar Backup
```bash
# Restaurar configuración
sudo tar -xzf /backup/apache-config-20250722.tar.gz -C /

# Restaurar certificados
sudo tar -xzf /backup/ssl-certificates-20250722.tar.gz -C /

# Recargar Apache
sudo systemctl reload apache2
```

---

## Notas Importantes

1. **Esta configuración está optimizada** para el proyecto Biblioges
2. **Los certificados SSL se renuevan automáticamente** cada 90 días
3. **El tráfico HTTP se redirige automáticamente** a HTTPS
4. **Los logs se mantienen separados** para facilitar el debugging
5. **La configuración incluye optimizaciones** de rendimiento y seguridad
6. **Siempre haz backup** antes de modificar la configuración
7. **Prueba los cambios** en un entorno de desarrollo antes de aplicar en producción 