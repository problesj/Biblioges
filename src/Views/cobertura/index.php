<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generar Reporte de Cobertura Bibliográfica</h3>
                </div>
                <div class="card-body">
                    <form action="<?= Config::get('app_url') ?>reportes/cobertura/generar-reporte" method="POST" id="reporteForm">
                        <div class="form-group">
                            <label for="carrera_id">Carrera</label>
                            <select class="form-control" id="carrera_id" name="carrera_id" required>
                                <option value="">Seleccione una carrera</option>
                                <?php foreach ($carreras as $carrera): ?>
                                    <option value="<?= $carrera->id ?>"><?= $carrera->codigo ?> - <?= $carrera->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-4">
                            <label>Asignaturas de Formación a Incluir</label>
                            <div id="asignaturasFormacion" class="mt-2">
                                <!-- Se llenará dinámicamente con AJAX -->
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-excel"></i> Generar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('carrera_id').addEventListener('change', function() {
    const carreraId = this.value;
    if (carreraId) {
        // Cargar asignaturas de formación de la carrera seleccionada
        fetch(`<?= Config::get('app_url') ?>reportes/cobertura/asignaturas-formacion/${carreraId}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('asignaturasFormacion');
                container.innerHTML = '';
                
                data.forEach(asignatura => {
                    const div = document.createElement('div');
                    div.className = 'custom-control custom-checkbox';
                    div.innerHTML = `
                        <input type="checkbox" class="custom-control-input" 
                               id="asignatura_${asignatura.id}" 
                               name="asignaturas_formacion[]" 
                               value="${asignatura.id}">
                        <label class="custom-control-label" for="asignatura_${asignatura.id}">
                            ${asignatura.codigo} - ${asignatura.nombre}
                        </label>
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar las asignaturas de formación');
            });
    } else {
        document.getElementById('asignaturasFormacion').innerHTML = '';
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 