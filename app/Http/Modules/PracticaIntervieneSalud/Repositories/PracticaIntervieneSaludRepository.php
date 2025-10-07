<?php

namespace App\Http\Modules\PracticaIntervieneSalud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PracticaIntervieneSalud\Models\PracticaIntervieneSalud;

class PracticaIntervieneSaludRepository extends RepositoryBase
{
    protected $practicaModel;

    public function __construct()
    {
        $this->practicaModel = new PracticaIntervieneSalud();
        parent::__construct($this->practicaModel);
    }

    public function listarTodas()
    {
        return $this->practicaModel->all();
    }


}