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

/* bibliografias_declaradas/form.twig */
class __TwigTemplate_7a47c0b419c07b80ebec47e1f4188e86 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_declaradas/form.twig", 1);
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
            yield "        Editar Bibliografía Declarada
    ";
        } else {
            // line 7
            yield "        Nueva Bibliografía Declarada
    ";
        }
        yield from [];
    }

    // line 13
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 14
        yield "<div class=\"container mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            ";
        // line 17
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 17)) {
            // line 18
            yield "                Editar Bibliografía Declarada
            ";
        } else {
            // line 20
            yield "                Nueva Bibliografía Declarada
            ";
        }
        // line 22
        yield "        </h1>
        <a href=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    ";
        // line 28
        if (($context["error"] ?? null)) {
            // line 29
            yield "        <div class=\"alert alert-danger\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 31
        yield "
    <div class=\"card\">
        <div class=\"card-body\">
            <form id=\"bibliografiaForm\" method=\"POST\" 
                  action=\"";
        // line 35
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 35)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 35), "html", null, true);
        } else {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
            yield "bibliografias-declaradas";
        }
        yield "\">
                ";
        // line 36
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 36)) {
            // line 37
            yield "                    <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                ";
        }
        // line 39
        yield "                <input type=\"hidden\" name=\"_token\" id=\"formToken\" value=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "form_token", [], "any", true, true, false, 39)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "form_token", [], "any", false, false, false, 39), "")) : ("")), "html", null, true);
        yield "\">

                <div class=\"row\">
                    <!-- Primera columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"titulo\" class=\"form-label\">Título <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" 
                                   value=\"";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 47), "html", null, true);
        yield "\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"anio_publicacion\" class=\"form-label\">Año de Edición <span class=\"text-danger\">*</span></label>
                            <input type=\"number\" class=\"form-control\" id=\"anio_publicacion\" name=\"anio_publicacion\" 
                                   value=\"";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_publicacion", [], "any", false, false, false, 53), "html", null, true);
        yield "\" min=\"1900\" max=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "\" 
                                   maxlength=\"4\" pattern=\"\\d{4}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"edicion\" class=\"form-label\">Edición</label>
                            <input type=\"text\" class=\"form-control\" id=\"edicion\" name=\"edicion\" 
                                   value=\"";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "edicion", [], "any", false, false, false, 60), "html", null, true);
        yield "\">
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url\" class=\"form-label\">URL</label>
                            <input type=\"url\" class=\"form-control\" id=\"url\" name=\"url\" 
                                   value=\"";
        // line 66
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "url", [], "any", false, false, false, 66), "html", null, true);
        yield "\">
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"formato\" class=\"form-label\">Formato <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"formato\" name=\"formato\" required>
                                <option value=\"impreso\" ";
        // line 72
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 72) == "impreso")) {
            yield "selected";
        }
        yield ">Impreso</option>
                                <option value=\"electronico\" ";
        // line 73
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 73) == "electronico")) {
            yield "selected";
        }
        yield ">Electrónico</option>
                                <option value=\"ambos\" ";
        // line 74
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 74) == "ambos")) {
            yield "selected";
        }
        yield ">Ambos</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\" ";
        // line 81
        if (( !CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 81) || (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "estado", [], "any", false, false, false, 81) == 1))) {
            yield "selected";
        }
        yield ">Activo</option>
                                <option value=\"0\" ";
        // line 82
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 82) && (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "estado", [], "any", false, false, false, 82) == 0))) {
            yield "selected";
        }
        yield ">Inactivo</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"nota\" class=\"form-label\">Nota</label>
                            <textarea class=\"form-control\" id=\"nota\" name=\"nota\" rows=\"3\">";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nota", [], "any", false, false, false, 88), "html", null, true);
        yield "</textarea>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"tipo\" class=\"form-label\">Tipo <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"tipo\" name=\"tipo\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"libro\" ";
        // line 95
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 95) == "libro")) {
            yield "selected";
        }
        yield ">Libro</option>
                                <option value=\"articulo\" ";
        // line 96
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 96) == "articulo")) {
            yield "selected";
        }
        yield ">Artículo</option>
                                <option value=\"tesis\" ";
        // line 97
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 97) == "tesis")) {
            yield "selected";
        }
        yield ">Tesis</option>
                                <option value=\"software\" ";
        // line 98
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 98) == "software")) {
            yield "selected";
        }
        yield ">Software</option>
                                <option value=\"sitio_web\" ";
        // line 99
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 99) == "sitio_web")) {
            yield "selected";
        }
        yield ">Sitio Web</option>
                                <option value=\"generico\" ";
        // line 100
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 100) == "generico")) {
            yield "selected";
        }
        yield ">Genérico</option>
                            </select>
                        </div>
                        </div>

                    <!-- Segunda columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"editorial\" class=\"form-label\">Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"buscarEditorial\" placeholder=\"Buscar editorial...\" style=\"font-size: 0.9rem;\">
                            <select class=\"form-select\" id=\"editorial\" name=\"editorial\" style=\"margin-top: 0.5rem;\" size=\"5\">
                                <option value=\"\">Seleccione una editorial</option>
                                ";
        // line 112
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["editoriales"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["editorial"]) {
            // line 113
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["editorial"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 113) == $context["editorial"])) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["editorial"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['editorial'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
        yield "                                <option value=\"otra\">Otra editorial...</option>
                            </select>
                        </div>

                        <div class=\"mb-3\" id=\"nuevaEditorialContainer\" style=\"display: none;\">
                            <label for=\"nueva_editorial\" class=\"form-label\">Nueva Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_editorial\" name=\"nueva_editorial\">
                        </div>
                        
                        <div class=\"mb-3\">
                            <label for=\"doi\" class=\"form-label\">DOI</label>
                            <input type=\"text\" class=\"form-control\" id=\"doi\" name=\"doi\" 
                                   value=\"";
        // line 127
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "doi", [], "any", false, false, false, 127), "html", null, true);
        yield "\" placeholder=\"10.1000/182\">
                        </div>
                        </div>
                    </div>

                <!-- Campos específicos según el tipo -->
                <div id=\"camposEspecificos\">
                    <!-- Libro -->
                    <div class=\"tipo-campo\" id=\"camposLibro\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Libro</h3>
                        <div class=\"mb-3\">
                            <label for=\"isbn\" class=\"form-label\">ISBN</label>
                            <input type=\"text\" class=\"form-control\" id=\"isbn\" name=\"isbn\" 
                                   value=\"";
        // line 140
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "isbn", [], "any", false, false, false, 140), "html", null, true);
        yield "\">
                        </div>
                        </div>

                    <!-- Tesis -->
                    <div class=\"tipo-campo\" id=\"camposTesis\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos de la Tesis</h3>
                        <div class=\"mb-3\">
                            <label for=\"nombre_carrera\" class=\"form-label\">Carrera</label>
                            <select class=\"form-select\" id=\"nombre_carrera\" name=\"nombre_carrera\">
                                <option value=\"\">Seleccione una carrera</option>
                                ";
        // line 151
        if (array_key_exists("carrerasExistentes", $context)) {
            // line 152
            yield "                                    <optgroup label=\"Carreras existentes en tesis\">
                                        ";
            // line 153
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["carrerasExistentes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
                // line 154
                yield "                                            <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["carrera"], "html", null, true);
                yield "\" ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nombre_carrera", [], "any", false, false, false, 154) == $context["carrera"])) {
                    yield "selected";
                }
                yield ">
                                                ";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["carrera"], "html", null, true);
                yield "
                                            </option>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 158
            yield "                                    </optgroup>
                                ";
        }
        // line 160
        yield "                                <optgroup label=\"Carreras del sistema\">
                                    ";
        // line 161
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["carreras"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["carrera"]) {
            // line 162
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 162), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "nombre_carrera", [], "any", false, false, false, 162) == CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 162))) {
                yield "selected";
            }
            yield ">
                                            ";
            // line 163
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["carrera"], "nombre", [], "any", false, false, false, 163), "html", null, true);
            yield "
                                        </option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['carrera'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 166
        yield "                                </optgroup>
                                <option value=\"otra\">Otra carrera...</option>
                            </select>
                        </div>
                        <div class=\"mb-3\" id=\"nuevaCarreraContainer\" style=\"display: none;\">
                            <label for=\"nueva_carrera\" class=\"form-label\">Nueva Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_carrera\" name=\"nueva_carrera\" placeholder=\"Ingrese el nombre de la nueva carrera\">
                        </div>
                        </div>

                    <!-- Artículo -->
                    <div class=\"tipo-campo\" id=\"camposArticulo\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Artículo</h3>
                        <div class=\"mb-3\">
                            <label for=\"issn\" class=\"form-label\">ISSN</label>
                            <input type=\"text\" class=\"form-control\" id=\"issn\" name=\"issn\" 
                                   value=\"";
        // line 182
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "issn", [], "any", false, false, false, 182), "html", null, true);
        yield "\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"titulo_revista\" class=\"form-label\">Título de la Revista</label>
                            <select class=\"form-select\" id=\"titulo_revista\" name=\"titulo_revista\">
                                <option value=\"\">Seleccione una revista</option>
                                ";
        // line 188
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["revistas"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["revista"]) {
            // line 189
            yield "                                    <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["revista"], "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo_revista", [], "any", false, false, false, 189) == $context["revista"])) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["revista"], "html", null, true);
            yield "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['revista'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 191
        yield "                                <option value=\"otra\">Otra...</option>
                            </select>
                        </div>
                        <div class=\"mb-3\" id=\"nuevaRevistaContainer\" style=\"display: none;\">
                            <label for=\"nueva_revista\" class=\"form-label\">Nueva Revista</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_revista\" name=\"nueva_revista\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"cronologia\" class=\"form-label\">Cronología</label>
                            <input type=\"text\" class=\"form-control\" id=\"cronologia\" name=\"cronologia\" 
                                   value=\"";
        // line 201
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "cronologia", [], "any", false, false, false, 201), "html", null, true);
        yield "\">
                        </div>
                    </div>

                    <!-- Genérico -->
                    <div class=\"tipo-campo\" id=\"camposGenerico\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos Genéricos</h3>
                        <div class=\"mb-3\">
                            <label for=\"descripcion\" class=\"form-label\">Descripción</label>
                            <textarea class=\"form-control\" id=\"descripcion\" name=\"descripcion\" rows=\"3\">";
        // line 210
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "descripcion", [], "any", false, false, false, 210), "html", null, true);
        yield "</textarea>
                        </div>
                        </div>

                    <!-- Sitio Web -->
                    <div class=\"tipo-campo\" id=\"camposSitioWeb\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Sitio Web</h3>
                            <div class=\"mb-3\">
                            <label for=\"fecha_consulta\" class=\"form-label\">Fecha de Consulta <span class=\"text-danger\">*</span></label>
                            <input type=\"date\" class=\"form-control\" id=\"fecha_consulta\" name=\"fecha_consulta\" 
                                   value=\"";
        // line 220
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "fecha_consulta", [], "any", false, false, false, 220), "Y-m-d"), "html", null, true);
        yield "\" required>
                            <small class=\"form-text text-muted\">Seleccione la fecha en que se consultó el sitio web</small>
                                </div>
                            </div>

                    <!-- Software -->
                    <div class=\"tipo-campo\" id=\"camposSoftware\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Software</h3>
                        <div class=\"mb-3\">
                            <label for=\"version\" class=\"form-label\">Versión</label>
                            <input type=\"text\" class=\"form-control\" id=\"version\" name=\"version\" 
                                   value=\"";
        // line 231
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "version", [], "any", false, false, false, 231), "html", null, true);
        yield "\">
                        </div>
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
                                <div class=\"mb-2\">
                                    <input type=\"text\" class=\"form-control\" id=\"buscarAutor\" placeholder=\"Buscar autores por nombre o apellido...\" style=\"font-size: 0.9rem;\">
                                </div>
                                <select class=\"form-select\" id=\"autoresDisponibles\" multiple size=\"10\" style=\"height: auto;\">
                        ";
        // line 249
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["autores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
            // line 250
            yield "                                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 250), "html", null, true);
            yield "\" 
                                                data-apellidos=\"";
            // line 251
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 251), "html", null, true);
            yield "\" 
                                                data-nombres=\"";
            // line 252
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 252), "html", null, true);
            yield "\" 
                                                data-genero=\"";
            // line 253
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 253), "html", null, true);
            yield "\">
                                            ";
            // line 254
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 254), "html", null, true);
            yield ", ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 254), "html", null, true);
            yield "
                                        </option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 257
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
        // line 278
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", true, true, false, 278)) {
            // line 279
            yield "                                            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 279));
            foreach ($context['_seq'] as $context["_key"] => $context["autor"]) {
                // line 280
                yield "                                            <div class=\"list-group-item d-flex justify-content-between align-items-center\" data-autor-id=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 280), "html", null, true);
                yield "\">
                                                <div>
                                                        <span class=\"autor-apellidos\">";
                // line 282
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "apellidos", [], "any", false, false, false, 282), "html", null, true);
                yield "</span>, 
                                                        <span class=\"autor-nombres\">";
                // line 283
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "nombres", [], "any", false, false, false, 283), "html", null, true);
                yield "</span>
                                                    <br>
                                                        <small class=\"text-muted autor-genero\">";
                // line 285
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "genero", [], "any", false, false, false, 285), "html", null, true);
                yield "</small>
                                                </div>
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('";
                // line 287
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["autor"], "id", [], "any", false, false, false, 287), "html", null, true);
                yield "')\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                            </div>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['autor'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 292
            yield "                                        ";
        }
        // line 293
        yield "                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"text-end mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Autor -->
