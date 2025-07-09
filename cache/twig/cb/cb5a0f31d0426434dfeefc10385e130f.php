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

/* autores/duplicados_globales.twig */
class __TwigTemplate_b2a37bbd8c432101c0aaa0ff0c6134dc extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "autores/duplicados_globales.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Búsqueda Global de Duplicados";
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
                    <h3 class=\"card-title\">Búsqueda Global de Duplicados</h3>
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
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["gruposDuplicados"] ?? null)) > 0)) {
            // line 28
            yield "                        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["gruposDuplicados"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["grupo"]) {
                // line 29
                yield "                            <div class=\"card mb-3\">
                                <div class=\"card-header bg-light\">
                                    <h5 class=\"mb-0\">Grupo ";
                // line 31
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 31), "html", null, true);
                yield "</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form action=\"";
                // line 34
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/fusionar-grupo\" method=\"POST\" class=\"grupo-form\">
                                        <input type=\"hidden\" name=\"grupo_id\" value=\"";
                // line 35
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 35), "html", null, true);
                yield "\">
                                        
                                        <div class=\"table-responsive\">
                                            <table class=\"table table-bordered table-striped\">
                                                <thead>
                                                    <tr>
                                                        <th style=\"width: 50px;\">Principal</th>
                                                        <th style=\"width: 50px;\">Fusionar</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>Género</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class=\"custom-control custom-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                       id=\"autor_";
                // line 54
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 54), "id", [], "any", false, false, false, 54), "html", null, true);
                yield "\" 
                                                                       name=\"autor_principal\" 
                                                                       value=\"";
                // line 56
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 56), "id", [], "any", false, false, false, 56), "html", null, true);
                yield "\" required>
                                                                <label class=\"custom-control-label\" for=\"autor_";
                // line 57
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 57), "id", [], "any", false, false, false, 57), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class=\"custom-control custom-checkbox\">
                                                                <input type=\"checkbox\" class=\"custom-control-input autor-fusionar\" 
                                                                       id=\"fusionar_";
                // line 63
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 63), "id", [], "any", false, false, false, 63), "html", null, true);
                yield "\" 
                                                                       name=\"autores_fusionar[]\" 
                                                                       value=\"";
                // line 65
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 65), "id", [], "any", false, false, false, 65), "html", null, true);
                yield "\">
                                                                <label class=\"custom-control-label\" for=\"fusionar_";
                // line 66
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 66), "id", [], "any", false, false, false, 66), "html", null, true);
                yield "\"></label>
                                                            </div>
                                                        </td>
                                                        <td>";
                // line 69
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 69), "nombres", [], "any", false, false, false, 69), "html", null, true);
                yield "</td>
                                                        <td>";
                // line 70
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 70), "apellidos", [], "any", false, false, false, 70), "html", null, true);
                yield "</td>
                                                        <td>";
                // line 71
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 71), "genero", [], "any", false, false, false, 71), "html", null, true);
                yield "</td>
                                                        <td>
                                                            <a href=\"";
                // line 73
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                yield "autores/";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "principal", [], "any", false, false, false, 73), "id", [], "any", false, false, false, 73), "html", null, true);
                yield "/edit\" class=\"btn btn-sm btn-info\">
                                                                <i class=\"fas fa-edit\"></i> Editar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    ";
                // line 78
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["grupo"], "duplicados", [], "any", false, false, false, 78));
                foreach ($context['_seq'] as $context["_key"] => $context["duplicado"]) {
                    // line 79
                    yield "                                                        <tr>
                                                            <td>
                                                                <div class=\"custom-control custom-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                           id=\"autor_";
                    // line 83
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 83), "html", null, true);
                    yield "\" 
                                                                           name=\"autor_principal\" 
                                                                           value=\"";
                    // line 85
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 85), "html", null, true);
                    yield "\" required>
                                                                    <label class=\"custom-control-label\" for=\"autor_";
                    // line 86
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 86), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class=\"custom-control custom-checkbox\">
                                                                    <input type=\"checkbox\" class=\"custom-control-input autor-fusionar\" 
                                                                           id=\"fusionar_";
                    // line 92
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 92), "html", null, true);
                    yield "\" 
                                                                           name=\"autores_fusionar[]\" 
                                                                           value=\"";
                    // line 94
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 94), "html", null, true);
                    yield "\">
                                                                    <label class=\"custom-control-label\" for=\"fusionar_";
                    // line 95
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 95), "html", null, true);
                    yield "\"></label>
                                                                </div>
                                                            </td>
                                                            <td>";
                    // line 98
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "nombres", [], "any", false, false, false, 98), "html", null, true);
                    yield "</td>
                                                            <td>";
                    // line 99
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "apellidos", [], "any", false, false, false, 99), "html", null, true);
                    yield "</td>
                                                            <td>";
                    // line 100
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "genero", [], "any", false, false, false, 100), "html", null, true);
                    yield "</td>
                                                            <td>
                                                                <a href=\"";
                    // line 102
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
                    yield "autores/";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["duplicado"], "id", [], "any", false, false, false, 102), "html", null, true);
                    yield "/edit\" class=\"btn btn-sm btn-info\">
                                                                    <i class=\"fas fa-edit\"></i> Editar
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['duplicado'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 108
                yield "                                                </tbody>
                                            </table>
                                        </div>

                                        <div class=\"form-group mt-3\">
                                            <button type=\"submit\" class=\"btn btn-primary fusionar-grupo-btn\" disabled>
                                                <i class=\"fas fa-object-group\"></i> Fusionar Grupo
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
            unset($context['_seq'], $context['_key'], $context['grupo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 121
            yield "
                        <div class=\"form-group\">
                            <a href=\"";
            // line 123
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    ";
        } else {
            // line 128
            yield "                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores duplicados en el sistema.
                        </div>
                        <a href=\"";
            // line 132
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "autores\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-arrow-left\"></i> Volver
                        </a>
                    ";
        }
        // line 136
        yield "                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 143
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 144
        yield "    ";
        yield from $this->yieldParentBlock("scripts", $context, $blocks);
        yield "
    <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js\"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Para cada formulario de grupo
        document.querySelectorAll('.grupo-form').forEach(form => {
            const radioButtons = form.querySelectorAll('.autor-principal');
            const checkboxes = form.querySelectorAll('.autor-fusionar');
            const fusionarBtn = form.querySelector('.fusionar-grupo-btn');

            // Función para actualizar el estado del botón de fusionar
            function actualizarBotonFusionar() {
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const autoresFusionar = form.querySelectorAll('.autor-fusionar:checked');
                
                // Habilitar el botón solo si hay un autor principal y al menos un autor para fusionar
                fusionarBtn.disabled = !autorPrincipal || autoresFusionar.length === 0;
            }

            // Evento para los radio buttons
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Desmarcar el checkbox del autor principal
                    const checkbox = form.querySelector(`#fusionar_\${this.value}`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Si se marca el checkbox, desmarcar el radio button
                    if (this.checked) {
                        const radio = form.querySelector(`#autor_\${this.value}`);
                        if (radio) {
                            radio.checked = false;
                        }
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para el formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const autoresFusionar = form.querySelectorAll('.autor-fusionar:checked');
                
                if (!autorPrincipal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione un autor principal.',
                        icon: 'error'
                    });
                    return;
                }
                
                if (autoresFusionar.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione al menos un autor para fusionar.',
                        icon: 'error'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: \"¿Está seguro de que desea fusionar los autores seleccionados? Esta acción no se puede deshacer.\",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, fusionar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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
        return "autores/duplicados_globales.twig";
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
        return array (  364 => 144,  357 => 143,  347 => 136,  340 => 132,  334 => 128,  326 => 123,  322 => 121,  296 => 108,  282 => 102,  277 => 100,  273 => 99,  269 => 98,  263 => 95,  259 => 94,  254 => 92,  245 => 86,  241 => 85,  236 => 83,  230 => 79,  226 => 78,  216 => 73,  211 => 71,  207 => 70,  203 => 69,  197 => 66,  193 => 65,  188 => 63,  179 => 57,  175 => 56,  170 => 54,  148 => 35,  144 => 34,  138 => 31,  134 => 29,  116 => 28,  114 => 27,  111 => 26,  105 => 23,  100 => 20,  98 => 19,  88 => 11,  81 => 10,  72 => 6,  65 => 5,  54 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Búsqueda Global de Duplicados{% endblock %}

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
                    <h3 class=\"card-title\">Búsqueda Global de Duplicados</h3>
                </div>
                <div class=\"card-body\">
                    {% if error %}
                        <div class=\"alert alert-danger alert-dismissible\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                            <h5><i class=\"icon fas fa-ban\"></i> Error</h5>
                            {{ error }}
                        </div>
                    {% endif %}

                    {% if gruposDuplicados|length > 0 %}
                        {% for grupo in gruposDuplicados %}
                            <div class=\"card mb-3\">
                                <div class=\"card-header bg-light\">
                                    <h5 class=\"mb-0\">Grupo {{ loop.index }}</h5>
                                </div>
                                <div class=\"card-body\">
                                    <form action=\"{{ app_url }}autores/fusionar-grupo\" method=\"POST\" class=\"grupo-form\">
                                        <input type=\"hidden\" name=\"grupo_id\" value=\"{{ loop.index }}\">
                                        
                                        <div class=\"table-responsive\">
                                            <table class=\"table table-bordered table-striped\">
                                                <thead>
                                                    <tr>
                                                        <th style=\"width: 50px;\">Principal</th>
                                                        <th style=\"width: 50px;\">Fusionar</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>Género</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class=\"custom-control custom-radio\">
                                                                <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                       id=\"autor_{{ grupo.principal.id }}\" 
                                                                       name=\"autor_principal\" 
                                                                       value=\"{{ grupo.principal.id }}\" required>
                                                                <label class=\"custom-control-label\" for=\"autor_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class=\"custom-control custom-checkbox\">
                                                                <input type=\"checkbox\" class=\"custom-control-input autor-fusionar\" 
                                                                       id=\"fusionar_{{ grupo.principal.id }}\" 
                                                                       name=\"autores_fusionar[]\" 
                                                                       value=\"{{ grupo.principal.id }}\">
                                                                <label class=\"custom-control-label\" for=\"fusionar_{{ grupo.principal.id }}\"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ grupo.principal.nombres }}</td>
                                                        <td>{{ grupo.principal.apellidos }}</td>
                                                        <td>{{ grupo.principal.genero }}</td>
                                                        <td>
                                                            <a href=\"{{ app_url }}autores/{{ grupo.principal.id }}/edit\" class=\"btn btn-sm btn-info\">
                                                                <i class=\"fas fa-edit\"></i> Editar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {% for duplicado in grupo.duplicados %}
                                                        <tr>
                                                            <td>
                                                                <div class=\"custom-control custom-radio\">
                                                                    <input type=\"radio\" class=\"custom-control-input autor-principal\" 
                                                                           id=\"autor_{{ duplicado.id }}\" 
                                                                           name=\"autor_principal\" 
                                                                           value=\"{{ duplicado.id }}\" required>
                                                                    <label class=\"custom-control-label\" for=\"autor_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class=\"custom-control custom-checkbox\">
                                                                    <input type=\"checkbox\" class=\"custom-control-input autor-fusionar\" 
                                                                           id=\"fusionar_{{ duplicado.id }}\" 
                                                                           name=\"autores_fusionar[]\" 
                                                                           value=\"{{ duplicado.id }}\">
                                                                    <label class=\"custom-control-label\" for=\"fusionar_{{ duplicado.id }}\"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ duplicado.nombres }}</td>
                                                            <td>{{ duplicado.apellidos }}</td>
                                                            <td>{{ duplicado.genero }}</td>
                                                            <td>
                                                                <a href=\"{{ app_url }}autores/{{ duplicado.id }}/edit\" class=\"btn btn-sm btn-info\">
                                                                    <i class=\"fas fa-edit\"></i> Editar
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    {% endfor %}
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class=\"form-group mt-3\">
                                            <button type=\"submit\" class=\"btn btn-primary fusionar-grupo-btn\" disabled>
                                                <i class=\"fas fa-object-group\"></i> Fusionar Grupo
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        {% endfor %}

                        <div class=\"form-group\">
                            <a href=\"{{ app_url }}autores\" class=\"btn btn-secondary\">
                                <i class=\"fas fa-arrow-left\"></i> Volver
                            </a>
                        </div>
                    {% else %}
                        <div class=\"alert alert-info\">
                            <h5><i class=\"icon fas fa-info\"></i> No se encontraron duplicados</h5>
                            No se encontraron autores duplicados en el sistema.
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
        // Para cada formulario de grupo
        document.querySelectorAll('.grupo-form').forEach(form => {
            const radioButtons = form.querySelectorAll('.autor-principal');
            const checkboxes = form.querySelectorAll('.autor-fusionar');
            const fusionarBtn = form.querySelector('.fusionar-grupo-btn');

            // Función para actualizar el estado del botón de fusionar
            function actualizarBotonFusionar() {
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const autoresFusionar = form.querySelectorAll('.autor-fusionar:checked');
                
                // Habilitar el botón solo si hay un autor principal y al menos un autor para fusionar
                fusionarBtn.disabled = !autorPrincipal || autoresFusionar.length === 0;
            }

            // Evento para los radio buttons
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Desmarcar el checkbox del autor principal
                    const checkbox = form.querySelector(`#fusionar_\${this.value}`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Si se marca el checkbox, desmarcar el radio button
                    if (this.checked) {
                        const radio = form.querySelector(`#autor_\${this.value}`);
                        if (radio) {
                            radio.checked = false;
                        }
                    }
                    actualizarBotonFusionar();
                });
            });

            // Evento para el formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const autorPrincipal = form.querySelector('.autor-principal:checked');
                const autoresFusionar = form.querySelectorAll('.autor-fusionar:checked');
                
                if (!autorPrincipal) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione un autor principal.',
                        icon: 'error'
                    });
                    return;
                }
                
                if (autoresFusionar.length === 0) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, seleccione al menos un autor para fusionar.',
                        icon: 'error'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: \"¿Está seguro de que desea fusionar los autores seleccionados? Esta acción no se puede deshacer.\",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, fusionar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
{% endblock %} ", "autores/duplicados_globales.twig", "/var/www/html/biblioges/templates/autores/duplicados_globales.twig");
    }
}
