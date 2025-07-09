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

/* bibliografias_disponibles/form.twig */
class __TwigTemplate_cca946115ed43a0602ee5ffa2c7ba2d9 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_disponibles/form.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 4
        yield "    ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 4)) {
            // line 5
            yield "        Editar Bibliografía Disponible
    ";
        } else {
            // line 7
            yield "        Nueva Bibliografía Disponible
    ";
        }
        yield from [];
    }

    // line 11
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 12
        yield "<div class=\"container mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            ";
        // line 15
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 15)) {
            // line 16
            yield "                Editar Bibliografía Disponible
            ";
        } else {
            // line 18
            yield "                Nueva Bibliografía Disponible
            ";
        }
        // line 20
        yield "        </h1>
        <a href=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 26
        if (($context["error"] ?? null)) {
            // line 27
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 29
        yield "
    <div class=\"card\">
        <div class=\"card-body\">
            <form method=\"POST\" action=\"";
        // line 32
        yield ((($context["isEdit"] ?? null)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((((($context["app_url"] ?? null) . "bibliografias-disponibles/") . CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 32)) . "/update"), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($context["app_url"] ?? null) . "bibliografias-disponibles"), "html", null, true)));
        yield "\" id=\"bibliografiaForm\">
                ";
        // line 33
        if (($context["isEdit"] ?? null)) {
            // line 34
            yield "                    <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                ";
        }
        // line 36
        yield "                
                <!-- Campo oculto para autores temporales -->
                <input type=\"hidden\" id=\"autores_temporales\" name=\"autores_temporales\" value=\"[]\">
                <!-- Campo oculto para autores seleccionados -->
                <input type=\"hidden\" name=\"autores[]\" value=\"\">

                <div class=\"row\">
                    <!-- Primera columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"titulo\" class=\"form-label\">Título <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" 
                                   value=\"";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 48), "html", null, true);
        yield "\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"anio_edicion\" class=\"form-label\">Año de Edición <span class=\"text-danger\">*</span></label>
                            <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                                   value=\"";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_edicion", [], "any", false, false, false, 54), "html", null, true);
        yield "\" min=\"1900\" max=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "\" 
                                   maxlength=\"4\" pattern=\"\\d{4}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"disponibilidad\" class=\"form-label\">Disponibilidad <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"disponibilidad\" name=\"disponibilidad\" required>
                                <option value=\"\">Seleccione una disponibilidad</option>
                                <option value=\"impreso\" ";
        // line 62
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "disponibilidad", [], "any", false, false, false, 62) == "impreso")) {
            yield "selected";
        }
        yield ">Impreso</option>
                                <option value=\"electronico\" ";
        // line 63
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "disponibilidad", [], "any", false, false, false, 63) == "electronico")) {
            yield "selected";
        }
        yield ">Electrónico</option>
                                <option value=\"ambos\" ";
        // line 64
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "disponibilidad", [], "any", false, false, false, 64) == "ambos")) {
            yield "selected";
        }
        yield ">Ambos</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url_acceso\" class=\"form-label\">URL de Acceso</label>
                            <input type=\"url\" class=\"form-control\" id=\"url_acceso\" name=\"url_acceso\" 
                                   value=\"";
        // line 71
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_acceso", [], "any", false, false, false, 71), "html", null, true);
        yield "\">
                            <small class=\"form-text text-muted\">URL para acceder al recurso electrónico</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url_catalogo\" class=\"form-label\">URL del Catálogo</label>
                            <input type=\"url\" class=\"form-control\" id=\"url_catalogo\" name=\"url_catalogo\" 
                                   value=\"";
        // line 78
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url_catalogo", [], "any", false, false, false, 78), "html", null, true);
        yield "\">
                            <small class=\"form-text text-muted\">URL en el catálogo de la biblioteca</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"id_mms\" class=\"form-label\">ID MMS</label>
                            <input type=\"text\" class=\"form-control\" id=\"id_mms\" name=\"id_mms\" 
                                   value=\"";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id_mms", [], "any", false, false, false, 85), "html", null, true);
        yield "\">
                            <small class=\"form-text text-muted\">Identificador único en el sistema de gestión bibliotecaria</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"ejemplares_digitales\" class=\"form-label\">Ejemplares Digitales</label>
                            <input type=\"number\" class=\"form-control\" id=\"ejemplares_digitales\" name=\"ejemplares_digitales\" 
                                   value=\"";
        // line 92
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "ejemplares_digitales", [], "any", false, false, false, 92), "html", null, true);
        yield "\" min=\"0\">
                            <small class=\"form-text text-muted\">0 para acceso ilimitado</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"bibliografia_declarada_id\" class=\"form-label\">Bibliografía Declarada</label>
                            <div class=\"input-group mb-2\">
                                <input type=\"text\" class=\"form-control\" id=\"buscarBibliografiaDeclarada\" 
                                       placeholder=\"Buscar bibliografía declarada...\">
                                <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"btnBuscarBibliografiaDeclarada\">
                                    <i class=\"fas fa-search\"></i>
                                </button>
                            </div>
                            <select class=\"form-select\" id=\"bibliografia_declarada_id\" name=\"bibliografia_declarada_id\">
                                <option value=\"\">Seleccione una bibliografía declarada</option>
                                ";
        // line 107
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["bibliografiasDeclaradas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["bd"]) {
            // line 108
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "id", [], "any", false, false, false, 108), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "bibliografia_declarada_id", [], "any", false, false, false, 108) == CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "id", [], "any", false, false, false, 108))) {
                yield "selected";
            }
            yield ">
                                        ";
            // line 109
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["bd"], "titulo", [], "any", false, false, false, 109), "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['bd'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 112
        yield "                            </select>
                        </div>
                    </div>

                    <!-- Segunda columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"editorial\" class=\"form-label\">Editorial</label>
                            <select class=\"form-select\" id=\"editorial-select\" onchange=\"toggleEditorialInput()\">
                                <option value=\"\">Seleccione una editorial</option>
                                ";
        // line 122
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["editoriales"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["editorial"]) {
            // line 123
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["editorial"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 123) == $context["editorial"])) {
                yield "selected";
            }
            yield ">
                                        ";
            // line 124
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["editorial"], "html", null, true);
            yield "
                                    </option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['editorial'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 127
        yield "                            </select>
                            <div id=\"nueva-editorial-container\" class=\"mt-2\" style=\"display: none;\">
                                <input type=\"text\" class=\"form-control\" id=\"nueva-editorial\" name=\"editorial\" 
                                       placeholder=\"Ingrese el nombre de la nueva editorial\">
                            </div>
                        </div>
                    </div>
                        </div>

                <!-- Sedes y Ejemplares -->
                <div id=\"seccionSedes\" class=\"mt-4\" style=\"display: none;\">
                    <h3 class=\"mb-3\">Sedes y Ejemplares</h3>
                    <div class=\"row\">
                        ";
        // line 140
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["sedes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["sede"]) {
            // line 141
            yield "                            <div class=\"col-md-4 mb-3\">
                                <div class=\"card\">
                                    <div class=\"card-body\">
                                        <h5 class=\"card-title\">";
            // line 144
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "nombre", [], "any", false, false, false, 144), "html", null, true);
            yield "</h5>
                                        <div class=\"mb-3\">
                                            <label for=\"ejemplares_";
            // line 146
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 146), "html", null, true);
            yield "\" class=\"form-label\">Ejemplares</label>
                                            <input type=\"number\" class=\"form-control\" 
                                                   id=\"ejemplares_";
            // line 148
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 148), "html", null, true);
            yield "\" 
                                                   name=\"sedes[";
            // line 149
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 149), "html", null, true);
            yield "][ejemplares]\" 
                                                   min=\"0\" 
                                                   value=\"";
            // line 151
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "sedes", [], "any", false, true, false, 151), CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 151), [], "array", false, true, false, 151), "ejemplares", [], "any", true, true, false, 151)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, (($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "sedes", [], "any", false, false, false, 151)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["sede"], "id", [], "any", false, false, false, 151)] ?? null) : null), "ejemplares", [], "any", false, false, false, 151), 0)) : (0)), "html", null, true);
            yield "\">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['sede'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 157
        yield "                    </div>
                        </div>

                <!-- Autores -->
                <div class=\"mt-4\">
                    <h3 class=\"mb-3\">Autores</h3>
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"mb-3\">
                                <div class=\"d-flex justify-content-between align-items-center mb-2\">
                                    <label class=\"form-label\">Autores Disponibles</label>
                                </div>
                                <select class=\"form-select\" id=\"autoresDisponibles\" multiple size=\"10\" style=\"height: auto;\">
                                    ";
        // line 170
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["autores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
            // line 171
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 171), "html", null, true);
            yield "\" data-apellidos=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 171), "html", null, true);
            yield "\" data-nombres=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 171), "html", null, true);
            yield "\" data-genero=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 171), "html", null, true);
            yield "\">
                                            ";
            // line 172
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 172), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 172), "html", null, true);
            yield "
                                        </option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 175
        yield "                                </select>
                                <div class=\"mt-2\">
                                    <button type=\"button\" class=\"btn btn-sm btn-success\" id=\"agregarAutorSeleccionado\">
                                        <i class=\"fas fa-arrow-right\"></i> Agregar Seleccionados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"row mt-4\">
                        <div class=\"col-md-8\">
                            <div class=\"card\">
                                <div class=\"card-header d-flex justify-content-between align-items-center\">
                                    <h5 class=\"card-title mb-0\">Autores Seleccionados</h5>
                                    <button type=\"button\" class=\"btn btn-sm btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#nuevoAutorModal\">
                                        <i class=\"fas fa-plus\"></i> Nuevo Autor
                                    </button>
                                </div>
                                <div class=\"card-body\">
                                    <div id=\"autoresSeleccionados\" class=\"list-group\">
                                        ";
        // line 196
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 196));
        foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
            // line 197
            yield "                                            <div class=\"list-group-item d-flex justify-content-between align-items-center\" data-autor-id=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 197), "html", null, true);
            yield "\">
                                                <div>
                                                    <strong>";
            // line 199
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 199), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 199), "html", null, true);
            yield "</strong>
                                                    <br>
                                                    <small class=\"text-muted\">";
            // line 201
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 201), "html", null, true);
            yield "</small>
                                                </div>
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('";
            // line 203
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 203), "html", null, true);
            yield "')\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                                            </div>
                                            <input type=\"hidden\" name=\"autores[]\" value=\"";
            // line 207
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 207), "html", null, true);
            yield "\">
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 209
        yield "                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                    <a href=\"";
        // line 220
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-disponibles\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para nuevo autor -->
<div class=\"modal fade\" id=\"nuevoAutorModal\" tabindex=\"-1\" aria-labelledby=\"nuevoAutorModalLabel\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"nuevoAutorModalLabel\">Agregar Nuevo Autor</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"formNuevoAutor\">
                    <div class=\"mb-3\">
                        <label for=\"nombres\" class=\"form-label\">Nombres</label>
                        <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"apellidos\" class=\"form-label\">Apellidos</label>
                        <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"genero\" class=\"form-label\">Género</label>
                        <select class=\"form-select\" id=\"genero\" name=\"genero\" required>
                            <option value=\"\">Seleccione...</option>
                            <option value=\"Masculino\">Masculino</option>
                            <option value=\"Femenino\">Femenino</option>
                            <option value=\"Otro\">Otro</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" id=\"guardarNuevoAutor\">Guardar</button>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 267
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 268
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar sección de sedes según disponibilidad
    const disponibilidadSelect = document.getElementById('disponibilidad');
    const seccionSedes = document.getElementById('seccionSedes');
    const urlAcceso = document.getElementById('url_acceso');
    const urlCatalogo = document.getElementById('url_catalogo');
    const idMms = document.getElementById('id_mms');
    const ejemplaresDigitales = document.getElementById('ejemplares_digitales');

    function actualizarValidaciones() {
        const valor = disponibilidadSelect.value;
        
        // Resetear todas las validaciones
        urlAcceso.required = false;
        urlCatalogo.required = false;
        idMms.required = false;
        ejemplaresDigitales.required = false;
        
        // Aplicar validaciones según disponibilidad
        switch(valor) {
            case 'impreso':
                urlCatalogo.required = true;
                idMms.required = true;
                break;
            case 'electronico':
                urlAcceso.required = true;
                ejemplaresDigitales.required = true;
                break;
            case 'ambos':
                urlAcceso.required = true;
                urlCatalogo.required = true;
                idMms.required = true;
                ejemplaresDigitales.required = true;
                break;
        }
        
        // Actualizar visualización de campos requeridos
        actualizarIndicadoresRequeridos();
    }

    function actualizarIndicadoresRequeridos() {
        const campos = [urlAcceso, urlCatalogo, idMms, ejemplaresDigitales];
        campos.forEach(campo => {
            const label = campo.previousElementSibling;
            if (campo.required) {
                if (!label.querySelector('.text-danger')) {
                    label.innerHTML += ' <span class=\"text-danger\">*</span>';
                }
            } else {
                const asterisco = label.querySelector('.text-danger');
                if (asterisco) {
                    asterisco.remove();
                }
            }
        });
    }

    disponibilidadSelect.addEventListener('change', actualizarValidaciones);
    actualizarValidaciones();

    // Inicializar el estado del campo de nueva editorial
    toggleEditorialInput();

    // Manejo de autores
    const autoresDisponibles = document.getElementById('autoresDisponibles');
    const autoresSeleccionados = document.getElementById('autoresSeleccionados');
    const agregarAutorBtn = document.getElementById('agregarAutorSeleccionado');
    const autoresTemporales = [];
    const autoresSeleccionadosIds = new Set();

    // Cargar autores existentes al inicializar
    document.querySelectorAll('#autoresSeleccionados .list-group-item').forEach(item => {
        const autorId = item.dataset.autorId;
        if (autorId) {
            autoresSeleccionadosIds.add(autorId);
        }
    });

    // Función para agregar autor a la lista
    function agregarAutorALista(autor) {
        // Verificar si el autor ya está en la lista
        if (autoresSeleccionadosIds.has(autor.id)) {
            return;
        }

        const autorElement = document.createElement('div');
        autorElement.className = 'list-group-item d-flex justify-content-between align-items-center';
        autorElement.dataset.autorId = autor.id;
        autorElement.innerHTML = `
            <div>
                <strong>\${autor.apellidos}, \${autor.nombres}</strong>
                <br>
                <small class=\"text-muted\">\${autor.genero}</small>
            </div>
            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('\${autor.id}')\">
                <i class=\"fas fa-times\"></i>
            </button>
        `;
        autoresSeleccionados.appendChild(autorElement);
        autoresSeleccionadosIds.add(autor.id);
        
        // Actualizar el campo oculto con los IDs de autores seleccionados
        actualizarAutoresSeleccionados();
    }

    // Función para actualizar el campo oculto de autores seleccionados
    function actualizarAutoresSeleccionados() {
        // Eliminar todos los campos de autores existentes
        const autoresInputs = document.querySelectorAll('input[name=\"autores[]\"]');
        autoresInputs.forEach(input => input.remove());
        
        // Crear un nuevo campo para cada autor seleccionado
        Array.from(autoresSeleccionadosIds).forEach(autorId => {
            if (autorId && autorId !== '') {  // Solo agregar si el ID no está vacío
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'autores[]';
                input.value = autorId;
                document.getElementById('bibliografiaForm').appendChild(input);
            }
        });
    }

    // Función para agregar autor temporal
    function agregarAutorTemporal(autor) {
        const autorTemp = {
            id: 'temp_' + Date.now(),
            nombres: autor.nombres,
            apellidos: autor.apellidos,
            genero: autor.genero
        };
        autoresTemporales.push(autorTemp);
        agregarAutorALista(autorTemp);
        actualizarAutoresTemporales();
    }

    // Función para actualizar la lista de autores temporales
    function actualizarAutoresTemporales() {
        const autoresTemporalesInput = document.getElementById('autores_temporales');
        autoresTemporalesInput.value = JSON.stringify(autoresTemporales);
    }

    // Función para eliminar autor temporal
    window.eliminarAutorTemporal = function(index) {
        const autorTemp = autoresTemporales[index];
        if (autorTemp) {
            autoresSeleccionadosIds.delete(autorTemp.id);
            autoresTemporales.splice(index, 1);
            actualizarAutoresTemporales();
            const autorElement = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autorTemp.id}\"]`);
            if (autorElement) {
                autorElement.remove();
            }
        }
    };

    // Agregar autores seleccionados
    agregarAutorBtn.addEventListener('click', function() {
        const seleccionados = Array.from(autoresDisponibles.selectedOptions);
        if (seleccionados.length === 0) return;

        seleccionados.forEach(option => {
            if (!option.value) return;
            
            const autor = {
                id: option.value,
                apellidos: option.dataset.apellidos || '',
                nombres: option.dataset.nombres || '',
                genero: option.dataset.genero || ''
            };
            
            if (autor.apellidos && autor.nombres) {
                agregarAutorALista(autor);
            }
        });
        
        // Limpiar la selección después de agregar
        autoresDisponibles.selectedIndex = -1;
    });

    // Manejar el guardado de nuevo autor
    const guardarNuevoAutorBtn = document.getElementById('guardarNuevoAutor');
    guardarNuevoAutorBtn.addEventListener('click', function() {
        const formNuevoAutor = document.getElementById('formNuevoAutor');
        if (formNuevoAutor.checkValidity()) {
            const autor = {
                nombres: document.getElementById('nombres').value.trim(),
                apellidos: document.getElementById('apellidos').value.trim(),
                genero: document.getElementById('genero').value
            };
            
            if (autor.nombres && autor.apellidos && autor.genero) {
                agregarAutorTemporal(autor);
                
                // Limpiar y cerrar el modal
                formNuevoAutor.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoAutorModal'));
                if (modal) {
                    modal.hide();
                }
            }
        } else {
            formNuevoAutor.reportValidity();
        }
    });

    // Limpiar el formulario cuando se cierra el modal
    const nuevoAutorModal = document.getElementById('nuevoAutorModal');
    nuevoAutorModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formNuevoAutor').reset();
    });

    // Función para eliminar autor
    window.eliminarAutor = function(autorId) {
        const elemento = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autorId}\"]`);
        if (elemento) {
            elemento.remove();
            autoresSeleccionadosIds.delete(autorId);
            
            // Si es un autor temporal, eliminarlo de la lista
            const index = autoresTemporales.findIndex(a => a.id === autorId);
            if (index !== -1) {
                autoresTemporales.splice(index, 1);
                actualizarAutoresTemporales();
            }
            
            // Actualizar el campo oculto de autores seleccionados
            actualizarAutoresSeleccionados();
        }
    };

    // Manejar el envío del formulario principal
    const bibliografiaForm = document.getElementById('bibliografiaForm');
    bibliografiaForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos requeridos según disponibilidad
        const valor = disponibilidadSelect.value;
        let camposFaltantes = [];
        
        if (valor === 'impreso' || valor === 'ambos') {
            if (!urlCatalogo.value) camposFaltantes.push('URL del Catálogo');
            if (!idMms.value) camposFaltantes.push('ID MMS');
        }
        
        if (valor === 'electronico' || valor === 'ambos') {
            if (!urlAcceso.value) camposFaltantes.push('URL de Acceso');
            if (!ejemplaresDigitales.value) camposFaltantes.push('Ejemplares Digitales');
        }
        
        if (camposFaltantes.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                html: `Por favor complete los siguientes campos:<br><br>\${camposFaltantes.join('<br>')}`,
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: this.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'Aceptar'
                });
                
                if (data.formData) {
                    Object.keys(data.formData).forEach(key => {
                        const input = document.querySelector(`[name=\"\${key}\"]`);
                        if (input) {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                input.checked = data.formData[key] === 'on' || data.formData[key] === '1';
                            } else {
                                input.value = data.formData[key];
                            }
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud',
                confirmButtonText: 'Aceptar'
            });
        });
    });

    // Función para buscar bibliografías declaradas
    const buscarBibliografiaDeclarada = document.getElementById('buscarBibliografiaDeclarada');
    const btnBuscarBibliografiaDeclarada = document.getElementById('btnBuscarBibliografiaDeclarada');
    const selectBibliografiaDeclarada = document.getElementById('bibliografia_declarada_id');

    function buscarBibliografiasDeclaradas(termino) {
        const opciones = selectBibliografiaDeclarada.options;
        let encontrado = false;

        // Convertir el término de búsqueda a minúsculas para búsqueda insensible a mayúsculas
        termino = termino.toLowerCase();

        // Primero, ocultar todas las opciones
        for (let i = 0; i < opciones.length; i++) {
            opciones[i].style.display = 'none';
        }

        // Mostrar la opción por defecto
        opciones[0].style.display = '';

        // Buscar coincidencias
        for (let i = 1; i < opciones.length; i++) {
            const texto = opciones[i].text.toLowerCase();
            if (texto.includes(termino)) {
                opciones[i].style.display = '';
                encontrado = true;
                // Seleccionar la primera coincidencia
                if (!selectBibliografiaDeclarada.value) {
                    selectBibliografiaDeclarada.value = opciones[i].value;
                }
            }
        }

        // Si no se encontraron coincidencias, mostrar mensaje
        if (!encontrado && termino !== '') {
            Swal.fire({
                icon: 'info',
                title: 'Sin resultados',
                text: 'No se encontraron bibliografías declaradas que coincidan con la búsqueda',
                confirmButtonText: 'Aceptar'
            });
        }
    }

    // Evento para buscar al escribir
    buscarBibliografiaDeclarada.addEventListener('input', function() {
        buscarBibliografiasDeclaradas(this.value);
    });

    // Evento para buscar al hacer clic en el botón
    btnBuscarBibliografiaDeclarada.addEventListener('click', function() {
        buscarBibliografiasDeclaradas(buscarBibliografiaDeclarada.value);
    });

    // Evento para buscar al presionar Enter
    buscarBibliografiaDeclarada.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarBibliografiasDeclaradas(this.value);
        }
    });

    // Limpiar búsqueda cuando se cambia la selección
    selectBibliografiaDeclarada.addEventListener('change', function() {
        buscarBibliografiaDeclarada.value = '';
        // Mostrar todas las opciones
        const opciones = this.options;
        for (let i = 0; i < opciones.length; i++) {
            opciones[i].style.display = '';
        }
    });
});

