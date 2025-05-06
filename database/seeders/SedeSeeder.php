<?php

namespace Database\Seeders;

use src\Models\Sede;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codigoBase = 'SED';
        $contador = 1;

        $sedes = [
            [
                'nombre' => 'Sede Central',
                'estado' => 1
            ],
            [
                'nombre' => 'Sede Norte',
                'estado' => 1
            ],
            [
                'nombre' => 'Sede Sur',
                'estado' => 1
            ],
            [
                'nombre' => 'Sede Este',
                'estado' => 1
            ],
            [
                'nombre' => 'Sede Oeste',
                'estado' => 1
            ]
        ];

        foreach ($sedes as $sede) {
            Sede::create([
                'codigo' => $codigoBase . str_pad($contador++, 3, '0', STR_PAD_LEFT),
                'nombre' => $sede['nombre'],
                'estado' => $sede['estado']
            ]);
        }

        $this->command->info('Sedes creadas exitosamente.');
    }
} 