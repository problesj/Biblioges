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

/* autores/variaciones.twig */
class __TwigTemplate_93bfed8917125660f70dfa768dde6e34 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/variaciones.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Variaciones de Nombre - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 3), "html", null, true);
        yield ", ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 3), "html", null, true);
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
        yield "    ";
        yield from $this->yieldParentBlock("stylesheets", $context, $blocks);
        yield "
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
";
        yield from [];
    }

    // line 10
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 11
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <div>
            <h1>Variaciones de Nombre</h1>
            <p class=\"text-muted\">Autor: <strong>";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 15), "html", null, true);
        yield ", ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 15), "html", null, true);
        yield "</strong></p>
        </div>
        <div>
            <a href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
            <button type=\"button\" class=\"btn btn-primary\" onclick=\"agregarVariacion()\">
                <i class=\"fas fa-plus\"></i> Agregar Variación
            </button>
        </div>
    </div>

    ";
        // line 27
        if (($context["error"] ?? null)) {
            // line 28
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 30
        yield "
    ";
        // line 31
        if (($context["success"] ?? null)) {
            // line 32
            yield "        <div class=\"alert alert-success\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["success"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 34
        yield "
    <div class=\"row\">
        <div class=\"col-md-8\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Variaciones de Nombre</h3>
                </div>
                <div class=\"card-body\">
                    ";
        // line 42
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "alias", [], "any", false, false, false, 42)) > 0)) {
            // line 43
            yield "                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-bordered\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Variación de Nombre</th>
                                        <th>Fecha de Creación</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ";
            // line 53
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "alias", [], "any", false, false, false, 53));
            foreach ($context['_seq'] as $context["_key"] => $context["alias"]) {
                // line 54
                yield "                                        <tr>
                                            <td>";
                // line 55
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alias"], "nombre_variacion", [], "any", false, false, false, 55), "html", null, true);
                yield "</td>
                                            <td>";
                // line 56
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["alias"], "fecha_creacion", [], "any", false, false, false, 56), "d/m/Y H:i"), "html", null, true);
                yield "</td>
                                            <td class=\"text-center\">
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarVariacion(";
                // line 58
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alias"], "id", [], "any", false, false, false, 58), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["alias"], "nombre_variacion", [], "any", false, false, false, 58), "html", null, true);
                yield "')\">
                                                    <i class=\"fas fa-trash\"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['alias'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            yield "                                </tbody>
                            </table>
                        </div>
                    ";
        } else {
            // line 68
            yield "                        <div class=\"alert alert-info\">
                            <i class=\"fas fa-info-circle\"></i> No hay variaciones de nombre registradas para este autor.
                        </div>
                    ";
        }
        // line 72
        yield "                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Información del Autor</h3>
                </div>
                <div class=\"card-body\">
                    <dl class=\"row\">
                        <dt class=\"col-sm-4\">Apellidos:</dt>
                        <dd class=\"col-sm-8\">";
        // line 84
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 84), "html", null, true);
        yield "</dd>
                        
                        <dt class=\"col-sm-4\">Nombres:</dt>
                        <dd class=\"col-sm-8\">";
        // line 87
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 87), "html", null, true);
        yield "</dd>
                        
                        <dt class=\"col-sm-4\">Género:</dt>
                        <dd class=\"col-sm-8\">";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "genero", [], "any", false, false, false, 90), "html", null, true);
        yield "</dd>
                        
                        <dt class=\"col-sm-4\">Total Variaciones:</dt>
                        <dd class=\"col-sm-8\">
                            <span class=\"badge bg-primary\">";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "alias", [], "any", false, false, false, 94)), "html", null, true);
        yield "</span>
                        </dd>
                    </dl>
                    
                    <div class=\"mt-3\">
                        <a href=\"";
        // line 99
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 99), "html", null, true);
        yield "/edit\" class=\"btn btn-info btn-sm\">
                            <i class=\"fas fa-edit\"></i> Editar Autor
                        </a>
                        <a href=\"";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 102), "html", null, true);
        yield "/duplicados\" class=\"btn btn-warning btn-sm\">
                            <i class=\"fas fa-search\"></i> Buscar Duplicados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar variación -->
