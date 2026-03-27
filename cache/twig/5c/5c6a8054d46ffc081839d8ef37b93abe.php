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

/* mallas/index.twig */
class __TwigTemplate_1ff7a65751cf2102c78348d3c4541aec extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "mallas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Mallas - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de mallas */
    .mallas-table thead th {
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
    
    .mallas-table thead th:first-child {
        min-width: 100px !important;
        width: 100px !important;
    }
    
    .mallas-table thead th:nth-child(2) {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .mallas-table thead th:nth-child(3) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .mallas-table thead th:nth-child(4) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .mallas-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .mallas-table thead th:last-child {
        min-width: 150px !important;
        width: 150px !important;
    }
    
    .mallas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .mallas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .mallas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .mallas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .mallas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .mallas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .mallas-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .mallas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    /* Estilos para el botón de fusionar asignaturas */
    .btn-warning.btn-sm {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
        color: #212529 !important;
        font-size: 0.75rem !important;
        padding: 0.25rem 0.5rem !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-warning.btn-sm:hover {
        background-color: #e0a800 !important;
        border-color: #d39e00 !important;
        color: #212529 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    .btn-warning.btn-sm:active {
        transform: translateY(0) !important;
    }
    
    .mallas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .mallas-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .mallas-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .mallas-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .mallas-table tbody td:last-child {
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
        background-color: white !important;
        padding: 8px !important;
    }
    
    /* Asegurar que el gradiente se aplique correctamente */
    .mallas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .mallas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
";
        yield from [];
    }

    // line 217
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 218
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Mallas de Carreras</h1>
        <a href=\"";
        // line 221
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "dashboard\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 226
        if (($context["swal"] ?? null)) {
            // line 227
            yield "    <script>
        Swal.fire({
            icon: '";
            // line 229
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 229), "html", null, true);
            yield "',
            title: '";
            // line 230
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 230), "html", null, true);
            yield "',
            text: '";
            // line 231
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 231), "html", null, true);
            yield "',
            confirmButtonText: 'Aceptar'
        });
    </script>
    ";
        }
        // line 236
        yield "
    ";
        // line 237
        if (($context["success"] ?? null)) {
            // line 238
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 239
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 243
        yield "
    ";
        // line 244
        if (($context["error"] ?? null)) {
            // line 245
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 246
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 250
        yield "
    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 257
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"busqueda\" class=\"form-label\">Búsqueda</label>
                    <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                           value=\"";
        // line 261
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "busqueda", [], "any", false, false, false, 261), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre o código (ignora acentos, mayúsculas y orden de palabras)...\">
                    <small class=\"form-text text-muted\">
                        <i class=\"fas fa-info-circle\"></i>
                        La búsqueda ignora acentos, mayúsculas/minúsculas y permite palabras en cualquier orden.
                    </small>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa</label>
                    <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"P\" ";
        // line 271
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 271) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                        <option value=\"G\" ";
        // line 272
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 272) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                        <option value=\"O\" ";
        // line 273
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 273) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        ";
        // line 280
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 281
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 281), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 281) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 281))) {
                yield "selected";
            }
            yield ">
                                ";
            // line 282
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 282), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 285
        yield "                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 291
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 291) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 292
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 292) == "0")) {
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
        // line 301
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "mallas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 319
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 319));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 320
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 320) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 321
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 324
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 327
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 327), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 327), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover mallas-table\">
                    <thead>
                        <tr>
                            <th>Código(s)</th>
                            <th>
                                <a href=\"";
        // line 338
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 338), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 338), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 338), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 338)), "html", null, true);
        yield "\">
                                    Nombre
                                    <i class=\"fas ";
        // line 340
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 340), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 340)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>Vigencia Desde</th>
                            <th>Vigencia Hasta</th>
                            <th>
                                <a href=\"";
        // line 346
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 346), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 346), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 346), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 346)), "html", null, true);
        yield "\">
                                    Tipo de Programa
                                    <i class=\"fas ";
        // line 348
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 348), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 348)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 352
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 352), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 352), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 352), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 352)), "html", null, true);
        yield "\">
                                    Sede
                                    <i class=\"fas ";
        // line 354
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 354), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 354)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 358
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 358), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 358), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 358), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 358)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 360
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 360), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 360)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 367
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 368
            yield "                        <tr>
                            <td>
                                ";
            // line 370
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "codigos_carrera", [], "any", false, false, false, 370));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["codigo"]) {
                // line 371
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["codigo"], "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 371)) {
                    yield "<br>";
                }
                // line 372
                yield "                                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['codigo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 373
            yield "                            </td>
                            <td>";
            // line 374
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 374), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 376
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencias_desde", [], "any", false, false, false, 376));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["vig"]) {
                // line 377
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["vig"], "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 377)) {
                    yield "<br>";
                }
                // line 378
                yield "                                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['vig'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 379
            yield "                            </td>
                            <td>
                                ";
            // line 381
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "vigencias_hasta", [], "any", false, false, false, 381));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["vig"]) {
                // line 382
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["vig"], "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 382)) {
                    yield "<br>";
                }
                // line 383
                yield "                                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['vig'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 384
            yield "                            </td>
                            <td>
                                ";
            // line 386
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 386) == "P")) {
                // line 387
                yield "                                    Pregrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 388
$context["carrera"], "tipo_programa", [], "any", false, false, false, 388) == "G")) {
                // line 389
                yield "                                    Postgrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 390
$context["carrera"], "tipo_programa", [], "any", false, false, false, 390) == "O")) {
                // line 391
                yield "                                    Otro
                                ";
            } else {
                // line 393
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 393), "html", null, true);
                yield "
                                ";
            }
            // line 395
            yield "                            </td>
                            <td>
                                ";
            // line 397
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes", [], "any", false, false, false, 397));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 398
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["sede"], "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 398)) {
                    yield "<br>";
                }
                // line 399
                yield "                                ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 400
            yield "                            </td>
                            <td class=\"text-center\">
                                ";
            // line 402
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "estado", [], "any", false, false, false, 402) == 1)) {
                // line 403
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 405
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 407
            yield "                            </td>
                            <td class=\"text-align: center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"";
            // line 410
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "mallas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 410), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\" title=\"Ver Carrera\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 413
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "mallas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 413), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar Malla\">
                                        <i class=\"fas fa-sitemap\"></i>
                                    </a>
                                    <a href=\"";
            // line 416
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "mallas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 416), "html", null, true);
            yield "/fusion-asignaturas\" class=\"btn btn-sm btn-warning\" title=\"Fusionar Asignaturas\">
                                        <i class=\"fas fa-object-group\"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 422
        if (!$context['_iterated']) {
            // line 423
            yield "                        <tr>
                            <td colspan=\"8\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 427
        yield "                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            ";
        // line 432
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 432) > 1)) {
            // line 433
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 436
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 436)) {
                // line 437
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 438
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 438), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 438), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 438), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 438)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 443
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 447
            yield "
                    <!-- Números de página -->
                    ";
            // line 449
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 449) - 2));
            // line 450
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 450), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 450) + 2));
            // line 451
            yield "
                    ";
            // line 452
            if ((($context["start_page"] ?? null) > 1)) {
                // line 453
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 454
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 454), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 454), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 454)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 456
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 457
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 461
                yield "                    ";
            }
            // line 462
            yield "
                    ";
            // line 463
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 464
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 464))) {
                    // line 465
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 466
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 469
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 470
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 470), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 470), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 470)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 473
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 474
            yield "
                    ";
            // line 475
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 475))) {
                // line 476
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 476) - 1))) {
                    // line 477
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 481
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 482
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 482), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 482), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 482), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 482)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 482), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 485
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 487
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 487)) {
                // line 488
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 489
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 489), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 489), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 489), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 489)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 494
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 498
            yield "                </ul>
            </nav>
            ";
        }
        // line 501
        yield "        </div>
    </div>
