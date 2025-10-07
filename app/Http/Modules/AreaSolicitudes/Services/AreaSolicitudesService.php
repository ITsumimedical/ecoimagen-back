<?php

namespace App\Http\Modules\AreaSolicitudes\Services;

use App\Http\Modules\AreaSolicitudes\Repositories\AreaSolicitudesRepository;

class AreaSolicitudesService{

    public function __construct( private AreaSolicitudesRepository $areaSolicitudesRepository)
    {

    }

    public function guardar($data){
       $area = $this->areaSolicitudesRepository->crear($data);
       $area->user()->attach($data['user_id']);
        return 'ok';

    }


}
