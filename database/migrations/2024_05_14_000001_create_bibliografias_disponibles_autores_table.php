<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bibliografias_disponibles_autores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_disponible_id')->constrained('bibliografias_disponibles')->onDelete('cascade');
            $table->foreignId('autor_id')->constrained('autores')->onDelete('cascade');
            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['bibliografia_disponible_id', 'autor_id'], 'unique_bibliografia_autor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliografias_disponibles_autores');
    }
}; 