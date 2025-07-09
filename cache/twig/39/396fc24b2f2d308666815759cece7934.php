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

/* bibliografias_declaradas/index.twig */
class __TwigTemplate_544561dcee3d20c64ebb0d18ac7bfb4a extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_declaradas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografías Declaradas";
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
        <h1>Bibliografías Declaradas</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía Declarada
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
    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"row g-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" placeholder=\"Buscar...\" value=\"";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 28), "")) : ("")), "html", null, true);
        yield "\">
                        <select class=\"form-select\" id=\"tipo_busqueda\" name=\"tipo_busqueda\" style=\"max-width: 150px;\">
                            <option value=\"todos\" ";
        // line 30
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 30)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 30), "todos")) : ("todos")) == "todos")) {
            yield "selected";
        }
        yield ">Todos</option>
                            <option value=\"titulo\" ";
        // line 31
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 31)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 31), "")) : ("")) == "titulo")) {
            yield "selected";
        }
        yield ">Título</option>
                            <option value=\"autor\" ";
        // line 32
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 32)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 32), "")) : ("")) == "autor")) {
            yield "selected";
        }
        yield ">Autor</option>
                            <option value=\"editorial\" ";
        // line 33
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 33)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 33), "")) : ("")) == "editorial")) {
            yield "selected";
        }
        yield ">Editorial</option>
                        </select>
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"libro\" ";
        // line 45
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 45)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 45), "")) : ("")) == "libro")) {
            yield "selected";
        }
        yield ">Libro</option>
                        <option value=\"articulo\" ";
        // line 46
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 46)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 46), "")) : ("")) == "articulo")) {
            yield "selected";
        }
        yield ">Artículo</option>
                        <option value=\"tesis\" ";
        // line 47
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 47)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 47), "")) : ("")) == "tesis")) {
            yield "selected";
        }
        yield ">Tesis</option>
                        <option value=\"software\" ";
        // line 48
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 48)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 48), "")) : ("")) == "software")) {
            yield "selected";
        }
        yield ">Software</option>
                        <option value=\"sitio_web\" ";
        // line 49
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 49)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 49), "")) : ("")) == "sitio_web")) {
            yield "selected";
        }
        yield ">Sitio Web</option>
                        <option value=\"generico\" ";
        // line 50
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 50)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 50), "")) : ("")) == "generico")) {
            yield "selected";
        }
        yield ">Genérico</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
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
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <a href=\"";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-secondary w-100\">
                        <i class=\"fas fa-times\"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 74
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 75
            yield "        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100\">
                        <thead class=\"table-light\">
                            <tr>
                                <th style=\"width: 25%\">
                                    <a href=\"";
            // line 82
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=titulo&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 82) == "titulo") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 82) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 82)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 82)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 82)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 82)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 82)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 82)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 82))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 82)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Título
                                        ";
            // line 84
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 84) == "titulo")) {
                // line 85
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 85) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 87
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 89
            yield "                                    </a>
                                </th>
                                <th style=\"width: 10%\">Tipo</th>
                                <th style=\"width: 20%\">
                                    <a href=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=autores&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 93) == "autores") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 93) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 93)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 93))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 93)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Autores
                                        ";
            // line 95
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 95) == "autores")) {
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
                                <th style=\"width: 25%\">
                                    <a href=\"";
            // line 103
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=asignaturas&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 103) == "asignaturas") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 103) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 103)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 103))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 103)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Asignaturas
                                        ";
            // line 105
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 105) == "asignaturas")) {
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
                                <th style=\"width: 10%\">Estado</th>
                                <th style=\"width: 10%\" class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 117
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 118
                yield "                            <tr>
                                <td>";
                // line 119
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 119), "html", null, true);
                yield "</td>
                                <td>";
                // line 120
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 120), "html", null, true);
                yield "</td>
                                <td>";
                // line 121
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 121)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 121), "Sin autores")) : ("Sin autores")), "html", null, true);
                yield "</td>
                                <td>";
                // line 122
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", true, true, false, 122)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", false, false, false, 122), "Sin asignaturas")) : ("Sin asignaturas")), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 124
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 124)) {
                    // line 125
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 127
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 129
                yield "                                </td>
                                <td>
                                    <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                        <a href=\"";
                // line 132
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 132), "html", null, true);
                yield "\" 
                                           class=\"btn btn-info btn-sm\" 
                                           title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 137
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 137), "html", null, true);
                yield "/edit\" 
                                           class=\"btn btn-primary btn-sm\" 
                                           title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <a href=\"";
                // line 142
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 142)) . "/vincular"), "html", null, true);
                yield "\"
                                           class=\"btn btn-success btn-sm\"
                                           title=\"Vincular Asignaturas\">
                                            <i class=\"fas fa-link\"></i>
                                        </a>
                                        <a href=\"";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 147)) . "/buscarCatalogo"), "html", null, true);
                yield "\"
                                           class=\"btn btn-warning btn-sm\"
                                           title=\"Buscar en Catálogo\">
                                            <i class=\"fas fa-search\"></i>
                                        </a>
                                        <button type=\"button\" 
                                                class=\"btn btn-danger btn-sm\" 
                                                title=\"Eliminar\"
                                                onclick=\"confirmarEliminacion(";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 155), "html", null, true);
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
            // line 162
            yield "                        </tbody>
                    </table>
                </div>

                ";
            // line 167
            yield "                ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 167) > 1)) {
                // line 168
                yield "                <div class=\"row mt-4\">
                    <div class=\"col-md-6\">
                        <p class=\"text-muted\">
                            Mostrando ";
                // line 171
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 171) - 1) * 20) + 1), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(min((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 171) * 20), CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 171)), "html", null, true);
                yield " de ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 171), "html", null, true);
                yield " registros
                        </p>
                    </div>
                    <div class=\"col-md-6\">
                        <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                            <ul class=\"pagination mb-0\">
                                ";
                // line 178
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 178) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 179
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=1";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 179)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 179), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 179)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 179), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 179)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 179), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 179)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 179), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 179)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 179), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 179)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 179), "html", null, true);
                }
                yield "\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 185
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 185) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 186
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 186) - 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 186)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 186), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 186)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 186), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 186)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 186), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 186)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 186), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 186)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 186), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 186)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 186), "html", null, true);
                }
                yield "\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 192
                yield "                                ";
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 192) - 2));
                // line 193
                yield "                                ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 193), (($context["inicio"] ?? null) + 4));
                // line 194
                yield "                                ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 195
                    yield "                                    ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 196
                    yield "                                ";
                }
                // line 197
                yield "
                                ";
                // line 198
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 199
                    yield "                                    <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 199))) {
                        yield "active";
                    }
                    yield "\">
                                        <a class=\"page-link\" href=\"";
                    // line 200
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "bibliografias-declaradas?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 200)) {
                        yield "&busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 200), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 200)) {
                        yield "&tipo_busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 200), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 200)) {
                        yield "&tipo=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 200), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 200)) {
                        yield "&estado=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 200), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 200)) {
                        yield "&orden=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 200), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 200)) {
                        yield "&direccion=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 200), "html", null, true);
                    }
                    yield "\">
                                            ";
                    // line 201
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "
                                        </a>
                                    </li>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 205
                yield "
                                ";
                // line 207
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 207) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 207))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 208
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 208) + 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 208)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 208), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 208)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 208), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 208)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 208), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 208)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 208), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 208)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 208), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 208)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 208), "html", null, true);
                }
                yield "\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                ";
                // line 214
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 214) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 214))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 215
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 215), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 215)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 215), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 215)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 215), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 215)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 215), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 215)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 215), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 215)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 215), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 215)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 215), "html", null, true);
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
            // line 224
            yield "            </div>
        </div>
    ";
        } else {
            // line 227
            yield "        <div class=\"alert alert-info\">
            No hay bibliografías declaradas registradas.
        </div>
    ";
        }
        // line 231
        yield "</div>
