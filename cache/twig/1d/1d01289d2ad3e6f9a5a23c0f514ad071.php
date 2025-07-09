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

/* bibliografias_disponibles/show.twig */
class __TwigTemplate_099694cbb61ed656d91cd1b51012a8d7 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_disponibles/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Bibliografía Disponible";
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
        yield "<div class=\"container mt-4\">
    <div class=\"card\">
        <div class=\"card-header d-flex justify-content-between align-items-center\">
            <h2 class=\"mb-0\">Detalles de Bibliografía Disponible</h2>
            <div>
                <a href=\"";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles\" class=\"btn btn-secondary\">
                    <i class=\"fas fa-arrow-left\"></i> Volver
                </a>
                <a href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 14), "html", null, true);
        yield "/edit\" class=\"btn btn-primary\">
                    <i class=\"fas fa-edit\"></i> Editar
                </a>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <table class=\"table table-bordered\">
                        <tr>
                            <th class=\"bg-light\" style=\"width: 200px;\">Título</th>
                            <td>";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 25), "html", null, true);
        yield "</td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Autor(es)</th>
                            <td>
                                ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 30));
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
        foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
            // line 31
            yield "                                    ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 31), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 31), "html", null, true);
            if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 31)) {
                yield "; ";
            }
            // line 32
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
        unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        yield "                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Año de edición</th>
                            <td>";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_edicion", [], "any", false, false, false, 37), "html", null, true);
        yield "</td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Editorial</th>
                            <td>";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 41), "html", null, true);
        yield "</td>
                        </tr>
                        ";
        // line 43
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada_id", [], "any", true, true, false, 43) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada_id", [], "any", false, false, false, 43)))) {
            // line 44
            yield "                        <tr>
                            <th class=\"bg-light\">Bibliografía Declarada Vinculada</th>
                            <td>
                                <table class=\"table table-sm table-bordered mb-0\">
                                    <tr>
                                        <th class=\"bg-light\" style=\"width: 150px;\">Título</th>
                                        <td>";
            // line 50
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 50)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["titulo"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Autor(es)</th>
                                        <td>
                                            ";
            // line 55
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, true, false, 55), "autores", [], "array", true, true, false, 55) &&  !Twig\Extension\CoreExtension::testEmpty((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 55)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["autores"] ?? null) : null)))) {
                // line 56
                yield "                                                ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 56)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["autores"] ?? null) : null));
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
                foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                    // line 57
                    yield "                                                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = $context["autor"]) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["apellidos"] ?? null) : null), "html", null, true);
                    yield ", ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v4 = $context["autor"]) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4["nombres"] ?? null) : null), "html", null, true);
                    if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 57)) {
                        yield "; ";
                    }
                    // line 58
                    yield "                                                ";
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
                unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 59
                yield "                                            ";
            } else {
                // line 60
                yield "                                                No hay autores registrados
                                            ";
            }
            // line 62
            yield "                                        </td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Año de publicación</th>
                                        <td>";
            // line 66
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v5 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 66)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5["anio_publicacion"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Editorial</th>
                                        <td>";
            // line 70
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v6 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 70)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6["editorial"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Edición</th>
                                        <td>";
            // line 74
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v7 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 74)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7["edicion"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Tipo</th>
                                        <td>";
            // line 78
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v8 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 78)) && is_array($_v8) || $_v8 instanceof ArrayAccess ? ($_v8["tipo"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Formato</th>
                                        <td>";
            // line 82
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v9 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 82)) && is_array($_v9) || $_v9 instanceof ArrayAccess ? ($_v9["formato"] ?? null) : null), "html", null, true);
            yield "</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Estado</th>
                                        <td>
                                            ";
            // line 87
            if ((($_v10 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada", [], "any", false, false, false, 87)) && is_array($_v10) || $_v10 instanceof ArrayAccess ? ($_v10["estado"] ?? null) : null)) {
                // line 88
                yield "                                                <span class=\"badge bg-success\">Activo</span>
                                            ";
            } else {
                // line 90
                yield "                                                <span class=\"badge bg-danger\">Inactivo</span>
                                            ";
            }
            // line 92
            yield "                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        ";
        }
        // line 98
        yield "                        <tr>
                            <th class=\"bg-light\">URL de acceso Internet</th>
                            <td>
                                ";
        // line 101
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_acceso", [], "any", false, false, false, 101)) {
            // line 102
            yield "                                    <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_acceso", [], "any", false, false, false, 102), "html", null, true);
            yield "\" target=\"_blank\" class=\"btn btn-link\">
                                        <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
                                    </a>
                                ";
        } else {
            // line 106
            yield "                                    No disponible
                                ";
        }
        // line 108
        yield "                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">URL de Catálogo</th>
                            <td>
                                ";
        // line 113
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_catalogo", [], "any", false, false, false, 113)) {
            // line 114
            yield "                                    <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_catalogo", [], "any", false, false, false, 114), "html", null, true);
            yield "\" target=\"_blank\" class=\"btn btn-link\">
                                        <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
                                    </a>
                                ";
        } else {
            // line 118
            yield "                                    No disponible
                                ";
        }
        // line 120
        yield "                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Disponibilidad</th>
                            <td>
                                ";
        // line 125
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "disponibilidad", [], "any", false, false, false, 125) == "impreso")) {
            // line 126
            yield "                                    <span class=\"badge bg-primary\">Impreso</span>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 127
($context["bibliografia"] ?? null), "disponibilidad", [], "any", false, false, false, 127) == "electronico")) {
            // line 128
            yield "                                    <span class=\"badge bg-success\">Electrónico</span>
                                ";
        } else {
            // line 130
            yield "                                    <span class=\"badge bg-info\">Ambos</span>
                                ";
        }
        // line 132
        yield "                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Estado</th>
                            <td>
                                ";
        // line 137
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "estado", [], "any", false, false, false, 137)) {
            // line 138
            yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
        } else {
            // line 140
            yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
        }
        // line 142
        yield "                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Ejemplares digitales</th>
                            <td>
                                ";
        // line 147
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_acceso", [], "any", false, false, false, 147)) {
            // line 148
            yield "                                    ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "ejemplares_digitales", [], "any", false, false, false, 148) == 0)) {
                // line 149
                yield "                                        Ilimitados
                                    ";
            } else {
                // line 151
                yield "                                        ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "ejemplares_digitales", [], "any", false, false, false, 151), "html", null, true);
                yield " ejemplares
                                    ";
            }
            // line 153
            yield "                                ";
        } else {
            // line 154
            yield "                                    No aplica
                                ";
        }
        // line 156
        yield "                            </td>
                        </tr>
                        ";
        // line 158
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "sedes", [], "any", true, true, false, 158) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "sedes", [], "any", false, false, false, 158)) > 0))) {
            // line 159
            yield "                        <tr>
                            <th class=\"bg-light\">Copias por Sede</th>
                            <td>
                                <table class=\"table table-sm table-bordered mb-0\">
                                    <thead class=\"table-primary\">
                                        <tr>
                                            <th class=\"text-center\">Sede</th>
                                            <th class=\"text-center\">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
            // line 170
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "sedes", [], "any", false, false, false, 170));
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
            foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
                // line 171
                yield "                                            ";
                if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "pivot", [], "any", false, true, false, 171), "ejemplares", [], "any", true, true, false, 171) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "pivot", [], "any", false, false, false, 171), "ejemplares", [], "any", false, false, false, 171) > 0))) {
                    // line 172
                    yield "                                            <tr class=\"";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 172) % 2 != 0)) {
                        yield "table-light";
                    } else {
                        yield "table-white";
                    }
                    yield "\">
                                                <td>";
                    // line 173
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 173), "html", null, true);
                    yield "</td>
                                                <td class=\"text-center\">";
                    // line 174
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "pivot", [], "any", false, false, false, 174), "ejemplares", [], "any", false, false, false, 174), "html", null, true);
                    yield "</td>
                                            </tr>
                                            ";
                }
                // line 177
                yield "                                        ";
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
            unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 178
            yield "                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        ";
        } else {
            // line 183
            yield "                        <tr>
                            <th class=\"bg-light\">Copias por Sede</th>
                            <td>No hay copias registradas</td>
                        </tr>
                        ";
        }
        // line 188
        yield "                    </table>
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
        return "bibliografias_disponibles/show.twig";
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
        return array (  485 => 188,  478 => 183,  471 => 178,  457 => 177,  451 => 174,  447 => 173,  438 => 172,  435 => 171,  418 => 170,  405 => 159,  403 => 158,  399 => 156,  395 => 154,  392 => 153,  386 => 151,  382 => 149,  379 => 148,  377 => 147,  370 => 142,  366 => 140,  362 => 138,  360 => 137,  353 => 132,  349 => 130,  345 => 128,  343 => 127,  340 => 126,  338 => 125,  331 => 120,  327 => 118,  319 => 114,  317 => 113,  310 => 108,  306 => 106,  298 => 102,  296 => 101,  291 => 98,  283 => 92,  279 => 90,  275 => 88,  273 => 87,  265 => 82,  258 => 78,  251 => 74,  244 => 70,  237 => 66,  231 => 62,  227 => 60,  224 => 59,  210 => 58,  202 => 57,  184 => 56,  182 => 55,  174 => 50,  166 => 44,  164 => 43,  159 => 41,  152 => 37,  146 => 33,  132 => 32,  124 => 31,  107 => 30,  99 => 25,  83 => 14,  77 => 11,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Detalles de Bibliografía Disponible{% endblock %}

{% block content %}
<div class=\"container mt-4\">
    <div class=\"card\">
        <div class=\"card-header d-flex justify-content-between align-items-center\">
            <h2 class=\"mb-0\">Detalles de Bibliografía Disponible</h2>
            <div>
                <a href=\"{{ app_url }}bibliografias-disponibles\" class=\"btn btn-secondary\">
                    <i class=\"fas fa-arrow-left\"></i> Volver
                </a>
                <a href=\"{{ app_url }}bibliografias-disponibles/{{ bibliografia.id }}/edit\" class=\"btn btn-primary\">
                    <i class=\"fas fa-edit\"></i> Editar
                </a>
            </div>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <table class=\"table table-bordered\">
                        <tr>
                            <th class=\"bg-light\" style=\"width: 200px;\">Título</th>
                            <td>{{ bibliografia.titulo }}</td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Autor(es)</th>
                            <td>
                                {% for autor in bibliografia.autores %}
                                    {{ autor.apellidos }}, {{ autor.nombres }}{% if not loop.last %}; {% endif %}
                                {% endfor %}
                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Año de edición</th>
                            <td>{{ bibliografia.anio_edicion }}</td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Editorial</th>
                            <td>{{ bibliografia.editorial }}</td>
                        </tr>
                        {% if bibliografia.bibliografia_declarada_id is defined and bibliografia.bibliografia_declarada_id is not empty %}
                        <tr>
                            <th class=\"bg-light\">Bibliografía Declarada Vinculada</th>
                            <td>
                                <table class=\"table table-sm table-bordered mb-0\">
                                    <tr>
                                        <th class=\"bg-light\" style=\"width: 150px;\">Título</th>
                                        <td>{{ bibliografia.bibliografia_declarada['titulo'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Autor(es)</th>
                                        <td>
                                            {% if bibliografia.bibliografia_declarada['autores'] is defined and bibliografia.bibliografia_declarada['autores'] is not empty %}
                                                {% for autor in bibliografia.bibliografia_declarada['autores'] %}
                                                    {{ autor['apellidos'] }}, {{ autor['nombres'] }}{% if not loop.last %}; {% endif %}
                                                {% endfor %}
                                            {% else %}
                                                No hay autores registrados
                                            {% endif %}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Año de publicación</th>
                                        <td>{{ bibliografia.bibliografia_declarada['anio_publicacion'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Editorial</th>
                                        <td>{{ bibliografia.bibliografia_declarada['editorial'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Edición</th>
                                        <td>{{ bibliografia.bibliografia_declarada['edicion'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Tipo</th>
                                        <td>{{ bibliografia.bibliografia_declarada['tipo'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Formato</th>
                                        <td>{{ bibliografia.bibliografia_declarada['formato'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class=\"bg-light\">Estado</th>
                                        <td>
                                            {% if bibliografia.bibliografia_declarada['estado'] %}
                                                <span class=\"badge bg-success\">Activo</span>
                                            {% else %}
                                                <span class=\"badge bg-danger\">Inactivo</span>
                                            {% endif %}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        {% endif %}
                        <tr>
                            <th class=\"bg-light\">URL de acceso Internet</th>
                            <td>
                                {% if bibliografia.url_acceso %}
                                    <a href=\"{{ bibliografia.url_acceso }}\" target=\"_blank\" class=\"btn btn-link\">
                                        <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
                                    </a>
                                {% else %}
                                    No disponible
                                {% endif %}
                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">URL de Catálogo</th>
                            <td>
                                {% if bibliografia.url_catalogo %}
                                    <a href=\"{{ bibliografia.url_catalogo }}\" target=\"_blank\" class=\"btn btn-link\">
                                        <i class=\"fas fa-external-link-alt\"></i> Abrir enlace
                                    </a>
                                {% else %}
                                    No disponible
                                {% endif %}
                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Disponibilidad</th>
                            <td>
                                {% if bibliografia.disponibilidad == 'impreso' %}
                                    <span class=\"badge bg-primary\">Impreso</span>
                                {% elseif bibliografia.disponibilidad == 'electronico' %}
                                    <span class=\"badge bg-success\">Electrónico</span>
                                {% else %}
                                    <span class=\"badge bg-info\">Ambos</span>
                                {% endif %}
                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Estado</th>
                            <td>
                                {% if bibliografia.estado %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                        </tr>
                        <tr>
                            <th class=\"bg-light\">Ejemplares digitales</th>
                            <td>
                                {% if bibliografia.url_acceso %}
                                    {% if bibliografia.ejemplares_digitales == 0 %}
                                        Ilimitados
                                    {% else %}
                                        {{ bibliografia.ejemplares_digitales }} ejemplares
                                    {% endif %}
                                {% else %}
                                    No aplica
                                {% endif %}
                            </td>
                        </tr>
                        {% if bibliografia.sedes is defined and bibliografia.sedes|length > 0 %}
                        <tr>
                            <th class=\"bg-light\">Copias por Sede</th>
                            <td>
                                <table class=\"table table-sm table-bordered mb-0\">
                                    <thead class=\"table-primary\">
                                        <tr>
                                            <th class=\"text-center\">Sede</th>
                                            <th class=\"text-center\">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for sede in bibliografia.sedes %}
                                            {% if sede.pivot.ejemplares is defined and sede.pivot.ejemplares > 0 %}
                                            <tr class=\"{% if loop.index is odd %}table-light{% else %}table-white{% endif %}\">
                                                <td>{{ sede.nombre }}</td>
                                                <td class=\"text-center\">{{ sede.pivot.ejemplares }}</td>
                                            </tr>
                                            {% endif %}
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <th class=\"bg-light\">Copias por Sede</th>
                            <td>No hay copias registradas</td>
                        </tr>
                        {% endif %}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "bibliografias_disponibles/show.twig", "/var/www/html/biblioges/templates/bibliografias_disponibles/show.twig");
    }
}
