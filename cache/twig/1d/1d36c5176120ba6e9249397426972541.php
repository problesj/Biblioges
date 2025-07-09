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

/* usuarios/show.twig */
class __TwigTemplate_a68a2f3896dd22bd2e0fbb4a82b92159 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "usuarios/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Ver Usuario";
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
                            <i class=\"fas fa-user\"></i> Información del Usuario
                        </h3>
                        <div>
                            <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                            <a href=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "id", [], "any", false, false, false, 19), "html", null, true);
        yield "/edit\" class=\"btn btn-warning\">
                                <i class=\"fas fa-edit\"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <table class=\"table table-borderless\">
                                <tr>
                                    <th width=\"30%\">RUT:</th>
                                    <td>";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rut", [], "any", false, false, false, 31), "html", null, true);
        yield "</td>
                                </tr>
                                <tr>
                                    <th>Nombre:</th>
                                    <td>";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "nombre", [], "any", false, false, false, 35), "html", null, true);
        yield "</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "email", [], "any", false, false, false, 39), "html", null, true);
        yield "</td>
                                </tr>
                            </table>
                        </div>
                        <div class=\"col-md-6\">
                            <table class=\"table table-borderless\">
                                <tr>
                                    <th width=\"30%\">Rol:</th>
                                    <td>
                                        <span class=\"badge bg-info\">";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["roles"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rol", [], "any", false, false, false, 48)] ?? null) : null), "html", null, true);
        yield "</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        ";
        // line 54
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "estado", [], "any", false, false, false, 54)) {
            // line 55
            yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
        } else {
            // line 57
            yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
        }
        // line 59
        yield "                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha Creación:</th>
                                    <td>";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "fecha_creacion", [], "any", false, false, false, 63), "d/m/Y H:i:s"), "html", null, true);
        yield "</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "fecha_actualizacion", [], "any", false, false, false, 67), "d/m/Y H:i:s"), "html", null, true);
        yield "</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5>Permisos del Rol</h5>
                            <div class=\"alert alert-info\">
                                ";
        // line 77
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["usuario"] ?? null), "rol", [], "any", false, false, false, 77) == "admin")) {
            // line 78
            yield "                                    <strong>Administrador:</strong> Puede realizar todas las funciones del sistema.
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 79
($context["usuario"] ?? null), "rol", [], "any", false, false, false, 79) == "admin_bidoc")) {
            // line 80
            yield "                                    <strong>Administrador Biblioteca:</strong> Puede ver los módulos de:
                                    <ul class=\"mb-0 mt-2\">
                                        <li>Principal</li>
                                        <li>Bibliografía Declarada</li>
                                        <li>Bibliografía Disponible</li>
                                        <li>Reportes (Cobertura, Listado de bibliografías)</li>
                                        <li>Admin</li>
                                        <li>Autores</li>
                                    </ul>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 89
($context["usuario"] ?? null), "rol", [], "any", false, false, false, 89) == "usuario")) {
            // line 90
            yield "                                    <strong>Usuario:</strong> Solo puede ver:
                                    <ul class=\"mb-0 mt-2\">
                                        <li>Reportes</li>
                                        <li>Cobertura</li>
                                        <li>Listado de bibliografías</li>
                                    </ul>
                                ";
        }
        // line 97
        yield "                            </div>
                        </div>
                    </div>
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
        return "usuarios/show.twig";
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
        return array (  205 => 97,  196 => 90,  194 => 89,  183 => 80,  181 => 79,  178 => 78,  176 => 77,  163 => 67,  156 => 63,  150 => 59,  146 => 57,  142 => 55,  140 => 54,  131 => 48,  119 => 39,  112 => 35,  105 => 31,  88 => 19,  82 => 16,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Ver Usuario{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">
                            <i class=\"fas fa-user\"></i> Información del Usuario
                        </h3>
                        <div>
                            <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                            <a href=\"{{ app_url }}usuarios/{{ usuario.id }}/edit\" class=\"btn btn-warning\">
                                <i class=\"fas fa-edit\"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <table class=\"table table-borderless\">
                                <tr>
                                    <th width=\"30%\">RUT:</th>
                                    <td>{{ usuario.rut }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre:</th>
                                    <td>{{ usuario.nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ usuario.email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class=\"col-md-6\">
                            <table class=\"table table-borderless\">
                                <tr>
                                    <th width=\"30%\">Rol:</th>
                                    <td>
                                        <span class=\"badge bg-info\">{{ roles[usuario.rol] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        {% if usuario.estado %}
                                            <span class=\"badge bg-success\">Activo</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        {% endif %}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha Creación:</th>
                                    <td>{{ usuario.fecha_creacion|date('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>{{ usuario.fecha_actualizacion|date('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5>Permisos del Rol</h5>
                            <div class=\"alert alert-info\">
                                {% if usuario.rol == 'admin' %}
                                    <strong>Administrador:</strong> Puede realizar todas las funciones del sistema.
                                {% elseif usuario.rol == 'admin_bidoc' %}
                                    <strong>Administrador Biblioteca:</strong> Puede ver los módulos de:
                                    <ul class=\"mb-0 mt-2\">
                                        <li>Principal</li>
                                        <li>Bibliografía Declarada</li>
                                        <li>Bibliografía Disponible</li>
                                        <li>Reportes (Cobertura, Listado de bibliografías)</li>
                                        <li>Admin</li>
                                        <li>Autores</li>
                                    </ul>
                                {% elseif usuario.rol == 'usuario' %}
                                    <strong>Usuario:</strong> Solo puede ver:
                                    <ul class=\"mb-0 mt-2\">
                                        <li>Reportes</li>
                                        <li>Cobertura</li>
                                        <li>Listado de bibliografías</li>
                                    </ul>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "usuarios/show.twig", "/var/www/html/biblioges/templates/usuarios/show.twig");
    }
}
