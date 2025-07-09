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
class __TwigTemplate_9af07d48709131d7e69934c41edbb6d8 extends Template
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
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/nueva\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" ";
        // line 25
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 25) == "REGULAR")) {
            yield "selected";
        }
        yield ">Regular</option>
                        <option value=\"FORMACION_BASICA\" ";
        // line 26
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 26) == "FORMACION_BASICA")) {
            yield "selected";
        }
        yield ">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" ";
        // line 27
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 27) == "FORMACION_GENERAL")) {
            yield "selected";
        }
        yield ">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" ";
        // line 28
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 28) == "FORMACION_IDIOMAS")) {
            yield "selected";
        }
        yield ">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" ";
        // line 29
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 29) == "FORMACION_PROFESIONAL")) {
            yield "selected";
        }
        yield ">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" ";
        // line 30
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 30) == "FORMACION_VALORES")) {
            yield "selected";
        }
        yield ">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" ";
        // line 31
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 31) == "FORMACION_ESPECIALIDAD")) {
            yield "selected";
        }
        yield ">Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" ";
        // line 32
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 32) == "FORMACION_ELECTIVA")) {
            yield "selected";
        }
        yield ">Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" ";
        // line 33
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 33) == "FORMACION_ESPECIAL")) {
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
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
            // line 41
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 41), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "departamento", [], "any", false, false, false, 41) == CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 41))) {
                yield "selected";
            }
            yield ">
                                ";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "nombre", [], "any", false, false, false, 42), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        yield "                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 51
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 51) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 52
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 52) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-4 d-flex align-items-end\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Filtrar
                    </button>
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
        // line 81
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 82
            yield "                        <tr>
                            <td>";
            // line 83
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 83), "html", null, true);
            yield "</td>
                            <td>";
            // line 84
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 84), "html", null, true);
            yield "</td>
                            <td>";
            // line 85
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_desde", [], "any", false, false, false, 85), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_hasta", [], "any", false, false, false, 85), "html", null, true);
            yield "</td>
                            <td>";
            // line 86
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 86), "html", null, true);
            yield "</td>
                            <td>
                                <span class=\"badge ";
            // line 88
            if (CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 88)) {
                yield "bg-success";
            } else {
                yield "bg-danger";
            }
            yield "\">
                                    ";
            // line 89
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 89)) ? ("Activo") : ("Inactivo"));
            yield "
                                </span>
                            </td>
                            <td>";
            // line 92
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "departamentos", [], "any", false, false, false, 92), "html", null, true);
            yield "</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 95), "html", null, true);
            yield "\" class=\"btn btn-sm btn-primary\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 98), "html", null, true);
            yield "/editar\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 101
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 101), "html", null, true);
            yield "\" method=\"POST\" class=\"d-inline\">
                                        <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('¿Está seguro de eliminar esta asignatura?')\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 110
        if (!$context['_iterated']) {
            // line 111
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
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
        return array (  317 => 115,  308 => 111,  306 => 110,  290 => 101,  282 => 98,  274 => 95,  268 => 92,  262 => 89,  254 => 88,  249 => 86,  243 => 85,  239 => 84,  235 => 83,  232 => 82,  227 => 81,  193 => 52,  187 => 51,  179 => 45,  170 => 42,  161 => 41,  157 => 40,  145 => 33,  139 => 32,  133 => 31,  127 => 30,  121 => 29,  115 => 28,  109 => 27,  103 => 26,  97 => 25,  89 => 20,  75 => 9,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "asignaturas/index.twig", "/var/www/html/biblioges/templates/asignaturas/index.twig");
    }
}
