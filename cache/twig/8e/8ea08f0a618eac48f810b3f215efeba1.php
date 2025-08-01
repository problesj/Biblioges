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

/* frontend/index.twig */
class __TwigTemplate_803fc1d1cc8d2ce62a4ece97cbedd28e extends Template
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
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografía UCN - Carreras de Pregrado";
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
        yield "<!-- Hero Section -->
<section class=\"hero-section\">
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\">
        ";
        // line 39
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["carreras"] ?? null)) > 0)) {
            // line 40
            yield "            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 41
                yield "            <div class=\"col-md-6 col-lg-4 mb-4\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        ";
                // line 44
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 44)) {
                    // line 45
                    yield "                            <img src=\"/biblioges/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 45), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 45), "html", null, true);
                    yield "\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                } else {
                    // line 47
                    yield "                            <img src=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["assets_url"] ?? null), "html", null, true);
                    yield "/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                }
                // line 49
                yield "                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">";
                // line 51
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 51), "html", null, true);
                yield "</h5>
                        <p class=\"card-text\">";
                // line 52
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", true, true, false, 52)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", false, false, false, 52), "Forma profesionales capaces de optimizar procesos productivos y de servicios.")) : ("Forma profesionales capaces de optimizar procesos productivos y de servicios.")), "html", null, true);
                yield "</p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>";
                // line 56
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", true, true, false, 56)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", false, false, false, 56), 10)) : (10)), "html", null, true);
                yield " semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>Antofagasta</span>
                            </div>
                        </div>
                        ";
                // line 63
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 63)) {
                    // line 64
                    yield "                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/carrera/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 64), "html", null, true);
                    yield "/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 64), "html", null, true);
                    yield "\" 
                           class=\"btn btn-primary btn-ver-bibliografia\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        ";
                } else {
                    // line 70
                    yield "                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        ";
                }
                // line 75
                yield "                    </div>
                </div>
            </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 79
            yield "        ";
        } else {
            // line 80
            yield "            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        ";
        }
        // line 87
        yield "    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/index.twig";
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
        return array (  202 => 87,  193 => 80,  190 => 79,  181 => 75,  174 => 70,  160 => 64,  158 => 63,  148 => 56,  141 => 52,  137 => 51,  133 => 49,  127 => 47,  119 => 45,  117 => 44,  112 => 41,  107 => 40,  105 => 39,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}Bibliografía UCN - Carreras de Pregrado{% endblock %}

{% block content %}
<!-- Hero Section -->
<section class=\"hero-section\">
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\">
        {% if carreras|length > 0 %}
            {% for carrera in carreras %}
            <div class=\"col-md-6 col-lg-4 mb-4\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        {% if carrera.imagen_url %}
                            <img src=\"/biblioges/{{ carrera.imagen_url }}\" alt=\"{{ carrera.nombre }}\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% else %}
                            <img src=\"{{ assets_url }}/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% endif %}
                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{{ carrera.nombre }}</h5>
                        <p class=\"card-text\">{{ carrera.descripcion|default('Forma profesionales capaces de optimizar procesos productivos y de servicios.') }}</p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>{{ carrera.cantidad_semestres|default(10) }} semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>Antofagasta</span>
                            </div>
                        </div>
                        {% if carrera.sede_id %}
                        <a href=\"{{ app_url }}/carrera/{{ carrera.sede_id }}/{{ carrera.id }}\" 
                           class=\"btn btn-primary btn-ver-bibliografia\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        {% else %}
                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% endfor %}
        {% else %}
            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        {% endif %}
    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{% endblock %} ", "frontend/index.twig", "/var/www/html/biblioges/templates/frontend/index.twig");
    }
}
