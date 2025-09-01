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

/* asignaturas/vinculacion.twig */
class __TwigTemplate_25ec99e6ec2cd2a12f19c06933a092ad extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "asignaturas/vinculacion.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Vincular Asignaturas Electivas - Sistema de Bibliografía";
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
    /* Estilos personalizados para mejorar la visualización */
    .btn-group-vertical {
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        transition: all 0.3s ease;
        margin-top: 0;
        align-self: flex-start;
        margin-top: 0;
    }
    
    .btn-group-vertical.position-sticky {
        position: sticky;
        top: 20px;
        animation: fadeInSticky 0.3s ease-in-out;
    }
    
    .btn-group-vertical.position-sticky.active {
        position: fixed;
        top: 20px;
        right: 50%;
        transform: translateX(50%);
        z-index: 1050;
        animation: slideInFixed 0.4s ease-out;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    
    @keyframes slideInFixed {
        from {
            opacity: 0.9;
            transform: translateX(50%) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(50%) translateY(0);
        }
    }
    
    @keyframes fadeInSticky {
        from {
            opacity: 0.8;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .btn-group-vertical .btn {
        min-width: 50px;
        height: 45px;
        font-size: 16px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-group-vertical .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Mejorar espaciado entre paneles */
    .col-md-5 .card {
        margin-bottom: 0;
        height: 100%;
    }
    
    /* Asegurar márgenes consistentes en las tablas */
    .table-responsive {
        margin: 0;
        padding: 0;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
    }
    
    .table th:last-child,
    .table td:last-child {
        padding-right: 15px;
        word-wrap: break-word;
        max-width: 0;
    }
    
    .table th:first-child,
    .table td:first-child {
        padding-left: 15px;
    }
    
    /* Mejorar espaciado del panel central */
    .col-md-2 {
        padding: 0 10px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 0;
    }
    
    /* Asegurar que ambos paneles tengan la misma altura */
    .row {
        align-items: stretch;
    }
    
    /* Responsive para pantallas pequeñas */
    @media (max-width: 768px) {
        .btn-group-vertical.position-sticky {
            position: relative !important;
            top: auto !important;
            margin: 20px 0;
        }
        
        .col-md-2 {
            order: 3;
            margin-top: 20px;
        }
    }
</style>
";
        yield from [];
    }

    // line 136
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 137
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Vincular Asignaturas Electivas</h1>
        <a href=\"";
        // line 140
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 145
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 145)) {
            // line 146
            yield "    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        ";
            // line 147
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 147), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 151
        yield "
    ";
        // line 152
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 152)) {
            // line 153
            yield "    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        ";
            // line 154
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 154), "html", null, true);
            yield "
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    ";
        }
        // line 158
        yield "
    <!-- Selección de asignatura de formación -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Seleccionar Asignatura Electiva</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"formAsignaturaFormacion\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"asignatura_formacion\" class=\"form-label\">Asignatura Electiva</label>
                    <select class=\"form-select\" id=\"asignatura_formacion\" name=\"asignatura_formacion\" required>
                        <option value=\"\">Seleccione una asignatura</option>
                        ";
        // line 170
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_electivas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
            // line 171
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "id", [], "any", false, false, false, 171), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "nombre", [], "any", false, false, false, 171), "html", null, true);
            yield " (";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigos", [], "any", false, false, false, 171), "html", null, true);
            yield ")</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 173
        yield "                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura a Vincular</label>
                    <select class=\"form-select\" id=\"tipo_asignatura\" name=\"tipo_asignatura\" required>
                        <option value=\"\">Seleccione un tipo</option>
                        ";
        // line 179
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["tipos_asignaturas"] ?? null));
        foreach ($context['_seq'] as $context["tipo"] => $context["nombre"]) {
            // line 180
            yield "                            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tipo"], "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["nombre"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['tipo'], $context['nombre'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 182
        yield "                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de asignaturas -->
    <div class=\"row\" id=\"panelAsignaturas\" style=\"display: none;\">
        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Disponibles</h6>
                </div>
                <div class=\"card-body\">
                    <!-- Buscador para asignaturas disponibles -->
                    <div class=\"mb-3\">
                        <div class=\"input-group\">
                            <span class=\"input-group-text\">
                                <i class=\"fas fa-search\"></i>
                            </span>
                            <input type=\"text\" class=\"form-control\" id=\"buscarDisponibles\" 
                                   placeholder=\"Buscar por nombre o código...\" 
                                   autocomplete=\"off\">
                        </div>
                        <small class=\"text-muted\">
                            La búsqueda ignora mayúsculas, acentos y caracteres especiales. 
                            Puede buscar por nombre o código de asignatura.
                        </small>
                    </div>
                    
                    <div class=\"table-responsive\">
                        <div class=\"mb-2\">
                            <small class=\"text-muted\" id=\"contadorDisponibles\">
                                Mostrando todas las asignaturas disponibles
                            </small>
                        </div>
                        <table class=\"table table-bordered\" id=\"tablaNoVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllNoVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-2 d-flex align-items-center justify-content-center\">
            <div class=\"btn-group-vertical\" id=\"actionButtons\">
                <div class=\"text-center mb-2\">
                    <small class=\"text-muted d-block\">Acciones</small>
                </div>
                <button type=\"button\" class=\"btn btn-primary mb-2\" id=\"btnVincular\" 
                        title=\"Vincular asignaturas seleccionadas\">
                    <i class=\"fas fa-chevron-right\"></i>
                </button>
                <button type=\"button\" class=\"btn btn-danger\" id=\"btnQuitar\" 
                        title=\"Desvincular asignaturas seleccionadas\">
                    <i class=\"fas fa-chevron-left\"></i>
                </button>
                <div class=\"text-center mt-2\">
                    <small class=\"text-muted d-block\">Los botones se mantienen visibles</small>
                </div>
            </div>
        </div>

        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
                </div>
                <div class=\"card-body\">
                    <!-- Buscador para asignaturas vinculadas -->
                    <div class=\"mb-3\">
                        <div class=\"input-group\">
                            <span class=\"input-group-text\">
                                <i class=\"fas fa-search\"></i>
                            </span>
                            <input type=\"text\" class=\"form-control\" id=\"buscarVinculadas\" 
                                   placeholder=\"Buscar por nombre o código...\" 
                                   autocomplete=\"off\">
                        </div>
                        <small class=\"text-muted\">
                            La búsqueda ignora mayúsculas, acentos y caracteres especiales. 
                            Puede buscar por nombre o código de asignatura.
                        </small>
                    </div>
                    
                    <div class=\"table-responsive\">
                        <div class=\"mb-2\">
                            <small class=\"text-muted\" id=\"contadorVinculadas\">
                                Mostrando todas las asignaturas vinculadas
                            </small>
                        </div>
                        <table class=\"table table-bordered\" id=\"tablaVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
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

    // line 304
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 305
        yield "<script>
