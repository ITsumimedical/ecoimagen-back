<?php

namespace App\Http\Modules\DeclaracionFondos\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DeclaracionFondos\Models\DeclaracionFondo;

class DeclaracionFondosRepository extends RepositoryBase {

    public function __construct(protected DeclaracionFondo $declaracionFondoModel) {
        parent::__construct($this->declaracionFondoModel);
    }



}
