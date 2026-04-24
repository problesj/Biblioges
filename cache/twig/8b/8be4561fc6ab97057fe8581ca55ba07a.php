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
            'head' => [$this, 'block_head'],
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
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<style>
    .malla-grafica-header {
        background: linear-gradient(90deg, #8b2f13 0%, #a83c16 100%);
        color: #fff;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .malla-grafica-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 0.75rem;
    }

    .malla-semestre-col {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .malla-semestre-title {
        background: #ef6c00;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        text-align: center;
        padding: 0.45rem 0.5rem;
        font-size: 0.82rem;
    }

    .malla-asignatura-item {
        margin: 0.4rem;
        background: #f2f4f8;
        border-radius: 0.35rem;
        border-left: 4px solid #8b2f13;
        padding: 0.45rem 0.5rem;
        font-size: 0.78rem;
        line-height: 1.2;
    }

    .malla-asignatura-tipo {
        display: block;
        color: #6c757d;
        font-size: 0.68rem;
        margin-top: 0.2rem;
    }
</style>
";
        yield from [];
    }

    // line 57
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 58
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Malla Curricular - ";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 60), "html", null, true);
        yield "</h1>
        <div>
            <a href=\"";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
            <a href=\"";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 65), "html", null, true);
        yield "/fusion-asignaturas\" class=\"btn btn-warning\">
                <i class=\"fas fa-object-group\"></i> Fusionar Asignaturas
            </a>
            <a href=\"";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 68), "html", null, true);
        yield "/edit\" class=\"btn btn-primary\">
                <i class=\"fas fa-edit\"></i> Editar
            </a>
            <button type=\"button\" class=\"btn btn-success\" id=\"btnVerMallaGrafica\">
                <i class=\"fas fa-image\"></i> Ver formato gráfico (PNG)
            </button>
        </div>
    </div>

    ";
        // line 77
        if (($context["swal"] ?? null)) {
            // line 78
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 80
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 80), "html", null, true);
            yield "',
            title: '";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 81), "html", null, true);
            yield "',
            text: '";
            // line 82
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 82), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 87
        yield "
    ";
        // line 88
        if (($context["success"] ?? null)) {
            // line 89
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 90
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 94
        yield "
    ";
        // line 95
        if (($context["error"] ?? null)) {
            // line 96
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 101
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
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 110), "html", null, true);
        yield "</p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Tipo de Programa:</strong>
                        ";
        // line 114
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 114) == "P")) {
            // line 115
            yield "                            Pregrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 116
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 116) == "G")) {
            // line 117
            yield "                            Postgrado
                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 118
($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 118) == "O")) {
            // line 119
            yield "                            Otro
                        ";
        } else {
            // line 121
            yield "                            ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "tipo_programa", [], "any", false, false, false, 121), "html", null, true);
            yield "
                        ";
        }
        // line 123
        yield "                    </p>
                </div>
                <div class=\"col-md-4\">
                    <p><strong>Estado:</strong>
                        ";
        // line 127
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 127) == 1)) {
            // line 128
            yield "                            <span class=\"badge bg-success\">Activo</span>
                        ";
        } else {
            // line 130
            yield "                            <span class=\"badge bg-danger\">Inactivo</span>
                        ";
        }
        // line 132
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
        // line 157
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "codigos_carrera", [], "any", false, false, false, 157));
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
            // line 158
            yield "                        <tr>
                            <td>";
            // line 159
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
            yield "</td>
                            <td>";
            // line 160
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_desde", [], "any", false, false, false, 160)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 160)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 161
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencias_hasta", [], "any", false, false, false, 161)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 161)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 162
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sedes", [], "any", false, false, false, 162)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 162)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>";
            // line 163
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "unidades", [], "any", false, false, false, 163)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 163)] ?? null) : null), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 165
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "estado", [], "any", false, false, false, 165) == 1)) {
                // line 166
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 168
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 170
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
        // line 173
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
        // line 199
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 199) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 199)) > 0))) {
            // line 200
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 200));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                // line 201
                yield "                            <tr>
                                <td>
                                    ";
                // line 203
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 203));
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
                    // line 204
                    yield "                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 204)) {
                        yield "<br>";
                    }
                    // line 205
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
                // line 206
                yield "                                </td>
                                <td>";
                // line 207
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 207), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 208
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 208), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 209
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 209), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 210
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "semestre", [], "any", false, false, false, 210), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 212
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 212) == 1)) {
                    // line 213
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 215
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 217
                yield "                                </td>
                                <td class=\"text-center\">
                                    <a href=\"";
                // line 219
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "asignaturas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 219), "html", null, true);
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
            // line 225
            yield "                        ";
        } else {
            // line 226
            yield "                            <tr>
                                <td colspan=\"7\" class=\"text-center\">No hay asignaturas vinculadas</td>
                            </tr>
                        ";
        }
        // line 230
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class=\"d-flex gap-2 mb-4\">
        <a href=\"";
        // line 238
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

