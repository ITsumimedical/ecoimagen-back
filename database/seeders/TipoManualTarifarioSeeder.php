<?php

namespace Database\Seeders;

use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoManualTarifarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $tipoManualTarifarios = [
                [
                    'nombre' => 'SOAT',
                    'descripcion' => 'Manual SOAT',
                ],
                [
                    'nombre' => 'IS2000',
                    'descripcion' => 'Manual iss2000',
                ],
                [
                    'nombre' => 'IS2001',
                    'descripcion' => 'Manual iss2001',
                ],
                [
                    'nombre' => 'PGP',
                    'descripcion' => 'Modalidas de contrato PGP',
                ],
                [
                    'nombre' => 'Capitado',
                    'descripcion' => 'Modalidad de contrato capitado',
                ],
                [
                    'nombre' => 'Evento',
                    'descripcion' => 'Modalidad de contrato evento',
                ],
            ];
            foreach ($tipoManualTarifarios as $tipoManualTarifario){
                ManualTarifario::updateOrCreate([
                    'nombre' => $tipoManualTarifario['nombre']
                ],[
                    'nombre' => $tipoManualTarifario['nombre'],
                    'descripcion' => $tipoManualTarifario['descripcion']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo manual tarifario'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
