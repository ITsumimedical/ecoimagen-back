<?php

namespace Database\Seeders;

use App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Models\TipoInmunodeficienciasCaracterizacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TipoInmunodeficienciasCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $tipoInmunodeficiencias = [
                ['nombre' => 'VIH', 'activo' => true],
                ['nombre' => 'Enfermedades Autoinmunes', 'activo' => true],
                ['nombre' => 'Tratamientos con Biológicos', 'activo' => true],
                ['nombre' => 'Quimioterapia', 'activo' => true],
                ['nombre' => 'Otros', 'activo' => true],
                ['nombre' => 'Ninguna', 'activo' => true],
            ];

            foreach ($tipoInmunodeficiencias as $item) {
                TipoInmunodeficienciasCaracterizacion::updateOrCreate([
                    'nombre' => $item['nombre'] 
                ],[
                    'nombre' => $item['nombre'],
                    'activo' => $item['activo']
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error al insertar el tipo de categoria ' . $th->getMessage());
        }
    }
}
