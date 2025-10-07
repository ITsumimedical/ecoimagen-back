<?php

namespace App\Http\Modules\NovedadContratos;

use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use Illuminate\Support\Facades\Auth;

class NovedadContratoService {

    private $model;

    public function __construct() {
        $this->model = new novedadContrato();
    }

    /**
     * crea una novedad para un contrato
     * @param array $data
     * @return 
     */
    public function crear($data){
        $data['user_id'] = Auth::id();
        return $this->model->create($data);
    }

}