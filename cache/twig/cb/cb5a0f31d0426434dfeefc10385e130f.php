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

/* autores/duplicados_globales.twig */
class __TwigTemplate_b2a37bbd8c432101c0aaa0ff0c6134dc extends Template
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
            'stylesheets' => [$this, 'block_stylesheets'],
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
        $this->parent = $this->loadTemplate("base.twig", "autores/duplicados_globales.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Búsqueda Global de Duplicados";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "    ";
        yield from $this->yieldParentBlock("stylesheets", $context, $blocks);
        yield "
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
    <style>
        .modal-progreso {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-progreso .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .modal-progreso .titulo {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }
        
        .modal-progreso .descripcion {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .modal-progreso .barra-progreso {
            width: 100%;
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .modal-progreso .progreso-fill {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 10px;
            transition: width 0.3s ease;
            width: 0%;
        }
        
        .modal-progreso .porcentaje {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }
        
        .modal-progreso .estado {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 12px;
            font-style: italic;
        }
        
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos para las acciones de fusión */
        .accion-radio {
            margin: 0;
            padding: 0;
        }
        
        .accion-radio .custom-control {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .accion-radio .custom-control-label {
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .accion-radio .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .table th {
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .btn-accion {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin: 0.1rem;
        }
    </style>
";
        yield from [];
    }

    // line 134
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 135
        yield "<!-- Modal de Progreso -->
<div id=\"modalProgreso\" class=\"modal-progreso\">
    <div class=\"modal-content\">
        <div class=\"titulo\">
            <i class=\"fas fa-search\"></i> Buscando Duplicados
        </div>
        <div class=\"descripcion\">
            Analizando autores para encontrar posibles duplicados...
        </div>
        <div class=\"barra-progreso\">
            <div class=\"progreso-fill\" id=\"progresoFill\"></div>
        </div>
        <div class=\"porcentaje\" id=\"porcentaje\">0%</div>
        <div class=\"estado\" id=\"estado\">
            <span class=\"spinner\"></span>Iniciando búsqueda...
        </div>
    </div>
</div>

<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Búsqueda Global de Duplicados</h3>
                </div>
                <div class=\"card-body\">
                    <!-- Formulario de búsqueda para fusión mejorada -->
                    <div class=\"row mb-4\">
                        <div class=\"col-md-8\">
                            <div class=\"card\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title\">Buscar Variaciones para Fusión</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form method=\"POST\" action=\"";
        // line 170
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/buscar-variaciones-fusion\" class=\"row g-3\">
                                        <div class=\"col-md-8\">
                                            <input type=\"text\" class=\"form-control\" name=\"termino_busqueda\" 
                                                   placeholder=\"Ingrese nombre, apellido o variación para buscar...\" required>
                                        </div>
                                        <div class=\"col-md-4\">
                                            <button type=\"submit\" class=\"btn btn-primary\">
                                                <i class=\"fas fa-search\"></i> Buscar Variaciones
                                            </button>
                                        </div>
                                    </form>
                                    <small class=\"text-muted\">
                                        <i class=\"fas fa-info-circle\"></i> 
                                        Busca autores por nombre, apellido o variaciones para fusionar duplicados con selección de acciones.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
        // line 189
        if (($context["error"] ?? null)) {
            // line 190
            yield "                        <div class=\"alert alert-danger alert-dismissible\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
                            ";
            // line 193
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
                        </div>
                    ";
        }
        // line 196
        yield "
                    ";
        // line 197
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["gruposDuplicados"] ?? null)) > 0)) {
            // line 198
            yield "                        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["gruposDuplicados"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["grupo"]) {
                // line 199
                yield "                            <div class=\"card mb-3\">
                                <div class=\"card-header bg-light\">
                                    <h5 class=\"mb-0\">Grupo ";
                // line 201
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 201), "html", null, true);
                yield "</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form action=\"";
                // line 204
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/fusionar-grupo\" method=\"POST\" class=\"grupo-form\">
                                        <input type=\"hidden\" name=\"grupo_id\" value=\"";
                // line 205
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 205), "html", null, true);
                yield "\">
                                        
                                        <div class=\"table-responsive\">
                                            <table class=\"table table-bordered table-striped\">
                                                <thead>
                                                    <tr>
                                                        <th style=\"width: 80px;\">Principal</th>
                                                        <th style=\"width: 80px;\">Mantener</th>
                                                        <th style=\"width: 100px;\">Convertir en Alias</th>
                                                        <th style=\"width: 80px;\">Eliminar</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>Género</th>
                                                        <th style=\"width: 100px;\">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                       id=\"autor_";
                // line 226
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 226), "id", [], "any", false, false, false, 226), "html", null, true);
                yield "\" 
                                                                       name=\"autor_principal\" 
                                                                       value=\"";
                // line 228
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 228), "id", [], "any", false, false, false, 228), "html", null, true);
                yield "\" required>
                                                                <label class=\"custom-control-label\" for=\"autor_";
                // line 229
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 229), "id", [], "any", false, false, false, 229), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"mantener_";
                // line 235
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 235), "id", [], "any", false, false, false, 235), "html", null, true);
                yield "\" 
                                                                       name=\"acciones_autores[";
                // line 236
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 236), "id", [], "any", false, false, false, 236), "html", null, true);
                yield "]\" 
                                                                       value=\"mantener\">
                                                                <label class=\"custom-control-label\" for=\"mantener_";
                // line 238
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 238), "id", [], "any", false, false, false, 238), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"alias_";
                // line 244
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 244), "id", [], "any", false, false, false, 244), "html", null, true);
                yield "\" 
                                                                       name=\"acciones_autores[";
                // line 245
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 245), "id", [], "any", false, false, false, 245), "html", null, true);
                yield "]\" 
                                                                       value=\"convertir_alias\">
                                                                <label class=\"custom-control-label\" for=\"alias_";
                // line 247
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 247), "id", [], "any", false, false, false, 247), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"eliminar_";
                // line 253
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 253), "id", [], "any", false, false, false, 253), "html", null, true);
                yield "\" 
                                                                       name=\"acciones_autores[";
                // line 254
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 254), "id", [], "any", false, false, false, 254), "html", null, true);
                yield "]\" 
                                                                       value=\"eliminar\">
                                                                <label class=\"custom-control-label\" for=\"eliminar_";
                // line 256
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 256), "id", [], "any", false, false, false, 256), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td>";
                // line 259
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 259), "nombres", [], "any", false, false, false, 259), "html", null, true);
                yield "</td>
                                                        <td>";
                // line 260
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 260), "apellidos", [], "any", false, false, false, 260), "html", null, true);
                yield "</td>
                                                        <td>";
                // line 261
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 261), "genero", [], "any", false, false, false, 261), "html", null, true);
                yield "</td>
                                                        <td class=\"text-center\">
                                                            <a href=\"";
                // line 263
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 263), "id", [], "any", false, false, false, 263), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-info btn-accion\">
                                                                <i class=\"fas fa-edit\"></i> Editar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    ";
                // line 268
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "duplicados", [], "any", false, false, false, 268));
                foreach ($context['_seq'] as $context["_key"] => $context["duplicado"]) {
                    // line 269
                    yield "                                                        <tr>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                           id=\"autor_";
                    // line 273
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 273), "html", null, true);
                    yield "\" 
                                                                           name=\"autor_principal\" 
                                                                           value=\"";
                    // line 275
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 275), "html", null, true);
                    yield "\" required>
                                                                    <label class=\"custom-control-label\" for=\"autor_";
                    // line 276
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 276), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"mantener_";
                    // line 282
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 282), "html", null, true);
                    yield "\" 
                                                                           name=\"acciones_autores[";
                    // line 283
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 283), "html", null, true);
                    yield "]\" 
                                                                           value=\"mantener\">
                                                                    <label class=\"custom-control-label\" for=\"mantener_";
                    // line 285
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 285), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"alias_";
                    // line 291
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 291), "html", null, true);
                    yield "\" 
                                                                           name=\"acciones_autores[";
                    // line 292
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 292), "html", null, true);
                    yield "]\" 
                                                                           value=\"convertir_alias\">
                                                                    <label class=\"custom-control-label\" for=\"alias_";
                    // line 294
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 294), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"eliminar_";
                    // line 300
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 300), "html", null, true);
                    yield "\" 
                                                                           name=\"acciones_autores[";
                    // line 301
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 301), "html", null, true);
                    yield "]\" 
                                                                           value=\"eliminar\">
                                                                    <label class=\"custom-control-label\" for=\"eliminar_";
                    // line 303
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 303), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td>";
                    // line 306
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "nombres", [], "any", false, false, false, 306), "html", null, true);
                    yield "</td>
                                                            <td>";
                    // line 307
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "apellidos", [], "any", false, false, false, 307), "html", null, true);
                    yield "</td>
                                                            <td>";
                    // line 308
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "genero", [], "any", false, false, false, 308), "html", null, true);
                    yield "</td>
                                                            <td class=\"text-center\">
                                                                <a href=\"";
                    // line 310
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "autores/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 310), "html", null, true);
                    yield "/edit\" class=\"btn btn-sm btn-info btn-accion\">
                                                                    <i class=\"fas fa-edit\"></i> Editar
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['duplicado'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 316
                yield "                                                </tbody>
                                            </table>
                                        </div>

                                        <div class=\"form-group mt-3\">
                                            <button type=\"submit\" class=\"btn btn-primary fusionar-grupo-btn\" disabled>
                                                <i class=\"fas fa-object-group\"></i> Fusionar Grupo
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        ";
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
            unset($context['_seq'], $context['_key'], $context['grupo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 329
            yield "
                        <div class=\"form-group\">
                            <a href=\"";
            // line 331
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    ";
        } else {
            // line 336
            yield "                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores duplicados en el sistema.
                        </div>
                        <a href=\"";
            // line 340
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                    ";
        }
        // line 344
        yield "                </div>
            </div>
        </div>
    </div>

    ";
        // line 350
        yield "    ";
        if ((array_key_exists("paginacion", $context) && (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 350) > 1))) {
            // line 351
            yield "    <div class=\"row mt-4\">
        <div class=\"col-md-6\">
            <p class=\"text-muted\">
                Mostrando página ";
            // line 354
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 354), "html", null, true);
            yield " de ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 354), "html", null, true);
            yield " 
                (";
            // line 355
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalGrupos", [], "any", false, false, false, 355), "html", null, true);
            yield " grupos de duplicados encontrados)
            </p>
        </div>
        <div class=\"col-md-6\">
            <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                <ul class=\"pagination mb-0\">
                    ";
            // line 362
            yield "                    <li class=\"page-item ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 362) == 1)) {
                yield "disabled";
            }
            yield "\">
                        <a class=\"page-link\" href=\"";
            // line 363
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/duplicados-globales?pagina=1\" aria-label=\"Primera\">
                            <i class=\"fas fa-angle-double-left\"></i>
                        </a>
                    </li>

                    ";
            // line 369
            yield "                    <li class=\"page-item ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 369) == 1)) {
                yield "disabled";
            }
            yield "\">
                        <a class=\"page-link\" href=\"";
            // line 370
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/duplicados-globales?pagina=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 370) - 1), "html", null, true);
            yield "\" aria-label=\"Anterior\">
                            <i class=\"fas fa-angle-left\"></i>
                        </a>
                    </li>

                    ";
            // line 376
            yield "                    ";
            $context["inicio"] = max(1, (CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 376) - 2));
            // line 377
            yield "                    ";
            $context["fin"] = min(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 377), (($context["inicio"] ?? null) + 4));
            // line 378
            yield "                    ";
            if (((($context["fin"] ?? null) - ($context["inicio"] ?? null)) < 4)) {
                // line 379
                yield "                        ";
                $context["inicio"] = max(1, (($context["fin"] ?? null) - 4));
                // line 380
                yield "                    ";
            }
            // line 381
            yield "
                    ";
            // line 382
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(($context["inicio"] ?? null), ($context["fin"] ?? null)));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 383
                yield "                        <li class=\"page-item ";
                if (($context["i"] == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 383))) {
                    yield "active";
                }
                yield "\">
                            <a class=\"page-link\" href=\"";
                // line 384
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/duplicados-globales?pagina=";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                yield "\">
                                ";
                // line 385
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["i"], "html", null, true);
                yield "
                            </a>
                        </li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 389
            yield "
                    ";
            // line 391
            yield "                    <li class=\"page-item ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 391) == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 391))) {
                yield "disabled";
            }
            yield "\">
                        <a class=\"page-link\" href=\"";
            // line 392
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/duplicados-globales?pagina=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 392) + 1), "html", null, true);
            yield "\" aria-label=\"Siguiente\">
                            <i class=\"fas fa-angle-right\"></i>
                        </a>
                    </li>

                    ";
            // line 398
            yield "                    <li class=\"page-item ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "pagina", [], "any", false, false, false, 398) == CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 398))) {
                yield "disabled";
            }
            yield "\">
                        <a class=\"page-link\" href=\"";
            // line 399
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/duplicados-globales?pagina=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["paginacion"] ?? null), "totalPaginas", [], "any", false, false, false, 399), "html", null, true);
            yield "\" aria-label=\"Última\">
                            <i class=\"fas fa-angle-double-right\"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    ";
        }
        // line 408
        yield "</div>
