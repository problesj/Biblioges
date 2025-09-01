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

/* carreras/create.twig */
class __TwigTemplate_ffa4d2f16e9c69ed2a7e3237dc809bcb extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/create.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Nueva Carrera - Sistema de Bibliografía";
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
    <!-- Botón para ocultar/mostrar el panel lateral -->
    <button id=\"sidebarToggle\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
        <i class=\"fas fa-bars\"></i>
    </button>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Nueva Carrera</h1>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Datos de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"POST\" action=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/store\" id=\"form-carrera\" enctype=\"multipart/form-data\">
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                   value=\"";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "nombre", [], "any", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "nombre", [], "any", false, false, false, 28), "")) : ("")), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"P\" ";
        // line 36
        yield (((((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", true, true, false, 36)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", false, false, false, 36), "")) : ("")) == "P")) ? ("selected") : (""));
        yield ">Pregrado</option>
                                <option value=\"G\" ";
        // line 37
        yield (((((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", true, true, false, 37)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", false, false, false, 37), "")) : ("")) == "G")) ? ("selected") : (""));
        yield ">Postgrado</option>
                                <option value=\"O\" ";
        // line 38
        yield (((((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", true, true, false, 38)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "tipo_programa", [], "any", false, false, false, 38), "")) : ("")) == "O")) ? ("selected") : (""));
        yield ">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\" ";
        // line 46
        yield (((((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "estado", [], "any", true, true, false, 46)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "estado", [], "any", false, false, false, 46), "1")) : ("1")) == "1")) ? ("selected") : (""));
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 47
        yield (((((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "estado", [], "any", true, true, false, 47)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "estado", [], "any", false, false, false, 47), "1")) : ("1")) == "0")) ? ("selected") : (""));
        yield ">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección 1.5: Libro de Carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-12\">
                        <div class=\"form-group\">
                            <label for=\"libro_carrera\" class=\"form-label\">Libro de Carrera (PDF)</label>
                            <input type=\"file\" class=\"form-control\" id=\"libro_carrera\" name=\"libro_carrera\" 
                                   accept=\".pdf\" max=\"10485760\">
                            <small class=\"form-text text-muted\">
                                <i class=\"fas fa-info-circle\"></i> 
                                Solo archivos PDF. Tamaño máximo: 10MB
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Sección 1.6: Imagen de la Carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"imagen_carrera\" class=\"form-label\">Imagen de la Carrera</label>
                            <input type=\"file\" class=\"form-control\" id=\"imagen_carrera\" name=\"imagen_carrera\" accept=\"image/*\">
                            <small class=\"form-text text-muted\">
                                <i class=\"fas fa-info-circle\"></i> Solo imágenes JPG, PNG o GIF. Tamaño recomendado: 1440x700px
                            </small>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"cantidad_semestres\" class=\"form-label\">Cantidad de Semestres *</label>
                            <input type=\"number\" class=\"form-control\" id=\"cantidad_semestres\" name=\"cantidad_semestres\" min=\"1\" max=\"20\" value=\"";
        // line 82
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "cantidad_semestres", [], "any", true, true, false, 82)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "cantidad_semestres", [], "any", false, false, false, 82), 10)) : (10)), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Códigos de carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-12\">
                        <h6 class=\"mb-3\">Códigos de Carrera</h6>
                        <div id=\"codigos-container\">
                            ";
        // line 92
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "codigos", [], "any", true, true, false, 92) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "codigos", [], "any", false, false, false, 92)) > 0))) {
            // line 93
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "codigos", [], "any", false, false, false, 93));
            foreach ($context['_seq'] as $context["index"] => $context["codigo"]) {
                // line 94
                yield "                                    ";
                if ( !Twig\Extension\CoreExtension::testEmpty($context["codigo"])) {
                    // line 95
                    yield "                                    <div class=\"row mb-3 codigo-row\">
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                                <input type=\"text\" class=\"form-control\" name=\"codigos[]\" 
                                                       value=\"";
                    // line 100
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                    yield "\" required>
                                            </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                                <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                                       value=\"";
                    // line 107
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "vigencias_desde", [], "any", false, true, false, 107), $context["index"], [], "array", true, true, false, 107)) ? (Twig\Extension\CoreExtension::default((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "vigencias_desde", [], "any", false, false, false, 107)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["index"]] ?? null) : null), "")) : ("")), "html", null, true);
                    yield "\"
                                                       pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required>
                                            </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                                <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                                       value=\"";
                    // line 115
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "vigencias_hasta", [], "any", false, true, false, 115), $context["index"], [], "array", true, true, false, 115)) ? (Twig\Extension\CoreExtension::default((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "vigencias_hasta", [], "any", false, false, false, 115)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["index"]] ?? null) : null), "999999")) : ("999999")), "html", null, true);
                    yield "\"
                                                       pattern=\"\\d{6}\" title=\"Formato: AAAAMM\">
                                            </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                            <div class=\"form-group\">
                                                <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                                <select class=\"form-select\" name=\"sedes[]\" required>
                                                    <option value=\"\">Seleccione una sede</option>
                                                    ";
                    // line 124
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                        // line 125
                        yield "                                                    <option value=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 125), "html", null, true);
                        yield "\" ";
                        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "sedes", [], "any", false, true, false, 125), $context["index"], [], "array", true, true, false, 125)) ? (Twig\Extension\CoreExtension::default((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "sedes", [], "any", false, false, false, 125)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["index"]] ?? null) : null), "")) : ("")) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 125))) ? ("selected") : (""));
                        yield ">
                                                        ";
                        // line 126
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 126), "html", null, true);
                        yield "
                                                    </option>
                                                    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 129
                    yield "                                                </select>
                                            </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                            <div class=\"form-group\">
                                                <label for=\"unidades[]\" class=\"form-label\">Unidad *</label>
                                                <select class=\"form-select\" name=\"unidades[]\" required>
                                                    <option value=\"\">Seleccione una unidad</option>
                                                    ";
                    // line 137
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
                        // line 138
                        yield "                                                    <option value=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 138), "html", null, true);
                        yield "\" ";
                        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "unidades", [], "any", false, true, false, 138), $context["index"], [], "array", true, true, false, 138)) ? (Twig\Extension\CoreExtension::default((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "unidades", [], "any", false, false, false, 138)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["index"]] ?? null) : null), "")) : ("")) == CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 138))) ? ("selected") : (""));
                        yield ">
                                                        ";
                        // line 139
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 139), "html", null, true);
                        yield "
                                                    </option>
                                                    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 142
                    yield "                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                }
                // line 147
                yield "                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['index'], $context['codigo'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 148
            yield "                            ";
        } else {
            // line 149
            yield "                            <div class=\"row mb-3 codigo-row\">
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"codigos[]\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                               pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                               value=\"999999\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\">
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                        <select class=\"form-select\" name=\"sedes[]\" required>
                                            <option value=\"\">Seleccione una sede</option>
                                            ";
            // line 175
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 176
                yield "                                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 176), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 176), "html", null, true);
                yield "</option>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 178
            yield "                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label for=\"unidades[]\" class=\"form-label\">Unidad *</label>
                                        <select class=\"form-select\" name=\"unidades[]\" required>
                                            <option value=\"\">Seleccione una unidad</option>
                                            ";
            // line 186
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
                // line 187
                yield "                                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 187), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 187), "html", null, true);
                yield "</option>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 189
            yield "                                        </select>
                                    </div>
                                </div>
                            </div>
                            ";
        }
        // line 194
        yield "                        </div>
                        <button type=\"button\" class=\"btn btn-secondary btn-sm\" id=\"agregar-codigo\">
                            <i class=\"fas fa-plus\"></i> Agregar otro código
                        </button>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-12 d-flex gap-2\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-save\"></i> Guardar
                        </button>
                        <a href=\"";
        // line 206
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 217
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 218
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar error de sesión con SweetAlert2 si existe
        ";
        // line 221
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 221)) {
            // line 222
            yield "        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `";
            // line 225
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 225), "js"), "html", null, true);
            yield "`
        });
        ";
        }
        // line 228
        yield "
        // Función para cargar unidades por sede
        function cargarUnidadesPorSede(sedeSelect) {
            var unidadSelect = sedeSelect.closest('.row').find('select[name=\"unidades[]\"]');
            unidadSelect.html('<option value=\"\">Cargando...</option>');
            
            \$.ajax({
                url: '";
        // line 235
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "api/unidades',
                method: 'GET',
                data: { sede_id: sedeSelect.val() },
                success: function(unidades) {
                    unidadSelect.html('<option value=\"\">Seleccione una unidad</option>');
                    if (Array.isArray(unidades)) {
                        unidades.forEach(function(unidad) {
                            unidadSelect.append('<option value=\"' + unidad.id + '\">' + unidad.nombre + '</option>');
                        });
                    } else {
                        console.error('La respuesta no es un array:', unidades);
                        unidadSelect.append('<option value=\"\">Error al cargar unidades</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar unidades:', error);
                    unidadSelect.html('<option value=\"\">Error al cargar unidades</option>');
                }
            });
        }

        // Función para validar campos de vigencia
        function validarVigencia(input) {
            // Eliminar cualquier carácter que no sea dígito
            var value = input.value.replace(/\\D/g, '');
            
            // Limitar a 6 dígitos
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            
            // Actualizar el valor del campo
            input.value = value;
            
            // Agregar clase de error si no tiene 6 dígitos
            if (value.length !== 6) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        }

        // Función para validar duplicados en tiempo real
        function validarDuplicadosEnTiempoReal() {
            var codigosValidos = [];
            var duplicados = [];
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                
                if (codigo && sede && unidad) {
                    var codigoKey = codigo + '_' + sede + '_' + unidad;
                    if (codigosValidos.indexOf(codigoKey) !== -1) {
                        duplicados.push(codigo);
                        \$(this).find('input[name=\"codigos[]\"]').addClass('is-invalid');
                        \$(this).find('select[name=\"sedes[]\"]').addClass('is-invalid');
                        \$(this).find('select[name=\"unidades[]\"]').addClass('is-invalid');
                    } else {
                        codigosValidos.push(codigoKey);
                        \$(this).find('input[name=\"codigos[]\"]').removeClass('is-invalid');
                        \$(this).find('select[name=\"sedes[]\"]').removeClass('is-invalid');
                        \$(this).find('select[name=\"unidades[]\"]').removeClass('is-invalid');
                    }
                } else {
                    \$(this).find('input[name=\"codigos[]\"]').removeClass('is-invalid');
                    \$(this).find('select[name=\"sedes[]\"]').removeClass('is-invalid');
                    \$(this).find('select[name=\"unidades[]\"]').removeClass('is-invalid');
                }
            });
            
            return duplicados;
        }

        // Agregar eventos para validación en tiempo real
        \$(document).on('input change', '.codigo-row input[name=\"codigos[]\"], .codigo-row select[name=\"sedes[]\"], .codigo-row select[name=\"unidades[]\"]', function() {
            validarDuplicadosEnTiempoReal();
        });

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            row.find('input, select').removeClass('is-invalid');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarUnidadesPorSede(\$(this));
                validarDuplicadosEnTiempoReal();
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
            
            // Agregar eventos para validación en tiempo real
            row.find('input[name=\"codigos[]\"], select[name=\"unidades[]\"]').on('input change', function() {
                validarDuplicadosEnTiempoReal();
            });
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            cargarUnidadesPorSede(\$(this));
            validarDuplicadosEnTiempoReal();
        });

        // Cargar unidades iniciales si hay una sede seleccionada
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                cargarUnidadesPorSede(\$(this));
            }
        });

        // Cargar unidades para los códigos existentes después de un error
        ";
        // line 359
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "codigos", [], "any", true, true, false, 359) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["form_data"] ?? null), "codigos", [], "any", false, false, false, 359)) > 0))) {
            // line 360
            yield "        setTimeout(function() {
            \$('.codigo-row').each(function(index) {
                var sedeSelect = \$(this).find('select[name=\"sedes[]\"]');
                if (sedeSelect.val()) {
                    cargarUnidadesPorSede(sedeSelect);
                }
            });
        }, 500);
        ";
        }
        // line 369
        yield "
        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            e.preventDefault();
            
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            var codigosValidos = [];
            var duplicados = [];
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && unidad && vigenciaDesde) {
                    codigosCompletos = true;
                    
                    // Verificar duplicados en el formulario
                    var codigoKey = codigo + '_' + sede + '_' + unidad;
                    if (codigosValidos.indexOf(codigoKey) !== -1) {
                        duplicados.push(codigo);
                    } else {
                        codigosValidos.push(codigoKey);
                    }
                }
                
                // Validar formato de vigencia
                if (vigenciaDesde && vigenciaDesde.length !== 6) {
                    vigenciasValidas = false;
                    \$(this).find('input[name=\"vigencias_desde[]\"]').addClass('is-invalid');
                }
            });

            if (!codigosCompletos) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Debe completar al menos un código de carrera con todos sus datos'
                });
                return false;
            }
            
            if (!vigenciasValidas) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Los campos de vigencia deben tener exactamente 6 dígitos'
                });
                return false;
            }

            if (duplicados.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Códigos duplicados',
                    text: 'No se permiten códigos duplicados por sede y unidad. Códigos duplicados: ' + duplicados.join(', ')
                });
                return false;
            }

            // Si todo está bien, enviar el formulario
            this.submit();
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
        return "carreras/create.twig";
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
        return array (  577 => 369,  566 => 360,  564 => 359,  437 => 235,  428 => 228,  422 => 225,  417 => 222,  415 => 221,  410 => 218,  403 => 217,  388 => 206,  374 => 194,  367 => 189,  356 => 187,  352 => 186,  342 => 178,  331 => 176,  327 => 175,  299 => 149,  296 => 148,  290 => 147,  283 => 142,  274 => 139,  267 => 138,  263 => 137,  253 => 129,  244 => 126,  237 => 125,  233 => 124,  221 => 115,  210 => 107,  200 => 100,  193 => 95,  190 => 94,  185 => 93,  183 => 92,  170 => 82,  132 => 47,  128 => 46,  117 => 38,  113 => 37,  109 => 36,  98 => 28,  88 => 21,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Nueva Carrera - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <!-- Botón para ocultar/mostrar el panel lateral -->
    <button id=\"sidebarToggle\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
        <i class=\"fas fa-bars\"></i>
    </button>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Nueva Carrera</h1>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Datos de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"POST\" action=\"{{ app_url }}carreras/store\" id=\"form-carrera\" enctype=\"multipart/form-data\">
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" 
                                   value=\"{{ form_data.nombre|default('') }}\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"P\" {{ form_data.tipo_programa|default('') == 'P' ? 'selected' : '' }}>Pregrado</option>
                                <option value=\"G\" {{ form_data.tipo_programa|default('') == 'G' ? 'selected' : '' }}>Postgrado</option>
                                <option value=\"O\" {{ form_data.tipo_programa|default('') == 'O' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\" {{ form_data.estado|default('1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value=\"0\" {{ form_data.estado|default('1') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección 1.5: Libro de Carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-12\">
                        <div class=\"form-group\">
                            <label for=\"libro_carrera\" class=\"form-label\">Libro de Carrera (PDF)</label>
                            <input type=\"file\" class=\"form-control\" id=\"libro_carrera\" name=\"libro_carrera\" 
                                   accept=\".pdf\" max=\"10485760\">
                            <small class=\"form-text text-muted\">
                                <i class=\"fas fa-info-circle\"></i> 
                                Solo archivos PDF. Tamaño máximo: 10MB
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Sección 1.6: Imagen de la Carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"imagen_carrera\" class=\"form-label\">Imagen de la Carrera</label>
                            <input type=\"file\" class=\"form-control\" id=\"imagen_carrera\" name=\"imagen_carrera\" accept=\"image/*\">
                            <small class=\"form-text text-muted\">
                                <i class=\"fas fa-info-circle\"></i> Solo imágenes JPG, PNG o GIF. Tamaño recomendado: 1440x700px
                            </small>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"cantidad_semestres\" class=\"form-label\">Cantidad de Semestres *</label>
                            <input type=\"number\" class=\"form-control\" id=\"cantidad_semestres\" name=\"cantidad_semestres\" min=\"1\" max=\"20\" value=\"{{ form_data.cantidad_semestres|default(10) }}\" required>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Códigos de carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-12\">
                        <h6 class=\"mb-3\">Códigos de Carrera</h6>
                        <div id=\"codigos-container\">
                            {% if form_data.codigos is defined and form_data.codigos|length > 0 %}
                                {% for index, codigo in form_data.codigos %}
                                    {% if codigo is not empty %}
                                    <div class=\"row mb-3 codigo-row\">
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                                <input type=\"text\" class=\"form-control\" name=\"codigos[]\" 
                                                       value=\"{{ codigo }}\" required>
                                            </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                                <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                                       value=\"{{ form_data.vigencias_desde[index]|default('') }}\"
                                                       pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required>
                                            </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                            <div class=\"form-group\">
                                                <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                                <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                                       value=\"{{ form_data.vigencias_hasta[index]|default('999999') }}\"
                                                       pattern=\"\\d{6}\" title=\"Formato: AAAAMM\">
                                            </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                            <div class=\"form-group\">
                                                <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                                <select class=\"form-select\" name=\"sedes[]\" required>
                                                    <option value=\"\">Seleccione una sede</option>
                                                    {% for sede in sedes %}
                                                    <option value=\"{{ sede.id }}\" {{ form_data.sedes[index]|default('') == sede.id ? 'selected' : '' }}>
                                                        {{ sede.nombre }}
                                                    </option>
                                                    {% endfor %}
                                                </select>
                                            </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                            <div class=\"form-group\">
                                                <label for=\"unidades[]\" class=\"form-label\">Unidad *</label>
                                                <select class=\"form-select\" name=\"unidades[]\" required>
                                                    <option value=\"\">Seleccione una unidad</option>
                                                    {% for unidad in unidades %}
                                                    <option value=\"{{ unidad.id }}\" {{ form_data.unidades[index]|default('') == unidad.id ? 'selected' : '' }}>
                                                        {{ unidad.nombre }}
                                                    </option>
                                                    {% endfor %}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {% endif %}
                                {% endfor %}
                            {% else %}
                            <div class=\"row mb-3 codigo-row\">
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"codigos[]\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                               pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                               value=\"999999\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\">
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                        <select class=\"form-select\" name=\"sedes[]\" required>
                                            <option value=\"\">Seleccione una sede</option>
                                            {% for sede in sedes %}
                                            <option value=\"{{ sede.id }}\">{{ sede.nombre }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label for=\"unidades[]\" class=\"form-label\">Unidad *</label>
                                        <select class=\"form-select\" name=\"unidades[]\" required>
                                            <option value=\"\">Seleccione una unidad</option>
                                            {% for unidad in unidades %}
                                            <option value=\"{{ unidad.id }}\">{{ unidad.nombre }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {% endif %}
                        </div>
                        <button type=\"button\" class=\"btn btn-secondary btn-sm\" id=\"agregar-codigo\">
                            <i class=\"fas fa-plus\"></i> Agregar otro código
                        </button>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-12 d-flex gap-2\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-save\"></i> Guardar
                        </button>
                        <a href=\"{{ app_url }}carreras\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar error de sesión con SweetAlert2 si existe
        {% if session.error %}
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `{{ session.error|e('js') }}`
        });
        {% endif %}

        // Función para cargar unidades por sede
        function cargarUnidadesPorSede(sedeSelect) {
            var unidadSelect = sedeSelect.closest('.row').find('select[name=\"unidades[]\"]');
            unidadSelect.html('<option value=\"\">Cargando...</option>');
            
            \$.ajax({
                url: '{{ app_url }}api/unidades',
                method: 'GET',
                data: { sede_id: sedeSelect.val() },
                success: function(unidades) {
                    unidadSelect.html('<option value=\"\">Seleccione una unidad</option>');
                    if (Array.isArray(unidades)) {
                        unidades.forEach(function(unidad) {
                            unidadSelect.append('<option value=\"' + unidad.id + '\">' + unidad.nombre + '</option>');
                        });
                    } else {
                        console.error('La respuesta no es un array:', unidades);
                        unidadSelect.append('<option value=\"\">Error al cargar unidades</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar unidades:', error);
                    unidadSelect.html('<option value=\"\">Error al cargar unidades</option>');
                }
            });
        }

        // Función para validar campos de vigencia
        function validarVigencia(input) {
            // Eliminar cualquier carácter que no sea dígito
            var value = input.value.replace(/\\D/g, '');
            
            // Limitar a 6 dígitos
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            
            // Actualizar el valor del campo
            input.value = value;
            
            // Agregar clase de error si no tiene 6 dígitos
            if (value.length !== 6) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        }

        // Función para validar duplicados en tiempo real
        function validarDuplicadosEnTiempoReal() {
            var codigosValidos = [];
            var duplicados = [];
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                
                if (codigo && sede && unidad) {
                    var codigoKey = codigo + '_' + sede + '_' + unidad;
                    if (codigosValidos.indexOf(codigoKey) !== -1) {
                        duplicados.push(codigo);
                        \$(this).find('input[name=\"codigos[]\"]').addClass('is-invalid');
                        \$(this).find('select[name=\"sedes[]\"]').addClass('is-invalid');
                        \$(this).find('select[name=\"unidades[]\"]').addClass('is-invalid');
                    } else {
                        codigosValidos.push(codigoKey);
                        \$(this).find('input[name=\"codigos[]\"]').removeClass('is-invalid');
                        \$(this).find('select[name=\"sedes[]\"]').removeClass('is-invalid');
                        \$(this).find('select[name=\"unidades[]\"]').removeClass('is-invalid');
                    }
                } else {
                    \$(this).find('input[name=\"codigos[]\"]').removeClass('is-invalid');
                    \$(this).find('select[name=\"sedes[]\"]').removeClass('is-invalid');
                    \$(this).find('select[name=\"unidades[]\"]').removeClass('is-invalid');
                }
            });
            
            return duplicados;
        }

        // Agregar eventos para validación en tiempo real
        \$(document).on('input change', '.codigo-row input[name=\"codigos[]\"], .codigo-row select[name=\"sedes[]\"], .codigo-row select[name=\"unidades[]\"]', function() {
            validarDuplicadosEnTiempoReal();
        });

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            row.find('input, select').removeClass('is-invalid');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarUnidadesPorSede(\$(this));
                validarDuplicadosEnTiempoReal();
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
            
            // Agregar eventos para validación en tiempo real
            row.find('input[name=\"codigos[]\"], select[name=\"unidades[]\"]').on('input change', function() {
                validarDuplicadosEnTiempoReal();
            });
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            cargarUnidadesPorSede(\$(this));
            validarDuplicadosEnTiempoReal();
        });

        // Cargar unidades iniciales si hay una sede seleccionada
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                cargarUnidadesPorSede(\$(this));
            }
        });

        // Cargar unidades para los códigos existentes después de un error
        {% if form_data.codigos is defined and form_data.codigos|length > 0 %}
        setTimeout(function() {
            \$('.codigo-row').each(function(index) {
                var sedeSelect = \$(this).find('select[name=\"sedes[]\"]');
                if (sedeSelect.val()) {
                    cargarUnidadesPorSede(sedeSelect);
                }
            });
        }, 500);
        {% endif %}

        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            e.preventDefault();
            
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            var codigosValidos = [];
            var duplicados = [];
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && unidad && vigenciaDesde) {
                    codigosCompletos = true;
                    
                    // Verificar duplicados en el formulario
                    var codigoKey = codigo + '_' + sede + '_' + unidad;
                    if (codigosValidos.indexOf(codigoKey) !== -1) {
                        duplicados.push(codigo);
                    } else {
                        codigosValidos.push(codigoKey);
                    }
                }
                
                // Validar formato de vigencia
                if (vigenciaDesde && vigenciaDesde.length !== 6) {
                    vigenciasValidas = false;
                    \$(this).find('input[name=\"vigencias_desde[]\"]').addClass('is-invalid');
                }
            });

            if (!codigosCompletos) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Debe completar al menos un código de carrera con todos sus datos'
                });
                return false;
            }
            
            if (!vigenciasValidas) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Los campos de vigencia deben tener exactamente 6 dígitos'
                });
                return false;
            }

            if (duplicados.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Códigos duplicados',
                    text: 'No se permiten códigos duplicados por sede y unidad. Códigos duplicados: ' + duplicados.join(', ')
                });
                return false;
            }

            // Si todo está bien, enviar el formulario
            this.submit();
        });
    });
</script>
{% endblock %} ", "carreras/create.twig", "/var/www/html/biblioges/templates/carreras/create.twig");
    }
}
