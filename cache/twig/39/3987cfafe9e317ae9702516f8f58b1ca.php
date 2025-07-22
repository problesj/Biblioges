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

/* usuarios/index.twig */
class __TwigTemplate_648c3a5d6657051a98a6c3379593bc6a extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "usuarios/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Gestión de Usuarios";
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
                            <i class=\"fas fa-users\"></i> Gestión de Usuarios
                        </h3>
                        <div>
                            <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/create\" class=\"btn btn-primary\">
                                <i class=\"fas fa-plus\"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"card-title mb-0\">Filtros</h5>
                        </div>
                        <div class=\"card-body\">
                            <form id=\"filtrosForm\" method=\"GET\">
                                <div class=\"row g-3\">
                                    <div class=\"col-md-4\">
                                        <label for=\"search\" class=\"form-label\">Buscar</label>
                                        <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                               placeholder=\"Nombre, email o RUT\" value=\"";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "search", [], "any", false, false, false, 34), "html", null, true);
        yield "\">
                                    </div>
                                    <div class=\"col-md-3\">
                                        <label for=\"rol\" class=\"form-label\">Rol</label>
                                        <select class=\"form-select\" id=\"rol\" name=\"rol\">
                                            <option value=\"\">Todos los roles</option>
                                            ";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["roles"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 41
            yield "                                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "rol", [], "any", false, false, false, 41) == $context["key"])) ? ("selected") : (""));
            yield ">
                                                    ";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                                </option>
                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        yield "                                        </select>
                                    </div>
                                    <div class=\"col-md-3\">
                                        <label for=\"estado\" class=\"form-label\">Estado</label>
                                        <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                            <option value=\"\">Todos los estados</option>
                                            ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["estados"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 52
            yield "                                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "estado", [], "any", false, false, false, 52) == $context["key"])) ? ("selected") : (""));
            yield ">
                                                    ";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                                </option>
                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 56
        yield "                                        </select>
                                    </div>
                                </div>
                                <div class=\"row mt-3\">
                                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                                        <button type=\"submit\" class=\"btn btn-primary\">
                                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                                        </button>
                                        <a href=\"";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de usuarios -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-striped table-bordered\">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 88
        if (($context["usuarios"] ?? null)) {
            // line 89
            yield "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["usuarios"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["usuario"]) {
                // line 90
                yield "                                        <tr>
                                            <td>";
                // line 91
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "rut", [], "any", false, false, false, 91), "html", null, true);
                yield "</td>
                                            <td>";
                // line 92
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "nombre", [], "any", false, false, false, 92), "html", null, true);
                yield "</td>
                                            <td>";
                // line 93
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "email", [], "any", false, false, false, 93), "html", null, true);
                yield "</td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 95
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["roles"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "rol", [], "any", false, false, false, 95)] ?? null) : null), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>
                                                ";
                // line 98
                if (CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 98)) {
                    // line 99
                    yield "                                                    <span class=\"badge bg-success\">Activo</span>
                                                ";
                } else {
                    // line 101
                    yield "                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                ";
                }
                // line 103
                yield "                                            </td>
                                            <td>";
                // line 104
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "fecha_creacion", [], "any", false, false, false, 104), "d/m/Y H:i"), "html", null, true);
                yield "</td>
                                            <td>
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 107
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "usuarios/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 107), "html", null, true);
                yield "\" 
                                                       class=\"btn btn-sm btn-info\" title=\"Ver\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 111
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "usuarios/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 111), "html", null, true);
                yield "/edit\" 
                                                       class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                    ";
                // line 115
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 115) != CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 115))) {
                    // line 116
                    yield "                                                        <button type=\"button\" 
                                                                class=\"btn btn-sm ";
                    // line 117
                    yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 117)) ? ("btn-danger") : ("btn-success"));
                    yield "\"
                                                                onclick=\"cambiarEstado(";
                    // line 118
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 118), "html", null, true);
                    yield ", ";
                    yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 118)) ? (0) : (1));
                    yield ")\"
                                                                title=\"";
                    // line 119
                    yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 119)) ? ("Desactivar") : ("Activar"));
                    yield "\">
                                                            <i class=\"fas fa-";
                    // line 120
                    yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 120)) ? ("times") : ("check"));
                    yield "\"></i>
                                                        </button>
                                                        <button type=\"button\" 
                                                                class=\"btn btn-sm btn-danger\"
                                                                onclick=\"eliminarUsuario(";
                    // line 124
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 124), "html", null, true);
                    yield ")\"
                                                                title=\"Eliminar\">
                                                            <i class=\"fas fa-trash\"></i>
                                                        </button>
                                                    ";
                }
                // line 129
                yield "                                                </div>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['usuario'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 133
            yield "                                ";
        } else {
            // line 134
            yield "                                    <tr>
                                        <td colspan=\"7\" class=\"text-center\">No se encontraron usuarios</td>
                                    </tr>
                                ";
        }
        // line 138
        yield "                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    ";
        // line 143
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 143) > 1)) {
            // line 144
            yield "                        <nav aria-label=\"Paginación de usuarios\">
                            <ul class=\"pagination justify-content-center\">
                                ";
            // line 146
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current_page", [], "any", false, false, false, 146) > 1)) {
                // line 147
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"?page=";
                // line 148
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current_page", [], "any", false, false, false, 148) - 1), "html", null, true);
                yield "&search=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "search", [], "any", false, false, false, 148), "html", null, true);
                yield "&rol=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "rol", [], "any", false, false, false, 148), "html", null, true);
                yield "&estado=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "estado", [], "any", false, false, false, 148), "html", null, true);
                yield "\">
                                            Anterior
                                        </a>
                                    </li>
                                ";
            }
            // line 153
            yield "                                
                                ";
            // line 154
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(1, CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 154)));
            foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
                // line 155
                yield "                                    <li class=\"page-item ";
                yield ((($context["page"] == CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current_page", [], "any", false, false, false, 155))) ? ("active") : (""));
                yield "\">
                                        <a class=\"page-link\" href=\"?page=";
                // line 156
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
                yield "&search=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "search", [], "any", false, false, false, 156), "html", null, true);
                yield "&rol=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "rol", [], "any", false, false, false, 156), "html", null, true);
                yield "&estado=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "estado", [], "any", false, false, false, 156), "html", null, true);
                yield "\">
                                            ";
                // line 157
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
                yield "
                                        </a>
                                    </li>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 161
            yield "                                
                                ";
            // line 162
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current_page", [], "any", false, false, false, 162) < CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 162))) {
                // line 163
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"?page=";
                // line 164
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current_page", [], "any", false, false, false, 164) + 1), "html", null, true);
                yield "&search=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "search", [], "any", false, false, false, 164), "html", null, true);
                yield "&rol=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "rol", [], "any", false, false, false, 164), "html", null, true);
                yield "&estado=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "estado", [], "any", false, false, false, 164), "html", null, true);
                yield "\">
                                            Siguiente
                                        </a>
                                    </li>
                                ";
            }
            // line 169
            yield "                            </ul>
                        </nav>
                    ";
        }
        // line 172
        yield "                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 179
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 180
        yield "<script>
function cambiarEstado(userId, nuevoEstado) {
    const accion = nuevoEstado ? 'activar' : 'desactivar';
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas \${accion} este usuario?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`";
        // line 195
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/\${userId}/change-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    estado: nuevoEstado
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Éxito!',
                        data.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Ocurrió un error al procesar la solicitud',
                    'error'
                );
            });
        }
    });
}

function eliminarUsuario(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: \"Esta acción no se puede deshacer\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`";
        // line 246
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/\${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        data.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Ocurrió un error al procesar la solicitud',
                    'error'
                );
            });
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
        return "usuarios/index.twig";
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
        return array (  495 => 246,  441 => 195,  424 => 180,  417 => 179,  407 => 172,  402 => 169,  388 => 164,  385 => 163,  383 => 162,  380 => 161,  370 => 157,  360 => 156,  355 => 155,  351 => 154,  348 => 153,  334 => 148,  331 => 147,  329 => 146,  325 => 144,  323 => 143,  316 => 138,  310 => 134,  307 => 133,  298 => 129,  290 => 124,  283 => 120,  279 => 119,  273 => 118,  269 => 117,  266 => 116,  264 => 115,  255 => 111,  246 => 107,  240 => 104,  237 => 103,  233 => 101,  229 => 99,  227 => 98,  221 => 95,  216 => 93,  212 => 92,  208 => 91,  205 => 90,  200 => 89,  198 => 88,  171 => 64,  161 => 56,  152 => 53,  145 => 52,  141 => 51,  133 => 45,  124 => 42,  117 => 41,  113 => 40,  104 => 34,  83 => 16,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Gestión de Usuarios{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">
                            <i class=\"fas fa-users\"></i> Gestión de Usuarios
                        </h3>
                        <div>
                            <a href=\"{{ app_url }}usuarios/create\" class=\"btn btn-primary\">
                                <i class=\"fas fa-plus\"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"card-title mb-0\">Filtros</h5>
                        </div>
                        <div class=\"card-body\">
                            <form id=\"filtrosForm\" method=\"GET\">
                                <div class=\"row g-3\">
                                    <div class=\"col-md-4\">
                                        <label for=\"search\" class=\"form-label\">Buscar</label>
                                        <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                               placeholder=\"Nombre, email o RUT\" value=\"{{ filters.search }}\">
                                    </div>
                                    <div class=\"col-md-3\">
                                        <label for=\"rol\" class=\"form-label\">Rol</label>
                                        <select class=\"form-select\" id=\"rol\" name=\"rol\">
                                            <option value=\"\">Todos los roles</option>
                                            {% for key, value in roles %}
                                                <option value=\"{{ key }}\" {{ filters.rol == key ? 'selected' : '' }}>
                                                    {{ value }}
                                                </option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                    <div class=\"col-md-3\">
                                        <label for=\"estado\" class=\"form-label\">Estado</label>
                                        <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                            <option value=\"\">Todos los estados</option>
                                            {% for key, value in estados %}
                                                <option value=\"{{ key }}\" {{ filters.estado == key ? 'selected' : '' }}>
                                                    {{ value }}
                                                </option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class=\"row mt-3\">
                                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                                        <button type=\"submit\" class=\"btn btn-primary\">
                                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                                        </button>
                                        <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de usuarios -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-striped table-bordered\">
                            <thead>
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if usuarios %}
                                    {% for usuario in usuarios %}
                                        <tr>
                                            <td>{{ usuario.rut }}</td>
                                            <td>{{ usuario.nombre }}</td>
                                            <td>{{ usuario.email }}</td>
                                            <td>
                                                <span class=\"badge bg-info\">{{ roles[usuario.rol] }}</span>
                                            </td>
                                            <td>
                                                {% if usuario.estado %}
                                                    <span class=\"badge bg-success\">Activo</span>
                                                {% else %}
                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                {% endif %}
                                            </td>
                                            <td>{{ usuario.fecha_creacion|date('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"{{ app_url }}usuarios/{{ usuario.id }}\" 
                                                       class=\"btn btn-sm btn-info\" title=\"Ver\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}usuarios/{{ usuario.id }}/edit\" 
                                                       class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                    {% if usuario.id != user.id %}
                                                        <button type=\"button\" 
                                                                class=\"btn btn-sm {{ usuario.estado ? 'btn-danger' : 'btn-success' }}\"
                                                                onclick=\"cambiarEstado({{ usuario.id }}, {{ usuario.estado ? 0 : 1 }})\"
                                                                title=\"{{ usuario.estado ? 'Desactivar' : 'Activar' }}\">
                                                            <i class=\"fas fa-{{ usuario.estado ? 'times' : 'check' }}\"></i>
                                                        </button>
                                                        <button type=\"button\" 
                                                                class=\"btn btn-sm btn-danger\"
                                                                onclick=\"eliminarUsuario({{ usuario.id }})\"
                                                                title=\"Eliminar\">
                                                            <i class=\"fas fa-trash\"></i>
                                                        </button>
                                                    {% endif %}
                                                </div>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                {% else %}
                                    <tr>
                                        <td colspan=\"7\" class=\"text-center\">No se encontraron usuarios</td>
                                    </tr>
                                {% endif %}
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    {% if pagination.total_pages > 1 %}
                        <nav aria-label=\"Paginación de usuarios\">
                            <ul class=\"pagination justify-content-center\">
                                {% if pagination.current_page > 1 %}
                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"?page={{ pagination.current_page - 1 }}&search={{ filters.search }}&rol={{ filters.rol }}&estado={{ filters.estado }}\">
                                            Anterior
                                        </a>
                                    </li>
                                {% endif %}
                                
                                {% for page in 1..pagination.total_pages %}
                                    <li class=\"page-item {{ page == pagination.current_page ? 'active' : '' }}\">
                                        <a class=\"page-link\" href=\"?page={{ page }}&search={{ filters.search }}&rol={{ filters.rol }}&estado={{ filters.estado }}\">
                                            {{ page }}
                                        </a>
                                    </li>
                                {% endfor %}
                                
                                {% if pagination.current_page < pagination.total_pages %}
                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"?page={{ pagination.current_page + 1 }}&search={{ filters.search }}&rol={{ filters.rol }}&estado={{ filters.estado }}\">
                                            Siguiente
                                        </a>
                                    </li>
                                {% endif %}
                            </ul>
                        </nav>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
function cambiarEstado(userId, nuevoEstado) {
    const accion = nuevoEstado ? 'activar' : 'desactivar';
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas \${accion} este usuario?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ app_url }}usuarios/\${userId}/change-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    estado: nuevoEstado
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Éxito!',
                        data.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Ocurrió un error al procesar la solicitud',
                    'error'
                );
            });
        }
    });
}

function eliminarUsuario(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: \"Esta acción no se puede deshacer\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ app_url }}usuarios/\${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        data.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Ocurrió un error al procesar la solicitud',
                    'error'
                );
            });
        }
    });
}
</script>
{% endblock %} ", "usuarios/index.twig", "/var/www/html/biblioges/templates/usuarios/index.twig");
    }
}
