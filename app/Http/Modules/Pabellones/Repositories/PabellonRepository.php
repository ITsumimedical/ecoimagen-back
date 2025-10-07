<?php

namespace App\Http\Modules\Pabellones\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Pabellones\Models\Pabellon;

class PabellonRepository extends RepositoryBase {

    public function __construct(protected Pabellon $pabellonModel)
    {
        parent::__construct($this->pabellonModel);
    }

    public function listarPabellon($data){
        return $this->pabellonModel::select('nombre','estado','id')
        ->when(!empty($data['estado']), function($query) use ($data) {
            return $query->where('estado', $data['estado']);
        })
        ->get();
    }

    public function actualizarPabellon(int $id,$data){
        return $this->pabellonModel::where('id',$id)->update($data);
    }

    public function listarConCama(){
        return $this->pabellonModel::with('camas')
        ->whereHas('camas', function ($q){
            $q->where('estado_id',1);
        })
        ->get();
    }

}
