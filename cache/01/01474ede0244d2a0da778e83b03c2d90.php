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

/* base.twig */
class __TwigTemplate_2dff20b2630b1b21e16746ae4e577b89 extends Template
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

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
            'unauthenticated_content' => [$this, 'block_unauthenticated_content'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"es\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    
    <!-- Bootstrap CSS -->
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    
    <!-- Font Awesome -->
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css\" rel=\"stylesheet\">
    
    <!-- DataTables -->
    <link href=\"https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css\" rel=\"stylesheet\">
    
    <!-- Custom CSS -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            width: 250px;
            overflow-y: auto;
            max-height: 100vh;
        }
        
        .sidebar.collapsed {
            margin-left: -250px;
        }
        
        .content {
            margin-left: 250px;
            transition: all 0.3s;
            width: calc(100% - 250px);
            padding: 20px;
        }
        
        .content.expanded {
            margin-left: 0;
            width: 100%;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar .nav-link:hover {
            color: rgba(255,255,255,1);
            background-color: rgba(255,255,255,.1);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,.1);
        }
        
        .sidebar .nav-link i {
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }
        
        .sidebar .menu-group {
            padding: 0.5rem 1rem;
            color: rgba(255,255,255,.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .sidebar .menu-divider {
            border-top: 1px solid rgba(255,255,255,.1);
            margin: 0.5rem 0;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
            position: fixed;
            left: 250px;
            top: 10px;
            z-index: 1001;
            background-color: #343a40;
            border-radius: 0 5px 5px 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
        }

        .sidebar-toggle:focus-visible {
            outline: 2px solid #4e73df;
            outline-offset: -2px;
        }

        .sidebar-toggle i {
            font-size: 1.25rem;
        }

        .sidebar.collapsed + .content .sidebar-toggle {
            left: 0;
        }

        /* Estilos para resoluciones pequeñas */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            
            .sidebar.collapsed {
                margin-left: -200px;
            }
            
            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
            
            .sidebar-toggle {
                left: 200px;
            }
        }
    </style>
</head>
<body>
    ";
        // line 176
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 176)) {
            // line 177
            yield "    <div class=\"d-flex\">
        <!-- Sidebar -->
        <div class=\"sidebar\" id=\"sidebar\">
            <div class=\"p-3\">
                <div class=\"d-flex justify-content-between align-items-center\">
                    <h5 class=\"text-white mb-0\">Biblioges</h5>
                </div>
                <hr class=\"text-white\">
                <ul class=\"nav flex-column\">
                    <!-- PRINCIPAL -->
                    <li class=\"menu-group\">PRINCIPAL</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 189
            if (((($context["current_page"] ?? null) == "dashboard") ||  !($context["current_page"] ?? null))) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "dashboard\">
                            <i class=\"fas fa-tachometer-alt\"></i> Dashboard
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 194
            if ((($context["current_page"] ?? null) == "carreras")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras\">
                            <i class=\"fas fa-graduation-cap\"></i> Carreras
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 199
            if ((($context["current_page"] ?? null) == "asignaturas")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "asignaturas\">
                            <i class=\"fas fa-book-open\"></i> Asignaturas
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 204
            if ((($context["current_page"] ?? null) == "mallas")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "mallas\">
                            <i class=\"fas fa-project-diagram\"></i> Mallas
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 209
            if ((($context["current_page"] ?? null) == "bibliografias-declaradas")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas\">
                            <i class=\"fas fa-book\"></i> Bibliografía Declarada
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 214
            if ((($context["current_page"] ?? null) == "bibliografias-disponibles")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-disponibles\">
                            <i class=\"fas fa-book\"></i> Bibliografía Disponible
                        </a>
                    </li>

                    <!-- REPORTES -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">REPORTES</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 223
            if ((($context["current_page"] ?? null) == "cobertura")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "cobertura\">
                            <i class=\"fas fa-chart-pie\"></i> Cobertura
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 228
            if ((($context["current_page"] ?? null) == "listado-bibliografias")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "listado-bibliografias\">
                            <i class=\"fas fa-file-alt\"></i> Listado de Bibliografías
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 233
            if ((($context["current_page"] ?? null) == "reportes-personalizados")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes-personalizados\">
                            <i class=\"fas fa-cogs\"></i> Reportes Personalizados
                        </a>
                    </li>

                    <!-- ADMINISTRACIÓN -->
                    ";
            // line 239
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 239) == "admin")) {
                // line 240
                yield "                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">ADMINISTRACIÓN</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 243
                if ((($context["current_page"] ?? null) == "sedes")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "sedes\">
                            <i class=\"fas fa-building\"></i> Sedes
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 248
                if ((($context["current_page"] ?? null) == "facultades")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "facultades\">
                            <i class=\"fas fa-university\"></i> Facultades
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 253
                if ((($context["current_page"] ?? null) == "departamentos")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "departamentos\">
                            <i class=\"fas fa-sitemap\"></i> Departamentos
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 258
                if ((($context["current_page"] ?? null) == "usuarios")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "usuarios\">
                            <i class=\"fas fa-users\"></i> Usuarios
                        </a>
                    </li>
                    ";
            }
            // line 263
            yield "
                    <!-- Perfil y Cerrar Sesión -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 267
            if ((($context["current_page"] ?? null) == "perfil")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "perfil\">
                            <i class=\"fas fa-user\"></i> Perfil
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"";
            // line 272
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "logout\">
                            <i class=\"fas fa-sign-out-alt\"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class=\"content\" id=\"content\">
            <!-- Toggle Sidebar Button -->
            <button class=\"sidebar-toggle\" id=\"sidebarToggle\">
                <i class=\"fas fa-chevron-left\"></i>
            </button>

            <!-- Main Content -->
            <main class=\"container-fluid py-4\">
                <!-- Mensajes de alerta -->
                ";
            // line 290
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 290))) {
                // line 291
                yield "                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    ";
                // line 292
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 292), "html", null, true);
                yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>
                ";
            }
            // line 296
            yield "
                ";
            // line 297
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 297))) {
                // line 298
                yield "                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    ";
                // line 299
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 299), "html", null, true);
                yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>
                ";
            }
            // line 303
            yield "
                ";
            // line 304
            yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
            // line 305
            yield "            </main>
        </div>
    </div>
    ";
        } else {
            // line 309
            yield "        ";
            yield from $this->unwrap()->yieldBlock('unauthenticated_content', $context, $blocks);
            // line 310
            yield "    ";
        }
        // line 311
        yield "
    <!-- jQuery -->
    <script src=\"https://code.jquery.com/jquery-3.7.0.min.js\"></script>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"></script>
    
    <!-- DataTables -->
    <script src=\"https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js\"></script>
    <script src=\"https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js\"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const toggleIcon = sidebarToggle.querySelector('i');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                toggleIcon.classList.toggle('fa-chevron-left');
                toggleIcon.classList.toggle('fa-chevron-right');
            });

            // Ocultar automáticamente los mensajes de alerta después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                    
                    // Limpiar las variables de sesión después de cerrar la alerta
                    fetch('";
        // line 347
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "clear-session-messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                }, 5000);
            });
        });
    </script>

    ";
        // line 359
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        // line 360
        yield "</body>
</html> ";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Biblioges";
        yield from [];
    }

    // line 304
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 309
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 359
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.twig";
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
        return array (  585 => 359,  575 => 309,  565 => 304,  554 => 6,  548 => 360,  546 => 359,  531 => 347,  493 => 311,  490 => 310,  487 => 309,  481 => 305,  479 => 304,  476 => 303,  469 => 299,  466 => 298,  464 => 297,  461 => 296,  454 => 292,  451 => 291,  449 => 290,  428 => 272,  416 => 267,  410 => 263,  398 => 258,  386 => 253,  374 => 248,  362 => 243,  357 => 240,  355 => 239,  342 => 233,  330 => 228,  318 => 223,  302 => 214,  290 => 209,  278 => 204,  266 => 199,  254 => 194,  242 => 189,  228 => 177,  226 => 176,  53 => 6,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "base.twig", "/var/www/html/biblioges/templates/base.twig");
    }
}
