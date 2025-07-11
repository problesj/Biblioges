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

/* asignaturas/index.twig */
class __TwigTemplate_1e815bd89ad0d729e990e1c9122cd56e extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Asignaturas - Sistema de Bibliografía";
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
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"nombre\" class=\"form-label\">Nombre</label>
                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", false, false, false, 28), "")) : ("")), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre...\">
                </div>
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" ";
        // line 34
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 34) == "REGULAR")) {
            yield "selected";
        }
        yield ">Regular</option>
                        <option value=\"FORMACION_BASICA\" ";
        // line 35
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 35) == "FORMACION_BASICA")) {
            yield "selected";
        }
        yield ">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" ";
        // line 36
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 36) == "FORMACION_GENERAL")) {
            yield "selected";
        }
        yield ">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" ";
        // line 37
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 37) == "FORMACION_IDIOMAS")) {
            yield "selected";
        }
        yield ">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" ";
        // line 38
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 38) == "FORMACION_PROFESIONAL")) {
            yield "selected";
        }
        yield ">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" ";
        // line 39
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 39) == "FORMACION_VALORES")) {
            yield "selected";
        }
        yield ">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" ";
        // line 40
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 40) == "FORMACION_ESPECIALIDAD")) {
            yield "selected";
        }
        yield ">Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" ";
        // line 41
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 41) == "FORMACION_ELECTIVA")) {
            yield "selected";
        }
        yield ">Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" ";
        // line 42
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 42) == "FORMACION_ESPECIAL")) {
            yield "selected";
        }
        yield ">Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"unidad\" class=\"form-label\">Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" name=\"unidad\">
                        <option value=\"\">Todas las unidades</option>
                        ";
        // line 49
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
            // line 50
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 50), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "unidad", [], "any", false, false, false, 50) == CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 50))) {
                yield "selected";
            }
            yield ">
                                ";
            // line 51
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 51), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        yield "                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 60
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 60) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 61
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 61) == "0")) {
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
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Vigencia</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                            <th>Unidades</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 93
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 94
            yield "                        <tr>
                            <td>";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 95), "html", null, true);
            yield "</td>
                            <td>";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 96), "html", null, true);
            yield "</td>
                            <td>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_desde", [], "any", false, false, false, 97), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_hasta", [], "any", false, false, false, 97), "html", null, true);
            yield "</td>
                            <td>";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 98), "html", null, true);
            yield "</td>
                            <td>
                                <span class=\"badge bg-";
            // line 100
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 100) == "1")) ? ("success") : ("danger"));
            yield "\">
                                    ";
            // line 101
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 101) == "1")) ? ("Activo") : ("Inactivo"));
            yield "
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">";
            // line 104
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "unidades", [], "any", true, true, false, 104)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "unidades", [], "any", false, false, false, 104), "Sin unidad")) : ("Sin unidad")), "html", null, true);
            yield "</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"";
            // line 107
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 107), "html", null, true);
            yield "\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 110
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 110), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 113
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 113), "html", null, true);
            yield "/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 121
        if (!$context['_iterated']) {
            // line 122
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 126
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 134
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 135
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el envío del formulario de eliminación
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar la solicitud AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            // Determinar el tipo de icono basado en el tipo de respuesta
                            let icon = 'error';
                            if (data.type === 'warning') {
                                icon = 'warning';
                            } else if (data.type === 'info') {
                                icon = 'info';
                            }
                            
                            Swal.fire({
                                title: data.type === 'warning' ? 'Advertencia' : 'Error',
                                text: data.message,
                                icon: icon,
                                confirmButtonColor: data.type === 'warning' ? '#ffc107' : '#d33',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        });
    });

    // Mostrar mensajes de éxito o error si existen y limpiarlos
    ";
        // line 232
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 232)) {
            // line 233
            yield "        Swal.fire({
            title: '¡Éxito!',
            text: '";
            // line 235
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 235), "html", null, true);
            yield "',
            icon: 'success',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('";
            // line 241
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    ";
        }
        // line 249
        yield "
    ";
        // line 250
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 250)) {
            // line 251
            yield "        Swal.fire({
            title: 'Error',
            text: '";
            // line 253
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 253), "html", null, true);
            yield "',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('";
            // line 259
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    ";
        }
        // line 267
        yield "});
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "asignaturas/index.twig";
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
        return array (  506 => 267,  495 => 259,  486 => 253,  482 => 251,  480 => 250,  477 => 249,  466 => 241,  457 => 235,  453 => 233,  451 => 232,  352 => 135,  345 => 134,  334 => 126,  325 => 122,  323 => 121,  308 => 113,  300 => 110,  292 => 107,  286 => 104,  280 => 101,  276 => 100,  271 => 98,  265 => 97,  261 => 96,  257 => 95,  254 => 94,  249 => 93,  221 => 68,  209 => 61,  203 => 60,  195 => 54,  186 => 51,  177 => 50,  173 => 49,  161 => 42,  155 => 41,  149 => 40,  143 => 39,  137 => 38,  131 => 37,  125 => 36,  119 => 35,  113 => 34,  104 => 28,  98 => 25,  83 => 13,  77 => 10,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Asignaturas - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"{{ app_url }}asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"{{ app_url }}asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"nombre\" class=\"form-label\">Nombre</label>
                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ filtros.nombre|default('') }}\" placeholder=\"Buscar por nombre...\">
                </div>
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" {% if filtros.tipo == 'REGULAR' %}selected{% endif %}>Regular</option>
                        <option value=\"FORMACION_BASICA\" {% if filtros.tipo == 'FORMACION_BASICA' %}selected{% endif %}>Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" {% if filtros.tipo == 'FORMACION_GENERAL' %}selected{% endif %}>Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" {% if filtros.tipo == 'FORMACION_IDIOMAS' %}selected{% endif %}>Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" {% if filtros.tipo == 'FORMACION_PROFESIONAL' %}selected{% endif %}>Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" {% if filtros.tipo == 'FORMACION_VALORES' %}selected{% endif %}>Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" {% if filtros.tipo == 'FORMACION_ESPECIALIDAD' %}selected{% endif %}>Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" {% if filtros.tipo == 'FORMACION_ELECTIVA' %}selected{% endif %}>Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" {% if filtros.tipo == 'FORMACION_ESPECIAL' %}selected{% endif %}>Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"unidad\" class=\"form-label\">Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" name=\"unidad\">
                        <option value=\"\">Todas las unidades</option>
                        {% for unidad in unidades %}
                            <option value=\"{{ unidad.id }}\" {% if filtros.unidad == unidad.id %}selected{% endif %}>
                                {{ unidad.nombre }}
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
                    <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-broom\"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Vigencia</th>
                            <th>Periodicidad</th>
                            <th>Estado</th>
                            <th>Unidades</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for asignatura in asignaturas %}
                        <tr>
                            <td>{{ asignatura.nombre }}</td>
                            <td>{{ asignatura.tipo }}</td>
                            <td>{{ asignatura.vigencia_desde }} - {{ asignatura.vigencia_hasta }}</td>
                            <td>{{ asignatura.periodicidad }}</td>
                            <td>
                                <span class=\"badge bg-{{ asignatura.estado == '1' ? 'success' : 'danger' }}\">
                                    {{ asignatura.estado == '1' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">{{ asignatura.unidades|default('Sin unidad') }}</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}asignaturas/{{ asignatura.id }}/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el envío del formulario de eliminación
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar la solicitud AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            // Determinar el tipo de icono basado en el tipo de respuesta
                            let icon = 'error';
                            if (data.type === 'warning') {
                                icon = 'warning';
                            } else if (data.type === 'info') {
                                icon = 'info';
                            }
                            
                            Swal.fire({
                                title: data.type === 'warning' ? 'Advertencia' : 'Error',
                                text: data.message,
                                icon: icon,
                                confirmButtonColor: data.type === 'warning' ? '#ffc107' : '#d33',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        });
    });

    // Mostrar mensajes de éxito o error si existen y limpiarlos
    {% if session.success %}
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session.success }}',
            icon: 'success',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    {% endif %}

    {% if session.error %}
        Swal.fire({
            title: 'Error',
            text: '{{ session.error }}',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    {% endif %}
});
</script>
{% endblock %} ", "asignaturas/index.twig", "/var/www/html/biblioges/templates/asignaturas/index.twig");
    }
}