function toggleEditorialInput() {
    const editorialSelect = document.getElementById('editorial-select');
    const nuevaEditorialContainer = document.getElementById('nueva-editorial-container');
    const nuevaEditorialInput = document.getElementById('nueva-editorial');
    
    if (editorialSelect.value === 'Otra') {
        nuevaEditorialContainer.style.display = 'block';
        nuevaEditorialInput.required = true;
        nuevaEditorialInput.focus();
    } else {
        nuevaEditorialContainer.style.display = 'none';
        nuevaEditorialInput.required = false;
        if (editorialSelect.value) {
            nuevaEditorialInput.value = editorialSelect.value;
        }
    }
}
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "bibliografias_disponibles/form.twig";
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
        return array (  521 => 268,  514 => 267,  463 => 220,  450 => 209,  442 => 207,  435 => 203,  430 => 201,  423 => 199,  417 => 197,  413 => 196,  390 => 175,  379 => 172,  368 => 171,  364 => 170,  349 => 157,  337 => 151,  332 => 149,  328 => 148,  323 => 146,  318 => 144,  313 => 141,  309 => 140,  294 => 127,  285 => 124,  276 => 123,  272 => 122,  260 => 112,  251 => 109,  242 => 108,  238 => 107,  220 => 92,  210 => 85,  200 => 78,  190 => 71,  178 => 64,  172 => 63,  166 => 62,  153 => 54,  144 => 48,  130 => 36,  126 => 34,  124 => 33,  120 => 32,  115 => 29,  109 => 27,  107 => 26,  99 => 21,  96 => 20,  92 => 18,  88 => 16,  86 => 15,  81 => 12,  74 => 11,  67 => 7,  63 => 5,  60 => 4,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}
    {% if bibliografia.id %}
        Editar Bibliografía Disponible
    {% else %}
        Nueva Bibliografía Disponible
    {% endif %}
{% endblock %}

