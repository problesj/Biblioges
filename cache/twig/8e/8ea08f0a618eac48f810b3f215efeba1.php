<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* frontend/index.twig */
class __TwigTemplate_803fc1d1cc8d2ce62a4ece97cbedd28e extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "frontend/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografía UCN - Carreras de Pregrado";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<!-- Hero Section con Filtros -->
<section class=\"hero-section\">
    <div class=\"hero-background\"></div>
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3 text-white\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4 text-white\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university text-white\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
        
        <!-- Filtros de Sede -->
        <div class=\"row mt-5\">
            <div class=\"col-12\">
                <div class=\"filter-section\">
                    <div class=\"row align-items-end g-3\">
                        <div class=\"col-md-3\">
                            <label class=\"form-label text-white fw-bold\" for=\"sedeSelect\">Sedes</label>
                            <div class=\"select-con-indicador\">
                                <select class=\"form-select sede-select\" id=\"sedeSelect\" title=\"Seleccionar sede\">
                                    <option value=\"todas\">Todas</option>
                                    ";
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 37
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 37), "html", null, true);
            yield "\" ";
            if ((($context["sede_filtro"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 37))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 37), "html", null, true);
            yield "</option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        yield "                                </select>
                                <span class=\"select-indicador\" aria-hidden=\"true\">
                                    <i class=\"fas fa-chevron-down\"></i>
                                </span>
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                            <label class=\"form-label text-white fw-bold\" for=\"tipoBusqueda\">Buscar por</label>
                            <div class=\"select-con-indicador\">
                                <select class=\"form-select\" id=\"tipoBusqueda\" title=\"Seleccionar criterio de búsqueda\">
                                    <option value=\"carrera\">Nombre de carrera</option>
                                    <option value=\"asignatura_nombre\">Nombre de asignatura</option>
                                    <option value=\"asignatura_codigo\">Código de asignatura</option>
                                    <option value=\"titulo_autor\">Título o autor</option>
                                </select>
                                <span class=\"select-indicador\" aria-hidden=\"true\">
                                    <i class=\"fas fa-chevron-down\"></i>
                                </span>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\" for=\"carreraSearch\">Texto de búsqueda</label>
                            <input type=\"text\" class=\"form-control\" id=\"carreraSearch\" placeholder=\"¿Qué carrera buscas?\">
                        </div>
                        <div class=\"col-md-2\">
                            <button class=\"btn btn-warning btn-lg w-100\" id=\"buscarBtn\" type=\"button\">
                                <i class=\"fas fa-search me-2\"></i>Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Filtros por Áreas -->
<section class=\"container mb-4\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-4\">Explora las distintas áreas</h2>
            <div class=\"filter-tabs\">
                <div class=\"tab-buttons\">
                    <button class=\"tab-btn active\" data-sede=\"todas\">
                        TODAS
                    </button>
                    ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 86
            yield "                    <button class=\"tab-btn\" data-sede=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 86), "html", null, true);
            yield "\">
                        ";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 87)), "html", null, true);
            yield "
                    </button>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 90
        yield "                </div>
            </div>
        </div>
    </div>
</section>

<!-- Resultados de búsqueda por asignatura -->
<section id=\"resultadosAsignaturas\" class=\"container mb-5 d-none\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-3\">
                <i class=\"fas fa-list me-2\"></i>
                <span id=\"tituloResultadosAsignaturas\">Asignaturas encontradas</span>
            </h2>
            <p class=\"text-muted mb-3\" id=\"subtituloResultadosAsignaturas\"></p>
            <div id=\"listaAsignaturas\" class=\"list-group shadow-sm\"></div>
            <div id=\"sinResultadosAsignaturas\" class=\"alert alert-info d-none mt-3\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No se encontraron asignaturas que coincidan con tu búsqueda.
            </div>
        </div>
    </div>
</section>

<!-- Resultados de búsqueda por título o autor -->
<section id=\"resultadosBibliografia\" class=\"container mb-5 d-none\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-3\">
                <i class=\"fas fa-book me-2\"></i>
                <span id=\"tituloResultadosBibliografia\">Bibliografías encontradas</span>
            </h2>
            <p class=\"text-muted mb-3\" id=\"subtituloResultadosBibliografia\"></p>
            <div id=\"listaBibliografias\" class=\"list-group shadow-sm\"></div>
            <div id=\"sinResultadosBibliografia\" class=\"alert alert-info d-none mt-3\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No se encontraron bibliografías que coincidan con tu búsqueda.
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\" id=\"encabezadoCarreras\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\" id=\"carrerasContainer\">
        ";
        // line 144
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["carreras"] ?? null)) > 0)) {
            // line 145
            yield "            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 146
                yield "            <div class=\"col-md-6 col-lg-4 mb-4 carrera-item\" 
                 data-sedes=\"";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 147), "html", null, true);
                yield "\"
                 data-nombre=\"";
                // line 148
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 148)), "html", null, true);
                yield "\"
                 data-carrera-id=\"";
                // line 149
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 149), "html", null, true);
                yield "\"
                 data-carrera-nombre=\"";
                // line 150
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 150), "html_attr");
                yield "\"
                 data-sede-nombre=\"";
                // line 151
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_nombre", [], "any", false, false, false, 151), "html_attr");
                yield "\"
                 data-vigencia-desde=\"";
                // line 152
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", true, true, false, 152)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", false, false, false, 152), "")) : ("")), "html_attr");
                yield "\"
                 data-asignaturas=\"";
                // line 153
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "asignaturas_busqueda", [], "any", true, true, false, 153)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "asignaturas_busqueda", [], "any", false, false, false, 153), "{}")) : ("{}")), "html_attr");
                yield "\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        ";
                // line 156
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 156)) {
                    // line 157
                    yield "                            <img src=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/biblioges/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 157), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 157), "html", null, true);
                    yield "\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                } else {
                    // line 159
                    yield "                            <img src=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["assets_url"] ?? null), "html", null, true);
                    yield "/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                }
                // line 161
                yield "                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">";
                // line 163
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 163), "html", null, true);
                yield "</h5>
                        <p class=\"card-text\">
                            ";
                // line 165
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", true, true, false, 165)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", false, false, false, 165), "Forma profesionales capaces de optimizar procesos productivos y de servicios.")) : ("Forma profesionales capaces de optimizar procesos productivos y de servicios.")), "html", null, true);
                yield "
                            <br>
                            <small class=\"text-muted\">
                                Vigencia desde:
                                ";
                // line 169
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", true, true, false, 169) && CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", false, false, false, 169))) {
                    // line 170
                    yield "                                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", false, false, false, 170), 0, 4), "html", null, true);
                    yield "
                                ";
                } else {
                    // line 172
                    yield "                                    —
                                ";
                }
                // line 174
                yield "                            </small>
                        </p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>";
                // line 179
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", true, true, false, 179)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", false, false, false, 179), 10)) : (10)), "html", null, true);
                yield " semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>";
                // line 183
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_nombre", [], "any", false, false, false, 183), "html", null, true);
                yield "</span>
                            </div>
                        </div>
                        ";
                // line 186
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 186)) {
                    // line 187
                    yield "                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/carrera/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 187), "html", null, true);
                    yield "/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 187), "html", null, true);
                    yield "?vigencia_desde=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", true, true, false, 187)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", false, false, false, 187), "")) : (""))), "html", null, true);
                    yield "\" 
                           class=\"btn btn-primary btn-ver-bibliografia\"
                           data-carrera-id=\"";
                    // line 189
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 189), "html", null, true);
                    yield "\"
                           data-sedes=\"";
                    // line 190
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 190), "html", null, true);
                    yield "\"
                           data-vigencia-desde=\"";
                    // line 191
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", true, true, false, 191)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencia_desde", [], "any", false, false, false, 191), "")) : ("")), "html", null, true);
                    yield "\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        ";
                } else {
                    // line 196
                    yield "                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        ";
                }
                // line 201
                yield "                    </div>
                </div>
            </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 205
            yield "        ";
        } else {
            // line 206
            yield "            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        ";
        }
        // line 213
        yield "    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
