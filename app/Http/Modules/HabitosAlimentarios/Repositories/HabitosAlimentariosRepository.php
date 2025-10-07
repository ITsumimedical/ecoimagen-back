<?php

namespace App\Http\Modules\HabitosAlimentarios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\HabitosAlimentarios\Model\HabitosAlimentarios;

class HabitosAlimentariosRepository extends RepositoryBase {


    public function __construct(protected HabitosAlimentarios $habitosAlimentarios)
    {
        parent::__construct($this->habitosAlimentarios);
    }
}
