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

/* frontend/asignatura_biblio.twig */
class __TwigTemplate_d149e771d791e5c82baf29bc318518e1 extends Template
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
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/asignatura_biblio.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 3), "html", null, true);
        yield " - Bibliografías";
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
        $context["canonical"] = ((((($context["app_url"] ?? null) . "/asignatura-biblio/") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_id", [], "any", false, false, false, 5)) . "/") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_id", [], "any", false, false, false, 5));
        // line 6
        yield "    ";
        $context["img"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "imagen_url", [], "any", false, false, false, 6) && (CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "imagen_url", [], "any", false, false, false, 6) != ""))) ? (((($context["app_url"] ?? null) . "/biblioges/") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "imagen_url", [], "any", false, false, false, 6))) : ((($context["assets_url"] ?? null) . "/images/carreras/default.svg")));
        // line 7
        yield "    ";
        $context["share_title"] = ((((("Bibliografía de la carrera/programa " . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "carrera_nombre", [], "any", false, false, false, 7)) . " - Sede: ") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_nombre", [], "any", false, false, false, 7)) . " - Asignatura: ") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 7));
        // line 8
        yield "    ";
        $context["share_desc"] = (((((("Se detalla la bibliografía de la carrera/programa " . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "carrera_nombre", [], "any", false, false, false, 8)) . " de la sede ") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_nombre", [], "any", false, false, false, 8)) . ", informando bibliografía básica, complementaria u otra y su disponibilidad en formato impreso, electrónico o ambos, de la asignatura ") . CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 8)) . ".");
        // line 9
        yield "    
    <!-- Canonical URL -->
    <link rel=\"canonical\" href=\"";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["canonical"] ?? null), "html", null, true);
        yield "\">
    
    <!-- Basic Meta Tags -->
    <meta name=\"description\" content=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"keywords\" content=\"bibliografía, ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "carrera_nombre", [], "any", false, false, false, 15)), "html", null, true);
        yield ", ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_nombre", [], "any", false, false, false, 15)), "html", null, true);
        yield ", ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 15)), "html", null, true);
        yield ", universidad, libros, recursos académicos\">
    <meta name=\"author\" content=\"Sistema Biblioges\">
    <meta name=\"robots\" content=\"index, follow\">
    
    <!-- Open Graph / Facebook -->
    <meta property=\"og:type\" content=\"article\">
    <meta property=\"og:url\" content=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["canonical"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:title\" content=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:description\" content=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:image\" content=\"";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"og:image:width\" content=\"1200\">
    <meta property=\"og:image:height\" content=\"630\">
    <meta property=\"og:image:alt\" content=\"Bibliografía de ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 27), "html", null, true);
        yield "\">
    <meta property=\"og:site_name\" content=\"Biblioges\">
    <meta property=\"og:locale\" content=\"es_ES\">
    
    <!-- Twitter Card -->
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:url\" content=\"";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["canonical"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:title\" content=\"";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:description\" content=\"";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:image\" content=\"";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    <meta name=\"twitter:image:alt\" content=\"Bibliografía de ";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 37), "html", null, true);
        yield "\">
    
    <!-- LinkedIn -->
    <meta property=\"linkedin:title\" content=\"";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"linkedin:description\" content=\"";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"linkedin:image\" content=\"";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    
    <!-- WhatsApp -->
    <meta property=\"whatsapp:title\" content=\"";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"whatsapp:description\" content=\"";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"whatsapp:image\" content=\"";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    
    <!-- Telegram -->
    <meta property=\"telegram:title\" content=\"";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_title"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"telegram:description\" content=\"";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["share_desc"] ?? null), "html", null, true);
        yield "\">
    <meta property=\"telegram:image\" content=\"";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["img"] ?? null), "html", null, true);
        yield "\">
    
    <!-- Additional Meta Tags for better SEO -->
    <meta name=\"theme-color\" content=\"#2c3e50\">
    <meta name=\"msapplication-TileColor\" content=\"#2c3e50\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"default\">
    <meta name=\"apple-mobile-web-app-title\" content=\"Biblioges\">
";
        yield from [];
    }

    // line 62
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 63
        if ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo_asignatura", [], "any", false, false, false, 63)) == "formacion electiva")) {
            // line 64
            yield "<section class=\"container mb-4\">
    <div class=\"alert alert-warning\">
        <i class=\"fas fa-exclamation-triangle me-2\"></i>
        <strong>Asignatura de Formación Electiva:</strong> Esta asignatura no requiere bibliografía específica.
    </div>
