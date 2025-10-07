<?php

namespace App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Services;

use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Repositories\SubcategoriaPqrsfRepository;

class SubcategoriaPqrsfService {

public function __construct(private SubcategoriaPqrsfRepository $subcategoriaPqrsfRepository) {

}

public function crearSub($data){

    foreach ($data['subcategoria_id'] as $subcategoria) {

     $this->subcategoriaPqrsfRepository->crearSub($subcategoria,$data['pqrsf_id']);
    }

    return 'ok';
}
}
