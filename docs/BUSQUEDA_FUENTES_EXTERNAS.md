# Búsqueda en fuentes externas ("Buscar en Catálogo")

Cuando una bibliografía declarada no se encuentra en el catálogo (Primo/Alma), la vista
*Bibliografías Declaradas → Buscar en Catálogo* permite buscarla en fuentes externas y guardar los resultados
como bibliografías disponibles **electrónicas** (con su enlace como URL de acceso).

| Fuente | Qué contiene | Key | Variable de `.env` |
|---|---|---|---|
| **Semantic Scholar** | Artículos científicos | Recomendada: sin key se usa una cuota anónima compartida que suele estar agotada (HTTP 429). Se solicita gratis en <https://www.semanticscholar.org/product/api#api-key-form>. | `SEMANTIC_SCHOLAR_API_KEY` |
| **CrossRef** | Metadatos de publicaciones con DOI (artículos, libros, capítulos) | No usa key. Opcional: correo institucional de contacto para el *polite pool* (mejor servicio). | `CROSSREF_MAILTO` |
| **OpenAlex** | Catálogo abierto de obras académicas | Recomendada: gratuita en <https://openalex.org/settings/api>; sin key la cuota diaria es muy pequeña. | `OPENALEX_API_KEY` |
| **Google Books** | Libros | Key de un proyecto de Google Cloud con la *Books API* habilitada; sin key se usa la cuota anónima (suele estar agotada). | `GOOGLE_API_KEY` |

Las variables se configuran en el `.env` de cada servidor (no van en el repositorio). Tras cambiarlas no hay que
reiniciar nada: se leen en cada consulta.

## Comportamiento

- La búsqueda usa el título, el autor y la búsqueda adicional del formulario. En Google Books el título se busca
  como frase exacta; Google Books se limita a libros en español (`langRestrict=es`).
- Con key, Semantic Scholar admite muy pocas consultas por segundo: si responde 429 se reintenta hasta dos veces (pausas de 1,5 y 3 s).
  Los enlaces de Google Books se guardan con `https://`.
- Se muestran hasta 10 resultados por fuente. Todos los datos externos se escapan antes de mostrarse y solo se
  enlazan URL `http`/`https`.
- Si un servicio falla, el usuario ve el motivo en vez de "sin resultados": límite de consultas (429, indicando
  qué variable falta), key rechazada (401/403), servicio no disponible, sin conexión o sin respuesta en 20 s.
  El detalle técnico queda en el log de PHP (`Búsqueda externa: ...`); las keys y las URL nunca se registran.
- Al guardar, los resultados de estas fuentes quedan como disponibles **electrónicas** (`url_acceso` = enlace del
  resultado). Los autores de CrossRef y OpenAlex se guardan como "Apellido, Nombres".

## Fuentes retiradas (noviembre de 2026)

- **Google Scholar:** no tiene API oficial; la integración descargaba la página web (*scraping*), lo que va contra
  las condiciones de uso de Google, era bloqueado y nunca llegó a funcionar. Se reemplazó por CrossRef.
- **Google Custom Search** (usado como "Google Scholar" y "Google tradicional"): Google cerró la *Custom Search JSON
  API* a clientes nuevos y la da de baja el 1 de enero de 2027. Se retiró; `GOOGLE_SEARCH_ENGINE_ID` ya no se usa.

## Código

| Archivo | Rol |
|---|---|
| `src/Services/BusquedaExternaService.php` | Consultas a las cuatro fuentes (SSL verificado, tiempos máximos, keys en cabeceras salvo OpenAlex). |
| `src/Services/ServicioExternoException.php` | Error de servicio externo con mensaje para el usuario. |
| `src/Controllers/BibliografiaDeclaradaController.php` | `apiBuscarGoogle` (POST `/bibliografias-declaradas/{id}/buscarGoogle/api`, parámetro `fuente`: `semantic_scholar`, `crossref`, `openalex` o `google_books`) y el guardado (`guardarBibliografiasSeleccionadas`). |
| `templates/bibliografias_declaradas/buscar_catalogo.twig` | Botones por fuente, tabla de resultados (escapada) y guardado. |
