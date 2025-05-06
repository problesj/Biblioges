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

/* sedes/index.twig */
class __TwigTemplate_059be6476ad0e5d3597f9a76ee60846d extends Template
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
            'stylesheets' => [$this, 'block_stylesheets'],
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
        $this->parent = $this->loadTemplate("base.twig", "sedes/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Sedes - Sistema de Bibliografía";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
<style>
    .alert {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    .alert-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    .alert-content i {
        margin-right: 0.5rem;
    }
    .alert-actions {
        display: flex;
        align-items: center;
    }
    .alert .close {
        padding: 0;
        margin-left: 1rem;
        color: inherit;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        line-height: 1;
        font-weight: bold;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert .close:focus {
        outline: none;
    }
</style>
";
        yield from [];
    }

    // line 48
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 49
        yield "<div class=\"container-fluid\">
    <!-- Mensajes de alerta -->
    ";
        // line 51
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["error"] ?? null))) {
            // line 52
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-exclamation-circle me-2\"></i>
        ";
            // line 54
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
            // line 57
            yield $this->env->getFunction('clean_error_message')->getCallable()();
            yield "
    ";
        }
        // line 59
        yield "
    ";
        // line 60
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["success"] ?? null))) {
            // line 61
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-check-circle me-2\"></i>
        ";
            // line 63
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
            // line 66
            yield $this->env->getFunction('clean_error_message')->getCallable()();
            yield "
    ";
        }
        // line 68
        yield "
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Sedes</h3>
                        <a href=\"";
        // line 75
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nueva Sede
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row mb-3\">
                        <div class=\"col-md-12\">
                            <form method=\"get\" class=\"form-inline\">
                                <div class=\"form-group mr-2\">
                                    <label for=\"estado\" class=\"mr-2\">Estado:</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" ";
        // line 88
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 88) == "1")) ? ("selected") : (""));
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 89
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 89) == "0")) ? ("selected") : (""));
        yield ">Inactivo</option>
                                    </select>
                                </div>
                                <button type=\"submit\" class=\"btn btn-primary mr-2\">
                                    <i class=\"fas fa-filter\"></i> Filtrar
                                </button>
                                <a href=\"";
        // line 95
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"btn btn-secondary\">
                                    <i class=\"fas fa-times\"></i> Limpiar
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"sedes-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 113
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["sedes"] ?? null)) > 0)) {
            // line 114
            yield "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 115
                yield "                                        <tr>
                                            <td style=\"text-align: center;\">";
                // line 116
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "codigo", [], "any", false, false, false, 116), "html", null, true);
                yield "</td>
                                            <td>";
                // line 117
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 117), "html", null, true);
                yield "</td>
                                            <td style=\"text-align: center;\">
                                                ";
                // line 119
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "estado", [], "any", false, false, false, 119) == "1")) {
                    // line 120
                    yield "                                                    <span class=\"badge bg-success\">Activo</span>
                                                ";
                } else {
                    // line 122
                    yield "                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                ";
                }
                // line 124
                yield "                                            </td>
                                            <td style=\"text-align: center;\">
                                                <a href=\"";
                // line 126
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "sedes/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 126), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-primary\">
                                                    <i class=\"fas fa-edit\"></i>
                                                </a>
                                                <form action=\"";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "sedes/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 129), "html", null, true);
                yield "\" method=\"post\" class=\"d-inline\" onsubmit=\"return confirm('¿Está seguro de eliminar esta sede?');\">
                                                    <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                                    <button type=\"submit\" class=\"btn btn-sm btn-danger\">
                                                        <i class=\"fas fa-trash\"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 138
            yield "                                ";
        } else {
            // line 139
            yield "                                    <tr>
                                        <td colspan=\"4\" class=\"text-center\">No hay sedes registradas</td>
                                    </tr>
                                ";
        }
        // line 143
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 153
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 154
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#sedes-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]],
            \"pageLength\": 10
        });

        // Cerrar alertas automáticamente después de 5 segundos
        \$('.alert').delay(5000).fadeOut(500);
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
        return "sedes/index.twig";
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
        return array (  311 => 154,  304 => 153,  291 => 143,  285 => 139,  282 => 138,  265 => 129,  257 => 126,  253 => 124,  249 => 122,  245 => 120,  243 => 119,  238 => 117,  234 => 116,  231 => 115,  226 => 114,  224 => 113,  203 => 95,  194 => 89,  190 => 88,  174 => 75,  165 => 68,  160 => 66,  154 => 63,  150 => 61,  148 => 60,  145 => 59,  140 => 57,  134 => 54,  130 => 52,  128 => 51,  124 => 49,  117 => 48,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Sedes - Sistema de Bibliografía{% endblock %}

{% block stylesheets %}
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
<style>
    .alert {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    .alert-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    .alert-content i {
        margin-right: 0.5rem;
    }
    .alert-actions {
        display: flex;
        align-items: center;
    }
    .alert .close {
        padding: 0;
        margin-left: 1rem;
        color: inherit;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        line-height: 1;
        font-weight: bold;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert .close:focus {
        outline: none;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <!-- Mensajes de alerta -->
    {% if error is not empty %}
    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-exclamation-circle me-2\"></i>
        {{ error }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {{ clean_error_message()|raw }}
    {% endif %}

    {% if success is not empty %}
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-check-circle me-2\"></i>
        {{ success }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {{ clean_error_message()|raw }}
    {% endif %}

    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Sedes</h3>
                        <a href=\"{{ app_url }}sedes/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nueva Sede
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row mb-3\">
                        <div class=\"col-md-12\">
                            <form method=\"get\" class=\"form-inline\">
                                <div class=\"form-group mr-2\">
                                    <label for=\"estado\" class=\"mr-2\">Estado:</label>
                                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" {{ filtros.estado == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value=\"0\" {{ filtros.estado == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                                <button type=\"submit\" class=\"btn btn-primary mr-2\">
                                    <i class=\"fas fa-filter\"></i> Filtrar
                                </button>
                                <a href=\"{{ app_url }}sedes\" class=\"btn btn-secondary\">
                                    <i class=\"fas fa-times\"></i> Limpiar
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"sedes-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if sedes|length > 0 %}
                                    {% for sede in sedes %}
                                        <tr>
                                            <td style=\"text-align: center;\">{{ sede.codigo }}</td>
                                            <td>{{ sede.nombre }}</td>
                                            <td style=\"text-align: center;\">
                                                {% if sede.estado == '1' %}
                                                    <span class=\"badge bg-success\">Activo</span>
                                                {% else %}
                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                {% endif %}
                                            </td>
                                            <td style=\"text-align: center;\">
                                                <a href=\"{{ app_url }}sedes/{{ sede.id }}/edit\" class=\"btn btn-sm btn-primary\">
                                                    <i class=\"fas fa-edit\"></i>
                                                </a>
                                                <form action=\"{{ app_url }}sedes/{{ sede.id }}\" method=\"post\" class=\"d-inline\" onsubmit=\"return confirm('¿Está seguro de eliminar esta sede?');\">
                                                    <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                                                    <button type=\"submit\" class=\"btn btn-sm btn-danger\">
                                                        <i class=\"fas fa-trash\"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                {% else %}
                                    <tr>
                                        <td colspan=\"4\" class=\"text-center\">No hay sedes registradas</td>
                                    </tr>
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#sedes-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]],
            \"pageLength\": 10
        });

        // Cerrar alertas automáticamente después de 5 segundos
        \$('.alert').delay(5000).fadeOut(500);
    });
</script>
{% endblock %} ", "sedes/index.twig", "/var/www/html/biblioges/templates/sedes/index.twig");
    }
}