";
        yield from [];
    }

    // line 254
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 255
        yield "<script id=\"bibliografiasBusquedaData\" type=\"application/json\">";
        yield ((array_key_exists("bibliografias_busqueda_json", $context)) ? (Twig\Extension\CoreExtension::default(($context["bibliografias_busqueda_json"] ?? null), "[]")) : ("[]"));
        yield "</script>
<script>
window.APP_URL = ";
        // line 257
        yield json_encode(($context["app_url"] ?? null));
        yield ";

/**
 * Normaliza texto para búsqueda: minúsculas, sin acentos/diacríticos ni caracteres especiales.
 */
function normalizarTextoBusqueda(texto) {
    if (!texto) return '';
    return String(texto)
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\\u0300-\\u036f]/g, '')
        .replace(/[^a-z0-9\\s]/g, ' ')
        .replace(/\\s+/g, ' ')
        .trim();
}

/** Normaliza códigos de asignatura (sin guiones ni espacios) para comparar. */
function normalizarCodigoAsignatura(texto) {
    return normalizarTextoBusqueda(texto).replace(/\\s+/g, '');
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto == null ? '' : String(texto);
    return div.innerHTML;
}

function obtenerAsignaturasItem(item) {
    try {
        const raw = item.getAttribute('data-asignaturas') || '{}';
        const datos = JSON.parse(raw);
        return {
            items: Array.isArray(datos.items) ? datos.items : [],
            nombres: Array.isArray(datos.nombres) ? datos.nombres : [],
            codigos: Array.isArray(datos.codigos) ? datos.codigos : []
        };
    } catch (e) {
        return { items: [], nombres: [], codigos: [] };
    }
}

function itemPasaFiltroSede(item, sedeSeleccionada) {
    if (sedeSeleccionada === 'todas') {
        return true;
    }
    const sedes = (item.getAttribute('data-sedes') || '').split(',').map(function(s) { return s.trim(); });
    return sedes.includes(sedeSeleccionada);
}

function asignaturaCoincidePatron(asig, busqueda, tipoBusqueda) {
    if (!busqueda) {
        return false;
    }
    if (tipoBusqueda === 'asignatura_nombre') {
        return normalizarTextoBusqueda(asig.nombre || '').includes(busqueda);
    }
    if (tipoBusqueda === 'asignatura_codigo') {
        return normalizarCodigoAsignatura(asig.codigo || '').includes(busqueda);
    }
    return false;
}

function recopilarAsignaturasCoincidentes(busqueda, tipoBusqueda, sedeSeleccionada) {
    const resultados = [];
    const vistos = new Set();

    document.querySelectorAll('.carrera-item').forEach(function(item) {
        if (!itemPasaFiltroSede(item, sedeSeleccionada)) {
            return;
        }

        const datos = obtenerAsignaturasItem(item);
        const meta = {
            carreraId: item.getAttribute('data-carrera-id'),
            carreraNombre: item.getAttribute('data-carrera-nombre') || '',
            sedeId: item.getAttribute('data-sedes'),
            sedeNombre: item.getAttribute('data-sede-nombre') || '',
            vigenciaDesde: item.getAttribute('data-vigencia-desde') || ''
        };

        datos.items.forEach(function(asig) {
            if (!asignaturaCoincidePatron(asig, busqueda, tipoBusqueda)) {
                return;
            }
            const clave = asig.id + '_' + meta.carreraId + '_' + meta.sedeId;
            if (vistos.has(clave)) {
                return;
            }
            vistos.add(clave);
            resultados.push(Object.assign({}, asig, meta));
        });
    });

    resultados.sort(function(a, b) {
        return (a.nombre || '').localeCompare(b.nombre || '', 'es', { sensitivity: 'base' });
    });

    return resultados;
}

function renderizarListadoAsignaturas(resultados) {
    const seccion = document.getElementById('resultadosAsignaturas');
    const lista = document.getElementById('listaAsignaturas');
    const sinResultados = document.getElementById('sinResultadosAsignaturas');
    const subtitulo = document.getElementById('subtituloResultadosAsignaturas');
    const appUrl = window.APP_URL || '';

    if (!seccion || !lista) {
        return;
    }

    lista.innerHTML = '';

    if (subtitulo) {
        subtitulo.textContent = resultados.length === 1
            ? '1 asignatura encontrada'
            : resultados.length + ' asignaturas encontradas';
    }

    if (resultados.length === 0) {
        sinResultados?.classList.remove('d-none');
        return;
    }

    sinResultados?.classList.add('d-none');

    resultados.forEach(function(r) {
        const vigenciaQuery = r.vigenciaDesde ? '?vigencia_desde=' + encodeURIComponent(r.vigenciaDesde) : '';
        const urlCarrera = appUrl + '/carrera/' + r.sedeId + '/' + r.carreraId + vigenciaQuery;
        const urlBiblio = appUrl + '/asignatura-biblio/' + r.sedeId + '/' + r.id;

        const item = document.createElement('div');
        item.className = 'list-group-item';
        item.innerHTML =
            '<div class=\"d-flex w-100 justify-content-between align-items-start flex-wrap gap-3\">' +
                '<div class=\"flex-grow-1\">' +
                    '<h5 class=\"mb-1\">' + escapeHtml(r.nombre) + '</h5>' +
                    '<p class=\"mb-1 text-muted small mb-0\">' +
                        '<strong>Código:</strong> ' + escapeHtml(r.codigo || '—') +
                        (r.semestre ? ' &nbsp;·&nbsp; <strong>Semestre:</strong> ' + escapeHtml(r.semestre) : '') +
                    '</p>' +
                    '<p class=\"mb-0 small text-secondary\">' +
                        '<i class=\"fas fa-graduation-cap me-1\"></i>' + escapeHtml(r.carreraNombre) +
                        ' <span class=\"text-muted\">· ' + escapeHtml(r.sedeNombre) + '</span>' +
                    '</p>' +
                '</div>' +
                '<div class=\"d-flex gap-2 flex-shrink-0 align-items-center\">' +
                    '<a href=\"' + urlBiblio + '\" class=\"btn btn-sm btn-primary\" target=\"_blank\" rel=\"noopener\">' +
                        '<i class=\"fas fa-book me-1\"></i>Ver bibliografía' +
                    '</a>' +
                    '<a href=\"' + urlCarrera + '\" class=\"btn btn-sm btn-outline-secondary\">' +
                        '<i class=\"fas fa-university me-1\"></i>Ver carrera' +
                    '</a>' +
                '</div>' +
            '</div>';
        lista.appendChild(item);
    });
}

