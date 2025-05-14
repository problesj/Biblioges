<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_id')->constrained('bibliografias_declaradas')->onDelete('cascade');
            $table->string('issn')->nullable();
            $table->string('titulo_revista');
            $table->string('cronologia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('articulos');
    }
}; 