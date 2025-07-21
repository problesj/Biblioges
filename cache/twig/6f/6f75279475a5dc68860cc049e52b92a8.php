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

/* reportes/bibliografias_declaradas.twig */
class __TwigTemplate_acc31e2bd16defdc1d6e89c426afe274 extends Template
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
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.twig", "reportes/bibliografias_declaradas.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Reporte de Bibliografías Declaradas";
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
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            <i class=\"fas fa-book\"></i> Reporte de Bibliografías Declaradas
        </h1>
        <button type=\"button\" class=\"btn btn-success\" id=\"btnExportar\">
            <i class=\"fas fa-file-excel\"></i> Exportar Excel
        </button>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body p-0\">
            <form class=\"p-3\">
                            <!-- Fila de búsqueda general -->
                            <div class=\"row mb-3\">
                                <div class=\"col-12\">
                                    <div class=\"input-group\">
                                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" placeholder=\"Buscar...\" value=\"\">
                                        <select class=\"form-select\" id=\"tipo_busqueda\" style=\"max-width: 150px;\">
                                            <option value=\"todos\">Todos</option>
                                            <option value=\"titulo\">Título</option>
                                            <option value=\"autor\">Autor</option>
                                            <option value=\"editorial\">Editorial</option>
                                            <option value=\"asignatura\">Asignatura</option>
                                        </select>
                                        <button type=\"button\" class=\"btn btn-primary\" id=\"btnBuscar\">
                                            <i class=\"fas fa-search\"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Fila de filtros específicos -->
                            <div class=\"row g-3\">
                                <div class=\"col-md-3\">
                                    <label for=\"filtroEstado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"filtroEstado\">
                                        <option value=\"\">Todos los estados</option>
                                        <option value=\"1\">Activo</option>
                                        <option value=\"0\">Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroTipo\" class=\"form-label\">Tipo</label>
                                    <select class=\"form-select\" id=\"filtroTipo\">
                                        <option value=\"\">Todos los tipos</option>
                                        <option value=\"libro\">Libro</option>
                                        <option value=\"articulo\">Artículo</option>
                                        <option value=\"tesis\">Tesis</option>
                                        <option value=\"software\">Software</option>
                                        <option value=\"sitio_web\">Sitio Web</option>
                                        <option value=\"generico\">Genérico</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroTipoBibliografia\" class=\"form-label\">Tipo de Bibliografía</label>
                                    <select class=\"form-select\" id=\"filtroTipoBibliografia\">
                                        <option value=\"\">Todos los tipos</option>
                                        <option value=\"basica\">Básica</option>
                                        <option value=\"complementaria\">Complementaria</option>
                                        <option value=\"otro\">Otro</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroBibliografiasDisponibles\" class=\"form-label\">Bibliografías Disponibles</label>
                                    <select class=\"form-select\" id=\"filtroBibliografiasDisponibles\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"con_disponibles\">Disponibles</option>
                                        <option value=\"sin_disponibles\">No disponibles</option>
                                    </select>
                                </div>
                            </div>
                            <div class=\"row mt-3\">
                                <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                                    <button type=\"button\" class=\"btn btn-primary\" id=\"btnAplicarFiltros\">
                                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                                    </button>
                                    <button type=\"button\" class=\"btn btn-secondary\" id=\"btnLimpiarFiltros\">
                                        <i class=\"fas fa-times\"></i> Limpiar Filtros
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla -->
                <div class=\"card\">
                    <div class=\"card-body p-0\">
                        <div class=\"table-responsive\">
                            <table id=\"tablaBibliografias\" class=\"table table-striped table-bordered w-100 mb-0\">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor(es)</th>
                                    <th>Año Edición</th>
                                    <th>Editorial</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th># Asignaturas</th>
                                    <th># Bibliografías Disponibles</th>
                                    <th>Tipos de Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de carga -->
<div class=\"modal fade\" id=\"modalCarga\" tabindex=\"-1\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-dialog-centered\">
        <div class=\"modal-content\">
            <div class=\"modal-body text-center\">
                <div class=\"spinner-border text-primary\" role=\"status\">
                    <span class=\"visually-hidden\">Cargando...</span>
                </div>
                <p class=\"mt-2\">Generando reporte...</p>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 138
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 139
        yield "<script>
