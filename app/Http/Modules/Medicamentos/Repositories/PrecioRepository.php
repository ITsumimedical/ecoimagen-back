<?php

namespace App\Http\Modules\Medicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Medicamentos\Models\PrecioProveedorMedicamento;

class PrecioRepository extends RepositoryBase
{

    public function __construct(protected PrecioProveedorMedicamento $medicamentoModel) {
        parent::__construct($this->medicamentoModel);
    }

    public function crearActualizar(array $data){
        $camposUnicos = [
            'medicamento_id' => $data['medicamento_id'],
            'rep_id' => $data['rep_id']
        ];
        $valoresActualizar = collect($data)->except(array_keys($camposUnicos))->toArray();
        return $this->medicamentoModel::updateOrCreate($camposUnicos, $valoresActualizar);
    }





}
