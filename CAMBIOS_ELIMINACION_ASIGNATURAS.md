# Cambios Realizados - Eliminación de Asignaturas y Validación de Códigos

## Problemas Identificados

1. **No aparecían alertas del estado del proceso**: Las alertas de SweetAlert2 no se mostraban correctamente después de eliminar una asignatura.
2. **Falta de validación de bibliografías vinculadas**: Se podía eliminar una asignatura que tenía bibliografías declaradas vinculadas.
3. **Falta de validación de códigos duplicados**: Se podían crear o editar asignaturas con códigos de asignatura duplicados en la tabla `asignaturas_departamentos`.

## Soluciones Implementadas

### 1. Validación de Bibliografías Vinculadas

**Archivo modificado**: `src/Controllers/AsignaturaController.php`

**Cambios en el método `destroy()`**:

- ✅ **Agregada validación**: Antes de eliminar una asignatura, se verifica si tiene bibliografías declaradas vinculadas con estado 'activa'.
- ✅ **Mensaje informativo**: Si la asignatura tiene bibliografías vinculadas, se muestra un mensaje claro indicando que debe desvincular las bibliografías primero.
- ✅ **Prevención de eliminación**: La asignatura no se elimina si tiene bibliografías activas vinculadas.

```php
// Verificar si la asignatura tiene bibliografías vinculadas
$stmt = $this->db->prepare("
    SELECT COUNT(*) as total 
    FROM asignaturas_bibliografias 
    WHERE asignatura_id = ? AND estado = 'activa'
");
$stmt->execute([$id]);
$resultado = $stmt->fetch();

if ($resultado['total'] > 0) {
    $mensaje = 'No se puede eliminar la asignatura "' . $asignatura['nombre'] . '" porque tiene bibliografías declaradas vinculadas. Debe desvincular las bibliografías antes de eliminar la asignatura.';
    // ... manejo del error
}
```

### 2. Validación de Códigos de Asignatura Duplicados

**Archivo modificado**: `src/Controllers/AsignaturaController.php`

**Cambios en el método `validateAsignaturaData()`**:

- ✅ **Validación de duplicados en formulario**: Se verifica que no haya códigos duplicados dentro del mismo formulario.
- ✅ **Validación de duplicados en base de datos**: Se verifica que el código no exista en otra asignatura activa.
- ✅ **Mensajes específicos**: Los errores indican exactamente qué asignatura y departamento tiene el código duplicado.
- ✅ **Soporte para edición**: En modo edición, se excluye la asignatura actual de la validación.

```php
// Validar códigos duplicados en la base de datos
if (empty($errors)) {
    foreach ($data['codigos'] as $index => $codigo) {
        if (!empty($codigo['codigo'])) {
            $codigoDuplicado = $this->verificarCodigoDuplicado($codigo['codigo'], $asignaturaId);
            if ($codigoDuplicado) {
                $errors["codigos.{$index}.codigo"] = "El código '{$codigo['codigo']}' ya existe en la asignatura '{$codigoDuplicado['nombre_asignatura']}' del departamento '{$codigoDuplicado['nombre_departamento']}'";
            }
        }
    }
}
```

**Nuevo método `verificarCodigoDuplicado()`**:

```php
private function verificarCodigoDuplicado($codigo, $asignaturaId = null)
{
    try {
        if ($asignaturaId) {
            // Para edición: excluir la asignatura actual
            $stmt = $this->db->prepare("
                SELECT 
                    a.nombre as nombre_asignatura,
                    d.nombre as nombre_departamento,
                    ad.codigo_asignatura
                FROM asignaturas_departamentos ad
                JOIN asignaturas a ON ad.asignatura_id = a.id
                JOIN departamentos d ON ad.departamento_id = d.id
                WHERE ad.codigo_asignatura = ? 
                AND ad.asignatura_id != ?
                AND a.estado = 1
                LIMIT 1
            ");
            $stmt->execute([$codigo, $asignaturaId]);
        } else {
            // Para creación: verificar todos los códigos
            $stmt = $this->db->prepare("
                SELECT 
                    a.nombre as nombre_asignatura,
                    d.nombre as nombre_departamento,
                    ad.codigo_asignatura
                FROM asignaturas_departamentos ad
                JOIN asignaturas a ON ad.asignatura_id = a.id
                JOIN departamentos d ON ad.departamento_id = d.id
                WHERE ad.codigo_asignatura = ? 
                AND a.estado = 1
                LIMIT 1
            ");
            $stmt->execute([$codigo]);
        }
        
        return $stmt->fetch();
    } catch (\Exception $e) {
        error_log("Error al verificar código duplicado: " . $e->getMessage());
        return false;
    }
}
```

### 3. Mejora en el Manejo de Alertas con SweetAlert2

**Archivos modificados**: 
- `templates/asignaturas/index.twig`
- `templates/asignaturas/create.twig`
- `templates/asignaturas/edit.twig`

**Mejoras implementadas**:

- ✅ **Indicador de carga**: Se muestra un indicador de carga mientras se procesa la eliminación.
- ✅ **Diferentes tipos de alertas**: Se manejan diferentes tipos de alertas según el resultado:
  - `success`: Eliminación exitosa
  - `warning`: Asignatura con bibliografías vinculadas o códigos duplicados
  - `error`: Error en el proceso
- ✅ **Mejor UX**: Las alertas tienen colores y textos apropiados para cada situación.
- ✅ **Manejo específico de errores de códigos**: Alertas especiales para códigos duplicados.

```javascript
// Manejo de errores de códigos duplicados
if (field === 'codigos_duplicados_formulario') {
    Swal.fire({
        icon: 'warning',
        title: 'Códigos Duplicados',
        text: message,
        confirmButtonColor: '#ffc107'
    });
} else if (field.startsWith('codigos.')) {
    // Manejar errores de códigos específicos
    const parts = field.split('.');
    const index = parts[1];
    const subField = parts[2];
    
    if (subField === 'codigo' && message.includes('ya existe')) {
        Swal.fire({
            icon: 'warning',
            title: 'Código Duplicado',
            text: message,
            confirmButtonColor: '#ffc107'
        });
    }
}
```

### 4. Corrección del Manejo de Respuestas AJAX

### Problema Identificado
- Cuando había errores de validación (como códigos duplicados), se mostraba una alerta de "Éxito" incorrectamente
- El formulario se redirigía a la lista de asignaturas en lugar de mantenerse con los datos
- La lógica verificaba `response.ok` en lugar del campo `success` del JSON

### Solución Implementada
- **Corrección de Lógica**: Se cambió la verificación de `response.ok` a `result.success` en las plantillas
- **Mantenimiento de Formulario**: Se aseguró que el formulario se mantenga con los datos cuando hay errores
- **Alertas Correctas**: Se corrigió el tipo de alerta mostrada según el resultado de la validación

### Archivos Modificados
- `templates/asignaturas/create.twig`
- `templates/asignaturas/edit.twig`

### Código Relevante
```javascript
// ANTES (incorrecto)
if (response.ok) {
    // Mostrar alerta de éxito
}

// DESPUÉS (correcto)
if (result.success) {
    // Mostrar alerta de éxito
} else {
    // Mostrar errores y mantener formulario
}
```

## 5. Mejora de Alertas con Errores Específicos

### Problema Identificado
- Las alertas mostraban mensajes genéricos como "Por favor corrija los errores en el formulario"
- No se informaba al usuario exactamente qué error específico había ocurrido
- La experiencia de usuario era confusa al no saber qué corregir

### Solución Implementada
- **Controlador**: Se modificó para enviar el primer error específico en el campo `message` del JSON
- **Plantillas**: Se actualizaron para mostrar el error específico en la alerta principal
- **Lógica Mejorada**: Se obtiene el primer error del objeto `errors` para la alerta principal

### Archivos Modificados
- `src/Controllers/AsignaturaController.php` (métodos `store` y `update`)
- `templates/asignaturas/create.twig`
- `templates/asignaturas/edit.twig`

### Código Relevante
```php
// ANTES (mensaje genérico)
$response->getBody()->write(json_encode([
    'success' => false, 
    'message' => 'Errores de validación', 
    'errors' => $errors
]));

// DESPUÉS (error específico)
$firstError = reset($errors);
$response->getBody()->write(json_encode([
    'success' => false, 
    'message' => $firstError, 
    'errors' => $errors
]));
```

```javascript
// ANTES (alerta genérica)
Swal.fire({
    icon: 'error',
    title: 'Errores de Validación',
    text: 'Por favor corrija los errores en el formulario'
});

// DESPUÉS (error específico)
const firstErrorKey = Object.keys(result.errors)[0];
const firstErrorMessage = result.errors[firstErrorKey];

Swal.fire({
    icon: 'error',
    title: 'Error de Validación',
    text: firstErrorMessage
});
```

### Ejemplos de Mensajes Mejorados
- **Código Duplicado**: "El código 'BD-00123' ya existe en la asignatura 'Base de Datos' del departamento 'Departamento de Sistemas'"
- **Campo Requerido**: "El nombre es requerido"
- **Códigos Duplicados en Formulario**: "Los siguientes códigos están duplicados en el formulario: BD-00123, BD-00124"

## 6. Manejo de Errores y Experiencia de Usuario

### Mejoras Implementadas
- **Resaltado de Campos**: Los campos con errores se resaltan visualmente
- **Mensajes Específicos**: Cada error se muestra en el campo correspondiente
- **Preservación de Datos**: Los datos del formulario se mantienen cuando hay errores
- **Navegación Intuitiva**: El usuario permanece en el formulario para corregir errores

### Características de UX
- Alertas no intrusivas con SweetAlert2
- Feedback visual inmediato
- Mensajes de error claros y específicos
- Flujo de trabajo optimizado

## 7. Validación Flexible para Asignaturas de Formación Electiva

### Problema Identificado
- Las asignaturas de tipo "Formación Electiva" requerían departamento y cantidad de alumnos
- No había diferenciación en la validación según el tipo de asignatura
- La experiencia de usuario era confusa al requerir campos innecesarios

