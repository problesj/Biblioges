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

/* departamentos/index.twig */
class __TwigTemplate_ff902130f1f423d9019728f243b64a8f extends Template
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
            'stylesheets' => [$this, 'block_stylesheets'],
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
        $this->parent = $this->loadTemplate("base.twig", "departamentos/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Departamentos - Sistema de Bibliografía";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
<style>
    .alert {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    .alert-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    .alert-content i {
        margin-right: 0.5rem;
    }
    .alert-actions {
        display: flex;
        align-items: center;
    }
    .alert .close {
        padding: 0;
        margin-left: 1rem;
        color: inherit;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        line-height: 1;
        font-weight: bold;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert .close:focus {
        outline: none;
    }
    /* Estilos para los filtros */
    .filtros-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: end;
        margin-bottom: 20px;
    }
    .filtros-container > div {
        margin-right: 0;
    }
    .filtros-container label {
        margin-right: 5px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .filtros-container select {
        min-width: 150px;
    }
    .filtros-container .btn {
        white-space: nowrap;
    }
    
    /* Estilos para la columna de acciones */
    .acciones-column {
        min-width: 200px;
        width: 200px;
        white-space: nowrap !important;
        overflow: visible;
    }
    
    .acciones-buttons {
        display: flex !important;
        gap: 8px;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap !important;
        flex-direction: row !important;
        width: 100%;
    }
    
    .acciones-buttons .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        min-width: 35px;
        height: 32px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 0 !important;
    }
    
    .acciones-buttons a,
    .acciones-buttons button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 0 !important;
        text-decoration: none;
    }
    
    /* Asegurar que la tabla sea responsive */
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Ajustar el ancho de las columnas */
    #departamentos-table th:nth-child(1), /* Código */
    #departamentos-table td:nth-child(1) {
        width: 100px;
        min-width: 100px;
    }
    
    #departamentos-table th:nth-child(5), /* Estado */
    #departamentos-table td:nth-child(5) {
        width: 100px;
        min-width: 100px;
    }
    
    #departamentos-table th:nth-child(6), /* Acciones */
    #departamentos-table td:nth-child(6) {
        width: 200px;
        min-width: 200px;
        white-space: nowrap;
        vertical-align: middle;
    }
    
    /* Forzar que los elementos dentro de la celda de acciones no se rompan */
    .acciones-column > div {
        white-space: nowrap !important;
        overflow: visible;
    }
