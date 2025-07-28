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

/* usuarios/index.twig */
class __TwigTemplate_648c3a5d6657051a98a6c3379593bc6a extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "usuarios/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Gestión de Usuarios - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de usuarios */
    .usuarios-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .usuarios-table thead th {
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
    
    .usuarios-table thead th:first-child {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(2) {
        width: 25% !important;
        min-width: 150px !important;
    }
    
    .usuarios-table thead th:nth-child(3) {
        width: 20% !important;
        min-width: 120px !important;
    }
    
    .usuarios-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(5) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(6) {
        width: 15% !important;
        min-width: 100px !important;
    }
    
    .usuarios-table thead th:last-child {
        width: 16% !important;
        min-width: 120px !important;
    }
    
    .usuarios-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .usuarios-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .usuarios-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .usuarios-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .usuarios-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .usuarios-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .usuarios-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .usuarios-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .usuarios-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .usuarios-table tbody td:nth-child(3) {
        font-size: 0.8rem !important;
        color: #495057 !important;
    }
    
    .usuarios-table tbody td:nth-child(4) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:last-child {
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
        .usuarios-table {
            font-size: 0.75rem !important;
        }
        
        .usuarios-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .usuarios-table tbody td {
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
        .usuarios-table {
            font-size: 0.7rem !important;
        }
        
        .usuarios-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .usuarios-table tbody td {
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

    // line 357
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 358
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">
            <i class=\"fas fa-users\"></i> Gestión de Usuarios
        </h1>
        <a href=\"";
        // line 363
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nuevo Usuario
        </a>
    </div>

    ";
        // line 368
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 368)) {
            // line 369
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 371
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 371), "icon", [], "any", false, false, false, 371), "html", null, true);
            yield "',
            title: '";
            // line 372
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 372), "title", [], "any", false, false, false, 372);
            yield "',
            text: '";
            // line 373
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 373), "text", [], "any", false, false, false, 373);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 378
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 385
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label for=\"search\">Buscar</label>
                            <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                   placeholder=\"Nombre, email o RUT\" value=\"";
        // line 391
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "search", [], "any", false, false, false, 391), "html", null, true);
        yield "\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"rol\">Rol</label>
                            <select class=\"form-control\" id=\"rol\" name=\"rol\">
                                <option value=\"\">Todos los roles</option>
                                ";
        // line 399
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["roles"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 400
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "rol", [], "any", false, false, false, 400) == $context["key"])) ? ("selected") : (""));
            yield ">
                                        ";
            // line 401
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 404
        yield "                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos los estados</option>
                                ";
        // line 412
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["estados"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 413
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 413) == $context["key"])) ? ("selected") : (""));
            yield ">
                                        ";
            // line 414
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["value"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 417
        yield "                            </select>
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
        // line 427
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Usuarios</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 446
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 446));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 447
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 447) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 448
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 451
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 454
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 454), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 454), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover usuarios-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"";
        // line 464
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("rut", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 464), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 464), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 464), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 464)), "html", null, true);
        yield "\">
                                    RUT
                                    <i class=\"fas ";
        // line 466
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("rut", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 466), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 466)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 470
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 470), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 470), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 470), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 470)), "html", null, true);
        yield "\">
                                    Nombre
                                    <i class=\"fas ";
        // line 472
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 472), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 472)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 476
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("email", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 476), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 476), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 476), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 476)), "html", null, true);
        yield "\">
                                    Email
                                    <i class=\"fas ";
        // line 478
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("email", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 478), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 478)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 482
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("rol", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 482), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 482), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 482), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 482)), "html", null, true);
        yield "\">
                                    Rol
                                    <i class=\"fas ";
        // line 484
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("rol", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 484), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 484)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 488
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 488), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 488), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 488), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 488)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 490
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 490), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 490)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 494
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("fecha_creacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 494), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 494), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 494), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 494)), "html", null, true);
        yield "\">
                                    Fecha Creación
                                    <i class=\"fas ";
        // line 496
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("fecha_creacion", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 496), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 496)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 503
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["usuarios"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["usuario"]) {
            // line 504
            yield "                        <tr>
                            <td>";
            // line 505
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "rut", [], "any", false, false, false, 505), "html", null, true);
            yield "</td>
                            <td>";
            // line 506
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "nombre", [], "any", false, false, false, 506), "html", null, true);
            yield "</td>
                            <td>";
            // line 507
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "email", [], "any", false, false, false, 507), "html", null, true);
            yield "</td>
                            <td class=\"text-center\">
                                <span class=\"badge bg-info\">";
            // line 509
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["roles"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "rol", [], "any", false, false, false, 509)] ?? null) : null), "html", null, true);
            yield "</span>
                            </td>
                            <td class=\"text-center\">
                                ";
            // line 512
            if (CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 512)) {
                // line 513
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 515
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 517
            yield "                            </td>
                            <td class=\"text-center\">";
            // line 518
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "fecha_creacion", [], "any", false, false, false, 518), "d/m/Y H:i"), "html", null, true);
            yield "</td>
                            <td class=\"text-center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"";
            // line 521
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "usuarios/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 521), "html", null, true);
            yield "\" 
                                       class=\"btn btn-sm btn-info btn-action\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 525
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "usuarios/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 525), "html", null, true);
            yield "/edit\" 
                                       class=\"btn btn-sm btn-warning btn-action\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    ";
            // line 529
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 529) != CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 529))) {
                // line 530
                yield "                                        <button type=\"button\" 
                                                class=\"btn btn-sm ";
                // line 531
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 531)) ? ("btn-danger") : ("btn-success"));
                yield " btn-action\"
                                                onclick=\"cambiarEstado(";
                // line 532
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 532), "html", null, true);
                yield ", ";
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 532)) ? (0) : (1));
                yield ")\"
                                                title=\"";
                // line 533
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 533)) ? ("Desactivar") : ("Activar"));
                yield "\">
                                            <i class=\"fas fa-";
                // line 534
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "estado", [], "any", false, false, false, 534)) ? ("times") : ("check"));
                yield "\"></i>
                                        </button>
                                        <button type=\"button\" 
                                                class=\"btn btn-sm btn-danger btn-action\"
                                                onclick=\"eliminarUsuario(";
                // line 538
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["usuario"], "id", [], "any", false, false, false, 538), "html", null, true);
                yield ")\"
                                                title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    ";
            }
            // line 543
            yield "                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 546
        if (!$context['_iterated']) {
            // line 547
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron usuarios</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['usuario'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 551
        yield "                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            ";
        // line 556
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 556) > 1)) {
            // line 557
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 560
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 560)) {
                // line 561
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 562
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 562), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 562), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 562), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 562)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 567
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 571
            yield "
                    <!-- Números de página -->
                    ";
            // line 573
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 573) - 2));
            // line 574
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 574), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 574) + 2));
            // line 575
            yield "
                    ";
            // line 576
            if ((($context["start_page"] ?? null) > 1)) {
                // line 577
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 578
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 578), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 578), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 578)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 580
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 581
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 585
                yield "                    ";
            }
            // line 586
            yield "
                    ";
            // line 587
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 588
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 588))) {
                    // line 589
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 590
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 593
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 594
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 594), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 594), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 594)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 597
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 598
            yield "
                    ";
            // line 599
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 599))) {
                // line 600
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 600) - 1))) {
                    // line 601
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 605
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 606
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 606), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 606), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 606), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 606)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 606), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 609
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 611
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 611)) {
                // line 612
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 613
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 613), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 613), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 613), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 613)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 618
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 622
            yield "                </ul>
            </nav>
            ";
        }
        // line 625
        yield "        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 630
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 631
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

    function cambiarEstado(userId, nuevoEstado) {
        const accion = nuevoEstado ? 'activar' : 'desactivar';
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas \${accion} este usuario?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`";
        // line 661
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/\${userId}/change-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        estado: nuevoEstado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cambiar el estado del usuario',
                        confirmButtonColor: '#4e73df'
                    });
                });
            }
        });
    }

    function eliminarUsuario(userId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: \"Esta acción no se puede deshacer\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`";
        // line 715
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios/\${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al eliminar el usuario',
                        confirmButtonColor: '#4e73df'
                    });
                });
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
        return "usuarios/index.twig";
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
        return array (  1075 => 715,  1018 => 661,  986 => 631,  979 => 630,  971 => 625,  966 => 622,  960 => 618,  952 => 613,  949 => 612,  947 => 611,  943 => 609,  935 => 606,  932 => 605,  926 => 601,  923 => 600,  921 => 599,  918 => 598,  912 => 597,  904 => 594,  901 => 593,  895 => 590,  892 => 589,  889 => 588,  885 => 587,  882 => 586,  879 => 585,  873 => 581,  871 => 580,  866 => 578,  863 => 577,  861 => 576,  858 => 575,  855 => 574,  853 => 573,  849 => 571,  843 => 567,  835 => 562,  832 => 561,  830 => 560,  825 => 557,  823 => 556,  816 => 551,  807 => 547,  805 => 546,  798 => 543,  790 => 538,  783 => 534,  779 => 533,  773 => 532,  769 => 531,  766 => 530,  764 => 529,  755 => 525,  746 => 521,  740 => 518,  737 => 517,  733 => 515,  729 => 513,  727 => 512,  721 => 509,  716 => 507,  712 => 506,  708 => 505,  705 => 504,  700 => 503,  690 => 496,  685 => 494,  678 => 490,  673 => 488,  666 => 484,  661 => 482,  654 => 478,  649 => 476,  642 => 472,  637 => 470,  630 => 466,  625 => 464,  610 => 454,  605 => 451,  596 => 448,  587 => 447,  583 => 446,  561 => 427,  549 => 417,  540 => 414,  533 => 413,  529 => 412,  519 => 404,  510 => 401,  503 => 400,  499 => 399,  488 => 391,  479 => 385,  470 => 378,  462 => 373,  458 => 372,  454 => 371,  450 => 369,  448 => 368,  440 => 363,  433 => 358,  426 => 357,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Gestión de Usuarios - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de usuarios */
    .usuarios-table {
        font-size: 0.8rem !important;
        width: 100% !important;
        table-layout: auto !important;
        word-wrap: break-word !important;
    }
    
    .usuarios-table thead th {
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
    
    .usuarios-table thead th:first-child {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(2) {
        width: 25% !important;
        min-width: 150px !important;
    }
    
    .usuarios-table thead th:nth-child(3) {
        width: 20% !important;
        min-width: 120px !important;
    }
    
    .usuarios-table thead th:nth-child(4) {
        width: 12% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(5) {
        width: 10% !important;
        min-width: 80px !important;
    }
    
    .usuarios-table thead th:nth-child(6) {
        width: 15% !important;
        min-width: 100px !important;
    }
    
    .usuarios-table thead th:last-child {
        width: 16% !important;
        min-width: 120px !important;
    }
    
    .usuarios-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .usuarios-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .usuarios-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .usuarios-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .usuarios-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .usuarios-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .usuarios-table tbody td {
        font-size: 0.8rem !important;
        padding: 8px 6px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    
    .usuarios-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .usuarios-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
        font-size: 0.8rem !important;
    }
    
    .usuarios-table tbody td:nth-child(3) {
        font-size: 0.8rem !important;
        color: #495057 !important;
    }
    
    .usuarios-table tbody td:nth-child(4) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:nth-child(5) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:nth-child(6) {
        text-align: center !important;
        font-size: 0.75rem !important;
    }
    
    .usuarios-table tbody td:last-child {
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
        .usuarios-table {
            font-size: 0.75rem !important;
        }
        
        .usuarios-table thead th {
            font-size: 0.7rem !important;
            padding: 6px 3px !important;
        }
        
        .usuarios-table tbody td {
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
        .usuarios-table {
            font-size: 0.7rem !important;
        }
        
        .usuarios-table thead th {
            font-size: 0.65rem !important;
            padding: 4px 2px !important;
        }
        
        .usuarios-table tbody td {
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
        <h1 class=\"h3 mb-0 text-gray-800\">
            <i class=\"fas fa-users\"></i> Gestión de Usuarios
        </h1>
        <a href=\"{{ app_url }}usuarios/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nuevo Usuario
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
            <form method=\"GET\" action=\"{{ app_url }}usuarios\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-4\">
                        <div class=\"form-group\">
                            <label for=\"search\">Buscar</label>
                            <input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\" 
                                   placeholder=\"Nombre, email o RUT\" value=\"{{ filtros.search }}\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"rol\">Rol</label>
                            <select class=\"form-control\" id=\"rol\" name=\"rol\">
                                <option value=\"\">Todos los roles</option>
                                {% for key, value in roles %}
                                    <option value=\"{{ key }}\" {{ filtros.rol == key ? 'selected' : '' }}>
                                        {{ value }}
                                    </option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos los estados</option>
                                {% for key, value in estados %}
                                    <option value=\"{{ key }}\" {{ filtros.estado == key ? 'selected' : '' }}>
                                        {{ value }}
                                    </option>
                                {% endfor %}
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
                            <a href=\"{{ app_url }}usuarios\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-times\"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Usuarios</h6>
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
                <table class=\"table table-striped table-hover usuarios-table\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"{{ build_sort_url('rut', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    RUT
                                    <i class=\"fas {{ get_sort_icon('rut', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('email', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Email
                                    <i class=\"fas {{ get_sort_icon('email', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('rol', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Rol
                                    <i class=\"fas {{ get_sort_icon('rol', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('fecha_creacion', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Fecha Creación
                                    <i class=\"fas {{ get_sort_icon('fecha_creacion', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for usuario in usuarios %}
                        <tr>
                            <td>{{ usuario.rut }}</td>
                            <td>{{ usuario.nombre }}</td>
                            <td>{{ usuario.email }}</td>
                            <td class=\"text-center\">
                                <span class=\"badge bg-info\">{{ roles[usuario.rol] }}</span>
                            </td>
                            <td class=\"text-center\">
                                {% if usuario.estado %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td class=\"text-center\">{{ usuario.fecha_creacion|date('d/m/Y H:i') }}</td>
                            <td class=\"text-center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"{{ app_url }}usuarios/{{ usuario.id }}\" 
                                       class=\"btn btn-sm btn-info btn-action\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}usuarios/{{ usuario.id }}/edit\" 
                                       class=\"btn btn-sm btn-warning btn-action\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    {% if usuario.id != session.user_id %}
                                        <button type=\"button\" 
                                                class=\"btn btn-sm {{ usuario.estado ? 'btn-danger' : 'btn-success' }} btn-action\"
                                                onclick=\"cambiarEstado({{ usuario.id }}, {{ usuario.estado ? 0 : 1 }})\"
                                                title=\"{{ usuario.estado ? 'Desactivar' : 'Activar' }}\">
                                            <i class=\"fas fa-{{ usuario.estado ? 'times' : 'check' }}\"></i>
                                        </button>
                                        <button type=\"button\" 
                                                class=\"btn btn-sm btn-danger btn-action\"
                                                onclick=\"eliminarUsuario({{ usuario.id }})\"
                                                title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    {% endif %}
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron usuarios</td>
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

    function cambiarEstado(userId, nuevoEstado) {
        const accion = nuevoEstado ? 'activar' : 'desactivar';
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas \${accion} este usuario?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ app_url }}usuarios/\${userId}/change-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        estado: nuevoEstado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cambiar el estado del usuario',
                        confirmButtonColor: '#4e73df'
                    });
                });
            }
        });
    }

    function eliminarUsuario(userId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: \"Esta acción no se puede deshacer\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ app_url }}usuarios/\${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#4e73df'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al eliminar el usuario',
                        confirmButtonColor: '#4e73df'
                    });
                });
            }
        });
    }
</script>
{% endblock %} ", "usuarios/index.twig", "/var/www/html/biblioges/templates/usuarios/index.twig");
    }
}
