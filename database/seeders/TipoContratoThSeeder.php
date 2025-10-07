<?php

namespace Database\Seeders;

use App\Http\Modules\TiposContratosTH\Models\TipoContratoTh;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class TipoContratoThSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $contratos = [
                ['nombre'  =>  'Término fijo','descripcion'       => 'Se caracteriza por tener una fecha de inicio y de terminación que no puede superar 3 años, es fundamental que sea por escrito. Puede ser prorrogado indefinidamente cuando su vigencia sea superior a un (1) año, o cuando siendo inferior, se haya prorrogado hasta por tres (3) veces.'],
                ['nombre'  =>  'Término indefinido','descripcion' => 'Este contrato indica la fecha de inicio del trabajador, pero no tiene fecha de finalización determinada, aquí el empleador se compromete a pagar prestaciones sociales, prima de servicio, vacaciones remuneradas e impuestos que correspondan. El contrato se puede finalizar por acuerdo de las partes o por decisión de una sola.'],
                ['nombre'  =>  'Obra labor','descripcion'         => 'En este caso, la persona es contratada para realizar una actividad específica, no se sabe con exactitud la fecha de terminación del contrato y podrá finalizar una vez el trabajador culmine la labor para la cual se contrató.'],
                ['nombre'  =>  'Aprendizaje','descripcion'        => 'Este tipo de contrato se realiza entre el empleador, una institución educativa y un aprendiz. El objetivo de este, es que el aspirante obtenga formación práctica sobre su profesión y no puede ser mayor a dos años.'],
                ['nombre'  =>  'Convenio','descripcion'           => 'es un arreglo bilateral que establece una relación jurídica entre las partes involucradas.'],
            ];
            foreach ($contratos as $contrato) {
                TipoContratoTh::updateOrCreate([
                    'nombre'      => $contrato['nombre']
                ],[
                    'nombre'      => $contrato['nombre'],
                    'descripcion' => $contrato['descripcion'],
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo contrato th'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
