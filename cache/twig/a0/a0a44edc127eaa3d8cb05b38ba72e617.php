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

/* carreras/importar_previsualizar.twig */
class __TwigTemplate_97091f5a08e4c295112dc2beb9faec39 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "carreras/importar_previsualizar.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Informe importación carrera - Biblioges";
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
        $context["puede_importar"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "puede_ejecutar", [], "any", true, true, false, 6)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "puede_ejecutar", [], "any", false, false, false, 6), false)) : (false));
        // line 7
        yield "<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Informe previo de importación</h1>
        <a href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/importar\" class=\"btn btn-outline-secondary\"><i class=\"fas fa-arrow-left\"></i> Volver</a>
    </div>

    <div class=\"alert alert-light border\">
        <strong>Archivo guardado:</strong> ";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["archivo_guardado"] ?? null), "html", null, true);
        yield "<br>
        <span class=\"text-muted\">Original: ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["archivo_original"] ?? null), "html", null, true);
        yield "</span>
    </div>

    <div id=\"resultado_importacion\" class=\"mb-3\" style=\"display:none;\"></div>

    ";
        // line 20
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "errores", [], "any", false, false, false, 20))) {
            // line 21
            yield "    <div class=\"alert alert-danger\">
        <h6 class=\"alert-heading\">Errores globales (bloquean toda la importación)</h6>
        <ul class=\"mb-0\">
            ";
            // line 24
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "errores", [], "any", false, false, false, 24));
            foreach ($context['_seq'] as $context["_key"] => $context["e"]) {
                yield "<li>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["e"], "html", null, true);
                yield "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['e'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 25
            yield "        </ul>
    </div>
    ";
        }
        // line 28
        yield "
    ";
        // line 29
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "errores_detalle", [], "any", false, false, false, 29))) {
            // line 30
            yield "    <div class=\"card border-danger mb-4\">
        <div class=\"card-header bg-danger text-white py-2\">
            <strong>Errores por fila (se omiten esas asignaturas, el resto sí puede importarse)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 260px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Fila</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 46
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "errores_detalle", [], "any", false, false, false, 46));
            foreach ($context['_seq'] as $context["_key"] => $context["err"]) {
                // line 47
                yield "                        <tr>
                            <td>";
                // line 48
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["err"], "fila", [], "any", true, true, false, 48)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["err"], "fila", [], "any", false, false, false, 48), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 49
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["err"], "codigo", [], "any", true, true, false, 49)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["err"], "codigo", [], "any", false, false, false, 49), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 50
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["err"], "tipo", [], "any", true, true, false, 50)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["err"], "tipo", [], "any", false, false, false, 50), "fila")) : ("fila")), "html", null, true);
                yield "</td>
                            <td>";
                // line 51
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["err"], "motivo", [], "any", true, true, false, 51)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["err"], "motivo", [], "any", false, false, false, 51), "Error de validación")) : ("Error de validación")), "html", null, true);
                yield "</td>
                        </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['err'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 54
            yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ";
        }
        // line 60
        yield "
    ";
        // line 61
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "advertencias", [], "any", false, false, false, 61))) {
            // line 62
            yield "    <div class=\"alert alert-warning\">
        <h6 class=\"alert-heading\">Advertencias</h6>
        <ul class=\"mb-0\">
            ";
            // line 65
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "advertencias", [], "any", false, false, false, 65));
            foreach ($context['_seq'] as $context["_key"] => $context["a"]) {
                yield "<li>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["a"], "html", null, true);
                yield "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['a'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 66
            yield "        </ul>
    </div>
    ";
        }
        // line 69
        yield "
    ";
        // line 70
        if ((array_key_exists("error_unidades", $context) && ($context["error_unidades"] ?? null))) {
            // line 71
            yield "    <div class=\"alert alert-danger\">
        <i class=\"fas fa-exclamation-triangle\"></i> ";
            // line 72
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error_unidades"] ?? null), "html", null, true);
            yield "
    </div>
    ";
        }
        // line 75
        yield "
    ";
        // line 76
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "unidades_por_crear", [], "any", false, false, false, 76))) {
            // line 77
            yield "    <div class=\"card border-warning mb-4\">
        <div class=\"card-header bg-warning\">
            <strong>Unidades faltantes detectadas (se crearán al confirmar)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 220px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Tipo</th>
                            <th>Fila</th>
                            <th>Código unidad</th>
                            <th>Nombre unidad</th>
                            <th>Sede</th>
                            <th>Código asignatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 95
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "unidades_por_crear", [], "any", false, false, false, 95));
            foreach ($context['_seq'] as $context["_key"] => $context["u"]) {
                // line 96
                yield "                        <tr>
                            <td>";
                // line 97
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "tipo", [], "any", false, false, false, 97), "html", null, true);
                yield "</td>
                            <td>";
                // line 98
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "fila", [], "any", false, false, false, 98), "html", null, true);
                yield "</td>
                            <td>";
                // line 99
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_unidad", [], "any", true, true, false, 99)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_unidad", [], "any", false, false, false, 99), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 100
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "nombre_unidad", [], "any", true, true, false, 100)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "nombre_unidad", [], "any", false, false, false, 100), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 101
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "sede_id", [], "any", true, true, false, 101)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "sede_id", [], "any", false, false, false, 101), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 102
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_asignatura", [], "any", true, true, false, 102)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_asignatura", [], "any", false, false, false, 102), "—")) : ("—")), "html", null, true);
                yield "</td>
                        </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['u'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ";
        }
        // line 111
        yield "
    ";
        // line 112
        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "equivalencias_unidades", [], "any", false, false, false, 112))) {
            // line 113
            yield "    <div class=\"card border-info mb-4\">
        <div class=\"card-header bg-info text-white py-2\">
            <strong>Trazabilidad de equivalencias de unidades (Excel → tabla unidades)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 240px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Tipo</th>
                            <th>Fila</th>
                            <th>Sede</th>
                            <th>Código Asig.</th>
                            <th>Excel: cod</th>
                            <th>Excel: nombre</th>
                            <th>Equiv.: cod</th>
                            <th>Equiv.: nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 133
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "equivalencias_unidades", [], "any", false, false, false, 133));
            foreach ($context['_seq'] as $context["_key"] => $context["eq"]) {
                // line 134
                yield "                        <tr>
                            <td>";
                // line 135
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "tipo", [], "any", true, true, false, 135)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "tipo", [], "any", false, false, false, 135), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 136
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "fila", [], "any", true, true, false, 136)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "fila", [], "any", false, false, false, 136), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 137
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "sede_id", [], "any", true, true, false, 137)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "sede_id", [], "any", false, false, false, 137), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 138
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "codigo_asignatura", [], "any", true, true, false, 138)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "codigo_asignatura", [], "any", false, false, false, 138), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 139
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "excel_codigo", [], "any", true, true, false, 139)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "excel_codigo", [], "any", false, false, false, 139), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 140
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "excel_nombre", [], "any", true, true, false, 140)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "excel_nombre", [], "any", false, false, false, 140), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 141
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "equiv_codigo", [], "any", true, true, false, 141)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "equiv_codigo", [], "any", false, false, false, 141), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 142
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "equiv_nombre", [], "any", true, true, false, 142)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["eq"], "equiv_nombre", [], "any", false, false, false, 142), "—")) : ("—")), "html", null, true);
                yield "</td>
                        </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['eq'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 145
            yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ";
        }
        // line 151
        yield "
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\"><h6 class=\"m-0 font-weight-bold text-primary\">Resumen</h6></div>
        <div class=\"card-body\">
            <div class=\"alert alert-info py-2 mb-3\">
                <small>
                    <i class=\"fas fa-info-circle\"></i>
                    Regla aplicada: toda asignatura de formación cuyo código comience con <strong>UN</strong>
                    se considera <strong>asignatura electiva padre</strong>. Sus asignaturas hijas se toman desde
                    <code>CODIGO_ASIGNATURA_1</code>, <code>NOMBRE_ASIGNATURA_1</code>,
                    <code>COD_UNIDAD_FORMACION</code> y <code>UNIDAD_FORMACION</code>.
                </small>
            </div>
            <dl class=\"row mb-0\">
                <dt class=\"col-sm-3\">Estado</dt>
                <dd class=\"col-sm-9\">
                    ";
        // line 167
        if (($context["puede_importar"] ?? null)) {
            // line 168
            yield "                        <span class=\"badge bg-success\">Listo para confirmar</span>
                    ";
        } else {
            // line 170
            yield "                        <span class=\"badge bg-danger\">Bloqueado: hay errores que deben corregirse</span>
                    ";
        }
        // line 172
        yield "                </dd>
                <dt class=\"col-sm-3\">Modo</dt><dd class=\"col-sm-9\">";
        // line 173
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 173), "modo", [], "any", false, false, false, 173), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Código programa</dt><dd class=\"col-sm-9\">";
        // line 174
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 174), "codigo_programa", [], "any", false, false, false, 174), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Nombre programa</dt><dd class=\"col-sm-9\">";
        // line 175
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 175), "nombre_programa", [], "any", false, false, false, 175), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Tipo programa</dt><dd class=\"col-sm-9\">";
        // line 176
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 176), "tipo_programa", [], "any", false, false, false, 176), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Vigencia</dt><dd class=\"col-sm-9\">";
        // line 177
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 177), "inicio_vigencia", [], "any", false, false, false, 177), "html", null, true);
        yield " → ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 177), "termino_vigencia", [], "any", false, false, false, 177), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Sede</dt><dd class=\"col-sm-9\">";
        // line 178
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 178), "sede", [], "any", false, false, false, 178), "html", null, true);
        yield " ";
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 178), "sede_id", [], "any", false, false, false, 178)) {
            yield "(id ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 178), "sede_id", [], "any", false, false, false, 178), "html", null, true);
            yield ")";
        }
        yield "</dd>
                <dt class=\"col-sm-3\">Unidad carrera</dt><dd class=\"col-sm-9\">";
        // line 179
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 179), "unidad_carrera_id", [], "any", false, false, false, 179)) {
            yield "id ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 179), "unidad_carrera_id", [], "any", false, false, false, 179), "html", null, true);
        } else {
            yield "—";
        }
        yield "</dd>
                <dt class=\"col-sm-3\">Filas Excel</dt><dd class=\"col-sm-9\">";
        // line 180
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 180), "filas_excel", [], "any", false, false, false, 180), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Filas malla distintas</dt><dd class=\"col-sm-9\">";
        // line 181
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 181), "filas_malla_distintas", [], "any", false, false, false, 181), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Filas importables</dt><dd class=\"col-sm-9\">";
        // line 182
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 182), "filas_importables", [], "any", true, true, false, 182)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 182), "filas_importables", [], "any", false, false, false, 182), 0)) : (0)), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Filas con conflicto</dt><dd class=\"col-sm-9\">";
        // line 183
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 183), "filas_con_conflicto", [], "any", true, true, false, 183)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 183), "filas_con_conflicto", [], "any", false, false, false, 183), 0)) : (0)), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Equivalencias de unidades</dt><dd class=\"col-sm-9\">";
        // line 184
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 184), "equivalencias_unidades_total", [], "any", true, true, false, 184)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 184), "equivalencias_unidades_total", [], "any", false, false, false, 184), 0)) : (0)), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Vigencias previas a cerrar</dt><dd class=\"col-sm-9\">";
        // line 185
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 185), "vigencias_previas_a_cerrar", [], "any", true, true, false, 185)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 185), "vigencias_previas_a_cerrar", [], "any", false, false, false, 185), 0)) : (0)), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Carreras previas relacionadas</dt><dd class=\"col-sm-9\">";
        // line 186
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 186), "carreras_previas_relacionadas", [], "any", true, true, false, 186)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 186), "carreras_previas_relacionadas", [], "any", false, false, false, 186), 0)) : (0)), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Máx. semestre</dt><dd class=\"col-sm-9\">";
        // line 187
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 187), "max_semestre", [], "any", false, false, false, 187), "html", null, true);
        yield "</dd>
                <dt class=\"col-sm-3\">Relaciones formación (filas)</dt><dd class=\"col-sm-9\">";
        // line 188
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 188), "filas_relacion_formacion", [], "any", false, false, false, 188), "html", null, true);
        yield "</dd>
                ";
        // line 189
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 189), "modo", [], "any", false, false, false, 189) == "nueva")) {
            // line 190
            yield "                <dt class=\"col-sm-3\">Asignaturas</dt><dd class=\"col-sm-9\">
                    Códigos únicos: ";
            // line 191
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 191), "asignaturas_codigos_unicos", [], "any", true, true, false, 191)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 191), "asignaturas_codigos_unicos", [], "any", false, false, false, 191), "—")) : ("—")), "html", null, true);
            yield ",
                    existentes en BD: ";
            // line 192
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 192), "asignaturas_existentes_bd", [], "any", true, true, false, 192)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 192), "asignaturas_existentes_bd", [], "any", false, false, false, 192), "—")) : ("—")), "html", null, true);
            yield ",
                    nuevas: ";
            // line 193
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 193), "asignaturas_nuevas", [], "any", true, true, false, 193)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 193), "asignaturas_nuevas", [], "any", false, false, false, 193), "—")) : ("—")), "html", null, true);
            yield "
                </dd>
                ";
        }
        // line 196
        yield "                ";
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 196), "modo", [], "any", false, false, false, 196) == "espejo")) {
            // line 197
            yield "                <dt class=\"col-sm-3\">Carrera referencia</dt><dd class=\"col-sm-9\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 197), "carrera_referencia", [], "any", true, true, false, 197)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 197), "carrera_referencia", [], "any", false, false, false, 197), "—")) : ("—")), "html", null, true);
            yield " (id ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 197), "carrera_referencia_id", [], "any", true, true, false, 197)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 197), "carrera_referencia_id", [], "any", false, false, false, 197), "—")) : ("—")), "html", null, true);
            yield ")</dd>
                <dt class=\"col-sm-3\">Códigos ya en deptos.</dt><dd class=\"col-sm-9\">";
            // line 198
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 198), "espejo_filas_codigo_ya_en_sede", [], "any", true, true, false, 198)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 198), "espejo_filas_codigo_ya_en_sede", [], "any", false, false, false, 198), 0)) : (0)), "html", null, true);
            yield " <span class=\"text-muted small\">(único en BD)</span></dd>
                <dt class=\"col-sm-3\">Fusión recomendada</dt><dd class=\"col-sm-9\">";
            // line 199
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, true, false, 199), "espejo_filas_fusion_recomendada", [], "any", true, true, false, 199)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 199), "espejo_filas_fusion_recomendada", [], "any", false, false, false, 199), 0)) : (0)), "html", null, true);
            yield " <span class=\"text-muted small\">(id referencia ≠ id ya cargado en sede)</span></dd>
                ";
        }
        // line 201
        yield "            </dl>
        </div>
    </div>

    ";
        // line 205
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "recomendaciones_fusion", [], "any", true, true, false, 205) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "recomendaciones_fusion", [], "any", false, false, false, 205)))) {
            // line 206
            yield "    <div class=\"card border-primary mb-4\">
        <div class=\"card-header bg-primary text-white py-2\">
            <strong>Recomendación: fusionar asignaturas al editar la malla</strong>
        </div>
        <div class=\"card-body\">
            <p class=\"small text-muted mb-2\">
                El código del Excel ya está cargado en departamentos (código único en BD) con un <code>asignatura_id</code> distinto al que corresponde por nombre en la carrera de referencia.
                La importación <strong>agregará la asignatura a la malla</strong> usando el id ya existente en sede. Luego, en la edición de malla del sistema conviene <strong>fusionar</strong> esos registros para unificar bibliografías y datos.
            </p>
            <div class=\"table-responsive\" style=\"max-height: 280px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Fila</th>
                            <th>Código Excel</th>
                            <th>Nombre Excel</th>
                            <th>Sem.</th>
                            <th>Id (nombre ref.)</th>
                            <th>Nombre referencia</th>
                            <th>Id (código en sede)</th>
                            <th>Nombre en BD sede</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 230
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "recomendaciones_fusion", [], "any", false, false, false, 230));
            foreach ($context['_seq'] as $context["_key"] => $context["rf"]) {
                // line 231
                yield "                        <tr>
                            <td>";
                // line 232
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "fila", [], "any", false, false, false, 232), "html", null, true);
                yield "</td>
                            <td>";
                // line 233
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "codigo_excel", [], "any", false, false, false, 233), "html", null, true);
                yield "</td>
                            <td>";
                // line 234
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_excel", [], "any", true, true, false, 234)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_excel", [], "any", false, false, false, 234), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 235
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "semestre", [], "any", false, false, false, 235), "html", null, true);
                yield "</td>
                            <td>";
                // line 236
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "asignatura_id_por_nombre_referencia", [], "any", false, false, false, 236), "html", null, true);
                yield "</td>
                            <td><small>";
                // line 237
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_por_referencia", [], "any", true, true, false, 237)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_por_referencia", [], "any", false, false, false, 237), "—")) : ("—")), "html", null, true);
                yield "</small></td>
                            <td>";
                // line 238
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "asignatura_id_codigo_en_sede", [], "any", false, false, false, 238), "html", null, true);
                yield "</td>
                            <td><small>";
                // line 239
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_en_bd_sede", [], "any", true, true, false, 239)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["rf"], "nombre_en_bd_sede", [], "any", false, false, false, 239), "—")) : ("—")), "html", null, true);
                yield "</small></td>
                        </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['rf'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 242
            yield "                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ";
        }
        // line 248
        yield "
    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\"><h6 class=\"m-0 font-weight-bold text-primary\">Detalle malla / equivalencias</h6></div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 420px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            ";
        // line 256
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 256), "modo", [], "any", false, false, false, 256) == "espejo")) {
            // line 257
            yield "                            <th>Fila</th><th>Código Excel</th><th>Sem.</th><th>Equiv. id</th><th>Equiv. nombre</th><th>En sede</th><th>Malla id</th><th>Fusión</th><th>Método / nota</th>
                            ";
        } else {
            // line 259
            yield "                            <th>Fila</th><th>Código</th><th>Sem.</th><th>Nombre</th><th>En BD</th>
                            ";
        }
        // line 261
        yield "                        </tr>
                    </thead>
                    <tbody>
                        ";
        // line 264
        $context["max_filas"] = 80;
        // line 265
        yield "                        ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "informe_malla", [], "any", false, false, false, 265), 0, ($context["max_filas"] ?? null)));
        foreach ($context['_seq'] as $context["_key"] => $context["linea"]) {
            // line 266
            yield "                        <tr>
                            ";
            // line 267
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "resumen", [], "any", false, false, false, 267), "modo", [], "any", false, false, false, 267) == "espejo")) {
                // line 268
                yield "                            <td>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "fila", [], "any", false, false, false, 268), "html", null, true);
                yield "</td>
                            <td>";
                // line 269
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo_excel", [], "any", false, false, false, 269), "html", null, true);
                yield "</td>
                            <td>";
                // line 270
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "semestre", [], "any", false, false, false, 270), "html", null, true);
                yield "</td>
                            <td>";
                // line 271
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", true, true, false, 271)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", false, false, false, 271), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>";
                // line 272
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_nombre", [], "any", true, true, false, 272)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_nombre", [], "any", false, false, false, 272), "—")) : ("—")), "html", null, true);
                yield "</td>
                            <td>
                                ";
                // line 274
                if (((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo_ya_en_sede", [], "any", true, true, false, 274)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo_ya_en_sede", [], "any", false, false, false, 274), false)) : (false))) {
                    // line 275
                    yield "                                    <span class=\"badge bg-secondary\">sí</span>
                                    ";
                    // line 276
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo_en_misma_sede", [], "any", true, true, false, 276) && CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo_en_misma_sede", [], "any", false, false, false, 276))) {
                        yield "<span class=\"badge bg-light text-dark border\">misma sede</span>";
                    }
                    // line 277
                    yield "                                ";
                } else {
                    yield "—";
                }
                // line 278
                yield "                            </td>
                            <td>";
                // line 279
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "malla_usara_asignatura_id", [], "any", true, true, false, 279)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "malla_usara_asignatura_id", [], "any", false, false, false, 279), ((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", true, true, false, 279)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", false, false, false, 279), "—")) : ("—")))) : (((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", true, true, false, 279)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "equivalente_id", [], "any", false, false, false, 279), "—")) : ("—")))), "html", null, true);
                yield "</td>
                            <td>";
                // line 280
                if (((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "fusion_recomendada", [], "any", true, true, false, 280)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "fusion_recomendada", [], "any", false, false, false, 280), false)) : (false))) {
                    yield "<span class=\"badge bg-warning text-dark\">revisar</span>";
                } else {
                    yield "—";
                }
                yield "</td>
                            <td><small>";
                // line 281
                if (CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "nota_malla", [], "any", false, false, false, 281)) {
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "nota_malla", [], "any", false, false, false, 281), "html", null, true);
                    yield "<br>";
                }
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "metodo", [], "any", true, true, false, 281)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "metodo", [], "any", false, false, false, 281), "")) : ("")), "html", null, true);
                yield "</small></td>
                            ";
            } else {
                // line 283
                yield "                            <td>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "fila", [], "any", false, false, false, 283), "html", null, true);
                yield "</td>
                            <td>";
                // line 284
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "codigo", [], "any", false, false, false, 284), "html", null, true);
                yield "</td>
                            <td>";
                // line 285
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "semestre", [], "any", false, false, false, 285), "html", null, true);
                yield "</td>
                            <td>";
                // line 286
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "nombre", [], "any", false, false, false, 286), "html", null, true);
                yield "</td>
                            <td>
                                ";
                // line 288
                if (((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "asignatura_en_bd", [], "any", true, true, false, 288)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "asignatura_en_bd", [], "any", false, false, false, 288), false)) : (false))) {
                    // line 289
                    yield "                                    <span class=\"badge bg-info text-dark\">Ya existe</span>
                                    ";
                    // line 290
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "asignatura_id_existente", [], "any", true, true, false, 290) && CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "asignatura_id_existente", [], "any", false, false, false, 290))) {
                        yield "<small class=\"text-muted\">id ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["linea"], "asignatura_id_existente", [], "any", false, false, false, 290), "html", null, true);
                        yield "</small>";
                    }
                    // line 291
                    yield "                                ";
                } else {
                    // line 292
                    yield "                                    <span class=\"badge bg-success\">Nueva</span>
                                ";
                }
                // line 294
                yield "                            </td>
                            ";
            }
            // line 296
            yield "                        </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['linea'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 298
        yield "                    </tbody>
                </table>
            </div>
            ";
        // line 301
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "informe_malla", [], "any", false, false, false, 301)) > ($context["max_filas"] ?? null))) {
            // line 302
            yield "            <div class=\"p-2 text-muted small\">Mostrando las primeras ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["max_filas"] ?? null), "html", null, true);
            yield " filas de ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "informe_malla", [], "any", false, false, false, 302)), "html", null, true);
            yield ".</div>
            ";
        }
        // line 304
        yield "        </div>
    </div>

    <div class=\"card border-secondary mb-3\">
        <div class=\"card-body py-3\">
            <div class=\"d-flex flex-wrap align-items-center gap-3\">
                <form method=\"post\" action=\"";
        // line 310
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/importar/confirmar\" class=\"d-inline mb-0\"
                      id=\"form_confirmar_importacion\"
                      onsubmit=\"if (this.querySelector('[type=submit]').disabled) { return false; } return confirmarImportacionConUnidades(this);\">
                    <input type=\"hidden\" name=\"import_token\" value=\"";
        // line 313
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["import_token"] ?? null), "html", null, true);
        yield "\">
                    <input type=\"hidden\" name=\"confirmar_creacion_unidades\" id=\"confirmar_creacion_unidades\" value=\"0\">
                    <button type=\"submit\" class=\"btn btn-success btn-lg\"
                            id=\"btn_confirmar_importacion\"
                            ";
        // line 317
        if ( !($context["puede_importar"] ?? null)) {
            yield "disabled title=\"Corrija los errores del informe para poder confirmar\" aria-disabled=\"true\"";
        }
        yield ">
                        <i class=\"fas fa-check\"></i> Confirmar importación
                    </button>
                </form>
                <form method=\"post\" action=\"";
        // line 321
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "carreras/importar/cancelar\" class=\"d-inline mb-0\">
                    <button type=\"submit\" class=\"btn btn-outline-danger btn-lg\"><i class=\"fas fa-times\"></i> Cancelar importación</button>
                </form>
            </div>
            ";
        // line 325
        if ( !($context["puede_importar"] ?? null)) {
            // line 326
            yield "            <p class=\"text-danger small mb-0 mt-3\">
                <i class=\"fas fa-info-circle\"></i>
                Si hay errores globales o no quedaron filas importables, el botón se deshabilita.
                Corrige el archivo y vuelve a generar el informe previo.
            </p>
            ";
        }
        // line 332
        yield "        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 337
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 338
        yield "<script>
