<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditorialToBibliografiasDisponibles extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bibliografias_disponibles', function (Blueprint $table) {
            $table->string('editorial', 250)->nullable()->after('titulo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bibliografias_disponibles', function (Blueprint $table) {
            $table->dropColumn('editorial');
        });
    }
} 