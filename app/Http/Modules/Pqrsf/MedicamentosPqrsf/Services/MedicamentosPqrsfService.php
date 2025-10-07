<?php

namespace App\Http\Modules\Pqrsf\MedicamentosPqrsf\Services;

use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Repositories\medicamentosPqrsfsRepository;

class MedicamentosPqrsfService {

public function __construct(private medicamentosPqrsfsRepository $medicamentosPqrsfsRepository) {

}

public function crearMedicamento($data){

    foreach ($data['medicamento_id'] as $medicamento) {

     $this->medicamentosPqrsfsRepository->crearMedicamento($medicamento,$data['pqrsf_id']);
    }

    return 'ok';
}
}
