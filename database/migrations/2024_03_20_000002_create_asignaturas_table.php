<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('nombre', 100);
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->tinyInteger('semestre');
            $table->tinyInteger('creditos');
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();

            $table->index(['carrera_id', 'semestre']);
            $table->index('codigo');
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('asignaturas');
    }
}; 