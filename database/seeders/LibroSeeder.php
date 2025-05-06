<?php

namespace Database\Seeders;

use src\Models\Libro;
use src\Models\BibliografiaDeclarada;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las bibliografías declaradas de tipo libro
        $bibliografias = BibliografiaDeclarada::where('tipo', 'libro')->get();

        foreach ($bibliografias as $bibliografia) {
            // Verificar si ya existe un libro para esta bibliografía
            if (!$bibliografia->libro) {
                Libro::create([
                    'bibliografia_id' => $bibliografia->id,
                    'isbn' => '978' . rand(100000000, 999999999)
                ]);
            }
        }

        $this->command->info('Libros creados exitosamente.');
    }
} 