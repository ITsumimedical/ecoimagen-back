<?php

namespace Database\Seeders;

use App\Http\Modules\Ordenamiento\Models\TipoOrden;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoOrdenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $ordenes = [
                [
                'nombre'      =>  'Medicamentos',
                'descripcion'  =>  'Medicamentos',
                ],
                [
                'nombre'      =>  'Servicios',
                'descripcion'  =>  'Servicios',
                ],
            ];
            foreach ($ordenes as $orden) {
                TipoOrden::updateOrCreate([
                    'nombre' => $orden['nombre']
                ],[
                    'nombre' => $orden['nombre'],
                    'descripcion' => $orden['descripcion']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo ordenes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
