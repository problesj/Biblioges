document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const reporteForm = document.getElementById('reporteForm');
    const reporteResultado = document.getElementById('reporteResultado');
    const btnGenerarReporte = document.getElementById('btnGenerarReporte');
    const btnExportarPDF = document.getElementById('btnExportarPDF');
    const btnExportarExcel = document.getElementById('btnExportarExcel');

    // Event Listeners
    if (btnGenerarReporte) {
        btnGenerarReporte.addEventListener('click', generarReporte);
    }

    if (btnExportarPDF) {
        btnExportarPDF.addEventListener('click', exportarPDF);
    }

    if (btnExportarExcel) {
        btnExportarExcel.addEventListener('click', exportarExcel);
    }

    // Funciones principales
    function generarReporte() {
        if (!reporteForm) return;

        const formData = new FormData(reporteForm);
        const data = Object.fromEntries(formData.entries());

        // Validar datos del formulario
        if (!validarFormularioReporte(data)) {
            return;
        }

        // Mostrar indicador de carga
        mostrarCargando();

        // Enviar solicitud al servidor
        fetch('/api/reportes/generar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarResultadoReporte(result.data);
            } else {
                mostrarNotificacion(result.message || 'Error al generar el reporte', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al generar el reporte', 'error');
        })
        .finally(() => {
            ocultarCargando();
        });
    }

    function exportarPDF() {
        if (!reporteResultado) return;

        const data = obtenerDatosReporte();
        if (!data) return;

        fetch('/api/reportes/exportar-pdf', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'reporte.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al exportar el reporte a PDF', 'error');
        });
    }

    function exportarExcel() {
        if (!reporteResultado) return;

        const data = obtenerDatosReporte();
        if (!data) return;

        fetch('/api/reportes/exportar-excel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'reporte.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al exportar el reporte a Excel', 'error');
        });
    }

    // Funciones auxiliares
    function validarFormularioReporte(data) {
        const errores = [];

        if (!data.tipo_reporte) {
            errores.push('Seleccione un tipo de reporte');
        }

        if (!data.fecha_inicio) {
            errores.push('Seleccione una fecha de inicio');
        }

        if (!data.fecha_fin) {
            errores.push('Seleccione una fecha de fin');
        }

        if (new Date(data.fecha_inicio) > new Date(data.fecha_fin)) {
            errores.push('La fecha de inicio debe ser anterior a la fecha de fin');
        }

        if (errores.length > 0) {
            mostrarNotificacion(errores.join('<br>'), 'error');
            return false;
        }

        return true;
    }

    function mostrarResultadoReporte(data) {
        if (!reporteResultado) return;

        let html = '';

        switch (data.tipo) {
            case 'bibliografias':
                html = generarTablaBibliografias(data.datos);
                break;
            case 'asignaturas':
                html = generarTablaAsignaturas(data.datos);
                break;
            case 'carreras':
                html = generarTablaCarreras(data.datos);
                break;
            default:
                html = '<p>No se pudo generar la visualización del reporte</p>';
        }

        reporteResultado.innerHTML = html;
    }

    function generarTablaBibliografias(datos) {
        return `
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Asignatura</th>
                        <th>Carrera</th>
                        <th>Tipo</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    ${datos.map(item => `
                        <tr>
                            <td>${item.titulo}</td>
                            <td>${item.autor}</td>
                            <td>${item.asignatura}</td>
                            <td>${item.carrera}</td>
                            <td>${item.tipo}</td>
                            <td>${item.fecha_registro}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function generarTablaAsignaturas(datos) {
        return `
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Carrera</th>
                        <th>Semestre</th>
                        <th>Créditos</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    ${datos.map(item => `
                        <tr>
                            <td>${item.codigo}</td>
                            <td>${item.nombre}</td>
                            <td>${item.carrera}</td>
                            <td>${item.semestre}</td>
                            <td>${item.creditos}</td>
                            <td>${item.estado}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function generarTablaCarreras(datos) {
        return `
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th>Total Asignaturas</th>
                    </tr>
                </thead>
                <tbody>
                    ${datos.map(item => `
                        <tr>
                            <td>${item.codigo}</td>
                            <td>${item.nombre}</td>
                            <td>${item.duracion}</td>
                            <td>${item.estado}</td>
                            <td>${item.total_asignaturas}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function obtenerDatosReporte() {
        if (!reporteResultado) return null;

        const formData = new FormData(reporteForm);
        const data = Object.fromEntries(formData.entries());

        return {
            tipo: data.tipo_reporte,
            fecha_inicio: data.fecha_inicio,
            fecha_fin: data.fecha_fin,
            filtros: {
                carrera: data.carrera,
                asignatura: data.asignatura,
                estado: data.estado
            }
        };
    }

    function mostrarCargando() {
        if (reporteResultado) {
            reporteResultado.innerHTML = '<div class="loading">Generando reporte...</div>';
        }
    }

    function ocultarCargando() {
        // La carga se oculta automáticamente cuando se actualiza el contenido
    }
}); 