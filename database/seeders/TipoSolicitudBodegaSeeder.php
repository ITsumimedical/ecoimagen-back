<?php

namespace Database\Seeders;

use App\Http\Modules\TipoSolicitudBodegas\Models\TipoSolicitudBodega;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoSolicitudBodegaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $solicitudes = [
                ['nombre' => 'Solicitud de Compras','estado_id' => 1],
                ['nombre' => 'Traslado','estado_id' => 1],
                ['nombre' => 'Ajuste de Entrada','estado_id' => 1],
                ['nombre' => 'Ajuste de Salida','estado_id' => 1],
            ];
            foreach ($solicitudes as $solicitud){
                TipoSolicitudBodega::updateOrCreate([
                    'nombre'    => $solicitud['nombre']
                ],[
                    'nombre'    => $solicitud['nombre'],
                    'estado_id' => $solicitud['estado_id'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo solicitud bodega'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
