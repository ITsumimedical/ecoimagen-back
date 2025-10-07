<?php

namespace Database\Seeders;

use App\Http\Modules\RutaPromocionCaracterizacion\Models\RutaPromocionCaracterizacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RutaPromocionCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $rutaPromocionCaracterizacions = [
              ['nombre' => 'Atención en Salud para la Primera Infancia', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la Infancia', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la Adolescencia', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la Juventud', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la Adultez', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la Vejez', 'activo' => true],	  
              ['nombre' => 'Atención en Salud para la valoración, promoción y apoyo de la lactancia materna', 'activo' => true],	  
              ['nombre' => 'Atención a la Salud Maternoperinatal', 'activo' => true],	  
              ['nombre' => 'Ninguna', 'activo' => true],	  
            ];

            foreach ($rutaPromocionCaracterizacions as $item) {
                RutaPromocionCaracterizacion::updateOrCreate([
                    'nombre' => $item['nombre']
                ],[
                    'nombre' => $item['nombre'],
                    'activo' => $item['activo']
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
