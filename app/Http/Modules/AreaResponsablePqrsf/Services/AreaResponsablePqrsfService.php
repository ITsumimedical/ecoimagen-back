<?php

namespace App\Http\Modules\AreaResponsablePqrsf\Services;

use App\Http\Modules\AreaResponsablePqrsf\Repositories\AreaResponsablePqrsfRepository;

class AreaResponsablePqrsfService{



    public function __construct( private AreaResponsablePqrsfRepository $areaResponsablePqrsfRepository)
    {

    }

    public function guardar($data){
       $area = $this->areaResponsablePqrsfRepository->crear($data);
       $area->responsable()->attach($data['responsable_id']);
        return 'ok';

    }


}
