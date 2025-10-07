<?php

namespace Database\Seeders;

use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoAfiliadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Afiliados = [
                [
                    'nombre'                 => 'BENEFICIARIO',
                    'descripcion'            =>'Afiliado incluido en el grupo familiar del cotizante como: Hijo (propio, del conyugue, adoptado) - Conyugue -Padre o Madre',
                    'clasificacion_afiliado' => 'BENEFICIARIO',
                    'estado'                 => 1,
                    'user_id'                => 1
                ],
                [
                    'nombre'                 => 'COTIZANTE',
                    'descripcion'            =>'Afiliado con aporte a salud activo como empleado (con un contrato laboral)',
                    'clasificacion_afiliado' => 'COTIZANTE',
                    'estado'                 => 1,
                    'user_id'                   => 1
                ],
                [
                    'nombre'                 => 'COTIZANTE DEPENDIENTE',
                    'descripcion'            =>'Afiliado con UPC adicional (pago adicional por el servicio)',
                    'clasificacion_afiliado' => 'BENEFICIARIO',
                    'estado'                 => 1,
                    'user_id'                => 1
                ],
                [
                    'nombre'                 => 'COTIZANTE FALLECIDO',
                    'descripcion'            =>'Afiliado con aporte a salud repotado como Fallecido',
                    'clasificacion_afiliado' => 'COTIZANTE',
                    'estado'                 => 1,
                    'user_id'                => 1
                ],
                [
                    'nombre'                  => 'COTIZANTE PENSIONADO',
                    'descripcion'             =>'Afiliado con aporte a salud no activo como empleado (con una pensión)',
                    'clasificacion_afiliado'  => 'COTIZANTE',
                    'estado'                 => 1,
                    'user_id'                 => 1
                ],
                [
                    'nombre'                  => 'SUSTITUTO PENSIONAL',
                    'descripcion'             =>'Afiliado con aporte a salud pero como beneficiario del pensionado Fallecido, no activo como empleado (con una pensión)',
                    'clasificacion_afiliado'  => 'BENEFICIARIO',
                    'estado'                 => 1,
                    'user_id'                 => 1
                ],
            ];
            foreach ($Afiliados as $Afiliado) {
                TipoAfiliado::updateOrCreate([
                    'nombre' => $Afiliado['nombre']
                ],[
                    'nombre'         => $Afiliado['nombre'],
                    'descripcion'    => $Afiliado['descripcion'],
                    'clasificacion_afiliado'  => $Afiliado['clasificacion_afiliado'],
                    'estado'         => $Afiliado['estado'],
                    'user_id'        => $Afiliado['user_id'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Erro al ejecutar el seeder de Tipo Afiliado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
