# Manejo de Estado en Sesión para Listados

## Descripción

Se ha implementado un sistema para guardar y restaurar el estado de los listados (filtros, paginación, ordenamiento) en variables de sesión, mejorando significativamente la experiencia del usuario al mantener sus preferencias entre navegaciones.

---

## Componentes Implementados

### 1. ListStateManager (`src/Core/ListStateManager.php`)

Clase principal que maneja el estado de los listados:

#### Características:
- **Persistencia automática**: Guarda automáticamente el estado en sesión
- **Restauración inteligente**: Combina estado guardado con parámetros de URL
- **Validación robusta**: Valida todos los parámetros antes de aplicarlos
- **Configuración por listado**: Diferentes configuraciones según el tipo de listado

#### Métodos principales:
- `getState(array $urlParams)`: Obtiene estado combinando sesión y URL
- `saveState(array $state)`: Guarda estado en sesión
- `clearState()`: Limpia estado guardado
- `buildUrl(array $additionalParams)`: Construye URL con parámetros
- `buildSortUrl(string $column)`: Construye URL para ordenamiento
- `buildPageUrl(int $page)`: Construye URL para paginación
- `getSortIcon(string $column)`: Obtiene ícono de ordenamiento

### 2. Configuración de Twig (`src/config/twig.php`)

Funciones helper agregadas para facilitar el manejo en templates:

#### Funciones disponibles:
- `build_sort_url()`: Construye URL para ordenamiento
- `get_sort_icon()`: Obtiene ícono de ordenamiento
- `build_page_url()`: Construye URL para paginación
- `build_per_page_url()`: Construye URL para cambio de registros por página

---

## Implementación en Controladores

### Ejemplo: CarreraController

```php
public function index(Request $request, Response $response, array $args = [])
{
    // Inicializar el gestor de estado
    $stateManager = new ListStateManager($this->session, 'carreras');
    
    // Obtener parámetros de la URL
    $urlParams = $_GET;
    
    // Obtener estado (combinando sesión y URL)
    $state = $stateManager->getState($urlParams);
    
    // Guardar estado en sesión
    $stateManager->saveState($state);
    
    // Extraer parámetros del estado
    $page = $state['page'];
    $perPage = $state['per_page'];
    $sortColumn = $state['sort'];
    $sortDirection = $state['direction'];
    
    // Aplicar filtros desde el estado
    if (!empty($state['nombre'])) {
        $sql .= " AND c.nombre LIKE ?";
        $params[] = '%' . $state['nombre'] . '%';
    }
    
    // ... resto de la lógica
    
    // Pasar stateManager a la vista
    $viewData = [
        'stateManager' => $stateManager,
        'filtros' => [
            'nombre' => $state['nombre'],
            'tipo_programa' => $state['tipo_programa'],
            // ...
        ]
    ];
}
```

---

## Configuración por Tipo de Listado

### Carreras
```php
'defaults' => [
    'sort' => 'nombre',
    'allowed_columns' => ['nombre', 'tipo_programa', 'estado', 'cantidad_semestres', 'sede'],
    'filters' => [
        'nombre' => '',
        'tipo_programa' => '',
        'sede' => '',
        'estado' => ''
    ]
]
```

### Asignaturas
```php
'defaults' => [
    'sort' => 'nombre',
    'allowed_columns' => ['nombre', 'tipo', 'estado', 'periodicidad', 'unidad'],
    'filters' => [
        'nombre' => '',
        'tipo' => '',
        'unidad' => '',
        'estado' => ''
    ]
]
```

### Bibliografías
```php
'defaults' => [
    'sort' => 'titulo',
    'allowed_columns' => ['titulo', 'tipo', 'estado', 'autores', 'asignaturas', 'anio_publicacion'],
    'filters' => [
        'busqueda' => '',
        'tipo_busqueda' => 'todos',
        'tipo' => '',
        'estado' => ''
    ]
]
```

---

## Uso en Templates

### Encabezados ordenables
```twig
<th>
    <a href="{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page) }}">
        Nombre
        <i class="fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}"></i>
    </a>
</th>
```

### Paginación
```twig
{% if paginacion.has_previous %}
    <li class="page-item">
        <a class="page-link" href="{{ build_page_url(paginacion.previous_page, filtros, ordenamiento.column, ordenamiento.direction, paginacion.per_page) }}">
            Anterior
        </a>
    </li>
{% endif %}
```

### Selector de registros por página
```twig
<select id="per_page" class="form-select form-select-sm">
    {% for option in paginacion.allowed_per_page %}
        <option value="{{ option }}" {% if paginacion.per_page == option %}selected{% endif %}>
            {{ option }}
        </option>
    {% endfor %}
</select>
```

---

## Beneficios

### 1. Experiencia de Usuario Mejorada
- **Persistencia de preferencias**: Los usuarios mantienen sus filtros y ordenamiento
- **Navegación fluida**: No se pierde el estado al navegar entre páginas
- **Consistencia**: Comportamiento uniforme en todos los listados

### 2. Funcionalidad Avanzada
- **Filtros múltiples**: Soporte para múltiples filtros simultáneos
- **Ordenamiento inteligente**: Cambio de dirección al hacer clic en la misma columna
- **Paginación preservada**: Mantiene filtros al cambiar de página

### 3. Mantenibilidad
- **Código reutilizable**: Una sola clase maneja todos los listados
- **Configuración centralizada**: Fácil personalización por tipo de listado
- **Validación automática**: Previene errores de parámetros inválidos

---

## Implementación en Otros Controladores

Para implementar en otros controladores, seguir el mismo patrón:

1. **Importar la clase**:
```php
use App\Core\ListStateManager;
```

2. **Inicializar en el método index**:
```php
$stateManager = new ListStateManager($this->session, 'nombre_listado');
$state = $stateManager->getState($_GET);
$stateManager->saveState($state);
```

3. **Usar parámetros del estado**:
```php
$page = $state['page'];
$perPage = $state['per_page'];
// ... aplicar filtros desde $state
```

4. **Pasar a la vista**:
```php
$viewData['stateManager'] = $stateManager;
```

---

## Consideraciones Técnicas

### Seguridad
- **Validación de parámetros**: Todos los parámetros se validan antes de usar
- **Límites de paginación**: Valores mínimos y máximos controlados
- **Columnas permitidas**: Solo columnas válidas para ordenamiento

### Rendimiento
- **Sesión eficiente**: Solo se guardan parámetros necesarios
- **URLs limpias**: Parámetros vacíos se filtran automáticamente
- **Validación rápida**: Validación optimizada para cada tipo de listado

### Compatibilidad
- **URLs existentes**: Compatible con URLs actuales
- **Fallbacks**: Valores por defecto para parámetros faltantes
- **Migración gradual**: Se puede implementar sin afectar funcionalidad existente
