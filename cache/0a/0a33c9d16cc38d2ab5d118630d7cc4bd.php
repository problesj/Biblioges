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

/* auth/login.twig */
class __TwigTemplate_51f98e4e821499ccfb3ff8813bbb60ae extends Template
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
            'styles' => [$this, 'block_styles'],
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
        $this->parent = $this->loadTemplate("base.twig", "auth/login.twig", 1);
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
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "    <!-- Contenido Principal -->
    <main class=\"container my-4\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-6 col-lg-4\">
                <div class=\"card shadow\">
                    <div class=\"card-body\">
                        <h2 class=\"text-center mb-4\">Iniciar Sesión</h2>
                        
                        ";
        // line 14
        if (array_key_exists("error", $context)) {
            // line 15
            yield "                        <div class=\"alert alert-danger\">
                            ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
                        </div>
                        ";
        }
        // line 19
        yield "                        
                        <form id=\"loginForm\" action=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "login\" method=\"POST\" class=\"user\" novalidate>
                            <div class=\"form-group\">
                                <label for=\"email\">Correo Electrónico</label>
                                <input type=\"email\" 
                                       class=\"form-control\" 
                                       id=\"email\" 
                                       name=\"email\" 
                                       required 
                                       autocomplete=\"email\"
                                       value=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
        yield "\">
                            </div>
                            
                            <div class=\"form-group\">
                                <label for=\"password\">Contraseña</label>
                                <input type=\"password\" 
                                       class=\"form-control\" 
                                       id=\"password\" 
                                       name=\"password\" 
                                       required 
                                       autocomplete=\"current-password\">
                            </div>
                            
                            <div class=\"d-grid\">
                                <button type=\"submit\" class=\"btn btn-primary\">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
";
        yield from [];
    }

    // line 53
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 54
        yield "<style>
    .bg-login-image {
        background: url(\"https://source.unsplash.com/K4mSJ7kc0As/600x800\");
        background-position: center;
        background-size: cover;
    }
    
    .btn-user {
        font-size: 0.8rem;
        border-radius: 10rem;
        padding: 0.75rem 1rem;
    }
    
    .form-control-user {
        font-size: 0.8rem;
        border-radius: 10rem;
        padding: 0.75rem 1rem;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 5px;
        color: white;
        z-index: 1000;
    }

    .notification.success {
        background-color: #28a745;
    }

    .notification.error {
        background-color: #dc3545;
    }
</style>
";
        yield from [];
    }

    // line 93
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 94
        yield "<script>
    (function() {
        'use strict';

        const loginForm = document.getElementById('loginForm');
        
        if (loginForm) {
            console.log('Formulario de login encontrado');
            
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();
                
                console.log('Datos del formulario:', { email, password });
                
                if (!email || !password) {
                    showNotification('Por favor complete todos los campos', 'error');
                    return;
                }
                
                try {
                    console.log('Enviando datos de login...');
                    
                    const formData = new FormData();
                    formData.append('email', email);
                    formData.append('password', password);
                    
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    console.log('Status de la respuesta:', response.status);
                    console.log('Content-Type:', response.headers.get('Content-Type'));
                    
                    const contentType = response.headers.get('Content-Type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('Respuesta del servidor:', text);
                        throw new Error('La respuesta del servidor no es JSON');
                    }
                    
                    const result = await response.json();
                    console.log('Respuesta del servidor:', result);
                    
                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        showNotification(result.message || 'Error en las credenciales', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Error al conectar con el servidor. Por favor intente nuevamente.', 'error');
                }
            });
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification \${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    })();
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "auth/login.twig";
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
        return array (  192 => 94,  185 => 93,  143 => 54,  136 => 53,  108 => 29,  96 => 20,  93 => 19,  87 => 16,  84 => 15,  82 => 14,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/login.twig", "/var/www/html/biblioges/templates/auth/login.twig");
    }
}
