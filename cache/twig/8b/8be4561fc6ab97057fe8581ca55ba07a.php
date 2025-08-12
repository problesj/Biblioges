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

/* mallas/show.twig */
class __TwigTemplate_2e29d2ef4906adea61083fdcb803b2d0 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "mallas/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Malla Curricular - ";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Malla Curricular - ";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 8), "html", null, true);
        yield "</h1>
        <div>
            <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
            <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 13), "html", null, true);
        yield "/fusion-asignaturas\" class=\"btn btn-warning\">
                <i class=\"fas fa-object-group\"></i> Fusionar Asignaturas
            </a>
            <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 16), "html", null, true);
        yield "/edit\" class=\"btn btn-primary\">
                <i class=\"fas fa-edit\"></i> Editar
            </a>
        </div>
    </div>

    ";
        // line 22
        if (($context["swal"] ?? null)) {
            // line 23
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 25), "html", null, true);
            yield "',
            title: '";
            // line 26
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 26), "html", null, true);
            yield "',
            text: '";
            // line 27
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 27), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 32
        yield "
    ";
        // line 33
        if (($context["success"] ?? null)) {
            // line 34
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 35
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 39
        yield "
    ";
        // line 40
        if (($context["error"] ?? null)) {
            // line 41
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 46
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
        // line 55
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 55), "html", null, true);
        yield "</p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Tipo de Programa:</strong>
                        ";
        // line 59
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 59) == "P")) {
            // line 60
            yield "                            Pregrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 61
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 61) == "G")) {
            // line 62
            yield "                            Postgrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 63
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 63) == "O")) {
            // line 64
            yield "                            Otro
                        ";
        } else {
            // line 66
            yield "                            ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 66), "html", null, true);
            yield "
                        ";
        }
        // line 68
        yield "                    </p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Estado:</strong>
                        ";
        // line 72
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 72) == 1)) {
            // line 73
            yield "                            <span class=\"badge bg-success\">Activo</span>
                        ";
        } else {
            // line 75
            yield "                            <span class=\"badge bg-danger\">Inactivo</span>
                        ";
        }
        // line 77
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
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 102
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 102));
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
            // line 103
            yield "                        <tr>
                            <td>";
            // line 104
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
            yield "</td>
                            <td>";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 105)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 105)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 106
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 106)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 106)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 107
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 107)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 107)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 108
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades", [], "any", false, false, false, 108)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 108)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 110
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 110) == 1)) {
                // line 111
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 113
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 115
            yield "                            </td>
                        </tr>
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
        unset($context['_seq'], $context['_key'], $context['codigo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 118
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lista de Asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas de la Malla</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Códigos</th>
                            <th>Nombre</th>
                            <th class=\"text-center\">Tipo</th>
                            <th class=\"text-center\">Periodicidad</th>
                            <th class=\"text-center\">Semestre</th>
                            <th class=\"text-center\">Estado</th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 144
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 144) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 144)) > 0))) {
            // line 145
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 145));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 146
                yield "                            <tr>
                                <td>
                                    ";
                // line 148
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 148));
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
                    // line 149
                    yield "                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 149)) {
                        yield "<br>";
                    }
                    // line 150
                    yield "                                    ";
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
                // line 151
                yield "                                </td>
                                <td>";
                // line 152
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 152), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 153
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 153), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 154
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 154), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 155), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 157
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 157) == 1)) {
                    // line 158
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 160
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 162
                yield "                                </td>
                                <td class=\"text-center\">
                                    <a href=\"";
                // line 164
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "asignaturas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 164), "html", null, true);
                yield "\" class=\"btn btn-info btn-sm\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                </td>
                            </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 170
            yield "                        ";
        } else {
            // line 171
            yield "                            <tr>
                                <td colspan=\"7\" class=\"text-center\">No hay asignaturas vinculadas</td>
                            </tr>
                        ";
        }
        // line 175
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class=\"d-flex gap-2 mb-4\">
        <a href=\"";
        // line 183
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>
</div>

<!-- Modal para detalles de asignatura -->
<div class=\"modal fade\" id=\"modalDetalles\" tabindex=\"-1\" aria-labelledby=\"modalDetallesLabel\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalDetallesLabel\">Detalles de la Asignatura</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <!-- Contenido para asignaturas regulares -->
                <div id=\"detallesRegular\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Departamento</th>
                                    <th>Vigencia Desde</th>
                                    <th>Vigencia Hasta</th>
                                </tr>
                            </thead>
                            <tbody id=\"detallesRegularBody\">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Contenido para asignaturas de formación electiva -->
                <div id=\"detallesElectiva\" style=\"display: none;\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Periodicidad</th>
                                </tr>
                            </thead>
                            <tbody id=\"detallesElectivaBody\">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>

