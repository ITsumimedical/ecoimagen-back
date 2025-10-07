<?php

namespace App\Http\Modules\Recomendaciones\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Recomendaciones\Models\Recomendaciones;

class RecomendacionesRepository extends RepositoryBase
{

    public function __construct(protected Recomendaciones $recomendaciones)
    {
        parent::__construct($this->recomendaciones);
    }

    public function listarRecomendaciones(Request $request)
    {
        $consulta = Recomendaciones::select('recomendaciones.*')
            ->with(['cup', 'cie10', 'usuario.operador']);

        if ($request['filtroCie10'] === true) {
            $consulta->whereNotNull('cie10_id');
        } elseif ($request['filtroCups'] === true) {
            $consulta->whereNotNull('cup_id');
        }

        return $consulta->get();
    }

    /**
     * listarCondicionado -  lista las recomendaciones de cups y cie10
     * de acuerdo al genero y la edad del afiliado
     *
     * @param  mixed $request
     * @return void
     */

    public function listarCondicionado(Request $request)
    {

        $cie10_ids = $request->cie10_id;

        if (!$cie10_ids) {
            $cie10_afiliados = Cie10Afiliado::where('consulta_id', $request->consulta_id)
                ->with('cie10')
                ->get();

            if ($cie10_afiliados->isEmpty()) {
                return response()->json([
                    'message' => 'No se encontraron CIE10 relacionados para la consulta.',
                ], 404);
            }

            $cie10_ids = $cie10_afiliados->pluck('cie10_id')->toArray();
        }

        if (!is_array($cie10_ids)) {
            $cie10_ids = [$cie10_ids];
        }

        $cie10_ids = Arr::flatten($cie10_ids);

        $recomendaciones = Recomendaciones::whereIn('cie10_id', $cie10_ids)
            ->where('estado_id', 1)
            ->get();

        $cie10_afiliados = Cie10Afiliado::whereIn('cie10_id', $cie10_ids)
            ->with('cie10')
            ->get()
            ->keyBy('cie10_id');

        $recomendaciones->each(function ($recomendacion) use ($cie10_afiliados) {
            if (isset($cie10_afiliados[$recomendacion->cie10_id])) {
                $recomendacion->Codigo_Nombre = $cie10_afiliados[$recomendacion->cie10_id]->cie10->Codigo_Nombre ?? null;
            }
        });

        return $recomendaciones;
    }

}
