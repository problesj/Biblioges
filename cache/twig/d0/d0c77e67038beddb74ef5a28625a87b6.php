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

/* bibliografias_declaradas/buscar_catalogo.twig */
class __TwigTemplate_721ac0a882d164fc2af762d79d332299 extends Template
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
        $this->parent = $this->loadTemplate("base.twig", "bibliografias_declaradas/buscar_catalogo.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Buscar en Catálogo - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 3), "html", null, true);
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
                    <h5 class=\"card-title mb-0\">Datos de la Bibliografía Declarada</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <p><strong>Tipo de Bibliografía:</strong> ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 16)), "html", null, true);
        yield "</p>
                            <p><strong>Título:</strong> ";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 17), "html", null, true);
        yield "</p>
                            <p><strong>Autor(es):</strong> ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 18), "html", null, true);
        yield "</p>
                            <p><strong>Año de Edición:</strong> ";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "anio_publicacion", [], "any", false, false, false, 19), "html", null, true);
        yield "</p>
                            <p><strong>Editorial:</strong> ";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "editorial", [], "any", false, false, false, 20), "html", null, true);
        yield "</p>
                        </div>
                        <div class=\"col-md-6\">
                            <p><strong>Edición:</strong> ";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "edicion", [], "any", false, false, false, 23), "html", null, true);
        yield "</p>
                            <p><strong>Formato:</strong> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "formato", [], "any", false, false, false, 24)), "html", null, true);
        yield "</p>
                            <div class=\"mt-3\">
                                <h6>Datos Específicos:</h6>
                                ";
        // line 27
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 27) == "libro")) {
            // line 28
            yield "                                    <p><strong>ISBN:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "isbn", [], "any", false, false, false, 28), "html", null, true);
            yield "</p>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 29
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 29) == "articulo")) {
            // line 30
            yield "                                    <p><strong>ISSN:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "issn", [], "any", false, false, false, 30), "html", null, true);
            yield "</p>
                                    <p><strong>Revista:</strong> ";
            // line 31
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo_revista", [], "any", false, false, false, 31), "html", null, true);
            yield "</p>
                                    <p><strong>Cronología:</strong> ";
            // line 32
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "cronologia", [], "any", false, false, false, 32), "html", null, true);
            yield "</p>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 33
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 33) == "tesis")) {
            // line 34
            yield "                                    <p><strong>Carrera:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "carrera_nombre", [], "any", false, false, false, 34), "html", null, true);
            yield "</p>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 35
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 35) == "sitio_web")) {
            // line 36
            yield "                                    <p><strong>Fecha de Consulta:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "fecha_consulta", [], "any", false, false, false, 36), "html", null, true);
            yield "</p>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 37
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 37) == "software")) {
            // line 38
            yield "                                    <p><strong>Versión:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "version", [], "any", false, false, false, 38), "html", null, true);
            yield "</p>
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 39
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 39) == "generico")) {
            // line 40
            yield "                                    <p><strong>Descripción:</strong> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "descripcion", [], "any", false, false, false, 40), "html", null, true);
            yield "</p>
                                ";
        }
        // line 42
        yield "                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row mt-4\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"card-title mb-0\">Buscar en Catálogo</h5>
                </div>
                <div class=\"card-body\">
                    <form id=\"searchForm\" class=\"mb-4\">
                        <div class=\"row\">
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"titulo\">Título</label>
                                    <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" value=\"";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "titulo", [], "any", false, false, false, 62), "html", null, true);
        yield "\">
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"autor\">Autor</label>
                                    <input type=\"text\" class=\"form-control\" id=\"autor\" name=\"autor\" value=\"";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "autores", [], "any", false, false, false, 68), ";")), "html", null, true);
        yield "\">
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"busqueda_adicional\">Búsqueda Adicional</label>
                                    <input type=\"text\" class=\"form-control\" id=\"busqueda_adicional\" name=\"busqueda_adicional\" placeholder=\"Editorial u otra palabra clave\">
                                </div>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"tipo_recurso\">Tipo de Recurso</label>
                                    <select class=\"form-control\" id=\"tipo_recurso\" name=\"tipo_recurso\">
                                        <option value=\"\">Todos</option>
                                        ";
        // line 84
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 84) == "libro")) {
            // line 85
            yield "                                            <option value=\"books\" selected>Libros</option>
                                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 86
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 86) == "articulo")) {
            // line 87
            yield "                                            <option value=\"articles\" selected>Artículos</option>
                                        ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 88
($context["bibliografia"] ?? null), "tipo", [], "any", false, false, false, 88) == "tesis")) {
            // line 89
            yield "                                            <option value=\"dissertations\" selected>Tesis</option>
                                        ";
        } else {
            // line 91
            yield "                                            <option value=\"books\">Libros</option>
                                            <option value=\"articles\">Artículos</option>
                                            <option value=\"dissertations\">Tesis</option>
                                        ";
        }
        // line 95
        yield "                                    </select>
                                </div>
                            </div>
                            <div class=\"col-md-2\">
                                <div class=\"form-group\">
                                    <label>&nbsp;</label>
                                    <button type=\"submit\" class=\"btn btn-primary btn-block\">
                                        <i class=\"fas fa-search\"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id=\"searchResults\" class=\"mt-4\">
                        <!-- Los resultados se mostrarán aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Progreso -->
