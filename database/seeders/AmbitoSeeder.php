<?php

namespace Database\Seeders;

use App\Http\Modules\Ambitos\Models\Ambito;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class AmbitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $ambitos = [
                [
                    'nombre' => 'ambulatorio',
                ],

                [
                    'nombre' => 'hospilatario',
                ],

                [
                    'nombre' => 'ambulatorio/hospilatario',
                ],
            ];
            foreach ($ambitos as $ambito) {
                Ambito::updateOrCreate([
                    'nombre' => $ambito['nombre'],
                ],[
                    'nombre' => $ambito['nombre'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de ambito seeder'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
