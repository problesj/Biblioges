document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const facultadForm = document.getElementById('facultadForm');
    const codigoInput = document.getElementById('codigo');
    const nombreInput = document.getElementById('nombre');
    const sedeSelect = document.getElementById('sede');
    const estadoSelect = document.getElementById('estado');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnEliminar = document.getElementById('btnEliminar');
    const facultadIdInput = document.getElementById('facultadId');

    // Elementos de filtrado
    const filtroEstado = document.getElementById('filtroEstado');
    const filtroSede = document.getElementById('filtroSede');
    const tablaFacultades = document.getElementById('tablaFacultades').getElementsByTagName('tbody')[0];

    // Cargar sedes y facultades al iniciar
    cargarSedes();
    cargarFacultades();

    // Evento para guardar facultad
    facultadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        guardarFacultad();
    });

    // Evento para eliminar facultad
    btnEliminar.addEventListener('click', function() {
        if (facultadIdInput.value) {
            eliminarFacultad(facultadIdInput.value);
        }
    });

    // Eventos para filtros
    filtroEstado.addEventListener('change', cargarFacultades);
    filtroSede.addEventListener('change', cargarFacultades);

    // Función para cargar sedes
    async function cargarSedes() {
        try {
            const response = await fetch('/api/sedes');
            const sedes = await response.json();
            
            // Actualizar select de sedes en el formulario
            sedeSelect.innerHTML = '<option value="">Seleccione una sede</option>';
            sedes.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.id;
                option.textContent = sede.nombre;
                sedeSelect.appendChild(option);
            });

            // Actualizar select de sedes en el filtro
            filtroSede.innerHTML = '<option value="">Todas las sedes</option>';
            sedes.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.id;
                option.textContent = sede.nombre;
                filtroSede.appendChild(option);
            });
        } catch (error) {
            mostrarNotificacion('Error al cargar las sedes', 'error');
        }
    }

    // Función para cargar facultades
    async function cargarFacultades() {
        try {
            mostrarLoading();
            const estado = filtroEstado.value;
            const sedeId = filtroSede.value;
            const response = await fetch(`/api/facultades?estado=${estado}&sede_id=${sedeId}`);
            const facultades = await response.json();
            
            actualizarTabla(facultades);
        } catch (error) {
            mostrarNotificacion('Error al cargar las facultades', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para guardar facultad
    async function guardarFacultad() {
        if (!validarFormulario()) return;

        try {
            mostrarLoading();
            const facultad = {
                codigo: codigoInput.value,
                nombre: nombreInput.value,
                sede_id: sedeSelect.value,
                estado: estadoSelect.value === '1'
            };

            const url = facultadIdInput.value ? `/api/facultades/${facultadIdInput.value}` : '/api/facultades';
            const method = facultadIdInput.value ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(facultad)
            });

            if (response.ok) {
                mostrarNotificacion('Facultad guardada correctamente', 'success');
                limpiarFormulario();
                cargarFacultades();
            } else {
                throw new Error('Error al guardar la facultad');
            }
        } catch (error) {
            mostrarNotificacion('Error al guardar la facultad', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para eliminar facultad
    async function eliminarFacultad(id) {
        if (!confirm('¿Está seguro de eliminar esta facultad?')) return;

        try {
            mostrarLoading();
            const response = await fetch(`/api/facultades/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                mostrarNotificacion('Facultad eliminada correctamente', 'success');
                limpiarFormulario();
                cargarFacultades();
            } else {
                throw new Error('Error al eliminar la facultad');
            }
        } catch (error) {
            mostrarNotificacion('Error al eliminar la facultad', 'error');
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
        if (!sedeSelect.value) {
            mostrarNotificacion('La sede es requerida', 'error');
            return false;
        }
        return true;
    }

    // Función para actualizar tabla
    function actualizarTabla(facultades) {
        tablaFacultades.innerHTML = '';
        facultades.forEach(facultad => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${facultad.codigo}</td>
                <td>${facultad.nombre}</td>
                <td>${facultad.sede_nombre}</td>
                <td>${facultad.estado ? 'Activo' : 'Inactivo'}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editarFacultad(${facultad.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarFacultad(${facultad.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tablaFacultades.appendChild(tr);
        });
    }

    // Función para editar facultad
    window.editarFacultad = function(id) {
        fetch(`/api/facultades/${id}`)
            .then(response => response.json())
            .then(facultad => {
                facultadIdInput.value = facultad.id;
                codigoInput.value = facultad.codigo;
                nombreInput.value = facultad.nombre;
                sedeSelect.value = facultad.sede_id;
                estadoSelect.value = facultad.estado ? '1' : '0';
                btnGuardar.textContent = 'Actualizar';
                btnEliminar.style.display = 'inline-block';
            })
            .catch(error => {
                mostrarNotificacion('Error al cargar la facultad', 'error');
            });
    };

    // Función para limpiar formulario
    function limpiarFormulario() {
        facultadIdInput.value = '';
        facultadForm.reset();
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