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
";
        yield from [];
    }

    // line 9
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 10
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Sedes</h1>
        <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Sede
        </a>
    </div>

    ";
        // line 18
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 18)) {
            // line 19
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 21
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 21), "icon", [], "any", false, false, false, 21), "html", null, true);
            yield "',
            title: '";
            // line 22
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 22), "title", [], "any", false, false, false, 22);
            yield "',
            text: '";
            // line 23
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 23), "text", [], "any", false, false, false, 23);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 28
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 40
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 40) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 41
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 41) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de sedes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Sedes</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\" id=\"sedes-table\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 76
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 77
            yield "                                <tr>
                                    <td>";
            // line 78
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "codigo", [], "any", false, false, false, 78), "html", null, true);
            yield "</td>
                                    <td>";
            // line 79
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 79), "html", null, true);
            yield "</td>
                                    <td>
                                        ";
            // line 81
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "estado", [], "any", false, false, false, 81) == "1")) {
                // line 82
                yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
            } else {
                // line 84
                yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
            }
            // line 86
            yield "                                    </td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"";
            // line 89
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "sedes/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 89), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar Sede\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteSede(";
            // line 92
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 92), "html", null, true);
            yield ", '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 92), "html", null, true);
            yield "')\" title=\"Eliminar Sede\">
                                                <i class=\"fas fa-trash\"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 98
        if (!$context['_iterated']) {
            // line 99
            yield "                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay sedes registradas</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
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

    // line 113
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 114
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

        // Mostrar alertas de SweetAlert2 si existen en la sesión
        ";
        // line 130
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 130)) {
            // line 131
            yield "            Swal.fire({
                icon: '";
            // line 132
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 132), "icon", [], "any", false, false, false, 132), "html", null, true);
            yield "',
                title: '";
            // line 133
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 133), "title", [], "any", false, false, false, 133);
            yield "',
                text: '";
            // line 134
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 134), "text", [], "any", false, false, false, 134);
            yield "',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('";
            // line 143
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        ";
        }
        // line 151
        yield "    });

    // Función para confirmar eliminación con SweetAlert2
    function confirmDelete(message) {
        return Swal.fire({
            title: '¿Está seguro?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Función para eliminar sede
    function deleteSede(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la sede \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '";
        // line 185
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
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
        return array (  360 => 185,  324 => 151,  313 => 143,  301 => 134,  297 => 133,  293 => 132,  290 => 131,  288 => 130,  270 => 114,  263 => 113,  250 => 103,  241 => 99,  239 => 98,  226 => 92,  218 => 89,  213 => 86,  209 => 84,  205 => 82,  203 => 81,  198 => 79,  194 => 78,  191 => 77,  186 => 76,  157 => 50,  143 => 41,  137 => 40,  129 => 35,  120 => 28,  112 => 23,  108 => 22,  104 => 21,  100 => 19,  98 => 18,  90 => 13,  85 => 10,  78 => 9,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Sedes - Sistema de Bibliografía{% endblock %}

{% block stylesheets %}
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Sedes</h1>
        <a href=\"{{ app_url }}sedes/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Sede
        </a>
    </div>

    {% if session.swal %}
    <script>
        Swal.fire({
            icon: '{{ session.swal.icon }}',
            title: '{{ session.swal.title|raw }}',
            text: '{{ session.swal.text|raw }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}sedes\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}sedes\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de sedes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Sedes</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\" id=\"sedes-table\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for sede in sedes %}
                                <tr>
                                    <td>{{ sede.codigo }}</td>
                                    <td>{{ sede.nombre }}</td>
                                    <td>
                                        {% if sede.estado == '1' %}
                                            <span class=\"badge bg-success\">Activo</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"{{ app_url }}sedes/{{ sede.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar Sede\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteSede({{ sede.id }}, '{{ sede.nombre }}')\" title=\"Eliminar Sede\">
                                                <i class=\"fas fa-trash\"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay sedes registradas</td>
                                </tr>
                                {% endfor %}
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

        // Mostrar alertas de SweetAlert2 si existen en la sesión
        {% if session.swal %}
            Swal.fire({
                icon: '{{ session.swal.icon }}',
                title: '{{ session.swal.title|raw }}',
                text: '{{ session.swal.text|raw }}',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        {% endif %}
    });

    // Función para confirmar eliminación con SweetAlert2
    function confirmDelete(message) {
        return Swal.fire({
            title: '¿Está seguro?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Función para eliminar sede
    function deleteSede(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la sede \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ app_url }}sedes/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
{% endblock %} ", "sedes/index.twig", "/var/www/html/biblioges/templates/sedes/index.twig");
    }
}
