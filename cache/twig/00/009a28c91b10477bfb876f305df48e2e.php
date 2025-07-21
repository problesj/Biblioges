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

/* carreras/edit.twig */
class __TwigTemplate_65823c3b242353f98e2fcd3f39e92de0 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/edit.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Editar Carrera - Sistema de Bibliografía";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Carrera</h1>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Datos de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"POST\" action=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 21), "html", null, true);
        yield "/update\" id=\"form-carrera\" enctype=\"multipart/form-data\">
                <!-- <input type=\"hidden\" name=\"_method\" value=\"PUT\"> -->
                
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 29), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"P\" ";
        // line 37
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 37) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                                <option value=\"G\" ";
        // line 38
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 38) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                                <option value=\"O\" ";
        // line 39
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 39) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\" ";
        // line 47
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 47) == 1)) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 48
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 48) == 0)) {
            yield "selected";
        }
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
                            ";
        // line 65
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 65)) {
            // line 66
            yield "                            <div class=\"mt-2\">
                                <div class=\"d-flex align-items-center gap-3\">
                                    <small class=\"text-success\">
                                        <i class=\"fas fa-check-circle\"></i> 
                                        Archivo actual: 
                                        <a href=\"";
            // line 71
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "url_libro", [], "any", false, false, false, 71), "html", null, true);
            yield "\" target=\"_blank\" class=\"text-decoration-none\">
                                            <i class=\"fas fa-file-pdf\"></i> Ver PDF actual
                                        </a>
                                    </small>
                                    <div class=\"form-check\">
                                        <input class=\"form-check-input\" type=\"checkbox\" id=\"eliminar_libro\" name=\"eliminar_libro\" value=\"1\">
                                        <label class=\"form-check-label text-danger\" for=\"eliminar_libro\">
                                            <i class=\"fas fa-trash\"></i> Eliminar archivo actual
                                        </label>
                                    </div>
                                </div>
                            </div>
                            ";
        }
        // line 84
        yield "                        </div>
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
                            ";
        // line 97
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 97)) {
            // line 98
            yield "                            <div class=\"mt-2\">
                                <img src=\"";
            // line 99
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 99), "html", null, true);
            yield "\" alt=\"Imagen actual\" style=\"max-width: 120px; max-height: 120px; border-radius: 8px; border: 1px solid #ccc;\">
                                <small class=\"d-block text-muted\">Imagen actual</small>
                                <div class=\"form-check mt-2\">
                                    <input class=\"form-check-input\" type=\"checkbox\" id=\"eliminar_imagen\" name=\"eliminar_imagen\" value=\"1\">
                                    <label class=\"form-check-label text-danger\" for=\"eliminar_imagen\">
                                        <i class=\"fas fa-trash\"></i> Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                            ";
        }
        // line 109
        yield "                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"cantidad_semestres\" class=\"form-label\">Cantidad de Semestres *</label>
                            <input type=\"number\" class=\"form-control\" id=\"cantidad_semestres\" name=\"cantidad_semestres\" min=\"1\" max=\"20\" value=\"";
        // line 114
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 114), 10)) : (10)), "html", null, true);
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
        // line 124
        $context["codigos"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos", [], "any", false, false, false, 124), "|");
        // line 125
        yield "                            ";
        $context["vigencias_desde"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 125), "|");
        // line 126
        yield "                            ";
        $context["vigencias_hasta"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 126), "|");
        // line 127
        yield "                            ";
        $context["sedes_ids"] = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes_ids", [], "any", false, false, false, 127);
        // line 128
        yield "                            ";
        $context["unidades_ids"] = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades_ids", [], "any", false, false, false, 128);
        // line 129
        yield "                            ";
        $context["codigos_ids"] = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_ids", [], "any", false, false, false, 129);
        // line 130
        yield "                            
                            ";
        // line 131
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["codigos"] ?? null)) - 1)));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 132
            yield "                            <div class=\"row mb-3 codigo-row\" ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["codigos_ids"] ?? null), $context["i"], [], "array", true, true, false, 132)) {
                yield "data-codigo-id=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["codigos_ids"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
                yield "\"";
            }
            yield ">
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"codigos[]\" value=\"";
            // line 136
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["codigos"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
            yield "\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                               value=\"";
            // line 143
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = ($context["vigencias_desde"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[$context["i"]] ?? null) : null), "html", null, true);
            yield "\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required
                                               placeholder=\"AAAAMM\">
                                        <div class=\"invalid-feedback\">El formato debe ser AAAAMM (ej: 202401)</div>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                               value=\"";
            // line 152
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = ($context["vigencias_hasta"] ?? null)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[$context["i"]] ?? null) : null), "html", null, true);
            yield "\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\"
                                               placeholder=\"AAAAMM\">
                                        <div class=\"invalid-feedback\">El formato debe ser AAAAMM (ej: 202412)</div>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                        <select class=\"form-select\" name=\"sedes[]\" required>
                                            <option value=\"\">Seleccione una sede</option>
                                            ";
            // line 162
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 163
                yield "                                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 163), "html", null, true);
                yield "\" ";
                if (((($_v4 = ($context["sedes_ids"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[$context["i"]] ?? null) : null) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 163))) {
                    yield "selected";
                }
                yield ">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 163), "html", null, true);
                yield "</option>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 165
            yield "                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label class=\"form-label\">Unidad *</label>
                                        <select class=\"form-select\" name=\"unidades[]\" required>
                                            <option value=\"\">Seleccione una unidad</option>
                                            ";
            // line 173
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
                // line 174
                yield "                                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 174), "html", null, true);
                yield "\" 
                                                    ";
                // line 175
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["unidades_ids"] ?? null), $context["i"], [], "array", true, true, false, 175) && ((($_v5 = ($context["unidades_ids"] ?? null)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5[$context["i"]] ?? null) : null) == CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 175)))) {
                    yield "selected";
                }
                yield ">
                                                ";
                // line 176
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 176), "html", null, true);
                yield "
                                            </option>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 179
            yield "                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-1 d-flex align-items-end\">
                                    <div class=\"form-group mb-0\">
                                        <button type=\"button\" class=\"btn btn-danger btn-sm eliminar-codigo\" title=\"Eliminar código\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 191
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
        // line 203
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

    // line 214
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 215
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para cargar unidades por sede
        function cargarUnidadesPorSede(sedeSelect, unidadSeleccionada = null) {
            var unidadSelect = sedeSelect.closest('.row').find('select[name=\"unidades[]\"]');
            unidadSelect.html('<option value=\"\">Cargando...</option>');
            
            \$.ajax({
                url: '";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "api/unidades',
                method: 'GET',
                data: { sede_id: sedeSelect.val() },
                success: function(unidades) {
                    unidadSelect.html('<option value=\"\">Seleccione una unidad</option>');
                    if (Array.isArray(unidades)) {
                        unidades.forEach(function(unidad) {
                            var selected = (unidadSeleccionada && unidadSeleccionada == unidad.id) ? 'selected' : '';
                            unidadSelect.append('<option value=\"' + unidad.id + '\" ' + selected + '>' + unidad.nombre + '</option>');
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
            
            // Validar formato AAAAMM
            if (value.length === 6) {
                var anio = parseInt(value.substring(0, 4));
                var mes = parseInt(value.substring(4, 6));
                
                if (mes < 1 || mes > 12) {
                    input.classList.add('is-invalid');
                    return;
                }
                
                input.classList.remove('is-invalid');
            } else {
                input.classList.add('is-invalid');
            }
        }

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarUnidadesPorSede(\$(this));
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
            
            // Agregar evento de eliminación a la nueva fila
            row.find('.eliminar-codigo').click(function() {
                eliminarCodigo(\$(this));
            });
        });

        // Eliminar código de carrera
        function eliminarCodigo(button) {
            var row = button.closest('.codigo-row');
            var codigoId = row.data('codigo-id');
            
            if (!codigoId) {
                // Es una fila nueva, solo eliminar del DOM
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: '¿Está seguro de que desea eliminar este código de carrera?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            row.remove();
                        }
                    });
                } else {
                    if (confirm('¿Está seguro de que desea eliminar este código de carrera?')) {
                        row.remove();
                    }
                }
                return;
            }
            
            // Es un código existente, eliminar del backend
            var carreraId = ";
        // line 328
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 328), "html", null, true);
        yield ";
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Está seguro de que desea eliminar este código de carrera?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar loading
                        Swal.fire({
                            title: 'Eliminando...',
                            text: 'Por favor espere',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        \$.ajax({
                            url: '";
        // line 353
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/' + carreraId + '/codigos/' + codigoId + '/delete',
                            method: 'POST',
                            success: function(response) {
                                if (response.success) {
                                    row.remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: response.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al eliminar código:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al eliminar el código de carrera'
                                });
                            }
                        });
                    }
                });
            } else {
                // Fallback para navegadores sin SweetAlert2
                if (confirm('¿Está seguro de que desea eliminar este código de carrera?')) {
                    \$.ajax({
                        url: '";
        // line 386
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/' + carreraId + '/codigos/' + codigoId + '/delete',
                        method: 'POST',
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                alert(response.message);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar código:', error);
                            alert('Error al eliminar el código de carrera');
                        }
                    });
                }
            }
        }

        // Agregar evento de eliminación a todas las filas existentes
        \$('.eliminar-codigo').click(function() {
            eliminarCodigo(\$(this));
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            var unidadSeleccionada = \$(this).closest('.row').find('select[name=\"unidades[]\"]').val();
            cargarUnidadesPorSede(\$(this), unidadSeleccionada);
        });

        // Cargar unidades para las sedes ya seleccionadas al cargar la página
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                var unidadSeleccionada = \$(this).closest('.row').find('select[name=\"unidades[]\"]').val();
                cargarUnidadesPorSede(\$(this), unidadSeleccionada);
            }
        });

        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Manejar la eliminación del archivo PDF
        \$('#eliminar_libro').change(function() {
            var isChecked = \$(this).is(':checked');
            var fileInput = \$('#libro_carrera');
            
            if (isChecked) {
                // Deshabilitar el campo de archivo
                fileInput.prop('disabled', true);
                fileInput.val('');
            } else {
                // Habilitar el campo de archivo
                fileInput.prop('disabled', false);
            }
        });

        // Manejar la eliminación de la imagen
        \$('#eliminar_imagen').change(function() {
            var isChecked = \$(this).is(':checked');
            var fileInput = \$('#imagen_carrera');
            
            if (isChecked) {
                // Deshabilitar el campo de archivo
                fileInput.prop('disabled', true);
                fileInput.val('');
            } else {
                // Habilitar el campo de archivo
                fileInput.prop('disabled', false);
            }
        });

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            // Validar eliminación de archivo
            var eliminarLibro = \$('#eliminar_libro').is(':checked');
            var eliminarImagen = \$('#eliminar_imagen').is(':checked');

            if (eliminarLibro) {
                e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Eliminar archivo?',
                        text: '¿Está seguro de que desea eliminar el archivo PDF actual?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si confirma, enviar el formulario
                            \$('#form-carrera')[0].submit();
                        } else {
                            // Si cancela, desmarcar el checkbox y habilitar el campo
                            \$('#eliminar_libro').prop('checked', false);
                            \$('#libro_carrera').prop('disabled', false);
                        }
                    });
                    return false;
                } else {
                    // Fallback para navegadores sin SweetAlert2
                    var confirmacion = confirm('¿Está seguro de que desea eliminar el archivo PDF actual?');
                    if (!confirmacion) {
                        \$('#eliminar_libro').prop('checked', false);
                        \$('#libro_carrera').prop('disabled', false);
                        return false;
                    }
                }
            }

            if (eliminarImagen) {
                e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Eliminar imagen?',
                        text: '¿Está seguro de que desea eliminar la imagen actual de la carrera?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si confirma, enviar el formulario
                            \$('#form-carrera')[0].submit();
                        } else {
                            // Si cancela, desmarcar el checkbox y habilitar el campo
                            \$('#eliminar_imagen').prop('checked', false);
                            \$('#imagen_carrera').prop('disabled', false);
                        }
                    });
                    return false;
                } else {
                    // Fallback para navegadores sin SweetAlert2
                    var confirmacion = confirm('¿Está seguro de que desea eliminar la imagen actual de la carrera?');
                    if (!confirmacion) {
                        \$('#eliminar_imagen').prop('checked', false);
                        \$('#imagen_carrera').prop('disabled', false);
                        return false;
                    }
                }
            }
            
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && unidad && vigenciaDesde) {
                    codigosCompletos = true;
                }
                
                // Validar formato de vigencia
                if (vigenciaDesde && vigenciaDesde.length !== 6) {
                    vigenciasValidas = false;
                    \$(this).find('input[name=\"vigencias_desde[]\"]').addClass('is-invalid');
                }
            });

            if (!codigosCompletos) {
                e.preventDefault();
                alert('Debe completar al menos un código de carrera con todos sus datos');
                return false;
            }
            
            if (!vigenciasValidas) {
                e.preventDefault();
                alert('Los campos de vigencia deben tener exactamente 6 dígitos');
                return false;
            }

            // Si todo está bien, permitir el envío normal del formulario
            return true;
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
        return "carreras/edit.twig";
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
        return array (  604 => 386,  568 => 353,  540 => 328,  432 => 223,  422 => 215,  415 => 214,  400 => 203,  386 => 191,  369 => 179,  360 => 176,  354 => 175,  349 => 174,  345 => 173,  335 => 165,  320 => 163,  316 => 162,  303 => 152,  291 => 143,  281 => 136,  269 => 132,  265 => 131,  262 => 130,  259 => 129,  256 => 128,  253 => 127,  250 => 126,  247 => 125,  245 => 124,  232 => 114,  225 => 109,  211 => 99,  208 => 98,  206 => 97,  191 => 84,  174 => 71,  167 => 66,  165 => 65,  143 => 48,  137 => 47,  124 => 39,  118 => 38,  112 => 37,  101 => 29,  88 => 21,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Editar Carrera - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <!-- Botón para ocultar/mostrar el panel lateral -->
    <button id=\"sidebarToggle\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
        <i class=\"fas fa-bars\"></i>
    </button>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Editar Carrera</h1>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Datos de la Carrera</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"POST\" action=\"{{ app_url }}carreras/{{ carrera.id }}/update\" id=\"form-carrera\" enctype=\"multipart/form-data\">
                <!-- <input type=\"hidden\" name=\"_method\" value=\"PUT\"> -->
                
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ carrera.nombre }}\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"P\" {% if carrera.tipo_programa == 'P' %}selected{% endif %}>Pregrado</option>
                                <option value=\"G\" {% if carrera.tipo_programa == 'G' %}selected{% endif %}>Postgrado</option>
                                <option value=\"O\" {% if carrera.tipo_programa == 'O' %}selected{% endif %}>Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\" {% if carrera.estado == 1 %}selected{% endif %}>Activo</option>
                                <option value=\"0\" {% if carrera.estado == 0 %}selected{% endif %}>Inactivo</option>
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
                            {% if carrera.url_libro %}
                            <div class=\"mt-2\">
                                <div class=\"d-flex align-items-center gap-3\">
                                    <small class=\"text-success\">
                                        <i class=\"fas fa-check-circle\"></i> 
                                        Archivo actual: 
                                        <a href=\"{{ app_url }}{{ carrera.url_libro }}\" target=\"_blank\" class=\"text-decoration-none\">
                                            <i class=\"fas fa-file-pdf\"></i> Ver PDF actual
                                        </a>
                                    </small>
                                    <div class=\"form-check\">
                                        <input class=\"form-check-input\" type=\"checkbox\" id=\"eliminar_libro\" name=\"eliminar_libro\" value=\"1\">
                                        <label class=\"form-check-label text-danger\" for=\"eliminar_libro\">
                                            <i class=\"fas fa-trash\"></i> Eliminar archivo actual
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {% endif %}
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
                            {% if carrera.imagen_url %}
                            <div class=\"mt-2\">
                                <img src=\"{{ app_url }}{{ carrera.imagen_url }}\" alt=\"Imagen actual\" style=\"max-width: 120px; max-height: 120px; border-radius: 8px; border: 1px solid #ccc;\">
                                <small class=\"d-block text-muted\">Imagen actual</small>
                                <div class=\"form-check mt-2\">
                                    <input class=\"form-check-input\" type=\"checkbox\" id=\"eliminar_imagen\" name=\"eliminar_imagen\" value=\"1\">
                                    <label class=\"form-check-label text-danger\" for=\"eliminar_imagen\">
                                        <i class=\"fas fa-trash\"></i> Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                            {% endif %}
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"cantidad_semestres\" class=\"form-label\">Cantidad de Semestres *</label>
                            <input type=\"number\" class=\"form-control\" id=\"cantidad_semestres\" name=\"cantidad_semestres\" min=\"1\" max=\"20\" value=\"{{ carrera.cantidad_semestres|default(10) }}\" required>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Códigos de carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-12\">
                        <h6 class=\"mb-3\">Códigos de Carrera</h6>
                        <div id=\"codigos-container\">
                            {% set codigos = carrera.codigos|split('|') %}
                            {% set vigencias_desde = carrera.vigencias_desde|split('|') %}
                            {% set vigencias_hasta = carrera.vigencias_hasta|split('|') %}
                            {% set sedes_ids = carrera.sedes_ids %}
                            {% set unidades_ids = carrera.unidades_ids %}
                            {% set codigos_ids = carrera.codigos_ids %}
                            
                            {% for i in 0..(codigos|length - 1) %}
                            <div class=\"row mb-3 codigo-row\" {% if codigos_ids[i] is defined %}data-codigo-id=\"{{ codigos_ids[i] }}\"{% endif %}>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"codigos[]\" class=\"form-label\">Código *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"codigos[]\" value=\"{{ codigos[i] }}\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_desde[]\" class=\"form-label\">Vigencia Desde *</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_desde[]\" 
                                               value=\"{{ vigencias_desde[i] }}\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\" required
                                               placeholder=\"AAAAMM\">
                                        <div class=\"invalid-feedback\">El formato debe ser AAAAMM (ej: 202401)</div>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"vigencias_hasta[]\" class=\"form-label\">Vigencia Hasta</label>
                                        <input type=\"text\" class=\"form-control\" name=\"vigencias_hasta[]\" 
                                               value=\"{{ vigencias_hasta[i] }}\" pattern=\"\\d{6}\" title=\"Formato: AAAAMM\"
                                               placeholder=\"AAAAMM\">
                                        <div class=\"invalid-feedback\">El formato debe ser AAAAMM (ej: 202412)</div>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label for=\"sedes[]\" class=\"form-label\">Sede *</label>
                                        <select class=\"form-select\" name=\"sedes[]\" required>
                                            <option value=\"\">Seleccione una sede</option>
                                            {% for sede in sedes %}
                                            <option value=\"{{ sede.id }}\" {% if sedes_ids[i] == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-2\">
                                    <div class=\"form-group\">
                                        <label class=\"form-label\">Unidad *</label>
                                        <select class=\"form-select\" name=\"unidades[]\" required>
                                            <option value=\"\">Seleccione una unidad</option>
                                            {% for unidad in unidades %}
                                            <option value=\"{{ unidad.id }}\" 
                                                    {% if unidades_ids[i] is defined and unidades_ids[i] == unidad.id %}selected{% endif %}>
                                                {{ unidad.nombre }}
                                            </option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-1 d-flex align-items-end\">
                                    <div class=\"form-group mb-0\">
                                        <button type=\"button\" class=\"btn btn-danger btn-sm eliminar-codigo\" title=\"Eliminar código\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {% endfor %}
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
        // Función para cargar unidades por sede
        function cargarUnidadesPorSede(sedeSelect, unidadSeleccionada = null) {
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
                            var selected = (unidadSeleccionada && unidadSeleccionada == unidad.id) ? 'selected' : '';
                            unidadSelect.append('<option value=\"' + unidad.id + '\" ' + selected + '>' + unidad.nombre + '</option>');
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
            
            // Validar formato AAAAMM
            if (value.length === 6) {
                var anio = parseInt(value.substring(0, 4));
                var mes = parseInt(value.substring(4, 6));
                
                if (mes < 1 || mes > 12) {
                    input.classList.add('is-invalid');
                    return;
                }
                
                input.classList.remove('is-invalid');
            } else {
                input.classList.add('is-invalid');
            }
        }

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarUnidadesPorSede(\$(this));
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
            
            // Agregar evento de eliminación a la nueva fila
            row.find('.eliminar-codigo').click(function() {
                eliminarCodigo(\$(this));
            });
        });

        // Eliminar código de carrera
        function eliminarCodigo(button) {
            var row = button.closest('.codigo-row');
            var codigoId = row.data('codigo-id');
            
            if (!codigoId) {
                // Es una fila nueva, solo eliminar del DOM
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: '¿Está seguro de que desea eliminar este código de carrera?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            row.remove();
                        }
                    });
                } else {
                    if (confirm('¿Está seguro de que desea eliminar este código de carrera?')) {
                        row.remove();
                    }
                }
                return;
            }
            
            // Es un código existente, eliminar del backend
            var carreraId = {{ carrera.id }};
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Está seguro de que desea eliminar este código de carrera?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar loading
                        Swal.fire({
                            title: 'Eliminando...',
                            text: 'Por favor espere',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        \$.ajax({
                            url: '{{ app_url }}carreras/' + carreraId + '/codigos/' + codigoId + '/delete',
                            method: 'POST',
                            success: function(response) {
                                if (response.success) {
                                    row.remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: response.message
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al eliminar código:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al eliminar el código de carrera'
                                });
                            }
                        });
                    }
                });
            } else {
                // Fallback para navegadores sin SweetAlert2
                if (confirm('¿Está seguro de que desea eliminar este código de carrera?')) {
                    \$.ajax({
                        url: '{{ app_url }}carreras/' + carreraId + '/codigos/' + codigoId + '/delete',
                        method: 'POST',
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                                alert(response.message);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar código:', error);
                            alert('Error al eliminar el código de carrera');
                        }
                    });
                }
            }
        }

        // Agregar evento de eliminación a todas las filas existentes
        \$('.eliminar-codigo').click(function() {
            eliminarCodigo(\$(this));
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            var unidadSeleccionada = \$(this).closest('.row').find('select[name=\"unidades[]\"]').val();
            cargarUnidadesPorSede(\$(this), unidadSeleccionada);
        });

        // Cargar unidades para las sedes ya seleccionadas al cargar la página
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                var unidadSeleccionada = \$(this).closest('.row').find('select[name=\"unidades[]\"]').val();
                cargarUnidadesPorSede(\$(this), unidadSeleccionada);
            }
        });

        // Toggle del panel lateral
        \$('#sidebarToggle').click(function() {
            \$('body').toggleClass('sidebar-toggled');
            \$('.sidebar').toggleClass('toggled');
            if (\$('.sidebar').hasClass('toggled')) {
                \$('.sidebar .collapse').collapse('hide');
            }
        });

        // Manejar la eliminación del archivo PDF
        \$('#eliminar_libro').change(function() {
            var isChecked = \$(this).is(':checked');
            var fileInput = \$('#libro_carrera');
            
            if (isChecked) {
                // Deshabilitar el campo de archivo
                fileInput.prop('disabled', true);
                fileInput.val('');
            } else {
                // Habilitar el campo de archivo
                fileInput.prop('disabled', false);
            }
        });

        // Manejar la eliminación de la imagen
        \$('#eliminar_imagen').change(function() {
            var isChecked = \$(this).is(':checked');
            var fileInput = \$('#imagen_carrera');
            
            if (isChecked) {
                // Deshabilitar el campo de archivo
                fileInput.prop('disabled', true);
                fileInput.val('');
            } else {
                // Habilitar el campo de archivo
                fileInput.prop('disabled', false);
            }
        });

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            // Validar eliminación de archivo
            var eliminarLibro = \$('#eliminar_libro').is(':checked');
            var eliminarImagen = \$('#eliminar_imagen').is(':checked');

            if (eliminarLibro) {
                e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Eliminar archivo?',
                        text: '¿Está seguro de que desea eliminar el archivo PDF actual?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si confirma, enviar el formulario
                            \$('#form-carrera')[0].submit();
                        } else {
                            // Si cancela, desmarcar el checkbox y habilitar el campo
                            \$('#eliminar_libro').prop('checked', false);
                            \$('#libro_carrera').prop('disabled', false);
                        }
                    });
                    return false;
                } else {
                    // Fallback para navegadores sin SweetAlert2
                    var confirmacion = confirm('¿Está seguro de que desea eliminar el archivo PDF actual?');
                    if (!confirmacion) {
                        \$('#eliminar_libro').prop('checked', false);
                        \$('#libro_carrera').prop('disabled', false);
                        return false;
                    }
                }
            }

            if (eliminarImagen) {
                e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Eliminar imagen?',
                        text: '¿Está seguro de que desea eliminar la imagen actual de la carrera?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si confirma, enviar el formulario
                            \$('#form-carrera')[0].submit();
                        } else {
                            // Si cancela, desmarcar el checkbox y habilitar el campo
                            \$('#eliminar_imagen').prop('checked', false);
                            \$('#imagen_carrera').prop('disabled', false);
                        }
                    });
                    return false;
                } else {
                    // Fallback para navegadores sin SweetAlert2
                    var confirmacion = confirm('¿Está seguro de que desea eliminar la imagen actual de la carrera?');
                    if (!confirmacion) {
                        \$('#eliminar_imagen').prop('checked', false);
                        \$('#imagen_carrera').prop('disabled', false);
                        return false;
                    }
                }
            }
            
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var unidad = \$(this).find('select[name=\"unidades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && unidad && vigenciaDesde) {
                    codigosCompletos = true;
                }
                
                // Validar formato de vigencia
                if (vigenciaDesde && vigenciaDesde.length !== 6) {
                    vigenciasValidas = false;
                    \$(this).find('input[name=\"vigencias_desde[]\"]').addClass('is-invalid');
                }
            });

            if (!codigosCompletos) {
                e.preventDefault();
                alert('Debe completar al menos un código de carrera con todos sus datos');
                return false;
            }
            
            if (!vigenciasValidas) {
                e.preventDefault();
                alert('Los campos de vigencia deben tener exactamente 6 dígitos');
                return false;
            }

            // Si todo está bien, permitir el envío normal del formulario
            return true;
        });
    });
</script>
{% endblock %} ", "carreras/edit.twig", "/var/www/html/biblioges/templates/carreras/edit.twig");
    }
}
