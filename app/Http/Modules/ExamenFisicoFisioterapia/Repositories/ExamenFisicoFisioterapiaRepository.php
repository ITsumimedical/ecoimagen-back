<?php

namespace App\Http\Modules\ExamenFisicoFisioterapia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ExamenFisicoFisioterapia\Model\ExamenFisicoFisioterapia;

class ExamenFisicoFisioterapiaRepository extends RepositoryBase
{

    public function __construct(protected ExamenFisicoFisioterapia $examenFisicoFisioterapia)
    {
        parent::__construct($this->examenFisicoFisioterapia);
    }

    // public function crearExamen(array $data)
    // {
    //     dd($data["dolor"]["presente"]);
    //     return $this->examenFisicoFisioterapia->updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    // }

    public function crearExamen(array $data)
    {
        $datos = [
            'consulta_id' => $data['consulta_id'],
            'dolor_presente' => $data['dolor']['presente'] ?? null,
            'frecuencia_dolo' => $data['dolor']['frecuencia'] ?? null,
            'intensidad_dolor' => $data['dolor']['intensidad'] ?? null,
            'edema_presente' => $data['edema']['presente'] ?? null,
            'ubicacion_edema' => $data['edema']['ubicacion'] ?? null,
            'sensibilidad_conservada' => $data['sensibilidad']['conservada'] ?? null,
            'sensibilidad_alterada' => $data['sensibilidad']['alterada'] ?? null,
            'ubicacion_sensibilidad' => $data['sensibilidad']['localizacion'] ?? null,
            'fuerza_muscular' => $data['fuerza']['rango'] ?? null,
            'pruebas_semiologicas' => $data['fuerza']['pruebas_semiologicas'] ?? null,
            'equilibrio_conservado' => $data['equilibrio']['conservada'] ?? null,
            'equilibrio_alterado' => $data['equilibrio']['alterada'] ?? null,
            'marcha_conservada' => $data['marchas']['conservada'] ?? null,
            'marcha_alterada' => $data['marchas']['alterada'] ?? null,
            'ayudas_externas' => $data['ayudas'] ?? null,
        ];
        return $this->examenFisicoFisioterapia->updateOrCreate(
            ['consulta_id' => $datos['consulta_id']],
            $datos
        );
    }
}
