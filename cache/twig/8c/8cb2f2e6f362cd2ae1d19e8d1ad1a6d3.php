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

/* autores/variaciones_fusion.twig */
class __TwigTemplate_eb816f624dd63fa2dd63ddb4ef55e631 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/variaciones_fusion.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Fusión de Duplicados - Buscar Variaciones";
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
            <h1>Fusión de Duplicados</h1>
            <p class=\"text-muted\">Búsqueda: <strong>\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["terminoBusqueda"] ?? null), "html", null, true);
        yield "\"</strong></p>
        </div>
        <div>
            <a href=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "autores/duplicados-globales\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
    </div>

    ";
        // line 24
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)) > 0)) {
            // line 25
            yield "        <div class=\"card\">
            <div class=\"card-header\">
                <h3 class=\"card-title\">Autores Encontrados (";
            // line 27
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)), "html", null, true);
            yield ")</h3>
                <p class=\"text-muted mb-0\">Selecciona qué hacer con cada autor encontrado</p>
            </div>
            <div class=\"card-body\">
                <form method=\"POST\" action=\"";
            // line 31
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/fusionar-grupo\" id=\"fusionForm\">
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-striped table-bordered\">
                                    <thead class=\"table-light\">
                                        <tr>
                                            <th style=\"width: 50px;\">#</th>
                                            <th>Autor</th>
                                            <th>Género</th>
                                            <th>Acción</th>
                                            <th style=\"width: 100px;\">Principal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
            // line 46
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["autores"] ?? null));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                // line 47
                yield "                                            <tr>
                                                <td>";
                // line 48
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 48), "html", null, true);
                yield "</td>
                                                <td>
                                                    <strong>";
                // line 50
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 50), "html", null, true);
                yield ", ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 50), "html", null, true);
                yield "</strong>
                                                    ";
                // line 51
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "alias", [], "any", false, false, false, 51)) > 0)) {
                    // line 52
                    yield "                                                        <br>
                                                        <small class=\"text-muted\">
                                                            <i class=\"fas fa-tags\"></i> 
                                                            ";
                    // line 55
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "alias", [], "any", false, false, false, 55)), "html", null, true);
                    yield " variación(es)
                                                        </small>
                                                    ";
                }
                // line 58
                yield "                                                </td>
                                                <td class=\"text-center\">";
                // line 59
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 59), "html", null, true);
                yield "</td>
                                                <td>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[";
                // line 63
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 63), "html", null, true);
                yield "]\" 
                                                               value=\"mantener\" id=\"mantener_";
                // line 64
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 64), "html", null, true);
                yield "\" checked>
                                                        <label class=\"form-check-label\" for=\"mantener_";
                // line 65
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 65), "html", null, true);
                yield "\">
                                                            <span class=\"badge bg-secondary\">Mantener</span>
                                                        </label>
                                                    </div>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[";
                // line 71
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 71), "html", null, true);
                yield "]\" 
                                                               value=\"convertir_alias\" id=\"alias_";
                // line 72
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 72), "html", null, true);
                yield "\">
                                                        <label class=\"form-check-label\" for=\"alias_";
                // line 73
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 73), "html", null, true);
                yield "\">
                                                            <span class=\"badge bg-success\">Convertir en Alias</span>
                                                        </label>
                                                    </div>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[";
                // line 79
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 79), "html", null, true);
                yield "]\" 
                                                               value=\"eliminar\" id=\"eliminar_";
                // line 80
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 80), "html", null, true);
                yield "\">
                                                        <label class=\"form-check-label\" for=\"eliminar_";
                // line 81
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 81), "html", null, true);
                yield "\">
                                                            <span class=\"badge bg-danger\">Eliminar</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class=\"text-center\">
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input autor-principal\" type=\"radio\" 
                                                               name=\"autor_principal\" 
                                                               value=\"";
                // line 90
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 90), "html", null, true);
                yield "\" id=\"principal_";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 90), "html", null, true);
                yield "\">
                                                        <label class=\"form-check-label\" for=\"principal_";
                // line 91
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 91), "html", null, true);
                yield "\">
                                                            <i class=\"fas fa-star text-warning\"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 98
            yield "                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title\">Resumen de Acciones</h5>
                                </div>
                                <div class=\"card-body\">
                                    <div id=\"resumenAcciones\">
                                        <p class=\"text-muted\">Selecciona las acciones para ver el resumen</p>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class=\"alert alert-info\">
                                        <h6><i class=\"fas fa-info-circle\"></i> Instrucciones:</h6>
                                        <ul class=\"mb-0\">
                                            <li><strong>Mantener:</strong> El autor permanece sin cambios</li>
                                            <li><strong>Convertir en Alias:</strong> Se crea un alias y se transfieren referencias</li>
                                            <li><strong>Eliminar:</strong> Se elimina el autor y se transfieren referencias</li>
                                            <li><strong>Principal:</strong> El autor que recibirá las referencias</li>
                                        </ul>
                                    </div>
                                    
                                    <button type=\"submit\" class=\"btn btn-primary w-100\" id=\"btnFusionar\">
                                        <i class=\"fas fa-merge\"></i> Ejecutar Fusión
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    ";
        } else {
            // line 136
            yield "        <div class=\"alert alert-info\">
            <i class=\"fas fa-info-circle\"></i> 
            No se encontraron autores con el término \"<strong>";
            // line 138
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["terminoBusqueda"] ?? null), "html", null, true);
            yield "</strong>\".
            <br>
            <small class=\"text-muted\">
                Intente con un término diferente o verifique la ortografía.
            </small>
        </div>
    ";
        }
        // line 145
        yield "</div>
