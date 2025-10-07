<?php

namespace Database\Seeders;

use App\Http\Modules\PracticaIntervieneSalud\Models\PracticaIntervieneSalud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PracticaIntervieneSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $practicas =[
                
                    [
                        'nombre' => 'Red de Apoyo Familiar',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Red Social y Comunitaria',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Fuma',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Consumo de SPA',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Alcohol',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Actividad Física',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Consumo de Frutas y Verduras',
                        'activo' => true,
                    ],
                    [
                        'nombre' => 'Ninguna',
                        'activo' => true,
                    ],
                


                ];

            foreach ($practicas as $practica) {
                PracticaIntervieneSalud::updateOrCreate([
                    'nombre' => $practica['nombre']
                ],[
                    'nombre' => $practica['nombre'],
                    'activo' => $practica['activo'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error al ejecutar el seeder de practica interviene salud' . $th->getMessage());
        }
    }
}
