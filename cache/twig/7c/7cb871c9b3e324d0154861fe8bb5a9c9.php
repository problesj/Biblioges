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

/* frontend/malla_grafica.twig */
class __TwigTemplate_d1fb95c49d93f67b7f22b17229e92a18 extends Template
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
        $this->parent = $this->loadTemplate("frontend/base.twig", "frontend/malla_grafica.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Malla Gráfica - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 3), "html", null, true);
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
        yield "<section class=\"container py-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2\">
        <div>
            <h2 class=\"mb-1\">Malla Gráfica</h2>
            <div class=\"text-muted\">
                ";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 11), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 11), "html", null, true);
        yield "
                ";
        // line 12
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencia_desde", [], "any", false, false, false, 12)) {
            // line 13
            yield "                    (Vigencia desde: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencia_desde", [], "any", false, false, false, 13), 0, 4), "html", null, true);
            yield ")
                ";
        }
        // line 15
        yield "            </div>
        </div>
        <div class=\"d-flex gap-2\">
            <button type=\"button\" class=\"btn btn-success\" id=\"btnDescargarMallaPng\">
                <i class=\"fas fa-download me-1\"></i> Descargar PNG
            </button>
            <button type=\"button\" class=\"btn btn-secondary\" id=\"btnCerrarMallaGrafica\">
                <i class=\"fas fa-times me-1\"></i> Cerrar
            </button>
        </div>
    </div>

    <div id=\"mallaGraficaContenedor\" class=\"p-2 bg-white border rounded\">
        <div class=\"malla-grafica-header\">
            <h5 class=\"mb-1\">";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 29), "html", null, true);
        yield "</h5>
            <small>";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "sede_nombre", [], "any", false, false, false, 30), "html", null, true);
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencia_desde", [], "any", false, false, false, 30)) {
            yield " | Vigencia desde ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "vigencia_desde", [], "any", false, false, false, 30), 0, 4), "html", null, true);
        }
        yield "</small>
        </div>
        <div id=\"mallaGraficaGrid\" class=\"malla-grafica-grid\">
            ";
        // line 33
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["asignaturas_por_semestre"] ?? null))) {
            // line 34
            yield "                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["asignaturas_por_semestre"] ?? null));
            foreach ($context['_seq'] as $context["semestre"] => $context["asignaturas"]) {
                // line 35
                yield "                    <div class=\"malla-semestre-col\">
                        <div class=\"malla-semestre-title\">Semestre ";
                // line 36
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["semestre"], "html", null, true);
                yield "</div>
                        ";
                // line 37
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["asignaturas"]);
                foreach ($context['_seq'] as $context["_key"] => $context["asignatura"]) {
                    // line 38
                    yield "                            <div class=\"malla-asignatura-item\">
                                <strong>";
                    // line 39
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "asignatura_nombre", [], "any", false, false, false, 39), "html", null, true);
                    yield "</strong>
                                ";
                    // line 40
                    if (CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigo_asignatura", [], "any", false, false, false, 40)) {
                        // line 41
                        yield "                                    <br><small>";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "codigo_asignatura", [], "any", false, false, false, 41), "html", null, true);
                        yield "</small>
                                ";
                    }
                    // line 43
                    yield "                                <span class=\"malla-asignatura-tipo\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace(((CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo_asignatura", [], "any", true, true, false, 43)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["asignatura"], "tipo_asignatura", [], "any", false, false, false, 43), "—")) : ("—")), ["_" => " "]), "html", null, true);
                    yield "</span>
                            </div>
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['asignatura'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 46
                yield "                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['semestre'], $context['asignaturas'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 48
            yield "            ";
        } else {
            // line 49
            yield "                <p class=\"text-muted m-0\">No hay asignaturas para graficar.</p>
            ";
        }
        // line 51
        yield "        </div>
    </div>
</section>

<style>
.malla-grafica-header {
    background: linear-gradient(90deg, #8b2f13 0%, #a83c16 100%);
    color: #fff;
    padding: 1rem 1.25rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}
.malla-grafica-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 0.75rem;
}
.malla-semestre-col {
    background: #fff;
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
    overflow: hidden;
}
.malla-semestre-title {
    background: #ef6c00;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding: 0.45rem 0.5rem;
    font-size: 0.82rem;
}
.malla-asignatura-item {
    margin: 0.4rem;
    background: #f2f4f8;
    border-radius: 0.35rem;
    border-left: 4px solid #8b2f13;
    padding: 0.45rem 0.5rem;
    font-size: 0.78rem;
    line-height: 1.2;
}
.malla-asignatura-tipo {
    display: block;
    color: #6c757d;
    font-size: 0.68rem;
    margin-top: 0.2rem;
}
</style>

<script src=\"https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js\"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnDescargarMallaPng = document.getElementById('btnDescargarMallaPng');
    const btnCerrarMallaGrafica = document.getElementById('btnCerrarMallaGrafica');
    const mallaGraficaContenedor = document.getElementById('mallaGraficaContenedor');
    let generandoPng = false;

    if (!btnDescargarMallaPng || !mallaGraficaContenedor) return;

    btnDescargarMallaPng.onclick = function () {
        if (generandoPng) return;
        generandoPng = true;
        btnDescargarMallaPng.disabled = true;

        html2canvas(mallaGraficaContenedor, { scale: 2, backgroundColor: '#ffffff' })
            .then(function (canvas) {
                const link = document.createElement('a');
                link.download = 'malla-grafica-";
        // line 118
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, ($context["carrera"] ?? null), "carrera_nombre", [], "any", false, false, false, 118), [" " => "-"])), "html", null, true);
        yield ".png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            })
            .finally(function () {
                generandoPng = false;
                btnDescargarMallaPng.disabled = false;
            });
    };

    if (btnCerrarMallaGrafica) {
        btnCerrarMallaGrafica.onclick = function () {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: 'cerrarModalMallaGrafica' }, '*');
                return;
            }
            window.close();
        };
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
        return "frontend/malla_grafica.twig";
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
        return array (  248 => 118,  179 => 51,  175 => 49,  172 => 48,  165 => 46,  155 => 43,  149 => 41,  147 => 40,  143 => 39,  140 => 38,  136 => 37,  132 => 36,  129 => 35,  124 => 34,  122 => 33,  112 => 30,  108 => 29,  92 => 15,  86 => 13,  84 => 12,  78 => 11,  71 => 6,  64 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'frontend/base.twig' %}

