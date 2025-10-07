<?php

namespace App\Http\Modules\Familias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Familias\Models\Familia;
use App\Http\Modules\Tarifas\Models\Tarifa;

class FamiliaRepository extends RepositoryBase {

    protected $model;

    public function __construct(){
        $this->model = new Familia;
        parent::__construct($this->model);
    }

    /**
     * Lista
     * @param Object $data
     * @return Collection
     * @author David Peláez
     */
    public function listarFamilias($data){
        /** Definimos el orden*/
        $consulta = $this->model
            ->withCount('cups')
            ->whereBuscar($data->buscar)
            ->whereTipoFamilia($data->tipo_familia_id);

        return $data->page ? $consulta->paginate() : $consulta->get();
    }

    public function listarFamiliaTarifas($tarifa_id){
        $consulta = $this->model
            ->join('familia_tarifas','familia_tarifas.familia_id','familias.id')
            ->where('familia_tarifas.tarifa_id', $tarifa_id);

        return $consulta->get();
    }

    /**
     * Cambia el estado
     * @param TipoFamilia
     * @return boolean
     * @author David Peláez
     */
    public function cambiarEstado($modelo){
        return $modelo->update([
            'activo' => !$modelo->activo
        ]);
    }

  public function guardarFamiliaTarifa($id,$datos){
        $consulta = Tarifa::find($id);
        foreach ($datos->familias as $dato){
            $consulta->familias()->attach($dato);
        }
        return true;
  }

  public function listarFamiliaCups($data){

        $consulta = Cup::select('familias.nombre as familia_nombre','cups.codigo','cups.nombre')
            ->join('cup_familia','cup_familia.cup_id','cups.id')
            ->join('familias','familias.id','cup_familia.familia_id')
            ->where('cups.codigo','ILIKE','%'.$data->nombreCups.'%')
            ->orWhere('cups.nombre','ILIKE','%'.$data->nombreCups.'%')
            ->get();

        return $consulta;
    }

}
