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

/* frontend/index.twig */
class __TwigTemplate_803fc1d1cc8d2ce62a4ece97cbedd28e extends Template
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
        return "frontend/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Bibliografía UCN - Carreras de Pregrado";
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
        yield "<!-- Hero Section con Filtros -->
<section class=\"hero-section\">
    <div class=\"hero-background\"></div>
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3 text-white\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4 text-white\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university text-white\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
        
        <!-- Filtros de Sede -->
        <div class=\"row mt-5\">
            <div class=\"col-12\">
                <div class=\"filter-section\">
                    <div class=\"row align-items-center\">
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\">Sedes</label>
                            <select class=\"form-select sede-select\" id=\"sedeSelect\">
                                <option value=\"todas\">Todas</option>
                                ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 36
            yield "                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 36), "html", null, true);
            yield "\" ";
            if ((($context["sede_filtro"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 36))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 36), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        yield "                            </select>
                        </div>
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\">Carreras</label>
                            <input type=\"text\" class=\"form-control\" id=\"carreraSearch\" placeholder=\"¿Qué carrera buscas?\">
                        </div>
                        <div class=\"col-md-4 d-flex flex-column\">
                            <label class=\"form-label text-white fw-bold\">Acción</label>
                            <button class=\"btn btn-warning btn-lg w-100 mt-auto\" id=\"buscarBtn\">
                                <i class=\"fas fa-search me-2\"></i>Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Filtros por Áreas -->
<section class=\"container mb-4\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-4\">Explora las distintas áreas</h2>
            <div class=\"filter-tabs\">
                <div class=\"tab-buttons\">
                    <button class=\"tab-btn active\" data-sede=\"todas\">
                        TODAS
                    </button>
                    ";
        // line 67
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 68
            yield "                    <button class=\"tab-btn\" data-sede=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 68), "html", null, true);
            yield "\">
                        ";
            // line 69
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 69)), "html", null, true);
            yield "
                    </button>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 72
        yield "                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\" id=\"carrerasContainer\">
        ";
        // line 90
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["carreras"] ?? null)) > 0)) {
            // line 91
            yield "            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 92
                yield "            <div class=\"col-md-6 col-lg-4 mb-4 carrera-item\" 
                 data-sedes=\"";
                // line 93
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::join(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes_ids", [], "any", false, false, false, 93), ","), "html", null, true);
                yield "\"
                 data-nombre=\"";
                // line 94
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 94)), "html", null, true);
                yield "\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        ";
                // line 97
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 97)) {
                    // line 98
                    yield "                            <img src=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/biblioges/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "imagen_url", [], "any", false, false, false, 98), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 98), "html", null, true);
                    yield "\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                } else {
                    // line 100
                    yield "                            <img src=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["assets_url"] ?? null), "html", null, true);
                    yield "/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        ";
                }
                // line 102
                yield "                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">";
                // line 104
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 104), "html", null, true);
                yield "</h5>
                        <p class=\"card-text\">";
                // line 105
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", true, true, false, 105)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "descripcion", [], "any", false, false, false, 105), "Forma profesionales capaces de optimizar procesos productivos y de servicios.")) : ("Forma profesionales capaces de optimizar procesos productivos y de servicios.")), "html", null, true);
                yield "</p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>";
                // line 109
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", true, true, false, 109)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "cantidad_semestres", [], "any", false, false, false, 109), 10)) : (10)), "html", null, true);
                yield " semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>";
                // line 113
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::join(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes_nombres", [], "any", false, false, false, 113), ", "), "html", null, true);
                yield "</span>
                            </div>
                        </div>
                        ";
                // line 116
                if (CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 116)) {
                    // line 117
                    yield "                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "/carrera/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sede_id", [], "any", false, false, false, 117), "html", null, true);
                    yield "/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 117), "html", null, true);
                    yield "\" 
                           class=\"btn btn-primary btn-ver-bibliografia\"
                           data-carrera-id=\"";
                    // line 119
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 119), "html", null, true);
                    yield "\"
                           data-sedes=\"";
                    // line 120
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::join(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes_ids", [], "any", false, false, false, 120), ","), "html", null, true);
                    yield "\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        ";
                } else {
                    // line 125
                    yield "                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        ";
                }
                // line 130
                yield "                    </div>
                </div>
            </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 134
            yield "        ";
        } else {
            // line 135
            yield "            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        ";
        }
        // line 142
        yield "    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
