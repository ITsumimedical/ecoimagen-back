<?php

namespace App\Http\Modules\RxFinal\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RxFinal\Model\RxFinal;

class RxFinalRepository extends RepositoryBase
{

    public function __construct(protected RxFinal $rxFinalModel)
    {
        parent::__construct($this->rxFinalModel);
    }

    public function crearRx(array $data)
    {
        return $this->rxFinalModel->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function listarOjoDerecho($consulta_id)
    {
        return $this->rxFinalModel->select(
            'esfera_ojo_derecho',
            'cilindro_ojo_derecho',
            'eje_ojo_derecho',
            'add_ojo_derecho',
            'prima_base_ojo_derecho',
            'grados_ojo_derecho',
            'av_lejos_ojo_derecho',
            'av_cerca_ojo_derecho',
            'consulta_id'
        )
            ->join('consultas', 'rx_finals.consulta_id', 'consultas.id')
            ->where('consultas.id', $consulta_id)
            ->get();
    }

    public function listarOjoIzquierdo($consulta_id)
    {
        return $this->rxFinalModel->select(
            'esfera_ojo_izquierdo',
            'cilindro_ojo_izquierdo',
            'eje_ojo_izquierdo',
            'add_ojo_izquierdo',
            'prima_base_ojo_izquierdo',
            'grados_ojo_izquierdo',
            'av_lejos_ojo_izquierdo',
            'av_cerca_ojo_izquierdo',
            'consulta_id',
        )
            ->join('consultas', 'rx_finals.consulta_id', 'consultas.id')
            ->where('consultas.id', $consulta_id)
            ->get();
    }
}