const APP_URL_BASE = \"";
        // line 339
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "\";

function confirmarImportacionConUnidades(formEl) {
    const requiereUnidades = ";
        // line 342
        yield (( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "unidades_por_crear", [], "any", false, false, false, 342))) ? ("true") : ("false"));
        yield ";

    if (!requiereUnidades) {
        Swal.fire({
            title: 'Confirmar importación',
            text: '¿Confirma aplicar la importación en la base de datos? Esta acción no se puede deshacer automáticamente.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
        }).then((result) => {
            if (!result.isConfirmed) return;
            const input = document.getElementById('confirmar_creacion_unidades');
            if (input) input.value = '0';
            ejecutarImportacionAjax(formEl);
        });
        return false;
    }

    // Requiere creación de unidades
    const total = ";
        // line 363
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "unidades_por_crear", [], "any", false, false, false, 363)), "html", null, true);
        yield ";
    const unidadesHtml = `
        <p>Se detectaron <b>\${total}</b> unidad(es) faltante(s).</p>
        <p>Se crearán para continuar la importación.</p>
        <div style=\"max-height: 220px; overflow:auto; text-align:left;\">
            <ul class=\"mb-0\">
                ";
        // line 369
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["prev"] ?? null), "unidades_por_crear", [], "any", false, false, false, 369));
        foreach ($context['_seq'] as $context["_key"] => $context["u"]) {
            // line 370
            yield "                    <li>
                        <b>";
            // line 371
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "tipo", [], "any", false, false, false, 371), "html", null, true);
            yield "</b>:
                        ";
            // line 372
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_unidad", [], "any", true, true, false, 372)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "codigo_unidad", [], "any", false, false, false, 372), "—")) : ("—")), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["u"], "nombre_unidad", [], "any", true, true, false, 372)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["u"], "nombre_unidad", [], "any", false, false, false, 372), "—")) : ("—")), "html", null, true);
            yield "
                    </li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['u'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 375
        yield "            </ul>
        </div>
    `;

    Swal.fire({
        title: 'Crear unidades faltantes y continuar',
        html: unidadesHtml,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Crear y continuar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        width: '720px',
    }).then((result) => {
        if (!result.isConfirmed) return;
        const input = document.getElementById('confirmar_creacion_unidades');
        if (input) input.value = '1';
        ejecutarImportacionAjax(formEl);
    });

    return false;
}

