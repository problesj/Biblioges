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
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 150
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "basica", [], "any", false, false, false, 150));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 151
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 153
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 153), "html", null, true);
                yield "</strong>
                                                ";
                // line 154
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 154)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 154), "html", null, true);
                    yield "</small>";
                }
                // line 155
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 155)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 155), "html", null, true);
                    yield "</small>";
                }
                // line 156
                yield "                                            </td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 158
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 158)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 160
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 160)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 160), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 161
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 161)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 161), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 163
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 163)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 166
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 166), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                ";
                // line 169
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 169) > 0)) {
                    // line 170
                    yield "                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 170), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 170), "js"), "html", null, true);
                    yield "')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                ";
                } else {
                    // line 174
                    yield "                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
                                                ";
                }
                // line 176
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 179
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 183
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías básicas declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 188
        yield "                </div>

                <!-- Pestaña Complementaria -->
                <div class=\"tab-pane fade\" id=\"complementaria\" role=\"tabpanel\" aria-labelledby=\"complementaria-tab\">
                    ";
        // line 192
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 192)) > 0)) {
            // line 193
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
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 207
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "complementaria", [], "any", false, false, false, 207));
            foreach ($context['_seq'] as $context["_key"] => $context["bib"]) {
                // line 208
                yield "                                        <tr>
                                            <td>
                                                <strong>";
                // line 210
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 210), "html", null, true);
                yield "</strong>
                                                ";
                // line 211
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 211)) {
                    yield "<br><small class=\"text-muted\">Edición: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "edicion", [], "any", false, false, false, 211), "html", null, true);
                    yield "</small>";
                }
                // line 212
                yield "                                                ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 212)) {
                    yield "<br><small class=\"text-muted\">ISBN: ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "isbn", [], "any", false, false, false, 212), "html", null, true);
                    yield "</small>";
                }
                // line 213
                yield "                                            </td>
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 215
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 215)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 217
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 217)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 217), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 218
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 218)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 218), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 220
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 220)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 223
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 223), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                ";
                // line 226
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 226) > 0)) {
                    // line 227
                    yield "                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 227), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 227), "js"), "html", null, true);
                    yield "')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                ";
                } else {
                    // line 231
                    yield "                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
                                                ";
                }
                // line 233
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 236
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 240
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay bibliografías complementarias declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 245
        yield "                </div>

                <!-- Pestaña Otro -->
                <div class=\"tab-pane fade\" id=\"otro\" role=\"tabpanel\" aria-labelledby=\"otro-tab\">
                    ";
        // line 249
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 249)) > 0)) {
            // line 250
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
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 264
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografias"] ?? null), "otro", [], "any", false, false, false, 264));
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
                                            <td>
                                                <span class=\"badge bg-info\">";
                // line 272
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "tipo", [], "any", false, false, false, 272)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td>";
                // line 274
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 274)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "anio_publicacion", [], "any", false, false, false, 274), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td>";
                // line 275
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 275)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "editorial", [], "any", false, false, false, 275), "html", null, true)) : ("N/A"));
                yield "</td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-secondary\">";
                // line 277
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "formato", [], "any", false, false, false, 277)), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                <span class=\"badge bg-warning\">";
                // line 280
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 280), "html", null, true);
                yield "</span>
                                            </td>
                                            <td class=\"text-center\">
                                                ";
                // line 283
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "total_disponibles", [], "any", false, false, false, 283) > 0)) {
                    // line 284
                    yield "                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles(";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "id", [], "any", false, false, false, 284), "html", null, true);
                    yield ", '";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bib"], "titulo", [], "any", false, false, false, 284), "js"), "html", null, true);
                    yield "')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                ";
                } else {
                    // line 288
                    yield "                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
                                                ";
                }
                // line 290
                yield "                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bib'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 293
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 297
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                            <p class=\"text-muted\">No hay otras bibliografías declaradas para esta asignatura.</p>
                        </div>
                    ";
        }
        // line 302
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

    // line 327
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 328
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
        return array (  671 => 328,  664 => 327,  636 => 302,  629 => 297,  623 => 293,  615 => 290,  611 => 288,  601 => 284,  599 => 283,  593 => 280,  587 => 277,  582 => 275,  578 => 274,  573 => 272,  569 => 270,  562 => 269,  556 => 268,  552 => 267,  548 => 265,  544 => 264,  528 => 250,  526 => 249,  520 => 245,  513 => 240,  507 => 236,  499 => 233,  495 => 231,  485 => 227,  483 => 226,  477 => 223,  471 => 220,  466 => 218,  462 => 217,  457 => 215,  453 => 213,  446 => 212,  440 => 211,  436 => 210,  432 => 208,  428 => 207,  412 => 193,  410 => 192,  404 => 188,  397 => 183,  391 => 179,  383 => 176,  379 => 174,  369 => 170,  367 => 169,  361 => 166,  355 => 163,  350 => 161,  346 => 160,  341 => 158,  337 => 156,  330 => 155,  324 => 154,  320 => 153,  316 => 151,  312 => 150,  296 => 136,  294 => 135,  282 => 126,  274 => 121,  266 => 116,  253 => 105,  245 => 99,  236 => 96,  230 => 93,  222 => 92,  217 => 90,  213 => 89,  209 => 88,  206 => 87,  202 => 86,  182 => 68,  180 => 67,  172 => 61,  163 => 58,  159 => 57,  155 => 56,  152 => 55,  148 => 54,  121 => 30,  113 => 29,  108 => 27,  100 => 24,  96 => 23,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
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
                                                {% if bib.total_disponibles > 0 %}
                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                {% else %}
                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
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
                                                {% if bib.total_disponibles > 0 %}
                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                {% else %}
                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
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
                                                {% if bib.total_disponibles > 0 %}
                                                    <button class=\"btn btn-sm btn-primary\" onclick=\"mostrarBibliografiasDisponibles({{ bib.id }}, '{{ bib.titulo|e('js') }}')\">
                                                        <i class=\"fas fa-eye\"></i> Ver Disponibles
                                                    </button>
                                                {% else %}
                                                    <span class=\"text-muted\">Sin Bib. Disponibles</span>
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
