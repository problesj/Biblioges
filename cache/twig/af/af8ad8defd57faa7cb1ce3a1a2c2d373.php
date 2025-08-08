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

/* mallas/edit.twig */
class __TwigTemplate_2dd1edec0520a2dde0a37f937f33aee3 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "mallas/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Malla - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 3), "html", null, true);
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
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Malla - ";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 8), "html", null, true);
        yield "</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 9), "html", null, true);
        yield "\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 14
        if (($context["swal"] ?? null)) {
            // line 15
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 17
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 17), "html", null, true);
            yield "',
            title: '";
            // line 18
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 18), "html", null, true);
            yield "',
            text: '";
            // line 19
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 19), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 24
        yield "
    ";
        // line 25
        if (($context["success"] ?? null)) {
            // line 26
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 27
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 31
        yield "
    ";
        // line 32
        if (($context["error"] ?? null)) {
            // line 33
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 38
        yield "
    <!-- Información de la Carrera -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-4\">
                    <p><strong>Nombre:</strong> ";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 47), "html", null, true);
        yield "</p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Tipo de Programa:</strong>
                        ";
        // line 51
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 51) == "P")) {
            // line 52
            yield "                            Pregrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 53
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 53) == "G")) {
            // line 54
            yield "                            Postgrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 55
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 55) == "O")) {
            // line 56
            yield "                            Otro
                        ";
        } else {
            // line 58
            yield "                            ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 58), "html", null, true);
            yield "
                        ";
        }
        // line 60
        yield "                    </p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Estado:</strong>
                        ";
        // line 64
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 64) == 1)) {
            // line 65
            yield "                            <span class=\"badge bg-success\">Activo</span>
                        ";
        } else {
            // line 67
            yield "                            <span class=\"badge bg-danger\">Inactivo</span>
                        ";
        }
        // line 69
        yield "                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Carreras Espejo -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información de Carreras Espejo</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código</th>
                            <th>Vigencia Desde</th>
                            <th>Vigencia Hasta</th>
                            <th>Sede</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 93
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 93)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 94
            yield "                        <tr>
                            <td>";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 95)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 96)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 97)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 98)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 99
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades", [], "any", false, false, false, 99)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 102
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Panel de Edición de Malla -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Edición de Malla</h6>
        </div>
        <div class=\"card-body\">
            <!-- Filtros de búsqueda -->
            <div class=\"row mb-4\">
                <div class=\"col-md-6\">
                    <label for=\"sede\" class=\"form-label\">Seleccionar Sede</label>
                    <select class=\"form-select\" id=\"sede\">
                        <option value=\"\">Seleccione una sede</option>
                        ";
        // line 120
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 121
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 121), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 121), "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 123
        yield "                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"unidad\" class=\"form-label\">Seleccionar Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" disabled>
                        <option value=\"\">Primero seleccione una sede</option>
                    </select>
                </div>
            </div>

            <!-- Paneles de asignaturas -->
            <div class=\"row\">
                <!-- Panel Izquierdo: Asignaturas Disponibles -->
                <div class=\"col-12\">
                    <div class=\"card h-100 border-info\">
                        <div class=\"card-header py-3 bg-info text-white\">
                            <h6 class=\"m-0 font-weight-bold\">Asignaturas Disponibles</h6>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-sm\">
                                    <thead class=\"table-info\">
                                        <tr>
                                            <th>Códigos</th>
                                            <th>Nombre</th>
                                            <th class=\"text-center\">Tipo</th>
                                            <th class=\"text-center\">Periodicidad</th>
                                            <th class=\"text-center\">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id=\"asignaturas-disponibles\">
                                        <tr>
                                            <td colspan=\"5\" class=\"text-center\">Seleccione una sede</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Central: Botones de Acción -->
            <div class=\"row mt-2 mb-2\">
                <div class=\"col-12 d-flex align-items-center justify-content-center\">
                    <div class=\"d-flex flex-row gap-2\">
                        <button class=\"btn btn-primary btn-sm\" id=\"btn-agregar\" disabled>
                            <i class=\"fas fa-arrow-down\"></i>
                        </button>
                        <button class=\"btn btn-danger btn-sm\" id=\"btn-quitar\" disabled>
                            <i class=\"fas fa-arrow-up\"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Asignaturas Vinculadas -->
            <div class=\"row\">
                <div class=\"col-12\">
                    <div class=\"card h-100 border-primary\">
                        <div class=\"card-header py-3 bg-primary text-white\">
                            <h6 class=\"m-0 font-weight-bold\">Asignaturas Vinculadas</h6>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-sm\">
                                    <thead class=\"table-primary\">
                                        <tr>
                                            <th>Códigos</th>
                                            <th>Nombre</th>
                                            <th class=\"text-center\">Tipo</th>
                                            <th class=\"text-center\">Periodicidad</th>
                                            <th class=\"text-center\" style=\"width: 100px;\">Semestre</th>
                                            <th class=\"text-center\" style=\"width: 80px;\">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id=\"asignaturas-vinculadas\">
                                        ";
        // line 200
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 200) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 200)) > 0))) {
            // line 201
            yield "                                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 201));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 202
                yield "                                            <tr data-id=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 202), "html", null, true);
                yield "\">
                                                <td>
                                                    ";
                // line 204
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 204));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["codigo"]) {
                    // line 205
                    yield "                                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 205)) {
                        yield "<br>";
                    }
                    // line 206
                    yield "                                                    ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['codigo'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 207
                yield "                                                </td>
                                                <td>";
                // line 208
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 208), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">";
                // line 209
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 209), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">";
                // line 210
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 210), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">
                                                    <select class=\"form-select form-select-sm\" style=\"width: 80px;\">
                                                        ";
                // line 213
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(1, 10));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 214
                    yield "                                                            <option value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "\" ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 214) == $context["i"])) {
                        yield "selected";
                    }
                    yield ">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "</option>
                                                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 216
                yield "                                                    </select>
                                                </td>
                                                <td class=\"text-center\">
                                                    <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                                                </td>
                                            </tr>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 223
            yield "                                        ";
        } else {
            // line 224
            yield "                                            <tr id=\"no-asignaturas-message\">
                                                <td colspan=\"6\" class=\"text-center\">No hay asignaturas vinculadas</td>
                                            </tr>
                                        ";
        }
        // line 228
        yield "                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class=\"d-flex gap-2 mb-4\">
        <a href=\"";
        // line 240
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
        <button type=\"button\" class=\"btn btn-primary\" id=\"btn-guardar\">
            <i class=\"fas fa-save\"></i> Guardar Cambios
        </button>
    </div>
