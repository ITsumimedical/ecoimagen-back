<?php

namespace App\Http\Modules\SaludOcupacional\Services;

use App\Http\Modules\SaludOcupacional\Repositories\HistoriaOcupacionalRepository;

class HistoriaOcupacionalService{



    public function __construct(protected HistoriaOcupacionalRepository $historiaOcupacionalRepository)
    {

    }
}
