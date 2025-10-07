<?php

namespace Database\Seeders;

use App\Http\Modules\Eventos\Analisis\Models\MotivoAnulacionEvento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class MotivoAnulacionEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $motivos = [
                ['nombre' => 'Duplicidad en el reporte'],
                ['nombre' => 'No corresponde a un suceso de seguridad del paciente'],
                ['nombre' => 'No hay suficiente información para gestionar el suceso'],
                ['nombre' => 'Suceso de seguridad del paciente que no amerita análisis'],
                ['nombre' => 'Error de medicación - Tipo A: Circunstancias o incidentes con capacidad de causar error'],
                ['nombre' => 'Error de medicación - Tipo B: El error se produjo, pero no alcanzó al paciente'],
                ['nombre' => 'Otros'],
            ];

            foreach ($motivos as $motivo) {
                MotivoAnulacionEvento::updateOrCreate([
                    'nombre' => $motivo['nombre']
                ],[
                    'nombre' => $motivo['nombre']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de motivo anulacion'
            ]);
        }
    }
}
