<?php

namespace App\Http\Modules\Homologo\Services;

use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Homologo\Models\Homologo;
use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class HomologoService {

    public function cagar($file) {

        $excel = (new FastExcel)->import($file->getRealPath());
        $result = [
            'Error' => [],
            'resultado' => true,
        ];
        $i = 2;
        foreach ($excel as $row) {// //

            if(strlen($row['codigo']) > 7){
                $result['resultado'] = false;
                $result['Error'] = 'El campo codigo tiene mas de 6 digitos en la línea '.$i;
                return $result;
            }

            if ($row['valor'] == "") {
                $result['resultado'] = false;
                $result['Error'] = 'El campo Valor esta vacio en la línea '.$i;
                return $result;
            }
            if (empty($row['descripcion'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo descripcion esta vacio en la línea '.$i;
                return $result;
            }

            if(empty($row['codigo'])) {
                    $result['resultado'] = false;
                    $result['Error'] =  'El campo codigo esta vacio o tiene un 0 en la línea '.$i;
                    return $result;
                }

            if (empty($row['tipomanual_id'])) {
                $result['resultado'] = false;
                $result['Error'] =  'El campo tipo manual esta vacio en la línea '.$i;
                return $result;
            }

            if (empty($row['anio'])) {
                $result['resultado'] = false;
                $result['Error'] =  'El campo anio esta vacio en la línea '.$i;
                return $result;
            }

            $valueAnio = Homologo::where('anio',$row['anio'])->first();

            if($valueAnio){
                $result['resultado'] = false;
                $result['Error'] =  'El año ya se encuentra registrado en el sistema, Error en la línea '.$i;
                return $result;
            }

            $i ++;
        }
        if($result['resultado']){            
            foreach ($excel as $key) {
                $homologo = new Homologo();
                $homologo->tipo_manual_id = $key['tipomanual_id'];
                $homologo->cup_codigo = $key['codigo'];
                $homologo->descripcion = $key['descripcion'];
                $homologo->valor = intval($key['valor']);
                $homologo->estado = true;
                $homologo->anio = $key['anio'];
                $homologo->save();

            }
        }

        return $result;

    }

}
