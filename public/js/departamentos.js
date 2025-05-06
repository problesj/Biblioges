document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const departamentoForm = document.getElementById('departamentoForm');
    const codigoInput = document.getElementById('codigo');
    const nombreInput = document.getElementById('nombre');
    const facultadSelect = document.getElementById('facultad');
    const estadoSelect = document.getElementById('estado');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnEliminar = document.getElementById('btnEliminar');
    const departamentoIdInput = document.getElementById('departamentoId');

    // Elementos de filtrado
    const filtroEstado = document.getElementById('filtroEstado');
    const filtroFacultad = document.getElementById('filtroFacultad');
    const tablaDepartamentos = document.getElementById('tablaDepartamentos').getElementsByTagName('tbody')[0];

    // Cargar facultades y departamentos al iniciar
    cargarFacultades();
    cargarDepartamentos();

    // Evento para guardar departamento
    departamentoForm.addEventListener('submit', function(e) {
        e.preventDefault();
        guardarDepartamento();
    });

    // Evento para eliminar departamento
    btnEliminar.addEventListener('click', function() {
        if (departamentoIdInput.value) {
            eliminarDepartamento(departamentoIdInput.value);
        }
    });

    // Eventos para filtros
    filtroEstado.addEventListener('change', cargarDepartamentos);
    filtroFacultad.addEventListener('change', cargarDepartamentos);

    // Función para cargar facultades
    async function cargarFacultades() {
        try {
            const response = await fetch('/api/facultades');
            const facultades = await response.json();
            
            // Actualizar select de facultades en el formulario
            facultadSelect.innerHTML = '<option value="">Seleccione una facultad</option>';
            facultades.forEach(facultad => {
                const option = document.createElement('option');
                option.value = facultad.id;
                option.textContent = facultad.nombre;
                facultadSelect.appendChild(option);
            });

            // Actualizar select de facultades en el filtro
            filtroFacultad.innerHTML = '<option value="">Todas las facultades</option>';
            facultades.forEach(facultad => {
                const option = document.createElement('option');
                option.value = facultad.id;
                option.textContent = facultad.nombre;
                filtroFacultad.appendChild(option);
            });
        } catch (error) {
            mostrarNotificacion('Error al cargar las facultades', 'error');
        }
    }

    // Función para cargar departamentos
    async function cargarDepartamentos() {
        try {
            mostrarLoading();
            const estado = filtroEstado.value;
            const facultadId = filtroFacultad.value;
            const response = await fetch(`/api/departamentos?estado=${estado}&facultad_id=${facultadId}`);
            const departamentos = await response.json();
            
            actualizarTabla(departamentos);
        } catch (error) {
            mostrarNotificacion('Error al cargar los departamentos', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para guardar departamento
    async function guardarDepartamento() {
        if (!validarFormulario()) return;

        try {
            mostrarLoading();
            const departamento = {
                codigo: codigoInput.value,
                nombre: nombreInput.value,
                facultad_id: facultadSelect.value,
                estado: estadoSelect.value === '1'
            };

            const url = departamentoIdInput.value ? `/api/departamentos/${departamentoIdInput.value}` : '/api/departamentos';
            const method = departamentoIdInput.value ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(departamento)
            });

            if (response.ok) {
                mostrarNotificacion('Departamento guardado correctamente', 'success');
                limpiarFormulario();
                cargarDepartamentos();
            } else {
                throw new Error('Error al guardar el departamento');
            }
        } catch (error) {
            mostrarNotificacion('Error al guardar el departamento', 'error');
        } finally {
            ocultarLoading();
        }
    }

    // Función para eliminar departamento
    async function eliminarDepartamento(id) {
        if (!confirm('¿Está seguro de eliminar este departamento?')) return;

        try {
            mostrarLoading();
            const response = await fetch(`/api/departamentos/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                mostrarNotificacion('Departamento eliminado correctamente', 'success');
                limpiarFormulario();
                cargarDepartamentos();
            } else {
                throw new Error('Error al eliminar el departamento');
            }
        } catch (error) {
            mostrarNotificacion('Error al eliminar el departamento', 'error');
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
        if (!facultadSelect.value) {
            mostrarNotificacion('La facultad es requerida', 'error');
            return false;
        }
        return true;
    }

    // Función para actualizar tabla
    function actualizarTabla(departamentos) {
        tablaDepartamentos.innerHTML = '';
        departamentos.forEach(departamento => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${departamento.codigo}</td>
                <td>${departamento.nombre}</td>
                <td>${departamento.facultad_nombre}</td>
                <td>${departamento.estado ? 'Activo' : 'Inactivo'}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editarDepartamento(${departamento.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarDepartamento(${departamento.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tablaDepartamentos.appendChild(tr);
        });
    }

    // Función para editar departamento
    window.editarDepartamento = function(id) {
        fetch(`/api/departamentos/${id}`)
            .then(response => response.json())
            .then(departamento => {
                departamentoIdInput.value = departamento.id;
                codigoInput.value = departamento.codigo;
                nombreInput.value = departamento.nombre;
                facultadSelect.value = departamento.facultad_id;
                estadoSelect.value = departamento.estado ? '1' : '0';
                btnGuardar.textContent = 'Actualizar';
                btnEliminar.style.display = 'inline-block';
            })
            .catch(error => {
                mostrarNotificacion('Error al cargar el departamento', 'error');
            });
    };

    // Función para limpiar formulario
    function limpiarFormulario() {
        departamentoIdInput.value = '';
        departamentoForm.reset();
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