";
        yield from [];
    }

    // line 411
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 412
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables para la modal de progreso
        const modalProgreso = document.getElementById('modalProgreso');
        const progresoFill = document.getElementById('progresoFill');
        const porcentaje = document.getElementById('porcentaje');
        const estado = document.getElementById('estado');
        
        // Verificar que todos los elementos estén disponibles
        console.log('Elementos de modal encontrados:', {
            modalProgreso: !!modalProgreso,
            progresoFill: !!progresoFill,
            porcentaje: !!porcentaje,
            estado: !!estado
        });
        
        // Función para mostrar la modal de progreso
        function mostrarProgreso() {
            console.log('Mostrando modal de progreso');
            if (modalProgreso && progresoFill && porcentaje && estado) {
                modalProgreso.style.display = 'block';
                actualizarProgreso(0, 'Iniciando búsqueda de duplicados...');
                console.log('Modal mostrada correctamente');
            } else {
                console.error('Elementos de modal no encontrados:', {
                    modalProgreso: !!modalProgreso,
                    progresoFill: !!progresoFill,
                    porcentaje: !!porcentaje,
                    estado: !!estado
                });
            }
        }
        
        // Función para ocultar la modal de progreso
        function ocultarProgreso() {
            if (modalProgreso) {
                modalProgreso.style.display = 'none';
            }
        }
        
        // Función para actualizar el progreso
        function actualizarProgreso(porcentajeValor, mensaje) {
            if (progresoFill && porcentaje && estado) {
                progresoFill.style.width = porcentajeValor + '%';
                porcentaje.textContent = porcentajeValor + '%';
                estado.innerHTML = '<span class=\"spinner\"></span>' + mensaje;
            }
        }
        
        // Función para obtener progreso real desde el servidor
        function obtenerProgresoReal() {
            console.log('Obteniendo progreso real desde servidor');
            fetch('";
        // line 466
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/progreso-duplicados')
                .then(response => {
                    console.log('Respuesta del servidor:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos de progreso:', data);
                    if (data.error) {
                        console.error('Error al obtener progreso:', data.error);
                        simularProgreso();
                        return;
                    }
                    
                    const porcentaje = data.porcentaje || 0;
                    const mensaje = data.estado || 'Procesando búsqueda...';
                    const completado = data.completado || false;
                    
                    actualizarProgreso(porcentaje, mensaje);
                    
                    // Si está completado, ocultar modal después de un tiempo
                    if (completado) {
                        setTimeout(() => {
                            ocultarProgreso();
                        }, 2000);
                    } else if (porcentaje < 100) {
                        // Si aún no está completo, seguir consultando
                        setTimeout(obtenerProgresoReal, 1000);
                    } else {
                        // Si llegó al 100%, ocultar después de un tiempo
                        setTimeout(() => {
                            ocultarProgreso();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener progreso:', error);
                    // En caso de error, usar progreso simulado
                    simularProgreso();
                });
        }
        
        // Función para simular progreso durante la búsqueda (fallback)
        function simularProgreso() {
            console.log('Iniciando progreso simulado');
            let progreso = 0;
            const interval = setInterval(() => {
                progreso += Math.random() * 10 + 5; // Entre 5-15 por paso
                if (progreso > 90) {
                    progreso = 90;
                }
                
                let mensaje = '';
                if (progreso < 20) {
                    mensaje = 'Analizando estructura de datos...';
                } else if (progreso < 40) {
                    mensaje = 'Buscando autores similares...';
                } else if (progreso < 60) {
                    mensaje = 'Comparando nombres y apellidos...';
                } else if (progreso < 80) {
                    mensaje = 'Agrupando duplicados encontrados...';
                } else {
                    mensaje = 'Finalizando búsqueda...';
                }
                
                actualizarProgreso(Math.round(progreso), mensaje);
                
                if (progreso >= 90) {
                    clearInterval(interval);
                    // Ocultar modal después de completar
                    setTimeout(() => {
                        ocultarProgreso();
                    }, 2000);
                }
            }, 300);
            
            return interval;
        }
        
        // Función para verificar si estamos en la página de duplicados globales
        function esPaginaDuplicadosGlobales() {
            const esDuplicados = window.location.href.includes('duplicados-globales');
            console.log('URL actual:', window.location.href);
            console.log('¿Es página de duplicados globales?', esDuplicados);
            return esDuplicados;
        }
        
        // Función para iniciar progreso en carga de página
        function iniciarProgresoEnCarga() {
            console.log('Verificando si debe iniciar progreso en carga');
            if (esPaginaDuplicadosGlobales()) {
                console.log('Iniciando progreso en carga de página');
                // Pequeño delay para asegurar que la página se cargue completamente
                setTimeout(() => {
                    // Solo mostrar progreso si hay una búsqueda en curso
                    const busquedaEnCurso = sessionStorage.getItem('busqueda_duplicados_en_curso');
                    if (busquedaEnCurso === 'true') {
                        mostrarProgreso();
                        obtenerProgresoReal();
                        
                        // Limpiar el flag de búsqueda en curso
                        sessionStorage.removeItem('busqueda_duplicados_en_curso');
                    }
                }, 200); // Aumentar delay inicial
            } else {
                console.log('No es página de duplicados globales, no iniciando progreso');
            }
        }
        
        // Interceptar envío de formularios para mostrar progreso
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Solo mostrar progreso para búsquedas, no para fusiones
                if (form.action.includes('buscar-variaciones-fusion')) {
                    mostrarProgreso();
                    obtenerProgresoReal();
                }
            });
        });
        
        // Interceptar clicks en enlaces de paginación
        document.querySelectorAll('a[href*=\"duplicados-globales\"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href.includes('pagina=')) {
                    e.preventDefault();
                    mostrarProgreso();
                    obtenerProgresoReal();
                    
                    // Redirigir después de un breve delay
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 1000);
                }
            });
        });
        
        // Interceptar clicks en el botón de duplicados globales desde la página de autores
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('a[href*=\"duplicados-globales\"]')) {
                const link = e.target.closest('a[href*=\"duplicados-globales\"]');
                if (!link.href.includes('pagina=')) {
                    // Es el enlace principal de duplicados globales
                    e.preventDefault();
                    
                    // Marcar que hay una búsqueda en curso
                    sessionStorage.setItem('busqueda_duplicados_en_curso', 'true');
                    
                    // Mostrar modal de progreso
                    mostrarProgreso();
                    
                    // Iniciar búsqueda de duplicados
                    fetch('";
        // line 616
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
                            obtenerProgresoReal();
                            
                            // Redirigir después de un breve delay
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        } else {
                            console.error('Error al iniciar búsqueda:', data.error);
                            ocultarProgreso();
                            sessionStorage.removeItem('busqueda_duplicados_en_curso');
                        }
                    })
                    .catch(error => {
                        console.error('Error al iniciar búsqueda:', error);
                        ocultarProgreso();
                        sessionStorage.removeItem('busqueda_duplicados_en_curso');
                    });
                }
            }
        });
        
        // Iniciar progreso cuando se carga la página
        iniciarProgresoEnCarga();
        
        // Forzar la visualización del modal si estamos en la página correcta
        setTimeout(() => {
            if (esPaginaDuplicadosGlobales() && modalProgreso) {
                console.log('Forzando visualización del modal');
                mostrarProgreso();
                obtenerProgresoReal();
            }
        }, 500);
        
        // Agregar listener para el botón de duplicados globales en la página de autores
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('a[href*=\"duplicados-globales\"]')) {
                const link = e.target.closest('a[href*=\"duplicados-globales\"]');
                if (!link.href.includes('pagina=')) {
                    // Es el enlace principal de duplicados globales
                    e.preventDefault();
                    mostrarProgreso();
                    obtenerProgresoReal();
                    
                    // Redirigir después de un breve delay
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 1000);
                }
            }
        });
        
        // Para cada formulario de grupo
        document.querySelectorAll('.grupo-form').forEach(form => {
            const radioButtons = form.querySelectorAll('.autor-principal');
            const accionRadios = form.querySelectorAll('.accion-autor');
            const fusionarBtn = form.querySelector('.fusionar-grupo-btn');

            // Función para actualizar el estado del botón de fusionar
            function actualizarBotonFusionar() {
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const accionesSeleccionadas = form.querySelectorAll('.accion-autor:checked');
                
                // Habilitar el botón solo si hay un autor principal y al menos una acción seleccionada
                fusionarBtn.disabled = !autorPrincipal || accionesSeleccionadas.length === 0;
            }

            // Evento para los radio buttons de autor principal
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Desmarcar las acciones del autor que se convierte en principal
                    const accionesAutor = form.querySelectorAll(`input[name=\"acciones_autores[\${this.value}]\"]`);
                    accionesAutor.forEach(accion => {
                        accion.checked = false;
                    });
                    actualizarBotonFusionar();
                });
            });

            // Evento para los radio buttons de acciones
            accionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Si se selecciona una acción, desmarcar el radio de autor principal
                    const autorId = this.name.match(/\\[(\\d+)\\]/)[1];
                    const radioPrincipal = form.querySelector(`#autor_\${autorId}`);
                    if (radioPrincipal) {
                        radioPrincipal.checked = false;
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para el formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const accionesSeleccionadas = form.querySelectorAll('.accion-autor:checked');
                
                if (!autorPrincipal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione un autor principal.',
                        icon: 'error'
                    });
                    return;
                }
                
                if (accionesSeleccionadas.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione al menos una acción para los autores.',
                        icon: 'error'
                    });
                    return;
                }

                // Verificar que todos los autores tengan una acción seleccionada
                const todosAutores = form.querySelectorAll('input[name^=\"acciones_autores[\"]');
                const autoresSinAccion = [];
                
                todosAutores.forEach(input => {
                    const autorId = input.name.match(/\\[(\\d+)\\]/)[1];
                    const tieneAccion = form.querySelector(`input[name=\"acciones_autores[\${autorId}]\"]:checked`);
                    if (!tieneAccion && autorId !== autorPrincipal.value) {
                        autoresSinAccion.push(autorId);
                    }
                });
                
                if (autoresSinAccion.length > 0) {
                    Swal.fire({
                        title: 'Acciones incompletas',
                        text: 'Por favor, seleccione una acción para todos los autores (excepto el principal).',
                        icon: 'warning'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: \"¿Está seguro de que desea fusionar los autores seleccionados? Esta acción no se puede deshacer.\",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, fusionar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        
        // Función global para mostrar progreso manualmente (ya no es necesaria)
        window.mostrarProgresoManual = function() {
            console.log('Función mostrarProgresoManual ya no es necesaria');
        };
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
        return "autores/duplicados_globales.twig";
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
        return array (  966 => 616,  813 => 466,  755 => 412,  748 => 411,  742 => 408,  728 => 399,  721 => 398,  711 => 392,  704 => 391,  701 => 389,  691 => 385,  685 => 384,  678 => 383,  674 => 382,  671 => 381,  668 => 380,  665 => 379,  662 => 378,  659 => 377,  656 => 376,  646 => 370,  639 => 369,  631 => 363,  624 => 362,  615 => 355,  609 => 354,  604 => 351,  601 => 350,  594 => 344,  587 => 340,  581 => 336,  573 => 331,  569 => 329,  543 => 316,  529 => 310,  524 => 308,  520 => 307,  516 => 306,  510 => 303,  505 => 301,  501 => 300,  492 => 294,  487 => 292,  483 => 291,  474 => 285,  469 => 283,  465 => 282,  456 => 276,  452 => 275,  447 => 273,  441 => 269,  437 => 268,  427 => 263,  422 => 261,  418 => 260,  414 => 259,  408 => 256,  403 => 254,  399 => 253,  390 => 247,  385 => 245,  381 => 244,  372 => 238,  367 => 236,  363 => 235,  354 => 229,  350 => 228,  345 => 226,  321 => 205,  317 => 204,  311 => 201,  307 => 199,  289 => 198,  287 => 197,  284 => 196,  278 => 193,  273 => 190,  271 => 189,  249 => 170,  212 => 135,  205 => 134,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Búsqueda Global de Duplicados{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
    <style>
        .modal-progreso {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-progreso .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .modal-progreso .titulo {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }
        
        .modal-progreso .descripcion {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .modal-progreso .barra-progreso {
            width: 100%;
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .modal-progreso .progreso-fill {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 10px;
            transition: width 0.3s ease;
            width: 0%;
        }
        
        .modal-progreso .porcentaje {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }
        
        .modal-progreso .estado {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 12px;
            font-style: italic;
        }
        
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos para las acciones de fusión */
        .accion-radio {
            margin: 0;
            padding: 0;
        }
        
        .accion-radio .custom-control {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .accion-radio .custom-control-label {
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .accion-radio .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .table th {
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .btn-accion {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin: 0.1rem;
        }
    </style>
{% endblock %}

{% block content %}
<!-- Modal de Progreso -->
<div id=\"modalProgreso\" class=\"modal-progreso\">
    <div class=\"modal-content\">
        <div class=\"titulo\">
            <i class=\"fas fa-search\"></i> Buscando Duplicados
        </div>
        <div class=\"descripcion\">
            Analizando autores para encontrar posibles duplicados...
        </div>
        <div class=\"barra-progreso\">
            <div class=\"progreso-fill\" id=\"progresoFill\"></div>
        </div>
        <div class=\"porcentaje\" id=\"porcentaje\">0%</div>
        <div class=\"estado\" id=\"estado\">
            <span class=\"spinner\"></span>Iniciando búsqueda...
        </div>
    </div>
</div>

<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Búsqueda Global de Duplicados</h3>
                </div>
                <div class=\"card-body\">
                    <!-- Formulario de búsqueda para fusión mejorada -->
                    <div class=\"row mb-4\">
                        <div class=\"col-md-8\">
                            <div class=\"card\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title\">Buscar Variaciones para Fusión</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form method=\"POST\" action=\"{{ app_url }}autores/buscar-variaciones-fusion\" class=\"row g-3\">
                                        <div class=\"col-md-8\">
                                            <input type=\"text\" class=\"form-control\" name=\"termino_busqueda\" 
                                                   placeholder=\"Ingrese nombre, apellido o variación para buscar...\" required>
                                        </div>
                                        <div class=\"col-md-4\">
                                            <button type=\"submit\" class=\"btn btn-primary\">
                                                <i class=\"fas fa-search\"></i> Buscar Variaciones
                                            </button>
                                        </div>
                                    </form>
                                    <small class=\"text-muted\">
                                        <i class=\"fas fa-info-circle\"></i> 
                                        Busca autores por nombre, apellido o variaciones para fusionar duplicados con selección de acciones.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    {% if error %}
                        <div class=\"alert alert-danger alert-dismissible\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
                            {{ error }}
                        </div>
                    {% endif %}

                    {% if gruposDuplicados|length > 0 %}
                        {% for grupo in gruposDuplicados %}
                            <div class=\"card mb-3\">
                                <div class=\"card-header bg-light\">
                                    <h5 class=\"mb-0\">Grupo {{ loop.index }}</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form action=\"{{ app_url }}autores/fusionar-grupo\" method=\"POST\" class=\"grupo-form\">
                                        <input type=\"hidden\" name=\"grupo_id\" value=\"{{ loop.index }}\">
                                        
                                        <div class=\"table-responsive\">
                                            <table class=\"table table-bordered table-striped\">
                                                <thead>
                                                    <tr>
                                                        <th style=\"width: 80px;\">Principal</th>
                                                        <th style=\"width: 80px;\">Mantener</th>
                                                        <th style=\"width: 100px;\">Convertir en Alias</th>
                                                        <th style=\"width: 80px;\">Eliminar</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>Género</th>
                                                        <th style=\"width: 100px;\">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                       id=\"autor_{{ grupo.principal.id }}\" 
                                                                       name=\"autor_principal\" 
                                                                       value=\"{{ grupo.principal.id }}\" required>
                                                                <label class=\"custom-control-label\" for=\"autor_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"mantener_{{ grupo.principal.id }}\" 
                                                                       name=\"acciones_autores[{{ grupo.principal.id }}]\" 
                                                                       value=\"mantener\">
                                                                <label class=\"custom-control-label\" for=\"mantener_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"alias_{{ grupo.principal.id }}\" 
                                                                       name=\"acciones_autores[{{ grupo.principal.id }}]\" 
                                                                       value=\"convertir_alias\">
                                                                <label class=\"custom-control-label\" for=\"alias_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"custom-control custom-radio accion-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                       id=\"eliminar_{{ grupo.principal.id }}\" 
                                                                       name=\"acciones_autores[{{ grupo.principal.id }}]\" 
                                                                       value=\"eliminar\">
                                                                <label class=\"custom-control-label\" for=\"eliminar_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ grupo.principal.nombres }}</td>
                                                        <td>{{ grupo.principal.apellidos }}</td>
                                                        <td>{{ grupo.principal.genero }}</td>
                                                        <td class=\"text-center\">
                                                            <a href=\"{{ app_url }}autores/{{ grupo.principal.id }}/edit\" class=\"btn btn-sm btn-info btn-accion\">
                                                                <i class=\"fas fa-edit\"></i> Editar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {% for duplicado in grupo.duplicados %}
                                                        <tr>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                           id=\"autor_{{ duplicado.id }}\" 
                                                                           name=\"autor_principal\" 
                                                                           value=\"{{ duplicado.id }}\" required>
                                                                    <label class=\"custom-control-label\" for=\"autor_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"mantener_{{ duplicado.id }}\" 
                                                                           name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                           value=\"mantener\">
                                                                    <label class=\"custom-control-label\" for=\"mantener_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"alias_{{ duplicado.id }}\" 
                                                                           name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                           value=\"convertir_alias\">
                                                                    <label class=\"custom-control-label\" for=\"alias_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td class=\"text-center\">
                                                                <div class=\"custom-control custom-radio accion-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input accion-autor\" 
                                                                           id=\"eliminar_{{ duplicado.id }}\" 
                                                                           name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                           value=\"eliminar\">
                                                                    <label class=\"custom-control-label\" for=\"eliminar_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ duplicado.nombres }}</td>
                                                            <td>{{ duplicado.apellidos }}</td>
                                                            <td>{{ duplicado.genero }}</td>
                                                            <td class=\"text-center\">
                                                                <a href=\"{{ app_url }}autores/{{ duplicado.id }}/edit\" class=\"btn btn-sm btn-info btn-accion\">
                                                                    <i class=\"fas fa-edit\"></i> Editar
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    {% endfor %}
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class=\"form-group mt-3\">
                                            <button type=\"submit\" class=\"btn btn-primary fusionar-grupo-btn\" disabled>
                                                <i class=\"fas fa-object-group\"></i> Fusionar Grupo
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        {% endfor %}

                        <div class=\"form-group\">
                            <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    {% else %}
                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores duplicados en el sistema.
                        </div>
                        <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>

    {# Paginación #}
    {% if paginacion is defined and paginacion.totalPaginas > 1 %}
    <div class=\"row mt-4\">
        <div class=\"col-md-6\">
            <p class=\"text-muted\">
                Mostrando página {{ paginacion.pagina }} de {{ paginacion.totalPaginas }} 
                ({{ paginacion.totalGrupos }} grupos de duplicados encontrados)
            </p>
        </div>
        <div class=\"col-md-6\">
            <nav aria-label=\"Navegación de páginas\" class=\"float-end\">
                <ul class=\"pagination mb-0\">
                    {# Botón Primera Página #}
                    <li class=\"page-item {% if paginacion.pagina == 1 %}disabled{% endif %}\">
                        <a class=\"page-link\" href=\"{{ app_url }}autores/duplicados-globales?pagina=1\" aria-label=\"Primera\">
                            <i class=\"fas fa-angle-double-left\"></i>
                        </a>
                    </li>

                    {# Botón Página Anterior #}
                    <li class=\"page-item {% if paginacion.pagina == 1 %}disabled{% endif %}\">
                        <a class=\"page-link\" href=\"{{ app_url }}autores/duplicados-globales?pagina={{ paginacion.pagina - 1 }}\" aria-label=\"Anterior\">
                            <i class=\"fas fa-angle-left\"></i>
                        </a>
                    </li>

                    {# Números de Página #}
                    {% set inicio = max(1, paginacion.pagina - 2) %}
                    {% set fin = min(paginacion.totalPaginas, inicio + 4) %}
                    {% if fin - inicio < 4 %}
                        {% set inicio = max(1, fin - 4) %}
                    {% endif %}

                    {% for i in inicio..fin %}
                        <li class=\"page-item {% if i == paginacion.pagina %}active{% endif %}\">
                            <a class=\"page-link\" href=\"{{ app_url }}autores/duplicados-globales?pagina={{ i }}\">
                                {{ i }}
                            </a>
                        </li>
                    {% endfor %}

                    {# Botón Página Siguiente #}
                    <li class=\"page-item {% if paginacion.pagina == paginacion.totalPaginas %}disabled{% endif %}\">
                        <a class=\"page-link\" href=\"{{ app_url }}autores/duplicados-globales?pagina={{ paginacion.pagina + 1 }}\" aria-label=\"Siguiente\">
                            <i class=\"fas fa-angle-right\"></i>
                        </a>
                    </li>

                    {# Botón Última Página #}
                    <li class=\"page-item {% if paginacion.pagina == paginacion.totalPaginas %}disabled{% endif %}\">
                        <a class=\"page-link\" href=\"{{ app_url }}autores/duplicados-globales?pagina={{ paginacion.totalPaginas }}\" aria-label=\"Última\">
                            <i class=\"fas fa-angle-double-right\"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    {% endif %}
</div>
{% endblock %}

{% block scripts %}
    {{ parent() }}
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables para la modal de progreso
        const modalProgreso = document.getElementById('modalProgreso');
        const progresoFill = document.getElementById('progresoFill');
        const porcentaje = document.getElementById('porcentaje');
        const estado = document.getElementById('estado');
        
        // Verificar que todos los elementos estén disponibles
        console.log('Elementos de modal encontrados:', {
            modalProgreso: !!modalProgreso,
            progresoFill: !!progresoFill,
            porcentaje: !!porcentaje,
            estado: !!estado
        });
        
        // Función para mostrar la modal de progreso
        function mostrarProgreso() {
            console.log('Mostrando modal de progreso');
            if (modalProgreso && progresoFill && porcentaje && estado) {
                modalProgreso.style.display = 'block';
                actualizarProgreso(0, 'Iniciando búsqueda de duplicados...');
                console.log('Modal mostrada correctamente');
            } else {
                console.error('Elementos de modal no encontrados:', {
                    modalProgreso: !!modalProgreso,
                    progresoFill: !!progresoFill,
                    porcentaje: !!porcentaje,
                    estado: !!estado
                });
            }
        }
        
        // Función para ocultar la modal de progreso
        function ocultarProgreso() {
            if (modalProgreso) {
                modalProgreso.style.display = 'none';
            }
        }
        
        // Función para actualizar el progreso
        function actualizarProgreso(porcentajeValor, mensaje) {
            if (progresoFill && porcentaje && estado) {
                progresoFill.style.width = porcentajeValor + '%';
                porcentaje.textContent = porcentajeValor + '%';
                estado.innerHTML = '<span class=\"spinner\"></span>' + mensaje;
            }
        }
        
        // Función para obtener progreso real desde el servidor
        function obtenerProgresoReal() {
            console.log('Obteniendo progreso real desde servidor');
            fetch('{{ app_url }}autores/progreso-duplicados')
                .then(response => {
                    console.log('Respuesta del servidor:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Datos de progreso:', data);
                    if (data.error) {
                        console.error('Error al obtener progreso:', data.error);
                        simularProgreso();
                        return;
                    }
                    
                    const porcentaje = data.porcentaje || 0;
                    const mensaje = data.estado || 'Procesando búsqueda...';
                    const completado = data.completado || false;
                    
                    actualizarProgreso(porcentaje, mensaje);
                    
                    // Si está completado, ocultar modal después de un tiempo
                    if (completado) {
                        setTimeout(() => {
                            ocultarProgreso();
                        }, 2000);
                    } else if (porcentaje < 100) {
                        // Si aún no está completo, seguir consultando
                        setTimeout(obtenerProgresoReal, 1000);
                    } else {
                        // Si llegó al 100%, ocultar después de un tiempo
                        setTimeout(() => {
                            ocultarProgreso();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener progreso:', error);
                    // En caso de error, usar progreso simulado
                    simularProgreso();
                });
        }
        
        // Función para simular progreso durante la búsqueda (fallback)
        function simularProgreso() {
            console.log('Iniciando progreso simulado');
            let progreso = 0;
            const interval = setInterval(() => {
                progreso += Math.random() * 10 + 5; // Entre 5-15 por paso
                if (progreso > 90) {
                    progreso = 90;
                }
                
                let mensaje = '';
                if (progreso < 20) {
                    mensaje = 'Analizando estructura de datos...';
                } else if (progreso < 40) {
                    mensaje = 'Buscando autores similares...';
                } else if (progreso < 60) {
                    mensaje = 'Comparando nombres y apellidos...';
                } else if (progreso < 80) {
                    mensaje = 'Agrupando duplicados encontrados...';
                } else {
                    mensaje = 'Finalizando búsqueda...';
                }
                
                actualizarProgreso(Math.round(progreso), mensaje);
                
                if (progreso >= 90) {
                    clearInterval(interval);
                    // Ocultar modal después de completar
                    setTimeout(() => {
                        ocultarProgreso();
                    }, 2000);
                }
            }, 300);
            
            return interval;
        }
        
        // Función para verificar si estamos en la página de duplicados globales
        function esPaginaDuplicadosGlobales() {
            const esDuplicados = window.location.href.includes('duplicados-globales');
            console.log('URL actual:', window.location.href);
            console.log('¿Es página de duplicados globales?', esDuplicados);
            return esDuplicados;
        }
        
        // Función para iniciar progreso en carga de página
        function iniciarProgresoEnCarga() {
            console.log('Verificando si debe iniciar progreso en carga');
            if (esPaginaDuplicadosGlobales()) {
                console.log('Iniciando progreso en carga de página');
                // Pequeño delay para asegurar que la página se cargue completamente
                setTimeout(() => {
                    // Solo mostrar progreso si hay una búsqueda en curso
                    const busquedaEnCurso = sessionStorage.getItem('busqueda_duplicados_en_curso');
                    if (busquedaEnCurso === 'true') {
                        mostrarProgreso();
                        obtenerProgresoReal();
                        
                        // Limpiar el flag de búsqueda en curso
                        sessionStorage.removeItem('busqueda_duplicados_en_curso');
                    }
                }, 200); // Aumentar delay inicial
            } else {
                console.log('No es página de duplicados globales, no iniciando progreso');
            }
        }
        
        // Interceptar envío de formularios para mostrar progreso
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Solo mostrar progreso para búsquedas, no para fusiones
                if (form.action.includes('buscar-variaciones-fusion')) {
                    mostrarProgreso();
                    obtenerProgresoReal();
                }
            });
        });
        
        // Interceptar clicks en enlaces de paginación
        document.querySelectorAll('a[href*=\"duplicados-globales\"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href.includes('pagina=')) {
                    e.preventDefault();
                    mostrarProgreso();
                    obtenerProgresoReal();
                    
                    // Redirigir después de un breve delay
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 1000);
                }
            });
        });
        
        // Interceptar clicks en el botón de duplicados globales desde la página de autores
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('a[href*=\"duplicados-globales\"]')) {
                const link = e.target.closest('a[href*=\"duplicados-globales\"]');
                if (!link.href.includes('pagina=')) {
                    // Es el enlace principal de duplicados globales
                    e.preventDefault();
                    
                    // Marcar que hay una búsqueda en curso
                    sessionStorage.setItem('busqueda_duplicados_en_curso', 'true');
                    
                    // Mostrar modal de progreso
                    mostrarProgreso();
                    
                    // Iniciar búsqueda de duplicados
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
                            obtenerProgresoReal();
                            
                            // Redirigir después de un breve delay
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        } else {
                            console.error('Error al iniciar búsqueda:', data.error);
                            ocultarProgreso();
                            sessionStorage.removeItem('busqueda_duplicados_en_curso');
                        }
                    })
                    .catch(error => {
                        console.error('Error al iniciar búsqueda:', error);
                        ocultarProgreso();
                        sessionStorage.removeItem('busqueda_duplicados_en_curso');
                    });
                }
            }
        });
        
        // Iniciar progreso cuando se carga la página
        iniciarProgresoEnCarga();
        
        // Forzar la visualización del modal si estamos en la página correcta
        setTimeout(() => {
            if (esPaginaDuplicadosGlobales() && modalProgreso) {
                console.log('Forzando visualización del modal');
                mostrarProgreso();
                obtenerProgresoReal();
            }
        }, 500);
        
        // Agregar listener para el botón de duplicados globales en la página de autores
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('a[href*=\"duplicados-globales\"]')) {
                const link = e.target.closest('a[href*=\"duplicados-globales\"]');
                if (!link.href.includes('pagina=')) {
                    // Es el enlace principal de duplicados globales
                    e.preventDefault();
                    mostrarProgreso();
                    obtenerProgresoReal();
                    
                    // Redirigir después de un breve delay
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 1000);
                }
            }
        });
        
        // Para cada formulario de grupo
        document.querySelectorAll('.grupo-form').forEach(form => {
            const radioButtons = form.querySelectorAll('.autor-principal');
            const accionRadios = form.querySelectorAll('.accion-autor');
            const fusionarBtn = form.querySelector('.fusionar-grupo-btn');

            // Función para actualizar el estado del botón de fusionar
            function actualizarBotonFusionar() {
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const accionesSeleccionadas = form.querySelectorAll('.accion-autor:checked');
                
                // Habilitar el botón solo si hay un autor principal y al menos una acción seleccionada
                fusionarBtn.disabled = !autorPrincipal || accionesSeleccionadas.length === 0;
            }

            // Evento para los radio buttons de autor principal
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Desmarcar las acciones del autor que se convierte en principal
                    const accionesAutor = form.querySelectorAll(`input[name=\"acciones_autores[\${this.value}]\"]`);
                    accionesAutor.forEach(accion => {
                        accion.checked = false;
                    });
                    actualizarBotonFusionar();
                });
            });

            // Evento para los radio buttons de acciones
            accionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Si se selecciona una acción, desmarcar el radio de autor principal
                    const autorId = this.name.match(/\\[(\\d+)\\]/)[1];
                    const radioPrincipal = form.querySelector(`#autor_\${autorId}`);
                    if (radioPrincipal) {
                        radioPrincipal.checked = false;
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para el formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const accionesSeleccionadas = form.querySelectorAll('.accion-autor:checked');
                
                if (!autorPrincipal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione un autor principal.',
                        icon: 'error'
                    });
                    return;
                }
                
                if (accionesSeleccionadas.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione al menos una acción para los autores.',
                        icon: 'error'
                    });
                    return;
                }

                // Verificar que todos los autores tengan una acción seleccionada
                const todosAutores = form.querySelectorAll('input[name^=\"acciones_autores[\"]');
                const autoresSinAccion = [];
                
                todosAutores.forEach(input => {
                    const autorId = input.name.match(/\\[(\\d+)\\]/)[1];
                    const tieneAccion = form.querySelector(`input[name=\"acciones_autores[\${autorId}]\"]:checked`);
                    if (!tieneAccion && autorId !== autorPrincipal.value) {
                        autoresSinAccion.push(autorId);
                    }
                });
                
                if (autoresSinAccion.length > 0) {
                    Swal.fire({
                        title: 'Acciones incompletas',
                        text: 'Por favor, seleccione una acción para todos los autores (excepto el principal).',
                        icon: 'warning'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: \"¿Está seguro de que desea fusionar los autores seleccionados? Esta acción no se puede deshacer.\",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, fusionar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        
        // Función global para mostrar progreso manualmente (ya no es necesaria)
        window.mostrarProgresoManual = function() {
            console.log('Función mostrarProgresoManual ya no es necesaria');
        };
    });
    </script>
{% endblock %} ", "autores/duplicados_globales.twig", "/var/www/html/biblioges/templates/autores/duplicados_globales.twig");
    }
}
