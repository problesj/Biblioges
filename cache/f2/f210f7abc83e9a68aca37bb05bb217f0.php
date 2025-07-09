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

/* bibliografias/index.twig */
class __TwigTemplate_6d4e2ee686e12719cabd73f6956f64b5 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografías Declaradas - Sistema de Bibliografía";
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
    <h1 class=\"h3 mb-4 text-gray-800\">Bibliografías Declaradas</h1>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Lista de Bibliografías</h6>
            <a href=\"";
        // line 12
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/crear\" class=\"btn btn-sm btn-primary\">Nueva Bibliografía</a>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-bordered\" width=\"100%\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autores</th>
                            <th>Asignaturas</th>
                            <th>Tipo</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografias"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["bibliografia"]) {
            // line 31
            yield "                        <tr>
                            <td>";
            // line 32
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 32), "html", null, true);
            yield "</td>
                            <td>";
            // line 33
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "titulo", [], "any", false, false, false, 33), "html", null, true);
            yield "</td>
                            <td>";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "autores", [], "any", false, false, false, 34), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 36
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas_vinculadas", [], "any", false, false, false, 36) != "Sin asignaturas")) {
                // line 37
                yield "                                    ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "asignaturas_vinculadas", [], "any", false, false, false, 37), ";"));
                foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                    // line 38
                    yield "                                        ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::trim($context["asignatura"]), "html", null, true);
                    yield "<br>
                                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 40
                yield "                                ";
            } else {
                // line 41
                yield "                                    Sin asignaturas vinculadas
                                ";
            }
            // line 43
            yield "                            </td>
                            <td>";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "tipo", [], "any", false, false, false, 44), "html", null, true);
            yield "</td>
                            <td>";
            // line 45
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "anio_publicacion", [], "any", false, false, false, 45), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 47
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "estado", [], "any", false, false, false, 47) == "A")) {
                // line 48
                yield "                                    <span class=\"badge badge-success\">Activa</span>
                                ";
            } else {
                // line 50
                yield "                                    <span class=\"badge badge-danger\">Inactiva</span>
                                ";
            }
            // line 52
            yield "                            </td>
                            <td>
                                <a href=\"";
            // line 54
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 54), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\">
                                    <i class=\"fas fa-eye\"></i>
                                </a>
                                <a href=\"";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bibliografia"], "id", [], "any", false, false, false, 57), "html", null, true);
            yield "/editar\" class=\"btn btn-sm btn-warning\">
                                    <i class=\"fas fa-edit\"></i>
                                </a>
                            </td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bibliografia'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 71
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 72
        yield "<script>
    // Aquí puedes agregar scripts específicos de la página si son necesarios
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "bibliografias/index.twig";
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
        return array (  209 => 72,  202 => 71,  191 => 63,  177 => 57,  169 => 54,  165 => 52,  161 => 50,  157 => 48,  155 => 47,  150 => 45,  146 => 44,  143 => 43,  139 => 41,  136 => 40,  127 => 38,  122 => 37,  120 => 36,  115 => 34,  111 => 33,  107 => 32,  104 => 31,  100 => 30,  79 => 12,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "bibliografias/index.twig", "/var/www/html/biblioges/templates/bibliografias/index.twig");
    }
}
