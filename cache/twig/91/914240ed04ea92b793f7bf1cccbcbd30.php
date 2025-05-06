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
        yield "carreras/store\" id=\"form-carrera\">
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"P\">Pregrado</option>
                                <option value=\"G\">Postgrado</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Códigos de carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-12\">
                        <h6 class=\"mb-3\">Códigos de Carrera</h6>
                        <div id=\"codigos-container\">
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
                                            ";
        // line 81
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 82
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 82), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 82), "html", null, true);
            yield "</option>
                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 84
        yield "                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label for=\"facultades[]\" class=\"form-label\">Facultad *</label>
                                        <select class=\"form-select\" name=\"facultades[]\" required>
                                            <option value=\"\">Seleccione una facultad</option>
                                            ";
        // line 92
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["facultades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["facultad"]) {
            // line 93
            yield "                                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 93), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 93), "html", null, true);
            yield "</option>
                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['facultad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 95
        yield "                                        </select>
                                    </div>
                                </div>
                            </div>
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
                        <a href=\"";
        // line 111
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

    // line 122
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 123
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para cargar facultades
        function cargarFacultades(sedeSelect) {
            var sedeId = sedeSelect.val();
            var facultadSelect = sedeSelect.closest('.row').find('select[name=\"facultades[]\"]');
            
            if (sedeId) {
                \$.ajax({
                    url: '";
        // line 132
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/facultades',
                    method: 'GET',
                    data: { sede_id: sedeId },
                    dataType: 'json',
                    success: function(facultades) {
                        if (Array.isArray(facultades)) {
                            facultadSelect.empty();
                            facultadSelect.append('<option value=\"\">Seleccione una facultad</option>');
                            facultades.forEach(function(facultad) {
                                facultadSelect.append(`<option value=\"\${facultad.id}\">\${facultad.nombre}</option>`);
                            });
                        } else {
                            console.error('La respuesta no es un array:', facultades);
                            facultadSelect.empty();
                            facultadSelect.append('<option value=\"\">Error al cargar facultades</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar facultades:', error);
                        console.error('Estado:', status);
                        console.error('Respuesta:', xhr.responseText);
                        facultadSelect.empty();
                        facultadSelect.append('<option value=\"\">Error al cargar facultades</option>');
                    }
                });
            } else {
                facultadSelect.empty();
                facultadSelect.append('<option value=\"\">Seleccione una facultad</option>');
            }
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

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarFacultades(\$(this));
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            cargarFacultades(\$(this));
        });

        // Cargar facultades iniciales si hay una sede seleccionada
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                cargarFacultades(\$(this));
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

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var facultad = \$(this).find('select[name=\"facultades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && facultad && vigenciaDesde) {
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
        return array (  242 => 132,  231 => 123,  224 => 122,  209 => 111,  191 => 95,  180 => 93,  176 => 92,  166 => 84,  155 => 82,  151 => 81,  88 => 21,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
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
            <form method=\"POST\" action=\"{{ app_url }}carreras/store\" id=\"form-carrera\">
                <!-- Sección 1: Datos básicos -->
                <div class=\"row mb-4\">
                    <div class=\"col-md-6\">
                        <div class=\"form-group\">
                            <label for=\"nombre\" class=\"form-label\">Nombre de la Carrera *</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa *</label>
                            <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\" required>
                                <option value=\"P\">Pregrado</option>
                                <option value=\"G\">Postgrado</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\" class=\"form-label\">Estado</label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"1\">Activo</option>
                                <option value=\"0\">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Códigos de carrera -->
                <div class=\"row mb-4\">
                    <div class=\"col-12\">
                        <h6 class=\"mb-3\">Códigos de Carrera</h6>
                        <div id=\"codigos-container\">
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
                                        <label for=\"facultades[]\" class=\"form-label\">Facultad *</label>
                                        <select class=\"form-select\" name=\"facultades[]\" required>
                                            <option value=\"\">Seleccione una facultad</option>
                                            {% for facultad in facultades %}
                                            <option value=\"{{ facultad.id }}\">{{ facultad.nombre }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                            </div>
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
        // Función para cargar facultades
        function cargarFacultades(sedeSelect) {
            var sedeId = sedeSelect.val();
            var facultadSelect = sedeSelect.closest('.row').find('select[name=\"facultades[]\"]');
            
            if (sedeId) {
                \$.ajax({
                    url: '{{ app_url }}carreras/facultades',
                    method: 'GET',
                    data: { sede_id: sedeId },
                    dataType: 'json',
                    success: function(facultades) {
                        if (Array.isArray(facultades)) {
                            facultadSelect.empty();
                            facultadSelect.append('<option value=\"\">Seleccione una facultad</option>');
                            facultades.forEach(function(facultad) {
                                facultadSelect.append(`<option value=\"\${facultad.id}\">\${facultad.nombre}</option>`);
                            });
                        } else {
                            console.error('La respuesta no es un array:', facultades);
                            facultadSelect.empty();
                            facultadSelect.append('<option value=\"\">Error al cargar facultades</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar facultades:', error);
                        console.error('Estado:', status);
                        console.error('Respuesta:', xhr.responseText);
                        facultadSelect.empty();
                        facultadSelect.append('<option value=\"\">Error al cargar facultades</option>');
                    }
                });
            } else {
                facultadSelect.empty();
                facultadSelect.append('<option value=\"\">Seleccione una facultad</option>');
            }
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

        // Clonar fila de código
        \$('#agregar-codigo').click(function() {
            var row = \$('.codigo-row:first').clone();
            row.find('input').val('');
            row.find('select').val('');
            \$('#codigos-container').append(row);
            
            // Agregar evento de cambio de sede a la nueva fila
            row.find('select[name=\"sedes[]\"]').change(function() {
                cargarFacultades(\$(this));
            });
            
            // Agregar validación a los campos de vigencia
            row.find('input[name^=\"vigencias_\"]').on('input', function() {
                validarVigencia(this);
            });
        });

        // Agregar validación a los campos de vigencia existentes
        \$('input[name^=\"vigencias_\"]').on('input', function() {
            validarVigencia(this);
        });

        // Agregar evento de cambio de sede a todas las filas existentes
        \$('select[name=\"sedes[]\"]').change(function() {
            cargarFacultades(\$(this));
        });

        // Cargar facultades iniciales si hay una sede seleccionada
        \$('select[name=\"sedes[]\"]').each(function() {
            if (\$(this).val()) {
                cargarFacultades(\$(this));
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

        // Manejar el envío del formulario
        \$('#form-carrera').on('submit', function(e) {
            // Validar que al menos un código esté completo
            var codigosCompletos = false;
            var vigenciasValidas = true;
            
            \$('.codigo-row').each(function() {
                var codigo = \$(this).find('input[name=\"codigos[]\"]').val();
                var sede = \$(this).find('select[name=\"sedes[]\"]').val();
                var facultad = \$(this).find('select[name=\"facultades[]\"]').val();
                var vigenciaDesde = \$(this).find('input[name=\"vigencias_desde[]\"]').val();
                
                if (codigo && sede && facultad && vigenciaDesde) {
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
{% endblock %} ", "carreras/create.twig", "/var/www/html/biblioges/templates/carreras/create.twig");
    }
}
