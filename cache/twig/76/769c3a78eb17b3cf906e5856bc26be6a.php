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

/* carreras/index.twig */
class __TwigTemplate_ed3e3da13d7985b417858c2bf3734227 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Carreras - Sistema de Bibliografía";
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
        yield "<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "nombre", [], "any", false, false, false, 25), "html", null, true);
        yield "\" placeholder=\"Buscar por nombre...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\">Tipo de Programa</label>
                            <select class=\"form-control\" id=\"tipo_programa\" name=\"tipo_programa\">
                                <option value=\"\">Todos</option>
                                <option value=\"P\" ";
        // line 33
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 33) == "P")) {
            yield "selected";
        }
        yield ">Pregrado</option>
                                <option value=\"G\" ";
        // line 34
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 34) == "G")) {
            yield "selected";
        }
        yield ">Postgrado</option>
                                <option value=\"O\" ";
        // line 35
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "tipo_programa", [], "any", false, false, false, 35) == "O")) {
            yield "selected";
        }
        yield ">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas</option>
                                ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 45
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 45), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "sede", [], "any", false, false, false, 45) == CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 45))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 45), "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        yield "                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" ";
        // line 55
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 55) == "1")) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 56
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filtros"] ?? null), "estado", [], "any", false, false, false, 56) == "0")) {
            yield "selected";
        }
        yield ">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código(s)</th>
                            <th>Nombre</th>
                            <th>Tipo de Programa</th>
                            <th>Sede-Unidad</th>
                            <th class=\"text-center\">Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 94
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 95
            yield "                        <tr>
                            <td>";
            // line 96
            yield Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "codigos_carrera", [], "any", false, false, false, 96), ["," => "<br>"]);
            yield "</td>
                            <td>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 97), "html", null, true);
            yield "</td>
                            <td>
                                ";
            // line 99
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 99) == "P")) {
                // line 100
                yield "                                    Pregrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 101
$context["carrera"], "tipo_programa", [], "any", false, false, false, 101) == "G")) {
                // line 102
                yield "                                    Postgrado
                                ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 103
$context["carrera"], "tipo_programa", [], "any", false, false, false, 103) == "O")) {
                // line 104
                yield "                                    Otro
                                ";
            } else {
                // line 106
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "tipo_programa", [], "any", false, false, false, 106), "html", null, true);
                yield "
                                ";
            }
            // line 108
            yield "                            </td>
                            <td>
                                ";
            // line 110
            $context["sedes"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "sedes", [], "any", false, false, false, 110), ",");
            // line 111
            yield "                                ";
            $context["unidades"] = Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "unidades", [], "any", false, false, false, 111), ",");
            // line 112
            yield "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["sedes"] ?? null)) - 1)));
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
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 113
                yield "                                    ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v0 = ($context["sedes"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "html", null, true);
                yield " - ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = ($context["unidades"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "html", null, true);
                if ( !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 113)) {
                    yield "<br>";
                }
                // line 114
                yield "                                ";
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
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 115
            yield "                            </td>
                            <td class=\"text-center\">
                                ";
            // line 117
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "estado", [], "any", false, false, false, 117) == 1)) {
                // line 118
                yield "                                    <span class=\"badge bg-success\">Activo</span>
                                ";
            } else {
                // line 120
                yield "                                    <span class=\"badge bg-danger\">Inactivo</span>
                                ";
            }
            // line 122
            yield "                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"";
            // line 125
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 125), "html", null, true);
            yield "\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"";
            // line 128
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 128), "html", null, true);
            yield "/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"";
            // line 131
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "carreras/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 131), "html", null, true);
            yield "/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-danger btn-sm\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        ";
            $context['_iterated'] = true;
        }
        // line 139
        if (!$context['_iterated']) {
            // line 140
            yield "                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 144
        yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 152
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 153
        yield "<script>
    // Función para mostrar alertas
    function showAlert(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }

    // Mostrar alertas de sesión si existen
    ";
        // line 165
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 165)) {
            // line 166
            yield "        showAlert('¡Éxito!', '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "success", [], "any", false, false, false, 166), "html", null, true);
            yield "', 'success');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('";
            // line 168
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    ";
        }
        // line 176
        yield "
    ";
        // line 177
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 177)) {
            // line 178
            yield "        showAlert('Error', '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "error", [], "any", false, false, false, 178), "html", null, true);
            yield "', 'error');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('";
            // line 180
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    ";
        }
        // line 188
        yield "
    // Confirmación de eliminación con AJAX
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('¡Éxito!', data.message, 'success');
                            // Eliminar la fila de la tabla
                            form.closest('tr').remove();
                        } else {
                            showAlert('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                    });
                }
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
        return "carreras/index.twig";
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
        return array (  438 => 188,  427 => 180,  421 => 178,  419 => 177,  416 => 176,  405 => 168,  399 => 166,  397 => 165,  383 => 153,  376 => 152,  365 => 144,  356 => 140,  354 => 139,  339 => 131,  331 => 128,  323 => 125,  318 => 122,  314 => 120,  310 => 118,  308 => 117,  304 => 115,  290 => 114,  282 => 113,  264 => 112,  261 => 111,  259 => 110,  255 => 108,  249 => 106,  245 => 104,  243 => 103,  240 => 102,  238 => 101,  235 => 100,  233 => 99,  228 => 97,  224 => 96,  221 => 95,  216 => 94,  185 => 66,  170 => 56,  164 => 55,  154 => 47,  139 => 45,  135 => 44,  121 => 35,  115 => 34,  109 => 33,  98 => 25,  90 => 20,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Carreras - Sistema de Bibliografía{% endblock %}

{% block content %}
<div class=\"row\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Carreras</h1>
        <a href=\"{{ app_url }}carreras/create\" class=\"btn btn-primary\">
            <i class=\"fas fa-plus\"></i> Nueva Carrera
        </a>
    </div>

    <!-- Filtros -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Filtros de Búsqueda</h6>
        </div>
        <div class=\"card-body\">
            <form method=\"GET\" action=\"{{ app_url }}carreras\" class=\"mb-4\">
                <div class=\"row\">
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"nombre\">Nombre de la Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nombre\" name=\"nombre\" value=\"{{ filtros.nombre }}\" placeholder=\"Buscar por nombre...\">
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"tipo_programa\">Tipo de Programa</label>
                            <select class=\"form-control\" id=\"tipo_programa\" name=\"tipo_programa\">
                                <option value=\"\">Todos</option>
                                <option value=\"P\" {% if filtros.tipo_programa == 'P' %}selected{% endif %}>Pregrado</option>
                                <option value=\"G\" {% if filtros.tipo_programa == 'G' %}selected{% endif %}>Postgrado</option>
                                <option value=\"O\" {% if filtros.tipo_programa == 'O' %}selected{% endif %}>Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"sede\">Sede</label>
                            <select class=\"form-control\" id=\"sede\" name=\"sede\">
                                <option value=\"\">Todas</option>
                                {% for sede in sedes %}
                                    <option value=\"{{ sede.id }}\" {% if filtros.sede == sede.id %}selected{% endif %}>{{ sede.nombre }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class=\"col-md-3\">
                        <div class=\"form-group\">
                            <label for=\"estado\">Estado</label>
                            <select class=\"form-control\" id=\"estado\" name=\"estado\">
                                <option value=\"\">Todos</option>
                                <option value=\"1\" {% if filtros.estado == '1' %}selected{% endif %}>Activo</option>
                                <option value=\"0\" {% if filtros.estado == '0' %}selected{% endif %}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=\"row mt-3\">
                    <div class=\"col-12 d-flex gap-2\" style=\"padding-left: 2rem; padding-right: 2rem; padding-bottom: 2rem;\">
                        <button type=\"submit\" class=\"btn btn-primary\">
                            <i class=\"fas fa-filter\"></i> Aplicar Filtros
                        </button>
                        <a href=\"{{ app_url }}carreras\" class=\"btn btn-secondary\">
                            <i class=\"fas fa-times\"></i> Limpiar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de carreras -->
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3 d-flex justify-content-between align-items-center\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Listado de Carreras</h6>
        </div>
        <div class=\"card-body\">
            <div class=\"table-responsive\">
                <table class=\"table table-striped table-hover\">
                    <thead class=\"table-primary\">
                        <tr>
                            <th>Código(s)</th>
                            <th>Nombre</th>
                            <th>Tipo de Programa</th>
                            <th>Sede-Unidad</th>
                            <th class=\"text-center\">Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for carrera in carreras %}
                        <tr>
                            <td>{{ carrera.codigos_carrera|replace({',': '<br>'})|raw }}</td>
                            <td>{{ carrera.nombre }}</td>
                            <td>
                                {% if carrera.tipo_programa == 'P' %}
                                    Pregrado
                                {% elseif carrera.tipo_programa == 'G' %}
                                    Postgrado
                                {% elseif carrera.tipo_programa == 'O' %}
                                    Otro
                                {% else %}
                                    {{ carrera.tipo_programa }}
                                {% endif %}
                            </td>
                            <td>
                                {% set sedes = carrera.sedes|split(',') %}
                                {% set unidades = carrera.unidades|split(',') %}
                                {% for i in 0..sedes|length-1 %}
                                    {{ sedes[i] }} - {{ unidades[i] }}{% if not loop.last %}<br>{% endif %}
                                {% endfor %}
                            </td>
                            <td class=\"text-center\">
                                {% if carrera.estado == 1 %}
                                    <span class=\"badge bg-success\">Activo</span>
                                {% else %}
                                    <span class=\"badge bg-danger\">Inactivo</span>
                                {% endif %}
                            </td>
                            <td>
                                <div class=\"d-flex gap-2\">
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}\" class=\"btn btn-sm btn-info\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                    <a href=\"{{ app_url }}carreras/{{ carrera.id }}/edit\" class=\"btn btn-sm btn-warning\">
                                        <i class=\"fas fa-edit\"></i>
                                    </a>
                                    <form action=\"{{ app_url }}carreras/{{ carrera.id }}/delete\" method=\"POST\" class=\"d-inline delete-form\">
                                        <button type=\"submit\" class=\"btn btn-danger btn-sm\" title=\"Eliminar\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan=\"6\" class=\"text-center\">No se encontraron carreras</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    // Función para mostrar alertas
    function showAlert(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }

    // Mostrar alertas de sesión si existen
    {% if session.success %}
        showAlert('¡Éxito!', '{{ session.success }}', 'success');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('{{ app_url }}clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    {% endif %}

    {% if session.error %}
        showAlert('Error', '{{ session.error }}', 'error');
        // Limpiar el mensaje de sesión después de mostrarlo
        fetch('{{ app_url }}clear-session-messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    {% endif %}

    // Confirmación de eliminación con AJAX
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: \"Esta acción no se puede deshacer\",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('¡Éxito!', data.message, 'success');
                            // Eliminar la fila de la tabla
                            form.closest('tr').remove();
                        } else {
                            showAlert('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                    });
                }
            });
        });
    });
</script>
{% endblock %} ", "carreras/index.twig", "/var/www/html/biblioges/templates/carreras/index.twig");
    }
}
