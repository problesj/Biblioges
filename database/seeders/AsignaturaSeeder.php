<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\Asignatura;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignaturas = [
            [
                'nombre' => 'Cálculo I',
                'tipo' => 'Obligatoria',
                'vigencia_desde' => '202010',
                'vigencia_hasta' => '999999',
                'periodicidad' => 'Semestral',
                'estado' => 'A',
                'url_programa' => 'https://ejemplo.com/programa-calculo1'
            ],
            [
                'nombre' => 'Física I',
                'tipo' => 'Obligatoria',
                'vigencia_desde' => '202010',
                'vigencia_hasta' => '999999',
                'periodicidad' => 'Semestral',
                'estado' => 'A',
                'url_programa' => 'https://ejemplo.com/programa-fisica1'
            ],
            [
                'nombre' => 'Programación I',
                'tipo' => 'Obligatoria',
                'vigencia_desde' => '202010',
                'vigencia_hasta' => '999999',
                'periodicidad' => 'Semestral',
                'estado' => 'A',
                'url_programa' => 'https://ejemplo.com/programa-programacion1'
            ],
            [
                'nombre' => 'Inglés I',
                'tipo' => 'Obligatoria',
                'vigencia_desde' => '202010',
                'vigencia_hasta' => '999999',
                'periodicidad' => 'Semestral',
                'estado' => 'A',
                'url_programa' => 'https://ejemplo.com/programa-ingles1'
            ],
            [
                'nombre' => 'Historia del Arte',
                'tipo' => 'Electiva',
                'vigencia_desde' => '202010',
                'vigencia_hasta' => '999999',
                'periodicidad' => 'Semestral',
                'estado' => 'A',
                'url_programa' => 'https://ejemplo.com/programa-historia-arte'
            ]
        ];

        foreach ($asignaturas as $asignatura) {
            Asignatura::create($asignatura);
        }

        $this->command->info('Asignaturas creadas exitosamente.');
    }
} 