";
        yield from [];
    }

    // line 183
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 184
        yield "<script>
// Función global para filtrar carreras
function filtrarCarreras() {
    console.log('=== EJECUTANDO FILTRO DE CARRERAS ===');
    
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    if (!sedeSelect || !carreraSearch) {
        console.error('Elementos de filtro no encontrados');
        return;
    }
    
    const sedeSeleccionada = sedeSelect.value;
    const busqueda = carreraSearch.value.toLowerCase().trim();
    
    console.log('Sede seleccionada:', sedeSeleccionada);
    console.log('Búsqueda:', busqueda);
    console.log('Total carreras:', carreraItems.length);
    
    let carrerasMostradas = 0;
    
    carreraItems.forEach((item, index) => {
        const sedesCarrera = item.getAttribute('data-sedes') || '';
        const nombreCarrera = item.getAttribute('data-nombre') || '';
        
        let mostrar = true;
        
        // Filtro por sede
        if (sedeSeleccionada !== 'todas') {
            const sedesArray = sedesCarrera.split(',').map(s => s.trim());
            if (!sedesArray.includes(sedeSeleccionada)) {
                mostrar = false;
            }
        }
        
        // Filtro por búsqueda
        if (busqueda && !nombreCarrera.includes(busqueda)) {
            mostrar = false;
        }
        
        if (mostrar) {
            item.style.display = 'block';
            item.classList.add('fade-in');
            carrerasMostradas++;
        } else {
            item.style.display = 'none';
            item.classList.remove('fade-in');
        }
    });
    
    console.log('Carreras mostradas:', carrerasMostradas);
    console.log('=== FILTRO COMPLETADO ===');
}

