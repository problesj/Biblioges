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

/* bibliografias_declaradas/vincular.twig */
class __TwigTemplate_6b4959f1ae57c18788a9dcecd85387ae extends Template
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
            'styles' => [$this, 'block_styles'],
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_declaradas/vincular.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Vincular Asignaturas - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 3), "html", null, true);
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield from $this->yieldParentBlock("styles", $context, $blocks);
        yield "
<link href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\" rel=\"stylesheet\">
";
        yield from [];
    }

    // line 10
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 11
        yield "<div class=\"container-fluid mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Vincular Asignaturas</h1>
        <a href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Detalles de la Bibliografía -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h5 class=\"mb-0\">Detalles de la Bibliografía</h5>
        </div>
        <div class=\"card-body\">
            <div class=\"row mb-2\">
                <div class=\"col-md-4\">
                    <strong>Título:</strong> ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 27), "html", null, true);
        yield "
                </div>
                <div class=\"col-md-4\">
                    <strong>Año de Edición:</strong> ";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_publicacion", [], "any", false, false, false, 30), "html", null, true);
        yield "
                </div>
                <div class=\"col-md-4\">
                    <strong>Editorial:</strong> ";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 33), "html", null, true);
        yield "
                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-md-6\">
                    <strong>Edición:</strong> ";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "edicion", [], "any", false, false, false, 38), "html", null, true);
        yield "
                </div>
                <div class=\"col-md-6\">
                    <strong>Formato:</strong> ";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 41), "html", null, true);
        yield "
                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-12\">
                    <strong>URL:</strong> 
                    ";
        // line 47
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 47)) {
            // line 48
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 48), "html", null, true);
            yield "\" target=\"_blank\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 48), "html", null, true);
            yield "</a>
                    ";
        } else {
            // line 50
            yield "                        No disponible
                    ";
        }
        // line 52
        yield "                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-12\">
                    <strong>Autores:</strong>
                    ";
        // line 57
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", true, true, false, 57) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 57)) > 0))) {
            // line 58
            yield "                        ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::join(Twig\Extension\CoreExtension::map($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 58), function ($__a__) use ($context, $macros) { $context["a"] = $__a__; return ((CoreExtension::getAttribute($this->env, $this->source, ($context["a"] ?? null), "apellidos", [], "any", false, false, false, 58) . ", ") . CoreExtension::getAttribute($this->env, $this->source, ($context["a"] ?? null), "nombres", [], "any", false, false, false, 58)); }), "; "), "html", null, true);
            yield "
                    ";
        } else {
            // line 60
            yield "                        No hay autores registrados
                    ";
        }
        // line 62
        yield "                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-12\">
                    <strong>Datos Específicos:</strong>
                    ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 67) == "libro")) {
            // line 68
            yield "                        <p><strong>ISBN:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "isbn", [], "any", false, false, false, 68), "html", null, true);
            yield "</p>
                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 69
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 69) == "tesis")) {
            // line 70
            yield "                        <p><strong>Carrera:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "carrera_nombre", [], "any", false, false, false, 70), "html", null, true);
            yield "</p>
                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 71
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 71) == "articulo")) {
            // line 72
            yield "                        <p><strong>ISSN:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "issn", [], "any", false, false, false, 72), "html", null, true);
            yield "</p>
                        <p><strong>Revista:</strong> ";
            // line 73
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo_revista", [], "any", false, false, false, 73), "html", null, true);
            yield "</p>
                        <p><strong>Cronología:</strong> ";
            // line 74
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "cronologia", [], "any", false, false, false, 74), "html", null, true);
            yield "</p>
                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 75
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 75) == "generico")) {
            // line 76
            yield "                        <p><strong>Descripción:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "descripcion", [], "any", false, false, false, 76), "html", null, true);
            yield "</p>
                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 77
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 77) == "sitio_web")) {
            // line 78
            yield "                        <p><strong>Fecha de Consulta:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "fecha_consulta", [], "any", false, false, false, 78), "html", null, true);
            yield "</p>
                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 79
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 79) == "software")) {
            // line 80
            yield "                        <p><strong>Versión:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "version", [], "any", false, false, false, 80), "html", null, true);
            yield "</p>
                    ";
        }
        // line 82
        yield "                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"ubicacion\" class=\"form-label\">Ubicación</label>
                    <select name=\"ubicacion\" id=\"ubicacion\" class=\"form-select\">
                        <option value=\"\">Seleccione Ubicación</option>
                        ";
        // line 98
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 99
            yield "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "unidades", [], "any", false, false, false, 99));
            foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
                // line 100
                yield "                                <option value=\"u_";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 100), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 100), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 100), "html", null, true);
                yield "</option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 102
            yield "                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
        yield "                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura</label>
                    <select name=\"tipo_asignatura\" id=\"tipo_asignatura\" class=\"form-select\">
                        <option value=\"\">Seleccione Tipo de Asignatura</option>
                        <option value=\"REGULAR\">Regular</option>
                        <option value=\"FORMACION_BASICA\">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\">Formación Especialidad</option>
                        <option value=\"FORMACION_ESPECIAL\">Formación Especial</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de Asignaturas -->
    <div class=\"row\">
        <!-- Asignaturas Disponibles -->
        <div class=\"col-12\" id=\"panelAsignaturasDisponibles\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h3 class=\"card-title mb-0\">Asignaturas Disponibles</h3>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\" style=\"max-height: calc(100vh - 400px); overflow-y: auto;\">
                        <table id=\"tablaAsignaturas\" class=\"table table-striped table-hover mb-0\">
                            <thead class=\"sticky-top bg-white\">
                                <tr>
                                    <th style=\"width: 5%\">
                                        <input type=\"checkbox\" id=\"seleccionarTodasDisponibles\" class=\"form-check-input\">
                                    </th>
                                    <th style=\"width: 25%\">Código</th>
                                    <th style=\"width: 50%\">Nombre</th>
                                    <th style=\"width: 20%\">Tipo Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody id=\"tbodyAsignaturas\">
                                <tr id=\"mensajeSinFiltros\">
                                    <td colspan=\"4\" class=\"text-center text-muted py-4\">
                                        <i class=\"fas fa-info-circle fa-2x mb-2\"></i><br>
                                        Seleccione una ubicación o un tipo de asignatura para ver las asignaturas disponibles
                                    </td>
                                </tr>
                                ";
        // line 151
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_disponibles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 152
            yield "                                <tr class=\"asignatura-disponible\" style=\"display: none;\">
                                    <td class=\"align-top\">
                                        <input type=\"checkbox\" class=\"form-check-input\" name=\"asignaturas[]\" value=\"";
            // line 154
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 154), "html", null, true);
            yield "\" data-nombre=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 154), "html", null, true);
            yield "\" data-tipo=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 154), "html", null, true);
            yield "\">
                                    </td>
                                    <td class=\"align-top\">
                                        <div style=\"font-size: 0.9em; word-break: break-all;\">
                                            ";
            // line 158
            yield Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::trim(Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 158), [", " => "
"])), "html", null, true));
            yield "
                                        </div>
                                    </td>
                                    <td class=\"align-top\">";
            // line 161
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 161), "html", null, true);
            yield "</td>
                                    <td class=\"align-top\">
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_";
            // line 165
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 165), "html", null, true);
            yield "\" 
                                                   value=\"basica\" 
                                                   data-asignatura-id=\"";
            // line 167
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 167), "html", null, true);
            yield "\"
                                                   checked>
                                            <label class=\"form-check-label\">Básica</label>
                                        </div>
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 173), "html", null, true);
            yield "\" 
                                                   value=\"complementaria\" 
                                                   data-asignatura-id=\"";
            // line 175
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 175), "html", null, true);
            yield "\">
                                            <label class=\"form-check-label\">Complementaria</label>
                                        </div>
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_";
            // line 180
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 180), "html", null, true);
            yield "\" 
                                                   value=\"otro\" 
                                                   data-asignatura-id=\"";
            // line 182
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 182), "html", null, true);
            yield "\">
                                            <label class=\"form-check-label\">Otro</label>
                                        </div>
                                    </td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 188
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"row\">
        <!-- Botones de Acción -->
        <div class=\"col-12 d-flex align-items-center justify-content-center\" id=\"botonesAccion\" style=\"display: none;\">
            <div class=\"btn-group gap-2 mb-4\">
                <button type=\"button\" class=\"btn btn-success mb-2\" onclick=\"agregarSeleccionadas()\">
                    <i class=\"fas fa-arrow-down\"></i> Vincular Seleccionadas
                </button>
                <button type=\"button\" class=\"btn btn-danger mb-2\" onclick=\"quitarSeleccionadas()\">
                    <i class=\"fas fa-arrow-up\"></i> Desvincular Seleccionadas
                </button>
            </div>
        </div>
    </div>
    <div class=\"row\">
        <!-- Asignaturas Vinculadas -->
        <div class=\"col-12\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h3 class=\"card-title mb-0\">Asignaturas Vinculadas</h3>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\" style=\"max-height: calc(100vh - 400px); overflow-y: auto;\">
                        <table id=\"tablaVinculadas\" class=\"table table-striped table-hover mb-0\">
                            <thead class=\"sticky-top bg-white\">
                                <tr>
                                    <th style=\"width: 5%\">
                                        <input type=\"checkbox\" id=\"seleccionarTodasVinculadas\" class=\"form-check-input\">
                                    </th>
                                    <th style=\"width: 25%\">Código</th>
                                    <th style=\"width: 50%\">Nombre</th>
                                    <th style=\"width: 20%\">Tipo Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 229
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_vinculadas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 230
            yield "                                <tr>
                                    <td>
                                        <input type=\"checkbox\" class=\"form-check-input\" name=\"vinculaciones[]\" value=\"";
            // line 232
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vinculacion_id", [], "any", false, false, false, 232), "html", null, true);
            yield "\">
                                    </td>
                                    <td>
                                        <div style=\"font-size: 0.9em;\">
                                            ";
            // line 236
            if (CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 236)) {
                // line 237
                yield "                                                ";
                yield Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::trim(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 237)), "html", null, true));
                yield "
                                            ";
            } else {
                // line 239
                yield "                                                Sin código
                                            ";
            }
            // line 241
            yield "                                        </div>
                                    </td>
                                    <td>";
            // line 243
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 243), "html", null, true);
            yield "</td>
                                    <td>";
            // line 244
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo_bibliografia", [], "any", false, false, false, 244), "html", null, true);
            yield "</td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 246
        if (!$context['_iterated']) {
            // line 247
            yield "                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay asignaturas vinculadas</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 251
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

    // line 261
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 262
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
<script>
// Función para obtener parámetros de la URL
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Función para establecer valores de filtros desde la URL
function establecerFiltrosDesdeURL() {
    const unidad = getUrlParameter('unidad');
    const tipoAsignatura = getUrlParameter('tipo_asignatura');
    
    // Establecer valor del filtro de ubicación
    if (unidad) {
        document.getElementById('ubicacion').value = 'u_' + unidad;
    }
    
    // Establecer valor del filtro de tipo de asignatura
    if (tipoAsignatura) {
        document.getElementById('tipo_asignatura').value = tipoAsignatura;
    }
}

// Función para verificar filtros al cargar la página
function verificarFiltrosIniciales() {
    // Primero establecer los valores de los filtros desde la URL
    establecerFiltrosDesdeURL();
    
    const unidad = document.getElementById('ubicacion').value;
    const tipoAsignatura = document.getElementById('tipo_asignatura').value;
    
    // Verificar si se ha seleccionado al menos un filtro
    const hayFiltrosSeleccionados = unidad || tipoAsignatura;
    
    // Controlar visibilidad del mensaje y las asignaturas
    const mensajeSinFiltros = document.getElementById('mensajeSinFiltros');
    const asignaturasDisponibles = document.querySelectorAll('.asignatura-disponible');
    const botonesAccion = document.getElementById('botonesAccion');
    
    // Si hay filtros seleccionados, ocultar el mensaje y mostrar asignaturas y botones
    if (hayFiltrosSeleccionados) {
        mensajeSinFiltros.style.display = 'none';
        asignaturasDisponibles.forEach(asignatura => {
            asignatura.style.display = 'table-row';
        });
        if (botonesAccion) {
        botonesAccion.style.display = 'flex';
        }
    } else {
        // Si no hay filtros, mostrar el mensaje y ocultar asignaturas y botones
        mensajeSinFiltros.style.display = 'table-row';
        asignaturasDisponibles.forEach(asignatura => {
            asignatura.style.display = 'none';
        });
        if (botonesAccion) {
        botonesAccion.style.display = 'none';
        }
    }
}

// Función para aplicar filtros
function aplicarFiltros() {
    const unidad = document.getElementById('ubicacion').value;
    const tipoAsignatura = document.getElementById('tipo_asignatura').value;
    
    // Construir la URL con los filtros
    let url = `";
        // line 330
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 330), "html", null, true);
        yield "/vincular?`;
    const params = new URLSearchParams();
    
    if (unidad) {
        if (unidad.startsWith('u_')) {
            params.append('unidad', unidad.substring(2));
        }
    }
    
    if (tipoAsignatura) {
        params.append('tipo_asignatura', tipoAsignatura);
    }
    
    url += params.toString();
    
    // Recargar la página con los filtros
    window.location.href = url;
}

// Agregar eventos a los selectores de filtros
document.getElementById('ubicacion').addEventListener('change', aplicarFiltros);
document.getElementById('tipo_asignatura').addEventListener('change', aplicarFiltros);

// Verificar filtros iniciales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    verificarFiltrosIniciales();
});

