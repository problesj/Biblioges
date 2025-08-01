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

/* autores/create.twig */
class __TwigTemplate_4adcff3fee3a8e4b0df834faa7f2ce79 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Crear Autor";
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
                    <h3 class=\"card-title\">Crear Nuevo Autor</h3>
                </div>
                <div class=\"card-body\">
                    ";
        // line 14
        if (($context["error"] ?? null)) {
            // line 15
            yield "                    <div class=\"alert alert-danger\">
                        ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
                    </div>
                    ";
        }
        // line 19
        yield "
                    <form action=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/store\" method=\"POST\" class=\"needs-validation\" novalidate>
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"apellidos\">Apellidos *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                                    <div class=\"invalid-feedback\">
                                        Por favor ingrese los apellidos del autor.
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombres\">Nombres *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                                    <div class=\"invalid-feedback\">
                                        Por favor ingrese los nombres del autor.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-3\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"genero\">Género *</label>
                                    <select class=\"form-control\" id=\"genero\" name=\"genero\" required>
                                        <option value=\"\">Seleccione un género</option>
                                        <option value=\"M\">Masculino</option>
                                        <option value=\"F\">Femenino</option>
                                        <option value=\"O\">Otro</option>
                                    </select>
                                    <div class=\"invalid-feedback\">
                                        Por favor seleccione el género del autor.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> Guardar
                                </button>
                                <a href=\"";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"btn btn-secondary\">
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

    // line 77
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 78
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
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
        return "autores/create.twig";
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
        return array (  166 => 78,  159 => 77,  142 => 64,  95 => 20,  92 => 19,  86 => 16,  83 => 15,  81 => 14,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Crear Autor{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Crear Nuevo Autor</h3>
                </div>
                <div class=\"card-body\">
                    {% if error %}
                    <div class=\"alert alert-danger\">
                        {{ error }}
                    </div>
                    {% endif %}

                    <form action=\"{{ app_url }}autores/store\" method=\"POST\" class=\"needs-validation\" novalidate>
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"apellidos\">Apellidos *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                                    <div class=\"invalid-feedback\">
                                        Por favor ingrese los apellidos del autor.
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"nombres\">Nombres *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                                    <div class=\"invalid-feedback\">
                                        Por favor ingrese los nombres del autor.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-3\">
                            <div class=\"col-md-6\">
                                <div class=\"form-group\">
                                    <label for=\"genero\">Género *</label>
                                    <select class=\"form-control\" id=\"genero\" name=\"genero\" required>
                                        <option value=\"\">Seleccione un género</option>
                                        <option value=\"M\">Masculino</option>
                                        <option value=\"F\">Femenino</option>
                                        <option value=\"O\">Otro</option>
                                    </select>
                                    <div class=\"invalid-feedback\">
                                        Por favor seleccione el género del autor.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row mt-4\">
                            <div class=\"col-12\">
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> Guardar
                                </button>
                                <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
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
{% endblock %}

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
{% endblock %} ", "autores/create.twig", "/var/www/html/biblioges/templates/autores/create.twig");
    }
}
