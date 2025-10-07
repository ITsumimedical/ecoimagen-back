<?php

namespace App\Http\Modules\Certificados\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Certificados\Models\Certificado;


class CertificadoRepository extends RepositoryBase{

    public function __construct(protected Certificado $certificadoModel ){

        parent::__construct($this->certificadoModel);
    }



}
