<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\Carrera;
use src\Models\CarreraEspejo;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carreras = [
            [
                'nombre' => 'Ingeniería de Sistemas',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-sistemas'
            ],
            [
                'nombre' => 'Ingeniería Civil',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-civil'
            ],
            [
                'nombre' => 'Medicina',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-medicina'
            ],
            [
                'nombre' => 'Psicología',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-psicologia'
            ],
            [
                'nombre' => 'Administración de Empresas',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-administracion'
            ],
            [
                'nombre' => 'Derecho',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-derecho'
            ],
            [
                'nombre' => 'Arquitectura',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-arquitectura'
            ],
            [
                'nombre' => 'Contabilidad',
                'estado' => 'A',
                'url_libro' => 'https://ejemplo.com/libro-contabilidad'
            ]
        ];

        foreach ($carreras as $carrera) {
            Carrera::create($carrera);
        }

        $this->command->info('Carreras creadas exitosamente.');
    }
} 