</section>
";
        } else {
            // line 71
            yield "<section class=\"container mb-4\">
    <div class=\"card\">
        <div class=\"card-body\">
            <div class=\"d-flex justify-content-between align-items-center flex-wrap\">
                <div>
                    <h1 class=\"h3 mb-1\" style=\"cursor: pointer; color: #2c3e50; transition: color 0.3s ease;\" onclick=\"mostrarDetallesAsignatura()\" title=\"Hacer clic para ver detalles de la asignatura\" onmouseover=\"this.style.color='#3498db'\" onmouseout=\"this.style.color='#2c3e50'\">
                        ";
            // line 77
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 77), "html", null, true);
            yield "
                        <i class=\"fas fa-info-circle ms-2 text-primary\" style=\"font-size: 0.8em;\"></i>
                    </h1>
                    <div class=\"text-muted\">
                        ";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "carrera_nombre", [], "any", false, false, false, 81), "html", null, true);
            yield " · ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_nombre", [], "any", false, false, false, 81), "html", null, true);
            yield "
                        <small class=\"text-primary ms-2\">
                            <i class=\"fas fa-hand-pointer me-1\"></i>Hacer clic en el título para ver detalles
                        </small>
                    </div>
                </div>
                <div class=\"share-buttons d-flex gap-2\">
                    <span class=\"fw-semibold me-1\">Compartir:</span>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Facebook\" onclick=\"shareTo('facebook')\"><i class=\"fab fa-facebook-f\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"X\" onclick=\"shareTo('x')\"><i class=\"fab fa-twitter\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"WhatsApp\" onclick=\"shareTo('whatsapp')\"><i class=\"fab fa-whatsapp\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Telegram\" onclick=\"shareTo('telegram')\"><i class=\"fab fa-telegram-plane\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Copiar\" onclick=\"shareTo('copy')\"><i class=\"fas fa-link\"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=\"container\">
    ";
            // line 101
            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)) > 0)) {
                // line 102
                yield "        ";
                $context["bibliografiasBasicas"] = Twig\Extension\CoreExtension::filter($this->env, ($context["bibliografias"] ?? null), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 102) == "basica"); });
                // line 103
                yield "        ";
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasBasicas"] ?? null)) > 0)) {
                    // line 104
                    yield "        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"fas fa-star me-2 text-primary\"></i>Básicas</h3>
            </div>
            <div class=\"card-body\">
                ";
                    // line 109
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasBasicas"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                        // line 110
                        yield "                <div class=\"bibliografia-item\">
                    <div class=\"d-flex justify-content-between align-items-start\">
                        <div class=\"flex-grow-1\">
                            <i class=\"fas fa-file-alt\"></i>
                            <span>";
                        // line 114
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 114), "Autor")) : ("Autor")), "html", null, true);
                        yield ", ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 114), "Año")) : ("Año")), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 114), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 114), "Editorial")) : ("Editorial")), "html", null, true);
                        yield ".</span>
                        </div>
                        ";
                        // line 116
                        if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 116)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 116))) {
                            // line 117
                            yield "                        <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                onclick=\"mostrarBibliografiasDisponibles(";
                            // line 118
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 118), "html", null, true);
                            yield ", '";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 118), "js"), "html", null, true);
                            yield "')\">
                            <i class=\"fas fa-list me-1 text-white\"></i>
                            Ver Disponibles
                        </button>
                        ";
                        }
                        // line 123
                        yield "                    </div>
                </div>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 126
                    yield "            </div>
        </div>
        ";
                }
                // line 129
                yield "
        ";
                // line 130
                $context["bibliografiasComplementarias"] = Twig\Extension\CoreExtension::filter($this->env, ($context["bibliografias"] ?? null), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 130) == "complementaria"); });
                // line 131
                yield "        ";
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasComplementarias"] ?? null)) > 0)) {
                    // line 132
                    yield "        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"far fa-star me-2 text-warning\"></i>Complementarias</h3>
            </div>
            <div class=\"card-body\">
                ";
                    // line 137
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasComplementarias"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                        // line 138
                        yield "                <div class=\"bibliografia-item\">
                    <div class=\"d-flex justify-content-between align-items-start\">
                        <div class=\"flex-grow-1\">
                            <i class=\"fas fa-file-alt\"></i>
                            <span>";
                        // line 142
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 142)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 142), "Autor")) : ("Autor")), "html", null, true);
                        yield ", ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 142)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 142), "Año")) : ("Año")), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 142), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 142)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 142), "Editorial")) : ("Editorial")), "html", null, true);
                        yield ".</span>
                        </div>
                        ";
                        // line 144
                        if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 144)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 144))) {
                            // line 145
                            yield "                        <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                onclick=\"mostrarBibliografiasDisponibles(";
                            // line 146
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 146), "html", null, true);
                            yield ", '";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 146), "js"), "html", null, true);
                            yield "')\">
                            <i class=\"fas fa-list me-1 text-white\"></i>
                            Ver Disponibles
                        </button>
                        ";
                        }
                        // line 151
                        yield "                    </div>
                </div>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 154
                    yield "            </div>
        </div>
        ";
                }
                // line 157
                yield "
        ";
                // line 158
                $context["bibliografiasOtros"] = Twig\Extension\CoreExtension::filter($this->env, ($context["bibliografias"] ?? null), function ($__b__) use ($context, $macros) { $context["b"] = $__b__; return ((CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 158) != "basica") && (CoreExtension::getAttribute($this->env, $this->source, ($context["b"] ?? null), "tipo_bibliografia", [], "any", false, false, false, 158) != "complementaria")); });
                // line 159
                yield "        ";
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografiasOtros"] ?? null)) > 0)) {
                    // line 160
                    yield "        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"fas fa-bookmark me-2 text-secondary\"></i>Otros</h3>
            </div>
            <div class=\"card-body\">
                ";
                    // line 165
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasOtros"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
                        // line 166
                        yield "                <div class=\"bibliografia-item\">
                    <div class=\"d-flex justify-content-between align-items-start\">
                        <div class=\"flex-grow-1\">
                            <i class=\"fas fa-file-alt\"></i>
                            <span>";
                        // line 170
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", true, true, false, 170)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 170), "Autor")) : ("Autor")), "html", null, true);
                        yield ", ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", true, true, false, 170)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 170), "Año")) : ("Año")), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 170), "html", null, true);
                        yield ". ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", true, true, false, 170)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "editorial", [], "any", false, false, false, 170), "Editorial")) : ("Editorial")), "html", null, true);
                        yield ".</span>
                        </div>
                        ";
                        // line 172
                        if (((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "disponibles", [], "any", false, false, false, 172)) > 0) && CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tiene_disponibles", [], "any", false, false, false, 172))) {
                            // line 173
                            yield "                        <button type=\"button\" class=\"btn btn-primary btn-sm ms-2\" 
                                onclick=\"mostrarBibliografiasDisponibles(";
                            // line 174
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 174), "html", null, true);
                            yield ", '";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 174), "js"), "html", null, true);
                            yield "')\">
                            <i class=\"fas fa-list me-1 text-white\"></i>
                            Ver Disponibles
                        </button>
                        ";
                        }
                        // line 179
                        yield "                    </div>
                </div>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 182
                    yield "            </div>
        </div>
        ";
                }
                // line 185
                yield "    ";
            } else {
                // line 186
                yield "        <div class=\"alert alert-info\">
            <i class=\"fas fa-info-circle me-2\"></i>No hay bibliografías registradas para esta asignatura.
        </div>
    ";
            }
            // line 190
            yield "</section>

