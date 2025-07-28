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
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<style>
    /* Estilos personalizados para la tabla de bibliografías declaradas */
    .bibliografias-table thead th {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 12px 8px !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        min-width: 120px !important;
    }
    
    .bibliografias-table thead th:first-child {
        min-width: 250px !important;
        width: 30% !important;
    }
    
    .bibliografias-table thead th:nth-child(2) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .bibliografias-table thead th:nth-child(3) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-table thead th:nth-child(4) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .bibliografias-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .bibliografias-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .bibliografias-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .bibliografias-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .bibliografias-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .bibliografias-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .bibliografias-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .bibliografias-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .bibliografias-table tbody td:nth-child(1) {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .bibliografias-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .bibliografias-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .bibliografias-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    /* Estilos para el contador de registros */
    .records-counter {
        font-size: 0.85rem !important;
        color: #495057 !important;
        font-weight: 600 !important;
        background-color: #f8f9fa !important;
        padding: 6px 12px !important;
        border-radius: 6px !important;
        border: 1px solid #e9ecef !important;
        white-space: nowrap !important;
    }
    
    /* Mejoras para el selector de registros por página */
    .per-page-selector {
        font-size: 0.85rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    
    .per-page-selector label {
        font-weight: 600 !important;
        color: #495057 !important;
        margin: 0 !important;
        white-space: nowrap !important;
    }
    
    .per-page-selector select {
        border: 2px solid #4e73df !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        color: #495057 !important;
        background-color: white !important;
        min-width: 70px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.1) !important;
    }
    
    .per-page-selector select:hover {
        border-color: #224abe !important;
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.2) !important;
        transform: translateY(-1px) !important;
    }
    
    .per-page-selector select:focus {
        outline: none !important;
        border-color: #224abe !important;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.25) !important;
    }
    
    .per-page-selector select option {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    /* Estilos para la paginación */
    .pagination .page-link {
        color: #4e73df !important;
        border: 1px solid #dee2e6 !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
    }
    
    .pagination .page-link:hover {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        border-color: #4e73df !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        border-color: #4e73df !important;
        color: white !important;
        font-weight: 600 !important;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
        background: #f8f9fa !important;
        border-color: #dee2e6 !important;
    }
</style>
";
        yield from [];
    }

    // line 209
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 210
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Bibliografías Declaradas</h1>
        <a href=\"";
        // line 213
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía Declarada
        </a>
    </div>

    ";
        // line 218
        if (($context["error"] ?? null)) {
            // line 219
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 221
        yield "
    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 228
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"row g-3\">
                <!-- Fila de búsqueda -->
                <div class=\"col-12 mb-3\">
                    <div class=\"input-group\">
                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" placeholder=\"Buscar...\" value=\"";
        // line 232
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 232)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 232), "")) : ("")), "html", null, true);
        yield "\">
                        <select class=\"form-select\" id=\"tipo_busqueda\" name=\"tipo_busqueda\" style=\"max-width: 150px;\">
                            <option value=\"todos\" ";
        // line 234
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 234)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 234), "todos")) : ("todos")) == "todos")) {
            yield "selected";
        }
        yield ">Todos</option>
                            <option value=\"titulo\" ";
        // line 235
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 235)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 235), "")) : ("")) == "titulo")) {
            yield "selected";
        }
        yield ">Título</option>
                            <option value=\"autor\" ";
        // line 236
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 236)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 236), "")) : ("")) == "autor")) {
            yield "selected";
        }
        yield ">Autor</option>
                            <option value=\"editorial\" ";
        // line 237
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 237)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 237), "")) : ("")) == "editorial")) {
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
        // line 249
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 249)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 249), "")) : ("")) == "libro")) {
            yield "selected";
        }
        yield ">Libro</option>
                        <option value=\"articulo\" ";
        // line 250
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 250)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 250), "")) : ("")) == "articulo")) {
            yield "selected";
        }
        yield ">Artículo</option>
                        <option value=\"tesis\" ";
        // line 251
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 251)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 251), "")) : ("")) == "tesis")) {
            yield "selected";
        }
        yield ">Tesis</option>
                        <option value=\"software\" ";
        // line 252
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 252)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 252), "")) : ("")) == "software")) {
            yield "selected";
        }
        yield ">Software</option>
                        <option value=\"sitio_web\" ";
        // line 253
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 253)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 253), "")) : ("")) == "sitio_web")) {
            yield "selected";
        }
        yield ">Sitio Web</option>
                        <option value=\"generico\" ";
        // line 254
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", true, true, false, 254)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 254), "")) : ("")) == "generico")) {
            yield "selected";
        }
        yield ">Genérico</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos los estados</option>
                        <option value=\"1\" ";
        // line 260
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 260)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 260), "")) : ("")) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 261
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 261)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 261), "")) : ("")) == "0")) {
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
        // line 270
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
        // line 279
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 280
            yield "        <div class=\"card\">
            <div class=\"card-header d-flex justify-content-between align-items-center\">
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\" onchange=\"changePerPage(this.value)\">
                            <option value=\"5\" ";
            // line 287
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 287) == 5)) ? ("selected") : (""));
            yield ">5</option>
                            <option value=\"10\" ";
            // line 288
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 288) == 10)) ? ("selected") : (""));
            yield ">10</option>
                            <option value=\"15\" ";
            // line 289
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 289) == 15)) ? ("selected") : (""));
            yield ">15</option>
                            <option value=\"20\" ";
            // line 290
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 290) == 20)) ? ("selected") : (""));
            yield ">20</option>
                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando ";
            // line 294
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 294), "html", null, true);
            yield " de ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 294), "html", null, true);
            yield " registros
                    </div>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100 bibliografias-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"";
            // line 304
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 304), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 304), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 304), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 304)), "html", null, true);
            yield "\">
                                        Título
                                        <i class=\"fas ";
            // line 306
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 306), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 306)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th>Tipo</th>
                                <th>
                                    <a href=\"";
            // line 311
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 311), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 311)), "html", null, true);
            yield "\">
                                        Autores
                                        <i class=\"fas ";
            // line 313
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 313), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 313)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 317
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("asignaturas", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 317), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 317), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 317), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 317)), "html", null, true);
            yield "\">
                                        Asignaturas
                                        <i class=\"fas ";
            // line 319
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("asignaturas", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 319), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 319)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">Estado</th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 327
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 328
                yield "                            <tr>
                                <td>";
                // line 329
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 329), "html", null, true);
                yield "</td>
                                <td>";
                // line 330
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 330), "html", null, true);
                yield "</td>
                                <td>";
                // line 331
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 331)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 331), "Sin autores")) : ("Sin autores")), "html", null, true);
                yield "</td>
                                <td>";
                // line 332
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", true, true, false, 332)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas", [], "any", false, false, false, 332), "Sin asignaturas")) : ("Sin asignaturas")), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 334
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 334)) {
                    // line 335
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 337
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 339
                yield "                                </td>
                                <td>
                                    <div class=\"btn-group d-flex justify-content-center\" role=\"group\">
                                        <a href=\"";
                // line 342
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 342), "html", null, true);
                yield "\" 
                                           class=\"btn btn-info btn-sm\" 
                                           title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 347
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-declaradas/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 347), "html", null, true);
                yield "/edit\" 
                                           class=\"btn btn-primary btn-sm\" 
                                           title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <a href=\"";
                // line 352
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 352)) . "/vincular"), "html", null, true);
                yield "\"
                                           class=\"btn btn-success btn-sm\"
                                           title=\"Vincular Asignaturas\">
                                            <i class=\"fas fa-link\"></i>
                                        </a>
                                        <a href=\"";
                // line 357
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-declaradas/") . CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 357)) . "/buscarCatalogo"), "html", null, true);
                yield "\"
                                           class=\"btn btn-warning btn-sm\"
                                           title=\"Buscar en Catálogo\">
                                            <i class=\"fas fa-search\"></i>
                                        </a>
                                        <button type=\"button\" 
                                                class=\"btn btn-danger btn-sm\" 
                                                title=\"Eliminar\"
                                                onclick=\"confirmarEliminacion(";
                // line 365
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 365), "html", null, true);
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
            // line 372
            yield "                        </tbody>
                    </table>
                </div>

                ";
            // line 377
            yield "                ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 377) > 1)) {
                // line 378
                yield "                    <div class=\"d-flex justify-content-center mt-4\">
                        <nav aria-label=\"Navegación de páginas\">
                            <ul class=\"pagination\">
                                ";
                // line 382
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 382) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 383
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 383), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 383), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 383)), "html", null, true);
                yield "\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 389
                yield "                                <li class=\"page-item ";
                if ( !CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 389)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 390
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 390), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 390), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 390), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 390)), "html", null, true);
                yield "\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                ";
                // line 396
                yield "                                ";
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 396) - 2));
                // line 397
                yield "                                ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 397), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 397) + 2));
                // line 398
                yield "
                                ";
                // line 399
                if ((($context["inicio"] ?? null) > 1)) {
                    // line 400
                    yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                ";
                }
                // line 404
                yield "
                                ";
                // line 405
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 406
                    yield "                                    ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 407
                    yield "                                ";
                }
                // line 408
                yield "
                                ";
                // line 409
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 410
                    yield "                                    <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 410))) {
                        yield "active";
                    }
                    yield "\">
                                        <a class=\"page-link\" href=\"";
                    // line 411
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["i"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 411), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 411), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 411)), "html", null, true);
                    yield "\">
                                            ";
                    // line 412
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "
                                        </a>
                                    </li>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 416
                yield "
                                ";
                // line 417
                if ((($context["fin"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 417))) {
                    // line 418
                    yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                ";
                }
                // line 422
                yield "
                                ";
                // line 424
                yield "                                <li class=\"page-item ";
                if ( !CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 424)) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 425
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 425), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 425), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 425), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 425)), "html", null, true);
                yield "\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                ";
                // line 431
                yield "                                <li class=\"page-item ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 431) == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 431))) {
                    yield "disabled";
                }
                yield "\">
                                    <a class=\"page-link\" href=\"";
                // line 432
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 432), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 432), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 432), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 432)), "html", null, true);
                yield "\" aria-label=\"Última\">
                                        <i class=\"fas fa-angle-double-right\"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                ";
            }
            // line 440
            yield "            </div>
        </div>
    ";
        } else {
            // line 443
            yield "        <div class=\"alert alert-info\">
            No hay bibliografías declaradas registradas.
        </div>
    ";
        }
        // line 447
        yield "</div>
