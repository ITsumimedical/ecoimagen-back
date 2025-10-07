<?php

namespace Database\Seeders;

use App\Http\Modules\TipoPrestadoresTH\Models\TipoPrestadorTh;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoPrestadorThSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $tipoPrestadoresTh = [
                ['nombre' => 'Salud'],
                ['nombre' => 'Pensión'],
                ['nombre' => 'Riesgo'],
                ['nombre' => 'Caja compensación'],
            ];
            foreach ($tipoPrestadoresTh as $tipoPrestadorTh) {
                TipoPrestadorTh::updateOrCreate(
                    ['nombre' => $tipoPrestadorTh['nombre']],
                    ['nombre' => $tipoPrestadorTh['nombre'],]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al ejecutar el seeder de tipo prestador Th'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
