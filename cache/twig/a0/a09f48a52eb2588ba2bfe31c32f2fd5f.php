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
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<style>
    /* Estilos personalizados para la tabla de autores */
    .autores-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .autores-table thead th {
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
    
    .autores-table thead th:first-child {
        width: 35% !important;
        min-width: 180px !important;
    }
    
    .autores-table thead th:nth-child(2) {
        width: 35% !important;
        min-width: 180px !important;
    }
    
    .autores-table thead th:nth-child(3) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .autores-table thead th:last-child {
        width: 20% !important;
        min-width: 200px !important;
    }
    
    .autores-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .autores-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .autores-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .autores-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .autores-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .autores-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .autores-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .autores-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .autores-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .autores-table tbody td:nth-child(3) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .autores-table tbody td:last-child {
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
    
    /* Estilos para los botones de acciones en una fila horizontal */
    .btn-acciones-container {
        display: flex;
        flex-direction: row;
        gap: 2px;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-acciones-container .btn {
        flex: 0 0 auto;
        min-width: 32px;
        font-size: 0.65rem;
        padding: 0.2rem 0.3rem;
        white-space: nowrap;
        margin: 1px;
    }
    
    .btn-acciones-container .btn i {
        margin-right: 0;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .autores-table {
            font-size: 0.75rem !important;
        }
        
        .autores-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .autores-table tbody td {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .btn-acciones-container .btn {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.25rem !important;
            min-width: 28px !important;
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
        .autores-table {
            font-size: 0.7rem !important;
        }
        
        .autores-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .autores-table tbody td {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .btn-acciones-container {
            flex-direction: column !important;
            gap: 1px !important;
        }
        
        .btn-acciones-container .btn {
            font-size: 0.55rem !important;
            padding: 0.1rem 0.2rem !important;
            min-width: 24px !important;
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

    // line 367
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 368
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">
            <i class=\"fas fa-users\"></i> Autores
        </h1>
        <div class=\"d-flex gap-2\">
            <button type=\"button\" class=\"btn btn-warning\" onclick=\"iniciarBusquedaDuplicados()\">
                <i class=\"fas fa-search\"></i> Buscar Duplicados Globales
            </button>
            <a href=\"";
        // line 377
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/create\" class=\"btn btn-primary\">
                <i class=\"fas fa-plus\"></i> Nuevo Autor
            </a>
        </div>
    </div>

    ";
        // line 383
        if (($context["success"] ?? null)) {
            // line 384
            yield "        <div class=\"alert alert-success alert-dismissible\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <h5><i class=\"icon fas fa-check\"></i> Éxito</h5>
            ";
            // line 387
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        </div>
    ";
        }
        // line 390
        yield "
    ";
        // line 391
        if (($context["error"] ?? null)) {
            // line 392
            yield "        <div class=\"alert alert-danger alert-dismissible\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
            ";
            // line 395
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        </div>
    ";
        }
        // line 398
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 405
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label for=\"busqueda\">Buscar</label>
                            <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                                   placeholder=\"Nombre o apellido\" value=\"";
        // line 411
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", true, true, false, 411)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 411), "")) : ("")), "html", null, true);
        yield "\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_busqueda\">Tipo de búsqueda</label>
                            <select class=\"form-control\" id=\"tipo_busqueda\" name=\"tipo_busqueda\">
                                <option value=\"todos\" ";
        // line 418
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 418)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 418), "todos")) : ("todos")) == "todos")) {
            yield "selected";
        }
        yield ">Todos</option>
                                <option value=\"apellidos\" ";
        // line 419
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 419)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 419), "")) : ("")) == "apellidos")) {
            yield "selected";
        }
        yield ">Apellidos</option>
                                <option value=\"nombres\" ";
        // line 420
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", true, true, false, 420)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 420), "")) : ("")) == "nombres")) {
            yield "selected";
        }
        yield ">Nombres</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"genero\">Género</label>
                            <select class=\"form-control\" id=\"genero\" name=\"genero\">
                                <option value=\"\">Todos los géneros</option>
                                <option value=\"M\" ";
        // line 429
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 429)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 429), "")) : ("")) == "M")) {
            yield "selected";
        }
        yield ">Masculino</option>
                                <option value=\"F\" ";
        // line 430
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 430)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 430), "")) : ("")) == "F")) {
            yield "selected";
        }
        yield ">Femenino</option>
                                <option value=\"O\" ";
        // line 431
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", true, true, false, 431)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 431), "")) : ("")) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
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
        // line 442
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    ";
        // line 452
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)) > 0)) {
            // line 453
            yield "        <!-- Tabla de autores -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Autores</h6>
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                            <option value=\"10\" ";
            // line 462
            if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", true, true, false, 462)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", false, false, false, 462), 20)) : (20)) == 10)) {
                yield "selected";
            }
            yield ">10</option>
                            <option value=\"20\" ";
            // line 463
            if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", true, true, false, 463)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", false, false, false, 463), 20)) : (20)) == 20)) {
                yield "selected";
            }
            yield ">20</option>
                            <option value=\"50\" ";
            // line 464
            if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", true, true, false, 464)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", false, false, false, 464), 20)) : (20)) == 50)) {
                yield "selected";
            }
            yield ">50</option>
                            <option value=\"100\" ";
            // line 465
            if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", true, true, false, 465)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", false, false, false, 465), 20)) : (20)) == 100)) {
                yield "selected";
            }
            yield ">100</option>
                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando ";
            // line 469
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", true, true, false, 469)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "per_page", [], "any", false, false, false, 469), 20)) : (20)), "html", null, true);
            yield " de ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", true, true, false, 469)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_registros", [], "any", false, false, false, 469), Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)))) : (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)))), "html", null, true);
            yield " registros
                    </div>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-hover autores-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"";
            // line 479
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=apellidos&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 479) == "apellidos") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 479) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 479)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 479)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 479)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 479)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 479)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 479)), "html", null, true)) : (""));
            yield "\" class=\"text-white text-decoration-none\">
                                        Apellidos
                                        ";
            // line 481
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 481) == "apellidos")) {
                // line 482
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 482) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 484
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 486
            yield "                                    </a>
                                </th>
                                <th>
                                    <a href=\"";
            // line 489
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=nombres&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 489) == "nombres") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 489) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 489)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 489)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 489)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 489)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 489)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 489)), "html", null, true)) : (""));
            yield "\" class=\"text-white text-decoration-none\">
                                        Nombres
                                        ";
            // line 491
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 491) == "nombres")) {
                // line 492
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 492) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 494
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 496
            yield "                                    </a>
                                </th>
                                <th class=\"text-center\">
                                    <a href=\"";
            // line 499
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores?orden=genero&direccion=";
            yield ((((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 499) == "genero") && (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 499) == "asc"))) ? ("desc") : ("asc"));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 499)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 499)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 499)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&tipo_busqueda=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 499)), "html", null, true)) : (""));
            yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 499)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(("&genero=" . CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 499)), "html", null, true)) : (""));
            yield "\" class=\"text-white text-decoration-none\">
                                        Género
                                        ";
            // line 501
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 501) == "genero")) {
                // line 502
                yield "                                            <i class=\"fas fa-sort-";
                yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 502) == "asc")) ? ("up") : ("down"));
                yield "\"></i>
                                        ";
            } else {
                // line 504
                yield "                                            <i class=\"fas fa-sort\"></i>
                                        ";
            }
            // line 506
            yield "                                    </a>
                                </th>
                                <th class=\"text-center\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 512
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["autores"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                // line 513
                yield "                                <tr>
                                    <td class=\"text-wrap\" title=\"";
                // line 514
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 514), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 514), "html", null, true);
                yield "</td>
                                    <td class=\"text-wrap\" title=\"";
                // line 515
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 515), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 515), "html", null, true);
                yield "</td>
                                    <td class=\"text-center\">";
                // line 516
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 516), "html", null, true);
                yield "</td>
                                    <td class=\"text-center\">
                                        <div class=\"btn-acciones-container\">
                                            <a href=\"";
                // line 519
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 519), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-info\" title=\"Editar\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <a href=\"";
                // line 522
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 522), "html", null, true);
                yield "/variaciones\" class=\"btn btn-sm btn-success\" title=\"Alias\">
                                                <i class=\"fas fa-tags\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"agregarAlias(";
                // line 525
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 525), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 525), "html", null, true);
                yield ", ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 525), "html", null, true);
                yield "')\" title=\"+Alias\">
                                                <i class=\"fas fa-plus\"></i>
                                            </button>
                                            <a href=\"";
                // line 528
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 528), "html", null, true);
                yield "/duplicados\" class=\"btn btn-sm btn-warning\" title=\"Duplicados\">
                                                <i class=\"fas fa-search\"></i>
                                            </a>
                                            <form method=\"POST\" action=\"";
                // line 531
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 531), "html", null, true);
                yield "/delete\" class=\"d-inline delete-form\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                                    <i class=\"fas fa-trash\"></i>
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
            // line 540
            yield "                        </tbody>
                    </table>
                </div>

                ";
            // line 545
            yield "                ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 545) > 1)) {
                // line 546
                yield "                <nav aria-label=\"Navegación de páginas\">
                    <ul class=\"pagination justify-content-center\">
                        <!-- Botón Primera Página -->
                        <li class=\"page-item ";
                // line 549
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 549) == 1)) {
                    yield "disabled";
                }
                yield "\">
                            <a class=\"page-link\" href=\"";
                // line 550
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=1";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 550)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 550), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 550)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 550), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 550)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 550), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 550)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 550), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 550)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 550), "html", null, true);
                }
                yield "\" aria-label=\"Primera\">
                                <i class=\"fas fa-angle-double-left\"></i>
                            </a>
                        </li>

                        <!-- Botón Página Anterior -->
                        <li class=\"page-item ";
                // line 556
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 556) == 1)) {
                    yield "disabled";
                }
                yield "\">
                            <a class=\"page-link\" href=\"";
                // line 557
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 557) - 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 557)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 557), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 557)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 557), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 557)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 557), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 557)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 557), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 557)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 557), "html", null, true);
                }
                yield "\" aria-label=\"Anterior\">
                                <i class=\"fas fa-angle-left\"></i>
                            </a>
                        </li>

                        <!-- Números de Página -->
                        ";
                // line 563
                $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 563) - 2));
                // line 564
                yield "                        ";
                $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 564), (($context["inicio"] ?? null) + 4));
                // line 565
                yield "                        ";
                if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                    // line 566
                    yield "                            ";
                    $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                    // line 567
                    yield "                        ";
                }
                // line 568
                yield "
                        ";
                // line 569
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 570
                    yield "                            <li class=\"page-item ";
                    if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 570))) {
                        yield "active";
                    }
                    yield "\">
                                <a class=\"page-link\" href=\"";
                    // line 571
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "autores?pagina=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 571)) {
                        yield "&busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 571), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 571)) {
                        yield "&tipo_busqueda=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 571), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 571)) {
                        yield "&genero=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 571), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 571)) {
                        yield "&orden=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 571), "html", null, true);
                    }
                    if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 571)) {
                        yield "&direccion=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 571), "html", null, true);
                    }
                    yield "\">
                                    ";
                    // line 572
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                    yield "
                                </a>
                            </li>
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 576
                yield "
                        <!-- Botón Página Siguiente -->
                        <li class=\"page-item ";
                // line 578
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 578) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 578))) {
                    yield "disabled";
                }
                yield "\">
                            <a class=\"page-link\" href=\"";
                // line 579
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 579) + 1), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 579)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 579), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 579)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 579), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 579)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 579), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 579)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 579), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 579)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 579), "html", null, true);
                }
                yield "\" aria-label=\"Siguiente\">
                                <i class=\"fas fa-angle-right\"></i>
                            </a>
                        </li>

                        <!-- Botón Última Página -->
                        <li class=\"page-item ";
                // line 585
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "pagina", [], "any", false, false, false, 585) == CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 585))) {
                    yield "disabled";
                }
                yield "\">
                            <a class=\"page-link\" href=\"";
                // line 586
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "total_paginas", [], "any", false, false, false, 586), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 586)) {
                    yield "&busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 586), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 586)) {
                    yield "&tipo_busqueda=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_busqueda", [], "any", false, false, false, 586), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 586)) {
                    yield "&genero=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "genero", [], "any", false, false, false, 586), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 586)) {
                    yield "&orden=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "orden", [], "any", false, false, false, 586), "html", null, true);
                }
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 586)) {
                    yield "&direccion=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "direccion", [], "any", false, false, false, 586), "html", null, true);
                }
                yield "\" aria-label=\"Última\">
                                <i class=\"fas fa-angle-double-right\"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                ";
            }
            // line 593
            yield "            </div>
        </div>
    ";
        } else {
            // line 596
            yield "        <div class=\"alert alert-info\">
            <h5><i class=\"icon fas fa-info\"></i> No se encontraron autores</h5>
            No se encontraron autores que coincidan con los criterios de búsqueda.
        </div>
    ";
        }
        // line 601
        yield "</div>
