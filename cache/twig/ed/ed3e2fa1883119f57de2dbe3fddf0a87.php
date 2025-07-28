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

/* unidades/show.twig */
class __TwigTemplate_9db40204dd228f0f73b5cce032d0a7cf extends Template
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
            'current_page' => [$this, 'block_current_page'],
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
        $this->parent = $this->loadTemplate("base.twig", "unidades/show.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Detalles de Unidad - Sistema de Bibliografía";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_current_page(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "unidades";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Detalles de la Unidad</h3>
                        <div>
                            <a href=\"";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "id", [], "any", false, false, false, 16), "html", null, true);
        yield "/edit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-edit\"></i> Editar
                            </a>
                            <a href=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "unidades\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Código:</label>
                                        <p class=\"form-control-plaintext\">";
        // line 32
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "codigo", [], "any", false, false, false, 32), "html", null, true);
        yield "</p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Nombre:</label>
                                        <p class=\"form-control-plaintext\">";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "nombre", [], "any", false, false, false, 38), "html", null, true);
        yield "</p>
                                    </div>
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Sede:</label>
                                        <p class=\"form-control-plaintext\">";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "sede_nombre", [], "any", false, false, false, 47), "html", null, true);
        yield "</p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Unidad Padre:</label>
                                        <p class=\"form-control-plaintext\">
                                            ";
        // line 54
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "unidad_padre_nombre", [], "any", false, false, false, 54)) {
            // line 55
            yield "                                                <span class=\"badge bg-info\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "unidad_padre_nombre", [], "any", false, false, false, 55), "html", null, true);
            yield "</span>
                                            ";
        } else {
            // line 57
            yield "                                                <span class=\"text-muted\">Sin unidad padre</span>
                                            ";
        }
        // line 59
        yield "                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Estado:</label>
                                        <p class=\"form-control-plaintext\">
                                            ";
        // line 69
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "estado", [], "any", false, false, false, 69) == "1")) {
            // line 70
            yield "                                                <span class=\"badge bg-success\">Activo</span>
                                            ";
        } else {
            // line 72
            yield "                                                <span class=\"badge bg-danger\">Inactivo</span>
                                            ";
        }
        // line 74
        yield "                                        </p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Fecha de Creación:</label>
                                        <p class=\"form-control-plaintext\">";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "fecha_creacion", [], "any", false, false, false, 80), "d/m/Y H:i"), "html", null, true);
        yield "</p>
                                    </div>
                                </div>
                            </div>

                            ";
        // line 85
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "descripcion", [], "any", false, false, false, 85)) {
            // line 86
            yield "                            <div class=\"row\">
                                <div class=\"col-12\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Descripción:</label>
                                        <p class=\"form-control-plaintext\">";
            // line 90
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["unidad"] ?? null), "descripcion", [], "any", false, false, false, 90), "html", null, true);
            yield "</p>
                                    </div>
                                </div>
                            </div>
                            ";
        }
        // line 95
        yield "                        </div>

                        <div class=\"col-md-4\">
                            <div class=\"card bg-light\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title mb-0\">
                                        <i class=\"fas fa-info-circle\"></i> Información Adicional
                                    </h5>
                                </div>
                                <div class=\"card-body\">
                                    <div class=\"row text-center\">
                                        <div class=\"col-6\">
                                            <div class=\"border-right\">
                                                <h4 class=\"text-primary\">";
        // line 108
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["unidades_hijas"] ?? null)), "html", null, true);
        yield "</h4>
                                                <small class=\"text-muted\">Unidades Hijas</small>
                                            </div>
                                        </div>
                                        <div class=\"col-6\">
                                            <h4 class=\"text-success\">";
        // line 113
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["jerarquia"] ?? null)), "html", null, true);
        yield "</h4>
                                            <small class=\"text-muted\">Nivel Jerárquico</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jerarquía de la unidad -->
                    ";
        // line 123
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["jerarquia"] ?? null)) > 0)) {
            // line 124
            yield "                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5><i class=\"fas fa-sitemap\"></i> Jerarquía Organizacional</h5>
                            <div class=\"breadcrumb\">
                                ";
            // line 128
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["jerarquia"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["nivel"]) {
                // line 129
                yield "                                    ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 129)) {
                    // line 130
                    yield "                                        <span class=\"breadcrumb-item active\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["nivel"], "codigo", [], "any", false, false, false, 130), "html", null, true);
                    yield " - ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["nivel"], "nombre", [], "any", false, false, false, 130), "html", null, true);
                    yield "</span>
                                    ";
                } else {
                    // line 132
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "unidades/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["nivel"], "id", [], "any", false, false, false, 132), "html", null, true);
                    yield "\" class=\"breadcrumb-item\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["nivel"], "codigo", [], "any", false, false, false, 132), "html", null, true);
                    yield " - ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["nivel"], "nombre", [], "any", false, false, false, 132), "html", null, true);
                    yield "</a>
                                    ";
                }
                // line 134
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
            unset($context['_seq'], $context['_key'], $context['nivel'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 135
            yield "                            </div>
                        </div>
                    </div>
                    ";
        }
        // line 139
        yield "
                    <!-- Unidades hijas -->
                    ";
        // line 141
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["unidades_hijas"] ?? null)) > 0)) {
            // line 142
            yield "                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5><i class=\"fas fa-network-wired\"></i> Unidades Hijas</h5>
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-striped\">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
            // line 156
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["unidades_hijas"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["unidad_hija"]) {
                // line 157
                yield "                                            <tr>
                                                <td>";
                // line 158
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad_hija"], "codigo", [], "any", false, false, false, 158), "html", null, true);
                yield "</td>
                                                <td>";
                // line 159
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad_hija"], "nombre", [], "any", false, false, false, 159), "html", null, true);
                yield "</td>
                                                <td>
                                                    ";
                // line 161
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["unidad_hija"], "estado", [], "any", false, false, false, 161) == "1")) {
                    // line 162
                    yield "                                                        <span class=\"badge bg-success\">Activo</span>
                                                    ";
                } else {
                    // line 164
                    yield "                                                        <span class=\"badge bg-danger\">Inactivo</span>
                                                    ";
                }
                // line 166
                yield "                                                </td>
                                                <td>
                                                    <a href=\"";
                // line 168
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "unidades/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad_hija"], "id", [], "any", false, false, false, 168), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 171
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "unidades/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["unidad_hija"], "id", [], "any", false, false, false, 171), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['unidad_hija'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 177
            yield "                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    ";
        }
        // line 183
        yield "                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 190
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 191
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Mostrar alertas de SweetAlert2 si existen en la sesión
        ";
        // line 197
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 197)) {
            // line 198
            yield "            Swal.fire({
                icon: '";
            // line 199
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 199), "icon", [], "any", false, false, false, 199), "html", null, true);
            yield "',
                title: '";
            // line 200
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 200), "title", [], "any", false, false, false, 200);
            yield "',
                text: '";
            // line 201
            yield CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 201), "text", [], "any", false, false, false, 201);
            yield "',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('";
            // line 210
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
        // line 218
        yield "    });
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "unidades/show.twig";
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
        return array (  461 => 218,  450 => 210,  438 => 201,  434 => 200,  430 => 199,  427 => 198,  425 => 197,  417 => 191,  410 => 190,  400 => 183,  392 => 177,  378 => 171,  370 => 168,  366 => 166,  362 => 164,  358 => 162,  356 => 161,  351 => 159,  347 => 158,  344 => 157,  340 => 156,  324 => 142,  322 => 141,  318 => 139,  312 => 135,  298 => 134,  286 => 132,  278 => 130,  275 => 129,  258 => 128,  252 => 124,  250 => 123,  237 => 113,  229 => 108,  214 => 95,  206 => 90,  200 => 86,  198 => 85,  190 => 80,  182 => 74,  178 => 72,  174 => 70,  172 => 69,  160 => 59,  156 => 57,  150 => 55,  148 => 54,  138 => 47,  126 => 38,  117 => 32,  101 => 19,  93 => 16,  83 => 8,  76 => 7,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Detalles de Unidad - Sistema de Bibliografía{% endblock %}

{% block current_page %}unidades{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Detalles de la Unidad</h3>
                        <div>
                            <a href=\"{{ app_url }}unidades/{{ unidad.id }}/edit\" class=\"btn btn-primary\">
                                <i class=\"fas fa-edit\"></i> Editar
                            </a>
                            <a href=\"{{ app_url }}unidades\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Código:</label>
                                        <p class=\"form-control-plaintext\">{{ unidad.codigo }}</p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Nombre:</label>
                                        <p class=\"form-control-plaintext\">{{ unidad.nombre }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Sede:</label>
                                        <p class=\"form-control-plaintext\">{{ unidad.sede_nombre }}</p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Unidad Padre:</label>
                                        <p class=\"form-control-plaintext\">
                                            {% if unidad.unidad_padre_nombre %}
                                                <span class=\"badge bg-info\">{{ unidad.unidad_padre_nombre }}</span>
                                            {% else %}
                                                <span class=\"text-muted\">Sin unidad padre</span>
                                            {% endif %}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Estado:</label>
                                        <p class=\"form-control-plaintext\">
                                            {% if unidad.estado == '1' %}
                                                <span class=\"badge bg-success\">Activo</span>
                                            {% else %}
                                                <span class=\"badge bg-danger\">Inactivo</span>
                                            {% endif %}
                                        </p>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Fecha de Creación:</label>
                                        <p class=\"form-control-plaintext\">{{ unidad.fecha_creacion|date('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            {% if unidad.descripcion %}
                            <div class=\"row\">
                                <div class=\"col-12\">
                                    <div class=\"form-group\">
                                        <label class=\"font-weight-bold\">Descripción:</label>
                                        <p class=\"form-control-plaintext\">{{ unidad.descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                            {% endif %}
                        </div>

                        <div class=\"col-md-4\">
                            <div class=\"card bg-light\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title mb-0\">
                                        <i class=\"fas fa-info-circle\"></i> Información Adicional
                                    </h5>
                                </div>
                                <div class=\"card-body\">
                                    <div class=\"row text-center\">
                                        <div class=\"col-6\">
                                            <div class=\"border-right\">
                                                <h4 class=\"text-primary\">{{ unidades_hijas|length }}</h4>
                                                <small class=\"text-muted\">Unidades Hijas</small>
                                            </div>
                                        </div>
                                        <div class=\"col-6\">
                                            <h4 class=\"text-success\">{{ jerarquia|length }}</h4>
                                            <small class=\"text-muted\">Nivel Jerárquico</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jerarquía de la unidad -->
                    {% if jerarquia|length > 0 %}
                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5><i class=\"fas fa-sitemap\"></i> Jerarquía Organizacional</h5>
                            <div class=\"breadcrumb\">
                                {% for nivel in jerarquia %}
                                    {% if loop.last %}
                                        <span class=\"breadcrumb-item active\">{{ nivel.codigo }} - {{ nivel.nombre }}</span>
                                    {% else %}
                                        <a href=\"{{ app_url }}unidades/{{ nivel.id }}\" class=\"breadcrumb-item\">{{ nivel.codigo }} - {{ nivel.nombre }}</a>
                                    {% endif %}
                                {% endfor %}
                            </div>
                        </div>
                    </div>
                    {% endif %}

                    <!-- Unidades hijas -->
                    {% if unidades_hijas|length > 0 %}
                    <div class=\"row mt-4\">
                        <div class=\"col-12\">
                            <h5><i class=\"fas fa-network-wired\"></i> Unidades Hijas</h5>
                            <div class=\"table-responsive\">
                                <table class=\"table table-bordered table-striped\">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for unidad_hija in unidades_hijas %}
                                            <tr>
                                                <td>{{ unidad_hija.codigo }}</td>
                                                <td>{{ unidad_hija.nombre }}</td>
                                                <td>
                                                    {% if unidad_hija.estado == '1' %}
                                                        <span class=\"badge bg-success\">Activo</span>
                                                    {% else %}
                                                        <span class=\"badge bg-danger\">Inactivo</span>
                                                    {% endif %}
                                                </td>
                                                <td>
                                                    <a href=\"{{ app_url }}unidades/{{ unidad_hija.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}unidades/{{ unidad_hija.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    \$(document).ready(function() {
        // Mostrar alertas de SweetAlert2 si existen en la sesión
        {% if session.swal %}
            Swal.fire({
                icon: '{{ session.swal.icon }}',
                title: '{{ session.swal.title|raw }}',
                text: '{{ session.swal.text|raw }}',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });

            // Limpiar la alerta de la sesión después de mostrarla
            fetch('{{ app_url }}clear-session-messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        {% endif %}
    });
</script>
{% endblock %} ", "unidades/show.twig", "/var/www/html/biblioges/templates/unidades/show.twig");
    }
}
