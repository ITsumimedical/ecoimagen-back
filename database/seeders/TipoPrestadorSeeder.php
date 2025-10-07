<?php

namespace Database\Seeders;

use App\Http\Modules\TipoPrestador\Models\TipoPrestador;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoPrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $tipoPrestadores = [
                ['nombre' => 'Medicamentos'],
                ['nombre' => 'Servicios'],
            ];
            foreach ($tipoPrestadores as $tipoPrestador){
                TipoPrestador::updateOrCreate([
                    'nombre' => $tipoPrestador['nombre']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo prestador'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
