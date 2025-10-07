<?php

namespace Database\Seeders;

use App\Http\Modules\LogConsolidados\Models\TipoLogConsolidado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoConsolidadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoLogConsolidado::insert([
            ['nombre' => 'Consolidado de formulas'],
            ['nombre' => 'Consolidado de historias'],
        ]);
    }
}