function esBusquedaConListado(tipoBusqueda, busqueda) {
    return !!busqueda && (
        tipoBusqueda === 'asignatura_nombre' ||
        tipoBusqueda === 'asignatura_codigo' ||
        tipoBusqueda === 'titulo_autor'
    );
}

function alternarVistaResultados(tipoBusqueda, busqueda) {
    const seccionAsig = document.getElementById('resultadosAsignaturas');
    const seccionBib = document.getElementById('resultadosBibliografia');
    const encabezadoCarreras = document.getElementById('encabezadoCarreras');
    const carrerasContainer = document.getElementById('carrerasContainer');
    const esListado = esBusquedaConListado(tipoBusqueda, busqueda);
    const esAsignatura = esListado && (tipoBusqueda === 'asignatura_nombre' || tipoBusqueda === 'asignatura_codigo');
    const esBibliografia = esListado && tipoBusqueda === 'titulo_autor';

    seccionAsig?.classList.toggle('d-none', !esAsignatura);
    seccionBib?.classList.toggle('d-none', !esBibliografia);

    if (esListado) {
        encabezadoCarreras?.classList.add('d-none');
        if (carrerasContainer) {
            carrerasContainer.style.display = 'none';
        }
    } else {
        encabezadoCarreras?.classList.remove('d-none');
        if (carrerasContainer) {
            carrerasContainer.style.display = '';
        }
    }
}

function obtenerCatalogoBibliografias() {
    const el = document.getElementById('bibliografiasBusquedaData');
    if (!el || !el.textContent) {
        return [];
    }
    try {
        const datos = JSON.parse(el.textContent);
        return Array.isArray(datos) ? datos : [];
    } catch (e) {
        return [];
    }
}

/** Coincide texto normalizado en cadena completa o en fragmentos (autores separados por ; o ,). */
function textoCoincidePatron(texto, busqueda) {
    if (!busqueda || !texto) {
        return false;
    }
    if (normalizarTextoBusqueda(texto).includes(busqueda)) {
        return true;
    }
    return String(texto).split(/[;,]/).some(function(parte) {
        return normalizarTextoBusqueda(parte).includes(busqueda);
    });
}

function etiquetaTipoBibliografia(tipo) {
    const mapa = {
        basica: 'Básica',
        complementaria: 'Complementaria'
    };
    return mapa[tipo] || (tipo ? tipo.charAt(0).toUpperCase() + tipo.slice(1) : '—');
}

function recopilarBibliografiasCoincidentes(busqueda, sedeSeleccionada) {
    const resultados = [];
    const vistos = new Set();

    obtenerCatalogoBibliografias().forEach(function(bib) {
        if (sedeSeleccionada !== 'todas' && String(bib.sedeId) !== String(sedeSeleccionada)) {
            return;
        }

        const coincideTitulo = textoCoincidePatron(bib.titulo, busqueda);
        const coincideAutor = textoCoincidePatron(bib.autores, busqueda);
        if (!coincideTitulo && !coincideAutor) {
            return;
        }

        const clave = bib.id + '_' + bib.asignaturaId + '_' + bib.carreraId + '_' + bib.sedeId + '_' + (bib.tipoBibliografia || '');
        if (vistos.has(clave)) {
            return;
        }
        vistos.add(clave);
        resultados.push(Object.assign({}, bib, {
            coincideTitulo: coincideTitulo,
            coincideAutor: coincideAutor
        }));
    });

    resultados.sort(function(a, b) {
        const cmpTitulo = (a.titulo || '').localeCompare(b.titulo || '', 'es', { sensitivity: 'base' });
        if (cmpTitulo !== 0) {
            return cmpTitulo;
        }
        return (a.autores || '').localeCompare(b.autores || '', 'es', { sensitivity: 'base' });
    });

    return resultados;
}

function renderizarListadoBibliografias(resultados) {
    const seccion = document.getElementById('resultadosBibliografia');
    const lista = document.getElementById('listaBibliografias');
    const sinResultados = document.getElementById('sinResultadosBibliografia');
    const subtitulo = document.getElementById('subtituloResultadosBibliografia');
    const appUrl = window.APP_URL || '';

    if (!seccion || !lista) {
        return;
    }

    lista.innerHTML = '';

    if (subtitulo) {
        subtitulo.textContent = resultados.length === 1
            ? '1 bibliografía encontrada'
            : resultados.length + ' bibliografías encontradas';
    }

    if (resultados.length === 0) {
        sinResultados?.classList.remove('d-none');
        return;
    }

    sinResultados?.classList.add('d-none');

    resultados.forEach(function(r) {
        const vigenciaQuery = r.vigenciaDesde ? '?vigencia_desde=' + encodeURIComponent(r.vigenciaDesde) : '';
        const urlCarrera = appUrl + '/carrera/' + r.sedeId + '/' + r.carreraId + vigenciaQuery;
        const urlAsignatura = appUrl + '/asignatura-biblio/' + r.sedeId + '/' + r.asignaturaId;

        let coincidencia = '';
        if (r.coincideTitulo && r.coincideAutor) {
            coincidencia = '<span class=\"badge bg-secondary me-1\">Título</span><span class=\"badge bg-secondary\">Autor</span>';
        } else if (r.coincideTitulo) {
            coincidencia = '<span class=\"badge bg-secondary\">Título</span>';
        } else {
            coincidencia = '<span class=\"badge bg-secondary\">Autor</span>';
        }

        const item = document.createElement('div');
        item.className = 'list-group-item';
        item.innerHTML =
            '<div class=\"d-flex w-100 justify-content-between align-items-start flex-wrap gap-3\">' +
                '<div class=\"flex-grow-1\">' +
                    '<h5 class=\"mb-1\">' + escapeHtml(r.titulo) + '</h5>' +
                    '<p class=\"mb-1 text-muted small\">' +
                        '<strong>Autor(es):</strong> ' + escapeHtml(r.autores || '—') +
                    '</p>' +
                    '<p class=\"mb-1 small\">' + coincidencia +
                        ' <span class=\"badge bg-light text-dark border ms-1\">' + escapeHtml(etiquetaTipoBibliografia(r.tipoBibliografia)) + '</span>' +
                    '</p>' +
                    '<p class=\"mb-0 small text-secondary\">' +
                        '<i class=\"fas fa-chalkboard-teacher me-1\"></i>' + escapeHtml(r.asignaturaNombre) +
                        (r.codigoAsignatura ? ' <span class=\"text-muted\">(' + escapeHtml(r.codigoAsignatura) + ')</span>' : '') +
                        '<br><i class=\"fas fa-graduation-cap me-1\"></i>' + escapeHtml(r.carreraNombre) +
                        ' <span class=\"text-muted\">· ' + escapeHtml(r.sedeNombre) + '</span>' +
                    '</p>' +
                '</div>' +
                '<div class=\"d-flex gap-2 flex-shrink-0 align-items-center\">' +
                    '<a href=\"' + urlAsignatura + '\" class=\"btn btn-sm btn-primary\" target=\"_blank\" rel=\"noopener\">' +
                        '<i class=\"fas fa-book-open me-1\"></i>Ver en asignatura' +
                    '</a>' +
                    '<a href=\"' + urlCarrera + '\" class=\"btn btn-sm btn-outline-secondary\">' +
                        '<i class=\"fas fa-university me-1\"></i>Ver carrera' +
                    '</a>' +
                '</div>' +
            '</div>';
        lista.appendChild(item);
    });
}

