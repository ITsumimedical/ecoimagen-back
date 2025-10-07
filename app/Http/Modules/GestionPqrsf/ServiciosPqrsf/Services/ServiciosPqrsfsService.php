<?php

namespace App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Models\ServiciosPqrsfs;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Repositories\ServiciosPqrsfsRepository;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Requests\CrearServiciosPqrsfsRequest;

class ServiciosPqrsfsService
{

    public function __construct(private ServiciosPqrsfsRepository $serviciosPqrsfsRepository) {

    }

    public function crearServicio($data){

        foreach ($data['cup_id'] as $cup) {

         $this->serviciosPqrsfsRepository->crearServicio($cup,$data['pqrsf_id']);
        }

        return 'ok';
    }
}