<!-- Modal de Detalles de Asignatura -->
<div class=\"modal fade\" id=\"modalDetallesAsignatura\" tabindex=\"-1\" aria-labelledby=\"modalDetallesAsignaturaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalDetallesAsignaturaLabel\">
                    <i class=\"fas fa-book me-2\"></i>
                    Detalles de la Asignatura
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <h4>";
            // line 206
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "asignatura_nombre", [], "any", false, false, false, 206), "html", null, true);
            yield "</h4>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Carrera:</strong></p>
                                <p class=\"text-muted\">";
            // line 210
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "carrera_nombre", [], "any", false, false, false, 210), "html", null, true);
            yield "</p>
                            </div>
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Sede:</strong></p>
                                <p class=\"text-muted\">";
            // line 214
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_nombre", [], "any", false, false, false, 214), "html", null, true);
            yield "</p>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Tipo:</strong></p>
                                <p class=\"text-muted\">";
            // line 220
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo_asignatura", [], "any", true, true, false, 220)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "tipo_asignatura", [], "any", false, false, false, 220), "No especificado")) : ("No especificado")), "html", null, true);
            yield "</p>
                            </div>
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Bibliografías:</strong></p>
                                <p class=\"text-muted\">";
            // line 224
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["bibliografias"] ?? null)), "html", null, true);
            yield " registros</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"text-center\">
                            <h6 class=\"mb-3\">Compartir Asignatura</h6>
                            <div class=\"d-flex flex-column gap-2\">
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('facebook')\">
                                    <i class=\"fab fa-facebook-f me-2\"></i>Facebook
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('x')\">
                                    <i class=\"fab fa-twitter me-2\"></i>X (Twitter)
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('whatsapp')\">
                                    <i class=\"fab fa-whatsapp me-2\"></i>WhatsApp
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('telegram')\">
                                    <i class=\"fab fa-telegram-plane me-2\"></i>Telegram
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('copy')\">
                                    <i class=\"fas fa-link me-2\"></i>Copiar Enlace
                                </button>
                            </div>
                        </div>
                    </div>
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

