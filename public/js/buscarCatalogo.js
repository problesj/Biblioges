// Función para guardar las bibliografías seleccionadas
function saveSelectedResults() {
    try {
        // Obtener todas las filas seleccionadas
        const filasSeleccionadas = document.querySelectorAll('input[name="seleccion[]"]:checked');
        
        if (filasSeleccionadas.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Sin selección',
                text: 'Por favor, seleccione al menos una bibliografía para guardar.'
            });
            return;
        }

        // Recolectar los datos de las bibliografías seleccionadas
        const bibliografias = Array.from(filasSeleccionadas).map(checkbox => {
            const fila = checkbox.closest('tr');
            return {
                titulo: fila.querySelector('.titulo-bibliografia').textContent,
                autores: fila.querySelector('.autores-bibliografia').textContent,
                editorial: fila.querySelector('.editorial-bibliografia').textContent,
                anio_publicacion: fila.querySelector('.anio-bibliografia').textContent,
                isbn: fila.querySelector('.isbn-bibliografia').textContent,
                tipo: fila.querySelector('.tipo-bibliografia').textContent,
                estado: 1 // Por defecto activo
            };
        });

        // Mostrar confirmación
        Swal.fire({
            title: '¿Guardar selección?',
            text: `Se guardarán ${bibliografias.length} bibliografía(s) seleccionada(s)`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar los datos al servidor
                fetch(`${appUrl}api/bibliografias-declaradas/guardar-seleccion`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ bibliografias })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message || 'Bibliografías guardadas correctamente'
                        }).then(() => {
                            // Cerrar el modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('buscarCatalogoModal'));
                            modal.hide();

                            // Recargar la página de bibliografías declaradas
                            window.location.href = `${appUrl}bibliografias-declaradas`;
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar las bibliografías');
                    }
                })
                .catch(error => {
                    console.error('Error al guardar selección:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al guardar las bibliografías seleccionadas'
                    });
                });
            }
        });
    } catch (error) {
        console.error('Error al guardar selección:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al guardar las bibliografías seleccionadas'
        });
    }
}

// Asegurarse de que la función esté disponible globalmente
window.saveSelectedResults = saveSelectedResults; 