<div class=\"modal fade\" id=\"modalVariacion\" tabindex=\"-1\" aria-labelledby=\"modalVariacionLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <form method=\"POST\" action=\"";
        // line 116
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 116), "html", null, true);
        yield "/variaciones\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"modalVariacionLabel\">Agregar Variación de Nombre</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
                </div>
                <div class=\"modal-body\">
                    <div class=\"mb-3\">
                        <label for=\"nombre_variacion\" class=\"form-label\">Variación de Nombre <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"nombre_variacion\" name=\"nombre_variacion\" 
                               placeholder=\"Ej: Apellido, Nombre\" required>
                        <div class=\"form-text\">
                            Ingrese la variación de nombre tal como aparece en las publicaciones.
                        </div>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                    <button type=\"submit\" class=\"btn btn-primary\">Agregar Variación</button>
                </div>
            </form>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 141
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 142
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para agregar variación
            window.agregarVariacion = function() {
                const modal = new bootstrap.Modal(document.getElementById('modalVariacion'));
                modal.show();
            };

            // Función para eliminar variación
            window.eliminarVariacion = function(aliasId, nombreVariacion) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Desea eliminar la variación \"\${nombreVariacion}\"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Crear formulario temporal para eliminar
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `";
        // line 168
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 168), "html", null, true);
        yield "/variaciones/\${aliasId}/delete`;
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Validación del formulario
            document.getElementById('modalVariacion').addEventListener('submit', function(e) {
                const input = document.getElementById('nombre_variacion');
                if (!input.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Debe ingresar una variación de nombre',
                        icon: 'error'
                    });
                }
            });
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
        return "autores/variaciones.twig";
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
        return array (  338 => 168,  308 => 142,  301 => 141,  270 => 116,  251 => 102,  243 => 99,  235 => 94,  228 => 90,  222 => 87,  216 => 84,  202 => 72,  196 => 68,  190 => 64,  176 => 58,  171 => 56,  167 => 55,  164 => 54,  160 => 53,  148 => 43,  146 => 42,  136 => 34,  130 => 32,  128 => 31,  125 => 30,  119 => 28,  117 => 27,  105 => 18,  97 => 15,  91 => 11,  84 => 10,  75 => 6,  68 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Variaciones de Nombre - {{ autor.apellidos }}, {{ autor.nombres }}{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <div>
            <h1>Variaciones de Nombre</h1>
            <p class=\"text-muted\">Autor: <strong>{{ autor.apellidos }}, {{ autor.nombres }}</strong></p>
        </div>
        <div>
            <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
            <button type=\"button\" class=\"btn btn-primary\" onclick=\"agregarVariacion()\">
                <i class=\"fas fa-plus\"></i> Agregar Variación
            </button>
        </div>
    </div>

    {% if error %}
        <div class=\"alert alert-danger\">{{ error }}</div>
    {% endif %}

    {% if success %}
        <div class=\"alert alert-success\">{{ success }}</div>
    {% endif %}

    <div class=\"row\">
        <div class=\"col-md-8\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Variaciones de Nombre</h3>
                </div>
                <div class=\"card-body\">
                    {% if autor.alias|length > 0 %}
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-bordered\">
                                <thead class=\"table-light\">
                                    <tr>
                                        <th>Variación de Nombre</th>
                                        <th>Fecha de Creación</th>
                                        <th class=\"text-center\">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for alias in autor.alias %}
                                        <tr>
                                            <td>{{ alias.nombre_variacion }}</td>
                                            <td>{{ alias.fecha_creacion|date('d/m/Y H:i') }}</td>
                                            <td class=\"text-center\">
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarVariacion({{ alias.id }}, '{{ alias.nombre_variacion }}')\">
                                                    <i class=\"fas fa-trash\"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    {% else %}
                        <div class=\"alert alert-info\">
                            <i class=\"fas fa-info-circle\"></i> No hay variaciones de nombre registradas para este autor.
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>

        <div class=\"col-md-4\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Información del Autor</h3>
                </div>
                <div class=\"card-body\">
                    <dl class=\"row\">
                        <dt class=\"col-sm-4\">Apellidos:</dt>
                        <dd class=\"col-sm-8\">{{ autor.apellidos }}</dd>
                        
                        <dt class=\"col-sm-4\">Nombres:</dt>
                        <dd class=\"col-sm-8\">{{ autor.nombres }}</dd>
                        
                        <dt class=\"col-sm-4\">Género:</dt>
                        <dd class=\"col-sm-8\">{{ autor.genero }}</dd>
                        
                        <dt class=\"col-sm-4\">Total Variaciones:</dt>
                        <dd class=\"col-sm-8\">
                            <span class=\"badge bg-primary\">{{ autor.alias|length }}</span>
                        </dd>
                    </dl>
                    
                    <div class=\"mt-3\">
                        <a href=\"{{ app_url }}autores/{{ autor.id }}/edit\" class=\"btn btn-info btn-sm\">
                            <i class=\"fas fa-edit\"></i> Editar Autor
                        </a>
                        <a href=\"{{ app_url }}autores/{{ autor.id }}/duplicados\" class=\"btn btn-warning btn-sm\">
                            <i class=\"fas fa-search\"></i> Buscar Duplicados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar variación -->
<div class=\"modal fade\" id=\"modalVariacion\" tabindex=\"-1\" aria-labelledby=\"modalVariacionLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <form method=\"POST\" action=\"{{ app_url }}autores/{{ autor.id }}/variaciones\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"modalVariacionLabel\">Agregar Variación de Nombre</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
                </div>
                <div class=\"modal-body\">
                    <div class=\"mb-3\">
                        <label for=\"nombre_variacion\" class=\"form-label\">Variación de Nombre <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"nombre_variacion\" name=\"nombre_variacion\" 
                               placeholder=\"Ej: Apellido, Nombre\" required>
                        <div class=\"form-text\">
                            Ingrese la variación de nombre tal como aparece en las publicaciones.
                        </div>
                    </div>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                    <button type=\"submit\" class=\"btn btn-primary\">Agregar Variación</button>
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
    {{ parent() }}
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para agregar variación
            window.agregarVariacion = function() {
                const modal = new bootstrap.Modal(document.getElementById('modalVariacion'));
                modal.show();
            };

            // Función para eliminar variación
            window.eliminarVariacion = function(aliasId, nombreVariacion) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Desea eliminar la variación \"\${nombreVariacion}\"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Crear formulario temporal para eliminar
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ app_url }}autores/{{ autor.id }}/variaciones/\${aliasId}/delete`;
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Validación del formulario
            document.getElementById('modalVariacion').addEventListener('submit', function(e) {
                const input = document.getElementById('nombre_variacion');
                if (!input.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Debe ingresar una variación de nombre',
                        icon: 'error'
                    });
                }
            });
        });
    </script>
{% endblock %} ", "autores/variaciones.twig", "/var/www/html/biblioges/templates/autores/variaciones.twig");
    }
}
