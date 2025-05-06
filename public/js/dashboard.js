document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const statsContainer = document.getElementById('statsContainer');
    const chartsContainer = document.getElementById('chartsContainer');
    const recentActivity = document.getElementById('recentActivity');

    // Cargar estadísticas
    cargarEstadisticas();

    // Cargar gráficos
    cargarGraficos();

    // Cargar actividad reciente
    cargarActividadReciente();

    // Funciones auxiliares
    function cargarEstadisticas() {
        fetch('/api/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    actualizarEstadisticas(data.data);
                } else {
                    mostrarNotificacion('Error al cargar las estadísticas', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar las estadísticas', 'error');
            });
    }

    function actualizarEstadisticas(stats) {
        if (!statsContainer) return;

        statsContainer.innerHTML = `
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-info">
                    <h3>${stats.total_carreras}</h3>
                    <p>Carreras</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-info">
                    <h3>${stats.total_asignaturas}</h3>
                    <p>Asignaturas</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div class="stat-info">
                    <h3>${stats.total_bibliografias}</h3>
                    <p>Bibliografías</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>${stats.total_usuarios}</h3>
                    <p>Usuarios</p>
                </div>
            </div>
        `;
    }

    function cargarGraficos() {
        // Gráfico de bibliografías por carrera
        fetch('/api/dashboard/bibliografias-por-carrera')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    crearGraficoBibliografiasPorCarrera(data.data);
                }
            });

        // Gráfico de bibliografías por tipo
        fetch('/api/dashboard/bibliografias-por-tipo')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    crearGraficoBibliografiasPorTipo(data.data);
                }
            });
    }

    function crearGraficoBibliografiasPorCarrera(data) {
        const ctx = document.getElementById('bibliografiasPorCarreraChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.carrera),
                datasets: [{
                    label: 'Bibliografías por Carrera',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(52, 152, 219, 0.5)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function crearGraficoBibliografiasPorTipo(data) {
        const ctx = document.getElementById('bibliografiasPorTipoChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.map(item => item.tipo),
                datasets: [{
                    data: data.map(item => item.total),
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.5)',
                        'rgba(46, 204, 113, 0.5)',
                        'rgba(241, 196, 15, 0.5)',
                        'rgba(231, 76, 60, 0.5)'
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)',
                        'rgba(241, 196, 15, 1)',
                        'rgba(231, 76, 60, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function cargarActividadReciente() {
        fetch('/api/dashboard/actividad-reciente')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    actualizarActividadReciente(data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar la actividad reciente', 'error');
            });
    }

    function actualizarActividadReciente(actividades) {
        if (!recentActivity) return;

        const tbody = recentActivity.querySelector('tbody');
        tbody.innerHTML = '';

        actividades.forEach(actividad => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${actividad.fecha}</td>
                <td>${actividad.usuario}</td>
                <td>${actividad.accion}</td>
                <td>${actividad.detalle}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Actualizar datos cada 5 minutos
    setInterval(() => {
        cargarEstadisticas();
        cargarGraficos();
        cargarActividadReciente();
    }, 300000);
}); 