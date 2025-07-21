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
class __TwigTemplate_1c018f603f4eafe87dbc8b5ff7e9da12 extends Template
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
            'styles' => [$this, 'block_styles'],
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
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<style>
    body {
        background-image: url('";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "fondo_inicio.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    .login-container {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .card {
        background-color: transparent;
        border: none;
        box-shadow: none;
    }
    
    .card-body {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }
</style>
";
        yield from [];
    }

    // line 37
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 38
        yield "<div class=\"container-fluid\">
    <div class=\"row vh-100 align-items-center justify-content-center\">
        <div class=\"col-12 text-center mb-3\">
            <!-- <img src=\"";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "public/assets/img/logo-ucn.png\" alt=\"Logo UCN\" class=\"img-fluid mb-3\" style=\"max-height: 100px;\"> -->
            <h2 class=\"display-4 fw-bold text-white\" style=\"text-shadow: 2px 2px 4px rgba(0,0,0,0.7);\">Sistema de Gestión de Bibliografías UCN</h2>
        </div>
        <div class=\"col-10 col-md-6 col-lg-4\">
            <div class=\"card shadow-lg login-container\">
                <div class=\"card-body p-4\">
                    ";
        // line 47
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", true, true, false, 47) && CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 47))) {
            // line 48
            yield "                    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                        ";
            // line 49
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 49), "html", null, true);
            yield "
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    </div>
                    ";
        }
        // line 53
        yield "
                    <h2 class=\"text-center mb-4\">Iniciar Sesión</h2>
                    <form action=\"";
        // line 55
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "login\" method=\"POST\">
                        <div class=\"mb-3\">
                            <label for=\"email\" class=\"form-label\">Correo Electrónico</label>
                            <input type=\"email\" class=\"form-control form-control-lg\" id=\"email\" name=\"email\" autocomplete=\"email\" required value=\"";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "email", [], "any", true, true, false, 58)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "email", [], "any", false, false, false, 58), "")) : ("")), "html", null, true);
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
                    
                    <div class=\"mt-4 text-center\">
                        <small class=\"text-muted\">
                            <i class=\"fas fa-info-circle\"></i>
                            El sistema utiliza autenticación con Active Directory. 
                            Si el servidor LDAP no está disponible, se usará la contraseña local.
                        </small>
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
        return array (  151 => 58,  145 => 55,  141 => 53,  134 => 49,  131 => 48,  129 => 47,  120 => 41,  115 => 38,  108 => 37,  75 => 8,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Iniciar Sesión - Biblioges{% endblock %}

{% block styles %}
<style>
    body {
        background-image: url('{{ app_url }}fondo_inicio.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    .login-container {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .card {
        background-color: transparent;
        border: none;
        box-shadow: none;
    }
    
    .card-body {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }
</style>
{% endblock %}

{% block unauthenticated_content %}
<div class=\"container-fluid\">
    <div class=\"row vh-100 align-items-center justify-content-center\">
        <div class=\"col-12 text-center mb-3\">
            <!-- <img src=\"{{ app_url }}public/assets/img/logo-ucn.png\" alt=\"Logo UCN\" class=\"img-fluid mb-3\" style=\"max-height: 100px;\"> -->
            <h2 class=\"display-4 fw-bold text-white\" style=\"text-shadow: 2px 2px 4px rgba(0,0,0,0.7);\">Sistema de Gestión de Bibliografías UCN</h2>
        </div>
        <div class=\"col-10 col-md-6 col-lg-4\">
            <div class=\"card shadow-lg login-container\">
                <div class=\"card-body p-4\">
                    {% if session.error is defined and session.error %}
                    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                        {{ session.error }}
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    </div>
                    {% endif %}

                    <h2 class=\"text-center mb-4\">Iniciar Sesión</h2>
                    <form action=\"{{ app_url }}login\" method=\"POST\">
                        <div class=\"mb-3\">
                            <label for=\"email\" class=\"form-label\">Correo Electrónico</label>
                            <input type=\"email\" class=\"form-control form-control-lg\" id=\"email\" name=\"email\" autocomplete=\"email\" required value=\"{{ session.email|default('') }}\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"password\" class=\"form-label\">Contraseña</label>
                            <input type=\"password\" class=\"form-control form-control-lg\" id=\"password\" name=\"password\" autocomplete=\"current-password\" required>
                        </div>
                        <div class=\"d-grid\">
                            <button type=\"submit\" class=\"btn btn-primary btn-lg\">Iniciar Sesión</button>
                        </div>
                    </form>
                    
                    <div class=\"mt-4 text-center\">
                        <small class=\"text-muted\">
                            <i class=\"fas fa-info-circle\"></i>
                            El sistema utiliza autenticación con Active Directory. 
                            Si el servidor LDAP no está disponible, se usará la contraseña local.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %} ", "login.twig", "/var/www/html/biblioges/templates/login.twig");
    }
}