</div>

<script>
    // Manejar cambio de registros por página
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

    // Manejar envío del formulario de filtros
    document.querySelector('form[method=\"GET\"]').addEventListener('submit', function(e) {
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
    document.querySelectorAll('select[name=\"tipo_programa\"], select[name=\"sede\"], select[name=\"estado\"]').forEach(select => {
        select.addEventListener('change', function() {
            // Solo aplicar automáticamente si no es el campo de búsqueda (que requiere confirmación del usuario)
            if (this.name !== 'busqueda') {
                document.querySelector('form[method=\"GET\"]').dispatchEvent(new Event('submit'));
            }
        });
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
        return "mallas/index.twig";
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
        return array (  990 => 501,  985 => 498,  979 => 494,  971 => 489,  968 => 488,  966 => 487,  962 => 485,  954 => 482,  951 => 481,  945 => 477,  942 => 476,  940 => 475,  937 => 474,  931 => 473,  923 => 470,  920 => 469,  914 => 466,  911 => 465,  908 => 464,  904 => 463,  901 => 462,  898 => 461,  892 => 457,  890 => 456,  885 => 454,  882 => 453,  880 => 452,  877 => 451,  874 => 450,  872 => 449,  868 => 447,  862 => 443,  854 => 438,  851 => 437,  849 => 436,  844 => 433,  842 => 432,  835 => 427,  826 => 423,  824 => 422,  811 => 416,  803 => 413,  795 => 410,  790 => 407,  786 => 405,  782 => 403,  780 => 402,  776 => 400,  762 => 399,  756 => 398,  739 => 397,  735 => 395,  729 => 393,  725 => 391,  723 => 390,  720 => 389,  718 => 388,  715 => 387,  713 => 386,  709 => 384,  695 => 383,  689 => 382,  672 => 381,  668 => 379,  654 => 378,  648 => 377,  631 => 376,  626 => 374,  623 => 373,  609 => 372,  603 => 371,  586 => 370,  582 => 368,  577 => 367,  567 => 360,  562 => 358,  555 => 354,  550 => 352,  543 => 348,  538 => 346,  529 => 340,  524 => 338,  508 => 327,  503 => 324,  494 => 321,  485 => 320,  481 => 319,  460 => 301,  446 => 292,  440 => 291,  432 => 285,  423 => 282,  414 => 281,  410 => 280,  398 => 273,  392 => 272,  386 => 271,  373 => 261,  366 => 257,  357 => 250,  350 => 246,  347 => 245,  345 => 244,  342 => 243,  335 => 239,  332 => 238,  330 => 237,  327 => 236,  319 => 231,  315 => 230,  311 => 229,  307 => 227,  305 => 226,  297 => 221,  292 => 218,  285 => 217,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Mallas - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de mallas */
    .mallas-table thead th {
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
    
    .mallas-table thead th:first-child {
        min-width: 100px !important;
        width: 100px !important;
    }
    
    .mallas-table thead th:nth-child(2) {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .mallas-table thead th:nth-child(3) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .mallas-table thead th:nth-child(4) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .mallas-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .mallas-table thead th:last-child {
        min-width: 150px !important;
        width: 150px !important;
    }
    
    .mallas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .mallas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .mallas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .mallas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .mallas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .mallas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .mallas-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .mallas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    /* Estilos para el botón de fusionar asignaturas */
    .btn-warning.btn-sm {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
        color: #212529 !important;
        font-size: 0.75rem !important;
        padding: 0.25rem 0.5rem !important;
        transition: all 0.3s ease !important;
    }
    
    .btn-warning.btn-sm:hover {
        background-color: #e0a800 !important;
        border-color: #d39e00 !important;
        color: #212529 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15) !important;
    }
    
    .btn-warning.btn-sm:active {
        transform: translateY(0) !important;
    }
    
    .mallas-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .mallas-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .mallas-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .mallas-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .mallas-table tbody td:last-child {
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
        background-color: white !important;
        padding: 8px !important;
    }
    
    /* Asegurar que el gradiente se aplique correctamente */
    .mallas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .mallas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Mallas de Carreras</h1>
        <a href=\"{{ app_url }}dashboard\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if swal %}
    <script>
        Swal.fire({
            icon: '{{ swal.icon }}',
            title: '{{ swal.title }}',
            text: '{{ swal.text }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
    {% endif %}

    {% if success %}
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        {{ success }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    {% if error %}
    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        {{ error }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}mallas\" class=\"row g-3\">
                <div class=\"col-md-3\">
                    <label for=\"busqueda\" class=\"form-label\">Búsqueda</label>
                    <input type=\"text\" class=\"form-control\" id=\"busqueda\" name=\"busqueda\" 
                           value=\"{{ filtros.busqueda }}\" placeholder=\"Buscar por nombre o código (ignora acentos, mayúsculas y orden de palabras)...\">
                    <small class=\"form-text text-muted\">
                        <i class=\"fas fa-info-circle\"></i>
                        La búsqueda ignora acentos, mayúsculas/minúsculas y permite palabras en cualquier orden.
                    </small>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"tipo_programa\" class=\"form-label\">Tipo de Programa</label>
                    <select class=\"form-select\" id=\"tipo_programa\" name=\"tipo_programa\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"P\" {% if filtros.tipo_programa == 'P' %}selected{% endif %}>Pregrado</option>
                        <option value=\"G\" {% if filtros.tipo_programa == 'G' %}selected{% endif %}>Postgrado</option>
                        <option value=\"O\" {% if filtros.tipo_programa == 'O' %}selected{% endif %}>Otro</option>
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"sede\" class=\"form-label\">Sede</label>
                    <select class=\"form-select\" id=\"sede\" name=\"sede\">
                        <option value=\"\">Todas las sedes</option>
                        {% for sede in sedes %}
                            <option value=\"{{ sede.id }}\" {% if filtros.sede == sede.id %}selected{% endif %}>
                                {{ sede.nombre }}
                            </option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-3\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                    </select>
                </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}mallas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
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
                <table class=\"table table-striped table-hover mallas-table\">
                    <thead>
                        <tr>
                            <th>Código(s)</th>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>Vigencia Desde</th>
                            <th>Vigencia Hasta</th>
                            <th>
                                <a href=\"{{ build_sort_url('tipo_programa', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipo de Programa
                                    <i class=\"fas {{ get_sort_icon('tipo_programa', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('sede', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Sede
                                    <i class=\"fas {{ get_sort_icon('sede', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
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
                        {% for carrera in carreras %}
                        <tr>
                            <td>
                                {% for codigo in carrera.codigos_carrera %}
                                    {{ codigo }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td>{{ carrera.nombre }}</td>
                            <td>
                                {% for vig in carrera.vigencias_desde %}
                                    {{ vig }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td>
                                {% for vig in carrera.vigencias_hasta %}
                                    {{ vig }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td>
                                {% if carrera.tipo_programa == 'P' %}
                                    Pregrado
                                {% elseif carrera.tipo_programa == 'G' %}
                                    Postgrado
                                {% elseif carrera.tipo_programa == 'O' %}
                                    Otro
                                {% else %}
                                    {{ carrera.tipo_programa }}
                                {% endif %}
                            </td>
                            <td>
                                {% for sede in carrera.sedes %}
                                    {{ sede }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td class=\"text-center\">
                                {% if carrera.estado == 1 %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td class=\"text-align: center\">
                                <div class=\"d-flex gap-2 justify-content-center\">
                                    <a href=\"{{ app_url }}mallas/{{ carrera.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver Carrera\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}mallas/{{ carrera.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar Malla\">
                                        <i class=\"fas fa-sitemap\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}mallas/{{ carrera.id }}/fusion-asignaturas\" class=\"btn btn-sm btn-warning\" title=\"Fusionar Asignaturas\">
                                        <i class=\"fas fa-object-group\"></i>
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

<script>
    // Manejar cambio de registros por página
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

    // Manejar envío del formulario de filtros
    document.querySelector('form[method=\"GET\"]').addEventListener('submit', function(e) {
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
    document.querySelectorAll('select[name=\"tipo_programa\"], select[name=\"sede\"], select[name=\"estado\"]').forEach(select => {
        select.addEventListener('change', function() {
            // Solo aplicar automáticamente si no es el campo de búsqueda (que requiere confirmación del usuario)
            if (this.name !== 'busqueda') {
                document.querySelector('form[method=\"GET\"]').dispatchEvent(new Event('submit'));
            }
        });
    });
</script>
{% endblock %} ", "mallas/index.twig", "/var/www/html/biblioges/templates/mallas/index.twig");
    }
}
