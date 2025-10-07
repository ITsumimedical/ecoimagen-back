<?php

namespace App\Http\Modules\Pqrsf\IpsPqrsf\Services;

use App\Http\Modules\Pqrsf\IpsPqrsf\Repositories\IpsPqrsfRepository;

class IpsPqrsfService
{

    public function __construct(private IpsPqrsfRepository $ipsPqrsfRepository) {

    }

    public function crearIps($data){

        foreach ($data['rep_id'] as $ips) {

         $this->ipsPqrsfRepository->crearIps($ips,$data['pqrsf_id']);
        }

        return 'ok';
    }
}
