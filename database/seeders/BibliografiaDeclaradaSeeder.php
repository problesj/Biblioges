<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\BibliografiaDeclarada;
use src\Models\Autor;
use src\Models\Asignatura;
use src\Models\Libro;
use src\Models\Articulo;
use src\Models\Tesis;
use src\Models\Software;
use src\Models\SitioWeb;
use src\Models\Generico;

class BibliografiaDeclaradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignaturas = Asignatura::all();
        $autores = Autor::all();

        // Bibliografías para Cálculo I
        BibliografiaDeclarada::create([
            'titulo' => 'Cálculo de una Variable',
            'tipo' => 'libro',
            'anio_publicacion' => 2020,
            'editorial' => 'Editorial Matemática',
            'formato' => 'Físico y Digital',
            'estado' => 'A',
            'asignatura_id' => 1
        ])->autores()->attach([1, 2]);

        // Bibliografías para Física I
        BibliografiaDeclarada::create([
            'titulo' => 'Física Universitaria',
            'tipo' => 'libro',
            'anio_publicacion' => 2019,
            'editorial' => 'Editorial Ciencia',
            'formato' => 'Físico y Digital',
            'estado' => 'A',
            'asignatura_id' => 2
        ])->autores()->attach([3, 4]);

        // Bibliografías para Programación I
        BibliografiaDeclarada::create([
            'titulo' => 'Introducción a la Programación',
            'tipo' => 'libro',
            'anio_publicacion' => 2021,
            'editorial' => 'Editorial Tecnología',
            'formato' => 'Digital',
            'estado' => 'A',
            'asignatura_id' => 3
        ])->autores()->attach([5]);

        // Artículos científicos
        BibliografiaDeclarada::create([
            'titulo' => 'Avances en Métodos Numéricos',
            'tipo' => 'articulo',
            'anio_publicacion' => 2022,
            'editorial' => 'Revista Matemática Moderna',
            'formato' => 'Digital',
            'estado' => 'A',
            'asignatura_id' => 1
        ])->autores()->attach([6, 7]);

        // Software educativo
        BibliografiaDeclarada::create([
            'titulo' => 'GeoGebra',
            'tipo' => 'software',
            'anio_publicacion' => 2023,
            'editorial' => 'GeoGebra International',
            'formato' => 'Digital',
            'estado' => 'A',
            'asignatura_id' => 1
        ])->autores()->attach([8]);

        // Sitios web educativos
        BibliografiaDeclarada::create([
            'titulo' => 'Portal de Recursos Matemáticos',
            'tipo' => 'sitio_web',
            'anio_publicacion' => 2023,
            'editorial' => 'Universidad Virtual',
            'formato' => 'Digital',
            'estado' => 'A',
            'asignatura_id' => 1
        ])->autores()->attach([9, 10]);

        $this->command->info('Bibliografías declaradas creadas exitosamente.');
    }
} 