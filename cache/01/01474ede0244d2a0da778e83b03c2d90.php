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
    
    <!-- SweetAlert2 -->
    <link href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\" rel=\"stylesheet\">
    
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
        // line 179
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 179)) {
            // line 180
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
            // line 192
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
            // line 197
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
            // line 202
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
            // line 207
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
            // line 212
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
            // line 217
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
            // line 226
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
            // line 231
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
            // line 236
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
            // line 242
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 242) == "admin")) {
                // line 243
                yield "                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">ADMINISTRACIÓN</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 246
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
                // line 251
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
                // line 256
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
                // line 261
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
            // line 266
            yield "
                    <!-- Perfil y Cerrar Sesión -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 270
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
            // line 275
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
                ";
            // line 292
            yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
            // line 293
            yield "            </main>
        </div>
    </div>
    ";
        } else {
            // line 297
            yield "        ";
            yield from $this->unwrap()->yieldBlock('unauthenticated_content', $context, $blocks);
            // line 298
            yield "    ";
        }
        // line 299
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

    <!-- SweetAlert2 -->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>

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
        // line 338
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

            // Mostrar alertas de SweetAlert2 si existen
            ";
        // line 349
        if ((array_key_exists("swal", $context) && ($context["swal"] ?? null))) {
            // line 350
            yield "                Swal.fire({
                    icon: '";
            // line 351
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 351), "html", null, true);
            yield "',
                    title: '";
            // line 352
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 352), "html", null, true);
            yield "',
                    text: '";
            // line 353
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 353), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar'
                });
            ";
        }
        // line 357
        yield "        });
    </script>

    ";
        // line 360
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        // line 393
        yield "
    <!-- SweetAlert2 Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
        // line 397
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 397)) {
            // line 398
            yield "                Swal.fire({
                    icon: '";
            // line 399
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 399), "icon", [], "any", false, false, false, 399), "html", null, true);
            yield "',
                    title: '";
            // line 400
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 400), "title", [], "any", false, false, false, 400), "html", null, true);
            yield "',
                    text: '";
            // line 401
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 401), "text", [], "any", false, false, false, 401), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#4e73df',
                    timer: null,
                    timerProgressBar: false,
                    allowOutsideClick: false
                });
            ";
        }
        // line 409
        yield "        });

        function mostrarNotificacion(mensaje, tipo = 'success') {
            Swal.fire({
                icon: tipo,
                title: tipo === 'success' ? 'Éxito' : 'Error',
                text: mensaje,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4e73df',
                timer: null,
                timerProgressBar: false,
                allowOutsideClick: false
            });
        }
    </script>
</body>
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

    // line 292
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 297
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 360
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 361
        yield "    <!-- jQuery -->
    <script src=\"https://code.jquery.com/jquery-3.7.1.min.js\"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"></script>

    <!-- DataTables -->
    <script src=\"https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js\"></script>
    <script src=\"https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js\"></script>

    <!-- SweetAlert2 -->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>

    <!-- Custom Scripts -->
    <script>
        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.querySelector('.content');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                });
            }
        });
    </script>
    ";
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
        return array (  636 => 361,  629 => 360,  619 => 297,  609 => 292,  598 => 6,  577 => 409,  566 => 401,  562 => 400,  558 => 399,  555 => 398,  553 => 397,  547 => 393,  545 => 360,  540 => 357,  533 => 353,  529 => 352,  525 => 351,  522 => 350,  520 => 349,  506 => 338,  465 => 299,  462 => 298,  459 => 297,  453 => 293,  451 => 292,  431 => 275,  419 => 270,  413 => 266,  401 => 261,  389 => 256,  377 => 251,  365 => 246,  360 => 243,  358 => 242,  345 => 236,  333 => 231,  321 => 226,  305 => 217,  293 => 212,  281 => 207,  269 => 202,  257 => 197,  245 => 192,  231 => 180,  229 => 179,  53 => 6,  46 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "base.twig", "/var/www/html/biblioges/templates/base.twig");
    }
}
