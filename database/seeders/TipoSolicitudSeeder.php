<?php

namespace Database\Seeders;

use App\Http\Modules\TipoSolicitud\Models\TipoSolicitude;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        try {
            $tipos = [
                ['nombre' => 'Normal', 'descripcion' => 'Normal'],
                ['nombre' => 'Prioritario', 'descripcion' => 'Prioritario'],


            ];
            foreach ($tipos as $tipo) {
                TipoSolicitude::updateOrCreate([
                    'nombre' => $tipo['nombre']
                ],[
                    'nombre' => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion']
                ]);
            };
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'No se ha podido ejecutar el seeder TipoSolicitudSeeder'],
            Response::HTTP_BAD_REQUEST);
        }
    }
}
