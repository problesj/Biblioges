# Sistema de Gestión de Bibliografías Universitarias

Sistema web para gestionar y generar reportes de bibliografías de carreras universitarias.

## Requisitos

- PHP 8.0 o superior
- PostgreSQL 12 o superior
- Composer
- Node.js y npm (para el frontend)

## Instalación

1. Clonar el repositorio:
```bash
git clone [url-del-repositorio]
cd bibliografia
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Configurar variables de entorno:
```bash
cp .env.example .env
```
Editar el archivo `.env` con los datos de conexión a la base de datos y otras configuraciones.

4. Crear la base de datos:
```bash
psql -U postgres
CREATE DATABASE bibliografia;
\q
```

5. Ejecutar migraciones:
```bash
psql -U postgres -d bibliografia -f database/schema.sql
```

6. Instalar dependencias del frontend:
```bash
cd public
npm install
```

## Estructura del Proyecto

```
bibliografia/
├── public/             # Archivos públicos y frontend
├── src/                # Código fuente PHP
│   ├── Controllers/    # Controladores
│   ├── Models/         # Modelos
│   ├── Middleware/     # Middleware
│   └── config/         # Configuraciones
├── templates/          # Plantillas Twig
├── database/           # Scripts de base de datos
└── vendor/            # Dependencias PHP
```

## Uso

1. Iniciar el servidor de desarrollo:
```bash
php -S localhost:8000 -t public
```

2. Acceder a la aplicación:
```
http://localhost:8000
```

## Funcionalidades

- Gestión de carreras (pregrado y postgrado)
- Gestión de asignaturas
- Gestión de bibliografías
- Reportes de cobertura por asignatura y carrera
- Sistema de autenticación y autorización
- Interfaz responsiva

## Roles de Usuario

- Administrador: Acceso total al sistema
- Administrador de Bibliografías: Gestión de bibliografías
- Usuario: Consulta de reportes

## API Endpoints

### Autenticación
- POST /auth/login
- POST /auth/logout

### Carreras
- GET /carreras
- GET /carreras/{id}
- POST /carreras
- PUT /carreras/{id}
- DELETE /carreras/{id}

### Asignaturas
- GET /asignaturas
- GET /asignaturas/{codigo}
- POST /asignaturas
- PUT /asignaturas/{codigo}
- DELETE /asignaturas/{codigo}

### Bibliografías
- GET /bibliografias
- GET /bibliografias/{id}
- POST /bibliografias
- PUT /bibliografias/{id}
- DELETE /bibliografias/{id}

### Reportes
- GET /reportes/cobertura-asignatura/{codigo}
- GET /reportes/cobertura-carrera/{id}

## Licencia

Este proyecto está bajo la Licencia MIT. 