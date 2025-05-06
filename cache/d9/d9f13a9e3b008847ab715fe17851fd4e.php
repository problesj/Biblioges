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
class __TwigTemplate_9f71708bff0bac0dd5123ebc9f5b2420 extends Template
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
        <!-- Tabla de bibliografías recientes -->
        <div class=\"col-xl-6 mb-4\">
            <div class=\"card shadow\">
                <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Bibliografías Declaradas Recientes</h6>
                    <a href=\"";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fas fa-list\"></i> Ver Todas
                    </a>
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
                                ";
        // line 104
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasRecientes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
            // line 105
            yield "                                <tr>
                                    <td>";
            // line 106
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 106), "html", null, true);
            yield "</td>
                                    <td>";
            // line 107
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 107), "html", null, true);
            yield "</td>
                                    <td>";
            // line 108
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 108), "html", null, true);
            yield "</td>
                                    <td>";
            // line 109
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "formato", [], "any", false, false, false, 109), "html", null, true);
            yield "</td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 111
        if (!$context['_iterated']) {
            // line 112
            yield "                                <tr>
                                    <td colspan=\"4\" class=\"text-center\">No hay bibliografías recientes</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 116
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
                    <a href=\"";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fas fa-list\"></i> Ver Todas
                    </a>
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
                                ";
        // line 143
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturasRecientes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 144
            yield "                                <tr>
                                    <td>";
            // line 145
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 145), "html", null, true);
            yield "</td>
                                    <td>";
            // line 146
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo", [], "any", false, false, false, 146), "html", null, true);
            yield "</td>
                                    <td>";
            // line 147
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "periodicidad", [], "any", false, false, false, 147), "html", null, true);
            yield "</td>
                                </tr>
                                ";
            $context['_iterated'] = true;
        }
        // line 149
        if (!$context['_iterated']) {
            // line 150
            yield "                                <tr>
                                    <td colspan=\"3\" class=\"text-center\">No hay asignaturas recientes</td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 154
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

    // line 164
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 165
        yield "<script>
    // Aquí puedes agregar scripts específicos del dashboard si son necesarios
</script>
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
        return array (  310 => 165,  303 => 164,  290 => 154,  281 => 150,  279 => 149,  272 => 147,  268 => 146,  264 => 145,  261 => 144,  256 => 143,  238 => 128,  224 => 116,  215 => 112,  213 => 111,  206 => 109,  202 => 108,  198 => 107,  194 => 106,  191 => 105,  186 => 104,  167 => 88,  147 => 71,  127 => 54,  107 => 37,  87 => 20,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "dashboard/index.twig", "/var/www/html/biblioges/templates/dashboard/index.twig");
    }
}
