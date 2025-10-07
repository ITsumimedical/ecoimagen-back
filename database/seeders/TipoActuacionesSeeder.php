<?php

namespace Database\Seeders;

use App\Http\Modules\TipoActuaciones\Models\TipoActuacion;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoActuacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            $actuaciones = [
                [
                    'nombre' => 'ACCION DE TUTELA'
                ],

                [
                    'nombre' => 'ARRESTO'
                ],

                [
                    'nombre' => 'DEMANDA'
                ],

                [
                    'nombre' => 'DERECHO DE PETICIÓN'
                ],

                [
                    'nombre' => 'DESACATO'
                ],

                [
                    'nombre' => 'FALLO'
                ],

                [
                    'nombre' => 'MEDIDA PROVISIONAL'
                ],

                [
                    'nombre' => 'REQUERIMIENTO'
                ],

                [
                    'nombre' => 'SANCION'
                ],
            ];
            foreach ($actuaciones as $actuacion) {
                TipoActuacion::updateOrCreate([
                    'nombre' => $actuacion['nombre']
                ],[
                    'nombre' => $actuacion['nombre'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo actuaciónes'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
