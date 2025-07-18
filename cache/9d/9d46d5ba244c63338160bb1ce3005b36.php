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

/* login.twig */
class __TwigTemplate_0e3fad29fd2b5fa217fa738ab3c1559b extends Template
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
            'unauthenticated_content' => [$this, 'block_unauthenticated_content'],
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
        $this->parent = $this->loadTemplate("base.twig", "login.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Iniciar Sesión - Biblioges";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<div class=\"container-fluid\">
    <div class=\"row vh-80 align-items-center justify-content-center\">
        <div class=\"col-12 text-center mb-5\">
            <img src=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "public/assets/img/logo-ucn.png\" alt=\"Logo UCN\" class=\"img-fluid mb-3\" style=\"max-height: 100px;\">
            <h2 class=\"display-4 fw-bold\">Sistema de Gestión de Bibliografías UCN</h2>
        </div>
        <div class=\"col-10 col-md-6 col-lg-4\">
            <div class=\"card shadow-lg\">
                <div class=\"card-body p-4\">
                    ";
        // line 15
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", true, true, false, 15) && CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 15))) {
            // line 16
            yield "                    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                        ";
            // line 17
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 17), "html", null, true);
            yield "
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    </div>
                    ";
        }
        // line 21
        yield "
                    <h2 class=\"text-center mb-4\">Iniciar Sesión</h2>
                    <form action=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "login\" method=\"POST\">
                        <div class=\"mb-3\">
                            <label for=\"email\" class=\"form-label\">Correo Electrónico</label>
                            <input type=\"email\" class=\"form-control form-control-lg\" id=\"email\" name=\"email\" autocomplete=\"email\" required value=\"";
        // line 26
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "email", [], "any", true, true, false, 26)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "email", [], "any", false, false, false, 26), "")) : ("")), "html", null, true);
        yield "\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"password\" class=\"form-label\">Contraseña</label>
                            <input type=\"password\" class=\"form-control form-control-lg\" id=\"password\" name=\"password\" autocomplete=\"current-password\" required>
                        </div>
                        <div class=\"d-grid\">
                            <button type=\"submit\" class=\"btn btn-primary btn-lg\">Iniciar Sesión</button>
                        </div>
                    </form>
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
        return "login.twig";
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
        return array (  106 => 26,  100 => 23,  96 => 21,  89 => 17,  86 => 16,  84 => 15,  75 => 9,  70 => 6,  63 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "login.twig", "/var/www/html/biblioges/templates/login.twig");
    }
}