function carreraCoincideBusqueda(item, busqueda, tipoBusqueda) {
    if (!busqueda) {
        return true;
    }
    if (tipoBusqueda === 'carrera') {
        const nombreCarrera = normalizarTextoBusqueda(item.getAttribute('data-nombre') || '');
        return nombreCarrera.includes(busqueda);
    }
    return true;
}

const PLACEHOLDERS_BUSQUEDA = {
    carrera: '¿Qué carrera buscas?',
    asignatura_nombre: '¿Qué asignatura buscas?',
    asignatura_codigo: 'Ej: DAII-00505',
    titulo_autor: 'Título o nombre de autor'
};

function actualizarPlaceholderBusqueda() {
    const tipoBusqueda = document.getElementById('tipoBusqueda');
    const carreraSearch = document.getElementById('carreraSearch');
    if (!tipoBusqueda || !carreraSearch) {
        return;
    }
    carreraSearch.placeholder = PLACEHOLDERS_BUSQUEDA[tipoBusqueda.value] || PLACEHOLDERS_BUSQUEDA.carrera;
}

// Función global para filtrar carreras
function filtrarCarreras() {
    console.log('=== EJECUTANDO FILTRO DE CARRERAS ===');
    
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const tipoBusquedaEl = document.getElementById('tipoBusqueda');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    if (!sedeSelect || !carreraSearch) {
        console.error('Elementos de filtro no encontrados');
        return;
    }
    
    const sedeSeleccionada = sedeSelect.value;
    const tipoBusqueda = tipoBusquedaEl ? tipoBusquedaEl.value : 'carrera';
    const busqueda = tipoBusqueda === 'asignatura_codigo'
        ? normalizarCodigoAsignatura(carreraSearch.value)
        : normalizarTextoBusqueda(carreraSearch.value);

    alternarVistaResultados(tipoBusqueda, busqueda);

    if (tipoBusqueda === 'titulo_autor' && busqueda) {
        const resultadosBib = recopilarBibliografiasCoincidentes(busqueda, sedeSeleccionada);
        renderizarListadoBibliografias(resultadosBib);
        return;
    }

    if ((tipoBusqueda === 'asignatura_nombre' || tipoBusqueda === 'asignatura_codigo') && busqueda) {
        const resultados = recopilarAsignaturasCoincidentes(busqueda, tipoBusqueda, sedeSeleccionada);
        renderizarListadoAsignaturas(resultados);
        return;
    }

    let carrerasMostradas = 0;

    carreraItems.forEach(function(item) {
        const sedesCarrera = item.getAttribute('data-sedes') || '';
        let mostrar = true;

        if (sedeSeleccionada !== 'todas') {
            const sedesArray = sedesCarrera.split(',').map(function(s) { return s.trim(); });
            if (!sedesArray.includes(sedeSeleccionada)) {
                mostrar = false;
            }
        }

        if (busqueda && !carreraCoincideBusqueda(item, busqueda, tipoBusqueda)) {
            mostrar = false;
        }

        if (mostrar) {
            item.style.display = 'block';
            item.classList.add('fade-in');
            carrerasMostradas++;
        } else {
            item.style.display = 'none';
            item.classList.remove('fade-in');
        }
    });

    console.log('Carreras mostradas:', carrerasMostradas);
}

// Sincroniza la pestaña activa con el valor del select de sedes
function setActiveTab(sedeId) {
    const tabs = document.querySelectorAll('.tab-btn');
    if (!tabs || tabs.length === 0) return;
    tabs.forEach(btn => btn.classList.remove('active'));
    let target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === sedeId);
    if (!target) {
        target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === 'todas');
    }
    if (target) target.classList.add('active');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INICIANDO FILTROS DE CARRERAS ===');
    
    // Verificar elementos
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const tipoBusqueda = document.getElementById('tipoBusqueda');
    const buscarBtn = document.getElementById('buscarBtn');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    console.log('Elementos encontrados:');
    console.log('- sedeSelect:', sedeSelect ? 'OK' : 'NO ENCONTRADO');
    console.log('- carreraSearch:', carreraSearch ? 'OK' : 'NO ENCONTRADO');
    console.log('- buscarBtn:', buscarBtn ? 'OK' : 'NO ENCONTRADO');
    console.log('- tabButtons:', tabButtons.length);
    console.log('- carreraItems:', carreraItems.length);
    
    // Event listeners
    if (sedeSelect) {
        sedeSelect.addEventListener('change', function() {
            console.log('Cambio en sede select:', this.value);
            // Sincronizar pestañas
            setActiveTab(this.value);
            filtrarCarreras();
        });
    }
    
    if (tipoBusqueda) {
        tipoBusqueda.addEventListener('change', function() {
            actualizarPlaceholderBusqueda();
            filtrarCarreras();
        });
        actualizarPlaceholderBusqueda();
    }

    if (carreraSearch) {
        carreraSearch.addEventListener('input', function() {
            console.log('Búsqueda:', this.value);
            filtrarCarreras();
        });
    }
    
    if (buscarBtn) {
        buscarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón buscar clickeado');
            filtrarCarreras();
        });
    }
    
    // Tabs de sedes
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Tab clickeado:', this.textContent.trim());
            
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Filtrar por sede
            const sedeId = this.getAttribute('data-sede');
            if (sedeSelect) {
                sedeSelect.value = sedeId;
            }
            filtrarCarreras();
        });
    });
    
    // Aplicar filtro inicial
    console.log('Aplicando filtro inicial...');
    // Sincronizar pestañas con el valor inicial del select
    if (sedeSelect) {
        setActiveTab(sedeSelect.value);
    }
    filtrarCarreras();
    
    console.log('=== FILTROS INICIALIZADOS ===');
    
    // Manejar clics en botones de \"Ver Bibliografía\"
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ver-bibliografia')) {
            e.preventDefault();
            
            const button = e.target.closest('.btn-ver-bibliografia');
            const carreraId = button.getAttribute('data-carrera-id');
            const sedesDisponibles = button.getAttribute('data-sedes').split(',');
            const vigenciaDesde = button.getAttribute('data-vigencia-desde') || '';
            const sedeSeleccionada = sedeSelect.value;
            
            console.log('Carrera ID:', carreraId);
            console.log('Sedes disponibles:', sedesDisponibles);
            console.log('Sede seleccionada:', sedeSeleccionada);
            
            // Verificar si la sede seleccionada está disponible para esta carrera
            if (sedeSeleccionada === 'todas' || sedesDisponibles.includes(sedeSeleccionada)) {
                // Usar la sede seleccionada o la primera disponible
                const sedeParaUsar = sedeSeleccionada === 'todas' ? sedesDisponibles[0] : sedeSeleccionada;
                const vigenciaQuery = vigenciaDesde ? `?vigencia_desde=\${encodeURIComponent(vigenciaDesde)}` : '';
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}\${vigenciaQuery}`;
                console.log('Navegando a:', url);
                window.location.href = url;
            } else {
                // Si la sede seleccionada no está disponible, usar la primera sede disponible
                const sedeParaUsar = sedesDisponibles[0];
                const vigenciaQuery = vigenciaDesde ? `?vigencia_desde=\${encodeURIComponent(vigenciaDesde)}` : '';
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}\${vigenciaQuery}`;
                console.log('Sede seleccionada no disponible, usando:', sedeParaUsar);
                console.log('Navegando a:', url);
                window.location.href = url;
            }
        }
    });
});

