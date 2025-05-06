document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const usuarioForm = document.getElementById('usuarioForm');
    const btnGuardarUsuario = document.getElementById('btnGuardarUsuario');
    const btnEliminarUsuario = document.getElementById('btnEliminarUsuario');
    const filtroRol = document.getElementById('filtroRol');
    const filtroEstado = document.getElementById('filtroEstado');
    const tablaUsuarios = document.getElementById('tablaUsuarios');
    const buscador = document.getElementById('buscador');

    // Event Listeners
    if (btnGuardarUsuario) {
        btnGuardarUsuario.addEventListener('click', guardarUsuario);
    }

    if (filtroRol) {
        filtroRol.addEventListener('change', filtrarUsuarios);
    }

    if (filtroEstado) {
        filtroEstado.addEventListener('change', filtrarUsuarios);
    }

    if (buscador) {
        buscador.addEventListener('input', buscarUsuarios);
    }

    // Funciones principales
    function guardarUsuario() {
        if (!usuarioForm) return;

        const formData = new FormData(usuarioForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarUsuario(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando('Guardando usuario...');

        // Enviar solicitud al servidor
        fetch('/api/usuarios/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Usuario guardado correctamente', 'success');
                actualizarTablaUsuarios();
                $('#modalUsuario').modal('hide');
            } else {
                mostrarNotificacion(result.message || 'Error al guardar el usuario', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al guardar el usuario', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function eliminarUsuario(id) {
        if (!confirm('¿Está seguro que desea eliminar este usuario?')) {
            return;
        }

        mostrarCargando('Eliminando usuario...');

        fetch(`/api/usuarios/eliminar/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Usuario eliminado correctamente', 'success');
                actualizarTablaUsuarios();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar el usuario', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar el usuario', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function filtrarUsuarios() {
        const rol = filtroRol ? filtroRol.value : '';
        const estado = filtroEstado ? filtroEstado.value : '';

        mostrarCargando('Filtrando usuarios...');

        fetch(`/api/usuarios/filtrar?rol=${rol}&estado=${estado}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                actualizarTablaUsuarios(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al filtrar los usuarios', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al filtrar los usuarios', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function buscarUsuarios() {
        const busqueda = buscador.value.trim();
        
        if (busqueda.length < 3) {
            return;
        }

        mostrarCargando('Buscando usuarios...');

        fetch(`/api/usuarios/buscar?q=${encodeURIComponent(busqueda)}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                actualizarTablaUsuarios(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al buscar usuarios', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al buscar usuarios', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    // Funciones auxiliares
    function validarUsuario(data) {
        const errores = [];

        if (!data.nombre) {
            errores.push('El nombre es requerido');
        }

        if (!data.email) {
            errores.push('El correo electrónico es requerido');
        } else if (!validarEmail(data.email)) {
            errores.push('El correo electrónico no es válido');
        }

        if (!data.rol) {
            errores.push('El rol es requerido');
        }

        if (!data.id && !data.password) {
            errores.push('La contraseña es requerida');
        }

        if (data.password && data.password.length < 8) {
            errores.push('La contraseña debe tener al menos 8 caracteres');
        }

        if (errores.length > 0) {
            mostrarNotificacion(errores.join('<br>'), 'error');
            return false;
        }

        return true;
    }

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function actualizarTablaUsuarios(usuarios) {
        if (!tablaUsuarios) return;

        let html = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
        `;

        usuarios.forEach(usuario => {
            html += `
                <tr>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.rol}</td>
                    <td>${usuario.estado ? 'Activo' : 'Inactivo'}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editarUsuario(${usuario.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${usuario.id})">
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

        tablaUsuarios.innerHTML = html;
    }

    function editarUsuario(id) {
        mostrarCargando('Cargando datos del usuario...');

        fetch(`/api/usuarios/obtener/${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const usuario = result.data;
                usuarioForm.reset();
                
                // Llenar el formulario con los datos del usuario
                Object.keys(usuario).forEach(key => {
                    const input = usuarioForm.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = usuario[key];
                    }
                });

                $('#modalUsuario').modal('show');
            } else {
                mostrarNotificacion(result.message || 'Error al cargar los datos del usuario', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los datos del usuario', 'error');
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
    filtrarUsuarios();
}); 