</div>

";
        // line 249
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 250
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definir la variable app_url dentro del scope de DOMContentLoaded
    const app_url = \"";
        // line 253
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\";
    
    const sedeSelect = document.getElementById('sede');
    const unidadSelect = document.getElementById('unidad');
    const btnAgregar = document.getElementById('btn-agregar');
    const btnQuitar = document.getElementById('btn-quitar');
    const btnGuardar = document.getElementById('btn-guardar');
    const asignaturasDisponibles = document.getElementById('asignaturas-disponibles');
    const asignaturasVinculadas = document.getElementById('asignaturas-vinculadas');

    let asignaturasSeleccionadas = new Set();
    let asignaturasVinculadasSeleccionadas = new Set();

    // Función para resetear la tabla de asignaturas
    function resetearAsignaturas() {
        asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Seleccione una sede</td></tr>';
    }

    // Manejar cambio de sede
    sedeSelect.addEventListener('change', function() {
        const sedeId = this.value;
        
        // Resetear la tabla de asignaturas
        resetearAsignaturas();
        unidadSelect.value = ''; // Limpiar unidad seleccionada
        unidadSelect.disabled = true; // Deshabilitar unidad hasta que se seleccione una sede
        
        if (sedeId) {
            // Caso especial: Sin sede (id 4)
            if (sedeId === '4') {
                unidadSelect.innerHTML = '<option value=\"55\">Sin Unidad</option>';
                unidadSelect.disabled = false;
                cargarAsignaturasDeUnidad('55');
                return;
            }
            // Habilitar unidad y cargar unidades de la sede seleccionada
            unidadSelect.disabled = false;
            cargarUnidadesDeSede(sedeId);
        }
    });

    // Manejar cambio de unidad
    unidadSelect.addEventListener('change', function() {
        const unidadId = this.value;
        if (unidadId) {
            // Cargar asignaturas de la unidad seleccionada
            cargarAsignaturasDeUnidad(unidadId);
        } else {
            // Si se selecciona \"Primero seleccione una sede\", no cargar asignaturas
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Seleccione una unidad</td></tr>';
        }
    });

    // Función para cargar unidades de una sede
    function cargarUnidadesDeSede(sedeId) {
        const apiUrl = `\${app_url}api/unidades/sede/\${sedeId}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: \${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                // Limpiar opciones existentes y agregar nuevas
                unidadSelect.innerHTML = '<option value=\"\">Seleccione una unidad</option>';
                data.forEach(unidad => {
                    const option = document.createElement('option');
                    option.value = unidad.id;
                    option.textContent = unidad.nombre;
                    unidadSelect.appendChild(option);
                });
                // Si ya hay una unidad seleccionada, cargar asignaturas de esa unidad
                if (unidadSelect.value) {
                    cargarAsignaturasDeUnidad(unidadSelect.value);
                }
            } else {
                unidadSelect.innerHTML = '<option value=\"\">No hay unidades disponibles para esta sede</option>';
                asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay unidades disponibles para esta sede</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error al cargar unidades:', error);
            unidadSelect.innerHTML = '<option value=\"\">Error al cargar unidades</option>';
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Error al cargar unidades</td></tr>';
        });
    }

    // Función para cargar asignaturas de una unidad específica
    function cargarAsignaturasDeUnidad(unidadId) {
        const apiUrl = `\${app_url}api/asignaturas/unidad/\${unidadId}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: \${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                mostrarAsignaturasDisponibles(data);
            } else {
                asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay asignaturas disponibles para esta unidad</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error al cargar asignaturas:', error);
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Error al cargar asignaturas</td></tr>';
        });
    }

    // Función para mostrar asignaturas disponibles
    function mostrarAsignaturasDisponibles(asignaturas) {
        asignaturasDisponibles.innerHTML = '';
        
        if (asignaturas.length > 0) {
            asignaturas.forEach(asignatura => {
                // Verificar si la asignatura ya está vinculada
                const yaVinculada = Array.from(asignaturasVinculadas.querySelectorAll('tr[data-id]'))
                    .some(row => row.dataset.id === asignatura.id.toString());
                
                if (!yaVinculada) {
                    // Formatear los códigos con saltos de línea
                    let codigos = '';
                    if (asignatura.codigos) {
                        if (Array.isArray(asignatura.codigos)) {
                            codigos = asignatura.codigos.join('<br>');
                        } else if (typeof asignatura.codigos === 'string') {
                            codigos = asignatura.codigos.split(',').join('<br>');
                        }
                    }
                    
                    asignaturasDisponibles.innerHTML += `
                        <tr data-id=\"\${asignatura.id}\">
                            <td>\${codigos}</td>
                            <td>\${asignatura.nombre}<br><small class=\"text-muted\">\${asignatura.unidad_nombre || ''}</small></td>
                            <td class=\"text-center\">\${asignatura.tipo}</td>
                            <td class=\"text-center\">\${asignatura.periodicidad}</td>
                            <td class=\"text-center\">
                                <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                            </td>
                        </tr>
                    `;
                }
            });
        } else {
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay asignaturas disponibles</td></tr>';
        }
    }

    // Manejar selección de asignaturas disponibles
    asignaturasDisponibles.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-seleccionar')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            
            if (asignaturasSeleccionadas.has(id)) {
                asignaturasSeleccionadas.delete(id);
                row.classList.remove('table-primary');
            } else {
                asignaturasSeleccionadas.add(id);
                row.classList.add('table-primary');
            }
            
            btnAgregar.disabled = asignaturasSeleccionadas.size === 0;
        }
    });

    // Manejar selección de asignaturas vinculadas
    asignaturasVinculadas.addEventListener('click', function(e) {
        if (e.target.closest('.btn-seleccionar')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            
            if (asignaturasVinculadasSeleccionadas.has(id)) {
                asignaturasVinculadasSeleccionadas.delete(id);
                row.classList.remove('table-primary');
            } else {
                asignaturasVinculadasSeleccionadas.add(id);
                row.classList.add('table-primary');
            }
            
            btnQuitar.disabled = asignaturasVinculadasSeleccionadas.size === 0;
        }
    });

    // Función para cargar asignaturas vinculadas iniciales
    function cargarAsignaturasVinculadas() {
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        rows.forEach(row => {
            // Asegurarse de que cada fila tenga un select para el semestre
            if (!row.querySelector('select')) {
                const semestreCell = row.cells[3];
                const selectSemestre = document.createElement('select');
                selectSemestre.className = 'form-select form-select-sm';
                
                // Agregar opciones del 1 al 10
                for (let i = 1; i <= 10; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    selectSemestre.appendChild(option);
                }
                
                // Si hay un valor de semestre existente, seleccionarlo
                const semestreActual = semestreCell.textContent.trim();
                if (semestreActual) {
                    selectSemestre.value = semestreActual;
                }
                
                semestreCell.innerHTML = '';
                semestreCell.appendChild(selectSemestre);
            }
        });
    }

    // Manejar agregar asignaturas
    btnAgregar.addEventListener('click', function() {
        const rows = asignaturasDisponibles.querySelectorAll('tr[data-id]');
        const noAsignaturasMessage = document.getElementById('no-asignaturas-message');
        
        if (noAsignaturasMessage) {
            noAsignaturasMessage.remove();
        }
        
        rows.forEach(row => {
            if (asignaturasSeleccionadas.has(row.dataset.id)) {
                const asignatura = {
                    id: row.dataset.id,
                    codigos: row.cells[0].textContent,
                    nombre: row.cells[1].textContent,
                    tipo: row.cells[2].textContent,
                    periodicidad: row.cells[3].textContent
                };
                
                // Crear el selector de semestre
                const selectSemestre = document.createElement('select');
                selectSemestre.className = 'form-select form-select-sm w-100';
                for (let i = 1; i <= 10; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    selectSemestre.appendChild(option);
                }
                
                // Crear la nueva fila
                const nuevaFila = document.createElement('tr');
                nuevaFila.dataset.id = asignatura.id;
                nuevaFila.innerHTML = `
                    <td>\${asignatura.codigos}</td>
                    <td>\${asignatura.nombre}</td>
                    <td class=\"text-center\">\${asignatura.tipo}</td>
                    <td class=\"text-center\">\${asignatura.periodicidad}</td>
                    <td class=\"text-center\"></td>
                    <td class=\"text-center\">
                        <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                    </td>
                `;
                
                // Agregar el selector de semestre a la celda
                const semestreCell = nuevaFila.cells[4];
                semestreCell.appendChild(selectSemestre);
                
                // Agregar la nueva fila a la tabla
                asignaturasVinculadas.appendChild(nuevaFila);
                
                // Eliminar de la tabla de disponibles
                row.remove();
            }
        });
        
        asignaturasSeleccionadas.clear();
        btnAgregar.disabled = true;
    });

    // Manejar quitar asignaturas
    btnQuitar.addEventListener('click', function() {
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        rows.forEach(row => {
            if (asignaturasVinculadasSeleccionadas.has(row.dataset.id)) {
                // Crear nueva fila para la tabla de disponibles
                const nuevaFila = document.createElement('tr');
                nuevaFila.dataset.id = row.dataset.id;
                nuevaFila.innerHTML = `
                    <td>\${row.cells[0].textContent}</td>
                    <td>\${row.cells[1].textContent}</td>
                    <td class=\"text-center\">\${row.cells[2].textContent}</td>
                    <td class=\"text-center\">\${row.cells[3].textContent}</td>
                    <td class=\"text-center\">
                        <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                    </td>
                `;
                
                // Agregar la nueva fila a la tabla de disponibles
                asignaturasDisponibles.appendChild(nuevaFila);
                
                // Eliminar de la tabla de vinculadas
                row.remove();
            }
        });
        
        // Si no quedan asignaturas vinculadas, mostrar el mensaje
        if (asignaturasVinculadas.querySelectorAll('tr[data-id]').length === 0) {
            asignaturasVinculadas.innerHTML = `
                <tr id=\"no-asignaturas-message\">
                    <td colspan=\"6\" class=\"text-center\">No hay asignaturas vinculadas</td>
                </tr>
            `;
        }
        
        asignaturasVinculadasSeleccionadas.clear();
        btnQuitar.disabled = true;
    });

    // Manejar guardado de cambios
    btnGuardar.addEventListener('click', function() {
        const asignaturas = [];
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        
        // Verificar si hay asignaturas vinculadas
        if (rows.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No hay asignaturas vinculadas para guardar',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Recolectar todas las asignaturas vinculadas
        rows.forEach(row => {
            const selectSemestre = row.querySelector('select');
            if (selectSemestre) {
                asignaturas.push({
                    id: row.dataset.id,
                    semestre: selectSemestre.value,
                    nombre: row.cells[1].textContent,
                    tipo: row.cells[2].textContent,
                    periodicidad: row.cells[3].textContent
                });
            }
        });

        // Mostrar confirmación antes de guardar
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de guardar \${asignaturas.length} asignaturas en la malla?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar datos al servidor
                fetch(`\${app_url}api/mallas/";
        // line 623
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 623), "html", null, true);
        yield "`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ 
                        asignaturas: asignaturas,
                        carrera_id: ";
        // line 632
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 632), "html", null, true);
        yield "
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: \${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Malla actualizada correctamente',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = `\${app_url}mallas/";
        // line 649
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 649), "html", null, true);
        yield "`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al actualizar la malla: ' + (data.error || 'Error desconocido'),
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar la malla: ' + error.message,
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    });

    // Cargar asignaturas vinculadas al iniciar
    cargarAsignaturasVinculadas();
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
        return "mallas/edit.twig";
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
        return array (  924 => 649,  904 => 632,  892 => 623,  519 => 253,  514 => 250,  503 => 249,  491 => 240,  477 => 228,  471 => 224,  468 => 223,  456 => 216,  441 => 214,  437 => 213,  431 => 210,  427 => 209,  423 => 208,  420 => 207,  406 => 206,  400 => 205,  383 => 204,  377 => 202,  372 => 201,  370 => 200,  291 => 123,  280 => 121,  276 => 120,  256 => 102,  247 => 99,  243 => 98,  239 => 97,  235 => 96,  231 => 95,  228 => 94,  224 => 93,  198 => 69,  194 => 67,  190 => 65,  188 => 64,  182 => 60,  176 => 58,  172 => 56,  170 => 55,  167 => 54,  165 => 53,  162 => 52,  160 => 51,  153 => 47,  142 => 38,  135 => 34,  132 => 33,  130 => 32,  127 => 31,  120 => 27,  117 => 26,  115 => 25,  112 => 24,  104 => 19,  100 => 18,  96 => 17,  92 => 15,  90 => 14,  80 => 9,  76 => 8,  72 => 6,  65 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Editar Malla - {{ carrera.nombre }}{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Malla - {{ carrera.nombre }}</h1>
        <a href=\"{{ app_url }}mallas/{{ carrera.id }}\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if swal %}
    <script>
        Swal.fire({
            icon: '{{ swal.icon }}',
            title: '{{ swal.title }}',
            text: '{{ swal.text }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    {% endif %}

    {% if success %}
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        {{ success }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    {% if error %}
    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        {{ error }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    <!-- Información de la Carrera -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-4\">
                    <p><strong>Nombre:</strong> {{ carrera.nombre }}</p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Tipo de Programa:</strong>
                        {% if carrera.tipo_programa == 'P' %}
                            Pregrado
                        {% elseif carrera.tipo_programa == 'G' %}
                            Postgrado
                        {% elseif carrera.tipo_programa == 'O' %}
                            Otro
                        {% else %}
                            {{ carrera.tipo_programa }}
                        {% endif %}
                    </p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Estado:</strong>
                        {% if carrera.estado == 1 %}
                            <span class=\"badge bg-success\">Activo</span>
                        {% else %}
                            <span class=\"badge bg-danger\">Inactivo</span>
                        {% endif %}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Carreras Espejo -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información de Carreras Espejo</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código</th>
                            <th>Vigencia Desde</th>
                            <th>Vigencia Hasta</th>
                            <th>Sede</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for i in 0..carrera.codigos_carrera|length-1 %}
                        <tr>
                            <td>{{ carrera.codigos_carrera[i] }}</td>
                            <td>{{ carrera.vigencias_desde[i] }}</td>
                            <td>{{ carrera.vigencias_hasta[i] }}</td>
                            <td>{{ carrera.sedes[i] }}</td>
                            <td>{{ carrera.unidades[i] }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Panel de Edición de Malla -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Edición de Malla</h6>
        </div>
        <div class=\"card-body\">
            <!-- Filtros de búsqueda -->
            <div class=\"row mb-4\">
                <div class=\"col-md-6\">
                    <label for=\"sede\" class=\"form-label\">Seleccionar Sede</label>
                    <select class=\"form-select\" id=\"sede\">
                        <option value=\"\">Seleccione una sede</option>
                        {% for sede in sedes %}
                            <option value=\"{{ sede.id }}\">{{ sede.nombre }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"unidad\" class=\"form-label\">Seleccionar Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" disabled>
                        <option value=\"\">Primero seleccione una sede</option>
                    </select>
                </div>
            </div>

            <!-- Paneles de asignaturas -->
            <div class=\"row\">
                <!-- Panel Izquierdo: Asignaturas Disponibles -->
                <div class=\"col-12\">
                    <div class=\"card h-100 border-info\">
                        <div class=\"card-header py-3 bg-info text-white\">
                            <h6 class=\"m-0 font-weight-bold\">Asignaturas Disponibles</h6>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-sm\">
                                    <thead class=\"table-info\">
                                        <tr>
                                            <th>Códigos</th>
                                            <th>Nombre</th>
                                            <th class=\"text-center\">Tipo</th>
                                            <th class=\"text-center\">Periodicidad</th>
                                            <th class=\"text-center\">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id=\"asignaturas-disponibles\">
                                        <tr>
                                            <td colspan=\"5\" class=\"text-center\">Seleccione una sede</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Central: Botones de Acción -->
            <div class=\"row mt-2 mb-2\">
                <div class=\"col-12 d-flex align-items-center justify-content-center\">
                    <div class=\"d-flex flex-row gap-2\">
                        <button class=\"btn btn-primary btn-sm\" id=\"btn-agregar\" disabled>
                            <i class=\"fas fa-arrow-down\"></i>
                        </button>
                        <button class=\"btn btn-danger btn-sm\" id=\"btn-quitar\" disabled>
                            <i class=\"fas fa-arrow-up\"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Asignaturas Vinculadas -->
            <div class=\"row\">
                <div class=\"col-12\">
                    <div class=\"card h-100 border-primary\">
                        <div class=\"card-header py-3 bg-primary text-white\">
                            <h6 class=\"m-0 font-weight-bold\">Asignaturas Vinculadas</h6>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-sm\">
                                    <thead class=\"table-primary\">
                                        <tr>
                                            <th>Códigos</th>
                                            <th>Nombre</th>
                                            <th class=\"text-center\">Tipo</th>
                                            <th class=\"text-center\">Periodicidad</th>
                                            <th class=\"text-center\" style=\"width: 100px;\">Semestre</th>
                                            <th class=\"text-center\" style=\"width: 80px;\">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id=\"asignaturas-vinculadas\">
                                        {% if carrera.asignaturas is defined and carrera.asignaturas|length > 0 %}
                                            {% for asignatura in carrera.asignaturas %}
                                            <tr data-id=\"{{ asignatura.id }}\">
                                                <td>
                                                    {% for codigo in asignatura.codigos %}
                                                        {{ codigo }}{% if not loop.last %}<br>{% endif %}
                                                    {% endfor %}
                                                </td>
                                                <td>{{ asignatura.nombre }}</td>
                                                <td class=\"text-center\">{{ asignatura.tipo }}</td>
                                                <td class=\"text-center\">{{ asignatura.periodicidad }}</td>
                                                <td class=\"text-center\">
                                                    <select class=\"form-select form-select-sm\" style=\"width: 80px;\">
                                                        {% for i in 1..10 %}
                                                            <option value=\"{{ i }}\" {% if asignatura.semestre == i %}selected{% endif %}>{{ i }}</option>
                                                        {% endfor %}
                                                    </select>
                                                </td>
                                                <td class=\"text-center\">
                                                    <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                                                </td>
                                            </tr>
                                            {% endfor %}
                                        {% else %}
                                            <tr id=\"no-asignaturas-message\">
                                                <td colspan=\"6\" class=\"text-center\">No hay asignaturas vinculadas</td>
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
    </div>

    <!-- Botones de acción -->
    <div class=\"d-flex gap-2 mb-4\">
        <a href=\"{{ app_url }}mallas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
        <button type=\"button\" class=\"btn btn-primary\" id=\"btn-guardar\">
            <i class=\"fas fa-save\"></i> Guardar Cambios
        </button>
    </div>
</div>

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definir la variable app_url dentro del scope de DOMContentLoaded
    const app_url = \"{{ app_url }}\";
    
    const sedeSelect = document.getElementById('sede');
    const unidadSelect = document.getElementById('unidad');
    const btnAgregar = document.getElementById('btn-agregar');
    const btnQuitar = document.getElementById('btn-quitar');
    const btnGuardar = document.getElementById('btn-guardar');
    const asignaturasDisponibles = document.getElementById('asignaturas-disponibles');
    const asignaturasVinculadas = document.getElementById('asignaturas-vinculadas');

    let asignaturasSeleccionadas = new Set();
    let asignaturasVinculadasSeleccionadas = new Set();

    // Función para resetear la tabla de asignaturas
    function resetearAsignaturas() {
        asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Seleccione una sede</td></tr>';
    }

    // Manejar cambio de sede
    sedeSelect.addEventListener('change', function() {
        const sedeId = this.value;
        
        // Resetear la tabla de asignaturas
        resetearAsignaturas();
        unidadSelect.value = ''; // Limpiar unidad seleccionada
        unidadSelect.disabled = true; // Deshabilitar unidad hasta que se seleccione una sede
        
        if (sedeId) {
            // Caso especial: Sin sede (id 4)
            if (sedeId === '4') {
                unidadSelect.innerHTML = '<option value=\"55\">Sin Unidad</option>';
                unidadSelect.disabled = false;
                cargarAsignaturasDeUnidad('55');
                return;
            }
            // Habilitar unidad y cargar unidades de la sede seleccionada
            unidadSelect.disabled = false;
            cargarUnidadesDeSede(sedeId);
        }
    });

    // Manejar cambio de unidad
    unidadSelect.addEventListener('change', function() {
        const unidadId = this.value;
        if (unidadId) {
            // Cargar asignaturas de la unidad seleccionada
            cargarAsignaturasDeUnidad(unidadId);
        } else {
            // Si se selecciona \"Primero seleccione una sede\", no cargar asignaturas
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Seleccione una unidad</td></tr>';
        }
    });

    // Función para cargar unidades de una sede
    function cargarUnidadesDeSede(sedeId) {
        const apiUrl = `\${app_url}api/unidades/sede/\${sedeId}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: \${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                // Limpiar opciones existentes y agregar nuevas
                unidadSelect.innerHTML = '<option value=\"\">Seleccione una unidad</option>';
                data.forEach(unidad => {
                    const option = document.createElement('option');
                    option.value = unidad.id;
                    option.textContent = unidad.nombre;
                    unidadSelect.appendChild(option);
                });
                // Si ya hay una unidad seleccionada, cargar asignaturas de esa unidad
                if (unidadSelect.value) {
                    cargarAsignaturasDeUnidad(unidadSelect.value);
                }
            } else {
                unidadSelect.innerHTML = '<option value=\"\">No hay unidades disponibles para esta sede</option>';
                asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay unidades disponibles para esta sede</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error al cargar unidades:', error);
            unidadSelect.innerHTML = '<option value=\"\">Error al cargar unidades</option>';
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Error al cargar unidades</td></tr>';
        });
    }

    // Función para cargar asignaturas de una unidad específica
    function cargarAsignaturasDeUnidad(unidadId) {
        const apiUrl = `\${app_url}api/asignaturas/unidad/\${unidadId}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: \${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                mostrarAsignaturasDisponibles(data);
            } else {
                asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay asignaturas disponibles para esta unidad</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error al cargar asignaturas:', error);
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">Error al cargar asignaturas</td></tr>';
        });
    }

    // Función para mostrar asignaturas disponibles
    function mostrarAsignaturasDisponibles(asignaturas) {
        asignaturasDisponibles.innerHTML = '';
        
        if (asignaturas.length > 0) {
            asignaturas.forEach(asignatura => {
                // Verificar si la asignatura ya está vinculada
                const yaVinculada = Array.from(asignaturasVinculadas.querySelectorAll('tr[data-id]'))
                    .some(row => row.dataset.id === asignatura.id.toString());
                
                if (!yaVinculada) {
                    // Formatear los códigos con saltos de línea
                    let codigos = '';
                    if (asignatura.codigos) {
                        if (Array.isArray(asignatura.codigos)) {
                            codigos = asignatura.codigos.join('<br>');
                        } else if (typeof asignatura.codigos === 'string') {
                            codigos = asignatura.codigos.split(',').join('<br>');
                        }
                    }
                    
                    asignaturasDisponibles.innerHTML += `
                        <tr data-id=\"\${asignatura.id}\">
                            <td>\${codigos}</td>
                            <td>\${asignatura.nombre}<br><small class=\"text-muted\">\${asignatura.unidad_nombre || ''}</small></td>
                            <td class=\"text-center\">\${asignatura.tipo}</td>
                            <td class=\"text-center\">\${asignatura.periodicidad}</td>
                            <td class=\"text-center\">
                                <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                            </td>
                        </tr>
                    `;
                }
            });
        } else {
            asignaturasDisponibles.innerHTML = '<tr><td colspan=\"5\" class=\"text-center\">No hay asignaturas disponibles</td></tr>';
        }
    }

    // Manejar selección de asignaturas disponibles
    asignaturasDisponibles.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-seleccionar')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            
            if (asignaturasSeleccionadas.has(id)) {
                asignaturasSeleccionadas.delete(id);
                row.classList.remove('table-primary');
            } else {
                asignaturasSeleccionadas.add(id);
                row.classList.add('table-primary');
            }
            
            btnAgregar.disabled = asignaturasSeleccionadas.size === 0;
        }
    });

    // Manejar selección de asignaturas vinculadas
    asignaturasVinculadas.addEventListener('click', function(e) {
        if (e.target.closest('.btn-seleccionar')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            
            if (asignaturasVinculadasSeleccionadas.has(id)) {
                asignaturasVinculadasSeleccionadas.delete(id);
                row.classList.remove('table-primary');
            } else {
                asignaturasVinculadasSeleccionadas.add(id);
                row.classList.add('table-primary');
            }
            
            btnQuitar.disabled = asignaturasVinculadasSeleccionadas.size === 0;
        }
    });

    // Función para cargar asignaturas vinculadas iniciales
    function cargarAsignaturasVinculadas() {
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        rows.forEach(row => {
            // Asegurarse de que cada fila tenga un select para el semestre
            if (!row.querySelector('select')) {
                const semestreCell = row.cells[3];
                const selectSemestre = document.createElement('select');
                selectSemestre.className = 'form-select form-select-sm';
                
                // Agregar opciones del 1 al 10
                for (let i = 1; i <= 10; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    selectSemestre.appendChild(option);
                }
                
                // Si hay un valor de semestre existente, seleccionarlo
                const semestreActual = semestreCell.textContent.trim();
                if (semestreActual) {
                    selectSemestre.value = semestreActual;
                }
                
                semestreCell.innerHTML = '';
                semestreCell.appendChild(selectSemestre);
            }
        });
    }

    // Manejar agregar asignaturas
    btnAgregar.addEventListener('click', function() {
        const rows = asignaturasDisponibles.querySelectorAll('tr[data-id]');
        const noAsignaturasMessage = document.getElementById('no-asignaturas-message');
        
        if (noAsignaturasMessage) {
            noAsignaturasMessage.remove();
        }
        
        rows.forEach(row => {
            if (asignaturasSeleccionadas.has(row.dataset.id)) {
                const asignatura = {
                    id: row.dataset.id,
                    codigos: row.cells[0].textContent,
                    nombre: row.cells[1].textContent,
                    tipo: row.cells[2].textContent,
                    periodicidad: row.cells[3].textContent
                };
                
                // Crear el selector de semestre
                const selectSemestre = document.createElement('select');
                selectSemestre.className = 'form-select form-select-sm w-100';
                for (let i = 1; i <= 10; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    selectSemestre.appendChild(option);
                }
                
                // Crear la nueva fila
                const nuevaFila = document.createElement('tr');
                nuevaFila.dataset.id = asignatura.id;
                nuevaFila.innerHTML = `
                    <td>\${asignatura.codigos}</td>
                    <td>\${asignatura.nombre}</td>
                    <td class=\"text-center\">\${asignatura.tipo}</td>
                    <td class=\"text-center\">\${asignatura.periodicidad}</td>
                    <td class=\"text-center\"></td>
                    <td class=\"text-center\">
                        <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                    </td>
                `;
                
                // Agregar el selector de semestre a la celda
                const semestreCell = nuevaFila.cells[4];
                semestreCell.appendChild(selectSemestre);
                
                // Agregar la nueva fila a la tabla
                asignaturasVinculadas.appendChild(nuevaFila);
                
                // Eliminar de la tabla de disponibles
                row.remove();
            }
        });
        
        asignaturasSeleccionadas.clear();
        btnAgregar.disabled = true;
    });

    // Manejar quitar asignaturas
    btnQuitar.addEventListener('click', function() {
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        rows.forEach(row => {
            if (asignaturasVinculadasSeleccionadas.has(row.dataset.id)) {
                // Crear nueva fila para la tabla de disponibles
                const nuevaFila = document.createElement('tr');
                nuevaFila.dataset.id = row.dataset.id;
                nuevaFila.innerHTML = `
                    <td>\${row.cells[0].textContent}</td>
                    <td>\${row.cells[1].textContent}</td>
                    <td class=\"text-center\">\${row.cells[2].textContent}</td>
                    <td class=\"text-center\">\${row.cells[3].textContent}</td>
                    <td class=\"text-center\">
                        <input type=\"checkbox\" class=\"form-check-input btn-seleccionar\">
                    </td>
                `;
                
                // Agregar la nueva fila a la tabla de disponibles
                asignaturasDisponibles.appendChild(nuevaFila);
                
                // Eliminar de la tabla de vinculadas
                row.remove();
            }
        });
        
        // Si no quedan asignaturas vinculadas, mostrar el mensaje
        if (asignaturasVinculadas.querySelectorAll('tr[data-id]').length === 0) {
            asignaturasVinculadas.innerHTML = `
                <tr id=\"no-asignaturas-message\">
                    <td colspan=\"6\" class=\"text-center\">No hay asignaturas vinculadas</td>
                </tr>
            `;
        }
        
        asignaturasVinculadasSeleccionadas.clear();
        btnQuitar.disabled = true;
    });

    // Manejar guardado de cambios
    btnGuardar.addEventListener('click', function() {
        const asignaturas = [];
        const rows = asignaturasVinculadas.querySelectorAll('tr[data-id]');
        
        // Verificar si hay asignaturas vinculadas
        if (rows.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No hay asignaturas vinculadas para guardar',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Recolectar todas las asignaturas vinculadas
        rows.forEach(row => {
            const selectSemestre = row.querySelector('select');
            if (selectSemestre) {
                asignaturas.push({
                    id: row.dataset.id,
                    semestre: selectSemestre.value,
                    nombre: row.cells[1].textContent,
                    tipo: row.cells[2].textContent,
                    periodicidad: row.cells[3].textContent
                });
            }
        });

        // Mostrar confirmación antes de guardar
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de guardar \${asignaturas.length} asignaturas en la malla?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar datos al servidor
                fetch(`\${app_url}api/mallas/{{ carrera.id }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ 
                        asignaturas: asignaturas,
                        carrera_id: {{ carrera.id }}
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: \${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Malla actualizada correctamente',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = `\${app_url}mallas/{{ carrera.id }}`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al actualizar la malla: ' + (data.error || 'Error desconocido'),
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar la malla: ' + error.message,
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    });

    // Cargar asignaturas vinculadas al iniciar
    cargarAsignaturasVinculadas();
});
</script>
{% endblock %}
{% endblock %} ", "mallas/edit.twig", "/var/www/html/biblioges/templates/mallas/edit.twig");
    }
}
