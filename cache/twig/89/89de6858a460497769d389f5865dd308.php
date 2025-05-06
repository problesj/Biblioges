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

/* departamentos/index.twig */
class __TwigTemplate_ff902130f1f423d9019728f243b64a8f extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "departamentos/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Departamentos - Sistema de Bibliografía";
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
    /* Estilos para los filtros */
    .filtros-container {
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px 0;
        float: left
    }
    .filtros-container .form-group {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        margin-bottom: 0;
        flex-shrink: 0;
    }
    .filtros-container .form-group:last-child {
        margin-right: 0;
    }
    .filtros-container label {
        margin-right: 5px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .filtros-container select {
        min-width: 150px;
    }
    .filtros-container .btn {
        white-space: nowrap;
    }
</style>
";
        yield from [];
    }

    // line 80
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 81
        yield "<div class=\"container-fluid\">
    <!-- Mensajes de alerta -->
    ";
        // line 83
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["error"] ?? null))) {
            // line 84
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-exclamation-circle me-2\"></i>
        ";
            // line 86
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
            // line 89
            yield $this->env->getFunction('clean_error_message')->getCallable()();
            yield "
    ";
        }
        // line 91
        yield "
    ";
        // line 92
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["success"] ?? null))) {
            // line 93
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        <i class=\"fas fa-check-circle me-2\"></i>
        ";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
            // line 98
            yield $this->env->getFunction('clean_error_message')->getCallable()();
            yield "
    ";
        }
        // line 100
        yield "
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Departamentos</h3>
                        <a href=\"";
        // line 107
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nuevo Departamento
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card shadow mb-4\">
                        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"GET\" action=\"";
        // line 119
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                                    <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\">
                                        <option value=\"\">Todas las sedes</option>
                                        ";
        // line 124
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 125
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 125), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede_id", [], "any", false, false, false, 125) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 125))) {
                yield "selected";
            }
            yield ">
                                            ";
            // line 126
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 126), "html", null, true);
            yield "
                                        </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 129
        yield "                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"facultad_id\" class=\"form-label\">Facultad</label>
                                    <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\">
                                        <option value=\"\">Todas las facultades</option>
                                        ";
        // line 135
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["facultades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["facultad"]) {
            // line 136
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 136), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "facultad_id", [], "any", false, false, false, 136) == CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 136))) {
                yield "selected";
            }
            yield ">
                                            ";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 137), "html", null, true);
            yield "
                                        </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['facultad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 140
        yield "                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" ";
        // line 146
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 146) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 147
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 147) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-filter\"></i> Filtrar
                                    </button>
                                    <a href=\"";
        // line 154
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-broom\"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de departamentos -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"departamentos-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th>Facultad</th>
                                    <th>Sede</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 176
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["departamentos"] ?? null)) > 0)) {
            // line 177
            yield "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
                // line 178
                yield "                                        <tr>
                                            <td style=\"text-align: center;\">";
                // line 179
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "codigo", [], "any", false, false, false, 179), "html", null, true);
                yield "</td>
                                            <td>";
                // line 180
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "nombre", [], "any", false, false, false, 180), "html", null, true);
                yield "</td>
                                            <td>";
                // line 181
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 181), "html", null, true);
                yield "</td>
                                            <td>";
                // line 182
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 182), "html", null, true);
                yield "</td>
                                            <td style=\"text-align: center;\">
                                                ";
                // line 184
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "estado", [], "any", false, false, false, 184) == "1")) {
                    // line 185
                    yield "                                                    <span class=\"badge bg-success\">Activo</span>
                                                ";
                } else {
                    // line 187
                    yield "                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                ";
                }
                // line 189
                yield "                                            </td>
                                            <td style=\"text-align: center;\">
                                                <a href=\"";
                // line 191
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "departamentos/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 191), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-primary\">
                                                    <i class=\"fas fa-edit\"></i>
                                                </a>
                                                <form action=\"";
                // line 194
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "departamentos/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 194), "html", null, true);
                yield "\" method=\"post\" class=\"d-inline\" onsubmit=\"return confirm('¿Está seguro de eliminar este departamento?');\">
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
            unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 203
            yield "                                ";
        } else {
            // line 204
            yield "                                    <tr>
                                        <td colspan=\"6\" class=\"text-center\">No hay departamentos registrados</td>
                                    </tr>
                                ";
        }
        // line 208
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

    // line 218
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 219
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#departamentos-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"], [2, \"asc\"]], // Ordenar por facultad y luego por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 4 } // Deshabilitar ordenamiento en columna de acciones
            ]
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
        return "departamentos/index.twig";
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
        return array (  427 => 219,  420 => 218,  407 => 208,  401 => 204,  398 => 203,  381 => 194,  373 => 191,  369 => 189,  365 => 187,  361 => 185,  359 => 184,  354 => 182,  350 => 181,  346 => 180,  342 => 179,  339 => 178,  334 => 177,  332 => 176,  307 => 154,  295 => 147,  289 => 146,  281 => 140,  272 => 137,  263 => 136,  259 => 135,  251 => 129,  242 => 126,  233 => 125,  229 => 124,  221 => 119,  206 => 107,  197 => 100,  192 => 98,  186 => 95,  182 => 93,  180 => 92,  177 => 91,  172 => 89,  166 => 86,  162 => 84,  160 => 83,  156 => 81,  149 => 80,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Departamentos - Sistema de Bibliografía{% endblock %}

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
    /* Estilos para los filtros */
    .filtros-container {
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px 0;
        float: left
    }
    .filtros-container .form-group {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        margin-bottom: 0;
        flex-shrink: 0;
    }
    .filtros-container .form-group:last-child {
        margin-right: 0;
    }
    .filtros-container label {
        margin-right: 5px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .filtros-container select {
        min-width: 150px;
    }
    .filtros-container .btn {
        white-space: nowrap;
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
                        <h3 class=\"card-title\">Listado de Departamentos</h3>
                        <a href=\"{{ app_url }}departamentos/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nuevo Departamento
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card shadow mb-4\">
                        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"GET\" action=\"{{ app_url }}departamentos\" class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                                    <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\">
                                        <option value=\"\">Todas las sedes</option>
                                        {% for sede in sedes %}
                                        <option value=\"{{ sede.id }}\" {% if filtros.sede_id == sede.id %}selected{% endif %}>
                                            {{ sede.nombre }}
                                        </option>
                                        {% endfor %}
                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"facultad_id\" class=\"form-label\">Facultad</label>
                                    <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\">
                                        <option value=\"\">Todas las facultades</option>
                                        {% for facultad in facultades %}
                                        <option value=\"{{ facultad.id }}\" {% if filtros.facultad_id == facultad.id %}selected{% endif %}>
                                            {{ facultad.nombre }}
                                        </option>
                                        {% endfor %}
                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-filter\"></i> Filtrar
                                    </button>
                                    <a href=\"{{ app_url }}departamentos\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-broom\"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de departamentos -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"departamentos-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th>Facultad</th>
                                    <th>Sede</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if departamentos|length > 0 %}
                                    {% for departamento in departamentos %}
                                        <tr>
                                            <td style=\"text-align: center;\">{{ departamento.codigo }}</td>
                                            <td>{{ departamento.nombre }}</td>
                                            <td>{{ departamento.facultad_nombre }}</td>
                                            <td>{{ departamento.sede_nombre }}</td>
                                            <td style=\"text-align: center;\">
                                                {% if departamento.estado == '1' %}
                                                    <span class=\"badge bg-success\">Activo</span>
                                                {% else %}
                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                {% endif %}
                                            </td>
                                            <td style=\"text-align: center;\">
                                                <a href=\"{{ app_url }}departamentos/{{ departamento.id }}/edit\" class=\"btn btn-sm btn-primary\">
                                                    <i class=\"fas fa-edit\"></i>
                                                </a>
                                                <form action=\"{{ app_url }}departamentos/{{ departamento.id }}\" method=\"post\" class=\"d-inline\" onsubmit=\"return confirm('¿Está seguro de eliminar este departamento?');\">
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
                                        <td colspan=\"6\" class=\"text-center\">No hay departamentos registrados</td>
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
        \$('#departamentos-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"], [2, \"asc\"]], // Ordenar por facultad y luego por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 4 } // Deshabilitar ordenamiento en columna de acciones
            ]
        });

        // Cerrar alertas automáticamente después de 5 segundos
        \$('.alert').delay(5000).fadeOut(500);
    });
</script>
{% endblock %} ", "departamentos/index.twig", "/var/www/html/biblioges/templates/departamentos/index.twig");
    }
}
