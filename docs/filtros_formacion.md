# Funcionalidad de Filtros de Formación

## Descripción

Esta funcionalidad permite a los usuarios guardar y aplicar automáticamente filtros de tipos de formación en los reportes de cobertura básica y cobertura básica expandido.

## Características

- **Guardar Filtros**: Los usuarios pueden guardar la configuración actual de filtros de formación para una carrera específica
- **Aplicación Automática**: Los filtros guardados se aplican automáticamente cada vez que se carga el reporte
- **Persistencia**: Los filtros se almacenan en la base de datos y persisten entre sesiones

## Tabla de Base de Datos

### `filtros_formaciones`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `codigo_carrera` | VARCHAR(20) | Código de la carrera (clave primaria) |
| `basica` | INT | 1 si incluye Formación Básica, 0 si no |
| `general` | INT | 1 si incluye Formación General, 0 si no |
| `idioma` | INT | 1 si incluye Formación Idiomas, 0 si no |
| `profesional` | INT | 1 si incluye Formación Profesional, 0 si no |
| `valores` | INT | 1 si incluye Formación Valores, 0 si no |
| `especialidad` | INT | 1 si incluye Formación Especialidad, 0 si no |
| `especial` | INT | 1 si incluye Formación Especial, 0 si no |
| `fecha_creacion` | TIMESTAMP | Fecha de creación del registro |
| `fecha_actualizacion` | TIMESTAMP | Fecha de última actualización |

## Endpoints API

### Guardar Filtros
- **URL**: `POST /reportes/guardar-filtros-formacion/{sede_id}/{carrera_id}`
- **Descripción**: Guarda los filtros de formación para una carrera específica
- **Parámetros del cuerpo**:
  ```json
  {
    "filtros": ["FORMACION_BASICA", "FORMACION_GENERAL", ...]
  }
  ```
- **Respuesta exitosa**:
  ```json
  {
    "success": true,
    "message": "Filtros guardados correctamente para la carrera XXX",
    "codigo_carrera": "XXX",
    "filtros": ["FORMACION_BASICA", "FORMACION_GENERAL"]
  }
  ```

### Cargar Filtros
- **URL**: `GET /reportes/cargar-filtros-formacion/{sede_id}/{carrera_id}`
- **Descripción**: Carga los filtros guardados para una carrera específica
- **Respuesta exitosa**:
  ```json
  {
    "success": true,
    "filtros": ["FORMACION_BASICA", "FORMACION_GENERAL"],
    "codigo_carrera": "XXX"
  }
  ```

## Flujo de Funcionamiento

1. **Primera carga del reporte**: Si no hay filtros en la URL, el sistema busca filtros guardados en la base de datos
2. **Aplicación de filtros**: Los filtros guardados se aplican automáticamente al cargar el reporte
3. **Guardado de filtros**: El usuario puede hacer clic en "Guardar Filtros" para persistir la configuración actual
4. **Actualización**: Si ya existen filtros guardados, se actualizan con la nueva configuración

## Interfaz de Usuario

### Botón "Guardar Filtros"
- Ubicación: Junto al botón "Aplicar Filtros" en ambos reportes
- Icono: `fas fa-save`
- Color: Verde (`btn-success`)
- Funcionalidad: Guarda la configuración actual de filtros

### Mensajes de Confirmación
- **Éxito**: SweetAlert2 con mensaje de confirmación
- **Error**: SweetAlert2 con mensaje de error
- **Carga**: Indicador de carga mientras se procesa la petición

## Archivos Modificados

### Controladores
- `src/Controllers/ReporteController.php`
  - `guardarFiltrosFormacion()`: Método para guardar filtros
  - `cargarFiltrosFormacion()`: Método para cargar filtros
  - `reporteBibliografiaBasica()`: Modificado para cargar filtros automáticamente
  - `reporteBibliografiaBasicaExpandido()`: Modificado para cargar filtros automáticamente

### Rutas
- `src/routes.php`: Agregadas rutas para guardar y cargar filtros

### Plantillas
- `templates/reportes/coberturas/carrera.twig`: Agregado botón y JavaScript para guardar filtros
- `templates/reportes/coberturas/carrera_expandido.twig`: Agregado botón y JavaScript para guardar filtros

### Base de Datos
- `database/schema.sql`: Agregada definición de la tabla `filtros_formaciones`
- `database/create_filtros_formaciones.sql`: Script para crear la tabla en bases de datos existentes

## Instalación

1. Ejecutar el script SQL para crear la tabla:
   ```bash
   mysql -u root -p < database/create_filtros_formaciones.sql
   ```

2. Verificar que la tabla se creó correctamente:
   ```sql
   DESCRIBE filtros_formaciones;
   ```

## Uso

1. Navegar a un reporte de cobertura básica o cobertura básica expandido
2. Seleccionar los tipos de formación deseados
3. Hacer clic en "Guardar Filtros"
4. Confirmar la acción
5. Los filtros se aplicarán automáticamente en futuras cargas del reporte

## Notas Técnicas

- Los filtros se almacenan por código de carrera, no por ID de carrera
- La relación con `carreras_espejos` permite que los filtros persistan incluso si cambia la estructura de carreras
- Los filtros se aplican automáticamente solo si no hay filtros en la URL (para permitir filtros temporales)
- Se utiliza SweetAlert2 para las notificaciones, siguiendo el estándar del proyecto 