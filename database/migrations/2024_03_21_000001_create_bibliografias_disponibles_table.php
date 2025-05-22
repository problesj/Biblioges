<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bibliografias_disponibles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_declarada_id')->nullable()->constrained('bibliografias_declaradas')->onDelete('set null');
            $table->string('titulo', 250);
            $table->integer('anio_edicion');
            $table->string('url_acceso', 500)->nullable();
            $table->string('url_catalogo', 500)->nullable();
            $table->enum('disponibilidad', ['impreso', 'electronico', 'ambos']);
            $table->string('id_mms', 50)->nullable()->unique();
            $table->integer('ejemplares_digitales')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });

        Schema::create('bibliografias_disponibles_sedes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_disponible_id')->constrained('bibliografias_disponibles')->onDelete('cascade');
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->integer('ejemplares');
            $table->timestamps();

            $table->unique(['bibliografia_disponible_id', 'sede_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bibliografias_disponibles_sedes');
        Schema::dropIfExists('bibliografias_disponibles');
    }
}; 