";
        // line 240
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 241
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    const app_url = \"";
        // line 243
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\";
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'));
    const detallesRegular = document.getElementById('detallesRegular');
    const detallesElectiva = document.getElementById('detallesElectiva');
    const modalElement = document.getElementById('modalDetalles');
    let lastFocusedElement = null;
    
    // Manejar clic en botón de detalles
    document.querySelectorAll('.btn-detalles').forEach(btn => {
        btn.addEventListener('click', function() {
            const asignaturaId = this.dataset.id;
            const tipo = this.dataset.tipo;
            
            // Guardar el elemento que tenía el foco
            lastFocusedElement = document.activeElement;
            
            // Mostrar el contenido correspondiente según el tipo
            if (tipo === 'FORMACION_ELECTIVA') {
                detallesRegular.style.display = 'none';
                detallesElectiva.style.display = 'block';
                cargarDetallesElectiva(asignaturaId);
            } else {
                detallesRegular.style.display = 'block';
                detallesElectiva.style.display = 'none';
                cargarDetallesRegular(asignaturaId);
            }
            
            modalDetalles.show();
        });
    });

    // Manejar el cierre del modal
    modalElement.addEventListener('hidden.bs.modal', function () {
        // Remover la clase modal-open del body
        document.body.classList.remove('modal-open');
        // Remover el padding-right que Bootstrap agrega
        document.body.style.paddingRight = '';
        // Remover el backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        // Restaurar el foco al elemento anterior
        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    });
    
    // Función para cargar detalles de asignatura regular
    function cargarDetallesRegular(asignaturaId) {
        fetch(`\${app_url}api/asignaturas/\${asignaturaId}/detalles`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('detallesRegularBody');
                tbody.innerHTML = '';
                
                data.forEach(detalle => {
                    tbody.innerHTML += `
                        <tr>
                            <td>\${detalle.codigo || '-'}</td>
                            <td>\${detalle.departamento || '-'}</td>
                            <td>\${detalle.vigencia_desde || '-'}</td>
                            <td>\${detalle.vigencia_hasta || '-'}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los detalles de la asignatura');
            });
    }
    
    // Función para cargar detalles de asignatura electiva
    function cargarDetallesElectiva(asignaturaId) {
        fetch(`\${app_url}api/asignaturas/\${asignaturaId}/vinculadas`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('detallesElectivaBody');
                tbody.innerHTML = '';
                
                data.forEach(asignatura => {
                    tbody.innerHTML += `
                        <tr>
                            <td>\${asignatura.nombre}</td>
                            <td>
                                \${asignatura.estado == 1 
                                    ? '<span class=\"badge bg-success\">Activo</span>' 
                                    : '<span class=\"badge bg-danger\">Inactivo</span>'}
                            </td>
                            <td>\${asignatura.periodicidad}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas vinculadas');
            });
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
        return "mallas/show.twig";
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
        return array (  526 => 243,  522 => 241,  511 => 240,  451 => 183,  441 => 175,  435 => 171,  432 => 170,  418 => 164,  414 => 162,  410 => 160,  406 => 158,  404 => 157,  399 => 155,  395 => 154,  391 => 153,  387 => 152,  384 => 151,  370 => 150,  364 => 149,  347 => 148,  343 => 146,  338 => 145,  336 => 144,  308 => 118,  292 => 115,  288 => 113,  284 => 111,  282 => 110,  277 => 108,  273 => 107,  269 => 106,  265 => 105,  261 => 104,  258 => 103,  241 => 102,  214 => 77,  210 => 75,  206 => 73,  204 => 72,  198 => 68,  192 => 66,  188 => 64,  186 => 63,  183 => 62,  181 => 61,  178 => 60,  176 => 59,  169 => 55,  158 => 46,  151 => 42,  148 => 41,  146 => 40,  143 => 39,  136 => 35,  133 => 34,  131 => 33,  128 => 32,  120 => 27,  116 => 26,  112 => 25,  108 => 23,  106 => 22,  95 => 16,  87 => 13,  81 => 10,  76 => 8,  72 => 6,  65 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Malla Curricular - {{ carrera.nombre }}{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Malla Curricular - {{ carrera.nombre }}</h1>
        <div>
            <a href=\"{{ app_url }}mallas\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
            <a href=\"{{ app_url }}mallas/{{ carrera.id }}/fusion-asignaturas\" class=\"btn btn-warning\">
                <i class=\"fas fa-object-group\"></i> Fusionar Asignaturas
            </a>
            <a href=\"{{ app_url }}mallas/{{ carrera.id }}/edit\" class=\"btn btn-primary\">
                <i class=\"fas fa-edit\"></i> Editar
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
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for codigo in carrera.codigos_carrera %}
                        <tr>
                            <td>{{ codigo }}</td>
                            <td>{{ carrera.vigencias_desde[loop.index0] }}</td>
                            <td>{{ carrera.vigencias_hasta[loop.index0] }}</td>
                            <td>{{ carrera.sedes[loop.index0] }}</td>
                            <td>{{ carrera.unidades[loop.index0] }}</td>
                            <td>
                                {% if carrera.estado == 1 %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lista de Asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas de la Malla</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Códigos</th>
                            <th>Nombre</th>
                            <th class=\"text-center\">Tipo</th>
                            <th class=\"text-center\">Periodicidad</th>
                            <th class=\"text-center\">Semestre</th>
                            <th class=\"text-center\">Estado</th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% if carrera.asignaturas is defined and carrera.asignaturas|length > 0 %}
                            {% for asignatura in carrera.asignaturas %}
                            <tr>
                                <td>
                                    {% for codigo in asignatura.codigos %}
                                        {{ codigo }}{% if not loop.last %}<br>{% endif %}
                                    {% endfor %}
                                </td>
                                <td>{{ asignatura.nombre }}</td>
                                <td class=\"text-center\">{{ asignatura.tipo }}</td>
                                <td class=\"text-center\">{{ asignatura.periodicidad }}</td>
                                <td class=\"text-center\">{{ asignatura.semestre }}</td>
                                <td class=\"text-center\">
                                    {% if asignatura.estado == 1 %}
                                        <span class=\"badge bg-success\">Activo</span>
                                    {% else %}
                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}\" class=\"btn btn-info btn-sm\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                </td>
                            </tr>
                            {% endfor %}
                        {% else %}
                            <tr>
                                <td colspan=\"7\" class=\"text-center\">No hay asignaturas vinculadas</td>
                            </tr>
                        {% endif %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class=\"d-flex gap-2 mb-4\">
        <a href=\"{{ app_url }}mallas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>
</div>

<!-- Modal para detalles de asignatura -->
<div class=\"modal fade\" id=\"modalDetalles\" tabindex=\"-1\" aria-labelledby=\"modalDetallesLabel\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalDetallesLabel\">Detalles de la Asignatura</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <!-- Contenido para asignaturas regulares -->
                <div id=\"detallesRegular\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Código</th>
                                    <th>Departamento</th>
                                    <th>Vigencia Desde</th>
                                    <th>Vigencia Hasta</th>
                                </tr>
                            </thead>
                            <tbody id=\"detallesRegularBody\">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Contenido para asignaturas de formación electiva -->
                <div id=\"detallesElectiva\" style=\"display: none;\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\">
                            <thead class=\"table-primary\">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Periodicidad</th>
                                </tr>
                            </thead>
                            <tbody id=\"detallesElectivaBody\">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const app_url = \"{{ app_url }}\";
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'));
    const detallesRegular = document.getElementById('detallesRegular');
    const detallesElectiva = document.getElementById('detallesElectiva');
    const modalElement = document.getElementById('modalDetalles');
    let lastFocusedElement = null;
    
    // Manejar clic en botón de detalles
    document.querySelectorAll('.btn-detalles').forEach(btn => {
        btn.addEventListener('click', function() {
            const asignaturaId = this.dataset.id;
            const tipo = this.dataset.tipo;
            
            // Guardar el elemento que tenía el foco
            lastFocusedElement = document.activeElement;
            
            // Mostrar el contenido correspondiente según el tipo
            if (tipo === 'FORMACION_ELECTIVA') {
                detallesRegular.style.display = 'none';
                detallesElectiva.style.display = 'block';
                cargarDetallesElectiva(asignaturaId);
            } else {
                detallesRegular.style.display = 'block';
                detallesElectiva.style.display = 'none';
                cargarDetallesRegular(asignaturaId);
            }
            
            modalDetalles.show();
        });
    });

    // Manejar el cierre del modal
    modalElement.addEventListener('hidden.bs.modal', function () {
        // Remover la clase modal-open del body
        document.body.classList.remove('modal-open');
        // Remover el padding-right que Bootstrap agrega
        document.body.style.paddingRight = '';
        // Remover el backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        // Restaurar el foco al elemento anterior
        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    });
    
    // Función para cargar detalles de asignatura regular
    function cargarDetallesRegular(asignaturaId) {
        fetch(`\${app_url}api/asignaturas/\${asignaturaId}/detalles`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('detallesRegularBody');
                tbody.innerHTML = '';
                
                data.forEach(detalle => {
                    tbody.innerHTML += `
                        <tr>
                            <td>\${detalle.codigo || '-'}</td>
                            <td>\${detalle.departamento || '-'}</td>
                            <td>\${detalle.vigencia_desde || '-'}</td>
                            <td>\${detalle.vigencia_hasta || '-'}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los detalles de la asignatura');
            });
    }
    
    // Función para cargar detalles de asignatura electiva
    function cargarDetallesElectiva(asignaturaId) {
        fetch(`\${app_url}api/asignaturas/\${asignaturaId}/vinculadas`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('detallesElectivaBody');
                tbody.innerHTML = '';
                
                data.forEach(asignatura => {
                    tbody.innerHTML += `
                        <tr>
                            <td>\${asignatura.nombre}</td>
                            <td>
                                \${asignatura.estado == 1 
                                    ? '<span class=\"badge bg-success\">Activo</span>' 
                                    : '<span class=\"badge bg-danger\">Inactivo</span>'}
                            </td>
                            <td>\${asignatura.periodicidad}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas vinculadas');
            });
    }
});
</script>
{% endblock %}
{% endblock %} ", "mallas/show.twig", "/var/www/html/biblioges/templates/mallas/show.twig");
    }
}
