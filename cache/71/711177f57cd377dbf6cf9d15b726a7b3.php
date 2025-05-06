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

/* asignaturas/edit.twig */
class __TwigTemplate_a67ffa1ea22abce4fce5df9d2380a684 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Asignatura - Biblioges";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Asignatura</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <form id=\"editAsignaturaForm\" method=\"POST\" action=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "id", [], "any", false, false, false, 16), "html", null, true);
        yield "/actualizar\">
                <!-- Datos Básicos -->
                <h5 class=\"mb-3\">Datos Básicos</h5>
                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"nombre\" class=\"form-label\">Nombre</label>
                        <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "nombre", [], "any", false, false, false, 22), "html", null, true);
        yield "\" required>
                        <div class=\"invalid-feedback\" id=\"nombreError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"tipo\" class=\"form-label\">Tipo</label>
                        <select class=\"form-select\" id=\"tipo\" name=\"tipo\" required>
                            <option value=\"\">Seleccione un tipo</option>
                            <option value=\"REGULAR\" ";
        // line 30
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 30) == "REGULAR")) {
            yield "selected";
        }
        yield ">Regular</option>
                            <option value=\"FORMACION_BASICA\" ";
        // line 31
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 31) == "FORMACION_BASICA")) {
            yield "selected";
        }
        yield ">Formación Básica</option>
                            <option value=\"FORMACION_GENERAL\" ";
        // line 32
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 32) == "FORMACION_GENERAL")) {
            yield "selected";
        }
        yield ">Formación General</option>
                            <option value=\"FORMACION_IDIOMAS\" ";
        // line 33
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 33) == "FORMACION_IDIOMAS")) {
            yield "selected";
        }
        yield ">Formación Idiomas</option>
                            <option value=\"FORMACION_PROFESIONAL\" ";
        // line 34
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 34) == "FORMACION_PROFESIONAL")) {
            yield "selected";
        }
        yield ">Formación Profesional</option>
                            <option value=\"FORMACION_VALORES\" ";
        // line 35
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 35) == "FORMACION_VALORES")) {
            yield "selected";
        }
        yield ">Formación Valores</option>
                            <option value=\"FORMACION_ESPECIALIDAD\" ";
        // line 36
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 36) == "FORMACION_ESPECIALIDAD")) {
            yield "selected";
        }
        yield ">Formación Especialidad</option>
                            <option value=\"FORMACION_ELECTIVA\" ";
        // line 37
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 37) == "FORMACION_ELECTIVA")) {
            yield "selected";
        }
        yield ">Formación Electiva</option>
                            <option value=\"FORMACION_ESPECIAL\" ";
        // line 38
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 38) == "FORMACION_ESPECIAL")) {
            yield "selected";
        }
        yield ">Formación Especial</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"tipoError\"></div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"vigencia_desde\" class=\"form-label\">Vigencia Desde</label>
                        <input type=\"number\" class=\"form-control\" id=\"vigencia_desde\" name=\"vigencia_desde\" 
                               value=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_desde", [], "any", false, false, false, 48), "html", null, true);
        yield "\" required
                               min=\"100000\" max=\"999999\" pattern=\"\\d{6}\" 
                               title=\"Debe ser un número de 6 dígitos\">
                        <small class=\"form-text text-muted\">Formato: AAAAXX (4 dígitos año + 2 dígitos secuencia)</small>
                        <div class=\"invalid-feedback\" id=\"vigenciaDesdeError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"vigencia_hasta\" class=\"form-label\">Vigencia Hasta</label>
                        <input type=\"number\" class=\"form-control\" id=\"vigencia_hasta\" name=\"vigencia_hasta\"
                               value=\"";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_hasta", [], "any", false, false, false, 58), "html", null, true);
        yield "\"
                               min=\"100000\" max=\"999999\" pattern=\"\\d{6}\"
                               title=\"Debe ser un número de 6 dígitos\">
                        <small class=\"form-text text-muted\">Formato: AAAAXX (4 dígitos año + 2 dígitos secuencia)</small>
                        <div class=\"invalid-feedback\" id=\"vigenciaHastaError\"></div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"periodicidad\" class=\"form-label\">Periodicidad</label>
                        <select class=\"form-select\" id=\"periodicidad\" name=\"periodicidad\" required>
                            <option value=\"\">Seleccione una periodicidad</option>
                            <option value=\"semestral\" ";
        // line 71
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "periodicidad", [], "any", false, false, false, 71) == "semestral")) {
            yield "selected";
        }
        yield ">Semestral</option>
                            <option value=\"anual\" ";
        // line 72
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "periodicidad", [], "any", false, false, false, 72) == "anual")) {
            yield "selected";
        }
        yield ">Anual</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"periodicidadError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"estado\" class=\"form-label\">Estado</label>
                        <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                            <option value=\"1\" ";
        // line 80
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 80) == 1)) {
            yield "selected";
        }
        yield ">Activa</option>
                            <option value=\"0\" ";
        // line 81
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 81) == 0)) {
            yield "selected";
        }
        yield ">Inactiva</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"estadoError\"></div>
                    </div>
                </div>

                <!-- Datos por Departamento -->
                <h5 class=\"mb-3 mt-4\">Datos por Departamento</h5>
                <div id=\"codigosContainer\">
                    ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "departamentos", [], "any", false, false, false, 90));
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
        foreach ($context['_seq'] as $context["_key"] => $context["info"]) {
            // line 91
            yield "                    <div class=\"row mb-3 codigo-row\">
                        <div class=\"col-md-4\">
                            <label for=\"departamento_id_";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 93), "html", null, true);
            yield "\" class=\"form-label\">Departamento</label>
                            <select class=\"form-control select-departamento\" 
                                    name=\"codigos[";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 95), "html", null, true);
            yield "][departamento_id]\" 
                                    data-index=\"";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 96), "html", null, true);
            yield "\" required>
                                <option value=\"\">Seleccione un departamento</option>
                                ";
            // line 98
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
                // line 99
                yield "                                <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 99), "html", null, true);
                yield "\" 
                                        ";
                // line 100
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 100) == CoreExtension::getAttribute($this->env, $this->source, $context["info"], "departamento_id", [], "any", false, false, false, 100))) {
                    yield "selected";
                }
                yield ">
                                    ";
                // line 101
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 101), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 101), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "departamento_nombre", [], "any", false, false, false, 101), "html", null, true);
                yield "
                                </option>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 104
            yield "                            </select>
                            <div class=\"invalid-feedback\" id=\"departamentoError_";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 105), "html", null, true);
            yield "\"></div>
                        </div>

                        <div class=\"col-md-4\">
                            <div class=\"form-group\">
                                <label for=\"codigo_";
            // line 110
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 110), "html", null, true);
            yield "\" class=\"form-label\">Código de Asignatura</label>
                                <input type=\"text\" class=\"form-control\" id=\"codigo_";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 111), "html", null, true);
            yield "\" 
                                       name=\"codigos[";
            // line 112
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 112), "html", null, true);
            yield "][codigo]\" 
                                       value=\"";
            // line 113
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "codigo_asignatura", [], "any", false, false, false, 113), "html", null, true);
            yield "\" required>
                                <div class=\"invalid-feedback\" id=\"codigoError_";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 114), "html", null, true);
            yield "\"></div>
                            </div>
                        </div>

                        <div class=\"col-md-4\">
                            <div class=\"form-group\">
                                <label for=\"cantidad_alumnos_";
            // line 120
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 120), "html", null, true);
            yield "\" class=\"form-label\">Cantidad de Alumnos</label>
                                <input type=\"number\" class=\"form-control\" id=\"cantidad_alumnos_";
            // line 121
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 121), "html", null, true);
            yield "\" 
                                       name=\"codigos[";
            // line 122
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 122), "html", null, true);
            yield "][cantidad_alumnos]\" 
                                       value=\"";
            // line 123
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "cantidad_alumnos", [], "any", false, false, false, 123), "html", null, true);
            yield "\" min=\"1\" required>
                                <div class=\"invalid-feedback\" id=\"cantidadAlumnosError_";
            // line 124
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 124), "html", null, true);
            yield "\"></div>
                            </div>
                        </div>

                        <div class=\"col-md-2 d-flex align-items-end\">
                            <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"removeRow(this)\" 
                                    ";
            // line 130
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 130) == 0)) {
                yield "style=\"display: none;\"";
            }
            yield ">
                                <i class=\"fas fa-times\"></i>
                            </button>
                        </div>
                    </div>
                    ";
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
        unset($context['_seq'], $context['_key'], $context['info'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 136
        yield "                </div>

                <div class=\"row mb-3\">
                    <div class=\"col-12\">
                        <button type=\"button\" class=\"btn btn-secondary\" onclick=\"addRow()\">
                            <i class=\"fas fa-plus\"></i> Agregar Otro Código
                        </button>
                    </div>
                </div>

                <div class=\"d-grid gap-2 d-md-flex justify-content-md-end\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 157
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 158
        yield "<script>
let codigoCount = ";
        // line 159
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "departamentos", [], "any", false, false, false, 159)) - 1), "html", null, true);
        yield ";

