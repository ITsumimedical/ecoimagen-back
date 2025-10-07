<?php

namespace Database\Seeders;

use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class CategoriaHistoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            $Categorias = [
                ['nombre' => 'Datos Generales'],
                ['nombre' => 'Datos de atención'],
                ['nombre' => 'anamnesis'],
                ['nombre' => 'Revisión por sistemas'],
                ['nombre' => 'Antecedentes personales'],
                ['nombre' => 'Prácticas de Crianza y cuidado'],
                ['nombre' => 'Hábitos Alimentarios'],
                ['nombre' => 'Antecedentes de Hospitalización'],
                ['nombre' => 'Antecedentes de Transfusiones'],
                ['nombre' => 'Antecedentes Farmacológicos'],
                ['nombre' => 'Esquema de vacunación'],
                ['nombre' => 'Antecedentes de Traumatismos'],
                ['nombre' => 'Antecedentes Quirúrgicos'],
                ['nombre' => 'Hábitos tóxicos'],
                ['nombre' => 'Rutinas y hábitos saludables'],
                ['nombre' => 'Antecedentes Familiares'],
                ['nombre' => 'Familiograma'],
                ['nombre' => 'Apgar familiar'],
                ['nombre' => 'Ecomapa y/o redes de apoyo'],
                ['nombre' => 'Avances compromisos de sesiones de educación'],
                ['nombre' => 'Signos vitales'],
                ['nombre' => 'Regional y por Sistemas'],
                ['nombre' => 'Valoración del desarrollo y rendimiento escolar'],
                ['nombre' => 'Valoracióndel estado nutricional '],
                ['nombre' => 'Valoración salud sexual'],
                ['nombre' => 'Valoración salud visual'],
                ['nombre' => 'Valoración salud auditiva y comunicativa'],
                ['nombre' => 'Valoración salud bucal'],
                ['nombre' => 'Valoración salud mental'],
                ['nombre' => 'Información en salud'],
                ['nombre' => 'Plan de Cuidado'],
                ['nombre' => 'Diagnóstico'],
                ['nombre' => 'Marcación '],
                ['nombre' => 'Destino'],
                ['nombre' => 'Próximo Control'],
                ['nombre' => 'Finalidad'],
            ];
            foreach ($Categorias as $Categoria) {
                CategoriaHistoria::updateOrCreate([
                    'nombre' => $Categoria['nombre'],
                ],[
                    'nombre' => $Categoria['nombre'],
                ]);
            };
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de la categoria historia'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