// Función global para debug
window.debugFiltros = function() {
    console.log('=== DEBUG FILTROS ===');
    console.log('sedeSelect value:', document.getElementById('sedeSelect')?.value);
    console.log('carreraSearch value:', document.getElementById('carreraSearch')?.value);
    console.log('carreraItems:', document.querySelectorAll('.carrera-item').length);
    console.log('tabButtons:', document.querySelectorAll('.tab-btn').length);
    filtrarCarreras();
};
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  465 => 257,  459 => 255,  452 => 254,  408 => 213,  399 => 206,  396 => 205,  387 => 201,  380 => 196,  372 => 191,  368 => 190,  364 => 189,  352 => 187,  350 => 186,  344 => 183,  337 => 179,  330 => 174,  326 => 172,  320 => 170,  318 => 169,  311 => 165,  306 => 163,  302 => 161,  296 => 159,  286 => 157,  284 => 156,  278 => 153,  274 => 152,  270 => 151,  266 => 150,  262 => 149,  258 => 148,  254 => 147,  251 => 146,  246 => 145,  244 => 144,  188 => 90,  179 => 87,  174 => 86,  170 => 85,  122 => 39,  107 => 37,  103 => 36,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}Bibliografía UCN - Carreras de Pregrado{% endblock %}

{% block content %}
<!-- Hero Section con Filtros -->
<section class=\"hero-section\">
    <div class=\"hero-background\"></div>
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3 text-white\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4 text-white\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university text-white\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
        
        <!-- Filtros de Sede -->
        <div class=\"row mt-5\">
            <div class=\"col-12\">
                <div class=\"filter-section\">
                    <div class=\"row align-items-end g-3\">
                        <div class=\"col-md-3\">
                            <label class=\"form-label text-white fw-bold\" for=\"sedeSelect\">Sedes</label>
                            <div class=\"select-con-indicador\">
                                <select class=\"form-select sede-select\" id=\"sedeSelect\" title=\"Seleccionar sede\">
                                    <option value=\"todas\">Todas</option>
                                    {% for sede in sedes %}
                                    <option value=\"{{ sede.id }}\" {% if sede_filtro == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                                    {% endfor %}
                                </select>
                                <span class=\"select-indicador\" aria-hidden=\"true\">
                                    <i class=\"fas fa-chevron-down\"></i>
                                </span>
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                            <label class=\"form-label text-white fw-bold\" for=\"tipoBusqueda\">Buscar por</label>
                            <div class=\"select-con-indicador\">
                                <select class=\"form-select\" id=\"tipoBusqueda\" title=\"Seleccionar criterio de búsqueda\">
                                    <option value=\"carrera\">Nombre de carrera</option>
                                    <option value=\"asignatura_nombre\">Nombre de asignatura</option>
                                    <option value=\"asignatura_codigo\">Código de asignatura</option>
                                    <option value=\"titulo_autor\">Título o autor</option>
                                </select>
                                <span class=\"select-indicador\" aria-hidden=\"true\">
                                    <i class=\"fas fa-chevron-down\"></i>
                                </span>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\" for=\"carreraSearch\">Texto de búsqueda</label>
                            <input type=\"text\" class=\"form-control\" id=\"carreraSearch\" placeholder=\"¿Qué carrera buscas?\">
                        </div>
                        <div class=\"col-md-2\">
                            <button class=\"btn btn-warning btn-lg w-100\" id=\"buscarBtn\" type=\"button\">
                                <i class=\"fas fa-search me-2\"></i>Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Filtros por Áreas -->
<section class=\"container mb-4\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-4\">Explora las distintas áreas</h2>
            <div class=\"filter-tabs\">
                <div class=\"tab-buttons\">
                    <button class=\"tab-btn active\" data-sede=\"todas\">
                        TODAS
                    </button>
                    {% for sede in sedes %}
                    <button class=\"tab-btn\" data-sede=\"{{ sede.id }}\">
                        {{ sede.nombre|upper }}
                    </button>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Resultados de búsqueda por asignatura -->
<section id=\"resultadosAsignaturas\" class=\"container mb-5 d-none\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-3\">
                <i class=\"fas fa-list me-2\"></i>
                <span id=\"tituloResultadosAsignaturas\">Asignaturas encontradas</span>
            </h2>
            <p class=\"text-muted mb-3\" id=\"subtituloResultadosAsignaturas\"></p>
            <div id=\"listaAsignaturas\" class=\"list-group shadow-sm\"></div>
            <div id=\"sinResultadosAsignaturas\" class=\"alert alert-info d-none mt-3\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No se encontraron asignaturas que coincidan con tu búsqueda.
            </div>
        </div>
    </div>
</section>

<!-- Resultados de búsqueda por título o autor -->
<section id=\"resultadosBibliografia\" class=\"container mb-5 d-none\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-3\">
                <i class=\"fas fa-book me-2\"></i>
                <span id=\"tituloResultadosBibliografia\">Bibliografías encontradas</span>
            </h2>
            <p class=\"text-muted mb-3\" id=\"subtituloResultadosBibliografia\"></p>
            <div id=\"listaBibliografias\" class=\"list-group shadow-sm\"></div>
            <div id=\"sinResultadosBibliografia\" class=\"alert alert-info d-none mt-3\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No se encontraron bibliografías que coincidan con tu búsqueda.
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\" id=\"encabezadoCarreras\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\" id=\"carrerasContainer\">
        {% if carreras|length > 0 %}
            {% for carrera in carreras %}
            <div class=\"col-md-6 col-lg-4 mb-4 carrera-item\" 
                 data-sedes=\"{{ carrera.sede_id }}\"
                 data-nombre=\"{{ carrera.nombre|lower }}\"
                 data-carrera-id=\"{{ carrera.id }}\"
                 data-carrera-nombre=\"{{ carrera.nombre|e('html_attr') }}\"
                 data-sede-nombre=\"{{ carrera.sede_nombre|e('html_attr') }}\"
                 data-vigencia-desde=\"{{ carrera.vigencia_desde|default('')|e('html_attr') }}\"
                 data-asignaturas=\"{{ carrera.asignaturas_busqueda|default('{}')|e('html_attr') }}\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        {% if carrera.imagen_url %}
                            <img src=\"{{ app_url }}/biblioges/{{ carrera.imagen_url }}\" alt=\"{{ carrera.nombre }}\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% else %}
                            <img src=\"{{ assets_url }}/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% endif %}
                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{{ carrera.nombre }}</h5>
                        <p class=\"card-text\">
                            {{ carrera.descripcion|default('Forma profesionales capaces de optimizar procesos productivos y de servicios.') }}
                            <br>
                            <small class=\"text-muted\">
                                Vigencia desde:
                                {% if carrera.vigencia_desde is defined and carrera.vigencia_desde %}
                                    {{ carrera.vigencia_desde|slice(0, 4) }}
                                {% else %}
                                    —
                                {% endif %}
                            </small>
                        </p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>{{ carrera.cantidad_semestres|default(10) }} semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>{{ carrera.sede_nombre }}</span>
                            </div>
                        </div>
                        {% if carrera.sede_id %}
                        <a href=\"{{ app_url }}/carrera/{{ carrera.sede_id }}/{{ carrera.id }}?vigencia_desde={{ carrera.vigencia_desde|default('')|url_encode }}\" 
                           class=\"btn btn-primary btn-ver-bibliografia\"
                           data-carrera-id=\"{{ carrera.id }}\"
                           data-sedes=\"{{ carrera.sede_id }}\"
                           data-vigencia-desde=\"{{ carrera.vigencia_desde|default('') }}\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        {% else %}
                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% endfor %}
        {% else %}
            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        {% endif %}
    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{% endblock %}