";
        yield from [];
    }

    // line 234
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 235
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un mensaje swal del servidor
    ";
        // line 239
        if (($context["swal"] ?? null)) {
            // line 240
            yield "        Swal.fire({
            icon: '";
            // line 241
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 241), "html", null, true);
            yield "',
            title: '";
            // line 242
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 242), "html", null, true);
            yield "',
            text: '";
            // line 243
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 243), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    ";
        }
        // line 247
        yield "    
    // Verificar si hay un mensaje en sessionStorage (para compatibilidad)
    const swalMessage = sessionStorage.getItem('swal');
    if (swalMessage) {
        const message = JSON.parse(swalMessage);
        Swal.fire({
            icon: message.icon,
            title: message.title,
            text: message.text,
            confirmButtonText: 'Aceptar'
        });
        // Limpiar el mensaje después de mostrarlo
        sessionStorage.removeItem('swal');
    }
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: \"¿Está seguro de que desea eliminar esta bibliografía declarada?\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
            form.action = '";
        // line 277
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/' + id + '/delete';
        
        document.body.appendChild(form);
        form.submit();
    }
    });
}

function limpiarFiltros() {
    document.getElementById('busqueda').value = '';
    document.getElementById('tipo_busqueda').value = 'todos';
    document.getElementById('tipo').value = '';
    document.getElementById('estado').value = '';
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
        return "bibliografias_declaradas/index.twig";
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
        return array (  759 => 277,  727 => 247,  720 => 243,  716 => 242,  712 => 241,  709 => 240,  707 => 239,  701 => 235,  694 => 234,  688 => 231,  682 => 227,  677 => 224,  639 => 215,  632 => 214,  598 => 208,  591 => 207,  588 => 205,  578 => 201,  548 => 200,  541 => 199,  537 => 198,  534 => 197,  531 => 196,  528 => 195,  525 => 194,  522 => 193,  519 => 192,  485 => 186,  478 => 185,  445 => 179,  438 => 178,  425 => 171,  420 => 168,  417 => 167,  411 => 162,  398 => 155,  387 => 147,  379 => 142,  369 => 137,  359 => 132,  354 => 129,  350 => 127,  346 => 125,  344 => 124,  339 => 122,  335 => 121,  331 => 120,  327 => 119,  324 => 118,  320 => 117,  311 => 110,  307 => 108,  301 => 106,  299 => 105,  288 => 103,  283 => 100,  279 => 98,  273 => 96,  271 => 95,  260 => 93,  254 => 89,  250 => 87,  244 => 85,  242 => 84,  231 => 82,  222 => 75,  220 => 74,  209 => 66,  195 => 57,  189 => 56,  178 => 50,  172 => 49,  166 => 48,  160 => 47,  154 => 46,  148 => 45,  131 => 33,  125 => 32,  119 => 31,  113 => 30,  108 => 28,  101 => 24,  92 => 17,  86 => 15,  84 => 14,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Bibliografías Declaradas{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Bibliografías Declaradas</h1>
        <a href=\"{{ app_url }}bibliografias-declaradas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía Declarada
        </a>
    </div>

    {% if error %}
        <div class=\"alert alert-danger\">{{ error }}</div>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}bibliografias-declaradas\" class=\"row g-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" placeholder=\"Buscar...\" value=\"{{ filtros.busqueda|default('') }}\">
                        <select class=\"form-select\" id=\"tipo_busqueda\" name=\"tipo_busqueda\" style=\"max-width: 150px;\">
                            <option value=\"todos\" {% if filtros.tipo_busqueda|default('todos') == 'todos' %}selected{% endif %}>Todos</option>
                            <option value=\"titulo\" {% if filtros.tipo_busqueda|default('') == 'titulo' %}selected{% endif %}>Título</option>
                            <option value=\"autor\" {% if filtros.tipo_busqueda|default('') == 'autor' %}selected{% endif %}>Autor</option>
                            <option value=\"editorial\" {% if filtros.tipo_busqueda|default('') == 'editorial' %}selected{% endif %}>Editorial</option>
                        </select>
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-search\"></i> Buscar
                        </button>
                    </div>
                </div>

                <!-- Fila de filtros -->
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"libro\" {% if filtros.tipo|default('') == 'libro' %}selected{% endif %}>Libro</option>
                        <option value=\"articulo\" {% if filtros.tipo|default('') == 'articulo' %}selected{% endif %}>Artículo</option>
                        <option value=\"tesis\" {% if filtros.tipo|default('') == 'tesis' %}selected{% endif %}>Tesis</option>
                        <option value=\"software\" {% if filtros.tipo|default('') == 'software' %}selected{% endif %}>Software</option>
                        <option value=\"sitio_web\" {% if filtros.tipo|default('') == 'sitio_web' %}selected{% endif %}>Sitio Web</option>
                        <option value=\"generico\" {% if filtros.tipo|default('') == 'generico' %}selected{% endif %}>Genérico</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" {% if filtros.estado|default('') == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado|default('') == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <button type=\"submit\" class=\"btn btn-primary w-100\">
                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                    </button>
                </div>
                <div class=\"col-md-1\">
                    <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-secondary w-100\">
                        <i class=\"fas fa-times\"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {% if bibliografias|length > 0 %}
        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100\">
                        <thead class=\"table-light\">
                            <tr>
                                <th style=\"width: 25%\">
                                    <a href=\"{{ app_url }}bibliografias-declaradas?orden=titulo&direccion={{ filtros.orden == 'titulo' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.tipo ? '&tipo=' ~ filtros.tipo : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}\" class=\"text-dark text-decoration-none\">
                                        Título
                                        {% if filtros.orden == 'titulo' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th style=\"width: 10%\">Tipo</th>
                                <th style=\"width: 20%\">
                                    <a href=\"{{ app_url }}bibliografias-declaradas?orden=autores&direccion={{ filtros.orden == 'autores' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.tipo ? '&tipo=' ~ filtros.tipo : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}\" class=\"text-dark text-decoration-none\">
                                        Autores
                                        {% if filtros.orden == 'autores' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th style=\"width: 25%\">
                                    <a href=\"{{ app_url }}bibliografias-declaradas?orden=asignaturas&direccion={{ filtros.orden == 'asignaturas' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.tipo ? '&tipo=' ~ filtros.tipo : '' }}{{ filtros.estado is not null ? '&estado=' ~ filtros.estado : '' }}\" class=\"text-dark text-decoration-none\">
                                        Asignaturas
                                        {% if filtros.orden == 'asignaturas' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th style=\"width: 10%\">Estado</th>
                                <th style=\"width: 10%\" class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for bibliografia in bibliografias %}
                            <tr>
                                <td>{{ bibliografia.titulo }}</td>
                                <td>{{ bibliografia.tipo }}</td>
                                <td>{{ bibliografia.autores|default('Sin autores') }}</td>
                                <td>{{ bibliografia.asignaturas|default('Sin asignaturas') }}</td>
                                <td class=\"text-center\">
                                    {% if bibliografia.estado %}
                                        <span class=\"badge bg-success\">Activo</span>
                                    {% else %}
                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    {% endif %}
                                </td>
                                <td>
                                    <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                        <a href=\"{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}\" 
                                           class=\"btn btn-info btn-sm\" 
                                           title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/edit\" 
                                           class=\"btn btn-primary btn-sm\" 
                                           title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <a href=\"{{ app_url ~ 'bibliografias-declaradas/' ~ bibliografia.id ~ '/vincular' }}\"
                                           class=\"btn btn-success btn-sm\"
                                           title=\"Vincular Asignaturas\">
                                            <i class=\"fas fa-link\"></i>
                                        </a>
                                        <a href=\"{{ app_url ~ 'bibliografias-declaradas/' ~ bibliografia.id ~ '/buscarCatalogo' }}\"
                                           class=\"btn btn-warning btn-sm\"
                                           title=\"Buscar en Catálogo\">
                                            <i class=\"fas fa-search\"></i>
                                        </a>
                                        <button type=\"button\" 
                                                class=\"btn btn-danger btn-sm\" 
                                                title=\"Eliminar\"
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
                                    <a class=\"page-link\" href=\"{{ app_url }}bibliografias-declaradas?pagina=1{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.tipo %}&tipo={{ filtros.tipo }}{% endif %}{% if filtros.estado %}&estado={{ filtros.estado }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                {# Botón Página Anterior #}
                                <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}bibliografias-declaradas?pagina={{ filtros.pagina - 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.tipo %}&tipo={{ filtros.tipo }}{% endif %}{% if filtros.estado %}&estado={{ filtros.estado }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Anterior\">
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
                                        <a class=\"page-link\" href=\"{{ app_url }}bibliografias-declaradas?pagina={{ i }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.tipo %}&tipo={{ filtros.tipo }}{% endif %}{% if filtros.estado %}&estado={{ filtros.estado }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\">
                                            {{ i }}
                                        </a>
                                    </li>
                                {% endfor %}

                                {# Botón Página Siguiente #}
                                <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}bibliografias-declaradas?pagina={{ filtros.pagina + 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.tipo %}&tipo={{ filtros.tipo }}{% endif %}{% if filtros.estado %}&estado={{ filtros.estado }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                {# Botón Última Página #}
                                <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ app_url }}bibliografias-declaradas?pagina={{ filtros.total_paginas }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.tipo %}&tipo={{ filtros.tipo }}{% endif %}{% if filtros.estado %}&estado={{ filtros.estado }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Última\">
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
            No hay bibliografías declaradas registradas.
        </div>
    {% endif %}
</div>
{% endblock %}

{% block scripts %}
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un mensaje swal del servidor
    {% if swal %}
        Swal.fire({
            icon: '{{ swal.icon }}',
            title: '{{ swal.title }}',
            text: '{{ swal.text }}',
            confirmButtonText: 'Aceptar'
        });
    {% endif %}
    
    // Verificar si hay un mensaje en sessionStorage (para compatibilidad)
    const swalMessage = sessionStorage.getItem('swal');
    if (swalMessage) {
        const message = JSON.parse(swalMessage);
        Swal.fire({
            icon: message.icon,
            title: message.title,
            text: message.text,
            confirmButtonText: 'Aceptar'
        });
        // Limpiar el mensaje después de mostrarlo
        sessionStorage.removeItem('swal');
    }
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: \"¿Está seguro de que desea eliminar esta bibliografía declarada?\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
            form.action = '{{ app_url }}bibliografias-declaradas/' + id + '/delete';
        
        document.body.appendChild(form);
        form.submit();
    }
    });
}

function limpiarFiltros() {
    document.getElementById('busqueda').value = '';
    document.getElementById('tipo_busqueda').value = 'todos';
    document.getElementById('tipo').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('filtroForm').submit();
}
</script>
{% endblock %} ", "bibliografias_declaradas/index.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/index.twig");
    }
}