";
        yield from [];
    }

    // line 148
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 149
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para actualizar el resumen
            function actualizarResumen() {
                const autores = document.querySelectorAll('tbody tr');
                let mantener = 0;
                let convertirAlias = 0;
                let eliminar = 0;
                let principal = null;

                autores.forEach(function(fila) {
                    const autorId = fila.querySelector('input[name^=\"acciones_autores\"]').name.match(/\\[(\\d+)\\]/)[1];
                    const accionSeleccionada = fila.querySelector('input[name^=\"acciones_autores\"]:checked').value;
                    const esPrincipal = fila.querySelector('input[name=\"autor_principal\"]:checked');

                    if (esPrincipal) {
                        principal = autorId;
                    }

                    switch (accionSeleccionada) {
                        case 'mantener':
                            mantener++;
                            break;
                        case 'convertir_alias':
                            convertirAlias++;
                            break;
                        case 'eliminar':
                            eliminar++;
                            break;
                    }
                });

                const resumen = document.getElementById('resumenAcciones');
                let html = '<ul class=\"list-unstyled\">';
                
                if (principal) {
                    html += `<li><i class=\"fas fa-star text-warning\"></i> <strong>Autor Principal:</strong> ID \${principal}</li>`;
                }
                
                if (mantener > 0) {
                    html += `<li><span class=\"badge bg-secondary\">\${mantener}</span> autores se mantendrán</li>`;
                }
                
                if (convertirAlias > 0) {
                    html += `<li><span class=\"badge bg-success\">\${convertirAlias}</span> autores se convertirán en alias</li>`;
                }
                
                if (eliminar > 0) {
                    html += `<li><span class=\"badge bg-danger\">\${eliminar}</span> autores se eliminarán</li>`;
                }
                
                html += '</ul>';
                resumen.innerHTML = html;
            }

            // Event listeners para actualizar resumen
            document.querySelectorAll('input[name^=\"acciones_autores\"]').forEach(function(radio) {
                radio.addEventListener('change', actualizarResumen);
            });

            document.querySelectorAll('input[name=\"autor_principal\"]').forEach(function(radio) {
                radio.addEventListener('change', actualizarResumen);
            });

            // Validación del formulario
            document.getElementById('fusionForm').addEventListener('submit', function(e) {
                const autorPrincipal = document.querySelector('input[name=\"autor_principal\"]:checked');
                
                if (!autorPrincipal) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Debe seleccionar un autor principal',
                        icon: 'error'
                    });
                    return;
                }

                const eliminarCount = document.querySelectorAll('input[value=\"eliminar\"]:checked').length;
                const totalAutores = ";
        // line 230
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["autores"] ?? null)), "html", null, true);
        yield ";

                if (eliminarCount === totalAutores) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'No puede eliminar todos los autores',
                        icon: 'error'
                    });
                    return;
                }

                // Confirmación antes de ejecutar
                e.preventDefault();
                Swal.fire({
                    title: '¿Confirmar fusión?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ejecutar fusión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('fusionForm').submit();
                    }
                });
            });

            // Inicializar resumen
            actualizarResumen();
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
        return "autores/variaciones_fusion.twig";
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
        return array (  427 => 230,  342 => 149,  335 => 148,  329 => 145,  319 => 138,  315 => 136,  275 => 98,  254 => 91,  248 => 90,  236 => 81,  232 => 80,  228 => 79,  219 => 73,  215 => 72,  211 => 71,  202 => 65,  198 => 64,  194 => 63,  187 => 59,  184 => 58,  178 => 55,  173 => 52,  171 => 51,  165 => 50,  160 => 48,  157 => 47,  140 => 46,  122 => 31,  115 => 27,  111 => 25,  109 => 24,  100 => 18,  94 => 15,  88 => 11,  81 => 10,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Fusión de Duplicados - Buscar Variaciones{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <div>
            <h1>Fusión de Duplicados</h1>
            <p class=\"text-muted\">Búsqueda: <strong>\"{{ terminoBusqueda }}\"</strong></p>
        </div>
        <div>
            <a href=\"{{ app_url }}autores/duplicados-globales\" class=\"btn btn-secondary\">
                <i class=\"fas fa-arrow-left\"></i> Volver
            </a>
        </div>
    </div>

    {% if autores|length > 0 %}
        <div class=\"card\">
            <div class=\"card-header\">
                <h3 class=\"card-title\">Autores Encontrados ({{ autores|length }})</h3>
                <p class=\"text-muted mb-0\">Selecciona qué hacer con cada autor encontrado</p>
            </div>
            <div class=\"card-body\">
                <form method=\"POST\" action=\"{{ app_url }}autores/fusionar-grupo\" id=\"fusionForm\">
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"table-responsive\">
                                <table class=\"table table-striped table-bordered\">
                                    <thead class=\"table-light\">
                                        <tr>
                                            <th style=\"width: 50px;\">#</th>
                                            <th>Autor</th>
                                            <th>Género</th>
                                            <th>Acción</th>
                                            <th style=\"width: 100px;\">Principal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for autor in autores %}
                                            <tr>
                                                <td>{{ loop.index }}</td>
                                                <td>
                                                    <strong>{{ autor.apellidos }}, {{ autor.nombres }}</strong>
                                                    {% if autor.alias|length > 0 %}
                                                        <br>
                                                        <small class=\"text-muted\">
                                                            <i class=\"fas fa-tags\"></i> 
                                                            {{ autor.alias|length }} variación(es)
                                                        </small>
                                                    {% endif %}
                                                </td>
                                                <td class=\"text-center\">{{ autor.genero }}</td>
                                                <td>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[{{ autor.id }}]\" 
                                                               value=\"mantener\" id=\"mantener_{{ autor.id }}\" checked>
                                                        <label class=\"form-check-label\" for=\"mantener_{{ autor.id }}\">
                                                            <span class=\"badge bg-secondary\">Mantener</span>
                                                        </label>
                                                    </div>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[{{ autor.id }}]\" 
                                                               value=\"convertir_alias\" id=\"alias_{{ autor.id }}\">
                                                        <label class=\"form-check-label\" for=\"alias_{{ autor.id }}\">
                                                            <span class=\"badge bg-success\">Convertir en Alias</span>
                                                        </label>
                                                    </div>
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input\" type=\"radio\" 
                                                               name=\"acciones_autores[{{ autor.id }}]\" 
                                                               value=\"eliminar\" id=\"eliminar_{{ autor.id }}\">
                                                        <label class=\"form-check-label\" for=\"eliminar_{{ autor.id }}\">
                                                            <span class=\"badge bg-danger\">Eliminar</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class=\"text-center\">
                                                    <div class=\"form-check\">
                                                        <input class=\"form-check-input autor-principal\" type=\"radio\" 
                                                               name=\"autor_principal\" 
                                                               value=\"{{ autor.id }}\" id=\"principal_{{ autor.id }}\">
                                                        <label class=\"form-check-label\" for=\"principal_{{ autor.id }}\">
                                                            <i class=\"fas fa-star text-warning\"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class=\"col-md-4\">
                            <div class=\"card\">
                                <div class=\"card-header\">
                                    <h5 class=\"card-title\">Resumen de Acciones</h5>
                                </div>
                                <div class=\"card-body\">
                                    <div id=\"resumenAcciones\">
                                        <p class=\"text-muted\">Selecciona las acciones para ver el resumen</p>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class=\"alert alert-info\">
                                        <h6><i class=\"fas fa-info-circle\"></i> Instrucciones:</h6>
                                        <ul class=\"mb-0\">
                                            <li><strong>Mantener:</strong> El autor permanece sin cambios</li>
                                            <li><strong>Convertir en Alias:</strong> Se crea un alias y se transfieren referencias</li>
                                            <li><strong>Eliminar:</strong> Se elimina el autor y se transfieren referencias</li>
                                            <li><strong>Principal:</strong> El autor que recibirá las referencias</li>
                                        </ul>
                                    </div>
                                    
                                    <button type=\"submit\" class=\"btn btn-primary w-100\" id=\"btnFusionar\">
                                        <i class=\"fas fa-merge\"></i> Ejecutar Fusión
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    {% else %}
        <div class=\"alert alert-info\">
            <i class=\"fas fa-info-circle\"></i> 
            No se encontraron autores con el término \"<strong>{{ terminoBusqueda }}</strong>\".
            <br>
            <small class=\"text-muted\">
                Intente con un término diferente o verifique la ortografía.
            </small>
        </div>
    {% endif %}
</div>
{% endblock %}

{% block scripts %}
    {{ parent() }}
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para actualizar el resumen
            function actualizarResumen() {
                const autores = document.querySelectorAll('tbody tr');
                let mantener = 0;
                let convertirAlias = 0;
                let eliminar = 0;
                let principal = null;

                autores.forEach(function(fila) {
                    const autorId = fila.querySelector('input[name^=\"acciones_autores\"]').name.match(/\\[(\\d+)\\]/)[1];
                    const accionSeleccionada = fila.querySelector('input[name^=\"acciones_autores\"]:checked').value;
                    const esPrincipal = fila.querySelector('input[name=\"autor_principal\"]:checked');

                    if (esPrincipal) {
                        principal = autorId;
                    }

                    switch (accionSeleccionada) {
                        case 'mantener':
                            mantener++;
                            break;
                        case 'convertir_alias':
                            convertirAlias++;
                            break;
                        case 'eliminar':
                            eliminar++;
                            break;
                    }
                });

                const resumen = document.getElementById('resumenAcciones');
                let html = '<ul class=\"list-unstyled\">';
                
                if (principal) {
                    html += `<li><i class=\"fas fa-star text-warning\"></i> <strong>Autor Principal:</strong> ID \${principal}</li>`;
                }
                
                if (mantener > 0) {
                    html += `<li><span class=\"badge bg-secondary\">\${mantener}</span> autores se mantendrán</li>`;
                }
                
                if (convertirAlias > 0) {
                    html += `<li><span class=\"badge bg-success\">\${convertirAlias}</span> autores se convertirán en alias</li>`;
                }
                
                if (eliminar > 0) {
                    html += `<li><span class=\"badge bg-danger\">\${eliminar}</span> autores se eliminarán</li>`;
                }
                
                html += '</ul>';
                resumen.innerHTML = html;
            }

            // Event listeners para actualizar resumen
            document.querySelectorAll('input[name^=\"acciones_autores\"]').forEach(function(radio) {
                radio.addEventListener('change', actualizarResumen);
            });

            document.querySelectorAll('input[name=\"autor_principal\"]').forEach(function(radio) {
                radio.addEventListener('change', actualizarResumen);
            });

            // Validación del formulario
            document.getElementById('fusionForm').addEventListener('submit', function(e) {
                const autorPrincipal = document.querySelector('input[name=\"autor_principal\"]:checked');
                
                if (!autorPrincipal) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'Debe seleccionar un autor principal',
                        icon: 'error'
                    });
                    return;
                }

                const eliminarCount = document.querySelectorAll('input[value=\"eliminar\"]:checked').length;
                const totalAutores = {{ autores|length }};

                if (eliminarCount === totalAutores) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error',
                        text: 'No puede eliminar todos los autores',
                        icon: 'error'
                    });
                    return;
                }

                // Confirmación antes de ejecutar
                e.preventDefault();
                Swal.fire({
                    title: '¿Confirmar fusión?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ejecutar fusión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('fusionForm').submit();
                    }
                });
            });

            // Inicializar resumen
            actualizarResumen();
        });
    </script>
{% endblock %} ", "autores/variaciones_fusion.twig", "/var/www/html/biblioges/templates/autores/variaciones_fusion.twig");
    }
}
