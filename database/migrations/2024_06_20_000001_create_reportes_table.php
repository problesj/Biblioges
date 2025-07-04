<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Inicializar Eloquent
require_once __DIR__ . '/../../src/config/eloquent.php';

class CreateReportesTable
{
    public function up()
    {
        Capsule::schema()->create('reportes', function ($table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('reportes');
    }
}

// Ejecutar la migración
$migration = new CreateReportesTable();
$migration->up();

echo "Tabla reportes creada exitosamente.\n"; 