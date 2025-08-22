# Integración de Semantic Scholar API

## Descripción

Este documento describe la integración de Semantic Scholar API en el sistema de gestión de bibliografías UCN, que permite buscar artículos académicos y papers científicos como alternativa a las búsquedas en catálogo y Google.

## Características

### Funcionalidades Principales
- **Búsqueda de artículos académicos** con metadatos completos
- **Integración automática** en el flujo de búsqueda de bibliografías
- **Fallback inteligente** a otras fuentes cuando Semantic Scholar no está disponible
- **Soporte para API key** para mayor velocidad y límites de uso
- **Manejo robusto de errores** con mensajes informativos

### Metadatos Extraídos
- Título del artículo
- Autores (con nombres completos)
- Año de publicación
- Revista o venue de publicación
- URL del artículo
- Número de citas
- Abstract (resumen)
- ID único del paper

## Configuración

### Variables de Entorno

Agregar al archivo `.env`:

```env
# Configuración de Semantic Scholar API
SEMANTIC_SCHOLAR_API_KEY=tu_api_key_semantic_scholar
```

### Obtención de API Key

1. **Visitar:** https://www.semanticscholar.org/product/api#api-key-form
2. **Completar el formulario** con información básica
3. **Recibir la API key** por email (gratuita)
4. **Configurar** en el archivo `.env`

### Límites de Uso

#### Sin API Key (acceso público):
- **Rate limit:** Muy restrictivo (pocas consultas por minuto)
- **Funcionalidad:** Limitada
- **Recomendación:** Obtener API key para uso en producción

#### Con API Key:
- **Rate limit:** 1 request por segundo (configurable)
- **Funcionalidad:** Completa
- **Soporte:** Prioridad en soporte técnico

## Implementación Técnica

### Método Principal: `buscarEnSemanticScholar()`

```php
private function buscarEnSemanticScholar($titulo, $autor, $busquedaAdicional)
```

#### Parámetros:
- `$titulo`: Título del artículo a buscar
- `$autor`: Nombre del autor
- `$busquedaAdicional`: Términos adicionales de búsqueda

#### Proceso:
1. **Construcción de query** con términos de búsqueda
2. **Llamada a la API** con parámetros optimizados
3. **Procesamiento de respuesta** y extracción de metadatos
4. **Normalización de datos** para consistencia con el sistema

### Endpoint Utilizado

```
GET https://api.semanticscholar.org/graph/v1/paper/search
```

#### Parámetros de la API:
- `query`: Términos de búsqueda
- `limit`: Número máximo de resultados (10 por defecto)
- `fields`: Campos a retornar (title, authors, year, abstract, venue, url, citationCount, publicationVenue)

### Manejo de Errores

#### Códigos de Error Comunes:
- **429 (Too Many Requests):** Límite de velocidad excedido
- **403 (Forbidden):** API key inválida o acceso denegado
- **504 (Gateway Timeout):** Servicio temporalmente sobrecargado
- **500 (Internal Server Error):** Error interno del servidor

#### Estrategia de Fallback:
1. **Semantic Scholar** (primera opción)
2. **Google Scholar** (si Semantic Scholar falla)
3. **Google Books** (si Google Scholar falla)
4. **Google Tradicional** (última opción)

## Interfaz de Usuario

### Botón de Búsqueda

El botón de Semantic Scholar aparece en la interfaz de búsqueda de catálogo cuando no se encuentran resultados:

```html
<button type="button" class="btn btn-primary me-2" onclick="buscarEnSemanticScholar()">
    <i class="fas fa-search"></i> Buscar en Semantic Scholar
</button>
```

### Función JavaScript

