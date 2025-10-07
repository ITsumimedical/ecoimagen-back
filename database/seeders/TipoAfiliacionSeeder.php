<?php

namespace Database\Seeders;

use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoAfiliacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Afiliaciones = [
                [
                    'nombre'  => 'CONTRIBUTIVO',
                    'user_id' => 1
                ],
                [
                    'nombre'  => 'SUBSIDIADO',
                    'user_id' => 1
                ],
                [
                    'nombre'  => 'EXCEPCIÓN (ESPECIAL)',
                    'user_id' => 1
                ],
                [
                    'nombre'  => 'ADAPATADO',
                    'user_id' => 1
                ],
            ];
            foreach ($Afiliaciones as $Afiliacion) {
                TipoAfiliacion::updateOrCreate([
                    'nombre'  => $Afiliacion['nombre']
                ],[
                    'nombre'  => $Afiliacion['nombre'],
                    'user_id' => $Afiliacion['user_id'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo afiliacion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
