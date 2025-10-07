<?php

namespace Database\Seeders;

use App\Http\Modules\TipoCitas\Models\TipoCita;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $citas = [
                [
                    'nombre'    => 'Individual',
                    'multiples' => false,
                ],
                [
                    'nombre'    => 'Grupal',
                    'multiples' => true,
                ],
            ];
            foreach ($citas as $cita) {
                TipoCita::updateOrCreate([
                    'nombre'    => $cita['nombre']
                ],[
                    'nombre'    => $cita['nombre'],
                    'multiples' => $cita['multiples'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo cita'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