// Función para manejar el cambio en el tipo de asignatura
function handleTipoChange() {
    const tipoSelect = document.getElementById('tipo');
    const codigosContainer = document.getElementById('codigosContainer');
    const addRowButton = document.querySelector('button[onclick=\"addRow()\"]');
    
    if (tipoSelect.value === 'FORMACION_ELECTIVA') {
        // Mantener el botón de agregar códigos visible para Formación Electiva
        if (addRowButton) {
            addRowButton.style.display = 'block';
        }
        
        // Actualizar todas las filas existentes
        document.querySelectorAll('.codigo-row').forEach((row, index) => {
            const cantInput = row.querySelector(`input[name\$=\"[cantidad_alumnos]\"]`);
            const depSelect = row.querySelector(`select[name^=\"codigos[\"]`);
            if (cantInput && depSelect) {
                cantInput.value = '0';
                cantInput.disabled = true;
                depSelect.disabled = true;
            }
        });
    } else {
        // Restaurar el estado normal para otros tipos
        if (addRowButton) {
            addRowButton.style.display = 'block';
        }
        
        // Restaurar todas las filas existentes
        document.querySelectorAll('.codigo-row').forEach(row => {
            const cantInput = row.querySelector(`input[name\$=\"[cantidad_alumnos]\"]`);
            const depSelect = row.querySelector(`select[name^=\"codigos[\"]`);
            if (cantInput && depSelect) {
                cantInput.disabled = false;
                depSelect.disabled = false;
            }
        });
    }
}

