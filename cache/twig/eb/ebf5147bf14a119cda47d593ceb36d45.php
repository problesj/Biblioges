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
class __TwigTemplate_0abc41e98917abe7a9f18caa74c99c1a extends Template
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
            'styles' => [$this, 'block_styles'],
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
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 7
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    
    <!-- Favicon -->
    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "favicon.ico\">
    
    <!-- Bootstrap CSS -->
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    
    <!-- Font Awesome -->
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css\" rel=\"stylesheet\">
    
    <!-- DataTables -->
    <link href=\"https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css\" rel=\"stylesheet\">
    
    <!-- AYa -->
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
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            width: 250px;
            overflow-y: auto;
            max-height: 100vh;
            transform: translateX(0);
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .content {
            margin-left: 250px;
            transition: all 0.3s ease;
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
    
    ";
        // line 183
        yield from $this->unwrap()->yieldBlock('styles', $context, $blocks);
        // line 184
        yield "</head>
<body>
";
        // line 186
        $context["current_page"] = ((        $this->unwrap()->hasBlock("current_page", $context, $blocks)) ? (        $this->unwrap()->renderBlock("current_page", $context, $blocks)) : (((array_key_exists("current_page", $context)) ? (Twig\Extension\CoreExtension::default(($context["current_page"] ?? null), "")) : (""))));
        // line 187
        yield "    ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 187)) {
            // line 188
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
            // line 200
            if (((($context["current_page"] ?? null) == "dashboard") ||  !($context["current_page"] ?? null))) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "dashboard\">
                            <i class=\"fas fa-tachometer-alt\"></i> Dashboard
                        </a>
                    </li>
                    ";
            // line 204
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 204) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 204) == "admin_bidoc"))) {
                // line 205
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 206
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
                // line 211
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
                // line 216
                if ((($context["current_page"] ?? null) == "mallas")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "mallas\">
                            <i class=\"fas fa-project-diagram\"></i> Mallas
                        </a>
                    </li>
                    ";
            }
            // line 221
            yield "                    ";
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 221) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 221) == "admin_bidoc"))) {
                // line 222
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 223
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
                // line 228
                if ((($context["current_page"] ?? null) == "bibliografias-disponibles")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "bibliografias-disponibles\">
                            <i class=\"fas fa-book\"></i> Bibliografía Disponible
                        </a>
                    </li>
                    ";
            }
            // line 233
            yield "
                    <!-- REPORTES -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">REPORTES</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 238
            if ((($context["current_page"] ?? null) == "coberturas")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/coberturas\">
                            <i class=\"fas fa-chart-pie\"></i> Cobertura
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 243
            if ((($context["current_page"] ?? null) == "listado-bibliografias")) {
                yield "active";
            }
            yield "\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "reportes/listado-bibliografias\">
                            <i class=\"fas fa-list\"></i> Listado de Bibliografías
                        </a>
                    </li>


                    <!-- ADMINISTRACIÓN -->
                    ";
            // line 250
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 250) == "admin")) {
                // line 251
                yield "                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">ADMINISTRACIÓN</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 254
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
                // line 259
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
                // line 264
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
                // line 269
                if ((($context["current_page"] ?? null) == "usuarios")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "usuarios\">
                            <i class=\"fas fa-users\"></i> Usuarios
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 274
                if ((($context["current_page"] ?? null) == "tareas_programadas")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "tareas-programadas\">
                            <i class=\"fas fa-clock\"></i> Tareas Programadas
                        </a>
                    </li>
                    ";
            }
            // line 279
            yield "                    ";
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 279) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 279) == "admin_bidoc"))) {
                // line 280
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 281
                if ((($context["current_page"] ?? null) == "autores")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores\">
                            <i class=\"fas fa-user-edit\"></i> Autores
                        </a>
                    </li>
                    ";
            }
            // line 286
            yield "
                    <!-- Perfil y Cerrar Sesión -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 290
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
            // line 295
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
            // line 312
            yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
            // line 313
            yield "            </main>
        </div>
    </div>
    ";
        } else {
            // line 317
            yield "        ";
            yield from $this->unwrap()->yieldBlock('unauthenticated_content', $context, $blocks);
            // line 318
            yield "    ";
        }
        // line 319
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
            console.log('DOM loaded, initializing sidebar toggle...');
            
            // Toggle del sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            console.log('Elements found:', {
                sidebarToggle: !!sidebarToggle,
                sidebar: !!sidebar,
                content: !!content
            });
            
            if (sidebarToggle && sidebar && content) {
                console.log('All elements found, adding event listener...');
                
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Toggle sidebar clicked');
                    
                    // Verificar estado actual
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    console.log('Current state - collapsed:', isCollapsed);
                    
                    // Toggle classes
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    
                    // Verificar estado después del toggle
                    const newCollapsed = sidebar.classList.contains('collapsed');
                    const newExpanded = content.classList.contains('expanded');
                    console.log('New state - collapsed:', newCollapsed, 'expanded:', newExpanded);
                    
                    // Toggle icon
                    const toggleIcon = sidebarToggle.querySelector('i');
                    if (toggleIcon) {
                        toggleIcon.classList.toggle('fa-chevron-left');
                        toggleIcon.classList.toggle('fa-chevron-right');
                        console.log('Icon toggled');
                    }
                });
                
                console.log('Event listener added successfully');
            } else {
                console.error('Some elements not found:', {
                    sidebarToggle: !!sidebarToggle,
                    sidebar: !!sidebar,
                    content: !!content
                });
            }

            // Verificar si la sesión está activa
            ";
        // line 390
        if ( !CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 390)) {
            // line 391
            yield "                // Si no hay sesión activa y no estamos en la página de login, redirigir
                if (!window.location.href.includes('login')) {
                    window.location.href = '";
            // line 393
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "login';
                }
            ";
        }
        // line 396
        yield "
            // Ocultar automáticamente los mensajes de alerta después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                    
                    // Limpiar las variables de sesión después de cerrar la alerta
                    fetch('";
        // line 405
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
        // line 416
        if ((array_key_exists("swal", $context) && ($context["swal"] ?? null))) {
            // line 417
            yield "                Swal.fire({
                    icon: '";
            // line 418
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 418), "html", null, true);
            yield "',
                    title: '";
            // line 419
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 419), "html", null, true);
            yield "',
                    text: '";
            // line 420
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 420), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar'
                });
            ";
        }
        // line 424
        yield "        });
    </script>

    ";
        // line 427
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        // line 440
        yield "
    <!-- SweetAlert2 Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
        // line 444
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 444)) {
            // line 445
            yield "                Swal.fire({
                    icon: '";
            // line 446
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 446), "icon", [], "any", false, false, false, 446), "html", null, true);
            yield "',
                    title: '";
            // line 447
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 447), "title", [], "any", false, false, false, 447), "html", null, true);
            yield "',
                    text: '";
            // line 448
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 448), "text", [], "any", false, false, false, 448), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#4e73df',
                    timer: null,
                    timerProgressBar: false,
                    allowOutsideClick: false
                });
            ";
        }
        // line 456
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

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Biblioges";
        yield from [];
    }

    // line 183
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 312
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 317
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 427
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 428
        yield "    <!-- Bootstrap Bundle with Popper -->
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"></script>

    <!-- DataTables -->
    <script src=\"https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js\"></script>
    <script src=\"https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js\"></script>

    <!-- SweetAlert2 -->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
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
        return array (  750 => 428,  743 => 427,  733 => 317,  723 => 312,  713 => 183,  702 => 7,  681 => 456,  670 => 448,  666 => 447,  662 => 446,  659 => 445,  657 => 444,  651 => 440,  649 => 427,  644 => 424,  637 => 420,  633 => 419,  629 => 418,  626 => 417,  624 => 416,  610 => 405,  599 => 396,  593 => 393,  589 => 391,  587 => 390,  514 => 319,  511 => 318,  508 => 317,  502 => 313,  500 => 312,  480 => 295,  468 => 290,  462 => 286,  450 => 281,  447 => 280,  444 => 279,  432 => 274,  420 => 269,  408 => 264,  396 => 259,  384 => 254,  379 => 251,  377 => 250,  363 => 243,  351 => 238,  344 => 233,  332 => 228,  320 => 223,  317 => 222,  314 => 221,  302 => 216,  290 => 211,  278 => 206,  275 => 205,  273 => 204,  262 => 200,  248 => 188,  245 => 187,  243 => 186,  239 => 184,  237 => 183,  61 => 10,  55 => 7,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"es\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{% block title %}Biblioges{% endblock %}</title>
    
    <!-- Favicon -->
    <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ app_url }}favicon.ico\">
    
    <!-- Bootstrap CSS -->
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    
    <!-- Font Awesome -->
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css\" rel=\"stylesheet\">
    
    <!-- DataTables -->
    <link href=\"https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css\" rel=\"stylesheet\">
    
    <!-- AYa -->
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
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            width: 250px;
            overflow-y: auto;
            max-height: 100vh;
            transform: translateX(0);
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .content {
            margin-left: 250px;
            transition: all 0.3s ease;
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
    
    {% block styles %}{% endblock %}
</head>
<body>
{% set current_page = block('current_page') is defined ? block('current_page') : current_page|default('') %}
    {% if session.user_id %}
    <div class=\"d-flex\">
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
                        <a class=\"nav-link {% if current_page == 'dashboard' or not current_page %}active{% endif %}\" href=\"{{ app_url }}dashboard\">
                            <i class=\"fas fa-tachometer-alt\"></i> Dashboard
                        </a>
                    </li>
                    {% if session.user_rol == 'admin' or session.user_rol == 'admin_bidoc' %}
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'carreras' %}active{% endif %}\" href=\"{{ app_url }}carreras\">
                            <i class=\"fas fa-graduation-cap\"></i> Carreras
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'asignaturas' %}active{% endif %}\" href=\"{{ app_url }}asignaturas\">
                            <i class=\"fas fa-book-open\"></i> Asignaturas
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'mallas' %}active{% endif %}\" href=\"{{ app_url }}mallas\">
                            <i class=\"fas fa-project-diagram\"></i> Mallas
                        </a>
                    </li>
                    {% endif %}
                    {% if session.user_rol == 'admin' or session.user_rol == 'admin_bidoc' %}
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'bibliografias-declaradas' %}active{% endif %}\" href=\"{{ app_url }}bibliografias-declaradas\">
                            <i class=\"fas fa-book\"></i> Bibliografía Declarada
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'bibliografias-disponibles' %}active{% endif %}\" href=\"{{ app_url }}bibliografias-disponibles\">
                            <i class=\"fas fa-book\"></i> Bibliografía Disponible
                        </a>
                    </li>
                    {% endif %}

                    <!-- REPORTES -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">REPORTES</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'coberturas' %}active{% endif %}\" href=\"{{ app_url }}reportes/coberturas\">
                            <i class=\"fas fa-chart-pie\"></i> Cobertura
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'listado-bibliografias' %}active{% endif %}\" href=\"{{ app_url }}reportes/listado-bibliografias\">
                            <i class=\"fas fa-list\"></i> Listado de Bibliografías
                        </a>
                    </li>


                    <!-- ADMINISTRACIÓN -->
                    {% if session.user_rol == 'admin' %}
                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">ADMINISTRACIÓN</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'sedes' %}active{% endif %}\" href=\"{{ app_url }}sedes\">
                            <i class=\"fas fa-building\"></i> Sedes
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'facultades' %}active{% endif %}\" href=\"{{ app_url }}facultades\">
                            <i class=\"fas fa-university\"></i> Facultades
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'departamentos' %}active{% endif %}\" href=\"{{ app_url }}departamentos\">
                            <i class=\"fas fa-sitemap\"></i> Departamentos
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'usuarios' %}active{% endif %}\" href=\"{{ app_url }}usuarios\">
                            <i class=\"fas fa-users\"></i> Usuarios
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'tareas_programadas' %}active{% endif %}\" href=\"{{ app_url }}tareas-programadas\">
                            <i class=\"fas fa-clock\"></i> Tareas Programadas
                        </a>
                    </li>
                    {% endif %}
                    {% if session.user_rol == 'admin' or session.user_rol == 'admin_bidoc' %}
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'autores' %}active{% endif %}\" href=\"{{ app_url }}autores\">
                            <i class=\"fas fa-user-edit\"></i> Autores
                        </a>
                    </li>
                    {% endif %}

                    <!-- Perfil y Cerrar Sesión -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link {% if current_page == 'perfil' %}active{% endif %}\" href=\"{{ app_url }}perfil\">
                            <i class=\"fas fa-user\"></i> Perfil
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"{{ app_url }}logout\">
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
                {% block content %}{% endblock %}
            </main>
        </div>
    </div>
    {% else %}
        {% block unauthenticated_content %}{% endblock %}
    {% endif %}

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
            console.log('DOM loaded, initializing sidebar toggle...');
            
            // Toggle del sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            console.log('Elements found:', {
                sidebarToggle: !!sidebarToggle,
                sidebar: !!sidebar,
                content: !!content
            });
            
            if (sidebarToggle && sidebar && content) {
                console.log('All elements found, adding event listener...');
                
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Toggle sidebar clicked');
                    
                    // Verificar estado actual
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    console.log('Current state - collapsed:', isCollapsed);
                    
                    // Toggle classes
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    
                    // Verificar estado después del toggle
                    const newCollapsed = sidebar.classList.contains('collapsed');
                    const newExpanded = content.classList.contains('expanded');
                    console.log('New state - collapsed:', newCollapsed, 'expanded:', newExpanded);
                    
                    // Toggle icon
                    const toggleIcon = sidebarToggle.querySelector('i');
                    if (toggleIcon) {
                        toggleIcon.classList.toggle('fa-chevron-left');
                        toggleIcon.classList.toggle('fa-chevron-right');
                        console.log('Icon toggled');
                    }
                });
                
                console.log('Event listener added successfully');
            } else {
                console.error('Some elements not found:', {
                    sidebarToggle: !!sidebarToggle,
                    sidebar: !!sidebar,
                    content: !!content
                });
            }

            // Verificar si la sesión está activa
            {% if not session.user_id %}
                // Si no hay sesión activa y no estamos en la página de login, redirigir
                if (!window.location.href.includes('login')) {
                    window.location.href = '{{ app_url }}login';
                }
            {% endif %}

            // Ocultar automáticamente los mensajes de alerta después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                    
                    // Limpiar las variables de sesión después de cerrar la alerta
                    fetch('{{ app_url }}clear-session-messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                }, 5000);
            });

            // Mostrar alertas de SweetAlert2 si existen
            {% if swal is defined and swal %}
                Swal.fire({
                    icon: '{{ swal.icon }}',
                    title: '{{ swal.title }}',
                    text: '{{ swal.text }}',
                    confirmButtonText: 'Aceptar'
                });
            {% endif %}
        });
    </script>

    {% block scripts %}
    <!-- Bootstrap Bundle with Popper -->
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"></script>

    <!-- DataTables -->
    <script src=\"https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js\"></script>
    <script src=\"https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js\"></script>
    <script src=\"https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js\"></script>

    <!-- SweetAlert2 -->
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    {% endblock %}

    <!-- SweetAlert2 Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            {% if session.swal %}
                Swal.fire({
                    icon: '{{ session.swal.icon }}',
                    title: '{{ session.swal.title }}',
                    text: '{{ session.swal.text }}',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#4e73df',
                    timer: null,
                    timerProgressBar: false,
                    allowOutsideClick: false
                });
            {% endif %}
        });

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
</html> ", "base.twig", "/var/www/html/biblioges/templates/base.twig");
    }
}
