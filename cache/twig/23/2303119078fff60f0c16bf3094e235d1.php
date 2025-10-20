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
            'meta' => [$this, 'block_meta'],
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

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_meta(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 5
        yield "    ";
        $context["canonical"] = ((((($context["app_url"] ?? null) . "/carrera/") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_id", [], "any", false, false, false, 5)) . "/") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "id", [], "any", false, false, false, 5));
        // line 6
        yield "    ";
        $context["img"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 6)) ? (((($context["app_url"] ?? null) . "/biblioges/") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 6))) : ((($context["assets_url"] ?? null) . "/images/carreras/default.svg")));
        // line 7
        yield "    ";
        $context["share_title"] = ((("Bibliografía de la carrera/programa " . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 7)) . " - Sede: ") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 7));
        // line 8
        yield "    ";
        $context["share_desc"] = (((("Se detalla la bibliografía de la carrera/programa " . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 8)) . " de la sede ") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 8)) . ", informando bibliografía básica, complementaria u otra y su disponibilidad en formato impreso, electrónico o ambos.");
        // line 9
        yield "    <link rel=\"canonical\" href=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["canonical"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"description\" content=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:title\" content=\"";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:description\" content=\"";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:image\" content=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:url\" content=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["canonical"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:type\" content=\"article\">
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:title\" content=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:description\" content=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:image\" content=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
";
        yield from [];
    }

    // line 22
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 23
        yield "<!-- Header -->