// Sincroniza la pestaña activa con el valor del select de sedes
function setActiveTab(sedeId) {
    const tabs = document.querySelectorAll('.tab-btn');
    if (!tabs || tabs.length === 0) return;
    tabs.forEach(btn => btn.classList.remove('active'));
    let target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === sedeId);
    if (!target) {
        target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === 'todas');
    }
    if (target) target.classList.add('active');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INICIANDO FILTROS DE CARRERAS ===');
    
    // Verificar elementos
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const buscarBtn = document.getElementById('buscarBtn');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    console.log('Elementos encontrados:');
    console.log('- sedeSelect:', sedeSelect ? 'OK' : 'NO ENCONTRADO');
    console.log('- carreraSearch:', carreraSearch ? 'OK' : 'NO ENCONTRADO');
    console.log('- buscarBtn:', buscarBtn ? 'OK' : 'NO ENCONTRADO');
    console.log('- tabButtons:', tabButtons.length);
    console.log('- carreraItems:', carreraItems.length);
    
    // Event listeners
    if (sedeSelect) {
        sedeSelect.addEventListener('change', function() {
            console.log('Cambio en sede select:', this.value);
            // Sincronizar pestañas
            setActiveTab(this.value);
            filtrarCarreras();
        });
    }
    
    if (carreraSearch) {
        carreraSearch.addEventListener('input', function() {
            console.log('Búsqueda:', this.value);
            filtrarCarreras();
        });
    }
    
    if (buscarBtn) {
        buscarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón buscar clickeado');
            filtrarCarreras();
        });
    }
    
    // Tabs de sedes
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Tab clickeado:', this.textContent.trim());
            
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Filtrar por sede
            const sedeId = this.getAttribute('data-sede');
            if (sedeSelect) {
                sedeSelect.value = sedeId;
            }
            filtrarCarreras();
        });
    });
    
    // Aplicar filtro inicial
    console.log('Aplicando filtro inicial...');
    // Sincronizar pestañas con el valor inicial del select
    if (sedeSelect) {
        setActiveTab(sedeSelect.value);
    }
    filtrarCarreras();
    
    console.log('=== FILTROS INICIALIZADOS ===');
    
    // Manejar clics en botones de \"Ver Bibliografía\"
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ver-bibliografia')) {
            e.preventDefault();
            
            const button = e.target.closest('.btn-ver-bibliografia');
            const carreraId = button.getAttribute('data-carrera-id');
            const sedesDisponibles = button.getAttribute('data-sedes').split(',');
            const sedeSeleccionada = sedeSelect.value;
            
            console.log('Carrera ID:', carreraId);
            console.log('Sedes disponibles:', sedesDisponibles);
            console.log('Sede seleccionada:', sedeSeleccionada);
            
            // Verificar si la sede seleccionada está disponible para esta carrera
            if (sedeSeleccionada === 'todas' || sedesDisponibles.includes(sedeSeleccionada)) {
                // Usar la sede seleccionada o la primera disponible
                const sedeParaUsar = sedeSeleccionada === 'todas' ? sedesDisponibles[0] : sedeSeleccionada;
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}`;
                console.log('Navegando a:', url);
                window.location.href = url;
            } else {
                // Si la sede seleccionada no está disponible, usar la primera sede disponible
                const sedeParaUsar = sedesDisponibles[0];
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}`;
                console.log('Sede seleccionada no disponible, usando:', sedeParaUsar);
                console.log('Navegando a:', url);
                window.location.href = url;
            }
        }
    });
});

// Función global para debug
window.debugFiltros = function() {
    console.log('=== DEBUG FILTROS ===');
    console.log('sedeSelect value:', document.getElementById('sedeSelect')?.value);
    console.log('carreraSearch value:', document.getElementById('carreraSearch')?.value);
    console.log('carreraItems:', document.querySelectorAll('.carrera-item').length);
    console.log('tabButtons:', document.querySelectorAll('.tab-btn').length);
    filtrarCarreras();
};
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/index.twig";
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
        return array (  359 => 184,  352 => 183,  308 => 142,  299 => 135,  296 => 134,  287 => 130,  280 => 125,  272 => 120,  268 => 119,  258 => 117,  256 => 116,  250 => 113,  243 => 109,  236 => 105,  232 => 104,  228 => 102,  222 => 100,  212 => 98,  210 => 97,  204 => 94,  200 => 93,  197 => 92,  192 => 91,  190 => 90,  170 => 72,  161 => 69,  156 => 68,  152 => 67,  121 => 38,  106 => 36,  102 => 35,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}Bibliografía UCN - Carreras de Pregrado{% endblock %}

{% block content %}
<!-- Hero Section con Filtros -->
<section class=\"hero-section\">
    <div class=\"hero-background\"></div>
    <div class=\"container\">
        <div class=\"row align-items-center\">
            <div class=\"col-lg-8\">
                <h1 class=\"display-4 fw-bold mb-3 text-white\">
                    <i class=\"fas fa-book-open me-3\"></i>
                    Bibliografía UCN
                </h1>
                <p class=\"lead mb-4 text-white\">
                    Consulta las bibliografías disponibles para las carreras de pregrado de la Universidad Católica del Norte.
                    Encuentra libros, artículos, tesis y otros recursos académicos organizados por programa.
                </p>
            </div>
            <div class=\"col-lg-4 text-center\">
                <i class=\"fas fa-university text-white\" style=\"font-size: 8rem; opacity: 0.8;\"></i>
            </div>
        </div>
        
        <!-- Filtros de Sede -->
        <div class=\"row mt-5\">
            <div class=\"col-12\">
                <div class=\"filter-section\">
                    <div class=\"row align-items-center\">
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\">Sedes</label>
                            <select class=\"form-select sede-select\" id=\"sedeSelect\">
                                <option value=\"todas\">Todas</option>
                                {% for sede in sedes %}
                                <option value=\"{{ sede.id }}\" {% if sede_filtro == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <div class=\"col-md-4\">
                            <label class=\"form-label text-white fw-bold\">Carreras</label>
                            <input type=\"text\" class=\"form-control\" id=\"carreraSearch\" placeholder=\"¿Qué carrera buscas?\">
                        </div>
                        <div class=\"col-md-4 d-flex flex-column\">
                            <label class=\"form-label text-white fw-bold\">Acción</label>
                            <button class=\"btn btn-warning btn-lg w-100 mt-auto\" id=\"buscarBtn\">
                                <i class=\"fas fa-search me-2\"></i>Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Filtros por Áreas -->
