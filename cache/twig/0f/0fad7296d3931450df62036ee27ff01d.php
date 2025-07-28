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

/* sedes/edit.twig */
class __TwigTemplate_9f79acb48d9401d9deb5e3368ce42862 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "sedes/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Sede";
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
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Editar Sede</h3>
                </div>
                <div class=\"card-body\">
                    ";
        // line 14
        if (($context["error"] ?? null)) {
            // line 15
            yield "                        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
                    ";
        }
        // line 17
        yield "
                    <form action=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["sede"] ?? null), "id", [], "any", false, false, false, 18), "html", null, true);
        yield "/update\" method=\"post\">
                        <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                        
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"codigo\">Código de Sede *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" value=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["sede"] ?? null), "codigo", [], "any", false, false, false, 25), "html", null, true);
        yield "\" required>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombre\">Nombre de Sede *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["sede"] ?? null), "nombre", [], "any", false, false, false, 31), "html", null, true);
        yield "\" required>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-3\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"estado\">Estado</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"1\" ";
        // line 41
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["sede"] ?? null), "estado", [], "any", false, false, false, 41) == 1)) ? ("selected") : (""));
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 42
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["sede"] ?? null), "estado", [], "any", false, false, false, 42) == 0)) ? ("selected") : (""));
        yield ">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> Guardar Cambios
                                </button>
                                <a href=\"";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"btn btn-secondary\">
                                    <i class=\"fas fa-times\"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
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
        return "sedes/edit.twig";
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
        return array (  143 => 53,  129 => 42,  125 => 41,  112 => 31,  103 => 25,  91 => 18,  88 => 17,  82 => 15,  80 => 14,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Editar Sede{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Editar Sede</h3>
                </div>
                <div class=\"card-body\">
                    {% if error %}
                        <div class=\"alert alert-danger\">{{ error }}</div>
                    {% endif %}

                    <form action=\"{{ app_url }}sedes/{{ sede.id }}/update\" method=\"post\">
                        <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                        
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"codigo\">Código de Sede *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" value=\"{{ sede.codigo }}\" required>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombre\">Nombre de Sede *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ sede.nombre }}\" required>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-3\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"estado\">Estado</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"1\" {{ sede.estado == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value=\"0\" {{ sede.estado == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> Guardar Cambios
                                </button>
                                <a href=\"{{ app_url }}sedes\" class=\"btn btn-secondary\">
                                    <i class=\"fas fa-times\"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "sedes/edit.twig", "/var/www/html/biblioges/templates/sedes/edit.twig");
    }
}
