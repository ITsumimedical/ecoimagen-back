<?php

namespace App\Http\Modules\Turnos\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Carbon\Carbon;

class TurnoService
{
    /**
     * Sigue la secuencia del turno o lo reinicia
     * @param $ultimo_turno
     * @return int
     * @author Arles Garcia
     */
    public function generarCodigo($ultimo_turno){

        $hoy = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $fecha_turno = Carbon::parse($ultimo_turno->created_at->format('Y-m-d'));

        if($hoy->diffInDays($fecha_turno) < 1){
            return $ultimo_turno->codigo + 1;
        }else{
            return 1;
        }
    }

    /**
     * Prepara la data
     * @param $data
     * @param $codigo
     * @return $data
     * @author Arles Garcia
     */
    public function prepararData($data, $codigo){
        $afiliado = Afiliado::where('numero_documento',$data['numero_documento'])->first();
        if($afiliado){
            if($data['area_clinica_id'] == 2){
                $data['estado_id'] = 32;
            }else{
                $data['estado_id'] = 27;
            }
        }else{
            $data['estado_id'] = 27;
        }
        $data['codigo'] = $codigo;
        return $data;
    }
}
