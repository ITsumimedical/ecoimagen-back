<?php

namespace App\Http\Modules\DemandaInducida\Services;

use App\Http\Modules\DemandaInducida\Repositories\DemandaInducidaRepository;
use Illuminate\Support\Facades\Auth;

class DemandaInducidaService {

    public function __construct(protected DemandaInducidaRepository $demandaInducidaRepository) {

    }

    public function guardarDemandaInducida($request) {
        $request['usuario_registra_id'] = Auth()->id();
        return $this->demandaInducidaRepository->crear($request);
    }


}
