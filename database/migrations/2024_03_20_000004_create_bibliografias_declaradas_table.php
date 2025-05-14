<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('bibliografias_declaradas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['libro', 'articulo', 'tesis', 'software', 'sitio_web', 'generico']);
            $table->integer('anio_publicacion');
            $table->string('editorial');
            $table->string('edicion')->nullable();
            $table->string('url')->nullable();
            $table->text('nota')->nullable();
            $table->enum('formato', ['impreso', 'electronico', 'ambos']);
            $table->enum('estado', ['A', 'I'])->default('A');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('bibliografias_declaradas');
    }
}; 