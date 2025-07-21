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

/* bibliografias_disponibles/index.twig */
class __TwigTemplate_b38bcd4511ce9305f04d4ed195f88289 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_disponibles/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografías Disponibles";
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
        <h1>Bibliografías Disponibles</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía
        </a>
    </div>

    ";
        // line 14
        if (($context["error"] ?? null)) {
            // line 15
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 17
        yield "
    ";
        // line 18
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 18)) {
            // line 19
            yield "        <div class=\"alert alert-success\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 19), "html", null, true);
            yield "</div>
    ";
        }
        // line 21
        yield "
    ";
        // line 22
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 22)) {
            // line 23
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 23), "html", null, true);
            yield "</div>
    ";
        }
        // line 25
        yield "
    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body p-0\">
            <form id=\"filtroForm\" class=\"row g-3 p-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                               placeholder=\"Buscar por título o autor...\" value=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 37)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 37), "")) : ("")), "html", null, true);
        yield "\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-3\">
                    <select name=\"disponibilidad\" id=\"disponibilidad\" class=\"form-select\">
                        <option value=\"\">Todas las disponibilidades</option>
                        <option value=\"impreso\" ";
        // line 48
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 48)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 48), "")) : ("")) == "impreso")) {
            yield "selected";
        }
        yield ">Impreso</option>
                        <option value=\"electronico\" ";
        // line 49
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 49)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 49), "")) : ("")) == "electronico")) {
            yield "selected";
        }
        yield ">Electrónico</option>
                        <option value=\"ambos\" ";
        // line 50
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 50)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 50), "")) : ("")) == "ambos")) {
            yield "selected";
        }
        yield ">Ambos</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <select name=\"estado\" id=\"estado\" class=\"form-select\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" ";
        // line 56
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 56)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 56), "")) : ("")) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 57
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 57)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 57), "")) : ("")) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                           placeholder=\"Año edición\" value=\"";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", true, true, false, 62)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 62), "")) : ("")), "html", null, true);
        yield "\"
                           min=\"1900\" max=\"";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "\">
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <button type=\"button\" class=\"btn btn-secondary\" onclick=\"limpiarFiltros()\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 80
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 81
            yield "        <div class=\"card\">
            <div class=\"card-body p-0\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100 mb-0\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>
                                    <a href=\"";
            // line 88
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=titulo&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 88) == "titulo") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 88) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 88)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 88)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 88)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 88)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 88))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 88)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 88)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 88)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Título
                                        ";
            // line 90
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 90) == "titulo")) {
                // line 91
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 91) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 93
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 95
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 98
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=editorial&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 98) == "editorial") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 98) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 98)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 98)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 98)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 98)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 98))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 98)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 98)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 98)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Editorial
                                        ";
            // line 100
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 100) == "editorial")) {
                // line 101
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 101) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 103
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 105
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 108
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=autores&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 108) == "autores") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 108) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 108)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 108)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 108)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 108)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 108))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 108)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 108)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 108)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Autor(es)
                                        ";
            // line 110
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 110) == "autores")) {
                // line 111
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 111) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 113
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 115
            yield "                                    </a>
                                </th>
                                <th class=\"text-center\">Año Edición</th>
                                <th class=\"text-center\">Disponibilidad</th>
                                <th class=\"text-center\">URL Acceso</th>
                                <th class=\"text-center\">URL Catálogo</th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 125
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 126
                yield "                            <tr>
                                <td>
                                        ";
                // line 128
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 128), "html", null, true);
                yield "
                                </td>
                                <td>";
                // line 130
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 130), "html", null, true);
                yield "</td>
                                <td>
                                    ";
                // line 132
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 132));
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
                foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                    // line 133
                    yield "                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 133), "html", null, true);
                    yield ", ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 133), "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 133)) {
                        yield "; ";
                    }
                    // line 134
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
                unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 135
                yield "                                </td>
                                <td class=\"text-center\">";
                // line 136
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_edicion", [], "any", false, false, false, 136), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 138
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibilidad", [], "any", false, false, false, 138) == "impreso")) {
                    // line 139
                    yield "                                        <span class=\"badge bg-primary\">Impreso</span>
                                    ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 140
