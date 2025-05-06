<?php

namespace Database\Seeders;

use src\Models\Articulo;
use src\Models\BibliografiaDeclarada;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las bibliografías declaradas de tipo artículo
        $bibliografias = BibliografiaDeclarada::where('tipo', 'articulo')->get();

        foreach ($bibliografias as $bibliografia) {
            // Verificar si ya existe un artículo para esta bibliografía
            if (!$bibliografia->articulo) {
                Articulo::create([
                    'bibliografia_id' => $bibliografia->id,
                    'issn' => 'ISSN ' . rand(1000, 9999) . '-' . rand(1000, 9999),
                    'titulo_revista' => 'Revista Científica ' . rand(1, 100),
                    'cronologia' => 'Vol. ' . rand(1, 10) . ', No. ' . rand(1, 4) . ', ' . rand(2010, 2023)
                ]);
            }
        }

        $this->command->info('Artículos creados exitosamente.');
    }
} 