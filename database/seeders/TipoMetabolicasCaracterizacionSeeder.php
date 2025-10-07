<?php

namespace Database\Seeders;

use App\Http\Modules\TipoMetabolicasCaracterizacion\Models\TipoMetabolicasCaracterizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TipoMetabolicasCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $tipoMetabolicas = [
                [
                    'nombre' => 'Obesidad',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Enfermedades de Tiroides',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Diabetes Mellitus',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Dislipidemias',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Ninguno',
                    'activo' => true,
                ],
            ];

            foreach ($tipoMetabolicas as $item) {
                TipoMetabolicasCaracterizacion::updateOrCreate([
                    'nombre' => $item['nombre']
                ], [
                    'nombre' => $item['nombre'],
                    'activo' => $item['activo']
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error al insertar el tipo de categoria ' . $th->getMessage());
        }
    }
}
