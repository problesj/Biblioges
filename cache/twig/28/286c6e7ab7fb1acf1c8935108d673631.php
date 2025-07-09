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
        yield "<div class=\"container mt-4\">
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
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
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
                <div class=\"col-md-2\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <button type=\"button\" class=\"btn btn-secondary w-100\" onclick=\"limpiarFiltros()\">
                        <i class=\"fas fa-times\"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 79
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 80
            yield "        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>
                                    <a href=\"";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=titulo&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 87) == "titulo") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 87) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 87)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 87)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 87)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 87)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 87))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 87)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 87)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 87)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Título
                                        ";
            // line 89
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 89) == "titulo")) {
                // line 90
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 90) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 92
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 94
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=editorial&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 97) == "editorial") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 97) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 97)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 97)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 97)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 97)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 97))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 97)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 97)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 97)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Editorial
                                        ";
            // line 99
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 99) == "editorial")) {
                // line 100
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 100) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 102
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 104
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 107
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles?orden=autores&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 107) == "autores") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 107) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 107)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 107)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 107)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 107)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 107))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 107)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 107)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 107)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Autor(es)
                                        ";
            // line 109
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 109) == "autores")) {
                // line 110
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 110) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 112
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 114
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
            // line 124
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 125
                yield "                            <tr>
                                <td>
                                        ";
                // line 127
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 127), "html", null, true);
                yield "
                                </td>
                                <td>";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 129), "html", null, true);
                yield "</td>
                                <td>
                                    ";
                // line 131
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 131));
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
                    // line 132
                    yield "                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 132), "html", null, true);
                    yield ", ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 132), "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 132)) {
                        yield "; ";
                    }
                    // line 133
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
                // line 134
                yield "                                </td>
                                <td class=\"text-center\">";
                // line 135
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_edicion", [], "any", false, false, false, 135), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 137
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibilidad", [], "any", false, false, false, 137) == "impreso")) {
                    // line 138
                    yield "                                        <span class=\"badge bg-primary\">Impreso</span>
                                    ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 139
$context["bibliografia"], "disponibilidad", [], "any", false, false, false, 139) == "electronico")) {
                    // line 140
                    yield "                                        <span class=\"badge bg-success\">Electrónico</span>
                                    ";
                } else {
                    // line 142
                    yield "                                        <span class=\"badge bg-info\">Ambos</span>
                                    ";
                }
                // line 144
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 146
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 146)) {
                    // line 147
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 147), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 151
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 153
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 153)) {
                    // line 154
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 154), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 158
                yield "                                </td>
                                <td class=\"text-center\">
                                    <div class=\"btn-group\">
                                        <a href=\"";
                // line 161
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 161), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 164
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 164), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                                onclick=\"confirmarEliminacion(";
                // line 168
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 168), "html", null, true);
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
            // line 175
            yield "                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                ";
            // line 180
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 180) > 1)) {
                // line 181
                yield "                <div class=\"d-flex justify-content-between align-items-center mt-4\">
                    <div class=\"text-muted\">
                        Mostrando ";
                // line 183
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 183) - 1) * 20) + 1), "html", null, true);
                yield " a ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(min((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 183) * 20), CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 183)), "html", null, true);
                yield " de ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 183), "html", null, true);
                yield " registros
                    </div>
                    <nav aria-label=\"Navegación de páginas\">
                        <ul class=\"pagination mb-0\">
                            <!-- Primera página -->
                            <li class=\"page-item ";
                // line 188
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 188) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 189
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=1";
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 189)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 189)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 189))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 189)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 189)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 189)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 189)), "html", null, true)) : (""));
                yield "\" aria-label=\"Primera\">
                                    <i class=\"fas fa-angle-double-left\"></i>
                                </a>
                            </li>
                            <!-- Página anterior -->
                            <li class=\"page-item ";
                // line 194
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 194) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 195
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 195) - 1), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 195)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 195)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 195))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 195)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 195)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 195)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 195)), "html", null, true)) : (""));
                yield "\" aria-label=\"Anterior\">
                                    <i class=\"fas fa-angle-left\"></i>
                                </a>
                            </li>

                            <!-- Números de página -->
                            ";
                // line 201
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 201) - 2));
                // line 202
                yield "                            ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 202), (($context["inicio"] ?? null) + 4));
                // line 203
                yield "                            ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 204
                    yield "                                ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 205
                    yield "                            ";
                }
                // line 206
                yield "
                            ";
                // line 207
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 208
                    yield "                                <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 208))) {
                        yield "active";
                    }
                    yield "\">
                                    <a class=\"page-link\" href=\"";
                    // line 209
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "bibliografias-disponibles?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 209)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 209)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 209))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 209)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 209)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 209)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 209)), "html", null, true)) : (""));
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "</a>
                                </li>
                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 212
                yield "
                            <!-- Página siguiente -->
                            <li class=\"page-item ";
                // line 214
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 214) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 214))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 215
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 215) + 1), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 215)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 215)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 215))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 215)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 215)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 215)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 215)), "html", null, true)) : (""));
                yield "\" aria-label=\"Siguiente\">
                                    <i class=\"fas fa-angle-right\"></i>
                                </a>
                            </li>
                            <!-- Última página -->
                            <li class=\"page-item ";
                // line 220
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 220) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 220))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 221
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 221), "html", null, true);
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 221)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 221)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&disponibilidad=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 221))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 221)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&anio_edicion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 221)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&orden=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 221)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&direccion=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 221)), "html", null, true)) : (""));
                yield "\" aria-label=\"Última\">
                                    <i class=\"fas fa-angle-double-right\"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                ";
            }
            // line 229
            yield "            </div>
        </div>
    ";
        } else {
            // line 232
            yield "        <div class=\"alert alert-info\">
            No hay bibliografías disponibles registradas.
        </div>
    ";
        }
        // line 236
        yield "</div>

