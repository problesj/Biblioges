# Configuración de Apache para HTTP y HTTPS

## Índice
1. [Requisitos Previos](#requisitos-previos)
2. [Instalación de Módulos Necesarios](#instalación-de-módulos-necesarios)
3. [Configuración de Certificados SSL](#configuración-de-certificados-ssl)
4. [Configuración de VirtualHost HTTP](#configuración-de-virtualhost-http)
5. [Configuración de VirtualHost HTTPS](#configuración-de-virtualhost-https)
6. [Configuración de Redirección HTTP → HTTPS](#configuración-de-redirección-http--https)
7. [Configuración de Seguridad](#configuración-de-seguridad)
8. [Configuración de Rendimiento](#configuración-de-rendimiento)
9. [Verificación y Pruebas](#verificación-y-pruebas)
10. [Solución de Problemas](#solución-de-problemas)

---

## Requisitos Previos

### Software Necesario
- Ubuntu/Debian Server
- Apache2
- PHP 8.3+
- Certbot (para certificados Let's Encrypt)
- OpenSSL

### Comandos de Instalación
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache2
sudo apt install apache2 -y

# Instalar PHP y módulos necesarios
sudo apt install php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl -y

# Instalar Certbot para certificados SSL
sudo apt install certbot python3-certbot-apache -y
```

---

## Instalación de Módulos Necesarios

### Habilitar Módulos de Apache
```bash
# Módulos esenciales
sudo a2enmod ssl
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod expires
sudo a2enmod deflate

# Recargar Apache
sudo systemctl reload apache2
```

### Verificar Módulos Instalados
```bash
# Listar módulos habilitados
apache2ctl -M | grep -E "(ssl|rewrite|headers|expires|deflate)"
```

---

## Configuración de Certificados SSL

### Opción 1: Certificados Let's Encrypt (Recomendado)

#### 1. Obtener Certificado
```bash
# Obtener certificado para tu dominio
sudo certbot --apache -d tu-dominio.com -d www.tu-dominio.com

# Verificar renovación automática
sudo certbot renew --dry-run
```

#### 2. Ubicación de Certificados
Los certificados se almacenan en:
- **Certificado:** `/etc/letsencrypt/live/tu-dominio.com/fullchain.pem`
- **Clave privada:** `/etc/letsencrypt/live/tu-dominio.com/privkey.pem`

### Opción 2: Certificados Auto-firmados (Solo para desarrollo)
```bash
# Crear certificado auto-firmado
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/tu-dominio.com.key \
    -out /etc/ssl/certs/tu-dominio.com.crt
```

---

## Configuración de VirtualHost HTTP

### Archivo: `/etc/apache2/sites-available/tu-dominio.conf`

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    ServerAdmin webmaster@tu-dominio.com
    
    # Redirección automática a HTTPS
    Redirect permanent / https://tu-dominio.com/
    
    # Logs
    ErrorLog ${APACHE_LOG_DIR}/tu-dominio_error.log
    CustomLog ${APACHE_LOG_DIR}/tu-dominio_access.log combined
</VirtualHost>
```

### Habilitar Sitio
```bash
sudo a2ensite tu-dominio.conf
sudo systemctl reload apache2
```

---

## Configuración de VirtualHost HTTPS

### Archivo: `/etc/apache2/sites-available/tu-dominio-ssl.conf`

```apache
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName tu-dominio.com
    ServerAdmin webmaster@tu-dominio.com

    # Frontend en la raíz
    DocumentRoot /var/www/html/tu-proyecto/view

    # Configuración del frontend (raíz)
    <Directory /var/www/html/tu-proyecto/view>
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

    # Backend en /api/ (ejemplo)
    Alias /api /var/www/html/tu-proyecto/public

    <Directory /var/www/html/tu-proyecto/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        AddDefaultCharset utf-8
        Require all granted

        AddHandler application/x-httpd-php .php
        DirectoryIndex index.php

        # Configuración de mod_rewrite para el backend
        RewriteEngine On
        RewriteBase /api/

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
        ExpiresByType image/svg+xml "access plus 1 month"
        ExpiresByType application/pdf "access plus 1 month"
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
        AddOutputFilterByType DEFLATE application/json
    </IfModule>

    # Headers de seguridad
    <IfModule mod_headers.c>
        Header always set X-Content-Type-Options nosniff
        Header always set X-Frame-Options DENY
        Header always set X-XSS-Protection "1; mode=block"
        Header always set Referrer-Policy "strict-origin-when-cross-origin"
        Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    </IfModule>

    # Logs
    ErrorLog ${APACHE_LOG_DIR}/tu-dominio-error.log
    CustomLog ${APACHE_LOG_DIR}/tu-dominio-access.log combined

    # Configuración SSL
    Include /etc/letsencrypt/options-ssl-apache.conf
    SSLCertificateFile /etc/letsencrypt/live/tu-dominio.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/tu-dominio.com/privkey.pem
</VirtualHost>
</IfModule>
```

### Habilitar Sitio SSL
```bash
sudo a2ensite tu-dominio-ssl.conf
sudo systemctl reload apache2
```

---

## Configuración de Redirección HTTP → HTTPS

### Opción 1: Redirección en VirtualHost HTTP (Recomendado)
```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    Redirect permanent / https://tu-dominio.com/
</VirtualHost>
```

### Opción 2: Redirección con mod_rewrite
```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    
    RewriteEngine on
    RewriteCond %{SERVER_NAME} =tu-dominio.com
    RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>
```

---

## Configuración de Seguridad

### Archivo: `/etc/apache2/conf-available/security-headers.conf`

```apache
# Headers de seguridad globales
<IfModule mod_headers.c>
    # Prevenir MIME type sniffing
    Header always set X-Content-Type-Options nosniff
    
    # Prevenir clickjacking
    Header always set X-Frame-Options DENY
    
    # Protección XSS
    Header always set X-XSS-Protection "1; mode=block"
    
    # Política de referrer
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    
    # HSTS (HTTP Strict Transport Security)
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    
    # Prevenir cacheo de contenido sensible
    <FilesMatch "\.(php|log)$">
        Header set Cache-Control "no-cache, no-store, must-revalidate"
        Header set Pragma "no-cache"
        Header set Expires 0
    </FilesMatch>
</IfModule>

# Configuración de directorios
<Directory /var/www/html>
    Options -Indexes +FollowSymLinks
    AllowOverride All
    Require all granted
    
    # Bloquear acceso a archivos sensibles
    <FilesMatch "\.(htaccess|htpasswd|ini|log|sh|sql|conf)$">
        Require all denied
    </FilesMatch>
</Directory>
```

### Habilitar Configuración de Seguridad
```bash
sudo a2enconf security-headers
sudo systemctl reload apache2
```

---

## Configuración de Rendimiento

### Archivo: `/etc/apache2/conf-available/performance.conf`

```apache
# Configuración de caché para archivos estáticos
<IfModule mod_expires.c>
    ExpiresActive On
    
    # Imágenes
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
    
    # CSS y JavaScript
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    
    # Fuentes
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType font/woff2 "access plus 1 year"
    ExpiresByType application/font-woff "access plus 1 year"
    ExpiresByType application/font-woff2 "access plus 1 year"
    
    # Documentos
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType application/xml "access plus 1 hour"
    ExpiresByType text/xml "access plus 1 hour"
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
    AddOutputFilterByType DEFLATE application/json
    AddOutputFilterByType DEFLATE application/xml+rss
</IfModule>

# Configuración de Keep-Alive
KeepAlive On
KeepAliveTimeout 5
MaxKeepAliveRequests 100
```

### Habilitar Configuración de Rendimiento
```bash
sudo a2enconf performance
sudo systemctl reload apache2
```

---

## Verificación y Pruebas

### 1. Verificar Configuración de Apache
```bash
# Verificar sintaxis
sudo apache2ctl configtest

# Verificar VirtualHosts
sudo apache2ctl -S

# Verificar estado del servicio
sudo systemctl status apache2
```

### 2. Verificar Certificados SSL
```bash
# Verificar certificado
sudo certbot certificates

# Verificar renovación
sudo certbot renew --dry-run
```

### 3. Pruebas de Conectividad
```bash
# Probar puerto 80 (debe redirigir a HTTPS)
curl -I http://tu-dominio.com

# Probar puerto 443
curl -I https://tu-dominio.com

# Verificar headers de seguridad
curl -I https://tu-dominio.com | grep -E "(Strict-Transport-Security|X-Content-Type-Options|X-Frame-Options)"
```

### 4. Pruebas de Rendimiento
```bash
# Verificar compresión GZIP
curl -H "Accept-Encoding: gzip" -I https://tu-dominio.com

# Verificar caché
curl -I https://tu-dominio.com/assets/style.css
```

---

## Solución de Problemas

### Problemas Comunes

#### 1. Error de Certificado SSL
```bash
# Verificar permisos de certificados
sudo chmod 644 /etc/letsencrypt/live/tu-dominio.com/fullchain.pem
sudo chmod 600 /etc/letsencrypt/live/tu-dominio.com/privkey.pem

# Verificar que Apache puede leer los certificados
sudo -u www-data test -r /etc/letsencrypt/live/tu-dominio.com/fullchain.pem && echo "OK" || echo "Error"
```

#### 2. Error de Redirección
```bash
# Verificar que mod_rewrite está habilitado
sudo a2enmod rewrite
sudo systemctl reload apache2

# Verificar logs de error
sudo tail -f /var/log/apache2/tu-dominio_error.log
```

#### 3. Error de Permisos
```bash
# Establecer permisos correctos
sudo chown -R www-data:www-data /var/www/html/tu-proyecto
sudo chmod -R 755 /var/www/html/tu-proyecto
sudo chmod -R 644 /var/www/html/tu-proyecto/*.php
```

#### 4. Error de Módulos
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

### Comandos Útiles de Diagnóstico

```bash
# Ver configuración completa
sudo apache2ctl -S

# Ver logs en tiempo real
sudo tail -f /var/log/apache2/error.log

# Verificar puertos abiertos
sudo netstat -tlnp | grep :80
sudo netstat -tlnp | grep :443

# Verificar firewall
sudo ufw status
```

---

## Mantenimiento

### Renovación Automática de Certificados
```bash
# Agregar al crontab para renovación automática
sudo crontab -e

# Agregar esta línea:
0 12 * * * /usr/bin/certbot renew --quiet
```

### Monitoreo de Logs
```bash
# Crear script de monitoreo
sudo nano /usr/local/bin/apache-monitor.sh

#!/bin/bash
# Verificar estado de Apache
if ! systemctl is-active --quiet apache2; then
    echo "Apache no está ejecutándose"
    systemctl restart apache2
fi

# Verificar certificados
if ! certbot certificates | grep -q "VALID"; then
    echo "Certificados SSL expirados"
    certbot renew
fi
```

### Backup de Configuración
```bash
# Crear backup de configuración
sudo tar -czf /backup/apache-config-$(date +%Y%m%d).tar.gz /etc/apache2/
```

---

## Referencias

- [Documentación oficial de Apache](https://httpd.apache.org/docs/)
- [Documentación de Certbot](https://certbot.eff.org/docs/)
- [Guía de seguridad de Apache](https://httpd.apache.org/docs/2.4/misc/security_tips.html)
- [Configuración de SSL/TLS](https://httpd.apache.org/docs/2.4/ssl/ssl_howto.html)

---

## Notas Importantes

1. **Siempre haz backup** de la configuración antes de hacer cambios
2. **Prueba en un entorno de desarrollo** antes de aplicar en producción
3. **Mantén actualizado** Apache y los certificados SSL
4. **Monitorea los logs** regularmente para detectar problemas
5. **Configura renovación automática** de certificados SSL
6. **Usa HTTPS siempre** en producción
7. **Implementa headers de seguridad** para proteger tu aplicación 