// Variables globales
let modalAsignatura = document.getElementById('modalAsignatura');
let asignaturaForm = document.getElementById('asignaturaForm');
let modalTitle = document.getElementById('modalTitle');

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal al hacer clic en el botón de cerrar
    const closeModalBtn = document.querySelector('.close-modal');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', cerrarModal);
    }
    
    // Cerrar modal al hacer clic fuera del contenido
    if (modalAsignatura) {
    window.addEventListener('click', function(event) {
        if (event.target === modalAsignatura) {
            cerrarModal();
        }
    });
    }

    // Manejar el envío del formulario de filtros
    const filtersForm = document.querySelector('.filters-form');
    if (filtersForm) {
        filtersForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filtrarAsignaturas();
    });
    }

    // Elementos del DOM
    const btnNuevaAsignatura = document.getElementById('btnNuevaAsignatura');
    const btnCerrarModal = document.querySelector('.modal-close');
    const filtroCarrera = document.getElementById('filtroCarrera');
    const filtroSemestre = document.getElementById('filtroSemestre');
    const filtroEstado = document.getElementById('filtroEstado');
    const tablaAsignaturas = document.getElementById('tablaAsignaturas');

    // Event Listeners
    if (btnNuevaAsignatura) {
        btnNuevaAsignatura.addEventListener('click', function() {
            resetForm();
            modalAsignatura.classList.add('show');
        });
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener('click', function() {
            modalAsignatura.classList.remove('show');
        });
    }

    // Filtros
    if (filtroCarrera && filtroSemestre && filtroEstado) {
        [filtroCarrera, filtroSemestre, filtroEstado].forEach(filtro => {
            filtro.addEventListener('change', aplicarFiltros);
        });
    }

    // Formulario de asignatura
    if (asignaturaForm) {
        asignaturaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            // Validación
            if (!validarFormulario(data)) {
                return;
            }

            // Envío del formulario
            enviarFormulario(data);
        });
    }
});

// Funciones para el manejo del modal
function abrirModal() {
    modalAsignatura.style.display = 'block';
}

function cerrarModal() {
    modalAsignatura.style.display = 'none';
    asignaturaForm.reset();
    document.getElementById('asignaturaId').value = '';
    modalTitle.textContent = 'Nueva Asignatura';
}

// Funciones para CRUD de asignaturas
function nuevaAsignatura() {
    modalTitle.textContent = 'Nueva Asignatura';
    abrirModal();
}

function editarAsignatura(id) {
    // Obtener los datos de la asignatura
    fetch(`/api/asignaturas/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('asignaturaId').value = data.id;
            document.getElementById('codigo').value = data.codigo;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('carrera').value = data.carrera_id;
            document.getElementById('semestre').value = data.semestre;
            document.getElementById('creditos').value = data.creditos;
            document.getElementById('descripcion').value = data.descripcion || '';
            
            modalTitle.textContent = 'Editar Asignatura';
            abrirModal();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos de la asignatura');
        });
}

function verAsignatura(id) {
    // Redirigir a la página de detalles de la asignatura
    window.location.href = `/asignaturas/${id}`;
}

function eliminarAsignatura(id) {
    if (confirm('¿Está seguro de que desea eliminar esta asignatura?')) {
        fetch(`/api/asignaturas/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                mostrarMensaje('Asignatura eliminada exitosamente', 'success');
                setTimeout(() => {
                    window.location.href = '/asignaturas';
                }, 1000);
            } else {
                throw new Error('Error al eliminar la asignatura');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al eliminar la asignatura', 'danger');
        });
    }
}

function guardarAsignatura() {
    const formData = new FormData(asignaturaForm);
    const data = Object.fromEntries(formData.entries());
    const id = data.id;
    const url = id ? `/api/asignaturas/${id}` : '/api/asignaturas';
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.ok) {
            cerrarModal();
            location.reload();
        } else {
            throw new Error('Error al guardar la asignatura');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la asignatura');
    });
}

