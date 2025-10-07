<?php

namespace Database\Seeders;

use App\Http\Modules\Epidemiologia\Models\EventoSivigila;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventoSivigilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $eventoSivigilas = [
                [
                    'nombre_evento' => 'ACCIDENTE OFIDICO',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'AGRESIONES POR ANIMALES POTENCIALMENTE TRANSMISORES DE RABIA',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'CÁNCER DE CUELLO UTERINO',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'CÁNCER DE MAMA',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'CÁNCER EN MENORES DE 18 AÑOS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 18,
                ],
                [
                    'nombre_evento' => 'DEFECTOS CONGENITOS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 1,
                ],
                [
                    'nombre_evento' => 'DENGUE',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'DESNUTRICION EN MENORES DE 5 AÑOS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 5,
                ],
                [
                    'nombre_evento' => 'ENFERMEDADES HUERFANAS - RARAS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'ENFERMEDADES TRANSMITIDAS POR ALIMENTOS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'HEPATITIS A',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'HEPATITIS B',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'HEPATITIS C',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'INTOXICACIONES POR SUSTANCIAS QUIMICAS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'LEPTOSPIROSIS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'MALARIA',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'MORBILIDAD MATERNA EXTREMA',
                    'rango_edad_inicio' => 10,
                    'rango_edad_final' => 70,
                    'gestante' => true
                ],
                [
                    'nombre_evento' => 'TUBERCULOSIS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'VARICELA',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'VIH - SIDA',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'VIOLENCIAS DE GENERO',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],
                [
                    'nombre_evento' => 'LEISHMANIASIS',
                    'rango_edad_inicio' => 0,
                    'rango_edad_final' => 150,
                ],

            ];

            foreach ($eventoSivigilas as $eventoSivigila) {
                EventoSivigila::updateOrCreate([
                    'nombre_evento' => $eventoSivigila['nombre_evento'],
                ], [
                    'nombre_evento' => $eventoSivigila['nombre_evento'],
                    'rango_edad_inicio' => $eventoSivigila['rango_edad_inicio'],
                    'rango_edad_final' => $eventoSivigila['rango_edad_final'],
                    'gestante' => $eventoSivigila['gestante'] ?? false,
                ]);
            }

        } catch (\Throwable $th) {
            Log::error('Error en EventoSivigilaSeeder: ' . $th->getMessage());
        }
    }
}
