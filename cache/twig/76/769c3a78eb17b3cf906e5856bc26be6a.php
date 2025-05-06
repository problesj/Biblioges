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

/* carreras/index.twig */
class __TwigTemplate_ed3e3da13d7985b417858c2bf3734227 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Carreras - Sistema de Bibliografía";
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
        yield "<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa</label>
                    <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"P\" ";
        // line 25
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 25) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                        <option value=\"G\" ";
        // line 26
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 26) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                        <option value=\"O\" ";
        // line 27
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 27) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 35
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 35), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 35) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 35))) {
                yield "selected";
            }
            yield ">
                                ";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 36), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        yield "                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 45
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 45) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 46
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 46) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-filter\"></i> Filtrar
                    </button>
                    <a href=\"";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código(s)</th>
                            <th>Nombre</th>
                            <th>Tipo de Programa</th>
                            <th>Sede-Facultad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 80
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 81
            yield "                        <tr>
                                <td>";
            // line 82
            yield Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "codigos_carrera", [], "any", false, false, false, 82), ["," => "<br>"]);
            yield "</td>
                            <td>";
            // line 83
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 83), "html", null, true);
            yield "</td>
                                <td>
                                    ";
            // line 85
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 85) == "P")) {
                // line 86
                yield "                                        Pregrado
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 87
$context["carrera"], "tipo_programa", [], "any", false, false, false, 87) == "G")) {
                // line 88
                yield "                                        Postgrado
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 89
$context["carrera"], "tipo_programa", [], "any", false, false, false, 89) == "O")) {
                // line 90
                yield "                                        Otro
                                    ";
            } else {
                // line 92
                yield "                                        ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 92), "html", null, true);
                yield "
                                    ";
            }
            // line 94
            yield "                                </td>
                            <td>
                                ";
            // line 96
            $context["sedes"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes", [], "any", false, false, false, 96), ",");
            // line 97
            yield "                                ";
            $context["facultades"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "facultades", [], "any", false, false, false, 97), ",");
            // line 98
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["sedes"] ?? null)) - 1)));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 99
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["sedes"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["facultades"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 99)) {
                    yield "<br>";
                }
                // line 100
                yield "                                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 101
            yield "                            </td>
                            <td>
                                    ";
            // line 103
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "estado", [], "any", false, false, false, 103) == 1)) {
                // line 104
                yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
            } else {
                // line 106
                yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
            }
            // line 108
            yield "                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 111), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 114), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 117
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 117), "html", null, true);
            yield "\" method=\"POST\" class=\"d-inline\">
                                        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('¿Está seguro de eliminar esta carrera?')\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 126
        if (!$context['_iterated']) {
            // line 127
            yield "                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 131
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "carreras/index.twig";
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
        return array (  349 => 131,  340 => 127,  338 => 126,  322 => 117,  314 => 114,  306 => 111,  301 => 108,  297 => 106,  293 => 104,  291 => 103,  287 => 101,  273 => 100,  265 => 99,  247 => 98,  244 => 97,  242 => 96,  238 => 94,  232 => 92,  228 => 90,  226 => 89,  223 => 88,  221 => 87,  218 => 86,  216 => 85,  211 => 83,  207 => 82,  204 => 81,  199 => 80,  169 => 53,  157 => 46,  151 => 45,  143 => 39,  134 => 36,  125 => 35,  121 => 34,  109 => 27,  103 => 26,  97 => 25,  89 => 20,  75 => 9,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Carreras - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"{{ app_url }}carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}carreras\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa</label>
                    <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"P\" {% if filtros.tipo_programa == 'P' %}selected{% endif %}>Pregrado</option>
                        <option value=\"G\" {% if filtros.tipo_programa == 'G' %}selected{% endif %}>Postgrado</option>
                        <option value=\"O\" {% if filtros.tipo_programa == 'O' %}selected{% endif %}>Otro</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        {% for sede in sedes %}
                            <option value=\"{{ sede.id }}\" {% if filtros.sede == sede.id %}selected{% endif %}>
                                {{ sede.nombre }}
                            </option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-filter\"></i> Filtrar
                    </button>
                    <a href=\"{{ app_url }}carreras\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código(s)</th>
                            <th>Nombre</th>
                            <th>Tipo de Programa</th>
                            <th>Sede-Facultad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for carrera in carreras %}
                        <tr>
                                <td>{{ carrera.codigos_carrera|replace({',': '<br>'})|raw }}</td>
                            <td>{{ carrera.nombre }}</td>
                                <td>
                                    {% if carrera.tipo_programa == 'P' %}
                                        Pregrado
                                    {% elseif carrera.tipo_programa == 'G' %}
                                        Postgrado
                                    {% elseif carrera.tipo_programa == 'O' %}
                                        Otro
                                    {% else %}
                                        {{ carrera.tipo_programa }}
                                    {% endif %}
                                </td>
                            <td>
                                {% set sedes = carrera.sedes|split(',') %}
                                {% set facultades = carrera.facultades|split(',') %}
                                {% for i in 0..sedes|length-1 %}
                                    {{ sedes[i] }} - {{ facultades[i] }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td>
                                    {% if carrera.estado == 1 %}
                                        <span class=\"badge bg-success\">Activo</span>
                                    {% else %}
                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    {% endif %}
                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}carreras/{{ carrera.id }}\" method=\"POST\" class=\"d-inline\">
                                        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('¿Está seguro de eliminar esta carrera?')\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "carreras/index.twig", "/var/www/html/biblioges/templates/carreras/index.twig");
    }
}
