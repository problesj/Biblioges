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

/* tareas_programadas/index.twig */
class __TwigTemplate_023bb236ce09185b2d249aea4f59399b extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "tareas_programadas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Gestión de Tareas Programadas - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de tareas programadas */
    .tareas-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .tareas-table thead th {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;
        padding: 8px 4px !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    /* Distribución de columnas optimizada */
    .tareas-table thead th:first-child {
        width: 6% !important;
        min-width: 60px !important;
    }
    
    .tareas-table thead th:nth-child(2) {
        width: 18% !important;
        min-width: 150px !important;
    }
    
    .tareas-table thead th:nth-child(3) {
        width: 15% !important;
        min-width: 140px !important;
    }
    
    .tareas-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:nth-child(5) {
        width: 15% !important;
        min-width: 140px !important;
    }
    
    .tareas-table thead th:nth-child(6) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:nth-child(7) {
        width: 8% !important;
        min-width: 80px !important;
    }
    
    .tareas-table thead th:nth-child(8) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:last-child {
        width: 8% !important;
        min-width: 80px !important;
    }
    
    .tareas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .tareas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .tareas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .tareas-table thead th a .fas {
        margin-left: 4px !important;
        font-size: 0.7rem !important;
        opacity: 0.8 !important;
    }
    
    .tareas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .tareas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .tareas-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.3 !important;
        word-wrap: break-word !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        max-width: 0 !important;
    }
    
    .tareas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        text-align: center !important;
    }
    
    .tareas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #2c3e50 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(3) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(4) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(5) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(6) {
        text-align: center !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(7) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(8) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:last-child {
        text-align: center !important;
        white-space: nowrap !important;
    }
    
    /* Estilos para badges */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.3em 0.6em !important;
        font-weight: 500 !important;
        border-radius: 0.375rem !important;
        white-space: nowrap !important;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 4px !important;
        margin: 0 2px !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .btn-action:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    .btn-action.btn-view {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
    }
    
    .btn-action.btn-edit {
        background-color: #f6c23e !important;
        border-color: #f6c23e !important;
        color: #2c3e50 !important;
    }
    
    .btn-action.btn-cancel {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    .btn-action.btn-delete {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    /* Estilos para filtros */
    .card-header {
        background-color: #f8f9fc !important;
        border-bottom: 1px solid #e3e6f0 !important;
    }
    
    .card-header h6 {
        color: #4e73df !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
    }
    
    .form-control,
    .form-select {
        border-radius: 0.375rem !important;
        border: 1px solid #d1d3e2 !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }
    
    /* Estilos para botones */
    .btn {
        border-radius: 0.375rem !important;
        font-weight: 500 !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    /* Estilos para paginación */
    .pagination {
        margin-top: 1.25rem !important;
        justify-content: center !important;
    }
    
    .page-link {
        border-radius: 0.375rem !important;
        margin: 0 2px !important;
        border: 1px solid #d1d3e2 !important;
        color: #4e73df !important;
        font-weight: 500 !important;
        font-size: 0.8rem !important;
        padding: 0.4rem 0.6rem !important;
        transition: all 0.2s ease !important;
    }
    
    .page-link:hover {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        transform: translateY(-1px) !important;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
    }
    
    .page-item.disabled .page-link {
        color: #858796 !important;
        background-color: #f8f9fc !important;
        border-color: #d1d3e2 !important;
    }
    
    /* Estilos para selector de registros por página */
    .per-page-selector {
        background: rgba(78, 115, 223, 0.1) !important;
        border-radius: 0.5rem !important;
        padding: 0.4rem 0.8rem !important;
        border: 1px solid rgba(78, 115, 223, 0.2) !important;
    }
    
    .per-page-selector label {
        color: #4e73df !important;
        font-weight: 600 !important;
        margin-bottom: 0 !important;
        font-size: 0.8rem !important;
    }
    
    .per-page-selector select {
        border: 1px solid rgba(78, 115, 223, 0.3) !important;
        border-radius: 0.375rem !important;
        color: #4e73df !important;
        font-weight: 500 !important;
        background-color: white !important;
        font-size: 0.8rem !important;
    }
    
    .records-counter {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
    }
    
    /* Estilos para el contenedor principal */
    .container-fluid {
        padding: 0 1rem !important;
    }
    
    .card {
        margin-bottom: 1.5rem !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%) !important;
        border-bottom: 1px solid #d1d3e2 !important;
        padding: 1rem 1.25rem !important;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    
    .card-body {
        padding: 1.25rem !important;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.75rem !important;
            padding: 6px 4px !important;
        }
        
        .tareas-table thead th a {
            padding: 4px !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 0.25em 0.5em !important;
        }
    }
    
    @media (max-width: 768px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.7rem !important;
            padding: 4px 2px !important;
        }
        
        .filters-section {
            padding: 1rem !important;
        }
        
        .filter-buttons {
            justify-content: center !important;
        }
        
        .card-header {
            padding: 0.75rem 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
    }
    
    /* Optimización para pantallas grandes */
    @media (min-width: 1400px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.85rem !important;
            padding: 10px 8px !important;
        }
        
        .tareas-table thead th a {
            padding: 8px !important;
        }
        
        .badge {
            font-size: 0.75rem !important;
            padding: 0.35em 0.65em !important;
        }
    }
</style>
";
        yield from [];
    }

    // line 429
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 430
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <!-- Header principal -->
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <div class=\"d-flex align-items-center\">
                    <i class=\"fas fa-clock fa-2x text-dark me-3\"></i>
                    <h2 class=\"mb-0 text-dark fw-bold\">Gestión de Tareas Programadas</h2>
                </div>
                <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modalNuevaTarea\">
                    <i class=\"fas fa-plus me-2\"></i>Nueva Tarea
                </button>
            </div>

            <!-- Filtros de Búsqueda -->
            <div class=\"card shadow mb-4\">
                <div class=\"card-header bg-white\">
                    <h6 class=\"text-primary fw-bold mb-3\">
                        <i class=\"fas fa-filter me-2\"></i>Filtros de Búsqueda
                    </h6>
                    <form method=\"GET\" class=\"row g-3\">
                        <div class=\"col-md-4\">
                            <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                   value=\"";
        // line 453
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "search", [], "any", false, false, false, 453), "html", null, true);
        yield "\" placeholder=\"Nombre, sede o carrera\">
                        </div>
                        <div class=\"col-md-3\">
                            <select class=\"form-select\" id=\"tipo_reporte\" name=\"tipo_reporte\">
                                <option value=\"\">Todos los tipos</option>
                                ";
        // line 458
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["tiposReporte"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 459
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_reporte", [], "any", false, false, false, 459) == $context["key"])) {
                yield "selected";
            }
            yield ">
                                        ";
            // line 460
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 463
        yield "                            </select>
                        </div>
                        <div class=\"col-md-3\">
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos los estados</option>
                                ";
        // line 468
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["estados"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 469
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 469) == $context["key"])) {
                yield "selected";
            }
            yield ">
                                        ";
            // line 470
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 473
        yield "                            </select>
                        </div>
                        <div class=\"col-md-2\">
                            <button type=\"submit\" class=\"btn btn-primary w-100\">
                                <i class=\"fas fa-chevron-down me-2\"></i>Aplicar Filtros
                            </button>
                        </div>
                    </form>
                    <div class=\"mt-3\">
                        <a href=\"";
        // line 482
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "tareas-programadas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times me-2\"></i>Limpiar Filtros
                        </a>
                    </div>
                </div>
            </div>

            <!-- Listado de Tareas -->
            <div class=\"card shadow\">
                <div class=\"card-header bg-white\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h6 class=\"text-primary fw-bold mb-0\">
                            <i class=\"fas fa-list me-2\"></i>Listado de Tareas Programadas
                        </h6>
                        <div class=\"d-flex align-items-center gap-3\">
                            <span class=\"text-muted\">Registros por página:</span>
                            <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                                ";
        // line 499
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 499));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 500
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 500) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                        ";
            // line 501
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 504
        yield "                            </select>
                            <span class=\"text-muted\">
                                Mostrando ";
        // line 506
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 506), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 506), "html", null, true);
        yield " registros
                            </span>
                        </div>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-striped table-hover tareas-table mb-0\">
                            <thead>
                                <tr>
                                    <th>
                                        <a href=\"";
        // line 517
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("id", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 517), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 517), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 517), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 517)), "html", null, true);
        yield "\">
                                            ID
                                            <i class=\"fas ";
        // line 519
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("id", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 519), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 519)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href=\"";
        // line 523
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 523), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 523), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 523), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 523)), "html", null, true);
        yield "\">
                                            NOMBRE
                                            <i class=\"fas ";
        // line 525
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 525), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 525)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 529
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo_reporte", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 529), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 529), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 529), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 529)), "html", null, true);
        yield "\">
                                            TIPO DE<br>REPORTE
                                            <i class=\"fas ";
        // line 531
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo_reporte", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 531), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 531)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 535
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("sede_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 535), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 535), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 535), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 535)), "html", null, true);
        yield "\">
                                            SEDE
                                            <i class=\"fas ";
        // line 537
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("sede_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 537), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 537)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 541
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("carrera_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 541), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 541), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 541), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 541)), "html", null, true);
        yield "\">
                                            CARRERA
                                            <i class=\"fas ";
        // line 543
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("carrera_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 543), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 543)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 547
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("fecha_programada", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 547), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 547), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 547), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 547)), "html", null, true);
        yield "\">
                                            FECHA<br>PROGRAMADA
                                            <i class=\"fas ";
        // line 549
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("fecha_programada", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 549), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 549)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 553
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 553), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 553), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 553), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 553)), "html", null, true);
        yield "\">
                                            ESTADO
                                            <i class=\"fas ";
        // line 555
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 555), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 555)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"";
        // line 559
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("fecha_creacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 559), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 559), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 559), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 559)), "html", null, true);
        yield "\">
                                            FECHA
                                            <i class=\"fas ";
        // line 561
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("fecha_creacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 561), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 561)), "html", null, true);
        yield "\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 568
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["tareas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["tarea"]) {
            // line 569
            yield "                                <tr>
                                    <td>";
            // line 570
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "id", [], "any", false, false, false, 570), "html", null, true);
            yield "</td>
                                    <td title=\"";
            // line 571
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "nombre", [], "any", false, false, false, 571), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "nombre", [], "any", false, false, false, 571), "html", null, true);
            yield "</td>
                                    <td class=\"text-center\">
                                        ";
            // line 573
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "tipo_reporte", [], "any", false, false, false, 573) == "cobertura_basica_expandido")) {
                // line 574
                yield "                                            <span class=\"badge bg-info text-dark\">Cobertura Básica Expandido</span>
                                        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 575
$context["tarea"], "tipo_reporte", [], "any", false, false, false, 575) == "cobertura_complementaria_expandido")) {
                // line 576
                yield "                                            <span class=\"badge bg-warning text-dark\">Cobertura Complementaria Expandido</span>
                                        ";
            } else {
                // line 578
                yield "                                            <span class=\"badge bg-secondary\">Sin tipo</span>
                                        ";
            }
            // line 580
            yield "                                    </td>
                                    <td class=\"text-center\" title=\"";
            // line 581
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "sede_nombre", [], "any", false, false, false, 581), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "sede_nombre", [], "any", false, false, false, 581), "html", null, true);
            yield "</td>
                                    <td class=\"text-center\" title=\"";
            // line 582
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "carrera_nombre", [], "any", false, false, false, 582), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "carrera_nombre", [], "any", false, false, false, 582), "html", null, true);
            yield "</td>
                                    <td class=\"text-center\">";
            // line 583
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "fecha_programada", [], "any", false, false, false, 583), "d/m/Y H:i"), "html", null, true);
            yield "</td>
                                    <td class=\"text-center\">
                                        ";
            // line 585
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "estado", [], "any", false, false, false, 585) == "pendiente")) {
                // line 586
                yield "                                            <span class=\"badge bg-secondary\">Pendiente</span>
                                        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 587
$context["tarea"], "estado", [], "any", false, false, false, 587) == "en_proceso")) {
                // line 588
                yield "                                            <span class=\"badge bg-primary\">En Proceso</span>
                                        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 589
$context["tarea"], "estado", [], "any", false, false, false, 589) == "completada")) {
                // line 590
                yield "                                            <span class=\"badge bg-success\">Completada</span>
                                        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 591
$context["tarea"], "estado", [], "any", false, false, false, 591) == "error")) {
                // line 592
                yield "                                            <span class=\"badge bg-danger\">Error</span>
                                        ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 593
$context["tarea"], "estado", [], "any", false, false, false, 593) == "cancelada")) {
                // line 594
                yield "                                            <span class=\"badge bg-dark\">Cancelada</span>
                                        ";
            } else {
                // line 596
                yield "                                            <span class=\"badge bg-secondary\">Desconocido</span>
                                        ";
            }
            // line 598
            yield "                                    </td>
                                    <td class=\"text-center\">";
            // line 599
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "fecha_creacion", [], "any", false, false, false, 599), "d/m/Y H:i"), "html", null, true);
            yield "</td>
                                    <td class=\"text-center\">
                                        <div class=\"d-flex gap-1 justify-content-center\">
                                            ";
            // line 602
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "estado", [], "any", false, false, false, 602) == "pendiente")) {
                // line 603
                yield "                                                <button type=\"button\" class=\"btn btn-action btn-cancel\" 
                                                        onclick=\"cancelarTarea(";
                // line 604
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "id", [], "any", false, false, false, 604), "html", null, true);
                yield ")\" title=\"Cancelar\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                                            ";
            }
            // line 608
            yield "                                            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "estado", [], "any", false, false, false, 608) == "error")) {
                // line 609
                yield "                                                <button type=\"button\" class=\"btn btn-action btn-view\" 
                                                        onclick=\"verError(";
                // line 610
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "id", [], "any", false, false, false, 610), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tarea"], "error_mensaje", [], "any", false, false, false, 610));
                yield "')\" title=\"Ver Error\">
                                                    <i class=\"fas fa-exclamation-triangle\"></i>
                                                </button>
                                            ";
            }
            // line 614
            yield "                                        </div>
                                    </td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 617
        if (!$context['_iterated']) {
            // line 618
            yield "                                <tr>
                                    <td colspan=\"9\" class=\"text-center\">No se encontraron tareas programadas</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tarea'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 622
        yield "                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    ";
        // line 627
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 627) > 1)) {
            // line 628
            yield "                    <div class=\"card-footer\">
                        <nav aria-label=\"Navegación de páginas\">
                            <ul class=\"pagination justify-content-center mb-0\">
                                <!-- Botón Anterior -->
                                ";
            // line 632
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 632)) {
                // line 633
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"";
                // line 634
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 634), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 634), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 634), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 634)), "html", null, true);
                yield "\">
                                            <i class=\"fas fa-chevron-left\"></i> Anterior
                                        </a>
                                    </li>
                                ";
            } else {
                // line 639
                yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                                    </li>
                                ";
            }
            // line 643
            yield "
                                <!-- Números de página -->
                                ";
            // line 645
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 645) - 2));
            // line 646
            yield "                                ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 646), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 646) + 2));
            // line 647
            yield "
                                ";
            // line 648
            if ((($context["start_page"] ?? null) > 1)) {
                // line 649
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"";
                // line 650
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 650), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 650), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 650)), "html", null, true);
                yield "\">1</a>
                                    </li>
                                    ";
                // line 652
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 653
                    yield "                                        <li class=\"page-item disabled\">
                                            <span class=\"page-link\">...</span>
                                        </li>
                                    ";
                }
                // line 657
                yield "                                ";
            }
            // line 658
            yield "
                                ";
            // line 659
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 660
                yield "                                    ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 660))) {
                    // line 661
                    yield "                                        <li class=\"page-item active\">
                                            <span class=\"page-link\">";
                    // line 662
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                                        </li>
                                    ";
                } else {
                    // line 665
                    yield "                                        <li class=\"page-item\">
                                            <a class=\"page-link\" href=\"";
                    // line 666
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 666), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 666), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 666)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                                        </li>
                                    ";
                }
                // line 669
                yield "                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 670
            yield "
                                ";
            // line 671
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 671))) {
                // line 672
                yield "                                    ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 672) - 1))) {
                    // line 673
                    yield "                                        <li class=\"page-item disabled\">
                                            <span class=\"page-link\">...</span>
                                        </li>
                                    ";
                }
                // line 677
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"";
                // line 678
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 678), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 678), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 678), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 678)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 678), "html", null, true);
                yield "</a>
                                    </li>
                                ";
            }
            // line 681
            yield "
                                <!-- Botón Siguiente -->
                                ";
            // line 683
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 683)) {
                // line 684
                yield "                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"";
                // line 685
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 685), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 685), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 685), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 685)), "html", null, true);
                yield "\">
                                            Siguiente <i class=\"fas fa-chevron-right\"></i>
                                        </a>
                                    </li>
                                ";
            } else {
                // line 690
                yield "                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                                    </li>
                                ";
            }
            // line 694
            yield "                            </ul>
                        </nav>
                    </div>
                    ";
        }
        // line 698
        yield "                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Tarea -->
