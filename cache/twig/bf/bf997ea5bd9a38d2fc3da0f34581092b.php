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

/* unidades/index.twig */
class __TwigTemplate_e4b79d94e7baaca22a0ffb9e198d65e1 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "unidades/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Unidades - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de unidades */
    .unidades-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .unidades-table thead th {
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
    
    .unidades-table thead th:first-child {
        width: 10% !important;
        min-width: 60px !important;
    }
    
    .unidades-table thead th:nth-child(2) {
        width: 30% !important;
        min-width: 200px !important;
    }
    
    .unidades-table thead th:nth-child(3) {
        width: 10% !important;
        min-width: 70px !important;
    }
    
    .unidades-table thead th:nth-child(4) {
        width: 18% !important;
        min-width: 110px !important;
    }
    
    .unidades-table thead th:nth-child(5) {
        width: 14% !important;
        min-width: 90px !important;
    }
    
    .unidades-table thead th:nth-child(6) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .unidades-table thead th:last-child {
        width: 10% !important;
        min-width: 100px !important;
    }
    
    .unidades-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .unidades-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .unidades-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .unidades-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .unidades-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .unidades-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .unidades-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    /* Estilos específicos para la columna del nombre */
    .unidades-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:nth-child(3) {
        font-size: 0.8rem !important;
        color: #495057 !important;
    }
    
    .unidades-table tbody td:nth-child(4) {
        text-align: center !important;
        font-size: 0.75rem !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .unidades-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
        word-wrap: break-word !important;
    }
    
    .unidades-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .unidades-table tbody td:last-child {
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
        .unidades-table {
            font-size: 0.75rem !important;
        }
        
        .unidades-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .unidades-table tbody td {
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
        .unidades-table {
            font-size: 0.7rem !important;
        }
        
        .unidades-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .unidades-table tbody td {
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

    // line 369
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 370
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Unidades</h1>
        <a href=\"";
        // line 373
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Unidad
        </a>
    </div>

    ";
        // line 378
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 378)) {
            // line 379
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 381
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 381), "icon", [], "any", false, false, false, 381), "html", null, true);
            yield "',
            title: '";
            // line 382
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 382), "title", [], "any", false, false, false, 382);
            yield "',
            text: '";
            // line 383
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 383), "text", [], "any", false, false, false, 383);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 388
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 395
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas las sedes</option>
                                ";
        // line 402
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 403
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 403), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 403) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 403))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 403), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 405
        yield "                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" ";
        // line 413
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 413) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 414
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 414) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
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
        // line 425
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de unidades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Unidades</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 444
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 444));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 445
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 445) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 446
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 449
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 452
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 452), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 452), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover unidades-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"";
        // line 462
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("codigo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 462), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 462), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 462), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 462)), "html", null, true);
        yield "\">
                                    Código
                                    <i class=\"fas ";
        // line 464
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("codigo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 464), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 464)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 468
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 468), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 468), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 468), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 468)), "html", null, true);
        yield "\">
                                    Nombre
                                    <i class=\"fas ";
        // line 470
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 470), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 470)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 474
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("sede_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 474), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 474), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 474), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 474)), "html", null, true);
        yield "\">
                                    Sede
                                    <i class=\"fas ";
        // line 476
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("sede_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 476), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 476)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 480
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("unidad_padre_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 480), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 480), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 480), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 480)), "html", null, true);
        yield "\">
                                    Unidad Padre
                                    <i class=\"fas ";
        // line 482
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("unidad_padre_nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 482), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 482)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Unidades Hijas</th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 487
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 487), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 487), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 487), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 487)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 489
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 489), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 489)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 496
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
            // line 497
            yield "                        <tr>
                            <td>";
            // line 498
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "codigo", [], "any", false, false, false, 498), "html", null, true);
            yield "</td>
                            <td>";
            // line 499
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 499), "html", null, true);
            yield "</td>
                            <td>";
            // line 500
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "sede_nombre", [], "any", false, false, false, 500), "html", null, true);
            yield "</td>
                            <td class=\"text-center\">
                                ";
            // line 502
            if (CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "unidad_padre_nombre", [], "any", false, false, false, 502)) {
                // line 503
                yield "                                    <span class=\"badge bg-info\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "unidad_padre_nombre", [], "any", false, false, false, 503), "html", null, true);
                yield "</span>
                                ";
            } else {
                // line 505
                yield "                                    <span class=\"text-muted\">Sin unidad padre</span>
                                ";
            }
            // line 507
            yield "                            </td>
                            <td class=\"text-center\">
                                ";
            // line 509
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "cantidad_hijas", [], "any", false, false, false, 509) > 0)) {
                // line 510
                yield "                                    <span class=\"badge bg-warning\" title=\"Ver unidades hijas\" onclick=\"mostrarUnidadesHijas('";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "codigo", [], "any", false, false, false, 510), "html", null, true);
                yield "', '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 510), "html", null, true);
                yield "')\" style=\"cursor: pointer;\">
                                        ";
                // line 511
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "cantidad_hijas", [], "any", false, false, false, 511), "html", null, true);
                yield " unidad(es)
                                    </span>
                                ";
            } else {
                // line 514
                yield "                                    <span class=\"text-muted\">Sin unidades hijas</span>
                                ";
            }
            // line 516
            yield "                            </td>
                            <td class=\"text-center\">
                                ";
            // line 518
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "estado", [], "any", false, false, false, 518) == "1")) {
                // line 519
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 521
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 523
            yield "                            </td>
                            <td class=\"text-center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"";
            // line 526
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "unidades/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 526), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info btn-action\" title=\"Ver detalles\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 529
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "unidades/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 529), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-primary btn-action\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <button type=\"button\" class=\"btn btn-sm btn-danger btn-action\" onclick=\"deleteUnidad(";
            // line 532
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 532), "html", null, true);
            yield ", '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "nombre", [], "any", false, false, false, 532), "html", null, true);
            yield "')\" title=\"Eliminar\">
                                        <i class=\"fas fa-trash\"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 538
        if (!$context['_iterated']) {
            // line 539
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No hay unidades registradas</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 543
        yield "                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            ";
        // line 548
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 548) > 1)) {
            // line 549
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 552
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 552)) {
                // line 553
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 554
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 554), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 554), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 554), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 554)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 559
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 563
            yield "
                    <!-- Números de página -->
                    ";
            // line 565
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 565) - 2));
            // line 566
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 566), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 566) + 2));
            // line 567
            yield "
                    ";
            // line 568
            if ((($context["start_page"] ?? null) > 1)) {
                // line 569
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 570
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 570), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 570), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 570)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 572
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 573
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 577
                yield "                    ";
            }
            // line 578
            yield "
                    ";
            // line 579
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 580
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 580))) {
                    // line 581
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 582
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 585
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 586
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 586), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 586), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 586)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 589
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 590
            yield "
                    ";
            // line 591
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 591))) {
                // line 592
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 592) - 1))) {
                    // line 593
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 597
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 598
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 598), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 598), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 598), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 598)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 598), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 601
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 603
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 603)) {
                // line 604
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 605
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 605), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 605), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 605), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 605)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 610
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 614
            yield "                </ul>
            </nav>
            ";
        }
        // line 617
        yield "        </div>
    </div>
