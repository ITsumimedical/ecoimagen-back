<?php

namespace Database\Seeders;

use App\Http\Modules\TipoVacantesTH\Models\TipoVacanteTh;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoVacanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $vacantes = [
                ['nombre' => 'Interno','descripcion' => 'Vacante solo para personal interno!','estado_id' => 1],
                ['nombre' => 'Externo','descripcion' => 'Vacante solo para personal externo!','estado_id' => 1],
            ];
            foreach ($vacantes as $vacante) {
                TipoVacanteTh::updateOrCreate(
                    ['nombre' => $vacante['nombre']],
                    [
                    'nombre'      =>  $vacante['nombre'],
                    'descripcion' =>  $vacante['descripcion'],
                    'estado_id'   =>  $vacante['estado_id'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo vacante'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