<div class=\"modal fade\" id=\"nuevoAutorModal\" tabindex=\"-1\" aria-labelledby=\"nuevoAutorModalLabel\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"nuevoAutorModalLabel\">Nuevo Autor</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"nuevoAutorForm\" class=\"needs-validation\" novalidate>
                    <div class=\"mb-3\">
                        <label for=\"apellidos\" class=\"form-label\">Apellidos <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"nombres\" class=\"form-label\">Nombres <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"genero\" class=\"form-label\">Género <span class=\"text-danger\">*</span></label>
                        <select class=\"form-select\" id=\"genero\" name=\"genero\" required>
                            <option value=\"\">Seleccione un género</option>
                            <option value=\"masculino\">Masculino</option>
                            <option value=\"femenino\">Femenino</option>
                            <option value=\"otro\">Otro</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" id=\"guardarAutor\">Agregar Temporalmente</button>
            </div>
        </div>
    </div>
</div>

";
        // line 347
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 348
        yield "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
// Variables globales
let isFormSubmitting = false;
let tempAutorId = 1;

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bibliografiaForm');
    const autoresDisponibles = document.getElementById('autoresDisponibles');
    const autoresSeleccionados = document.getElementById('autoresSeleccionados');
    const agregarAutorSeleccionado = document.getElementById('agregarAutorSeleccionado');
    const tipoSelect = document.getElementById('tipo');
    const camposEspecificos = document.getElementById('camposEspecificos');
    const tipoCampos = document.querySelectorAll('.tipo-campo');
                const editorialSelect = document.getElementById('editorial');
            const nuevaEditorialContainer = document.getElementById('nuevaEditorialContainer');
            const buscarEditorial = document.getElementById('buscarEditorial');
    const tituloRevistaSelect = document.getElementById('titulo_revista');
    const nuevaRevistaContainer = document.getElementById('nuevaRevistaContainer');
    const nombreCarreraSelect = document.getElementById('nombre_carrera');
    const nuevaCarreraContainer = document.getElementById('nuevaCarreraContainer');
    let autoresSeleccionadosList = new Set();
    let submitButton = form.querySelector('button[type=\"submit\"]');

    // Inicializar autores existentes
    document.querySelectorAll('#autoresSeleccionados .list-group-item').forEach(item => {
        const autorId = item.getAttribute('data-autor-id');
        if (autorId) {
            autoresSeleccionadosList.add(autorId);
            // Desmarcar el autor en el select de disponibles
            const option = autoresDisponibles.querySelector(`option[value=\"\${autorId}\"]`);
            if (option) {
                option.selected = false;
            }
        }
    });

    // Función para mostrar campos específicos según el tipo
    function mostrarCamposEspecificos() {
        // Ocultar todos los campos específicos
        tipoCampos.forEach(campo => {
            campo.style.display = 'none';
        });
        
        // Mostrar los campos correspondientes al tipo seleccionado
        const tipoSeleccionado = tipoSelect.value;
        if (tipoSeleccionado) {
            // Convertir el tipo a formato camelCase para el ID
            const tipoFormateado = tipoSeleccionado.split('_').map((word, index) => {
                return index === 0 ? word : word.charAt(0).toUpperCase() + word.slice(1);
            }).join('');
            
            const camposTipo = document.getElementById('campos' + tipoFormateado.charAt(0).toUpperCase() + tipoFormateado.slice(1));
            if (camposTipo) {
                camposTipo.style.display = 'block';
                
                // Si es sitio web, asegurarse de que el campo de fecha sea requerido
                if (tipoSeleccionado === 'sitio_web') {
                    const fechaConsulta = document.getElementById('fecha_consulta');
                    if (fechaConsulta) {
                        fechaConsulta.required = true;
                    }
                }
            }
        }
    }
    
    // Mostrar campos específicos al cargar la página
    mostrarCamposEspecificos();
    
    // Mostrar campos específicos cuando cambie el tipo
    tipoSelect.addEventListener('change', mostrarCamposEspecificos);
    
                // Funcionalidad de búsqueda de editoriales
            function filtrarEditoriales(termino) {
                const opciones = editorialSelect.options;
                const terminoNormalizado = normalizarTexto(termino.trim());
                
                // Mostrar todas las opciones si no hay término de búsqueda
                if (terminoNormalizado === '') {
                    for (let i = 0; i < opciones.length; i++) {
                        opciones[i].style.display = '';
                    }
                    return;
                }
                
                // Filtrar opciones
                for (let i = 0; i < opciones.length; i++) {
                    const opcion = opciones[i];
                    const textoEditorial = normalizarTexto(opcion.textContent);
                    
                    if (textoEditorial.includes(terminoNormalizado)) {
                        opcion.style.display = '';
                    } else {
                        opcion.style.display = 'none';
                    }
                }
            }
            
            // Evento para buscar al escribir
            buscarEditorial.addEventListener('input', function() {
                filtrarEditoriales(this.value);
            });
            
            // Limpiar búsqueda cuando se hace clic en el campo
            buscarEditorial.addEventListener('focus', function() {
                if (this.value === '') {
                    filtrarEditoriales('');
                }
            });
            
            // Limpiar búsqueda cuando se presiona Escape
            buscarEditorial.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filtrarEditoriales('');
                    this.blur();
                }
            });
    
                // Manejar la visibilidad de la nueva editorial
            editorialSelect.addEventListener('change', function() {
                nuevaEditorialContainer.style.display = this.value === 'otra' ? 'block' : 'none';
            });

            // Manejar la visibilidad de la nueva revista
    if (tituloRevistaSelect) {
        tituloRevistaSelect.addEventListener('change', function() {
            nuevaRevistaContainer.style.display = this.value === 'otra' ? 'block' : 'none';
        });
    }
    
    // Manejar la visibilidad de la nueva carrera
    if (nombreCarreraSelect) {
        nombreCarreraSelect.addEventListener('change', function() {
            nuevaCarreraContainer.style.display = this.value === 'otra' ? 'block' : 'none';
        });
    }

    // Función para agregar autor a la lista de seleccionados
    function agregarAutorALista(autor) {
        // Verificar si el autor ya está en la lista
        const autorExistente = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autor.id}\"]`);
        if (autorExistente) {
            return; // Si el autor ya existe, no lo agregamos
        }

        const autorElement = document.createElement('div');
        autorElement.className = 'list-group-item d-flex justify-content-between align-items-center';
        autorElement.setAttribute('data-autor-id', autor.id);
        
        const autorInfo = document.createElement('div');
        autorInfo.innerHTML = `
            <span class=\"autor-apellidos\">\${autor.apellidos}</span>, 
            <span class=\"autor-nombres\">\${autor.nombres}</span>
                <br>
            <small class=\"text-muted autor-genero\">\${autor.genero}</small>
        `;
        
        const eliminarBtn = document.createElement('button');
        eliminarBtn.type = 'button';
        eliminarBtn.className = 'btn btn-sm btn-danger';
        eliminarBtn.setAttribute('aria-label', `Eliminar autor \${autor.apellidos}, \${autor.nombres}`);
        eliminarBtn.innerHTML = '<i class=\"fas fa-times\"></i>';
        eliminarBtn.onclick = function() {
            eliminarAutor(autor.id);
        };
        
        autorElement.appendChild(autorInfo);
        autorElement.appendChild(eliminarBtn);
        
        autoresSeleccionados.appendChild(autorElement);
        autoresSeleccionadosList.add(autor.id);

        // Desmarcar el autor en el select de disponibles
        const option = autoresDisponibles.querySelector(`option[value=\"\${autor.id}\"]`);
        if (option) {
            option.selected = false;
        }
    }

    // Función para eliminar autor de la lista
    window.eliminarAutor = function(id) {
        const autorElement = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${id}\"]`);
        if (autorElement) {
            autorElement.remove();
            autoresSeleccionadosList.delete(id);
        }
    };

    // Manejar el modal de nuevo autor
    const nuevoAutorModal = document.getElementById('nuevoAutorModal');
    const nuevoAutorForm = document.getElementById('nuevoAutorForm');
    const guardarAutorBtn = document.getElementById('guardarAutor');

    guardarAutorBtn.addEventListener('click', function() {
        if (!nuevoAutorForm.checkValidity()) {
            nuevoAutorForm.reportValidity();
            return;
        }
        
        const apellidos = document.getElementById('apellidos').value;
        const nombres = document.getElementById('nombres').value;
        const genero = document.getElementById('genero').value;

        // Crear un ID temporal para el nuevo autor
        const id = `temp_\${tempAutorId++}`;

        // Agregar el autor a la lista de seleccionados
        const autor = {
            id: id,
                apellidos: apellidos,
                nombres: nombres,
                genero: genero
        };

        agregarAutorALista(autor);
        
        // Limpiar y cerrar el modal
        nuevoAutorForm.reset();
        const modal = bootstrap.Modal.getInstance(nuevoAutorModal);
        if (modal) {
            modal.hide();
        }
    });

    // Función para manejar el envío del formulario
    async function handleSubmit(event) {
        event.preventDefault();
        
        if (isFormSubmitting) {
            // console.log('Formulario ya está siendo enviado');
            return;
        }

        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        isFormSubmitting = true;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Guardando...';

        try {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
        
            // Obtener todos los autores seleccionados
            const autores = Array.from(document.querySelectorAll('#autoresSeleccionados .list-group-item')).map(item => {
                try {
                    const autorId = item.dataset.autorId;
                    const apellidosElement = item.querySelector('.autor-apellidos');
                    const nombresElement = item.querySelector('.autor-nombres');
                    const generoElement = item.querySelector('.autor-genero');

                    if (!apellidosElement || !nombresElement || !generoElement) {
                        console.error('Elementos de autor no encontrados:', item);
                        return null;
                    }

                    const apellidos = apellidosElement.textContent.trim();
                    const nombres = nombresElement.textContent.trim();
                    const genero = generoElement.textContent.trim();

                    if (!apellidos || !nombres || !genero) {
                        console.error('Datos del autor incompletos:', { apellidos, nombres, genero });
                        return null;
                    }

                    const isNewAuthor = autorId.startsWith('temp_');
                    return {
                        id: isNewAuthor ? null : autorId,
                        temp_id: isNewAuthor ? autorId : null,
                        apellidos: apellidos,
                        nombres: nombres,
                        genero: genero,
                        es_nuevo: isNewAuthor
                    };
                } catch (error) {
                    console.error('Error al procesar autor:', error);
                    return null;
                }
            }).filter(autor => autor !== null);

            data.autores = JSON.stringify(autores);
            
            // Manejar el caso de nueva carrera para tesis
            if (data.tipo === 'tesis' && data.nombre_carrera === 'otra') {
                data.nombre_carrera = data.nueva_carrera;
            }

            // Determinar si es una actualización o creación
            const isUpdate = form.action.includes('/edit') || form.querySelector('input[name=\"_method\"]')?.value === 'PUT';
            const url = isUpdate ? form.action.replace('/edit', '') : form.action;

            const response = await fetch(url, {
                method: isUpdate ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: \${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else if (result.duplicados) {
                // Mostrar alerta de duplicados
                mostrarAlertaDuplicados(result.duplicados_list, data);
            } else {
                throw new Error(result.message || 'Error al procesar la solicitud');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al procesar la solicitud. Por favor, intente nuevamente.'
            });
        } finally {
            isFormSubmitting = false;
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar';
        }
    }

    // Función para mostrar alerta de duplicados
    function mostrarAlertaDuplicados(duplicados, formData) {
        let duplicadosHtml = '<div class=\"text-start\">';
        duplicados.forEach((duplicado, index) => {
            duplicadosHtml += `
                <div class=\"mb-2 p-2 border rounded\">
                    <strong>\${index + 1}. \${duplicado.titulo}</strong><br>
                    <small class=\"text-muted\">
                        Año: \${duplicado.anio_publicacion || 'N/A'} | 
                        Editorial: \${duplicado.editorial || 'N/A'} | 
                        Tipo: \${duplicado.tipo || 'N/A'}
                    </small>
                </div>
            `;
        });
        duplicadosHtml += '</div>';

        Swal.fire({
            icon: 'warning',
            title: 'Títulos similares encontrados',
            html: `
                <p>Se encontraron los siguientes títulos similares en la base de datos:</p>
                \${duplicadosHtml}
                <p class=\"mt-3\"><strong>¿Desea continuar con el ingreso de todas formas?</strong></p>
            `,
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar a la ruta de forzar creación
                forzarCreacion(formData);
            }
        });
    }

    // Función para forzar la creación ignorando duplicados
    async function forzarCreacion(formData) {
        try {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Guardando...';

            const response = await fetch('";
        // line 738
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/forzar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: \${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else {
                throw new Error(result.message || 'Error al procesar la solicitud');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al procesar la solicitud. Por favor, intente nuevamente.'
            });
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar';
        }
    }

    // Mostrar duplicados si existen (para peticiones no AJAX)
    ";
        // line 780
        if (($context["duplicados"] ?? null)) {
            // line 781
            yield "        document.addEventListener('DOMContentLoaded', function() {
            mostrarAlertaDuplicados(";
            // line 782
            yield json_encode(($context["duplicados"] ?? null));
            yield ", {});
        });
    ";
        }
        // line 785
        yield "
    // Remover todos los manejadores de eventos anteriores
    const oldSubmitHandler = form.onsubmit;
    form.onsubmit = null;
    
    // Agregar el manejador de eventos al formulario
    form.addEventListener('submit', handleSubmit);

    // Agregar autores seleccionados
    agregarAutorSeleccionado.addEventListener('click', function() {
        const opcionesSeleccionadas = Array.from(autoresDisponibles.selectedOptions);
        opcionesSeleccionadas.forEach(option => {
            const autor = {
                id: option.value,
                apellidos: option.dataset.apellidos,
                nombres: option.dataset.nombres,
                genero: option.dataset.genero
            };
            agregarAutorALista(autor);
            });
        });

    // Funcionalidad de búsqueda de autores
    const buscarAutor = document.getElementById('buscarAutor');
    
    function normalizarTexto(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\\u0300-\\u036f]/g, '') // Remover acentos
            .replace(/[ñ]/g, 'n') // Reemplazar ñ por n
            .replace(/[ü]/g, 'u') // Reemplazar ü por u
            .replace(/[ç]/g, 'c') // Reemplazar ç por c
            .replace(/[^a-z0-9\\s]/g, ''); // Remover caracteres especiales excepto espacios
    }
    
    function filtrarAutores(termino) {
        const opciones = autoresDisponibles.options;
        const terminoNormalizado = normalizarTexto(termino.trim());
        
        // Mostrar todas las opciones si no hay término de búsqueda
        if (terminoNormalizado === '') {
            for (let i = 0; i < opciones.length; i++) {
                opciones[i].style.display = '';
            }
            return;
        }
        
        // Filtrar opciones
        for (let i = 0; i < opciones.length; i++) {
            const opcion = opciones[i];
            const apellidos = normalizarTexto(opcion.dataset.apellidos);
            const nombres = normalizarTexto(opcion.dataset.nombres);
            const textoCompleto = normalizarTexto(`\${opcion.dataset.apellidos}, \${opcion.dataset.nombres}`);
            
            if (apellidos.includes(terminoNormalizado) || 
                nombres.includes(terminoNormalizado) || 
                textoCompleto.includes(terminoNormalizado)) {
                opcion.style.display = '';
            } else {
                opcion.style.display = 'none';
            }
        }
    }
    
    // Evento para buscar al escribir
    buscarAutor.addEventListener('input', function() {
        filtrarAutores(this.value);
    });
    
    // Limpiar búsqueda cuando se hace clic en el campo
    buscarAutor.addEventListener('focus', function() {
        if (this.value === '') {
            filtrarAutores('');
        }
    });
    
    // Limpiar búsqueda cuando se presiona Escape
    buscarAutor.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            filtrarAutores('');
            this.blur();
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
        return "bibliografias_declaradas/form.twig";
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
        return array (  1135 => 785,  1129 => 782,  1126 => 781,  1124 => 780,  1079 => 738,  687 => 348,  676 => 347,  620 => 293,  617 => 292,  606 => 287,  601 => 285,  596 => 283,  592 => 282,  586 => 280,  581 => 279,  579 => 278,  556 => 257,  545 => 254,  541 => 253,  537 => 252,  533 => 251,  528 => 250,  524 => 249,  503 => 231,  489 => 220,  476 => 210,  464 => 201,  452 => 191,  437 => 189,  433 => 188,  424 => 182,  406 => 166,  397 => 163,  388 => 162,  384 => 161,  381 => 160,  377 => 158,  368 => 155,  359 => 154,  355 => 153,  352 => 152,  350 => 151,  336 => 140,  320 => 127,  306 => 115,  291 => 113,  287 => 112,  270 => 100,  264 => 99,  258 => 98,  252 => 97,  246 => 96,  240 => 95,  230 => 88,  219 => 82,  213 => 81,  201 => 74,  195 => 73,  189 => 72,  180 => 66,  171 => 60,  159 => 53,  150 => 47,  138 => 39,  134 => 37,  132 => 36,  121 => 35,  115 => 31,  109 => 29,  107 => 28,  99 => 23,  96 => 22,  92 => 20,  88 => 18,  86 => 17,  81 => 14,  74 => 13,  67 => 7,  63 => 5,  60 => 4,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}
    {% if bibliografia.id %}
        Editar Bibliografía Declarada
    {% else %}
        Nueva Bibliografía Declarada
    {% endif %}
{% endblock %}