<!-- Modal malla gráfica -->
<div class=\"modal fade\" id=\"modalMallaGrafica\" tabindex=\"-1\" aria-labelledby=\"modalMallaGraficaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-xl modal-dialog-scrollable\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalMallaGraficaLabel\">Malla en formato gráfico</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"mallaGraficaContenedor\" class=\"p-2\">
                    <div class=\"malla-grafica-header\">
                        <h4 class=\"mb-0\">Malla Curricular ";
        // line 306
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 306), "html", null, true);
        yield "</h4>
                    </div>
                    <div id=\"mallaGraficaGrid\" class=\"malla-grafica-grid\"></div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-success\" id=\"btnDescargarMallaPng\">
                    <i class=\"fas fa-download\"></i> Descargar PNG
                </button>
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>

";
        // line 321
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 322
        yield "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.__mallaShowScriptInitialized) {
        return;
    }
    window.__mallaShowScriptInitialized = true;

    const app_url = \"";
        // line 330
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\";
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'));
    const detallesRegular = document.getElementById('detallesRegular');
    const detallesElectiva = document.getElementById('detallesElectiva');
    const modalElement = document.getElementById('modalDetalles');
    let lastFocusedElement = null;
    const btnVerMallaGrafica = document.getElementById('btnVerMallaGrafica');
    const btnDescargarMallaPng = document.getElementById('btnDescargarMallaPng');
    const mallaGraficaGrid = document.getElementById('mallaGraficaGrid');
    const mallaGraficaContenedor = document.getElementById('mallaGraficaContenedor');
    const modalMallaGraficaElement = document.getElementById('modalMallaGrafica');
    const modalMallaGrafica = new bootstrap.Modal(modalMallaGraficaElement);
    const asignaturasMalla = ";
        // line 342
        yield json_encode(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", true, true, false, 342)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "asignaturas", [], "any", false, false, false, 342), [])) : ([])));
        yield ";
    let generandoPng = false;

    function construirMallaGrafica() {
        if (!mallaGraficaGrid) return;
        const porSemestre = {};

        asignaturasMalla.forEach(asignatura => {
            const semestreNumero = parseInt(asignatura.semestre, 10) || 0;
            if (!porSemestre[semestreNumero]) {
                porSemestre[semestreNumero] = [];
            }
            porSemestre[semestreNumero].push(asignatura);
        });

        const semestresOrdenados = Object.keys(porSemestre)
            .map(Number)
            .sort((a, b) => a - b);

        if (semestresOrdenados.length === 0) {
            mallaGraficaGrid.innerHTML = '<p class=\"text-muted\">No hay asignaturas para graficar.</p>';
            return;
        }

        let html = '';
        semestresOrdenados.forEach(semestre => {
            const asignaturas = porSemestre[semestre];
            html += `<div class=\"malla-semestre-col\">`;
            html += `<div class=\"malla-semestre-title\">Semestre \${semestre}</div>`;
            asignaturas.forEach(item => {
                const nombre = item.nombre || 'Sin nombre';
                const tipo = item.tipo || '';
                html += `
                    <div class=\"malla-asignatura-item\">
                        \${nombre}
                        <span class=\"malla-asignatura-tipo\">\${tipo}</span>
                    </div>
                `;
            });
            html += `</div>`;
        });

        mallaGraficaGrid.innerHTML = html;
    }

    if (btnVerMallaGrafica) {
        btnVerMallaGrafica.onclick = function() {
            construirMallaGrafica();
            modalMallaGrafica.show();
        };

        const params = new URLSearchParams(window.location.search);
        if (params.get('ver_grafico') === '1') {
            btnVerMallaGrafica.click();
            params.delete('ver_grafico');
            const nuevaUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.replaceState({}, '', nuevaUrl);
        }
    }

    if (btnDescargarMallaPng) {
        btnDescargarMallaPng.onclick = function() {
            if (!mallaGraficaContenedor || generandoPng) return;
            generandoPng = true;
            btnDescargarMallaPng.disabled = true;
            html2canvas(mallaGraficaContenedor, {
                scale: 2,
                backgroundColor: '#ffffff',
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                const nombre = 'Malla_' + '";
        // line 413
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "nombre", [], "any", false, false, false, 413), [" " => "_"]), "html", null, true);
        yield "' + '.png';
                link.download = nombre;
                link.href = canvas.toDataURL('image/png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No fue posible generar el PNG de la malla.'
                });
            }).finally(() => {
                generandoPng = false;
                btnDescargarMallaPng.disabled = false;
            });
        };
    }

    if (modalMallaGraficaElement) {
        modalMallaGraficaElement.addEventListener('hidden.bs.modal', function () {
            // Limpieza defensiva por si quedó un backdrop colgado
            if (!document.querySelector('.modal.show')) {
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            }
        });
    }
    
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
        return array (  715 => 413,  641 => 342,  626 => 330,  616 => 322,  605 => 321,  587 => 306,  516 => 238,  506 => 230,  500 => 226,  497 => 225,  483 => 219,  479 => 217,  475 => 215,  471 => 213,  469 => 212,  464 => 210,  460 => 209,  456 => 208,  452 => 207,  449 => 206,  435 => 205,  429 => 204,  412 => 203,  408 => 201,  403 => 200,  401 => 199,  373 => 173,  357 => 170,  353 => 168,  349 => 166,  347 => 165,  342 => 163,  338 => 162,  334 => 161,  330 => 160,  326 => 159,  323 => 158,  306 => 157,  279 => 132,  275 => 130,  271 => 128,  269 => 127,  263 => 123,  257 => 121,  253 => 119,  251 => 118,  248 => 117,  246 => 116,  243 => 115,  241 => 114,  234 => 110,  223 => 101,  216 => 97,  213 => 96,  211 => 95,  208 => 94,  201 => 90,  198 => 89,  196 => 88,  193 => 87,  185 => 82,  181 => 81,  177 => 80,  173 => 78,  171 => 77,  157 => 68,  149 => 65,  143 => 62,  138 => 60,  134 => 58,  127 => 57,  73 => 6,  66 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Malla Curricular - {{ carrera.nombre }}{% endblock %}

{% block head %}
<style>
    .malla-grafica-header {
        background: linear-gradient(90deg, #8b2f13 0%, #a83c16 100%);
        color: #fff;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .malla-grafica-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 0.75rem;
    }

    .malla-semestre-col {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .malla-semestre-title {
        background: #ef6c00;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        text-align: center;
        padding: 0.45rem 0.5rem;
        font-size: 0.82rem;
    }

    .malla-asignatura-item {
        margin: 0.4rem;
        background: #f2f4f8;
        border-radius: 0.35rem;
        border-left: 4px solid #8b2f13;
        padding: 0.45rem 0.5rem;
        font-size: 0.78rem;
        line-height: 1.2;
    }

    .malla-asignatura-tipo {
        display: block;
        color: #6c757d;
        font-size: 0.68rem;
        margin-top: 0.2rem;
    }
</style>
{% endblock %}

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
            <button type=\"button\" class=\"btn btn-success\" id=\"btnVerMallaGrafica\">
                <i class=\"fas fa-image\"></i> Ver formato gráfico (PNG)
            </button>
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

<!-- Modal malla gráfica -->
<div class=\"modal fade\" id=\"modalMallaGrafica\" tabindex=\"-1\" aria-labelledby=\"modalMallaGraficaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-xl modal-dialog-scrollable\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalMallaGraficaLabel\">Malla en formato gráfico</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"mallaGraficaContenedor\" class=\"p-2\">
                    <div class=\"malla-grafica-header\">
                        <h4 class=\"mb-0\">Malla Curricular {{ carrera.nombre }}</h4>
                    </div>
                    <div id=\"mallaGraficaGrid\" class=\"malla-grafica-grid\"></div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-success\" id=\"btnDescargarMallaPng\">
                    <i class=\"fas fa-download\"></i> Descargar PNG
                </button>
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{% block scripts %}
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.__mallaShowScriptInitialized) {
        return;
    }
    window.__mallaShowScriptInitialized = true;

    const app_url = \"{{ app_url }}\";
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'));
    const detallesRegular = document.getElementById('detallesRegular');
    const detallesElectiva = document.getElementById('detallesElectiva');
    const modalElement = document.getElementById('modalDetalles');
    let lastFocusedElement = null;
    const btnVerMallaGrafica = document.getElementById('btnVerMallaGrafica');
    const btnDescargarMallaPng = document.getElementById('btnDescargarMallaPng');
    const mallaGraficaGrid = document.getElementById('mallaGraficaGrid');
    const mallaGraficaContenedor = document.getElementById('mallaGraficaContenedor');
    const modalMallaGraficaElement = document.getElementById('modalMallaGrafica');
    const modalMallaGrafica = new bootstrap.Modal(modalMallaGraficaElement);
    const asignaturasMalla = {{ carrera.asignaturas|default([])|json_encode|raw }};
    let generandoPng = false;

    function construirMallaGrafica() {
        if (!mallaGraficaGrid) return;
        const porSemestre = {};

        asignaturasMalla.forEach(asignatura => {
            const semestreNumero = parseInt(asignatura.semestre, 10) || 0;
            if (!porSemestre[semestreNumero]) {
                porSemestre[semestreNumero] = [];
            }
            porSemestre[semestreNumero].push(asignatura);
        });

        const semestresOrdenados = Object.keys(porSemestre)
            .map(Number)
            .sort((a, b) => a - b);

        if (semestresOrdenados.length === 0) {
            mallaGraficaGrid.innerHTML = '<p class=\"text-muted\">No hay asignaturas para graficar.</p>';
            return;
        }

        let html = '';
        semestresOrdenados.forEach(semestre => {
            const asignaturas = porSemestre[semestre];
            html += `<div class=\"malla-semestre-col\">`;
            html += `<div class=\"malla-semestre-title\">Semestre \${semestre}</div>`;
            asignaturas.forEach(item => {
                const nombre = item.nombre || 'Sin nombre';
                const tipo = item.tipo || '';
                html += `
                    <div class=\"malla-asignatura-item\">
                        \${nombre}
                        <span class=\"malla-asignatura-tipo\">\${tipo}</span>
                    </div>
                `;
            });
            html += `</div>`;
        });

        mallaGraficaGrid.innerHTML = html;
    }

    if (btnVerMallaGrafica) {
        btnVerMallaGrafica.onclick = function() {
            construirMallaGrafica();
            modalMallaGrafica.show();
        };

        const params = new URLSearchParams(window.location.search);
        if (params.get('ver_grafico') === '1') {
            btnVerMallaGrafica.click();
            params.delete('ver_grafico');
            const nuevaUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.replaceState({}, '', nuevaUrl);
        }
    }

    if (btnDescargarMallaPng) {
        btnDescargarMallaPng.onclick = function() {
            if (!mallaGraficaContenedor || generandoPng) return;
            generandoPng = true;
            btnDescargarMallaPng.disabled = true;
            html2canvas(mallaGraficaContenedor, {
                scale: 2,
                backgroundColor: '#ffffff',
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                const nombre = 'Malla_' + '{{ carrera.nombre|replace({' ': '_'}) }}' + '.png';
                link.download = nombre;
                link.href = canvas.toDataURL('image/png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No fue posible generar el PNG de la malla.'
                });
            }).finally(() => {
                generandoPng = false;
                btnDescargarMallaPng.disabled = false;
            });
        };
    }

    if (modalMallaGraficaElement) {
        modalMallaGraficaElement.addEventListener('hidden.bs.modal', function () {
            // Limpieza defensiva por si quedó un backdrop colgado
            if (!document.querySelector('.modal.show')) {
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            }
        });
    }
    
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
