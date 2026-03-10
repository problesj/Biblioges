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

    ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo", [], "any", false, false, false, 67) == "FORMACION_ELECTIVA")) {
            // line 68
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
            // line 86
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "vinculadas", [], "any", false, false, false, 86));
            foreach ($context['_seq'] as $context["_key"] => $context["asignatura_vinculada"]) {
                // line 87
                yield "                                <tr>
                                    <td>";
                // line 88
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "codigo_asignatura", [], "any", false, false, false, 88), "html", null, true);
                yield "</td>
                                    <td>";
                // line 89
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "nombre", [], "any", false, false, false, 89), "html", null, true);
                yield "</td>
                                    <td>";
                // line 90
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "tipo", [], "any", false, false, false, 90), "html", null, true);
                yield "</td>
                                    <td>
                                        <span class=\"badge ";
                // line 92
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 92) == 1)) {
                    yield "bg-success";
                } else {
                    yield "bg-danger";
                }
                yield " text-white\">
                                            ";
                // line 93
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "estado", [], "any", false, false, false, 93) == 1)) ? ("Activo") : ("Inactivo"));
                yield "
                                        </span>
                                    </td>
                                    <td>";
                // line 96
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura_vinculada"], "periodicidad", [], "any", false, false, false, 96), "html", null, true);
                yield "</td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['asignatura_vinculada'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 99
            yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    ";
        }
        // line 105
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
        // line 116
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 116)), "html", null, true);
        yield "</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"complementaria-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#complementaria\" type=\"button\" role=\"tab\" aria-controls=\"complementaria\" aria-selected=\"false\">
                        Complementaria <span class=\"badge bg-success ms-1\">";
        // line 121
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 121)), "html", null, true);
        yield "</span>
                    </button>
                </li>
                <li class=\"nav-item\" role=\"presentation\">
                    <button class=\"nav-link\" id=\"otro-tab\" data-bs-toggle=\"tab\" data-bs-target=\"#otro\" type=\"button\" role=\"tab\" aria-controls=\"otro\" aria-selected=\"false\">
                        Otro <span class=\"badge bg-secondary ms-1\">";
        // line 126
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 126)), "html", null, true);
        yield "</span>
                    </button>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class=\"tab-content mt-3\" id=\"bibliografiasTabsContent\">
                <!-- Pestaña Básica -->
                <div class=\"tab-pane fade show active\" id=\"basica\" role=\"tabpanel\" aria-labelledby=\"basica-tab\">
                    ";
        // line 135
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 135)) > 0)) {
            // line 136
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
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
            // line 151
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 151));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 152
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 154
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 154), "html", null, true);
                yield "</strong>
                                                ";
                // line 155
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 155)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 155), "html", null, true);
                    yield "</small>";
                }
                // line 156
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 156)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 156), "html", null, true);
                    yield "</small>";
                }
                // line 157
                yield "                                            </td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 159
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 159)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 161
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 161)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 161), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 162
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 162)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 162), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 164
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 164)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 167
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 167), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 170
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 170)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 170), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 170)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 170), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 174
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 174), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 177
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 177), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 180
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 180) > 0)) {
                    // line 181
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 181), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 181), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 185
                yield "                                                </div>
                                                ";
                // line 186
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 186) == 0)) {
                    // line 187
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 189
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 192
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 196
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías básicas declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 201
        yield "                </div>

                <!-- Pestaña Complementaria -->
                <div class=\"tab-pane fade\" id=\"complementaria\" role=\"tabpanel\" aria-labelledby=\"complementaria-tab\">
                    ";
        // line 205
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 205)) > 0)) {
            // line 206
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
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
            // line 221
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 221));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 222
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 224
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 224), "html", null, true);
                yield "</strong>
                                                ";
                // line 225
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 225)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 225), "html", null, true);
                    yield "</small>";
                }
                // line 226
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 226)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 226), "html", null, true);
                    yield "</small>";
                }
                // line 227
                yield "                                            </td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 229
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 229)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 231
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 231)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 231), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 232
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 232)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 232), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 234
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 234)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 237
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 237), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 240
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 240)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 240), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 240)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 240), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 244
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 244), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 247
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 247), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 250
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 250) > 0)) {
                    // line 251
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 251), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 251), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 255
                yield "                                                </div>
                                                ";
                // line 256
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 256) == 0)) {
                    // line 257
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 259
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 262
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 266
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías complementarias declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 271
        yield "                </div>

                <!-- Pestaña Otro -->
                <div class=\"tab-pane fade\" id=\"otro\" role=\"tabpanel\" aria-labelledby=\"otro-tab\">
                    ";
        // line 275
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 275)) > 0)) {
            // line 276
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Título</th>
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
            // line 291
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 291));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 292
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 294
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 294), "html", null, true);
                yield "</strong>
                                                ";
                // line 295
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 295)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 295), "html", null, true);
                    yield "</small>";
                }
                // line 296
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 296)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 296), "html", null, true);
                    yield "</small>";
                }
                // line 297
                yield "                                            </td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 299
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 299)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 301
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 301)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 301), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 302
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 302)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 302), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 304
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 304)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 307
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 307), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <small>";
                // line 310
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 310)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_actualizacion", [], "any", false, false, false, 310), "d/m/Y H:i"), "html", null, true);
                } elseif (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 310)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "fecha_vinculacion_creacion", [], "any", false, false, false, 310), "d/m/Y H:i"), "html", null, true);
                } else {
                    yield "N/A";
                }
                yield "</small>
                                            </td>
                                            <td class=\"text-center\">
                                                <div class=\"btn-group\" role=\"group\">
                                                    <a href=\"";
                // line 314
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 314), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Detalles\">
                                                        <i class=\"fas fa-info-circle\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 317
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 317), "html", null, true);
                yield "/buscarCatalogo\" class=\"btn btn-sm btn-secondary\" title=\"Buscar en Catálogo\">
                                                        <i class=\"fas fa-search\"></i>
                                                    </a>
                                                    ";
                // line 320
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 320) > 0)) {
                    // line 321
                    yield "                                                        <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 321), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 321), "js"), "html", null, true);
                    yield "')\" title=\"Ver Disponibles\">
                                                            <i class=\"fas fa-eye\"></i>
                                                        </button>
                                                    ";
                }
                // line 325
                yield "                                                </div>
                                                ";
                // line 326
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 326) == 0)) {
                    // line 327
                    yield "                                                    <div class=\"mt-1\"><small class=\"text-muted\">Sin Bib. Disponibles</small></div>
                                                ";
                }
                // line 329
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 332
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 336
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay otras bibliografías declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 341
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

    // line 366
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 367
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
        return array (  776 => 367,  769 => 366,  741 => 341,  734 => 336,  728 => 332,  720 => 329,  716 => 327,  714 => 326,  711 => 325,  701 => 321,  699 => 320,  691 => 317,  683 => 314,  670 => 310,  664 => 307,  658 => 304,  653 => 302,  649 => 301,  644 => 299,  640 => 297,  633 => 296,  627 => 295,  623 => 294,  619 => 292,  615 => 291,  598 => 276,  596 => 275,  590 => 271,  583 => 266,  577 => 262,  569 => 259,  565 => 257,  563 => 256,  560 => 255,  550 => 251,  548 => 250,  540 => 247,  532 => 244,  519 => 240,  513 => 237,  507 => 234,  502 => 232,  498 => 231,  493 => 229,  489 => 227,  482 => 226,  476 => 225,  472 => 224,  468 => 222,  464 => 221,  447 => 206,  445 => 205,  439 => 201,  432 => 196,  426 => 192,  418 => 189,  414 => 187,  412 => 186,  409 => 185,  399 => 181,  397 => 180,  389 => 177,  381 => 174,  368 => 170,  362 => 167,  356 => 164,  351 => 162,  347 => 161,  342 => 159,  338 => 157,  331 => 156,  325 => 155,  321 => 154,  317 => 152,  313 => 151,  296 => 136,  294 => 135,  282 => 126,  274 => 121,  266 => 116,  253 => 105,  245 => 99,  236 => 96,  230 => 93,  222 => 92,  217 => 90,  213 => 89,  209 => 88,  206 => 87,  202 => 86,  182 => 68,  180 => 67,  172 => 61,  163 => 58,  159 => 57,  155 => 56,  152 => 55,  148 => 54,  121 => 30,  113 => 29,  108 => 27,  100 => 24,  96 => 23,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
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