{% block title %}Malla Gráfica - {{ carrera.carrera_nombre }}{% endblock %}

{% block content %}
<section class=\"container py-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2\">
        <div>
            <h2 class=\"mb-1\">Malla Gráfica</h2>
            <div class=\"text-muted\">
                {{ carrera.carrera_nombre }} - {{ carrera.sede_nombre }}
                {% if carrera.vigencia_desde %}
                    (Vigencia desde: {{ carrera.vigencia_desde|slice(0, 4) }})
                {% endif %}
            </div>
        </div>
        <div class=\"d-flex gap-2\">
            <button type=\"button\" class=\"btn btn-success\" id=\"btnDescargarMallaPng\">
                <i class=\"fas fa-download me-1\"></i> Descargar PNG
            </button>
            <button type=\"button\" class=\"btn btn-secondary\" id=\"btnCerrarMallaGrafica\">
                <i class=\"fas fa-times me-1\"></i> Cerrar
            </button>
        </div>
    </div>

    <div id=\"mallaGraficaContenedor\" class=\"p-2 bg-white border rounded\">
        <div class=\"malla-grafica-header\">
            <h5 class=\"mb-1\">{{ carrera.carrera_nombre }}</h5>
            <small>{{ carrera.sede_nombre }}{% if carrera.vigencia_desde %} | Vigencia desde {{ carrera.vigencia_desde|slice(0, 4) }}{% endif %}</small>
        </div>
        <div id=\"mallaGraficaGrid\" class=\"malla-grafica-grid\">
            {% if asignaturas_por_semestre is not empty %}
                {% for semestre, asignaturas in asignaturas_por_semestre %}
                    <div class=\"malla-semestre-col\">
                        <div class=\"malla-semestre-title\">Semestre {{ semestre }}</div>
                        {% for asignatura in asignaturas %}
                            <div class=\"malla-asignatura-item\">
                                <strong>{{ asignatura.asignatura_nombre }}</strong>
                                {% if asignatura.codigo_asignatura %}
                                    <br><small>{{ asignatura.codigo_asignatura }}</small>
                                {% endif %}
                                <span class=\"malla-asignatura-tipo\">{{ asignatura.tipo_asignatura|default('—')|replace({'_':' '}) }}</span>
                            </div>
                        {% endfor %}
                    </div>
                {% endfor %}
            {% else %}
                <p class=\"text-muted m-0\">No hay asignaturas para graficar.</p>
            {% endif %}
        </div>
    </div>
</section>

<style>
.malla-grafica-header {
    background: linear-gradient(90deg, #8b2f13 0%, #a83c16 100%);
    color: #fff;
    padding: 1rem 1.25rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}
.malla-grafica-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 0.75rem;
}
.malla-semestre-col {
    background: #fff;
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
    overflow: hidden;
}
.malla-semestre-title {
    background: #ef6c00;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    text-align: center;
    padding: 0.45rem 0.5rem;
    font-size: 0.82rem;
}
.malla-asignatura-item {
    margin: 0.4rem;
    background: #f2f4f8;
    border-radius: 0.35rem;
    border-left: 4px solid #8b2f13;
    padding: 0.45rem 0.5rem;
    font-size: 0.78rem;
    line-height: 1.2;
}
.malla-asignatura-tipo {
    display: block;
    color: #6c757d;
    font-size: 0.68rem;
    margin-top: 0.2rem;
}
</style>

<script src=\"https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js\"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnDescargarMallaPng = document.getElementById('btnDescargarMallaPng');
    const btnCerrarMallaGrafica = document.getElementById('btnCerrarMallaGrafica');
    const mallaGraficaContenedor = document.getElementById('mallaGraficaContenedor');
    let generandoPng = false;

    if (!btnDescargarMallaPng || !mallaGraficaContenedor) return;

    btnDescargarMallaPng.onclick = function () {
        if (generandoPng) return;
        generandoPng = true;
        btnDescargarMallaPng.disabled = true;

        html2canvas(mallaGraficaContenedor, { scale: 2, backgroundColor: '#ffffff' })
            .then(function (canvas) {
                const link = document.createElement('a');
                link.download = 'malla-grafica-{{ carrera.carrera_nombre|replace({\" \":\"-\"})|lower }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            })
            .finally(function () {
                generandoPng = false;
                btnDescargarMallaPng.disabled = false;
            });
    };

    if (btnCerrarMallaGrafica) {
        btnCerrarMallaGrafica.onclick = function () {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: 'cerrarModalMallaGrafica' }, '*');
                return;
            }
            window.close();
        };
    }
});
</script>
{% endblock %}
", "frontend/malla_grafica.twig", "/var/www/html/biblioges/templates/frontend/malla_grafica.twig");
    }
}
