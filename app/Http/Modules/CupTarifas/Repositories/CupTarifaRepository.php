<?php

namespace App\Http\Modules\CupTarifas\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\DeclaracionFondos\Models\DeclaracionFondo;

class CupTarifaRepository extends RepositoryBase {

    public function __construct(protected CupTarifa $cupTarifa) {
        parent::__construct($this->cupTarifa);
    }


    public function tarifaCupEntidadPrestador($cup,$entidad,$rep) {
        return $this->cupTarifa::select('cup_tarifas.id', 'cup_tarifas.valor')
            ->join('tarifas as t', 'cup_tarifas.tarifa_id', 't.id')
            ->join('contratos as c', 't.contrato_id', 'c.id')
            ->where('cup_tarifas.cup_id', $cup)
            ->where('c.entidad_id', $entidad)
            ->where('t.rep_id',$rep)
            ->first();
    }


}
