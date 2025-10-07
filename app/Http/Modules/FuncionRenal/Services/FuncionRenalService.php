<?php

namespace App\Http\Modules\FuncionRenal\Services;

use App\Http\Modules\FuncionRenal\Model\FuncionRenal;

class FuncionRenalService
{

    public function guardarResultadosFr($data)
    {
        FuncionRenal::create([
            'resultado_cockcroft_gault' => $data['resultado_cockcroft_gault'],
            'resultado_ckd_epi' => $data['resultado_ckd_epi'],
            'valor_creatinina' => $data['valor_creatinina'],
            'consulta_id' => $data['consulta_id'],
        ]);

        return 'Datos guardados correctamente';
    }
}