// Función para filtrar asignaturas
function filtrarAsignaturas() {
    const formData = new FormData(document.querySelector('.filters-form'));
    const params = new URLSearchParams(formData);
    
    fetch(`/api/asignaturas?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            actualizarTablaAsignaturas(data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al filtrar las asignaturas');
        });
}

// Función para actualizar la tabla de asignaturas
function actualizarTablaAsignaturas(asignaturas) {
    const tbody = document.querySelector('.table tbody');
    tbody.innerHTML = '';

    asignaturas.forEach(asignatura => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${asignatura.codigo}</td>
            <td>${asignatura.nombre}</td>
            <td>${asignatura.carrera_nombre}</td>
            <td>${asignatura.semestre}°</td>
            <td>${asignatura.creditos}</td>
            <td>
                <span class="badge ${asignatura.activa ? 'badge-success' : 'badge-danger'}">
                    ${asignatura.activa ? 'Activa' : 'Inactiva'}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-info" onclick="verAsignatura(${asignatura.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-primary" onclick="editarAsignatura(${asignatura.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarAsignatura(${asignatura.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Función para mostrar mensajes de éxito/error
function mostrarMensaje(mensaje, tipo = 'success') {
    const mensajeDiv = document.createElement('div');
    mensajeDiv.className = `alert alert-${tipo}`;
    mensajeDiv.textContent = mensaje;
    
    // Insertar el mensaje antes de la tarjeta de detalles
    const container = document.querySelector('.asignatura-details');
    const card = document.querySelector('.details-card');
    container.insertBefore(mensajeDiv, card);
    
    // Configurar la animación de salida
    setTimeout(() => {
        mensajeDiv.classList.add('fade-out');
        
        // Eliminar el elemento después de que termine la animación
        mensajeDiv.addEventListener('animationend', () => {
            mensajeDiv.remove();
        });
    }, 2500); // Mostrar por 2.5 segundos antes de comenzar la animación de salida
}

// Event Listeners para la vista de detalles
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en la vista de detalles
    if (document.querySelector('.asignatura-details')) {
        // Agregar confirmación antes de eliminar
        const btnEliminar = document.querySelector('.btn-danger');
        if (btnEliminar) {
            btnEliminar.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                eliminarAsignatura(id);
            });
        }
    }
});

// Funciones auxiliares
function resetForm() {
    if (asignaturaForm) {
        asignaturaForm.reset();
        asignaturaForm.dataset.mode = 'create';
        document.getElementById('formTitle').textContent = 'Nueva Asignatura';
    }
}

function validarFormulario(data) {
    let isValid = true;
    const errores = [];

    if (!data.codigo) {
        errores.push('El código es requerido');
        isValid = false;
    }

    if (!data.nombre) {
        errores.push('El nombre es requerido');
        isValid = false;
    }

    if (!data.carrera_id) {
        errores.push('La carrera es requerida');
        isValid = false;
    }

    if (!data.semestre) {
        errores.push('El semestre es requerido');
        isValid = false;
    }

    if (!data.creditos) {
        errores.push('Los créditos son requeridos');
        isValid = false;
    }

    if (errores.length > 0) {
        mostrarNotificacion(errores.join('<br>'), 'error');
    }

    return isValid;
}

function enviarFormulario(data) {
    const url = asignaturaForm.dataset.mode === 'edit' 
        ? `/api/asignaturas/${asignaturaForm.dataset.id}`
        : '/api/asignaturas';
    
    const method = asignaturaForm.dataset.mode === 'edit' ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(
                asignaturaForm.dataset.mode === 'edit' 
                    ? 'Asignatura actualizada correctamente'
                    : 'Asignatura creada correctamente',
                'success'
            );
            modalAsignatura.classList.remove('show');
            location.reload();
        } else {
            mostrarNotificacion(result.message || 'Error al procesar la solicitud', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al procesar la solicitud', 'error');
    });
}

function aplicarFiltros() {
    const carrera = filtroCarrera.value;
    const semestre = filtroSemestre.value;
    const estado = filtroEstado.value;

    fetch(`/api/asignaturas/filtrar?carrera=${carrera}&semestre=${semestre}&estado=${estado}`)
        .then(response => response.json())
        .then(data => {
            actualizarTabla(data);
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al aplicar los filtros', 'error');
        });
}

function actualizarTabla(asignaturas) {
    if (!tablaAsignaturas) return;

    const tbody = tablaAsignaturas.querySelector('tbody');
    tbody.innerHTML = '';

    asignaturas.forEach(asignatura => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${asignatura.codigo}</td>
            <td>${asignatura.nombre}</td>
            <td>${asignatura.carrera_nombre}</td>
            <td>${asignatura.semestre}</td>
            <td>${asignatura.creditos}</td>
            <td>
                <span class="badge ${asignatura.estado ? 'badge-success' : 'badge-danger'}">
                    ${asignatura.estado ? 'Activo' : 'Inactivo'}
                </span>
            </td>
            <td>
                <button class="btn btn-sm btn-info" onclick="verAsignatura(${asignatura.id})">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary" onclick="editarAsignatura(${asignatura.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarAsignatura(${asignatura.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Funciones globales para los botones de acción
window.verAsignatura = function(id) {
    window.location.href = `/asignaturas/${id}`;
};

window.editarAsignatura = function(id) {
    fetch(`/api/asignaturas/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const asignatura = data.data;
                asignaturaForm.dataset.mode = 'edit';
                asignaturaForm.dataset.id = id;
                document.getElementById('formTitle').textContent = 'Editar Asignatura';
                
                // Llenar el formulario
                document.getElementById('codigo').value = asignatura.codigo;
                document.getElementById('nombre').value = asignatura.nombre;
                document.getElementById('carrera_id').value = asignatura.carrera_id;
                document.getElementById('semestre').value = asignatura.semestre;
                document.getElementById('creditos').value = asignatura.creditos;
                document.getElementById('descripcion').value = asignatura.descripcion || '';
                document.getElementById('estado').checked = asignatura.estado;
                
                modalAsignatura.classList.add('show');
            } else {
                mostrarNotificacion('Error al cargar la asignatura', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar la asignatura', 'error');
        });
};

window.eliminarAsignatura = function(id) {
    if (confirm('¿Está seguro de eliminar esta asignatura?')) {
        fetch(`/api/asignaturas/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Asignatura eliminada correctamente', 'success');
                location.reload();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar la asignatura', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar la asignatura', 'error');
        });
    }
}; 