{% block scripts %}
<script id=\"bibliografiasBusquedaData\" type=\"application/json\">{{ bibliografias_busqueda_json|default('[]')|raw }}</script>
<script>
window.APP_URL = {{ app_url|json_encode|raw }};

/**
 * Normaliza texto para búsqueda: minúsculas, sin acentos/diacríticos ni caracteres especiales.
 */
function normalizarTextoBusqueda(texto) {
    if (!texto) return '';
    return String(texto)
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\\u0300-\\u036f]/g, '')
        .replace(/[^a-z0-9\\s]/g, ' ')
        .replace(/\\s+/g, ' ')
        .trim();
}

/** Normaliza códigos de asignatura (sin guiones ni espacios) para comparar. */
function normalizarCodigoAsignatura(texto) {
    return normalizarTextoBusqueda(texto).replace(/\\s+/g, '');
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto == null ? '' : String(texto);
    return div.innerHTML;
}

function obtenerAsignaturasItem(item) {
    try {
        const raw = item.getAttribute('data-asignaturas') || '{}';
        const datos = JSON.parse(raw);
        return {
            items: Array.isArray(datos.items) ? datos.items : [],
            nombres: Array.isArray(datos.nombres) ? datos.nombres : [],
            codigos: Array.isArray(datos.codigos) ? datos.codigos : []
        };
    } catch (e) {
        return { items: [], nombres: [], codigos: [] };
    }
}

function itemPasaFiltroSede(item, sedeSeleccionada) {
    if (sedeSeleccionada === 'todas') {
        return true;
    }
    const sedes = (item.getAttribute('data-sedes') || '').split(',').map(function(s) { return s.trim(); });
    return sedes.includes(sedeSeleccionada);
}

function asignaturaCoincidePatron(asig, busqueda, tipoBusqueda) {
    if (!busqueda) {
        return false;
    }
    if (tipoBusqueda === 'asignatura_nombre') {
        return normalizarTextoBusqueda(asig.nombre || '').includes(busqueda);
    }
    if (tipoBusqueda === 'asignatura_codigo') {
        return normalizarCodigoAsignatura(asig.codigo || '').includes(busqueda);
    }
    return false;
}

function recopilarAsignaturasCoincidentes(busqueda, tipoBusqueda, sedeSeleccionada) {
    const resultados = [];
    const vistos = new Set();

    document.querySelectorAll('.carrera-item').forEach(function(item) {
        if (!itemPasaFiltroSede(item, sedeSeleccionada)) {
            return;
        }

        const datos = obtenerAsignaturasItem(item);
        const meta = {
            carreraId: item.getAttribute('data-carrera-id'),
            carreraNombre: item.getAttribute('data-carrera-nombre') || '',
            sedeId: item.getAttribute('data-sedes'),
            sedeNombre: item.getAttribute('data-sede-nombre') || '',
            vigenciaDesde: item.getAttribute('data-vigencia-desde') || ''
        };

        datos.items.forEach(function(asig) {
            if (!asignaturaCoincidePatron(asig, busqueda, tipoBusqueda)) {
                return;
            }
            const clave = asig.id + '_' + meta.carreraId + '_' + meta.sedeId;
            if (vistos.has(clave)) {
                return;
            }
            vistos.add(clave);
            resultados.push(Object.assign({}, asig, meta));
        });
    });

    resultados.sort(function(a, b) {
        return (a.nombre || '').localeCompare(b.nombre || '', 'es', { sensitivity: 'base' });
    });

    return resultados;
}

function renderizarListadoAsignaturas(resultados) {
    const seccion = document.getElementById('resultadosAsignaturas');
    const lista = document.getElementById('listaAsignaturas');
    const sinResultados = document.getElementById('sinResultadosAsignaturas');
    const subtitulo = document.getElementById('subtituloResultadosAsignaturas');
    const appUrl = window.APP_URL || '';

    if (!seccion || !lista) {
        return;
    }

    lista.innerHTML = '';

    if (subtitulo) {
        subtitulo.textContent = resultados.length === 1
            ? '1 asignatura encontrada'
            : resultados.length + ' asignaturas encontradas';
    }

    if (resultados.length === 0) {
        sinResultados?.classList.remove('d-none');
        return;
    }

    sinResultados?.classList.add('d-none');

    resultados.forEach(function(r) {
        const vigenciaQuery = r.vigenciaDesde ? '?vigencia_desde=' + encodeURIComponent(r.vigenciaDesde) : '';
        const urlCarrera = appUrl + '/carrera/' + r.sedeId + '/' + r.carreraId + vigenciaQuery;
        const urlBiblio = appUrl + '/asignatura-biblio/' + r.sedeId + '/' + r.id;

        const item = document.createElement('div');
        item.className = 'list-group-item';
        item.innerHTML =
            '<div class=\"d-flex w-100 justify-content-between align-items-start flex-wrap gap-3\">' +
                '<div class=\"flex-grow-1\">' +
                    '<h5 class=\"mb-1\">' + escapeHtml(r.nombre) + '</h5>' +
                    '<p class=\"mb-1 text-muted small mb-0\">' +
                        '<strong>Código:</strong> ' + escapeHtml(r.codigo || '—') +
                        (r.semestre ? ' &nbsp;·&nbsp; <strong>Semestre:</strong> ' + escapeHtml(r.semestre) : '') +
                    '</p>' +
                    '<p class=\"mb-0 small text-secondary\">' +
                        '<i class=\"fas fa-graduation-cap me-1\"></i>' + escapeHtml(r.carreraNombre) +
                        ' <span class=\"text-muted\">· ' + escapeHtml(r.sedeNombre) + '</span>' +
                    '</p>' +
                '</div>' +
                '<div class=\"d-flex gap-2 flex-shrink-0 align-items-center\">' +
                    '<a href=\"' + urlBiblio + '\" class=\"btn btn-sm btn-primary\" target=\"_blank\" rel=\"noopener\">' +
                        '<i class=\"fas fa-book me-1\"></i>Ver bibliografía' +
                    '</a>' +
                    '<a href=\"' + urlCarrera + '\" class=\"btn btn-sm btn-outline-secondary\">' +
                        '<i class=\"fas fa-university me-1\"></i>Ver carrera' +
                    '</a>' +
                '</div>' +
            '</div>';
        lista.appendChild(item);
    });
}

function esBusquedaConListado(tipoBusqueda, busqueda) {
    return !!busqueda && (
        tipoBusqueda === 'asignatura_nombre' ||
        tipoBusqueda === 'asignatura_codigo' ||
        tipoBusqueda === 'titulo_autor'
    );
}

