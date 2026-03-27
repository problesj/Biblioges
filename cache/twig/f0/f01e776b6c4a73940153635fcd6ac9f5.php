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

/* carreras/importar.twig */
class __TwigTemplate_6188f23f58c36be6c7eeda443521924d extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/importar.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Importar carrera - Biblioges";
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
        <h1 class=\"h3 mb-0 text-gray-800\">Importar carrera desde Excel</h1>
        <a href=\"";
        // line 9
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras\" class=\"btn btn-secondary\"><i class=\"fas fa-arrow-left\"></i> Volver al listado</a>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Archivo y tipo de importación</h6>
        </div>
        <div class=\"card-body\">
            <p class=\"text-muted\">
                El archivo debe seguir el formato de malla (columnas: CODIGO_PROGRAMA, NOMBRE_PROGRAMA, NIVEL, INICIO_VIGENCIA,
                TERMINO_VIGENCIA, SEDE, unidad de carrera, semestre, códigos y tipos de asignatura, etc.).
                El archivo se guardará en el servidor con fecha y hora en el nombre.
            </p>
            <form method=\"post\" action=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/importar/previsualizar\" enctype=\"multipart/form-data\" id=\"form_importar_carrera\">
                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label class=\"form-label\">Archivo Excel (.xlsx) *</label>
                        <input type=\"file\" name=\"archivo_excel\" class=\"form-control\" accept=\".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\" required>
                    </div>
                    <div class=\"col-md-6 mb-3\">
                        <label class=\"form-label\">Tipo *</label>
                        <select name=\"modo_importacion\" id=\"modo_importacion\" class=\"form-select\" required>
                            <option value=\"nueva\">Carrera con plan nuevo (crea carrera y malla completa)</option>
                            <option value=\"espejo\">Carrera espejo (asocia a carrera vigente y mapea códigos por sede)</option>
                        </select>
                    </div>
                </div>
                <div class=\"row mb-3\" id=\"bloque_carrera_referencia\" style=\"display: none;\">
                    <div class=\"col-md-8\">
                        <label class=\"form-label\">Carrera vigente a asociar (espejo)</label>
                        <select name=\"carrera_espejo_id\" id=\"carrera_espejo_id\" class=\"form-select\">
                            <option value=\"\">— Seleccione —</option>
                            ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras_activas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 42
            yield "                                <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["c"], "carrera_id", [], "any", false, false, false, 42), "html", null, true);
            yield "\">
                                    ";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["c"], "codigo_carrera", [], "any", false, false, false, 43), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["c"], "nombre", [], "any", false, false, false, 43), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["c"], "vigencia_desde", [], "any", false, false, false, 43), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["c"], "vigencia_hasta", [], "any", false, false, false, 43), "html", null, true);
            yield "
                                </option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['c'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        yield "                        </select>
                    </div>
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">
                    <i class=\"fas fa-search\"></i> Generar informe previo
                </button>
            </form>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 58
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 59
        yield "<script>
function actualizarModoEspejo() {
    const modo = document.getElementById('modo_importacion').value;
    const bloque = document.getElementById('bloque_carrera_referencia');
    const sel = document.getElementById('carrera_espejo_id');
    bloque.style.display = modo === 'espejo' ? 'block' : 'none';
    if (sel) sel.required = modo === 'espejo';
}
document.getElementById('modo_importacion').addEventListener('change', actualizarModoEspejo);
actualizarModoEspejo();
document.getElementById('form_importar_carrera').addEventListener('submit', function (e) {
    const modo = document.getElementById('modo_importacion').value;
    const sel = document.getElementById('carrera_espejo_id');
    if (modo === 'espejo' && sel && !sel.value) {
        e.preventDefault();
        alert('Seleccione la carrera vigente a la que se asociará el espejo.');
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
        return "carreras/importar.twig";
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
        return array (  160 => 59,  153 => 58,  138 => 46,  123 => 43,  118 => 42,  114 => 41,  92 => 22,  76 => 9,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Importar carrera - Biblioges{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Importar carrera desde Excel</h1>
        <a href=\"{{ app_url }}carreras\" class=\"btn btn-secondary\"><i class=\"fas fa-arrow-left\"></i> Volver al listado</a>
    </div>

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Archivo y tipo de importación</h6>
        </div>
        <div class=\"card-body\">
            <p class=\"text-muted\">
                El archivo debe seguir el formato de malla (columnas: CODIGO_PROGRAMA, NOMBRE_PROGRAMA, NIVEL, INICIO_VIGENCIA,
                TERMINO_VIGENCIA, SEDE, unidad de carrera, semestre, códigos y tipos de asignatura, etc.).
                El archivo se guardará en el servidor con fecha y hora en el nombre.
            </p>
            <form method=\"post\" action=\"{{ app_url }}carreras/importar/previsualizar\" enctype=\"multipart/form-data\" id=\"form_importar_carrera\">
                <div class=\"row\">
                    <div class=\"col-md-6 mb-3\">
                        <label class=\"form-label\">Archivo Excel (.xlsx) *</label>
                        <input type=\"file\" name=\"archivo_excel\" class=\"form-control\" accept=\".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\" required>
                    </div>
                    <div class=\"col-md-6 mb-3\">
                        <label class=\"form-label\">Tipo *</label>
                        <select name=\"modo_importacion\" id=\"modo_importacion\" class=\"form-select\" required>
                            <option value=\"nueva\">Carrera con plan nuevo (crea carrera y malla completa)</option>
                            <option value=\"espejo\">Carrera espejo (asocia a carrera vigente y mapea códigos por sede)</option>
                        </select>
                    </div>
                </div>
                <div class=\"row mb-3\" id=\"bloque_carrera_referencia\" style=\"display: none;\">
                    <div class=\"col-md-8\">
                        <label class=\"form-label\">Carrera vigente a asociar (espejo)</label>
                        <select name=\"carrera_espejo_id\" id=\"carrera_espejo_id\" class=\"form-select\">
                            <option value=\"\">— Seleccione —</option>
                            {% for c in carreras_activas %}
                                <option value=\"{{ c.carrera_id }}\">
                                    {{ c.codigo_carrera }} - {{ c.nombre }} - {{ c.vigencia_desde }} - {{ c.vigencia_hasta }}
                                </option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">
                    <i class=\"fas fa-search\"></i> Generar informe previo
                </button>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
function actualizarModoEspejo() {
    const modo = document.getElementById('modo_importacion').value;
    const bloque = document.getElementById('bloque_carrera_referencia');
    const sel = document.getElementById('carrera_espejo_id');
    bloque.style.display = modo === 'espejo' ? 'block' : 'none';
    if (sel) sel.required = modo === 'espejo';
}
document.getElementById('modo_importacion').addEventListener('change', actualizarModoEspejo);
actualizarModoEspejo();
document.getElementById('form_importar_carrera').addEventListener('submit', function (e) {
    const modo = document.getElementById('modo_importacion').value;
    const sel = document.getElementById('carrera_espejo_id');
    if (modo === 'espejo' && sel && !sel.value) {
        e.preventDefault();
        alert('Seleccione la carrera vigente a la que se asociará el espejo.');
    }
});
</script>
{% endblock %}
", "carreras/importar.twig", "/var/www/html/biblioges/templates/carreras/importar.twig");
    }
}