// Función para agregar asignaturas seleccionadas
function agregarSeleccionadas() {
    // Obtener todas las asignaturas seleccionadas
    const asignaturasSeleccionadas = [];
    document.querySelectorAll('input[name=\"asignaturas[]\"]:checked').forEach(checkbox => {
        const asignaturaId = checkbox.value;
        const tipoBibliografia = document.querySelector(`input[name=\"tipo_bibliografia_\${asignaturaId}\"]:checked`).value;
        asignaturasSeleccionadas.push({
            asignatura_id: asignaturaId,
            tipo_bibliografia: tipoBibliografia
        });
    });

    if (asignaturasSeleccionadas.length === 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Por favor, seleccione al menos una asignatura',
            icon: 'warning'
        });
        return;
    }

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    // Realizar la petición AJAX
    const url = '";
        // line 387
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 387), "html", null, true);
        yield "/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: asignaturasSeleccionadas
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success'
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al vincular las asignaturas',
                icon: 'error'
            });
        }
        })
        .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al vincular las asignaturas',
            icon: 'error'
        });
    })
    .finally(() => {
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    });
}

// Función para quitar asignaturas seleccionadas
function quitarSeleccionadas() {
    const checkboxes = document.querySelectorAll('#tablaVinculadas tbody input[type=\"checkbox\"]:checked');
    if (checkboxes.length === 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Por favor, seleccione al menos una asignatura para quitar',
            icon: 'warning'
        });
        return;
    }

    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Está seguro de quitar las asignaturas seleccionadas?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, quitar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const vinculaciones = Array.from(checkboxes).map(checkbox => checkbox.value);
            
            // Mostrar indicador de carga
            const loadingIndicator = document.getElementById('loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            const url = `";
        // line 462
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 462), "html", null, true);
        yield "/desvincularMultiple`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    vinculaciones: vinculaciones
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Error al desvincular las asignaturas',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al desvincular las asignaturas',
                    icon: 'error'
                });
            })
            .finally(() => {
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
            });
        }
    });
}

