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
        yield "Bibliografías Disponibles - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de bibliografías disponibles */
    .bibliografias-disponibles-table thead th {
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
    
    .bibliografias-disponibles-table thead th:first-child {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(2) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(3) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(4) {
        min-width: 100px !important;
        width: 8% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(5) {
        min-width: 120px !important;
        width: 10% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(6) {
        min-width: 80px !important;
        width: 6% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(7) {
        min-width: 80px !important;
        width: 6% !important;
    }
    
    .bibliografias-disponibles-table thead th:last-child {
        min-width: 120px !important;
        width: 10% !important;
    }
    
    .bibliografias-disponibles-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .bibliografias-disponibles-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .bibliografias-disponibles-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .bibliografias-disponibles-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .bibliografias-disponibles-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .bibliografias-disponibles-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .bibliografias-disponibles-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(1) {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(6),
    .bibliografias-disponibles-table tbody td:nth-child(7) {
        text-align: center !important;
    }
    
    .bibliografias-disponibles-table tbody td:last-child {
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
        border-color: #e3e6f0 !important;
        font-weight: 500 !important;
        padding: 0.5rem 0.75rem !important;
        transition: all 0.3s ease !important;
    }
    
    .pagination .page-link:hover {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.2) !important;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        font-weight: 600 !important;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
        background-color: #f8f9fa !important;
        border-color: #e3e6f0 !important;
    }
    
    /* Estilos para badges de disponibilidad */
    .badge.bg-primary {
        background-color: #4e73df !important;
    }
    
    .badge.bg-success {
        background-color: #1cc88a !important;
    }
    
    .badge.bg-info {
        background-color: #36b9cc !important;
    }
    
    .badge.bg-danger {
        background-color: #e74a3b !important;
    }
    
    /* Estilos para botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important;
        border-radius: 0.25rem !important;
    }
    
    .btn-info {
        background-color: #36b9cc !important;
        border-color: #36b9cc !important;
        color: white !important;
    }
    
    .btn-warning {
        background-color: #f6c23e !important;
        border-color: #f6c23e !important;
        color: white !important;
    }
    
    .btn-danger {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    .btn-link {
        color: #4e73df !important;
        text-decoration: none !important;
    }
    
    .btn-link:hover {
        color: #224abe !important;
        transform: scale(1.1) !important;
    }
</style>
";
        yield from [];
    }

    // line 281
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 282
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Bibliografías Disponibles</h1>
        <a href=\"";
        // line 285
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía
        </a>
    </div>

    ";
        // line 290
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 290)) {
            // line 291
            yield "        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            ";
            // line 292
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 292), "html", null, true);
            yield "
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    ";
        }
        // line 296
        yield "
    ";
        // line 297
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 297)) {
            // line 298
            yield "        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            ";
            // line 299
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 299), "html", null, true);
            yield "
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    ";
        }
        // line 303
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"busqueda\" class=\"form-label\">Buscar</label>
                    <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                           placeholder=\"Buscar por título, editorial o autor (ignora acentos, mayúsculas y orden de palabras)...\" value=\"";
        // line 314
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 314)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 314), "")) : ("")), "html", null, true);
        yield "\">
                    <small class=\"form-text text-muted\">
                        <i class=\"fas fa-info-circle\"></i>
                        La búsqueda ignora acentos, mayúsculas/minúsculas y permite palabras en cualquier orden.
                    </small>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"disponibilidad\" class=\"form-label\">Disponibilidad</label>
                    <select name=\"disponibilidad\" id=\"disponibilidad\" class=\"form-select\">
                        <option value=\"\">Todas</option>
                        <option value=\"impreso\" ";
        // line 324
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 324)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 324), "")) : ("")) == "impreso")) {
            yield "selected";
        }
        yield ">Impreso</option>
                        <option value=\"electronico\" ";
        // line 325
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 325)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 325), "")) : ("")) == "electronico")) {
            yield "selected";
        }
        yield ">Electrónico</option>
                        <option value=\"ambos\" ";
        // line 326
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", true, true, false, 326)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "disponibilidad", [], "any", false, false, false, 326), "")) : ("")) == "ambos")) {
            yield "selected";
        }
        yield ">Ambos</option>
                    </select>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select name=\"estado\" id=\"estado\" class=\"form-select\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 333
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 333)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 333), "")) : ("")) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 334
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", true, true, false, 334)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 334), "")) : ("")) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"anio_edicion\" class=\"form-label\">Año Edición</label>
                    <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                           placeholder=\"Año\" value=\"";
        // line 340
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", true, true, false, 340)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "anio_edicion", [], "any", false, false, false, 340), "")) : ("")), "html", null, true);
        yield "\"
                           min=\"1900\" max=\"";
        // line 341
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "\">
                </div>
                <div class=\"col-12\">
                    <div class=\"d-flex gap-2\">
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
        // line 357
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
            // line 358
            yield "        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Bibliografías Disponibles</h6>
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\" onchange=\"changePerPage(this.value)\">
                            ";
            // line 366
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 366));
            foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
                // line 367
                yield "                                <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
                yield "\" ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 367) == $context["option"])) {
                    yield "selected";
                }
                yield ">
                                    ";
                // line 368
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
                yield "
                                </option>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 371
            yield "                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando ";
            // line 374
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 374), "html", null, true);
            yield " de ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 374), "html", null, true);
            yield " registros
                    </div>
                </div>
            </div>
            <div class=\"card-body p-0\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-hover bibliografias-disponibles-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"";
            // line 384
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 384), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 384), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 384), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 384)), "html", null, true);
            yield "\">
                                        Título
                                        <i class=\"fas ";
            // line 386
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 386), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 386)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 390
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("editorial", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 390), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 390), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 390), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 390)), "html", null, true);
            yield "\">
                                        Editorial
                                        <i class=\"fas ";
            // line 392
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("editorial", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 392), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 392)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 396
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 396), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 396), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 396), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 396)), "html", null, true);
            yield "\">
                                        Autor(es)
                                        <i class=\"fas ";
            // line 398
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 398), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 398)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">Año Edición</th>
                                <th class=\"text-center\">Disponibilidad</th>
                                <th class=\"text-center\">
                                    <a href=\"";
            // line 404
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 404), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 404), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 404), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 404)), "html", null, true);
            yield "\">
                                        Estado
                                        <i class=\"fas ";
            // line 406
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 406), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 406)), "html", null, true);
            yield "\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">URL Acceso</th>
                                <th class=\"text-center\">URL Catálogo</th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 415
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                // line 416
                yield "                            <tr>
                                <td>";
                // line 417
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 417), "html", null, true);
                yield "</td>
                                <td>";
                // line 418
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 418), "html", null, true);
                yield "</td>
                                <td>";
                // line 419
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores_nombres", [], "any", true, true, false, 419)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores_nombres", [], "any", false, false, false, 419), "")) : ("")), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">";
                // line 420
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_edicion", [], "any", false, false, false, 420), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    ";
                // line 422
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibilidad", [], "any", false, false, false, 422) == "impreso")) {
                    // line 423
                    yield "                                        <span class=\"badge bg-primary\">Impreso</span>
                                    ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 424
$context["bibliografia"], "disponibilidad", [], "any", false, false, false, 424) == "electronico")) {
                    // line 425
                    yield "                                        <span class=\"badge bg-success\">Electrónico</span>
                                    ";
                } else {
                    // line 427
                    yield "                                        <span class=\"badge bg-info\">Ambos</span>
                                    ";
                }
                // line 429
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 431
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 431) == 1)) {
                    // line 432
                    yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
                } else {
                    // line 434
                    yield "                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
                }
                // line 436
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 438
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 438)) {
                    // line 439
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_acceso", [], "any", false, false, false, 439), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\" title=\"Acceder\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 443
                yield "                                </td>
                                <td class=\"text-center\">
                                    ";
                // line 445
                if (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 445)) {
                    // line 446
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "url_catalogo", [], "any", false, false, false, 446), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-sm btn-link\" title=\"Ver catálogo\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    ";
                }
                // line 450
                yield "                                </td>
                                <td class=\"text-center\">
                                    <div class=\"d-flex gap-2 justify-content-center\">
                                        <a href=\"";
                // line 453
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 453), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                            <i class=\"fas fa-eye\"></i>
                                        </a>
                                        <a href=\"";
                // line 456
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 456), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                            <i class=\"fas fa-edit\"></i>
                                        </a>
                                        <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" 
                                                onclick=\"confirmarEliminacion(";
                // line 460
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 460), "html", null, true);
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
            // line 467
            yield "                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                ";
            // line 472
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 472) > 1)) {
                // line 473
                yield "                <div class=\"card-footer\">
                    <nav aria-label=\"Navegación de páginas\">
                        <ul class=\"pagination justify-content-center mb-0\">
                            <!-- Primera página -->
                            <li class=\"page-item ";
                // line 477
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 477) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 478
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 478), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 478), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 478)), "html", null, true);
                yield "\" aria-label=\"Primera\">
                                    <i class=\"fas fa-angle-double-left\"></i>
                                </a>
                            </li>
                            
                            <!-- Página anterior -->
                            <li class=\"page-item ";
                // line 484
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 484) == 1)) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 485
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 485) - 1), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 485), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 485), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 485)), "html", null, true);
                yield "\" aria-label=\"Anterior\">
                                    <i class=\"fas fa-angle-left\"></i>
                                </a>
                            </li>

                            <!-- Números de página -->
                            ";
                // line 491
                $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 491) - 2));
                // line 492
                yield "                            ";
                $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 492), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 492) + 2));
                // line 493
                yield "                            
                            ";
                // line 494
                if ((($context["start_page"] ?? null) > 1)) {
                    // line 495
                    yield "                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"";
                    // line 496
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 496), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 496), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 496)), "html", null, true);
                    yield "\">1</a>
                                </li>
                                ";
                    // line 498
                    if ((($context["start_page"] ?? null) > 2)) {
                        // line 499
                        yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                ";
                    }
                    // line 503
                    yield "                            ";
                }
                // line 504
                yield "
                            ";
                // line 505
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                    // line 506
                    yield "                                <li class=\"page-item ";
                    if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 506))) {
                        yield "active";
                    }
                    yield "\">
                                    <a class=\"page-link\" href=\"";
                    // line 507
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 507), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 507), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 507)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                                </li>
                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 510
                yield "
                            ";
                // line 511
                if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 511))) {
                    // line 512
                    yield "                                ";
                    if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 512) - 1))) {
                        // line 513
                        yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                ";
                    }
                    // line 517
                    yield "                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"";
                    // line 518
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 518), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 518), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 518), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 518)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 518), "html", null, true);
                    yield "</a>
                                </li>
                            ";
                }
                // line 521
                yield "
                            <!-- Página siguiente -->
                            <li class=\"page-item ";
                // line 523
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 523) == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 523))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 524
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 524) + 1), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 524), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 524), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 524)), "html", null, true);
                yield "\" aria-label=\"Siguiente\">
                                    <i class=\"fas fa-angle-right\"></i>
                                </a>
                            </li>
                            
                            <!-- Última página -->
                            <li class=\"page-item ";
                // line 530
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 530) == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 530))) {
                    yield "disabled";
                }
                yield "\">
                                <a class=\"page-link\" href=\"";
                // line 531
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 531), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 531), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 531), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 531)), "html", null, true);
                yield "\" aria-label=\"Última\">
                                    <i class=\"fas fa-angle-double-right\"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                ";
            }
            // line 539
            yield "            </div>
        </div>
    ";
        } else {
            // line 542
            yield "        <div class=\"card shadow\">
            <div class=\"card-body text-center py-5\">
                <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                <h5 class=\"text-muted\">No se encontraron bibliografías disponibles</h5>
                <p class=\"text-muted\">Intenta ajustar los filtros de búsqueda</p>
            </div>
        </div>
    ";
        }
        // line 550
        yield "</div>

";
        // line 552
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 553
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un mensaje swal del servidor
    ";
        // line 557
        if (($context["swal"] ?? null)) {
            // line 558
            yield "        Swal.fire({
            icon: '";
            // line 559
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 559), "html", null, true);
            yield "',
            title: '";
            // line 560
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 560), "html", null, true);
            yield "',
            text: '";
            // line 561
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 561), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    ";
        }
        // line 565
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

function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', '1'); // Reset a la primera página
    window.location.href = url.toString();
}

// Manejar envío del formulario de filtros
document.getElementById('filtroForm').addEventListener('submit', function(e) {
    const currentUrl = new URL(window.location);
    const formData = new FormData(this);
    
    // Limpiar parámetros existentes
    currentUrl.search = '';
    
    // Agregar solo los filtros que tienen valor
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '') {
            currentUrl.searchParams.set(key, value);
        }
    }
    
    // Resetear paginación al aplicar filtros
    currentUrl.searchParams.set('page', '1');
    
    // Redirigir a la nueva URL
    window.location.href = currentUrl.toString();
    e.preventDefault();
});

// Manejar cambio de filtros en tiempo real (opcional)
document.querySelectorAll('select[name=\"disponibilidad\"], select[name=\"estado\"]').forEach(select => {
    select.addEventListener('change', function() {
        // Solo aplicar automáticamente si no es el campo de búsqueda (que requiere confirmación del usuario)
        if (this.name !== 'busqueda') {
            document.getElementById('filtroForm').dispatchEvent(new Event('submit'));
        }
    });
});

function limpiarFiltros() {
    window.location.href = '";
        // line 622
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/clear-state';
}

function confirmarEliminacion(id) {
    console.log('Iniciando eliminación para ID:', id);
    
    Swal.fire({
        title: '¿Está seguro?',
        text: \"¿Está seguro de que desea eliminar esta bibliografía disponible?\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Confirmado, creando formulario...');
            
            // Crear un formulario temporal para enviar la petición POST
            const form = document.createElement('form');
            form.method = 'POST';
            const actionUrl = '";
        // line 644
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/' + id + '/delete';
            form.action = actionUrl;
            
            console.log('URL de acción del formulario:', actionUrl);
            
            // Agregar el token CSRF si existe
            const csrfToken = document.querySelector('meta[name=\"csrf-token\"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Agregar un campo oculto para debug
            const debugInput = document.createElement('input');
            debugInput.type = 'hidden';
            debugInput.name = 'debug_action';
            debugInput.value = 'delete_bibliografia_disponible';
            form.appendChild(debugInput);
            
            document.body.appendChild(form);
            console.log('Formulario creado, enviando...');
            console.log('Formulario HTML:', form.outerHTML);
            form.submit();
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
        return array (  1012 => 644,  987 => 622,  928 => 565,  921 => 561,  917 => 560,  913 => 559,  910 => 558,  908 => 557,  902 => 553,  891 => 552,  887 => 550,  877 => 542,  872 => 539,  861 => 531,  855 => 530,  846 => 524,  840 => 523,  836 => 521,  828 => 518,  825 => 517,  819 => 513,  816 => 512,  814 => 511,  811 => 510,  800 => 507,  793 => 506,  789 => 505,  786 => 504,  783 => 503,  777 => 499,  775 => 498,  770 => 496,  767 => 495,  765 => 494,  762 => 493,  759 => 492,  757 => 491,  748 => 485,  742 => 484,  733 => 478,  727 => 477,  721 => 473,  719 => 472,  712 => 467,  699 => 460,  690 => 456,  682 => 453,  677 => 450,  669 => 446,  667 => 445,  663 => 443,  655 => 439,  653 => 438,  649 => 436,  645 => 434,  641 => 432,  639 => 431,  635 => 429,  631 => 427,  627 => 425,  625 => 424,  622 => 423,  620 => 422,  615 => 420,  611 => 419,  607 => 418,  603 => 417,  600 => 416,  596 => 415,  584 => 406,  579 => 404,  570 => 398,  565 => 396,  558 => 392,  553 => 390,  546 => 386,  541 => 384,  526 => 374,  521 => 371,  512 => 368,  503 => 367,  499 => 366,  489 => 358,  487 => 357,  468 => 341,  464 => 340,  453 => 334,  447 => 333,  435 => 326,  429 => 325,  423 => 324,  410 => 314,  397 => 303,  390 => 299,  387 => 298,  385 => 297,  382 => 296,  375 => 292,  372 => 291,  370 => 290,  362 => 285,  357 => 282,  350 => 281,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Bibliografías Disponibles - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de bibliografías disponibles */
    .bibliografias-disponibles-table thead th {
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
    
    .bibliografias-disponibles-table thead th:first-child {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(2) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(3) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(4) {
        min-width: 100px !important;
        width: 8% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(5) {
        min-width: 120px !important;
        width: 10% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(6) {
        min-width: 80px !important;
        width: 6% !important;
    }
    
    .bibliografias-disponibles-table thead th:nth-child(7) {
        min-width: 80px !important;
        width: 6% !important;
    }
    
    .bibliografias-disponibles-table thead th:last-child {
        min-width: 120px !important;
        width: 10% !important;
    }
    
    .bibliografias-disponibles-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .bibliografias-disponibles-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .bibliografias-disponibles-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .bibliografias-disponibles-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .bibliografias-disponibles-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .bibliografias-disponibles-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .bibliografias-disponibles-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(1) {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .bibliografias-disponibles-table tbody td:nth-child(6),
    .bibliografias-disponibles-table tbody td:nth-child(7) {
        text-align: center !important;
    }
    
    .bibliografias-disponibles-table tbody td:last-child {
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
        border-color: #e3e6f0 !important;
        font-weight: 500 !important;
        padding: 0.5rem 0.75rem !important;
        transition: all 0.3s ease !important;
    }
    
    .pagination .page-link:hover {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.2) !important;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        font-weight: 600 !important;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
        background-color: #f8f9fa !important;
        border-color: #e3e6f0 !important;
    }
    
    /* Estilos para badges de disponibilidad */
    .badge.bg-primary {
        background-color: #4e73df !important;
    }
    
    .badge.bg-success {
        background-color: #1cc88a !important;
    }
    
    .badge.bg-info {
        background-color: #36b9cc !important;
    }
    
    .badge.bg-danger {
        background-color: #e74a3b !important;
    }
    
    /* Estilos para botones de acción */
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important;
        border-radius: 0.25rem !important;
    }
    
    .btn-info {
        background-color: #36b9cc !important;
        border-color: #36b9cc !important;
        color: white !important;
    }
    
    .btn-warning {
        background-color: #f6c23e !important;
        border-color: #f6c23e !important;
        color: white !important;
    }
    
    .btn-danger {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    .btn-link {
        color: #4e73df !important;
        text-decoration: none !important;
    }
    
    .btn-link:hover {
        color: #224abe !important;
        transform: scale(1.1) !important;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Bibliografías Disponibles</h1>
        <a href=\"{{ app_url }}bibliografias-disponibles/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Bibliografía
        </a>
    </div>

    {% if session.success %}
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            {{ session.success }}
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    {% endif %}

    {% if session.error %}
        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            {{ session.error }}
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"filtroForm\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"busqueda\" class=\"form-label\">Buscar</label>
                    <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                           placeholder=\"Buscar por título, editorial o autor (ignora acentos, mayúsculas y orden de palabras)...\" value=\"{{ filtros.busqueda|default('') }}\">
                    <small class=\"form-text text-muted\">
                        <i class=\"fas fa-info-circle\"></i>
                        La búsqueda ignora acentos, mayúsculas/minúsculas y permite palabras en cualquier orden.
                    </small>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"disponibilidad\" class=\"form-label\">Disponibilidad</label>
                    <select name=\"disponibilidad\" id=\"disponibilidad\" class=\"form-select\">
                        <option value=\"\">Todas</option>
                        <option value=\"impreso\" {% if filtros.disponibilidad|default('') == 'impreso' %}selected{% endif %}>Impreso</option>
                        <option value=\"electronico\" {% if filtros.disponibilidad|default('') == 'electronico' %}selected{% endif %}>Electrónico</option>
                        <option value=\"ambos\" {% if filtros.disponibilidad|default('') == 'ambos' %}selected{% endif %}>Ambos</option>
                    </select>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select name=\"estado\" id=\"estado\" class=\"form-select\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" {% if filtros.estado|default('') == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado|default('') == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                <div class=\"col-md-2\">
                    <label for=\"anio_edicion\" class=\"form-label\">Año Edición</label>
                    <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                           placeholder=\"Año\" value=\"{{ filtros.anio_edicion|default('') }}\"
                           min=\"1900\" max=\"{{ \"now\"|date(\"Y\") }}\">
                </div>
                <div class=\"col-12\">
                    <div class=\"d-flex gap-2\">
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
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Bibliografías Disponibles</h6>
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\" onchange=\"changePerPage(this.value)\">
                            {% for option in paginacion.allowed_per_page %}
                                <option value=\"{{ option }}\" {% if paginacion.per_page == option %}selected{% endif %}>
                                    {{ option }}
                                </option>
                            {% endfor %}
                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando {{ paginacion.per_page }} de {{ paginacion.total_records }} registros
                    </div>
                </div>
            </div>
            <div class=\"card-body p-0\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-hover bibliografias-disponibles-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"{{ build_sort_url('titulo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Título
                                        <i class=\"fas {{ get_sort_icon('titulo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ build_sort_url('editorial', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Editorial
                                        <i class=\"fas {{ get_sort_icon('editorial', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ build_sort_url('autores', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Autor(es)
                                        <i class=\"fas {{ get_sort_icon('autores', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">Año Edición</th>
                                <th class=\"text-center\">Disponibilidad</th>
                                <th class=\"text-center\">
                                    <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                        Estado
                                        <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                    </a>
                                </th>
                                <th class=\"text-center\">URL Acceso</th>
                                <th class=\"text-center\">URL Catálogo</th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for bibliografia in bibliografias %}
                            <tr>
                                <td>{{ bibliografia.titulo }}</td>
                                <td>{{ bibliografia.editorial }}</td>
                                <td>{{ bibliografia.autores_nombres|default('') }}</td>
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
                                    {% if bibliografia.estado == 1 %}
                                        <span class=\"badge bg-success\">Activo</span>
                                    {% else %}
                                        <span class=\"badge bg-danger\">Inactivo</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    {% if bibliografia.url_acceso %}
                                        <a href=\"{{ bibliografia.url_acceso }}\" target=\"_blank\" class=\"btn btn-sm btn-link\" title=\"Acceder\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    {% if bibliografia.url_catalogo %}
                                        <a href=\"{{ bibliografia.url_catalogo }}\" target=\"_blank\" class=\"btn btn-sm btn-link\" title=\"Ver catálogo\">
                                            <i class=\"fas fa-external-link-alt\"></i>
                                        </a>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    <div class=\"d-flex gap-2 justify-content-center\">
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
                {% if paginacion.total_pages > 1 %}
                <div class=\"card-footer\">
                    <nav aria-label=\"Navegación de páginas\">
                        <ul class=\"pagination justify-content-center mb-0\">
                            <!-- Primera página -->
                            <li class=\"page-item {% if paginacion.current_page == 1 %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ build_page_url(1, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Primera\">
                                    <i class=\"fas fa-angle-double-left\"></i>
                                </a>
                            </li>
                            
                            <!-- Página anterior -->
                            <li class=\"page-item {% if paginacion.current_page == 1 %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ build_page_url(paginacion.current_page - 1, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Anterior\">
                                    <i class=\"fas fa-angle-left\"></i>
                                </a>
                            </li>

                            <!-- Números de página -->
                            {% set start_page = max(1, paginacion.current_page - 2) %}
                            {% set end_page = min(paginacion.total_pages, paginacion.current_page + 2) %}
                            
                            {% if start_page > 1 %}
                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(1, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">1</a>
                                </li>
                                {% if start_page > 2 %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                {% endif %}
                            {% endif %}

                            {% for page_num in start_page..end_page %}
                                <li class=\"page-item {% if page_num == paginacion.current_page %}active{% endif %}\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(page_num, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">{{ page_num }}</a>
                                </li>
                            {% endfor %}

                            {% if end_page < paginacion.total_pages %}
                                {% if end_page < paginacion.total_pages - 1 %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">...</span>
                                    </li>
                                {% endif %}
                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"{{ build_page_url(paginacion.total_pages, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">{{ paginacion.total_pages }}</a>
                                </li>
                            {% endif %}

                            <!-- Página siguiente -->
                            <li class=\"page-item {% if paginacion.current_page == paginacion.total_pages %}disabled{% endif %}\">
                                <a class=\"page-link\" href=\"{{ build_page_url(paginacion.current_page + 1, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\" aria-label=\"Siguiente\">
                                    <i class=\"fas fa-angle-right\"></i>
                                </a>
                            </li>
                            
                            <!-- Última página -->
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
        <div class=\"card shadow\">
            <div class=\"card-body text-center py-5\">
                <i class=\"fas fa-book fa-3x text-muted mb-3\"></i>
                <h5 class=\"text-muted\">No se encontraron bibliografías disponibles</h5>
                <p class=\"text-muted\">Intenta ajustar los filtros de búsqueda</p>
            </div>
        </div>
    {% endif %}
</div>

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

function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.set('page', '1'); // Reset a la primera página
    window.location.href = url.toString();
}

// Manejar envío del formulario de filtros
document.getElementById('filtroForm').addEventListener('submit', function(e) {
    const currentUrl = new URL(window.location);
    const formData = new FormData(this);
    
    // Limpiar parámetros existentes
    currentUrl.search = '';
    
    // Agregar solo los filtros que tienen valor
    for (let [key, value] of formData.entries()) {
        if (value && value.trim() !== '') {
            currentUrl.searchParams.set(key, value);
        }
    }
    
    // Resetear paginación al aplicar filtros
    currentUrl.searchParams.set('page', '1');
    
    // Redirigir a la nueva URL
    window.location.href = currentUrl.toString();
    e.preventDefault();
});

// Manejar cambio de filtros en tiempo real (opcional)
document.querySelectorAll('select[name=\"disponibilidad\"], select[name=\"estado\"]').forEach(select => {
    select.addEventListener('change', function() {
        // Solo aplicar automáticamente si no es el campo de búsqueda (que requiere confirmación del usuario)
        if (this.name !== 'busqueda') {
            document.getElementById('filtroForm').dispatchEvent(new Event('submit'));
        }
    });
});

function limpiarFiltros() {
    window.location.href = '{{ app_url }}bibliografias-disponibles/clear-state';
}

function confirmarEliminacion(id) {
    console.log('Iniciando eliminación para ID:', id);
    
    Swal.fire({
        title: '¿Está seguro?',
        text: \"¿Está seguro de que desea eliminar esta bibliografía disponible?\",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Confirmado, creando formulario...');
            
            // Crear un formulario temporal para enviar la petición POST
            const form = document.createElement('form');
            form.method = 'POST';
            const actionUrl = '{{ app_url }}bibliografias-disponibles/' + id + '/delete';
            form.action = actionUrl;
            
            console.log('URL de acción del formulario:', actionUrl);
            
            // Agregar el token CSRF si existe
            const csrfToken = document.querySelector('meta[name=\"csrf-token\"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Agregar un campo oculto para debug
            const debugInput = document.createElement('input');
            debugInput.type = 'hidden';
            debugInput.name = 'debug_action';
            debugInput.value = 'delete_bibliografia_disponible';
            form.appendChild(debugInput);
            
            document.body.appendChild(form);
            console.log('Formulario creado, enviando...');
            console.log('Formulario HTML:', form.outerHTML);
            form.submit();
        }
    });
}
</script>
{% endblock %}
{% endblock %} ", "bibliografias_disponibles/index.twig", "/var/www/html/biblioges/templates/bibliografias_disponibles/index.twig");
    }
}