\$(document).ready(function() {
    let table;
    
    // Inicializar DataTable
    function inicializarTabla() {
        table = \$('#tablaBibliografias').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '";
        // line 149
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/listado-bibliografias/data',
                type: 'GET',
                data: function(d) {
                    // Búsqueda general
                    d.busqueda = \$('#busqueda').val();
                    d.tipo_busqueda = \$('#tipo_busqueda').val();
                    // Filtros específicos
                    d.estado = \$('#filtroEstado').val();
                    d.tipo = \$('#filtroTipo').val();
                    d.tipo_bibliografia = \$('#filtroTipoBibliografia').val();
                    d.bibliografias_disponibles = \$('#filtroBibliografiasDisponibles').val();
                }
            },
            columns: [
                { data: 'titulo' },
                { data: 'autores' },
                { data: 'anio_publicacion' },
                { data: 'editorial' },
                { data: 'tipo' },
                { 
                    data: 'estado',
                    render: function(data) {
                        return data === 'Activo' 
                            ? '<span class=\"badge bg-success\">Activo</span>'
                            : '<span class=\"badge bg-danger\">Inactivo</span>';
                    }
                },
                { 
                    data: 'num_asignaturas',
                    className: 'text-center'
                },
                { 
                    data: 'num_bibliografias_disponibles',
                    className: 'text-center'
                },
                { 
                    data: 'tipos_bibliografias',
                    render: function(data) {
                        if (!data || data === 'Sin asignar') {
                            return '<span class=\"text-muted\">Sin asignar</span>';
                        }
                        return data;
                    }
                }
            ],
            order: [[0, 'asc']],
            pageLength: 25,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            dom: '<\"row\"<\"col-sm-12 col-md-6\"l><\"col-sm-12 col-md-6\"f>>' +
                 '<\"row\"<\"col-sm-12\"tr>>' +
                 '<\"row\"<\"col-sm-12 col-md-5\"i><\"col-sm-12 col-md-7\"p>>',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, \"Todos\"]]
        });
    }
    
    // Búsqueda general
    \$('#btnBuscar').click(function() {
        table.ajax.reload();
    });
    
    // Búsqueda al presionar Enter
    \$('#busqueda').keypress(function(e) {
        if (e.which == 13) {
            table.ajax.reload();
        }
    });
    
    // Aplicar filtros
    \$('#btnAplicarFiltros').click(function() {
        table.ajax.reload();
    });
    
    // Limpiar filtros
    \$('#btnLimpiarFiltros').click(function() {
        \$('#busqueda').val('');
        \$('#tipo_busqueda').val('todos');
        \$('#filtroEstado').val('');
        \$('#filtroTipo').val('');
        \$('#filtroTipoBibliografia').val('');
        \$('#filtroBibliografiasDisponibles').val('');
        table.ajax.reload();
    });
    
    // Exportar Excel
    \$('#btnExportar').click(function() {
        const btn = \$(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class=\"fas fa-spinner fa-spin\"></i> Exportando...');
        
        // Mostrar modal de carga
        \$('#modalCarga').modal('show');
        
        // Preparar parámetros para la exportación
        const params = new URLSearchParams({
            busqueda: \$('#busqueda').val(),
            tipo_busqueda: \$('#tipo_busqueda').val(),
            estado: \$('#filtroEstado').val(),
            tipo: \$('#filtroTipo').val(),
            tipo_bibliografia: \$('#filtroTipoBibliografia').val(),
            bibliografias_disponibles: \$('#filtroBibliografiasDisponibles').val()
        });
        
        // Crear enlace de descarga
        const link = document.createElement('a');
        link.href = '";
        // line 257
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "reportes/listado-bibliografias/exportar?' + params.toString();
        link.download = 'reporte_bibliografias_declaradas.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Ocultar modal y restaurar botón
        setTimeout(function() {
            \$('#modalCarga').modal('hide');
            btn.prop('disabled', false).html(originalText);
        }, 1000);
    });
    
    // Inicializar tabla
    inicializarTabla();
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
        return "reportes/bibliografias_declaradas.twig";
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
        return array (  336 => 257,  225 => 149,  213 => 139,  206 => 138,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Reporte de Bibliografías Declaradas{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            <i class=\"fas fa-book\"></i> Reporte de Bibliografías Declaradas
        </h1>
        <button type=\"button\" class=\"btn btn-success\" id=\"btnExportar\">
            <i class=\"fas fa-file-excel\"></i> Exportar Excel
        </button>
    </div>

    <!-- Filtros -->
    <div class=\"card mb-4\">
        <div class=\"card-header\">
            <h3 class=\"card-title mb-0\">Filtros</h3>
        </div>
        <div class=\"card-body p-0\">
            <form class=\"p-3\">
                            <!-- Fila de búsqueda general -->
                            <div class=\"row mb-3\">
                                <div class=\"col-12\">
                                    <div class=\"input-group\">
                                        <input type=\"text\" class=\"form-control\" id=\"busqueda\" placeholder=\"Buscar...\" value=\"\">
                                        <select class=\"form-select\" id=\"tipo_busqueda\" style=\"max-width: 150px;\">
                                            <option value=\"todos\">Todos</option>
                                            <option value=\"titulo\">Título</option>
                                            <option value=\"autor\">Autor</option>
                                            <option value=\"editorial\">Editorial</option>
                                            <option value=\"asignatura\">Asignatura</option>
                                        </select>
                                        <button type=\"button\" class=\"btn btn-primary\" id=\"btnBuscar\">
                                            <i class=\"fas fa-search\"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Fila de filtros específicos -->
                            <div class=\"row g-3\">
                                <div class=\"col-md-3\">
                                    <label for=\"filtroEstado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"filtroEstado\">
                                        <option value=\"\">Todos los estados</option>
                                        <option value=\"1\">Activo</option>
                                        <option value=\"0\">Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroTipo\" class=\"form-label\">Tipo</label>
                                    <select class=\"form-select\" id=\"filtroTipo\">
                                        <option value=\"\">Todos los tipos</option>
                                        <option value=\"libro\">Libro</option>
                                        <option value=\"articulo\">Artículo</option>
                                        <option value=\"tesis\">Tesis</option>
                                        <option value=\"software\">Software</option>
                                        <option value=\"sitio_web\">Sitio Web</option>
                                        <option value=\"generico\">Genérico</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroTipoBibliografia\" class=\"form-label\">Tipo de Bibliografía</label>
                                    <select class=\"form-select\" id=\"filtroTipoBibliografia\">
                                        <option value=\"\">Todos los tipos</option>
                                        <option value=\"basica\">Básica</option>
                                        <option value=\"complementaria\">Complementaria</option>
                                        <option value=\"otro\">Otro</option>
                                    </select>
                                </div>
                                <div class=\"col-md-3\">
                                    <label for=\"filtroBibliografiasDisponibles\" class=\"form-label\">Bibliografías Disponibles</label>
                                    <select class=\"form-select\" id=\"filtroBibliografiasDisponibles\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"con_disponibles\">Disponibles</option>
                                        <option value=\"sin_disponibles\">No disponibles</option>
                                    </select>
                                </div>
                            </div>
                            <div class=\"row mt-3\">
                                <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                                    <button type=\"button\" class=\"btn btn-primary\" id=\"btnAplicarFiltros\">
                                        <i class=\"fas fa-filter\"></i> Aplicar Filtros
                                    </button>
                                    <button type=\"button\" class=\"btn btn-secondary\" id=\"btnLimpiarFiltros\">
                                        <i class=\"fas fa-times\"></i> Limpiar Filtros
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla -->
                <div class=\"card\">
                    <div class=\"card-body p-0\">
                        <div class=\"table-responsive\">
                            <table id=\"tablaBibliografias\" class=\"table table-striped table-bordered w-100 mb-0\">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor(es)</th>
                                    <th>Año Edición</th>
                                    <th>Editorial</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th># Asignaturas</th>
                                    <th># Bibliografías Disponibles</th>
                                    <th>Tipos de Bibliografía</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de carga -->
<div class=\"modal fade\" id=\"modalCarga\" tabindex=\"-1\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-dialog-centered\">
        <div class=\"modal-content\">
            <div class=\"modal-body text-center\">
                <div class=\"spinner-border text-primary\" role=\"status\">
                    <span class=\"visually-hidden\">Cargando...</span>
                </div>
                <p class=\"mt-2\">Generando reporte...</p>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
\$(document).ready(function() {
    let table;
    
    // Inicializar DataTable
    function inicializarTabla() {
        table = \$('#tablaBibliografias').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ app_url }}reportes/listado-bibliografias/data',
                type: 'GET',
                data: function(d) {
                    // Búsqueda general
                    d.busqueda = \$('#busqueda').val();
                    d.tipo_busqueda = \$('#tipo_busqueda').val();
                    // Filtros específicos
                    d.estado = \$('#filtroEstado').val();
                    d.tipo = \$('#filtroTipo').val();
                    d.tipo_bibliografia = \$('#filtroTipoBibliografia').val();
                    d.bibliografias_disponibles = \$('#filtroBibliografiasDisponibles').val();
                }
            },
            columns: [
                { data: 'titulo' },
                { data: 'autores' },
                { data: 'anio_publicacion' },
                { data: 'editorial' },
                { data: 'tipo' },
                { 
                    data: 'estado',
                    render: function(data) {
                        return data === 'Activo' 
                            ? '<span class=\"badge bg-success\">Activo</span>'
                            : '<span class=\"badge bg-danger\">Inactivo</span>';
                    }
                },
                { 
                    data: 'num_asignaturas',
                    className: 'text-center'
                },
                { 
                    data: 'num_bibliografias_disponibles',
                    className: 'text-center'
                },
                { 
                    data: 'tipos_bibliografias',
                    render: function(data) {
                        if (!data || data === 'Sin asignar') {
                            return '<span class=\"text-muted\">Sin asignar</span>';
                        }
                        return data;
                    }
                }
            ],
            order: [[0, 'asc']],
            pageLength: 25,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            dom: '<\"row\"<\"col-sm-12 col-md-6\"l><\"col-sm-12 col-md-6\"f>>' +
                 '<\"row\"<\"col-sm-12\"tr>>' +
                 '<\"row\"<\"col-sm-12 col-md-5\"i><\"col-sm-12 col-md-7\"p>>',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, \"Todos\"]]
        });
    }
    
    // Búsqueda general
    \$('#btnBuscar').click(function() {
        table.ajax.reload();
    });
    
    // Búsqueda al presionar Enter
    \$('#busqueda').keypress(function(e) {
        if (e.which == 13) {
            table.ajax.reload();
        }
    });
    
    // Aplicar filtros
    \$('#btnAplicarFiltros').click(function() {
        table.ajax.reload();
    });
    
    // Limpiar filtros
    \$('#btnLimpiarFiltros').click(function() {
        \$('#busqueda').val('');
        \$('#tipo_busqueda').val('todos');
        \$('#filtroEstado').val('');
        \$('#filtroTipo').val('');
        \$('#filtroTipoBibliografia').val('');
        \$('#filtroBibliografiasDisponibles').val('');
        table.ajax.reload();
    });
    
    // Exportar Excel
    \$('#btnExportar').click(function() {
        const btn = \$(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class=\"fas fa-spinner fa-spin\"></i> Exportando...');
        
        // Mostrar modal de carga
        \$('#modalCarga').modal('show');
        
        // Preparar parámetros para la exportación
        const params = new URLSearchParams({
            busqueda: \$('#busqueda').val(),
            tipo_busqueda: \$('#tipo_busqueda').val(),
            estado: \$('#filtroEstado').val(),
            tipo: \$('#filtroTipo').val(),
            tipo_bibliografia: \$('#filtroTipoBibliografia').val(),
            bibliografias_disponibles: \$('#filtroBibliografiasDisponibles').val()
        });
        
        // Crear enlace de descarga
        const link = document.createElement('a');
        link.href = '{{ app_url }}reportes/listado-bibliografias/exportar?' + params.toString();
        link.download = 'reporte_bibliografias_declaradas.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Ocultar modal y restaurar botón
        setTimeout(function() {
            \$('#modalCarga').modal('hide');
            btn.prop('disabled', false).html(originalText);
        }, 1000);
    });
    
    // Inicializar tabla
    inicializarTabla();
});
</script>
{% endblock %} ", "reportes/bibliografias_declaradas.twig", "/var/www/html/biblioges/templates/reportes/bibliografias_declaradas.twig");
    }
}
