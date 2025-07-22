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

/* perfil.twig */
class __TwigTemplate_c0227c952b070c9f7d68b27483c705fd extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "perfil.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Mi Perfil";
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
    <div class=\"row justify-content-center\">
        <div class=\"col-lg-8\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"m-0 font-weight-bold text-primary\"><i class=\"fas fa-user\"></i> Mi Perfil</h5>
                </div>
                <div class=\"card-body\">
                    <!-- Alertas -->
                    <div id=\"alertasPerfil\"></div>

                    <form id=\"perfilForm\" autocomplete=\"off\">
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label for=\"rut\" class=\"form-label\">RUT</label>
                                <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" value=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rut", [], "any", false, false, false, 21), "html", null, true);
        yield "\" readonly>
                            </div>
                            <div class=\"col-md-6\">
                                <label for=\"email\" class=\"form-label\">Correo electrónico</label>
                                <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" value=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "email", [], "any", false, false, false, 25), "html", null, true);
        yield "\" required>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label for=\"nombre\" class=\"form-label\">Nombre</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "nombre", [], "any", false, false, false, 31), "html", null, true);
        yield "\" required>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label class=\"form-label\">Rol</label>
                                <div class=\"form-control-plaintext\">
                                    ";
        // line 38
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rol", [], "any", false, false, false, 38) == "admin")) {
            // line 39
            yield "                                        <span class=\"badge bg-primary\">Administrador</span>
                                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 40