<div class=\"modal fade\" id=\"modalNuevaTarea\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalNuevaTareaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalNuevaTareaLabel\">
                    <i class=\"fas fa-plus\"></i> Nueva Tarea Programada
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"formNuevaTarea\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"nombre\" class=\"form-label\">Nombre de la Tarea *</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"tipo_reporte\" class=\"form-label\">Tipo de Reporte *</label>
                                <select class=\"form-select\" id=\"tipo_reporte\" name=\"tipo_reporte\" required>
                                    <option value=\"\">Seleccione un tipo</option>
                                    <option value=\"cobertura_basica_expandido\">Cobertura Básica Expandido</option>
                                    <option value=\"cobertura_complementaria_expandido\">Cobertura Complementaria Expandido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"sede_id\" class=\"form-label\">Sede *</label>
                                <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\" required>
                                    <option value=\"\">Seleccione una sede</option>
                                    ";
        // line 740
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 741
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 741), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "sede", [], "any", false, false, false, 741), "html", null, true);
            yield "</option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 743
        yield "                                </select>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"carrera_id\" class=\"form-label\">Carrera *</label>
                                <select class=\"form-select\" id=\"carrera_id\" name=\"carrera_id\" required>
                                    <option value=\"\">Seleccione una carrera</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"fecha_programada\" class=\"form-label\">Fecha y Hora Programada *</label>
                                <input type=\"datetime-local\" class=\"form-control\" id=\"fecha_programada\" name=\"fecha_programada\" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" onclick=\"crearTarea()\">
                    <i class=\"fas fa-save\"></i> Crear Tarea
                </button>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 776
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 777
        yield "<script>
    // Evento para cambiar registros por página
    document.getElementById('per_page').addEventListener('change', function() {
        const perPage = this.value;
        const currentUrl = new URL(window.location);
        
        // Actualizar parámetro per_page
        currentUrl.searchParams.set('per_page', perPage);
        
        // Resetear a la primera página cuando se cambia el número de registros
        currentUrl.searchParams.set('page', '1');
        
        // Redirigir a la nueva URL
        window.location.href = currentUrl.toString();
    });

    // Filtrar carreras según la sede seleccionada
    document.getElementById('sede_id').addEventListener('change', function() {
        const sedeId = this.value;
        const carreraSelect = document.getElementById('carrera_id');
        
        // Limpiar opciones actuales
        carreraSelect.innerHTML = '<option value=\"\">Seleccione una carrera</option>';
        
        if (sedeId) {
            // Filtrar carreras por sede
            const carreras = ";
        // line 803
        yield json_encode(($context["carreras"] ?? null));
        yield ";
            const carrerasFiltradas = carreras.filter(carrera => carrera.id_sede == sedeId);
            
            carrerasFiltradas.forEach(carrera => {
                const option = document.createElement('option');
                option.value = carrera.id;
                option.textContent = carrera.carrera;
                carreraSelect.appendChild(option);
            });
        }
    });

    // Función para crear nueva tarea
    function crearTarea() {
        const form = document.getElementById('formNuevaTarea');
        const formData = new FormData(form);
        
        // Convertir FormData a objeto
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        
        // Validar que todos los campos requeridos estén completos
        if (!data.nombre || !data.tipo_reporte || !data.sede_id || !data.carrera_id || !data.fecha_programada) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor complete todos los campos requeridos'
            });
            return;
        }
        
        // Enviar petición AJAX
        fetch('";
        // line 837
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "tareas-programadas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Error al crear la tarea'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de conexión al crear la tarea'
            });
        });
    }

    // Función para cancelar tarea
    function cancelarTarea(tareaId) {
        Swal.fire({
            title: '¿Está seguro?',
            text: \"Esta acción cancelará la tarea programada\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('";
        // line 885
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "tareas-programadas/' + tareaId + '/cancelar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: result.message
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message || 'Error al cancelar la tarea'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión al cancelar la tarea'
                    });
                });
            }
        });
    }

    // Función para ver error
    function verError(tareaId, errorMensaje) {
        Swal.fire({
            title: 'Error en Tarea #' + tareaId,
            text: errorMensaje || 'No hay información de error disponible',
            icon: 'error',
            confirmButtonText: 'Cerrar'
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
        return "tareas_programadas/index.twig";
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
        return array (  1274 => 885,  1223 => 837,  1186 => 803,  1158 => 777,  1151 => 776,  1115 => 743,  1104 => 741,  1100 => 740,  1056 => 698,  1050 => 694,  1044 => 690,  1036 => 685,  1033 => 684,  1031 => 683,  1027 => 681,  1019 => 678,  1016 => 677,  1010 => 673,  1007 => 672,  1005 => 671,  1002 => 670,  996 => 669,  988 => 666,  985 => 665,  979 => 662,  976 => 661,  973 => 660,  969 => 659,  966 => 658,  963 => 657,  957 => 653,  955 => 652,  950 => 650,  947 => 649,  945 => 648,  942 => 647,  939 => 646,  937 => 645,  933 => 643,  927 => 639,  919 => 634,  916 => 633,  914 => 632,  908 => 628,  906 => 627,  899 => 622,  890 => 618,  888 => 617,  881 => 614,  872 => 610,  869 => 609,  866 => 608,  859 => 604,  856 => 603,  854 => 602,  848 => 599,  845 => 598,  841 => 596,  837 => 594,  835 => 593,  832 => 592,  830 => 591,  827 => 590,  825 => 589,  822 => 588,  820 => 587,  817 => 586,  815 => 585,  810 => 583,  804 => 582,  798 => 581,  795 => 580,  791 => 578,  787 => 576,  785 => 575,  782 => 574,  780 => 573,  773 => 571,  769 => 570,  766 => 569,  761 => 568,  751 => 561,  746 => 559,  739 => 555,  734 => 553,  727 => 549,  722 => 547,  715 => 543,  710 => 541,  703 => 537,  698 => 535,  691 => 531,  686 => 529,  679 => 525,  674 => 523,  667 => 519,  662 => 517,  646 => 506,  642 => 504,  633 => 501,  624 => 500,  620 => 499,  600 => 482,  589 => 473,  580 => 470,  571 => 469,  567 => 468,  560 => 463,  551 => 460,  542 => 459,  538 => 458,  530 => 453,  505 => 430,  498 => 429,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Gestión de Tareas Programadas - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de tareas programadas */
    .tareas-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .tareas-table thead th {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;
        padding: 8px 4px !important;
        border: none !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    /* Distribución de columnas optimizada */
    .tareas-table thead th:first-child {
        width: 6% !important;
        min-width: 60px !important;
    }
    
    .tareas-table thead th:nth-child(2) {
        width: 18% !important;
        min-width: 150px !important;
    }
    
    .tareas-table thead th:nth-child(3) {
        width: 15% !important;
        min-width: 140px !important;
    }
    
    .tareas-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:nth-child(5) {
        width: 15% !important;
        min-width: 140px !important;
    }
    
    .tareas-table thead th:nth-child(6) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:nth-child(7) {
        width: 8% !important;
        min-width: 80px !important;
    }
    
    .tareas-table thead th:nth-child(8) {
        width: 12% !important;
        min-width: 120px !important;
    }
    
    .tareas-table thead th:last-child {
        width: 8% !important;
        min-width: 80px !important;
    }
    
    .tareas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .tareas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .tareas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .tareas-table thead th a .fas {
        margin-left: 4px !important;
        font-size: 0.7rem !important;
        opacity: 0.8 !important;
    }
    
    .tareas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .tareas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .tareas-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.3 !important;
        word-wrap: break-word !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        max-width: 0 !important;
    }
    
    .tareas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        text-align: center !important;
    }
    
    .tareas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #2c3e50 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(3) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(4) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(5) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(6) {
        text-align: center !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(7) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:nth-child(8) {
        text-align: center !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    
    .tareas-table tbody td:last-child {
        text-align: center !important;
        white-space: nowrap !important;
    }
    
    /* Estilos para badges */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.3em 0.6em !important;
        font-weight: 500 !important;
        border-radius: 0.375rem !important;
        white-space: nowrap !important;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 4px !important;
        margin: 0 2px !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .btn-action:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    .btn-action.btn-view {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
    }
    
    .btn-action.btn-edit {
        background-color: #f6c23e !important;
        border-color: #f6c23e !important;
        color: #2c3e50 !important;
    }
    
    .btn-action.btn-cancel {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    .btn-action.btn-delete {
        background-color: #e74a3b !important;
        border-color: #e74a3b !important;
        color: white !important;
    }
    
    /* Estilos para filtros */
    .card-header {
        background-color: #f8f9fc !important;
        border-bottom: 1px solid #e3e6f0 !important;
    }
    
    .card-header h6 {
        color: #4e73df !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
    }
    
    .form-control,
    .form-select {
        border-radius: 0.375rem !important;
        border: 1px solid #d1d3e2 !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }
    
    /* Estilos para botones */
    .btn {
        border-radius: 0.375rem !important;
        font-weight: 500 !important;
        font-size: 0.8rem !important;
        transition: all 0.2s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    /* Estilos para paginación */
    .pagination {
        margin-top: 1.25rem !important;
        justify-content: center !important;
    }
    
    .page-link {
        border-radius: 0.375rem !important;
        margin: 0 2px !important;
        border: 1px solid #d1d3e2 !important;
        color: #4e73df !important;
        font-weight: 500 !important;
        font-size: 0.8rem !important;
        padding: 0.4rem 0.6rem !important;
        transition: all 0.2s ease !important;
    }
    
    .page-link:hover {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
        transform: translateY(-1px) !important;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white !important;
    }
    
    .page-item.disabled .page-link {
        color: #858796 !important;
        background-color: #f8f9fc !important;
        border-color: #d1d3e2 !important;
    }
    
    /* Estilos para selector de registros por página */
    .per-page-selector {
        background: rgba(78, 115, 223, 0.1) !important;
        border-radius: 0.5rem !important;
        padding: 0.4rem 0.8rem !important;
        border: 1px solid rgba(78, 115, 223, 0.2) !important;
    }
    
    .per-page-selector label {
        color: #4e73df !important;
        font-weight: 600 !important;
        margin-bottom: 0 !important;
        font-size: 0.8rem !important;
    }
    
    .per-page-selector select {
        border: 1px solid rgba(78, 115, 223, 0.3) !important;
        border-radius: 0.375rem !important;
        color: #4e73df !important;
        font-weight: 500 !important;
        background-color: white !important;
        font-size: 0.8rem !important;
    }
    
    .records-counter {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
    }
    
    /* Estilos para el contenedor principal */
    .container-fluid {
        padding: 0 1rem !important;
    }
    
    .card {
        margin-bottom: 1.5rem !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%) !important;
        border-bottom: 1px solid #d1d3e2 !important;
        padding: 1rem 1.25rem !important;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    
    .card-body {
        padding: 1.25rem !important;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.75rem !important;
            padding: 6px 4px !important;
        }
        
        .tareas-table thead th a {
            padding: 4px !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 0.25em 0.5em !important;
        }
    }
    
    @media (max-width: 768px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.7rem !important;
            padding: 4px 2px !important;
        }
        
        .filters-section {
            padding: 1rem !important;
        }
        
        .filter-buttons {
            justify-content: center !important;
        }
        
        .card-header {
            padding: 0.75rem 1rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
    }
    
    /* Optimización para pantallas grandes */
    @media (min-width: 1400px) {
        .tareas-table thead th,
        .tareas-table tbody td {
            font-size: 0.85rem !important;
            padding: 10px 8px !important;
        }
        
        .tareas-table thead th a {
            padding: 8px !important;
        }
        
        .badge {
            font-size: 0.75rem !important;
            padding: 0.35em 0.65em !important;
        }
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <!-- Header principal -->
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <div class=\"d-flex align-items-center\">
                    <i class=\"fas fa-clock fa-2x text-dark me-3\"></i>
                    <h2 class=\"mb-0 text-dark fw-bold\">Gestión de Tareas Programadas</h2>
                </div>
                <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modalNuevaTarea\">
                    <i class=\"fas fa-plus me-2\"></i>Nueva Tarea
                </button>
            </div>

            <!-- Filtros de Búsqueda -->
            <div class=\"card shadow mb-4\">
                <div class=\"card-header bg-white\">
                    <h6 class=\"text-primary fw-bold mb-3\">
                        <i class=\"fas fa-filter me-2\"></i>Filtros de Búsqueda
                    </h6>
                    <form method=\"GET\" class=\"row g-3\">
                        <div class=\"col-md-4\">
                            <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                   value=\"{{ filtros.search }}\" placeholder=\"Nombre, sede o carrera\">
                        </div>
                        <div class=\"col-md-3\">
                            <select class=\"form-select\" id=\"tipo_reporte\" name=\"tipo_reporte\">
                                <option value=\"\">Todos los tipos</option>
                                {% for key, value in tiposReporte %}
                                    <option value=\"{{ key }}\" {% if filtros.tipo_reporte == key %}selected{% endif %}>
                                        {{ value }}
                                    </option>
                                {% endfor %}
                            </select>
                        </div>
                        <div class=\"col-md-3\">
                            <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos los estados</option>
                                {% for key, value in estados %}
                                    <option value=\"{{ key }}\" {% if filtros.estado == key %}selected{% endif %}>
                                        {{ value }}
                                    </option>
                                {% endfor %}
                            </select>
                        </div>
                        <div class=\"col-md-2\">
                            <button type=\"submit\" class=\"btn btn-primary w-100\">
                                <i class=\"fas fa-chevron-down me-2\"></i>Aplicar Filtros
                            </button>
                        </div>
                    </form>
                    <div class=\"mt-3\">
                        <a href=\"{{ app_url }}tareas-programadas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times me-2\"></i>Limpiar Filtros
                        </a>
                    </div>
                </div>
            </div>

            <!-- Listado de Tareas -->
            <div class=\"card shadow\">
                <div class=\"card-header bg-white\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h6 class=\"text-primary fw-bold mb-0\">
                            <i class=\"fas fa-list me-2\"></i>Listado de Tareas Programadas
                        </h6>
                        <div class=\"d-flex align-items-center gap-3\">
                            <span class=\"text-muted\">Registros por página:</span>
                            <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                                {% for option in paginacion.allowed_per_page %}
                                    <option value=\"{{ option }}\" {% if paginacion.per_page == option %}selected{% endif %}>
                                        {{ option }}
                                    </option>
                                {% endfor %}
                            </select>
                            <span class=\"text-muted\">
                                Mostrando {{ paginacion.per_page }} de {{ paginacion.total_records }} registros
                            </span>
                        </div>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-striped table-hover tareas-table mb-0\">
                            <thead>
                                <tr>
                                    <th>
                                        <a href=\"{{ build_sort_url('id', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            ID
                                            <i class=\"fas {{ get_sort_icon('id', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            NOMBRE
                                            <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('tipo_reporte', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            TIPO DE<br>REPORTE
                                            <i class=\"fas {{ get_sort_icon('tipo_reporte', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('sede_nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            SEDE
                                            <i class=\"fas {{ get_sort_icon('sede_nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('carrera_nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            CARRERA
                                            <i class=\"fas {{ get_sort_icon('carrera_nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('fecha_programada', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            FECHA<br>PROGRAMADA
                                            <i class=\"fas {{ get_sort_icon('fecha_programada', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            ESTADO
                                            <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">
                                        <a href=\"{{ build_sort_url('fecha_creacion', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                            FECHA
                                            <i class=\"fas {{ get_sort_icon('fecha_creacion', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                        </a>
                                    </th>
                                    <th class=\"text-center\">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for tarea in tareas %}
                                <tr>
                                    <td>{{ tarea.id }}</td>
                                    <td title=\"{{ tarea.nombre }}\">{{ tarea.nombre }}</td>
                                    <td class=\"text-center\">
                                        {% if tarea.tipo_reporte == 'cobertura_basica_expandido' %}
                                            <span class=\"badge bg-info text-dark\">Cobertura Básica Expandido</span>
                                        {% elseif tarea.tipo_reporte == 'cobertura_complementaria_expandido' %}
                                            <span class=\"badge bg-warning text-dark\">Cobertura Complementaria Expandido</span>
                                        {% else %}
                                            <span class=\"badge bg-secondary\">Sin tipo</span>
                                        {% endif %}
                                    </td>
                                    <td class=\"text-center\" title=\"{{ tarea.sede_nombre }}\">{{ tarea.sede_nombre }}</td>
                                    <td class=\"text-center\" title=\"{{ tarea.carrera_nombre }}\">{{ tarea.carrera_nombre }}</td>
                                    <td class=\"text-center\">{{ tarea.fecha_programada|date('d/m/Y H:i') }}</td>
                                    <td class=\"text-center\">
                                        {% if tarea.estado == 'pendiente' %}
                                            <span class=\"badge bg-secondary\">Pendiente</span>
                                        {% elseif tarea.estado == 'en_proceso' %}
                                            <span class=\"badge bg-primary\">En Proceso</span>
                                        {% elseif tarea.estado == 'completada' %}
                                            <span class=\"badge bg-success\">Completada</span>
                                        {% elseif tarea.estado == 'error' %}
                                            <span class=\"badge bg-danger\">Error</span>
                                        {% elseif tarea.estado == 'cancelada' %}
                                            <span class=\"badge bg-dark\">Cancelada</span>
                                        {% else %}
                                            <span class=\"badge bg-secondary\">Desconocido</span>
                                        {% endif %}
                                    </td>
                                    <td class=\"text-center\">{{ tarea.fecha_creacion|date('d/m/Y H:i') }}</td>
                                    <td class=\"text-center\">
                                        <div class=\"d-flex gap-1 justify-content-center\">
                                            {% if tarea.estado == 'pendiente' %}
                                                <button type=\"button\" class=\"btn btn-action btn-cancel\" 
                                                        onclick=\"cancelarTarea({{ tarea.id }})\" title=\"Cancelar\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                                            {% endif %}
                                            {% if tarea.estado == 'error' %}
                                                <button type=\"button\" class=\"btn btn-action btn-view\" 
                                                        onclick=\"verError({{ tarea.id }}, '{{ tarea.error_mensaje|escape }}')\" title=\"Ver Error\">
                                                    <i class=\"fas fa-exclamation-triangle\"></i>
                                                </button>
                                            {% endif %}
                                        </div>
                                    </td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"9\" class=\"text-center\">No se encontraron tareas programadas</td>
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
                                <!-- Botón Anterior -->
                                {% if paginacion.has_previous %}
                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"{{ build_page_url(paginacion.previous_page, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">
                                            <i class=\"fas fa-chevron-left\"></i> Anterior
                                        </a>
                                    </li>
                                {% else %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                                    </li>
                                {% endif %}

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
                                    {% if page_num == paginacion.current_page %}
                                        <li class=\"page-item active\">
                                            <span class=\"page-link\">{{ page_num }}</span>
                                        </li>
                                    {% else %}
                                        <li class=\"page-item\">
                                            <a class=\"page-link\" href=\"{{ build_page_url(page_num, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">{{ page_num }}</a>
                                        </li>
                                    {% endif %}
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

                                <!-- Botón Siguiente -->
                                {% if paginacion.has_next %}
                                    <li class=\"page-item\">
                                        <a class=\"page-link\" href=\"{{ build_page_url(paginacion.next_page, ordenamiento.column, ordenamiento.direction, filtros, paginacion.per_page) }}\">
                                            Siguiente <i class=\"fas fa-chevron-right\"></i>
                                        </a>
                                    </li>
                                {% else %}
                                    <li class=\"page-item disabled\">
                                        <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                                    </li>
                                {% endif %}
                            </ul>
                        </nav>
                    </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Tarea -->
<div class=\"modal fade\" id=\"modalNuevaTarea\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalNuevaTareaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalNuevaTareaLabel\">
                    <i class=\"fas fa-plus\"></i> Nueva Tarea Programada
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"formNuevaTarea\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"nombre\" class=\"form-label\">Nombre de la Tarea *</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" required>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"tipo_reporte\" class=\"form-label\">Tipo de Reporte *</label>
                                <select class=\"form-select\" id=\"tipo_reporte\" name=\"tipo_reporte\" required>
                                    <option value=\"\">Seleccione un tipo</option>
                                    <option value=\"cobertura_basica_expandido\">Cobertura Básica Expandido</option>
                                    <option value=\"cobertura_complementaria_expandido\">Cobertura Complementaria Expandido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"sede_id\" class=\"form-label\">Sede *</label>
                                <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\" required>
                                    <option value=\"\">Seleccione una sede</option>
                                    {% for sede in sedes %}
                                        <option value=\"{{ sede.id }}\">{{ sede.sede }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"carrera_id\" class=\"form-label\">Carrera *</label>
                                <select class=\"form-select\" id=\"carrera_id\" name=\"carrera_id\" required>
                                    <option value=\"\">Seleccione una carrera</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <div class=\"mb-3\">
                                <label for=\"fecha_programada\" class=\"form-label\">Fecha y Hora Programada *</label>
                                <input type=\"datetime-local\" class=\"form-control\" id=\"fecha_programada\" name=\"fecha_programada\" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" onclick=\"crearTarea()\">
                    <i class=\"fas fa-save\"></i> Crear Tarea
                </button>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    // Evento para cambiar registros por página
    document.getElementById('per_page').addEventListener('change', function() {
        const perPage = this.value;
        const currentUrl = new URL(window.location);
        
        // Actualizar parámetro per_page
        currentUrl.searchParams.set('per_page', perPage);
        
        // Resetear a la primera página cuando se cambia el número de registros
        currentUrl.searchParams.set('page', '1');
        
        // Redirigir a la nueva URL
        window.location.href = currentUrl.toString();
    });

    // Filtrar carreras según la sede seleccionada
    document.getElementById('sede_id').addEventListener('change', function() {
        const sedeId = this.value;
        const carreraSelect = document.getElementById('carrera_id');
        
        // Limpiar opciones actuales
        carreraSelect.innerHTML = '<option value=\"\">Seleccione una carrera</option>';
        
        if (sedeId) {
            // Filtrar carreras por sede
            const carreras = {{ carreras|json_encode|raw }};
            const carrerasFiltradas = carreras.filter(carrera => carrera.id_sede == sedeId);
            
            carrerasFiltradas.forEach(carrera => {
                const option = document.createElement('option');
                option.value = carrera.id;
                option.textContent = carrera.carrera;
                carreraSelect.appendChild(option);
            });
        }
    });

    // Función para crear nueva tarea
    function crearTarea() {
        const form = document.getElementById('formNuevaTarea');
        const formData = new FormData(form);
        
        // Convertir FormData a objeto
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        
        // Validar que todos los campos requeridos estén completos
        if (!data.nombre || !data.tipo_reporte || !data.sede_id || !data.carrera_id || !data.fecha_programada) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor complete todos los campos requeridos'
            });
            return;
        }
        
        // Enviar petición AJAX
        fetch('{{ app_url }}tareas-programadas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Error al crear la tarea'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de conexión al crear la tarea'
            });
        });
    }

    // Función para cancelar tarea
    function cancelarTarea(tareaId) {
        Swal.fire({
            title: '¿Está seguro?',
            text: \"Esta acción cancelará la tarea programada\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ app_url }}tareas-programadas/' + tareaId + '/cancelar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: result.message
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message || 'Error al cancelar la tarea'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión al cancelar la tarea'
                    });
                });
            }
        });
    }

    // Función para ver error
    function verError(tareaId, errorMensaje) {
        Swal.fire({
            title: 'Error en Tarea #' + tareaId,
            text: errorMensaje || 'No hay información de error disponible',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });
    }
</script>
{% endblock %} ", "tareas_programadas/index.twig", "/var/www/html/biblioges/templates/tareas_programadas/index.twig");
    }
}
