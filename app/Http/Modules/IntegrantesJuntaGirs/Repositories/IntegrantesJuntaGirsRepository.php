<?php

namespace App\Http\Modules\IntegrantesJuntaGirs\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\IntegrantesJuntaGirs\Models\IntegrantesJuntaGirs;
use Illuminate\Database\Eloquent\Model;

class IntegrantesJuntaGirsRepository extends RepositoryBase {

    protected $model;

    public function __construct(){
        $this->model = new IntegrantesJuntaGirs();
        parent::__construct($this->model);
    }

    public function guardarIntegrantes($request,$teleapoyo)
    {
        foreach ($request as $operador){
          $integrantes =  $this->model::create(['teleapoyo_id'=>$teleapoyo,'operador_id'=>$operador]);
        }

        return 'Registro Exitoso!';
    }



}
