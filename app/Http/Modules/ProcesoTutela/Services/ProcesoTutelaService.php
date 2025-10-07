<?php

namespace App\Http\Modules\ProcesoTutela\Services;

use App\Http\Modules\ProcesoTutela\Repositories\ProcesoTutelaRepository;

class ProcesoTutelaService
{
public function __construct(private ProcesoTutelaRepository $procesoTutelaRepository){}


 /**
     * Lista los procesos que se crearon. Se listan sin paginación dado que son menos de 100 datos
     * @return $Coleccion de datos
     * @author AlejoSR
     */
public function listarProceso($data){
    return $this->procesoTutelaRepository->listarProceso($data);
}



}