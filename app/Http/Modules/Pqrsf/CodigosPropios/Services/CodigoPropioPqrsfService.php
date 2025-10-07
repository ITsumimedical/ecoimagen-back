<?php

namespace App\Http\Modules\Pqrsf\CodigosPropios\Services;

use App\Http\Modules\Pqrsf\CodigosPropios\Repositories\CodigoPropioPqrsfRepository;

class CodigoPropioPqrsfService {

    public function __construct(private CodigoPropioPqrsfRepository $cpropioPqrsfRepository) {

    }

    public function crearServicio($data){

        foreach ($data['codigo_propio_id'] as $codigo) {

         $this->cpropioPqrsfRepository->crearCodigoPropio($codigo,$data['formulariopqrsf_id']);
        }

        return 'ok';
    }
}