// Función para agregar una asignatura
function agregarAsignatura(asignaturaId) {
    const tipoBibliografia = document.querySelector(`input[name=\"tipo_bibliografia_\${asignaturaId}\"]:checked`).value;

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    // Realizar la petición AJAX
    const url = '";
        // line 520
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 520), "html", null, true);
        yield "/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: [{
                asignatura_id: asignaturaId,
                tipo_bibliografia: tipoBibliografia
            }]
        })
    })
    .then(async response => {
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));
        
        const text = await response.text();
        console.log('Response text:', text);
        
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: \${response.status} \${response.statusText}`);
        }
        
        if (!text) {
            throw new Error('La respuesta del servidor está vacía');
        }

        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            console.error('Texto recibido:', text);
            throw new Error('Error al procesar la respuesta del servidor');
        }
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.success) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Error al vincular las asignaturas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al vincular las asignaturas: ' + error.message);
    })
    .finally(() => {
        // Ocultar indicador de carga
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    });
}

// Función para quitar una asignatura
function quitarAsignatura(vinculacionId) {
    if (!confirm('¿Está seguro de quitar esta asignatura?')) {
        return;
    }

    const url = `";
        // line 588
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 588)) . "/desvincularSingle/"), "html", null, true);
        yield "\${vinculacionId}`;
    
    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            window.location.reload();
            } else {
            alert(data.message || 'Error al desvincular la asignatura');
            }
        })
        .catch(error => {
        console.error('Error:', error);
        alert('Error al desvincular la asignatura');
    });
}