function setProgress(percent, text) {
    const bar = document.getElementById('progress_importacion_bar');
    const label = document.getElementById('progress_importacion_text');
    if (bar) {
        bar.style.width = percent + '%';
        bar.setAttribute('aria-valuenow', String(percent));
        bar.textContent = percent + '%';
    }
    if (label) label.textContent = text;
}

async function ejecutarImportacionAjax(formEl) {
    const modalEl = document.getElementById('modal_progreso_importacion');
    const modal = new bootstrap.Modal(modalEl, {backdrop: 'static', keyboard: false});
    const btn = document.getElementById('btn_confirmar_importacion');
    if (btn) btn.disabled = true;
    modal.show();

    setProgress(10, 'Iniciando importación...');

    // avance visual mientras espera respuesta
    let p = 15;
    const timer = setInterval(() => {
        p = Math.min(90, p + 5);
        setProgress(p, 'Procesando datos en el servidor...');
    }, 700);

    try {
        const fd = new FormData(formEl);
        const resp = await fetch(formEl.action, {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        });
        const data = await resp.json();
        clearInterval(timer);

        if (!resp.ok || !data.success) {
            setProgress(100, 'Importación finalizada con error');
            mostrarResultado(false, data.message || 'Error en la importación.');
            if (btn) btn.disabled = false;
            Swal.fire({
                icon: 'error',
                title: 'Importación fallida',
                text: data.message || 'Error en la importación.',
            });
            return;
        }

        setProgress(100, 'Importación completada');
        mostrarResultado(true,
            'Carrera ID: ' + data.carrera_id +
            ' | Filas importadas: ' + data.filas_importadas +
            ' | Filas omitidas: ' + data.filas_omitidas
        );

        Swal.fire({
            icon: 'success',
            title: 'Importación completada',
            html: 'Se creó la carrera con ID <b>' + data.carrera_id + '</b>.<br>' +
                  'Filas importadas: ' + data.filas_importadas + '<br>' +
                  'Filas omitidas: ' + data.filas_omitidas,
            confirmButtonText: 'Ver carrera',
            allowOutsideClick: false,
        }).then(() => {
            if (data.carrera_id) {
                window.location.href = APP_URL_BASE + 'carreras/' + data.carrera_id;
            }
        });
    } catch (e) {
        clearInterval(timer);
        setProgress(100, 'Importación finalizada con error');
        mostrarResultado(false, 'Error de red o servidor: ' + e.message);
        if (btn) btn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: e.message || 'Error inesperado',
        });
    } finally {
        setTimeout(() => modal.hide(), 900);
    }
}

