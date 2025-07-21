<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('url_libro')->nullable();
            $table->string('imagen_url')->nullable();
            $table->integer('cantidad_semestres')->default(10);
            $table->enum('estado', ['A', 'I'])->default('A');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('carreras');
    }
}; 