<?php

namespace Database\Seeders;

use src\Models\Autor;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autores = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Pérez',
                'genero' => 'Masculino'
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'García',
                'genero' => 'Femenino'
            ],
            [
                'nombres' => 'Carlos',
                'apellidos' => 'López',
                'genero' => 'Masculino'
            ],
            [
                'nombres' => 'Ana',
                'apellidos' => 'Martínez',
                'genero' => 'Femenino'
            ],
            [
                'nombres' => 'Pedro',
                'apellidos' => 'Rodríguez',
                'genero' => 'Masculino'
            ],
            [
                'nombres' => 'Laura',
                'apellidos' => 'Sánchez',
                'genero' => 'Femenino'
            ],
            [
                'nombres' => 'Miguel',
                'apellidos' => 'González',
                'genero' => 'Masculino'
            ],
            [
                'nombres' => 'Sofía',
                'apellidos' => 'Fernández',
                'genero' => 'Femenino'
            ],
            [
                'nombres' => 'David',
                'apellidos' => 'Ruiz',
                'genero' => 'Masculino'
            ],
            [
                'nombres' => 'Elena',
                'apellidos' => 'Díaz',
                'genero' => 'Femenino'
            ]
        ];

        foreach ($autores as $autor) {
            Autor::create($autor);
        }

        $this->command->info('Autores creados exitosamente.');
    }
} 