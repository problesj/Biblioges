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

/* reportes/cobertura/index.twig */
class __TwigTemplate_c6c8cb709ddd34d1ef391bd0a2bf7c90 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "reportes/cobertura/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Reporte de Cobertura";
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
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h3 class=\"card-title\">Reporte de Cobertura</h3>
                </div>
                <div class=\"card-body\">
                    ";
        // line 15
        yield "                    <p>Número de carreras: ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["carreras"] ?? null)), "html", null, true);
        yield "</p>

                    <form id=\"reporteForm\" method=\"post\" action=\"";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('url')->getCallable()("/biblioges/reportes/cobertura/generar-reporte"), "html", null, true);
        yield "\">
                        <div class=\"form-group\">
                            <label for=\"carrera\">Carrera</label>
                            <select class=\"form-control\" id=\"carrera\" name=\"carrera_id\" required>
                                <option value=\"\">Seleccione una carrera</option>
                                ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 23
            yield "                                    ";
            // line 24
            yield "                                    <!-- Debug: Carrera ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 24), "html", null, true);
            yield ": ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 24), "html", null, true);
            yield " -->
                                    <option value=\"";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "id", [], "any", false, false, false, 25), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 25), "html", null, true);
            yield "</option>
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
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        yield "                            </select>
                        </div>

                        <div class=\"form-group\">
                            <label>Asignaturas de Formación</label>
                            <div id=\"asignaturas-container\">
                                <p class=\"text-muted\">Seleccione una carrera para ver las asignaturas</p>
                            </div>
                        </div>

                        <button type=\"submit\" class=\"btn btn-primary\">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 46
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 47
        yield "<script>
\$(document).ready(function() {
    \$('#carrera').change(function() {
        var carreraId = \$(this).val();
        if (carreraId) {
            \$.get('";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('url')->getCallable()("/biblioges/reportes/cobertura/asignaturas-formacion/"), "html", null, true);
        yield "' + carreraId, function(asignaturas) {
                var container = \$('#asignaturas-container');
                container.empty();
                
                if (asignaturas.length > 0) {
                    asignaturas.forEach(function(asignatura) {
                        container.append(`
                            <div class=\"custom-control custom-checkbox\">
                                <input type=\"checkbox\" class=\"custom-control-input\" 
                                       id=\"asignatura_\${asignatura.id}\" 
                                       name=\"asignaturas[]\" 
                                       value=\"\${asignatura.id}\">
                                <label class=\"custom-control-label\" for=\"asignatura_\${asignatura.id}\">
                                    \${asignatura.nombre}
                                </label>
                            </div>
                        `);
                    });
                } else {
                    container.html('<p class=\"text-muted\">No hay asignaturas disponibles</p>');
                }
            });
        } else {
            \$('#asignaturas-container').html('<p class=\"text-muted\">Seleccione una carrera para ver las asignaturas</p>');
        }
    });

    \$('#reporteForm').submit(function(e) {
        e.preventDefault();
        
        var formData = \$(this).serialize();
        
        \$.post(\$(this).attr('action'), formData, function(response) {
            if (response.success) {
                window.location.href = response.file_url;
            } else {
                alert('Error al generar el reporte: ' + response.error);
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
        return "reportes/cobertura/index.twig";
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
        return array (  175 => 52,  168 => 47,  161 => 46,  139 => 27,  121 => 25,  114 => 24,  112 => 23,  95 => 22,  87 => 17,  81 => 15,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "reportes/cobertura/index.twig", "/var/www/html/biblioges/templates/reportes/cobertura/index.twig");
    }
}