function alternarVistaResultados(tipoBusqueda, busqueda) {
    const seccionAsig = document.getElementById('resultadosAsignaturas');
    const seccionBib = document.getElementById('resultadosBibliografia');
    const encabezadoCarreras = document.getElementById('encabezadoCarreras');
    const carrerasContainer = document.getElementById('carrerasContainer');
    const esListado = esBusquedaConListado(tipoBusqueda, busqueda);
    const esAsignatura = esListado && (tipoBusqueda === 'asignatura_nombre' || tipoBusqueda === 'asignatura_codigo');
    const esBibliografia = esListado && tipoBusqueda === 'titulo_autor';

    seccionAsig?.classList.toggle('d-none', !esAsignatura);
    seccionBib?.classList.toggle('d-none', !esBibliografia);

    if (esListado) {
        encabezadoCarreras?.classList.add('d-none');
        if (carrerasContainer) {
            carrerasContainer.style.display = 'none';
        }
    } else {
        encabezadoCarreras?.classList.remove('d-none');
        if (carrerasContainer) {
            carrerasContainer.style.display = '';
        }
    }
}

function obtenerCatalogoBibliografias() {
    const el = document.getElementById('bibliografiasBusquedaData');
    if (!el || !el.textContent) {
        return [];
    }
    try {
        const datos = JSON.parse(el.textContent);
        return Array.isArray(datos) ? datos : [];
    } catch (e) {
        return [];
    }
}

/** Coincide texto normalizado en cadena completa o en fragmentos (autores separados por ; o ,). */
function textoCoincidePatron(texto, busqueda) {
    if (!busqueda || !texto) {
        return false;
    }
    if (normalizarTextoBusqueda(texto).includes(busqueda)) {
        return true;
    }
    return String(texto).split(/[;,]/).some(function(parte) {
        return normalizarTextoBusqueda(parte).includes(busqueda);
    });
}

function etiquetaTipoBibliografia(tipo) {
    const mapa = {
        basica: 'Básica',
        complementaria: 'Complementaria'
    };
    return mapa[tipo] || (tipo ? tipo.charAt(0).toUpperCase() + tipo.slice(1) : '—');
}

function recopilarBibliografiasCoincidentes(busqueda, sedeSeleccionada) {
    const resultados = [];
    const vistos = new Set();

    obtenerCatalogoBibliografias().forEach(function(bib) {
        if (sedeSeleccionada !== 'todas' && String(bib.sedeId) !== String(sedeSeleccionada)) {
            return;
        }

        const coincideTitulo = textoCoincidePatron(bib.titulo, busqueda);
        const coincideAutor = textoCoincidePatron(bib.autores, busqueda);
        if (!coincideTitulo && !coincideAutor) {
            return;
        }

        const clave = bib.id + '_' + bib.asignaturaId + '_' + bib.carreraId + '_' + bib.sedeId + '_' + (bib.tipoBibliografia || '');
        if (vistos.has(clave)) {
            return;
        }
        vistos.add(clave);
        resultados.push(Object.assign({}, bib, {
            coincideTitulo: coincideTitulo,
            coincideAutor: coincideAutor
        }));
    });

    resultados.sort(function(a, b) {
        const cmpTitulo = (a.titulo || '').localeCompare(b.titulo || '', 'es', { sensitivity: 'base' });
        if (cmpTitulo !== 0) {
            return cmpTitulo;
        }
        return (a.autores || '').localeCompare(b.autores || '', 'es', { sensitivity: 'base' });
    });

    return resultados;
}

function renderizarListadoBibliografias(resultados) {
    const seccion = document.getElementById('resultadosBibliografia');
    const lista = document.getElementById('listaBibliografias');
    const sinResultados = document.getElementById('sinResultadosBibliografia');
    const subtitulo = document.getElementById('subtituloResultadosBibliografia');
    const appUrl = window.APP_URL || '';

    if (!seccion || !lista) {
        return;
    }

    lista.innerHTML = '';

    if (subtitulo) {
        subtitulo.textContent = resultados.length === 1
            ? '1 bibliografía encontrada'
            : resultados.length + ' bibliografías encontradas';
    }

    if (resultados.length === 0) {
        sinResultados?.classList.remove('d-none');
        return;
    }

    sinResultados?.classList.add('d-none');

    resultados.forEach(function(r) {
        const vigenciaQuery = r.vigenciaDesde ? '?vigencia_desde=' + encodeURIComponent(r.vigenciaDesde) : '';
        const urlCarrera = appUrl + '/carrera/' + r.sedeId + '/' + r.carreraId + vigenciaQuery;
        const urlAsignatura = appUrl + '/asignatura-biblio/' + r.sedeId + '/' + r.asignaturaId;

        let coincidencia = '';
        if (r.coincideTitulo && r.coincideAutor) {
            coincidencia = '<span class=\"badge bg-secondary me-1\">Título</span><span class=\"badge bg-secondary\">Autor</span>';
        } else if (r.coincideTitulo) {
            coincidencia = '<span class=\"badge bg-secondary\">Título</span>';
        } else {
            coincidencia = '<span class=\"badge bg-secondary\">Autor</span>';
        }

        const item = document.createElement('div');
        item.className = 'list-group-item';
        item.innerHTML =
            '<div class=\"d-flex w-100 justify-content-between align-items-start flex-wrap gap-3\">' +
                '<div class=\"flex-grow-1\">' +
                    '<h5 class=\"mb-1\">' + escapeHtml(r.titulo) + '</h5>' +
                    '<p class=\"mb-1 text-muted small\">' +
                        '<strong>Autor(es):</strong> ' + escapeHtml(r.autores || '—') +
                    '</p>' +
                    '<p class=\"mb-1 small\">' + coincidencia +
                        ' <span class=\"badge bg-light text-dark border ms-1\">' + escapeHtml(etiquetaTipoBibliografia(r.tipoBibliografia)) + '</span>' +
                    '</p>' +
                    '<p class=\"mb-0 small text-secondary\">' +
                        '<i class=\"fas fa-chalkboard-teacher me-1\"></i>' + escapeHtml(r.asignaturaNombre) +
                        (r.codigoAsignatura ? ' <span class=\"text-muted\">(' + escapeHtml(r.codigoAsignatura) + ')</span>' : '') +
                        '<br><i class=\"fas fa-graduation-cap me-1\"></i>' + escapeHtml(r.carreraNombre) +
                        ' <span class=\"text-muted\">· ' + escapeHtml(r.sedeNombre) + '</span>' +
                    '</p>' +
                '</div>' +
                '<div class=\"d-flex gap-2 flex-shrink-0 align-items-center\">' +
                    '<a href=\"' + urlAsignatura + '\" class=\"btn btn-sm btn-primary\" target=\"_blank\" rel=\"noopener\">' +
                        '<i class=\"fas fa-book-open me-1\"></i>Ver en asignatura' +
                    '</a>' +
                    '<a href=\"' + urlCarrera + '\" class=\"btn btn-sm btn-outline-secondary\">' +
                        '<i class=\"fas fa-university me-1\"></i>Ver carrera' +
                    '</a>' +
                '</div>' +
            '</div>';
        lista.appendChild(item);
    });
}

function carreraCoincideBusqueda(item, busqueda, tipoBusqueda) {
    if (!busqueda) {
        return true;
    }
    if (tipoBusqueda === 'carrera') {
        const nombreCarrera = normalizarTextoBusqueda(item.getAttribute('data-nombre') || '');
        return nombreCarrera.includes(busqueda);
    }
    return true;
}

const PLACEHOLDERS_BUSQUEDA = {
    carrera: '¿Qué carrera buscas?',
    asignatura_nombre: '¿Qué asignatura buscas?',
    asignatura_codigo: 'Ej: DAII-00505',
    titulo_autor: 'Título o nombre de autor'
};

