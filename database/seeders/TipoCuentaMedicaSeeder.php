<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Models\TiposCuentasMedica;

class TipoCuentaMedicaSeeder extends Seeder
{
    public function run()
    {
        try {
            $tipos = [
                ['nombre' => 'Facturacion'],
                ['nombre' => 'Tarifas'],
                ['nombre' => 'Soportes'],
                ['nombre' => 'Autorizaciones'],
                ['nombre' => 'Cobertura'],
                ['nombre' => 'Pertinencia'],
                ['nombre' => 'Devoluciones'],
                ['nombre' => 'Respuestas a glosas y devoluciones'],
                ['nombre' => 'Servicio'],



            ];
            foreach ($tipos as $tipo){
                TiposCuentasMedica::updateOrCreate([
                    'nombre'    => $tipo['nombre']
                ],[
                    'nombre'    => $tipo['nombre'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo '
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