// Agregar evento para el checkbox \"Seleccionar todas\" en asignaturas disponibles
document.getElementById('seleccionarTodasDisponibles').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#tablaAsignaturas tbody input[type=\"checkbox\"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Agregar evento para el checkbox \"Seleccionar todas\" en asignaturas vinculadas
document.getElementById('seleccionarTodasVinculadas').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#tablaVinculadas tbody input[type=\"checkbox\"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

function vincularAsignaturas() {
    // Obtener todas las asignaturas seleccionadas
    const asignaturasSeleccionadas = [];
    document.querySelectorAll('.asignatura-seleccionada').forEach(asignatura => {
        const asignaturaId = asignatura.getAttribute('data-asignatura-id');
        const tipoBibliografia = asignatura.querySelector('select').value;
        if (asignaturaId && tipoBibliografia) {
            asignaturasSeleccionadas.push({
                asignatura_id: asignaturaId,
                tipo_bibliografia: tipoBibliografia
            });
        }
    });

    if (asignaturasSeleccionadas.length === 0) {
        alert('Por favor, seleccione al menos una asignatura');
        return;
    }

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    // Realizar la petición AJAX
    const url = '";
        // line 654
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 654), "html", null, true);
        yield "/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: asignaturasSeleccionadas
        })
    })
    .then(async response => {
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));
        
        const text = await response.text();
        console.log('Response text:', text);
        
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: \${response.status} \${response.statusText}`);
        }
        
        if (!text) {
            throw new Error('La respuesta del servidor está vacía');
        }
        
        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            console.error('Texto recibido:', text);
            throw new Error('Error al procesar la respuesta del servidor');
        }
    })
    .then(data => {
        console.log('Datos recibidos:', data);
            if (data.success) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Error al vincular las asignaturas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al vincular las asignaturas: ' + error.message);
    })
    .finally(() => {
        // Ocultar indicador de carga
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
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
        return "bibliografias_declaradas/vincular.twig";
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
        return array (  943 => 654,  874 => 588,  801 => 520,  738 => 462,  658 => 387,  596 => 330,  525 => 262,  518 => 261,  505 => 251,  496 => 247,  494 => 246,  487 => 244,  483 => 243,  479 => 241,  475 => 239,  469 => 237,  467 => 236,  460 => 232,  456 => 230,  451 => 229,  408 => 188,  396 => 182,  391 => 180,  383 => 175,  378 => 173,  369 => 167,  364 => 165,  357 => 161,  350 => 158,  339 => 154,  335 => 152,  331 => 151,  281 => 103,  275 => 102,  262 => 100,  257 => 99,  253 => 98,  235 => 82,  229 => 80,  227 => 79,  222 => 78,  220 => 77,  215 => 76,  213 => 75,  209 => 74,  205 => 73,  200 => 72,  198 => 71,  193 => 70,  191 => 69,  186 => 68,  184 => 67,  177 => 62,  173 => 60,  167 => 58,  165 => 57,  158 => 52,  154 => 50,  146 => 48,  144 => 47,  135 => 41,  129 => 38,  121 => 33,  115 => 30,  109 => 27,  93 => 14,  88 => 11,  81 => 10,  73 => 6,  66 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Vincular Asignaturas - {{ bibliografia.titulo }}{% endblock %}

{% block styles %}
{{ parent() }}
<link href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\" rel=\"stylesheet\">
{% endblock %}

{% block content %}
<div class=\"container-fluid mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Vincular Asignaturas</h1>
        <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Detalles de la Bibliografía -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h5 class=\"mb-0\">Detalles de la Bibliografía</h5>
        </div>
        <div class=\"card-body\">
            <div class=\"row mb-2\">
                <div class=\"col-md-4\">
                    <strong>Título:</strong> {{ bibliografia.titulo }}
                </div>
                <div class=\"col-md-4\">
                    <strong>Año de Edición:</strong> {{ bibliografia.anio_publicacion }}
                </div>
                <div class=\"col-md-4\">
                    <strong>Editorial:</strong> {{ bibliografia.editorial }}
                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-md-6\">
                    <strong>Edición:</strong> {{ bibliografia.edicion }}
                </div>
                <div class=\"col-md-6\">
                    <strong>Formato:</strong> {{ bibliografia.formato }}
                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-12\">
                    <strong>URL:</strong> 
                    {% if bibliografia.url %}
                        <a href=\"{{ bibliografia.url }}\" target=\"_blank\">{{ bibliografia.url }}</a>
                    {% else %}
                        No disponible
                    {% endif %}
                </div>
            </div>
            <div class=\"row mb-2\">
                <div class=\"col-12\">
                    <strong>Autores:</strong>
                    {% if bibliografia.autores is defined and bibliografia.autores|length > 0 %}
                        {{ bibliografia.autores|map(a => a.apellidos ~ ', ' ~ a.nombres)|join('; ') }}
                    {% else %}
                        No hay autores registrados
                    {% endif %}
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-12\">
                    <strong>Datos Específicos:</strong>
                    {% if bibliografia.tipo == 'libro' %}
                        <p><strong>ISBN:</strong> {{ bibliografia.isbn }}</p>
                    {% elseif bibliografia.tipo == 'tesis' %}
                        <p><strong>Carrera:</strong> {{ bibliografia.carrera_nombre }}</p>
                    {% elseif bibliografia.tipo == 'articulo' %}
                        <p><strong>ISSN:</strong> {{ bibliografia.issn }}</p>
                        <p><strong>Revista:</strong> {{ bibliografia.titulo_revista }}</p>
                        <p><strong>Cronología:</strong> {{ bibliografia.cronologia }}</p>
                    {% elseif bibliografia.tipo == 'generico' %}
                        <p><strong>Descripción:</strong> {{ bibliografia.descripcion }}</p>
                    {% elseif bibliografia.tipo == 'sitio_web' %}
                        <p><strong>Fecha de Consulta:</strong> {{ bibliografia.fecha_consulta }}</p>
                    {% elseif bibliografia.tipo == 'software' %}
                        <p><strong>Versión:</strong> {{ bibliografia.version }}</p>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"ubicacion\" class=\"form-label\">Ubicación</label>
                    <select name=\"ubicacion\" id=\"ubicacion\" class=\"form-select\">
                        <option value=\"\">Seleccione Ubicación</option>
                        {% for sede in sedes %}
                            {% for unidad in sede.unidades %}
                                <option value=\"u_{{ unidad.id }}\">{{ sede.nombre }} - {{ unidad.nombre }}</option>
                            {% endfor %}
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura</label>
                    <select name=\"tipo_asignatura\" id=\"tipo_asignatura\" class=\"form-select\">
                        <option value=\"\">Seleccione Tipo de Asignatura</option>
                        <option value=\"REGULAR\">Regular</option>
                        <option value=\"FORMACION_BASICA\">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\">Formación Especialidad</option>
                        <option value=\"FORMACION_ESPECIAL\">Formación Especial</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de Asignaturas -->
    <div class=\"row\">
        <!-- Asignaturas Disponibles -->
        <div class=\"col-12\" id=\"panelAsignaturasDisponibles\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h3 class=\"card-title mb-0\">Asignaturas Disponibles</h3>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\" style=\"max-height: calc(100vh - 400px); overflow-y: auto;\">
                        <table id=\"tablaAsignaturas\" class=\"table table-striped table-hover mb-0\">
                            <thead class=\"sticky-top bg-white\">
                                <tr>
                                    <th style=\"width: 5%\">
                                        <input type=\"checkbox\" id=\"seleccionarTodasDisponibles\" class=\"form-check-input\">
                                    </th>
                                    <th style=\"width: 25%\">Código</th>
                                    <th style=\"width: 50%\">Nombre</th>
                                    <th style=\"width: 20%\">Tipo Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody id=\"tbodyAsignaturas\">
                                <tr id=\"mensajeSinFiltros\">
                                    <td colspan=\"4\" class=\"text-center text-muted py-4\">
                                        <i class=\"fas fa-info-circle fa-2x mb-2\"></i><br>
                                        Seleccione una ubicación o un tipo de asignatura para ver las asignaturas disponibles
                                    </td>
                                </tr>
                                {% for asignatura in asignaturas_disponibles %}
                                <tr class=\"asignatura-disponible\" style=\"display: none;\">
                                    <td class=\"align-top\">
                                        <input type=\"checkbox\" class=\"form-check-input\" name=\"asignaturas[]\" value=\"{{ asignatura.id }}\" data-nombre=\"{{ asignatura.nombre }}\" data-tipo=\"{{ asignatura.tipo }}\">
                                    </td>
                                    <td class=\"align-top\">
                                        <div style=\"font-size: 0.9em; word-break: break-all;\">
                                            {{ asignatura.codigos|replace({', ': '\\n'})|trim|nl2br }}
                                        </div>
                                    </td>
                                    <td class=\"align-top\">{{ asignatura.nombre }}</td>
                                    <td class=\"align-top\">
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_{{ asignatura.id }}\" 
                                                   value=\"basica\" 
                                                   data-asignatura-id=\"{{ asignatura.id }}\"
                                                   checked>
                                            <label class=\"form-check-label\">Básica</label>
                                        </div>
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_{{ asignatura.id }}\" 
                                                   value=\"complementaria\" 
                                                   data-asignatura-id=\"{{ asignatura.id }}\">
                                            <label class=\"form-check-label\">Complementaria</label>
                                        </div>
                                        <div class=\"form-check\">
                                            <input class=\"form-check-input tipo-bibliografia\" type=\"radio\" 
                                                   name=\"tipo_bibliografia_{{ asignatura.id }}\" 
                                                   value=\"otro\" 
                                                   data-asignatura-id=\"{{ asignatura.id }}\">
                                            <label class=\"form-check-label\">Otro</label>
                                        </div>
                                    </td>
                                </tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"row\">
        <!-- Botones de Acción -->
        <div class=\"col-12 d-flex align-items-center justify-content-center\" id=\"botonesAccion\" style=\"display: none;\">
            <div class=\"btn-group gap-2 mb-4\">
                <button type=\"button\" class=\"btn btn-success mb-2\" onclick=\"agregarSeleccionadas()\">
                    <i class=\"fas fa-arrow-down\"></i> Vincular Seleccionadas
                </button>
                <button type=\"button\" class=\"btn btn-danger mb-2\" onclick=\"quitarSeleccionadas()\">
                    <i class=\"fas fa-arrow-up\"></i> Desvincular Seleccionadas
                </button>
            </div>
        </div>
    </div>
    <div class=\"row\">
        <!-- Asignaturas Vinculadas -->
        <div class=\"col-12\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h3 class=\"card-title mb-0\">Asignaturas Vinculadas</h3>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\" style=\"max-height: calc(100vh - 400px); overflow-y: auto;\">
                        <table id=\"tablaVinculadas\" class=\"table table-striped table-hover mb-0\">
                            <thead class=\"sticky-top bg-white\">
                                <tr>
                                    <th style=\"width: 5%\">
                                        <input type=\"checkbox\" id=\"seleccionarTodasVinculadas\" class=\"form-check-input\">
                                    </th>
                                    <th style=\"width: 25%\">Código</th>
                                    <th style=\"width: 50%\">Nombre</th>
                                    <th style=\"width: 20%\">Tipo Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for asignatura in asignaturas_vinculadas %}
                                <tr>
                                    <td>
                                        <input type=\"checkbox\" class=\"form-check-input\" name=\"vinculaciones[]\" value=\"{{ asignatura.vinculacion_id }}\">
                                    </td>
                                    <td>
                                        <div style=\"font-size: 0.9em;\">
                                            {% if asignatura.codigos %}
                                                {{ asignatura.codigos|trim|nl2br }}
                                            {% else %}
                                                Sin código
                                            {% endif %}
                                        </div>
                                    </td>
                                    <td>{{ asignatura.nombre }}</td>
                                    <td>{{ asignatura.tipo_bibliografia }}</td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay asignaturas vinculadas</td>
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
{{ parent() }}
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
<script>
// Función para obtener parámetros de la URL
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Función para establecer valores de filtros desde la URL
function establecerFiltrosDesdeURL() {
    const unidad = getUrlParameter('unidad');
    const tipoAsignatura = getUrlParameter('tipo_asignatura');
    
    // Establecer valor del filtro de ubicación
    if (unidad) {
        document.getElementById('ubicacion').value = 'u_' + unidad;
    }
    
    // Establecer valor del filtro de tipo de asignatura
    if (tipoAsignatura) {
        document.getElementById('tipo_asignatura').value = tipoAsignatura;
    }
}

// Función para verificar filtros al cargar la página
function verificarFiltrosIniciales() {
    // Primero establecer los valores de los filtros desde la URL
    establecerFiltrosDesdeURL();
    
    const unidad = document.getElementById('ubicacion').value;
    const tipoAsignatura = document.getElementById('tipo_asignatura').value;
    
    // Verificar si se ha seleccionado al menos un filtro
    const hayFiltrosSeleccionados = unidad || tipoAsignatura;
    
    // Controlar visibilidad del mensaje y las asignaturas
    const mensajeSinFiltros = document.getElementById('mensajeSinFiltros');
    const asignaturasDisponibles = document.querySelectorAll('.asignatura-disponible');
    const botonesAccion = document.getElementById('botonesAccion');
    
    // Si hay filtros seleccionados, ocultar el mensaje y mostrar asignaturas y botones
    if (hayFiltrosSeleccionados) {
        mensajeSinFiltros.style.display = 'none';
        asignaturasDisponibles.forEach(asignatura => {
            asignatura.style.display = 'table-row';
        });
        if (botonesAccion) {
        botonesAccion.style.display = 'flex';
        }
    } else {
        // Si no hay filtros, mostrar el mensaje y ocultar asignaturas y botones
        mensajeSinFiltros.style.display = 'table-row';
        asignaturasDisponibles.forEach(asignatura => {
            asignatura.style.display = 'none';
        });
        if (botonesAccion) {
        botonesAccion.style.display = 'none';
        }
    }
}

// Función para aplicar filtros
function aplicarFiltros() {
    const unidad = document.getElementById('ubicacion').value;
    const tipoAsignatura = document.getElementById('tipo_asignatura').value;
    
    // Construir la URL con los filtros
    let url = `{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/vincular?`;
    const params = new URLSearchParams();
    
    if (unidad) {
        if (unidad.startsWith('u_')) {
            params.append('unidad', unidad.substring(2));
        }
    }
    
    if (tipoAsignatura) {
        params.append('tipo_asignatura', tipoAsignatura);
    }
    
    url += params.toString();
    
    // Recargar la página con los filtros
    window.location.href = url;
}

// Agregar eventos a los selectores de filtros
document.getElementById('ubicacion').addEventListener('change', aplicarFiltros);
document.getElementById('tipo_asignatura').addEventListener('change', aplicarFiltros);

// Verificar filtros iniciales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    verificarFiltrosIniciales();
});

// Función para agregar asignaturas seleccionadas
function agregarSeleccionadas() {
    // Obtener todas las asignaturas seleccionadas
    const asignaturasSeleccionadas = [];
    document.querySelectorAll('input[name=\"asignaturas[]\"]:checked').forEach(checkbox => {
        const asignaturaId = checkbox.value;
        const tipoBibliografia = document.querySelector(`input[name=\"tipo_bibliografia_\${asignaturaId}\"]:checked`).value;
        asignaturasSeleccionadas.push({
            asignatura_id: asignaturaId,
            tipo_bibliografia: tipoBibliografia
        });
    });

    if (asignaturasSeleccionadas.length === 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Por favor, seleccione al menos una asignatura',
            icon: 'warning'
        });
        return;
    }

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    // Realizar la petición AJAX
    const url = '{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: asignaturasSeleccionadas
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success'
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Error al vincular las asignaturas',
                icon: 'error'
            });
        }
        })
        .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al vincular las asignaturas',
            icon: 'error'
        });
    })
    .finally(() => {
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    });
}

