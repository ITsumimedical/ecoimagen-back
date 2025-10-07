<?php

namespace App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Models\CategoriaMesaAyuda;

class CategoriaMesaAyudaRepository extends RepositoryBase
{

    protected $CategoriaMesaAyudaModel;

    public function __construct(CategoriaMesaAyuda $CategoriaMesaAyudaModel)
    {
        $this->CategoriaMesaAyudaModel = $CategoriaMesaAyudaModel;
        parent::__construct($this->CategoriaMesaAyudaModel);
    }

    /**
     * Listar categorias con su respectiva area
     *
     * @return void
     */
    public function listarCategorias()
    {
        return CategoriaMesaAyuda::
            // ->join('area_ths', 'categoria_mesa_ayudas.area_th_id', 'area_ths.id')
            // join('estados', 'categoria_mesa_ayudas.estado_id', 'estados.id')
            where('categoria_mesa_ayudas.estado_id', 1)
            ->with(['areasMesaAyuda','user'])
            ->get();
    }

    public function listarTodas()
    {
        return $this->CategoriaMesaAyudaModel
            ->select('categoria_mesa_ayudas.*', 'estados.nombre as estadoNombre')
            ->leftjoin('estados', 'categoria_mesa_ayudas.estado_id', '=', 'estados.id')
            ->with(['areasMesaAyuda', 'user.operador'])
            ->get();
    }

    public function listarCategoriaConArea($area)
    {
        return $this->CategoriaMesaAyudaModel->where('areas_mesa_ayuda_id', $area)
            ->where('estado_id', 1)
            ->get();
    }

    public function CambiarEstado($id)
    {
        $canal = $this->CategoriaMesaAyudaModel->find($id);
        if ($canal) {
            $canal->estado_id = $canal->estado_id == 1 ? 2 : 1;
            $canal->save();
            return $canal;
        } else {
            return null;
        }
    }
}
