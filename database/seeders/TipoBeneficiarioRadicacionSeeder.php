<?php

namespace Database\Seeders;

use App\Http\Modules\Afiliados\Models\TipoBeneficiarioRadicacion;
use Illuminate\Database\Seeder;

class TipoBeneficiarioRadicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo_beneficiario = [
            [
                'nombre' => 'CÓNYUGUE DEL DOCENTE',
                'descripcion' => 'CÓNYUGUE DEL DOCENTE test',
            ],
            [
                'nombre' => 'COMPAÑERO(A) PERMANENTE DEL DOCENTE',
                'descripcion' => 'COMPAÑERO(A) PERMANENTE DEL DOCENTE test',
            ],
            [
                'nombre' => 'HIJO MENOR DE 19 AÑOS',
                'descripcion' => 'HIJO MENOR DE 19 AÑOS test',
            ],
            [
                'nombre' => 'HIJO DE 19 A 25 AÑOS',
                'descripcion' => 'HIJO DE 19 A 25 AÑOS test',
            ],
            [
                'nombre' => 'HIJO CON INCAPACIDAD PERMANENTE MAYOR DE 18 AÑOS',
                'descripcion' => 'HIJO CON INCAPACIDAD PERMANENTE MAYOR DE 18 AÑOS test',
            ],
            [
                'nombre' => 'NIETO 60 DÍAS',
                'descripcion' => 'NIETO 60 DÍAS test',
            ],
            [
                'nombre' => 'MENOR EN CUSTODIA',
                'descripcion' => 'MENOR EN CUSTODIA test',
            ],
            [
                'nombre' => 'PADRES DEL DOCENTE',
                'descripcion' => 'PADRES DEL DOCENTE test',
            ],
        ];

        foreach ($tipo_beneficiario as $beneficiario) {
            TipoBeneficiarioRadicacion::updateOrCreate([
                'nombre' => $beneficiario['nombre'],
            ],[
                'nombre' => $beneficiario['nombre'],
                'descripcion' => $beneficiario['descripcion'],
            ]);
        }
    }
}
