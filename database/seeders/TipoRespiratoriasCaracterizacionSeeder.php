<?php

namespace Database\Seeders;

use App\Http\Modules\TipoRespiratoriasCaracterizacion\Models\TipoRespiratoriasCaracterizacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TipoRespiratoriasCaracterizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $tipoRespiratorias = [
                [
                    'nombre' => 'Asma',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Epoc',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Bronquitis Crónica',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Síndrome de Apnea e Hipoapnea del Sueño (SAHOS)',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Otros',
                    'activo' => true,
                ],
                [
                    'nombre' => 'Ninguno',
                    'activo' => true,
                ],
            ];

            foreach ($tipoRespiratorias as $item) {
                TipoRespiratoriasCaracterizacion::updateOrCreate([
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