function mostrarResultado(ok, texto) {
    const c = document.getElementById('resultado_importacion');
    if (!c) return;
    c.style.display = 'block';
    c.className = ok ? 'alert alert-success mb-3' : 'alert alert-danger mb-3';
    c.innerHTML = '<strong>' + (ok ? 'Resultado de importación' : 'Error de importación') + ':</strong> ' + texto;
}
</script>

<div class=\"modal fade\" id=\"modal_progreso_importacion\" tabindex=\"-1\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-dialog-centered\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\">Importando carrera</h5>
      </div>
      <div class=\"modal-body\">
        <p id=\"progress_importacion_text\" class=\"mb-2\">Preparando...</p>
        <div class=\"progress\">
          <div id=\"progress_importacion_bar\" class=\"progress-bar progress-bar-striped progress-bar-animated\"
               role=\"progressbar\" style=\"width: 0%\" aria-valuemin=\"0\" aria-valuemax=\"100\" aria-valuenow=\"0\">0%</div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "carreras/importar_previsualizar.twig";
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
        return array (  884 => 375,  873 => 372,  869 => 371,  866 => 370,  862 => 369,  853 => 363,  829 => 342,  823 => 339,  820 => 338,  813 => 337,  805 => 332,  797 => 326,  795 => 325,  788 => 321,  779 => 317,  772 => 313,  766 => 310,  758 => 304,  750 => 302,  748 => 301,  743 => 298,  736 => 296,  732 => 294,  728 => 292,  725 => 291,  719 => 290,  716 => 289,  714 => 288,  709 => 286,  705 => 285,  701 => 284,  696 => 283,  687 => 281,  679 => 280,  675 => 279,  672 => 278,  667 => 277,  663 => 276,  660 => 275,  658 => 274,  653 => 272,  649 => 271,  645 => 270,  641 => 269,  636 => 268,  634 => 267,  631 => 266,  626 => 265,  624 => 264,  619 => 261,  615 => 259,  611 => 257,  609 => 256,  599 => 248,  591 => 242,  582 => 239,  578 => 238,  574 => 237,  570 => 236,  566 => 235,  562 => 234,  558 => 233,  554 => 232,  551 => 231,  547 => 230,  521 => 206,  519 => 205,  513 => 201,  508 => 199,  504 => 198,  497 => 197,  494 => 196,  488 => 193,  484 => 192,  480 => 191,  477 => 190,  475 => 189,  471 => 188,  467 => 187,  463 => 186,  459 => 185,  455 => 184,  451 => 183,  447 => 182,  443 => 181,  439 => 180,  430 => 179,  420 => 178,  414 => 177,  410 => 176,  406 => 175,  402 => 174,  398 => 173,  395 => 172,  391 => 170,  387 => 168,  385 => 167,  367 => 151,  359 => 145,  350 => 142,  346 => 141,  342 => 140,  338 => 139,  334 => 138,  330 => 137,  326 => 136,  322 => 135,  319 => 134,  315 => 133,  293 => 113,  291 => 112,  288 => 111,  280 => 105,  271 => 102,  267 => 101,  263 => 100,  259 => 99,  255 => 98,  251 => 97,  248 => 96,  244 => 95,  224 => 77,  222 => 76,  219 => 75,  213 => 72,  210 => 71,  208 => 70,  205 => 69,  200 => 66,  189 => 65,  184 => 62,  182 => 61,  179 => 60,  171 => 54,  162 => 51,  158 => 50,  154 => 49,  150 => 48,  147 => 47,  143 => 46,  125 => 30,  123 => 29,  120 => 28,  115 => 25,  104 => 24,  99 => 21,  97 => 20,  89 => 15,  85 => 14,  78 => 10,  73 => 7,  71 => 6,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends \"base.twig\" %}

{% block title %}Informe importación carrera - Biblioges{% endblock %}

{% block content %}
{% set puede_importar = prev.puede_ejecutar|default(false) %}
<div class=\"container-fluid\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1 class=\"h3 mb-0 text-gray-800\">Informe previo de importación</h1>
        <a href=\"{{ app_url }}carreras/importar\" class=\"btn btn-outline-secondary\"><i class=\"fas fa-arrow-left\"></i> Volver</a>
    </div>

    <div class=\"alert alert-light border\">
        <strong>Archivo guardado:</strong> {{ archivo_guardado }}<br>
        <span class=\"text-muted\">Original: {{ archivo_original }}</span>
    </div>

    <div id=\"resultado_importacion\" class=\"mb-3\" style=\"display:none;\"></div>

    {% if prev.errores is not empty %}
    <div class=\"alert alert-danger\">
        <h6 class=\"alert-heading\">Errores globales (bloquean toda la importación)</h6>
        <ul class=\"mb-0\">
            {% for e in prev.errores %}<li>{{ e }}</li>{% endfor %}
        </ul>
    </div>
    {% endif %}

    {% if prev.errores_detalle is not empty %}
    <div class=\"card border-danger mb-4\">
        <div class=\"card-header bg-danger text-white py-2\">
            <strong>Errores por fila (se omiten esas asignaturas, el resto sí puede importarse)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 260px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Fila</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for err in prev.errores_detalle %}
                        <tr>
                            <td>{{ err.fila|default('—') }}</td>
                            <td>{{ err.codigo|default('—') }}</td>
                            <td>{{ err.tipo|default('fila') }}</td>
                            <td>{{ err.motivo|default('Error de validación') }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {% endif %}

    {% if prev.advertencias is not empty %}
    <div class=\"alert alert-warning\">
        <h6 class=\"alert-heading\">Advertencias</h6>
        <ul class=\"mb-0\">
            {% for a in prev.advertencias %}<li>{{ a }}</li>{% endfor %}
        </ul>
    </div>
    {% endif %}

    {% if error_unidades is defined and error_unidades %}
    <div class=\"alert alert-danger\">
        <i class=\"fas fa-exclamation-triangle\"></i> {{ error_unidades }}
    </div>
    {% endif %}

    {% if prev.unidades_por_crear is not empty %}
    <div class=\"card border-warning mb-4\">
        <div class=\"card-header bg-warning\">
            <strong>Unidades faltantes detectadas (se crearán al confirmar)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 220px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Tipo</th>
                            <th>Fila</th>
                            <th>Código unidad</th>
                            <th>Nombre unidad</th>
                            <th>Sede</th>
                            <th>Código asignatura</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for u in prev.unidades_por_crear %}
                        <tr>
                            <td>{{ u.tipo }}</td>
                            <td>{{ u.fila }}</td>
                            <td>{{ u.codigo_unidad|default('—') }}</td>
                            <td>{{ u.nombre_unidad|default('—') }}</td>
                            <td>{{ u.sede_id|default('—') }}</td>
                            <td>{{ u.codigo_asignatura|default('—') }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {% endif %}

    {% if prev.equivalencias_unidades is not empty %}
    <div class=\"card border-info mb-4\">
        <div class=\"card-header bg-info text-white py-2\">
            <strong>Trazabilidad de equivalencias de unidades (Excel → tabla unidades)</strong>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 240px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Tipo</th>
                            <th>Fila</th>
                            <th>Sede</th>
                            <th>Código Asig.</th>
                            <th>Excel: cod</th>
                            <th>Excel: nombre</th>
                            <th>Equiv.: cod</th>
                            <th>Equiv.: nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for eq in prev.equivalencias_unidades %}
                        <tr>
                            <td>{{ eq.tipo|default('—') }}</td>
                            <td>{{ eq.fila|default('—') }}</td>
                            <td>{{ eq.sede_id|default('—') }}</td>
                            <td>{{ eq.codigo_asignatura|default('—') }}</td>
                            <td>{{ eq.excel_codigo|default('—') }}</td>
                            <td>{{ eq.excel_nombre|default('—') }}</td>
                            <td>{{ eq.equiv_codigo|default('—') }}</td>
                            <td>{{ eq.equiv_nombre|default('—') }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {% endif %}

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\"><h6 class=\"m-0 font-weight-bold text-primary\">Resumen</h6></div>
        <div class=\"card-body\">
            <div class=\"alert alert-info py-2 mb-3\">
                <small>
                    <i class=\"fas fa-info-circle\"></i>
                    Regla aplicada: toda asignatura de formación cuyo código comience con <strong>UN</strong>
                    se considera <strong>asignatura electiva padre</strong>. Sus asignaturas hijas se toman desde
                    <code>CODIGO_ASIGNATURA_1</code>, <code>NOMBRE_ASIGNATURA_1</code>,
                    <code>COD_UNIDAD_FORMACION</code> y <code>UNIDAD_FORMACION</code>.
                </small>
            </div>
            <dl class=\"row mb-0\">
                <dt class=\"col-sm-3\">Estado</dt>
                <dd class=\"col-sm-9\">
                    {% if puede_importar %}
                        <span class=\"badge bg-success\">Listo para confirmar</span>
                    {% else %}
                        <span class=\"badge bg-danger\">Bloqueado: hay errores que deben corregirse</span>
                    {% endif %}
                </dd>
                <dt class=\"col-sm-3\">Modo</dt><dd class=\"col-sm-9\">{{ prev.resumen.modo }}</dd>
                <dt class=\"col-sm-3\">Código programa</dt><dd class=\"col-sm-9\">{{ prev.resumen.codigo_programa }}</dd>
                <dt class=\"col-sm-3\">Nombre programa</dt><dd class=\"col-sm-9\">{{ prev.resumen.nombre_programa }}</dd>
                <dt class=\"col-sm-3\">Tipo programa</dt><dd class=\"col-sm-9\">{{ prev.resumen.tipo_programa }}</dd>
                <dt class=\"col-sm-3\">Vigencia</dt><dd class=\"col-sm-9\">{{ prev.resumen.inicio_vigencia }} → {{ prev.resumen.termino_vigencia }}</dd>
                <dt class=\"col-sm-3\">Sede</dt><dd class=\"col-sm-9\">{{ prev.resumen.sede }} {% if prev.resumen.sede_id %}(id {{ prev.resumen.sede_id }}){% endif %}</dd>
                <dt class=\"col-sm-3\">Unidad carrera</dt><dd class=\"col-sm-9\">{% if prev.resumen.unidad_carrera_id %}id {{ prev.resumen.unidad_carrera_id }}{% else %}—{% endif %}</dd>
                <dt class=\"col-sm-3\">Filas Excel</dt><dd class=\"col-sm-9\">{{ prev.resumen.filas_excel }}</dd>
                <dt class=\"col-sm-3\">Filas malla distintas</dt><dd class=\"col-sm-9\">{{ prev.resumen.filas_malla_distintas }}</dd>
                <dt class=\"col-sm-3\">Filas importables</dt><dd class=\"col-sm-9\">{{ prev.resumen.filas_importables|default(0) }}</dd>
                <dt class=\"col-sm-3\">Filas con conflicto</dt><dd class=\"col-sm-9\">{{ prev.resumen.filas_con_conflicto|default(0) }}</dd>
                <dt class=\"col-sm-3\">Equivalencias de unidades</dt><dd class=\"col-sm-9\">{{ prev.resumen.equivalencias_unidades_total|default(0) }}</dd>
                <dt class=\"col-sm-3\">Vigencias previas a cerrar</dt><dd class=\"col-sm-9\">{{ prev.resumen.vigencias_previas_a_cerrar|default(0) }}</dd>
                <dt class=\"col-sm-3\">Carreras previas relacionadas</dt><dd class=\"col-sm-9\">{{ prev.resumen.carreras_previas_relacionadas|default(0) }}</dd>
                <dt class=\"col-sm-3\">Máx. semestre</dt><dd class=\"col-sm-9\">{{ prev.resumen.max_semestre }}</dd>
                <dt class=\"col-sm-3\">Relaciones formación (filas)</dt><dd class=\"col-sm-9\">{{ prev.resumen.filas_relacion_formacion }}</dd>
                {% if prev.resumen.modo == 'nueva' %}
                <dt class=\"col-sm-3\">Asignaturas</dt><dd class=\"col-sm-9\">
                    Códigos únicos: {{ prev.resumen.asignaturas_codigos_unicos|default('—') }},
                    existentes en BD: {{ prev.resumen.asignaturas_existentes_bd|default('—') }},
                    nuevas: {{ prev.resumen.asignaturas_nuevas|default('—') }}
                </dd>
                {% endif %}
                {% if prev.resumen.modo == 'espejo' %}
                <dt class=\"col-sm-3\">Carrera referencia</dt><dd class=\"col-sm-9\">{{ prev.resumen.carrera_referencia|default('—') }} (id {{ prev.resumen.carrera_referencia_id|default('—') }})</dd>
                <dt class=\"col-sm-3\">Códigos ya en deptos.</dt><dd class=\"col-sm-9\">{{ prev.resumen.espejo_filas_codigo_ya_en_sede|default(0) }} <span class=\"text-muted small\">(único en BD)</span></dd>
                <dt class=\"col-sm-3\">Fusión recomendada</dt><dd class=\"col-sm-9\">{{ prev.resumen.espejo_filas_fusion_recomendada|default(0) }} <span class=\"text-muted small\">(id referencia ≠ id ya cargado en sede)</span></dd>
                {% endif %}
            </dl>
        </div>
    </div>

    {% if prev.recomendaciones_fusion is defined and prev.recomendaciones_fusion is not empty %}
    <div class=\"card border-primary mb-4\">
        <div class=\"card-header bg-primary text-white py-2\">
            <strong>Recomendación: fusionar asignaturas al editar la malla</strong>
        </div>
        <div class=\"card-body\">
            <p class=\"small text-muted mb-2\">
                El código del Excel ya está cargado en departamentos (código único en BD) con un <code>asignatura_id</code> distinto al que corresponde por nombre en la carrera de referencia.
                La importación <strong>agregará la asignatura a la malla</strong> usando el id ya existente en sede. Luego, en la edición de malla del sistema conviene <strong>fusionar</strong> esos registros para unificar bibliografías y datos.
            </p>
            <div class=\"table-responsive\" style=\"max-height: 280px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            <th>Fila</th>
                            <th>Código Excel</th>
                            <th>Nombre Excel</th>
                            <th>Sem.</th>
                            <th>Id (nombre ref.)</th>
                            <th>Nombre referencia</th>
                            <th>Id (código en sede)</th>
                            <th>Nombre en BD sede</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for rf in prev.recomendaciones_fusion %}
                        <tr>
                            <td>{{ rf.fila }}</td>
                            <td>{{ rf.codigo_excel }}</td>
                            <td>{{ rf.nombre_excel|default('—') }}</td>
                            <td>{{ rf.semestre }}</td>
                            <td>{{ rf.asignatura_id_por_nombre_referencia }}</td>
                            <td><small>{{ rf.nombre_por_referencia|default('—') }}</small></td>
                            <td>{{ rf.asignatura_id_codigo_en_sede }}</td>
                            <td><small>{{ rf.nombre_en_bd_sede|default('—') }}</small></td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {% endif %}

    <div class=\"card shadow mb-4\">
        <div class=\"card-header py-3\"><h6 class=\"m-0 font-weight-bold text-primary\">Detalle malla / equivalencias</h6></div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\" style=\"max-height: 420px;\">
                <table class=\"table table-sm table-striped mb-0\">
                    <thead class=\"table-light sticky-top\">
                        <tr>
                            {% if prev.resumen.modo == 'espejo' %}
                            <th>Fila</th><th>Código Excel</th><th>Sem.</th><th>Equiv. id</th><th>Equiv. nombre</th><th>En sede</th><th>Malla id</th><th>Fusión</th><th>Método / nota</th>
                            {% else %}
                            <th>Fila</th><th>Código</th><th>Sem.</th><th>Nombre</th><th>En BD</th>
                            {% endif %}
                        </tr>
                    </thead>
                    <tbody>
                        {% set max_filas = 80 %}
                        {% for linea in prev.informe_malla|slice(0, max_filas) %}
                        <tr>
                            {% if prev.resumen.modo == 'espejo' %}
                            <td>{{ linea.fila }}</td>
                            <td>{{ linea.codigo_excel }}</td>
                            <td>{{ linea.semestre }}</td>
                            <td>{{ linea.equivalente_id|default('—') }}</td>
                            <td>{{ linea.equivalente_nombre|default('—') }}</td>
                            <td>
                                {% if linea.codigo_ya_en_sede|default(false) %}
                                    <span class=\"badge bg-secondary\">sí</span>
                                    {% if linea.codigo_en_misma_sede is defined and linea.codigo_en_misma_sede %}<span class=\"badge bg-light text-dark border\">misma sede</span>{% endif %}
                                {% else %}—{% endif %}
                            </td>
                            <td>{{ linea.malla_usara_asignatura_id|default(linea.equivalente_id|default('—')) }}</td>
                            <td>{% if linea.fusion_recomendada|default(false) %}<span class=\"badge bg-warning text-dark\">revisar</span>{% else %}—{% endif %}</td>
                            <td><small>{% if linea.nota_malla %}{{ linea.nota_malla }}<br>{% endif %}{{ linea.metodo|default('') }}</small></td>
                            {% else %}
                            <td>{{ linea.fila }}</td>
                            <td>{{ linea.codigo }}</td>
                            <td>{{ linea.semestre }}</td>
                            <td>{{ linea.nombre }}</td>
                            <td>
                                {% if linea.asignatura_en_bd|default(false) %}
                                    <span class=\"badge bg-info text-dark\">Ya existe</span>
                                    {% if linea.asignatura_id_existente is defined and linea.asignatura_id_existente %}<small class=\"text-muted\">id {{ linea.asignatura_id_existente }}</small>{% endif %}
                                {% else %}
                                    <span class=\"badge bg-success\">Nueva</span>
                                {% endif %}
                            </td>
                            {% endif %}
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
            {% if prev.informe_malla|length > max_filas %}
            <div class=\"p-2 text-muted small\">Mostrando las primeras {{ max_filas }} filas de {{ prev.informe_malla|length }}.</div>
            {% endif %}
        </div>
    </div>

    <div class=\"card border-secondary mb-3\">
        <div class=\"card-body py-3\">
            <div class=\"d-flex flex-wrap align-items-center gap-3\">
                <form method=\"post\" action=\"{{ app_url }}carreras/importar/confirmar\" class=\"d-inline mb-0\"
                      id=\"form_confirmar_importacion\"
                      onsubmit=\"if (this.querySelector('[type=submit]').disabled) { return false; } return confirmarImportacionConUnidades(this);\">
                    <input type=\"hidden\" name=\"import_token\" value=\"{{ import_token }}\">
                    <input type=\"hidden\" name=\"confirmar_creacion_unidades\" id=\"confirmar_creacion_unidades\" value=\"0\">
                    <button type=\"submit\" class=\"btn btn-success btn-lg\"
                            id=\"btn_confirmar_importacion\"
                            {% if not puede_importar %}disabled title=\"Corrija los errores del informe para poder confirmar\" aria-disabled=\"true\"{% endif %}>
                        <i class=\"fas fa-check\"></i> Confirmar importación
                    </button>
                </form>
                <form method=\"post\" action=\"{{ app_url }}carreras/importar/cancelar\" class=\"d-inline mb-0\">
                    <button type=\"submit\" class=\"btn btn-outline-danger btn-lg\"><i class=\"fas fa-times\"></i> Cancelar importación</button>
                </form>
            </div>
            {% if not puede_importar %}
            <p class=\"text-danger small mb-0 mt-3\">
                <i class=\"fas fa-info-circle\"></i>
                Si hay errores globales o no quedaron filas importables, el botón se deshabilita.
                Corrige el archivo y vuelve a generar el informe previo.
            </p>
            {% endif %}
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
const APP_URL_BASE = \"{{ app_url }}\";

