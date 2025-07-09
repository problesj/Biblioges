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
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Sedes</h3>
                        <a href=\"";
        // line 17
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
        // line 30
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 30) == "1")) ? ("selected") : (""));
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 31
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 31) == "0")) ? ("selected") : (""));
        yield ">Inactivo</option>
                                    </select>
                                </div>
                                <button type=\"submit\" class=\"btn btn-primary mr-2\">
                                    <i class=\"fas fa-filter\"></i> Filtrar
                                </button>
                                <a href=\"";
        // line 37
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
        // line 55
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["sedes"] ?? null)) > 0)) {
            // line 56
            yield "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 57
                yield "                                        <tr>
                                            <td style=\"text-align: center;\">";
                // line 58
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "codigo", [], "any", false, false, false, 58), "html", null, true);
                yield "</td>
                                            <td>";
                // line 59
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 59), "html", null, true);
                yield "</td>
                                            <td style=\"text-align: center;\">
                                                ";
                // line 61
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "estado", [], "any", false, false, false, 61) == "1")) {
                    // line 62
                    yield "                                                    <span class=\"badge bg-success\">Activo</span>
                                                ";
                } else {
                    // line 64
                    yield "                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                ";
                }
                // line 66
                yield "                                            </td>
                                            <td style=\"text-align: center;\">
                                                <a href=\"";
                // line 68
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "sedes/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 68), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-primary\">
                                                    <i class=\"fas fa-edit\"></i>
                                                </a>
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteSede(";
                // line 71
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 71), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 71), "html", null, true);
                yield "')\">
                                                    <i class=\"fas fa-trash\"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 77
            yield "                                ";
        } else {
            // line 78
            yield "                                    <tr>
                                        <td colspan=\"4\" class=\"text-center\">No hay sedes registradas</td>
                                    </tr>
                                ";
        }
        // line 82
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

    // line 92
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 93
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
        // line 109
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 109)) {
            // line 110
            yield "            Swal.fire({
                icon: '";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 111), "icon", [], "any", false, false, false, 111), "html", null, true);
            yield "',
                title: '";
            // line 112
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 112), "title", [], "any", false, false, false, 112);
            yield "',
                text: '";
            // line 113
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 113), "text", [], "any", false, false, false, 113);
            yield "',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('";
            // line 122
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
        // line 130
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
        // line 164
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
        return array (  318 => 164,  282 => 130,  271 => 122,  259 => 113,  255 => 112,  251 => 111,  248 => 110,  246 => 109,  228 => 93,  221 => 92,  208 => 82,  202 => 78,  199 => 77,  185 => 71,  177 => 68,  173 => 66,  169 => 64,  165 => 62,  163 => 61,  158 => 59,  154 => 58,  151 => 57,  146 => 56,  144 => 55,  123 => 37,  114 => 31,  110 => 30,  94 => 17,  85 => 10,  78 => 9,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
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
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteSede({{ sede.id }}, '{{ sede.nombre }}')\">
                                                    <i class=\"fas fa-trash\"></i>
                                                </button>
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
