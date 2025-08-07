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

/* asignaturas/index.twig */
class __TwigTemplate_1e815bd89ad0d729e990e1c9122cd56e extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Asignaturas - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de asignaturas */
    .asignaturas-table thead th {
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
    
    .asignaturas-table thead th:first-child {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .asignaturas-table thead th:nth-child(2) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .asignaturas-table thead th:nth-child(3) {
        min-width: 120px !important;
        width: 12% !important;
    }
    
    .asignaturas-table thead th:nth-child(4) {
        min-width: 120px !important;
        width: 12% !important;
    }
    
    .asignaturas-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .asignaturas-table thead th:nth-child(6) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .asignaturas-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .asignaturas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .asignaturas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .asignaturas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .asignaturas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .asignaturas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .asignaturas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .asignaturas-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .asignaturas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .asignaturas-table tbody td:nth-child(2) {
        color: #6c757d !important;
    }
    
    .asignaturas-table tbody td:nth-child(3) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .asignaturas-table tbody td:nth-child(4) {
        color: #495057 !important;
    }
    
    .asignaturas-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .asignaturas-table tbody td:nth-child(6) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .asignaturas-table tbody td:last-child {
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
    .asignaturas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .asignaturas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
";
        yield from [];
    }

    // line 204
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 205
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"";
        // line 209
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"";
        // line 212
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 224
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"nombre\" class=\"form-label\">Nombre</label>
                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 227
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", true, true, false, 227)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", false, false, false, 227), "")) : ("")), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre...\">
                </div>
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" ";
        // line 233
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 233) == "REGULAR")) {
            yield "selected";
        }
        yield ">Regular</option>
                        <option value=\"FORMACION_BASICA\" ";
        // line 234
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 234) == "FORMACION_BASICA")) {
            yield "selected";
        }
        yield ">Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" ";
        // line 235
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 235) == "FORMACION_GENERAL")) {
            yield "selected";
        }
        yield ">Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" ";
        // line 236
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 236) == "FORMACION_IDIOMAS")) {
            yield "selected";
        }
        yield ">Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" ";
        // line 237
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 237) == "FORMACION_PROFESIONAL")) {
            yield "selected";
        }
        yield ">Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" ";
        // line 238
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 238) == "FORMACION_VALORES")) {
            yield "selected";
        }
        yield ">Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" ";
        // line 239
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 239) == "FORMACION_ESPECIALIDAD")) {
            yield "selected";
        }
        yield ">Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" ";
        // line 240
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 240) == "FORMACION_ELECTIVA")) {
            yield "selected";
        }
        yield ">Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" ";
        // line 241
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo", [], "any", false, false, false, 241) == "FORMACION_ESPECIAL")) {
            yield "selected";
        }
        yield ">Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"unidad\" class=\"form-label\">Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" name=\"unidad\" style=\"font-size: 0.85rem;\">
                        <option value=\"\">Todas las unidades</option>
                        ";
        // line 248
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["unidad"]) {
            // line 249
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 249), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "unidad", [], "any", false, false, false, 249) == CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "id", [], "any", false, false, false, 249))) {
                yield "selected";
            }
            yield " style=\"font-size: 0.85rem;\">
                                ";
            // line 250
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad"], "unidad_completa", [], "any", false, false, false, 250), "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['unidad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 253
        yield "                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"estado\" class=\"form-label\">Estado</label>
                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                        <option value=\"\">Todos</option>
                        <option value=\"1\" ";
        // line 259
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 259) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                        <option value=\"0\" ";
        // line 260
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 260) == "0")) {
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
        // line 269
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Asignaturas</h6>
            <div class=\"d-flex align-items-center gap-3\">
                <!-- Selector de registros por página -->
                <div class=\"d-flex align-items-center gap-2 per-page-selector\">
                    <label for=\"per_page\" class=\"form-label mb-0\">Registros por página:</label>
                    <select id=\"per_page\" class=\"form-select form-select-sm\" style=\"width: auto;\">
                        ";
        // line 287
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 287));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 288
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 288) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 289
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 292
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 295
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 295), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 295), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered asignaturas-table\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"";
        // line 305
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 305), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 305), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 305), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 305)), "html", null, true);
        yield "\">
                                    Nombre
                                    <i class=\"fas ";
        // line 307
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 307), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 307)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 311
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 311), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 311)), "html", null, true);
        yield "\">
                                    Tipo
                                    <i class=\"fas ";
        // line 313
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 313), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 313)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>Vigencia</th>
                            <th>
                                <a href=\"";
        // line 318
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("periodicidad", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 318), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 318), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 318), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 318)), "html", null, true);
        yield "\">
                                    Periodicidad
                                    <i class=\"fas ";
        // line 320
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("periodicidad", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 320), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 320)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 324
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 324), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 324), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 324), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 324)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 326
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 326), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 326)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 330
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("unidad", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 330), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 330), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 330), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 330)), "html", null, true);
        yield "\">
                                    Unidades
                                    <i class=\"fas ";
        // line 332
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("unidad", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 332), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 332)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 339
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 340
            yield "                        <tr>
                            <td>";
            // line 341
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 341), "html", null, true);
            yield "</td>
                            <td>";
            // line 342
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 342), "html", null, true);
            yield "</td>
                            <td>";
            // line 343
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_desde", [], "any", false, false, false, 343), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "vigencia_hasta", [], "any", false, false, false, 343), "html", null, true);
            yield "</td>
                            <td>";
            // line 344
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 344), "html", null, true);
            yield "</td>
                            <td>
                                <span class=\"badge bg-";
            // line 346
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 346) == "1")) ? ("success") : ("danger"));
            yield "\">
                                    ";
            // line 347
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "estado", [], "any", false, false, false, 347) == "1")) ? ("Activo") : ("Inactivo"));
            yield "
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">";
            // line 350
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "unidades", [], "any", true, true, false, 350)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "unidades", [], "any", false, false, false, 350), "Sin unidad")) : ("Sin unidad")), "html", null, true);
            yield "</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"";
            // line 353
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 353), "html", null, true);
            yield "\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 356
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 356), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 359
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 359), "html", null, true);
            yield "/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 367
        if (!$context['_iterated']) {
            // line 368
            yield "                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 372
        yield "                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            ";
        // line 377
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 377) > 1)) {
            // line 378
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 381
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 381)) {
                // line 382
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 383
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 383), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 383), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 383), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 383)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 388
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 392
            yield "
                    <!-- Números de página -->
                    ";
            // line 394
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 394) - 2));
            // line 395
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 395), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 395) + 2));
            // line 396
            yield "
                    ";
            // line 397
            if ((($context["start_page"] ?? null) > 1)) {
                // line 398
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 399
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 399), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 399), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 399)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 401
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 402
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 406
                yield "                    ";
            }
            // line 407
            yield "
                    ";
            // line 408
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 409
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 409))) {
                    // line 410
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 411
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 414
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 415
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 415), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 415), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 415)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 418
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 419
            yield "
                    ";
            // line 420
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 420))) {
                // line 421
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 421) - 1))) {
                    // line 422
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 426
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 427
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 427), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 427), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 427), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 427)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 427), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 430
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 432
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 432)) {
                // line 433
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 434
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 434), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 434), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 434), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 434)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 439
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 443
            yield "                </ul>
            </nav>
            ";
        }
        // line 446
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
</script>
";
        yield from [];
    }

    // line 468
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 469
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el envío del formulario de eliminación
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar la solicitud AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            // Determinar el tipo de icono basado en el tipo de respuesta
                            let icon = 'error';
                            if (data.type === 'warning') {
                                icon = 'warning';
                            } else if (data.type === 'info') {
                                icon = 'info';
                            }
                            
                            Swal.fire({
                                title: data.type === 'warning' ? 'Advertencia' : 'Error',
                                text: data.message,
                                icon: icon,
                                confirmButtonColor: data.type === 'warning' ? '#ffc107' : '#d33',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        });
    });

    // Mostrar mensajes de éxito o error si existen y limpiarlos
    ";
        // line 566
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 566)) {
            // line 567
            yield "        Swal.fire({
            title: '¡Éxito!',
            text: '";
            // line 569
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 569), "html", null, true);
            yield "',
            icon: 'success',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('";
            // line 575
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    ";
        }
        // line 583
        yield "
    ";
        // line 584
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 584)) {
            // line 585
            yield "        Swal.fire({
            title: 'Error',
            text: '";
            // line 587
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 587), "html", null, true);
            yield "',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('";
            // line 593
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    ";
        }
        // line 601
        yield "});
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "asignaturas/index.twig";
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
        return array (  985 => 601,  974 => 593,  965 => 587,  961 => 585,  959 => 584,  956 => 583,  945 => 575,  936 => 569,  932 => 567,  930 => 566,  831 => 469,  824 => 468,  799 => 446,  794 => 443,  788 => 439,  780 => 434,  777 => 433,  775 => 432,  771 => 430,  763 => 427,  760 => 426,  754 => 422,  751 => 421,  749 => 420,  746 => 419,  740 => 418,  732 => 415,  729 => 414,  723 => 411,  720 => 410,  717 => 409,  713 => 408,  710 => 407,  707 => 406,  701 => 402,  699 => 401,  694 => 399,  691 => 398,  689 => 397,  686 => 396,  683 => 395,  681 => 394,  677 => 392,  671 => 388,  663 => 383,  660 => 382,  658 => 381,  653 => 378,  651 => 377,  644 => 372,  635 => 368,  633 => 367,  618 => 359,  610 => 356,  602 => 353,  596 => 350,  590 => 347,  586 => 346,  581 => 344,  575 => 343,  571 => 342,  567 => 341,  564 => 340,  559 => 339,  549 => 332,  544 => 330,  537 => 326,  532 => 324,  525 => 320,  520 => 318,  512 => 313,  507 => 311,  500 => 307,  495 => 305,  480 => 295,  475 => 292,  466 => 289,  457 => 288,  453 => 287,  432 => 269,  418 => 260,  412 => 259,  404 => 253,  395 => 250,  386 => 249,  382 => 248,  370 => 241,  364 => 240,  358 => 239,  352 => 238,  346 => 237,  340 => 236,  334 => 235,  328 => 234,  322 => 233,  313 => 227,  307 => 224,  292 => 212,  286 => 209,  280 => 205,  273 => 204,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Asignaturas - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de asignaturas */
    .asignaturas-table thead th {
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
    
    .asignaturas-table thead th:first-child {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .asignaturas-table thead th:nth-child(2) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .asignaturas-table thead th:nth-child(3) {
        min-width: 120px !important;
        width: 12% !important;
    }
    
    .asignaturas-table thead th:nth-child(4) {
        min-width: 120px !important;
        width: 12% !important;
    }
    
    .asignaturas-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .asignaturas-table thead th:nth-child(6) {
        min-width: 200px !important;
        width: 20% !important;
    }
    
    .asignaturas-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .asignaturas-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .asignaturas-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .asignaturas-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .asignaturas-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .asignaturas-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .asignaturas-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .asignaturas-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .asignaturas-table tbody td:first-child {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .asignaturas-table tbody td:nth-child(2) {
        color: #6c757d !important;
    }
    
    .asignaturas-table tbody td:nth-child(3) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .asignaturas-table tbody td:nth-child(4) {
        color: #495057 !important;
    }
    
    .asignaturas-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .asignaturas-table tbody td:nth-child(6) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .asignaturas-table tbody td:last-child {
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
    .asignaturas-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .asignaturas-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Asignaturas</h1>
        <div>
            <a href=\"{{ app_url }}asignaturas/vinculacion\" class=\"btn btn-info me-2\">
                <i class=\"fas fa-link\"></i> Vincular Asignaturas Electivas
            </a>
        <a href=\"{{ app_url }}asignaturas/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Asignatura
        </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}asignaturas\" class=\"row g-3\">
                <div class=\"col-md-4\">
                    <label for=\"nombre\" class=\"form-label\">Nombre</label>
                    <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ filtros.nombre|default('') }}\" placeholder=\"Buscar por nombre...\">
                </div>
                <div class=\"col-md-4\">
                    <label for=\"tipo\" class=\"form-label\">Tipo</label>
                    <select class=\"form-select\" id=\"tipo\" name=\"tipo\">
                        <option value=\"\">Todos los tipos</option>
                        <option value=\"REGULAR\" {% if filtros.tipo == 'REGULAR' %}selected{% endif %}>Regular</option>
                        <option value=\"FORMACION_BASICA\" {% if filtros.tipo == 'FORMACION_BASICA' %}selected{% endif %}>Formación Básica</option>
                        <option value=\"FORMACION_GENERAL\" {% if filtros.tipo == 'FORMACION_GENERAL' %}selected{% endif %}>Formación General</option>
                        <option value=\"FORMACION_IDIOMAS\" {% if filtros.tipo == 'FORMACION_IDIOMAS' %}selected{% endif %}>Formación Idiomas</option>
                        <option value=\"FORMACION_PROFESIONAL\" {% if filtros.tipo == 'FORMACION_PROFESIONAL' %}selected{% endif %}>Formación Profesional</option>
                        <option value=\"FORMACION_VALORES\" {% if filtros.tipo == 'FORMACION_VALORES' %}selected{% endif %}>Formación Valores</option>
                        <option value=\"FORMACION_ESPECIALIDAD\" {% if filtros.tipo == 'FORMACION_ESPECIALIDAD' %}selected{% endif %}>Formación Especialidad</option>
                        <option value=\"FORMACION_ELECTIVA\" {% if filtros.tipo == 'FORMACION_ELECTIVA' %}selected{% endif %}>Formación Electiva</option>
                        <option value=\"FORMACION_ESPECIAL\" {% if filtros.tipo == 'FORMACION_ESPECIAL' %}selected{% endif %}>Formación Especial</option>
                    </select>
                </div>
                <div class=\"col-md-4\">
                    <label for=\"unidad\" class=\"form-label\">Unidad</label>
                    <select class=\"form-select\" id=\"unidad\" name=\"unidad\" style=\"font-size: 0.85rem;\">
                        <option value=\"\">Todas las unidades</option>
                        {% for unidad in unidades %}
                            <option value=\"{{ unidad.id }}\" {% if filtros.unidad == unidad.id %}selected{% endif %} style=\"font-size: 0.85rem;\">
                                {{ unidad.unidad_completa }}
                            </option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-4\">
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
                        <a href=\"{{ app_url }}asignaturas/clear-state\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de asignaturas -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Asignaturas</h6>
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
                <table class=\"table table-bordered asignaturas-table\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('tipo', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipo
                                    <i class=\"fas {{ get_sort_icon('tipo', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>Vigencia</th>
                            <th>
                                <a href=\"{{ build_sort_url('periodicidad', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Periodicidad
                                    <i class=\"fas {{ get_sort_icon('periodicidad', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('unidad', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Unidades
                                    <i class=\"fas {{ get_sort_icon('unidad', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for asignatura in asignaturas %}
                        <tr>
                            <td>{{ asignatura.nombre }}</td>
                            <td>{{ asignatura.tipo }}</td>
                            <td>{{ asignatura.vigencia_desde }} - {{ asignatura.vigencia_hasta }}</td>
                            <td>{{ asignatura.periodicidad }}</td>
                            <td>
                                <span class=\"badge bg-{{ asignatura.estado == '1' ? 'success' : 'danger' }}\">
                                    {{ asignatura.estado == '1' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td style=\"white-space: pre-line\">{{ asignatura.unidades|default('Sin unidad') }}</td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}\" class=\"btn btn-sm btn-primary\" title=\"Ver\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}asignaturas/{{ asignatura.id }}/edit\" class=\"btn btn-sm btn-warning\" title=\"Editar\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}asignaturas/{{ asignatura.id }}/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"7\" class=\"text-center\">No se encontraron asignaturas</td>
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
</script>
{% endblock %}

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el envío del formulario de eliminación
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar indicador de carga
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar la solicitud AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            // Determinar el tipo de icono basado en el tipo de respuesta
                            let icon = 'error';
                            if (data.type === 'warning') {
                                icon = 'warning';
                            } else if (data.type === 'info') {
                                icon = 'info';
                            }
                            
                            Swal.fire({
                                title: data.type === 'warning' ? 'Advertencia' : 'Error',
                                text: data.message,
                                icon: icon,
                                confirmButtonColor: data.type === 'warning' ? '#ffc107' : '#d33',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        // Cerrar el indicador de carga
                        Swal.close();
                        
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        });
    });

    // Mostrar mensajes de éxito o error si existen y limpiarlos
    {% if session.success %}
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session.success }}',
            icon: 'success',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    {% endif %}

    {% if session.error %}
        Swal.fire({
            title: 'Error',
            text: '{{ session.error }}',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Limpiar el mensaje de sesión
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    {% endif %}
});
</script>
{% endblock %} ", "asignaturas/index.twig", "/var/www/html/biblioges/templates/asignaturas/index.twig");
    }
}
