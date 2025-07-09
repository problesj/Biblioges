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

/* usuarios/create.twig */
class __TwigTemplate_1b9f9799b943e488b07daa795eaa5cbc extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "usuarios/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Crear Usuario";
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
                            <i class=\"fas fa-user-plus\"></i> Crear Nuevo Usuario
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
                    <form id=\"createUserForm\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rut\" class=\"form-label\">RUT *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" 
                                           placeholder=\"12345678-9\" required>
                                    <div class=\"invalid-feedback\" id=\"rut-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"nombre\" class=\"form-label\">Nombre Completo *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                           placeholder=\"Juan Pérez\" required>
                                    <div class=\"invalid-feedback\" id=\"nombre-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"email\" class=\"form-label\">Email *</label>
                                    <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" 
                                           placeholder=\"usuario@ejemplo.com\" required>
                                    <div class=\"invalid-feedback\" id=\"email-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"password\" class=\"form-label\">Contraseña *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" 
                                           placeholder=\"Mínimo 6 caracteres\" required>
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
        // line 68
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["roles"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 69
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "</option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 71
        yield "                                    </select>
                                    <div class=\"invalid-feedback\" id=\"rol-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        ";
        // line 79
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["estados"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 80
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield ((($context["key"] == 1)) ? ("selected") : (""));
            yield ">
                                                ";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                            </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 84
        yield "                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-12\">
                                <div class=\"d-flex justify-content-end gap-2\">
                                    <a href=\"";
        // line 92
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-times\"></i> Cancelar
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-save\"></i> Guardar Usuario
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

    // line 109
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 110
        yield "<script>
function limpiarRut(rut) {
    return rut.replace(/\\.|-/g, '').toUpperCase();
}

document.getElementById('createUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Limpiar errores previos
    clearErrors();
    
    // Limpiar el RUT antes de enviar
    const rutInput = document.getElementById('rut');
    rutInput.value = limpiarRut(rutInput.value);

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch('";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios', {
        method: 'POST',
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
        return "usuarios/create.twig";
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
        return array (  241 => 128,  221 => 110,  214 => 109,  193 => 92,  183 => 84,  174 => 81,  167 => 80,  163 => 79,  153 => 71,  142 => 69,  138 => 68,  83 => 16,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Crear Usuario{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">
                            <i class=\"fas fa-user-plus\"></i> Crear Nuevo Usuario
                        </h3>
                        <div>
                            <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <form id=\"createUserForm\">
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"rut\" class=\"form-label\">RUT *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" 
                                           placeholder=\"12345678-9\" required>
                                    <div class=\"invalid-feedback\" id=\"rut-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"nombre\" class=\"form-label\">Nombre Completo *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                           placeholder=\"Juan Pérez\" required>
                                    <div class=\"invalid-feedback\" id=\"nombre-error\"></div>
                                </div>
                            </div>
                        </div>

                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"email\" class=\"form-label\">Email *</label>
                                    <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" 
                                           placeholder=\"usuario@ejemplo.com\" required>
                                    <div class=\"invalid-feedback\" id=\"email-error\"></div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"mb-3\">
                                    <label for=\"password\" class=\"form-label\">Contraseña *</label>
                                    <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" 
                                           placeholder=\"Mínimo 6 caracteres\" required>
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
                                            <option value=\"{{ key }}\">{{ value }}</option>
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
                                            <option value=\"{{ key }}\" {{ key == 1 ? 'selected' : '' }}>
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
                                        <i class=\"fas fa-save\"></i> Guardar Usuario
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
function limpiarRut(rut) {
    return rut.replace(/\\.|-/g, '').toUpperCase();
}

document.getElementById('createUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Limpiar errores previos
    clearErrors();
    
    // Limpiar el RUT antes de enviar
    const rutInput = document.getElementById('rut');
    rutInput.value = limpiarRut(rutInput.value);

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch('{{ app_url }}usuarios', {
        method: 'POST',
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
{% endblock %} ", "usuarios/create.twig", "/var/www/html/biblioges/templates/usuarios/create.twig");
    }
}
