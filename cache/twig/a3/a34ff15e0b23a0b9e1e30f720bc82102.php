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

/* bibliografias_declaradas/partials/libro_details.twig */
class __TwigTemplate_a773f3f63b5f71fea94ec1b9c51285d4 extends Template
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

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 2
        yield "<div class=\"mb-4\">
    <h3 class=\"text-primary\">
        <i class=\"fas fa-book\"></i> Libro
    </h3>
</div>

<div class=\"mb-3\">
    <h4 class=\"text-muted\">Título:</h4>
    <h2>";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 10), "html", null, true);
        yield "</h2>
</div>

<div class=\"mb-3\">
    <h4>Autor(es):</h4>
    <ul class=\"list-unstyled\">
        ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 16));
        foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
            // line 17
            yield "            <li>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 17), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 17), "html", null, true);
            yield "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        yield "    </ul>
</div>

<div class=\"mb-3\">
    <h4>Información General:</h4>
    <p><strong>Año de Edición:</strong> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_publicacion", [], "any", false, false, false, 24), "html", null, true);
        yield "</p>
    <p><strong>Editorial:</strong> ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 25), "html", null, true);
        yield "</p>
    ";
        // line 26
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "edicion", [], "any", false, false, false, 26)) {
            // line 27
            yield "        <p><strong>Edición:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "edicion", [], "any", false, false, false, 27), "html", null, true);
            yield "</p>
    ";
        }
        // line 29
        yield "    ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "isbn", [], "any", false, false, false, 29)) {
            // line 30
            yield "        <p><strong>ISBN:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "isbn", [], "any", false, false, false, 30), "html", null, true);
            yield "</p>
    ";
        }
        // line 32
        yield "    <p><strong>Formato:</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 32)), "html", null, true);
        yield "</p>
</div>

";
        // line 35
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 35)) {
            // line 36
            yield "    <div class=\"mb-3\">
        <h4>Enlaces:</h4>
        <div class=\"d-flex align-items-center\">
            <div class=\"me-3 text-break\" style=\"max-width: 70%;\">
                <a href=\"";
            // line 40
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 40), "html", null, true);
            yield "\" target=\"_blank\" class=\"text-primary\">
                    ";
            // line 41
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 41), "html", null, true);
            yield "
                </a>
            </div>
            <a href=\"";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 44), "html", null, true);
            yield "\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
            </a>
        </div>
    </div>
";
        }
        // line 50
        yield "
";
        // line 51
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nota", [], "any", false, false, false, 51)) {
            // line 52
            yield "    <div class=\"mb-3\">
        <h4>Nota:</h4>
        <p>";
            // line 54
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nota", [], "any", false, false, false, 54), "html", null, true);
            yield "</p>
    </div>
";
        }
        // line 56
        yield " ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "bibliografias_declaradas/partials/libro_details.twig";
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
        return array (  157 => 56,  151 => 54,  147 => 52,  145 => 51,  142 => 50,  133 => 44,  127 => 41,  123 => 40,  117 => 36,  115 => 35,  108 => 32,  102 => 30,  99 => 29,  93 => 27,  91 => 26,  87 => 25,  83 => 24,  76 => 19,  65 => 17,  61 => 16,  52 => 10,  42 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# Detalles específicos de un libro #}
<div class=\"mb-4\">
    <h3 class=\"text-primary\">
        <i class=\"fas fa-book\"></i> Libro
    </h3>
</div>

<div class=\"mb-3\">
    <h4 class=\"text-muted\">Título:</h4>
    <h2>{{ bibliografia.titulo }}</h2>
</div>

<div class=\"mb-3\">
    <h4>Autor(es):</h4>
    <ul class=\"list-unstyled\">
        {% for autor in bibliografia.autores %}
            <li>{{ autor.apellidos }}, {{ autor.nombres }}</li>
        {% endfor %}
    </ul>
</div>

<div class=\"mb-3\">
    <h4>Información General:</h4>
    <p><strong>Año de Edición:</strong> {{ bibliografia.anio_publicacion }}</p>
    <p><strong>Editorial:</strong> {{ bibliografia.editorial }}</p>
    {% if bibliografia.edicion %}
        <p><strong>Edición:</strong> {{ bibliografia.edicion }}</p>
    {% endif %}
    {% if bibliografia.isbn %}
        <p><strong>ISBN:</strong> {{ bibliografia.isbn }}</p>
    {% endif %}
    <p><strong>Formato:</strong> {{ bibliografia.formato|title }}</p>
</div>

{% if bibliografia.url %}
    <div class=\"mb-3\">
        <h4>Enlaces:</h4>
        <div class=\"d-flex align-items-center\">
            <div class=\"me-3 text-break\" style=\"max-width: 70%;\">
                <a href=\"{{ bibliografia.url }}\" target=\"_blank\" class=\"text-primary\">
                    {{ bibliografia.url }}
                </a>
            </div>
            <a href=\"{{ bibliografia.url }}\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
            </a>
        </div>
    </div>
{% endif %}

{% if bibliografia.nota %}
    <div class=\"mb-3\">
        <h4>Nota:</h4>
        <p>{{ bibliografia.nota }}</p>
    </div>
{% endif %} ", "bibliografias_declaradas/partials/libro_details.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/partials/libro_details.twig");
    }
}
