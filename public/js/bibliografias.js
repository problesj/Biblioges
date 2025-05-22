document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const bibliografiaForm = document.getElementById('bibliografiaForm');
    const btnGuardarBibliografia = document.getElementById('btnGuardarBibliografia');
    const btnEliminarBibliografia = document.getElementById('btnEliminarBibliografia');
    const filtroTipo = document.getElementById('filtroTipo');
    const filtroAsignatura = document.getElementById('filtroAsignatura');
    const filtroEstado = document.getElementById('filtroEstado');
    const tablaBibliografias = document.getElementById('tablaBibliografias');
    const buscador = document.getElementById('buscador');

    // Event Listeners
    if (btnGuardarBibliografia) {
        btnGuardarBibliografia.addEventListener('click', guardarBibliografia);
    }

    if (filtroTipo) {
        filtroTipo.addEventListener('change', filtrarBibliografias);
    }

    if (filtroAsignatura) {
        filtroAsignatura.addEventListener('change', filtrarBibliografias);
    }

    if (filtroEstado) {
        filtroEstado.addEventListener('change', filtrarBibliografias);
    }

    if (buscador) {
        buscador.addEventListener('input', buscarBibliografias);
    }

    // Funciones principales
    function guardarBibliografia() {
        if (!bibliografiaForm) return;

        const formData = new FormData(bibliografiaForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarBibliografia(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando('Guardando bibliografía...');

        // Enviar solicitud al servidor
        fetch('/api/bibliografias/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Bibliografía guardada correctamente', 'success');
                actualizarTablaBibliografias();
                $('#modalBibliografia').modal('hide');
            } else {
                mostrarNotificacion(result.message || 'Error al guardar la bibliografía', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al guardar la bibliografía', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function eliminarBibliografia(id) {
        if (!confirm('¿Está seguro que desea eliminar esta bibliografía?')) {
            return;
        }

        mostrarCargando('Eliminando bibliografía...');

        fetch(`/api/bibliografias/eliminar/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Bibliografía eliminada correctamente', 'success');
                actualizarTablaBibliografias();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar la bibliografía', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar la bibliografía', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function filtrarBibliografias() {
        const tipo = filtroTipo ? filtroTipo.value : '';
        const asignatura = filtroAsignatura ? filtroAsignatura.value : '';
        const estado = filtroEstado ? filtroEstado.value : '';

        mostrarCargando('Filtrando bibliografías...');

        fetch(`/api/bibliografias/filtrar?tipo=${tipo}&asignatura=${asignatura}&estado=${estado}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                actualizarTablaBibliografias(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al filtrar las bibliografías', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al filtrar las bibliografías', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function buscarBibliografias() {
        const busqueda = buscador.value.trim();
        
        if (busqueda.length < 3) {
            return;
        }

        mostrarCargando('Buscando bibliografías...');

        fetch(`/api/bibliografias/buscar?q=${encodeURIComponent(busqueda)}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                actualizarTablaBibliografias(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al buscar bibliografías', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al buscar bibliografías', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function editarBibliografia(id) {
        mostrarCargando('Cargando datos de la bibliografía...');

        fetch(`/api/bibliografias/obtener/${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const bibliografia = result.data;
                bibliografiaForm.reset();
                
                // Llenar el formulario con los datos de la bibliografía
                Object.keys(bibliografia).forEach(key => {
                    const input = bibliografiaForm.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = bibliografia[key];
                    }
                });

                $('#modalBibliografia').modal('show');
            } else {
                mostrarNotificacion(result.message || 'Error al cargar los datos de la bibliografía', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los datos de la bibliografía', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    // Funciones para vinculación y desvinculación
    function vincularAsignatura(bibliografiaId, asignaturaId, tipoBibliografia) {
        mostrarCargando('Vinculando asignatura...');

        fetch(`/api/bibliografias/${bibliografiaId}/vincular`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                asignatura_id: asignaturaId,
                tipo_bibliografia: tipoBibliografia
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Asignatura vinculada correctamente', 'success');
                actualizarTablaBibliografias();
            } else {
                mostrarNotificacion(result.message || 'Error al vincular la asignatura', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al vincular la asignatura', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function desvincularAsignatura(bibliografiaId, vinculacionId) {
        if (!confirm('¿Está seguro que desea desvincular esta asignatura?')) {
            return;
        }

        mostrarCargando('Desvinculando asignatura...');

        fetch(`/api/bibliografias/${bibliografiaId}/desvincular/${vinculacionId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Asignatura desvinculada correctamente', 'success');
                actualizarTablaBibliografias();
            } else {
                mostrarNotificacion(result.message || 'Error al desvincular la asignatura', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al desvincular la asignatura', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function vincularMultipleAsignaturas(bibliografiaId, asignaturas) {
        mostrarCargando('Vinculando asignaturas...');

        fetch(`/api/bibliografias/${bibliografiaId}/vincular-multiple`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                asignaturas: asignaturas
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                actualizarTablaBibliografias();
            } else {
                mostrarNotificacion(result.message || 'Error al vincular las asignaturas', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al vincular las asignaturas', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function desvincularMultipleAsignaturas(bibliografiaId, vinculaciones) {
        if (!confirm('¿Está seguro que desea desvincular las asignaturas seleccionadas?')) {
            return;
        }

        mostrarCargando('Desvinculando asignaturas...');

        fetch(`/api/bibliografias/${bibliografiaId}/desvincular-multiple`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                vinculaciones: vinculaciones
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Asignaturas desvinculadas correctamente', 'success');
                actualizarTablaBibliografias();
            } else {
                mostrarNotificacion(result.message || 'Error al desvincular las asignaturas', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al desvincular las asignaturas', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    // Funciones auxiliares
    function validarBibliografia(data) {
        const errores = [];

        if (!data.titulo) {
            errores.push('El título es requerido');
        }

        if (!data.autor) {
            errores.push('El autor es requerido');
        }

        if (!data.tipo) {
            errores.push('El tipo es requerido');
        }

        if (!data.asignatura_id) {
            errores.push('La asignatura es requerida');
        }

        if (errores.length > 0) {
            mostrarNotificacion(errores.join('<br>'), 'error');
            return false;
        }

        return true;
    }

    function actualizarTablaBibliografias(bibliografias) {
        if (!tablaBibliografias) return;

        let html = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Tipo</th>
                        <th>Asignatura</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
        `;

        bibliografias.forEach(bibliografia => {
            html += `
                <tr>
                    <td>${bibliografia.titulo}</td>
                    <td>${bibliografia.autor}</td>
                    <td>${bibliografia.tipo}</td>
                    <td>${bibliografia.asignatura_nombre}</td>
                    <td>${bibliografia.estado ? 'Activo' : 'Inactivo'}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editarBibliografia(${bibliografia.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarBibliografia(${bibliografia.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;

        tablaBibliografias.innerHTML = html;
    }

    function mostrarCargando(mensaje) {
        const loading = document.createElement('div');
        loading.className = 'loading';
        loading.textContent = mensaje;
        document.body.appendChild(loading);
    }

    function ocultarCargando() {
        const loading = document.querySelector('.loading');
        if (loading) {
            loading.remove();
        }
    }

    // Cargar datos iniciales
    filtrarBibliografias();
}); 