</style>
";
        yield from [];
    }

    // line 144
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 145
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Departamentos</h3>
                        <a href=\"";
        // line 152
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nuevo Departamento
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card shadow mb-4\">
                        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"GET\" action=\"";
        // line 164
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                                    <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\">
                                        <option value=\"\">Todas las sedes</option>
                                        ";
        // line 169
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 170
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 170), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede_id", [], "any", false, false, false, 170) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 170))) {
                yield "selected";
            }
            yield ">
                                            ";
            // line 171
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 171), "html", null, true);
            yield "
                                        </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 174
        yield "                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"facultad_id\" class=\"form-label\">Facultad</label>
                                    <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\">
                                        <option value=\"\">Todas las facultades</option>
                                        ";
        // line 180
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["facultades"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["facultad"]) {
            // line 181
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 181), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "facultad_id", [], "any", false, false, false, 181) == CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "id", [], "any", false, false, false, 181))) {
                yield "selected";
            }
            yield ">
                                            ";
            // line 182
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["facultad"], "nombre", [], "any", false, false, false, 182), "html", null, true);
            yield "
                                        </option>
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['facultad'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 185
        yield "                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" ";
        // line 191
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 191) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                        <option value=\"0\" ";
        // line 192
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 192) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-filter\"></i> Filtrar
                                    </button>
                                    <a href=\"";
        // line 199
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-broom\"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de departamentos -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"departamentos-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th>Facultad</th>
                                    <th>Sede</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\" class=\"acciones-column\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 221
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["departamentos"] ?? null)) > 0)) {
            // line 222
            yield "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["departamentos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["departamento"]) {
                // line 223
                yield "                                        <tr>
                                            <td style=\"text-align: center;\">";
                // line 224
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "codigo", [], "any", false, false, false, 224), "html", null, true);
                yield "</td>
                                            <td>";
                // line 225
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "nombre", [], "any", false, false, false, 225), "html", null, true);
                yield "</td>
                                            <td>";
                // line 226
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "facultad_nombre", [], "any", false, false, false, 226), "html", null, true);
                yield "</td>
                                            <td>";
                // line 227
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "sede_nombre", [], "any", false, false, false, 227), "html", null, true);
                yield "</td>
                                            <td style=\"text-align: center;\">
                                                ";
                // line 229
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "estado", [], "any", false, false, false, 229) == "1")) {
                    // line 230
                    yield "                                                    <span class=\"badge bg-success\">Activo</span>
                                                ";
                } else {
                    // line 232
                    yield "                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                ";
                }
                // line 234
                yield "                                            </td>
                                            <td style=\"text-align: center;\" class=\"acciones-column\">
                                                <div class=\"acciones-buttons\">
                                                    <a href=\"";
                // line 237
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "departamentos/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 237), "html", null, true);
                yield "\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"";
                // line 240
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "departamentos/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 240), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                    <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" onclick=\"confirmarEliminacion(";
                // line 243
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "id", [], "any", false, false, false, 243), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["departamento"], "nombre", [], "any", false, false, false, 243), "html", null, true);
                yield "')\">
                                                        <i class=\"fas fa-trash\"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['departamento'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 250
            yield "                                ";
        } else {
            // line 251
            yield "                                    <tr>
                                        <td colspan=\"6\" class=\"text-center\">No hay departamentos registrados</td>
                                    </tr>
                                ";
        }
        // line 255
        yield "                            </tbody>
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

    // line 265
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 266
        yield "<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#departamentos-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"], [2, \"asc\"]], // Ordenar por facultad y luego por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 5 } // Deshabilitar ordenamiento en columna de acciones
            ]
        });

        // Mostrar mensajes de sesión con SweetAlert2
        ";
        // line 285
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["success"] ?? null))) {
            // line 286
            yield "            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '";
            // line 289
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "js"), "html", null, true);
            yield "',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        ";
        }
        // line 295
        yield "
        ";
        // line 296
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["error"] ?? null))) {
            // line 297
            yield "            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '";
            // line 300
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "js"), "html", null, true);
            yield "',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true
            });
        ";
        }
        // line 306
        yield "
        // Función para confirmar eliminación con SweetAlert2
        \$('form[action*=\"/delete\"]').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Función para confirmar eliminación de departamentos
        window.confirmarEliminacion = function(id, nombre) {
            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea eliminar el departamento \"\${nombre}\"? Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario dinámicamente y enviarlo
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '";
        // line 344
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "departamentos/' + id + '/delete';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        };
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
        return "departamentos/index.twig";
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
        return array (  553 => 344,  513 => 306,  504 => 300,  499 => 297,  497 => 296,  494 => 295,  485 => 289,  480 => 286,  478 => 285,  457 => 266,  450 => 265,  437 => 255,  431 => 251,  428 => 250,  413 => 243,  405 => 240,  397 => 237,  392 => 234,  388 => 232,  384 => 230,  382 => 229,  377 => 227,  373 => 226,  369 => 225,  365 => 224,  362 => 223,  357 => 222,  355 => 221,  330 => 199,  318 => 192,  312 => 191,  304 => 185,  295 => 182,  286 => 181,  282 => 180,  274 => 174,  265 => 171,  256 => 170,  252 => 169,  244 => 164,  229 => 152,  220 => 145,  213 => 144,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Departamentos - Sistema de Bibliografía{% endblock %}

{% block stylesheets %}
<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css\">
<style>
    .alert {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    .alert-content {
        display: flex;
        align-items: center;
        flex: 1;
    }
    .alert-content i {
        margin-right: 0.5rem;
    }
    .alert-actions {
        display: flex;
        align-items: center;
    }
    .alert .close {
        padding: 0;
        margin-left: 1rem;
        color: inherit;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        line-height: 1;
        font-weight: bold;
    }
    .alert .close:hover {
        opacity: 0.75;
    }
    .alert .close:focus {
        outline: none;
    }
    /* Estilos para los filtros */
    .filtros-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: end;
        margin-bottom: 20px;
    }
    .filtros-container > div {
        margin-right: 0;
    }
    .filtros-container label {
        margin-right: 5px;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .filtros-container select {
        min-width: 150px;
    }
    .filtros-container .btn {
        white-space: nowrap;
    }
    
    /* Estilos para la columna de acciones */
    .acciones-column {
        min-width: 200px;
        width: 200px;
        white-space: nowrap !important;
        overflow: visible;
    }
    
    .acciones-buttons {
        display: flex !important;
        gap: 8px;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap !important;
        flex-direction: row !important;
        width: 100%;
    }
    
    .acciones-buttons .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        min-width: 35px;
        height: 32px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 0 !important;
    }
    
    .acciones-buttons a,
    .acciones-buttons button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 0 !important;
        text-decoration: none;
    }
    
    /* Asegurar que la tabla sea responsive */
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Ajustar el ancho de las columnas */
    #departamentos-table th:nth-child(1), /* Código */
    #departamentos-table td:nth-child(1) {
        width: 100px;
        min-width: 100px;
    }
    
    #departamentos-table th:nth-child(5), /* Estado */
    #departamentos-table td:nth-child(5) {
        width: 100px;
        min-width: 100px;
    }
    
    #departamentos-table th:nth-child(6), /* Acciones */
    #departamentos-table td:nth-child(6) {
        width: 200px;
        min-width: 200px;
        white-space: nowrap;
        vertical-align: middle;
    }
    
    /* Forzar que los elementos dentro de la celda de acciones no se rompan */
    .acciones-column > div {
        white-space: nowrap !important;
        overflow: visible;
    }
