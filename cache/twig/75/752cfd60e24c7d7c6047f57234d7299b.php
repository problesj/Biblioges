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

/* facultades/edit.twig */
class __TwigTemplate_c63ff253983737ebf73089880edde947 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "facultades/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Facultad - Sistema de Bibliografía";
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
                    <h3 class=\"card-title\">Editar Facultad</h3>
                </div>
                <div class=\"card-body\">
                    <form action=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "id", [], "any", false, false, false, 14), "html", null, true);
        yield "/update\" method=\"POST\">
                        <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"codigo\">Código de Facultad</label>
                                    <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" value=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "codigo", [], "any", false, false, false, 20), "html", null, true);
        yield "\" required>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombre\">Nombre de Facultad</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 26
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "nombre", [], "any", false, false, false, 26), "html", null, true);
        yield "\" required>
                                </div>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"sede_id\">Sede</label>
                                    <select class=\"form-control\" id=\"sede_id\" name=\"sede_id\" required>
                                        <option value=\"\">Seleccione una sede</option>
                                        ";
        // line 36
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 37
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 37), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 37) == CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "sede_id", [], "any", false, false, false, 37))) {
                yield "selected";
            }
            yield ">
                                                ";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 38), "html", null, true);
            yield "
                                            </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield "                                    </select>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"estado\">Estado</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"1\" ";
        // line 48
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "estado", [], "any", false, false, false, 48) == 1)) {
            yield "selected";
        }
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 49
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["facultad"] ?? null), "estado", [], "any", false, false, false, 49) == 0)) {
            yield "selected";
        }
        yield ">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-12\">
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
        return "facultades/edit.twig";
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
        return array (  165 => 59,  150 => 49,  144 => 48,  135 => 41,  126 => 38,  117 => 37,  113 => 36,  100 => 26,  91 => 20,  80 => 14,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Editar Facultad - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Editar Facultad</h3>
                </div>
                <div class=\"card-body\">
                    <form action=\"{{ app_url }}facultades/{{ facultad.id }}/update\" method=\"POST\">
                        <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"codigo\">Código de Facultad</label>
                                    <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" value=\"{{ facultad.codigo }}\" required>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombre\">Nombre de Facultad</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ facultad.nombre }}\" required>
                                </div>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"sede_id\">Sede</label>
                                    <select class=\"form-control\" id=\"sede_id\" name=\"sede_id\" required>
                                        <option value=\"\">Seleccione una sede</option>
                                        {% for sede in sedes %}
                                            <option value=\"{{ sede.id }}\" {% if sede.id == facultad.sede_id %}selected{% endif %}>
                                                {{ sede.nombre }}
                                            </option>
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"estado\">Estado</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"1\" {% if facultad.estado == 1 %}selected{% endif %}>Activo</option>
                                        <option value=\"0\" {% if facultad.estado == 0 %}selected{% endif %}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-12\">
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> Guardar
                                </button>
                                <a href=\"{{ app_url }}facultades\" class=\"btn btn-secondary\">
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
{% endblock %} ", "facultades/edit.twig", "/var/www/html/biblioges/templates/facultades/edit.twig");
    }
}
