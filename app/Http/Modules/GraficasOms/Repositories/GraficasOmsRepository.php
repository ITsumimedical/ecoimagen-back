<?php

namespace App\Http\Modules\GraficasOms\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\Historia;
use Carbon\Carbon;

class GraficasOmsRepository extends RepositoryBase
{
    public function __construct(Consulta $consulta, Historia $historia)
    {
        parent::__construct($consulta, $historia);
    }
    public function obtenerDatos($afiliadoId, $consultaId = null)
    {
        $fechaReferencia = null;
        if ($consultaId) {
            $datosConsulta = $this->obtenerConsulta($consultaId);
            $fechaReferencia = $datosConsulta->hora_fin_atendio_consulta ?? $datosConsulta->fecha_hora_final;
        }

        $resultados = $this->model
            ->join('historias_clinicas', 'consultas.id', '=', 'historias_clinicas.consulta_id')
            ->select(
                'consultas.hora_fin_atendio_consulta as hora_fin',
                'consultas.fecha_hora_final as hora_opcion',
                'historias_clinicas.peso',
                'historias_clinicas.talla',
                'historias_clinicas.perimetro_cefalico',
                'historias_clinicas.imc'
            )
            ->where('consultas.afiliado_id', $afiliadoId)
            ->whereIn('consultas.ciclo_vida_atencion', [
                'Primera Infancia (0-5 Años)',
                'Infancia (6-11 Años)',
                'Adolescencia (12 A 17 Años)'
            ])
            ->where('consultas.tipo_consulta_id', '!=', 1)
            ->where('consultas.estado_id', 9)
            ->whereNotNull('historias_clinicas.peso')
            ->whereNotNull('historias_clinicas.talla')
            ->whereNotNull('historias_clinicas.imc')
            ->when($consultaId, function ($query) use ($fechaReferencia) {
                $query->whereRaw('COALESCE(consultas.fecha_hora_final, consultas.hora_fin_atendio_consulta) <= ?', [$fechaReferencia]);
            })
            ->orderByRaw('COALESCE(consultas.fecha_hora_final, consultas.hora_fin_atendio_consulta)')
            ->get();

        return $resultados->map(function ($item) {
            return [
                'hora_fin_atendio_consulta' => $item->hora_fin
                    ? Carbon::parse($item->hora_fin)->format('d/m/Y')
                    : Carbon::parse($item->hora_opcion)->format('d/m/Y'),
                'peso' => $item->peso,
                'talla' => $item->talla,
                'perimetro_cefalico' => $item->perimetro_cefalico,
                'imc' => $item->imc,
            ];
        });
    }

    private function obtenerConsulta(int $consultaId)
    {
        return Consulta::where('id', $consultaId)->first();
    }
}
