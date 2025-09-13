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

/* bibliografias_declaradas/partials/sitio_web_details.twig */
class __TwigTemplate_aa16b878daa57a1f66ed8b88742edac1 extends Template
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
        <i class=\"fas fa-globe\"></i> Sitio Web
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
    <p><strong>Año de Publicación:</strong> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_publicacion", [], "any", false, false, false, 24), "html", null, true);
        yield "</p>
    <p><strong>Editorial:</strong> ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 25), "html", null, true);
        yield "</p>
    ";
        // line 26
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "fecha_consulta", [], "any", false, false, false, 26)) {
            // line 27
            yield "        <p><strong>Fecha de Consulta:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "fecha_consulta", [], "any", false, false, false, 27), "d/m/Y"), "html", null, true);
            yield "</p>
    ";
        }
        // line 29
        yield "    <p><strong>Formato:</strong> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 29)), "html", null, true);
        yield "</p>
    ";
        // line 30
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi", [], "any", false, false, false, 30)) {
            // line 31
            yield "        <p>
            <strong>DOI:</strong> ";
            // line 32
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi", [], "any", false, false, false, 32), "html", null, true);
            yield "
            ";
            // line 33
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi_link", [], "any", false, false, false, 33)) {
                // line 34
                yield "                - <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi_link", [], "any", false, false, false, 34), "html", null, true);
                yield "\" target=\"_blank\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi_link", [], "any", false, false, false, 34), "html", null, true);
                yield "</a>
            ";
            }
            // line 36
            yield "        </p>
    ";
        }
        // line 38
        yield "</div>

";
        // line 40
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 40)) {
            // line 41
            yield "    <div class=\"mb-3\">
        <h4>Enlaces:</h4>
        <div class=\"d-flex align-items-center\">
            <div class=\"me-3 text-break\" style=\"max-width: 70%;\">
                <a href=\"";
            // line 45
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 45), "html", null, true);
            yield "\" target=\"_blank\" class=\"text-primary\">
                    ";
            // line 46
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 46), "html", null, true);
            yield "
                </a>
            </div>
            <a href=\"";
            // line 49
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 49), "html", null, true);
            yield "\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
            </a>
        </div>
    </div>
";
        }
        // line 55
        yield "
";
        // line 56
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nota", [], "any", false, false, false, 56)) {
            // line 57
            yield "    <div class=\"mb-3\">
        <h4>Nota:</h4>
        <p>";
            // line 59
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nota", [], "any", false, false, false, 59), "html", null, true);
            yield "</p>
    </div>
";
        }
        // line 61
        yield " ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "bibliografias_declaradas/partials/sitio_web_details.twig";
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
        return array (  173 => 61,  167 => 59,  163 => 57,  161 => 56,  158 => 55,  149 => 49,  143 => 46,  139 => 45,  133 => 41,  131 => 40,  127 => 38,  123 => 36,  115 => 34,  113 => 33,  109 => 32,  106 => 31,  104 => 30,  99 => 29,  93 => 27,  91 => 26,  87 => 25,  83 => 24,  76 => 19,  65 => 17,  61 => 16,  52 => 10,  42 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# Detalles específicos de un sitio web #}
<div class=\"mb-4\">
    <h3 class=\"text-primary\">
        <i class=\"fas fa-globe\"></i> Sitio Web
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
    <p><strong>Año de Publicación:</strong> {{ bibliografia.anio_publicacion }}</p>
    <p><strong>Editorial:</strong> {{ bibliografia.editorial }}</p>
    {% if bibliografia.fecha_consulta %}
        <p><strong>Fecha de Consulta:</strong> {{ bibliografia.fecha_consulta|date('d/m/Y') }}</p>
    {% endif %}
    <p><strong>Formato:</strong> {{ bibliografia.formato|title }}</p>
    {% if bibliografia.doi %}
        <p>
            <strong>DOI:</strong> {{ bibliografia.doi }}
            {% if bibliografia.doi_link %}
                - <a href=\"{{ bibliografia.doi_link }}\" target=\"_blank\">{{ bibliografia.doi_link }}</a>
            {% endif %}
        </p>
    {% endif %}
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
{% endif %} ", "bibliografias_declaradas/partials/sitio_web_details.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/partials/sitio_web_details.twig");
    }
}