<section class=\"container mb-4\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"mb-4\">Explora las distintas áreas</h2>
            <div class=\"filter-tabs\">
                <div class=\"tab-buttons\">
                    <button class=\"tab-btn active\" data-sede=\"todas\">
                        TODAS
                    </button>
                    {% for sede in sedes %}
                    <button class=\"tab-btn\" data-sede=\"{{ sede.id }}\">
                        {{ sede.nombre|upper }}
                    </button>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Carreras -->
<section id=\"carreras\" class=\"container\">
    <div class=\"row\">
        <div class=\"col-12\">
            <h2 class=\"text-center mb-5\">
                <i class=\"fas fa-graduation-cap me-2\"></i>
                Carreras de Pregrado
            </h2>
        </div>
    </div>

    <div class=\"row\" id=\"carrerasContainer\">
        {% if carreras|length > 0 %}
            {% for carrera in carreras %}
            <div class=\"col-md-6 col-lg-4 mb-4 carrera-item\" 
                 data-sedes=\"{{ carrera.sedes_ids|join(',') }}\"
                 data-nombre=\"{{ carrera.nombre|lower }}\">
                <div class=\"card h-100 carrera-card\">
                    <div class=\"carrera-image\">
                        {% if carrera.imagen_url %}
                            <img src=\"{{ app_url }}/biblioges/{{ carrera.imagen_url }}\" alt=\"{{ carrera.nombre }}\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% else %}
                            <img src=\"{{ assets_url }}/images/carreras/default.svg\" alt=\"Imagen no disponible\" class=\"card-img-top\" style=\"object-fit:cover; width:100%; height:200px;\">
                        {% endif %}
                    </div>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{{ carrera.nombre }}</h5>
                        <p class=\"card-text\">{{ carrera.descripcion|default('Forma profesionales capaces de optimizar procesos productivos y de servicios.') }}</p>
                        <div class=\"carrera-meta\">
                            <div class=\"meta-item\">
                                <i class=\"fas fa-clock\"></i>
                                <span>{{ carrera.cantidad_semestres|default(10) }} semestres</span>
                            </div>
                            <div class=\"meta-item\">
                                <i class=\"fas fa-map-marker-alt\"></i>
                                <span>{{ carrera.sedes_nombres|join(', ') }}</span>
                            </div>
                        </div>
                        {% if carrera.sede_id %}
                        <a href=\"{{ app_url }}/carrera/{{ carrera.sede_id }}/{{ carrera.id }}\" 
                           class=\"btn btn-primary btn-ver-bibliografia\"
                           data-carrera-id=\"{{ carrera.id }}\"
                           data-sedes=\"{{ carrera.sedes_ids|join(',') }}\">
                            <i class=\"fas fa-book me-1\"></i>
                            Ver Bibliografía
                        </a>
                        {% else %}
                        <button class=\"btn btn-secondary btn-ver-bibliografia\" disabled>
                            <i class=\"fas fa-exclamation-triangle me-1\"></i>
                            No disponible
                        </button>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% endfor %}
        {% else %}
            <div class=\"col-12\">
                <div class=\"alert alert-info text-center\">
                    <i class=\"fas fa-info-circle me-2\"></i>
                    No hay carreras de pregrado disponibles en este momento.
                </div>
            </div>
        {% endif %}
    </div>
