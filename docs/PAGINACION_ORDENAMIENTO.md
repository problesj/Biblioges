# Paginación y Ordenamiento en el Sistema Biblioges

## Descripción

Se han implementado funcionalidades de **paginación** y **ordenamiento** en el controlador de carreras para mejorar la experiencia del usuario y el rendimiento del sistema.

---

## Funcionalidades Implementadas

### 1. Paginación

#### Características:
- **Selector de registros por página** (5, 10, 15, 20 registros)
- **Navegación intuitiva** con botones "Anterior" y "Siguiente"
- **Números de página** con elipsis para páginas extensas
- **Contador de registros** mostrando "X de Y registros"
- **Preservación de filtros** al navegar entre páginas
- **Reset automático** a la primera página al cambiar registros por página

#### Parámetros URL:
- `page`: Número de página actual (ej: `?page=2`)
- `per_page`: Registros por página (ej: `?per_page=15`)

#### Ejemplo de uso:
```
https://biblioges.ucn.cl/biblioges/carreras?page=3&sort=nombre&direction=ASC&per_page=15
```

### 2. Ordenamiento

#### Columnas ordenables:
- **Nombre** (`nombre`)
- **Tipo de Programa** (`tipo_programa`)
- **Sede-Unidad** (`sede`)
- **Estado** (`estado`)
- **Cantidad de Semestres** (`cantidad_semestres`)

#### Características:
- **Ordenamiento ascendente/descendente** alternando al hacer clic
- **Íconos visuales** indicando el estado de ordenamiento:
  - `fa-sort`: Sin ordenamiento
  - `fa-sort-up`: Ordenamiento ascendente
  - `fa-sort-down`: Ordenamiento descendente
- **Preservación de filtros** al cambiar ordenamiento

#### Parámetros URL:
- `sort`: Columna por la cual ordenar
- `direction`: Dirección del ordenamiento (`ASC` o `DESC`)

#### Ejemplo de uso:
```
https://biblioges.ucn.cl/biblioges/carreras?sort=nombre&direction=DESC
```

---

## Implementación Técnica

### 1. Controlador (`CarreraController.php`)

#### Cambios principales:

```php
// Parámetros de paginación
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = intval($_GET['per_page'] ?? 10);

// Validar opciones de registros por página
$allowedPerPage = [5, 10, 15, 20];
if (!in_array($perPage, $allowedPerPage)) {
    $perPage = 10;
}

$offset = ($page - 1) * $perPage;

// Parámetros de ordenamiento
$sortColumn = $_GET['sort'] ?? 'nombre';
$sortDirection = strtoupper($_GET['direction'] ?? 'ASC');

// Validación de columnas permitidas
$allowedColumns = ['nombre', 'tipo_programa', 'estado', 'cantidad_semestres', 'sede'];

// Consulta para contar total de registros
$countSql = "SELECT COUNT(DISTINCT c.id) as total FROM carreras c...";

// Consulta principal con LIMIT y OFFSET
if ($sortColumn === 'sede') {
    // Para ordenar por sede, usamos MIN() para obtener la primera sede de cada carrera
    // Esto es compatible con ONLY_FULL_GROUP_BY de MySQL
    $sql .= " GROUP BY c.id ORDER BY MIN(s.nombre) {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
} else {
    $sql .= " GROUP BY c.id ORDER BY c.{$sortColumn} {$sortDirection} LIMIT {$perPage} OFFSET {$offset}";
}
```

#### Datos enviados a la vista:

```php
'paginacion' => [
    'current_page' => $currentPage,
    'per_page' => $perPage,
    'total_records' => $totalRecords,
    'total_pages' => $totalPages,
    'has_previous' => $currentPage > 1,
    'has_next' => $currentPage < $totalPages,
    'previous_page' => $currentPage - 1,
    'next_page' => $currentPage + 1,
    'allowed_per_page' => $allowedPerPage
],
'ordenamiento' => [
    'column' => $sortColumn,
    'direction' => $sortDirection
]
```

### 2. Template (`templates/carreras/index.twig`)

#### Encabezados ordenables:

```twig
<th>
    <a href="{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page) }}" class="text-white text-decoration-none">
        Nombre
        <i class="fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}"></i>
    </a>
</th>
```