function actualizarPlaceholderBusqueda() {
    const tipoBusqueda = document.getElementById('tipoBusqueda');
    const carreraSearch = document.getElementById('carreraSearch');
    if (!tipoBusqueda || !carreraSearch) {
        return;
    }
    carreraSearch.placeholder = PLACEHOLDERS_BUSQUEDA[tipoBusqueda.value] || PLACEHOLDERS_BUSQUEDA.carrera;
}

// Función global para filtrar carreras
function filtrarCarreras() {
    console.log('=== EJECUTANDO FILTRO DE CARRERAS ===');
    
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const tipoBusquedaEl = document.getElementById('tipoBusqueda');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    if (!sedeSelect || !carreraSearch) {
        console.error('Elementos de filtro no encontrados');
        return;
    }
    
    const sedeSeleccionada = sedeSelect.value;
    const tipoBusqueda = tipoBusquedaEl ? tipoBusquedaEl.value : 'carrera';
    const busqueda = tipoBusqueda === 'asignatura_codigo'
        ? normalizarCodigoAsignatura(carreraSearch.value)
        : normalizarTextoBusqueda(carreraSearch.value);

    alternarVistaResultados(tipoBusqueda, busqueda);

    if (tipoBusqueda === 'titulo_autor' && busqueda) {
        const resultadosBib = recopilarBibliografiasCoincidentes(busqueda, sedeSeleccionada);
        renderizarListadoBibliografias(resultadosBib);
        return;
    }

    if ((tipoBusqueda === 'asignatura_nombre' || tipoBusqueda === 'asignatura_codigo') && busqueda) {
        const resultados = recopilarAsignaturasCoincidentes(busqueda, tipoBusqueda, sedeSeleccionada);
        renderizarListadoAsignaturas(resultados);
        return;
    }

    let carrerasMostradas = 0;

    carreraItems.forEach(function(item) {
        const sedesCarrera = item.getAttribute('data-sedes') || '';
        let mostrar = true;

        if (sedeSeleccionada !== 'todas') {
            const sedesArray = sedesCarrera.split(',').map(function(s) { return s.trim(); });
            if (!sedesArray.includes(sedeSeleccionada)) {
                mostrar = false;
            }
        }

        if (busqueda && !carreraCoincideBusqueda(item, busqueda, tipoBusqueda)) {
            mostrar = false;
        }

        if (mostrar) {
            item.style.display = 'block';
            item.classList.add('fade-in');
            carrerasMostradas++;
        } else {
            item.style.display = 'none';
            item.classList.remove('fade-in');
        }
    });

    console.log('Carreras mostradas:', carrerasMostradas);
}

// Sincroniza la pestaña activa con el valor del select de sedes
function setActiveTab(sedeId) {
    const tabs = document.querySelectorAll('.tab-btn');
    if (!tabs || tabs.length === 0) return;
    tabs.forEach(btn => btn.classList.remove('active'));
    let target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === sedeId);
    if (!target) {
        target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === 'todas');
    }
    if (target) target.classList.add('active');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INICIANDO FILTROS DE CARRERAS ===');
    
    // Verificar elementos
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const tipoBusqueda = document.getElementById('tipoBusqueda');
    const buscarBtn = document.getElementById('buscarBtn');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    console.log('Elementos encontrados:');
    console.log('- sedeSelect:', sedeSelect ? 'OK' : 'NO ENCONTRADO');
    console.log('- carreraSearch:', carreraSearch ? 'OK' : 'NO ENCONTRADO');
    console.log('- buscarBtn:', buscarBtn ? 'OK' : 'NO ENCONTRADO');
    console.log('- tabButtons:', tabButtons.length);
    console.log('- carreraItems:', carreraItems.length);
    
    // Event listeners
    if (sedeSelect) {
        sedeSelect.addEventListener('change', function() {
            console.log('Cambio en sede select:', this.value);
            // Sincronizar pestañas
            setActiveTab(this.value);
            filtrarCarreras();
        });
    }
    
    if (tipoBusqueda) {
        tipoBusqueda.addEventListener('change', function() {
            actualizarPlaceholderBusqueda();
            filtrarCarreras();
        });
        actualizarPlaceholderBusqueda();
    }

    if (carreraSearch) {
        carreraSearch.addEventListener('input', function() {
            console.log('Búsqueda:', this.value);
            filtrarCarreras();
        });
    }
    
    if (buscarBtn) {
        buscarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón buscar clickeado');
            filtrarCarreras();
        });
    }
    
    // Tabs de sedes
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Tab clickeado:', this.textContent.trim());
            
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Filtrar por sede
            const sedeId = this.getAttribute('data-sede');
            if (sedeSelect) {
                sedeSelect.value = sedeId;
            }
            filtrarCarreras();
        });
    });
    
    // Aplicar filtro inicial
    console.log('Aplicando filtro inicial...');
    // Sincronizar pestañas con el valor inicial del select
    if (sedeSelect) {
        setActiveTab(sedeSelect.value);
    }
    filtrarCarreras();
    
    console.log('=== FILTROS INICIALIZADOS ===');
    
    // Manejar clics en botones de \"Ver Bibliografía\"
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ver-bibliografia')) {
            e.preventDefault();
            
            const button = e.target.closest('.btn-ver-bibliografia');
            const carreraId = button.getAttribute('data-carrera-id');
            const sedesDisponibles = button.getAttribute('data-sedes').split(',');
            const vigenciaDesde = button.getAttribute('data-vigencia-desde') || '';
            const sedeSeleccionada = sedeSelect.value;
            
            console.log('Carrera ID:', carreraId);
            console.log('Sedes disponibles:', sedesDisponibles);
            console.log('Sede seleccionada:', sedeSeleccionada);
            
            // Verificar si la sede seleccionada está disponible para esta carrera
            if (sedeSeleccionada === 'todas' || sedesDisponibles.includes(sedeSeleccionada)) {
                // Usar la sede seleccionada o la primera disponible
                const sedeParaUsar = sedeSeleccionada === 'todas' ? sedesDisponibles[0] : sedeSeleccionada;
                const vigenciaQuery = vigenciaDesde ? `?vigencia_desde=\${encodeURIComponent(vigenciaDesde)}` : '';
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}\${vigenciaQuery}`;
                console.log('Navegando a:', url);
                window.location.href = url;
            } else {
                // Si la sede seleccionada no está disponible, usar la primera sede disponible
                const sedeParaUsar = sedesDisponibles[0];
                const vigenciaQuery = vigenciaDesde ? `?vigencia_desde=\${encodeURIComponent(vigenciaDesde)}` : '';
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}\${vigenciaQuery}`;
                console.log('Sede seleccionada no disponible, usando:', sedeParaUsar);
                console.log('Navegando a:', url);
                window.location.href = url;
            }
        }
    });
});

// Función global para debug
window.debugFiltros = function() {
    console.log('=== DEBUG FILTROS ===');
    console.log('sedeSelect value:', document.getElementById('sedeSelect')?.value);
    console.log('carreraSearch value:', document.getElementById('carreraSearch')?.value);
    console.log('carreraItems:', document.querySelectorAll('.carrera-item').length);
    console.log('tabButtons:', document.querySelectorAll('.tab-btn').length);
    filtrarCarreras();
};
</script>
{% endblock %} ", "frontend/index.twig", "/var/www/html/biblioges/templates/frontend/index.twig");
    }
}
