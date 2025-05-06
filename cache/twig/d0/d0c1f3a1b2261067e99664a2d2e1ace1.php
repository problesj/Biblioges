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

/* facultades/create.twig */
class __TwigTemplate_14e5f12a71beb77df916dd98d4cfdfb1 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "facultades/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Nueva Facultad - Sistema de Bibliografía";
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
            <h6 class=\"m-0 font-weight-bold text-primary\">Nueva Facultad</h6>
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
        yield "facultades/store\">
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código de Facultad</label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de Facultad</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"sede_id\" class=\"form-label\">Sede</label>
                            <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\" required>
                                <option value=\"\">Seleccione una sede</option>
                                ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 39
            yield "                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 39), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 39), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield "                            </select>
                        </div>
                    </div>
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
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades\" class=\"btn btn-secondary\">
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
        return "facultades/create.twig";
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
        return array (  149 => 59,  129 => 41,  118 => 39,  114 => 38,  89 => 16,  86 => 15,  80 => 13,  78 => 12,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Nueva Facultad - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Nueva Facultad</h6>
        </div>
        <div class=\"card-body\">
            {% if error %}
            <div class=\"alert alert-danger\">{{ error }}</div>
            {% endif %}

            <form method=\"POST\" action=\"{{ app_url }}facultades/store\">
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código de Facultad</label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de Facultad</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"sede_id\" class=\"form-label\">Sede</label>
                            <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\" required>
                                <option value=\"\">Seleccione una sede</option>
                                {% for sede in sedes %}
                                <option value=\"{{ sede.id }}\">{{ sede.nombre }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
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
                    <a href=\"{{ app_url }}facultades\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %} ", "facultades/create.twig", "/var/www/html/biblioges/templates/facultades/create.twig");
    }
}