// Función para quitar asignaturas seleccionadas
function quitarSeleccionadas() {
    const checkboxes = document.querySelectorAll('#tablaVinculadas tbody input[type=\"checkbox\"]:checked');
    if (checkboxes.length === 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Por favor, seleccione al menos una asignatura para quitar',
            icon: 'warning'
        });
        return;
    }

    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Está seguro de quitar las asignaturas seleccionadas?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, quitar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const vinculaciones = Array.from(checkboxes).map(checkbox => checkbox.value);
            
            // Mostrar indicador de carga
            const loadingIndicator = document.getElementById('loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            const url = `{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/desvincularMultiple`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    vinculaciones: vinculaciones
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Error al desvincular las asignaturas',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al desvincular las asignaturas',
                    icon: 'error'
                });
            })
            .finally(() => {
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
            });
        }
    });
}

// Función para agregar una asignatura
function agregarAsignatura(asignaturaId) {
    const tipoBibliografia = document.querySelector(`input[name=\"tipo_bibliografia_\${asignaturaId}\"]:checked`).value;

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    // Realizar la petición AJAX
    const url = '{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: [{
                asignatura_id: asignaturaId,
                tipo_bibliografia: tipoBibliografia
            }]
        })
    })
    .then(async response => {
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));
        
        const text = await response.text();
        console.log('Response text:', text);
        
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: \${response.status} \${response.statusText}`);
        }
        
        if (!text) {
            throw new Error('La respuesta del servidor está vacía');
        }

        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            console.error('Texto recibido:', text);
            throw new Error('Error al procesar la respuesta del servidor');
        }
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.success) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Error al vincular las asignaturas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al vincular las asignaturas: ' + error.message);
    })
    .finally(() => {
        // Ocultar indicador de carga
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    });
}

// Función para quitar una asignatura
function quitarAsignatura(vinculacionId) {
    if (!confirm('¿Está seguro de quitar esta asignatura?')) {
        return;
    }

    const url = `{{ app_url ~ 'bibliografias-declaradas/' ~ bibliografia.id ~ '/desvincularSingle/' }}\${vinculacionId}`;
    
    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            window.location.reload();
            } else {
            alert(data.message || 'Error al desvincular la asignatura');
            }
        })
        .catch(error => {
        console.error('Error:', error);
        alert('Error al desvincular la asignatura');
    });
}

// Agregar evento para el checkbox \"Seleccionar todas\" en asignaturas disponibles
document.getElementById('seleccionarTodasDisponibles').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#tablaAsignaturas tbody input[type=\"checkbox\"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Agregar evento para el checkbox \"Seleccionar todas\" en asignaturas vinculadas
document.getElementById('seleccionarTodasVinculadas').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#tablaVinculadas tbody input[type=\"checkbox\"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

function vincularAsignaturas() {
    // Obtener todas las asignaturas seleccionadas
    const asignaturasSeleccionadas = [];
    document.querySelectorAll('.asignatura-seleccionada').forEach(asignatura => {
        const asignaturaId = asignatura.getAttribute('data-asignatura-id');
        const tipoBibliografia = asignatura.querySelector('select').value;
        if (asignaturaId && tipoBibliografia) {
            asignaturasSeleccionadas.push({
                asignatura_id: asignaturaId,
                tipo_bibliografia: tipoBibliografia
            });
        }
    });

    if (asignaturasSeleccionadas.length === 0) {
        alert('Por favor, seleccione al menos una asignatura');
        return;
    }

    // Mostrar indicador de carga
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    // Realizar la petición AJAX
    const url = '{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/vincularMultiple'.replace(/([^:]\\/)\\/+/g, \"\$1\");
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            asignaturas: asignaturasSeleccionadas
        })
    })
    .then(async response => {
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));
        
        const text = await response.text();
        console.log('Response text:', text);
        
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: \${response.status} \${response.statusText}`);
        }
        
        if (!text) {
            throw new Error('La respuesta del servidor está vacía');
        }
        
        try {
            return JSON.parse(text);
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            console.error('Texto recibido:', text);
            throw new Error('Error al procesar la respuesta del servidor');
        }
    })
    .then(data => {
        console.log('Datos recibidos:', data);
            if (data.success) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Error al vincular las asignaturas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al vincular las asignaturas: ' + error.message);
    })
    .finally(() => {
        // Ocultar indicador de carga
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    });
}
</script>
{% endblock %} ", "bibliografias_declaradas/vincular.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/vincular.twig");
    }
}