function confirmarImportacionConUnidades(formEl) {
    const requiereUnidades = {{ prev.unidades_por_crear is not empty ? 'true' : 'false' }};

    if (!requiereUnidades) {
        Swal.fire({
            title: 'Confirmar importación',
            text: '¿Confirma aplicar la importación en la base de datos? Esta acción no se puede deshacer automáticamente.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
        }).then((result) => {
            if (!result.isConfirmed) return;
            const input = document.getElementById('confirmar_creacion_unidades');
            if (input) input.value = '0';
            ejecutarImportacionAjax(formEl);
        });
        return false;
    }

    // Requiere creación de unidades
    const total = {{ prev.unidades_por_crear|length }};
    const unidadesHtml = `
        <p>Se detectaron <b>\${total}</b> unidad(es) faltante(s).</p>
        <p>Se crearán para continuar la importación.</p>
        <div style=\"max-height: 220px; overflow:auto; text-align:left;\">
            <ul class=\"mb-0\">
                {% for u in prev.unidades_por_crear %}
                    <li>
                        <b>{{ u.tipo }}</b>:
                        {{ u.codigo_unidad|default('—') }} - {{ u.nombre_unidad|default('—') }}
                    </li>
                {% endfor %}
            </ul>
        </div>
    `;

    Swal.fire({
        title: 'Crear unidades faltantes y continuar',
        html: unidadesHtml,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Crear y continuar',
        cancelButtonText: 'Cancelar',
        allowOutsideClick: false,
        width: '720px',
    }).then((result) => {
        if (!result.isConfirmed) return;
        const input = document.getElementById('confirmar_creacion_unidades');
        if (input) input.value = '1';
        ejecutarImportacionAjax(formEl);
    });

    return false;
}

