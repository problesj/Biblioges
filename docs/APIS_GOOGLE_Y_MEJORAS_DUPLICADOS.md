# APIs de Google y Mejoras en Duplicados de Autores

## Descripción General

Este documento describe las nuevas funcionalidades implementadas en el sistema de gestión de bibliografías, incluyendo la integración con APIs de Google (Scholar y Books) y las mejoras significativas en la detección y gestión de duplicados de autores.

## APIs de Google Integradas

### 1. Google Scholar API

#### Funcionalidad
- **Búsqueda académica avanzada** en Google Scholar
- **Extracción automática** de metadatos de artículos académicos
- **Filtrado inteligente** de resultados por relevancia
- **Procesamiento de HTML** para extraer información estructurada

#### Características Técnicas
```php
private function buscarEnGoogleScholar($titulo, $autor, $busquedaAdicional) {
    // Construcción de consulta optimizada
    $query = implode(' ', $searchTerms);
    
    // Búsqueda directa en Google Scholar
    return $this->buscarEnGoogleWeb($query);
}
```

#### Procesamiento de Respuestas
- **Extracción de títulos** usando expresiones regulares mejoradas
- **Identificación de autores** en múltiples formatos
- **Detección de años** de publicación
- **Filtrado de resultados** por calidad académica

#### Configuración
```env
# Variables de entorno para Google Scholar
GOOGLE_SCHOLAR_ENABLED=true
GOOGLE_SCHOLAR_MAX_RESULTS=10
GOOGLE_SCHOLAR_LANGUAGE=es
```

### 2. Google Books API

#### Funcionalidad
- **Búsqueda de libros** usando la API oficial de Google Books
- **Extracción de metadatos** completos (título, autores, editorial, año)
- **Enlaces de vista previa** para libros disponibles
- **Filtrado por idioma** y tipo de publicación

#### Características Técnicas
```php
private function buscarEnGoogleBooks($titulo, $autor, $busquedaAdicional) {
    $url = "https://www.googleapis.com/books/v1/volumes?" .
           "q=" . urlencode($query) .
           "&langRestrict=es" .
           "&maxResults=10" .
           "&printType=books";
}
```

#### Metadatos Extraídos
- **Título del libro**
- **Autores** (múltiples autores separados por punto y coma)
- **Año de publicación**
- **Editorial**
- **Descripción** del libro
- **Enlace de vista previa**

#### Configuración
```env
# Variables de entorno para Google Books
GOOGLE_BOOKS_ENABLED=true
GOOGLE_BOOKS_MAX_RESULTS=10
GOOGLE_BOOKS_LANGUAGE=es
```

### 3. Google Custom Search API (Opcional)

#### Funcionalidad
- **Búsqueda web personalizada** usando Google Custom Search
- **Configuración de motor de búsqueda** personalizado
- **Filtrado por dominio** específico
- **Resultados más precisos** para búsquedas académicas

#### Configuración
```env
# Variables de entorno para Google Custom Search
GOOGLE_API_KEY=tu_api_key_aqui
GOOGLE_SEARCH_ENGINE_ID=tu_search_engine_id
GOOGLE_CUSTOM_SEARCH_ENABLED=true
```

## Mejoras en Detección de Duplicados de Autores

### 1. Algoritmo Ultra-Optimizado

#### Características Principales
- **Indexación avanzada** de patrones de nombres
- **Detección de similitud** usando múltiples algoritmos
- **Procesamiento por lotes** para evitar timeouts
- **Paginación inteligente** de resultados

#### Implementación Técnica
```php
private function buscarDuplicadosOptimizado($pagina = 1, $porPagina = 50) {
    // Paso 1: Obtener autores en lotes pequeños
    $autores = Autor::where('nombres', '!=', 'Sin nombre')
        ->select('id', 'nombres', 'apellidos', 'genero')
        ->limit(500)
        ->get();
    
    // Paso 2: Crear índices de patrones
    $indices = $this->crearIndicesPatrones($autores);
    
    // Paso 3: Encontrar grupos usando índices
    $grupos = $this->encontrarGruposConIndices($indices);
    
    // Paso 4: Aplicar paginación
    $gruposPaginados = array_slice($grupos, $offset, $porPagina, true);
}
```

