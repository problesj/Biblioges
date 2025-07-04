# Autenticación LDAP con Active Directory - Biblioges

## Descripción

El sistema Biblioges ahora incluye autenticación LDAP con Active Directory como método principal de autenticación, con fallback a la autenticación local cuando el servidor LDAP no está disponible.

## Características

### Autenticación Híbrida
- **Primario**: Autenticación LDAP con Active Directory
- **Secundario**: Autenticación local con contraseñas hasheadas
- **Fallback automático**: Si el servidor LDAP no está disponible, se usa la autenticación local

### Flujo de Autenticación
1. Usuario ingresa email y contraseña
2. Sistema busca el usuario por email en la base de datos local
3. Si el usuario existe y está activo:
   - Verifica disponibilidad del servidor LDAP
   - Si está disponible, intenta autenticación LDAP usando el RUT del usuario
   - Si LDAP falla o no está disponible, usa autenticación local
4. Si la autenticación es exitosa, establece la sesión

### Sincronización de Datos
- Si la autenticación LDAP es exitosa, actualiza automáticamente:
  - Nombre del usuario
  - Email del usuario
- Solo actualiza si la información es diferente a la almacenada localmente

## Configuración

### Archivo de Configuración LDAP
Ubicación: `src/config/ldap.php`

```php
return [
    'host' => '146.83.118.18',
    'port' => 389,
    'bind_dn' => 'adminbidoc',
    'bind_password' => 'H_205p#M',
    'base_dn' => 'DC=usach,DC=cl',
    'timeout' => 10,
    'protocol_version' => 3,
    'referrals' => 0,
    'user_filter' => '(sAMAccountName={rut})',
    'attributes' => [
        'displayname',
        'cn',
        'mail',
        'sAMAccountName'
    ]
];
```

### Parámetros de Configuración

| Parámetro | Descripción | Valor Actual |
|-----------|-------------|--------------|
| `host` | IP del servidor LDAP | 146.83.118.18 |
| `port` | Puerto LDAP | 389 |
| `bind_dn` | Usuario de consulta LDAP | adminbidoc |
| `bind_password` | Contraseña de consulta | H_205p#M |
| `base_dn` | Base DN del Active Directory | DC=usach,DC=cl |
| `timeout` | Timeout de conexión (segundos) | 10 |
| `protocol_version` | Versión del protocolo LDAP | 3 |
| `referrals` | Habilitar referencias | 0 (deshabilitado) |
| `user_filter` | Filtro para buscar usuarios | (sAMAccountName={rut}) |
| `attributes` | Atributos a recuperar | displayname, cn, mail, sAMAccountName |

## Estructura de Archivos

```
src/
├── Core/
│   └── LdapService.php          # Servicio principal de LDAP
├── config/
│   └── ldap.php                 # Configuración LDAP
└── Controllers/
    └── AuthController.php       # Controlador de autenticación (modificado)

templates/
└── login.twig                   # Template de login (modificado)

test_ldap.php                    # Script de prueba LDAP
```

## Clases Principales

### LdapService
Maneja toda la lógica de conexión y autenticación LDAP.

**Métodos principales:**
- `connect()`: Establece conexión con el servidor LDAP
- `authenticate($rut, $password)`: Autentica un usuario
- `isServerAvailable()`: Verifica disponibilidad del servidor
- `getUserInfo($rut)`: Obtiene información del usuario

### AuthController (Modificado)
Integra la autenticación LDAP en el flujo de login.

**Cambios principales:**
- Agregado `LdapService` como dependencia
- Modificado método `login()` para usar autenticación híbrida
- Agregado método `updateUserInfoFromLdap()` para sincronización

## Pruebas

### Script de Prueba
Ejecutar: `php test_ldap.php`

Este script permite:
1. Verificar conectividad con el servidor LDAP
2. Probar autenticación con credenciales específicas
3. Mostrar información del usuario autenticado

### Logs
Los logs de autenticación LDAP se registran con el prefijo "LDAP:" en el log de errores de PHP.

## Seguridad

### Consideraciones
- Las credenciales LDAP están en archivo de configuración (considerar variables de entorno)
- Timeout configurado para evitar bloqueos
- Fallback a autenticación local garantiza disponibilidad
- Solo se actualiza información del usuario si es diferente

### Recomendaciones
1. Mover credenciales LDAP a variables de entorno
2. Implementar rate limiting para intentos de autenticación
3. Monitorear logs de autenticación LDAP
4. Configurar alertas para fallos de conectividad LDAP

## Troubleshooting

### Problemas Comunes

**Error: "Servidor LDAP no disponible"**
- Verificar conectividad de red al servidor 146.83.118.18:389
- Verificar credenciales de bind en la configuración
- Revisar logs de PHP para errores específicos

**Error: "Usuario no encontrado en Active Directory"**
- Verificar que el RUT existe en el Active Directory
- Confirmar que el filtro de búsqueda es correcto
- Verificar permisos del usuario de bind

**Error: "Contraseña incorrecta"**
- Verificar que la contraseña del usuario es correcta
- Confirmar que la cuenta no está bloqueada en AD
- Verificar políticas de contraseñas del dominio

### Comandos de Diagnóstico

```bash
# Verificar conectividad
telnet 146.83.118.18 389

# Probar script de LDAP
php test_ldap.php

# Revisar logs
tail -f /var/log/php_errors.log | grep LDAP
```

## Mantenimiento

### Monitoreo
- Revisar logs de autenticación regularmente
- Monitorear disponibilidad del servidor LDAP
- Verificar sincronización de datos de usuarios

### Actualizaciones
- Mantener configuración LDAP actualizada
- Revisar cambios en estructura del Active Directory
- Actualizar filtros de búsqueda si es necesario

## Soporte

Para problemas relacionados con la autenticación LDAP:
1. Revisar logs del sistema
2. Ejecutar script de prueba
3. Verificar conectividad de red
4. Contactar al administrador del Active Directory 