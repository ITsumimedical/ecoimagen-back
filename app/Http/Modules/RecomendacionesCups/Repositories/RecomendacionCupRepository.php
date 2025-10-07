<?php

namespace App\Http\Modules\RecomendacionesCups\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RecomendacionesCups\Models\RecomendacionCup;
use Illuminate\Http\Request;


class RecomendacionCupRepository extends RepositoryBase
{


    public function __construct(protected RecomendacionCup $recomendacionCupModel) {
        parent::__construct($this->recomendacionCupModel);
    }

    /**
     * cambiar el estado de una referencia
     *
     * @param  mixed $request
     * @param  mixed $id->estado_id
     * @return void
     * @author Manuela
     */
    public function cambiarEstado(Request $request, $estado_id)
    {
        // $estado = Referencia::find($estado_id);
        // $estado['estado_id'] = $request['estado_id'];

        // $estado = $estado->update();
        // return $estado;
    }


    /**
     * listar
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author jdss
     */
    public function listar($data){
        $recomendaciones = $this->recomendacionCupModel->select('id','cup_id','estado','descripcion','usuario_realiza_id');
        return $data['page'] ? $recomendaciones->paginate($data['cantidad']) : $recomendaciones->get();


    }

    public function consultarRecomendacion($datos){
        $recomendacion = $this->recomendacionCupModel->where('cup_id',$datos['id'])->first();

        if($recomendacion == null || isset($recomendacion)){
            return  false;
        }else{
            return  true;
        }
    }

}