### 2. Generación de Patrones de Similitud

#### Patrones de Nombres
```php
private function generarHashNombre($nombres) {
    // Patrón 1: Primer nombre (3 caracteres)
    $patrones[] = 'p1:' . substr($palabras[0], 0, 3);
    
    // Patrón 2: Primer nombre completo
    $patrones[] = 'p2:' . $palabras[0];
    
    // Patrón 3: Nombres completos
    $patrones[] = 'p3:' . $nombres;
    
    // Patrón 4: Iniciales
    $patrones[] = 'p4:' . $iniciales;
}
```

#### Patrones de Apellidos
```php
private function generarHashApellido($apellidos) {
    // Patrón 1: Primer apellido (3 caracteres)
    $patrones[] = 'a1:' . substr($palabras[0], 0, 3);
    
    // Patrón 2: Primer apellido completo
    $patrones[] = 'a2:' . $palabras[0];
    
    // Patrón 3: Apellidos completos
    $patrones[] = 'a3:' . $apellidos;
    
    // Patrón 4: Iniciales de apellidos
    $patrones[] = 'a4:' . $iniciales;
}
```

### 3. Sistema de Variaciones de Autores

#### Gestión de Alias
- **Registro de variaciones** de nombres de autores
- **Búsqueda por variaciones** para encontrar duplicados
- **Fusión automática** de registros duplicados
- **Preservación de referencias** durante la fusión

#### Funcionalidades
```php
// Búsqueda por variación de nombre
public function buscarPorVariacion($request, $response, $args)

// Agregar nueva variación
public function agregarVariacion($request, $response, $args)

// Eliminar variación
public function eliminarVariacion($request, $response, $args)

// Fusión de autores duplicados
public function fusionar($request, $response, $args)
```

## Nuevas Búsquedas Integradas

### 1. Búsqueda Combinada Google Scholar + Books

#### Flujo de Búsqueda
1. **Búsqueda en Google Scholar** (prioridad alta)
2. **Búsqueda en Google Books** (si no hay resultados en Scholar)
3. **Filtrado y ordenamiento** de resultados
4. **Presentación unificada** de resultados

#### Implementación
```php
private function buscarEnGoogle($titulo, $autor, $busquedaAdicional) {
    // Construir consulta optimizada
    $query = implode(' ', $searchTerms);
    
    // Primero intentar con Google Scholar
    $googleScholarResults = $this->buscarEnGoogleWeb($query);
    if (!empty($googleScholarResults)) {
        return $googleScholarResults;
    }
    
    // Si no hay resultados, intentar con Google Books
    $googleBooksResults = $this->buscarEnGoogleBooks($titulo, $autor, $busquedaAdicional);
    if (!empty($googleBooksResults)) {
        return $googleBooksResults;
    }
    
    return [];
}
```

### 2. Extracción Inteligente de Metadatos

#### Procesamiento de Autores
```php
private function procesarAutor($autor, $context, $adaptor) {
    // Procesamiento específico por fuente
    if ($context === 'PC' && $adaptor === 'Primo Central') {
        // Procesamiento para Primo Central
        $partes = explode(',', $autor);
        $apellidos = trim($partes[0]);
        $nombres = trim($partes[1]);
    } else {
        // Procesamiento genérico
        $partes = explode(',', $autor);
        if (count($partes) >= 2) {
            $apellidos = trim($partes[0]);
            $nombres = trim($partes[1]);
        } else {
            $nombres = $autor;
        }
    }
}
```

#### Extracción de Años
```php
private function extraerAnioDeTexto($texto) {
    if (preg_match('/(19|20)\d{2}/', $texto, $matches)) {
        return $matches[0];
    }
    return '';
}
```

## Configuración del Sistema

### 1. Variables de Entorno Requeridas

```env
# Configuración de APIs de Google
GOOGLE_API_KEY=tu_api_key_aqui
GOOGLE_SEARCH_ENGINE_ID=tu_search_engine_id
GOOGLE_SCHOLAR_ENABLED=true
GOOGLE_BOOKS_ENABLED=true
GOOGLE_CUSTOM_SEARCH_ENABLED=false

# Configuración de búsquedas
GOOGLE_SCHOLAR_MAX_RESULTS=10
GOOGLE_BOOKS_MAX_RESULTS=10
GOOGLE_SEARCH_LANGUAGE=es

# Configuración de duplicados
DUPLICADOS_AUTORES_ENABLED=true
DUPLICADOS_PAGINA_SIZE=50
DUPLICADOS_SIMILITUD_MINIMA=0.8
```