### Solución Implementada
- **Validación Condicional**: Se modificó la validación para excluir departamento y cantidad de alumnos en Formación Electiva
- **Plantillas Adaptativas**: Se ajustó la lógica frontend para manejar campos opcionales
- **Valores por Defecto**: Se establecen valores por defecto apropiados para Formación Electiva

### Archivos Modificados
- `src/Controllers/AsignaturaController.php` (método `validateAsignaturaData`)
- `templates/asignaturas/create.twig`
- `templates/asignaturas/edit.twig`

### Código Relevante
```php
// ANTES (validación estricta para todos los tipos)
foreach ($data['codigos'] as $index => $codigo) {
    if (empty($codigo['departamento_id'])) {
        $errors["codigos.{$index}.departamento_id"] = 'El departamento es requerido';
    }
    if (empty($codigo['cantidad_alumnos'])) {
        $errors["codigos.{$index}.cantidad_alumnos"] = 'La cantidad de alumnos es requerida';
    }
}

// DESPUÉS (validación condicional)
foreach ($data['codigos'] as $index => $codigo) {
    // Para Formación Electiva, no validar departamento ni cantidad de alumnos
    if ($data['tipo'] !== 'FORMACION_ELECTIVA') {
        if (empty($codigo['departamento_id'])) {
            $errors["codigos.{$index}.departamento_id"] = 'El departamento es requerido';
        }
        if (empty($codigo['cantidad_alumnos'])) {
            $errors["codigos.{$index}.cantidad_alumnos"] = 'La cantidad de alumnos es requerida';
        }
    }
}
```

```javascript
// ANTES (lógica fija)
if (!depSelect.value) {
    errores[`departamento_${index}`] = 'El departamento es requerido';
}

// DESPUÉS (lógica condicional)
if (data.tipo === 'FORMACION_ELECTIVA') {
    data.codigos.push({
        departamento_id: depSelect.value || '',
        codigo: codigo,
        cantidad_alumnos: '0'
    });
} else {
    if (!depSelect.value) {
        errores[`departamento_${index}`] = 'El departamento es requerido';
    }
}
```

### Reglas de Validación Actualizadas
- **Formación Electiva**: 
  - ✅ Código requerido
  - ✅ Departamento opcional (se asocia automáticamente a "Sin departamento")
  - ✅ Cantidad de alumnos opcional (se usa 0 por defecto)
- **Otras Asignaturas**: 
  - ✅ Código requerido
  - ✅ Departamento requerido
  - ✅ Cantidad de alumnos requerida

### Flujo de Datos para Formación Electiva
1. Usuario selecciona tipo "FORMACION_ELECTIVA"
2. Campos de departamento y cantidad de alumnos se vuelven opcionales
3. Al enviar, se busca o crea automáticamente el departamento "Sin departamento"
4. Se asocia la asignatura al departamento "Sin departamento" con cantidad de alumnos = 0
5. Se guarda en la base de datos con estos valores por defecto

### Manejo del Departamento "Sin departamento"
- **Existencia**: El departamento "Sin departamento" ya existe en la base de datos (ID: 4)
- **Creación automática**: Si no existiera, se crea automáticamente
- **Asociación**: Todas las asignaturas de Formación Electiva se asocian a este departamento
- **Consulta**: Se modificó la consulta de departamentos para usar LEFT JOIN y incluir departamentos sin facultad

## 8. Estructura de Base de Datos Verificada

### Tablas Relevantes
- `asignaturas`: Información básica de asignaturas
- `asignaturas_departamentos`: Relación entre asignaturas y departamentos con códigos
- `asignaturas_bibliografias`: Relación entre asignaturas y bibliografías declaradas
- `departamentos`: Información de departamentos

### Consultas de Validación
- Verificación de bibliografías vinculadas activas
- Verificación de códigos duplicados por departamento
- Validación de integridad referencial

## 9. Pruebas y Validación

### Scripts de Prueba Creados
- Verificación de conexión a base de datos
- Validación de existencia de bibliografías vinculadas
- Verificación de códigos duplicados
- Simulación de respuestas del servidor

### Resultados de Pruebas
- ✅ Validación de bibliografías vinculadas funciona correctamente
- ✅ Detección de códigos duplicados funciona correctamente
- ✅ Alertas se muestran con el tipo correcto
- ✅ Formularios se mantienen con datos cuando hay errores

## Conclusión

Las modificaciones implementadas han mejorado significativamente la robustez del sistema de gestión de asignaturas:

1. **Prevención de Eliminación Incorrecta**: Se evita la eliminación de asignaturas con bibliografías vinculadas
2. **Validación de Integridad**: Se previenen códigos duplicados en la base de datos
3. **Experiencia de Usuario**: Se mejoró la claridad de las alertas y el manejo de errores
4. **Consistencia**: Se unificó el uso de SweetAlert2 en todo el sistema
5. **Corrección de Bugs**: Se solucionó el problema de alertas incorrectas en validación de códigos

El sistema ahora proporciona una experiencia más robusta y amigable para la gestión de asignaturas, con validaciones apropiadas y feedback claro para el usuario. 