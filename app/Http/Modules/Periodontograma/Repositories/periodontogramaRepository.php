<?php

namespace App\Http\Modules\Periodontograma\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Periodontograma\Model\periodontograma;

class periodontogramaRepository extends RepositoryBase
{

    public function __construct(protected periodontograma $periodontograma)
    {
        parent::__construct($this->periodontograma);
    }

    public function periodontogramaListar($consulta_id)
    {
        $periodontograma = $this->periodontograma
            ->where('periodontogramas.consulta_id', $consulta_id)
            ->get();

        return $periodontograma;
    }

    public function actualizarPeriodontograma($id, $data)
    {
        $periodontograma = $this->periodontograma->findOrFail($id);
        $periodontograma->fill($data);
        $periodontograma->save();
        return $periodontograma;
    }

    public function crearOdontograma ($data){
        foreach ($data['diente'] as $diente){
            $this->periodontograma->create([
                'consulta_id'=>$data['consulta_id'],
                'diente' => $diente,
                'diente_tipo' =>$data['diente_tipo'],
                'distal' =>$data['distal'],
                'mesial' =>$data['mesial'],
                'oclusal'=>$data['oclusal'],
                'palatino'=>$data['palatino'],
                'vestibular'=>$data['vestibular'],
                'requiere_endodoncia'=>$data['requiereEndodoncia'],
                'requiere_sellante'=>$data['requiereSellante'],
                'endodocia_presente'=>$data['endodociaPresente']
            ]);
        }
        return true;

    }

    public function eliminarPeriodontograma($id)
    {
        $perio = $this->periodontograma->findOrFail($id);
        $perio->delete();
    }
}