$context["bibliografia"], "disponibilidad", [], "any", false, false, false, 140) == "electronico")) {
                    // line 141
                    yield "                                        <span class=\"badge bg-success\">Electrónico</span>
                                    ";
                } else {
                    // line 143
                    yield "                                        <span class=\"badge bg-info\">Ambos</span>
                                    ";
                }
                // line 145
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 147
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 147)) {
                    // line 148
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 148), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 152
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 154
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 154)) {
                    // line 155
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 155), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 159
                yield "                                </td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <a href=\"";
                // line 162
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 162), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 165
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 165), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                                onclick=\"confirmarEliminacion(";
                // line 169
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 169), "html", null, true);
                yield ")\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 176
            yield "                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                ";
            // line 181
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 181) > 1)) {
                // line 182
                yield "                <div class=\"d-flex justify-content-between align-items-center mt-4\">
                    <div class=\"text-muted\">
                        Mostrando ";
                // line 184
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 184) - 1) * 20) + 1), "html", null, true);
                yield " a ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(min((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 184) * 20), CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 184)), "html", null, true);
                yield " de ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 184), "html", null, true);
                yield " registros
                    </div>
                    <nav aria-label=\"Navegación de páginas\">
                        <ul class=\"pagination mb-0\">
                            <!-- Primera página -->
                            <li class=\"page-item ";
                // line 189
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 189) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 190
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=1";
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 190)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 190)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 190))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 190)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 190)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 190)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 190)), "html", null, true)) : (""));
                yield "\" aria-label=\"Primera\">
                                    <i class=\"fas fa-angle-double-left\"></i>
                                </a>
                            </li>
                            <!-- Página anterior -->
                            <li class=\"page-item ";
                // line 195
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 195) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 196
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 196) - 1), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 196)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 196)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 196))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 196)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 196)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 196)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 196)), "html", null, true)) : (""));
                yield "\" aria-label=\"Anterior\">
                                    <i class=\"fas fa-angle-left\"></i>
                                </a>
                            </li>

                            <!-- Números de página -->
                            ";
                // line 202
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 202) - 2));
                // line 203
                yield "                            ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 203), (($context["inicio"] ?? null) + 4));
                // line 204
                yield "                            ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 205
                    yield "                                ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 206
                    yield "                            ";
                }
                // line 207
                yield "
                            ";
                // line 208
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 209
                    yield "                                <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 209))) {
                        yield "active";
                    }
                    yield "\">
                                    <a class=\"page-link\" href=\"";
                    // line 210
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "bibliografias-disponibles?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 210)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 210)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 210))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 210)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 210)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 210)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 210)), "html", null, true)) : (""));
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "</a>
                                </li>
                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 213
                yield "
                            <!-- Página siguiente -->
                            <li class=\"page-item ";
                // line 215
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 215) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 215))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 216
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 216) + 1), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 216)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 216)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 216))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 216)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 216)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 216)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 216)), "html", null, true)) : (""));
                yield "\" aria-label=\"Siguiente\">
                                    <i class=\"fas fa-angle-right\"></i>
                                </a>
                            </li>
                            <!-- Última página -->
                            <li class=\"page-item ";
                // line 221
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 221) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 221))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 222
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 222), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 222)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 222)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 222))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 222)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 222)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 222)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 222)), "html", null, true)) : (""));
                yield "\" aria-label=\"Última\">
                                    <i class=\"fas fa-angle-double-right\"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                ";
            }
            // line 230
            yield "            </div>
        </div>
    ";
        } else {
            // line 233
            yield "        <div class=\"alert alert-info\">
            No hay bibliografías disponibles registradas.
        </div>
    ";
        }
        // line 237
        yield "</div>

";
        // line 240
        yield "<div class=\"modal fade\" id=\"modalEliminar\" tabindex=\"-1\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Confirmar Eliminación</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
            </div>
            <div class=\"modal-body\">
                ¿Está seguro que desea eliminar esta bibliografía disponible?
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <form id=\"formEliminar\" method=\"POST\" style=\"display: inline;\">
                    <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                    <button type=\"submit\" class=\"btn btn-danger\">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 262
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 263
        yield "<script>
function confirmarEliminacion(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const form = document.getElementById('formEliminar');
    form.action = '";
        // line 267
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/' + id + '/delete';
    modal.show();
}