<script>
function mostrarDetallesAsignatura() {
    const modal = new bootstrap.Modal(document.getElementById('modalDetallesAsignatura'));
    modal.show();
}

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
            // line 316
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["asignatura"] ?? null), "sede_id", [], "any", false, false, false, 316), "html", null, true);
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
        }
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/asignatura_biblio.twig";
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
        return array (  612 => 316,  517 => 224,  510 => 220,  501 => 214,  494 => 210,  487 => 206,  469 => 190,  463 => 186,  460 => 185,  455 => 182,  447 => 179,  437 => 174,  434 => 173,  432 => 172,  421 => 170,  415 => 166,  411 => 165,  404 => 160,  401 => 159,  399 => 158,  396 => 157,  391 => 154,  383 => 151,  373 => 146,  370 => 145,  368 => 144,  357 => 142,  351 => 138,  347 => 137,  340 => 132,  337 => 131,  335 => 130,  332 => 129,  327 => 126,  319 => 123,  309 => 118,  306 => 117,  304 => 116,  293 => 114,  287 => 110,  283 => 109,  276 => 104,  273 => 103,  270 => 102,  268 => 101,  243 => 81,  236 => 77,  228 => 71,  219 => 64,  217 => 63,  210 => 62,  196 => 52,  192 => 51,  188 => 50,  182 => 47,  178 => 46,  174 => 45,  168 => 42,  164 => 41,  160 => 40,  154 => 37,  150 => 36,  146 => 35,  142 => 34,  138 => 33,  129 => 27,  123 => 24,  119 => 23,  115 => 22,  111 => 21,  98 => 15,  94 => 14,  88 => 11,  84 => 9,  81 => 8,  78 => 7,  75 => 6,  72 => 5,  65 => 4,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}{{ asignatura.asignatura_nombre }} - Bibliografías{% endblock %}
{% block meta %}
    {% set canonical = app_url ~ '/asignatura-biblio/' ~ asignatura.sede_id ~ '/' ~ asignatura.asignatura_id %}
    {% set img = asignatura.imagen_url and asignatura.imagen_url != '' ? app_url ~ '/biblioges/' ~ asignatura.imagen_url : assets_url ~ '/images/carreras/default.svg' %}
    {% set share_title = 'Bibliografía de la carrera/programa ' ~ asignatura.carrera_nombre ~ ' - Sede: ' ~ asignatura.sede_nombre ~ ' - Asignatura: ' ~ asignatura.asignatura_nombre %}
    {% set share_desc = 'Se detalla la bibliografía de la carrera/programa ' ~ asignatura.carrera_nombre ~ ' de la sede ' ~ asignatura.sede_nombre ~ ', informando bibliografía básica, complementaria u otra y su disponibilidad en formato impreso, electrónico o ambos, de la asignatura ' ~ asignatura.asignatura_nombre ~ '.' %}
    
    <!-- Canonical URL -->
    <link rel=\"canonical\" href=\"{{ canonical }}\">
    
    <!-- Basic Meta Tags -->
    <meta name=\"description\" content=\"{{ share_desc }}\">
    <meta name=\"keywords\" content=\"bibliografía, {{ asignatura.carrera_nombre|lower }}, {{ asignatura.sede_nombre|lower }}, {{ asignatura.asignatura_nombre|lower }}, universidad, libros, recursos académicos\">
    <meta name=\"author\" content=\"Sistema Biblioges\">
    <meta name=\"robots\" content=\"index, follow\">
    
    <!-- Open Graph / Facebook -->
    <meta property=\"og:type\" content=\"article\">
    <meta property=\"og:url\" content=\"{{ canonical }}\">
    <meta property=\"og:title\" content=\"{{ share_title }}\">
    <meta property=\"og:description\" content=\"{{ share_desc }}\">
    <meta property=\"og:image\" content=\"{{ img }}\">
    <meta property=\"og:image:width\" content=\"1200\">
    <meta property=\"og:image:height\" content=\"630\">
    <meta property=\"og:image:alt\" content=\"Bibliografía de {{ asignatura.asignatura_nombre }}\">
    <meta property=\"og:site_name\" content=\"Biblioges\">
    <meta property=\"og:locale\" content=\"es_ES\">
    
    <!-- Twitter Card -->
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:url\" content=\"{{ canonical }}\">
    <meta name=\"twitter:title\" content=\"{{ share_title }}\">
    <meta name=\"twitter:description\" content=\"{{ share_desc }}\">
    <meta name=\"twitter:image\" content=\"{{ img }}\">
    <meta name=\"twitter:image:alt\" content=\"Bibliografía de {{ asignatura.asignatura_nombre }}\">
    
    <!-- LinkedIn -->
    <meta property=\"linkedin:title\" content=\"{{ share_title }}\">
    <meta property=\"linkedin:description\" content=\"{{ share_desc }}\">
    <meta property=\"linkedin:image\" content=\"{{ img }}\">
    
    <!-- WhatsApp -->
    <meta property=\"whatsapp:title\" content=\"{{ share_title }}\">
    <meta property=\"whatsapp:description\" content=\"{{ share_desc }}\">
    <meta property=\"whatsapp:image\" content=\"{{ img }}\">
    
    <!-- Telegram -->
    <meta property=\"telegram:title\" content=\"{{ share_title }}\">
    <meta property=\"telegram:description\" content=\"{{ share_desc }}\">
    <meta property=\"telegram:image\" content=\"{{ img }}\">
    
    <!-- Additional Meta Tags for better SEO -->
    <meta name=\"theme-color\" content=\"#2c3e50\">
    <meta name=\"msapplication-TileColor\" content=\"#2c3e50\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"default\">
    <meta name=\"apple-mobile-web-app-title\" content=\"Biblioges\">
{% endblock %}