function addRow() {
    codigoCount++;
    const container = document.getElementById('codigosContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-3 codigo-row';
    newRow.innerHTML = `
        <div class=\"col-md-4\">
            <label for=\"departamento_id_\${codigoCount}\" class=\"form-label\">Departamento</label>
            <select class=\"form-control select-departamento\" 
                    name=\"codigos[\${codigoCount}][departamento_id]\" 
                    data-index=\"\${codigoCount}\" required>
                <option value=\"\">Seleccione un departamento</option>
                ";
        // line 213
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
            // line 214
            yield "                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 214), "html", null, true);
            yield "\">
                    ";
            // line 215
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 215), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 215), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "departamento_nombre", [], "any", false, false, false, 215), "html", null, true);
            yield "
                </option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 218
        yield "            </select>
            <div class=\"invalid-feedback\" id=\"departamentoError_\${codigoCount}\"></div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"form-group\">
                <label for=\"codigo_\${codigoCount}\" class=\"form-label\">Código de Asignatura</label>
                <input type=\"text\" class=\"form-control\" id=\"codigo_\${codigoCount}\" name=\"codigos[\${codigoCount}][codigo]\" required>
                <div class=\"invalid-feedback\" id=\"codigoError_\${codigoCount}\"></div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"form-group\">
                <label for=\"cantidad_alumnos_\${codigoCount}\" class=\"form-label\">Cantidad de Alumnos</label>
                <input type=\"number\" class=\"form-control\" id=\"cantidad_alumnos_\${codigoCount}\" name=\"codigos[\${codigoCount}][cantidad_alumnos]\" min=\"1\" required>
                <div class=\"invalid-feedback\" id=\"cantidadAlumnosError_\${codigoCount}\"></div>
            </div>
        </div>

        <div class=\"col-md-2 d-flex align-items-end\">
            <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"removeRow(this)\">
                <i class=\"fas fa-times\"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);

    // Si es Formación Electiva, aplicar las restricciones a la nueva fila
    if (document.getElementById('tipo').value === 'FORMACION_ELECTIVA') {
        const cantInput = newRow.querySelector(`input[name\$=\"[cantidad_alumnos]\"]`);
        const depSelect = newRow.querySelector(`select[name^=\"codigos[\"]`);
        if (cantInput && depSelect) {
            cantInput.value = '0';
            cantInput.disabled = true;
            depSelect.value = document.getElementById('departamento_id_0').value;
            depSelect.disabled = true;
        }
    }
}

function removeRow(button) {
    const row = button.closest('.codigo-row');
    row.remove();
    reindexRows();
}

function reindexRows() {
    const rows = document.querySelectorAll('.codigo-row');
    rows.forEach((row, index) => {
        const depSelect = row.querySelector('select[name^=\"codigos[\"]');
        const codInput = row.querySelector('input[name\$=\"[codigo]\"]');
        const cantInput = row.querySelector('input[name\$=\"[cantidad_alumnos]\"]');
        
        if (depSelect && codInput && cantInput) {
            depSelect.name = `codigos[\${index}][departamento_id]`;
            depSelect.id = `departamento_id_\${index}`;
            codInput.name = `codigos[\${index}][codigo]`;
            codInput.id = `codigo_\${index}`;
            cantInput.name = `codigos[\${index}][cantidad_alumnos]`;
            cantInput.id = `cantidad_alumnos_\${index}`;
            row.querySelector(`[id^=\"departamentoError\"]`).id = `departamentoError_\${index}`;
            row.querySelector(`[id^=\"codigoError\"]`).id = `codigoError_\${index}`;
            row.querySelector(`[id^=\"cantidadAlumnosError\"]`).id = `cantidadAlumnosError_\${index}`;
        }
    });
    
    codigoCount = Math.max(0, rows.length - 1);
}

document.addEventListener('DOMContentLoaded', function() {
    // Agregar el event listener para el cambio de tipo
    const tipoSelect = document.getElementById('tipo');
    if (tipoSelect) {
        tipoSelect.addEventListener('change', handleTipoChange);
    }
    
    // Aplicar la lógica inicial según el tipo de asignatura
    handleTipoChange();

    document.getElementById('editAsignaturaForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        const formData = new FormData(this);
        const data = {
            nombre: formData.get('nombre'),
            tipo: formData.get('tipo'),
            vigencia_desde: formData.get('vigencia_desde'),
            vigencia_hasta: formData.get('vigencia_hasta'),
            periodicidad: formData.get('periodicidad'),
            estado: formData.get('estado'),
            codigos: []
        };

        // Validaciones del frontend
        let errores = {};

        if (!data.nombre) {
            errores['nombre'] = 'El nombre de la asignatura es requerido';
        }

        if (!data.tipo) {
            errores['tipo'] = 'El tipo de asignatura es requerido';
        }

        if (!data.vigencia_desde) {
            errores['vigencia_desde'] = 'La fecha de inicio de vigencia es requerida';
        }

        if (!data.periodicidad) {
            errores['periodicidad'] = 'La periodicidad es requerida';
        }

        const codigoRows = document.querySelectorAll('.codigo-row');
        let hasValidCodigo = false;

        codigoRows.forEach((row, index) => {
            const depSelect = row.querySelector('select[name^=\"codigos[\"]');
            const codInput = row.querySelector('input[name\$=\"[codigo]\"]');
            const cantInput = row.querySelector('input[name\$=\"[cantidad_alumnos]\"]');
            
            if (depSelect && codInput && cantInput) {
                const codigo = codInput.value.trim();
                
                if (codigo) {
                    hasValidCodigo = true;
                    if (data.tipo === 'FORMACION_ELECTIVA') {
                        data.codigos.push({
                            departamento_id: depSelect.value,
                            codigo: codigo,
                            cantidad_alumnos: '0'
                        });
                    } else {
                        if (!depSelect.value) {
                            errores[`departamento_\${index}`] = 'El departamento es requerido';
                            depSelect.classList.add('is-invalid');
                        }
                        if (!cantInput.value || cantInput.value < 1) {
                            errores[`cantidad_alumnos_\${index}`] = 'La cantidad de alumnos debe ser mayor a 0';
                            cantInput.classList.add('is-invalid');
                        }
                        data.codigos.push({
                            departamento_id: depSelect.value,
                            codigo: codigo,
                            cantidad_alumnos: cantInput.value
                        });
                    }
                } else {
                    errores[`codigo_\${index}`] = 'El código de asignatura es requerido';
                    codInput.classList.add('is-invalid');
                }
            }
        });

        if (!hasValidCodigo) {
            errores['codigos'] = 'Debe ingresar al menos un código de asignatura';
        }

        // Si hay errores, mostrarlos y detener el envío
        if (Object.keys(errores).length > 0) {
            Object.entries(errores).forEach(([field, message]) => {
                const errorDiv = document.getElementById(`\${field}Error`);
                if (errorDiv) {
                    errorDiv.textContent = message;
                    const input = document.getElementById(field);
                    if (input) {
                        input.classList.add('is-invalid');
                    }
                }
            });
            return;
        }
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                alert('Asignatura actualizada exitosamente');
                window.location.href = '";
        // line 407
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas';
            } else {
                if (result.errors) {
                    Object.entries(result.errors).forEach(([field, message]) => {
                        const errorDiv = document.getElementById(`\${field}Error`);
                        if (errorDiv) {
                            const input = document.getElementById(field);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            errorDiv.textContent = message;
                        }
                    });
                } else {
                    alert('Error al actualizar la asignatura: ' + result.message);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    });
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
        return "asignaturas/edit.twig";
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
        return array (  689 => 407,  498 => 218,  485 => 215,  480 => 214,  476 => 213,  419 => 159,  416 => 158,  409 => 157,  385 => 136,  363 => 130,  354 => 124,  350 => 123,  346 => 122,  342 => 121,  338 => 120,  329 => 114,  325 => 113,  321 => 112,  317 => 111,  313 => 110,  305 => 105,  302 => 104,  289 => 101,  283 => 100,  278 => 99,  274 => 98,  269 => 96,  265 => 95,  260 => 93,  256 => 91,  239 => 90,  225 => 81,  219 => 80,  206 => 72,  200 => 71,  184 => 58,  171 => 48,  156 => 38,  150 => 37,  144 => 36,  138 => 35,  132 => 34,  126 => 33,  120 => 32,  114 => 31,  108 => 30,  97 => 22,  86 => 16,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "asignaturas/edit.twig", "/var/www/html/biblioges/templates/asignaturas/edit.twig");
    }
}
