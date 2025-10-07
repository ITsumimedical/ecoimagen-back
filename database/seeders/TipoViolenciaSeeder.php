<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Modules\TipoViolencia\Models\TipoViolencia;
use Illuminate\Support\Facades\Log;

class TipoViolenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $tiposViolencia = [
                [
                    'nombre' => 'Persona con condición de discapacidad',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Víctima de desplazamiento forzado',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Víctima de conflicto armado',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Víctima de violencia física',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Víctima de violencia sexual',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Otros tipos de violencia',
                    'activo' => true,
                ],
            ];

            foreach ($tiposViolencia as $tipoViolencia) {
                TipoViolencia::updateOrCreate([
                    'nombre' => $tipoViolencia['nombre'],
                ], [
                    'nombre' => $tipoViolencia['nombre'],
                    'activo' => $tipoViolencia['activo'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error en TipoViolenciaSeeder: ' . $th->getMessage());
        }
    }
}
