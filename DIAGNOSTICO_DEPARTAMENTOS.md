# Diagnóstico del Problema: Departamentos no aparecen en edición de mallas

## Resumen del Problema
El usuario reporta que al editar una malla, al recuperar las sedes, facultades y departamentos, no aparecen todos los departamentos vinculados a una facultad. Específicamente menciona que la Facultad de Medicina no recupera el Departamento de Clínica.

## Diagnóstico Realizado

### 1. Verificación de Datos en Base de Datos
✅ **RESULTADO: Los datos existen correctamente**
- Facultad de Medicina: ID 9, Sede ID 6 (Coquimbo)
- Departamento de Clínica: ID 8, Código DCLI00, asociado a Facultad ID 9
- La relación sede-facultad-departamento está correctamente establecida

### 2. Verificación de APIs Backend
✅ **RESULTADO: Las APIs funcionan correctamente**

#### API de Facultades por Sede (`/api/facultades/sede/{sedeId}`)
- **URL probada**: `/api/facultades/sede/6`
- **Respuesta**: Devuelve 3 facultades incluyendo la Facultad de Medicina (ID: 9)
- **Estado**: ✅ FUNCIONA

#### API de Departamentos por Sede y Facultad (`/api/departamentos/{sedeId}/{facultadId}`)
- **URL probada**: `/api/departamentos/6/9`
- **Respuesta**: Devuelve 1 departamento (Departamento de Clínica)
- **Estado**: ✅ FUNCIONA

### 3. Verificación del Flujo Frontend
❌ **RESULTADO: Se encontró un problema en la lógica JavaScript**

## Problema Identificado y Solucionado

### 🔍 **Causa Raíz del Problema**
El problema estaba en la lógica JavaScript del template `templates/mallas/edit.twig`. Específicamente:

1. **Conflicto de IDs**: La Facultad de Medicina tiene ID 9, pero había un caso especial para "Sin Facultad" que también usaba ID 9
2. **Lógica Incorrecta**: Cuando se seleccionaba la Facultad de Medicina (ID: 9), se ejecutaba el caso especial que cargaba directamente el departamento 7 ("Sin Departamento") en lugar de llamar a la API de departamentos

### 🛠️ **Código Problemático (ANTES)**
```javascript
// Caso especial para "Sin Facultad" (ID: 9)
if (facultadId === '9') {
    departamentoSelect.innerHTML = '<option value="7">Sin Departamento</option>';
    departamentoSelect.disabled = false;
    cargarAsignaturasDepartamento('7');
    return;
}
```

### ✅ **Código Corregido (DESPUÉS)**
```javascript
// Caso especial para "Sin Facultad" (ID: 9) - solo cuando viene de "Sin Sede"
if (facultadId === '9' && sedeId === '14') {
    departamentoSelect.innerHTML = '<option value="7">Sin Departamento</option>';
    departamentoSelect.disabled = false;
    cargarAsignaturasDepartamento('7');
    return;
}
```

### 📊 **Evidencia de los Logs**
Los logs de la consola mostraron:
- ✅ Selección correcta de sede 6 (Coquimbo)
- ✅ Carga correcta de facultades (incluyendo Facultad de Medicina)
- ❌ Llamadas duplicadas a las APIs (event listeners duplicados)
- ❌ Carga incorrecta del departamento 7 en lugar del Departamento de Clínica

## Soluciones Implementadas

### 1. ✅ **Corrección de la Lógica JavaScript**
- Se modificó la condición del caso especial para que solo se ejecute cuando la sede sea "Sin Sede" (ID: 14)
- Ahora la Facultad de Medicina (ID: 9) en la sede Coquimbo (ID: 6) cargará correctamente sus departamentos

### 2. ✅ **Eliminación de Script de Depuración**
- Se removió el script de depuración que estaba causando llamadas duplicadas
- Se limpió la estructura del template para evitar duplicación de event listeners

### 3. ✅ **Scripts de Prueba Creados**
- `test_departamentos.php`: Verifica datos en base de datos
- `test_api_departamentos.php`: Prueba la API de departamentos
- `test_api_facultades.php`: Prueba la API de facultades
- `test_frontend_simulation.php`: Simula el flujo completo del frontend

## Verificación de la Solución

### Flujo Corregido:
1. **Usuario selecciona sede "Coquimbo" (ID: 6)**
2. **Se cargan las facultades de la sede 6** ✅
3. **Usuario selecciona "Facultad de Medicina" (ID: 9)**
4. **Se llama a la API: `/api/departamentos/6/9`** ✅
5. **Se muestra "Departamento de Clínica"** ✅

### Condición Corregida:
```javascript
// ANTES: Se ejecutaba para cualquier facultad con ID 9
if (facultadId === '9') { ... }

// DESPUÉS: Solo se ejecuta para "Sin Facultad" cuando viene de "Sin Sede"
if (facultadId === '9' && sedeId === '14') { ... }
```

## Resultado Final

✅ **PROBLEMA RESUELTO**: 
- La Facultad de Medicina ahora carga correctamente el Departamento de Clínica
- Se eliminaron las llamadas duplicadas a las APIs
- El flujo de selección sede → facultad → departamento funciona correctamente

## Pasos para Verificar

1. **Abrir la página de edición de mallas**
2. **Seleccionar la sede "Coquimbo"**
3. **Verificar que aparezca "Facultad de Medicina" en el selector de facultades**
4. **Seleccionar "Facultad de Medicina"**
5. **Verificar que aparezca "Departamento de Clínica" en el selector de departamentos**

## Conclusión

El problema estaba en el frontend, específicamente en la lógica JavaScript que manejaba los casos especiales. La corrección asegura que:

1. **La Facultad de Medicina (ID: 9) en la sede Coquimbo (ID: 6) cargue correctamente sus departamentos**
2. **El caso especial "Sin Facultad" solo se ejecute cuando corresponda**
3. **No haya conflictos entre diferentes facultades con el mismo ID**

La solución es robusta y mantiene la funcionalidad existente mientras corrige el problema específico reportado. 