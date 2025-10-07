<?php

namespace Database\Seeders;

use App\Http\Modules\Proyectos\Models\Proyecto;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class ProyectoThSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $proyectos = [
                [
                    'nombre' => 'REDVITAL'
                ],
                [
                    'nombre' => 'FONDO DE PASIVO SOCIAL DE LOS FERROCARRILES NACIONALES'
                ],
                [
                    'nombre' => 'CLINICA VICTORIANA'
                ],
                [
                    'nombre' => 'SALUD OCUPACIONAL'
                ]
            ];
            foreach ($proyectos as $proyecto) {
                Proyecto::updateOrCreate([
                    'nombre' => $proyecto['nombre']
                ],[
                    'nombre' => $proyecto['nombre']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de proyecto Th'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
