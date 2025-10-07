<?php

namespace Database\Seeders;

use App\Http\Modules\TipoSolicitudBodegas\Models\TipoSolicitudBodega;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSolicitudBodegasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoSolicitudBodega::updateOrCreate(
            ['nombre' => 'Solicitud Compras'],
            ['estado_id' => 1]
        );
        TipoSolicitudBodega::updateOrCreate(
            ['nombre' => 'Traslado'],
            ['estado_id' => 1]
        );
        TipoSolicitudBodega::updateOrCreate(
            ['nombre' => 'Ajuste Entrada'],
            ['estado_id' => 1]
        );
        TipoSolicitudBodega::updateOrCreate(
            ['nombre' => 'Ajuste Salida'],
            ['estado_id' => 1]
        );
    }
}
