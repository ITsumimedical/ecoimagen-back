<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Modules\TiposCuentasBancarias\Models\TipoCuentaBancaria;

class TipoCuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $tiposCuentasBancarias = [
                [
                    'nombre' => 'Ahorros'
                ],
                [
                    'nombre' => 'Corriente'
                ],
                [
                    'nombre' => 'Nequi'
                ],
            ];
            foreach ($tiposCuentasBancarias as $tipo) {
                TipoCuentaBancaria::updateOrCreate([
                    'nombre' => $tipo['nombre']
                ],[
                    'nombre' => $tipo['nombre']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipos de cuentas bancarias'
            ]);
        }
    }
}
