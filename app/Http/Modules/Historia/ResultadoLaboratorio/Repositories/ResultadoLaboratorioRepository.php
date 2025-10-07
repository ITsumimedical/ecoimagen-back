<?php

namespace App\Http\Modules\Historia\ResultadoLaboratorio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;

class ResultadoLaboratorioRepository extends RepositoryBase
{

    public function __construct(protected ResultadoLaboratorio $resultadoModel)
    {
        parent::__construct($this->resultadoModel);
    }

    public function listarResultado($data)
    {

        $afiliadoId = $data->input('afiliado');
        $listarCg = $data->input('listarCg', false);

        $laboratorios = $this->resultadoModel::with('consulta', 'user.operador')->whereHas('consulta.afiliado', function ($q) use ($afiliadoId) {
            $q->where('afiliados.id', $afiliadoId);
        });
        if ($listarCg) {
            $laboratorios->where('laboratorio', '903895 - CREATININA EN SUERO U OTROS FLUIDOS');
            return $laboratorios->orderBy('fecha_laboratorio', 'desc')->first();
        } else {
            return $laboratorios->get();
        }
    }

    public function listarResultadoRiesgoCardiovascular($data)
    {
        $afiliadoId = $data->input('afiliado');
        $usoFraminghan = $data->input('usoFraminghan');

        if ($usoFraminghan) {
            $codigos = [
                '903818',
                '903815'
            ];
        } else {
            $codigos = [
                '903028',
                '903818',
                '903868',
                '903815',
                '903817',
                '903841',
                '903427',
                '903426',
                '903895'
            ];
        }

        $resultados = $this->resultadoModel::with('consulta', 'user.operador')
            ->whereHas('consulta.afiliado', function ($q) use ($afiliadoId) {
                $q->where('afiliados.id', $afiliadoId);
            })
            ->where(function ($q) use ($codigos) {
                foreach ($codigos as $codigo) {
                    $q->orWhere('laboratorio', 'LIKE', "$codigo%");
                }
            })
            ->orderBy('fecha_laboratorio', 'desc')
            ->get();

        $final = [];

        $agrupados = $resultados->groupBy('laboratorio');

        foreach ($agrupados as $laboratorio => $items) {
            $items = $items->take(3);

            $fila = ['laboratorio' => $laboratorio];
            $metaReferencia = $items->firstWhere('meta_individual', '!=', null);

            if ($metaReferencia) {
                $fila['meta'] = $metaReferencia->meta_individual;
            }

            $i = 1;
            foreach ($items as $item) {
                $fila["id{$i}"] = $item->id;
                $fila["resultado{$i}"] = $item->resultado_lab;
                $fila["fecha{$i}"] = $item->fecha_laboratorio;
                $i++;
            }

            $final[] = $fila;
        }
        return $final;
    }
    // public function crearApgar($data){
    //     $this->resultadoModel::updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    // }


}
