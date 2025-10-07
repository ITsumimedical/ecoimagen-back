<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Modules\Bodegas\Models\Bodega;

class BodegaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bodegas = [
            [
                'nombre' => 'BODEGA CENTRAL SUMIMEDICAL',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO CENTRO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO BELLO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO ENVIGADO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO ITAGUI',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO RIONEGRO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO APARTADO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO TURBO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO CAUCASIA',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO PUERTO BERRIO',
                'estado_id' => 1
            ],
            [
                'nombre' => 'SERVICIO FARMACEUTICO COPACABANA',
                'estado_id' => 1
            ],
        ];
        foreach ($bodegas as $bodega) {
            Bodega::updateOrCreate([
                'nombre' => $bodega['nombre'],
            ],[
                'nombre' => $bodega['nombre'],
                'estado_id' => $bodega['estado_id']
            ]);
        }
    }
}
