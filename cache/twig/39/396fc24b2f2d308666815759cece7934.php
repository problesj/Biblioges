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
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 75
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 76
            yield "        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100\">
                        <thead class=\"table-light\">
                            <tr>
                                <th style=\"width: 25%\">
                                    <a href=\"";
            // line 83
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=titulo&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 83) == "titulo") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 83) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 83)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 83))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 83)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Título
                                        ";
            // line 85
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 85) == "titulo")) {
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
                                <th style=\"width: 10%\">Tipo</th>
                                <th style=\"width: 20%\">
                                    <a href=\"";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=autores&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 94) == "autores") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 94) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 94)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 94)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 94)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 94)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 94)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 94)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 94))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 94)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Autores
                                        ";
            // line 96
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 96) == "autores")) {
                // line 97
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 97) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 99
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 101
            yield "                                    </a>
                                </th>
                                <th style=\"width: 25%\">
                                    <a href=\"";
            // line 104
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas?orden=asignaturas&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 104) == "asignaturas") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 104) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 104)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 104)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 104)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 104)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 104)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 104)), "html", null, true)) : (""));
            yield (( !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 104))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&estado=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 104)), "html", null, true)) : (""));
            yield "\" class=\"text-dark text-decoration-none\">
                                        Asignaturas
                                        ";
            // line 106
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 106) == "asignaturas")) {
                // line 107
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 107) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 109
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 111
            yield "                                    </a>
                                </th>
                                <th style=\"width: 10%\">Estado</th>
                                <th style=\"width: 10%\" class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 118
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 119
                yield "                            <tr>
                                <td>";
                // line 120
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 120), "html", null, true);
                yield "</td>
                                <td>";
                // line 121
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 121), "html", null, true);
                yield "</td>
                                <td>";
                // line 122
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 122)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 122), "Sin autores")) : ("Sin autores")), "html", null, true);
                yield "</td>
                                <td>";
                // line 123
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", true, true, false, 123)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", false, false, false, 123), "Sin asignaturas")) : ("Sin asignaturas")), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 125
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 125)) {
                    // line 126
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 128
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 130
                yield "                                </td>
                                <td>
                                    <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                        <a href=\"";
                // line 133
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 133), "html", null, true);
                yield "\" 
                                           class=\"btn btn-info btn-sm\" 
                                           title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 138
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 138), "html", null, true);
                yield "/edit\" 
                                           class=\"btn btn-primary btn-sm\" 
                                           title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <a href=\"";
                // line 143
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 143)) . "/vincular"), "html", null, true);
                yield "\"
                                           class=\"btn btn-success btn-sm\"
                                           title=\"Vincular Asignaturas\">
                                            <i class=\"fas fa-link\"></i>
                                        </a>
                                        <a href=\"";
                // line 148
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 148)) . "/buscarCatalogo"), "html", null, true);
                yield "\"
                                           class=\"btn btn-warning btn-sm\"
                                           title=\"Buscar en Catálogo\">
                                            <i class=\"fas fa-search\"></i>
                                        </a>
                                        <button type=\"button\" 
                                                class=\"btn btn-danger btn-sm\" 
                                                title=\"Eliminar\"
                                                onclick=\"confirmarEliminacion(";
                // line 156
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 156), "html", null, true);
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
            // line 163
            yield "                        </tbody>
                    </table>
                </div>

                ";
            // line 168
            yield "                ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 168) > 1)) {
                // line 169
                yield "                <div class=\"row mt-4\">
                    <div class=\"col-md-6\">
                        <p class=\"text-muted\">
                            Mostrando ";
                // line 172
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 172) - 1) * 20) + 1), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(min((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 172) * 20), CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 172)), "html", null, true);
                yield " de ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 172), "html", null, true);
                yield " registros
                        </p>
                    </div>
                    <div class=\"col-md-6\">
                        <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                            <ul class=\"pagination mb-0\">
                                ";
                // line 179
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 179) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 180
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=1";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 180)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 180), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 180)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 180), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 180)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 180), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 180)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 180), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 180)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 180), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 180)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 180), "html", null, true);
                }
                yield "\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 186
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 186) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 187
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 187) - 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 187)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 187), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 187)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 187), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 187)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 187), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 187)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 187), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 187)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 187), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 187)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 187), "html", null, true);
                }
                yield "\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 193
                yield "                                ";
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 193) - 2));
                // line 194
                yield "                                ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 194), (($context["inicio"] ?? null) + 4));
                // line 195
                yield "                                ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 196
                    yield "                                    ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 197
                    yield "                                ";
                }
                // line 198
                yield "
                                ";
                // line 199
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 200
                    yield "                                    <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 200))) {
                        yield "active";
                    }
                    yield "\">
                                        <a class=\"page-link\" href=\"";
                    // line 201
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "bibliografias-declaradas?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 201)) {
                        yield "&busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 201), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 201)) {
                        yield "&tipo_busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 201), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 201)) {
                        yield "&tipo=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 201), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 201)) {
                        yield "&estado=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 201), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 201)) {
                        yield "&orden=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 201), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 201)) {
                        yield "&direccion=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 201), "html", null, true);
                    }
                    yield "\">
                                            ";
                    // line 202
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "
                                        </a>
                                    </li>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 206
                yield "
                                ";
                // line 208
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 208) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 208))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 209
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 209) + 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 209)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 209), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 209)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 209), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 209)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 209), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 209)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 209), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 209)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 209), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 209)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 209), "html", null, true);
                }
                yield "\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                ";
                // line 215
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 215) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 215))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 216
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 216), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 216)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 216), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 216)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 216), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 216)) {
                    yield "&tipo=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 216), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 216)) {
                    yield "&estado=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 216), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 216)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 216), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 216)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 216), "html", null, true);
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
            // line 225
            yield "            </div>
        </div>
    ";
        } else {
            // line 228
            yield "        <div class=\"alert alert-info\">
            No hay bibliografías declaradas registradas.
        </div>
    ";
        }
        // line 232
        yield "</div>
