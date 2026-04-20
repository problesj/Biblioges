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

/* asignaturas/show.twig */
class __TwigTemplate_22c6f3c12a447186507b22fb7e42cdfe extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Asignatura - Sistema de Bibliografía";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de Asignatura</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Datos comunes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <p><strong>Nombre:</strong> ";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "nombre", [], "any", false, false, false, 22), "html", null, true);
        yield "</p>
                    <p><strong>Tipo:</strong> ";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 23), "html", null, true);
        yield "</p>
                    <p><strong>Vigencia:</strong> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_desde", [], "any", false, false, false, 24), "html", null, true);
        yield " - ";
        yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_hasta", [], "any", false, false, false, 24)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vigencia_hasta", [], "any", false, false, false, 24), "html", null, true)) : ("Sin fecha de término"));
        yield "</p>
                </div>
                <div class=\"col-md-6\">
                    <p><strong>Periodicidad:</strong> ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "periodicidad", [], "any", false, false, false, 27), "html", null, true);
        yield "</p>
                    <p><strong>Estado:</strong> 
                        <span class=\"badge ";
        // line 29
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 29) == 1)) {
            yield "bg-success";
        } else {
            yield "bg-danger";
        }
        yield " text-white\">
                            ";
        // line 30
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "estado", [], "any", false, false, false, 30) == 1)) ? ("Activo") : ("Inactivo"));
        yield "
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Códigos asociados -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos Asociados</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código Asignatura</th>
                            <th>Sede - Unidad</th>
                            <th>Cantidad de Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "unidades", [], "any", false, false, false, 54));
        foreach ($context['_seq'] as $context["_key"] => $context["info"]) {
            // line 55
            yield "                            <tr>
                                <td>";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "codigo_asignatura", [], "any", false, false, false, 56), "html", null, true);
            yield "</td>
                                <td>";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "unidad_completa", [], "any", false, false, false, 57), "html", null, true);
            yield "</td>
                                <td>";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["info"], "cantidad_alumnos", [], "any", false, false, false, 58), "html", null, true);
            yield "</td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['info'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Carreras (malla curricular)</h6>
        </div>
        <div class=\"card-body\">
            ";
        // line 72
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["carreras_malla"] ?? null))) {
            // line 73
            yield "            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código carrera</th>
                            <th>Nombre</th>
                            <th>Vigencia desde</th>
                            <th>Vigencia hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 84
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras_malla"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["car"]) {
                // line 85
                yield "                        <tr>
                            <td>";
                // line 86
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["car"], "codigo_carrera", [], "any", true, true, false, 86)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "codigo_carrera", [], "any", false, false, false, 86), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>
                                ";
                // line 88
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["car"], "carrera_id", [], "any", true, true, false, 88) && CoreExtension::getAttribute($this->env, $this->source, $context["car"], "carrera_id", [], "any", false, false, false, 88))) {
                    // line 89
                    yield "                                    <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "carreras/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "carrera_id", [], "any", false, false, false, 89), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "nombre_carrera", [], "any", false, false, false, 89), "html", null, true);
                    yield "</a>
                                ";
                } else {
                    // line 91
                    yield "                                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["car"], "nombre_carrera", [], "any", true, true, false, 91)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "nombre_carrera", [], "any", false, false, false, 91), "—")) : ("—")), "html", null, true);
                    yield "
                                ";
                }
                // line 93
                yield "                            </td>
                            <td>";
                // line 94
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["car"], "vigencia_desde", [], "any", true, true, false, 94)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "vigencia_desde", [], "any", false, false, false, 94), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 95
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["car"], "vigencia_hasta", [], "any", true, true, false, 95)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["car"], "vigencia_hasta", [], "any", false, false, false, 95), "—")) : ("—")), "html", null, true);
                yield "</td>
                        </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['car'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 98
            yield "                    </tbody>
                </table>
            </div>
            ";
        } else {
            // line 102
            yield "            <p class=\"text-muted mb-0\">Esta asignatura no está incluida en ninguna malla curricular.</p>
            ";
        }
        // line 104
        yield "        </div>
    </div>

    ";
        // line 107
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 107) == "FORMACION_ELECTIVA")) {
            // line 108
            yield "        <!-- Asignaturas vinculadas (solo para Formación Electiva) -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Periodicidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 126
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vinculadas", [], "any", false, false, false, 126));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura_vinculada"]) {
                // line 127
                yield "                                <tr>
                                    <td>";
                // line 128
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "codigo_asignatura", [], "any", false, false, false, 128), "html", null, true);
                yield "</td>
                                    <td>";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "nombre", [], "any", false, false, false, 129), "html", null, true);
                yield "</td>
                                    <td>";
                // line 130
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "tipo", [], "any", false, false, false, 130), "html", null, true);
                yield "</td>
                                    <td>
                                        <span class=\"badge ";
                // line 132
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 132) == 1)) {
                    yield "bg-success";
                } else {
                    yield "bg-danger";
                }
                yield " text-white\">
                                            ";
                // line 133
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 133) == 1)) ? ("Activo") : ("Inactivo"));
                yield "
                                        </span>
                                    </td>
                                    <td>";
                // line 136
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "periodicidad", [], "any", false, false, false, 136), "html", null, true);
                yield "</td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura_vinculada'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 139
            yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    ";
        }
        // line 145
        yield "
    <!-- Bibliografías Declaradas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Bibliografías Declaradas</h6>
        </div>
        <div class=\"card-body\">
            <!-- Pestañas de navegación -->
            <ul class=\"nav nav-tabs\" id=\"bibliografiasTabs\" role=\"tablist\">
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link active\" id=\"basica-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#basica\" type=\"button\" role=\"tab\" aria-controls=\"basica\" aria-selected=\"true\">
                        Básica <span class=\"badge bg-primary ms-1\">";
        // line 156
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 156)), "html", null, true);
        yield "</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"complementaria-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#complementaria\" type=\"button\" role=\"tab\" aria-controls=\"complementaria\" aria-selected=\"false\">
                        Complementaria <span class=\"badge bg-success ms-1\">";
        // line 161
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 161)), "html", null, true);
        yield "</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"otro-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#otro\" type=\"button\" role=\"tab\" aria-controls=\"otro\" aria-selected=\"false\">
                        Otro <span class=\"badge bg-secondary ms-1\">";
        // line 166
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 166)), "html", null, true);
        yield "</span>
                    </button>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class=\"tab-content mt-3\" id=\"bibliografiasTabsContent\">
                <!-- Pestaña Básica -->
                <div class=\"tab-pane fade show active\" id=\"basica\" role=\"tabpanel\" aria-labelledby=\"basica-tab\">
                    ";
        // line 175
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 175)) > 0)) {
            // line 176
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 192
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 192));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 193
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 195
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 195), "html", null, true);
                yield "</strong>
                                                ";
                // line 196
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 196)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 196), "html", null, true);
                    yield "</small>";
                }
                // line 197
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 197)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 197), "html", null, true);
                    yield "</small>";
                }
                // line 198
                yield "                                            </td>
                                            <td>";
                // line 199
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 199)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 199), "html", null, true)) : ("Sin autores"));
                yield "</td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 201
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 201)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 203
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 203)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 203), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 204
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 204)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 204), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 206
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 206)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 209
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 209), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 212
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 212)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 212), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 212)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 212), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 216
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 216), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 219
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 219), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 222
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 222) > 0)) {
                    // line 223
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 223), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 223), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 227
                yield "                                                </div>
                                                ";
                // line 228
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 228) == 0)) {
                    // line 229
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 231
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 234
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 238
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías básicas declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 243
        yield "                </div>

                <!-- Pestaña Complementaria -->
                <div class=\"tab-pane fade\" id=\"complementaria\" role=\"tabpanel\" aria-labelledby=\"complementaria-tab\">
                    ";
        // line 247
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 247)) > 0)) {
            // line 248
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 264
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 264));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 265
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 267
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 267), "html", null, true);
                yield "</strong>
                                                ";
                // line 268
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 268)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 268), "html", null, true);
                    yield "</small>";
                }
                // line 269
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 269)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 269), "html", null, true);
                    yield "</small>";
                }
                // line 270
                yield "                                            </td>
                                            <td>";
                // line 271
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 271)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 271), "html", null, true)) : ("Sin autores"));
                yield "</td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 273
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 273)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 275
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 275)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 275), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 276
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 276)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 276), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 278
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 278)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 281
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 281), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 284
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 284)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 284), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 284)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 284), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 288
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 288), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 291
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 291), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 294
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 294) > 0)) {
                    // line 295
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 295), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 295), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 299
                yield "                                                </div>
                                                ";
                // line 300
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 300) == 0)) {
                    // line 301
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 303
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 306
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 310
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías complementarias declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 315
        yield "                </div>

                <!-- Pestaña Otro -->
                <div class=\"tab-pane fade\" id=\"otro\" role=\"tabpanel\" aria-labelledby=\"otro-tab\">
                    ";
        // line 319
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 319)) > 0)) {
            // line 320
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 336
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 336));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 337
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 339
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 339), "html", null, true);
                yield "</strong>
                                                ";
                // line 340
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 340)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 340), "html", null, true);
                    yield "</small>";
                }
                // line 341
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 341)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 341), "html", null, true);
                    yield "</small>";
                }
                // line 342
                yield "                                            </td>
                                            <td>";
                // line 343
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 343)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "autores", [], "any", false, false, false, 343), "html", null, true)) : ("Sin autores"));
                yield "</td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 345
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 345)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 347
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 347)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 347), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 348
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 348)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 348), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 350
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 350)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 353
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 353), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 356
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 356)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 356), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 356)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 356), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 360
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 360), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 363
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 363), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 366
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 366) > 0)) {
                    // line 367
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 367), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 367), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 371
                yield "                                                </div>
                                                ";
                // line 372
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 372) == 0)) {
                    // line 373
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 375
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 378
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 382
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay otras bibliografías declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 387
        yield "                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar bibliografías disponibles -->
<div class=\"modal fade\" id=\"modalBibliografiasDisponibles\" tabindex=\"-1\" aria-labelledby=\"modalBibliografiasDisponiblesLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-xl\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalBibliografiasDisponiblesLabel\">Bibliografías Disponibles</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\" id=\"modalBibliografiasDisponiblesBody\">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 412
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 413
        yield "<script src=\"/js/asignaturas.js\"></script>
<script>
function mostrarBibliografiasDisponibles(bibliografiaId, titulo) {
    // Mostrar loading en el modal
    document.getElementById('modalBibliografiasDisponiblesLabel').textContent = `Bibliografías Disponibles - \${titulo}`;
    document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
        <div class=\"text-center py-4\">
            <div class=\"spinner-border text-primary\" role=\"status\">
                <span class=\"visually-hidden\">Cargando...</span>
            </div>
            <p class=\"mt-2\">Cargando bibliografías disponibles...</p>
        </div>
    `;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalBibliografiasDisponibles'));
    modal.show();
    
    // Cargar las bibliografías disponibles via AJAX
    fetch(`\${window.location.origin}/biblioges/api/bibliografias-declaradas/\${bibliografiaId}/disponibles`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarBibliografiasDisponiblesEnModal(data.bibliografias, titulo);
        } else {
            document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
                <div class=\"alert alert-danger\">
                    <i class=\"fas fa-exclamation-triangle\"></i>
                    Error al cargar las bibliografías disponibles: \${data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
            <div class=\"alert alert-danger\">
                <i class=\"fas fa-exclamation-triangle\"></i>
                Error de conexión al cargar las bibliografías disponibles.
            </div>
        `;
    });
}

