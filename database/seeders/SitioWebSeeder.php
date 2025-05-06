<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\SitioWeb;
use src\Models\BibliografiaDeclarada;

class SitioWebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las bibliografías declaradas de tipo sitio_web
        $bibliografias = BibliografiaDeclarada::where('tipo', 'sitio_web')->get();

        foreach ($bibliografias as $bibliografia) {
            // Verificar si ya existe un sitio web para esta bibliografía
            if (!$bibliografia->sitioWeb) {
                SitioWeb::create([
                    'bibliografia_id' => $bibliografia->id,
                    'url' => 'https://www.ejemplo' . rand(1, 100) . '.com',
                    'fecha_consulta' => now()->subDays(rand(1, 30)),
                    'organizacion' => 'Organización ' . rand(1, 10),
                    'tipo_contenido' => ['Blog', 'Portal', 'Base de datos', 'Repositorio'][rand(0, 3)]
                ]);
            }
        }

        $this->command->info('Sitios web creados exitosamente.');
    }
} 