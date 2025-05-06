document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const sedeForm = document.getElementById('sedeForm');
    const codigoInput = document.getElementById('codigo');
    const nombreInput = document.getElementById('nombre');
    const estadoSelect = document.getElementById('estado');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnEliminar = document.getElementById('btnEliminar');
    const sedeIdInput = document.getElementById('sedeId');

    // Elementos de filtrado
    const filtroEstado = document.getElementById('filtroEstado');
    const tablaSedes = document.getElementById('tablaSedes').getElementsByTagName('tbody')[0];

    // Cargar sedes al iniciar
    cargarSedes();

    // Evento para guardar sede
    sedeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        guardarSede();
    });

    // Evento para eliminar sede
    btnEliminar.addEventListener('click', function() {
        if (sedeIdInput.value) {
            eliminarSede(sedeIdInput.value);
        }
    });

    // Evento para filtrar por estado
    filtroEstado.addEventListener('change', function() {
        cargarSedes();
    });

    // Función para cargar sedes
    async function cargarSedes() {
        try {
            mostrarLoading();
            const estado = filtroEstado.value;
            const response = await fetch(`/api/sedes?estado=${estado}`);
            const sedes = await response.json();
            
            actualizarTabla(sedes);
        } catch (error) {
            mostrarNotificacion('Error al cargar las sedes', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para guardar sede
    async function guardarSede() {
        if (!validarFormulario()) return;

        try {
            mostrarLoading();
            const sede = {
                codigo: codigoInput.value,
                nombre: nombreInput.value,
                estado: estadoSelect.value === '1'
            };

            const url = sedeIdInput.value ? `/api/sedes/${sedeIdInput.value}` : '/api/sedes';
            const method = sedeIdInput.value ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(sede)
            });

            if (response.ok) {
                mostrarNotificacion('Sede guardada correctamente', 'success');
                limpiarFormulario();
                cargarSedes();
            } else {
                throw new Error('Error al guardar la sede');
            }
        } catch (error) {
            mostrarNotificacion('Error al guardar la sede', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para eliminar sede
    async function eliminarSede(id) {
        if (!confirm('¿Está seguro de eliminar esta sede?')) return;

        try {
            mostrarLoading();
            const response = await fetch(`/api/sedes/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                mostrarNotificacion('Sede eliminada correctamente', 'success');
                limpiarFormulario();
                cargarSedes();
            } else {
                throw new Error('Error al eliminar la sede');
            }
        } catch (error) {
            mostrarNotificacion('Error al eliminar la sede', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para validar formulario
    function validarFormulario() {
        if (!codigoInput.value.trim()) {
            mostrarNotificacion('El código es requerido', 'error');
            return false;
        }
        if (!nombreInput.value.trim()) {
            mostrarNotificacion('El nombre es requerido', 'error');
            return false;
        }
        return true;
    }

    // Función para actualizar tabla
    function actualizarTabla(sedes) {
        tablaSedes.innerHTML = '';
        sedes.forEach(sede => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${sede.codigo}</td>
                <td>${sede.nombre}</td>
                <td>${sede.estado ? 'Activo' : 'Inactivo'}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editarSede(${sede.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarSede(${sede.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tablaSedes.appendChild(tr);
        });
    }

    // Función para editar sede
    window.editarSede = function(id) {
        fetch(`/api/sedes/${id}`)
            .then(response => response.json())
            .then(sede => {
                sedeIdInput.value = sede.id;
                codigoInput.value = sede.codigo;
                nombreInput.value = sede.nombre;
                estadoSelect.value = sede.estado ? '1' : '0';
                btnGuardar.textContent = 'Actualizar';
                btnEliminar.style.display = 'inline-block';
            })
            .catch(error => {
                mostrarNotificacion('Error al cargar la sede', 'error');
            });
    };

    // Función para limpiar formulario
    function limpiarFormulario() {
        sedeIdInput.value = '';
        sedeForm.reset();
        btnGuardar.textContent = 'Guardar';
        btnEliminar.style.display = 'none';
    }

    // Funciones auxiliares
    function mostrarLoading() {
        // Implementar lógica de loading
    }

    function ocultarLoading() {
        // Implementar lógica de ocultar loading
    }

    function mostrarNotificacion(mensaje, tipo) {
        // Implementar lógica de notificaciones
    }
}); 
}); 