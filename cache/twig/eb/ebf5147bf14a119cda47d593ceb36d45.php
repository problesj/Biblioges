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
            'head' => [$this, 'block_head'],
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
    ";
        // line 26
        yield from $this->unwrap()->yieldBlock('head', $context, $blocks);
        // line 27
        yield "    <style>
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
        // line 184
        yield from $this->unwrap()->yieldBlock('styles', $context, $blocks);
        // line 185
        yield "</head>
<body>
";
        // line 187
        $context["current_page"] = ((        $this->unwrap()->hasBlock("current_page", $context, $blocks)) ? (        $this->unwrap()->renderBlock("current_page", $context, $blocks)) : (((array_key_exists("current_page", $context)) ? (Twig\Extension\CoreExtension::default(($context["current_page"] ?? null), "")) : (""))));
        // line 188
        yield "    ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 188)) {
            // line 189
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
            // line 201
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
            // line 205
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 205) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 205) == "admin_bidoc"))) {
                // line 206
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 207
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
                // line 212
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
                // line 217
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
            // line 222
            yield "                    ";
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 222) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 222) == "admin_bidoc"))) {
                // line 223
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 224
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
                // line 229
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
            // line 234
            yield "
                    <!-- REPORTES -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">REPORTES</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 239
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
            // line 244
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
            // line 251
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 251) == "admin")) {
                // line 252
                yield "                    <li class=\"menu-divider\"></li>
                    <li class=\"menu-group\">ADMINISTRACIÓN</li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 255
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
                // line 260
                if ((($context["current_page"] ?? null) == "unidades")) {
                    yield "active";
                }
                yield "\" href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "unidades\">
                            <i class=\"fas fa-sitemap\"></i> Unidades
                        </a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 265
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
                // line 270
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
            // line 275
            yield "                    ";
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 275) == "admin") || (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_rol", [], "any", false, false, false, 275) == "admin_bidoc"))) {
                // line 276
                yield "                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
                // line 277
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
            // line 282
            yield "
                    <!-- Perfil y Cerrar Sesión -->
                    <li class=\"menu-divider\"></li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link ";
            // line 286
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
            // line 291
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
            // line 308
            yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
            // line 309
            yield "            </main>
        </div>
    </div>
    ";
        } else {
            // line 313
            yield "        ";
            yield from $this->unwrap()->yieldBlock('unauthenticated_content', $context, $blocks);
            // line 314
            yield "    ";
        }
        // line 315
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
            // console.log('DOM loaded, initializing sidebar toggle...');
            
            // Toggle del sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            // console.log('Elements found:', {
            //     sidebarToggle: !!sidebarToggle,
            //     sidebar: !!sidebar,
            //     content: !!content
            // });
            
            if (sidebarToggle && sidebar && content) {
                // console.log('All elements found, adding event listener...');
                
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    // console.log('Toggle sidebar clicked');
                    
                    // Verificar estado actual
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    // console.log('Current state - collapsed:', isCollapsed);
                    
                    // Toggle classes
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    
                    // Verificar estado después del toggle
                    const newCollapsed = sidebar.classList.contains('collapsed');
                    const newExpanded = content.classList.contains('expanded');
                    // console.log('New state - collapsed:', newCollapsed, 'expanded:', newExpanded);
                    
                    // Toggle icon
                    const toggleIcon = sidebarToggle.querySelector('i');
                    if (toggleIcon) {
                        toggleIcon.classList.toggle('fa-chevron-left');
                        toggleIcon.classList.toggle('fa-chevron-right');
                        // console.log('Icon toggled');
                    }
                });
                
                // console.log('Event listener added successfully');
            } else {
                console.error('Some elements not found:', {
                    sidebarToggle: !!sidebarToggle,
                    sidebar: !!sidebar,
                    content: !!content
                });
            }

            // Verificar si la sesión está activa
            ";
        // line 386
        if ( !CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "user_id", [], "any", false, false, false, 386)) {
            // line 387
            yield "                // Si no hay sesión activa y no estamos en la página de login, redirigir
                if (!window.location.href.includes('login')) {
                    window.location.href = '";
            // line 389
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "login';
                }
            ";
        }
        // line 392
        yield "
            // Ocultar automáticamente los mensajes de alerta después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                    
                    // Limpiar las variables de sesión después de cerrar la alerta
                    fetch('";
        // line 401
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
        // line 412
        if ((array_key_exists("swal", $context) && ($context["swal"] ?? null))) {
            // line 413
            yield "                Swal.fire({
                    icon: '";
            // line 414
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "icon", [], "any", false, false, false, 414), "html", null, true);
            yield "',
                    title: '";
            // line 415
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "title", [], "any", false, false, false, 415), "html", null, true);
            yield "',
                    text: '";
            // line 416
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["swal"] ?? null), "text", [], "any", false, false, false, 416), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar'
                });
            ";
        }
        // line 420
        yield "        });
    </script>

    ";
        // line 423
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        // line 436
        yield "
    <!-- SweetAlert2 Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
        // line 440
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 440)) {
            // line 441
            yield "                Swal.fire({
                    icon: '";
            // line 442
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 442), "icon", [], "any", false, false, false, 442), "html", null, true);
            yield "',
                    title: '";
            // line 443
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 443), "title", [], "any", false, false, false, 443), "html", null, true);
            yield "',
                    text: '";
            // line 444
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "swal", [], "any", false, false, false, 444), "text", [], "any", false, false, false, 444), "html", null, true);
            yield "',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#4e73df',
                    timer: null,
                    timerProgressBar: false,
                    allowOutsideClick: false
                });
            ";
        }
        // line 452
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

    // line 26
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 184
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_styles(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 308
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 313
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_unauthenticated_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 423
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 424
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
        return array (  753 => 424,  746 => 423,  736 => 313,  726 => 308,  716 => 184,  706 => 26,  695 => 7,  674 => 452,  663 => 444,  659 => 443,  655 => 442,  652 => 441,  650 => 440,  644 => 436,  642 => 423,  637 => 420,  630 => 416,  626 => 415,  622 => 414,  619 => 413,  617 => 412,  603 => 401,  592 => 392,  586 => 389,  582 => 387,  580 => 386,  507 => 315,  504 => 314,  501 => 313,  495 => 309,  493 => 308,  473 => 291,  461 => 286,  455 => 282,  443 => 277,  440 => 276,  437 => 275,  425 => 270,  413 => 265,  401 => 260,  389 => 255,  384 => 252,  382 => 251,  368 => 244,  356 => 239,  349 => 234,  337 => 229,  325 => 224,  322 => 223,  319 => 222,  307 => 217,  295 => 212,  283 => 207,  280 => 206,  278 => 205,  267 => 201,  253 => 189,  250 => 188,  248 => 187,  244 => 185,  242 => 184,  83 => 27,  81 => 26,  62 => 10,  56 => 7,  48 => 1,);
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
    {% block head %}{% endblock %}
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
                        <a class=\"nav-link {% if current_page == 'unidades' %}active{% endif %}\" href=\"{{ app_url }}unidades\">
                            <i class=\"fas fa-sitemap\"></i> Unidades
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
            // console.log('DOM loaded, initializing sidebar toggle...');
            
            // Toggle del sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            
            // console.log('Elements found:', {
            //     sidebarToggle: !!sidebarToggle,
            //     sidebar: !!sidebar,
            //     content: !!content
            // });
            
            if (sidebarToggle && sidebar && content) {
                // console.log('All elements found, adding event listener...');
                
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    // console.log('Toggle sidebar clicked');
                    
                    // Verificar estado actual
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    // console.log('Current state - collapsed:', isCollapsed);
                    
                    // Toggle classes
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    
                    // Verificar estado después del toggle
                    const newCollapsed = sidebar.classList.contains('collapsed');
                    const newExpanded = content.classList.contains('expanded');
                    // console.log('New state - collapsed:', newCollapsed, 'expanded:', newExpanded);
                    
                    // Toggle icon
                    const toggleIcon = sidebarToggle.querySelector('i');
                    if (toggleIcon) {
                        toggleIcon.classList.toggle('fa-chevron-left');
                        toggleIcon.classList.toggle('fa-chevron-right');
                        // console.log('Icon toggled');
                    }
                });
                
                // console.log('Event listener added successfully');
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