</section>

<!-- Información Adicional -->
<section class=\"container mb-5\">
    <div class=\"row\">
        <div class=\"col-lg-8 mx-auto\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h4 class=\"mb-0\">
                        <i class=\"fas fa-info-circle me-2\"></i>
                        Información del Sistema
                    </h4>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-book me-2 text-primary\"></i>Tipos de Bibliografía</h5>
                            <ul class=\"list-unstyled\">
                                <li><span class=\"badge badge-basica me-2\">Básica</span> Bibliografía fundamental del curso</li>
                                <li><span class=\"badge badge-complementaria me-2\">Complementaria</span> Bibliografía adicional recomendada</li>
                            </ul>
                        </div>
                        <div class=\"col-md-6\">
                            <h5><i class=\"fas fa-file-alt me-2 text-success\"></i>Tipos de Material</h5>
                            <ul class=\"list-unstyled\">
                                <li><i class=\"fas fa-book me-2\"></i>Libros</li>
                                <li><i class=\"fas fa-newspaper me-2\"></i>Artículos</li>
                                <li><i class=\"fas fa-file-pdf me-2\"></i>Tesis</li>
                                <li><i class=\"fas fa-laptop me-2\"></i>Software</li>
                                <li><i class=\"fas fa-globe me-2\"></i>Sitios Web</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{% endblock %}

{% block scripts %}
<script>
// Función global para filtrar carreras
function filtrarCarreras() {
    console.log('=== EJECUTANDO FILTRO DE CARRERAS ===');
    
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    if (!sedeSelect || !carreraSearch) {
        console.error('Elementos de filtro no encontrados');
        return;
    }
    
    const sedeSeleccionada = sedeSelect.value;
    const busqueda = carreraSearch.value.toLowerCase().trim();
    
    console.log('Sede seleccionada:', sedeSeleccionada);
    console.log('Búsqueda:', busqueda);
    console.log('Total carreras:', carreraItems.length);
    
    let carrerasMostradas = 0;
    
    carreraItems.forEach((item, index) => {
        const sedesCarrera = item.getAttribute('data-sedes') || '';
        const nombreCarrera = item.getAttribute('data-nombre') || '';
        
        let mostrar = true;
        
        // Filtro por sede
        if (sedeSeleccionada !== 'todas') {
            const sedesArray = sedesCarrera.split(',').map(s => s.trim());
            if (!sedesArray.includes(sedeSeleccionada)) {
                mostrar = false;
            }
        }
        
        // Filtro por búsqueda
        if (busqueda && !nombreCarrera.includes(busqueda)) {
            mostrar = false;
        }
        
        if (mostrar) {
            item.style.display = 'block';
            item.classList.add('fade-in');
            carrerasMostradas++;
        } else {
            item.style.display = 'none';
            item.classList.remove('fade-in');
        }
    });
    
    console.log('Carreras mostradas:', carrerasMostradas);
    console.log('=== FILTRO COMPLETADO ===');
}