{% block content %}
<div class=\"container mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>
            {% if bibliografia.id %}
                Editar Bibliografía Declarada
            {% else %}
                Nueva Bibliografía Declarada
            {% endif %}
        </h1>
        <a href=\"{{ app_url }}bibliografias-declaradas\" class=\"btn btn-secondary\">
            <i class=\"fas fa-arrow-left\"></i> Volver
        </a>
    </div>

    {% if error %}
        <div class=\"alert alert-danger\">{{ error }}</div>
    {% endif %}

    <div class=\"card\">
        <div class=\"card-body\">
            <form id=\"bibliografiaForm\" method=\"POST\" 
                  action=\"{% if bibliografia.id %}{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}{% else %}{{ app_url }}bibliografias-declaradas{% endif %}\">
                {% if bibliografia.id %}
                    <input type=\"hidden\" name=\"_method\" value=\"PUT\">
                {% endif %}
                <input type=\"hidden\" name=\"_token\" id=\"formToken\" value=\"{{ session.form_token|default('') }}\">

                <div class=\"row\">
                    <!-- Primera columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"titulo\" class=\"form-label\">Título <span class=\"text-danger\">*</span></label>
                            <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" 
                                   value=\"{{ bibliografia.titulo }}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"anio_publicacion\" class=\"form-label\">Año de Edición <span class=\"text-danger\">*</span></label>
                            <input type=\"number\" class=\"form-control\" id=\"anio_publicacion\" name=\"anio_publicacion\" 
                                   value=\"{{ bibliografia.anio_publicacion }}\" min=\"1900\" max=\"{{ 'now'|date('Y') }}\" 
                                   maxlength=\"4\" pattern=\"\\d{4}\" required>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"edicion\" class=\"form-label\">Edición</label>
                            <input type=\"text\" class=\"form-control\" id=\"edicion\" name=\"edicion\" 
                                   value=\"{{ bibliografia.edicion }}\">
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"url\" class=\"form-label\">URL</label>
                            <input type=\"url\" class=\"form-control\" id=\"url\" name=\"url\" 
                                   value=\"{{ bibliografia.url }}\">
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"formato\" class=\"form-label\">Formato <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"formato\" name=\"formato\" required>
                                <option value=\"impreso\" {% if bibliografia.formato == 'impreso' %}selected{% endif %}>Impreso</option>
                                <option value=\"electronico\" {% if bibliografia.formato == 'electronico' %}selected{% endif %}>Electrónico</option>
                                <option value=\"ambos\" {% if bibliografia.formato == 'ambos' %}selected{% endif %}>Ambos</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"estado\" class=\"form-label\">Estado <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"estado\" name=\"estado\" required>
                                <option value=\"1\" {% if not bibliografia.id or bibliografia.estado == 1 %}selected{% endif %}>Activo</option>
                                <option value=\"0\" {% if bibliografia.id and bibliografia.estado == 0 %}selected{% endif %}>Inactivo</option>
                            </select>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"nota\" class=\"form-label\">Nota</label>
                            <textarea class=\"form-control\" id=\"nota\" name=\"nota\" rows=\"3\">{{ bibliografia.nota }}</textarea>
                        </div>

                        <div class=\"mb-3\">
                            <label for=\"tipo\" class=\"form-label\">Tipo <span class=\"text-danger\">*</span></label>
                            <select class=\"form-select\" id=\"tipo\" name=\"tipo\" required>
                                <option value=\"\">Seleccione un tipo</option>
                                <option value=\"libro\" {% if bibliografia.tipo == 'libro' %}selected{% endif %}>Libro</option>
                                <option value=\"articulo\" {% if bibliografia.tipo == 'articulo' %}selected{% endif %}>Artículo</option>
                                <option value=\"tesis\" {% if bibliografia.tipo == 'tesis' %}selected{% endif %}>Tesis</option>
                                <option value=\"software\" {% if bibliografia.tipo == 'software' %}selected{% endif %}>Software</option>
                                <option value=\"sitio_web\" {% if bibliografia.tipo == 'sitio_web' %}selected{% endif %}>Sitio Web</option>
                                <option value=\"generico\" {% if bibliografia.tipo == 'generico' %}selected{% endif %}>Genérico</option>
                            </select>
                        </div>
                        </div>

                    <!-- Segunda columna -->
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label for=\"editorial\" class=\"form-label\">Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"buscarEditorial\" placeholder=\"Buscar editorial...\" style=\"font-size: 0.9rem;\">
                            <select class=\"form-select\" id=\"editorial\" name=\"editorial\" style=\"margin-top: 0.5rem;\" size=\"5\">
                                <option value=\"\">Seleccione una editorial</option>
                                {% for editorial in editoriales %}
                                    <option value=\"{{ editorial }}\" {% if bibliografia.editorial == editorial %}selected{% endif %}>{{ editorial }}</option>
                                {% endfor %}
                                <option value=\"otra\">Otra editorial...</option>
                            </select>
                        </div>

                        <div class=\"mb-3\" id=\"nuevaEditorialContainer\" style=\"display: none;\">
                            <label for=\"nueva_editorial\" class=\"form-label\">Nueva Editorial</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_editorial\" name=\"nueva_editorial\">
                        </div>
                        
                        <div class=\"mb-3\">
                            <label for=\"doi\" class=\"form-label\">DOI</label>
                            <input type=\"text\" class=\"form-control\" id=\"doi\" name=\"doi\" 
                                   value=\"{{ bibliografia.doi }}\" placeholder=\"10.1000/182\">
                        </div>
                        </div>
                    </div>

                <!-- Campos específicos según el tipo -->
                <div id=\"camposEspecificos\">
                    <!-- Libro -->
                    <div class=\"tipo-campo\" id=\"camposLibro\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Libro</h3>
                        <div class=\"mb-3\">
                            <label for=\"isbn\" class=\"form-label\">ISBN</label>
                            <input type=\"text\" class=\"form-control\" id=\"isbn\" name=\"isbn\" 
                                   value=\"{{ bibliografia.isbn }}\">
                        </div>
                        </div>

                    <!-- Tesis -->
                    <div class=\"tipo-campo\" id=\"camposTesis\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos de la Tesis</h3>
                        <div class=\"mb-3\">
                            <label for=\"nombre_carrera\" class=\"form-label\">Carrera</label>
                            <select class=\"form-select\" id=\"nombre_carrera\" name=\"nombre_carrera\">
                                <option value=\"\">Seleccione una carrera</option>
                                {% if carrerasExistentes is defined %}
                                    <optgroup label=\"Carreras existentes en tesis\">
                                        {% for carrera in carrerasExistentes %}
                                            <option value=\"{{ carrera }}\" {% if bibliografia.nombre_carrera == carrera %}selected{% endif %}>
                                                {{ carrera }}
                                            </option>
                                        {% endfor %}
                                    </optgroup>
                                {% endif %}
                                <optgroup label=\"Carreras del sistema\">
                                    {% for carrera in carreras %}
                                        <option value=\"{{ carrera.nombre }}\" {% if bibliografia.nombre_carrera == carrera.nombre %}selected{% endif %}>
                                            {{ carrera.nombre }}
                                        </option>
                                    {% endfor %}
                                </optgroup>
                                <option value=\"otra\">Otra carrera...</option>
                            </select>
                        </div>
                        <div class=\"mb-3\" id=\"nuevaCarreraContainer\" style=\"display: none;\">
                            <label for=\"nueva_carrera\" class=\"form-label\">Nueva Carrera</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_carrera\" name=\"nueva_carrera\" placeholder=\"Ingrese el nombre de la nueva carrera\">
                        </div>
                        </div>

                    <!-- Artículo -->
                    <div class=\"tipo-campo\" id=\"camposArticulo\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Artículo</h3>
                        <div class=\"mb-3\">
                            <label for=\"issn\" class=\"form-label\">ISSN</label>
                            <input type=\"text\" class=\"form-control\" id=\"issn\" name=\"issn\" 
                                   value=\"{{ bibliografia.issn }}\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"titulo_revista\" class=\"form-label\">Título de la Revista</label>
                            <select class=\"form-select\" id=\"titulo_revista\" name=\"titulo_revista\">
                                <option value=\"\">Seleccione una revista</option>
                                {% for revista in revistas %}
                                    <option value=\"{{ revista }}\" {% if bibliografia.titulo_revista == revista %}selected{% endif %}>{{ revista }}</option>
                                {% endfor %}
                                <option value=\"otra\">Otra...</option>
                            </select>
                        </div>
                        <div class=\"mb-3\" id=\"nuevaRevistaContainer\" style=\"display: none;\">
                            <label for=\"nueva_revista\" class=\"form-label\">Nueva Revista</label>
                            <input type=\"text\" class=\"form-control\" id=\"nueva_revista\" name=\"nueva_revista\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"cronologia\" class=\"form-label\">Cronología</label>
                            <input type=\"text\" class=\"form-control\" id=\"cronologia\" name=\"cronologia\" 
                                   value=\"{{ bibliografia.cronologia }}\">
                        </div>
                    </div>

                    <!-- Genérico -->
                    <div class=\"tipo-campo\" id=\"camposGenerico\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos Genéricos</h3>
                        <div class=\"mb-3\">
                            <label for=\"descripcion\" class=\"form-label\">Descripción</label>
                            <textarea class=\"form-control\" id=\"descripcion\" name=\"descripcion\" rows=\"3\">{{ bibliografia.descripcion }}</textarea>
                        </div>
                        </div>

                    <!-- Sitio Web -->
                    <div class=\"tipo-campo\" id=\"camposSitioWeb\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Sitio Web</h3>
                            <div class=\"mb-3\">
                            <label for=\"fecha_consulta\" class=\"form-label\">Fecha de Consulta <span class=\"text-danger\">*</span></label>
                            <input type=\"date\" class=\"form-control\" id=\"fecha_consulta\" name=\"fecha_consulta\" 
                                   value=\"{{ bibliografia.fecha_consulta|date('Y-m-d') }}\" required>
                            <small class=\"form-text text-muted\">Seleccione la fecha en que se consultó el sitio web</small>
                                </div>
                            </div>

                    <!-- Software -->
                    <div class=\"tipo-campo\" id=\"camposSoftware\" style=\"display: none;\">
                        <h3 class=\"mb-3\">Datos del Software</h3>
                        <div class=\"mb-3\">
                            <label for=\"version\" class=\"form-label\">Versión</label>
                            <input type=\"text\" class=\"form-control\" id=\"version\" name=\"version\" 
                                   value=\"{{ bibliografia.version }}\">
                        </div>
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
                                <div class=\"mb-2\">
                                    <input type=\"text\" class=\"form-control\" id=\"buscarAutor\" placeholder=\"Buscar autores por nombre o apellido...\" style=\"font-size: 0.9rem;\">
                                </div>
                                <select class=\"form-select\" id=\"autoresDisponibles\" multiple size=\"10\" style=\"height: auto;\">
                        {% for autor in autores %}
                                        <option value=\"{{ autor.id }}\" 
                                                data-apellidos=\"{{ autor.apellidos }}\" 
                                                data-nombres=\"{{ autor.nombres }}\" 
                                                data-genero=\"{{ autor.genero }}\">
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
                                        {% if bibliografia.autores is defined %}
                                            {% for autor in bibliografia.autores %}
                                            <div class=\"list-group-item d-flex justify-content-between align-items-center\" data-autor-id=\"{{ autor.id }}\">
                                                <div>
                                                        <span class=\"autor-apellidos\">{{ autor.apellidos }}</span>, 
                                                        <span class=\"autor-nombres\">{{ autor.nombres }}</span>
                                                    <br>
                                                        <small class=\"text-muted autor-genero\">{{ autor.genero }}</small>
                                                </div>
                                                <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"eliminarAutor('{{ autor.id }}')\">
                                                    <i class=\"fas fa-times\"></i>
                                                </button>
                            </div>
                        {% endfor %}
                                        {% endif %}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"text-end mt-4\">
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fas fa-save\"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Nuevo Autor -->
<div class=\"modal fade\" id=\"nuevoAutorModal\" tabindex=\"-1\" aria-labelledby=\"nuevoAutorModalLabel\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"nuevoAutorModalLabel\">Nuevo Autor</h5>
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
            </div>
            <div class=\"modal-body\">
                <form id=\"nuevoAutorForm\" class=\"needs-validation\" novalidate>
                    <div class=\"mb-3\">
                        <label for=\"apellidos\" class=\"form-label\">Apellidos <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"apellidos\" name=\"apellidos\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"nombres\" class=\"form-label\">Nombres <span class=\"text-danger\">*</span></label>
                        <input type=\"text\" class=\"form-control\" id=\"nombres\" name=\"nombres\" required>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"genero\" class=\"form-label\">Género <span class=\"text-danger\">*</span></label>
                        <select class=\"form-select\" id=\"genero\" name=\"genero\" required>
                            <option value=\"\">Seleccione un género</option>
                            <option value=\"masculino\">Masculino</option>
                            <option value=\"femenino\">Femenino</option>
                            <option value=\"otro\">Otro</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancelar</button>
                <button type=\"button\" class=\"btn btn-primary\" id=\"guardarAutor\">Agregar Temporalmente</button>
            </div>
        </div>
    </div>
