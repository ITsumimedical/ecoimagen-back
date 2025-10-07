<?php

namespace App\Http\Modules\PrestadoresTH\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PrestadoresTH\Models\PrestadorTh;

class PrestadorThRepository extends RepositoryBase {

    protected $PrestadorThModel;

    public function __construct(){
        $PrestadorThModel = new PrestadorTh();
        parent::__construct($PrestadorThModel);
        $this->PrestadorThModel = $PrestadorThModel;
     }

     public function listarPrestadorTh($data, $id)
     {
         /** Definimos el orden*/
         $orden = isset($data->orden) ? $data->orden : 'desc';
         if($data->page){
             $filas = $data->filas ? $data->filas : 10;
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->paginate($filas)
                 ->where('tipo_prestador_id', $id);
         }else{
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->where('tipo_prestador_id', $id)
                 ->get();
         }
     }

     public function listarPrestadorTipo($data, $id)
     {
         /** Definimos el orden*/
         $orden = isset($data->orden) ? $data->orden : 'desc';
         if($data->page){
             $filas = $data->filas ? $data->filas : 10;
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->paginate($filas)
                 ->where('tipo_prestador_id', $id);
         }else{
             return $this->model
                 ->orderBy('created_at', $orden)
                 ->where('tipo_prestador_id', $id)
                 ->get();
         }
     }

     public function listarPrestadores()
     {
        $consulta = PrestadorTh::select('prestador_ths.*')
        ->with('tipoPrestador')
        ->get();

        return $consulta;
     }

}
