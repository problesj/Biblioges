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

/* asignaturas/create.twig */
class __TwigTemplate_c53fc817eaabb037c1b0e3240075b8cb extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Crear Asignatura - Biblioges";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Crear Nueva Asignatura</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-body\">
            <form id=\"createAsignaturaForm\" action=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" method=\"POST\">
                <!-- Datos Básicos -->
                <h5 class=\"mb-3\">Datos Básicos</h5>
                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"nombre\" class=\"form-label\">Nombre</label>
                        <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        <div class=\"invalid-feedback\" id=\"nombreError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"tipo\" class=\"form-label\">Tipo</label>
                        <select class=\"form-select\" id=\"tipo\" name=\"tipo\" required>
                            <option value=\"\">Seleccione un tipo</option>
                            <option value=\"REGULAR\">Regular</option>
                            <option value=\"FORMACION_BASICA\">Formación Básica</option>
                            <option value=\"FORMACION_GENERAL\">Formación General</option>
                            <option value=\"FORMACION_IDIOMAS\">Formación Idiomas</option>
                            <option value=\"FORMACION_PROFESIONAL\">Formación Profesional</option>
                            <option value=\"FORMACION_VALORES\">Formación Valores</option>
                            <option value=\"FORMACION_ESPECIALIDAD\">Formación Especialidad</option>
                            <option value=\"FORMACION_ELECTIVA\">Formación Electiva</option>
                            <option value=\"FORMACION_ESPECIAL\">Formación Especial</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"tipoError\"></div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"vigencia_desde\" class=\"form-label\">Vigencia Desde</label>
                        <input type=\"number\" class=\"form-control\" id=\"vigencia_desde\" name=\"vigencia_desde\" 
                               min=\"100000\" max=\"999999\" required
                               pattern=\"\\d{6}\" title=\"Debe ser un número de 6 dígitos\">
                        <small class=\"form-text text-muted\">Formato: AAAAXX (4 dígitos año + 2 dígitos secuencia)</small>
                        <div class=\"invalid-feedback\" id=\"vigenciaDesdeError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"vigencia_hasta\" class=\"form-label\">Vigencia Hasta</label>
                        <input type=\"number\" class=\"form-control\" id=\"vigencia_hasta\" name=\"vigencia_hasta\"
                               min=\"100000\" max=\"999999\"
                               pattern=\"\\d{6}\" title=\"Debe ser un número de 6 dígitos\">
                        <small class=\"form-text text-muted\">Formato: AAAAXX (4 dígitos año + 2 dígitos secuencia)</small>
                        <div class=\"invalid-feedback\" id=\"vigenciaHastaError\"></div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label for=\"periodicidad\" class=\"form-label\">Periodicidad</label>
                        <select class=\"form-select\" id=\"periodicidad\" name=\"periodicidad\" required>
                            <option value=\"\">Seleccione una periodicidad</option>
                            <option value=\"semestral\">Semestral</option>
                            <option value=\"anual\">Anual</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"periodicidadError\"></div>
                    </div>

                    <div class=\"col-md-6 mb-3\">
                        <label for=\"estado\" class=\"form-label\">Estado</label>
                        <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                            <option value=\"1\">Activa</option>
                            <option value=\"0\">Inactiva</option>
                        </select>
                        <div class=\"invalid-feedback\" id=\"estadoError\"></div>
                    </div>
                </div>

                <!-- Datos por Departamento -->
                <h5 class=\"mb-3 mt-4\">Datos por Departamento</h5>
                <div id=\"codigosContainer\">
                    <div class=\"row mb-3 codigo-row\">
                        <div class=\"col-md-4\">
                            <label for=\"departamento_id_0\" class=\"form-label\">Departamento</label>
                            <select class=\"form-select\" id=\"departamento_id_0\" name=\"codigos[0][departamento_id]\" required>
                                <option value=\"\">Seleccione un departamento</option>
                                ";
        // line 93
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
            // line 94
            yield "                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 94), "html", null, true);
            yield "\">
                                    ";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 95), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 95), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "departamento_nombre", [], "any", false, false, false, 95), "html", null, true);
            yield "
                                </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 98
        yield "                            </select>
                            <div class=\"invalid-feedback\" id=\"departamentoError_0\"></div>
                        </div>

                        <div class=\"col-md-3\">
                            <label for=\"codigo_0\" class=\"form-label\">Código de Asignatura</label>
                            <input type=\"text\" class=\"form-control\" id=\"codigo_0\" name=\"codigos[0][codigo]\" required>
                            <div class=\"invalid-feedback\" id=\"codigoError_0\"></div>
                        </div>

                        <div class=\"col-md-3\">
                            <label for=\"cantidad_alumnos_0\" class=\"form-label\">Cantidad de Alumnos</label>
                            <input type=\"number\" class=\"form-control\" id=\"cantidad_alumnos_0\" name=\"codigos[0][cantidad_alumnos]\" min=\"1\" required>
                            <div class=\"invalid-feedback\" id=\"cantidadAlumnosError_0\"></div>
                        </div>

                        <div class=\"col-md-2 d-flex align-items-end\">
                            <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"removeRow(this)\" style=\"display: none;\">
                                <i class=\"fas fa-times\"></i>
                            </button>
                        </div>
                    </div>
                </div>

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

    // line 141
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 142
        yield "<script>
