<?php

namespace Database\Seeders;

use App\Http\Modules\Citas\Models\Modalidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modalidad::updateOrCreate([
            'nombre' => 'presencial',
            'estado_id' => '1'
        ]);

        Modalidad::updateOrCreate([
            'nombre' => 'Virtual',
            'estado_id' => '1'
        ]);
    }
}
