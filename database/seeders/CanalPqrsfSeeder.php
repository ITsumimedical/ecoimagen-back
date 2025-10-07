<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Modules\GestionPqrsf\Canales\Models\Canalpqrsf;

class CanalPqrsfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $canales = [
                ['nombre' => 'Buzón'],
                ['nombre' => 'Presencial'],
                ['nombre' => 'Escrito'],
                ['nombre' => 'Veeduría'],
                ['nombre' => 'Telefónico'],
                ['nombre' => 'Fiduprevisora'],
                ['nombre' => 'Comité regional'],
                ['nombre' => 'Procuraduría'],
                ['nombre' => 'Personería'],
                ['nombre' => 'Contraloría'],
                ['nombre' => 'Supersalud'],
                ['nombre' => 'Secretaría de educación'],
                ['nombre' => 'Derecho de petición'],
                ['nombre' => 'EPS Medimas'],
                ['nombre' => 'Correo electrónico'],
                ['nombre' => 'Redes sociales'],
                ['nombre' => 'Encuesta de satisfacción'],
                ['nombre' => 'DSSA'],
                ['nombre' => 'Secretaría de salud'],
                ['nombre' => 'FPSF'],
                ['nombre' => 'Jorge te ayuda'],
                ['nombre' => 'Web'],
            ];
            foreach ($canales as $canal) {
                Canalpqrsf::updateOrCreate([
                    'nombre' => $canal['nombre'],
                ],[
                    'nombre' => $canal['nombre']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de de canalPqrsfSeeder'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
