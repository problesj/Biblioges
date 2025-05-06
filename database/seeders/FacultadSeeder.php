<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\Facultad;
use src\Models\Sede;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero necesitamos asegurarnos de que existan sedes
        if (Sede::count() === 0) {
            $this->command->info('No hay sedes creadas. Por favor, ejecute primero el SedeSeeder.');
            return;
        }

        $sedes = Sede::all();
        $codigoBase = 'FAC';
        $contador = 1;

        $facultades = [
            [
                'nombre' => 'Facultad de Ingeniería',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Ciencias',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Humanidades',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Educación',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Ciencias de la Salud',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Ciencias Económicas',
                'estado' => 1
            ],
            [
                'nombre' => 'Facultad de Artes',
                'estado' => 1
            ]
        ];

        foreach ($facultades as $facultad) {
            // Asignar una sede aleatoria
            $sede = $sedes->random();
            
            Facultad::create([
                'codigo' => $codigoBase . str_pad($contador++, 3, '0', STR_PAD_LEFT),
                'nombre' => $facultad['nombre'],
                'sede_id' => $sede->id,
                'estado' => $facultad['estado']
            ]);
        }

        $this->command->info('Facultades creadas exitosamente.');
    }
} 