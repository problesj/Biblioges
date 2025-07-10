# Migración de Unidades

## Descripción

Esta migración implementa una nueva estructura de datos que centraliza la información de departamentos y facultades en una tabla única llamada `unidades`. Esto permite una estructura jerárquica más flexible y escalable.

## Cambios Realizados

### 1. Nueva Tabla: `unidades`

La tabla `unidades` reemplaza la funcionalidad de las tablas `departamentos` y `facultades` con una estructura más flexible:

```sql
CREATE TABLE unidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(250) NOT NULL,
    sede_id INT NOT NULL,
    id_unidad_padre VARCHAR(255) NULL,
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_unidad_padre) REFERENCES unidades(codigo) ON DELETE SET NULL
);
```

### 2. Migración de Datos

#### Departamentos → Unidades
- Los departamentos se migran como unidades hijas
- Código generado: `DEPT_XXXX` (donde XXXX es el ID del departamento)
- Se mantiene la relación con la facultad padre

#### Facultades → Unidades
- Las facultades se migran como unidades padre
- Código generado: `FAC_XXXX` (donde XXXX es el ID de la facultad)
- No tienen unidad padre (son unidades raíz)

### 3. Actualización de Tablas Relacionadas

#### `asignaturas_departamentos`
- **Antes**: `departamento_id INT`
- **Después**: `id_unidad INT`
- Se migran los datos automáticamente

#### `carreras_espejos`
- **Antes**: `facultad_id INT`
- **Después**: `id_unidad INT`
- Se migran los datos automáticamente

## Estructura Jerárquica

La nueva estructura permite relaciones padre-hijo flexibles:

```
Facultad de Medicina (FAC_0001)
├── Departamento de Clínica (DEPT_0001)
├── Departamento de Cirugía (DEPT_0002)
└── Departamento de Pediatría (DEPT_0003)

Facultad de Ingeniería (FAC_0002)
├── Departamento de Informática (DEPT_0004)
└── Departamento de Mecánica (DEPT_0005)
```

## Archivos Creados/Modificados

### Nuevos Archivos
- `database/migrations/2024_12_19_000001_create_unidades_table_and_migrate_departments.php`
- `database/run_unidades_migration.php`
- `src/Models/Unidad.php`
- `src/Controllers/UnidadController.php`
- `docs/MIGRACION_UNIDADES.md`

## Ejecución de la Migración

### 1. Preparación
```bash
# Asegúrate de estar en la rama correcta
git checkout ajuste-importante

# Verifica que no hay cambios pendientes
git status
```

### 2. Ejecutar Migración
```bash
# Navegar al directorio de la base de datos
cd database

# Ejecutar la migración
php run_unidades_migration.php
```

### 3. Verificación
```sql
-- Verificar que la tabla unidades se creó
SHOW TABLES LIKE 'unidades';

-- Verificar que los datos se migraron correctamente
SELECT COUNT(*) as total_unidades FROM unidades;

-- Verificar las relaciones padre-hijo
SELECT 
    u.codigo,
    u.nombre,
    up.nombre as unidad_padre
FROM unidades u
LEFT JOIN unidades up ON u.id_unidad_padre = up.codigo
ORDER BY u.codigo;
```

## Rollback

Si es necesario revertir los cambios:

```php
// En el archivo de migración
$migration = new CreateUnidadesTableAndMigrateDepartments($pdo);
$migration->down();
```

## Consideraciones Importantes

### 1. Integridad de Datos
- La migración mantiene todas las relaciones existentes
- Se preservan los datos históricos
- Las foreign keys se actualizan automáticamente

### 2. Compatibilidad
- Los modelos y controladores existentes necesitarán actualizaciones
- Las consultas que usen `departamento_id` o `facultad_id` deben actualizarse
- Las vistas y reportes pueden requerir ajustes

### 3. Rendimiento
- Se crean índices apropiados para las nuevas columnas
- Las consultas jerárquicas usan CTEs recursivos para mejor rendimiento

## Próximos Pasos

1. **Actualizar Modelos Existentes**
   - Modificar `Departamento.php` y `Facultad.php` para usar la nueva estructura
   - Actualizar relaciones en otros modelos

2. **Actualizar Controladores**
   - Modificar consultas en controladores existentes
   - Actualizar referencias a `departamento_id` y `facultad_id`

3. **Actualizar Vistas**
   - Modificar consultas en las vistas de base de datos
   - Actualizar reportes que usen las tablas antiguas

4. **Pruebas**
   - Verificar que todas las funcionalidades siguen funcionando
   - Probar la nueva estructura jerárquica
   - Validar reportes y consultas

## Notas Técnicas

### Códigos de Unidades
- **Facultades**: `FAC_XXXX` (4 dígitos)
- **Departamentos**: `DEPT_XXXX` (4 dígitos)
- Los códigos son únicos y permiten identificación rápida del tipo

### Relaciones
- `id_unidad_padre` referencia el `codigo` de la unidad padre
- Permite referencias circulares nulas (unidades raíz)
- Se mantiene integridad referencial

### Migración de Datos
- Se usa `ON DUPLICATE KEY UPDATE` para evitar duplicados
- Se preservan timestamps originales
- Se mantienen estados activos/inactivos 