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

/* usuarios/edit.twig */
class __TwigTemplate_d27d274f462440293bf483d1463ba46a extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "usuarios/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Usuario";
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
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">
                            <i class=\"fas fa-user-edit\"></i> Editar Usuario
                        </h3>
                        <div>
                            <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <form id=\"editUserForm\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rut\" class=\"form-label\">RUT *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" 
                                           value=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rut", [], "any", false, false, false, 29), "html", null, true);
        yield "\" placeholder=\"12345678-9\" required>
                                    <div class=\"invalid-feedback\" id=\"rut-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"nombre\" class=\"form-label\">Nombre Completo *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                           value=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "nombre", [], "any", false, false, false, 37), "html", null, true);
        yield "\" placeholder=\"Juan Pérez\" required>
                                    <div class=\"invalid-feedback\" id=\"nombre-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"email\" class=\"form-label\">Email *</label>
                                    <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" 
                                           value=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "email", [], "any", false, false, false, 48), "html", null, true);
        yield "\" placeholder=\"usuario@ejemplo.com\" required>
                                    <div class=\"invalid-feedback\" id=\"email-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"password\" class=\"form-label\">Contraseña</label>
                                    <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" 
                                           placeholder=\"Dejar vacío para mantener la actual\">
                                    <small class=\"form-text text-muted\">Mínimo 6 caracteres si se desea cambiar</small>
                                    <div class=\"invalid-feedback\" id=\"password-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rol\" class=\"form-label\">Rol *</label>
                                    <select class=\"form-select\" id=\"rol\" name=\"rol\" required>
                                        <option value=\"\">Seleccione un rol</option>
                                        ";
        // line 69
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["roles"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 70
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rol", [], "any", false, false, false, 70) == $context["key"])) ? ("selected") : (""));
            yield ">
                                                ";
            // line 71
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                            </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        yield "                                    </select>
                                    <div class=\"invalid-feedback\" id=\"rol-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        ";
        // line 82
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["estados"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 83
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "estado", [], "any", false, false, false, 83) == $context["key"])) ? ("selected") : (""));
            yield ">
                                                ";
            // line 84
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                            </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 87
        yield "                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-12\">
                                <div class=\"d-flex justify-content-end gap-2\">
                                    <a href=\"";
        // line 95
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-times\"></i> Cancelar
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-save\"></i> Actualizar Usuario
                                    </button>
                                </div>
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

    // line 112
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 113
        yield "<script>
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Limpiar errores previos
    clearErrors();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch('";
        // line 123
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "id", [], "any", false, false, false, 123), "html", null, true);
        yield "', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Continuar'
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            if (data.errors) {
                showErrors(data.errors);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    });
});

function clearErrors() {
    const fields = ['rut', 'nombre', 'email', 'password', 'rol'];
    fields.forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        element.classList.remove('is-invalid');
        errorElement.textContent = '';
    });
}

function showErrors(errors) {
    Object.keys(errors).forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        if (element && errorElement) {
            element.classList.add('is-invalid');
            errorElement.textContent = errors[field];
        }
    });
}
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "usuarios/edit.twig";
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
        return array (  248 => 123,  236 => 113,  229 => 112,  208 => 95,  198 => 87,  189 => 84,  182 => 83,  178 => 82,  168 => 74,  159 => 71,  152 => 70,  148 => 69,  124 => 48,  110 => 37,  99 => 29,  83 => 16,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Editar Usuario{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">
                            <i class=\"fas fa-user-edit\"></i> Editar Usuario
                        </h3>
                        <div>
                            <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <form id=\"editUserForm\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rut\" class=\"form-label\">RUT *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" 
                                           value=\"{{ usuario.rut }}\" placeholder=\"12345678-9\" required>
                                    <div class=\"invalid-feedback\" id=\"rut-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"nombre\" class=\"form-label\">Nombre Completo *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                           value=\"{{ usuario.nombre }}\" placeholder=\"Juan Pérez\" required>
                                    <div class=\"invalid-feedback\" id=\"nombre-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"email\" class=\"form-label\">Email *</label>
                                    <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" 
                                           value=\"{{ usuario.email }}\" placeholder=\"usuario@ejemplo.com\" required>
                                    <div class=\"invalid-feedback\" id=\"email-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"password\" class=\"form-label\">Contraseña</label>
                                    <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" 
                                           placeholder=\"Dejar vacío para mantener la actual\">
                                    <small class=\"form-text text-muted\">Mínimo 6 caracteres si se desea cambiar</small>
                                    <div class=\"invalid-feedback\" id=\"password-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rol\" class=\"form-label\">Rol *</label>
                                    <select class=\"form-select\" id=\"rol\" name=\"rol\" required>
                                        <option value=\"\">Seleccione un rol</option>
                                        {% for key, value in roles %}
                                            <option value=\"{{ key }}\" {{ usuario.rol == key ? 'selected' : '' }}>
                                                {{ value }}
                                            </option>
                                        {% endfor %}
                                    </select>
                                    <div class=\"invalid-feedback\" id=\"rol-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        {% for key, value in estados %}
                                            <option value=\"{{ key }}\" {{ usuario.estado == key ? 'selected' : '' }}>
                                                {{ value }}
                                            </option>
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-12\">
                                <div class=\"d-flex justify-content-end gap-2\">
                                    <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-times\"></i> Cancelar
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-save\"></i> Actualizar Usuario
                                    </button>
                                </div>
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
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Limpiar errores previos
    clearErrors();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch('{{ app_url }}usuarios/{{ usuario.id }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Continuar'
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            if (data.errors) {
                showErrors(data.errors);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    });
});

function clearErrors() {
    const fields = ['rut', 'nombre', 'email', 'password', 'rol'];
    fields.forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        element.classList.remove('is-invalid');
        errorElement.textContent = '';
    });
}

function showErrors(errors) {
    Object.keys(errors).forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        if (element && errorElement) {
            element.classList.add('is-invalid');
            errorElement.textContent = errors[field];
        }
    });
}
</script>
{% endblock %} ", "usuarios/edit.twig", "/var/www/html/biblioges/templates/usuarios/edit.twig");
    }
}
