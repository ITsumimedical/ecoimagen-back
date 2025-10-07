<?php

namespace Database\Seeders;

use App\Http\Modules\TipoTurnos\Models\TipoTurno;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoTurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $turnos = [
                [
                'nombre'    => 'Preferencial',
                'prefijo'   => 'PRE',
                'color'     => 'F0F4C3',
                'imagen'    => null,
                'prioridad' => 1
                ],
                [
                'nombre'    => 'Menor de 5 años',
                'prefijo'   => 'MEN',
                'color'     => 'FFAB91',
                'imagen'    => null,
                'prioridad' => 2
                ],
                [
                'nombre'    => 'Adulto Mayor',
                'prefijo'   => 'ADM',
                'color'     => 'BCAAA4',
                'imagen'    => null,
                'prioridad' => 3
                ],
                [
                'nombre'    => 'Gestante',
                'prefijo'   => 'GES',
                'color'     => 'D1C4E9',
                'imagen'    => null,
                'prioridad' => 1
                ],
            ];
            foreach ($turnos as $turno){
                TipoTurno::updateOrCreate([
                    'nombre' => $turno['nombre']
                ],[
                    'nombre' => $turno['nombre'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo turno seeder'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
