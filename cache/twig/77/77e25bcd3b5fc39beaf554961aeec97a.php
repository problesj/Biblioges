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

/* reportes/coberturas/index.twig */
class __TwigTemplate_5fa5fe05ac3a42744178ebc0320b3e53 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "reportes/coberturas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Reporte de Coberturas - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de coberturas */
    .coberturas-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: fixed !important;
    }
    
    .coberturas-table thead th {
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
    
    .coberturas-table thead th:first-child {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .coberturas-table thead th:nth-child(2) {
        width: 10% !important;
        min-width: 70px !important;
    }
    
    .coberturas-table thead th:nth-child(3) {
        width: 20% !important;
        min-width: 120px !important;
    }
    
    .coberturas-table thead th:nth-child(4) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .coberturas-table thead th:nth-child(5) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .coberturas-table thead th:nth-child(6) {
        width: 12% !important;
        min-width: 90px !important;
    }
    
    .coberturas-table thead th:nth-child(7) {
        width: 12% !important;
        min-width: 90px !important;
    }
    
    .coberturas-table thead th:last-child {
        width: 16% !important;
        min-width: 120px !important;
    }
    
    .coberturas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .coberturas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .coberturas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .coberturas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .coberturas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .coberturas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .coberturas-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    
    .coberturas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .coberturas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .coberturas-table tbody td:nth-child(3) {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        max-width: 0 !important;
    }
    
    .coberturas-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.75rem !important;
        text-align: center !important;
    }
    
    .coberturas-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .coberturas-table tbody td:nth-child(6),
    .coberturas-table tbody td:nth-child(7) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .coberturas-table tbody td:last-child {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    /* Estilos para el contador de registros */
    .records-counter {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 400;
        background-color: transparent;
        padding: 0;
        border: none;
        box-shadow: none;
        display: inline-block;
    }
    
    /* Estilos para el selector de registros por página */
    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: transparent;
        padding: 0;
        border: none;
        box-shadow: none;
    }
    
    .per-page-selector label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0;
        white-space: nowrap;
        font-weight: 400;
    }
    
    .per-page-selector select {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        border: 2px solid #4e73df;
        border-radius: 0.25rem;
        background-color: white;
        color: #495057;
        font-weight: 400;
        min-width: 60px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: none;
    }
    
    .per-page-selector select:hover {
        border-color: #224abe;
        box-shadow: 0 1px 3px rgba(78, 115, 223, 0.2);
    }
    
    .per-page-selector select:focus {
        outline: none;
        border-color: #224abe;
        box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.2);
    }
    
    .per-page-selector select option {
        font-size: 0.875rem;
        padding: 0.25rem;
        background-color: white;
        color: #495057;
    }
    
    /* Estilos para la paginación */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        color: #4e73df;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .page-link:hover {
        color: #224abe;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: white;
        border-color: #dee2e6;
    }
    
    /* Estilos para badges de cobertura */
    .badge-cobertura {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .badge-cobertura.basica {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-cobertura.complementaria {
        background-color: #ffc107;
        color: #212529;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        margin: 0.15rem;
        white-space: nowrap;
    }
    
    /* Estilos para badges de estado y tipo */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Estilos para el header de la tabla */
    .coberturas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .coberturas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .coberturas-table {
            font-size: 0.75rem !important;
        }
        
        .coberturas-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .coberturas-table tbody td {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .btn-action {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.4rem !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.4rem !important;
        }
        
        .per-page-selector {
            gap: 0.4rem !important;
        }
        
        .per-page-selector label {
            font-size: 0.8rem !important;
        }
        
        .per-page-selector select {
            font-size: 0.8rem !important;
            padding: 0.2rem 0.4rem !important;
            min-width: 60px !important;
        }
        
        .records-counter {
            font-size: 0.8rem !important;
        }
    }
    
    @media (max-width: 768px) {
        .coberturas-table {
            font-size: 0.7rem !important;
        }
        
        .coberturas-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .coberturas-table tbody td {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .btn-action {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }
        
        .badge {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }
        
        .per-page-selector {
            gap: 0.3rem !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        
        .per-page-selector label {
            font-size: 0.75rem !important;
        }
        
        .per-page-selector select {
            font-size: 0.75rem !important;
            padding: 0.2rem 0.4rem !important;
            min-width: 50px !important;
        }
        
        .records-counter {
            font-size: 0.75rem !important;
        }
    }
</style>
";
        yield from [];
    }

    // line 392
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 393
        yield "<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Reporte de Coberturas</h1>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 404
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/coberturas\" class=\"mb-4\">
                <div class=\"row\">
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"sede\" name=\"sede\" value=\"";
        // line 409
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 409), "html", null, true);
        yield "\" placeholder=\"Buscar por sede...\">
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\">Tipo de Programa</label>
                            <select class=\"form-control\" id=\"tipo_programa\" name=\"tipo_programa\">
                                <option value=\"\">Todos</option>
                                <option value=\"P\" ";
        // line 417
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 417) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                                <option value=\"G\" ";
        // line 418
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 418) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                                <option value=\"O\" ";
        // line 419
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 419) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                    </select>
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" ";
        // line 428
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 428) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 429
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 429) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                    </select>
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 436
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", false, false, false, 436), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre...\">
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 445
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/coberturas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                        <button type=\"button\" id=\"exportarExcel\" class=\"btn btn-success\">
                            <i class=\"fas fa-file-excel\"></i> Exportar a Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de datos -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Coberturas</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 466
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 466));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 467
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 467) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 468
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 471
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 474
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 474), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 474), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover coberturas-table\">
                        <thead>
                            <tr>
                            <th>
                                <a href=\"";
        // line 484
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 484), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 484), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 484), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 484)), "html", null, true);
        yield "\">
                                    Sede
                                    <i class=\"fas ";
        // line 486
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 486), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 486)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 490
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("codigo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 490), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 490), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 490), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 490)), "html", null, true);
        yield "\">
                                    Código<br>Carrera
                                    <i class=\"fas ";
        // line 492
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("codigo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 492), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 492)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 496
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 496), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 496), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 496), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 496)), "html", null, true);
        yield "\">
                                    Nombre Carrera
                                    <i class=\"fas ";
        // line 498
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 498), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 498)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 502
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 502), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 502), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 502), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 502)), "html", null, true);
        yield "\">
                                    Tipo Programa
                                    <i class=\"fas ";
        // line 504
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 504), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 504)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 508
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 508), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 508), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 508), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 508)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 510
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 510), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 510)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 514
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("cobertura_basica", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 514), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 514), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 514), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 514)), "html", null, true);
        yield "\">
                                    Cobertura<br>Básica<br>(";
        // line 515
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["anio_actual"] ?? null), "html", null, true);
        yield ")
                                    <i class=\"fas ";
        // line 516
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("cobertura_basica", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 516), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 516)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 520
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("cobertura_complementaria", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 520), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 520), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 520), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 520)), "html", null, true);
        yield "\">
                                    Cobertura<br>Complementaria<br>(";
        // line 521
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["anio_actual"] ?? null), "html", null, true);
        yield ")
                                    <i class=\"fas ";
        // line 522
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("cobertura_complementaria", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 522), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 522)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        ";
        // line 529
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 530
            yield "                        <tr>
                                <td>";
            // line 531
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede", [], "any", false, false, false, 531), "html", null, true);
            yield "</td>
                            <td>";
            // line 532
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "codigo", [], "any", false, false, false, 532), "html", null, true);
            yield "</td>
                                <td>";
            // line 533
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 533), "html", null, true);
            yield "</td>
                                <td class=\"text-center\">
                                    ";
            // line 535
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 535) == "P")) {
                // line 536
                yield "                                        <span class=\"badge bg-primary\">Pregrado</span>
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 537
$context["carrera"], "tipo_programa", [], "any", false, false, false, 537) == "G")) {
                // line 538
                yield "                                        <span class=\"badge bg-success\">Postgrado</span>
                                    ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 539
$context["carrera"], "tipo_programa", [], "any", false, false, false, 539) == "O")) {
                // line 540
                yield "                                        <span class=\"badge bg-warning\">Otro</span>
                                    ";
            } else {
                // line 542
                yield "                                        <span class=\"badge bg-secondary\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 542), "html", null, true);
                yield "</span>
                                    ";
            }
            // line 544
            yield "                                </td>
                                <td class=\"text-center\">
                                    ";
            // line 546
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "estado", [], "any", false, false, false, 546) == 1)) {
                // line 547
                yield "                                        <span class=\"badge bg-success\">Activo</span>
                                    ";
            } else {
                // line 549
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                    ";
            }
            // line 551
            yield "                                </td>
                                <td class=\"text-center\">
                                ";
            // line 553
            if (( !(null === CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_basica", [], "any", false, false, false, 553)) && (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_basica", [], "any", false, false, false, 553) != "Sin información"))) {
                // line 554
                yield "                                    <span class=\"badge badge-cobertura basica\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_basica", [], "any", false, false, false, 554), 2), "html", null, true);
                yield "%</span>
                                    ";
            } else {
                // line 556
                yield "                                        <span class=\"text-muted\">Sin información</span>
                                    ";
            }
            // line 558
            yield "                                </td>
                                <td class=\"text-center\">
                                ";
            // line 560
            if (( !(null === CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_complementaria", [], "any", false, false, false, 560)) && (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_complementaria", [], "any", false, false, false, 560) != "Sin información"))) {
                // line 561
                yield "                                    <span class=\"badge badge-cobertura complementaria\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_complementaria", [], "any", false, false, false, 561), 2), "html", null, true);
                yield "%</span>
                                    ";
            } else {
                // line 563
                yield "                                        <span class=\"text-muted\">Sin información</span>
                                    ";
            }
            // line 565
            yield "                                </td>
                                <td class=\"text-center\">
                                <div class=\"d-flex gap-1 flex-wrap justify-content-center\">
                                    <a href=\"";
            // line 568
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/coberturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 568), "html", null, true);
            yield "/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "carrera_id", [], "any", false, false, false, 568), "html", null, true);
            yield "\" class=\"btn btn-primary btn-action\">
                                        <i class=\"fas fa-chart-bar\"></i> Básicas
                                    </a>
                                    <a href=\"";
            // line 571
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/coberturas-complementaria/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 571), "html", null, true);
            yield "/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "carrera_id", [], "any", false, false, false, 571), "html", null, true);
            yield "\" class=\"btn btn-secondary btn-action\">
                                        <i class=\"fas fa-chart-line\"></i> Complementarias
                                    </a>
                                    <a href=\"";
            // line 574
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/coberturas-fusionado/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 574), "html", null, true);
            yield "/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "carrera_id", [], "any", false, false, false, 574), "html", null, true);
            yield "\" class=\"btn btn-info btn-action\">
                                        <i class=\"fas fa-object-group\"></i> Fusión
                                    </a>
                                </div>
                                </td>
                            </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 580
        if (!$context['_iterated']) {
            // line 581
            yield "                        <tr>
                            <td colspan=\"8\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 585
        yield "                        </tbody>
                    </table>
                </div>

            <!-- Paginación -->
            ";
        // line 590
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 590) > 1)) {
            // line 591
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 594
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 594)) {
                // line 595
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 596
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 596), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 596), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 596), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 596)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 601
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 605
            yield "
                    <!-- Números de página -->
                    ";
            // line 607
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 607) - 2));
            // line 608
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 608), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 608) + 2));
            // line 609
            yield "
                    ";
            // line 610
            if ((($context["start_page"] ?? null) > 1)) {
                // line 611
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 612
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 612), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 612), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 612)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 614
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 615
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 619
                yield "                    ";
            }
            // line 620
            yield "
                    ";
            // line 621
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 622
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 622))) {
                    // line 623
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 624
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 627
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 628
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 628), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 628), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 628)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 631
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 632
            yield "
                    ";
            // line 633
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 633))) {
                // line 634
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 634) - 1))) {
                    // line 635
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 639
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 640
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 640), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 640), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 640), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 640)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 640), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 643
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 645
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 645)) {
                // line 646
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 647
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 647), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 647), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 647), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 647)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 652
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 656
            yield "                </ul>
            </nav>
            ";
        }
        // line 659
        yield "        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 664
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 665
        yield "<script>
    // Función para exportar a Excel
    document.getElementById('exportarExcel').addEventListener('click', function() {
        // Obtener los filtros actuales
        const currentUrl = new URL(window.location);
        const sede = currentUrl.searchParams.get('sede') || '';
        const tipoPrograma = currentUrl.searchParams.get('tipo_programa') || '';
        const estado = currentUrl.searchParams.get('estado') || '';
        const nombre = currentUrl.searchParams.get('nombre') || '';
        
        // Construir la URL de exportación con los filtros
        let exportUrl = '";
        // line 676
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/coberturas-excel?';
        
        if (sede) exportUrl += 'sede=' + encodeURIComponent(sede) + '&';
        if (tipoPrograma) exportUrl += 'tipo_programa=' + encodeURIComponent(tipoPrograma) + '&';
        if (estado) exportUrl += 'estado=' + encodeURIComponent(estado) + '&';
        if (nombre) exportUrl += 'nombre=' + encodeURIComponent(nombre) + '&';
        
        // Remover el último '&' si existe
        exportUrl = exportUrl.replace(/&\$/, '');
        
        // Descargar el archivo
        window.location.href = exportUrl;
    });

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
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "reportes/coberturas/index.twig";
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
        return array (  1038 => 676,  1025 => 665,  1018 => 664,  1010 => 659,  1005 => 656,  999 => 652,  991 => 647,  988 => 646,  986 => 645,  982 => 643,  974 => 640,  971 => 639,  965 => 635,  962 => 634,  960 => 633,  957 => 632,  951 => 631,  943 => 628,  940 => 627,  934 => 624,  931 => 623,  928 => 622,  924 => 621,  921 => 620,  918 => 619,  912 => 615,  910 => 614,  905 => 612,  902 => 611,  900 => 610,  897 => 609,  894 => 608,  892 => 607,  888 => 605,  882 => 601,  874 => 596,  871 => 595,  869 => 594,  864 => 591,  862 => 590,  855 => 585,  846 => 581,  844 => 580,  829 => 574,  819 => 571,  809 => 568,  804 => 565,  800 => 563,  794 => 561,  792 => 560,  788 => 558,  784 => 556,  778 => 554,  776 => 553,  772 => 551,  768 => 549,  764 => 547,  762 => 546,  758 => 544,  752 => 542,  748 => 540,  746 => 539,  743 => 538,  741 => 537,  738 => 536,  736 => 535,  731 => 533,  727 => 532,  723 => 531,  720 => 530,  715 => 529,  705 => 522,  701 => 521,  697 => 520,  690 => 516,  686 => 515,  682 => 514,  675 => 510,  670 => 508,  663 => 504,  658 => 502,  651 => 498,  646 => 496,  639 => 492,  634 => 490,  627 => 486,  622 => 484,  607 => 474,  602 => 471,  593 => 468,  584 => 467,  580 => 466,  556 => 445,  544 => 436,  532 => 429,  526 => 428,  512 => 419,  506 => 418,  500 => 417,  489 => 409,  481 => 404,  468 => 393,  461 => 392,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Reporte de Coberturas - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de coberturas */
    .coberturas-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: fixed !important;
    }
    
    .coberturas-table thead th {
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
    
    .coberturas-table thead th:first-child {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .coberturas-table thead th:nth-child(2) {
        width: 10% !important;
        min-width: 70px !important;
    }
    
    .coberturas-table thead th:nth-child(3) {
        width: 20% !important;
        min-width: 120px !important;
    }
    
    .coberturas-table thead th:nth-child(4) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .coberturas-table thead th:nth-child(5) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .coberturas-table thead th:nth-child(6) {
        width: 12% !important;
        min-width: 90px !important;
    }
    
    .coberturas-table thead th:nth-child(7) {
        width: 12% !important;
        min-width: 90px !important;
    }
    
    .coberturas-table thead th:last-child {
        width: 16% !important;
        min-width: 120px !important;
    }
    
    .coberturas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .coberturas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .coberturas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .coberturas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .coberturas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .coberturas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .coberturas-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    
    .coberturas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .coberturas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .coberturas-table tbody td:nth-child(3) {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        max-width: 0 !important;
    }
    
    .coberturas-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.75rem !important;
        text-align: center !important;
    }
    
    .coberturas-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .coberturas-table tbody td:nth-child(6),
    .coberturas-table tbody td:nth-child(7) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .coberturas-table tbody td:last-child {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    /* Estilos para el contador de registros */
    .records-counter {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 400;
        background-color: transparent;
        padding: 0;
        border: none;
        box-shadow: none;
        display: inline-block;
    }
    
    /* Estilos para el selector de registros por página */
    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: transparent;
        padding: 0;
        border: none;
        box-shadow: none;
    }
    
    .per-page-selector label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0;
        white-space: nowrap;
        font-weight: 400;
    }
    
    .per-page-selector select {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        border: 2px solid #4e73df;
        border-radius: 0.25rem;
        background-color: white;
        color: #495057;
        font-weight: 400;
        min-width: 60px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: none;
    }
    
    .per-page-selector select:hover {
        border-color: #224abe;
        box-shadow: 0 1px 3px rgba(78, 115, 223, 0.2);
    }
    
    .per-page-selector select:focus {
        outline: none;
        border-color: #224abe;
        box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.2);
    }
    
    .per-page-selector select option {
        font-size: 0.875rem;
        padding: 0.25rem;
        background-color: white;
        color: #495057;
    }
    
    /* Estilos para la paginación */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        color: #4e73df;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .page-link:hover {
        color: #224abe;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: white;
        border-color: #dee2e6;
    }
    
    /* Estilos para badges de cobertura */
    .badge-cobertura {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .badge-cobertura.basica {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-cobertura.complementaria {
        background-color: #ffc107;
        color: #212529;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        margin: 0.15rem;
        white-space: nowrap;
    }
    
    /* Estilos para badges de estado y tipo */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Estilos para el header de la tabla */
    .coberturas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .coberturas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .coberturas-table {
            font-size: 0.75rem !important;
        }
        
        .coberturas-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .coberturas-table tbody td {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .btn-action {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.4rem !important;
        }
        
        .badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.4rem !important;
        }
        
        .per-page-selector {
            gap: 0.4rem !important;
        }
        
        .per-page-selector label {
            font-size: 0.8rem !important;
        }
        
        .per-page-selector select {
            font-size: 0.8rem !important;
            padding: 0.2rem 0.4rem !important;
            min-width: 60px !important;
        }
        
        .records-counter {
            font-size: 0.8rem !important;
        }
    }
    
    @media (max-width: 768px) {
        .coberturas-table {
            font-size: 0.7rem !important;
        }
        
        .coberturas-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .coberturas-table tbody td {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .btn-action {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }
        
        .badge {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.3rem !important;
        }
        
        .per-page-selector {
            gap: 0.3rem !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        
        .per-page-selector label {
            font-size: 0.75rem !important;
        }
        
        .per-page-selector select {
            font-size: 0.75rem !important;
            padding: 0.2rem 0.4rem !important;
            min-width: 50px !important;
        }
        
        .records-counter {
            font-size: 0.75rem !important;
        }
    }
</style>
{% endblock %}

{% block content %}
<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Reporte de Coberturas</h1>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}reportes/coberturas\" class=\"mb-4\">
                <div class=\"row\">
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <input type=\"text\" class=\"form-control\" id=\"sede\" name=\"sede\" value=\"{{ filtros.sede }}\" placeholder=\"Buscar por sede...\">
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\">Tipo de Programa</label>
                            <select class=\"form-control\" id=\"tipo_programa\" name=\"tipo_programa\">
                                <option value=\"\">Todos</option>
                                <option value=\"P\" {% if filtros.tipo_programa == 'P' %}selected{% endif %}>Pregrado</option>
                                <option value=\"G\" {% if filtros.tipo_programa == 'G' %}selected{% endif %}>Postgrado</option>
                                <option value=\"O\" {% if filtros.tipo_programa == 'O' %}selected{% endif %}>Otro</option>
                    </select>
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                                <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                        </div>
                </div>
                <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ filtros.nombre }}\" placeholder=\"Buscar por nombre...\">
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}reportes/coberturas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                        <button type=\"button\" id=\"exportarExcel\" class=\"btn btn-success\">
                            <i class=\"fas fa-file-excel\"></i> Exportar a Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de datos -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Coberturas</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
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
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover coberturas-table\">
                        <thead>
                            <tr>
                            <th>
                                <a href=\"{{ build_sort_url('sede', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Sede
                                    <i class=\"fas {{ get_sort_icon('sede', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('codigo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Código<br>Carrera
                                    <i class=\"fas {{ get_sort_icon('codigo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre Carrera
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('tipo_programa', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipo Programa
                                    <i class=\"fas {{ get_sort_icon('tipo_programa', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('cobertura_basica', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Cobertura<br>Básica<br>({{ anio_actual }})
                                    <i class=\"fas {{ get_sort_icon('cobertura_basica', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('cobertura_complementaria', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Cobertura<br>Complementaria<br>({{ anio_actual }})
                                    <i class=\"fas {{ get_sort_icon('cobertura_complementaria', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        {% for carrera in carreras %}
                        <tr>
                                <td>{{ carrera.sede }}</td>
                            <td>{{ carrera.codigo }}</td>
                                <td>{{ carrera.nombre }}</td>
                                <td class=\"text-center\">
                                    {% if carrera.tipo_programa == 'P' %}
                                        <span class=\"badge bg-primary\">Pregrado</span>
                                    {% elseif carrera.tipo_programa == 'G' %}
                                        <span class=\"badge bg-success\">Postgrado</span>
                                    {% elseif carrera.tipo_programa == 'O' %}
                                        <span class=\"badge bg-warning\">Otro</span>
                                    {% else %}
                                        <span class=\"badge bg-secondary\">{{ carrera.tipo_programa }}</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                    {% if carrera.estado == 1 %}
                                        <span class=\"badge bg-success\">Activo</span>
                                    {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                {% if carrera.cobertura_basica is not null and carrera.cobertura_basica != 'Sin información' %}
                                    <span class=\"badge badge-cobertura basica\">{{ carrera.cobertura_basica|number_format(2) }}%</span>
                                    {% else %}
                                        <span class=\"text-muted\">Sin información</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                {% if carrera.cobertura_complementaria is not null and carrera.cobertura_complementaria != 'Sin información' %}
                                    <span class=\"badge badge-cobertura complementaria\">{{ carrera.cobertura_complementaria|number_format(2) }}%</span>
                                    {% else %}
                                        <span class=\"text-muted\">Sin información</span>
                                    {% endif %}
                                </td>
                                <td class=\"text-center\">
                                <div class=\"d-flex gap-1 flex-wrap justify-content-center\">
                                    <a href=\"{{ app_url }}reportes/coberturas/{{ carrera.sede_id }}/{{ carrera.carrera_id }}\" class=\"btn btn-primary btn-action\">
                                        <i class=\"fas fa-chart-bar\"></i> Básicas
                                    </a>
                                    <a href=\"{{ app_url }}reportes/coberturas-complementaria/{{ carrera.sede_id }}/{{ carrera.carrera_id }}\" class=\"btn btn-secondary btn-action\">
                                        <i class=\"fas fa-chart-line\"></i> Complementarias
                                    </a>
                                    <a href=\"{{ app_url }}reportes/coberturas-fusionado/{{ carrera.sede_id }}/{{ carrera.carrera_id }}\" class=\"btn btn-info btn-action\">
                                        <i class=\"fas fa-object-group\"></i> Fusión
                                    </a>
                                </div>
                                </td>
                            </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"8\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </div>

            <!-- Paginación -->
            {% if paginacion.total_pages > 1 %}
            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
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
            {% endif %}
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    // Función para exportar a Excel
    document.getElementById('exportarExcel').addEventListener('click', function() {
        // Obtener los filtros actuales
        const currentUrl = new URL(window.location);
        const sede = currentUrl.searchParams.get('sede') || '';
        const tipoPrograma = currentUrl.searchParams.get('tipo_programa') || '';
        const estado = currentUrl.searchParams.get('estado') || '';
        const nombre = currentUrl.searchParams.get('nombre') || '';
        
        // Construir la URL de exportación con los filtros
        let exportUrl = '{{ app_url }}reportes/coberturas-excel?';
        
        if (sede) exportUrl += 'sede=' + encodeURIComponent(sede) + '&';
        if (tipoPrograma) exportUrl += 'tipo_programa=' + encodeURIComponent(tipoPrograma) + '&';
        if (estado) exportUrl += 'estado=' + encodeURIComponent(estado) + '&';
        if (nombre) exportUrl += 'nombre=' + encodeURIComponent(nombre) + '&';
        
        // Remover el último '&' si existe
        exportUrl = exportUrl.replace(/&\$/, '');
        
        // Descargar el archivo
        window.location.href = exportUrl;
    });

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
</script>
{% endblock %} ", "reportes/coberturas/index.twig", "/var/www/html/biblioges/templates/reportes/coberturas/index.twig");
    }
}
