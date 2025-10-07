<?php

namespace Database\Seeders;

use App\Http\Modules\TiposNovedadAfiliados\Models\tipoNovedadAfiliados;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoNovedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $novedades = [
                [
                    'nombre'       => 'Usuario Nuevo',
                    'descripcion'  => 'Usuario Nuevo',
                ],

                [
                    'nombre'        => 'Retiro',
                    'descripcion'   => 'Retiro',
                ],

                [
                    'nombre'        => 'Reintegro',
                    'descripcion'   => 'Reintegro',
                ],

                [
                    'nombre'        => 'Cambio de Datos Básicos',
                    'descripcion'   => 'Cambio de Datos Básicos',
                ],

                [
                    'nombre'        => 'Portabilidad Salida',
                    'descripcion'   => 'Portabilidad Salida',
                ],

                [
                    'nombre'        => 'Finalización Portabilidad Salida',
                    'descripcion'   => 'Finalización Portabilidad Salida',
                ],

                [
                    'nombre'        => 'Traslados',
                    'descripcion'   => 'Traslados',
                ],

                [
                    'nombre'        => 'Portabilidad Entrada',
                    'descripcion'   => 'Portabilidad Entrada',
                ],

                [
                    'nombre'        => 'Finalización Portabilidad Entrada',
                    'descripcion'   => 'Finalización Portabilidad Entrada',
                ],
            ];
                foreach ($novedades as $novedad){
                    tipoNovedadAfiliados::updateOrCreate([
                        'nombre' => $novedad['nombre']
                    ],[
                        'nombre' => $novedad['nombre'],
                        'descripcion' => $novedad['descripcion']
                    ]);
                }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo novedad'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
