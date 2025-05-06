<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('bibliografia_autor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bibliografia_declarada_id')->constrained('bibliografias_declaradas');
            $table->foreignId('autor_id')->constrained('autores');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('bibliografia_autor');
    }
}; 