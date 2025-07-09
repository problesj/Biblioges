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

/* bibliografias_declaradas/show.twig */
class __TwigTemplate_55448b137459bbd34738cebe63f98ebf extends Template
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
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_declaradas/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Bibliografía Declarada";
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
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Detalles de la Bibliografía Declarada</h3>
                    <div class=\"card-tools\" align=\"right\">
                        <a href=\"";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                        <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/edit/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 16), "html", null, true);
        yield "\" class=\"btn btn-primary\">
                            <i class=\"fas fa-edit\"></i> Editar
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    ";
        // line 23
        yield "                    ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 23) == "libro")) {
            // line 24
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/libro_details.twig", "bibliografias_declaradas/show.twig", 24)->unwrap()->yield($context);
            // line 25
            yield "                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 25) == "articulo")) {
            // line 26
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/articulo_details.twig", "bibliografias_declaradas/show.twig", 26)->unwrap()->yield($context);
            // line 27
            yield "                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 27) == "tesis")) {
            // line 28
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/tesis_details.twig", "bibliografias_declaradas/show.twig", 28)->unwrap()->yield($context);
            // line 29
            yield "                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 29) == "sitio_web")) {
            // line 30
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/sitio_web_details.twig", "bibliografias_declaradas/show.twig", 30)->unwrap()->yield($context);
            // line 31
            yield "                    ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 31) == "software")) {
            // line 32
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/software_details.twig", "bibliografias_declaradas/show.twig", 32)->unwrap()->yield($context);
            // line 33
            yield "                    ";
        } else {
            // line 34
            yield "                        ";
            yield from $this->loadTemplate("bibliografias_declaradas/partials/generico_details.twig", "bibliografias_declaradas/show.twig", 34)->unwrap()->yield($context);
            // line 35
            yield "                    ";
        }
        // line 36
        yield "
                    ";
        // line 38
        yield "                    <div class=\"mt-4\">
                        <h4>Asignaturas Vinculadas</h4>
                        <div class=\"table-responsive\">
                            <table class=\"table table-bordered table-striped\">
                                <thead>
                                    <tr>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white;\">Asignatura</th>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white;\">Códigos</th>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white; text-align:center\">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
        // line 50
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 51
            yield "                                        <tr>
                                            <td>";
            // line 52
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 52), "html", null, true);
            yield "</td>
                                            <td>";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 53), "html", null, true);
            yield "</td>
                                            <td align=\"center\">
                                                ";
            // line 55
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo_bibliografia", [], "any", false, false, false, 55) == "basica")) {
                // line 56
                yield "                                                    <span class=\"badge bg-primary\" style=\"font-size: 0.9em; padding: 8px 12px;\">Bibliografía Básica</span>
                                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 57