### 2. Configuración de Base de Datos

#### Tabla de Alias de Autores
```sql
CREATE TABLE alias_autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    autor_id INT NOT NULL,
    nombre_variacion VARCHAR(255) NOT NULL,
    tipo_variacion ENUM('nombre', 'apellido', 'completo') DEFAULT 'completo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE,
    INDEX idx_autor_id (autor_id),
    INDEX idx_nombre_variacion (nombre_variacion)
);
```

## Rutas API Implementadas

### 1. Búsquedas de Google
```
POST /bibliografias-declaradas/{id}/buscarGoogle/api
```

### 2. Gestión de Duplicados
```
GET /autores/{id}/duplicados
POST /autores/buscar-variaciones-fusion
POST /autores/{id}/fusionar
```

### 3. Gestión de Variaciones
```
GET /autores/{id}/variaciones
POST /autores/{id}/variaciones
DELETE /autores/{autor_id}/variaciones/{alias_id}
GET /autores/buscar-variacion
```

## Mejoras de Rendimiento

### 1. Optimización de Consultas
- **Índices optimizados** para búsquedas de autores
- **Consultas paginadas** para evitar timeouts
- **Caché de resultados** de búsquedas frecuentes
- **Procesamiento asíncrono** para tareas pesadas

### 2. Gestión de Memoria
- **Procesamiento por lotes** de 500 autores máximo
- **Limpieza automática** de datos temporales
- **Optimización de expresiones regulares**
- **Reducción de consultas** a la base de datos

## Monitoreo y Logs

### 1. Logs de Búsquedas
```php
error_log('Búsqueda en Google Scholar: ' . $query);
error_log('Resultados encontrados: ' . count($results));
error_log('Error en búsqueda: ' . $e->getMessage());
```

### 2. Logs de Duplicados
```php
error_log('Procesando duplicados - Página: ' . $pagina);
error_log('Grupos encontrados: ' . count($grupos));
error_log('Fusión completada - Autor ID: ' . $autorId);
```

## Solución de Problemas

### 1. Errores Comunes de APIs

#### Error de API Key
```bash
# Verificar configuración
echo $GOOGLE_API_KEY
php -r "echo getenv('GOOGLE_API_KEY');"
```

#### Error de Rate Limiting
```php
// Implementar retry con backoff exponencial
private function retryWithBackoff($callback, $maxRetries = 3) {
    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            return $callback();
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '429') !== false) {
                sleep(pow(2, $i)); // Backoff exponencial
                continue;
            }
            throw $e;
        }
    }
}
```

### 2. Errores de Duplicados

#### Timeout en Búsqueda
```php
// Reducir tamaño de lote
$autores = Autor::where('nombres', '!=', 'Sin nombre')
    ->select('id', 'nombres', 'apellidos', 'genero')
    ->limit(250) // Reducir de 500 a 250
    ->get();
```

#### Memoria Insuficiente
```php
// Limpiar memoria después de cada lote
gc_collect_cycles();
unset($indices);
unset($grupos);
```

## Próximas Mejoras

### 1. Funcionalidades Planificadas
- **Integración con Scopus API** para búsquedas académicas adicionales
- **Machine Learning** para detección automática de duplicados
- **Sincronización con ORCID** para autores académicos
- **API REST completa** para integración con sistemas externos

### 2. Optimizaciones Técnicas
- **Implementación de Redis** para caché de búsquedas
- **Procesamiento paralelo** de búsquedas múltiples
- **Compresión de respuestas** para mejorar rendimiento
- **Monitoreo en tiempo real** de uso de APIs

## Contacto y Soporte

Para dudas sobre las nuevas funcionalidades:
- **Equipo de desarrollo:** [contacto]
- **Documentación técnica:** Ver carpeta `docs/`
- **Issues y bugs:** [repositorio del proyecto]

---

**Versión del documento:** 1.0  
**Última actualización:** Diciembre 2024  
**Autor:** Equipo de Desarrollo Biblioges 