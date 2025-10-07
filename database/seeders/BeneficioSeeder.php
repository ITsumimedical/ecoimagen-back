<?php

namespace Database\Seeders;

use App\Http\Modules\Beneficios\Models\Beneficio;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class BeneficioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $Beneficios = [
                ['nombre' => 'Reconocimiento', 'horas' => 0, 'permitir_duplicidad' => true],
                ['nombre' => 'Boda', 'horas' => 16, 'permitir_duplicidad' => false],
                ['nombre' => 'Aniversario de boda', 'horas' => 4, 'permitir_duplicidad' => false],
                ['nombre' => 'Día de grado', 'horas' => 8, 'permitir_duplicidad' => true],
                ['nombre' => 'Día de grado del hijo', 'horas' => 4, 'permitir_duplicidad' => true],
                ['nombre' => 'Cumpleaños', 'horas' => 4, 'permitir_duplicidad' => false],
                ['nombre' => 'Vacaciones por antigüedad 8 horas', 'horas' => 8, 'permitir_duplicidad' => false],
                ['nombre' => 'Vacaciones por antigüedad 16 horas', 'horas' => 16, 'permitir_duplicidad' => false],
                ['nombre' => 'Vacaciones por antigüedad 24 horas', 'horas' => 24, 'permitir_duplicidad' => false],
                ['nombre' => 'Bono kubera', 'horas' => 0, 'permitir_duplicidad' => true],
                ['nombre' => 'Kit nacimientos', 'horas' => 0, 'permitir_duplicidad' => false],
                ['nombre' => 'Boletas comfama', 'horas' => 0, 'permitir_duplicidad' => true],
                ['nombre' => 'Salud visual', 'horas' => 0, 'permitir_duplicidad' => true],
                ['nombre' => 'Recreación y actividades', 'horas' => 0, 'permitir_duplicidad' => true],
                ['nombre' => 'Orientación al logro', 'horas' => 0, 'permitir_duplicidad' => true],
            ];
            foreach ($Beneficios as $Beneficio){
                Beneficio::updateOrCreate([
                    'nombre' => $Beneficio['nombre'],
                ],[
                    'nombre' => $Beneficio['nombre'],
                    'horas' => $Beneficio['horas'],
                    'permitir_duplicidad' => $Beneficio['permitir_duplicidad'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de beneficio seeder'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