$context["asignatura"], "tipo_bibliografia", [], "any", false, false, false, 57) == "complementaria")) {
                // line 58
                yield "                                                    <span class=\"badge bg-info\" style=\"font-size: 0.9em; padding: 8px 12px;\">Bibliografía Complementaria</span>
                                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 59
$context["asignatura"], "tipo_bibliografia", [], "any", false, false, false, 59) == "otro")) {
                // line 60
                yield "                                                    <span class=\"badge bg-secondary\" style=\"font-size: 0.9em; padding: 8px 12px;\">Otro</span>
                                                ";
            } else {
                // line 62
                yield "                                                    <span class=\"badge bg-secondary\" style=\"font-size: 0.9em; padding: 8px 12px;\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo_bibliografia", [], "any", false, false, false, 62)), "html", null, true);
                yield "</span>
                                                ";
            }
            // line 64
            yield "                                            </td>
                                        </tr>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        yield "                                </tbody>
                            </table>
                        </div>
                    </div>

                    ";
        // line 73
        yield "                    <div class=\"mt-4\">
                        <h4>Bibliografías Disponibles</h4>
                        <div class=\"table-responsive\">
                            <table class=\"table table-bordered\">
                                <thead>
                                    <tr>
                                        <th>ID MMS</th>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th style=\"text-align:center;\">URL Acceso</th>
                                        <th style=\"text-align:center;\">URL Catálogo</th>
                                        <th style=\"text-align:center;\">Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias_disponibles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["bd"]) {
            // line 91
            yield "                                        <tr>
                                            <td>";
            // line 92
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "id_mms", [], "any", false, false, false, 92), "html", null, true);
            yield "</td>
                                            <td>";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "titulo", [], "any", false, false, false, 93), "html", null, true);
            yield "</td>
                                            <td>";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "autores", [], "any", false, false, false, 94), "html", null, true);
            yield "</td>
                                            <td>";
            // line 95
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "anio_edicion", [], "any", false, false, false, 95), "html", null, true);
            yield "</td>
                                            <td>";
            // line 96
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "editorial", [], "any", false, false, false, 96), "html", null, true);
            yield "</td>
                                            <td  align=\"center\">
                                                ";
            // line 98
            if (CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "url_acceso", [], "any", false, false, false, 98)) {
                // line 99
                yield "                                                    <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "url_acceso", [], "any", false, false, false, 99), "html", null, true);
                yield "\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                                                        <i class=\"fas fa-external-link-alt\"></i>
                                                    </a>
                                                ";
            }
            // line 103
            yield "                                            </td>
                                            <td align=\"center\">
                                                ";
            // line 105
            if (CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "url_catalogo", [], "any", false, false, false, 105)) {
                // line 106
                yield "                                                    <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "url_catalogo", [], "any", false, false, false, 106), "html", null, true);
                yield "\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                                                        <i class=\"fas fa-external-link-alt\"></i>
                                                    </a>
                                                ";
            }
            // line 110
            yield "                                            </td>
                                            <td align=\"center\">
                                                ";
            // line 112
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "disponibilidad", [], "any", false, false, false, 112) == "impreso")) {
                // line 113
                yield "                                                    <span class=\"badge bg-info\">Impreso</span>
                                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 114
$context["bd"], "disponibilidad", [], "any", false, false, false, 114) == "electronico")) {
                // line 115
                yield "                                                    <span class=\"badge bg-info\">Electrónico</span>
                                                ";
            } else {
                // line 117
                yield "                                                    <span class=\"badge bg-info\">Ambos</span>
                                                ";
            }
            // line 119
            yield "                                            </td>
                                        </tr>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bd'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 122
        yield "                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "bibliografias_declaradas/show.twig";
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
        return array (  303 => 122,  295 => 119,  291 => 117,  287 => 115,  285 => 114,  282 => 113,  280 => 112,  276 => 110,  268 => 106,  266 => 105,  262 => 103,  254 => 99,  252 => 98,  247 => 96,  243 => 95,  239 => 94,  235 => 93,  231 => 92,  228 => 91,  224 => 90,  205 => 73,  198 => 67,  190 => 64,  184 => 62,  180 => 60,  178 => 59,  175 => 58,  173 => 57,  170 => 56,  168 => 55,  163 => 53,  159 => 52,  156 => 51,  152 => 50,  138 => 38,  135 => 36,  132 => 35,  129 => 34,  126 => 33,  123 => 32,  120 => 31,  117 => 30,  114 => 29,  111 => 28,  108 => 27,  105 => 26,  102 => 25,  99 => 24,  96 => 23,  85 => 16,  79 => 13,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Detalles de Bibliografía Declarada{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Detalles de la Bibliografía Declarada</h3>
                    <div class=\"card-tools\" align=\"right\">
                        <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                        <a href=\"{{ app_url }}bibliografias-declaradas/edit/{{ bibliografia.id }}\" class=\"btn btn-primary\">
                            <i class=\"fas fa-edit\"></i> Editar
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    {# Mostrar detalles de la bibliografía según su tipo #}
                    {% if bibliografia.tipo == 'libro' %}
                        {% include 'bibliografias_declaradas/partials/libro_details.twig' %}
                    {% elseif bibliografia.tipo == 'articulo' %}
                        {% include 'bibliografias_declaradas/partials/articulo_details.twig' %}
                    {% elseif bibliografia.tipo == 'tesis' %}
                        {% include 'bibliografias_declaradas/partials/tesis_details.twig' %}
                    {% elseif bibliografia.tipo == 'sitio_web' %}
                        {% include 'bibliografias_declaradas/partials/sitio_web_details.twig' %}
                    {% elseif bibliografia.tipo == 'software' %}
                        {% include 'bibliografias_declaradas/partials/software_details.twig' %}
                    {% else %}
                        {% include 'bibliografias_declaradas/partials/generico_details.twig' %}
                    {% endif %}

                    {# Mostrar asignaturas vinculadas #}
                    <div class=\"mt-4\">
                        <h4>Asignaturas Vinculadas</h4>
                        <div class=\"table-responsive\">
                            <table class=\"table table-bordered table-striped\">
                                <thead>
                                    <tr>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white;\">Asignatura</th>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white;\">Códigos</th>
                                        <th style=\"border-color: #2c3e50;background-color:rgb(1, 96, 192); color:white; text-align:center\">Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for asignatura in asignaturas %}
                                        <tr>
                                            <td>{{ asignatura.nombre }}</td>
                                            <td>{{ asignatura.codigos }}</td>
                                            <td align=\"center\">
                                                {% if asignatura.tipo_bibliografia == 'basica' %}
                                                    <span class=\"badge bg-primary\" style=\"font-size: 0.9em; padding: 8px 12px;\">Bibliografía Básica</span>
                                                {% elseif asignatura.tipo_bibliografia == 'complementaria' %}
                                                    <span class=\"badge bg-info\" style=\"font-size: 0.9em; padding: 8px 12px;\">Bibliografía Complementaria</span>
                                                {% elseif asignatura.tipo_bibliografia == 'otro' %}
                                                    <span class=\"badge bg-secondary\" style=\"font-size: 0.9em; padding: 8px 12px;\">Otro</span>
                                                {% else %}
                                                    <span class=\"badge bg-secondary\" style=\"font-size: 0.9em; padding: 8px 12px;\">{{ asignatura.tipo_bibliografia|title }}</span>
                                                {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {# Mostrar bibliografías disponibles #}
                    <div class=\"mt-4\">
                        <h4>Bibliografías Disponibles</h4>
                        <div class=\"table-responsive\">
                            <table class=\"table table-bordered\">
                                <thead>
                                    <tr>
                                        <th>ID MMS</th>
                                        <th>Título</th>
                                        <th>Autor(es)</th>
                                        <th>Año</th>
                                        <th>Editorial</th>
                                        <th style=\"text-align:center;\">URL Acceso</th>
                                        <th style=\"text-align:center;\">URL Catálogo</th>
                                        <th style=\"text-align:center;\">Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for bd in bibliografias_disponibles %}
                                        <tr>
                                            <td>{{ bd.id_mms }}</td>
                                            <td>{{ bd.titulo }}</td>
                                            <td>{{ bd.autores }}</td>
                                            <td>{{ bd.anio_edicion }}</td>
                                            <td>{{ bd.editorial }}</td>
                                            <td  align=\"center\">
                                                {% if bd.url_acceso %}
                                                    <a href=\"{{ bd.url_acceso }}\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                                                        <i class=\"fas fa-external-link-alt\"></i>
                                                    </a>
                                                {% endif %}
                                            </td>
                                            <td align=\"center\">
                                                {% if bd.url_catalogo %}
                                                    <a href=\"{{ bd.url_catalogo }}\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                                                        <i class=\"fas fa-external-link-alt\"></i>
                                                    </a>
                                                {% endif %}
                                            </td>
                                            <td align=\"center\">
                                                {% if bd.disponibilidad == 'impreso' %}
                                                    <span class=\"badge bg-info\">Impreso</span>
                                                {% elseif (bd.disponibilidad == 'electronico') %}
                                                    <span class=\"badge bg-info\">Electrónico</span>
                                                {% else  %}
                                                    <span class=\"badge bg-info\">Ambos</span>
                                                {% endif %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "bibliografias_declaradas/show.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/show.twig");
    }
}