";
        yield from [];
    }

    // line 604
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 605
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
        // line 609
        if (($context["success"] ?? null)) {
            // line 610
            yield "                Swal.fire({
                    title: '";
            // line 611
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "title", [], "any", false, false, false, 611), "html", null, true);
            yield "',
                    text: '";
            // line 612
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "text", [], "any", false, false, false, 612), "html", null, true);
            yield "',
                    icon: '";
            // line 613
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["success"] ?? null), "icon", [], "any", false, false, false, 613), "html", null, true);
            yield "'
                });
            ";
        }
        // line 616
        yield "
            ";
        // line 617
        if (($context["error"] ?? null)) {
            // line 618
            yield "                Swal.fire({
                    title: '";
            // line 619
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "title", [], "any", false, false, false, 619), "html", null, true);
            yield "',
                    text: '";
            // line 620
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "text", [], "any", false, false, false, 620), "html", null, true);
            yield "',
                    icon: '";
            // line 621
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["error"] ?? null), "icon", [], "any", false, false, false, 621), "html", null, true);
            yield "'
                });
            ";
        }
        // line 624
        yield "
            // Evento para cambiar registros por página
            document.getElementById('per_page').addEventListener('change', function() {
                const perPage = this.value;
                const currentUrl = new URL(window.location);
                
                // Actualizar parámetro per_page
                currentUrl.searchParams.set('per_page', perPage);
                
                // Resetear a la primera página cuando se cambia el número de registros
                currentUrl.searchParams.set('pagina', '1');
                
                // Redirigir a la nueva URL
                window.location.href = currentUrl.toString();
            });

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

            // Función para agregar alias
            window.agregarAlias = function(autorId, nombreAutor) {
                Swal.fire({
                    title: 'Agregar Alias',
                    text: `Agregar variación de nombre para: \${nombreAutor}`,
                    input: 'text',
                    inputLabel: 'Variación de nombre',
                    inputPlaceholder: 'Ej: Apellido, Nombre',
                    inputValue: nombreAutor,
                    showCancelButton: true,
                    confirmButtonText: 'Agregar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value || value.trim() === '') {
                            return 'Debe ingresar una variación de nombre';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const nombreVariacion = result.value.trim();
                        
                        // Crear formulario temporal para enviar los datos
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `";
        // line 687
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/\${autorId}/variaciones`;
                        
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'nombre_variacion';
                        input.value = nombreVariacion;
                        
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Función para iniciar búsqueda de duplicados globales
            window.iniciarBusquedaDuplicados = function() {
                // Marcar que hay una búsqueda en curso
                sessionStorage.setItem('busqueda_duplicados_en_curso', 'true');
                
                // Mostrar modal de progreso
                Swal.fire({
                    title: 'Buscando Duplicados',
                    html: `
                        <div class=\"text-center\">
                            <div class=\"mb-3\">
                                <div class=\"progress\" style=\"height: 20px;\">
                                    <div class=\"progress-bar progress-bar-striped progress-bar-animated\" 
                                         role=\"progressbar\" style=\"width: 0%\" id=\"progresoBar\">0%</div>
                                </div>
                            </div>
                            <p id=\"estadoProgreso\">Iniciando búsqueda...</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        // Iniciar búsqueda
                        fetch('";
        // line 724
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/iniciar-busqueda-duplicados', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Iniciar monitoreo de progreso
                                monitorearProgreso();
                            } else {
                                Swal.fire('Error', 'Error al iniciar búsqueda', 'error');
                                sessionStorage.removeItem('busqueda_duplicados_en_curso');
                            }
                        })
                        .catch(error => {
                            console.error('Error al iniciar búsqueda:', error);
                            Swal.fire('Error', 'Error al iniciar búsqueda', 'error');
                            sessionStorage.removeItem('busqueda_duplicados_en_curso');
                        });
                    }
                });
            };

            // Función para monitorear el progreso
            function monitorearProgreso() {
                fetch('";
        // line 751
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/progreso-duplicados')
                    .then(response => response.json())
                    .then(data => {
                        const progresoBar = document.getElementById('progresoBar');
                        const estadoProgreso = document.getElementById('estadoProgreso');
                        
                        if (data.error) {
                            Swal.fire('Error', 'Error al obtener progreso', 'error');
                            return;
                        }
                        
                        const porcentaje = data.porcentaje || 0;
                        const estado = data.estado || 'Procesando...';
                        const completado = data.completado || false;
                        
                        // Actualizar barra de progreso
                        progresoBar.style.width = porcentaje + '%';
                        progresoBar.textContent = porcentaje + '%';
                        estadoProgreso.textContent = estado;
                        
                        if (completado) {
                            // Redirigir a la página de duplicados globales
                            setTimeout(() => {
                                window.location.href = '";
        // line 774
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/duplicados-globales';
                            }, 1000);
                        } else if (porcentaje < 100) {
                            // Continuar monitoreando
                            setTimeout(monitorearProgreso, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener progreso:', error);
                        Swal.fire('Error', 'Error al obtener progreso', 'error');
                    });
            }
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
        return array (  1267 => 774,  1241 => 751,  1211 => 724,  1171 => 687,  1106 => 624,  1100 => 621,  1096 => 620,  1092 => 619,  1089 => 618,  1087 => 617,  1084 => 616,  1078 => 613,  1074 => 612,  1070 => 611,  1067 => 610,  1065 => 609,  1057 => 605,  1050 => 604,  1044 => 601,  1037 => 596,  1032 => 593,  1000 => 586,  994 => 585,  963 => 579,  957 => 578,  953 => 576,  943 => 572,  917 => 571,  910 => 570,  906 => 569,  903 => 568,  900 => 567,  897 => 566,  894 => 565,  891 => 564,  889 => 563,  858 => 557,  852 => 556,  822 => 550,  816 => 549,  811 => 546,  808 => 545,  802 => 540,  785 => 531,  777 => 528,  767 => 525,  759 => 522,  751 => 519,  745 => 516,  739 => 515,  733 => 514,  730 => 513,  726 => 512,  718 => 506,  714 => 504,  708 => 502,  706 => 501,  696 => 499,  691 => 496,  687 => 494,  681 => 492,  679 => 491,  669 => 489,  664 => 486,  660 => 484,  654 => 482,  652 => 481,  642 => 479,  627 => 469,  618 => 465,  612 => 464,  606 => 463,  600 => 462,  589 => 453,  587 => 452,  574 => 442,  558 => 431,  552 => 430,  546 => 429,  532 => 420,  526 => 419,  520 => 418,  510 => 411,  501 => 405,  492 => 398,  486 => 395,  481 => 392,  479 => 391,  476 => 390,  470 => 387,  465 => 384,  463 => 383,  454 => 377,  443 => 368,  436 => 367,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Autores{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de autores */
    .autores-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .autores-table thead th {
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
    
    .autores-table thead th:first-child {
        width: 35% !important;
        min-width: 180px !important;
    }
    
    .autores-table thead th:nth-child(2) {
        width: 35% !important;
        min-width: 180px !important;
    }
    
    .autores-table thead th:nth-child(3) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .autores-table thead th:last-child {
        width: 20% !important;
        min-width: 200px !important;
    }
    
    .autores-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .autores-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .autores-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .autores-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .autores-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .autores-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .autores-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .autores-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .autores-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .autores-table tbody td:nth-child(3) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .autores-table tbody td:last-child {
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
    
    /* Estilos para los botones de acciones en una fila horizontal */
    .btn-acciones-container {
        display: flex;
        flex-direction: row;
        gap: 2px;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .btn-acciones-container .btn {
        flex: 0 0 auto;
        min-width: 32px;
        font-size: 0.65rem;
        padding: 0.2rem 0.3rem;
        white-space: nowrap;
        margin: 1px;
    }
    
    .btn-acciones-container .btn i {
        margin-right: 0;
    }
    
    /* Estilos para mejorar la responsividad */
    .table-responsive {
        overflow-x: auto !important;
        max-width: 100% !important;
    }
    
    /* Ajustes para pantallas pequeñas */
    @media (max-width: 1200px) {
        .autores-table {
            font-size: 0.75rem !important;
        }
        
        .autores-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .autores-table tbody td {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .btn-acciones-container .btn {
            font-size: 0.6rem !important;
            padding: 0.15rem 0.25rem !important;
            min-width: 28px !important;
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
        .autores-table {
            font-size: 0.7rem !important;
        }
        
        .autores-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .autores-table tbody td {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .btn-acciones-container {
            flex-direction: column !important;
            gap: 1px !important;
        }
        
        .btn-acciones-container .btn {
            font-size: 0.55rem !important;
            padding: 0.1rem 0.2rem !important;
            min-width: 24px !important;
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
        <h1 class=\"h3 mb-0 text-gray-800\">
            <i class=\"fas fa-users\"></i> Autores
        </h1>
        <div class=\"d-flex gap-2\">
            <button type=\"button\" class=\"btn btn-warning\" onclick=\"iniciarBusquedaDuplicados()\">
                <i class=\"fas fa-search\"></i> Buscar Duplicados Globales
            </button>
            <a href=\"{{ app_url }}autores/create\" class=\"btn btn-primary\">
                <i class=\"fas fa-plus\"></i> Nuevo Autor
            </a>
        </div>
    </div>

    {% if success %}
        <div class=\"alert alert-success alert-dismissible\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <h5><i class=\"icon fas fa-check\"></i> Éxito</h5>
            {{ success }}
        </div>
    {% endif %}

    {% if error %}
        <div class=\"alert alert-danger alert-dismissible\">
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
            {{ error }}
        </div>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}autores\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label for=\"busqueda\">Buscar</label>
                            <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                                   placeholder=\"Nombre o apellido\" value=\"{{ filtros.busqueda|default('') }}\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_busqueda\">Tipo de búsqueda</label>
                            <select class=\"form-control\" id=\"tipo_busqueda\" name=\"tipo_busqueda\">
                                <option value=\"todos\" {% if filtros.tipo_busqueda|default('todos') == 'todos' %}selected{% endif %}>Todos</option>
                                <option value=\"apellidos\" {% if filtros.tipo_busqueda|default('') == 'apellidos' %}selected{% endif %}>Apellidos</option>
                                <option value=\"nombres\" {% if filtros.tipo_busqueda|default('') == 'nombres' %}selected{% endif %}>Nombres</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"genero\">Género</label>
                            <select class=\"form-control\" id=\"genero\" name=\"genero\">
                                <option value=\"\">Todos los géneros</option>
                                <option value=\"M\" {% if filtros.genero|default('') == 'M' %}selected{% endif %}>Masculino</option>
                                <option value=\"F\" {% if filtros.genero|default('') == 'F' %}selected{% endif %}>Femenino</option>
                                <option value=\"O\" {% if filtros.genero|default('') == 'O' %}selected{% endif %}>Otro</option>
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
                            <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {% if autores|length > 0 %}
        <!-- Tabla de autores -->
        <div class=\"card shadow mb-4\">
            <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Autores</h6>
                <div class=\"d-flex align-items-center gap-3\">
                    <!-- Selector de registros por página -->
                    <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                        <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                        <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                            <option value=\"10\" {% if filtros.per_page|default(20) == 10 %}selected{% endif %}>10</option>
                            <option value=\"20\" {% if filtros.per_page|default(20) == 20 %}selected{% endif %}>20</option>
                            <option value=\"50\" {% if filtros.per_page|default(20) == 50 %}selected{% endif %}>50</option>
                            <option value=\"100\" {% if filtros.per_page|default(20) == 100 %}selected{% endif %}>100</option>
                        </select>
                    </div>
                    <div class=\"records-counter\">
                        Mostrando {{ filtros.per_page|default(20) }} de {{ filtros.total_registros|default(autores|length) }} registros
                    </div>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-striped table-hover autores-table\">
                        <thead>
                            <tr>
                                <th>
                                    <a href=\"{{ app_url }}autores?orden=apellidos&direccion={{ filtros.orden == 'apellidos' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-white text-decoration-none\">
                                        Apellidos
                                        {% if filtros.orden == 'apellidos' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th>
                                    <a href=\"{{ app_url }}autores?orden=nombres&direccion={{ filtros.orden == 'nombres' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-white text-decoration-none\">
                                        Nombres
                                        {% if filtros.orden == 'nombres' %}
                                            <i class=\"fas fa-sort-{{ filtros.direccion == 'asc' ? 'up' : 'down' }}\"></i>
                                        {% else %}
                                            <i class=\"fas fa-sort\"></i>
                                        {% endif %}
                                    </a>
                                </th>
                                <th class=\"text-center\">
                                    <a href=\"{{ app_url }}autores?orden=genero&direccion={{ filtros.orden == 'genero' and filtros.direccion == 'asc' ? 'desc' : 'asc' }}{{ filtros.busqueda ? '&busqueda=' ~ filtros.busqueda : '' }}{{ filtros.tipo_busqueda ? '&tipo_busqueda=' ~ filtros.tipo_busqueda : '' }}{{ filtros.genero ? '&genero=' ~ filtros.genero : '' }}\" class=\"text-white text-decoration-none\">
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
                                    <td class=\"text-wrap\" title=\"{{ autor.apellidos }}\">{{ autor.apellidos }}</td>
                                    <td class=\"text-wrap\" title=\"{{ autor.nombres }}\">{{ autor.nombres }}</td>
                                    <td class=\"text-center\">{{ autor.genero }}</td>
                                    <td class=\"text-center\">
                                        <div class=\"btn-acciones-container\">
                                            <a href=\"{{ app_url }}autores/{{ autor.id }}/edit\" class=\"btn btn-sm btn-info\" title=\"Editar\">
                                                <i class=\"fas fa-edit\"></i>
                                            </a>
                                            <a href=\"{{ app_url }}autores/{{ autor.id }}/variaciones\" class=\"btn btn-sm btn-success\" title=\"Alias\">
                                                <i class=\"fas fa-tags\"></i>
                                            </a>
                                            <button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"agregarAlias({{ autor.id }}, '{{ autor.apellidos }}, {{ autor.nombres }}')\" title=\"+Alias\">
                                                <i class=\"fas fa-plus\"></i>
                                            </button>
                                            <a href=\"{{ app_url }}autores/{{ autor.id }}/duplicados\" class=\"btn btn-sm btn-warning\" title=\"Duplicados\">
                                                <i class=\"fas fa-search\"></i>
                                            </a>
                                            <form method=\"POST\" action=\"{{ app_url }}autores/{{ autor.id }}/delete\" class=\"d-inline delete-form\">
                                                <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                                    <i class=\"fas fa-trash\"></i>
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
                <nav aria-label=\"Navegación de páginas\">
                    <ul class=\"pagination justify-content-center\">
                        <!-- Botón Primera Página -->
                        <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                            <a class=\"page-link\" href=\"{{ app_url }}autores?pagina=1{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Primera\">
                                <i class=\"fas fa-angle-double-left\"></i>
                            </a>
                        </li>

                        <!-- Botón Página Anterior -->
                        <li class=\"page-item {% if filtros.pagina == 1 %}disabled{% endif %}\">
                            <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.pagina - 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Anterior\">
                                <i class=\"fas fa-angle-left\"></i>
                            </a>
                        </li>

                        <!-- Números de Página -->
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

                        <!-- Botón Página Siguiente -->
                        <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                            <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.pagina + 1 }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Siguiente\">
                                <i class=\"fas fa-angle-right\"></i>
                            </a>
                        </li>

                        <!-- Botón Última Página -->
                        <li class=\"page-item {% if filtros.pagina == filtros.total_paginas %}disabled{% endif %}\">
                            <a class=\"page-link\" href=\"{{ app_url }}autores?pagina={{ filtros.total_paginas }}{% if filtros.busqueda %}&busqueda={{ filtros.busqueda }}{% endif %}{% if filtros.tipo_busqueda %}&tipo_busqueda={{ filtros.tipo_busqueda }}{% endif %}{% if filtros.genero %}&genero={{ filtros.genero }}{% endif %}{% if filtros.orden %}&orden={{ filtros.orden }}{% endif %}{% if filtros.direccion %}&direccion={{ filtros.direccion }}{% endif %}\" aria-label=\"Última\">
                                <i class=\"fas fa-angle-double-right\"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
    {% else %}
        <div class=\"alert alert-info\">
            <h5><i class=\"icon fas fa-info\"></i> No se encontraron autores</h5>
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

            // Evento para cambiar registros por página
            document.getElementById('per_page').addEventListener('change', function() {
                const perPage = this.value;
                const currentUrl = new URL(window.location);
                
                // Actualizar parámetro per_page
                currentUrl.searchParams.set('per_page', perPage);
                
                // Resetear a la primera página cuando se cambia el número de registros
                currentUrl.searchParams.set('pagina', '1');
                
                // Redirigir a la nueva URL
                window.location.href = currentUrl.toString();
            });

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

            // Función para agregar alias
            window.agregarAlias = function(autorId, nombreAutor) {
                Swal.fire({
                    title: 'Agregar Alias',
                    text: `Agregar variación de nombre para: \${nombreAutor}`,
                    input: 'text',
                    inputLabel: 'Variación de nombre',
                    inputPlaceholder: 'Ej: Apellido, Nombre',
                    inputValue: nombreAutor,
                    showCancelButton: true,
                    confirmButtonText: 'Agregar',
                    cancelButtonText: 'Cancelar',
                    inputValidator: (value) => {
                        if (!value || value.trim() === '') {
                            return 'Debe ingresar una variación de nombre';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const nombreVariacion = result.value.trim();
                        
                        // Crear formulario temporal para enviar los datos
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ app_url }}autores/\${autorId}/variaciones`;
                        
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'nombre_variacion';
                        input.value = nombreVariacion;
                        
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Función para iniciar búsqueda de duplicados globales
            window.iniciarBusquedaDuplicados = function() {
                // Marcar que hay una búsqueda en curso
                sessionStorage.setItem('busqueda_duplicados_en_curso', 'true');
                
                // Mostrar modal de progreso
                Swal.fire({
                    title: 'Buscando Duplicados',
                    html: `
                        <div class=\"text-center\">
                            <div class=\"mb-3\">
                                <div class=\"progress\" style=\"height: 20px;\">
                                    <div class=\"progress-bar progress-bar-striped progress-bar-animated\" 
                                         role=\"progressbar\" style=\"width: 0%\" id=\"progresoBar\">0%</div>
                                </div>
                            </div>
                            <p id=\"estadoProgreso\">Iniciando búsqueda...</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        // Iniciar búsqueda
                        fetch('{{ app_url }}autores/iniciar-busqueda-duplicados', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Iniciar monitoreo de progreso
                                monitorearProgreso();
                            } else {
                                Swal.fire('Error', 'Error al iniciar búsqueda', 'error');
                                sessionStorage.removeItem('busqueda_duplicados_en_curso');
                            }
                        })
                        .catch(error => {
                            console.error('Error al iniciar búsqueda:', error);
                            Swal.fire('Error', 'Error al iniciar búsqueda', 'error');
                            sessionStorage.removeItem('busqueda_duplicados_en_curso');
                        });
                    }
                });
            };

            // Función para monitorear el progreso
            function monitorearProgreso() {
                fetch('{{ app_url }}autores/progreso-duplicados')
                    .then(response => response.json())
                    .then(data => {
                        const progresoBar = document.getElementById('progresoBar');
                        const estadoProgreso = document.getElementById('estadoProgreso');
                        
                        if (data.error) {
                            Swal.fire('Error', 'Error al obtener progreso', 'error');
                            return;
                        }
                        
                        const porcentaje = data.porcentaje || 0;
                        const estado = data.estado || 'Procesando...';
                        const completado = data.completado || false;
                        
                        // Actualizar barra de progreso
                        progresoBar.style.width = porcentaje + '%';
                        progresoBar.textContent = porcentaje + '%';
                        estadoProgreso.textContent = estado;
                        
                        if (completado) {
                            // Redirigir a la página de duplicados globales
                            setTimeout(() => {
                                window.location.href = '{{ app_url }}autores/duplicados-globales';
                            }, 1000);
                        } else if (porcentaje < 100) {
                            // Continuar monitoreando
                            setTimeout(monitorearProgreso, 1000);
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener progreso:', error);
                        Swal.fire('Error', 'Error al obtener progreso', 'error');
                    });
            }
        });
    </script>
{% endblock %} ", "autores/index.twig", "/var/www/html/biblioges/templates/autores/index.twig");
    }
}
