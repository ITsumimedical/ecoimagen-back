<?php

namespace Database\Seeders;

use App\Http\Modules\TipoCancerCaracterizacion\Models\TipoCancerCaracterizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TipoCancerCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $caracterizaciones = [
                [
                    'nombre' => 'Mama',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Prostata',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Cervicouterino',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Piel',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Pulmón',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Gastrointestinal',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Otro',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Ninguno',
                    'activo' => true,
                ],

            ];

            foreach ($caracterizaciones as $caracterizacion) {
                TipoCancerCaracterizacion::updateOrCreate([
                    'nombre' => $caracterizacion['nombre']
                ], [
                    'nombre' => $caracterizacion['nombre'],
                    'activo' => $caracterizacion['activo']
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error al insertar TipoCancerCaracterizacionSeeder: ' . $th->getMessage());
        }
    }
}
