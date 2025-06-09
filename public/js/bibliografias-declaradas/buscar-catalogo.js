// Función para mostrar la modal de progreso
function mostrarModalProgreso() {
    const modal = new bootstrap.Modal(document.getElementById('modalProgreso'));
    modal.show();
}

// Función para actualizar el progreso
function actualizarProgreso(porcentaje, mensaje, detalles = '') {
    const progressBar = document.querySelector('#modalProgreso .progress-bar');
    const mensajeProgreso = document.getElementById('mensajeProgreso');
    const detallesProgreso = document.getElementById('detallesProgreso');
    
    progressBar.style.width = `${porcentaje}%`;
    progressBar.setAttribute('aria-valuenow', porcentaje);
    mensajeProgreso.textContent = mensaje;
    
    if (detalles) {
        detallesProgreso.innerHTML = detalles;
    }
}

// Función para ocultar la modal de progreso
function ocultarModalProgreso() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalProgreso'));
    if (modal) {
        modal.hide();
    }
}

// Modificar la función guardarBibliografiasSeleccionadas
async function guardarBibliografiasSeleccionadas() {
    console.log('Iniciando guardarBibliografiasSeleccionadas');
    const bibliografiasSeleccionadas = obtenerBibliografiasSeleccionadas();
    
    if (bibliografiasSeleccionadas.length === 0) {
        mostrarError('Por favor, seleccione al menos una bibliografía para guardar.');
        return;
    }
    
    try {
        console.log('Mostrando modal...');
        window.mostrarModalProgreso();
        window.actualizarProgreso(0, 'Iniciando proceso de guardado...');
        
        const response = await fetch(`/biblioges/bibliografias-declaradas/${bibliografiaDeclaradaId}/guardar-seleccionadas`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ bibliografias: bibliografiasSeleccionadas })
        });
        
        const data = await response.json();
        console.log('Respuesta del servidor:', data);
        
        if (data.success) {
            window.actualizarProgreso(100, '¡Proceso completado con éxito!', `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> ${data.message}
                </div>
                ${data.ejemplares_por_sede ? `
                    <div class="mt-3">
                        <h6>Ejemplares por sede:</h6>
                        <ul class="list-unstyled">
                            ${Object.entries(data.ejemplares_por_sede).map(([sedeId, cantidad]) => `
                                <li><i class="fas fa-book"></i> ${obtenerNombreSede(sedeId)}: ${cantidad} ejemplares</li>
                            `).join('')}
                        </ul>
                    </div>
                ` : ''}
            `);
            
            // Esperar 2 segundos antes de redirigir
            setTimeout(() => {
                window.location.href = `/biblioges/bibliografias-declaradas/${bibliografiaDeclaradaId}`;
            }, 2000);
        } else {
            window.actualizarProgreso(0, 'Error en el proceso', `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> ${data.message}
                </div>
            `);
            
            // Esperar 3 segundos antes de ocultar la modal
            setTimeout(() => {
                window.ocultarModalProgreso();
            }, 3000);
        }
    } catch (error) {
        console.error('Error:', error);
        window.actualizarProgreso(0, 'Error en el proceso', `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> Error al guardar las bibliografías: ${error.message}
            </div>
        `);
        
        // Esperar 3 segundos antes de ocultar la modal
        setTimeout(() => {
            window.ocultarModalProgreso();
        }, 3000);
    }
}

// Función auxiliar para obtener el nombre de la sede
function obtenerNombreSede(sedeId) {
    const sedes = {
        '1': 'Antofagasta',
        '2': 'Coquimbo',
        '3': 'San Pedro de Atacama'
    };
    return sedes[sedeId] || `Sede ${sedeId}`;
} 