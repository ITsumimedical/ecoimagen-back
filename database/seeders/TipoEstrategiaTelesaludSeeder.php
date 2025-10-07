<?php

namespace Database\Seeders;

use App\Http\Modules\Telesalud\Models\TipoEstrategiaTelesalud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEstrategiaTelesaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_estrategia_telesalud = [
            [
                "nombre" => "Junta Profesionales",
                "activo" => true
            ],
            [
                "nombre" => "Junta Aseguramiento",
                "activo" => false
            ],
            [
                "nombre" => "Teleapoyo",
                "activo" => true
            ],
            [
                "nombre" => "Teleorientación",
                "activo" => true
            ],
            [
                "nombre" => "Teleexperticia Asincrónica",
                "activo" => true
            ],
            [
                "nombre" => "Teleexperticia Sincrónica",
                "activo" => false
            ],
        ];

        foreach ($tipo_estrategia_telesalud as $item) {
            TipoEstrategiaTelesalud::updateOrCreate([
                'nombre' => $item['nombre']
            ], [
                'activo' => $item['activo']
            ]);
        }
    }
}
