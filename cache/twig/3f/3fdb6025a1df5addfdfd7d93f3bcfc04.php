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

/* asignaturas/show.twig */
class __TwigTemplate_22c6f3c12a447186507b22fb7e42cdfe extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Asignatura - Sistema de Bibliografía";
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
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de Asignatura</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Datos comunes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <p><strong>Nombre:</strong> ";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "nombre", [], "any", false, false, false, 22), "html", null, true);
        yield "</p>
                    <p><strong>Tipo:</strong> ";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 23), "html", null, true);
        yield "</p>
                    <p><strong>Vigencia:</strong> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_desde", [], "any", false, false, false, 24), "html", null, true);
        yield " - ";
        yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_hasta", [], "any", false, false, false, 24)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_hasta", [], "any", false, false, false, 24), "html", null, true)) : ("Sin fecha de término"));
        yield "</p>
                </div>
                <div class=\"col-md-6\">
                    <p><strong>Periodicidad:</strong> ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "periodicidad", [], "any", false, false, false, 27), "html", null, true);
        yield "</p>
                    <p><strong>Estado:</strong> 
                        <span class=\"badge ";
        // line 29
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 29) == 1)) {
            yield "bg-success";
        } else {
            yield "bg-danger";
        }
        yield " text-white\">
                            ";
        // line 30
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 30) == 1)) ? ("Activo") : ("Inactivo"));
        yield "
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Códigos asociados -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos Asociados</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código Asignatura</th>
                            <th>Sede - Unidad</th>
                            <th>Cantidad de Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "unidades", [], "any", false, false, false, 54));
        foreach ($context['_seq'] as $context["_key"] => $context["info"]) {
            // line 55
            yield "                            <tr>
                                <td>";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "codigo_asignatura", [], "any", false, false, false, 56), "html", null, true);
            yield "</td>
                                <td>";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "unidad_completa", [], "any", false, false, false, 57), "html", null, true);
            yield "</td>
                                <td>";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "cantidad_alumnos", [], "any", false, false, false, 58), "html", null, true);
            yield "</td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['info'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 67) == "FORMACION_ELECTIVA")) {
            // line 68
            yield "        <!-- Asignaturas vinculadas (solo para Formación Electiva) -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Periodicidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 86
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vinculadas", [], "any", false, false, false, 86));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura_vinculada"]) {
                // line 87
                yield "                                <tr>
                                    <td>";
                // line 88
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "codigo_asignatura", [], "any", false, false, false, 88), "html", null, true);
                yield "</td>
                                    <td>";
                // line 89
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "nombre", [], "any", false, false, false, 89), "html", null, true);
                yield "</td>
                                    <td>";
                // line 90
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "tipo", [], "any", false, false, false, 90), "html", null, true);
                yield "</td>
                                    <td>
                                        <span class=\"badge ";
                // line 92
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 92) == 1)) {
                    yield "bg-success";
                } else {
                    yield "bg-danger";
                }
                yield " text-white\">
                                            ";
                // line 93
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 93) == 1)) ? ("Activo") : ("Inactivo"));
                yield "
                                        </span>
                                    </td>
                                    <td>";
                // line 96
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "periodicidad", [], "any", false, false, false, 96), "html", null, true);
                yield "</td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura_vinculada'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 99
            yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    ";
        }
        // line 105
        yield "</div>
";
        yield from [];
    }

    // line 108
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 109
        yield "<script src=\"/js/asignaturas.js\"></script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "asignaturas/show.twig";
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
        return array (  266 => 109,  259 => 108,  253 => 105,  245 => 99,  236 => 96,  230 => 93,  222 => 92,  217 => 90,  213 => 89,  209 => 88,  206 => 87,  202 => 86,  182 => 68,  180 => 67,  172 => 61,  163 => 58,  159 => 57,  155 => 56,  152 => 55,  148 => 54,  121 => 30,  113 => 29,  108 => 27,  100 => 24,  96 => 23,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Detalles de Asignatura - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de Asignatura</h1>
        <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Datos comunes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <p><strong>Nombre:</strong> {{ asignatura.nombre }}</p>
                    <p><strong>Tipo:</strong> {{ asignatura.tipo }}</p>
                    <p><strong>Vigencia:</strong> {{ asignatura.vigencia_desde }} - {{ asignatura.vigencia_hasta ?: 'Sin fecha de término' }}</p>
                </div>
                <div class=\"col-md-6\">
                    <p><strong>Periodicidad:</strong> {{ asignatura.periodicidad }}</p>
                    <p><strong>Estado:</strong> 
                        <span class=\"badge {% if asignatura.estado == 1 %}bg-success{% else %}bg-danger{% endif %} text-white\">
                            {{ asignatura.estado == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Códigos asociados -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos Asociados</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código Asignatura</th>
                            <th>Sede - Unidad</th>
                            <th>Cantidad de Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for info in asignatura.unidades %}
                            <tr>
                                <td>{{ info.codigo_asignatura }}</td>
                                <td>{{ info.unidad_completa }}</td>
                                <td>{{ info.cantidad_alumnos }}</td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {% if asignatura.tipo == 'FORMACION_ELECTIVA' %}
        <!-- Asignaturas vinculadas (solo para Formación Electiva) -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Periodicidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for asignatura_vinculada in asignatura.vinculadas %}
                                <tr>
                                    <td>{{ asignatura_vinculada.codigo_asignatura }}</td>
                                    <td>{{ asignatura_vinculada.nombre }}</td>
                                    <td>{{ asignatura_vinculada.tipo }}</td>
                                    <td>
                                        <span class=\"badge {% if asignatura_vinculada.estado == 1 %}bg-success{% else %}bg-danger{% endif %} text-white\">
                                            {{ asignatura_vinculada.estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ asignatura_vinculada.periodicidad }}</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {% endif %}
</div>
{% endblock %}

{% block scripts %}
<script src=\"/js/asignaturas.js\"></script>
{% endblock %} ", "asignaturas/show.twig", "/var/www/html/biblioges/templates/asignaturas/show.twig");
    }
}
