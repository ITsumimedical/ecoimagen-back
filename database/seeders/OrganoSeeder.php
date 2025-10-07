<?php

namespace Database\Seeders;

use App\Http\Modules\Oncologia\Organos\Models\Organo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class OrganoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organos = [
            [
                "nombre" => 'CEREBRO',
                "estado" => 1
            ],
            [
                "nombre" => 'CORAZON',
                "estado" => 1
            ],
            [
                "nombre" => 'PULMONES',
                "estado" => 1
            ],
            [
                "nombre" => 'INTESTINO GRUESO',
                "estado" => 1
            ],
            [
                "nombre" => 'HIGADO',
                "estado" => 1
            ],
            [
                "nombre" => 'ESTOMAGO',
                "estado" => 1
            ],
            [
                "nombre" => 'PANCREAS',
                "estado" => 1
            ],
            [
                "nombre" => 'RIÑONES',
                "estado" => 1
            ],
            [
                "nombre" => 'INTESTINO DELGADO',
                "estado" => 1
            ],
            [
                "nombre" => 'APARATO REPRODUCTOR MASCULINO',
                "estado" => 1
            ],
            [
                "nombre" => 'APARATO REPRODUCTOR FEMENINO',
                "estado" => 1
            ],
            [
                "nombre" => 'BAZO',
                "estado" => 1
            ],
        ];

        foreach ($organos as $organo) {
            Organo::updateOrCreate(
                ['nombre' => $organo['nombre']],
                [
                    'nombre' => $organo['nombre'],
                    'estado' => $organo['estado']
                ]
            );
        }
    }
}