<header class=\"ucn-header\">
    <div class=\"container\">
        <a href=\"";
        // line 26
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
        // line 39
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 39)) {
            // line 40
            yield "                        <img src=\"/biblioges/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "imagen_url", [], "any", false, false, false, 40), "html", null, true);
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 40), "html", null, true);
            yield "\" style=\"object-fit:cover; width:100%; height:200px;\">
                    ";
        } else {
            // line 42
            yield "                        <img src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["assets_url"] ?? null), "html", null, true);
            yield "/images/carreras/default.svg\" alt=\"Sin imagen\" style=\"object-fit:cover; width:100%; height:200px;\">
                    ";
        }
        // line 44
        yield "                </div>
            </div>
            <div class=\"col-md-9\">
                <h1 class=\"program-title\">";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 47), "html", null, true);
        yield "</h1>
                <p class=\"program-description\">";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "descripcion", [], "any", true, true, false, 48)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "descripcion", [], "any", false, false, false, 48), "Forma profesionales capaces de optimizar procesos productivos y de servicios.")) : ("Forma profesionales capaces de optimizar procesos productivos y de servicios.")), "html", null, true);
        yield "</p>
                ";
        // line 49
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 49) && (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 49) != CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 49)))) {
            // line 50
            yield "                <div class=\"alert alert-info\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    <strong>Esta carrera se dicta en múltiples sedes:</strong> ";
            // line 52
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 52), "html", null, true);
            yield "
                    <br><small>Mostrando información para la sede: <strong>";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 53), "html", null, true);
            yield "</strong></small>
                </div>
                ";
        }
        // line 56
        yield "                <div class=\"program-stats\">
                    <div class=\"stat-item\">
                        <i class=\"fas fa-clock\"></i>
                        <span>Duración: ";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", true, true, false, 59)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "cantidad_semestres", [], "any", false, false, false, 59), 10)) : (10)), "html", null, true);
        yield " semestres</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        <span>Sede: ";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 63), "html", null, true);
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 63) && (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 63) != CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 63)))) {
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "todas_las_sedes", [], "any", false, false, false, 63), "html", null, true);
            yield ")";
        }
        yield "</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-bookmark\"></i>
                        <span>Semestres: ";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["asignaturas_por_semestre"] ?? null)), "html", null, true);
        yield "</span>
                    </div>
                </div>
                <div class=\"mt-3 d-flex align-items-center gap-2 flex-wrap share-buttons\">
                    <span class=\"fw-semibold me-1\">Compartir:</span>
                    <button class=\"btn btn-outline-secondary\" title=\"Facebook\" onclick=\"shareTo('facebook', { title: '";
        // line 72
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 72), "html", null, true);
        yield "', text: 'Bibliografía oficial - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 72), "html", null, true);
        yield "' })\">
                        <i class=\"fab fa-facebook-f\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"X\" onclick=\"shareTo('x', { title: '";
        // line 75
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 75), "html", null, true);
        yield "', text: 'Bibliografía oficial - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 75), "html", null, true);
        yield "' })\">
                        <i class=\"fab fa-twitter\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"WhatsApp\" onclick=\"shareTo('whatsapp', { text: '";
        // line 78
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 78), "html", null, true);
        yield " · ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 78), "html", null, true);
        yield "' })\">
                        <i class=\"fab fa-whatsapp\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"Telegram\" onclick=\"shareTo('telegram', { text: '";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 81), "html", null, true);
        yield " · ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 81), "html", null, true);
        yield "' })\">
                        <i class=\"fab fa-telegram-plane\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"Copiar enlace\" onclick=\"shareTo('copy', { title: '";
        // line 84
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 84), "html", null, true);
        yield "' })\">
                        <i class=\"fas fa-link\"></i>
                    </button>
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
        // line 98
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 98), "html", null, true);
        yield "</span>
        </nav>

        <!-- Semester Navigation Tabs -->
        <div class=\"semester-tabs\">
            ";
        // line 103
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
            // line 104
            yield "            <button class=\"semester-tab ";
            if (CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 104)) {
                yield "active";
            }
            yield "\" 
                    onclick=\"showSemester(";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
            yield ")\">
                Semestre ";
            // line 106
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
        // line 109
        yield "        </div>

        <!-- Semester Content -->
        ";
        // line 112
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["asignaturas_por_semestre"] ?? null)) > 0)) {
            // line 113
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
                // line 114
                yield "            <div class=\"semester-content ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 114)) {
                    yield "active";
                }
                yield "\" id=\"semester-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
                yield "\">
                <h2 class=\"semester-title\">Semestre ";
                // line 115
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
                yield "</h2>
                
                ";
                // line 117
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["asignaturas"]);
                foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                    // line 118
                    yield "                <div class=\"course-section\">
                    <h3 class=\"course-title\">";
                    // line 119
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_nombre", [], "any", false, false, false, 119), "html", null, true);
                    yield "</h3>
                    <p class=\"course-code\">Código: ";
                    // line 120
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigo_asignatura", [], "any", false, false, false, 120), "html", null, true);
                    yield "</p>
                    ";
                    // line 121
                    $context["asignatura_url"] = ((((($context["app_url"] ?? null) . "/asignatura-biblio/") . CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_id", [], "any", false, false, false, 121)) . "/") . CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 121));
                    // line 122
                    yield "                    <div class=\"mb-2\">
                        <a href=\"";
                    // line 123
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/asignatura-biblio/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_id", [], "any", false, false, false, 123), "html", null, true);
                    yield "/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 123), "html", null, true);
                    yield "\" target=\"_blank\" class=\"btn btn-primary btn-sm\" title=\"Ver bibliografía completa de la asignatura en nueva ventana\">
                            <i class=\"fas fa-book me-1\"></i>Ver Bibliografía
                            <i class=\"fas fa-external-link-alt ms-1\" style=\"font-size: 0.8em;\"></i>
                        </a>
                    </div>
                    
                    <div class=\"bibliography-section\">
                        <h4 class=\"bibliography-title\">
                            <i class=\"fas fa-bookmark\"></i>
                            Bibliografía
                        </h4>
                        
                        <!-- Bibliography Tabs -->
                        <div class=\"bibliography-tabs\">
                            <button class=\"bib-tab active\" onclick=\"showBibliography('basica', ";
                    // line 137
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 137), "html", null, true);
                    yield ")\">
                                <i class=\"fas fa-star\"></i>
                                Básicas
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('complementaria', ";
                    // line 141
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 141), "html", null, true);
                    yield ")\">
                                <i class=\"far fa-star\"></i>
                                Complementarias
                            </button>
                            <button class=\"bib-tab\" onclick=\"showBibliography('otros', ";
                    // line 145
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 145), "html", null, true);
                    yield ")\">
                                <i class=\"fas fa-bookmark\"></i>
                                Otros
                            </button>
                        </div>
                        
                        <!-- Bibliography Content -->
                        <div class=\"bibliography-content\">
                            <!-- Basic Bibliography -->
                            <div class=\"bib-content active\" id=\"basica-";
                    // line 154
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 154), "html", null, true);
                    yield "\">
                                ";
                    // line 155
                    $context["bibliografiasBasicas"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 155), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 155) == "basica"); });
                    // line 156
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasBasicas"] ?? null)) > 0)) {
                        // line 157
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasBasicas"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 158
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 162
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 162)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 162), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 162)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 162), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 162), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 162)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 162), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 164
                            if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 164)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 164))) {
                                // line 165
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 166
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 166), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 166), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 171
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 174
                        yield "                                ";
                    } else {
                        // line 175
                        yield "                                    <p class=\"no-bibliography\">No hay bibliografía básica disponible.</p>
                                ";
                    }
                    // line 177
                    yield "                            </div>
                            
                            <!-- Complementary Bibliography -->
                            <div class=\"bib-content\" id=\"complementaria-";
                    // line 180
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 180), "html", null, true);
                    yield "\">
                                ";
                    // line 181
                    $context["bibliografiasComplementarias"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 181), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 181) == "complementaria"); });
                    // line 182
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasComplementarias"] ?? null)) > 0)) {
                        // line 183
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasComplementarias"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 184
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 188
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 188)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 188), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 188)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 188), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 188), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 188)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 188), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 190
                            if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 190)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 190))) {
                                // line 191
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 192
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 192), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 192), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 197
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 200
                        yield "                                ";
                    } else {
                        // line 201
                        yield "                                    <p class=\"no-bibliography\">No hay bibliografía complementaria disponible.</p>
                                ";
                    }
                    // line 203
                    yield "                            </div>
                            
                            <!-- Other Bibliography -->
                            <div class=\"bib-content\" id=\"otros-";
                    // line 206
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_id", [], "any", false, false, false, 206), "html", null, true);
                    yield "\">
                                ";
                    // line 207
                    $context["bibliografiasOtros"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "bibliografias", [], "any", false, false, false, 207), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return ((CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 207) != "basica") && (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 207) != "complementaria")); });
                    // line 208
                    yield "                                ";
                    if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasOtros"] ?? null)) > 0)) {
                        // line 209
                        yield "                                    ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasOtros"] ?? null));
                        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                            // line 210
                            yield "                                    <div class=\"bibliography-item\">
                                        <div class=\"d-flex justify-content-between align-items-start\">
                                            <div class=\"flex-grow-1\">
                                                <i class=\"fas fa-file-alt\"></i>
                                                <span>";
                            // line 214
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 214)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 214), "Autor")) : ("Autor")), "html", null, true);
                            yield ", ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 214)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 214), "Año")) : ("Año")), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 214), "html", null, true);
                            yield ". ";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 214)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 214), "Editorial")) : ("Editorial")), "html", null, true);
                            yield ".</span>
                                            </div>
                                            ";
                            // line 216
                            if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 216)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 216))) {
                                // line 217
                                yield "                                            <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                                    onclick=\"mostrarBibliografiasDisponibles(";
                                // line 218
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 218), "html", null, true);
                                yield ", '";
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 218), "js"), "html", null, true);
                                yield "')\">
                                                <i class=\"fas fa-list me-1 text-white\"></i>
                                                Ver Disponibles
                                            </button>
                                            ";
                            }
                            // line 223
                            yield "                                        </div>
                                    </div>
                                    ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 226
                        yield "                                ";
                    } else {
                        // line 227
                        yield "                                    <p class=\"no-bibliography\">No hay otros tipos de bibliografía disponibles.</p>
                                ";
                    }
                    // line 229
                    yield "                            </div>
                        </div>
                    </div>
                </div>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 234
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
            // line 236
            yield "        ";
        } else {
            // line 237
            yield "            <div class=\"no-content\">
                <i class=\"fas fa-info-circle\"></i>
                <p>No hay asignaturas registradas para esta carrera en esta sede.</p>
            </div>
        ";
        }
        // line 242
        yield "    </div>
