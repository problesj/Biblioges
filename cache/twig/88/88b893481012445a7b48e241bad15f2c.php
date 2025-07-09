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

/* facultades/index.twig */
class __TwigTemplate_3248202af8dd365eca9df4203a17da14 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "facultades/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Facultades - Biblioges";
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
        justify-content: space-between;
        padding: 0.75rem 1.25rem;
    }
    .alert .close {
        padding: 0.5rem 1rem;
        margin-left: 1rem;
        line-height: 1;
        color: inherit;
        opacity: 0.5;
        background: transparent;
        border: 0;
        float: right;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert-content {
        flex: 1;
    }
</style>
";
        yield from [];
    }

    // line 33
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 34
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Facultades</h1>
        <a href=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Facultad
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" class=\"row\">
                <div class=\"col-md-6 mb-3\">
                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                    <select class=\"form-control\" id=\"sede_id\" name=\"sede_id\">
                        <option value=\"\">Todas las sedes</option>
                        ";
        // line 53
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 54
            yield "                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 54), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede_id", [], "any", false, false, false, 54) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 54))) {
                yield "selected";
            }
            yield ">
                            ";
            // line 55
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 55), "html", null, true);
            yield "
                        </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        yield "                    </select>
                </div>
                <div class=\"col-md-6 mb-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" ";
        // line 64
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 64) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 65
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 65) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                <div class=\"col-12\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-filter\"></i> Filtrar
                    </button>
                    <a href=\"";
        // line 72
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de facultades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Facultades</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered table-striped\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                    <thead class=\"thead-light\">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Sede</th>
                            <th style=\"text-align: center;\">Estado</th>
                            <th style=\"text-align: center;\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 98
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["facultades"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["facultad"]) {
            // line 99
            yield "                        <tr>
                            <td>";
            // line 100
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "codigo", [], "any", false, false, false, 100), "html", null, true);
            yield "</td>
                            <td>";
            // line 101
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 101), "html", null, true);
            yield "</td>
                            <td>";
            // line 102
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "sede_nombre", [], "any", true, true, false, 102) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "sede_nombre", [], "any", false, false, false, 102)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "sede_nombre", [], "any", false, false, false, 102), "html", null, true)) : ("Sin sede"));
            yield "</td>
                            <td style=\"text-align: center;\">
                                <span class=\"badge ";
            // line 104
            if (CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "estado", [], "any", false, false, false, 104)) {
                yield "bg-success";
            } else {
                yield "bg-danger";
            }
            yield "\">
                                    ";
            // line 105
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "estado", [], "any", false, false, false, 105)) ? ("Activo") : ("Inactivo"));
            yield "
                                </span>
                            </td>
                            <td style=\"text-align: center;\">
                                <div class=\"btn-group\">
                                    <a href=\"";
            // line 110
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "facultades/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 110), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                            onclick=\"confirmarEliminacion(";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 114), "html", null, true);
            yield ", '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 114), "html", null, true);
            yield "')\">
                                        <i class=\"fas fa-trash\"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 120
        if (!$context['_iterated']) {
            // line 121
            yield "                        <tr>
                            <td colspan=\"5\" class=\"text-center\">No se encontraron facultades</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['facultad'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 125
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminación -->
<form id=\"deleteForm\" method=\"POST\" style=\"display: none;\">
</form>
";
        yield from [];
    }

    // line 137
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 138
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#dataTable').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]], // Ordenar por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 4 } // Deshabilitar ordenamiento en columna de acciones
            ]
        });

        // Mostrar mensajes de sesión con SweetAlert2
        ";
        // line 157
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 157), "success", [], "any", false, false, false, 157)) {
            // line 158
            yield "            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '";
            // line 161
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 161), "success", [], "any", false, false, false, 161);
            yield "',
                timer: 3000,
                showConfirmButton: false
            });
        ";
        }
        // line 166
        yield "
        ";
        // line 167
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 167), "error", [], "any", false, false, false, 167)) {
            // line 168
            yield "            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '";
            // line 171
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "flash", [], "any", false, false, false, 171), "error", [], "any", false, false, false, 171);
            yield "',
                timer: 5000,
                showConfirmButton: false
            });
        ";
        }
        // line 176
        yield "    });

    function confirmarEliminacion(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea eliminar la facultad \"\${nombre}\"? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                const url = '";
        // line 191
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades/' + id + '/delete';
                console.log('ID de la facultad:', id);
                console.log('Nombre de la facultad:', nombre);
                console.log('app_url:', '";
        // line 194
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "');
                console.log('URL completa generada:', url);
                console.log('Datos del formulario:', new FormData(form));
                console.log('Método del formulario:', form.method);
                console.log('Action del formulario antes:', form.action);
                form.action = url;
                console.log('Action del formulario después:', form.action);
                form.submit();
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
        return "facultades/index.twig";
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
        return array (  379 => 194,  373 => 191,  356 => 176,  348 => 171,  343 => 168,  341 => 167,  338 => 166,  330 => 161,  325 => 158,  323 => 157,  302 => 138,  295 => 137,  280 => 125,  271 => 121,  269 => 120,  256 => 114,  247 => 110,  239 => 105,  231 => 104,  226 => 102,  222 => 101,  218 => 100,  215 => 99,  210 => 98,  181 => 72,  169 => 65,  163 => 64,  155 => 58,  146 => 55,  137 => 54,  133 => 53,  114 => 37,  109 => 34,  102 => 33,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Facultades - Biblioges{% endblock %}

{% block stylesheets %}
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
<style>
    .alert {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1.25rem;
    }
    .alert .close {
        padding: 0.5rem 1rem;
        margin-left: 1rem;
        line-height: 1;
        color: inherit;
        opacity: 0.5;
        background: transparent;
        border: 0;
        float: right;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert-content {
        flex: 1;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Facultades</h1>
        <a href=\"{{ app_url }}facultades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Facultad
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" class=\"row\">
                <div class=\"col-md-6 mb-3\">
                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                    <select class=\"form-control\" id=\"sede_id\" name=\"sede_id\">
                        <option value=\"\">Todas las sedes</option>
                        {% for sede in sedes %}
                        <option value=\"{{ sede.id }}\" {% if filtros.sede_id == sede.id %}selected{% endif %}>
                            {{ sede.nombre }}
                        </option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-6 mb-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-control\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                <div class=\"col-12\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-filter\"></i> Filtrar
                    </button>
                    <a href=\"{{ app_url }}facultades\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de facultades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Facultades</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered table-striped\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                    <thead class=\"thead-light\">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Sede</th>
                            <th style=\"text-align: center;\">Estado</th>
                            <th style=\"text-align: center;\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for facultad in facultades %}
                        <tr>
                            <td>{{ facultad.codigo }}</td>
                            <td>{{ facultad.nombre }}</td>
                            <td>{{ facultad.sede_nombre ?? 'Sin sede' }}</td>
                            <td style=\"text-align: center;\">
                                <span class=\"badge {% if facultad.estado %}bg-success{% else %}bg-danger{% endif %}\">
                                    {{ facultad.estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td style=\"text-align: center;\">
                                <div class=\"btn-group\">
                                    <a href=\"{{ app_url }}facultades/{{ facultad.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                            onclick=\"confirmarEliminacion({{ facultad.id }}, '{{ facultad.nombre }}')\">
                                        <i class=\"fas fa-trash\"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"5\" class=\"text-center\">No se encontraron facultades</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminación -->
<form id=\"deleteForm\" method=\"POST\" style=\"display: none;\">
</form>
{% endblock %}

{% block scripts %}
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#dataTable').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]], // Ordenar por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 4 } // Deshabilitar ordenamiento en columna de acciones
            ]
        });

        // Mostrar mensajes de sesión con SweetAlert2
        {% if session.flash.success %}
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session.flash.success|raw }}',
                timer: 3000,
                showConfirmButton: false
            });
        {% endif %}

        {% if session.flash.error %}
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session.flash.error|raw }}',
                timer: 5000,
                showConfirmButton: false
            });
        {% endif %}
    });

    function confirmarEliminacion(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea eliminar la facultad \"\${nombre}\"? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm');
                const url = '{{ app_url }}facultades/' + id + '/delete';
                console.log('ID de la facultad:', id);
                console.log('Nombre de la facultad:', nombre);
                console.log('app_url:', '{{ app_url }}');
                console.log('URL completa generada:', url);
                console.log('Datos del formulario:', new FormData(form));
                console.log('Método del formulario:', form.method);
                console.log('Action del formulario antes:', form.action);
                form.action = url;
                console.log('Action del formulario después:', form.action);
                form.submit();
            }
        });
    }
</script>
{% endblock %} ", "facultades/index.twig", "/var/www/html/biblioges/templates/facultades/index.twig");
    }
}