// Sincroniza la pestaña activa con el valor del select de sedes
function setActiveTab(sedeId) {
    const tabs = document.querySelectorAll('.tab-btn');
    if (!tabs || tabs.length === 0) return;
    tabs.forEach(btn => btn.classList.remove('active'));
    let target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === sedeId);
    if (!target) {
        target = Array.from(tabs).find(btn => btn.getAttribute('data-sede') === 'todas');
    }
    if (target) target.classList.add('active');
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INICIANDO FILTROS DE CARRERAS ===');
    
    // Verificar elementos
    const sedeSelect = document.getElementById('sedeSelect');
    const carreraSearch = document.getElementById('carreraSearch');
    const buscarBtn = document.getElementById('buscarBtn');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const carreraItems = document.querySelectorAll('.carrera-item');
    
    console.log('Elementos encontrados:');
    console.log('- sedeSelect:', sedeSelect ? 'OK' : 'NO ENCONTRADO');
    console.log('- carreraSearch:', carreraSearch ? 'OK' : 'NO ENCONTRADO');
    console.log('- buscarBtn:', buscarBtn ? 'OK' : 'NO ENCONTRADO');
    console.log('- tabButtons:', tabButtons.length);
    console.log('- carreraItems:', carreraItems.length);
    
    // Event listeners
    if (sedeSelect) {
        sedeSelect.addEventListener('change', function() {
            console.log('Cambio en sede select:', this.value);
            // Sincronizar pestañas
            setActiveTab(this.value);
            filtrarCarreras();
        });
    }
    
    if (carreraSearch) {
        carreraSearch.addEventListener('input', function() {
            console.log('Búsqueda:', this.value);
            filtrarCarreras();
        });
    }
    
    if (buscarBtn) {
        buscarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Botón buscar clickeado');
            filtrarCarreras();
        });
    }
    
    // Tabs de sedes
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Tab clickeado:', this.textContent.trim());
            
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Filtrar por sede
            const sedeId = this.getAttribute('data-sede');
            if (sedeSelect) {
                sedeSelect.value = sedeId;
            }
            filtrarCarreras();
        });
    });
    
    // Aplicar filtro inicial
    console.log('Aplicando filtro inicial...');
    // Sincronizar pestañas con el valor inicial del select
    if (sedeSelect) {
        setActiveTab(sedeSelect.value);
    }
    filtrarCarreras();
    
    console.log('=== FILTROS INICIALIZADOS ===');
    
    // Manejar clics en botones de \"Ver Bibliografía\"
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-ver-bibliografia')) {
            e.preventDefault();
            
            const button = e.target.closest('.btn-ver-bibliografia');
            const carreraId = button.getAttribute('data-carrera-id');
            const sedesDisponibles = button.getAttribute('data-sedes').split(',');
            const sedeSeleccionada = sedeSelect.value;
            
            console.log('Carrera ID:', carreraId);
            console.log('Sedes disponibles:', sedesDisponibles);
            console.log('Sede seleccionada:', sedeSeleccionada);
            
            // Verificar si la sede seleccionada está disponible para esta carrera
            if (sedeSeleccionada === 'todas' || sedesDisponibles.includes(sedeSeleccionada)) {
                // Usar la sede seleccionada o la primera disponible
                const sedeParaUsar = sedeSeleccionada === 'todas' ? sedesDisponibles[0] : sedeSeleccionada;
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}`;
                console.log('Navegando a:', url);
                window.location.href = url;
            } else {
                // Si la sede seleccionada no está disponible, usar la primera sede disponible
                const sedeParaUsar = sedesDisponibles[0];
                const url = `\${window.location.origin}/carrera/\${sedeParaUsar}/\${carreraId}`;
                console.log('Sede seleccionada no disponible, usando:', sedeParaUsar);
                console.log('Navegando a:', url);
                window.location.href = url;
            }
        }
    });
});

// Función global para debug
window.debugFiltros = function() {
    console.log('=== DEBUG FILTROS ===');
    console.log('sedeSelect value:', document.getElementById('sedeSelect')?.value);
    console.log('carreraSearch value:', document.getElementById('carreraSearch')?.value);
    console.log('carreraItems:', document.querySelectorAll('.carrera-item').length);
    console.log('tabButtons:', document.querySelectorAll('.tab-btn').length);
    filtrarCarreras();
};
</script>
{% endblock %} ", "frontend/index.twig", "/var/www/html/biblioges/templates/frontend/index.twig");
    }
}
