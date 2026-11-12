# API de consulta Biblioges (v1)

API REST de **solo lectura** para que otros sistemas consulten las bibliografías declaradas y disponibles
de Biblioges, por carrera (plan de estudio) o por asignatura. Responde en JSON (UTF-8).

- **URL base:** `https://<servidor>/biblioges/api/v1` (en producción, `https://biblioges.ucn.cl/biblioges/api/v1`).
- **Documentación interactiva (Swagger UI):** `/biblioges/api/v1/docs`. Permite probar las consultas con una API key.
- **Especificación OpenAPI 3:** [`docs/openapi.yaml`](openapi.yaml), también publicada en `/biblioges/api/v1/openapi.yaml`
  (se puede importar en Postman, Insomnia o generadores de clientes).

## Contenido

1. [Autenticación](#1-autenticación)
2. [Límite de solicitudes](#2-límite-de-solicitudes)
3. [Formato de respuesta y errores](#3-formato-de-respuesta-y-errores)
4. [Conceptos y criterios](#4-conceptos-y-criterios)
5. [Endpoints](#5-endpoints)
6. [Administración de API keys](#6-administración-de-api-keys)
7. [Instalación y despliegue](#7-instalación-y-despliegue)
8. [Notas técnicas](#8-notas-técnicas)

## 1. Autenticación

Cada llamada debe incluir una **API key** en la cabecera `X-API-Key`:

```bash
curl -H "X-API-Key: bg_xxxxxxxx..." https://biblioges.ucn.cl/biblioges/api/v1/carreras
```

También se acepta `Authorization: Bearer bg_xxxxxxxx...`. **La key no se acepta en la URL** (quedaría en logs e historiales).

Las keys las crea un usuario con rol **admin** en *Administración → API Keys* (ver [sección 6](#6-administración-de-api-keys)).
Sin key, con una key inexistente, revocada o expirada, la API responde `401`.

## 2. Límite de solicitudes

Cada key tiene un límite de solicitudes por minuto (60 por defecto; se define al crearla, entre 1 y 1000).
Cada respuesta autenticada incluye:

| Cabecera | Significado |
|---|---|
| `X-RateLimit-Limit` | Solicitudes permitidas por minuto. |
| `X-RateLimit-Remaining` | Solicitudes que quedan en la ventana del último minuto. |

Al superar el límite se responde `429` con la cabecera `Retry-After: 60`. Las solicitudes rechazadas también cuentan,
por lo que un cliente que reintenta sin esperar seguirá bloqueado: respete `Retry-After`.

## 3. Formato de respuesta y errores

Las respuestas exitosas son `200` con un objeto JSON. Los errores tienen siempre este formato:

```json
{ "error": { "codigo": "parametro_invalido", "mensaje": "Valores permitidos: todas o ultima.", "parametro": "ediciones" } }
```

| HTTP | `codigo` | Cuándo |
|---|---|---|
| 400 | `parametro_invalido` | Un parámetro tiene un valor no permitido (`parametro` indica cuál). |
| 401 | `no_autorizado` | Falta la key, no existe, fue revocada o expiró. |
| 404 | `carrera_no_encontrada` | No existe el código de carrera. |
| 404 | `vigencia_no_encontrada` | La carrera existe pero no con esa `vigencia_desde`; incluye `vigencias_disponibles`. |
| 404 | `asignatura_no_encontrada` | No existe el código de asignatura. |
| 404 | `ruta_no_encontrada` | La ruta no existe. |
| 405 | `metodo_no_permitido` | Se usó un método distinto de GET. |
| 429 | `limite_excedido` | Se superó el límite por minuto. |
| 500 | `error_interno` | Error del servidor (queda registrado en el log de PHP). |

Los campos sin valor se entregan como `null`. Los parámetros desconocidos se ignoran.

## 4. Conceptos y criterios

**Plan de estudio.** Una carrera se identifica por su **código** (por ejemplo `8213`). Un mismo código puede tener varios
planes con distinta **vigencia** (`vigencia_desde`/`vigencia_hasta`, formato `AAAASS`; `999999` = sin término).
Si no se indica `vigencia_desde`, se usa el **plan vigente** de vigencia más reciente. Un plan es vigente si la carrera y el
plan están activos y `vigencia_hasta` es igual o posterior al año en curso (misma regla del Dashboard).
Use `GET /carreras` para conocer códigos y vigencias.

**Asignaturas de un plan.** Se obtienen con el **mismo criterio que los reportes de cobertura**:

- las asignaturas **regulares** de la malla de la carrera, con código en una unidad de la sede del plan;
- además, según el parámetro `formacion`, las asignaturas que **componen** las asignaturas de formación de la malla
  (formación general, profesional, etc.), con código en la misma unidad. Estas indican en `asignaturas_malla` la
  asignatura de la malla de la que forman parte.

| `formacion` | Asignaturas de formación incluidas |
|---|---|
| `todas` (defecto) | Todas: básica, general, idiomas, profesional, valores, especialidad y especial. |
| `ninguna` | Ninguna (solo asignaturas regulares). |
| `plan` | Las guardadas para el plan en *Reportes de Cobertura → Guardar filtros*; si el plan no tiene filtros guardados, todas. |
| lista, p. ej. `general,profesional` | Solo esos tipos. Valores: `basica`, `general`, `idiomas`, `profesional`, `valores`, `especialidad`, `especial`. |

**Tipo de bibliografía** (`tipo_bibliografia`): `basica`, `complementaria`, `otro` o `todas` (defecto). Corresponde al tipo de
vínculo de la bibliografía con cada asignatura.

**Solo bibliografías activas.** Se consideran solo los **vínculos activos**, las **bibliografías declaradas activas** y las
**bibliografías disponibles activas**; las inactivas nunca se entregan. Por eso los totales pueden ser menores que los de los
reportes de cobertura, que también cuentan las declaradas inactivas.

**Bibliografía declarada** es la que informa el académico en el programa de la asignatura. **Bibliografía disponible**
es cada edición consultable en la biblioteca (impresa, electrónica o ambas), asociada a una declarada.

**Ediciones** (`ediciones`, solo en disponibles): `todas` (defecto) o `ultima`, que entrega para cada declarada solo la
disponible de mayor año de edición (a igual año, la registrada más recientemente).

**Ejemplares.** `ejemplares` lista los ejemplares impresos por sede (solo sedes con ejemplares); `total_ejemplares` es la
suma y `ejemplares_en_sede` los de la sede del plan (consultas por carrera) o de la asignatura (consultas por asignatura).

## 5. Endpoints

| Método y ruta | Descripción |
|---|---|
| `GET /carreras` | Planes de estudio (código, sede, vigencias). |
| `GET /carreras/{codigo}/bibliografias-declaradas` | Declaradas de un plan, por asignatura. |
| `GET /carreras/{codigo}/bibliografias-disponibles` | Disponibles de un plan, por asignatura y declarada. |
| `GET /asignaturas/{codigo}/bibliografias-declaradas` | Declaradas de una asignatura. |
| `GET /asignaturas/{codigo}/bibliografias-disponibles` | Disponibles de una asignatura, por declarada. |

### 5.1 `GET /carreras`

| Parámetro | Valores | Defecto |
|---|---|---|
| `tipo_programa` | `P` (pregrado), `G` (postgrado), `O` (otro) | todos |
| `sede` | código de sede, p. ej. `S001` | todas |
| `solo_vigentes` | `true` / `false` | `false` |

```bash
curl -H "X-API-Key: $BIBLIOGES_KEY" "https://biblioges.ucn.cl/biblioges/api/v1/carreras?tipo_programa=P&solo_vigentes=true"
```

```json
{
  "total": 70,
  "carreras": [
    {
      "codigo": "8213",
      "nombre": "ARQUITECTURA",
      "tipo_programa": "P",
      "sede": { "codigo": "S001", "nombre": "Antofagasta" },
      "vigencia_desde": "202610",
      "vigencia_hasta": "999999",
      "vigente": true
    }
  ]
}
```

### 5.2 `GET /carreras/{codigo}/bibliografias-declaradas`

| Parámetro | Valores | Defecto |
|---|---|---|
| `vigencia_desde` | `AAAASS`, p. ej. `202610` | plan vigente más reciente |
| `tipo_bibliografia` | `basica`, `complementaria`, `otro`, `todas` | `todas` |
| `formacion` | `todas`, `ninguna`, `plan` o lista (ver [sección 4](#4-conceptos-y-criterios)) | `todas` |

```bash
curl -H "X-API-Key: $BIBLIOGES_KEY" "https://biblioges.ucn.cl/biblioges/api/v1/carreras/8213/bibliografias-declaradas?tipo_bibliografia=basica"
```

```json
{
  "carrera": { "codigo": "8213", "nombre": "ARQUITECTURA", "tipo_programa": "P",
               "sede": { "codigo": "S001", "nombre": "Antofagasta" },
               "vigencia_desde": "202610", "vigencia_hasta": "999999", "vigente": true },
  "parametros": { "vigencia_desde": null, "tipo_bibliografia": "basica",
                  "formacion": ["basica", "general", "idiomas", "profesional", "valores", "especialidad", "especial"] },
  "resumen": { "asignaturas": 62, "bibliografias_declaradas": 118, "por_tipo": { "basica": 118 } },
  "asignaturas": [
    {
      "codigo": "ARQA-00101",
      "nombre": "TALLER DE ARQUITECTURA I",
      "tipo": "REGULAR",
      "asignaturas_malla": [],
      "bibliografias": [
        {
          "id": 1234,
          "tipo_bibliografia": "basica",
          "titulo": "Arquitectura: forma, espacio y orden",
          "tipo": "libro",
          "autores": ["Ching, Francis D. K."],
          "anio_publicacion": 2015,
          "editorial": "Gustavo Gili",
          "edicion": "4",
          "formato": "impreso",
          "isbn": "9788425227356",
          "doi": null,
          "url": null
        }
      ]
    }
  ]
}
```

(Valores de ejemplo.) Las asignaturas sin bibliografías del tipo pedido aparecen con `"bibliografias": []`.
Una misma bibliografía puede aparecer en varias asignaturas; `resumen.bibliografias_declaradas` cuenta las distintas.

### 5.3 `GET /carreras/{codigo}/bibliografias-disponibles`

Mismos parámetros que 5.2, más `ediciones` (`todas` o `ultima`). Cada bibliografía declarada incluye `disponibles`;
se omiten las declaradas sin disponibles activas (`resumen.declaradas_con_disponibles` y `resumen.disponibles` dan los totales).

```bash
curl -H "X-API-Key: $BIBLIOGES_KEY" "https://biblioges.ucn.cl/biblioges/api/v1/carreras/8213/bibliografias-disponibles?vigencia_desde=202610&ediciones=ultima"
```

```json
{
  "carrera": { "codigo": "8213", "...": "..." },
  "parametros": { "vigencia_desde": "202610", "tipo_bibliografia": "todas", "formacion": ["..."], "ediciones": "ultima" },
  "resumen": { "asignaturas": 62, "bibliografias_declaradas": 240, "por_tipo": { "basica": 118, "complementaria": 122, "otro": 0 },
               "declaradas_con_disponibles": 150, "disponibles": 150 },
  "asignaturas": [
    {
      "codigo": "ARQA-00101", "nombre": "TALLER DE ARQUITECTURA I", "tipo": "REGULAR", "asignaturas_malla": [],
      "bibliografias": [
        {
          "id": 1234, "tipo_bibliografia": "basica", "titulo": "Arquitectura: forma, espacio y orden", "...": "...",
          "disponibles": [
            {
              "id": 5678,
              "titulo": "Arquitectura : forma, espacio y orden",
              "autores": ["Ching, Francis D. K."],
              "anio_edicion": 2015,
              "editorial": "Gustavo Gili",
              "disponibilidad": "impreso",
              "id_mms": "991234567890",
              "url_acceso": null,
              "url_catalogo": "https://...",
              "ejemplares_digitales": null,
              "ejemplares": [ { "sede": { "codigo": "S001", "nombre": "Antofagasta" }, "cantidad": 3 } ],
              "total_ejemplares": 3,
              "ejemplares_en_sede": 3
            }
          ]
        }
      ]
    }
  ]
}
```

### 5.4 `GET /asignaturas/{codigo}/bibliografias-declaradas`

| Parámetro | Valores | Defecto |
|---|---|---|
| `tipo_bibliografia` | `basica`, `complementaria`, `otro`, `todas` | `todas` |

```bash
curl -H "X-API-Key: $BIBLIOGES_KEY" "https://biblioges.ucn.cl/biblioges/api/v1/asignaturas/ECDE-00666/bibliografias-declaradas"
```

```json
{
  "asignatura": {
    "codigo": "ECDE-00666", "nombre": "FILOSOFIA DEL DERECHO", "tipo": "REGULAR", "periodicidad": "semestral", "activa": true,
    "unidad": { "codigo": "...", "nombre": "..." },
    "sede": { "codigo": "S002", "nombre": "Coquimbo" }
  },
  "parametros": { "tipo_bibliografia": "todas" },
  "resumen": { "bibliografias_declaradas": 5, "por_tipo": { "basica": 2, "complementaria": 3, "otro": 0 } },
  "bibliografias": [ { "id": 1, "tipo_bibliografia": "basica", "titulo": "...", "...": "..." } ]
}
```

### 5.5 `GET /asignaturas/{codigo}/bibliografias-disponibles`

Parámetros `tipo_bibliografia` y `ediciones`. Igual que 5.4, pero cada bibliografía incluye `disponibles` (mismo formato
que 5.3, con `ejemplares_en_sede` referido a la sede de la asignatura) y se omiten las declaradas sin disponibles activas.

## 6. Administración de API keys

Menú **Administración → API Keys** (solo rol admin):

- **Nueva API key:** nombre del sistema (obligatorio), descripción, solicitudes por minuto (1–1000, defecto 60) y fecha de
  expiración opcional (la key vale hasta ese día inclusive). La key (`bg_` + 48 caracteres) **se muestra una sola vez**;
  Biblioges guarda solo su huella SHA-256 y un prefijo visible para identificarla.
- **Revocar:** deja la key sin acceso de inmediato. No se puede deshacer; si se requiere, cree una nueva.
- **Ver uso:** últimas 100 llamadas (fecha, código HTTP, ruta y parámetros, duración e IP) y resumen de los últimos 30 días.

Recomendaciones: una key por sistema; guárdela en la configuración segura del sistema cliente (nunca en el código ni en
repositorios); revóquela si se expone; use fecha de expiración para integraciones temporales.

La bitácora (`api_keys_bitacora`) crece con el uso. Para depurarla, por ejemplo, conservar un año:
`DELETE FROM api_keys_bitacora WHERE fecha < NOW() - INTERVAL 1 YEAR;`

## 7. Instalación y despliegue

1. Aplicar el SQL **antes** de desplegar el código: `database/2026-11-api-keys.sql` (crea `api_keys` y `api_keys_bitacora`).
2. `git pull --ff-only origin main` y limpiar la caché de Twig (`cache/twig`).
3. No requiere cambios en Apache ni dependencias nuevas: la API usa las mismas reglas de reescritura de `public/.htaccess`.
   Swagger UI se carga desde `cdn.jsdelivr.net` (`swagger-ui-dist` 5.17.14).

Verificación rápida (debe responder `401` en JSON):

```bash
curl -i https://biblioges.ucn.cl/biblioges/api/v1/carreras
```

## 8. Notas técnicas

| Archivo | Rol |
|---|---|
| `src/routes.php` | Grupo `/biblioges/api/v1` con `ApiKeyMiddleware` (fuera del grupo con sesión); `/docs` y `/openapi.yaml` son públicos. |
| `src/Middleware/ApiKeyMiddleware.php` | Valida la key (SHA-256), aplica el límite por minuto y registra cada llamada en la bitácora. |
| `src/Controllers/ApiV1Controller.php` | Endpoints, validación de parámetros y armado de respuestas. |
| `src/Services/ConsultaBibliografiasApi.php` | Consultas SQL (planes, asignaturas del plan, declaradas, disponibles, ejemplares, autores). |
| `src/Core/ApiRespuesta.php` | Respuestas y errores JSON. |
| `src/Controllers/ApiKeyController.php` y `templates/api_keys/index.twig` | Administración de keys (crear, revocar, bitácora). |
| `public/index.php` | Las rutas `/biblioges/api/v1/` no abren sesión PHP (no se crea un archivo de sesión por llamada). |

- Las asignaturas de un plan replican la vista `vw_mallas` usada por los reportes de cobertura, pero con consultas
  directas por carrera y sede (la vista tarda varios segundos por consulta).
- Se excluyen las bibliografías declaradas y disponibles inactivas y los vínculos no activos.
- La API es de solo lectura y no expone datos de usuarios.
- Versionado: cambios incompatibles se publicarán como `/api/v2`, manteniendo `/api/v1`.
