<?php

namespace Database\Seeders;

use App\Http\Modules\TipoFamilia\Models\TipoFamilia;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TipoFamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $tipoFamilias = [
                [
                    'nombre' => 'Clasificacion CUPS FIAS',
                    'descripcion' => 'Clasificacion CUPS para el informe FIAS',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Contabilidad',
                    'descripcion' => 'Clasificacion CUPS para informes de Contabilidad',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Gestion del Riesgo',
                    'descripcion' => 'Clasificacion CUPS para informes de Gestion del Riesgo',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Capitulos',
                    'descripcion' => 'Clasificacion CUPS por Capitulos',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Auditoria',
                    'descripcion' => 'Clasificacion CUPS para Auditoria',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Financiera',
                    'descripcion' => 'Clasificacion CUPS para Informe Financiero',
                    'activo' => true
                ],
                [
                    'nombre' => 'Clasificacion CUPS Alto Costo',
                    'descripcion' => 'Clasificacion CUPS Alto Costo Financiero',
                    'activo' => true
                ],
            ];
            foreach ($tipoFamilias as $tipoFamilia){
                TipoFamilia::updateOrCreate(
                    ['nombre' => $tipoFamilia['nombre']],
                    [
                    'nombre' => $tipoFamilia['nombre'],
                    'descripcion' => $tipoFamilia['descripcion'],
                    'activo' => $tipoFamilia['activo']
                    ]);
                }

        } catch (\Throwable $th) {
            //throw $th;
        }



    }
}
