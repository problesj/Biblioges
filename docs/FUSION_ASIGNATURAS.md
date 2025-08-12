# Fusión de Asignaturas - Sistema BIBLIOGES

## Descripción General

La funcionalidad de **Fusión de Asignaturas** permite combinar dos asignaturas de una carrera, transfiriendo bibliografías declaradas y códigos de asignatura de una asignatura a otra. Esta funcionalidad es útil para consolidar asignaturas similares o reorganizar la estructura curricular.

## Características Principales

- **Selección Inteligente**: Permite seleccionar una asignatura principal y una asignatura a fusionar
- **Gestión de Bibliografías**: Identifica automáticamente bibliografías duplicadas y permite decidir cómo manejarlas
- **Preservación de Datos**: Mantiene la integridad de los datos durante el proceso de fusión
- **Interfaz Intuitiva**: Proceso paso a paso con confirmaciones en cada etapa
- **Transacciones Seguras**: Utiliza transacciones de base de datos para garantizar la consistencia

## Proceso de Fusión

### Paso 1: Selección de Asignaturas
- **Asignatura Principal**: La asignatura que mantendrá su identidad y recibirá los elementos de la otra
- **Asignatura a Fusionar**: La asignatura que será consolidada en la principal

### Paso 2: Revisión de Bibliografías
- **Bibliografías de la Principal**: Se muestran las bibliografías ya vinculadas
- **Bibliografías a Fusionar**: Se muestran las bibliografías de la asignatura a fusionar
- **Detección Automática**: Se identifican bibliografías duplicadas por título
- **Opciones de Acción**:
  - **Fusionar**: Vincular la bibliografía a la asignatura principal
  - **Mantener**: La bibliografía permanece solo en la asignatura a fusionar
  - **Eliminar**: Se elimina la vinculación de la bibliografía con la asignatura a fusionar

### Paso 2.5: Revisión de Mallas Vinculadas
- **Mallas de la Principal**: Se muestran todas las carreras donde aparece la asignatura principal
- **Mallas a Fusionar**: Se muestran todas las carreras donde aparece la asignatura a fusionar
- **Identificación de Otras Mallas**: Se detectan automáticamente si la asignatura a fusionar está en otras mallas
- **Información Detallada**: Códigos de carrera, semestres y nombres de carreras

### Paso 3: Confirmación y Procesamiento
- **Resumen de la Fusión**: Muestra los detalles de ambas asignaturas
- **Consulta sobre Otras Mallas**: Si la asignatura a fusionar está en otras mallas, se consulta al usuario
- **Confirmación**: Requiere confirmación explícita del usuario
- **Procesamiento**: Ejecuta la fusión en la base de datos

## Tablas Involucradas

### Tablas Principales
- **`mallas`**: Relación entre carreras y asignaturas
- **`asignaturas`**: Información básica de las asignaturas
- **`asignaturas_departamentos`**: Códigos de asignatura por departamento
- **`asignaturas_bibliografias`**: Vinculación entre asignaturas y bibliografías declaradas
- **`asignaturas_formacion`**: Relaciones jerárquicas entre asignaturas

### Tablas de Soporte
- **`carreras`**: Información de las carreras
- **`bibliografias_declaradas`**: Bibliografías del sistema
- **`unidades`**: Departamentos donde se dictan las asignaturas

## Flujo de Datos

### 1. Gestión de Bibliografías
```sql
-- Opción 1: Fusionar - Vincular bibliografía a la asignatura principal
INSERT INTO asignaturas_bibliografias 
(asignatura_id, bibliografia_id, tipo_bibliografia, estado) 
SELECT ?, bibliografia_id, tipo_bibliografia, estado 
FROM asignaturas_bibliografias 
WHERE asignatura_id = ? AND bibliografia_id = ?
ON DUPLICATE KEY UPDATE 
tipo_bibliografia = VALUES(tipo_bibliografia),
estado = VALUES(estado)

-- Opción 2: Mantener - No hacer nada (la bibliografía permanece solo en la asignatura original)

-- Opción 3: Eliminar - Eliminar la vinculación de la bibliografía
DELETE FROM asignaturas_bibliografias 
WHERE asignatura_id = ? AND bibliografia_id = ?
```

### 2. Transferencia de Códigos
```sql
-- Agregar códigos de la asignatura a fusionar a la principal
INSERT INTO asignaturas_departamentos 
(asignatura_id, id_unidad, codigo_asignatura, cantidad_alumnos) 
SELECT ?, id_unidad, ?, cantidad_alumnos 
FROM asignaturas_departamentos 
WHERE asignatura_id = ? AND codigo_asignatura = ?
ON DUPLICATE KEY UPDATE 
codigo_asignatura = VALUES(codigo_asignatura)
```

