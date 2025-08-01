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

/* frontend/carrera.twig */
class __TwigTemplate_5d11cf1b01b81b36c1cb0dc08b21d418 extends Template
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
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "frontend/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/carrera.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 3), "html", null, true);
        yield " - Bibliografía UCN";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<!-- Header -->
<header class=\"ucn-header\">
    <div class=\"container\">
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\" class=\"back-link\">
            <i class=\"fas fa-arrow-left\"></i>
            Bibliografía UCN
        </a>
    </div>
</header>

<!-- Program Overview Section -->
<section class=\"program-overview\">
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-md-3\">
                <div class=\"program-image\">
                    ";
        // line 22
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 22)) {
            // line 23
            yield "                        <img src=\"/biblioges/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 23), "html", null, true);
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 23), "html", null, true);
            yield "\" style=\"object-fit:cover; width:100%; height:200px;\">
                    ";
        } else {
            // line 25
            yield "                        <img src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["assets_url"] ?? null), "html", null, true);
            yield "/images/carreras/default.svg\" alt=\"Sin imagen\" style=\"object-fit:cover; width:100%; height:200px;\">
                    ";
        }
        // line 27
        yield "                </div>
            </div>
            <div class=\"col-md-9\">
                <h1 class=\"program-title\">";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 30), "html", null, true);
        yield "</h1>
                <p class=\"program-description\">";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "descripcion", [], "any", true, true, false, 31)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "descripcion", [], "any", false, false, false, 31), "Forma profesionales capaces de optimizar procesos productivos y de servicios.")) : ("Forma profesionales capaces de optimizar procesos productivos y de servicios.")), "html", null, true);
        yield "</p>
                <div class=\"program-stats\">
                    <div class=\"stat-item\">
                        <i class=\"fas fa-clock\"></i>
                        <span>Duración: ";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", true, true, false, 35)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 35), 10)) : (10)), "html", null, true);
        yield " semestres</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        <span>Sede: ";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 39), "html", null, true);
        yield "</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-bookmark\"></i>
                        <span>Semestres: ";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["asignaturas_por_semestre"] ?? null)), "html", null, true);
        yield "</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class=\"content-area\">
    <div class=\"container\">
        <!-- Breadcrumbs -->
        <nav class=\"breadcrumb-nav\">
            <span>Carreras > ";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 56), "html", null, true);
        yield "</span>
        </nav>

        <!-- Semester Navigation Tabs -->
        <div class=\"semester-tabs\">
            ";
        // line 61
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_por_semestre"] ?? null));
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
        foreach ($context['_seq'] as $context["semestre"] => $context["asignaturas"]) {
            // line 62
            yield "            <button class=\"semester-tab ";
            if (CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 62)) {
                yield "active";
            }
            yield "\" 
                    onclick=\"showSemester(";
            // line 63
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
            yield ")\">
                Semestre ";
            // line 64
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
            yield "
            </button>
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
        unset($context['_seq'], $context['semestre'], $context['asignaturas'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        yield "        </div>

        <!-- Semester Content -->
        ";
        // line 70
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["asignaturas_por_semestre"] ?? null)) > 0)) {
            // line 71
            yield "            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_por_semestre"] ?? null));
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
            foreach ($context['_seq'] as $context["semestre"] => $context["asignaturas"]) {
                // line 72
                yield "            <div class=\"semester-content ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 72)) {
                    yield "active";
                }
                yield "\" id=\"semester-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
                yield "\">
                <h2 class=\"semester-title\">Semestre ";
                // line 73
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
                yield "</h2>
                
                ";
                // line 75
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["asignaturas"]);
                foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                    // line 76
                    yield "                <div class=\"course-section\">
                    <h3 class=\"course-title\">";
                    // line 77
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_nombre", [], "any", false, false, false, 77), "html", null, true);
                    yield "</h3>
                    <p class=\"course-code\">Código: ";
                    // line 78
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigo_asignatura", [], "any", false, false, false, 78), "html", null, true);
                    yield "</p>
                    
                    <div class=\"bibliography-section\">
                        <h4 class=\"bibliography-title\">
                            <i class=\"fas fa-bookmark\"></i>
                            Bibliografía
                        </h4>
                        
                        <!-- Bibliography Tabs -->
                        <div class=\"bibliography-tabs\">
                            <button class=\"bib-tab active\" onclick=\"showBibliography('basica', ";
                    // line 88
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 88), "html", null, true);
                    yield ")\">
                                <i class=\"fas fa-star\"></i>
                                Básicas
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('complementaria', ";
                    // line 92
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 92), "html", null, true);
                    yield ")\">
                                <i class=\"far fa-star\"></i>
                                Complementarias
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('otros', ";
                    // line 96
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 96), "html", null, true);
                    yield ")\">
                                <i class=\"fas fa-bookmark\"></i>
                                Otros
                            </button>
                        </div>
                        
                        <!-- Bibliography Content -->
                        <div class=\"bibliography-content\">
                            <!-- Basic Bibliography -->
                            <div class=\"bib-content active\" id=\"basica-";
                    // line 105
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 105), "html", null, true);
                    yield "\">
                                ";
                    // line 106
                    $context["bibliografiasBasicas"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 106), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 106) == "basica"); });
                    // line 107
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasBasicas"] ?? null)) > 0)) {
                        // line 108
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasBasicas"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 109
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 113
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 113)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 113), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 113)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 113), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 113), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 113)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 113), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 115
                            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 115)) > 0)) {
                                // line 116
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 117
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 117), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 117), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 122
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 125
                        yield "                                ";
                    } else {
                        // line 126
                        yield "                                    <p class=\"no-bibliography\">No hay bibliografía básica disponible.</p>
                                ";
                    }
                    // line 128
                    yield "                            </div>
                            
                            <!-- Complementary Bibliography -->
                            <div class=\"bib-content\" id=\"complementaria-";
                    // line 131
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 131), "html", null, true);
                    yield "\">
                                ";
                    // line 132
                    $context["bibliografiasComplementarias"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 132), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 132) == "complementaria"); });
                    // line 133
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasComplementarias"] ?? null)) > 0)) {
                        // line 134
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasComplementarias"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 135
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 139
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 139)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 139), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 139)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 139), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 139), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 139)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 139), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 141
                            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 141)) > 0)) {
                                // line 142
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 143
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 143), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 143), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 148
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 151
                        yield "                                ";
                    } else {
                        // line 152
                        yield "                                    <p class=\"no-bibliography\">No hay bibliografía complementaria disponible.</p>
                                ";
                    }
                    // line 154
                    yield "                            </div>
                            
                            <!-- Other Bibliography -->
                            <div class=\"bib-content\" id=\"otros-";
                    // line 157
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 157), "html", null, true);
                    yield "\">
                                ";
                    // line 158
                    $context["bibliografiasOtros"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 158), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return ((CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 158) != "basica") && (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 158) != "complementaria")); });
                    // line 159
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasOtros"] ?? null)) > 0)) {
                        // line 160
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasOtros"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 161
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 165
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 165)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 165), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 165)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 165), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 165), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 165)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 165), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 167
                            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 167)) > 0)) {
                                // line 168
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 169
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 169), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 169), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 174
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 177
                        yield "                                ";
                    } else {
                        // line 178
                        yield "                                    <p class=\"no-bibliography\">No hay otros tipos de bibliografía disponibles.</p>
                                ";
                    }
                    // line 180
                    yield "                            </div>
                        </div>
                    </div>
                </div>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 185
                yield "            </div>
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
            unset($context['_seq'], $context['semestre'], $context['asignaturas'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 187
            yield "        ";
        } else {
            // line 188
            yield "            <div class=\"no-content\">
                <i class=\"fas fa-info-circle\"></i>
                <p>No hay asignaturas registradas para esta carrera en esta sede.</p>
            </div>
        ";
        }
        // line 193
        yield "    </div>
</section>

<!-- Botón de Regreso -->
<section class=\"container mb-5\">
    <div class=\"text-center\">
        <a href=\"";
        // line 199
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\" class=\"btn btn-outline-primary\">
            <i class=\"fas fa-arrow-left me-2\"></i>
            Volver al Inicio
        </a>
    </div>
</section>

<!-- Modal de Bibliografías Disponibles -->
<div class=\"modal fade\" id=\"modalBibliografiasDisponibles\" tabindex=\"-1\" aria-labelledby=\"modalBibliografiasDisponiblesLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalBibliografiasDisponiblesLabel\">
                    <i class=\"fas fa-book me-2\"></i>
                    Bibliografías Disponibles
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"modalContent\">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">
                    <i class=\"fas fa-times me-1\"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el modal -->
<script>
function mostrarBibliografiasDisponibles(bibliografiaId, titulo) {
    // Mostrar loading
    document.getElementById('modalContent').innerHTML = `
        <div class=\"text-center\">
            <div class=\"spinner-border text-primary\" role=\"status\">
                <span class=\"visually-hidden\">Cargando...</span>
            </div>
            <p class=\"mt-2\">Cargando bibliografías disponibles...</p>
        </div>
    `;
    
    // Actualizar título del modal
    document.getElementById('modalBibliografiasDisponiblesLabel').innerHTML = `
        <i class=\"fas fa-book me-2\"></i>
        Bibliografías Disponibles: \${titulo}
    `;
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalBibliografiasDisponibles'));
    modal.show();
    
    // Cargar datos
    fetch(`\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarBibliografiasEnModal(data.bibliografias);
            } else {
                document.getElementById('modalContent').innerHTML = `
                    <div class=\"alert alert-danger\">
                        <i class=\"fas fa-exclamation-triangle me-2\"></i>
                        Error al cargar las bibliografías: \${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('modalContent').innerHTML = `
                <div class=\"alert alert-danger\">
                    <i class=\"fas fa-exclamation-triangle me-2\"></i>
                    Error de conexión: \${error.message}
                </div>
            `;
        });
}

function mostrarBibliografiasEnModal(bibliografias) {
    if (bibliografias.length === 0) {
        document.getElementById('modalContent').innerHTML = `
            <div class=\"alert alert-info\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No hay bibliografías disponibles para mostrar.
            </div>
        `;
        return;
    }
    
    let html = '<div class=\"row\">';
    
    bibliografias.forEach(bib => {
        html += `
            <div class=\"col-12 mb-3\">
                <div class=\"card\">
                    <div class=\"card-body\">
                        <h6 class=\"card-title\">\${bib.titulo}</h6>
                        <div class=\"row\">
                            <div class=\"col-md-8\">
                                <p class=\"mb-1\"><strong>Autor(es):</strong> \${bib.autores || 'No especificado'}</p>
                                <p class=\"mb-1\"><strong>Año:</strong> \${bib.anio_edicion}</p>
                                <p class=\"mb-1\"><strong>Editorial:</strong> \${bib.editorial || 'No especificada'}</p>
                                <p class=\"mb-1\"><strong>Disponibilidad:</strong> 
                                    <span class=\"badge bg-\${bib.disponibilidad === 'electronico' ? 'success' : bib.disponibilidad === 'impreso' ? 'primary' : 'info'}\">
                                        \${bib.disponibilidad}
                                    </span>
                                </p>
                            </div>
                            <div class=\"col-md-4 text-end\">
                                \${bib.url_acceso ? `
                                    <a href=\"\${bib.url_acceso}\" target=\"_blank\" class=\"btn btn-success btn-sm mb-1 w-100\">
                                        <i class=\"fas fa-external-link-alt me-1\"></i>
                                        Acceso Directo
                                    </a>
                                ` : ''}
                                \${bib.url_catalogo ? `
                                    <a href=\"\${bib.url_catalogo}\" target=\"_blank\" class=\"btn btn-primary btn-sm w-100\">
                                        <i class=\"fas fa-search me-1\"></i>
                                        Ver en Catálogo
                                    </a>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    document.getElementById('modalContent').innerHTML = html;
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
        return "frontend/carrera.twig";
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
        return array (  532 => 199,  524 => 193,  517 => 188,  514 => 187,  499 => 185,  489 => 180,  485 => 178,  482 => 177,  474 => 174,  464 => 169,  461 => 168,  459 => 167,  448 => 165,  442 => 161,  437 => 160,  434 => 159,  432 => 158,  428 => 157,  423 => 154,  419 => 152,  416 => 151,  408 => 148,  398 => 143,  395 => 142,  393 => 141,  382 => 139,  376 => 135,  371 => 134,  368 => 133,  366 => 132,  362 => 131,  357 => 128,  353 => 126,  350 => 125,  342 => 122,  332 => 117,  329 => 116,  327 => 115,  316 => 113,  310 => 109,  305 => 108,  302 => 107,  300 => 106,  296 => 105,  284 => 96,  277 => 92,  270 => 88,  257 => 78,  253 => 77,  250 => 76,  246 => 75,  241 => 73,  232 => 72,  214 => 71,  212 => 70,  207 => 67,  190 => 64,  186 => 63,  179 => 62,  162 => 61,  154 => 56,  138 => 43,  131 => 39,  124 => 35,  117 => 31,  113 => 30,  108 => 27,  102 => 25,  94 => 23,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}{{ carrera.carrera_nombre }} - Bibliografía UCN{% endblock %}

{% block content %}
<!-- Header -->
<header class=\"ucn-header\">
    <div class=\"container\">
        <a href=\"{{ app_url }}\" class=\"back-link\">
            <i class=\"fas fa-arrow-left\"></i>
            Bibliografía UCN
        </a>
    </div>
</header>

<!-- Program Overview Section -->
<section class=\"program-overview\">
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-md-3\">
                <div class=\"program-image\">
                    {% if carrera.imagen_url %}
                        <img src=\"/biblioges/{{ carrera.imagen_url }}\" alt=\"{{ carrera.carrera_nombre }}\" style=\"object-fit:cover; width:100%; height:200px;\">
                    {% else %}
                        <img src=\"{{ assets_url }}/images/carreras/default.svg\" alt=\"Sin imagen\" style=\"object-fit:cover; width:100%; height:200px;\">
                    {% endif %}
                </div>
            </div>
            <div class=\"col-md-9\">
                <h1 class=\"program-title\">{{ carrera.carrera_nombre }}</h1>
                <p class=\"program-description\">{{ carrera.descripcion|default('Forma profesionales capaces de optimizar procesos productivos y de servicios.') }}</p>
                <div class=\"program-stats\">
                    <div class=\"stat-item\">
                        <i class=\"fas fa-clock\"></i>
                        <span>Duración: {{ carrera.cantidad_semestres|default(10) }} semestres</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        <span>Sede: {{ carrera.sede_nombre }}</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-bookmark\"></i>
                        <span>Semestres: {{ asignaturas_por_semestre|length }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class=\"content-area\">
    <div class=\"container\">
        <!-- Breadcrumbs -->
        <nav class=\"breadcrumb-nav\">
            <span>Carreras > {{ carrera.carrera_nombre }}</span>
        </nav>

        <!-- Semester Navigation Tabs -->
        <div class=\"semester-tabs\">
            {% for semestre, asignaturas in asignaturas_por_semestre %}
            <button class=\"semester-tab {% if loop.first %}active{% endif %}\" 
                    onclick=\"showSemester({{ semestre }})\">
                Semestre {{ semestre }}
            </button>
            {% endfor %}
        </div>

        <!-- Semester Content -->
        {% if asignaturas_por_semestre|length > 0 %}
            {% for semestre, asignaturas in asignaturas_por_semestre %}
            <div class=\"semester-content {% if loop.first %}active{% endif %}\" id=\"semester-{{ semestre }}\">
                <h2 class=\"semester-title\">Semestre {{ semestre }}</h2>
                
                {% for asignatura in asignaturas %}
                <div class=\"course-section\">
                    <h3 class=\"course-title\">{{ asignatura.asignatura_nombre }}</h3>
                    <p class=\"course-code\">Código: {{ asignatura.codigo_asignatura }}</p>
                    
                    <div class=\"bibliography-section\">
                        <h4 class=\"bibliography-title\">
                            <i class=\"fas fa-bookmark\"></i>
                            Bibliografía
                        </h4>
                        
                        <!-- Bibliography Tabs -->
                        <div class=\"bibliography-tabs\">
                            <button class=\"bib-tab active\" onclick=\"showBibliography('basica', {{ asignatura.asignatura_id }})\">
                                <i class=\"fas fa-star\"></i>
                                Básicas
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('complementaria', {{ asignatura.asignatura_id }})\">
                                <i class=\"far fa-star\"></i>
                                Complementarias
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('otros', {{ asignatura.asignatura_id }})\">
                                <i class=\"fas fa-bookmark\"></i>
                                Otros
                            </button>
                        </div>
                        
                        <!-- Bibliography Content -->
                        <div class=\"bibliography-content\">
                            <!-- Basic Bibliography -->
                            <div class=\"bib-content active\" id=\"basica-{{ asignatura.asignatura_id }}\">
                                {% set bibliografiasBasicas = asignatura.bibliografias|filter(b => b.tipo_bibliografia == 'basica') %}
                                {% if bibliografiasBasicas|length > 0 %}
                                    {% for bibliografia in bibliografiasBasicas %}
                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>{{ bibliografia.autores|default('Autor') }}, {{ bibliografia.anio_publicacion|default('Año') }}. {{ bibliografia.titulo }}. {{ bibliografia.editorial|default('Editorial') }}.</span>
                                            </div>
                                            {% if bibliografia.disponibles|length > 0 %}
                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles({{ bibliografia.id }}, '{{ bibliografia.titulo|e('js') }}')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            {% endif %}
                                        </div>
                                    </div>
                                    {% endfor %}
                                {% else %}
                                    <p class=\"no-bibliography\">No hay bibliografía básica disponible.</p>
                                {% endif %}
                            </div>
                            
                            <!-- Complementary Bibliography -->
                            <div class=\"bib-content\" id=\"complementaria-{{ asignatura.asignatura_id }}\">
                                {% set bibliografiasComplementarias = asignatura.bibliografias|filter(b => b.tipo_bibliografia == 'complementaria') %}
                                {% if bibliografiasComplementarias|length > 0 %}
                                    {% for bibliografia in bibliografiasComplementarias %}
                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>{{ bibliografia.autores|default('Autor') }}, {{ bibliografia.anio_publicacion|default('Año') }}. {{ bibliografia.titulo }}. {{ bibliografia.editorial|default('Editorial') }}.</span>
                                            </div>
                                            {% if bibliografia.disponibles|length > 0 %}
                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles({{ bibliografia.id }}, '{{ bibliografia.titulo|e('js') }}')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            {% endif %}
                                        </div>
                                    </div>
                                    {% endfor %}
                                {% else %}
                                    <p class=\"no-bibliography\">No hay bibliografía complementaria disponible.</p>
                                {% endif %}
                            </div>
                            
                            <!-- Other Bibliography -->
                            <div class=\"bib-content\" id=\"otros-{{ asignatura.asignatura_id }}\">
                                {% set bibliografiasOtros = asignatura.bibliografias|filter(b => b.tipo_bibliografia != 'basica' and b.tipo_bibliografia != 'complementaria') %}
                                {% if bibliografiasOtros|length > 0 %}
                                    {% for bibliografia in bibliografiasOtros %}
                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>{{ bibliografia.autores|default('Autor') }}, {{ bibliografia.anio_publicacion|default('Año') }}. {{ bibliografia.titulo }}. {{ bibliografia.editorial|default('Editorial') }}.</span>
                                            </div>
                                            {% if bibliografia.disponibles|length > 0 %}
                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles({{ bibliografia.id }}, '{{ bibliografia.titulo|e('js') }}')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            {% endif %}
                                        </div>
                                    </div>
                                    {% endfor %}
                                {% else %}
                                    <p class=\"no-bibliography\">No hay otros tipos de bibliografía disponibles.</p>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
                {% endfor %}
            </div>
            {% endfor %}
        {% else %}
            <div class=\"no-content\">
                <i class=\"fas fa-info-circle\"></i>
                <p>No hay asignaturas registradas para esta carrera en esta sede.</p>
            </div>
        {% endif %}
    </div>
</section>

<!-- Botón de Regreso -->
<section class=\"container mb-5\">
    <div class=\"text-center\">
        <a href=\"{{ app_url }}\" class=\"btn btn-outline-primary\">
            <i class=\"fas fa-arrow-left me-2\"></i>
            Volver al Inicio
        </a>
    </div>
</section>

<!-- Modal de Bibliografías Disponibles -->
<div class=\"modal fade\" id=\"modalBibliografiasDisponibles\" tabindex=\"-1\" aria-labelledby=\"modalBibliografiasDisponiblesLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalBibliografiasDisponiblesLabel\">
                    <i class=\"fas fa-book me-2\"></i>
                    Bibliografías Disponibles
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"modalContent\">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">
                    <i class=\"fas fa-times me-1\"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el modal -->
<script>
function mostrarBibliografiasDisponibles(bibliografiaId, titulo) {
    // Mostrar loading
    document.getElementById('modalContent').innerHTML = `
        <div class=\"text-center\">
            <div class=\"spinner-border text-primary\" role=\"status\">
                <span class=\"visually-hidden\">Cargando...</span>
            </div>
            <p class=\"mt-2\">Cargando bibliografías disponibles...</p>
        </div>
    `;
    
    // Actualizar título del modal
    document.getElementById('modalBibliografiasDisponiblesLabel').innerHTML = `
        <i class=\"fas fa-book me-2\"></i>
        Bibliografías Disponibles: \${titulo}
    `;
    
    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalBibliografiasDisponibles'));
    modal.show();
    
    // Cargar datos
    fetch(`\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarBibliografiasEnModal(data.bibliografias);
            } else {
                document.getElementById('modalContent').innerHTML = `
                    <div class=\"alert alert-danger\">
                        <i class=\"fas fa-exclamation-triangle me-2\"></i>
                        Error al cargar las bibliografías: \${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('modalContent').innerHTML = `
                <div class=\"alert alert-danger\">
                    <i class=\"fas fa-exclamation-triangle me-2\"></i>
                    Error de conexión: \${error.message}
                </div>
            `;
        });
}

function mostrarBibliografiasEnModal(bibliografias) {
    if (bibliografias.length === 0) {
        document.getElementById('modalContent').innerHTML = `
            <div class=\"alert alert-info\">
                <i class=\"fas fa-info-circle me-2\"></i>
                No hay bibliografías disponibles para mostrar.
            </div>
        `;
        return;
    }
    
    let html = '<div class=\"row\">';
    
    bibliografias.forEach(bib => {
        html += `
            <div class=\"col-12 mb-3\">
                <div class=\"card\">
                    <div class=\"card-body\">
                        <h6 class=\"card-title\">\${bib.titulo}</h6>
                        <div class=\"row\">
                            <div class=\"col-md-8\">
                                <p class=\"mb-1\"><strong>Autor(es):</strong> \${bib.autores || 'No especificado'}</p>
                                <p class=\"mb-1\"><strong>Año:</strong> \${bib.anio_edicion}</p>
                                <p class=\"mb-1\"><strong>Editorial:</strong> \${bib.editorial || 'No especificada'}</p>
                                <p class=\"mb-1\"><strong>Disponibilidad:</strong> 
                                    <span class=\"badge bg-\${bib.disponibilidad === 'electronico' ? 'success' : bib.disponibilidad === 'impreso' ? 'primary' : 'info'}\">
                                        \${bib.disponibilidad}
                                    </span>
                                </p>
                            </div>
                            <div class=\"col-md-4 text-end\">
                                \${bib.url_acceso ? `
                                    <a href=\"\${bib.url_acceso}\" target=\"_blank\" class=\"btn btn-success btn-sm mb-1 w-100\">
                                        <i class=\"fas fa-external-link-alt me-1\"></i>
                                        Acceso Directo
                                    </a>
                                ` : ''}
                                \${bib.url_catalogo ? `
                                    <a href=\"\${bib.url_catalogo}\" target=\"_blank\" class=\"btn btn-primary btn-sm w-100\">
                                        <i class=\"fas fa-search me-1\"></i>
                                        Ver en Catálogo
                                    </a>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    document.getElementById('modalContent').innerHTML = html;
}
</script>
{% endblock %} ", "frontend/carrera.twig", "/var/www/html/biblioges/templates/frontend/carrera.twig");
    }
}
