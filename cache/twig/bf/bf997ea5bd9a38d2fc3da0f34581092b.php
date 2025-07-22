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

/* unidades/index.twig */
class __TwigTemplate_e4b79d94e7baaca22a0ffb9e198d65e1 extends Template
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
            'current_page' => [$this, 'block_current_page'],
            'stylesheets' => [$this, 'block_stylesheets'],
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
        $this->parent = $this->loadTemplate("base.twig", "unidades/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Unidades - Sistema de Bibliografía";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_current_page(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "unidades";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
";
        yield from [];
    }

    // line 11
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 12
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Unidades</h1>
        <a href=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Unidad
        </a>
    </div>

    ";
        // line 20
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 20)) {
            // line 21
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 23), "icon", [], "any", false, false, false, 23), "html", null, true);
            yield "',
            title: '";
            // line 24
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 24), "title", [], "any", false, false, false, 24);
            yield "',
            text: '";
            // line 25
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 25), "text", [], "any", false, false, false, 25);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 30
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 43
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 43), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 43) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 43))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 43), "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        yield "                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 51
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 51) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 52
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 52) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de unidades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Unidades</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\" id=\"unidades-table\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Sede</th>
                                    <th>Unidad Padre</th>
                                    <th>Unidades Hijas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
            // line 91
            yield "                                <tr>
                                    <td>";
            // line 92
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "codigo", [], "any", false, false, false, 92), "html", null, true);
            yield "</td>
                                    <td>";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 93), "html", null, true);
            yield "</td>
                                    <td>";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "sede_nombre", [], "any", false, false, false, 94), "html", null, true);
            yield "</td>
                                    <td>
                                        ";
            // line 96
            if (CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "unidad_padre_nombre", [], "any", false, false, false, 96)) {
                // line 97
                yield "                                            <span class=\"badge bg-info\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "unidad_padre_nombre", [], "any", false, false, false, 97), "html", null, true);
                yield "</span>
                                        ";
            } else {
                // line 99
                yield "                                            <span class=\"text-muted\">Sin unidad padre</span>
                                        ";
            }
            // line 101
            yield "                                    </td>
                                    <td>
                                        ";
            // line 103
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "cantidad_hijas", [], "any", false, false, false, 103) > 0)) {
                // line 104
                yield "                                            <span class=\"badge bg-warning\" title=\"Ver unidades hijas\" onclick=\"mostrarUnidadesHijas(";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 104), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 104), "html", null, true);
                yield "')\" style=\"cursor: pointer;\">
                                                ";
                // line 105
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "cantidad_hijas", [], "any", false, false, false, 105), "html", null, true);
                yield " unidad(es)
                                            </span>
                                        ";
            } else {
                // line 108
                yield "                                            <span class=\"text-muted\">Sin unidades hijas</span>
                                        ";
            }
            // line 110
            yield "                                    </td>
                                    <td>
                                        ";
            // line 112
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "estado", [], "any", false, false, false, 112) == "1")) {
                // line 113
                yield "                                            <span class=\"badge bg-success\">Activo</span>
                                        ";
            } else {
                // line 115
                yield "                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        ";
            }
            // line 117
            yield "                                    </td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"";
            // line 120
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "unidades/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 120), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                <i class=\"fas fa-eye\"></i>
                                            </a>
                                            <a href=\"";
            // line 123
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "unidades/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 123), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteUnidad(";
            // line 126
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 126), "html", null, true);
            yield ", '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 126), "html", null, true);
            yield "')\" title=\"Eliminar\">
                                                <i class=\"fas fa-trash\"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 132
        if (!$context['_iterated']) {
            // line 133
            yield "                                <tr>
                                    <td colspan=\"7\" class=\"text-center\">No hay unidades registradas</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 137
        yield "                            </tbody>
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

    // line 147
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 148
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#unidades-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]],
            \"pageLength\": 10,
            \"columnDefs\": [
                {
                    \"targets\": [6], // Columna de acciones
                    \"orderable\": false,
                    \"searchable\": false
                },
                {
                    \"targets\": [4], // Columna de unidades hijas
                    \"orderable\": false,
                    \"searchable\": false
                }
            ]
        });

        // Mostrar alertas de SweetAlert2 si existen en la sesión
        ";
        // line 177
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 177)) {
            // line 178
            yield "            Swal.fire({
                icon: '";
            // line 179
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 179), "icon", [], "any", false, false, false, 179), "html", null, true);
            yield "',
                title: '";
            // line 180
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 180), "title", [], "any", false, false, false, 180);
            yield "',
                text: '";
            // line 181
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 181), "text", [], "any", false, false, false, 181);
            yield "',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('";
            // line 190
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        ";
        }
        // line 198
        yield "    });

    // Función para eliminar unidad
    function deleteUnidad(id, nombre) {
        // Primero verificar las relaciones
        fetch('";
        // line 203
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/' + id + '/verificar-relaciones')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const relaciones = data.data.relaciones;
                    const puedeEliminar = data.data.puede_eliminar;
                    
                    if (!puedeEliminar) {
                        // Construir mensaje detallado
                        let mensaje = `No se puede eliminar la unidad \"\${nombre}\" porque tiene las siguientes relaciones:\\n\\n`;
                        
                        if (relaciones.unidades_hijas && relaciones.unidades_hijas.length > 0) {
                            mensaje += `• \${relaciones.unidades_hijas.length} unidad(es) hija(s):\\n`;
                            relaciones.unidades_hijas.forEach(hija => {
                                mensaje += `  - \${hija.nombre} (\${hija.codigo})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        if (relaciones.asignaturas && relaciones.asignaturas.length > 0) {
                            mensaje += `• \${relaciones.asignaturas.length} asignatura(s) asociada(s):\\n`;
                            relaciones.asignaturas.forEach(asignatura => {
                                mensaje += `  - \${asignatura.asignatura_nombre} (\${asignatura.codigo_asignatura})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        if (relaciones.carreras && relaciones.carreras.length > 0) {
                            mensaje += `• \${relaciones.carreras.length} carrera(s) asociada(s):\\n`;
                            relaciones.carreras.forEach(carrera => {
                                mensaje += `  - \${carrera.carrera_nombre} (\${carrera.codigo_carrera})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        mensaje += 'Primero debe eliminar o reasignar estas relaciones antes de eliminar la unidad.';
                        
                        Swal.fire({
                            title: 'No se puede eliminar',
                            text: mensaje,
                            icon: 'warning',
                            confirmButtonText: 'Entendido'
                        });
                    } else {
                        // Si no hay relaciones, proceder con la eliminación
                        confirmarEliminacion(id, nombre);
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al verificar las relaciones de la unidad',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al verificar las relaciones de la unidad',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }
    
    function confirmarEliminacion(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la unidad \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '";
        // line 285
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    function mostrarUnidadesHijas(unidadId, nombreUnidad) {
        // Obtener las unidades hijas mediante AJAX
        fetch('";
        // line 303
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/' + unidadId + '/verificar-relaciones')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const unidadesHijas = data.data.relaciones.unidades_hijas;
                    
                    if (unidadesHijas && unidadesHijas.length > 0) {
                        let mensaje = `<strong>Unidades hijas de \"\${nombreUnidad}\":</strong><br><br>`;
                        unidadesHijas.forEach(hija => {
                            mensaje += `• <strong>\${hija.nombre}</strong> (\${hija.codigo})<br>`;
                        });
                        
                        Swal.fire({
                            title: 'Unidades Hijas',
                            html: mensaje,
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: '#4e73df'
                        });
                    } else {
                        Swal.fire({
                            title: 'Sin unidades hijas',
                            text: `La unidad \"\${nombreUnidad}\" no tiene unidades hijas.`,
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: '#4e73df'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al obtener las unidades hijas',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al obtener las unidades hijas',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
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
        return "unidades/index.twig";
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
        return array (  543 => 303,  522 => 285,  437 => 203,  430 => 198,  419 => 190,  407 => 181,  403 => 180,  399 => 179,  396 => 178,  394 => 177,  363 => 148,  356 => 147,  343 => 137,  334 => 133,  332 => 132,  319 => 126,  311 => 123,  303 => 120,  298 => 117,  294 => 115,  290 => 113,  288 => 112,  284 => 110,  280 => 108,  274 => 105,  267 => 104,  265 => 103,  261 => 101,  257 => 99,  251 => 97,  249 => 96,  244 => 94,  240 => 93,  236 => 92,  233 => 91,  228 => 90,  196 => 61,  182 => 52,  176 => 51,  168 => 45,  153 => 43,  149 => 42,  141 => 37,  132 => 30,  124 => 25,  120 => 24,  116 => 23,  112 => 21,  110 => 20,  102 => 15,  97 => 12,  90 => 11,  84 => 8,  77 => 7,  66 => 5,  55 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Unidades - Sistema de Bibliografía{% endblock %}

{% block current_page %}unidades{% endblock %}

{% block stylesheets %}
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Unidades</h1>
        <a href=\"{{ app_url }}unidades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Unidad
        </a>
    </div>

    {% if session.swal %}
    <script>
        Swal.fire({
            icon: '{{ session.swal.icon }}',
            title: '{{ session.swal.title|raw }}',
            text: '{{ session.swal.text|raw }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}unidades\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        {% for sede in sedes %}
                            <option value=\"{{ sede.id }}\" {% if filtros.sede == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}unidades\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de unidades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Unidades</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\" id=\"unidades-table\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Sede</th>
                                    <th>Unidad Padre</th>
                                    <th>Unidades Hijas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for unidad in unidades %}
                                <tr>
                                    <td>{{ unidad.codigo }}</td>
                                    <td>{{ unidad.nombre }}</td>
                                    <td>{{ unidad.sede_nombre }}</td>
                                    <td>
                                        {% if unidad.unidad_padre_nombre %}
                                            <span class=\"badge bg-info\">{{ unidad.unidad_padre_nombre }}</span>
                                        {% else %}
                                            <span class=\"text-muted\">Sin unidad padre</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if unidad.cantidad_hijas > 0 %}
                                            <span class=\"badge bg-warning\" title=\"Ver unidades hijas\" onclick=\"mostrarUnidadesHijas({{ unidad.id }}, '{{ unidad.nombre }}')\" style=\"cursor: pointer;\">
                                                {{ unidad.cantidad_hijas }} unidad(es)
                                            </span>
                                        {% else %}
                                            <span class=\"text-muted\">Sin unidades hijas</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if unidad.estado == '1' %}
                                            <span class=\"badge bg-success\">Activo</span>
                                        {% else %}
                                            <span class=\"badge bg-danger\">Inactivo</span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <div class=\"d-flex gap-2\">
                                            <a href=\"{{ app_url }}unidades/{{ unidad.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                <i class=\"fas fa-eye\"></i>
                                            </a>
                                            <a href=\"{{ app_url }}unidades/{{ unidad.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"deleteUnidad({{ unidad.id }}, '{{ unidad.nombre }}')\" title=\"Eliminar\">
                                                <i class=\"fas fa-trash\"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"7\" class=\"text-center\">No hay unidades registradas</td>
                                </tr>
                                {% endfor %}
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
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#unidades-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"]],
            \"pageLength\": 10,
            \"columnDefs\": [
                {
                    \"targets\": [6], // Columna de acciones
                    \"orderable\": false,
                    \"searchable\": false
                },
                {
                    \"targets\": [4], // Columna de unidades hijas
                    \"orderable\": false,
                    \"searchable\": false
                }
            ]
        });

        // Mostrar alertas de SweetAlert2 si existen en la sesión
        {% if session.swal %}
            Swal.fire({
                icon: '{{ session.swal.icon }}',
                title: '{{ session.swal.title|raw }}',
                text: '{{ session.swal.text|raw }}',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        {% endif %}
    });

    // Función para eliminar unidad
    function deleteUnidad(id, nombre) {
        // Primero verificar las relaciones
        fetch('{{ app_url }}unidades/' + id + '/verificar-relaciones')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const relaciones = data.data.relaciones;
                    const puedeEliminar = data.data.puede_eliminar;
                    
                    if (!puedeEliminar) {
                        // Construir mensaje detallado
                        let mensaje = `No se puede eliminar la unidad \"\${nombre}\" porque tiene las siguientes relaciones:\\n\\n`;
                        
                        if (relaciones.unidades_hijas && relaciones.unidades_hijas.length > 0) {
                            mensaje += `• \${relaciones.unidades_hijas.length} unidad(es) hija(s):\\n`;
                            relaciones.unidades_hijas.forEach(hija => {
                                mensaje += `  - \${hija.nombre} (\${hija.codigo})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        if (relaciones.asignaturas && relaciones.asignaturas.length > 0) {
                            mensaje += `• \${relaciones.asignaturas.length} asignatura(s) asociada(s):\\n`;
                            relaciones.asignaturas.forEach(asignatura => {
                                mensaje += `  - \${asignatura.asignatura_nombre} (\${asignatura.codigo_asignatura})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        if (relaciones.carreras && relaciones.carreras.length > 0) {
                            mensaje += `• \${relaciones.carreras.length} carrera(s) asociada(s):\\n`;
                            relaciones.carreras.forEach(carrera => {
                                mensaje += `  - \${carrera.carrera_nombre} (\${carrera.codigo_carrera})\\n`;
                            });
                            mensaje += '\\n';
                        }
                        
                        mensaje += 'Primero debe eliminar o reasignar estas relaciones antes de eliminar la unidad.';
                        
                        Swal.fire({
                            title: 'No se puede eliminar',
                            text: mensaje,
                            icon: 'warning',
                            confirmButtonText: 'Entendido'
                        });
                    } else {
                        // Si no hay relaciones, proceder con la eliminación
                        confirmarEliminacion(id, nombre);
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al verificar las relaciones de la unidad',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al verificar las relaciones de la unidad',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }
    
    function confirmarEliminacion(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la unidad \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ app_url }}unidades/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    function mostrarUnidadesHijas(unidadId, nombreUnidad) {
        // Obtener las unidades hijas mediante AJAX
        fetch('{{ app_url }}unidades/' + unidadId + '/verificar-relaciones')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const unidadesHijas = data.data.relaciones.unidades_hijas;
                    
                    if (unidadesHijas && unidadesHijas.length > 0) {
                        let mensaje = `<strong>Unidades hijas de \"\${nombreUnidad}\":</strong><br><br>`;
                        unidadesHijas.forEach(hija => {
                            mensaje += `• <strong>\${hija.nombre}</strong> (\${hija.codigo})<br>`;
                        });
                        
                        Swal.fire({
                            title: 'Unidades Hijas',
                            html: mensaje,
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: '#4e73df'
                        });
                    } else {
                        Swal.fire({
                            title: 'Sin unidades hijas',
                            text: `La unidad \"\${nombreUnidad}\" no tiene unidades hijas.`,
                            icon: 'info',
                            confirmButtonText: 'Cerrar',
                            confirmButtonColor: '#4e73df'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al obtener las unidades hijas',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al obtener las unidades hijas',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }
</script>
{% endblock %} ", "unidades/index.twig", "/var/www/html/biblioges/templates/unidades/index.twig");
    }
}