### 3. Actualización de la Malla
```sql
-- Opción A: Solo malla actual
UPDATE mallas 
SET asignatura_id = ? 
WHERE carrera_id = ? AND asignatura_id = ?

-- Eliminar la asignatura a fusionar de la malla actual
DELETE FROM mallas 
WHERE carrera_id = ? AND asignatura_id = ?

-- Opción B: Todas las mallas (si se continúa con otras mallas)
UPDATE mallas 
SET asignatura_id = ? 
WHERE asignatura_id = ?
```

## Consideraciones de Seguridad

### Validaciones Implementadas
- **Autenticación**: Solo usuarios autenticados pueden acceder
- **Autorización**: Verificación de permisos de usuario
- **Transacciones**: Rollback automático en caso de error
- **Confirmación**: Requiere confirmación explícita del usuario

### Prevención de Errores
- **Verificación de Existencia**: Valida que ambas asignaturas existan
- **Prevención de Duplicados**: Maneja conflictos de claves únicas
- **Integridad Referencial**: Mantiene las relaciones de base de datos

## Casos de Uso

### 1. Consolidación de Asignaturas Similares
- **Escenario**: Dos asignaturas con contenido similar pero códigos diferentes
- **Beneficio**: Elimina redundancia y simplifica la gestión curricular

### 2. Reorganización Curricular
- **Escenario**: Cambio en la estructura de una carrera
- **Beneficio**: Permite adaptar la malla sin perder información histórica

### 3. Corrección de Errores
- **Escenario**: Asignaturas creadas por error o duplicadas
- **Beneficio**: Limpia la base de datos manteniendo la información relevante

## Limitaciones y Restricciones

### Restricciones Técnicas
- **Tipos de Asignatura**: Solo funciona con asignaturas de tipo 'REGULAR' y 'FORMACION_ELECTIVA'
- **Bibliografías**: No se pueden fusionar asignaturas sin bibliografías declaradas
- **Códigos Únicos**: Los códigos de asignatura deben ser únicos por departamento

### Restricciones de Negocio
- **Asignaturas Diferentes**: No se puede fusionar una asignatura consigo misma
- **Carreras Activas**: Solo se pueden fusionar asignaturas de carreras activas
- **Dependencias**: No se pueden fusionar asignaturas con dependencias complejas

## Mantenimiento y Monitoreo

### Logs del Sistema
- **Operaciones de Fusión**: Se registran todas las fusiones realizadas
- **Errores**: Se capturan y registran errores para análisis posterior
- **Auditoría**: Se mantiene trazabilidad de cambios realizados

### Métricas de Uso
- **Frecuencia de Uso**: Número de fusiones realizadas por período
- **Tipos de Fusión**: Estadísticas de bibliografías fusionadas vs. mantenidas
- **Tiempo de Procesamiento**: Rendimiento del sistema durante las fusiones

## Solución de Problemas

### Errores Comunes

#### 1. "Asignatura no encontrada"
- **Causa**: La asignatura especificada no existe en la base de datos
- **Solución**: Verificar que la asignatura esté activa y vinculada a la carrera

#### 2. "Error de transacción"
- **Causa**: Problema en la base de datos durante el procesamiento
- **Solución**: Verificar la conectividad y permisos de base de datos

#### 3. "Bibliografía duplicada"
- **Causa**: Conflicto de claves únicas en bibliografías
- **Solución**: Revisar las opciones de manejo de bibliografías duplicadas

### Recuperación de Errores
- **Rollback Automático**: En caso de error, se revierten todos los cambios
- **Estado Consistente**: La base de datos mantiene su estado anterior
- **Logs de Error**: Se registran detalles para análisis y corrección

## Mejoras Futuras

### Funcionalidades Planificadas
- **Fusión Masiva**: Procesar múltiples fusiones en lote
- **Historial de Fusiones**: Mantener registro de todas las operaciones
- **Deshacer Fusión**: Capacidad de revertir fusiones realizadas
- **Validación Avanzada**: Verificación de dependencias curriculares

### Optimizaciones Técnicas
- **Procesamiento Asíncrono**: Para fusiones complejas
- **Cache de Bibliografías**: Mejorar rendimiento en consultas
- **API REST**: Endpoints adicionales para integración externa

## Contacto y Soporte

Para reportar problemas o solicitar mejoras en la funcionalidad de fusión de asignaturas:

- **Equipo de Desarrollo**: desarrollo@biblioges.cl
- **Soporte Técnico**: soporte@biblioges.cl
- **Documentación**: docs.biblioges.cl

---

**Versión**: 1.0  
**Fecha de Creación**: {{ fecha_actual }}  
**Última Actualización**: {{ fecha_actual }}  
**Autor**: Equipo de Desarrollo BIBLIOGES
