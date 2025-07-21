# Frontend - Sistema de Bibliografías UCN

Este es el frontend público del sistema de bibliografías de la Universidad Católica del Norte. Permite a los usuarios consultar las bibliografías de las diferentes carreras organizadas por sede.

## Características

- **Interfaz pública**: Acceso sin autenticación para consulta de bibliografías
- **Navegación por sede y carrera**: Organización jerárquica de la información
- **Vistas detalladas**: Información completa de bibliografías por asignatura
- **Diseño responsive**: Compatible con dispositivos móviles y de escritorio
- **Tipos de bibliografía**: Separación entre bibliografía básica y complementaria
- **Información de disponibilidad**: Indicadores de disponibilidad en biblioteca

## Estructura de Archivos

```
view/
├── index.php              # Punto de entrada principal
├── routes.php             # Definición de rutas del frontend
├── .htaccess              # Configuración de Apache
└── README.md              # Este archivo
```

## Rutas Disponibles

- `/` - Página principal con listado de sedes y carreras
- `/carrera/{sede_id}/{carrera_id}` - Bibliografías de una carrera específica
- `/asignatura/{sede_id}/{carrera_id}/{asignatura_id}` - Detalles de una asignatura

## Tecnologías Utilizadas

- **PHP 8.0+** - Backend
- **Slim Framework 4** - Framework de rutas
- **Twig** - Motor de plantillas
- **Bootstrap 5** - Framework CSS
- **Font Awesome** - Iconografía
- **Eloquent ORM** - Acceso a base de datos

## Instalación y Configuración

1. Asegúrate de que el backend esté configurado correctamente
2. Verifica que las dependencias de Composer estén instaladas
3. Configura el archivo `.env` con las credenciales de base de datos
4. Asegúrate de que Apache tenga habilitado `mod_rewrite`

## Acceso

El frontend estará disponible en la raíz del sitio web:
- **URL**: `http://<servidor>/`
- **Administración**: `http://<servidor>/biblioges/`

## Funcionalidades

### Página Principal
- Listado de todas las sedes activas
- Estadísticas del sistema
- Información sobre tipos de bibliografía
- Navegación a carreras por sede

### Vista de Carrera
- Información general de la carrera
- Asignaturas organizadas por semestre
- Bibliografías básicas y complementarias
- Enlaces a vistas detalladas de asignaturas

### Vista de Asignatura
- Información completa de la asignatura
- Detalles de cada bibliografía
- Información de autores, editoriales, años
- Indicadores de disponibilidad en biblioteca
- Enlaces a recursos externos

## Personalización

### Estilos CSS
Los estilos están definidos en `templates/frontend/base.twig` y pueden ser personalizados modificando las variables CSS:

```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;
    --light-gray: #ecf0f1;
    --dark-gray: #34495e;
}
```

### Plantillas
Las plantillas están ubicadas en `templates/frontend/`:
- `base.twig` - Layout principal
- `index.twig` - Página principal
- `carrera.twig` - Vista de carrera
- `asignatura.twig` - Vista de asignatura

## Mantenimiento

### Logs
Los logs de errores se guardan en `../storage/logs/php-error.log`

### Caché
El caché de Twig se almacena en `../cache/twig/`

### Base de Datos
El frontend utiliza la misma base de datos que el backend, accediendo a las siguientes tablas principales:
- `sedes`
- `carreras`
- `carreras_espejos`
- `asignaturas`
- `mallas`
- `bibliografias_declaradas`
- `asignaturas_bibliografias`
- `autores`
- `bibliografias_autores`

## Soporte

Para reportar problemas o solicitar mejoras, contacta al equipo de desarrollo del sistema de bibliografías UCN. 