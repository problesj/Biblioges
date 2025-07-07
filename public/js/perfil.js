document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const perfilForm = document.getElementById('perfilForm');
    const cambioPasswordForm = document.getElementById('cambioPasswordForm');
    const btnGuardarPerfil = document.getElementById('btnGuardarPerfil');
    const btnCambiarPassword = document.getElementById('btnCambiarPassword');
    const btnEliminarCuenta = document.getElementById('btnEliminarCuenta');

    // Event Listeners
    if (btnGuardarPerfil) {
        btnGuardarPerfil.addEventListener('click', guardarPerfil);
    }

    if (btnCambiarPassword) {
        btnCambiarPassword.addEventListener('click', cambiarPassword);
    }

    if (btnEliminarCuenta) {
        btnEliminarCuenta.addEventListener('click', confirmarEliminacionCuenta);
    }

    // Funciones principales
    function guardarPerfil() {
        if (!perfilForm) return;

        const formData = new FormData(perfilForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarPerfil(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando('Guardando cambios...');

        // Enviar solicitud al servidor
        fetch('/biblioges/perfil/actualizar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Perfil actualizado correctamente', 'success');
                actualizarDatosPerfil(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al actualizar el perfil', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al actualizar el perfil', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function cambiarPassword() {
        if (!cambioPasswordForm) return;

        const formData = new FormData(cambioPasswordForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarCambioPassword(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando('Cambiando contraseña...');

        // Enviar solicitud al servidor
        fetch('/biblioges/perfil/cambiar-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Contraseña actualizada correctamente', 'success');
                cambioPasswordForm.reset();
            } else {
                mostrarNotificacion(result.message || 'Error al cambiar la contraseña', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cambiar la contraseña', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function confirmarEliminacionCuenta() {
        if (confirm('¿Está seguro que desea eliminar su cuenta? Esta acción no se puede deshacer.')) {
            eliminarCuenta();
        }
    }

    function eliminarCuenta() {
        // Mostrar indicador de carga
        mostrarCargando('Eliminando cuenta...');

        fetch('/biblioges/perfil/eliminar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion('Cuenta eliminada correctamente', 'success');
                setTimeout(() => {
                    window.location.href = '/logout';
                }, 2000);
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar la cuenta', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar la cuenta', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    // Funciones auxiliares
    function validarPerfil(data) {
        const errores = [];

        if (!data.nombre) {
            errores.push('El nombre es requerido');
        }

        if (!data.email) {
            errores.push('El correo electrónico es requerido');
        } else if (!validarEmail(data.email)) {
            errores.push('El correo electrónico no es válido');
        }

        if (data.telefono && !validarTelefono(data.telefono)) {
            errores.push('El número de teléfono no es válido');
        }

        if (errores.length > 0) {
            mostrarNotificacion(errores.join('<br>'), 'error');
            return false;
        }

        return true;
    }

    function validarCambioPassword(data) {
        const errores = [];

        if (!data.password_actual) {
            errores.push('La contraseña actual es requerida');
        }

        if (!data.nueva_password) {
            errores.push('La nueva contraseña es requerida');
        } else if (data.nueva_password.length < 8) {
            errores.push('La nueva contraseña debe tener al menos 8 caracteres');
        }

        if (data.nueva_password !== data.confirmar_password) {
            errores.push('Las contraseñas no coinciden');
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

    function validarTelefono(telefono) {
        const re = /^[0-9]{10}$/;
        return re.test(telefono);
    }

    function actualizarDatosPerfil(data) {
        // Actualizar los campos del formulario con los nuevos datos
        if (perfilForm) {
            Object.keys(data).forEach(key => {
                const input = perfilForm.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                }
            });
        }

        // Actualizar la información mostrada en la página
        const nombreUsuario = document.getElementById('nombreUsuario');
        const emailUsuario = document.getElementById('emailUsuario');

        if (nombreUsuario) {
            nombreUsuario.textContent = data.nombre;
        }

        if (emailUsuario) {
            emailUsuario.textContent = data.email;
        }
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
}); 