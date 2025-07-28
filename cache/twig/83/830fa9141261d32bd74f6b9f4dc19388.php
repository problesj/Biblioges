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

/* asignaturas/vinculacion.twig */
class __TwigTemplate_25ec99e6ec2cd2a12f19c06933a092ad extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/vinculacion.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Vincular Asignaturas Electivas - Sistema de Bibliografía";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Vincular Asignaturas Electivas</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 14
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 14)) {
            // line 15
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 16), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 20
        yield "
    ";
        // line 21
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 21)) {
            // line 22
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 23), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 27
        yield "
    <!-- Selección de asignatura de formación -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Seleccionar Asignatura Electiva</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"formAsignaturaFormacion\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"asignatura_formacion\" class=\"form-label\">Asignatura Electiva</label>
                    <select class=\"form-select\" id=\"asignatura_formacion\" name=\"asignatura_formacion\" required>
                        <option value=\"\">Seleccione una asignatura</option>
                        ";
        // line 39
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_electivas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 40
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 40), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 40), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 40), "html", null, true);
            yield ")</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        yield "                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura a Vincular</label>
                    <select class=\"form-select\" id=\"tipo_asignatura\" name=\"tipo_asignatura\" required>
                        <option value=\"\">Seleccione un tipo</option>
                        ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["tipos_asignaturas"] ?? null));
        foreach ($context['_seq'] as $context["tipo"] => $context["nombre"]) {
            // line 49
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tipo"], "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["nombre"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['tipo'], $context['nombre'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        yield "                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de asignaturas -->
    <div class=\"row\" id=\"panelAsignaturas\" style=\"display: none;\">
        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Disponibles</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"tablaNoVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllNoVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-2 d-flex align-items-center justify-content-center\">
            <div class=\"btn-group-vertical\">
                <button type=\"button\" class=\"btn btn-primary mb-2\" id=\"btnVincular\">
                    <i class=\"fas fa-chevron-right\"></i>
                </button>
                <button type=\"button\" class=\"btn btn-danger\" id=\"btnQuitar\">
                    <i class=\"fas fa-chevron-left\"></i>
                </button>
            </div>
        </div>

        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"tablaVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
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

    // line 123
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 124
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    const asignaturaFormacion = document.getElementById('asignatura_formacion');
    const tipoAsignatura = document.getElementById('tipo_asignatura');
    const panelAsignaturas = document.getElementById('panelAsignaturas');
    const tablaNoVinculadas = document.getElementById('tablaNoVinculadas').getElementsByTagName('tbody')[0];
    const tablaVinculadas = document.getElementById('tablaVinculadas').getElementsByTagName('tbody')[0];
    const selectAllNoVinculadas = document.getElementById('selectAllNoVinculadas');
    const selectAllVinculadas = document.getElementById('selectAllVinculadas');
    const btnVincular = document.getElementById('btnVincular');
    const btnQuitar = document.getElementById('btnQuitar');

    // Función para cargar asignaturas cuando se seleccione tanto la asignatura electiva como el tipo
    function cargarAsignaturasSegunSeleccion() {
        const asignaturaId = asignaturaFormacion.value;
        const tipo = tipoAsignatura.value;
        
        if (asignaturaId && tipo) {
            panelAsignaturas.style.display = 'flex';
            cargarAsignaturas(asignaturaId, tipo);
        } else {
            panelAsignaturas.style.display = 'none';
        }
    }

    // Event listeners para los selectores
    asignaturaFormacion.addEventListener('change', cargarAsignaturasSegunSeleccion);
    tipoAsignatura.addEventListener('change', cargarAsignaturasSegunSeleccion);

    // Event listener para el botón de vincular
    btnVincular.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        vincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listener para el botón de quitar
    btnQuitar.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        desvincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listeners para seleccionar/deseleccionar todo
    selectAllNoVinculadas.addEventListener('change', function() {
        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    selectAllVinculadas.addEventListener('change', function() {
        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function cargarAsignaturas(asignaturaFormacionId, tipo) {
        fetch(`";
        // line 201
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}?tipo=\${tipo}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    limpiarTablas();
                    llenarTablaNoVinculadas(data.no_vinculadas);
                    llenarTablaVinculadas(data.vinculadas);
                } else {
                    alert(data.message || 'Error al cargar las asignaturas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas');
            });
    }

    function vincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`";
        // line 219
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}/agregar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al vincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al vincular las asignaturas');
        });
    }

    function desvincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`";
        // line 242
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}/quitar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al desvincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desvincular las asignaturas');
        });
    }

    function llenarTablaNoVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaNoVinculadas.insertRow();
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${asignatura.nombre}</td>
            `;
        });
    }

    function llenarTablaVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaVinculadas.insertRow();
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${asignatura.nombre}</td>
            `;
        });
    }

    function limpiarTablas() {
        tablaNoVinculadas.innerHTML = '';
        tablaVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
        selectAllVinculadas.checked = false;
    }
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
        return "asignaturas/vinculacion.twig";
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
        return array (  373 => 242,  347 => 219,  326 => 201,  247 => 124,  240 => 123,  165 => 51,  154 => 49,  150 => 48,  142 => 42,  129 => 40,  125 => 39,  111 => 27,  104 => 23,  101 => 22,  99 => 21,  96 => 20,  89 => 16,  86 => 15,  84 => 14,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Vincular Asignaturas Electivas - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Vincular Asignaturas Electivas</h1>
        <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if session.success %}
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        {{ session.success }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    {% if session.error %}
    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        {{ session.error }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    <!-- Selección de asignatura de formación -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Seleccionar Asignatura Electiva</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"formAsignaturaFormacion\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"asignatura_formacion\" class=\"form-label\">Asignatura Electiva</label>
                    <select class=\"form-select\" id=\"asignatura_formacion\" name=\"asignatura_formacion\" required>
                        <option value=\"\">Seleccione una asignatura</option>
                        {% for asignatura in asignaturas_electivas %}
                            <option value=\"{{ asignatura.id }}\">{{ asignatura.nombre }} ({{ asignatura.codigos }})</option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura a Vincular</label>
                    <select class=\"form-select\" id=\"tipo_asignatura\" name=\"tipo_asignatura\" required>
                        <option value=\"\">Seleccione un tipo</option>
                        {% for tipo, nombre in tipos_asignaturas %}
                            <option value=\"{{ tipo }}\">{{ nombre }}</option>
                        {% endfor %}
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de asignaturas -->
    <div class=\"row\" id=\"panelAsignaturas\" style=\"display: none;\">
        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Disponibles</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"tablaNoVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllNoVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-2 d-flex align-items-center justify-content-center\">
            <div class=\"btn-group-vertical\">
                <button type=\"button\" class=\"btn btn-primary mb-2\" id=\"btnVincular\">
                    <i class=\"fas fa-chevron-right\"></i>
                </button>
                <button type=\"button\" class=\"btn btn-danger\" id=\"btnQuitar\">
                    <i class=\"fas fa-chevron-left\"></i>
                </button>
            </div>
        </div>

        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"tablaVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const asignaturaFormacion = document.getElementById('asignatura_formacion');
    const tipoAsignatura = document.getElementById('tipo_asignatura');
    const panelAsignaturas = document.getElementById('panelAsignaturas');
    const tablaNoVinculadas = document.getElementById('tablaNoVinculadas').getElementsByTagName('tbody')[0];
    const tablaVinculadas = document.getElementById('tablaVinculadas').getElementsByTagName('tbody')[0];
    const selectAllNoVinculadas = document.getElementById('selectAllNoVinculadas');
    const selectAllVinculadas = document.getElementById('selectAllVinculadas');
    const btnVincular = document.getElementById('btnVincular');
    const btnQuitar = document.getElementById('btnQuitar');

    // Función para cargar asignaturas cuando se seleccione tanto la asignatura electiva como el tipo
    function cargarAsignaturasSegunSeleccion() {
        const asignaturaId = asignaturaFormacion.value;
        const tipo = tipoAsignatura.value;
        
        if (asignaturaId && tipo) {
            panelAsignaturas.style.display = 'flex';
            cargarAsignaturas(asignaturaId, tipo);
        } else {
            panelAsignaturas.style.display = 'none';
        }
    }

    // Event listeners para los selectores
    asignaturaFormacion.addEventListener('change', cargarAsignaturasSegunSeleccion);
    tipoAsignatura.addEventListener('change', cargarAsignaturasSegunSeleccion);

    // Event listener para el botón de vincular
    btnVincular.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        vincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listener para el botón de quitar
    btnQuitar.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        desvincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listeners para seleccionar/deseleccionar todo
    selectAllNoVinculadas.addEventListener('change', function() {
        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    selectAllVinculadas.addEventListener('change', function() {
        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function cargarAsignaturas(asignaturaFormacionId, tipo) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}?tipo=\${tipo}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    limpiarTablas();
                    llenarTablaNoVinculadas(data.no_vinculadas);
                    llenarTablaVinculadas(data.vinculadas);
                } else {
                    alert(data.message || 'Error al cargar las asignaturas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas');
            });
    }

    function vincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}/agregar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al vincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al vincular las asignaturas');
        });
    }

    function desvincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}/quitar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al desvincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desvincular las asignaturas');
        });
    }

    function llenarTablaNoVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaNoVinculadas.insertRow();
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${asignatura.nombre}</td>
            `;
        });
    }

    function llenarTablaVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaVinculadas.insertRow();
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${asignatura.nombre}</td>
            `;
        });
    }

    function limpiarTablas() {
        tablaNoVinculadas.innerHTML = '';
        tablaVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
        selectAllVinculadas.checked = false;
    }
});
</script>
{% endblock %} ", "asignaturas/vinculacion.twig", "/var/www/html/biblioges/templates/asignaturas/vinculacion.twig");
    }
}