let codigoCount = 0;

// Función para manejar el cambio en el tipo de asignatura
function handleTipoChange() {
    const tipoSelect = document.getElementById('tipo');
    const codigosContainer = document.getElementById('codigosContainer');
    const addRowButton = document.querySelector('button[onclick=\"addRow()\"]');
    const cantidadAlumnosInput = document.getElementById('cantidad_alumnos_0');
    const departamentoSelect = document.getElementById('departamento_id_0');
    
    if (tipoSelect.value === 'FORMACION_ELECTIVA') {
        // Mantener el botón de agregar códigos visible para Formación Electiva
        addRowButton.style.display = 'block';
        
        // Establecer cantidad de alumnos a 0 y deshabilitar
        cantidadAlumnosInput.value = '0';
        cantidadAlumnosInput.disabled = true;
        
        // Buscar y seleccionar \"Sin departamento\"
        Array.from(departamentoSelect.options).forEach(option => {
            if (option.text.includes('Sin departamento')) {
                departamentoSelect.value = option.value;
            }
        });
        departamentoSelect.disabled = true;

        // Actualizar todas las filas existentes
        document.querySelectorAll('.codigo-row').forEach((row, index) => {
            const cantInput = row.querySelector(`input[name\$=\"[cantidad_alumnos]\"]`);
            const depSelect = row.querySelector(`select[name^=\"codigos[\"]`);
            if (cantInput && depSelect) {
                cantInput.value = '0';
                cantInput.disabled = true;
                depSelect.value = departamentoSelect.value;
                depSelect.disabled = true;
            }
        });
    } else {
        // Restaurar el estado normal para otros tipos
        addRowButton.style.display = 'block';
        cantidadAlumnosInput.disabled = false;
        cantidadAlumnosInput.value = '';
        departamentoSelect.disabled = false;
        departamentoSelect.value = '';

        // Restaurar todas las filas existentes
        document.querySelectorAll('.codigo-row').forEach(row => {
            const cantInput = row.querySelector(`input[name\$=\"[cantidad_alumnos]\"]`);
            const depSelect = row.querySelector(`select[name^=\"codigos[\"]`);
            if (cantInput && depSelect) {
                cantInput.disabled = false;
                cantInput.value = '';
                depSelect.disabled = false;
                depSelect.value = '';
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
            <select class=\"form-select\" id=\"departamento_id_\${codigoCount}\" name=\"codigos[\${codigoCount}][departamento_id]\" required>
                <option value=\"\">Seleccione un departamento</option>
                ";
        // line 212
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
            // line 213
            yield "                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 213), "html", null, true);
            yield "\">
                    ";
            // line 214
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 214), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 214), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "departamento_nombre", [], "any", false, false, false, 214), "html", null, true);
            yield "
                </option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 217
        yield "            </select>
            <div class=\"invalid-feedback\" id=\"departamentoError_\${codigoCount}\"></div>
        </div>

        <div class=\"col-md-3\">
            <label for=\"codigo_\${codigoCount}\" class=\"form-label\">Código de Asignatura</label>
            <input type=\"text\" class=\"form-control\" id=\"codigo_\${codigoCount}\" name=\"codigos[\${codigoCount}][codigo]\" required>
            <div class=\"invalid-feedback\" id=\"codigoError_\${codigoCount}\"></div>
        </div>

        <div class=\"col-md-3\">
            <label for=\"cantidad_alumnos_\${codigoCount}\" class=\"form-label\">Cantidad de Alumnos</label>
            <input type=\"number\" class=\"form-control\" id=\"cantidad_alumnos_\${codigoCount}\" name=\"codigos[\${codigoCount}][cantidad_alumnos]\" min=\"1\" required>
            <div class=\"invalid-feedback\" id=\"cantidadAlumnosError_\${codigoCount}\"></div>
        </div>

        <div class=\"col-md-2 d-flex align-items-end\">
            <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"removeRow(this)\">
                <i class=\"fas fa-times\"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
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
    document.getElementById('tipo').addEventListener('change', handleTipoChange);
    
    const rows = document.querySelectorAll('.codigo-row');
    if (rows.length > 1) {
        rows[0].querySelector('.btn-danger').style.display = 'block';
    }

    document.getElementById('createAsignaturaForm').addEventListener('submit', async function(e) {
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
            const response = await fetch('";
        // line 376
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                alert('Asignatura creada exitosamente');
                window.location.href = '";
        // line 389
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
                    alert('Error al crear la asignatura: ' + result.message);
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
        return "asignaturas/create.twig";
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
        return array (  512 => 389,  496 => 376,  335 => 217,  322 => 214,  317 => 213,  313 => 212,  241 => 142,  234 => 141,  188 => 98,  175 => 95,  170 => 94,  166 => 93,  86 => 16,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "asignaturas/create.twig", "/var/www/html/biblioges/templates/asignaturas/create.twig");
    }
}
