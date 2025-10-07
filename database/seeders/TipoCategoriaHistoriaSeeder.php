<?php

namespace Database\Seeders;

use App\Http\Modules\CategoriaHistorias\Models\TipoCategoriaHistoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoCategoriaHistoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre'=> 'formulario'],
            ['nombre' => 'promedio'],
            ['nombre' => 'calificacion'],
            ['nombre' => 'Plantilla']
        ];
        foreach ($tipos as $tipo) {
            TipoCategoriaHistoria::updateOrCreate(['nombre' => $tipo['nombre']]);
        }
    }
}
