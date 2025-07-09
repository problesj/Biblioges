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

/* dashboard/index.twig */
class __TwigTemplate_f103c268c85f1c8aa19329314c17160b extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "dashboard/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Dashboard - Sistema de Bibliografía";
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
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Dashboard</h1>
    </div>

    <!-- Tarjetas de resumen -->
    <div class=\"row\">
        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-primary shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                                Bibliografías Declaradas</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["totalBibliografias"] ?? null), "html", null, true);
        yield "</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-list fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-success shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-success text-uppercase mb-1\">
                                Bibliografías Disponibles</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["totalDisponibles"] ?? null), "html", null, true);
        yield "</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-book fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-info shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-info text-uppercase mb-1\">
                                Asignaturas</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["totalAsignaturas"] ?? null), "html", null, true);
        yield "</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-book-open fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-warning shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-warning text-uppercase mb-1\">
                                Carreras</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["totalCarreras"] ?? null), "html", null, true);
        yield "</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-graduation-cap fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row\">
        <!-- Gráfico de cobertura básica por carrera -->
        <div class=\"col-xl-12 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Cobertura Básica por Carrera (Pregrado)</h6>
                    <a href=\"";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/coberturas\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fas fa-chart-bar\"></i> Ver Reportes
                    </a>
                </div>
                <div class=\"card-body\">
                    ";
        // line 93
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["coberturaCarreras"] ?? null)) > 0)) {
            // line 94
            yield "                        <canvas id=\"coberturaChart\" width=\"400\" height=\"200\"></canvas>
                    ";
        } else {
            // line 96
            yield "                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-chart-bar fa-3x text-muted mb-3\"></i>
                            <h5 class=\"text-muted\">No hay datos de cobertura básica disponibles</h5>
                            <p class=\"text-muted\">Los datos de cobertura se mostrarán aquí una vez que se generen los reportes de cobertura básica.</p>
                        </div>
                    ";
        }
        // line 102
        yield "                </div>
            </div>
        </div>
    </div>

    <div class=\"row\">
        <!-- Tabla de bibliografías recientes -->
        <div class=\"col-xl-6 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Bibliografías Declaradas Recientes</h6>
                    ";
        // line 113
        if ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 113)) == "usuario")) {
            // line 114
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/listado-bibliografias\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    ";
        } else {
            // line 118
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    ";
        }
        // line 122
        yield "                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor(es)</th>
                                    <th>Tipo</th>
                                    <th>Formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 135
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasRecientes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
            // line 136
            yield "                                <tr>
                                    <td>";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 137), "html", null, true);
            yield "</td>
                                    <td>";
            // line 138
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 138), "html", null, true);
            yield "</td>
                                    <td>";
            // line 139
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 139), "html", null, true);
            yield "</td>
                                    <td>";
            // line 140
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "formato", [], "any", false, false, false, 140), "html", null, true);
            yield "</td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 142
        if (!$context['_iterated']) {
            // line 143
            yield "                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay bibliografías recientes</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 147
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de asignaturas recientes -->
        <div class=\"col-xl-6 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Recientes</h6>
                    ";
        // line 159
        if ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 159)) != "usuario")) {
            // line 160
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    ";
        }
        // line 164
        yield "                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Periodicidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 176
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturasRecientes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 177
            yield "                                <tr>
                                    <td>";
            // line 178
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 178), "html", null, true);
            yield "</td>
                                    <td>";
            // line 179
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 179), "html", null, true);
            yield "</td>
                                    <td>";
            // line 180
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 180), "html", null, true);
            yield "</td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 182
        if (!$context['_iterated']) {
            // line 183
            yield "                                <tr>
                                    <td colspan=\"3\" class=\"text-center\">No hay asignaturas recientes</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 187
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 197
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 198
        yield "<!-- Chart.js -->
<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>

<script>
    // Datos para el gráfico de cobertura
    ";
        // line 203
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["coberturaCarreras"] ?? null)) > 0)) {
            // line 204
            yield "    const coberturaData = {
        labels: [
            ";
            // line 206
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["coberturaCarreras"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 207
                yield "                '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "carrera_nombre", [], "any", false, false, false, 207), 0, 30), "html", null, true);
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "carrera_nombre", [], "any", false, false, false, 207)) > 30)) {
                    yield "...";
                }
                yield "',
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 209
            yield "        ],
        datasets: [{
            label: 'Cobertura Básica (%)',
            data: [
                ";
            // line 213
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["coberturaCarreras"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 214
                yield "                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cobertura_basica", [], "any", false, false, false, 214), "html", null, true);
                yield ",
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 216
            yield "            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)',
                'rgba(83, 102, 255, 0.8)',
                'rgba(78, 252, 3, 0.8)',
                'rgba(252, 3, 244, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(83, 102, 255, 1)',
                'rgba(78, 252, 3, 1)',
                'rgba(252, 3, 244, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración del gráfico
    const config = {
        type: 'bar',
        data: coberturaData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobertura Básica por Carrera de Pregrado'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Cobertura: ' + context.parsed.y.toFixed(1) + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Cobertura Básica (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Carreras'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    };

    // Crear el gráfico
    document.addEventListener('DOMContentLoaded', function() {
        ";
            // line 299
            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["coberturaCarreras"] ?? null)) > 0)) {
                // line 300
                yield "        const ctx = document.getElementById('coberturaChart').getContext('2d');
        new Chart(ctx, config);
        ";
            }
            // line 303
            yield "    });
    ";
        }
        // line 305
        yield "</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "dashboard/index.twig";
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
        return array (  509 => 305,  505 => 303,  500 => 300,  498 => 299,  413 => 216,  404 => 214,  400 => 213,  394 => 209,  382 => 207,  378 => 206,  374 => 204,  372 => 203,  365 => 198,  358 => 197,  345 => 187,  336 => 183,  334 => 182,  327 => 180,  323 => 179,  319 => 178,  316 => 177,  311 => 176,  297 => 164,  289 => 160,  287 => 159,  273 => 147,  264 => 143,  262 => 142,  255 => 140,  251 => 139,  247 => 138,  243 => 137,  240 => 136,  235 => 135,  220 => 122,  212 => 118,  204 => 114,  202 => 113,  189 => 102,  181 => 96,  177 => 94,  175 => 93,  167 => 88,  147 => 71,  127 => 54,  107 => 37,  87 => 20,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Dashboard - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Dashboard</h1>
    </div>

    <!-- Tarjetas de resumen -->
    <div class=\"row\">
        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-primary shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                                Bibliografías Declaradas</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">{{ totalBibliografias }}</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-list fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-success shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-success text-uppercase mb-1\">
                                Bibliografías Disponibles</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">{{ totalDisponibles }}</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-book fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-info shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-info text-uppercase mb-1\">
                                Asignaturas</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">{{ totalAsignaturas }}</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-book-open fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-xl-3 col-md-6 mb-4\">
            <div class=\"card border-left-warning shadow h-100 py-2\">
                <div class=\"card-body\">
                    <div class=\"row no-gutters align-items-center\">
                        <div class=\"col mr-2\">
                            <div class=\"text-xs font-weight-bold text-warning text-uppercase mb-1\">
                                Carreras</div>
                            <div class=\"h5 mb-0 font-weight-bold text-gray-800\">{{ totalCarreras }}</div>
                        </div>
                        <div class=\"col-auto\">
                            <i class=\"fas fa-graduation-cap fa-2x text-gray-300\"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row\">
        <!-- Gráfico de cobertura básica por carrera -->
        <div class=\"col-xl-12 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Cobertura Básica por Carrera (Pregrado)</h6>
                    <a href=\"{{ app_url }}reportes/coberturas\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fas fa-chart-bar\"></i> Ver Reportes
                    </a>
                </div>
                <div class=\"card-body\">
                    {% if coberturaCarreras|length > 0 %}
                        <canvas id=\"coberturaChart\" width=\"400\" height=\"200\"></canvas>
                    {% else %}
                        <div class=\"text-center py-4\">
                            <i class=\"fas fa-chart-bar fa-3x text-muted mb-3\"></i>
                            <h5 class=\"text-muted\">No hay datos de cobertura básica disponibles</h5>
                            <p class=\"text-muted\">Los datos de cobertura se mostrarán aquí una vez que se generen los reportes de cobertura básica.</p>
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>

    <div class=\"row\">
        <!-- Tabla de bibliografías recientes -->
        <div class=\"col-xl-6 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Bibliografías Declaradas Recientes</h6>
                    {% if session.user_rol|lower == 'usuario' %}
                        <a href=\"{{ app_url }}reportes/listado-bibliografias\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    {% else %}
                        <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    {% endif %}
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor(es)</th>
                                    <th>Tipo</th>
                                    <th>Formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for bibliografia in bibliografiasRecientes %}
                                <tr>
                                    <td>{{ bibliografia.titulo }}</td>
                                    <td>{{ bibliografia.autores }}</td>
                                    <td>{{ bibliografia.tipo }}</td>
                                    <td>{{ bibliografia.formato }}</td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay bibliografías recientes</td>
                                </tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de asignaturas recientes -->
        <div class=\"col-xl-6 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Recientes</h6>
                    {% if session.user_rol|lower != 'usuario' %}
                        <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-primary btn-sm\">
                            <i class=\"fas fa-list\"></i> Ver Todas
                        </a>
                    {% endif %}
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Periodicidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for asignatura in asignaturasRecientes %}
                                <tr>
                                    <td>{{ asignatura.nombre }}</td>
                                    <td>{{ asignatura.tipo }}</td>
                                    <td>{{ asignatura.periodicidad }}</td>
                                </tr>
                                {% else %}
                                <tr>
                                    <td colspan=\"3\" class=\"text-center\">No hay asignaturas recientes</td>
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
{% endblock %}