";
        yield from [];
    }

    // line 450
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 451
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un mensaje swal del servidor
    ";
        // line 455
        if (($context["swal"] ?? null)) {
            // line 456
            yield "        Swal.fire({
            icon: '";
            // line 457
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 457), "html", null, true);
            yield "',
            title: '";
            // line 458
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 458), "html", null, true);
            yield "',
            text: '";
            // line 459
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 459), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    ";
        }
        // line 463
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
        // line 493
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

function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
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
        return array (  841 => 493,  809 => 463,  802 => 459,  798 => 458,  794 => 457,  791 => 456,  789 => 455,  783 => 451,  776 => 450,  770 => 447,  764 => 443,  759 => 440,  748 => 432,  741 => 431,  733 => 425,  726 => 424,  723 => 422,  717 => 418,  715 => 417,  712 => 416,  702 => 412,  698 => 411,  691 => 410,  687 => 409,  684 => 408,  681 => 407,  678 => 406,  676 => 405,  673 => 404,  667 => 400,  665 => 399,  662 => 398,  659 => 397,  656 => 396,  648 => 390,  641 => 389,  633 => 383,  626 => 382,  621 => 378,  618 => 377,  612 => 372,  599 => 365,  588 => 357,  580 => 352,  570 => 347,  560 => 342,  555 => 339,  551 => 337,  547 => 335,  545 => 334,  540 => 332,  536 => 331,  532 => 330,  528 => 329,  525 => 328,  521 => 327,  510 => 319,  505 => 317,  498 => 313,  493 => 311,  485 => 306,  480 => 304,  465 => 294,  458 => 290,  454 => 289,  450 => 288,  446 => 287,  437 => 280,  435 => 279,  423 => 270,  409 => 261,  403 => 260,  392 => 254,  386 => 253,  380 => 252,  374 => 251,  368 => 250,  362 => 249,  345 => 237,  339 => 236,  333 => 235,  327 => 234,  322 => 232,  315 => 228,  306 => 221,  300 => 219,  298 => 218,  290 => 213,  285 => 210,  278 => 209,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Bibliografías Declaradas{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de bibliografías declaradas */
    .bibliografias-table thead th {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 12px 8px !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        min-width: 120px !important;
    }
    
    .bibliografias-table thead th:first-child {
        min-width: 250px !important;
        width: 30% !important;
    }
    
    .bibliografias-table thead th:nth-child(2) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .bibliografias-table thead th:nth-child(3) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-table thead th:nth-child(4) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .bibliografias-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .bibliografias-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .bibliografias-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .bibliografias-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .bibliografias-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .bibliografias-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .bibliografias-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .bibliografias-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .bibliografias-table tbody td:nth-child(1) {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .bibliografias-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .bibliografias-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .bibliografias-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    /* Estilos para el contador de registros */
    .records-counter {
        font-size: 0.85rem !important;
        color: #495057 !important;
        font-weight: 600 !important;
        background-color: #f8f9fa !important;
        padding: 6px 12px !important;
        border-radius: 6px !important;
        border: 1px solid #e9ecef !important;
        white-space: nowrap !important;
    }
    
    /* Mejoras para el selector de registros por página */
    .per-page-selector {
        font-size: 0.85rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    
    .per-page-selector label {
        font-weight: 600 !important;
        color: #495057 !important;
        margin: 0 !important;
        white-space: nowrap !important;
    }
    
    .per-page-selector select {
        border: 2px solid #4e73df !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        color: #495057 !important;
        background-color: white !important;
        min-width: 70px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.1) !important;
    }
    
    .per-page-selector select:hover {
        border-color: #224abe !important;
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.2) !important;
        transform: translateY(-1px) !important;
    }
    
    .per-page-selector select:focus {
        outline: none !important;
        border-color: #224abe !important;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.25) !important;
    }
    
    .per-page-selector select option {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    /* Estilos para la paginación */
    .pagination .page-link {
        color: #4e73df !important;
        border: 1px solid #dee2e6 !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
    }
    
    .pagination .page-link:hover {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        border-color: #4e73df !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        border-color: #4e73df !important;
        color: white !important;
        font-weight: 600 !important;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
        background: #f8f9fa !important;
        border-color: #dee2e6 !important;
    }
</style>
{% endblock %}

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
            <div class=\"card-header d-flex justify-content-between align-items-center\">
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\" onchange=\"changePerPage(this.value)\">
                            <option value=\"5\" {{ paginacion.per_page == 5 ? 'selected' : '' }}>5</option>
                            <option value=\"10\" {{ paginacion.per_page == 10 ? 'selected' : '' }}>10</option>
                            <option value=\"15\" {{ paginacion.per_page == 15 ? 'selected' : '' }}>15</option>
                            <option value=\"20\" {{ paginacion.per_page == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando {{ paginacion.per_page }} de {{ paginacion.total_records }} registros
                    </div>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-bordered table-hover w-100 bibliografias-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"{{ build_sort_url('titulo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Título
                                        <i class=\"fas {{ get_sort_icon('titulo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th>Tipo</th>
                                <th>
                                    <a href=\"{{ build_sort_url('autores', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Autores
                                        <i class=\"fas {{ get_sort_icon('autores', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ build_sort_url('asignaturas', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Asignaturas
                                        <i class=\"fas {{ get_sort_icon('asignaturas', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">Estado</th>
                                <th class=\"text-center\">Acciones</th>
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

                {# Paginación moderna #}
                {% if paginacion.total_pages > 1 %}
                    <div class=\"d-flex justify-content-center mt-4\">
                        <nav aria-label=\"Navegación de páginas\">
                            <ul class=\"pagination\">
                                {# Botón Primera Página #}
                                <li class=\"page-item {% if paginacion.current_page == 1 %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(1, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Primera\">
                                        <i class=\"fas fa-angle-double-left\"></i>
                                    </a>
                                </li>

                                {# Botón Página Anterior #}
                                <li class=\"page-item {% if not paginacion.has_previous %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(paginacion.previous_page, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Anterior\">
                                        <i class=\"fas fa-angle-left\"></i>
                                    </a>
                                </li>

                                {# Números de Página #}
                                {% set inicio = max(1, paginacion.current_page - 2) %}
                                {% set fin = min(paginacion.total_pages, paginacion.current_page + 2) %}

                                {% if inicio > 1 %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                {% endif %}

                                {% if fin - inicio < 4 %}
                                    {% set inicio = max(1, fin - 4) %}
                                {% endif %}

                                {% for i in inicio..fin %}
                                    <li class=\"page-item {% if i == paginacion.current_page %}active{% endif %}\">
                                        <a class=\"page-link\" href=\"{{ build_page_url(i, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">
                                            {{ i }}
                                        </a>
                                    </li>
                                {% endfor %}

                                {% if fin < paginacion.total_pages %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                {% endif %}

                                {# Botón Página Siguiente #}
                                <li class=\"page-item {% if not paginacion.has_next %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(paginacion.next_page, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Siguiente\">
                                        <i class=\"fas fa-angle-right\"></i>
                                    </a>
                                </li>

                                {# Botón Última Página #}
                                <li class=\"page-item {% if paginacion.current_page == paginacion.total_pages %}disabled{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(paginacion.total_pages, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Última\">
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

function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
}
</script>
{% endblock %} ", "bibliografias_declaradas/index.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/index.twig");
    }
}
