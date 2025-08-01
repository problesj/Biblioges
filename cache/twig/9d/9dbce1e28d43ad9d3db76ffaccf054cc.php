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

/* autores/duplicados.twig */
class __TwigTemplate_140352f4a0b5bfc9ff8ae84fd0ce2681 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/duplicados.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Duplicados de ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 3), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 3), "html", null, true);
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
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Duplicados de ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 16), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 16), "html", null, true);
        yield "</h3>
                </div>
                <div class=\"card-body\">
                    ";
        // line 19
        if (($context["error"] ?? null)) {
            // line 20
            yield "                        <div class=\"alert alert-danger alert-dismissible\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
                            ";
            // line 23
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
                        </div>
                    ";
        }
        // line 26
        yield "
                    ";
        // line 27
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["duplicados"] ?? null)) > 0)) {
            // line 28
            yield "                        <form action=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores/fusionar-grupo\" method=\"POST\" id=\"fusionarForm\">
                            <div class=\"row\">
                                <div class=\"col-md-8\">
                                    <div class=\"table-responsive\">
                                        <table class=\"table table-bordered table-striped\">
                                            <thead>
                                                <tr>
                                                    <th style=\"width: 50px;\">#</th>
                                                    <th>Autor</th>
                                                    <th>Género</th>
                                                    <th>Acción</th>
                                                    <th style=\"width: 100px;\">Principal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Autor original -->
                                                <tr class=\"table-primary\">
                                                    <td>";
            // line 45
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["loop"] ?? null), "index", [], "any", false, false, false, 45), "html", null, true);
            yield "</td>
                                                    <td>
                                                        <strong>";
            // line 47
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 47), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 47), "html", null, true);
            yield "</strong>
                                                        <br>
                                                        <small class=\"text-muted\">
                                                            <i class=\"fas fa-user\"></i> Autor original
                                                        </small>
                                                    </td>
                                                    <td class=\"text-center\">";
            // line 53
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "genero", [], "any", false, false, false, 53), "html", null, true);
            yield "</td>
                                                    <td>
                                                        <div class=\"form-check\">
                                                            <input class=\"form-check-input\" type=\"radio\" 
                                                                   name=\"acciones_autores[";
            // line 57
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 57), "html", null, true);
            yield "]\" 
                                                                   value=\"mantener\" id=\"mantener_";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 58), "html", null, true);
            yield "\" checked>
                                                            <label class=\"form-check-label\" for=\"mantener_";
            // line 59
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 59), "html", null, true);
            yield "\">
                                                                <span class=\"badge bg-secondary\">Mantener</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class=\"text-center\">
                                                        <div class=\"form-check\">
                                                            <input class=\"form-check-input autor-principal\" type=\"radio\" 
                                                                   name=\"autor_principal\" 
                                                                   value=\"";
            // line 68
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 68), "html", null, true);
            yield "\" id=\"principal_";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 68), "html", null, true);
            yield "\" checked>
                                                            <label class=\"form-check-label\" for=\"principal_";
            // line 69
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "id", [], "any", false, false, false, 69), "html", null, true);
            yield "\">
                                                                <i class=\"fas fa-star text-warning\"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <!-- Duplicados -->
                                                ";
            // line 77
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["duplicados"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["duplicado"]) {
                // line 78
                yield "                                                    <tr>
                                                        <td>";
                // line 79
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 79) + 1), "html", null, true);
                yield "</td>
                                                        <td>
                                                            <strong>";
                // line 81
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "apellidos", [], "any", false, false, false, 81), "html", null, true);
                yield ", ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "nombres", [], "any", false, false, false, 81), "html", null, true);
                yield "</strong>
                                                            ";
                // line 82
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "alias", [], "any", false, false, false, 82)) > 0)) {
                    // line 83
                    yield "                                                                <br>
                                                                <small class=\"text-muted\">
                                                                    <i class=\"fas fa-tags\"></i> 
                                                                    ";
                    // line 86
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "alias", [], "any", false, false, false, 86)), "html", null, true);
                    yield " variación(es)
                                                                </small>
                                                            ";
                }
                // line 89
                yield "                                                        </td>
                                                        <td class=\"text-center\">";
                // line 90
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "genero", [], "any", false, false, false, 90), "html", null, true);
                yield "</td>
                                                        <td>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[";
                // line 94
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 94), "html", null, true);
                yield "]\" 
                                                                       value=\"mantener\" id=\"mantener_";
                // line 95
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 95), "html", null, true);
                yield "\">
                                                                <label class=\"form-check-label\" for=\"mantener_";
                // line 96
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 96), "html", null, true);
                yield "\">
                                                                    <span class=\"badge bg-secondary\">Mantener</span>
                                                                </label>
                                                            </div>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[";
                // line 102
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 102), "html", null, true);
                yield "]\" 
                                                                       value=\"convertir_alias\" id=\"alias_";
                // line 103
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 103), "html", null, true);
                yield "\" checked>
                                                                <label class=\"form-check-label\" for=\"alias_";
                // line 104
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 104), "html", null, true);
                yield "\">
                                                                    <span class=\"badge bg-success\">Convertir en Alias</span>
                                                                </label>
                                                            </div>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[";
                // line 110
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 110), "html", null, true);
                yield "]\" 
                                                                       value=\"eliminar\" id=\"eliminar_";
                // line 111
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 111), "html", null, true);
                yield "\">
                                                                <label class=\"form-check-label\" for=\"eliminar_";
                // line 112
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 112), "html", null, true);
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
                // line 121
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 121), "html", null, true);
                yield "\" id=\"principal_";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 121), "html", null, true);
                yield "\">
                                                                <label class=\"form-check-label\" for=\"principal_";
                // line 122
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 122), "html", null, true);
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
            unset($context['_seq'], $context['_key'], $context['duplicado'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 129
            yield "                                            </tbody>
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
                                            
                                            <a href=\"";
            // line 160
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary w-100 mt-2\">
                                                <i class=\"fas fa-arrow-left\"></i> Volver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    ";
        } else {
            // line 169
            yield "                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores similares a ";
            // line 171
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "nombres", [], "any", false, false, false, 171), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["autor"] ?? null), "apellidos", [], "any", false, false, false, 171), "html", null, true);
            yield ".
                        </div>
                        <a href=\"";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                    ";
        }
        // line 177
        yield "                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 184
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 185
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
            document.getElementById('fusionarForm').addEventListener('submit', function(e) {
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
        // line 266
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["duplicados"] ?? null)) + 1), "html", null, true);
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
                        document.getElementById('fusionarForm').submit();
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
        return "autores/duplicados.twig";
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
        return array (  505 => 266,  420 => 185,  413 => 184,  403 => 177,  396 => 173,  389 => 171,  385 => 169,  373 => 160,  340 => 129,  319 => 122,  313 => 121,  301 => 112,  297 => 111,  293 => 110,  284 => 104,  280 => 103,  276 => 102,  267 => 96,  263 => 95,  259 => 94,  252 => 90,  249 => 89,  243 => 86,  238 => 83,  236 => 82,  230 => 81,  225 => 79,  222 => 78,  205 => 77,  194 => 69,  188 => 68,  176 => 59,  172 => 58,  168 => 57,  161 => 53,  150 => 47,  145 => 45,  124 => 28,  122 => 27,  119 => 26,  113 => 23,  108 => 20,  106 => 19,  98 => 16,  91 => 11,  84 => 10,  75 => 6,  68 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Duplicados de {{ autor.nombres }} {{ autor.apellidos }}{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css\">
{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Duplicados de {{ autor.nombres }} {{ autor.apellidos }}</h3>
                </div>
                <div class=\"card-body\">
                    {% if error %}
                        <div class=\"alert alert-danger alert-dismissible\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
                            {{ error }}
                        </div>
                    {% endif %}

                    {% if duplicados|length > 0 %}
                        <form action=\"{{ app_url }}autores/fusionar-grupo\" method=\"POST\" id=\"fusionarForm\">
                            <div class=\"row\">
                                <div class=\"col-md-8\">
                                    <div class=\"table-responsive\">
                                        <table class=\"table table-bordered table-striped\">
                                            <thead>
                                                <tr>
                                                    <th style=\"width: 50px;\">#</th>
                                                    <th>Autor</th>
                                                    <th>Género</th>
                                                    <th>Acción</th>
                                                    <th style=\"width: 100px;\">Principal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Autor original -->
                                                <tr class=\"table-primary\">
                                                    <td>{{ loop.index }}</td>
                                                    <td>
                                                        <strong>{{ autor.apellidos }}, {{ autor.nombres }}</strong>
                                                        <br>
                                                        <small class=\"text-muted\">
                                                            <i class=\"fas fa-user\"></i> Autor original
                                                        </small>
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
                                                    </td>
                                                    <td class=\"text-center\">
                                                        <div class=\"form-check\">
                                                            <input class=\"form-check-input autor-principal\" type=\"radio\" 
                                                                   name=\"autor_principal\" 
                                                                   value=\"{{ autor.id }}\" id=\"principal_{{ autor.id }}\" checked>
                                                            <label class=\"form-check-label\" for=\"principal_{{ autor.id }}\">
                                                                <i class=\"fas fa-star text-warning\"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <!-- Duplicados -->
                                                {% for duplicado in duplicados %}
                                                    <tr>
                                                        <td>{{ loop.index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ duplicado.apellidos }}, {{ duplicado.nombres }}</strong>
                                                            {% if duplicado.alias|length > 0 %}
                                                                <br>
                                                                <small class=\"text-muted\">
                                                                    <i class=\"fas fa-tags\"></i> 
                                                                    {{ duplicado.alias|length }} variación(es)
                                                                </small>
                                                            {% endif %}
                                                        </td>
                                                        <td class=\"text-center\">{{ duplicado.genero }}</td>
                                                        <td>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                       value=\"mantener\" id=\"mantener_{{ duplicado.id }}\">
                                                                <label class=\"form-check-label\" for=\"mantener_{{ duplicado.id }}\">
                                                                    <span class=\"badge bg-secondary\">Mantener</span>
                                                                </label>
                                                            </div>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                       value=\"convertir_alias\" id=\"alias_{{ duplicado.id }}\" checked>
                                                                <label class=\"form-check-label\" for=\"alias_{{ duplicado.id }}\">
                                                                    <span class=\"badge bg-success\">Convertir en Alias</span>
                                                                </label>
                                                            </div>
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input\" type=\"radio\" 
                                                                       name=\"acciones_autores[{{ duplicado.id }}]\" 
                                                                       value=\"eliminar\" id=\"eliminar_{{ duplicado.id }}\">
                                                                <label class=\"form-check-label\" for=\"eliminar_{{ duplicado.id }}\">
                                                                    <span class=\"badge bg-danger\">Eliminar</span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class=\"text-center\">
                                                            <div class=\"form-check\">
                                                                <input class=\"form-check-input autor-principal\" type=\"radio\" 
                                                                       name=\"autor_principal\" 
                                                                       value=\"{{ duplicado.id }}\" id=\"principal_{{ duplicado.id }}\">
                                                                <label class=\"form-check-label\" for=\"principal_{{ duplicado.id }}\">
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
                                            
                                            <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary w-100 mt-2\">
                                                <i class=\"fas fa-arrow-left\"></i> Volver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    {% else %}
                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores similares a {{ autor.nombres }} {{ autor.apellidos }}.
                        </div>
                        <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
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
            document.getElementById('fusionarForm').addEventListener('submit', function(e) {
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
                const totalAutores = {{ duplicados|length + 1 }};

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
                        document.getElementById('fusionarForm').submit();
                    }
                });
            });

            // Inicializar resumen
            actualizarResumen();
        });
    </script>
{% endblock %} ", "autores/duplicados.twig", "/var/www/html/biblioges/templates/autores/duplicados.twig");
    }
}
