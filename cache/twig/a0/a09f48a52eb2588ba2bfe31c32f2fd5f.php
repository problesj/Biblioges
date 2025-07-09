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

/* autores/index.twig */
class __TwigTemplate_58332a287678e1082be4021ae2011a82 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Autores";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "    ";
        yield from $this->yieldParentBlock("stylesheets", $context, $blocks);
        yield "
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
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
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Autores</h1>
        <a href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nuevo Autor
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"row g-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" placeholder=\"Buscar...\" value=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 29)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 29), "")) : ("")), "html", null, true);
        yield "\">
                        <select class=\"form-select\" id=\"tipo_busqueda\" name=\"tipo_busqueda\" style=\"max-width: 150px;\">
                            <option value=\"todos\" ";
        // line 31
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 31)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 31), "todos")) : ("todos")) == "todos")) {
            yield "selected";
        }
        yield ">Todos</option>
                            <option value=\"apellidos\" ";
        // line 32
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 32)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 32), "")) : ("")) == "apellidos")) {
            yield "selected";
        }
        yield ">Apellidos</option>
                            <option value=\"nombres\" ";
        // line 33
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 33)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 33), "")) : ("")) == "nombres")) {
            yield "selected";
        }
        yield ">Nombres</option>
                        </select>
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"genero\" name=\"genero\">
                        <option value=\"\">Todos los géneros</option>
                        <option value=\"M\" ";
        // line 45
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 45)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 45), "")) : ("")) == "M")) {
            yield "selected";
        }
        yield ">Masculino</option>
                        <option value=\"F\" ";
        // line 46
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 46)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 46), "")) : ("")) == "F")) {
            yield "selected";
        }
        yield ">Femenino</option>
                        <option value=\"O\" ";
        // line 47
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 47)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 47), "")) : ("")) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <a href=\"";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"btn btn-secondary w-100\">
                        <i class=\"fas fa-times\"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 64
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)) > 0)) {
            // line 65
            yield "        <div class=\"card\">
            <div class=\"card-header\">
                <h3 class=\"card-title\">Listado de Autores</h3>
                <div class=\"card-tools\">
                    <a href=\"";
            // line 69
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/duplicados-globales\" class=\"btn btn-warning\">
                        <i class=\"fas fa-search\"></i> Buscar Duplicados Globales
                    </a>
                    <a href=\"";
            // line 72
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/create\" class=\"btn btn-primary\">
                        <i class=\"fas fa-plus\"></i> Nuevo Autor
                    </a>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>
                                    <a href=\"";
            // line 83
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=apellidos&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 83) == "apellidos") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 83) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Apellidos
                                        ";
            // line 85
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 85) == "apellidos")) {
                // line 86
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 86) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 88
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 90
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=nombres&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 93) == "nombres") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 93) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Nombres
                                        ";
            // line 95
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 95) == "nombres")) {
                // line 96
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 96) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 98
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 100
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 103
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=genero&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 103) == "genero") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 103) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Género
                                        ";
            // line 105
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 105) == "genero")) {
                // line 106
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 106) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 108
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 110
            yield "                                    </a>
                                </th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 116
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["autores"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                // line 117
                yield "                                <tr>
                                    <td>";
                // line 118
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 118), "html", null, true);
                yield "</td>
                                    <td>";
                // line 119
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 119), "html", null, true);
                yield "</td>
                                    <td>";
                // line 120
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 120), "html", null, true);
                yield "</td>
                                    <td>
                                        <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                            <a href=\"";
                // line 123
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 123), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-info\">
                                                <i class=\"fas fa-edit\"></i> Editar
                                            </a>
                                            <a href=\"";
                // line 126
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 126), "html", null, true);
                yield "/duplicados\" class=\"btn btn-sm btn-warning\">
                                                <i class=\"fas fa-search\"></i> Buscar Duplicados
                                            </a>
                                            <form method=\"POST\" action=\"";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 129), "html", null, true);
                yield "/delete\" class=\"d-inline delete-form\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-danger\">
                                                    <i class=\"fas fa-trash\"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 138
            yield "                        </tbody>
                    </table>
                </div>

                ";
            // line 143
            yield "                ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 143) > 1)) {
                // line 144
                yield "                <div class=\"row mt-4\">
                    <div class=\"col-md-6\">
                        <p class=\"text-muted\">
                            Mostrando ";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 147) - 1) * 20) + 1), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(min((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 147) * 20), CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 147)), "html", null, true);
                yield " de ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 147), "html", null, true);
                yield " registros
                        </p>
                    </div>
                    <div class=\"col-md-6\">
                        <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                            <ul class=\"pagination mb-0\">
                                ";
                // line 154
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 154) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=1";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 155)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 155), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 155)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 155), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 155)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 155), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 155)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 155), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 155)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 155), "html", null, true);
                }
                yield "\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 161
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 161) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 162
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 162) - 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 162)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 162), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 162)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 162), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 162)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 162), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 162)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 162), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 162)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 162), "html", null, true);
                }
                yield "\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 168
                yield "                                ";
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 168) - 2));
                // line 169
                yield "                                ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 169), (($context["inicio"] ?? null) + 4));
                // line 170
                yield "                                ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 171
                    yield "                                    ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 172
                    yield "                                ";
                }
                // line 173
                yield "
                                ";
                // line 174
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 175
                    yield "                                    <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 175))) {
                        yield "active";
                    }
                    yield "\">
                                        <a class=\"page-link\" href=\"";
                    // line 176
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "autores?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 176)) {
                        yield "&busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 176), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 176)) {
                        yield "&tipo_busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 176), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 176)) {
                        yield "&genero=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 176), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 176)) {
                        yield "&orden=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 176), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 176)) {
                        yield "&direccion=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 176), "html", null, true);
                    }
                    yield "\">
                                            ";
                    // line 177
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "
                                        </a>
                                    </li>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 181
                yield "
                                ";
                // line 183
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 183) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 183))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 184
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 184) + 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 184)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 184), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 184)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 184), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 184)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 184), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 184)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 184), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 184)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 184), "html", null, true);
                }
                yield "\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                ";
                // line 190
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 190) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 190))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 191
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 191), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 191)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 191), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 191)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 191), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 191)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 191), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 191)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 191), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 191)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 191), "html", null, true);
                }
                yield "\" aria-label=\"Última\">
                                        <i class=\"fas fa-angle-double-right\"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                ";
            }
            // line 200
            yield "            </div>
        </div>
    ";
        } else {
            // line 203
            yield "        <div class=\"alert alert-info\">
            No se encontraron autores que coincidan con los criterios de búsqueda.
        </div>
    ";
        }
        // line 207
        yield "</div>
