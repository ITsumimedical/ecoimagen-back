<?php

namespace Database\Seeders;

use App\Http\Modules\TipoLicenciasEmpleados\Models\TipoLicenciaEmpleado;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoLicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $licencias = [
                ['nombre'   =>  'Remunerada'],
                ['nombre'   =>  'No remunerada'],
                ['nombre'   =>  'Maternidad'],
                ['nombre'   =>  'Paternidad'],
                ['nombre'   =>  'Ausentismo'],
                ['nombre'   =>  'Luto'],
                ['nombre'   =>  'Calamidad'],
            ];
            foreach ($licencias as $licencia) {
                TipoLicenciaEmpleado::updateOrCreate([
                    'nombre' => $licencia['nombre'],
                ],[
                    'nombre' => $licencia['nombre'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo licencia'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
