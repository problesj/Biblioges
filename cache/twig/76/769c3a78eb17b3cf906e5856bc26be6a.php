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

/* carreras/index.twig */
class __TwigTemplate_ed3e3da13d7985b417858c2bf3734227 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Carreras - Sistema de Bibliografía";
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
    /* Estilos personalizados para la tabla de carreras */
    .carreras-table thead th {
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
    
    .carreras-table thead th:first-child {
        min-width: 100px !important;
        width: 100px !important;
    }
    
    .carreras-table thead th:nth-child(2) {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .carreras-table thead th:nth-child(3) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .carreras-table thead th:nth-child(4) {
        min-width: 250px !important;
        width: 30% !important;
    }
    
    .carreras-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .carreras-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .carreras-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .carreras-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .carreras-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .carreras-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .carreras-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .carreras-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .carreras-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .carreras-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .carreras-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .carreras-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .carreras-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .carreras-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .carreras-table tbody td:last-child {
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
    .carreras-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .carreras-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
";
        yield from [];
    }

    // line 195
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 196
        yield "<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"";
        // line 199
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 210
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 215
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", false, false, false, 215), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\">Tipo de Programa</label>
                            <select class=\"form-control\" id=\"tipo_programa\" name=\"tipo_programa\">
                                <option value=\"\">Todos</option>
                                <option value=\"P\" ";
        // line 223
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 223) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                                <option value=\"G\" ";
        // line 224
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 224) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                                <option value=\"O\" ";
        // line 225
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 225) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas</option>
                                ";
        // line 234
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 235
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 235), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 235) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 235))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 235), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 237
        yield "                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" ";
        // line 245
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 245) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 246
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 246) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 256
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/clear-state\" class=\"btn btn-secondary\">
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
        // line 274
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "allowed_per_page", [], "any", false, false, false, 274));
        foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
            // line 275
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 275) == $context["option"])) {
                yield "selected";
            }
            yield ">
                                ";
            // line 276
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["option"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 279
        yield "                    </select>
                </div>
                <div class=\"records-counter\">
                    Mostrando ";
        // line 282
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 282), "html", null, true);
        yield " de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_records", [], "any", false, false, false, 282), "html", null, true);
        yield " registros
                </div>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover carreras-table\">
                    <thead>
                        <tr>
                            <th>Código(s)</th>
                            <th>
                                <a href=\"";
        // line 293
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 293), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 293), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 293), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 293)), "html", null, true);
        yield "\">
                                    Nombre
                                    <i class=\"fas ";
        // line 295
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("nombre", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 295), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 295)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 299
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 299), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 299), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 299), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 299)), "html", null, true);
        yield "\">
                                    Tipo de Programa
                                    <i class=\"fas ";
        // line 301
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("tipo_programa", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 301), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 301)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"";
        // line 305
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 305), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 305), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 305), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 305)), "html", null, true);
        yield "\">
                                    Sede-Unidad
                                    <i class=\"fas ";
        // line 307
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("sede", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 307), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 307)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"";
        // line 311
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_sort_url')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 311), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 311), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 311)), "html", null, true);
        yield "\">
                                    Estado
                                    <i class=\"fas ";
        // line 313
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('get_sort_icon')->getCallable()("estado", CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 313), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 313)), "html", null, true);
        yield "\"></i>
                                </a>
                            </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 320
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 321
            yield "                        <tr>
                            <td>";
            // line 322
            yield Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "codigos_carrera", [], "any", false, false, false, 322), ["," => "<br>"]);
            yield "</td>
                            <td>";
            // line 323
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 323), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 325
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 325) == "P")) {
                // line 326
                yield "                                    Pregrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 327
$context["carrera"], "tipo_programa", [], "any", false, false, false, 327) == "G")) {
                // line 328
                yield "                                    Postgrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 329
$context["carrera"], "tipo_programa", [], "any", false, false, false, 329) == "O")) {
                // line 330
                yield "                                    Otro
                                ";
            } else {
                // line 332
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 332), "html", null, true);
                yield "
                                ";
            }
            // line 334
            yield "                            </td>
                            <td>
                                ";
            // line 336
            $context["sedes"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes", [], "any", false, false, false, 336), ",");
            // line 337
            yield "                                ";
            $context["unidades"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "unidades", [], "any", false, false, false, 337), ",");
            // line 338
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["sedes"] ?? null)) - 1)));
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
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 339
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["sedes"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["unidades"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 339)) {
                    yield "<br>";
                }
                // line 340
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
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 341
            yield "                            </td>
                            <td class=\"text-center\">
                                ";
            // line 343
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "estado", [], "any", false, false, false, 343) == 1)) {
                // line 344
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 346
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 348
            yield "                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"";
            // line 351
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 351), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 354
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 354), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 357
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 357), "html", null, true);
            yield "/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-danger btn-sm\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 365
        if (!$context['_iterated']) {
            // line 366
            yield "                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 370
        yield "                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            ";
        // line 375
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 375) > 1)) {
            // line 376
            yield "            <nav aria-label=\"Navegación de páginas\">
                <ul class=\"pagination justify-content-center\">
                    <!-- Botón Anterior -->
                    ";
            // line 379
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_previous", [], "any", false, false, false, 379)) {
                // line 380
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 381
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "previous_page", [], "any", false, false, false, 381), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 381), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 381), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 381)), "html", null, true);
                yield "\">
                                <i class=\"fas fa-chevron-left\"></i> Anterior
                            </a>
                        </li>
                    ";
            } else {
                // line 386
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\"><i class=\"fas fa-chevron-left\"></i> Anterior</span>
                        </li>
                    ";
            }
            // line 390
            yield "
                    <!-- Números de página -->
                    ";
            // line 392
            $context["start_page"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 392) - 2));
            // line 393
            yield "                    ";
            $context["end_page"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 393), (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 393) + 2));
            // line 394
            yield "
                    ";
            // line 395
            if ((($context["start_page"] ?? null) > 1)) {
                // line 396
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 397
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(1, CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 397), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 397), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 397)), "html", null, true);
                yield "\">1</a>
                        </li>
                        ";
                // line 399
                if ((($context["start_page"] ?? null) > 2)) {
                    // line 400
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 404
                yield "                    ";
            }
            // line 405
            yield "
                    ";
            // line 406
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["start_page"] ?? null), ($context["end_page"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["page_num"]) {
                // line 407
                yield "                        ";
                if (($context["page_num"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "current_page", [], "any", false, false, false, 407))) {
                    // line 408
                    yield "                            <li class=\"page-item active\">
                                <span class=\"page-link\">";
                    // line 409
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</span>
                            </li>
                        ";
                } else {
                    // line 412
                    yield "                            <li class=\"page-item\">
                                <a class=\"page-link\" href=\"";
                    // line 413
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()($context["page_num"], CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 413), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 413), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 413)), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page_num"], "html", null, true);
                    yield "</a>
                            </li>
                        ";
                }
                // line 416
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['page_num'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 417
            yield "
                    ";
            // line 418
            if ((($context["end_page"] ?? null) < CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 418))) {
                // line 419
                yield "                        ";
                if ((($context["end_page"] ?? null) < (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 419) - 1))) {
                    // line 420
                    yield "                            <li class=\"page-item disabled\">
                                <span class=\"page-link\">...</span>
                            </li>
                        ";
                }
                // line 424
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 425
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 425), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 425), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 425), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 425)), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "total_pages", [], "any", false, false, false, 425), "html", null, true);
                yield "</a>
                        </li>
                    ";
            }
            // line 428
            yield "
                    <!-- Botón Siguiente -->
                    ";
            // line 430
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "has_next", [], "any", false, false, false, 430)) {
                // line 431
                yield "                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"";
                // line 432
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('build_page_url')->getCallable()(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "next_page", [], "any", false, false, false, 432), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "column", [], "any", false, false, false, 432), CoreExtension::getAttribute($this->env, $this->source, ($context["ordenamiento"] ?? null), "direction", [], "any", false, false, false, 432), ($context["filtros"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "per_page", [], "any", false, false, false, 432)), "html", null, true);
                yield "\">
                                Siguiente <i class=\"fas fa-chevron-right\"></i>
                            </a>
                        </li>
                    ";
            } else {
                // line 437
                yield "                        <li class=\"page-item disabled\">
                            <span class=\"page-link\">Siguiente <i class=\"fas fa-chevron-right\"></i></span>
                        </li>
                    ";
            }
            // line 441
            yield "                </ul>
            </nav>
            ";
        }
        // line 444
        yield "        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 449
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 450
        yield "<script>
    // Función para mostrar alertas
    function showAlert(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }

    // Mostrar alertas de sesión si existen
    ";
        // line 462
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 462)) {
            // line 463
            yield "        showAlert('¡Éxito!', '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 463), "html", null, true);
            yield "', 'success');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('";
            // line 465
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    ";
        }
        // line 473
        yield "
    ";
        // line 474
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 474)) {
            // line 475
            yield "        showAlert('Error', '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 475), "html", null, true);
            yield "', 'error');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('";
            // line 477
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    ";
        }
        // line 485
        yield "
    // Confirmación de eliminación con AJAX
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('¡Éxito!', data.message, 'success');
                            // Eliminar la fila de la tabla
                            form.closest('tr').remove();
                        } else {
                            showAlert('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                    });
                }
            });
        });
    });

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

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "carreras/index.twig";
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
        return array (  874 => 485,  863 => 477,  857 => 475,  855 => 474,  852 => 473,  841 => 465,  835 => 463,  833 => 462,  819 => 450,  812 => 449,  804 => 444,  799 => 441,  793 => 437,  785 => 432,  782 => 431,  780 => 430,  776 => 428,  768 => 425,  765 => 424,  759 => 420,  756 => 419,  754 => 418,  751 => 417,  745 => 416,  737 => 413,  734 => 412,  728 => 409,  725 => 408,  722 => 407,  718 => 406,  715 => 405,  712 => 404,  706 => 400,  704 => 399,  699 => 397,  696 => 396,  694 => 395,  691 => 394,  688 => 393,  686 => 392,  682 => 390,  676 => 386,  668 => 381,  665 => 380,  663 => 379,  658 => 376,  656 => 375,  649 => 370,  640 => 366,  638 => 365,  623 => 357,  615 => 354,  607 => 351,  602 => 348,  598 => 346,  594 => 344,  592 => 343,  588 => 341,  574 => 340,  566 => 339,  548 => 338,  545 => 337,  543 => 336,  539 => 334,  533 => 332,  529 => 330,  527 => 329,  524 => 328,  522 => 327,  519 => 326,  517 => 325,  512 => 323,  508 => 322,  505 => 321,  500 => 320,  490 => 313,  485 => 311,  478 => 307,  473 => 305,  466 => 301,  461 => 299,  454 => 295,  449 => 293,  433 => 282,  428 => 279,  419 => 276,  410 => 275,  406 => 274,  385 => 256,  370 => 246,  364 => 245,  354 => 237,  339 => 235,  335 => 234,  321 => 225,  315 => 224,  309 => 223,  298 => 215,  290 => 210,  276 => 199,  271 => 196,  264 => 195,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Carreras - Sistema de Bibliografía{% endblock %}

{% block head %}
<style>
    /* Estilos personalizados para la tabla de carreras */
    .carreras-table thead th {
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
    
    .carreras-table thead th:first-child {
        min-width: 100px !important;
        width: 100px !important;
    }
    
    .carreras-table thead th:nth-child(2) {
        min-width: 200px !important;
        width: 25% !important;
    }
    
    .carreras-table thead th:nth-child(3) {
        min-width: 150px !important;
        width: 15% !important;
    }
    
    .carreras-table thead th:nth-child(4) {
        min-width: 250px !important;
        width: 30% !important;
    }
    
    .carreras-table thead th:nth-child(5) {
        min-width: 100px !important;
        width: 10% !important;
    }
    
    .carreras-table thead th:last-child {
        min-width: 120px !important;
        width: 120px !important;
    }
    
    .carreras-table thead th a {
        color: white !important;
        text-decoration: none !important;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        transition: all 0.3s ease !important;
        padding: 8px !important;
        border-radius: 4px !important;
    }
    
    .carreras-table thead th a:hover {
        background: linear-gradient(135deg, #224abe 0%, #1a3a8f 100%) !important;
        color: #f8f9fc !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .carreras-table thead th a:active {
        transform: translateY(0) !important;
    }
    
    .carreras-table thead th a .fas {
        margin-left: 6px !important;
        font-size: 0.75rem !important;
        opacity: 0.8 !important;
    }
    
    .carreras-table thead th a:hover .fas {
        opacity: 1 !important;
    }
    
    .carreras-table thead th.text-center {
        text-align: center !important;
    }
    
    /* Estilos para el contenido de la tabla */
    .carreras-table tbody td {
        font-size: 0.85rem !important;
        padding: 10px 8px !important;
        vertical-align: middle !important;
        line-height: 1.4 !important;
    }
    
    .carreras-table tbody td:first-child {
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .carreras-table tbody td:nth-child(2) {
        font-weight: 500 !important;
        color: #212529 !important;
    }
    
    .carreras-table tbody td:nth-child(3) {
        color: #6c757d !important;
    }
    
    .carreras-table tbody td:nth-child(4) {
        color: #495057 !important;
        font-size: 0.8rem !important;
    }
    
    .carreras-table tbody td:nth-child(5) {
        text-align: center !important;
    }
    
    .carreras-table tbody td:last-child {
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
    .carreras-table thead {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .carreras-table thead tr {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"{{ app_url }}carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}carreras\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ filtros.nombre }}\" placeholder=\"Buscar por nombre...\">
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
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas</option>
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
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}carreras/clear-state\" class=\"btn btn-secondary\">
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
                <table class=\"table table-striped table-hover carreras-table\">
                    <thead>
                        <tr>
                            <th>Código(s)</th>
                            <th>
                                <a href=\"{{ build_sort_url('nombre', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Nombre
                                    <i class=\"fas {{ get_sort_icon('nombre', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('tipo_programa', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Tipo de Programa
                                    <i class=\"fas {{ get_sort_icon('tipo_programa', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>
                                <a href=\"{{ build_sort_url('sede', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Sede-Unidad
                                    <i class=\"fas {{ get_sort_icon('sede', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th class=\"text-center\">
                                <a href=\"{{ build_sort_url('estado', ordenamiento.column, ordenamiento.direction, filtros, paginacion.current_page, paginacion.per_page) }}\">
                                    Estado
                                    <i class=\"fas {{ get_sort_icon('estado', ordenamiento.column, ordenamiento.direction) }}\"></i>
                                </a>
                            </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for carrera in carreras %}
                        <tr>
                            <td>{{ carrera.codigos_carrera|replace({',': '<br>'})|raw }}</td>
                            <td>{{ carrera.nombre }}</td>
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
                                {% set sedes = carrera.sedes|split(',') %}
                                {% set unidades = carrera.unidades|split(',') %}
                                {% for i in 0..sedes|length-1 %}
                                    {{ sedes[i] }} - {{ unidades[i] }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td class=\"text-center\">
                                {% if carrera.estado == 1 %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}carreras/{{ carrera.id }}/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-danger btn-sm\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
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
    // Función para mostrar alertas
    function showAlert(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }

    // Mostrar alertas de sesión si existen
    {% if session.success %}
        showAlert('¡Éxito!', '{{ session.success }}', 'success');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('{{ app_url }}clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    {% endif %}

    {% if session.error %}
        showAlert('Error', '{{ session.error }}', 'error');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('{{ app_url }}clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    {% endif %}

    // Confirmación de eliminación con AJAX
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('¡Éxito!', data.message, 'success');
                            // Eliminar la fila de la tabla
                            form.closest('tr').remove();
                        } else {
                            showAlert('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                    });
                }
            });
        });
    });

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
{% endblock %} ", "carreras/index.twig", "/var/www/html/biblioges/templates/carreras/index.twig");
    }
}