{% block content %}
{% if asignatura.tipo_asignatura|lower == 'formacion electiva' %}
<section class=\"container mb-4\">
    <div class=\"alert alert-warning\">
        <i class=\"fas fa-exclamation-triangle me-2\"></i>
        <strong>Asignatura de Formación Electiva:</strong> Esta asignatura no requiere bibliografía específica.
    </div>
</section>
{% else %}
<section class=\"container mb-4\">
    <div class=\"card\">
        <div class=\"card-body\">
            <div class=\"d-flex justify-content-between align-items-center flex-wrap\">
                <div>
                    <h1 class=\"h3 mb-1\" style=\"cursor: pointer; color: #2c3e50; transition: color 0.3s ease;\" onclick=\"mostrarDetallesAsignatura()\" title=\"Hacer clic para ver detalles de la asignatura\" onmouseover=\"this.style.color='#3498db'\" onmouseout=\"this.style.color='#2c3e50'\">
                        {{ asignatura.asignatura_nombre }}
                        <i class=\"fas fa-info-circle ms-2 text-primary\" style=\"font-size: 0.8em;\"></i>
                    </h1>
                    <div class=\"text-muted\">
                        {{ asignatura.carrera_nombre }} · {{ asignatura.sede_nombre }}
                        <small class=\"text-primary ms-2\">
                            <i class=\"fas fa-hand-pointer me-1\"></i>Hacer clic en el título para ver detalles
                        </small>
                    </div>
                </div>
                <div class=\"share-buttons d-flex gap-2\">
                    <span class=\"fw-semibold me-1\">Compartir:</span>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Facebook\" onclick=\"shareTo('facebook')\"><i class=\"fab fa-facebook-f\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"X\" onclick=\"shareTo('x')\"><i class=\"fab fa-twitter\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"WhatsApp\" onclick=\"shareTo('whatsapp')\"><i class=\"fab fa-whatsapp\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Telegram\" onclick=\"shareTo('telegram')\"><i class=\"fab fa-telegram-plane\"></i></button>
                    <button class=\"btn btn-outline-secondary btn-sm\" title=\"Copiar\" onclick=\"shareTo('copy')\"><i class=\"fas fa-link\"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=\"container\">
    {% if bibliografias|length > 0 %}
        {% set bibliografiasBasicas = bibliografias|filter(b => b.tipo_bibliografia == 'basica') %}
        {% if bibliografiasBasicas|length > 0 %}
        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"fas fa-star me-2 text-primary\"></i>Básicas</h3>
            </div>
            <div class=\"card-body\">
                {% for bibliografia in bibliografiasBasicas %}
                <div class=\"bibliografia-item\">
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
            </div>
        </div>
        {% endif %}

        {% set bibliografiasComplementarias = bibliografias|filter(b => b.tipo_bibliografia == 'complementaria') %}
        {% if bibliografiasComplementarias|length > 0 %}
        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"far fa-star me-2 text-warning\"></i>Complementarias</h3>
            </div>
            <div class=\"card-body\">
                {% for bibliografia in bibliografiasComplementarias %}
                <div class=\"bibliografia-item\">
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
            </div>
        </div>
        {% endif %}

        {% set bibliografiasOtros = bibliografias|filter(b => b.tipo_bibliografia != 'basica' and b.tipo_bibliografia != 'complementaria') %}
        {% if bibliografiasOtros|length > 0 %}
        <div class=\"card mb-4\">
            <div class=\"card-header\">
                <h3 class=\"mb-0\"><i class=\"fas fa-bookmark me-2 text-secondary\"></i>Otros</h3>
            </div>
            <div class=\"card-body\">
                {% for bibliografia in bibliografiasOtros %}
                <div class=\"bibliografia-item\">
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
            </div>
        </div>
        {% endif %}
    {% else %}
        <div class=\"alert alert-info\">
            <i class=\"fas fa-info-circle me-2\"></i>No hay bibliografías registradas para esta asignatura.
        </div>
    {% endif %}