function setProgress(percent, text) {
    const bar = document.getElementById('progress_importacion_bar');
    const label = document.getElementById('progress_importacion_text');
    if (bar) {
        bar.style.width = percent + '%';
        bar.setAttribute('aria-valuenow', String(percent));
        bar.textContent = percent + '%';
    }
    if (label) label.textContent = text;
}

async function ejecutarImportacionAjax(formEl) {
    const modalEl = document.getElementById('modal_progreso_importacion');
    const modal = new bootstrap.Modal(modalEl, {backdrop: 'static', keyboard: false});
    const btn = document.getElementById('btn_confirmar_importacion');
    if (btn) btn.disabled = true;
    modal.show();

    setProgress(10, 'Iniciando importación...');

    // avance visual mientras espera respuesta
    let p = 15;
    const timer = setInterval(() => {
        p = Math.min(90, p + 5);
        setProgress(p, 'Procesando datos en el servidor...');
    }, 700);

    try {
        const fd = new FormData(formEl);
        const resp = await fetch(formEl.action, {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        });
        const data = await resp.json();
        clearInterval(timer);

        if (!resp.ok || !data.success) {
            setProgress(100, 'Importación finalizada con error');
            mostrarResultado(false, data.message || 'Error en la importación.');
            if (btn) btn.disabled = false;
            Swal.fire({
                icon: 'error',
                title: 'Importación fallida',
                text: data.message || 'Error en la importación.',
            });
            return;
        }

        setProgress(100, 'Importación completada');
        mostrarResultado(true,
            'Carrera ID: ' + data.carrera_id +
            ' | Filas importadas: ' + data.filas_importadas +
            ' | Filas omitidas: ' + data.filas_omitidas
        );

        Swal.fire({
            icon: 'success',
            title: 'Importación completada',
            html: 'Se creó la carrera con ID <b>' + data.carrera_id + '</b>.<br>' +
                  'Filas importadas: ' + data.filas_importadas + '<br>' +
                  'Filas omitidas: ' + data.filas_omitidas,
            confirmButtonText: 'Ver carrera',
            allowOutsideClick: false,
        }).then(() => {
            if (data.carrera_id) {
                window.location.href = APP_URL_BASE + 'carreras/' + data.carrera_id;
            }
        });
    } catch (e) {
        clearInterval(timer);
        setProgress(100, 'Importación finalizada con error');
        mostrarResultado(false, 'Error de red o servidor: ' + e.message);
        if (btn) btn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: e.message || 'Error inesperado',
        });
    } finally {
        setTimeout(() => modal.hide(), 900);
    }
}

function mostrarResultado(ok, texto) {
    const c = document.getElementById('resultado_importacion');
    if (!c) return;
    c.style.display = 'block';
    c.className = ok ? 'alert alert-success mb-3' : 'alert alert-danger mb-3';
    c.innerHTML = '<strong>' + (ok ? 'Resultado de importación' : 'Error de importación') + ':</strong> ' + texto;
}
</script>

<div class=\"modal fade\" id=\"modal_progreso_importacion\" tabindex=\"-1\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-dialog-centered\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\">Importando carrera</h5>
      </div>
      <div class=\"modal-body\">
        <p id=\"progress_importacion_text\" class=\"mb-2\">Preparando...</p>
        <div class=\"progress\">
          <div id=\"progress_importacion_bar\" class=\"progress-bar progress-bar-striped progress-bar-animated\"
               role=\"progressbar\" style=\"width: 0%\" aria-valuemin=\"0\" aria-valuemax=\"100\" aria-valuenow=\"0\">0%</div>
        </div>
      </div>
    </div>
  </div>
</div>
{% endblock %}
", "carreras/importar_previsualizar.twig", "/var/www/html/biblioges/templates/carreras/importar_previsualizar.twig");
    }
}
