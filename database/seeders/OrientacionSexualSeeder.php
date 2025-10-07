<?php

namespace Database\Seeders;

use App\Http\Modules\OrientacionesSexuales\Models\OrientacionSexual;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class OrientacionSexualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $orientaciones = [
                ['nombre'=>'Asexual','descripcion'=>'no experimenta atracción sexual y/o no desea contacto sexual',],
                ['nombre'=>'Bisexual','descripcion'=>'atracción romántica, la atracción sexual o la conducta sexual dirigida tanto hacia el sexo opuesto como hacia el sexo propio',],
                ['nombre'=>'Pansexual','descripcion'=>'atracción sexual, romántica o emocional hacia otras personas independientemente de su sexo o identidad de género',],
                ['nombre'=>'Homosexual','descripcion'=>'atracción romántica, atracción sexual o comportamiento sexual entre miembros del mismo sexo',],
                ['nombre'=>'Heterosexual','descripcion'=>'atracción romántica, atracción sexual o comportamiento sexual entre personas de distinto sexo',],
                ['nombre'=>'No refiere','descripcion'=>'No aplica',],
            ];

            foreach ($orientaciones as $orientacion) {
                OrientacionSexual::updateOrCreate([
                    'nombre' => $orientacion['nombre']
                ],[
                    'nombre' => $orientacion['nombre'],
                    'descripcion' => $orientacion['descripcion'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de orientacion sexual'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
