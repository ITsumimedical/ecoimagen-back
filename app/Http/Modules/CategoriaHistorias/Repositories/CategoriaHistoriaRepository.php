<?php

namespace App\Http\Modules\CategoriaHistorias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Citas\Models\Cita;

class CategoriaHistoriaRepository extends RepositoryBase {

    protected $CategoriaHistoriaModel;

    public function __construct(){
        $this->CategoriaHistoriaModel = new CategoriaHistoria();
        parent::__construct($this->CategoriaHistoriaModel);
    }

    public function guardarCategoria($request){

        $categoria = CategoriaHistoria::create([
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'tipo_categoria_historia_id' => $request->tipoCategoria
        ]);
        if($request->citas){
            $categoria->citas()->attach($request->citas,['orden'=> $request->orden,'requerido'=> intval($request->requerido)]);
        }
        if($request->especialidades){
            $categoria->especialidades()->attach($request->especialidades);
        }
        $data = ['id' => $categoria->id,
            'nombre' => $request->nombre,
            'titulo' => $request->titulo,
            'orden' => $request->orden,
            'editable' => $request->editable,
            'citas' => $request->citas,
            'tipo_categoria_historia_id' => $request->tipoCategoria];
        return $data;
    }

    public function listar($data)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->CategoriaHistoriaModel
            ->with([
                'citas',
                'especialidades'
            ])
                ->orderBy('categoria_historias.created_at', $orden)
                ->paginate($filas);
        }else{
            return $this->CategoriaHistoriaModel
            ->with([
                'citas',
                'especialidades'
            ])
                ->orderBy('categoria_historias.created_at', $orden)
                ->get();
        }
    }

}