{% block content %}
<div class=\"container mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            {% if bibliografia.id %}
                Editar Bibliografía Disponible
            {% else %}
                Nueva Bibliografía Disponible
            {% endif %}
        </h1>
        <a href=\"{{ app_url }}bibliografias-disponibles\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if error %}
        <div class=\"alert alert-danger\">{{ error }}</div>
    {% endif %}

    <div class=\"card\">
        <div class=\"card-body\">
            <form method=\"POST\" action=\"{{ isEdit ? app_url ~ 'bibliografias-disponibles/' ~ bibliografia.id ~ '/update' : app_url ~ 'bibliografias-disponibles' }}\" id=\"bibliografiaForm\">
                {% if isEdit %}
                    <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                {% endif %}
                
                <!-- Campo oculto para autores temporales -->
                <input type=\"hidden\" id=\"autores_temporales\" name=\"autores_temporales\" value=\"[]\">
                <!-- Campo oculto para autores seleccionados -->
                <input type=\"hidden\" name=\"autores[]\" value=\"\">

                <div class=\"row\">
                    <!-- Primera columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"titulo\" class=\"form-label\">Título <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" 
                                   value=\"{{ bibliografia.titulo }}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"anio_edicion\" class=\"form-label\">Año de Edición <span class=\"text-danger\">*</span></label>
                            <input type=\"number\" class=\"form-control\" id=\"anio_edicion\" name=\"anio_edicion\" 
                                   value=\"{{ bibliografia.anio_edicion }}\" min=\"1900\" max=\"{{ 'now'|date('Y') }}\" 
                                   maxlength=\"4\" pattern=\"\\d{4}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"disponibilidad\" class=\"form-label\">Disponibilidad <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"disponibilidad\" name=\"disponibilidad\" required>
                                <option value=\"\">Seleccione una disponibilidad</option>
                                <option value=\"impreso\" {% if bibliografia.disponibilidad == 'impreso' %}selected{% endif %}>Impreso</option>
                                <option value=\"electronico\" {% if bibliografia.disponibilidad == 'electronico' %}selected{% endif %}>Electrónico</option>
                                <option value=\"ambos\" {% if bibliografia.disponibilidad == 'ambos' %}selected{% endif %}>Ambos</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url_acceso\" class=\"form-label\">URL de Acceso</label>
                            <input type=\"url\" class=\"form-control\" id=\"url_acceso\" name=\"url_acceso\" 
                                   value=\"{{ bibliografia.url_acceso }}\">
                            <small class=\"form-text text-muted\">URL para acceder al recurso electrónico</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url_catalogo\" class=\"form-label\">URL del Catálogo</label>
                            <input type=\"url\" class=\"form-control\" id=\"url_catalogo\" name=\"url_catalogo\" 
                                   value=\"{{ bibliografia.url_catalogo }}\">
                            <small class=\"form-text text-muted\">URL en el catálogo de la biblioteca</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"id_mms\" class=\"form-label\">ID MMS</label>
                            <input type=\"text\" class=\"form-control\" id=\"id_mms\" name=\"id_mms\" 
                                   value=\"{{ bibliografia.id_mms }}\">
                            <small class=\"form-text text-muted\">Identificador único en el sistema de gestión bibliotecaria</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"ejemplares_digitales\" class=\"form-label\">Ejemplares Digitales</label>
                            <input type=\"number\" class=\"form-control\" id=\"ejemplares_digitales\" name=\"ejemplares_digitales\" 
                                   value=\"{{ bibliografia.ejemplares_digitales }}\" min=\"0\">
                            <small class=\"form-text text-muted\">0 para acceso ilimitado</small>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"bibliografia_declarada_id\" class=\"form-label\">Bibliografía Declarada</label>
                            <div class=\"input-group mb-2\">
                                <input type=\"text\" class=\"form-control\" id=\"buscarBibliografiaDeclarada\" 
                                       placeholder=\"Buscar bibliografía declarada...\">
                                <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"btnBuscarBibliografiaDeclarada\">
                                    <i class=\"fas fa-search\"></i>
                                </button>
                            </div>
                            <select class=\"form-select\" id=\"bibliografia_declarada_id\" name=\"bibliografia_declarada_id\">
                                <option value=\"\">Seleccione una bibliografía declarada</option>
                                {% for bd in bibliografiasDeclaradas %}
                                    <option value=\"{{ bd.id }}\" {% if bibliografia.bibliografia_declarada_id == bd.id %}selected{% endif %}>
                                        {{ bd.titulo }}
                                    </option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>

                    <!-- Segunda columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"editorial\" class=\"form-label\">Editorial</label>
                            <select class=\"form-select\" id=\"editorial-select\" onchange=\"toggleEditorialInput()\">
                                <option value=\"\">Seleccione una editorial</option>
                                {% for editorial in editoriales %}
                                    <option value=\"{{ editorial }}\" {% if bibliografia.editorial == editorial %}selected{% endif %}>
                                        {{ editorial }}
                                    </option>
                                {% endfor %}
                            </select>
                            <div id=\"nueva-editorial-container\" class=\"mt-2\" style=\"display: none;\">
                                <input type=\"text\" class=\"form-control\" id=\"nueva-editorial\" name=\"editorial\" 
                                       placeholder=\"Ingrese el nombre de la nueva editorial\">
                            </div>
                        </div>
                    </div>
                        </div>

                <!-- Sedes y Ejemplares -->
                <div id=\"seccionSedes\" class=\"mt-4\" style=\"display: none;\">
                    <h3 class=\"mb-3\">Sedes y Ejemplares</h3>
                    <div class=\"row\">
                        {% for sede in sedes %}
                            <div class=\"col-md-4 mb-3\">
                                <div class=\"card\">
                                    <div class=\"card-body\">
                                        <h5 class=\"card-title\">{{ sede.nombre }}</h5>
                                        <div class=\"mb-3\">
                                            <label for=\"ejemplares_{{ sede.id }}\" class=\"form-label\">Ejemplares</label>
                                            <input type=\"number\" class=\"form-control\" 
                                                   id=\"ejemplares_{{ sede.id }}\" 
                                                   name=\"sedes[{{ sede.id }}][ejemplares]\" 
                                                   min=\"0\" 
                                                   value=\"{{ bibliografia.sedes[sede.id].ejemplares|default(0) }}\">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                        </div>

                <!-- Autores -->
                <div class=\"mt-4\">
                    <h3 class=\"mb-3\">Autores</h3>
                    <div class=\"row\">
                        <div class=\"col-md-8\">
                            <div class=\"mb-3\">
                                <div class=\"d-flex justify-content-between align-items-center mb-2\">
                                    <label class=\"form-label\">Autores Disponibles</label>
                                </div>
                                <select class=\"form-select\" id=\"autoresDisponibles\" multiple size=\"10\" style=\"height: auto;\">
                                    {% for autor in autores %}
                                        <option value=\"{{ autor.id }}\" data-apellidos=\"{{ autor.apellidos }}\" data-nombres=\"{{ autor.nombres }}\" data-genero=\"{{ autor.genero }}\">
                                            {{ autor.apellidos }}, {{ autor.nombres }}
                                        </option>
                                    {% endfor %}
                                </select>
                                <div class=\"mt-2\">
                                    <button type=\"button\" class=\"btn btn-sm btn-success\" id=\"agregarAutorSeleccionado\">
                                        <i class=\"fas fa-arrow-right\"></i> Agregar Seleccionados
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"row mt-4\">
                        <div class=\"col-md-8\">
                            <div class=\"card\">
                                <div class=\"card-header d-flex justify-content-between align-items-center\">
                                    <h5 class=\"card-title mb-0\">Autores Seleccionados</h5>
                                    <button type=\"button\" class=\"btn btn-sm btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#nuevoAutorModal\">
                                        <i class=\"fas fa-plus\"></i> Nuevo Autor
                                    </button>
                                </div>
                                <div class=\"card-body\">
                                    <div id=\"autoresSeleccionados\" class=\"list-group\">
                                        {% for autor in bibliografia.autores %}
                                            <div class=\"list-group-item d-flex justify-content-between align-items-center\" data-autor-id=\"{{ autor.id }}\">
                                                <div>
                                                    <strong>{{ autor.apellidos }}, {{ autor.nombres }}</strong>
                                                    <br>
                                                    <small class=\"text-muted\">{{ autor.genero }}</small>
                                                </div>
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('{{ autor.id }}')\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                                            </div>
                                            <input type=\"hidden\" name=\"autores[]\" value=\"{{ autor.id }}\">
                                        {% endfor %}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                    <a href=\"{{ app_url }}bibliografias-disponibles\" class=\"btn btn-secondary\">
                        <i class=\"fas fa-times\"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para nuevo autor -->
