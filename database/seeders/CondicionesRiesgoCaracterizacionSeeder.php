<?php

namespace Database\Seeders;

use App\Http\Modules\CondicionesRiesgoCaracterizacion\Models\CondicionesRiesgoCaracterizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CondicionesRiesgoCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $condiciones = [
                ['nombre' => 'Alteraciones Nutricionales','activo' => true],
                ['nombre' => 'Enfermedades Infecciosas','activo' => true],
                ['nombre' => 'Enfermedades Zonóticas','activo' => true],
                ['nombre' => 'Enfermedades Huerfanas','activo' => true],
                ['nombre' => 'Trastornos Visuales','activo' => true],
                ['nombre' => 'Accidentes y Enfermedades Laborales','activo' => true],
                ['nombre' => 'Trastornos Degenerativos, Neuropatías y Enfermedades Autoinmunes','activo' => true],
                ['nombre' => 'Trastornos de Salud Bucal','activo' => true],
                ['nombre' => 'Recién Nacidos Pretérminos','activo' => true],
                ['nombre' => 'Embarazo','activo' => true],
                ['nombre' => 'Adultos Mayores (>60 Años)','activo' => true],
                ['nombre' => 'Niños y Adolescentes','activo' => true],
                ['nombre' => 'Ansiedad','activo' => true],
                ['nombre' => 'Depresión','activo' => true],
                ['nombre' => 'Esquizofrenia','activo' => true],
                ['nombre' => 'Otros Problemas de Salud Mental','activo' => true],
                ['nombre' => 'Ninguna','activo' => true],
            ];

            foreach ($condiciones as $item) {
                CondicionesRiesgoCaracterizacion::updateOrCreate([
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