<div class=\"modal fade\" id=\"progressModal\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" aria-labelledby=\"progressModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-dialog-centered\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"progressModalLabel\">Guardando Bibliografías</h5>
            </div>
            <div class=\"modal-body\">
                <div class=\"progress mb-3\">
                    <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: 0%\"></div>
                </div>
                <p id=\"progressText\" class=\"text-center mb-0\">Iniciando proceso...</p>
            </div>
        </div>
    </div>
</div>
";
        yield from [];
    }

    // line 136
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_scripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 137
        yield "<script>
document.getElementById('searchForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        titulo: document.getElementById('titulo').value,
        autor: document.getElementById('autor').value,
        busqueda_adicional: document.getElementById('busqueda_adicional').value,
        tipo_recurso: document.getElementById('tipo_recurso').value
    };

    const resultsDiv = document.getElementById('searchResults');
    resultsDiv.innerHTML = '<div class=\"text-center\"><div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\">Buscando...</span></div></div>';

    try {
        console.log('Enviando petición con datos:', formData);
        
        const response = await fetch('";
        // line 154
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["app_url"] ?? null), "html", null, true);
        yield "bibliografias-declaradas/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["bibliografia"] ?? null), "id", [], "any", false, false, false, 154), "html", null, true);
        yield "/buscarCatalogo/api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });

        console.log('Respuesta recibida:', response);
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));

        if (!response.ok) {
            throw new Error(`HTTP error! status: \${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            console.error('Content-Type incorrecto:', contentType);
            throw new Error('El servidor no devolvió una respuesta JSON válida');
        }

        const data = await response.json();
        console.log('Datos recibidos:', data);
        
        if (!data.success) {
            throw new Error(data.message || 'Error al buscar en el catálogo');
        }

        resultsDiv.innerHTML = '';

        if (data.results && data.results.length > 0) {
            const table = document.createElement('table');
            table.className = 'table table-striped';
            
            // Crear encabezado de la tabla
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th><input type=\"checkbox\" id=\"selectAll\"></th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Editorial</th>
                    <th>Formato</th>
                    <th>Acciones</th>
                </tr>
            `;
            table.appendChild(thead);

            // Crear cuerpo de la tabla
            const tbody = document.createElement('tbody');
            data.results.forEach(result => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type=\"checkbox\" class=\"result-checkbox\" data-id=\"\${result.catalogo_id}\" data-context=\"\${result.context}\" data-adaptor=\"\${result.adaptor}\" data-sourcerecordid=\"\${result.sourcerecordid}\" data-url=\"\${result.url}\"></td>
                    <td>\${result.titulo}</td>
                    <td>\${result.autores}</td>
                    <td>\${result.anio}</td>
                    <td>\${result.editorial}</td>
                    <td>\${result.formato}</td>
                    <td>
                        <a href=\"\${result.url}\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                            <i class=\"fas fa-external-link-alt\"></i> Ver en catálogo
                        </a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            resultsDiv.appendChild(table);

            // Agregar botón para guardar selección
            const saveButton = document.createElement('button');
            saveButton.className = 'btn btn-primary mt-3';
            saveButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar selección';
            saveButton.onclick = function() {
                const selectedIds = Array.from(document.querySelectorAll('.result-checkbox:checked'))
                    .map(checkbox => checkbox.dataset.id);
                if (selectedIds.length > 0) {
                    saveSelectedResults();
                } else {
                    alert('Por favor, seleccione al menos un resultado');
                }
            };
            resultsDiv.appendChild(saveButton);

            // Manejar selección de todos los resultados
            document.getElementById('selectAll').addEventListener('change', function() {
                document.querySelectorAll('.result-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        } else {
            resultsDiv.innerHTML = '<div class=\"alert alert-info\">No se encontraron resultados</div>';
        }
    } catch (error) {
        console.error('Error:', error);
        resultsDiv.innerHTML = `
            <div class=\"alert alert-danger\">
                <i class=\"fas fa-exclamation-triangle\"></i> \${error.message}
            </div>
        `;
    }
});

async function saveSelectedResults() {
    const checkboxes = document.querySelectorAll('.result-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Por favor seleccione al menos una bibliografía');
        return;
    }

    // Mostrar el modal de progreso
    const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
    progressModal.show();

    const progressBar = document.querySelector('.progress-bar');
    const progressText = document.getElementById('progressText');
    const totalItems = checkboxes.length;
    let processedItems = 0;

    const bibliografias = Array.from(checkboxes).map(checkbox => {
        const row = checkbox.closest('tr');
        const context = checkbox.getAttribute('data-context');
        const adaptor = checkbox.getAttribute('data-adaptor');
        let catalogo_id = checkbox.getAttribute('data-catalogo-id');
        if (context === 'L' && adaptor === 'Local Search Engine') {
            const sourcerecordid = checkbox.getAttribute('data-sourcerecordid');
            if (sourcerecordid) {
                catalogo_id = sourcerecordid;
            }
        }
        return {
            catalogo_id: catalogo_id,
            url: checkbox.getAttribute('data-url'),
            context: context || 'L',
            adaptor: adaptor || 'Local Search Engine',
            titulo: row.querySelector('td:nth-child(2)').textContent.trim(),
            autores: row.querySelector('td:nth-child(3)').textContent.trim(),
            anio: row.querySelector('td:nth-child(4)').textContent.trim(),
            editorial: row.querySelector('td:nth-child(5)').textContent.trim()
        };
    });

    const baseUrl = window.location.origin;
    const bibliografiaId = window.location.pathname.split('/')[3];
    const url = `\${baseUrl}/biblioges/bibliografias-declaradas/\${bibliografiaId}/guardar-seleccionadas`;

    try {
        // Actualizar progreso inicial
        progressText.textContent = 'Enviando datos al servidor...';
        progressBar.style.width = '10%';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ bibliografias: bibliografias })
        });

        // Actualizar progreso
        progressBar.style.width = '50%';
        progressText.textContent = 'Procesando respuesta del servidor...';

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('El servidor no devolvió una respuesta JSON válida');
        }

        const data = await response.json();
        
        if (data.success) {
            // Actualizar progreso final
            progressBar.style.width = '100%';
            progressText.textContent = '¡Proceso completado con éxito!';
            
            // Esperar un momento para mostrar el mensaje de éxito
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            // Cerrar el modal de progreso
            progressModal.hide();

            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message || 'Bibliografías guardadas correctamente',
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                // Redirigir a la página de bibliografías
                window.location.href = `\${baseUrl}/biblioges/bibliografias-declaradas`;
            });
        } else {
            throw new Error(data.message || 'Error desconocido');
        }
    } catch (error) {
        console.error('Error completo:', error);
        
        // Actualizar progreso en caso de error
        progressBar.style.width = '100%';
        progressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
        progressBar.classList.add('bg-danger');
        progressText.textContent = 'Error en el proceso';
        
        // Esperar un momento para mostrar el error
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Cerrar el modal de progreso
        progressModal.hide();

        // Mostrar mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al guardar las bibliografías',
            confirmButtonText: 'Aceptar'
        });
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
        return "bibliografias_declaradas/buscar_catalogo.twig";
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
        return array (  309 => 154,  290 => 137,  283 => 136,  239 => 95,  233 => 91,  229 => 89,  227 => 88,  224 => 87,  222 => 86,  219 => 85,  217 => 84,  198 => 68,  189 => 62,  167 => 42,  161 => 40,  159 => 39,  154 => 38,  152 => 37,  147 => 36,  145 => 35,  140 => 34,  138 => 33,  134 => 32,  130 => 31,  125 => 30,  123 => 29,  118 => 28,  116 => 27,  110 => 24,  106 => 23,  100 => 20,  96 => 19,  92 => 18,  88 => 17,  84 => 16,  72 => 6,  65 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.twig' %}

{% block title %}Buscar en Catálogo - {{ bibliografia.titulo }}{% endblock %}

{% block content %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"card-title mb-0\">Datos de la Bibliografía Declarada</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <p><strong>Tipo de Bibliografía:</strong> {{ bibliografia.tipo|title }}</p>
                            <p><strong>Título:</strong> {{ bibliografia.titulo }}</p>
                            <p><strong>Autor(es):</strong> {{ bibliografia.autores }}</p>
                            <p><strong>Año de Edición:</strong> {{ bibliografia.anio_publicacion }}</p>
                            <p><strong>Editorial:</strong> {{ bibliografia.editorial }}</p>
                        </div>
                        <div class=\"col-md-6\">
                            <p><strong>Edición:</strong> {{ bibliografia.edicion }}</p>
                            <p><strong>Formato:</strong> {{ bibliografia.formato|title }}</p>
                            <div class=\"mt-3\">
                                <h6>Datos Específicos:</h6>
                                {% if bibliografia.tipo == 'libro' %}
                                    <p><strong>ISBN:</strong> {{ bibliografia.isbn }}</p>
                                {% elseif bibliografia.tipo == 'articulo' %}
                                    <p><strong>ISSN:</strong> {{ bibliografia.issn }}</p>
                                    <p><strong>Revista:</strong> {{ bibliografia.titulo_revista }}</p>
                                    <p><strong>Cronología:</strong> {{ bibliografia.cronologia }}</p>
                                {% elseif bibliografia.tipo == 'tesis' %}
                                    <p><strong>Carrera:</strong> {{ bibliografia.carrera_nombre }}</p>
                                {% elseif bibliografia.tipo == 'sitio_web' %}
                                    <p><strong>Fecha de Consulta:</strong> {{ bibliografia.fecha_consulta }}</p>
                                {% elseif bibliografia.tipo == 'software' %}
                                    <p><strong>Versión:</strong> {{ bibliografia.version }}</p>
                                {% elseif bibliografia.tipo == 'generico' %}
                                    <p><strong>Descripción:</strong> {{ bibliografia.descripcion }}</p>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=\"row mt-4\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <h5 class=\"card-title mb-0\">Buscar en Catálogo</h5>
                </div>
                <div class=\"card-body\">
                    <form id=\"searchForm\" class=\"mb-4\">
                        <div class=\"row\">
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"titulo\">Título</label>
                                    <input type=\"text\" class=\"form-control\" id=\"titulo\" name=\"titulo\" value=\"{{ bibliografia.titulo }}\">
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"autor\">Autor</label>
                                    <input type=\"text\" class=\"form-control\" id=\"autor\" name=\"autor\" value=\"{{ bibliografia.autores|split(';')|first }}\">
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"busqueda_adicional\">Búsqueda Adicional</label>
                                    <input type=\"text\" class=\"form-control\" id=\"busqueda_adicional\" name=\"busqueda_adicional\" placeholder=\"Editorial u otra palabra clave\">
                                </div>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-md-4\">
                                <div class=\"form-group\">
                                    <label for=\"tipo_recurso\">Tipo de Recurso</label>
                                    <select class=\"form-control\" id=\"tipo_recurso\" name=\"tipo_recurso\">
                                        <option value=\"\">Todos</option>
                                        {% if bibliografia.tipo == 'libro' %}
                                            <option value=\"books\" selected>Libros</option>
                                        {% elseif bibliografia.tipo == 'articulo' %}
                                            <option value=\"articles\" selected>Artículos</option>
                                        {% elseif bibliografia.tipo == 'tesis' %}
                                            <option value=\"dissertations\" selected>Tesis</option>
                                        {% else %}
                                            <option value=\"books\">Libros</option>
                                            <option value=\"articles\">Artículos</option>
                                            <option value=\"dissertations\">Tesis</option>
                                        {% endif %}
                                    </select>
                                </div>
                            </div>
                            <div class=\"col-md-2\">
                                <div class=\"form-group\">
                                    <label>&nbsp;</label>
                                    <button type=\"submit\" class=\"btn btn-primary btn-block\">
                                        <i class=\"fas fa-search\"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id=\"searchResults\" class=\"mt-4\">
                        <!-- Los resultados se mostrarán aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Progreso -->
<div class=\"modal fade\" id=\"progressModal\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" aria-labelledby=\"progressModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-dialog-centered\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"progressModalLabel\">Guardando Bibliografías</h5>
            </div>
            <div class=\"modal-body\">
                <div class=\"progress mb-3\">
                    <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: 0%\"></div>
                </div>
                <p id=\"progressText\" class=\"text-center mb-0\">Iniciando proceso...</p>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
document.getElementById('searchForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        titulo: document.getElementById('titulo').value,
        autor: document.getElementById('autor').value,
        busqueda_adicional: document.getElementById('busqueda_adicional').value,
        tipo_recurso: document.getElementById('tipo_recurso').value
    };

    const resultsDiv = document.getElementById('searchResults');
    resultsDiv.innerHTML = '<div class=\"text-center\"><div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\">Buscando...</span></div></div>';

    try {
        console.log('Enviando petición con datos:', formData);
        
        const response = await fetch('{{ app_url }}bibliografias-declaradas/{{ bibliografia.id }}/buscarCatalogo/api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });

        console.log('Respuesta recibida:', response);
        console.log('Status:', response.status);
        console.log('Headers:', Object.fromEntries(response.headers.entries()));

        if (!response.ok) {
            throw new Error(`HTTP error! status: \${response.status}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            console.error('Content-Type incorrecto:', contentType);
            throw new Error('El servidor no devolvió una respuesta JSON válida');
        }

        const data = await response.json();
        console.log('Datos recibidos:', data);
        
        if (!data.success) {
            throw new Error(data.message || 'Error al buscar en el catálogo');
        }

        resultsDiv.innerHTML = '';

        if (data.results && data.results.length > 0) {
            const table = document.createElement('table');
            table.className = 'table table-striped';
            
            // Crear encabezado de la tabla
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th><input type=\"checkbox\" id=\"selectAll\"></th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Editorial</th>
                    <th>Formato</th>
                    <th>Acciones</th>
                </tr>
            `;
            table.appendChild(thead);

            // Crear cuerpo de la tabla
            const tbody = document.createElement('tbody');
            data.results.forEach(result => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type=\"checkbox\" class=\"result-checkbox\" data-id=\"\${result.catalogo_id}\" data-context=\"\${result.context}\" data-adaptor=\"\${result.adaptor}\" data-sourcerecordid=\"\${result.sourcerecordid}\" data-url=\"\${result.url}\"></td>
                    <td>\${result.titulo}</td>
                    <td>\${result.autores}</td>
                    <td>\${result.anio}</td>
                    <td>\${result.editorial}</td>
                    <td>\${result.formato}</td>
                    <td>
                        <a href=\"\${result.url}\" target=\"_blank\" class=\"btn btn-sm btn-info\">
                            <i class=\"fas fa-external-link-alt\"></i> Ver en catálogo
                        </a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            resultsDiv.appendChild(table);

            // Agregar botón para guardar selección
            const saveButton = document.createElement('button');
            saveButton.className = 'btn btn-primary mt-3';
            saveButton.innerHTML = '<i class=\"fas fa-save\"></i> Guardar selección';
            saveButton.onclick = function() {
                const selectedIds = Array.from(document.querySelectorAll('.result-checkbox:checked'))
                    .map(checkbox => checkbox.dataset.id);
                if (selectedIds.length > 0) {
                    saveSelectedResults();
                } else {
                    alert('Por favor, seleccione al menos un resultado');
                }
            };
            resultsDiv.appendChild(saveButton);

            // Manejar selección de todos los resultados
            document.getElementById('selectAll').addEventListener('change', function() {
                document.querySelectorAll('.result-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        } else {
            resultsDiv.innerHTML = '<div class=\"alert alert-info\">No se encontraron resultados</div>';
        }
    } catch (error) {
        console.error('Error:', error);
        resultsDiv.innerHTML = `
            <div class=\"alert alert-danger\">
                <i class=\"fas fa-exclamation-triangle\"></i> \${error.message}
            </div>
        `;
    }
});

async function saveSelectedResults() {
    const checkboxes = document.querySelectorAll('.result-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Por favor seleccione al menos una bibliografía');
        return;
    }

    // Mostrar el modal de progreso
    const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
    progressModal.show();

    const progressBar = document.querySelector('.progress-bar');
    const progressText = document.getElementById('progressText');
    const totalItems = checkboxes.length;
    let processedItems = 0;

    const bibliografias = Array.from(checkboxes).map(checkbox => {
        const row = checkbox.closest('tr');
        const context = checkbox.getAttribute('data-context');
        const adaptor = checkbox.getAttribute('data-adaptor');
        let catalogo_id = checkbox.getAttribute('data-catalogo-id');
        if (context === 'L' && adaptor === 'Local Search Engine') {
            const sourcerecordid = checkbox.getAttribute('data-sourcerecordid');
            if (sourcerecordid) {
                catalogo_id = sourcerecordid;
            }
        }
        return {
            catalogo_id: catalogo_id,
            url: checkbox.getAttribute('data-url'),
            context: context || 'L',
            adaptor: adaptor || 'Local Search Engine',
            titulo: row.querySelector('td:nth-child(2)').textContent.trim(),
            autores: row.querySelector('td:nth-child(3)').textContent.trim(),
            anio: row.querySelector('td:nth-child(4)').textContent.trim(),
            editorial: row.querySelector('td:nth-child(5)').textContent.trim()
        };
    });

    const baseUrl = window.location.origin;
    const bibliografiaId = window.location.pathname.split('/')[3];
    const url = `\${baseUrl}/biblioges/bibliografias-declaradas/\${bibliografiaId}/guardar-seleccionadas`;

    try {
        // Actualizar progreso inicial
        progressText.textContent = 'Enviando datos al servidor...';
        progressBar.style.width = '10%';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ bibliografias: bibliografias })
        });

        // Actualizar progreso
        progressBar.style.width = '50%';
        progressText.textContent = 'Procesando respuesta del servidor...';

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('El servidor no devolvió una respuesta JSON válida');
        }

        const data = await response.json();
        
        if (data.success) {
            // Actualizar progreso final
            progressBar.style.width = '100%';
            progressText.textContent = '¡Proceso completado con éxito!';
            
            // Esperar un momento para mostrar el mensaje de éxito
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            // Cerrar el modal de progreso
            progressModal.hide();

            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message || 'Bibliografías guardadas correctamente',
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                // Redirigir a la página de bibliografías
                window.location.href = `\${baseUrl}/biblioges/bibliografias-declaradas`;
            });
        } else {
            throw new Error(data.message || 'Error desconocido');
        }
    } catch (error) {
        console.error('Error completo:', error);
        
        // Actualizar progreso en caso de error
        progressBar.style.width = '100%';
        progressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
        progressBar.classList.add('bg-danger');
        progressText.textContent = 'Error en el proceso';
        
        // Esperar un momento para mostrar el error
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Cerrar el modal de progreso
        progressModal.hide();

        // Mostrar mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al guardar las bibliografías',
            confirmButtonText: 'Aceptar'
        });
    }
}
</script>
{% endblock %} ", "bibliografias_declaradas/buscar_catalogo.twig", "/var/www/html/biblioges/templates/bibliografias_declaradas/buscar_catalogo.twig");
    }
}