";
        // line 239
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

    // line 261
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 262
        yield "<script>
function confirmarEliminacion(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    const form = document.getElementById('formEliminar');
    form.action = '";
        // line 266
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
        return array (  669 => 266,  663 => 262,  656 => 261,  631 => 239,  627 => 236,  621 => 232,  616 => 229,  597 => 221,  591 => 220,  575 => 215,  569 => 214,  565 => 212,  546 => 209,  539 => 208,  535 => 207,  532 => 206,  529 => 205,  526 => 204,  523 => 203,  520 => 202,  518 => 201,  501 => 195,  495 => 194,  480 => 189,  474 => 188,  462 => 183,  458 => 181,  456 => 180,  449 => 175,  436 => 168,  427 => 164,  419 => 161,  414 => 158,  406 => 154,  404 => 153,  400 => 151,  392 => 147,  390 => 146,  386 => 144,  382 => 142,  378 => 140,  376 => 139,  373 => 138,  371 => 137,  366 => 135,  363 => 134,  349 => 133,  341 => 132,  324 => 131,  319 => 129,  314 => 127,  310 => 125,  306 => 124,  294 => 114,  290 => 112,  284 => 110,  282 => 109,  271 => 107,  266 => 104,  262 => 102,  256 => 100,  254 => 99,  243 => 97,  238 => 94,  234 => 92,  228 => 90,  226 => 89,  215 => 87,  206 => 80,  204 => 79,  185 => 63,  181 => 62,  171 => 57,  165 => 56,  154 => 50,  148 => 49,  142 => 48,  128 => 37,  114 => 25,  108 => 23,  106 => 22,  103 => 21,  97 => 19,  95 => 18,  92 => 17,  86 => 15,  84 => 14,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Bibliografías Disponibles{% endblock %}

{% block content %}
<div class=\"container mt-4\">
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
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
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
                <div class=\"col-md-2\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <button type=\"button\" class=\"btn btn-secondary w-100\" onclick=\"limpiarFiltros()\">
                        <i class=\"fas fa-times\"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {% if bibliografias|length > 0 %}
        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover\">
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