</style>
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card shadow\">
                <div class=\"card-header\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <h3 class=\"card-title\">Listado de Departamentos</h3>
                        <a href=\"{{ app_url }}departamentos/create\" class=\"btn btn-primary\">
                            <i class=\"fas fa-plus\"></i> Nuevo Departamento
                        </a>
                    </div>
                </div>
                <div class=\"card-body\">
                    <!-- Filtros -->
                    <div class=\"card shadow mb-4\">
                        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
                            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"GET\" action=\"{{ app_url }}departamentos\" class=\"row g-3\">
                                <div class=\"col-md-4\">
                                    <label for=\"sede_id\" class=\"form-label\">Sede</label>
                                    <select class=\"form-select\" id=\"sede_id\" name=\"sede_id\">
                                        <option value=\"\">Todas las sedes</option>
                                        {% for sede in sedes %}
                                        <option value=\"{{ sede.id }}\" {% if filtros.sede_id == sede.id %}selected{% endif %}>
                                            {{ sede.nombre }}
                                        </option>
                                        {% endfor %}
                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"facultad_id\" class=\"form-label\">Facultad</label>
                                    <select class=\"form-select\" id=\"facultad_id\" name=\"facultad_id\">
                                        <option value=\"\">Todas las facultades</option>
                                        {% for facultad in facultades %}
                                        <option value=\"{{ facultad.id }}\" {% if filtros.facultad_id == facultad.id %}selected{% endif %}>
                                            {{ facultad.nombre }}
                                        </option>
                                        {% endfor %}
                                    </select>
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"estado\" class=\"form-label\">Estado</label>
                                    <select class=\"form-select\" id=\"estado\" name=\"estado\">
                                        <option value=\"\">Todos</option>
                                        <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                                        <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                                    </select>
                                </div>
                                <div class=\"col-md-4 d-flex align-items-end gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-filter\"></i> Filtrar
                                    </button>
                                    <a href=\"{{ app_url }}departamentos\" class=\"btn btn-secondary\">
                                        <i class=\"fas fa-broom\"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de departamentos -->
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered table-striped\" id=\"departamentos-table\">
                            <thead>
                                <tr>
                                    <th style=\"text-align: center;\">Código</th>
                                    <th>Nombre</th>
                                    <th>Facultad</th>
                                    <th>Sede</th>
                                    <th style=\"text-align: center;\">Estado</th>
                                    <th style=\"text-align: center;\" class=\"acciones-column\">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% if departamentos|length > 0 %}
                                    {% for departamento in departamentos %}
                                        <tr>
                                            <td style=\"text-align: center;\">{{ departamento.codigo }}</td>
                                            <td>{{ departamento.nombre }}</td>
                                            <td>{{ departamento.facultad_nombre }}</td>
                                            <td>{{ departamento.sede_nombre }}</td>
                                            <td style=\"text-align: center;\">
                                                {% if departamento.estado == '1' %}
                                                    <span class=\"badge bg-success\">Activo</span>
                                                {% else %}
                                                    <span class=\"badge bg-danger\">Inactivo</span>
                                                {% endif %}
                                            </td>
                                            <td style=\"text-align: center;\" class=\"acciones-column\">
                                                <div class=\"acciones-buttons\">
                                                    <a href=\"{{ app_url }}departamentos/{{ departamento.id }}\" class=\"btn btn-sm btn-info\" title=\"Ver detalles\">
                                                        <i class=\"fas fa-eye\"></i>
                                                    </a>
                                                    <a href=\"{{ app_url }}departamentos/{{ departamento.id }}/edit\" class=\"btn btn-sm btn-primary\" title=\"Editar\">
                                                        <i class=\"fas fa-edit\"></i>
                                                    </a>
                                                    <button type=\"button\" class=\"btn btn-sm btn-danger\" title=\"Eliminar\" onclick=\"confirmarEliminacion({{ departamento.id }}, '{{ departamento.nombre }}')\">
                                                        <i class=\"fas fa-trash\"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                {% else %}
                                    <tr>
                                        <td colspan=\"6\" class=\"text-center\">No hay departamentos registrados</td>
                                    </tr>
                                {% endif %}
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
<script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js\"></script>
<script src=\"https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
<script>
    \$(document).ready(function() {
        // Inicializar DataTable
        \$('#departamentos-table').DataTable({
            \"language\": {
                \"url\": \"//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json\"
            },
            \"order\": [[0, \"asc\"], [2, \"asc\"]], // Ordenar por facultad y luego por nombre
            \"columnDefs\": [
                { \"orderable\": false, \"targets\": 5 } // Deshabilitar ordenamiento en columna de acciones
            ]
        });

        // Mostrar mensajes de sesión con SweetAlert2
        {% if success is not empty %}
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ success|escape('js') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        {% endif %}

        {% if error is not empty %}
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ error|escape('js') }}',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true
            });
        {% endif %}

        // Función para confirmar eliminación con SweetAlert2
        \$('form[action*=\"/delete\"]').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Función para confirmar eliminación de departamentos
        window.confirmarEliminacion = function(id, nombre) {
            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea eliminar el departamento \"\${nombre}\"? Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario dinámicamente y enviarlo
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ app_url }}departamentos/' + id + '/delete';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        };
    });
</script>
{% endblock %} ", "departamentos/index.twig", "/var/www/html/biblioges/templates/departamentos/index.twig");
    }
}
