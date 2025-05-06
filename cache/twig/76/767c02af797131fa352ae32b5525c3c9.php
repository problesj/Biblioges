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

/* asignaturas/index.twig */
class __TwigTemplate_1e815bd89ad0d729e990e1c9122cd56e extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Asignaturas - Sistema de Bibliografía";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" ";
        // line 30
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 30) == "REGULAR")) {
            yield "selected";
        }
        yield ">Regular</option>
                        <option value=\"FORMACION_BASICA\" ";
        // line 31
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 31) == "FORMACION_BASICA")) {
            yield "selected";
        }
        yield ">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" ";
        // line 32
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 32) == "FORMACION_GENERAL")) {
            yield "selected";
        }
        yield ">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" ";
        // line 33
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 33) == "FORMACION_IDIOMAS")) {
            yield "selected";
        }
        yield ">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" ";
        // line 34
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 34) == "FORMACION_PROFESIONAL")) {
            yield "selected";
        }
        yield ">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" ";
        // line 35
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 35) == "FORMACION_VALORES")) {
            yield "selected";
        }
        yield ">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" ";
        // line 36
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 36) == "FORMACION_ESPECIALIDAD")) {
            yield "selected";
        }
        yield ">Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" ";
        // line 37
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 37) == "FORMACION_ELECTIVA")) {
            yield "selected";
        }
        yield ">Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" ";
        // line 38
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 38) == "FORMACION_ESPECIAL")) {
            yield "selected";
        }
        yield ">Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"departamento\" class=\"form-label\">Departamento</label>
                    <select class=\"form-select\" id=\"departamento\" name=\"departamento\">
                        <option value=\"\">Todos los departamentos</option>
                        ";
        // line 45
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
            // line 46
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 46), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "departamento", [], "any", false, false, false, 46) == CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 46))) {
                yield "selected";
            }
            yield ">
                                ";
            // line 47
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "nombre", [], "any", false, false, false, 47), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        yield "                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 56
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 56) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 57
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 57) == "0")) {
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
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Vigencia</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                            <th>Departamentos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 89
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 90
            yield "                        <tr>
                            <td>";
            // line 91
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 91), "html", null, true);
            yield "</td>
                            <td>";
            // line 92
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 92), "html", null, true);
            yield "</td>
                            <td>";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_desde", [], "any", false, false, false, 93), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_hasta", [], "any", false, false, false, 93), "html", null, true);
            yield "</td>
                            <td>";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 94), "html", null, true);
            yield "</td>
                            <td>
                                <span class=\"badge bg-";
            // line 96
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 96) == "1")) ? ("success") : ("danger"));
            yield "\">
                                    ";
            // line 97
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 97) == "1")) ? ("Activo") : ("Inactivo"));
            yield "
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">";
            // line 100
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "departamentos", [], "any", true, true, false, 100)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "departamentos", [], "any", false, false, false, 100), "Sin departamento")) : ("Sin departamento")), "html", null, true);
            yield "</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"";
            // line 103
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 103), "html", null, true);
            yield "\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 106
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 106), "html", null, true);
            yield "/editar\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 109
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 109), "html", null, true);
            yield "\" method=\"POST\" class=\"d-inline\">
                                        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" onclick=\"return confirm('¿Está seguro de eliminar esta asignatura?')\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 118
        if (!$context['_iterated']) {
            // line 119
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 123
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
        return "asignaturas/index.twig";
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
        return array (  327 => 123,  318 => 119,  316 => 118,  300 => 109,  292 => 106,  284 => 103,  278 => 100,  272 => 97,  268 => 96,  263 => 94,  257 => 93,  253 => 92,  249 => 91,  246 => 90,  241 => 89,  213 => 64,  201 => 57,  195 => 56,  187 => 50,  178 => 47,  169 => 46,  165 => 45,  153 => 38,  147 => 37,  141 => 36,  135 => 35,  129 => 34,  123 => 33,  117 => 32,  111 => 31,  105 => 30,  97 => 25,  82 => 13,  76 => 10,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Asignaturas - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"{{ app_url }}asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"{{ app_url }}asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" {% if filtros.tipo == 'REGULAR' %}selected{% endif %}>Regular</option>
                        <option value=\"FORMACION_BASICA\" {% if filtros.tipo == 'FORMACION_BASICA' %}selected{% endif %}>Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" {% if filtros.tipo == 'FORMACION_GENERAL' %}selected{% endif %}>Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" {% if filtros.tipo == 'FORMACION_IDIOMAS' %}selected{% endif %}>Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" {% if filtros.tipo == 'FORMACION_PROFESIONAL' %}selected{% endif %}>Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" {% if filtros.tipo == 'FORMACION_VALORES' %}selected{% endif %}>Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" {% if filtros.tipo == 'FORMACION_ESPECIALIDAD' %}selected{% endif %}>Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" {% if filtros.tipo == 'FORMACION_ELECTIVA' %}selected{% endif %}>Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" {% if filtros.tipo == 'FORMACION_ESPECIAL' %}selected{% endif %}>Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"departamento\" class=\"form-label\">Departamento</label>
                    <select class=\"form-select\" id=\"departamento\" name=\"departamento\">
                        <option value=\"\">Todos los departamentos</option>
                        {% for departamento in departamentos %}
                            <option value=\"{{ departamento.id }}\" {% if filtros.departamento == departamento.id %}selected{% endif %}>
                                {{ departamento.nombre }}
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
                    <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Vigencia</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                            <th>Departamentos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for asignatura in asignaturas %}
                        <tr>
                            <td>{{ asignatura.nombre }}</td>
                            <td>{{ asignatura.tipo }}</td>
                            <td>{{ asignatura.vigencia_desde }} - {{ asignatura.vigencia_hasta }}</td>
                            <td>{{ asignatura.periodicidad }}</td>
                            <td>
                                <span class=\"badge bg-{{ asignatura.estado == '1' ? 'success' : 'danger' }}\">
                                    {{ asignatura.estado == '1' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">{{ asignatura.departamentos|default('Sin departamento') }}</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}/editar\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}asignaturas/{{ asignatura.id }}\" method=\"POST\" class=\"d-inline\">
                                        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" onclick=\"return confirm('¿Está seguro de eliminar esta asignatura?')\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "asignaturas/index.twig", "/var/www/html/biblioges/templates/asignaturas/index.twig");
    }
}