<div class=\"modal fade\" id=\"nuevoAutorModal\" tabindex=\"-1\" aria-labelledby=\"nuevoAutorModalLabel\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"nuevoAutorModalLabel\">Agregar Nuevo Autor</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"formNuevoAutor\">
                    <div class=\"mb-3\">
                        <label for=\"nombres\" class=\"form-label\">Nombres</label>
                        <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"apellidos\" class=\"form-label\">Apellidos</label>
                        <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"genero\" class=\"form-label\">Género</label>
                        <select class=\"form-select\" id=\"genero\" name=\"genero\" required>
                            <option value=\"\">Seleccione...</option>
                            <option value=\"Masculino\">Masculino</option>
                            <option value=\"Femenino\">Femenino</option>
                            <option value=\"Otro\">Otro</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" id=\"guardarNuevoAutor\">Guardar</button>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar sección de sedes según disponibilidad
    const disponibilidadSelect = document.getElementById('disponibilidad');
    const seccionSedes = document.getElementById('seccionSedes');
    const urlAcceso = document.getElementById('url_acceso');
    const urlCatalogo = document.getElementById('url_catalogo');
    const idMms = document.getElementById('id_mms');
    const ejemplaresDigitales = document.getElementById('ejemplares_digitales');

    function actualizarValidaciones() {
        const valor = disponibilidadSelect.value;
        
        // Resetear todas las validaciones
        urlAcceso.required = false;
        urlCatalogo.required = false;
        idMms.required = false;
        ejemplaresDigitales.required = false;
        
        // Aplicar validaciones según disponibilidad
        switch(valor) {
            case 'impreso':
                urlCatalogo.required = true;
                idMms.required = true;
                break;
            case 'electronico':
                urlAcceso.required = true;
                ejemplaresDigitales.required = true;
                break;
            case 'ambos':
                urlAcceso.required = true;
                urlCatalogo.required = true;
                idMms.required = true;
                ejemplaresDigitales.required = true;
                break;
        }
        
        // Actualizar visualización de campos requeridos
        actualizarIndicadoresRequeridos();
    }

    function actualizarIndicadoresRequeridos() {
        const campos = [urlAcceso, urlCatalogo, idMms, ejemplaresDigitales];
        campos.forEach(campo => {
            const label = campo.previousElementSibling;
            if (campo.required) {
                if (!label.querySelector('.text-danger')) {
                    label.innerHTML += ' <span class=\"text-danger\">*</span>';
                }
            } else {
                const asterisco = label.querySelector('.text-danger');
                if (asterisco) {
                    asterisco.remove();
                }
            }
        });
    }

    disponibilidadSelect.addEventListener('change', actualizarValidaciones);
    actualizarValidaciones();

    // Inicializar el estado del campo de nueva editorial
    toggleEditorialInput();

    // Manejo de autores
    const autoresDisponibles = document.getElementById('autoresDisponibles');
    const autoresSeleccionados = document.getElementById('autoresSeleccionados');
    const agregarAutorBtn = document.getElementById('agregarAutorSeleccionado');
    const autoresTemporales = [];
    const autoresSeleccionadosIds = new Set();

    // Cargar autores existentes al inicializar
    document.querySelectorAll('#autoresSeleccionados .list-group-item').forEach(item => {
        const autorId = item.dataset.autorId;
        if (autorId) {
            autoresSeleccionadosIds.add(autorId);
        }
    });

    // Función para agregar autor a la lista
    function agregarAutorALista(autor) {
        // Verificar si el autor ya está en la lista
        if (autoresSeleccionadosIds.has(autor.id)) {
            return;
        }

        const autorElement = document.createElement('div');
        autorElement.className = 'list-group-item d-flex justify-content-between align-items-center';
        autorElement.dataset.autorId = autor.id;
        autorElement.innerHTML = `
            <div>
                <strong>\${autor.apellidos}, \${autor.nombres}</strong>
                <br>
                <small class=\"text-muted\">\${autor.genero}</small>
            </div>
            <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('\${autor.id}')\">
                <i class=\"fas fa-times\"></i>
            </button>
        `;
        autoresSeleccionados.appendChild(autorElement);
        autoresSeleccionadosIds.add(autor.id);
        
        // Actualizar el campo oculto con los IDs de autores seleccionados
        actualizarAutoresSeleccionados();
    }

    // Función para actualizar el campo oculto de autores seleccionados
    function actualizarAutoresSeleccionados() {
        // Eliminar todos los campos de autores existentes
        const autoresInputs = document.querySelectorAll('input[name=\"autores[]\"]');
        autoresInputs.forEach(input => input.remove());
        
        // Crear un nuevo campo para cada autor seleccionado
        Array.from(autoresSeleccionadosIds).forEach(autorId => {
            if (autorId && autorId !== '') {  // Solo agregar si el ID no está vacío
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'autores[]';
                input.value = autorId;
                document.getElementById('bibliografiaForm').appendChild(input);
            }
        });
    }

    // Función para agregar autor temporal
    function agregarAutorTemporal(autor) {
        const autorTemp = {
            id: 'temp_' + Date.now(),
            nombres: autor.nombres,
            apellidos: autor.apellidos,
            genero: autor.genero
        };
        autoresTemporales.push(autorTemp);
        agregarAutorALista(autorTemp);
        actualizarAutoresTemporales();
    }

    // Función para actualizar la lista de autores temporales
    function actualizarAutoresTemporales() {
        const autoresTemporalesInput = document.getElementById('autores_temporales');
        autoresTemporalesInput.value = JSON.stringify(autoresTemporales);
    }

    // Función para eliminar autor temporal
    window.eliminarAutorTemporal = function(index) {
        const autorTemp = autoresTemporales[index];
        if (autorTemp) {
            autoresSeleccionadosIds.delete(autorTemp.id);
            autoresTemporales.splice(index, 1);
            actualizarAutoresTemporales();
            const autorElement = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autorTemp.id}\"]`);
            if (autorElement) {
                autorElement.remove();
            }
        }
    };

    // Agregar autores seleccionados
    agregarAutorBtn.addEventListener('click', function() {
        const seleccionados = Array.from(autoresDisponibles.selectedOptions);
        if (seleccionados.length === 0) return;

        seleccionados.forEach(option => {
            if (!option.value) return;
            
            const autor = {
                id: option.value,
                apellidos: option.dataset.apellidos || '',
                nombres: option.dataset.nombres || '',
                genero: option.dataset.genero || ''
            };
            
            if (autor.apellidos && autor.nombres) {
                agregarAutorALista(autor);
            }
        });
        
        // Limpiar la selección después de agregar
        autoresDisponibles.selectedIndex = -1;
    });

    // Manejar el guardado de nuevo autor
    const guardarNuevoAutorBtn = document.getElementById('guardarNuevoAutor');
    guardarNuevoAutorBtn.addEventListener('click', function() {
        const formNuevoAutor = document.getElementById('formNuevoAutor');
        if (formNuevoAutor.checkValidity()) {
            const autor = {
                nombres: document.getElementById('nombres').value.trim(),
                apellidos: document.getElementById('apellidos').value.trim(),
                genero: document.getElementById('genero').value
            };
            
            if (autor.nombres && autor.apellidos && autor.genero) {
                agregarAutorTemporal(autor);
                
                // Limpiar y cerrar el modal
                formNuevoAutor.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoAutorModal'));
                if (modal) {
                    modal.hide();
                }
            }
        } else {
            formNuevoAutor.reportValidity();
        }
    });

    // Limpiar el formulario cuando se cierra el modal
    const nuevoAutorModal = document.getElementById('nuevoAutorModal');
    nuevoAutorModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formNuevoAutor').reset();
    });

    // Función para eliminar autor
    window.eliminarAutor = function(autorId) {
        const elemento = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autorId}\"]`);
        if (elemento) {
            elemento.remove();
            autoresSeleccionadosIds.delete(autorId);
            
            // Si es un autor temporal, eliminarlo de la lista
            const index = autoresTemporales.findIndex(a => a.id === autorId);
            if (index !== -1) {
                autoresTemporales.splice(index, 1);
                actualizarAutoresTemporales();
            }
            
            // Actualizar el campo oculto de autores seleccionados
            actualizarAutoresSeleccionados();
        }
    };

    // Manejar el envío del formulario principal
    const bibliografiaForm = document.getElementById('bibliografiaForm');
    bibliografiaForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos requeridos según disponibilidad
        const valor = disponibilidadSelect.value;
        let camposFaltantes = [];
        
        if (valor === 'impreso' || valor === 'ambos') {
            if (!urlCatalogo.value) camposFaltantes.push('URL del Catálogo');
            if (!idMms.value) camposFaltantes.push('ID MMS');
        }
        
        if (valor === 'electronico' || valor === 'ambos') {
            if (!urlAcceso.value) camposFaltantes.push('URL de Acceso');
            if (!ejemplaresDigitales.value) camposFaltantes.push('Ejemplares Digitales');
        }
        
        if (camposFaltantes.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                html: `Por favor complete los siguientes campos:<br><br>\${camposFaltantes.join('<br>')}`,
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: this.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'Aceptar'
                });
                
                if (data.formData) {
                    Object.keys(data.formData).forEach(key => {
                        const input = document.querySelector(`[name=\"\${key}\"]`);
                        if (input) {
                            if (input.type === 'checkbox' || input.type === 'radio') {
                                input.checked = data.formData[key] === 'on' || data.formData[key] === '1';
                            } else {
                                input.value = data.formData[key];
                            }
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud',
                confirmButtonText: 'Aceptar'
            });
        });
    });

    // Función para buscar bibliografías declaradas
    const buscarBibliografiaDeclarada = document.getElementById('buscarBibliografiaDeclarada');
    const btnBuscarBibliografiaDeclarada = document.getElementById('btnBuscarBibliografiaDeclarada');
    const selectBibliografiaDeclarada = document.getElementById('bibliografia_declarada_id');

    function buscarBibliografiasDeclaradas(termino) {
        const opciones = selectBibliografiaDeclarada.options;
        let encontrado = false;

        // Convertir el término de búsqueda a minúsculas para búsqueda insensible a mayúsculas
        termino = termino.toLowerCase();

        // Primero, ocultar todas las opciones
        for (let i = 0; i < opciones.length; i++) {
            opciones[i].style.display = 'none';
        }

        // Mostrar la opción por defecto
        opciones[0].style.display = '';

        // Buscar coincidencias
        for (let i = 1; i < opciones.length; i++) {
            const texto = opciones[i].text.toLowerCase();
            if (texto.includes(termino)) {
                opciones[i].style.display = '';
                encontrado = true;
                // Seleccionar la primera coincidencia
                if (!selectBibliografiaDeclarada.value) {
                    selectBibliografiaDeclarada.value = opciones[i].value;
                }
            }
        }

        // Si no se encontraron coincidencias, mostrar mensaje
        if (!encontrado && termino !== '') {
            Swal.fire({
                icon: 'info',
                title: 'Sin resultados',
                text: 'No se encontraron bibliografías declaradas que coincidan con la búsqueda',
                confirmButtonText: 'Aceptar'
            });
        }
    }

    // Evento para buscar al escribir
    buscarBibliografiaDeclarada.addEventListener('input', function() {
        buscarBibliografiasDeclaradas(this.value);
    });

    // Evento para buscar al hacer clic en el botón
    btnBuscarBibliografiaDeclarada.addEventListener('click', function() {
        buscarBibliografiasDeclaradas(buscarBibliografiaDeclarada.value);
    });

    // Evento para buscar al presionar Enter
    buscarBibliografiaDeclarada.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarBibliografiasDeclaradas(this.value);
        }
    });

    // Limpiar búsqueda cuando se cambia la selección
    selectBibliografiaDeclarada.addEventListener('change', function() {
        buscarBibliografiaDeclarada.value = '';
        // Mostrar todas las opciones
        const opciones = this.options;
        for (let i = 0; i < opciones.length; i++) {
            opciones[i].style.display = '';
        }
    });
});

function toggleEditorialInput() {
    const editorialSelect = document.getElementById('editorial-select');
    const nuevaEditorialContainer = document.getElementById('nueva-editorial-container');
    const nuevaEditorialInput = document.getElementById('nueva-editorial');
    
    if (editorialSelect.value === 'Otra') {
        nuevaEditorialContainer.style.display = 'block';
        nuevaEditorialInput.required = true;
        nuevaEditorialInput.focus();
    } else {
        nuevaEditorialContainer.style.display = 'none';
        nuevaEditorialInput.required = false;
        if (editorialSelect.value) {
            nuevaEditorialInput.value = editorialSelect.value;
        }
    }
}
</script>
{% endblock %} ", "bibliografias_disponibles/form.twig", "/var/www/html/biblioges/templates/bibliografias_disponibles/form.twig");
    }
}