function mostrarBibliografiasDisponiblesEnModal(bibliografias, titulo) {
    if (bibliografias.length === 0) {
        document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
            <div class=\"text-center py-4\">
                <i class=\"fas fa-info-circle fa-3x text-muted mb-3\"></i>
                <p class=\"text-muted\">No hay bibliografías disponibles para \"\${titulo}\".</p>
            </div>
        `;
        return;
    }
    
    let html = `
        <div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead class=\"table-light\">
                    <tr>
                        <th>Título</th>
                        <th>Año</th>
                        <th>Editorial</th>
                        <th>Disponibilidad</th>
                        <th>Ejemplares</th>
                        <th>Enlaces</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    bibliografias.forEach(bib => {
        const disponibilidadClass = bib.disponibilidad === 'disponible' ? 'bg-success' : 
                                  bib.disponibilidad === 'limitada' ? 'bg-warning' : 'bg-danger';
        
                 html += `
             <tr>
                 <td>
                     <strong>\${bib.titulo}</strong>
                     \${bib.anio_edicion ? `<br><small class=\"text-muted\">Año: \${bib.anio_edicion}</small>` : ''}
                 </td>
                <td>\${bib.anio_edicion || 'N/A'}</td>
                <td>\${bib.editorial || 'N/A'}</td>
                <td>
                    <span class=\"badge \${disponibilidadClass}\">\${bib.disponibilidad || 'N/A'}</span>
                </td>
                <td>
                    \${bib.ejemplares_digitales ? `<span class=\"badge bg-info\">\${bib.ejemplares_digitales}</span>` : 'N/A'}
                </td>
                <td>
                    \${bib.url_acceso ? `<a href=\"\${bib.url_acceso}\" target=\"_blank\" class=\"btn btn-sm btn-success me-1\"><i class=\"fas fa-external-link-alt\"></i> Acceso</a>` : ''}
                    \${bib.url_catalogo ? `<a href=\"\${bib.url_catalogo}\" target=\"_blank\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-search\"></i> Catálogo</a>` : ''}
                    \${!bib.url_acceso && !bib.url_catalogo ? '<span class=\"text-muted\">Sin enlaces</span>' : ''}
                </td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = html;
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
        return "asignaturas/show.twig";
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
        return array (  872 => 413,  865 => 412,  837 => 387,  830 => 382,  824 => 378,  816 => 375,  812 => 373,  810 => 372,  807 => 371,  797 => 367,  795 => 366,  787 => 363,  779 => 360,  766 => 356,  760 => 353,  754 => 350,  749 => 348,  745 => 347,  740 => 345,  735 => 343,  732 => 342,  725 => 341,  719 => 340,  715 => 339,  711 => 337,  707 => 336,  689 => 320,  687 => 319,  681 => 315,  674 => 310,  668 => 306,  660 => 303,  656 => 301,  654 => 300,  651 => 299,  641 => 295,  639 => 294,  631 => 291,  623 => 288,  610 => 284,  604 => 281,  598 => 278,  593 => 276,  589 => 275,  584 => 273,  579 => 271,  576 => 270,  569 => 269,  563 => 268,  559 => 267,  555 => 265,  551 => 264,  533 => 248,  531 => 247,  525 => 243,  518 => 238,  512 => 234,  504 => 231,  500 => 229,  498 => 228,  495 => 227,  485 => 223,  483 => 222,  475 => 219,  467 => 216,  454 => 212,  448 => 209,  442 => 206,  437 => 204,  433 => 203,  428 => 201,  423 => 199,  420 => 198,  413 => 197,  407 => 196,  403 => 195,  399 => 193,  395 => 192,  377 => 176,  375 => 175,  363 => 166,  355 => 161,  347 => 156,  334 => 145,  326 => 139,  317 => 136,  311 => 133,  303 => 132,  298 => 130,  294 => 129,  290 => 128,  287 => 127,  283 => 126,  263 => 108,  261 => 107,  256 => 104,  252 => 102,  246 => 98,  237 => 95,  233 => 94,  230 => 93,  224 => 91,  214 => 89,  212 => 88,  207 => 86,  204 => 85,  200 => 84,  187 => 73,  185 => 72,  172 => 61,  163 => 58,  159 => 57,  155 => 56,  152 => 55,  148 => 54,  121 => 30,  113 => 29,  108 => 27,  100 => 24,  96 => 23,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Detalles de Asignatura - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Detalles de Asignatura</h1>
        <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    <!-- Datos comunes -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Información General</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-6\">
                    <p><strong>Nombre:</strong> {{ asignatura.nombre }}</p>
                    <p><strong>Tipo:</strong> {{ asignatura.tipo }}</p>
                    <p><strong>Vigencia:</strong> {{ asignatura.vigencia_desde }} - {{ asignatura.vigencia_hasta ?: 'Sin fecha de término' }}</p>
                </div>
                <div class=\"col-md-6\">
                    <p><strong>Periodicidad:</strong> {{ asignatura.periodicidad }}</p>
                    <p><strong>Estado:</strong> 
                        <span class=\"badge {% if asignatura.estado == 1 %}bg-success{% else %}bg-danger{% endif %} text-white\">
                            {{ asignatura.estado == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Códigos asociados -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Códigos Asociados</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código Asignatura</th>
                            <th>Sede - Unidad</th>
                            <th>Cantidad de Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for info in asignatura.unidades %}
                            <tr>
                                <td>{{ info.codigo_asignatura }}</td>
                                <td>{{ info.unidad_completa }}</td>
                                <td>{{ info.cantidad_alumnos }}</td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Carreras (malla curricular)</h6>
        </div>
        <div class=\"card-body\">
            {% if carreras_malla is not empty %}
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                    <thead>
                        <tr>
                            <th>Código carrera</th>
                            <th>Nombre</th>
                            <th>Vigencia desde</th>
                            <th>Vigencia hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for car in carreras_malla %}
                        <tr>
                            <td>{{ car.codigo_carrera|default('—') }}</td>
                            <td>
                                {% if car.carrera_id is defined and car.carrera_id %}
                                    <a href=\"{{ app_url }}carreras/{{ car.carrera_id }}\">{{ car.nombre_carrera }}</a>
                                {% else %}
                                    {{ car.nombre_carrera|default('—') }}
                                {% endif %}
                            </td>
                            <td>{{ car.vigencia_desde|default('—') }}</td>
                            <td>{{ car.vigencia_hasta|default('—') }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
            {% else %}
            <p class=\"text-muted mb-0\">Esta asignatura no está incluida en ninguna malla curricular.</p>
            {% endif %}
        </div>
    </div>

    {% if asignatura.tipo == 'FORMACION_ELECTIVA' %}
        <!-- Asignaturas vinculadas (solo para Formación Electiva) -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-bordered\">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Periodicidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for asignatura_vinculada in asignatura.vinculadas %}
                                <tr>
                                    <td>{{ asignatura_vinculada.codigo_asignatura }}</td>
                                    <td>{{ asignatura_vinculada.nombre }}</td>
                                    <td>{{ asignatura_vinculada.tipo }}</td>
                                    <td>
                                        <span class=\"badge {% if asignatura_vinculada.estado == 1 %}bg-success{% else %}bg-danger{% endif %} text-white\">
                                            {{ asignatura_vinculada.estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ asignatura_vinculada.periodicidad }}</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {% endif %}

    <!-- Bibliografías Declaradas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Bibliografías Declaradas</h6>
        </div>
        <div class=\"card-body\">
            <!-- Pestañas de navegación -->
            <ul class=\"nav nav-tabs\" id=\"bibliografiasTabs\" role=\"tablist\">
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link active\" id=\"basica-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#basica\" type=\"button\" role=\"tab\" aria-controls=\"basica\" aria-selected=\"true\">
                        Básica <span class=\"badge bg-primary ms-1\">{{ bibliografias.basica|length }}</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"complementaria-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#complementaria\" type=\"button\" role=\"tab\" aria-controls=\"complementaria\" aria-selected=\"false\">
                        Complementaria <span class=\"badge bg-success ms-1\">{{ bibliografias.complementaria|length }}</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"otro-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#otro\" type=\"button\" role=\"tab\" aria-controls=\"otro\" aria-selected=\"false\">
                        Otro <span class=\"badge bg-secondary ms-1\">{{ bibliografias.otro|length }}</span>
                    </button>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class=\"tab-content mt-3\" id=\"bibliografiasTabsContent\">
                <!-- Pestaña Básica -->
                <div class=\"tab-pane fade show active\" id=\"basica\" role=\"tabpanel\" aria-labelledby=\"basica-tab\">
                    {% if bibliografias.basica|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for bib in bibliografias.basica %}
                                        <tr>
                                            <td>
                                                <strong>{{ bib.titulo }}</strong>
                                                {% if bib.edicion %}<br><small class=\"text-muted\">Edición: {{ bib.edicion }}</small>{% endif %}
                                                {% if bib.isbn %}<br><small class=\"text-muted\">ISBN: {{ bib.isbn }}</small>{% endif %}
                                            </td>
                                            <td>{{ bib.autores ?: 'Sin autores' }}</td>
                                            <td>
                                                <span class=\"badge bg-info\">{{ bib.tipo|title }}</span>
                                            </td>
                                            <td>{{ bib.anio_publicacion ?: 'N/A' }}</td>
                                            <td>{{ bib.editorial ?: 'N/A' }}</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">{{ bib.formato|title }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">{{ bib.total_disponibles }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>{% if bib.fecha_vinculacion_actualizacion %}{{ bib.fecha_vinculacion_actualizacion|date('d/m/Y H:i') }}{% elseif bib.fecha_vinculacion_creacion %}{{ bib.fecha_vinculacion_creacion|date('d/m/Y H:i') }}{% else %}N/A{% endif %}</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    {% if bib.total_disponibles > 0 %}
                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    {% endif %}
                                                </div>
                                                {% if bib.total_disponibles == 0 %}
                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías básicas declaradas para esta asignatura.</p>
                        </div>
                    {% endif %}
                </div>

                <!-- Pestaña Complementaria -->
                <div class=\"tab-pane fade\" id=\"complementaria\" role=\"tabpanel\" aria-labelledby=\"complementaria-tab\">
                    {% if bibliografias.complementaria|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for bib in bibliografias.complementaria %}
                                        <tr>
                                            <td>
                                                <strong>{{ bib.titulo }}</strong>
                                                {% if bib.edicion %}<br><small class=\"text-muted\">Edición: {{ bib.edicion }}</small>{% endif %}
                                                {% if bib.isbn %}<br><small class=\"text-muted\">ISBN: {{ bib.isbn }}</small>{% endif %}
                                            </td>
                                            <td>{{ bib.autores ?: 'Sin autores' }}</td>
                                            <td>
                                                <span class=\"badge bg-info\">{{ bib.tipo|title }}</span>
                                            </td>
                                            <td>{{ bib.anio_publicacion ?: 'N/A' }}</td>
                                            <td>{{ bib.editorial ?: 'N/A' }}</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">{{ bib.formato|title }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">{{ bib.total_disponibles }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>{% if bib.fecha_vinculacion_actualizacion %}{{ bib.fecha_vinculacion_actualizacion|date('d/m/Y H:i') }}{% elseif bib.fecha_vinculacion_creacion %}{{ bib.fecha_vinculacion_creacion|date('d/m/Y H:i') }}{% else %}N/A{% endif %}</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    {% if bib.total_disponibles > 0 %}
                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    {% endif %}
                                                </div>
                                                {% if bib.total_disponibles == 0 %}
                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías complementarias declaradas para esta asignatura.</p>
                        </div>
                    {% endif %}
                </div>

                <!-- Pestaña Otro -->
                <div class=\"tab-pane fade\" id=\"otro\" role=\"tabpanel\" aria-labelledby=\"otro-tab\">
                    {% if bibliografias.otro|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th class=\"text-center\">Formato</th>
                                        <th class=\"text-center\"># Bib. Disponibles</th>
                                        <th class=\"text-center\">Última actualización</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for bib in bibliografias.otro %}
                                        <tr>
                                            <td>
                                                <strong>{{ bib.titulo }}</strong>
                                                {% if bib.edicion %}<br><small class=\"text-muted\">Edición: {{ bib.edicion }}</small>{% endif %}
                                                {% if bib.isbn %}<br><small class=\"text-muted\">ISBN: {{ bib.isbn }}</small>{% endif %}
                                            </td>
                                            <td>{{ bib.autores ?: 'Sin autores' }}</td>
                                            <td>
                                                <span class=\"badge bg-info\">{{ bib.tipo|title }}</span>
                                            </td>
                                            <td>{{ bib.anio_publicacion ?: 'N/A' }}</td>
                                            <td>{{ bib.editorial ?: 'N/A' }}</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">{{ bib.formato|title }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">{{ bib.total_disponibles }}</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>{% if bib.fecha_vinculacion_actualizacion %}{{ bib.fecha_vinculacion_actualizacion|date('d/m/Y H:i') }}{% elseif bib.fecha_vinculacion_creacion %}{{ bib.fecha_vinculacion_creacion|date('d/m/Y H:i') }}{% else %}N/A{% endif %}</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}bibliografias-declaradas/{{ bib.id }}/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    {% if bib.total_disponibles > 0 %}
                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    {% endif %}
                                                </div>
                                                {% if bib.total_disponibles == 0 %}
                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay otras bibliografías declaradas para esta asignatura.</p>
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar bibliografías disponibles -->
<div class=\"modal fade\" id=\"modalBibliografiasDisponibles\" tabindex=\"-1\" aria-labelledby=\"modalBibliografiasDisponiblesLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-xl\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalBibliografiasDisponiblesLabel\">Bibliografías Disponibles</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\" id=\"modalBibliografiasDisponiblesBody\">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src=\"/js/asignaturas.js\"></script>
<script>
function mostrarBibliografiasDisponibles(bibliografiaId, titulo) {
    // Mostrar loading en el modal
    document.getElementById('modalBibliografiasDisponiblesLabel').textContent = `Bibliografías Disponibles - \${titulo}`;
    document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
        <div class=\"text-center py-4\">
            <div class=\"spinner-border text-primary\" role=\"status\">
                <span class=\"visually-hidden\">Cargando...</span>
            </div>
            <p class=\"mt-2\">Cargando bibliografías disponibles...</p>
        </div>
    `;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalBibliografiasDisponibles'));
    modal.show();
    
    // Cargar las bibliografías disponibles via AJAX
    fetch(`\${window.location.origin}/biblioges/api/bibliografias-declaradas/\${bibliografiaId}/disponibles`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarBibliografiasDisponiblesEnModal(data.bibliografias, titulo);
        } else {
            document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
                <div class=\"alert alert-danger\">
                    <i class=\"fas fa-exclamation-triangle\"></i>
                    Error al cargar las bibliografías disponibles: \${data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
            <div class=\"alert alert-danger\">
                <i class=\"fas fa-exclamation-triangle\"></i>
                Error de conexión al cargar las bibliografías disponibles.
            </div>
        `;
    });
}

function mostrarBibliografiasDisponiblesEnModal(bibliografias, titulo) {
    if (bibliografias.length === 0) {
        document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = `
            <div class=\"text-center py-4\">
                <i class=\"fas fa-info-circle fa-3x text-muted mb-3\"></i>
                <p class=\"text-muted\">No hay bibliografías disponibles para \"\${titulo}\".</p>
            </div>
        `;
        return;
    }
    
    let html = `
        <div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead class=\"table-light\">
                    <tr>
                        <th>Título</th>
                        <th>Año</th>
                        <th>Editorial</th>
                        <th>Disponibilidad</th>
                        <th>Ejemplares</th>
                        <th>Enlaces</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    bibliografias.forEach(bib => {
        const disponibilidadClass = bib.disponibilidad === 'disponible' ? 'bg-success' : 
                                  bib.disponibilidad === 'limitada' ? 'bg-warning' : 'bg-danger';
        
                 html += `
             <tr>
                 <td>
                     <strong>\${bib.titulo}</strong>
                     \${bib.anio_edicion ? `<br><small class=\"text-muted\">Año: \${bib.anio_edicion}</small>` : ''}
                 </td>
                <td>\${bib.anio_edicion || 'N/A'}</td>
                <td>\${bib.editorial || 'N/A'}</td>
                <td>
                    <span class=\"badge \${disponibilidadClass}\">\${bib.disponibilidad || 'N/A'}</span>
                </td>
                <td>
                    \${bib.ejemplares_digitales ? `<span class=\"badge bg-info\">\${bib.ejemplares_digitales}</span>` : 'N/A'}
                </td>
                <td>
                    \${bib.url_acceso ? `<a href=\"\${bib.url_acceso}\" target=\"_blank\" class=\"btn btn-sm btn-success me-1\"><i class=\"fas fa-external-link-alt\"></i> Acceso</a>` : ''}
                    \${bib.url_catalogo ? `<a href=\"\${bib.url_catalogo}\" target=\"_blank\" class=\"btn btn-sm btn-info\"><i class=\"fas fa-search\"></i> Catálogo</a>` : ''}
                    \${!bib.url_acceso && !bib.url_catalogo ? '<span class=\"text-muted\">Sin enlaces</span>' : ''}
                </td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    document.getElementById('modalBibliografiasDisponiblesBody').innerHTML = html;
}
</script>
{% endblock %} ", "asignaturas/show.twig", "/var/www/html/biblioges/templates/asignaturas/show.twig");
    }
}
