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

/* carreras/show.twig */
class __TwigTemplate_cb8122c50c7c21b18f880e5b0ecb548b extends Template
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
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.twig", "carreras/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Carrera - Sistema de Bibliografía";
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
        yield "<div class=\"container-fluid\">
    <!-- Botón para ocultar/mostrar el panel lateral -->
    <button id=\"sidebarToggle\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
        <i class=\"fas fa-bars\"></i>
    </button>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de la Carrera</h1>
        <div>
            <a href=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 15), "html", null, true);
        yield "/edit\" class=\"btn btn-primary me-2\">
                <i class=\"fas fa-edit\"></i> Editar
            </a>
            <a href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Nombre de la Carrera:</label>
                        <p>";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 33), "html", null, true);
        yield "</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Tipo de Programa:</label>
                        <p>
                            ";
        // line 40
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 40) == "P")) {
            // line 41
            yield "                                Pregrado
                            ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 42
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 42) == "G")) {
            // line 43
            yield "                                Postgrado
                            ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 44
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 44) == "O")) {
            // line 45
            yield "                                Otro
                            ";
        } else {
            // line 47
            yield "                                ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 47), "html", null, true);
            yield "
                            ";
        }
        // line 49
        yield "                        </p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Estado:</label>
                        <p>
                            ";
        // line 56
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 56) == 1)) {
            // line 57
            yield "                                <span class=\"badge bg-success\">Activo</span>
                            ";
        } else {
            // line 59
            yield "                                <span class=\"badge bg-danger\">Inactivo</span>
                            ";
        }
        // line 61
        yield "                        </p>
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Libro de Carrera:</label>
                        <p>
                            ";
        // line 70
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 70)) {
            // line 71
            yield "                                <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 71), "html", null, true);
            yield "\" target=\"_blank\" class=\"btn btn-sm btn-primary\">
                                    <i class=\"fas fa-file-pdf\"></i> Ver Libro de Carrera
                                </a>
                                <small class=\"text-muted d-block mt-1\">
                                    <i class=\"fas fa-info-circle\"></i> 
                                    Archivo PDF disponible para descarga
                                </small>
                            ";
        } else {
            // line 79
            yield "                                <span class=\"text-muted\">
                                    <i class=\"fas fa-times-circle\"></i> 
                                    No hay libro de carrera disponible
                                </span>
                            ";
        }
        // line 84
        yield "                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos de Carrera</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Vigencia</th>
                            <th>Unidad</th>
                            <th>Sede</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 108
        if ((array_key_exists("codigos_carrera", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["codigos_carrera"] ?? null)) > 0))) {
            // line 109
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["codigos_carrera"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["codigo"]) {
                // line 110
                yield "                                <tr>
                                    <td>";
                // line 111
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "codigo_carrera", [], "any", false, false, false, 111), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 113
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "vigencia_desde", [], "any", false, false, false, 113), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "vigencia_hasta", [], "any", false, false, false, 113), "html", null, true);
                yield "
                                    </td>
                                    <td>";
                // line 115
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "unidad_nombre", [], "any", false, false, false, 115), "html", null, true);
                yield "</td>
                                    <td>";
                // line 116
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "sede_nombre", [], "any", false, false, false, 116), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 118
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["codigo"], "estado", [], "any", false, false, false, 118) == 1)) {
                    // line 119
                    yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
                } else {
                    // line 121
                    yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
                }
                // line 123
                yield "                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['codigo'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 126
            yield "                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", true, true, false, 126) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 126)) > 0))) {
            // line 127
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 127)) - 1)));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 128
                yield "                                <tr>
                                    <td>";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 129)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 131
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 131)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 131)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["i"]] ?? null) : null), "html", null, true);
                yield "
                                    </td>
                                    <td>";
                // line 133
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades", [], "any", false, false, false, 133)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["i"]] ?? null) : null), "html", null, true);
                yield "</td>
                                    <td>";
                // line 134
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 134)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[$context["i"]] ?? null) : null), "html", null, true);
                yield "</td>
                                    <td>
                                        <span class=\"badge bg-success\">Activo</span>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 140
            yield "                        ";
        } else {
            // line 141
            yield "                            <tr>
                                <td colspan=\"5\" class=\"text-center\">No hay códigos de carrera asociados</td>
                            </tr>
                        ";
        }
        // line 145
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            <a href=\"";
        // line 154
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 154), "html", null, true);
        yield "/edit\" class=\"btn btn-primary btn-sm\">
                <i class=\"fas fa-edit\"></i> Gestionar Malla
            </a>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Nombre de Asignatura</th>
                            <th>Tipo</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 171
        if ((array_key_exists("asignaturas_vinculadas", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["asignaturas_vinculadas"] ?? null)) > 0))) {
            // line 172
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_vinculadas"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 173
                yield "                                <tr>
                                    <td>";
                // line 174
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 174), "html", null, true);
                yield "</td>
                                    <td>";
                // line 175
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 175), "html", null, true);
                yield "</td>
                                    <td>";
                // line 176
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 176), "html", null, true);
                yield "</td>
                                    <td>";
                // line 177
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 177), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 179
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 179) == 1)) {
                    // line 180
                    yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
                } else {
                    // line 182
                    yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
                }
                // line 184
                yield "                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 187
            yield "                        ";
        } else {
            // line 188
            yield "                            <tr>
                                <td colspan=\"5\" class=\"text-center\">
                                    No hay asignaturas vinculadas a esta carrera
                                    <br>
                                    <small class=\"text-muted\">Haz clic en \"Gestionar Malla\" para agregar asignaturas</small>
                                </td>
                            </tr>
                        ";
        }
        // line 196
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 204
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 205
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Inicializar DataTables para la tabla de códigos
        \$('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            paging: false,
            info: false,
            searching: false,
            ordering: false
        });
    });
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "carreras/show.twig";
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
        return array (  424 => 205,  417 => 204,  406 => 196,  396 => 188,  393 => 187,  385 => 184,  381 => 182,  377 => 180,  375 => 179,  370 => 177,  366 => 176,  362 => 175,  358 => 174,  355 => 173,  350 => 172,  348 => 171,  326 => 154,  315 => 145,  309 => 141,  306 => 140,  294 => 134,  290 => 133,  283 => 131,  278 => 129,  275 => 128,  270 => 127,  267 => 126,  259 => 123,  255 => 121,  251 => 119,  249 => 118,  244 => 116,  240 => 115,  233 => 113,  228 => 111,  225 => 110,  220 => 109,  218 => 108,  192 => 84,  185 => 79,  172 => 71,  170 => 70,  159 => 61,  155 => 59,  151 => 57,  149 => 56,  140 => 49,  134 => 47,  130 => 45,  128 => 44,  125 => 43,  123 => 42,  120 => 41,  118 => 40,  108 => 33,  90 => 18,  82 => 15,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Detalles de Carrera - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <!-- Botón para ocultar/mostrar el panel lateral -->
    <button id=\"sidebarToggle\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
        <i class=\"fas fa-bars\"></i>
    </button>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de la Carrera</h1>
        <div>
            <a href=\"{{ app_url }}carreras/{{ carrera.id }}/edit\" class=\"btn btn-primary me-2\">
                <i class=\"fas fa-edit\"></i> Editar
            </a>
            <a href=\"{{ app_url }}carreras\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Nombre de la Carrera:</label>
                        <p>{{ carrera.nombre }}</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Tipo de Programa:</label>
                        <p>
                            {% if carrera.tipo_programa == 'P' %}
                                Pregrado
                            {% elseif carrera.tipo_programa == 'G' %}
                                Postgrado
                            {% elseif carrera.tipo_programa == 'O' %}
                                Otro
                            {% else %}
                                {{ carrera.tipo_programa }}
                            {% endif %}
                        </p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Estado:</label>
                        <p>
                            {% if carrera.estado == 1 %}
                                <span class=\"badge bg-success\">Activo</span>
                            {% else %}
                                <span class=\"badge bg-danger\">Inactivo</span>
                            {% endif %}
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Libro de Carrera:</label>
                        <p>
                            {% if carrera.url_libro %}
                                <a href=\"{{ app_url }}{{ carrera.url_libro }}\" target=\"_blank\" class=\"btn btn-sm btn-primary\">
                                    <i class=\"fas fa-file-pdf\"></i> Ver Libro de Carrera
                                </a>
                                <small class=\"text-muted d-block mt-1\">
                                    <i class=\"fas fa-info-circle\"></i> 
                                    Archivo PDF disponible para descarga
                                </small>
                            {% else %}
                                <span class=\"text-muted\">
                                    <i class=\"fas fa-times-circle\"></i> 
                                    No hay libro de carrera disponible
                                </span>
                            {% endif %}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos de Carrera</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Vigencia</th>
                            <th>Unidad</th>
                            <th>Sede</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% if codigos_carrera is defined and codigos_carrera|length > 0 %}
                            {% for codigo in codigos_carrera %}
                                <tr>
                                    <td>{{ codigo.codigo_carrera }}</td>
                                    <td>
                                        {{ codigo.vigencia_desde }} - {{ codigo.vigencia_hasta }}
                                    </td>
                                    <td>{{ codigo.unidad_nombre }}</td>
                                    <td>{{ codigo.sede_nombre }}</td>
                                    <td>
                                        {% if codigo.estado == 1 %}
                                            <span class=\"badge bg-success\">Activo</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        {% endif %}
                                    </td>
                                </tr>
                            {% endfor %}
                        {% elseif carrera.codigos_carrera is defined and carrera.codigos_carrera|length > 0 %}
                            {% for i in 0..(carrera.codigos_carrera|length - 1) %}
                                <tr>
                                    <td>{{ carrera.codigos_carrera[i] }}</td>
                                    <td>
                                        {{ carrera.vigencias_desde[i] }} - {{ carrera.vigencias_hasta[i] }}
                                    </td>
                                    <td>{{ carrera.unidades[i] }}</td>
                                    <td>{{ carrera.sedes[i] }}</td>
                                    <td>
                                        <span class=\"badge bg-success\">Activo</span>
                                    </td>
                                </tr>
                            {% endfor %}
                        {% else %}
                            <tr>
                                <td colspan=\"5\" class=\"text-center\">No hay códigos de carrera asociados</td>
                            </tr>
                        {% endif %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            <a href=\"{{ app_url }}mallas/{{ carrera.id }}/edit\" class=\"btn btn-primary btn-sm\">
                <i class=\"fas fa-edit\"></i> Gestionar Malla
            </a>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Nombre de Asignatura</th>
                            <th>Tipo</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% if asignaturas_vinculadas is defined and asignaturas_vinculadas|length > 0 %}
                            {% for asignatura in asignaturas_vinculadas %}
                                <tr>
                                    <td>{{ asignatura.semestre }}</td>
                                    <td>{{ asignatura.nombre }}</td>
                                    <td>{{ asignatura.tipo }}</td>
                                    <td>{{ asignatura.periodicidad }}</td>
                                    <td>
                                        {% if asignatura.estado == 1 %}
                                            <span class=\"badge bg-success\">Activo</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        {% endif %}
                                    </td>
                                </tr>
                            {% endfor %}
                        {% else %}
                            <tr>
                                <td colspan=\"5\" class=\"text-center\">
                                    No hay asignaturas vinculadas a esta carrera
                                    <br>
                                    <small class=\"text-muted\">Haz clic en \"Gestionar Malla\" para agregar asignaturas</small>
                                </td>
                            </tr>
                        {% endif %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Inicializar DataTables para la tabla de códigos
        \$('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            paging: false,
            info: false,
            searching: false,
            ordering: false
        });
    });
</script>
{% endblock %} ", "carreras/show.twig", "/var/www/html/biblioges/templates/carreras/show.twig");
    }
}
