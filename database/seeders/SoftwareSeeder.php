<?php

namespace Database\Seeders;

use src\Models\Software;
use src\Models\BibliografiaDeclarada;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las bibliografías declaradas de tipo software
        $bibliografias = BibliografiaDeclarada::where('tipo', 'software')->get();

        foreach ($bibliografias as $bibliografia) {
            // Verificar si ya existe un software para esta bibliografía
            if (!$bibliografia->software) {
                Software::create([
                    'bibliografia_id' => $bibliografia->id,
                    'version' => 'v' . rand(1, 5) . '.' . rand(0, 9) . '.' . rand(0, 9),
                    'plataforma' => ['Windows', 'Linux', 'MacOS', 'Multiplataforma'][rand(0, 3)],
                    'tipo_licencia' => ['Gratuita', 'Comercial', 'Open Source', 'Trial'][rand(0, 3)]
                ]);
            }
        }

        $this->command->info('Software creado exitosamente.');
    }
} 