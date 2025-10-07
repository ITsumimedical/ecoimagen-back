<?php

namespace App\Http\Modules\CampoHistorias\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use Illuminate\Database\Eloquent\Model;

class CampoHistoriaRepository extends RepositoryBase {

    protected $campoHistoriaModel;

    public function __construct()
    {
        $this->campoHistoriaModel = new CampoHistoria();
        parent::__construct($this->campoHistoriaModel);
    }

    public function listar($data)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->campoHistoriaModel
                ->whereBuscar($data->filtro)
                ->orderBy('campo_historias.created_at', $orden)
                ->paginate($filas);
        }else{
            return $this->campoHistoriaModel
            ->whereBuscar($data->filtro)
                ->orderBy('campo_historias.created_at', $orden)
                ->get();
        }
    }



    // public function actualizarData($data, $model)
    // {
    //     $datoNuevo = $data->orden;

    //     return $datoNuevo;


    // }

}