document.addEventListener('DOMContentLoaded', function() {
    const asignaturaFormacion = document.getElementById('asignatura_formacion');
    const tipoAsignatura = document.getElementById('tipo_asignatura');
    const panelAsignaturas = document.getElementById('panelAsignaturas');
    const tablaNoVinculadas = document.getElementById('tablaNoVinculadas').getElementsByTagName('tbody')[0];
    const tablaVinculadas = document.getElementById('tablaVinculadas').getElementsByTagName('tbody')[0];
    const selectAllNoVinculadas = document.getElementById('selectAllNoVinculadas');
    const selectAllVinculadas = document.getElementById('selectAllVinculadas');
    const btnVincular = document.getElementById('btnVincular');
    const btnQuitar = document.getElementById('btnQuitar');
    const buscarDisponibles = document.getElementById('buscarDisponibles');
    const buscarVinculadas = document.getElementById('buscarVinculadas');

    // Variables globales para almacenar las listas completas
    let asignaturasDisponibles = [];
    let asignaturasVinculadas = [];
    let asignaturasDisponiblesFiltradas = [];
    let asignaturasVinculadasFiltradas = [];

    // Función para cargar asignaturas cuando se seleccione tanto la asignatura electiva como el tipo
    function cargarAsignaturasSegunSeleccion() {
        const asignaturaId = asignaturaFormacion.value;
        const tipo = tipoAsignatura.value;
        
        if (asignaturaId && tipo) {
            panelAsignaturas.style.display = 'flex';
            cargarAsignaturas(asignaturaId, tipo);
            // Inicializar la posición de los botones cuando se muestran los paneles
            setTimeout(() => {
                inicializarBotonesAccion();
            }, 200);
        } else {
            panelAsignaturas.style.display = 'none';
        }
    }

    // Event listeners para los selectores
    asignaturaFormacion.addEventListener('change', cargarAsignaturasSegunSeleccion);
    tipoAsignatura.addEventListener('change', cargarAsignaturasSegunSeleccion);

    // Event listener para el botón de vincular
    btnVincular.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        vincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listener para el botón de quitar
    btnQuitar.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        desvincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listeners para seleccionar/deseleccionar todo
    selectAllNoVinculadas.addEventListener('change', function() {
        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    selectAllVinculadas.addEventListener('change', function() {
        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Event listeners para los campos de búsqueda
    buscarDisponibles.addEventListener('input', function() {
        filtrarAsignaturasDisponibles();
    });

    buscarVinculadas.addEventListener('input', function() {
        filtrarAsignaturasVinculadas();
    });

    // Función para hacer scroll suave a los botones de acción
    function scrollToActionButtons() {
        const actionButtons = document.querySelector('.btn-group-vertical');
        if (actionButtons) {
            actionButtons.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    // Función para inicializar la posición de los botones
    function inicializarBotonesAccion() {
        const actionButtons = document.getElementById('actionButtons');
        
        if (actionButtons) {
            // Los botones aparecen en la parte superior inicialmente
            actionButtons.style.position = 'relative';
            actionButtons.style.top = '0';
            actionButtons.classList.remove('position-sticky', 'active');
            
            // Activar el comportamiento sticky después de un delay
            setTimeout(() => {
                actionButtons.classList.add('position-sticky');
            }, 500);
        }
    }

    // Función para resetear la posición de los botones
    function resetearBotonesAccion() {
        const actionButtons = document.getElementById('actionButtons');
        if (actionButtons) {
            actionButtons.classList.remove('position-sticky', 'active');
            actionButtons.style.position = 'relative';
            actionButtons.style.top = '0';
        }
    }

    // Función para hacer scroll suave a los botones
    function scrollToActionButtons() {
        const actionButtons = document.getElementById('actionButtons');
        if (actionButtons) {
            actionButtons.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    // Event listener para mantener los botones visibles durante el scroll
    window.addEventListener('scroll', function() {
        const actionButtons = document.getElementById('actionButtons');
        if (!actionButtons || !actionButtons.classList.contains('position-sticky')) {
            return;
        }
        
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const panelTop = document.getElementById('panelAsignaturas').offsetTop;
        const panelHeight = document.getElementById('panelAsignaturas').offsetHeight;
        
        // Si el scroll está dentro del área de los paneles, mantener sticky
        if (scrollTop >= panelTop - 100 && scrollTop <= panelTop + panelHeight) {
            actionButtons.classList.remove('active');
        } else if (scrollTop > panelTop + panelHeight) {
            // Si el scroll está más allá de los paneles, activar modo fijo
            actionButtons.classList.add('active');
        } else {
            // Si el scroll está antes de los paneles, mantener sticky normal
            actionButtons.classList.remove('active');
        }
    });

    function cargarAsignaturas(asignaturaFormacionId, tipo) {
        fetch(`";
        // line 475
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}?tipo=\${tipo}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Almacenar las listas completas
                    asignaturasDisponibles = data.no_vinculadas;
                    asignaturasVinculadas = data.vinculadas;
                    asignaturasDisponiblesFiltradas = [...asignaturasDisponibles];
                    asignaturasVinculadasFiltradas = [...asignaturasVinculadas];
                    
                    limpiarTablas();
                    llenarTablaNoVinculadas(asignaturasDisponiblesFiltradas);
                    llenarTablaVinculadas(asignaturasVinculadasFiltradas);
                    
                    // Limpiar los campos de búsqueda
                    buscarDisponibles.value = '';
                    buscarVinculadas.value = '';
                    
                    // Inicializar contadores
                    mostrarContadorResultados('disponibles', asignaturasDisponiblesFiltradas.length, asignaturasDisponibles.length);
                    mostrarContadorResultados('vinculadas', asignaturasVinculadasFiltradas.length, asignaturasVinculadas.length);
                } else {
                    alert(data.message || 'Error al cargar las asignaturas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas');
            });
    }

    // Función para normalizar términos de búsqueda (ignora acentos, mayúsculas, etc.)
    function normalizarBusqueda(termino) {
        return termino.toLowerCase()
            .normalize('NFD')
            .replace(/[\\u0300-\\u036f]/g, '') // Remover acentos
            .replace(/[^a-z0-9\\s]/g, ' ') // Remover caracteres especiales
            .replace(/\\s+/g, ' ') // Normalizar espacios
            .trim();
    }

    // Función para filtrar asignaturas disponibles
    function filtrarAsignaturasDisponibles() {
        const termino = buscarDisponibles.value.trim();
        
        if (!termino) {
            asignaturasDisponiblesFiltradas = [...asignaturasDisponibles];
            // Limpiar selección cuando se resetea la búsqueda
            selectAllNoVinculadas.checked = false;
        } else {
            const terminoNormalizado = normalizarBusqueda(termino);
            asignaturasDisponiblesFiltradas = asignaturasDisponibles.filter(asignatura => {
                // Buscar en nombre
                const nombreNormalizado = normalizarBusqueda(asignatura.nombre);
                if (nombreNormalizado.includes(terminoNormalizado)) {
                    return true;
                }
                
                // Buscar en códigos
                if (asignatura.codigos && asignatura.codigos.length > 0) {
                    return asignatura.codigos.some(codigo => {
                        const codigoNormalizado = normalizarBusqueda(codigo);
                        return codigoNormalizado.includes(terminoNormalizado);
                    });
                }
                
                return false;
            });
        }
        
        // Actualizar la tabla
        limpiarTablaNoVinculadas();
        llenarTablaNoVinculadas(asignaturasDisponiblesFiltradas);
        
        // Mostrar contador de resultados
        mostrarContadorResultados('disponibles', asignaturasDisponiblesFiltradas.length, asignaturasDisponibles.length);
    }

    // Función para filtrar asignaturas vinculadas
    function filtrarAsignaturasVinculadas() {
        const termino = buscarVinculadas.value.trim();
        
        if (!termino) {
            asignaturasVinculadasFiltradas = [...asignaturasVinculadas];
            // Limpiar selección cuando se resetea la búsqueda
            selectAllVinculadas.checked = false;
        } else {
            const terminoNormalizado = normalizarBusqueda(termino);
            asignaturasVinculadasFiltradas = asignaturasVinculadas.filter(asignatura => {
                // Buscar en nombre
                const nombreNormalizado = normalizarBusqueda(asignatura.nombre);
                if (nombreNormalizado.includes(terminoNormalizado)) {
                    return true;
                }
                
                // Buscar en códigos
                if (asignatura.codigos && asignatura.codigos.length > 0) {
                    return asignatura.codigos.some(codigo => {
                        const codigoNormalizado = normalizarBusqueda(codigo);
                        return codigoNormalizado.includes(terminoNormalizado);
                    });
                }
                
                return false;
            });
        }
        
        // Actualizar la tabla
        limpiarTablaVinculadas();
        llenarTablaVinculadas(asignaturasVinculadasFiltradas);
        
        // Mostrar contador de resultados
        mostrarContadorResultados('vinculadas', asignaturasVinculadasFiltradas.length, asignaturasVinculadas.length);
    }

    function vincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`";
        // line 591
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}/agregar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al vincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al vincular las asignaturas');
        });
    }

    function desvincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`";
        // line 614
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "asignaturas/vinculacion/\${asignaturaFormacionId}/quitar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al desvincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desvincular las asignaturas');
        });
    }

    function llenarTablaNoVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaNoVinculadas.insertRow();
            
            // Crear el texto de códigos si existen
            let codigosTexto = '';
            if (asignatura.codigos && asignatura.codigos.length > 0) {
                codigosTexto = asignatura.codigos.join(', ') + ' - ';
            }
            
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${codigosTexto}\${asignatura.nombre}</td>
            `;
        });
    }

    function llenarTablaVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaVinculadas.insertRow();
            
            // Crear el texto de códigos si existen
            let codigosTexto = '';
            if (asignatura.codigos && asignatura.codigos.length > 0) {
                codigosTexto = asignatura.codigos.join(', ') + ' - ';
            }
            
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${codigosTexto}\${asignatura.nombre}</td>
            `;
        });
    }

    function limpiarTablas() {
        tablaNoVinculadas.innerHTML = '';
        tablaVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
        selectAllVinculadas.checked = false;
    }

    function limpiarTablaNoVinculadas() {
        tablaNoVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
    }

    function limpiarTablaVinculadas() {
        tablaVinculadas.innerHTML = '';
        selectAllVinculadas.checked = false;
    }

    // Función para mostrar contador de resultados de búsqueda
    function mostrarContadorResultados(tipo, encontradas, total) {
        const elemento = document.getElementById(`contador\${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
        
        if (encontradas === total) {
            elemento.textContent = `Mostrando todas las asignaturas \${tipo}`;
        } else {
            elemento.textContent = `Mostrando \${encontradas} de \${total} asignaturas \${tipo}`;
        }
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
        return "asignaturas/vinculacion.twig";
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
        return array (  755 => 614,  729 => 591,  610 => 475,  438 => 305,  431 => 304,  306 => 182,  295 => 180,  291 => 179,  283 => 173,  270 => 171,  266 => 170,  252 => 158,  245 => 154,  242 => 153,  240 => 152,  237 => 151,  230 => 147,  227 => 146,  225 => 145,  217 => 140,  212 => 137,  205 => 136,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Vincular Asignaturas Electivas - Sistema de Bibliografía{% endblock %}

{% block styles %}
<style>
    /* Estilos personalizados para mejorar la visualización */
    .btn-group-vertical {
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        transition: all 0.3s ease;
        margin-top: 0;
        align-self: flex-start;
        margin-top: 0;
    }
    
    .btn-group-vertical.position-sticky {
        position: sticky;
        top: 20px;
        animation: fadeInSticky 0.3s ease-in-out;
    }
    
    .btn-group-vertical.position-sticky.active {
        position: fixed;
        top: 20px;
        right: 50%;
        transform: translateX(50%);
        z-index: 1050;
        animation: slideInFixed 0.4s ease-out;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    
    @keyframes slideInFixed {
        from {
            opacity: 0.9;
            transform: translateX(50%) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(50%) translateY(0);
        }
    }
    
    @keyframes fadeInSticky {
        from {
            opacity: 0.8;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .btn-group-vertical .btn {
        min-width: 50px;
        height: 45px;
        font-size: 16px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-group-vertical .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Mejorar espaciado entre paneles */
    .col-md-5 .card {
        margin-bottom: 0;
        height: 100%;
    }
    
    /* Asegurar márgenes consistentes en las tablas */
    .table-responsive {
        margin: 0;
        padding: 0;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
    }
    
    .table th:last-child,
    .table td:last-child {
        padding-right: 15px;
        word-wrap: break-word;
        max-width: 0;
    }
    
    .table th:first-child,
    .table td:first-child {
        padding-left: 15px;
    }
    
    /* Mejorar espaciado del panel central */
    .col-md-2 {
        padding: 0 10px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 0;
    }
    
    /* Asegurar que ambos paneles tengan la misma altura */
    .row {
        align-items: stretch;
    }
    
    /* Responsive para pantallas pequeñas */
    @media (max-width: 768px) {
        .btn-group-vertical.position-sticky {
            position: relative !important;
            top: auto !important;
            margin: 20px 0;
        }
        
        .col-md-2 {
            order: 3;
            margin-top: 20px;
        }
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Vincular Asignaturas Electivas</h1>
        <a href=\"{{ app_url }}asignaturas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if session.success %}
    <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        {{ session.success }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    {% if session.error %}
    <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        {{ session.error }}
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
    {% endif %}

    <!-- Selección de asignatura de formación -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Seleccionar Asignatura Electiva</h6>
        </div>
        <div class=\"card-body\">
            <form id=\"formAsignaturaFormacion\" class=\"row g-3\">
                <div class=\"col-md-6\">
                    <label for=\"asignatura_formacion\" class=\"form-label\">Asignatura Electiva</label>
                    <select class=\"form-select\" id=\"asignatura_formacion\" name=\"asignatura_formacion\" required>
                        <option value=\"\">Seleccione una asignatura</option>
                        {% for asignatura in asignaturas_electivas %}
                            <option value=\"{{ asignatura.id }}\">{{ asignatura.nombre }} ({{ asignatura.codigos }})</option>
                        {% endfor %}
                    </select>
                </div>
                <div class=\"col-md-6\">
                    <label for=\"tipo_asignatura\" class=\"form-label\">Tipo de Asignatura a Vincular</label>
                    <select class=\"form-select\" id=\"tipo_asignatura\" name=\"tipo_asignatura\" required>
                        <option value=\"\">Seleccione un tipo</option>
                        {% for tipo, nombre in tipos_asignaturas %}
                            <option value=\"{{ tipo }}\">{{ nombre }}</option>
                        {% endfor %}
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Paneles de asignaturas -->
    <div class=\"row\" id=\"panelAsignaturas\" style=\"display: none;\">
        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Disponibles</h6>
                </div>
                <div class=\"card-body\">
                    <!-- Buscador para asignaturas disponibles -->
                    <div class=\"mb-3\">
                        <div class=\"input-group\">
                            <span class=\"input-group-text\">
                                <i class=\"fas fa-search\"></i>
                            </span>
                            <input type=\"text\" class=\"form-control\" id=\"buscarDisponibles\" 
                                   placeholder=\"Buscar por nombre o código...\" 
                                   autocomplete=\"off\">
                        </div>
                        <small class=\"text-muted\">
                            La búsqueda ignora mayúsculas, acentos y caracteres especiales. 
                            Puede buscar por nombre o código de asignatura.
                        </small>
                    </div>
                    
                    <div class=\"table-responsive\">
                        <div class=\"mb-2\">
                            <small class=\"text-muted\" id=\"contadorDisponibles\">
                                Mostrando todas las asignaturas disponibles
                            </small>
                        </div>
                        <table class=\"table table-bordered\" id=\"tablaNoVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllNoVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"col-md-2 d-flex align-items-center justify-content-center\">
            <div class=\"btn-group-vertical\" id=\"actionButtons\">
                <div class=\"text-center mb-2\">
                    <small class=\"text-muted d-block\">Acciones</small>
                </div>
                <button type=\"button\" class=\"btn btn-primary mb-2\" id=\"btnVincular\" 
                        title=\"Vincular asignaturas seleccionadas\">
                    <i class=\"fas fa-chevron-right\"></i>
                </button>
                <button type=\"button\" class=\"btn btn-danger\" id=\"btnQuitar\" 
                        title=\"Desvincular asignaturas seleccionadas\">
                    <i class=\"fas fa-chevron-left\"></i>
                </button>
                <div class=\"text-center mt-2\">
                    <small class=\"text-muted d-block\">Los botones se mantienen visibles</small>
                </div>
            </div>
        </div>

        <div class=\"col-md-5\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-primary\">Asignaturas Vinculadas</h6>
                </div>
                <div class=\"card-body\">
                    <!-- Buscador para asignaturas vinculadas -->
                    <div class=\"mb-3\">
                        <div class=\"input-group\">
                            <span class=\"input-group-text\">
                                <i class=\"fas fa-search\"></i>
                            </span>
                            <input type=\"text\" class=\"form-control\" id=\"buscarVinculadas\" 
                                   placeholder=\"Buscar por nombre o código...\" 
                                   autocomplete=\"off\">
                        </div>
                        <small class=\"text-muted\">
                            La búsqueda ignora mayúsculas, acentos y caracteres especiales. 
                            Puede buscar por nombre o código de asignatura.
                        </small>
                    </div>
                    
                    <div class=\"table-responsive\">
                        <div class=\"mb-2\">
                            <small class=\"text-muted\" id=\"contadorVinculadas\">
                                Mostrando todas las asignaturas vinculadas
                            </small>
                        </div>
                        <table class=\"table table-bordered\" id=\"tablaVinculadas\">
                            <thead>
                                <tr>
                                    <th width=\"50\">
                                        <input type=\"checkbox\" id=\"selectAllVinculadas\">
                                    </th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const asignaturaFormacion = document.getElementById('asignatura_formacion');
    const tipoAsignatura = document.getElementById('tipo_asignatura');
    const panelAsignaturas = document.getElementById('panelAsignaturas');
    const tablaNoVinculadas = document.getElementById('tablaNoVinculadas').getElementsByTagName('tbody')[0];
    const tablaVinculadas = document.getElementById('tablaVinculadas').getElementsByTagName('tbody')[0];
    const selectAllNoVinculadas = document.getElementById('selectAllNoVinculadas');
    const selectAllVinculadas = document.getElementById('selectAllVinculadas');
    const btnVincular = document.getElementById('btnVincular');
    const btnQuitar = document.getElementById('btnQuitar');
    const buscarDisponibles = document.getElementById('buscarDisponibles');
    const buscarVinculadas = document.getElementById('buscarVinculadas');

    // Variables globales para almacenar las listas completas
    let asignaturasDisponibles = [];
    let asignaturasVinculadas = [];
    let asignaturasDisponiblesFiltradas = [];
    let asignaturasVinculadasFiltradas = [];

    // Función para cargar asignaturas cuando se seleccione tanto la asignatura electiva como el tipo
    function cargarAsignaturasSegunSeleccion() {
        const asignaturaId = asignaturaFormacion.value;
        const tipo = tipoAsignatura.value;
        
        if (asignaturaId && tipo) {
            panelAsignaturas.style.display = 'flex';
            cargarAsignaturas(asignaturaId, tipo);
            // Inicializar la posición de los botones cuando se muestran los paneles
            setTimeout(() => {
                inicializarBotonesAccion();
            }, 200);
        } else {
            panelAsignaturas.style.display = 'none';
        }
    }

    // Event listeners para los selectores
    asignaturaFormacion.addEventListener('change', cargarAsignaturasSegunSeleccion);
    tipoAsignatura.addEventListener('change', cargarAsignaturasSegunSeleccion);

    // Event listener para el botón de vincular
    btnVincular.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        vincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listener para el botón de quitar
    btnQuitar.addEventListener('click', function() {
        const asignaturaFormacionId = asignaturaFormacion.value;
        if (!asignaturaFormacionId) {
            alert('Por favor seleccione una asignatura electiva');
            return;
        }

        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos una asignatura');
            return;
        }

        const asignaturasIds = Array.from(checkboxes).map(cb => cb.value);
        desvincularAsignaturas(asignaturaFormacionId, asignaturasIds);
    });

    // Event listeners para seleccionar/deseleccionar todo
    selectAllNoVinculadas.addEventListener('change', function() {
        const checkboxes = tablaNoVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    selectAllVinculadas.addEventListener('change', function() {
        const checkboxes = tablaVinculadas.querySelectorAll('input[type=\"checkbox\"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Event listeners para los campos de búsqueda
    buscarDisponibles.addEventListener('input', function() {
        filtrarAsignaturasDisponibles();
    });

    buscarVinculadas.addEventListener('input', function() {
        filtrarAsignaturasVinculadas();
    });

    // Función para hacer scroll suave a los botones de acción
    function scrollToActionButtons() {
        const actionButtons = document.querySelector('.btn-group-vertical');
        if (actionButtons) {
            actionButtons.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    // Función para inicializar la posición de los botones
    function inicializarBotonesAccion() {
        const actionButtons = document.getElementById('actionButtons');
        
        if (actionButtons) {
            // Los botones aparecen en la parte superior inicialmente
            actionButtons.style.position = 'relative';
            actionButtons.style.top = '0';
            actionButtons.classList.remove('position-sticky', 'active');
            
            // Activar el comportamiento sticky después de un delay
            setTimeout(() => {
                actionButtons.classList.add('position-sticky');
            }, 500);
        }
    }

    // Función para resetear la posición de los botones
    function resetearBotonesAccion() {
        const actionButtons = document.getElementById('actionButtons');
        if (actionButtons) {
            actionButtons.classList.remove('position-sticky', 'active');
            actionButtons.style.position = 'relative';
            actionButtons.style.top = '0';
        }
    }

    // Función para hacer scroll suave a los botones
    function scrollToActionButtons() {
        const actionButtons = document.getElementById('actionButtons');
        if (actionButtons) {
            actionButtons.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    // Event listener para mantener los botones visibles durante el scroll
    window.addEventListener('scroll', function() {
        const actionButtons = document.getElementById('actionButtons');
        if (!actionButtons || !actionButtons.classList.contains('position-sticky')) {
            return;
        }
        
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const panelTop = document.getElementById('panelAsignaturas').offsetTop;
        const panelHeight = document.getElementById('panelAsignaturas').offsetHeight;
        
        // Si el scroll está dentro del área de los paneles, mantener sticky
        if (scrollTop >= panelTop - 100 && scrollTop <= panelTop + panelHeight) {
            actionButtons.classList.remove('active');
        } else if (scrollTop > panelTop + panelHeight) {
            // Si el scroll está más allá de los paneles, activar modo fijo
            actionButtons.classList.add('active');
        } else {
            // Si el scroll está antes de los paneles, mantener sticky normal
            actionButtons.classList.remove('active');
        }
    });

    function cargarAsignaturas(asignaturaFormacionId, tipo) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}?tipo=\${tipo}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Almacenar las listas completas
                    asignaturasDisponibles = data.no_vinculadas;
                    asignaturasVinculadas = data.vinculadas;
                    asignaturasDisponiblesFiltradas = [...asignaturasDisponibles];
                    asignaturasVinculadasFiltradas = [...asignaturasVinculadas];
                    
                    limpiarTablas();
                    llenarTablaNoVinculadas(asignaturasDisponiblesFiltradas);
                    llenarTablaVinculadas(asignaturasVinculadasFiltradas);
                    
                    // Limpiar los campos de búsqueda
                    buscarDisponibles.value = '';
                    buscarVinculadas.value = '';
                    
                    // Inicializar contadores
                    mostrarContadorResultados('disponibles', asignaturasDisponiblesFiltradas.length, asignaturasDisponibles.length);
                    mostrarContadorResultados('vinculadas', asignaturasVinculadasFiltradas.length, asignaturasVinculadas.length);
                } else {
                    alert(data.message || 'Error al cargar las asignaturas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas');
            });
    }

    // Función para normalizar términos de búsqueda (ignora acentos, mayúsculas, etc.)
    function normalizarBusqueda(termino) {
        return termino.toLowerCase()
            .normalize('NFD')
            .replace(/[\\u0300-\\u036f]/g, '') // Remover acentos
            .replace(/[^a-z0-9\\s]/g, ' ') // Remover caracteres especiales
            .replace(/\\s+/g, ' ') // Normalizar espacios
            .trim();
    }

    // Función para filtrar asignaturas disponibles
    function filtrarAsignaturasDisponibles() {
        const termino = buscarDisponibles.value.trim();
        
        if (!termino) {
            asignaturasDisponiblesFiltradas = [...asignaturasDisponibles];
            // Limpiar selección cuando se resetea la búsqueda
            selectAllNoVinculadas.checked = false;
        } else {
            const terminoNormalizado = normalizarBusqueda(termino);
            asignaturasDisponiblesFiltradas = asignaturasDisponibles.filter(asignatura => {
                // Buscar en nombre
                const nombreNormalizado = normalizarBusqueda(asignatura.nombre);
                if (nombreNormalizado.includes(terminoNormalizado)) {
                    return true;
                }
                
                // Buscar en códigos
                if (asignatura.codigos && asignatura.codigos.length > 0) {
                    return asignatura.codigos.some(codigo => {
                        const codigoNormalizado = normalizarBusqueda(codigo);
                        return codigoNormalizado.includes(terminoNormalizado);
                    });
                }
                
                return false;
            });
        }
        
        // Actualizar la tabla
        limpiarTablaNoVinculadas();
        llenarTablaNoVinculadas(asignaturasDisponiblesFiltradas);
        
        // Mostrar contador de resultados
        mostrarContadorResultados('disponibles', asignaturasDisponiblesFiltradas.length, asignaturasDisponibles.length);
    }

    // Función para filtrar asignaturas vinculadas
    function filtrarAsignaturasVinculadas() {
        const termino = buscarVinculadas.value.trim();
        
        if (!termino) {
            asignaturasVinculadasFiltradas = [...asignaturasVinculadas];
            // Limpiar selección cuando se resetea la búsqueda
            selectAllVinculadas.checked = false;
        } else {
            const terminoNormalizado = normalizarBusqueda(termino);
            asignaturasVinculadasFiltradas = asignaturasVinculadas.filter(asignatura => {
                // Buscar en nombre
                const nombreNormalizado = normalizarBusqueda(asignatura.nombre);
                if (nombreNormalizado.includes(terminoNormalizado)) {
                    return true;
                }
                
                // Buscar en códigos
                if (asignatura.codigos && asignatura.codigos.length > 0) {
                    return asignatura.codigos.some(codigo => {
                        const codigoNormalizado = normalizarBusqueda(codigo);
                        return codigoNormalizado.includes(terminoNormalizado);
                    });
                }
                
                return false;
            });
        }
        
        // Actualizar la tabla
        limpiarTablaVinculadas();
        llenarTablaVinculadas(asignaturasVinculadasFiltradas);
        
        // Mostrar contador de resultados
        mostrarContadorResultados('vinculadas', asignaturasVinculadasFiltradas.length, asignaturasVinculadas.length);
    }

    function vincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}/agregar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al vincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al vincular las asignaturas');
        });
    }

    function desvincularAsignaturas(asignaturaFormacionId, asignaturasIds) {
        fetch(`{{ app_url }}asignaturas/vinculacion/\${asignaturaFormacionId}/quitar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ asignaturas: asignaturasIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarAsignaturas(asignaturaFormacionId, tipoAsignatura.value);
            } else {
                alert(data.message || 'Error al desvincular las asignaturas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desvincular las asignaturas');
        });
    }

    function llenarTablaNoVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaNoVinculadas.insertRow();
            
            // Crear el texto de códigos si existen
            let codigosTexto = '';
            if (asignatura.codigos && asignatura.codigos.length > 0) {
                codigosTexto = asignatura.codigos.join(', ') + ' - ';
            }
            
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${codigosTexto}\${asignatura.nombre}</td>
            `;
        });
    }

    function llenarTablaVinculadas(asignaturas) {
        asignaturas.forEach(asignatura => {
            const row = tablaVinculadas.insertRow();
            
            // Crear el texto de códigos si existen
            let codigosTexto = '';
            if (asignatura.codigos && asignatura.codigos.length > 0) {
                codigosTexto = asignatura.codigos.join(', ') + ' - ';
            }
            
            row.innerHTML = `
                <td><input type=\"checkbox\" value=\"\${asignatura.id}\"></td>
                <td>\${codigosTexto}\${asignatura.nombre}</td>
            `;
        });
    }

    function limpiarTablas() {
        tablaNoVinculadas.innerHTML = '';
        tablaVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
        selectAllVinculadas.checked = false;
    }

    function limpiarTablaNoVinculadas() {
        tablaNoVinculadas.innerHTML = '';
        selectAllNoVinculadas.checked = false;
    }

    function limpiarTablaVinculadas() {
        tablaVinculadas.innerHTML = '';
        selectAllVinculadas.checked = false;
    }

    // Función para mostrar contador de resultados de búsqueda
    function mostrarContadorResultados(tipo, encontradas, total) {
        const elemento = document.getElementById(`contador\${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
        
        if (encontradas === total) {
            elemento.textContent = `Mostrando todas las asignaturas \${tipo}`;
        } else {
            elemento.textContent = `Mostrando \${encontradas} de \${total} asignaturas \${tipo}`;
        }
    }
});
</script>
{% endblock %} ", "asignaturas/vinculacion.twig", "/var/www/html/biblioges/templates/asignaturas/vinculacion.twig");
    }
}