";
        yield from [];
    }

    // line 235
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 236
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un mensaje swal del servidor
    ";
        // line 240
        if (($context["swal"] ?? null)) {
            // line 241
            yield "        Swal.fire({
            icon: '";
            // line 242
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 242), "html", null, true);
            yield "',
            title: '";
            // line 243
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 243), "html", null, true);
            yield "',
            text: '";
            // line 244
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 244), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    ";
        }
        // line 248
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
        // line 278
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
        return array (  760 => 278,  728 => 248,  721 => 244,  717 => 243,  713 => 242,  710 => 241,  708 => 240,  702 => 236,  695 => 235,  689 => 232,  683 => 228,  678 => 225,  640 => 216,  633 => 215,  599 => 209,  592 => 208,  589 => 206,  579 => 202,  549 => 201,  542 => 200,  538 => 199,  535 => 198,  532 => 197,  529 => 196,  526 => 195,  523 => 194,  520 => 193,  486 => 187,  479 => 186,  446 => 180,  439 => 179,  426 => 172,  421 => 169,  418 => 168,  412 => 163,  399 => 156,  388 => 148,  380 => 143,  370 => 138,  360 => 133,  355 => 130,  351 => 128,  347 => 126,  345 => 125,  340 => 123,  336 => 122,  332 => 121,  328 => 120,  325 => 119,  321 => 118,  312 => 111,  308 => 109,  302 => 107,  300 => 106,  289 => 104,  284 => 101,  280 => 99,  274 => 97,  272 => 96,  261 => 94,  255 => 90,  251 => 88,  245 => 86,  243 => 85,  232 => 83,  223 => 76,  221 => 75,  209 => 66,  195 => 57,  189 => 56,  178 => 50,  172 => 49,  166 => 48,  160 => 47,  154 => 46,  148 => 45,  131 => 33,  125 => 32,  119 => 31,  113 => 30,  108 => 28,  101 => 24,  92 => 17,  86 => 15,  84 => 14,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
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
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
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