</section>

<!-- Modal de Detalles de Asignatura -->
<div class=\"modal fade\" id=\"modalDetallesAsignatura\" tabindex=\"-1\" aria-labelledby=\"modalDetallesAsignaturaLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"modalDetallesAsignaturaLabel\">
                    <i class=\"fas fa-book me-2\"></i>
                    Detalles de la Asignatura
                </h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <h4>{{ asignatura.asignatura_nombre }}</h4>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Carrera:</strong></p>
                                <p class=\"text-muted\">{{ asignatura.carrera_nombre }}</p>
                            </div>
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Sede:</strong></p>
                                <p class=\"text-muted\">{{ asignatura.sede_nombre }}</p>
                            </div>
                        </div>
                        <div class=\"row mb-3\">
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Tipo:</strong></p>
                                <p class=\"text-muted\">{{ asignatura.tipo_asignatura|default('No especificado') }}</p>
                            </div>
                            <div class=\"col-md-6\">
                                <p class=\"mb-1\"><strong>Bibliografías:</strong></p>
                                <p class=\"text-muted\">{{ bibliografias|length }} registros</p>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"text-center\">
                            <h6 class=\"mb-3\">Compartir Asignatura</h6>
                            <div class=\"d-flex flex-column gap-2\">
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('facebook')\">
                                    <i class=\"fab fa-facebook-f me-2\"></i>Facebook
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('x')\">
                                    <i class=\"fab fa-twitter me-2\"></i>X (Twitter)
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('whatsapp')\">
                                    <i class=\"fab fa-whatsapp me-2\"></i>WhatsApp
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('telegram')\">
                                    <i class=\"fab fa-telegram-plane me-2\"></i>Telegram
                                </button>
                                <button class=\"btn btn-outline-primary btn-sm\" onclick=\"shareTo('copy')\">
                                    <i class=\"fas fa-link me-2\"></i>Copiar Enlace
                                </button>
                            </div>
                        </div>
                    </div>
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

<script>
function mostrarDetallesAsignatura() {
    const modal = new bootstrap.Modal(document.getElementById('modalDetallesAsignatura'));
    modal.show();
}

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
    const sedeId = {{ asignatura.sede_id }};
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
{% endif %}
{% endblock %}


", "frontend/asignatura_biblio.twig", "/var/www/html/biblioges/templates/frontend/asignatura_biblio.twig");
    }
}