{% block scripts %}
<!-- Chart.js -->
<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>

<script>
    // Datos para el gráfico de cobertura
    {% if coberturaCarreras|length > 0 %}
    const coberturaData = {
        labels: [
            {% for carrera in coberturaCarreras %}
                '{{ carrera.carrera_nombre|slice(0, 30) }}{% if carrera.carrera_nombre|length > 30 %}...{% endif %}',
            {% endfor %}
        ],
        datasets: [{
            label: 'Cobertura Básica (%)',
            data: [
                {% for carrera in coberturaCarreras %}
                    {{ carrera.cobertura_basica }},
                {% endfor %}
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)',
                'rgba(83, 102, 255, 0.8)',
                'rgba(78, 252, 3, 0.8)',
                'rgba(252, 3, 244, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(83, 102, 255, 1)',
                'rgba(78, 252, 3, 1)',
                'rgba(252, 3, 244, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración del gráfico
    const config = {
        type: 'bar',
        data: coberturaData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Cobertura Básica por Carrera de Pregrado'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Cobertura: ' + context.parsed.y.toFixed(1) + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Cobertura Básica (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Carreras'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    };

    // Crear el gráfico
    document.addEventListener('DOMContentLoaded', function() {
        {% if coberturaCarreras|length > 0 %}
        const ctx = document.getElementById('coberturaChart').getContext('2d');
        new Chart(ctx, config);
        {% endif %}
    });
    {% endif %}
</script>
{% endblock %} ", "dashboard/index.twig", "/var/www/html/biblioges/templates/dashboard/index.twig");
    }
}
