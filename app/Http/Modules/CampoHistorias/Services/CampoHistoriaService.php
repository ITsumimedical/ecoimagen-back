<?php

namespace App\Http\Modules\CampoHistorias\Services;

use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\CampoHistorias\Models\CampoHistoriaOpcion;
use App\Http\Modules\CampoHistorias\Repositories\CampoHistoriaRepository;

class CampoHistoriaService{

    protected $campoHistoriaRepository;

    public function __construct(CampoHistoriaRepository $campoHistoriaRepository) {
        $this->campoHistoriaRepository = $campoHistoriaRepository;
    }


    public function guardarCampo($request)
    {
//       $existeCategoria = CampoHistoria::select('id')
//       ->where('categoria_historia_id', $request['categoria_historia_id'])
//       ->where('orden',$request['orden'])
//       ->first();
//        if ($existeCategoria == null){
            $nuevo = new CampoHistoria($request);
            $categoria = $this->campoHistoriaRepository->guardar($nuevo);
            $campo = CampoHistoria::find($categoria["id"]);
//        }else{
//            $categoria = 'false';
//        }
        return $campo;

    }

    public function actualizarCampo($request,$id){

        $existeCategoria = CampoHistoria::select('id')
       ->where('categoria_historia_id', $request['categoria_historia_id'])
       ->where('orden',$request['orden'])
       ->where('id','<>',$id)
       ->first();
       if($existeCategoria == null){
        $campo = $this->campoHistoriaRepository->buscar($id);
        $campo->fill($request);
        $actualizarCampo = $this->campoHistoriaRepository->guardar($campo);
       }else{
        $orden = CampoHistoria::select('orden')
       ->where('id',$id)
       ->first();
       CampoHistoria::where('id',$existeCategoria->id)->update(['orden' => $orden->orden]);
        $campo = $this->campoHistoriaRepository->buscar($id);
        $campo->fill($request);
        $actualizarCampo = $this->campoHistoriaRepository->guardar($campo);
       }
        return $actualizarCampo;

    }

}