</div>

<!-- Modal para mostrar unidades hijas -->
<div class=\"modal fade\" id=\"modalUnidadesHijas\" tabindex=\"-1\" aria-labelledby=\"modalUnidadesHijasLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalUnidadesHijasLabel\">Unidades Hijas</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"loadingUnidadesHijas\" class=\"text-center d-none\">
                    <div class=\"spinner-border text-primary\" role=\"status\">
                        <span class=\"visually-hidden\">Cargando...</span>
                    </div>
                    <p class=\"mt-2\">Cargando unidades hijas...</p>
                </div>
                <div id=\"contenidoUnidadesHijas\">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 648
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 649
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

    // Función para mostrar unidades hijas
    function mostrarUnidadesHijas(codigoUnidad, nombreUnidad) {
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalUnidadesHijas'));
        modal.show();
        
        // Actualizar título del modal
        document.getElementById('modalUnidadesHijasLabel').textContent = `Unidades Hijas de: \${nombreUnidad}`;
        
        // Mostrar loading
        document.getElementById('loadingUnidadesHijas').classList.remove('d-none');
        document.getElementById('contenidoUnidadesHijas').innerHTML = '';
        
        // Realizar petición AJAX para obtener unidades hijas
        fetch(`";
        // line 679
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "api/unidades/hijas/\${codigoUnidad}`)
            .then(response => response.json())
            .then(data => {
                // Ocultar loading
                document.getElementById('loadingUnidadesHijas').classList.add('d-none');
                
                if (data && data.length > 0) {
                    // Crear tabla con las unidades hijas
                    let html = `
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-hover\">
                                <thead class=\"table-primary\">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    data.forEach(unidad => {
                        const estadoBadge = unidad.estado == '1' 
                            ? '<span class=\"badge bg-success\">Activo</span>'
                            : '<span class=\"badge bg-danger\">Inactivo</span>';
                        
                        html += `
                            <tr>
                                <td><strong>\${unidad.codigo}</strong></td>
                                <td>\${unidad.nombre}</td>
                                <td class=\"text-center\">\${estadoBadge}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                        <div class=\"mt-3\">
                            <p class=\"text-muted mb-0\">
                                <i class=\"fas fa-info-circle\"></i> 
                                Total: <strong>\${data.length}</strong> unidad(es) hija(s)
                            </p>
                        </div>
                    `;
                    
                    document.getElementById('contenidoUnidadesHijas').innerHTML = html;
                } else {
                    document.getElementById('contenidoUnidadesHijas').innerHTML = `
                        <div class=\"text-center text-muted\">
                            <i class=\"fas fa-info-circle fa-2x mb-3\"></i>
                            <p>No se encontraron unidades hijas para esta unidad.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error al cargar unidades hijas:', error);
                document.getElementById('loadingUnidadesHijas').classList.add('d-none');
                document.getElementById('contenidoUnidadesHijas').innerHTML = `
                    <div class=\"alert alert-danger\">
                        <i class=\"fas fa-exclamation-triangle\"></i>
                        Error al cargar las unidades hijas. Por favor, intente nuevamente.
                    </div>
                `;
            });
    }

    // Función para eliminar unidad
    function deleteUnidad(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la unidad \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '";
        // line 764
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
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
        return "unidades/index.twig";
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
        return array (  1109 => 764,  1021 => 679,  989 => 649,  982 => 648,  948 => 617,  943 => 614,  937 => 610,  929 => 605,  926 => 604,  924 => 603,  920 => 601,  912 => 598,  909 => 597,  903 => 593,  900 => 592,  898 => 591,  895 => 590,  889 => 589,  881 => 586,  878 => 585,  872 => 582,  869 => 581,  866 => 580,  862 => 579,  859 => 578,  856 => 577,  850 => 573,  848 => 572,  843 => 570,  840 => 569,  838 => 568,  835 => 567,  832 => 566,  830 => 565,  826 => 563,  820 => 559,  812 => 554,  809 => 553,  807 => 552,  802 => 549,  800 => 548,  793 => 543,  784 => 539,  782 => 538,  769 => 532,  761 => 529,  753 => 526,  748 => 523,  744 => 521,  740 => 519,  738 => 518,  734 => 516,  730 => 514,  724 => 511,  717 => 510,  715 => 509,  711 => 507,  707 => 505,  701 => 503,  699 => 502,  694 => 500,  690 => 499,  686 => 498,  683 => 497,  678 => 496,  668 => 489,  663 => 487,  655 => 482,  650 => 480,  643 => 476,  638 => 474,  631 => 470,  626 => 468,  619 => 464,  614 => 462,  599 => 452,  594 => 449,  585 => 446,  576 => 445,  572 => 444,  550 => 425,  534 => 414,  528 => 413,  518 => 405,  503 => 403,  499 => 402,  489 => 395,  480 => 388,  472 => 383,  468 => 382,  464 => 381,  460 => 379,  458 => 378,  450 => 373,  445 => 370,  438 => 369,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Unidades - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de unidades */
    .unidades-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .unidades-table thead th {
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
    
    .unidades-table thead th:first-child {
        width: 10% !important;
        min-width: 60px !important;
    }
    
    .unidades-table thead th:nth-child(2) {
        width: 30% !important;
        min-width: 200px !important;
    }
    
    .unidades-table thead th:nth-child(3) {
        width: 10% !important;
        min-width: 70px !important;
    }
    
    .unidades-table thead th:nth-child(4) {
        width: 18% !important;
        min-width: 110px !important;
    }
    
    .unidades-table thead th:nth-child(5) {
        width: 14% !important;
        min-width: 90px !important;
    }
    
    .unidades-table thead th:nth-child(6) {
        width: 8% !important;
        min-width: 60px !important;
    }
    
    .unidades-table thead th:last-child {
        width: 10% !important;
        min-width: 100px !important;
    }
    
    .unidades-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .unidades-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .unidades-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .unidades-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .unidades-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .unidades-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .unidades-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    /* Estilos específicos para la columna del nombre */
    .unidades-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .unidades-table tbody td:nth-child(3) {
        font-size: 0.8rem !important;
        color: #495057 !important;
    }
    
    .unidades-table tbody td:nth-child(4) {
        text-align: center !important;
        font-size: 0.75rem !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .unidades-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
        word-wrap: break-word !important;
    }
    
    .unidades-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .unidades-table tbody td:last-child {
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
        .unidades-table {
            font-size: 0.75rem !important;
        }
        
        .unidades-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .unidades-table tbody td {
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
        .unidades-table {
            font-size: 0.7rem !important;
        }
        
        .unidades-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .unidades-table tbody td {
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
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Unidades</h1>
        <a href=\"{{ app_url }}unidades/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Unidad
        </a>
    </div>

    {% if session.swal %}
    <script>
        Swal.fire({
            icon: '{{ session.swal.icon }}',
            title: '{{ session.swal.title|raw }}',
            text: '{{ session.swal.text|raw }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}unidades\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas las sedes</option>
                                {% for sede in sedes %}
                                    <option value=\"{{ sede.id }}\" {% if filtros.sede == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                                {% endfor %}
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
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12\">
                        <div class=\"d-flex gap-2 justify-content-start\">
                            <button type=\"submit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-filter\"></i> Aplicar Filtros
                            </button>
                            <a href=\"{{ app_url }}unidades\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de unidades -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Unidades</h6>
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
                <table class=\"table table-striped table-hover unidades-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"{{ build_sort_url('codigo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Código
                                    <i class=\"fas {{ get_sort_icon('codigo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('sede_nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Sede
                                    <i class=\"fas {{ get_sort_icon('sede_nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('unidad_padre_nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Unidad Padre
                                    <i class=\"fas {{ get_sort_icon('unidad_padre_nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Unidades Hijas</th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for unidad in unidades %}
                        <tr>
                            <td>{{ unidad.codigo }}</td>
                            <td>{{ unidad.nombre }}</td>
                            <td>{{ unidad.sede_nombre }}</td>
                            <td class=\"text-center\">
                                {% if unidad.unidad_padre_nombre %}
                                    <span class=\"badge bg-info\">{{ unidad.unidad_padre_nombre }}</span>
                                {% else %}
                                    <span class=\"text-muted\">Sin unidad padre</span>
                                {% endif %}
                            </td>
                            <td class=\"text-center\">
                                {% if unidad.cantidad_hijas > 0 %}
                                    <span class=\"badge bg-warning\" title=\"Ver unidades hijas\" onclick=\"mostrarUnidadesHijas('{{ unidad.codigo }}', '{{ unidad.nombre }}')\" style=\"cursor: pointer;\">
                                        {{ unidad.cantidad_hijas }} unidad(es)
                                    </span>
                                {% else %}
                                    <span class=\"text-muted\">Sin unidades hijas</span>
                                {% endif %}
                            </td>
                            <td class=\"text-center\">
                                {% if unidad.estado == '1' %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td class=\"text-center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"{{ app_url }}unidades/{{ unidad.id }}\" class=\"btn btn-sm btn-info btn-action\" title=\"Ver detalles\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}unidades/{{ unidad.id }}/edit\" class=\"btn btn-sm btn-primary btn-action\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <button type=\"button\" class=\"btn btn-sm btn-danger btn-action\" onclick=\"deleteUnidad({{ unidad.id }}, '{{ unidad.nombre }}')\" title=\"Eliminar\">
                                        <i class=\"fas fa-trash\"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No hay unidades registradas</td>
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

<!-- Modal para mostrar unidades hijas -->
<div class=\"modal fade\" id=\"modalUnidadesHijas\" tabindex=\"-1\" aria-labelledby=\"modalUnidadesHijasLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalUnidadesHijasLabel\">Unidades Hijas</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"loadingUnidadesHijas\" class=\"text-center d-none\">
                    <div class=\"spinner-border text-primary\" role=\"status\">
                        <span class=\"visually-hidden\">Cargando...</span>
                    </div>
                    <p class=\"mt-2\">Cargando unidades hijas...</p>
                </div>
                <div id=\"contenidoUnidadesHijas\">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
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

    // Función para mostrar unidades hijas
    function mostrarUnidadesHijas(codigoUnidad, nombreUnidad) {
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalUnidadesHijas'));
        modal.show();
        
        // Actualizar título del modal
        document.getElementById('modalUnidadesHijasLabel').textContent = `Unidades Hijas de: \${nombreUnidad}`;
        
        // Mostrar loading
        document.getElementById('loadingUnidadesHijas').classList.remove('d-none');
        document.getElementById('contenidoUnidadesHijas').innerHTML = '';
        
        // Realizar petición AJAX para obtener unidades hijas
        fetch(`{{ app_url }}api/unidades/hijas/\${codigoUnidad}`)
            .then(response => response.json())
            .then(data => {
                // Ocultar loading
                document.getElementById('loadingUnidadesHijas').classList.add('d-none');
                
                if (data && data.length > 0) {
                    // Crear tabla con las unidades hijas
                    let html = `
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-hover\">
                                <thead class=\"table-primary\">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    data.forEach(unidad => {
                        const estadoBadge = unidad.estado == '1' 
                            ? '<span class=\"badge bg-success\">Activo</span>'
                            : '<span class=\"badge bg-danger\">Inactivo</span>';
                        
                        html += `
                            <tr>
                                <td><strong>\${unidad.codigo}</strong></td>
                                <td>\${unidad.nombre}</td>
                                <td class=\"text-center\">\${estadoBadge}</td>
                            </tr>
                        `;
                    });
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                        <div class=\"mt-3\">
                            <p class=\"text-muted mb-0\">
                                <i class=\"fas fa-info-circle\"></i> 
                                Total: <strong>\${data.length}</strong> unidad(es) hija(s)
                            </p>
                        </div>
                    `;
                    
                    document.getElementById('contenidoUnidadesHijas').innerHTML = html;
                } else {
                    document.getElementById('contenidoUnidadesHijas').innerHTML = `
                        <div class=\"text-center text-muted\">
                            <i class=\"fas fa-info-circle fa-2x mb-3\"></i>
                            <p>No se encontraron unidades hijas para esta unidad.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error al cargar unidades hijas:', error);
                document.getElementById('loadingUnidadesHijas').classList.add('d-none');
                document.getElementById('contenidoUnidadesHijas').innerHTML = `
                    <div class=\"alert alert-danger\">
                        <i class=\"fas fa-exclamation-triangle\"></i>
                        Error al cargar las unidades hijas. Por favor, intente nuevamente.
                    </div>
                `;
            });
    }

    // Función para eliminar unidad
    function deleteUnidad(id, nombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Está seguro de eliminar la unidad \"\${nombre}\"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario temporal para enviar la petición POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ app_url }}unidades/' + id + '/delete';
                
                // Agregar token CSRF si es necesario
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '';
                form.appendChild(csrfInput);
                
                // Agregar el formulario al DOM y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
{% endblock %} ", "unidades/index.twig", "/var/www/html/biblioges/templates/unidades/index.twig");
    }
}
