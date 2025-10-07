<?php

namespace App\Http\Modules\CategoriaHistorias\Services;

use App\Http\Modules\CategoriaHistorias\Repositories\CategoriaHistoriaRepository;

class CategoriaHistoriaServices{

    protected $categoriaHistoriaRepository;

    public function __construct(CategoriaHistoriaRepository $categoriaHistoriaRepository) {
        $this->categoriaHistoriaRepository = $categoriaHistoriaRepository;
    }

    public function actualizarCategoria($request, $id){
        $categoriaHistoria = $this->categoriaHistoriaRepository->buscar($id);
        $categoriaHistoria->fill($request->except(["citas", "especialidades", "changed_at"]));
        $actuaizarCategoriaHistoria = $this->categoriaHistoriaRepository->guardar($categoriaHistoria);
        $categoriaHistoria->citas()->attach($request["citas"]);
        return $actuaizarCategoriaHistoria;

    }
}
