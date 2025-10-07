<?php

namespace App\Http\Modules\FuncionRenal\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FuncionRenal\Model\FuncionRenal;

class FuncionRenalRepository extends RepositoryBase
{
    public function __construct(protected FuncionRenal $funcionRenalModel)
    {
        parent::__construct($this->funcionRenalModel);
    }

    public function listarFuncionRenal($request)
    {
        $afiliadoId = $request['afiliado'];

        $resultados = $this->funcionRenalModel::whereHas('consulta', function ($q) use ($afiliadoId) {
            $q->where('afiliado_id', $afiliadoId);
        })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $data = [
            'COCKCROFT GAULT' => ["laboratorio" => 'COCKCROFT GAULT'],
            'CKD EPI'         => ["laboratorio" => 'CKD EPI']
        ];

        $i = 1;
        foreach ($resultados as $r) {

            $data['COCKCROFT GAULT']["resultado{$i}"] = $r->resultado_cockcroft_gault;
            $data['CKD EPI']["resultado{$i}"] = $r->resultado_ckd_epi;
            $i++;
        }
        return $data;
    }
}
