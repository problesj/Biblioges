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

/* departamentos/create.twig */
class __TwigTemplate_bb5988bfccb160fcec73136f0aa0dd24 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "departamentos/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Nuevo Departamento";
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
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Nuevo Departamento</h6>
            <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"btn btn-secondary btn-sm\">
                <i class=\"fas fa-arrow-left me-2\"></i>Volver
            </a>
        </div>
        <div class=\"card-body\">
            ";
        // line 15
        if (($context["error"] ?? null)) {
            // line 16
            yield "            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <i class=\"fas fa-exclamation-circle me-2\"></i>
                ";
            // line 18
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
            ";
        }
        // line 22
        yield "
            <form method=\"POST\" action=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" id=\"departamentoForm\" class=\"needs-validation\" novalidate>
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código del Departamento <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required 
                                pattern=\"[A-Za-z0-9]+\" title=\"Solo se permiten letras y números\"
                                placeholder=\"Ingrese el código\">
                            <div class=\"invalid-feedback\">
                                Por favor ingrese un código válido (solo letras y números)
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre del Departamento <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required
                                placeholder=\"Ingrese el nombre\">
                            <div class=\"invalid-feedback\">
                                Por favor ingrese el nombre del departamento
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"facultad_id\" class=\"form-label\">Facultad <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\" required>
                                <option value=\"\">Seleccione una facultad</option>
                                ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["facultades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["facultad"]) {
            // line 55
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 55), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 55), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['facultad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
        yield "                            </select>
                            <div class=\"invalid-feedback\">
                                Por favor seleccione una facultad
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                            <div class=\"invalid-feedback\">
                                Por favor seleccione un estado
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"row mt-4\">
                    <div class=\"col-12\">
                        <div class=\"d-flex gap-2\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-save me-2\"></i>Guardar
                            </button>
                            <a href=\"";
        // line 83
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times me-2\"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validación del formulario usando Bootstrap
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "departamentos/create.twig";
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
        return array (  177 => 83,  149 => 57,  138 => 55,  134 => 54,  100 => 23,  97 => 22,  90 => 18,  86 => 16,  84 => 15,  76 => 10,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Nuevo Departamento{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Nuevo Departamento</h6>
            <a href=\"{{ app_url }}departamentos\" class=\"btn btn-secondary btn-sm\">
                <i class=\"fas fa-arrow-left me-2\"></i>Volver
            </a>
        </div>
        <div class=\"card-body\">
            {% if error %}
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <i class=\"fas fa-exclamation-circle me-2\"></i>
                {{ error }}
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
            {% endif %}

            <form method=\"POST\" action=\"{{ app_url }}departamentos\" id=\"departamentoForm\" class=\"needs-validation\" novalidate>
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"codigo\" class=\"form-label\">Código del Departamento <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo\" name=\"codigo\" required 
                                pattern=\"[A-Za-z0-9]+\" title=\"Solo se permiten letras y números\"
                                placeholder=\"Ingrese el código\">
                            <div class=\"invalid-feedback\">
                                Por favor ingrese un código válido (solo letras y números)
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"nombre\" class=\"form-label\">Nombre del Departamento <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required
                                placeholder=\"Ingrese el nombre\">
                            <div class=\"invalid-feedback\">
                                Por favor ingrese el nombre del departamento
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"facultad_id\" class=\"form-label\">Facultad <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\" required>
                                <option value=\"\">Seleccione una facultad</option>
                                {% for facultad in facultades %}
                                    <option value=\"{{ facultad.id }}\">{{ facultad.nombre }}</option>
                                {% endfor %}
                            </select>
                            <div class=\"invalid-feedback\">
                                Por favor seleccione una facultad
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                            <div class=\"invalid-feedback\">
                                Por favor seleccione un estado
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"row mt-4\">
                    <div class=\"col-12\">
                        <div class=\"d-flex gap-2\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-save me-2\"></i>Guardar
                            </button>
                            <a href=\"{{ app_url }}departamentos\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times me-2\"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validación del formulario usando Bootstrap
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
{% endblock %} ", "departamentos/create.twig", "/var/www/html/biblioges/templates/departamentos/create.twig");
    }
}