#### Paginación:

```twig
{% if paginacion.total_pages > 1 %}
<nav aria-label="Navegación de páginas">
    <ul class="pagination justify-content-center">
        <!-- Botones Anterior/Siguiente -->
        <!-- Números de página -->
        <!-- Elipsis para páginas extensas -->
    </ul>
</nav>
{% endif %}
```

#### Selector de registros por página:

```twig
<div class="d-flex align-items-center gap-2">
    <label for="per_page" class="form-label mb-0 text-muted small">Registros por página:</label>
    <select id="per_page" class="form-select form-select-sm" style="width: auto;">
        {% for option in paginacion.allowed_per_page %}
            <option value="{{ option }}" {% if paginacion.per_page == option %}selected{% endif %}>
                {{ option }}
            </option>
        {% endfor %}
    </select>
</div>
```

### 3. Funciones Helper (Twig)

#### `build_sort_url()`:
Construye URLs para ordenamiento preservando filtros y paginación.

#### `build_page_url()`:
Construye URLs para paginación preservando ordenamiento y filtros.

#### `build_per_page_url()`:
Construye URLs para cambio de registros por página preservando ordenamiento y filtros.

#### `get_sort_icon()`:
Retorna el ícono apropiado según el estado de ordenamiento.

---

## Configuración

### Variables de entorno:
No se requieren configuraciones adicionales en `.env`.

### Base de datos:
No se requieren cambios en la estructura de la base de datos.

### Permisos:
No se requieren permisos especiales adicionales.

---

## Uso y Navegación

### Para usuarios:

1. **Ordenar por columna**: Hacer clic en el encabezado de la columna deseada
2. **Cambiar dirección**: Hacer clic nuevamente en la misma columna
3. **Navegar páginas**: Usar los botones de paginación al final de la tabla
4. **Cambiar registros por página**: Usar el selector en la parte superior derecha
5. **Aplicar filtros**: Los filtros se mantienen al ordenar y paginar

### Para desarrolladores:

1. **Agregar nueva columna ordenable**:
   - Agregar el nombre de la columna a `$allowedColumns`
   - Agregar el encabezado ordenable en el template

2. **Cambiar registros por página**:
   - Modificar la variable `$allowedPerPage` en el controlador
   - Actualizar las opciones en el template

3. **Personalizar paginación**:
   - Modificar el template `templates/carreras/index.twig`

---

## Beneficios

### Rendimiento:
- **Menor carga de memoria** al cargar solo registros necesarios por vez
- **Consultas SQL optimizadas** con LIMIT y OFFSET
- **Mejor tiempo de respuesta** en listados extensos

### Experiencia de usuario:
- **Navegación intuitiva** con controles visuales claros
- **Ordenamiento flexible** por múltiples columnas
- **Preservación de contexto** al navegar entre páginas
- **Información clara** sobre la cantidad de registros
- **Selector de registros por página** para personalizar la vista

### Mantenibilidad:
- **Código reutilizable** con funciones helper
- **Separación de responsabilidades** entre controlador y vista
- **Fácil extensión** para otros módulos

---

## Compatibilidad

### Navegadores:
- ✅ Chrome/Chromium
- ✅ Firefox
- ✅ Safari
- ✅ Edge

### Dispositivos:
- ✅ Desktop
- ✅ Tablet
- ✅ Mobile (responsive)

---

## Próximas Mejoras

### Funcionalidades planificadas:
1. **Búsqueda en tiempo real** con AJAX
2. **Exportación de datos paginados**
3. **Ordenamiento múltiple** (múltiples columnas)
4. **Filtros avanzados** con rangos de fechas
5. **Vista de tarjetas** como alternativa a la tabla

### Optimizaciones técnicas:
1. **Caché de consultas** para mejorar rendimiento
2. **Lazy loading** para imágenes
3. **Infinite scroll** como alternativa a paginación
4. **WebSockets** para actualizaciones en tiempo real

---

## Soporte

Para reportar problemas o solicitar mejoras relacionadas con paginación y ordenamiento, contactar al equipo de desarrollo con:

- **Descripción del problema**
- **Pasos para reproducir**
- **Navegador y versión**
- **Capturas de pantalla** (si aplica)