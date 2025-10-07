<?php

namespace App\Http\Modules\AdjuntosAyudasDiagnosticos\Repositories;

use App\Http\Modules\AdjuntosAyudasDiagnosticos\Models\AdjuntosAyudasDiagnosticos;
use App\Http\Modules\Bases\RepositoryBase;

class AdjuntosAyudasDiagnosticosRespository extends RepositoryBase
{
    protected  $adjuntoAyudasDiagnosticas;

    public function __construct()
    {
        $this->adjuntoAyudasDiagnosticas = new AdjuntosAyudasDiagnosticos();
        parent::__construct($this->adjuntoAyudasDiagnosticas);
    }

    public function buscarAdjuntos($request)
    {
        // $adjuntoConsultado =  $this->adjuntoAyudasDiagnosticas->select('adjuntos_ayudas_diagnosticos.nombre', 'adjuntos_ayudas_diagnosticos.ruta', 'adjuntos_ayudas_diagnosticos.created_at')
        //     ->join('resultado_ayudas_diagnosticas', 'resultado_ayudas_diagnosticas.id', 'adjuntos_ayudas_diagnosticos.resultado_ayudas_diagnosticas_id')
        //     ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
        //     ->where('afiliados.id', )->get();
        // return $adjuntoConsultado;
    }
}
