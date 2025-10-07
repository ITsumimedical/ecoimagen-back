<?php

namespace Database\Seeders;

use App\Http\Modules\TipoRCVCaracterizacion\Models\TipoRCVCaracterizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TipoRCVCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $tipoRCVs = [
                ['nombre' => 'Cardiopatías Isquémicas', 'activo' => true],
                ['nombre' => 'Hipertensión Arterial', 'activo' => true],
                ['nombre' => 'Enfermedad Renal Crónica', 'activo' => true],
                ['nombre' => 'Enfermedad Cerebrovascular', 'activo' => true],
                ['nombre' => 'Enfermedad Arterial Oclusiva Crónica', 'activo' => true],
                ['nombre' => 'Ninguno', 'activo' => true],

            ];

            foreach($tipoRCVs as $tipo){
                TipoRCVCaracterizacion::updateOrCreate([
                    'nombre' => $tipo['nombre']
                ],[
                    'nombre' => $tipo['nombre'],
                    'activo' => $tipo['activo']
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