</section>

<!-- Botón de Regreso -->
<section class=\"container mb-5\">
    <div class=\"text-center\">
        <a href=\"";
        // line 248
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
    
    // Cargar datos con filtro por sede
    const sedeId = ";
        // line 306
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_id", [], "any", false, false, false, 306), "html", null, true);
        yield ";
    const url = sedeId ? 
        `\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}?sede_id=\${sedeId}` :
        `\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}`;
    
    fetch(url)
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
        return array (  736 => 306,  675 => 248,  667 => 242,  660 => 237,  657 => 236,  642 => 234,  632 => 229,  628 => 227,  625 => 226,  617 => 223,  607 => 218,  604 => 217,  602 => 216,  591 => 214,  585 => 210,  580 => 209,  577 => 208,  575 => 207,  571 => 206,  566 => 203,  562 => 201,  559 => 200,  551 => 197,  541 => 192,  538 => 191,  536 => 190,  525 => 188,  519 => 184,  514 => 183,  511 => 182,  509 => 181,  505 => 180,  500 => 177,  496 => 175,  493 => 174,  485 => 171,  475 => 166,  472 => 165,  470 => 164,  459 => 162,  453 => 158,  448 => 157,  445 => 156,  443 => 155,  439 => 154,  427 => 145,  420 => 141,  413 => 137,  392 => 123,  389 => 122,  387 => 121,  383 => 120,  379 => 119,  376 => 118,  372 => 117,  367 => 115,  358 => 114,  340 => 113,  338 => 112,  333 => 109,  316 => 106,  312 => 105,  305 => 104,  288 => 103,  280 => 98,  263 => 84,  255 => 81,  247 => 78,  239 => 75,  231 => 72,  223 => 67,  211 => 63,  204 => 59,  199 => 56,  193 => 53,  189 => 52,  185 => 50,  183 => 49,  179 => 48,  175 => 47,  170 => 44,  164 => 42,  156 => 40,  154 => 39,  138 => 26,  133 => 23,  126 => 22,  119 => 19,  115 => 18,  111 => 17,  105 => 14,  101 => 13,  97 => 12,  93 => 11,  89 => 10,  84 => 9,  81 => 8,  78 => 7,  75 => 6,  72 => 5,  65 => 4,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}{{ carrera.carrera_nombre }} - Bibliografía UCN{% endblock %}
{% block meta %}
    {% set canonical = app_url ~ '/carrera/' ~ carrera.sede_id ~ '/' ~ carrera.id %}
    {% set img = carrera.imagen_url ? (app_url ~ '/biblioges/' ~ carrera.imagen_url) : (assets_url ~ '/images/carreras/default.svg') %}
    {% set share_title = 'Bibliografía de la carrera/programa ' ~ carrera.carrera_nombre ~ ' - Sede: ' ~ carrera.sede_nombre %}
    {% set share_desc = 'Se detalla la bibliografía de la carrera/programa ' ~ carrera.carrera_nombre ~ ' de la sede ' ~ carrera.sede_nombre ~ ', informando bibliografía básica, complementaria u otra y su disponibilidad en formato impreso, electrónico o ambos.' %}
    <link rel=\"canonical\" href=\"{{ canonical }}\">
    <meta name=\"description\" content=\"{{ share_desc }}\">
    <meta property=\"og:title\" content=\"{{ share_title }}\">
    <meta property=\"og:description\" content=\"{{ share_desc }}\">
    <meta property=\"og:image\" content=\"{{ img }}\">
    <meta property=\"og:url\" content=\"{{ canonical }}\">
    <meta property=\"og:type\" content=\"article\">
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:title\" content=\"{{ share_title }}\">
    <meta name=\"twitter:description\" content=\"{{ share_desc }}\">
    <meta name=\"twitter:image\" content=\"{{ img }}\">
{% endblock %}

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
                {% if carrera.todas_las_sedes and carrera.todas_las_sedes != carrera.sede_nombre %}
                <div class=\"alert alert-info\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    <strong>Esta carrera se dicta en múltiples sedes:</strong> {{ carrera.todas_las_sedes }}
                    <br><small>Mostrando información para la sede: <strong>{{ carrera.sede_nombre }}</strong></small>
                </div>
                {% endif %}
                <div class=\"program-stats\">
                    <div class=\"stat-item\">
                        <i class=\"fas fa-clock\"></i>
                        <span>Duración: {{ carrera.cantidad_semestres|default(10) }} semestres</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-map-marker-alt\"></i>
                        <span>Sede: {{ carrera.sede_nombre }}{% if carrera.todas_las_sedes and carrera.todas_las_sedes != carrera.sede_nombre %} ({{ carrera.todas_las_sedes }}){% endif %}</span>
                    </div>
                    <div class=\"stat-item\">
                        <i class=\"fas fa-bookmark\"></i>
                        <span>Semestres: {{ asignaturas_por_semestre|length }}</span>
                    </div>
                </div>
                <div class=\"mt-3 d-flex align-items-center gap-2 flex-wrap share-buttons\">
                    <span class=\"fw-semibold me-1\">Compartir:</span>
                    <button class=\"btn btn-outline-secondary\" title=\"Facebook\" onclick=\"shareTo('facebook', { title: '{{ carrera.carrera_nombre }}', text: 'Bibliografía oficial - {{ carrera.sede_nombre }}' })\">
                        <i class=\"fab fa-facebook-f\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"X\" onclick=\"shareTo('x', { title: '{{ carrera.carrera_nombre }}', text: 'Bibliografía oficial - {{ carrera.sede_nombre }}' })\">
                        <i class=\"fab fa-twitter\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"WhatsApp\" onclick=\"shareTo('whatsapp', { text: '{{ carrera.carrera_nombre }} · {{ carrera.sede_nombre }}' })\">
                        <i class=\"fab fa-whatsapp\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"Telegram\" onclick=\"shareTo('telegram', { text: '{{ carrera.carrera_nombre }} · {{ carrera.sede_nombre }}' })\">
                        <i class=\"fab fa-telegram-plane\"></i>
                    </button>
                    <button class=\"btn btn-outline-secondary\" title=\"Copiar enlace\" onclick=\"shareTo('copy', { title: '{{ carrera.carrera_nombre }}' })\">
                        <i class=\"fas fa-link\"></i>
                    </button>
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
                    {% set asignatura_url = app_url ~ '/asignatura-biblio/' ~ carrera.sede_id ~ '/' ~ asignatura.asignatura_id %}
                    <div class=\"mb-2\">
                        <a href=\"{{ app_url }}/asignatura-biblio/{{ carrera.sede_id }}/{{ asignatura.asignatura_id }}\" target=\"_blank\" class=\"btn btn-primary btn-sm\" title=\"Ver bibliografía completa de la asignatura en nueva ventana\">
                            <i class=\"fas fa-book me-1\"></i>Ver Bibliografía
                            <i class=\"fas fa-external-link-alt ms-1\" style=\"font-size: 0.8em;\"></i>
                        </a>
                    </div>
                    
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
                                            {% if bibliografia.disponibles|length > 0 and bibliografia.tiene_disponibles %}
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
                                            {% if bibliografia.disponibles|length > 0 and bibliografia.tiene_disponibles %}
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
                                            {% if bibliografia.disponibles|length > 0 and bibliografia.tiene_disponibles %}
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
    
    // Cargar datos con filtro por sede
    const sedeId = {{ carrera.sede_id }};
    const url = sedeId ? 
        `\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}?sede_id=\${sedeId}` :
        `\${window.location.origin}/api/bibliografias-disponibles/\${bibliografiaId}`;
    
    fetch(url)
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
