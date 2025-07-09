# Biblioges - Sistema de Gestión de Bibliografías UCN

Sistema web para la gestión integral de bibliografías de la Universidad Católica del Norte (UCN), desarrollado con PHP, Slim Framework y MySQL.

## 🚀 Características

- **Gestión de Bibliografías**: Administración completa de bibliografías básicas y complementarias
- **Gestión Académica**: Manejo de carreras, asignaturas, mallas curriculares y departamentos
- **Reportes Avanzados**: Generación de reportes de cobertura y listados de bibliografías
- **Autenticación LDAP**: Integración con Active Directory de la UCN
- **Interfaz Moderna**: Diseño responsive con Bootstrap 5 y Font Awesome
- **Exportación de Datos**: Exportación a Excel de reportes y listados
- **Gestión de Autores**: Sistema de gestión y fusión de autores duplicados

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 8.3, Slim Framework 4
- **Base de Datos**: MySQL 8.0
- **Frontend**: Bootstrap 5, jQuery, DataTables
- **Template Engine**: Twig
- **ORM**: Eloquent ORM
- **Autenticación**: LDAP/Active Directory
- **Servidor Web**: Apache 2.4

## 📋 Requisitos del Sistema

- PHP 8.1 o superior
- MySQL 8.0 o superior
- Apache 2.4 con mod_rewrite habilitado
- Extensiones PHP: mbstring, pdo_mysql, ldap, zip
- Composer

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/problesj/Biblioges.git
cd Biblioges
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar la base de datos
```bash
# Crear la base de datos
mysql -u root -p -e "CREATE DATABASE bibliografia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Crear el usuario de la aplicación
mysql -u root -p -e "CREATE USER 'biblioges'@'localhost' IDENTIFIED BY 'tu_password';"
mysql -u root -p -e "GRANT ALL PRIVILEGES ON bibliografia.* TO 'biblioges'@'localhost';"
mysql -u root -p -e "FLUSH PRIVILEGES;"
```

### 4. Configurar variables de entorno
```bash
cp .env.example .env
# Editar .env con las credenciales de tu base de datos y configuración LDAP
```

### 5. Ejecutar migraciones
```bash
php database/migrate.php
```

### 6. Configurar el servidor web
```apache
# Configuración de Apache (biblioges.conf)
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/html/biblioges/public
    
    <Directory /var/www/html/biblioges/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>
</VirtualHost>
```

### 7. Configurar permisos
```bash
chmod -R 755 /var/www/html/biblioges
chmod -R 777 /var/www/html/biblioges/storage
chmod -R 777 /var/www/html/biblioges/public/exports
```

## 📁 Estructura del Proyecto

```
biblioges/
├── config/                 # Configuraciones de la aplicación
├── database/              # Migraciones y seeders
├── public/                # Directorio público (DocumentRoot)
│   ├── assets/           # CSS, JS, imágenes
│   ├── exports/          # Archivos exportados
│   └── index.php         # Punto de entrada
├── src/                  # Código fuente
│   ├── Controllers/      # Controladores
│   ├── Models/          # Modelos Eloquent
│   ├── Middleware/      # Middlewares
│   └── Core/            # Clases core
├── storage/              # Logs y archivos temporales
├── templates/            # Plantillas Twig
└── vendor/               # Dependencias de Composer
```

## 🔧 Configuración

### Variables de Entorno (.env)
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliografia
DB_USERNAME=biblioges
DB_PASSWORD=tu_password

LDAP_HOST=ldap://tu-servidor-ldap
LDAP_PORT=389
LDAP_BASE_DN=DC=ucn,DC=cl
LDAP_USERNAME=usuario_ldap
LDAP_PASSWORD=password_ldap

APP_URL=http://tu-dominio.com/
APP_DEBUG=true
```

### Configuración LDAP
El sistema está configurado para trabajar con Active Directory de la UCN. Asegúrate de configurar correctamente:
- Host del servidor LDAP
- Puerto (generalmente 389 para LDAP, 636 para LDAPS)
- Base DN de tu organización
- Credenciales de acceso

## 👥 Roles de Usuario

- **admin**: Acceso completo al sistema
- **admin_bidoc**: Administrador de bibliografía
- **usuario**: Usuario básico con acceso limitado

## 📊 Módulos Principales

### Gestión Académica
- **Sedes**: Administración de sedes universitarias
- **Facultades**: Gestión de facultades por sede
- **Departamentos**: Organización departamental
- **Carreras**: Gestión de carreras universitarias
- **Asignaturas**: Administración de asignaturas
- **Mallas**: Gestión de mallas curriculares

### Gestión de Bibliografías
- **Bibliografías Declaradas**: Bibliografías asignadas a asignaturas
- **Bibliografías Disponibles**: Catálogo de bibliografías disponibles
- **Autores**: Gestión de autores y fusión de duplicados

### Reportes
- **Cobertura**: Reportes de cobertura de bibliografías por carrera/asignatura
- **Listados**: Generación de listados de bibliografías
- **Exportación**: Exportación a Excel de reportes

## 🔒 Seguridad

- Autenticación mediante LDAP/Active Directory
- Validación de entrada de datos
- Protección contra inyección SQL (usando Eloquent ORM)
- Headers de seguridad configurados
- Validación de sesiones

## 🐛 Solución de Problemas

### Error de conexión LDAP
- Verificar configuración del servidor LDAP
- Comprobar credenciales y Base DN
- Verificar conectividad de red

### Error de permisos
```bash
chmod -R 755 /var/www/html/biblioges
chmod -R 777 /var/www/html/biblioges/storage
```

### Error de base de datos
- Verificar credenciales en .env
- Comprobar que la base de datos existe
- Ejecutar migraciones: `php database/migrate.php`

## 📝 Licencia

Este proyecto es propiedad de la Universidad Católica del Norte (UCN).

## 👨‍💻 Desarrolladores

- **Equipo de Desarrollo UCN**
- **Contacto**: [tu-email@ucn.cl]

## 🤝 Contribuciones

Para contribuir al proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

## 📞 Soporte

Para soporte técnico, contacta al equipo de desarrollo de la UCN. 