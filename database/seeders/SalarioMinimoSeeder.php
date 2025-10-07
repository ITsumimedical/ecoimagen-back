<?php

namespace Database\Seeders;

use App\Http\Modules\SalarioMinimo\Models\SalarioMinimo;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class SalarioMinimoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $salarios = [
                [
                    'anio'  => '2019',
                    'valor' => 6
                ],
                [
                    'anio'  => '2020',
                    'valor' => 6
                ],
                [
                    'anio'  => '2021',
                    'valor' => 3.5
                ],
                [
                    'anio'  => '2022',
                    'valor' => 10
                ],
                [
                    'anio'  => '2023',
                    'valor' => 16
                ],
            ];
            foreach ($salarios as $salario) {
                SalarioMinimo::updateOrCreate([
                    'anio' => $salario['anio']
                ],[
                    'anio' => $salario['anio'],
                    'valor' => $salario['valor'],
                ]);
            }

        }catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => 'Error al ejecutar el seeder de salario minimo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