function limpiarFiltros() {
    document.getElementById('busqueda').value = '';
    document.getElementById('disponibilidad').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('anio_edicion').value = '';
    document.getElementById('filtroForm').submit();
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
        return "bibliografias_disponibles/index.twig";
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
        return array (  670 => 267,  664 => 263,  657 => 262,  632 => 240,  628 => 237,  622 => 233,  617 => 230,  598 => 222,  592 => 221,  576 => 216,  570 => 215,  566 => 213,  547 => 210,  540 => 209,  536 => 208,  533 => 207,  530 => 206,  527 => 205,  524 => 204,  521 => 203,  519 => 202,  502 => 196,  496 => 195,  481 => 190,  475 => 189,  463 => 184,  459 => 182,  457 => 181,  450 => 176,  437 => 169,  428 => 165,  420 => 162,  415 => 159,  407 => 155,  405 => 154,  401 => 152,  393 => 148,  391 => 147,  387 => 145,  383 => 143,  379 => 141,  377 => 140,  374 => 139,  372 => 138,  367 => 136,  364 => 135,  350 => 134,  342 => 133,  325 => 132,  320 => 130,  315 => 128,  311 => 126,  307 => 125,  295 => 115,  291 => 113,  285 => 111,  283 => 110,  272 => 108,  267 => 105,  263 => 103,  257 => 101,  255 => 100,  244 => 98,  239 => 95,  235 => 93,  229 => 91,  227 => 90,  216 => 88,  207 => 81,  205 => 80,  185 => 63,  181 => 62,  171 => 57,  165 => 56,  154 => 50,  148 => 49,  142 => 48,  128 => 37,  114 => 25,  108 => 23,  106 => 22,  103 => 21,  97 => 19,  95 => 18,  92 => 17,  86 => 15,  84 => 14,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Bibliografías Disponibles{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Bibliografías Disponibles</h1>
        <a href=\"{{ app_url }}bibliografias-disponibles/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía
        </a>
    </div>

    {% if error %}
        <div class=\"alert alert-danger\">{{ error }}</div>
    {% endif %}

    {% if session.success %}
        <div class=\"alert alert-success\">{{ session.success }}</div>
    {% endif %}

    {% if session.error %}
        <div class=\"alert alert-danger\">{{ session.error }}</div>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body p-0\">
            <form id=\"filtroForm\" class=\"row g-3 p-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                               placeholder=\"Buscar por título o autor...\" value=\"{{ filtros.busqueda|default('') }}\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-3\">
                    <select name=\"disponibilidad\" id=\"disponibilidad\" class=\"form-select\">
                        <option value=\"\">Todas las disponibilidades</option>
                        <option value=\"impreso\" {% if filtros.disponibilidad|default('') == 'impreso' %}selected{% endif %}>Impreso</option>
                        <option value=\"electronico\" {% if filtros.disponibilidad|default('') == 'electronico' %}selected{% endif %}>Electrónico</option>
                        <option value=\"ambos\" {% if filtros.disponibilidad|default('') == 'ambos' %}selected{% endif %}>Ambos</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <select name=\"estado\" id=\"estado\" class=\"form-select\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" {% if filtros.estado|default('') == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado|default('') == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                           placeholder=\"Año edición\" value=\"{{ filtros.anio_edicion|default('') }}\"
                           min=\"1900\" max=\"{{ \"now\"|date(\"Y\") }}\">
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <button type=\"button\" class=\"btn btn-secondary\" onclick=\"limpiarFiltros()\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {% if bibliografias|length > 0 %}
        <div class=\"card\">
            <div class=\"card-body p-0\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100 mb-0\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>
                                    <a href=\"{{ app_url }}bibliografias-disponibles?orden=titulo&direccion={{ filtros.orden == 'titulo' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}\" class=\"text-dark text-decoration-none\">
                                        Título
                                        {% if filtros.orden == 'titulo' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ app_url }}bibliografias-disponibles?orden=editorial&direccion={{ filtros.orden == 'editorial' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}\" class=\"text-dark text-decoration-none\">
                                        Editorial
                                        {% if filtros.orden == 'editorial' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ app_url }}bibliografias-disponibles?orden=autores&direccion={{ filtros.orden == 'autores' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}\" class=\"text-dark text-decoration-none\">
                                        Autor(es)
                                        {% if filtros.orden == 'autores' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th class=\"text-center\">Año Edición</th>
                                <th class=\"text-center\">Disponibilidad</th>
                                <th class=\"text-center\">URL Acceso</th>
                                <th class=\"text-center\">URL Catálogo</th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for bibliografia in bibliografias %}
                            <tr>
                                <td>
                                        {{ bibliografia.titulo }}
                                </td>
                                <td>{{ bibliografia.editorial }}</td>
                                <td>
                                    {% for autor in bibliografia.autores %}
                                        {{ autor.apellidos }}, {{ autor.nombres }}{% if not loop.last %}; {% endif %}
                                    {% endfor %}
                                </td>
                                <td class=\"text-center\">{{ bibliografia.anio_edicion }}</td>
                                <td class=\"text-center\">
                                    {% if bibliografia.disponibilidad == 'impreso' %}
                                        <span class=\"badge bg-primary\">Impreso</span>
                                    {% elseif bibliografia.disponibilidad == 'electronico' %}
                                        <span class=\"badge bg-success\">Electrónico</span>
                                    {% else %}
                                        <span class=\"badge bg-info\">Ambos</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    {% if bibliografia.url_acceso %}
                                        <a href=\"{{ bibliografia.url_acceso }}\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    {% if bibliografia.url_catalogo %}
                                        <a href=\"{{ bibliografia.url_catalogo }}\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <a href=\"{{ app_url }}bibliografias-disponibles/{{ bibliografia.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"{{ app_url }}bibliografias-disponibles/{{ bibliografia.id }}/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                                onclick=\"confirmarEliminacion({{ bibliografia.id }})\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                {% if filtros.total_paginas > 1 %}
                <div class=\"d-flex justify-content-between align-items-center mt-4\">
                    <div class=\"text-muted\">
                        Mostrando {{ (filtros.pagina - 1) * 20 + 1 }} a {{ min(filtros.pagina * 20, filtros.total_registros) }} de {{ filtros.total_registros }} registros
                    </div>
                    <nav aria-label=\"Navegación de páginas\">
                        <ul class=\"pagination mb-0\">
                            <!-- Primera página -->
                            <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ app_url }}bibliografias-disponibles?pagina=1{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}{{ filtros.orden ? '&orden=' ~ filtros.orden : '' }}{{ filtros.direccion ? '&direccion=' ~ filtros.direccion : '' }}\" aria-label=\"Primera\">
                                    <i class=\"fas fa-angle-double-left\"></i>
                                </a>
                            </li>
                            <!-- Página anterior -->
                            <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ app_url }}bibliografias-disponibles?pagina={{ filtros.pagina - 1 }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}{{ filtros.orden ? '&orden=' ~ filtros.orden : '' }}{{ filtros.direccion ? '&direccion=' ~ filtros.direccion : '' }}\" aria-label=\"Anterior\">
                                    <i class=\"fas fa-angle-left\"></i>
                                </a>
                            </li>

                            <!-- Números de página -->
                            {% set inicio = max(1, filtros.pagina - 2) %}
                            {% set fin = min(filtros.total_paginas, inicio + 4) %}
                            {% if fin - inicio < 4 %}
                                {% set inicio = max(1, fin - 4) %}
                            {% endif %}

                            {% for i in inicio..fin %}
                                <li class=\"page-item {% if i == filtros.pagina %}active{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}bibliografias-disponibles?pagina={{ i }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}{{ filtros.orden ? '&orden=' ~ filtros.orden : '' }}{{ filtros.direccion ? '&direccion=' ~ filtros.direccion : '' }}\">{{ i }}</a>
                                </li>
                            {% endfor %}

                            <!-- Página siguiente -->
                            <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ app_url }}bibliografias-disponibles?pagina={{ filtros.pagina + 1 }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}{{ filtros.orden ? '&orden=' ~ filtros.orden : '' }}{{ filtros.direccion ? '&direccion=' ~ filtros.direccion : '' }}\" aria-label=\"Siguiente\">
                                    <i class=\"fas fa-angle-right\"></i>
                                </a>
                            </li>
                            <!-- Última página -->
                            <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ app_url }}bibliografias-disponibles?pagina={{ filtros.total_paginas }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.disponibilidad ? '&disponibilidad=' ~ filtros.disponibilidad : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}{{ filtros.anio_edicion ? '&anio_edicion=' ~ filtros.anio_edicion : '' }}{{ filtros.orden ? '&orden=' ~ filtros.orden : '' }}{{ filtros.direccion ? '&direccion=' ~ filtros.direccion : '' }}\" aria-label=\"Última\">
                                    <i class=\"fas fa-angle-double-right\"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                {% endif %}
            </div>
        </div>
    {% else %}
        <div class=\"alert alert-info\">
            No hay bibliografías disponibles registradas.
        </div>
    {% endif %}
</div>

{# Modal de confirmación de eliminación #}
<div class=\"modal fade\" id=\"modalEliminar\" tabindex=\"-1\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Confirmar Eliminación</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
            </div>
            <div class=\"modal-body\">
                ¿Está seguro que desea eliminar esta bibliografía disponible?
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <form id=\"formEliminar\" method=\"POST\" style=\"display: inline;\">
                    <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                    <button type=\"submit\" class=\"btn btn-danger\">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
function confirmarEliminacion(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const form = document.getElementById('formEliminar');
    form.action = '{{ app_url }}bibliografias-disponibles/' + id + '/delete';
    modal.show();
}

function limpiarFiltros() {
    document.getElementById('busqueda').value = '';
    document.getElementById('disponibilidad').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('anio_edicion').value = '';
    document.getElementById('filtroForm').submit();
}
</script>
{% endblock %} ", "bibliografias_disponibles/index.twig", "/var/www/html/biblioges/templates/bibliografias_disponibles/index.twig");
    }
}
