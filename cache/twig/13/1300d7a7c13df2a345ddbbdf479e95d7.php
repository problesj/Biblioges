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
                        <p>";
        // line 39
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 39) == "P")) ? ("Pregrado") : ("Postgrado"));
        yield "</p>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">Estado:</label>
                        <p>
                            ";
        // line 46
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 46) == 1)) {
            // line 47
            yield "                                <span class=\"badge bg-success\">Activo</span>
                            ";
        } else {
            // line 49
            yield "                                <span class=\"badge bg-danger\">Inactivo</span>
                            ";
        }
        // line 51
        yield "                        </p>
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <div class=\"form-group\">
                        <label class=\"font-weight-bold\">URL del Libro:</label>
                        <p>
                            ";
        // line 60
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 60)) {
            // line 61
            yield "                                <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 61), "html", null, true);
            yield "\" target=\"_blank\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 61), "html", null, true);
            yield "</a>
                            ";
        } else {
            // line 63
            yield "                                Sin información
                            ";
        }
        // line 65
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
                            <th>Facultad</th>
                            <th>Sede</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 89
        $context["codigos"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos", [], "any", false, false, false, 89), "
");
        // line 90
        yield "                        ";
        $context["vigencias_desde"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 90), "
");
        // line 91
        yield "                        ";
        $context["vigencias_hasta"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 91), "
");
        // line 92
        yield "                        ";
        $context["facultades"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "facultades", [], "any", false, false, false, 92), "
");
        // line 93
        yield "                        ";
        $context["sedes"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 93), "
");
        // line 94
        yield "                        
                        ";
        // line 95
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["codigos"] ?? null)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 96
            yield "                            <tr>
                                <td>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["codigos"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                                <td>
                                    ";
            // line 99
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["vigencias_desde"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = ($context["vigencias_hasta"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["i"]] ?? null) : null), "html", null, true);
            yield "
                                </td>
                                <td>";
            // line 101
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = ($context["facultades"] ?? null)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                                <td>";
            // line 102
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v4 = ($context["sedes"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[$context["i"]] ?? null) : null), "html", null, true);
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
        // line 108
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
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
        // line 131
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 131) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 131)) > 0))) {
            // line 132
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 132));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 133
                yield "                                <tr>
                                    <td>";
                // line 134
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 134), "html", null, true);
                yield "</td>
                                    <td>";
                // line 135
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 135), "html", null, true);
                yield "</td>
                                    <td>";
                // line 136
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 136), "html", null, true);
                yield "</td>
                                    <td>";
                // line 137
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 137), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 139
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 139) == 1)) {
                    // line 140
                    yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
                } else {
                    // line 142
                    yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
                }
                // line 144
                yield "                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 147
            yield "                        ";
        } else {
            // line 148
            yield "                            <tr>
                                <td colspan=\"5\" class=\"text-center\">No hay asignaturas vinculadas a esta carrera</td>
                            </tr>
                        ";
        }
        // line 152
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 160
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 161
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
        return array (  342 => 161,  335 => 160,  324 => 152,  318 => 148,  315 => 147,  307 => 144,  303 => 142,  299 => 140,  297 => 139,  292 => 137,  288 => 136,  284 => 135,  280 => 134,  277 => 133,  272 => 132,  270 => 131,  245 => 108,  233 => 102,  229 => 101,  222 => 99,  217 => 97,  214 => 96,  210 => 95,  207 => 94,  203 => 93,  199 => 92,  195 => 91,  191 => 90,  188 => 89,  162 => 65,  158 => 63,  150 => 61,  148 => 60,  137 => 51,  133 => 49,  129 => 47,  127 => 46,  117 => 39,  108 => 33,  90 => 18,  82 => 15,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
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
                        <p>{{ carrera.tipo_programa == 'P' ? 'Pregrado' : 'Postgrado' }}</p>
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
                        <label class=\"font-weight-bold\">URL del Libro:</label>
                        <p>
                            {% if carrera.url_libro %}
                                <a href=\"{{ carrera.url_libro }}\" target=\"_blank\">{{ carrera.url_libro }}</a>
                            {% else %}
                                Sin información
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
                            <th>Facultad</th>
                            <th>Sede</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% set codigos = carrera.codigos|split('\\n') %}
                        {% set vigencias_desde = carrera.vigencias_desde|split('\\n') %}
                        {% set vigencias_hasta = carrera.vigencias_hasta|split('\\n') %}
                        {% set facultades = carrera.facultades|split('\\n') %}
                        {% set sedes = carrera.sedes|split('\\n') %}
                        
                        {% for i in 0..(codigos|length - 1) %}
                            <tr>
                                <td>{{ codigos[i] }}</td>
                                <td>
                                    {{ vigencias_desde[i] }} - {{ vigencias_hasta[i] }}
                                </td>
                                <td>{{ facultades[i] }}</td>
                                <td>{{ sedes[i] }}</td>
                                <td>
                                    <span class=\"badge bg-success\">Activo</span>
                                </td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
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
                        {% if carrera.asignaturas is defined and carrera.asignaturas|length > 0 %}
                            {% for asignatura in carrera.asignaturas %}
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
                                <td colspan=\"5\" class=\"text-center\">No hay asignaturas vinculadas a esta carrera</td>
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
