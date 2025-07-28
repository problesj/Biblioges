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

/* reportes/bibliografias_declaradas/index.twig */
class __TwigTemplate_0691b1c89059cc836f0d28105550cfe2 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "reportes/bibliografias_declaradas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Reporte de Bibliografías Declaradas - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de bibliografías */
    .bibliografias-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: fixed !important;
    }
    
    .bibliografias-table thead th {
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
    
    .bibliografias-table thead th:first-child {
        width: 20% !important;
        min-width: 150px !important;
    }
    
    .bibliografias-table thead th:nth-child(2) {
        width: 15% !important;
        min-width: 120px !important;
    }
    
    .bibliografias-table thead th:nth-child(3) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 100px !important;
    }
    
    .bibliografias-table thead th:nth-child(5) {
        width: 8% !important;
        min-width: 70px !important;
    }
    
    .bibliografias-table thead th:nth-child(6) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(7) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(8) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:last-child {
        width: 13% !important;
        min-width: 100px !important;
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
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    
    .bibliografias-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(3) {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        text-align: center !important;
    }
    
    .bibliografias-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.75rem !important;
        text-align: center !important;
    }
    
    .bibliografias-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(7),
    .bibliografias-table tbody td:nth-child(8) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:last-child {
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
    
    /* Estilos para badges */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        margin: 0.15rem;
        white-space: nowrap;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .bibliografias-table {
            font-size: 0.75rem !important;
        }
        
        .bibliografias-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .bibliografias-table tbody td {
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
        .bibliografias-table {
            font-size: 0.7rem !important;
        }
        
        .bibliografias-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .bibliografias-table tbody td {
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

    // line 373
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 374
        yield "<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Reporte de Bibliografías Declaradas</h1>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 385
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/listado-bibliografias\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"titulo\">Título</label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" value=\"";
        // line 390
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "titulo", [], "any", false, false, false, 390), "html", null, true);
        yield "\" placeholder=\"Buscar por título...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"autor\">Autor</label>
                            <input type=\"text\" class=\"form-control\" id=\"autor\" name=\"autor\" value=\"";
        // line 396
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "autor", [], "any", false, false, false, 396), "html", null, true);
        yield "\" placeholder=\"Buscar por autor...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"editorial\">Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"editorial\" name=\"editorial\" value=\"";
        // line 402
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "editorial", [], "any", false, false, false, 402), "html", null, true);
        yield "\" placeholder=\"Buscar por editorial...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo\">Tipo</label>
                            <select class=\"form-control\" id=\"tipo\" name=\"tipo\">
                                <option value=\"\">Todos</option>
                                <option value=\"libro\" ";
        // line 410
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 410) == "libro")) {
            yield "selected";
        }
        yield ">Libro</option>
                                <option value=\"articulo\" ";
        // line 411
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 411) == "articulo")) {
            yield "selected";
        }
        yield ">Artículo</option>
                                <option value=\"tesis\" ";
        // line 412
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 412) == "tesis")) {
            yield "selected";
        }
        yield ">Tesis</option>
                                <option value=\"software\" ";
        // line 413
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 413) == "software")) {
            yield "selected";
        }
        yield ">Software</option>
                                <option value=\"sitio_web\" ";
        // line 414
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 414) == "sitio_web")) {
            yield "selected";
        }
        yield ">Sitio Web</option>
                                <option value=\"generico\" ";
        // line 415
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 415) == "generico")) {
            yield "selected";
        }
        yield ">Genérico</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" ";
        // line 426
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 426) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 427
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 427) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_bibliografia\">Tipo de Bibliografía</label>
                            <select class=\"form-control\" id=\"tipo_bibliografia\" name=\"tipo_bibliografia\">
                                <option value=\"\">Todos</option>
                                <option value=\"basica\" ";
        // line 436
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 436) == "basica")) {
            yield "selected";
        }
        yield ">Básica</option>
                                <option value=\"complementaria\" ";
        // line 437
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 437) == "complementaria")) {
            yield "selected";
        }
        yield ">Complementaria</option>
                                <option value=\"otro\" ";
        // line 438
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 438) == "otro")) {
            yield "selected";
        }
        yield ">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"bibliografias_disponibles\">Bibliografías Disponibles</label>
                            <select class=\"form-control\" id=\"bibliografias_disponibles\" name=\"bibliografias_disponibles\">
                                <option value=\"\">Todos</option>
                                <option value=\"con_disponibles\" ";
        // line 447
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "bibliografias_disponibles", [], "any", false, false, false, 447) == "con_disponibles")) {
            yield "selected";
        }
        yield ">Disponibles</option>
                                <option value=\"sin_disponibles\" ";
        // line 448
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "bibliografias_disponibles", [], "any", false, false, false, 448) == "sin_disponibles")) {
            yield "selected";
        }
        yield ">No disponibles</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12\">
                        <div class=\"d-flex gap-2 justify-content-start\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-filter\"></i> Aplicar Filtros
                            </button>
                            <a href=\"";
        // line 459
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/listado-bibliografias\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                            <button type=\"button\" id=\"exportarExcel\" class=\"btn btn-success\">
                                <i class=\"fas fa-file-excel\"></i> Exportar a Excel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de datos -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Bibliografías Declaradas</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 481
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 481));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 482
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 482) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 483
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 486
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 489
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 489), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 489), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover bibliografias-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"";
        // line 499
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 499), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 499), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 499), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 499)), "html", null, true);
        yield "\">
                                    Título
                                    <i class=\"fas ";
        // line 501
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("titulo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 501), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 501)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 505
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 505), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 505), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 505), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 505)), "html", null, true);
        yield "\">
                                    Autor(es)
                                    <i class=\"fas ";
        // line 507
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("autores", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 507), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 507)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 511
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("anio_publicacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 511), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 511), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 511), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 511)), "html", null, true);
        yield "\">
                                    Año<br>Edición
                                    <i class=\"fas ";
        // line 513
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("anio_publicacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 513), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 513)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 517
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("editorial", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 517), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 517), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 517), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 517)), "html", null, true);
        yield "\">
                                    Editorial
                                    <i class=\"fas ";
        // line 519
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("editorial", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 519), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 519)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 523
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 523), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 523), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 523), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 523)), "html", null, true);
        yield "\">
                                    Tipo
                                    <i class=\"fas ";
        // line 525
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 525), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 525)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 529
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 529), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 529), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 529), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 529)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 531
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 531), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 531)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 535
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("num_asignaturas", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 535), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 535), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 535), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 535)), "html", null, true);
        yield "\">
                                    #<br>Asignaturas
                                    <i class=\"fas ";
        // line 537
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("num_asignaturas", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 537), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 537)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 541
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("num_bibliografias_disponibles", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 541), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 541), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 541), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 541)), "html", null, true);
        yield "\">
                                    #<br>Disponibles
                                    <i class=\"fas ";
        // line 543
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("num_bibliografias_disponibles", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 543), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 543)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 547
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipos_bibliografias", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 547), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 547), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 547), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 547)), "html", null, true);
        yield "\">
                                    Tipos de<br>Bibliografía
                                    <i class=\"fas ";
        // line 549
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipos_bibliografias", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 549), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 549)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 555
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
            // line 556
            yield "                        <tr>
                            <td>";
            // line 557
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 557), "html", null, true);
            yield "</td>
                            <td>";
            // line 558
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 558)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 558), "html", null, true)) : ("Sin autores"));
            yield "</td>
                            <td class=\"text-center\">";
            // line 559
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 559)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 559), "html", null, true)) : ("N/A"));
            yield "</td>
                            <td class=\"text-center\">";
            // line 560
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 560)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 560), "html", null, true)) : ("N/A"));
            yield "</td>
                            <td class=\"text-center\">
                                <span class=\"badge bg-info\">";
            // line 562
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 562)), "html", null, true);
            yield "</span>
                            </td>
                            <td class=\"text-center\">
                                ";
            // line 565
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 565) == 1)) {
                // line 566
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 568
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 570
            yield "                            </td>
                            <td class=\"text-center\">";
            // line 571
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "num_asignaturas", [], "any", false, false, false, 571), "html", null, true);
            yield "</td>
                            <td class=\"text-center\">";
            // line 572
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "num_bibliografias_disponibles", [], "any", false, false, false, 572), "html", null, true);
            yield "</td>
                            <td class=\"text-center\">
                                ";
            // line 574
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipos_bibliografias", [], "any", false, false, false, 574) && (CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipos_bibliografias", [], "any", false, false, false, 574) != "Sin asignar"))) {
                // line 575
                yield "                                    ";
                $context["tipos"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipos_bibliografias", [], "any", false, false, false, 575), ", ");
                // line 576
                yield "                                    ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["tipos"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["tipo"]) {
                    // line 577
                    yield "                                        <span class=\"badge bg-primary\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), $context["tipo"]), "html", null, true);
                    yield "</span>
                                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['tipo'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 579
                yield "                                ";
            } else {
                // line 580
                yield "                                    <span class=\"text-muted\">Sin asignar</span>
                                ";
            }
            // line 582
            yield "                            </td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 585
        yield "                    </tbody>
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
        const titulo = currentUrl.searchParams.get('titulo') || '';
        const autor = currentUrl.searchParams.get('autor') || '';
        const editorial = currentUrl.searchParams.get('editorial') || '';
        const tipo = currentUrl.searchParams.get('tipo') || '';
        const estado = currentUrl.searchParams.get('estado') || '';
        const tipoBibliografia = currentUrl.searchParams.get('tipo_bibliografia') || '';
        const bibliografiasDisponibles = currentUrl.searchParams.get('bibliografias_disponibles') || '';
        
        // Construir la URL de exportación con los filtros
        let exportUrl = '";
        // line 679
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/listado-bibliografias/exportar?';
        
        if (titulo) exportUrl += 'titulo=' + encodeURIComponent(titulo) + '&';
        if (autor) exportUrl += 'autor=' + encodeURIComponent(autor) + '&';
        if (editorial) exportUrl += 'editorial=' + encodeURIComponent(editorial) + '&';
        if (tipo) exportUrl += 'tipo=' + encodeURIComponent(tipo) + '&';
        if (estado) exportUrl += 'estado=' + encodeURIComponent(estado) + '&';
        if (tipoBibliografia) exportUrl += 'tipo_bibliografia=' + encodeURIComponent(tipoBibliografia) + '&';
        if (bibliografiasDisponibles) exportUrl += 'bibliografias_disponibles=' + encodeURIComponent(bibliografiasDisponibles) + '&';
        
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
        return "reportes/bibliografias_declaradas/index.twig";
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
        return array (  1062 => 679,  1046 => 665,  1039 => 664,  1031 => 659,  1026 => 656,  1020 => 652,  1012 => 647,  1009 => 646,  1007 => 645,  1003 => 643,  995 => 640,  992 => 639,  986 => 635,  983 => 634,  981 => 633,  978 => 632,  972 => 631,  964 => 628,  961 => 627,  955 => 624,  952 => 623,  949 => 622,  945 => 621,  942 => 620,  939 => 619,  933 => 615,  931 => 614,  926 => 612,  923 => 611,  921 => 610,  918 => 609,  915 => 608,  913 => 607,  909 => 605,  903 => 601,  895 => 596,  892 => 595,  890 => 594,  885 => 591,  883 => 590,  876 => 585,  868 => 582,  864 => 580,  861 => 579,  852 => 577,  847 => 576,  844 => 575,  842 => 574,  837 => 572,  833 => 571,  830 => 570,  826 => 568,  822 => 566,  820 => 565,  814 => 562,  809 => 560,  805 => 559,  801 => 558,  797 => 557,  794 => 556,  790 => 555,  781 => 549,  776 => 547,  769 => 543,  764 => 541,  757 => 537,  752 => 535,  745 => 531,  740 => 529,  733 => 525,  728 => 523,  721 => 519,  716 => 517,  709 => 513,  704 => 511,  697 => 507,  692 => 505,  685 => 501,  680 => 499,  665 => 489,  660 => 486,  651 => 483,  642 => 482,  638 => 481,  613 => 459,  597 => 448,  591 => 447,  577 => 438,  571 => 437,  565 => 436,  551 => 427,  545 => 426,  529 => 415,  523 => 414,  517 => 413,  511 => 412,  505 => 411,  499 => 410,  488 => 402,  479 => 396,  470 => 390,  462 => 385,  449 => 374,  442 => 373,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Reporte de Bibliografías Declaradas - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de bibliografías */
    .bibliografias-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: fixed !important;
    }
    
    .bibliografias-table thead th {
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
    
    .bibliografias-table thead th:first-child {
        width: 20% !important;
        min-width: 150px !important;
    }
    
    .bibliografias-table thead th:nth-child(2) {
        width: 15% !important;
        min-width: 120px !important;
    }
    
    .bibliografias-table thead th:nth-child(3) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 100px !important;
    }
    
    .bibliografias-table thead th:nth-child(5) {
        width: 8% !important;
        min-width: 70px !important;
    }
    
    .bibliografias-table thead th:nth-child(6) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(7) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:nth-child(8) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .bibliografias-table thead th:last-child {
        width: 13% !important;
        min-width: 100px !important;
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
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
    
    .bibliografias-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(3) {
        color: #6c757d !important;
        font-size: 0.8rem !important;
        text-align: center !important;
    }
    
    .bibliografias-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.75rem !important;
        text-align: center !important;
    }
    
    .bibliografias-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:nth-child(7),
    .bibliografias-table tbody td:nth-child(8) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .bibliografias-table tbody td:last-child {
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
    
    /* Estilos para badges */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Estilos para botones de acción */
    .btn-action {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        margin: 0.15rem;
        white-space: nowrap;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .bibliografias-table {
            font-size: 0.75rem !important;
        }
        
        .bibliografias-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .bibliografias-table tbody td {
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
        .bibliografias-table {
            font-size: 0.7rem !important;
        }
        
        .bibliografias-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .bibliografias-table tbody td {
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
        <h1 class=\"h3 mb-0 text-gray-800\">Reporte de Bibliografías Declaradas</h1>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}reportes/listado-bibliografias\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"titulo\">Título</label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" value=\"{{ filtros.titulo }}\" placeholder=\"Buscar por título...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"autor\">Autor</label>
                            <input type=\"text\" class=\"form-control\" id=\"autor\" name=\"autor\" value=\"{{ filtros.autor }}\" placeholder=\"Buscar por autor...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"editorial\">Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"editorial\" name=\"editorial\" value=\"{{ filtros.editorial }}\" placeholder=\"Buscar por editorial...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo\">Tipo</label>
                            <select class=\"form-control\" id=\"tipo\" name=\"tipo\">
                                <option value=\"\">Todos</option>
                                <option value=\"libro\" {% if filtros.tipo == 'libro' %}selected{% endif %}>Libro</option>
                                <option value=\"articulo\" {% if filtros.tipo == 'articulo' %}selected{% endif %}>Artículo</option>
                                <option value=\"tesis\" {% if filtros.tipo == 'tesis' %}selected{% endif %}>Tesis</option>
                                <option value=\"software\" {% if filtros.tipo == 'software' %}selected{% endif %}>Software</option>
                                <option value=\"sitio_web\" {% if filtros.tipo == 'sitio_web' %}selected{% endif %}>Sitio Web</option>
                                <option value=\"generico\" {% if filtros.tipo == 'generico' %}selected{% endif %}>Genérico</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
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
                            <label for=\"tipo_bibliografia\">Tipo de Bibliografía</label>
                            <select class=\"form-control\" id=\"tipo_bibliografia\" name=\"tipo_bibliografia\">
                                <option value=\"\">Todos</option>
                                <option value=\"basica\" {% if filtros.tipo_bibliografia == 'basica' %}selected{% endif %}>Básica</option>
                                <option value=\"complementaria\" {% if filtros.tipo_bibliografia == 'complementaria' %}selected{% endif %}>Complementaria</option>
                                <option value=\"otro\" {% if filtros.tipo_bibliografia == 'otro' %}selected{% endif %}>Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"bibliografias_disponibles\">Bibliografías Disponibles</label>
                            <select class=\"form-control\" id=\"bibliografias_disponibles\" name=\"bibliografias_disponibles\">
                                <option value=\"\">Todos</option>
                                <option value=\"con_disponibles\" {% if filtros.bibliografias_disponibles == 'con_disponibles' %}selected{% endif %}>Disponibles</option>
                                <option value=\"sin_disponibles\" {% if filtros.bibliografias_disponibles == 'sin_disponibles' %}selected{% endif %}>No disponibles</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12\">
                        <div class=\"d-flex gap-2 justify-content-start\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-filter\"></i> Aplicar Filtros
                            </button>
                            <a href=\"{{ app_url }}reportes/listado-bibliografias\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                            <button type=\"button\" id=\"exportarExcel\" class=\"btn btn-success\">
                                <i class=\"fas fa-file-excel\"></i> Exportar a Excel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de datos -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Bibliografías Declaradas</h6>
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
                <table class=\"table table-striped table-hover bibliografias-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"{{ build_sort_url('titulo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Título
                                    <i class=\"fas {{ get_sort_icon('titulo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('autores', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Autor(es)
                                    <i class=\"fas {{ get_sort_icon('autores', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('anio_publicacion', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Año<br>Edición
                                    <i class=\"fas {{ get_sort_icon('anio_publicacion', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('editorial', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Editorial
                                    <i class=\"fas {{ get_sort_icon('editorial', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('tipo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipo
                                    <i class=\"fas {{ get_sort_icon('tipo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('num_asignaturas', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    #<br>Asignaturas
                                    <i class=\"fas {{ get_sort_icon('num_asignaturas', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('num_bibliografias_disponibles', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    #<br>Disponibles
                                    <i class=\"fas {{ get_sort_icon('num_bibliografias_disponibles', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('tipos_bibliografias', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipos de<br>Bibliografía
                                    <i class=\"fas {{ get_sort_icon('tipos_bibliografias', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for bibliografia in bibliografias %}
                        <tr>
                            <td>{{ bibliografia.titulo }}</td>
                            <td>{{ bibliografia.autores ?: 'Sin autores' }}</td>
                            <td class=\"text-center\">{{ bibliografia.anio_publicacion ?: 'N/A' }}</td>
                            <td class=\"text-center\">{{ bibliografia.editorial ?: 'N/A' }}</td>
                            <td class=\"text-center\">
                                <span class=\"badge bg-info\">{{ bibliografia.tipo|title }}</span>
                            </td>
                            <td class=\"text-center\">
                                {% if bibliografia.estado == 1 %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td class=\"text-center\">{{ bibliografia.num_asignaturas }}</td>
                            <td class=\"text-center\">{{ bibliografia.num_bibliografias_disponibles }}</td>
                            <td class=\"text-center\">
                                {% if bibliografia.tipos_bibliografias and bibliografia.tipos_bibliografias != 'Sin asignar' %}
                                    {% set tipos = bibliografia.tipos_bibliografias|split(', ') %}
                                    {% for tipo in tipos %}
                                        <span class=\"badge bg-primary\">{{ tipo|title }}</span>
                                    {% endfor %}
                                {% else %}
                                    <span class=\"text-muted\">Sin asignar</span>
                                {% endif %}
                            </td>
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
        const titulo = currentUrl.searchParams.get('titulo') || '';
        const autor = currentUrl.searchParams.get('autor') || '';
        const editorial = currentUrl.searchParams.get('editorial') || '';
        const tipo = currentUrl.searchParams.get('tipo') || '';
        const estado = currentUrl.searchParams.get('estado') || '';
        const tipoBibliografia = currentUrl.searchParams.get('tipo_bibliografia') || '';
        const bibliografiasDisponibles = currentUrl.searchParams.get('bibliografias_disponibles') || '';
        
        // Construir la URL de exportación con los filtros
        let exportUrl = '{{ app_url }}reportes/listado-bibliografias/exportar?';
        
        if (titulo) exportUrl += 'titulo=' + encodeURIComponent(titulo) + '&';
        if (autor) exportUrl += 'autor=' + encodeURIComponent(autor) + '&';
        if (editorial) exportUrl += 'editorial=' + encodeURIComponent(editorial) + '&';
        if (tipo) exportUrl += 'tipo=' + encodeURIComponent(tipo) + '&';
        if (estado) exportUrl += 'estado=' + encodeURIComponent(estado) + '&';
        if (tipoBibliografia) exportUrl += 'tipo_bibliografia=' + encodeURIComponent(tipoBibliografia) + '&';
        if (bibliografiasDisponibles) exportUrl += 'bibliografias_disponibles=' + encodeURIComponent(bibliografiasDisponibles) + '&';
        
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
{% endblock %} ", "reportes/bibliografias_declaradas/index.twig", "/var/www/html/biblioges/templates/reportes/bibliografias_declaradas/index.twig");
    }
}
