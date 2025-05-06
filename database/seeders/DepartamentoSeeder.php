<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\Departamento;
use src\Models\Facultad;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero necesitamos asegurarnos de que existan facultades
        if (Facultad::count() === 0) {
            $this->command->info('No hay facultades creadas. Por favor, ejecute primero el FacultadSeeder.');
            return;
        }

        $facultades = Facultad::all();
        $codigoBase = 'DEP';
        $contador = 1;

        $departamentos = [
            [
                'nombre' => 'Departamento de Ciencias Básicas',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ingeniería',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ciencias Sociales',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Humanidades',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ciencias de la Salud',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ciencias Económicas',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Artes y Diseño',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ciencias de la Computación',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Ciencias Ambientales',
                'estado' => 1
            ],
            [
                'nombre' => 'Departamento de Lenguas',
                'estado' => 1
            ]
        ];

        foreach ($departamentos as $departamento) {
            // Asignar una facultad aleatoria
            $facultad = $facultades->random();
            
            Departamento::create([
                'codigo' => $codigoBase . str_pad($contador++, 3, '0', STR_PAD_LEFT),
                'nombre' => $departamento['nombre'],
                'facultad_id' => $facultad->id,
                'estado' => $departamento['estado']
            ]);
        }

        $this->command->info('Departamentos creados exitosamente.');
    }
} 