<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up(): void
    {
        Capsule::schema()->create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['admin', 'user'])->default('user');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });

        // Crear usuario admin por defecto
        $password = password_hash('password', PASSWORD_DEFAULT);
        Capsule::table('usuarios')->insert([
            'nombre' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => $password,
            'rol' => 'admin',
            'estado' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('usuarios');
    }
}; 