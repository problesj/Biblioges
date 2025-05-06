<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use src\Models\BibliografiaDisponible;
use src\Models\BibliografiaDeclarada;
use src\Models\Sede;

class BibliografiaDisponibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bibliografias = BibliografiaDeclarada::all();
        $sedes = Sede::all();

        foreach ($bibliografias as $bibliografia) {
            // Para cada bibliografía, crear disponibilidad en diferentes sedes
            foreach ($sedes as $sede) {
                if ($bibliografia->formato === 'Físico y Digital') {
                    // Si es físico y digital, crear copias físicas en la sede y copias digitales
                    BibliografiaDisponible::create([
                        'bibliografia_declarada_id' => $bibliografia->id,
                        'sede_id' => $sede->id,
                        'ejemplares' => rand(1, 5),
                        'ejemplares_digitales' => rand(1, 3),
                        'estado' => 'A'
                    ]);
                } elseif ($bibliografia->formato === 'Digital') {
                    // Si es solo digital, crear solo copias digitales
                    BibliografiaDisponible::create([
                        'bibliografia_declarada_id' => $bibliografia->id,
                        'sede_id' => $sede->id,
                        'ejemplares' => null,
                        'ejemplares_digitales' => rand(1, 3),
                        'estado' => 'A'
                    ]);
                } else {
                    // Si es solo físico, crear solo copias físicas
                    BibliografiaDisponible::create([
                        'bibliografia_declarada_id' => $bibliografia->id,
                        'sede_id' => $sede->id,
                        'ejemplares' => rand(1, 5),
                        'ejemplares_digitales' => null,
                        'estado' => 'A'
                    ]);
                }
            }
        }

        $this->command->info('Bibliografías disponibles creadas exitosamente.');
    }
} 