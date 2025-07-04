<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoberturasCarrerasTable extends Migration
{
    public function up()
    {
        Schema::create('coberturas_carreras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrera_id');
            $table->string('codigo_carrera');
            $table->string('nombre_carrera');
            $table->string('sede');
            $table->decimal('cobertura_basica', 5, 2);
            $table->decimal('cobertura_complementaria', 5, 2);
            $table->timestamp('fecha_calculo');
            $table->integer('total_bibliografias_declaradas');
            $table->integer('total_bibliografias_disponibles_declaradas');
            $table->integer('total_bibliografias_disponibles');
            $table->timestamps();

            $table->foreign('carrera_id')
                  ->references('id')
                  ->on('carreras')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coberturas_carreras');
    }
} 