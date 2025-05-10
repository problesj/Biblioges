# Sistema de Gestión de Bibliografía

Sistema web para la gestión de bibliografía académica, desarrollado para la Universidad Nacional de Córdoba.

## Características

- Gestión de bibliografías declaradas
- Administración de asignaturas y departamentos
- Control de autores y sus obras
- Sistema de mallas curriculares
- Gestión de usuarios y roles
- Reportes y estadísticas

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Composer
- Node.js y NPM (para assets)

## Instalación

1. Clonar el repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd biblioges
```

2. Instalar dependencias:
```bash
composer install
npm install
```

3. Configurar el entorno:
```bash
cp .env.example .env
# Editar .env con los datos de conexión a la base de datos
```

4. Crear la base de datos:
```bash
mysql -u root -p < database/schema.sql
```

5. Iniciar el servidor:
```bash
php -S localhost:8000 -t public
```

## Estructura del Proyecto

```
biblioges/
├── config/             # Configuraciones
├── database/          # Migraciones y seeds
├── public/            # Punto de entrada y assets
├── src/              # Código fuente
│   ├── Controllers/  # Controladores
│   ├── Models/       # Modelos
│   └── Views/        # Vistas
└── templates/        # Plantillas Twig
```

## Licencia

Este proyecto es privado y confidencial. Todos los derechos reservados.

## Contacto

Para más información, contactar al administrador del sistema. 