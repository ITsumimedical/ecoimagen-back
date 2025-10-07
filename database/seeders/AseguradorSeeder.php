<?php

namespace Database\Seeders;

use App\Http\Modules\Aseguradores\Models\Asegurador;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class AseguradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Aseguradores = [
                ['nombre' => 'Magisterio',],
                ['nombre' => 'Magdalena Ferrocariles',],
                ['nombre' => 'Universidad De Antioquia',],
                ['nombre' => 'Medimas',],
                ['nombre' => 'Salud Ocupacional',],
            ];
            foreach ($Aseguradores as $Asegurador) {
                Asegurador::updateOrCreate([
                    'nombre' => $Asegurador['nombre'],
                ],[
                    'nombre' => $Asegurador['nombre'],
                ]);
            };
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de asegurador'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
