<?php

namespace Database\Seeders;

use App\Http\Modules\SolicitudBodegas\Models\TipoNovedadSolicitud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoNovedadSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $novedades = [
            [
                'nombre' => 'Averia',
                'estado_id' => 1,
            ],
            [
                'nombre' => 'Sobrante',
                'estado_id' => 1,
            ],
            [
                'nombre' => 'Faltante',
                'estado_id' => 1,
            ],
            [
                'nombre' => 'Producto No Conforme',
                'estado_id' => 1,
            ],
            [
                'nombre' => 'Producto No Solicitado',
                'estado_id' => 1,
            ],
            [
                'nombre' => 'Tarifa No Autorizada',
                'estado_id' => 1,
            ]
        ];

        foreach ($novedades as $novedad){
            TipoNovedadSolicitud::updateOrCreate([
                'nombre' => $novedad['nombre']
            ],[
                'estado_id' => $novedad['estado_id'],
            ]);
        }

    }
}
