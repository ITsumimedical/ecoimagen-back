<?php

namespace App\Http\Modules\PrecioEntidadMedicamento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PrecioEntidadMedicamento\Models\PrecioEntidadMedicamento;

class PrecioEntidadMedicamentoRepository extends RepositoryBase
{

    public function __construct(protected PrecioEntidadMedicamento $medicamentoModel) {
        parent::__construct($this->medicamentoModel);
    }

    public function listarPrecio($data){

        return $this->medicamentoModel::select('subtotal','total','iva','precio_maximo','entidad_id','medicamento_id','precio_entidad_medicamentos.id','entidades.nombre')
        ->join('entidades','entidades.id','precio_entidad_medicamentos.entidad_id')->where('medicamento_id',$data['medicamento_id'])
        ->get();
    }





}
