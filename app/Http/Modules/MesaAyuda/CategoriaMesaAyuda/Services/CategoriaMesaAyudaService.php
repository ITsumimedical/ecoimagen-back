<?php

namespace App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Services;

use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Repositories\CategoriaMesaAyudaRepository;

class CategoriaMesaAyudaService{

    public function __construct( private CategoriaMesaAyudaRepository $categoriaMesaAyudaRepository)
    {

    }

    public function guardar($data){
       $area = $this->categoriaMesaAyudaRepository->crear($data);
       $area->user()->attach($data['user_id']);
        return 'ok';

    }


}
