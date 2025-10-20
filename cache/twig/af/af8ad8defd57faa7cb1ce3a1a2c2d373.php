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
        <div>
            <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 10), "html", null, true);
        yield "/fusion-asignaturas\" class=\"btn btn-warning me-2\">
                <i class=\"fas fa-object-group\"></i> Fusionar Asignaturas
            </a>
            <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 13), "html", null, true);
        yield "\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
    </div>

    ";
        // line 19
        if (($context["swal"] ?? null)) {
            // line 20
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 22), "html", null, true);
            yield "',
            title: '";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 23), "html", null, true);
            yield "',
            text: '";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 24), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 29
        yield "
    ";
        // line 30
        if (($context["success"] ?? null)) {
            // line 31
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 32
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 36
        yield "
    ";
        // line 37
        if (($context["error"] ?? null)) {
            // line 38
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 43
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
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 52), "html", null, true);
        yield "</p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Tipo de Programa:</strong>
                        ";
        // line 56
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 56) == "P")) {
            // line 57
            yield "                            Pregrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 58
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 58) == "G")) {
            // line 59
            yield "                            Postgrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 60
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 60) == "O")) {
            // line 61
            yield "                            Otro
                        ";
        } else {
            // line 63
            yield "                            ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 63), "html", null, true);
            yield "
                        ";
        }
        // line 65
        yield "                    </p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Estado:</strong>
                        ";
        // line 69
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 69) == 1)) {
            // line 70
            yield "                            <span class=\"badge bg-success\">Activo</span>
                        ";
        } else {
            // line 72
            yield "                            <span class=\"badge bg-danger\">Inactivo</span>
                        ";
        }
        // line 74
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
        // line 98
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 98)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 99
            yield "                        <tr>
                            <td>";
            // line 100
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 100)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 101
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 101)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 102
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 102)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 103
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 103)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 104
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades", [], "any", false, false, false, 104)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[$context["i"]] ?? null) : null), "html", null, true);
            yield "</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 107
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
        // line 125
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 126
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 126), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 126), "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 128
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
        // line 205
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 205) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 205)) > 0))) {
            // line 206
            yield "                                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 206));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 207
                yield "                                            <tr data-id=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 207), "html", null, true);
                yield "\">
                                                <td>
                                                    ";
                // line 209
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 209));
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
                    // line 210
                    yield "                                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 210)) {
                        yield "<br>";
                    }
                    // line 211
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
                // line 212
                yield "                                                </td>
                                                <td>";
                // line 213
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 213), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">";
                // line 214
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 214), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">";
                // line 215
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 215), "html", null, true);
                yield "</td>
                                                <td class=\"text-center\">
                                                    <select class=\"form-select form-select-sm\" style=\"width: 80px;\">
                                                        ";
                // line 218
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(1, CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 218)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 219
                    yield "                                                            <option value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "\" ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 219) == $context["i"])) {
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
                // line 221
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
            // line 228
            yield "                                        ";
        } else {
            // line 229
            yield "                                            <tr id=\"no-asignaturas-message\">
                                                <td colspan=\"6\" class=\"text-center\">No hay asignaturas vinculadas</td>
                                            </tr>
                                        ";
        }
        // line 233
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
        // line 245
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
        // line 254
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 255
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definir la variable app_url dentro del scope de DOMContentLoaded
    const app_url = \"";
        // line 258
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
                
                // Agregar opciones del 1 al cantidad_semestres de la carrera
                const cantidadSemestres = ";
        // line 470
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", true, true, false, 470)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 470), 10)) : (10)), "html", null, true);
        yield ";
                for (let i = 1; i <= cantidadSemestres; i++) {
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
                const cantidadSemestres = ";
        // line 512
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", true, true, false, 512)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 512), 10)) : (10)), "html", null, true);
        yield ";
                for (let i = 1; i <= cantidadSemestres; i++) {
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
        // line 630
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 630), "html", null, true);
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
        // line 639
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 639), "html", null, true);
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
        // line 656
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 656), "html", null, true);
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
        return array (  942 => 656,  922 => 639,  910 => 630,  789 => 512,  744 => 470,  529 => 258,  524 => 255,  513 => 254,  501 => 245,  487 => 233,  481 => 229,  478 => 228,  466 => 221,  451 => 219,  447 => 218,  441 => 215,  437 => 214,  433 => 213,  430 => 212,  416 => 211,  410 => 210,  393 => 209,  387 => 207,  382 => 206,  380 => 205,  301 => 128,  290 => 126,  286 => 125,  266 => 107,  257 => 104,  253 => 103,  249 => 102,  245 => 101,  241 => 100,  238 => 99,  234 => 98,  208 => 74,  204 => 72,  200 => 70,  198 => 69,  192 => 65,  186 => 63,  182 => 61,  180 => 60,  177 => 59,  175 => 58,  172 => 57,  170 => 56,  163 => 52,  152 => 43,  145 => 39,  142 => 38,  140 => 37,  137 => 36,  130 => 32,  127 => 31,  125 => 30,  122 => 29,  114 => 24,  110 => 23,  106 => 22,  102 => 20,  100 => 19,  89 => 13,  81 => 10,  76 => 8,  72 => 6,  65 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Editar Malla - {{ carrera.nombre }}{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Malla - {{ carrera.nombre }}</h1>
        <div>
            <a href=\"{{ app_url }}mallas/{{ carrera.id }}/fusion-asignaturas\" class=\"btn btn-warning me-2\">
                <i class=\"fas fa-object-group\"></i> Fusionar Asignaturas
            </a>
            <a href=\"{{ app_url }}mallas/{{ carrera.id }}\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
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
                                                        {% for i in 1..carrera.cantidad_semestres %}
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
                
                // Agregar opciones del 1 al cantidad_semestres de la carrera
                const cantidadSemestres = {{ carrera.cantidad_semestres|default(10) }};
                for (let i = 1; i <= cantidadSemestres; i++) {
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
                const cantidadSemestres = {{ carrera.cantidad_semestres|default(10) }};
                for (let i = 1; i <= cantidadSemestres; i++) {
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
