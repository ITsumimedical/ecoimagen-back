<?php

namespace App\Http\Modules\Pqrsf\AreasPqrsf\Services;

use App\Http\Modules\Pqrsf\AreasPqrsf\Repositories\AreasPqrsfRepository;

class AreasPqrsfService
{

    public function __construct(private AreasPqrsfRepository $areasPqrsfRepository) {

    }

    public function crearServicio($data){

        foreach ($data['area_id'] as $area) {

         $this->areasPqrsfRepository->crearArea($area,$data['pqrsf_id']);
        }

        return 'ok';
    }
}