```javascript
async function buscarEnSemanticScholar() {
    // Configuración de la búsqueda
    const formData = {
        titulo: document.getElementById('titulo').value,
        autor: document.getElementById('autor').value,
        busqueda_adicional: document.getElementById('busqueda_adicional').value,
        tipo_recurso: document.getElementById('tipo_recurso').value,
        fuente: 'semantic_scholar'
    };

    // Llamada a la API
    const response = await fetch('/bibliografias-declaradas/{id}/buscarGoogle/api', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    });

    // Procesamiento de resultados
    const data = await response.json();
    mostrarResultadosGoogle(data, 'Semantic Scholar');
}
```

## Flujo de Búsqueda

### Secuencia de Búsqueda Automática

1. **Búsqueda en Catálogo Local**
   - Si encuentra resultados → Mostrar resultados del catálogo
   - Si no encuentra resultados → Mostrar opciones de búsqueda alternativa

2. **Opciones de Búsqueda Alternativa**
   - **Semantic Scholar** (botón azul)
   - **Google Scholar** (botón amarillo)
   - **Google Books** (botón azul claro)

3. **Búsqueda Manual por Fuente**
   - Usuario puede elegir específicamente qué fuente usar
   - Cada fuente se ejecuta independientemente

4. **Fallback Automático**
   - Si una fuente falla, automáticamente intenta la siguiente
   - Proceso transparente para el usuario

## Ventajas de Semantic Scholar

### Para Investigadores
- **Metadatos académicos precisos** con información de citas
- **Enfoque en papers científicos** y artículos académicos
- **Información de impacto** (número de citas)
- **Abstracts completos** para evaluación de relevancia

### Para el Sistema
- **Complementa búsquedas de catálogo** con contenido académico
- **Mejora la cobertura** de bibliografías especializadas
- **Proporciona metadatos estructurados** para importación
- **Reduce dependencia** de Google para contenido académico

## Solución de Problemas

### Error 429 (Too Many Requests)

**Síntoma:** Mensaje de límite de velocidad excedido

**Solución:**
1. Obtener API key gratuita en: https://www.semanticscholar.org/product/api#api-key-form
2. Configurar la API key en el archivo `.env`
3. Reiniciar la aplicación

### Error 403 (Forbidden)

**Síntoma:** Acceso denegado

**Solución:**
1. Verificar que la API key esté correctamente configurada
2. Verificar que la API key sea válida
3. Contactar soporte de Semantic Scholar si persiste

### Sin Resultados

**Síntoma:** Búsqueda no retorna resultados

**Solución:**
1. Verificar términos de búsqueda (título, autor)
2. Probar con términos más específicos
3. Usar otras fuentes de búsqueda (Google Scholar, Google Books)

## Mantenimiento

### Monitoreo
- **Logs de error** en `/var/log/apache2/error.log`
- **Logs de aplicación** en `storage/logs/`
- **Métricas de uso** de la API

### Actualizaciones
- **Revisar documentación** de Semantic Scholar API regularmente
- **Actualizar endpoints** si cambian
- **Probar funcionalidad** después de actualizaciones del sistema

### Optimización
- **Cache de resultados** para búsquedas frecuentes
- **Compresión de requests** para reducir uso de ancho de banda
- **Búsqueda inteligente** con términos optimizados

## Referencias

- **Documentación oficial:** https://www.semanticscholar.org/product/api/tutorial
- **Solicitud de API key:** https://www.semanticscholar.org/product/api#api-key-form
- **Base de conocimientos:** https://www.semanticscholar.org/product/api
- **Comunidad:** Slack channel de Semantic Scholar API

## Changelog

### v1.0.0 (2025-08-18)
- ✅ Integración inicial de Semantic Scholar API
- ✅ Búsqueda de artículos académicos
- ✅ Extracción de metadatos completos
- ✅ Manejo de errores y fallback
- ✅ Interfaz de usuario integrada
- ✅ Documentación completa

### Próximas Mejoras
- 🔄 Cache de resultados para optimizar rendimiento
- 🔄 Búsqueda avanzada con filtros por año, revista, etc.
- 🔄 Importación automática de metadatos
- 🔄 Integración con DOI para identificación única
- 🔄 Análisis de impacto y relevancia
