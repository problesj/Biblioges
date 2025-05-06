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

/* sedes/create.twig */
class __TwigTemplate_09acb8561f5d42b81f33915878c20cd2 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "sedes/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Nueva Sede - Sistema de Bibliografía";
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
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Nueva Sede</h6>
        </div>
        <div class=\"card-body\">
            ";
        // line 12
        if (($context["error"] ?? null)) {
            // line 13
            yield "            <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
            ";
        }
        // line 15
        yield "
            <form method=\"POST\" action=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes/store\">
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código de Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                    <a href=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Cancelar
                    </a>
                </div>
            </form>
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
        return "sedes/create.twig";
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
        return array (  124 => 48,  89 => 16,  86 => 15,  80 => 13,  78 => 12,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Nueva Sede - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Nueva Sede</h6>
        </div>
        <div class=\"card-body\">
            {% if error %}
            <div class=\"alert alert-danger\">{{ error }}</div>
            {% endif %}

            <form method=\"POST\" action=\"{{ app_url }}sedes/store\">
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código de Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                    <a href=\"{{ app_url }}sedes\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %} ", "sedes/create.twig", "/var/www/html/biblioges/templates/sedes/create.twig");
    }
}
