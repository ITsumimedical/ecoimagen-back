<?php

namespace App\Http\Modules\testSrq\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\testSrq\Model\srq;

class srqRepository extends RepositoryBase
{

    public function __construct(protected srq $srq)
    {
        parent::__construct($this->srq);
    }

    public function crearSrq(array $data)
    {
        return $this->srq->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function obtenerDatosporAfiliado($afiliadoId)
    {
        return $this->srq->select(
            'dolor_cabeza_frecuente',
            'mal_apetito',
            'duerme_mal',
            'asusta_facilidad',
            'temblor_manos',
            'nervioso_tenso',
            'mala_digestion',
            'pensar_claridad',
            'siente_triste',
            'llora_frecuencia',
            'dificultad_disfrutar',
            'tomar_decisiones',
            'dificultad_hacer_trabajo',
            'incapaz_util',
            'interes_cosas',
            'inutil',
            'idea_acabar_vida',
            'cansado_tiempo',
            'estomago_desagradable',
            'cansa_facilidad',
            'herirlo_forma',
            'importante_demas',
            'voces',
            'convulsiones_ataques',
            'demasiado_licor',
            'dejar_beber',
            'beber_trabajo',
            'detenido_borracho',
            'bebia_demasiado',
            'interpretacion_resultado'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
    }
}