($context["usuario"] ?? null), "rol", [], "any", false, false, false, 40) == "admin_bidoc")) {
            // line 41
            yield "                                        <span class=\"badge bg-info text-dark\">Administrador Biblioteca</span>
                                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 42
($context["usuario"] ?? null), "rol", [], "any", false, false, false, 42) == "usuario")) {
            // line 43
            yield "                                        <span class=\"badge bg-secondary\">Usuario</span>
                                    ";
        } else {
            // line 45
            yield "                                        <span class=\"badge bg-light text-dark\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rol", [], "any", false, false, false, 45)), "html", null, true);
            yield "</span>
                                    ";
        }
        // line 47
        yield "                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <label class=\"form-label\">Fecha de Creación</label>
                                        <div class=\"form-control-plaintext\">
                                            <i class=\"fas fa-calendar-plus text-muted\"></i> ";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "fecha_creacion", [], "any", false, false, false, 54), "d/m/Y H:i"), "html", null, true);
        yield "
                                        </div>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label class=\"form-label\">Última Actualización</label>
                                        <div class=\"form-control-plaintext\">
                                            <i class=\"fas fa-calendar-check text-muted\"></i> ";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "fecha_actualizacion", [], "any", false, false, false, 60), "d/m/Y H:i"), "html", null, true);
        yield "
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"d-flex justify-content-end\">
                            <button type=\"button\" class=\"btn btn-primary\" id=\"btnGuardarPerfil\">
                                <i class=\"fas fa-save\"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                    <hr>
                    <h5 class=\"mt-4 mb-3\"><i class=\"fas fa-key\"></i> Cambiar Contraseña</h5>
                    <form id=\"cambioPasswordForm\" autocomplete=\"off\">
                        <div class=\"row mb-3\">
                            <div class=\"col-md-4\">
                                <label for=\"password_actual\" class=\"form-label\">Contraseña Actual</label>
                                <input type=\"password\" class=\"form-control\" id=\"password_actual\" name=\"password_actual\" required>
                            </div>
                            <div class=\"col-md-4\">
                                <label for=\"nueva_password\" class=\"form-label\">Nueva Contraseña</label>
                                <input type=\"password\" class=\"form-control\" id=\"nueva_password\" name=\"nueva_password\" minlength=\"8\" required>
                            </div>
                            <div class=\"col-md-4\">
                                <label for=\"confirmar_password\" class=\"form-label\">Confirmar Nueva Contraseña</label>
                                <input type=\"password\" class=\"form-control\" id=\"confirmar_password\" name=\"confirmar_password\" minlength=\"8\" required>
                            </div>
                        </div>
                        <div class=\"d-flex justify-content-end\">
                            <button type=\"button\" class=\"btn btn-warning\" id=\"btnCambiarPassword\">
                                <i class=\"fas fa-key\"></i> Cambiar Contraseña
                            </button>
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

    // line 103
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 104
        yield "<script src=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "js/perfil.js?v=";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "U"), "html", null, true);
        yield "\"></script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "perfil.twig";
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
        return array (  208 => 104,  201 => 103,  154 => 60,  145 => 54,  136 => 47,  130 => 45,  126 => 43,  124 => 42,  121 => 41,  119 => 40,  116 => 39,  114 => 38,  104 => 31,  95 => 25,  88 => 21,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Mi Perfil{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row justify-content-center\">
        <div class=\"col-lg-8\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"m-0 font-weight-bold text-primary\"><i class=\"fas fa-user\"></i> Mi Perfil</h5>
                </div>
                <div class=\"card-body\">
                    <!-- Alertas -->
                    <div id=\"alertasPerfil\"></div>

                    <form id=\"perfilForm\" autocomplete=\"off\">
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label for=\"rut\" class=\"form-label\">RUT</label>
                                <input type=\"text\" class=\"form-control\" id=\"rut\" name=\"rut\" value=\"{{ usuario.rut }}\" readonly>
                            </div>
                            <div class=\"col-md-6\">
                                <label for=\"email\" class=\"form-label\">Correo electrónico</label>
                                <input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" value=\"{{ usuario.email }}\" required>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label for=\"nombre\" class=\"form-label\">Nombre</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ usuario.nombre }}\" required>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <label class=\"form-label\">Rol</label>
                                <div class=\"form-control-plaintext\">
                                    {% if usuario.rol == 'admin' %}
                                        <span class=\"badge bg-primary\">Administrador</span>
                                    {% elseif usuario.rol == 'admin_bidoc' %}
                                        <span class=\"badge bg-info text-dark\">Administrador Biblioteca</span>
                                    {% elseif usuario.rol == 'usuario' %}
                                        <span class=\"badge bg-secondary\">Usuario</span>
                                    {% else %}
                                        <span class=\"badge bg-light text-dark\">{{ usuario.rol|title }}</span>
                                    {% endif %}
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <label class=\"form-label\">Fecha de Creación</label>
                                        <div class=\"form-control-plaintext\">
                                            <i class=\"fas fa-calendar-plus text-muted\"></i> {{ usuario.fecha_creacion|date('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label class=\"form-label\">Última Actualización</label>
                                        <div class=\"form-control-plaintext\">
                                            <i class=\"fas fa-calendar-check text-muted\"></i> {{ usuario.fecha_actualizacion|date('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"d-flex justify-content-end\">
                            <button type=\"button\" class=\"btn btn-primary\" id=\"btnGuardarPerfil\">
                                <i class=\"fas fa-save\"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                    <hr>
                    <h5 class=\"mt-4 mb-3\"><i class=\"fas fa-key\"></i> Cambiar Contraseña</h5>
                    <form id=\"cambioPasswordForm\" autocomplete=\"off\">
                        <div class=\"row mb-3\">
                            <div class=\"col-md-4\">
                                <label for=\"password_actual\" class=\"form-label\">Contraseña Actual</label>
                                <input type=\"password\" class=\"form-control\" id=\"password_actual\" name=\"password_actual\" required>
                            </div>
                            <div class=\"col-md-4\">
                                <label for=\"nueva_password\" class=\"form-label\">Nueva Contraseña</label>
                                <input type=\"password\" class=\"form-control\" id=\"nueva_password\" name=\"nueva_password\" minlength=\"8\" required>
                            </div>
                            <div class=\"col-md-4\">
                                <label for=\"confirmar_password\" class=\"form-label\">Confirmar Nueva Contraseña</label>
                                <input type=\"password\" class=\"form-control\" id=\"confirmar_password\" name=\"confirmar_password\" minlength=\"8\" required>
                            </div>
                        </div>
                        <div class=\"d-flex justify-content-end\">
                            <button type=\"button\" class=\"btn btn-warning\" id=\"btnCambiarPassword\">
                                <i class=\"fas fa-key\"></i> Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src=\"{{ app_url }}js/perfil.js?v={{ \"now\"|date(\"U\") }}\"></script>
{% endblock %} ", "perfil.twig", "/var/www/html/biblioges/templates/perfil.twig");
    }
}