</div>

{% block scripts %}
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
// Variables globales
let isFormSubmitting = false;
let tempAutorId = 1;

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bibliografiaForm');
    const autoresDisponibles = document.getElementById('autoresDisponibles');
    const autoresSeleccionados = document.getElementById('autoresSeleccionados');
    const agregarAutorSeleccionado = document.getElementById('agregarAutorSeleccionado');
    const tipoSelect = document.getElementById('tipo');
    const camposEspecificos = document.getElementById('camposEspecificos');
    const tipoCampos = document.querySelectorAll('.tipo-campo');
                const editorialSelect = document.getElementById('editorial');
            const nuevaEditorialContainer = document.getElementById('nuevaEditorialContainer');
            const buscarEditorial = document.getElementById('buscarEditorial');
    const tituloRevistaSelect = document.getElementById('titulo_revista');
    const nuevaRevistaContainer = document.getElementById('nuevaRevistaContainer');
    const nombreCarreraSelect = document.getElementById('nombre_carrera');
    const nuevaCarreraContainer = document.getElementById('nuevaCarreraContainer');
    let autoresSeleccionadosList = new Set();
    let submitButton = form.querySelector('button[type=\"submit\"]');

    // Inicializar autores existentes
    document.querySelectorAll('#autoresSeleccionados .list-group-item').forEach(item => {
        const autorId = item.getAttribute('data-autor-id');
        if (autorId) {
            autoresSeleccionadosList.add(autorId);
            // Desmarcar el autor en el select de disponibles
            const option = autoresDisponibles.querySelector(`option[value=\"\${autorId}\"]`);
            if (option) {
                option.selected = false;
            }
        }
    });

    // Función para mostrar campos específicos según el tipo
    function mostrarCamposEspecificos() {
        // Ocultar todos los campos específicos
        tipoCampos.forEach(campo => {
            campo.style.display = 'none';
        });
        
        // Mostrar los campos correspondientes al tipo seleccionado
        const tipoSeleccionado = tipoSelect.value;
        if (tipoSeleccionado) {
            // Convertir el tipo a formato camelCase para el ID
            const tipoFormateado = tipoSeleccionado.split('_').map((word, index) => {
                return index === 0 ? word : word.charAt(0).toUpperCase() + word.slice(1);
            }).join('');
            
            const camposTipo = document.getElementById('campos' + tipoFormateado.charAt(0).toUpperCase() + tipoFormateado.slice(1));
            if (camposTipo) {
                camposTipo.style.display = 'block';
                
                // Si es sitio web, asegurarse de que el campo de fecha sea requerido
                if (tipoSeleccionado === 'sitio_web') {
                    const fechaConsulta = document.getElementById('fecha_consulta');
                    if (fechaConsulta) {
                        fechaConsulta.required = true;
                    }
                }
            }
        }
    }
    
    // Mostrar campos específicos al cargar la página
    mostrarCamposEspecificos();
    
    // Mostrar campos específicos cuando cambie el tipo
    tipoSelect.addEventListener('change', mostrarCamposEspecificos);
    
                // Funcionalidad de búsqueda de editoriales
            function filtrarEditoriales(termino) {
                const opciones = editorialSelect.options;
                const terminoNormalizado = normalizarTexto(termino.trim());
                
                // Mostrar todas las opciones si no hay término de búsqueda
                if (terminoNormalizado === '') {
                    for (let i = 0; i < opciones.length; i++) {
                        opciones[i].style.display = '';
                    }
                    return;
                }
                
                // Filtrar opciones
                for (let i = 0; i < opciones.length; i++) {
                    const opcion = opciones[i];
                    const textoEditorial = normalizarTexto(opcion.textContent);
                    
                    if (textoEditorial.includes(terminoNormalizado)) {
                        opcion.style.display = '';
                    } else {
                        opcion.style.display = 'none';
                    }
                }
            }
            
            // Evento para buscar al escribir
            buscarEditorial.addEventListener('input', function() {
                filtrarEditoriales(this.value);
            });
            
            // Limpiar búsqueda cuando se hace clic en el campo
            buscarEditorial.addEventListener('focus', function() {
                if (this.value === '') {
                    filtrarEditoriales('');
                }
            });
            
            // Limpiar búsqueda cuando se presiona Escape
            buscarEditorial.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    filtrarEditoriales('');
                    this.blur();
                }
            });
    
                // Manejar la visibilidad de la nueva editorial
            editorialSelect.addEventListener('change', function() {
                nuevaEditorialContainer.style.display = this.value === 'otra' ? 'block' : 'none';
            });

            // Manejar la visibilidad de la nueva revista
    if (tituloRevistaSelect) {
        tituloRevistaSelect.addEventListener('change', function() {
            nuevaRevistaContainer.style.display = this.value === 'otra' ? 'block' : 'none';
        });
    }
    
    // Manejar la visibilidad de la nueva carrera
    if (nombreCarreraSelect) {
        nombreCarreraSelect.addEventListener('change', function() {
            nuevaCarreraContainer.style.display = this.value === 'otra' ? 'block' : 'none';
        });
    }

    // Función para agregar autor a la lista de seleccionados
    function agregarAutorALista(autor) {
        // Verificar si el autor ya está en la lista
        const autorExistente = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${autor.id}\"]`);
        if (autorExistente) {
            return; // Si el autor ya existe, no lo agregamos
        }

        const autorElement = document.createElement('div');
        autorElement.className = 'list-group-item d-flex justify-content-between align-items-center';
        autorElement.setAttribute('data-autor-id', autor.id);
        
        const autorInfo = document.createElement('div');
        autorInfo.innerHTML = `
            <span class=\"autor-apellidos\">\${autor.apellidos}</span>, 
            <span class=\"autor-nombres\">\${autor.nombres}</span>
                <br>
            <small class=\"text-muted autor-genero\">\${autor.genero}</small>
        `;
        
        const eliminarBtn = document.createElement('button');
        eliminarBtn.type = 'button';
        eliminarBtn.className = 'btn btn-sm btn-danger';
        eliminarBtn.setAttribute('aria-label', `Eliminar autor \${autor.apellidos}, \${autor.nombres}`);
        eliminarBtn.innerHTML = '<i class=\"fas fa-times\"></i>';
        eliminarBtn.onclick = function() {
            eliminarAutor(autor.id);
        };
        
        autorElement.appendChild(autorInfo);
        autorElement.appendChild(eliminarBtn);
        
        autoresSeleccionados.appendChild(autorElement);
        autoresSeleccionadosList.add(autor.id);

        // Desmarcar el autor en el select de disponibles
        const option = autoresDisponibles.querySelector(`option[value=\"\${autor.id}\"]`);
        if (option) {
            option.selected = false;
        }
    }

    // Función para eliminar autor de la lista
    window.eliminarAutor = function(id) {
        const autorElement = document.querySelector(`#autoresSeleccionados [data-autor-id=\"\${id}\"]`);
        if (autorElement) {
            autorElement.remove();
            autoresSeleccionadosList.delete(id);
        }
    };

    // Manejar el modal de nuevo autor
    const nuevoAutorModal = document.getElementById('nuevoAutorModal');
    const nuevoAutorForm = document.getElementById('nuevoAutorForm');
    const guardarAutorBtn = document.getElementById('guardarAutor');

    guardarAutorBtn.addEventListener('click', function() {
        if (!nuevoAutorForm.checkValidity()) {
            nuevoAutorForm.reportValidity();
            return;
        }
        
        const apellidos = document.getElementById('apellidos').value;
        const nombres = document.getElementById('nombres').value;
        const genero = document.getElementById('genero').value;

        // Crear un ID temporal para el nuevo autor
        const id = `temp_\${tempAutorId++}`;

        // Agregar el autor a la lista de seleccionados
        const autor = {
            id: id,
                apellidos: apellidos,
                nombres: nombres,
                genero: genero
        };

        agregarAutorALista(autor);
        
        // Limpiar y cerrar el modal
        nuevoAutorForm.reset();
        const modal = bootstrap.Modal.getInstance(nuevoAutorModal);
        if (modal) {
            modal.hide();
        }
    });

    // Función para manejar el envío del formulario
    async function handleSubmit(event) {
        event.preventDefault();
        
        if (isFormSubmitting) {
            // console.log('Formulario ya está siendo enviado');
            return;
        }

        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        isFormSubmitting = true;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Guardando...';

        try {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
        
            // Obtener todos los autores seleccionados
            const autores = Array.from(document.querySelectorAll('#autoresSeleccionados .list-group-item')).map(item => {
                try {
                    const autorId = item.dataset.autorId;
                    const apellidosElement = item.querySelector('.autor-apellidos');
                    const nombresElement = item.querySelector('.autor-nombres');
                    const generoElement = item.querySelector('.autor-genero');

                    if (!apellidosElement || !nombresElement || !generoElement) {
                        console.error('Elementos de autor no encontrados:', item);
                        return null;
                    }

                    const apellidos = apellidosElement.textContent.trim();
                    const nombres = nombresElement.textContent.trim();
                    const genero = generoElement.textContent.trim();

                    if (!apellidos || !nombres || !genero) {
                        console.error('Datos del autor incompletos:', { apellidos, nombres, genero });
                        return null;
                    }

                    const isNewAuthor = autorId.startsWith('temp_');
                    return {
                        id: isNewAuthor ? null : autorId,
                        temp_id: isNewAuthor ? autorId : null,
                        apellidos: apellidos,
                        nombres: nombres,
                        genero: genero,
                        es_nuevo: isNewAuthor
                    };
                } catch (error) {
                    console.error('Error al procesar autor:', error);
                    return null;
                }
            }).filter(autor => autor !== null);

            data.autores = JSON.stringify(autores);
            
            // Manejar el caso de nueva carrera para tesis
            if (data.tipo === 'tesis' && data.nombre_carrera === 'otra') {
                data.nombre_carrera = data.nueva_carrera;
            }

            // Determinar si es una actualización o creación
            const isUpdate = form.action.includes('/edit') || form.querySelector('input[name=\"_method\"]')?.value === 'PUT';
            const url = isUpdate ? form.action.replace('/edit', '') : form.action;

            const response = await fetch(url, {
                method: isUpdate ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: \${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else if (result.duplicados) {
                // Mostrar alerta de duplicados
                mostrarAlertaDuplicados(result.duplicados_list, data);
            } else {
                throw new Error(result.message || 'Error al procesar la solicitud');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al procesar la solicitud. Por favor, intente nuevamente.'
            });
        } finally {
            isFormSubmitting = false;
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar';
        }
    }

    // Función para mostrar alerta de duplicados
    function mostrarAlertaDuplicados(duplicados, formData) {
        let duplicadosHtml = '<div class=\"text-start\">';
        duplicados.forEach((duplicado, index) => {
            duplicadosHtml += `
                <div class=\"mb-2 p-2 border rounded\">
                    <strong>\${index + 1}. \${duplicado.titulo}</strong><br>
                    <small class=\"text-muted\">
                        Año: \${duplicado.anio_publicacion || 'N/A'} | 
                        Editorial: \${duplicado.editorial || 'N/A'} | 
                        Tipo: \${duplicado.tipo || 'N/A'}
                    </small>
                </div>
            `;
        });
        duplicadosHtml += '</div>';

        Swal.fire({
            icon: 'warning',
            title: 'Títulos similares encontrados',
            html: `
                <p>Se encontraron los siguientes títulos similares en la base de datos:</p>
                \${duplicadosHtml}
                <p class=\"mt-3\"><strong>¿Desea continuar con el ingreso de todas formas?</strong></p>
            `,
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar a la ruta de forzar creación
                forzarCreacion(formData);
            }
        });
    }

    // Función para forzar la creación ignorando duplicados
    async function forzarCreacion(formData) {
        try {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class=\"fas fa-spinner fa-spin\"></i> Guardando...';

            const response = await fetch('{{ app_url }}bibliografias-declaradas/forzar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: \${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else {
                throw new Error(result.message || 'Error al procesar la solicitud');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al procesar la solicitud. Por favor, intente nuevamente.'
            });
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar';
        }
    }

    // Mostrar duplicados si existen (para peticiones no AJAX)
    {% if duplicados %}
        document.addEventListener('DOMContentLoaded', function() {
            mostrarAlertaDuplicados({{ duplicados|json_encode|raw }}, {});
        });
    {% endif %}

    // Remover todos los manejadores de eventos anteriores
    const oldSubmitHandler = form.onsubmit;
    form.onsubmit = null;
    
    // Agregar el manejador de eventos al formulario
    form.addEventListener('submit', handleSubmit);

    // Agregar autores seleccionados
    agregarAutorSeleccionado.addEventListener('click', function() {
        const opcionesSeleccionadas = Array.from(autoresDisponibles.selectedOptions);
        opcionesSeleccionadas.forEach(option => {
            const autor = {
                id: option.value,
                apellidos: option.dataset.apellidos,
                nombres: option.dataset.nombres,
                genero: option.dataset.genero
            };
            agregarAutorALista(autor);
            });
        });

    // Funcionalidad de búsqueda de autores
    const buscarAutor = document.getElementById('buscarAutor');
    
    function normalizarTexto(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\\u0300-\\u036f]/g, '') // Remover acentos
            .replace(/[ñ]/g, 'n') // Reemplazar ñ por n
            .replace(/[ü]/g, 'u') // Reemplazar ü por u
            .replace(/[ç]/g, 'c') // Reemplazar ç por c
            .replace(/[^a-z0-9\\s]/g, ''); // Remover caracteres especiales excepto espacios
    }
    
    function filtrarAutores(termino) {
        const opciones = autoresDisponibles.options;
        const terminoNormalizado = normalizarTexto(termino.trim());
        
        // Mostrar todas las opciones si no hay término de búsqueda
        if (terminoNormalizado === '') {
            for (let i = 0; i < opciones.length; i++) {
                opciones[i].style.display = '';
            }
            return;
        }
        
        // Filtrar opciones
        for (let i = 0; i < opciones.length; i++) {
            const opcion = opciones[i];
            const apellidos = normalizarTexto(opcion.dataset.apellidos);
            const nombres = normalizarTexto(opcion.dataset.nombres);
            const textoCompleto = normalizarTexto(`\${opcion.dataset.apellidos}, \${opcion.dataset.nombres}`);
            
            if (apellidos.includes(terminoNormalizado) || 
                nombres.includes(terminoNormalizado) || 
                textoCompleto.includes(terminoNormalizado)) {
                opcion.style.display = '';
            } else {
                opcion.style.display = 'none';
            }
        }
    }
    
    // Evento para buscar al escribir
    buscarAutor.addEventListener('input', function() {
        filtrarAutores(this.value);
    });
    
    // Limpiar búsqueda cuando se hace clic en el campo
    buscarAutor.addEventListener('focus', function() {
        if (this.value === '') {
            filtrarAutores('');
        }
    });
    
    // Limpiar búsqueda cuando se presiona Escape
    buscarAutor.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            filtrarAutores('');
            this.blur();
        }
    });
});
</script>
{% endblock %}
{% endblock %} ", "bibliografias_declaradas/form.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/form.twig");
    }
}
