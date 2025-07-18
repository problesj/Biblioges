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

/* admin/index.twig */
class __TwigTemplate_01cb817eb2f47a97bedffedf22b7ef0e extends Template
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
            'authenticated_content' => [$this, 'block_authenticated_content'],
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
        $this->parent = $this->loadTemplate("base.twig", "admin/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Panel de Administración";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_authenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Panel de Administración</h3>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Usuarios</h5>
                                    <p class=\"card-text\">Gestionar usuarios del sistema</p>
                                    <a href=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "usuarios\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Carreras</h5>
                                    <p class=\"card-text\">Gestionar carreras</p>
                                    <a href=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Facultades</h5>
                                    <p class=\"card-text\">Gestionar facultades</p>
                                    <a href=\"";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "facultades\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"row mt-4\">
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Sedes</h5>
                                    <p class=\"card-text\">Gestionar sedes</p>
                                    <a href=\"";
        // line 49
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "sedes\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Departamentos</h5>
                                    <p class=\"card-text\">Gestionar departamentos</p>
                                    <a href=\"";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">Asignaturas</h5>
                                    <p class=\"card-text\">Gestionar asignaturas</p>
                                    <a href=\"";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-primary\">Administrar</a>
                                </div>
                            </div>
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
        return "admin/index.twig";
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
        return array (  148 => 67,  136 => 58,  124 => 49,  110 => 38,  98 => 29,  86 => 20,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/index.twig", "/var/www/html/biblioges/templates/admin/index.twig");
    }
}