";
        yield from [];
    }

    // line 210
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 211
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
        // line 215
        if (($context["success"] ?? null)) {
            // line 216
            yield "                Swal.fire({
                    title: '";
            // line 217
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "title", [], "any", false, false, false, 217), "html", null, true);
            yield "',
                    text: '";
            // line 218
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "text", [], "any", false, false, false, 218), "html", null, true);
            yield "',
                    icon: '";
            // line 219
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "icon", [], "any", false, false, false, 219), "html", null, true);
            yield "'
                });
            ";
        }
        // line 222
        yield "
            ";
        // line 223
        if (($context["error"] ?? null)) {
            // line 224
            yield "                Swal.fire({
                    title: '";
            // line 225
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "title", [], "any", false, false, false, 225), "html", null, true);
            yield "',
                    text: '";
            // line 226
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "text", [], "any", false, false, false, 226), "html", null, true);
            yield "',
                    icon: '";
            // line 227
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "icon", [], "any", false, false, false, 227), "html", null, true);
            yield "'
                });
            ";
        }
        // line 230
        yield "
            // Manejar la eliminación de autores
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: \"Esta acción no se puede deshacer\",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
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
        return "autores/index.twig";
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
        return array (  670 => 230,  664 => 227,  660 => 226,  656 => 225,  653 => 224,  651 => 223,  648 => 222,  642 => 219,  638 => 218,  634 => 217,  631 => 216,  629 => 215,  621 => 211,  614 => 210,  608 => 207,  602 => 203,  597 => 200,  563 => 191,  556 => 190,  526 => 184,  519 => 183,  516 => 181,  506 => 177,  480 => 176,  473 => 175,  469 => 174,  466 => 173,  463 => 172,  460 => 171,  457 => 170,  454 => 169,  451 => 168,  421 => 162,  414 => 161,  385 => 155,  378 => 154,  365 => 147,  360 => 144,  357 => 143,  351 => 138,  334 => 129,  326 => 126,  318 => 123,  312 => 120,  308 => 119,  304 => 118,  301 => 117,  297 => 116,  289 => 110,  285 => 108,  279 => 106,  277 => 105,  267 => 103,  262 => 100,  258 => 98,  252 => 96,  250 => 95,  240 => 93,  235 => 90,  231 => 88,  225 => 86,  223 => 85,  213 => 83,  199 => 72,  193 => 69,  187 => 65,  185 => 64,  174 => 56,  160 => 47,  154 => 46,  148 => 45,  131 => 33,  125 => 32,  119 => 31,  114 => 29,  107 => 25,  93 => 14,  88 => 11,  81 => 10,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Autores{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Autores</h1>
        <a href=\"{{ app_url }}autores/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nuevo Autor
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}autores\" class=\"row g-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" placeholder=\"Buscar...\" value=\"{{ filtros.busqueda|default('') }}\">
                        <select class=\"form-select\" id=\"tipo_busqueda\" name=\"tipo_busqueda\" style=\"max-width: 150px;\">
                            <option value=\"todos\" {% if filtros.tipo_busqueda|default('todos') == 'todos' %}selected{% endif %}>Todos</option>
                            <option value=\"apellidos\" {% if filtros.tipo_busqueda|default('') == 'apellidos' %}selected{% endif %}>Apellidos</option>
                            <option value=\"nombres\" {% if filtros.tipo_busqueda|default('') == 'nombres' %}selected{% endif %}>Nombres</option>
                        </select>
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"genero\" name=\"genero\">
                        <option value=\"\">Todos los géneros</option>
                        <option value=\"M\" {% if filtros.genero|default('') == 'M' %}selected{% endif %}>Masculino</option>
                        <option value=\"F\" {% if filtros.genero|default('') == 'F' %}selected{% endif %}>Femenino</option>
                        <option value=\"O\" {% if filtros.genero|default('') == 'O' %}selected{% endif %}>Otro</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary w-100\">
                        <i class=\"fas fa-times\"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {% if autores|length > 0 %}
        <div class=\"card\">
            <div class=\"card-header\">
                <h3 class=\"card-title\">Listado de Autores</h3>
                <div class=\"card-tools\">
                    <a href=\"{{ app_url }}autores/duplicados-globales\" class=\"btn btn-warning\">
                        <i class=\"fas fa-search\"></i> Buscar Duplicados Globales
                    </a>
                    <a href=\"{{ app_url }}autores/create\" class=\"btn btn-primary\">
                        <i class=\"fas fa-plus\"></i> Nuevo Autor
                    </a>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100\">
                        <thead class=\"table-light\">
                            <tr>
                                <th>
                                    <a href=\"{{ app_url }}autores?orden=apellidos&direccion={{ filtros.orden == 'apellidos' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-dark text-decoration-none\">
                                        Apellidos
                                        {% if filtros.orden == 'apellidos' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ app_url }}autores?orden=nombres&direccion={{ filtros.orden == 'nombres' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-dark text-decoration-none\">
                                        Nombres
                                        {% if filtros.orden == 'nombres' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ app_url }}autores?orden=genero&direccion={{ filtros.orden == 'genero' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-dark text-decoration-none\">
                                        Género
                                        {% if filtros.orden == 'genero' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for autor in autores %}
                                <tr>
                                    <td>{{ autor.apellidos }}</td>
                                    <td>{{ autor.nombres }}</td>
                                    <td>{{ autor.genero }}</td>
                                    <td>
                                        <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                            <a href=\"{{ app_url }}autores/{{ autor.id }}/edit\" class=\"btn btn-sm btn-info\">
                                                <i class=\"fas fa-edit\"></i> Editar
                                            </a>
                                            <a href=\"{{ app_url }}autores/{{ autor.id }}/duplicados\" class=\"btn btn-sm btn-warning\">
                                                <i class=\"fas fa-search\"></i> Buscar Duplicados
                                            </a>
                                            <form method=\"POST\" action=\"{{ app_url }}autores/{{ autor.id }}/delete\" class=\"d-inline delete-form\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-danger\">
                                                    <i class=\"fas fa-trash\"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>

                {# Paginación #}
                {% if filtros.total_paginas > 1 %}
                <div class=\"row mt-4\">
                    <div class=\"col-md-6\">
                        <p class=\"text-muted\">
                            Mostrando {{ ((filtros.pagina - 1) * 20) + 1 }} - {{ min(filtros.pagina * 20, filtros.total_registros) }} de {{ filtros.total_registros }} registros
                        </p>
                    </div>
                    <div class=\"col-md-6\">
                        <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                            <ul class=\"pagination mb-0\">
                                {# Botón Primera Página #}
                                <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}autores?pagina=1{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                {# Botón Página Anterior #}
                                <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.pagina - 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                {# Números de Página #}
                                {% set inicio = max(1, filtros.pagina - 2) %}
                                {% set fin = min(filtros.total_paginas, inicio + 4) %}
                                {% if fin - inicio < 4 %}
                                    {% set inicio = max(1, fin - 4) %}
                                {% endif %}

                                {% for i in inicio..fin %}
                                    <li class=\"page-item {% if i == filtros.pagina %}active{% endif %}\">
                                        <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ i }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\">
                                            {{ i }}
                                        </a>
                                    </li>
                                {% endfor %}

                                {# Botón Página Siguiente #}
                                <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.pagina + 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                {# Botón Última Página #}
                                <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.total_paginas }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Última\">
                                        <i class=\"fas fa-angle-double-right\"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                {% endif %}
            </div>
        </div>
    {% else %}
        <div class=\"alert alert-info\">
            No se encontraron autores que coincidan con los criterios de búsqueda.
        </div>
    {% endif %}
</div>
{% endblock %}

{% block scripts %}
    {{ parent() }}
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            {% if success %}
                Swal.fire({
                    title: '{{ success.title }}',
                    text: '{{ success.text }}',
                    icon: '{{ success.icon }}'
                });
            {% endif %}

            {% if error %}
                Swal.fire({
                    title: '{{ error.title }}',
                    text: '{{ error.text }}',
                    icon: '{{ error.icon }}'
                });
            {% endif %}

            // Manejar la eliminación de autores
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: \"Esta acción no se puede deshacer\",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
{% endblock %} ", "autores/index.twig", "/var/www/html/biblioges/templates/autores/index.twig");
    }
}
