<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartamentoSeeder::class,
            FacultadSeeder::class,
            SedeSeeder::class,
            CarreraSeeder::class,
            AsignaturaSeeder::class,
            AutorSeeder::class,
            BibliografiaDeclaradaSeeder::class,
            LibroSeeder::class,
            ArticuloSeeder::class,
            SoftwareSeeder::class,
            SitioWebSeeder::class,
            BibliografiaDisponibleSeeder::class
        ]);
    }
} 