<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('tesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_id')->constrained('bibliografias_declaradas')->onDelete('cascade');
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('tesis');
    }
}; 