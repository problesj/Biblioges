document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const carreraForm = document.getElementById('carreraForm');
    const btnGuardarCarrera = document.getElementById('btnGuardarCarrera');
    const btnEliminarCarrera = document.getElementById('btnEliminarCarrera');
    const filtroEstado = document.getElementById('filtroEstado');
    const tablaCarreras = document.getElementById('tablaCarreras');

    // Event Listeners
    if (btnGuardarCarrera) {
        btnGuardarCarrera.addEventListener('click', guardarCarrera);
    }

    if (filtroEstado) {
        filtroEstado.addEventListener('change', filtrarCarreras);
    }

    // Funciones principales
    function guardarCarrera() {
        if (!carreraForm) return;

        const formData = new FormData(carreraForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarCarrera(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando('Guardando carrera...');

        // Enviar solicitud al servidor
        fetch('/api/carreras/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Carrera guardada correctamente', 'success');
                actualizarTablaCarreras();
                $('#modalCarrera').modal('hide');
            } else {
                mostrarNotificacion(result.message || 'Error al guardar la carrera', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al guardar la carrera', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function eliminarCarrera(id) {
        if (!confirm('¿Está seguro que desea eliminar esta carrera?')) {
            return;
        }

        mostrarCargando('Eliminando carrera...');

        fetch(`/api/carreras/eliminar/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Carrera eliminada correctamente', 'success');
                actualizarTablaCarreras();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar la carrera', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar la carrera', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function filtrarCarreras() {
        const estado = filtroEstado ? filtroEstado.value : '';

        mostrarCargando('Filtrando carreras...');

        fetch(`/api/carreras/filtrar?estado=${estado}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                actualizarTablaCarreras(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al filtrar las carreras', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al filtrar las carreras', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    // Funciones auxiliares
    function validarCarrera(data) {
        const errores = [];

        if (!data.codigo) {
            errores.push('El código es requerido');
        }

        if (!data.nombre) {
            errores.push('El nombre es requerido');
        }

        if (!data.duracion) {
            errores.push('La duración es requerida');
        } else if (data.duracion < 1 || data.duracion > 10) {
            errores.push('La duración debe estar entre 1 y 10 semestres');
        }

        if (errores.length > 0) {
            mostrarNotificacion(errores.join('<br>'), 'error');
            return false;
        }

        return true;
    }

    function actualizarTablaCarreras(carreras) {
        if (!tablaCarreras) return;

        let html = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
        `;

        carreras.forEach(carrera => {
            html += `
                <tr>
                    <td>${carrera.codigo}</td>
                    <td>${carrera.nombre}</td>
                    <td>${carrera.duracion} semestres</td>
                    <td>${carrera.estado ? 'Activo' : 'Inactivo'}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editarCarrera(${carrera.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarCarrera(${carrera.id})">
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

        tablaCarreras.innerHTML = html;
    }

    function editarCarrera(id) {
        mostrarCargando('Cargando datos de la carrera...');

        fetch(`/api/carreras/obtener/${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const carrera = result.data;
                carreraForm.reset();
                
                // Llenar el formulario con los datos de la carrera
                Object.keys(carrera).forEach(key => {
                    const input = carreraForm.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = carrera[key];
                    }
                });

                $('#modalCarrera').modal('show');
            } else {
                mostrarNotificacion(result.message || 'Error al cargar los datos de la carrera', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los datos de la carrera', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
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
    filtrarCarreras();
}); 