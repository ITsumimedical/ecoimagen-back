<?php

namespace App\Http\Modules\Historia\AntecedentesFarmacologicos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use Illuminate\Support\Facades\DB;

class AntecedentesFarmacologicosRepository extends RepositoryBase
{

    public function __construct(protected AntecedentesFarmacologico $antecedentePersonalModel)
    {
        parent::__construct($this->antecedentePersonalModel);
    }

    // public function listarAlergiaMedicamento($data) {
    //     return AntecedentesFarmacologico::with('consulta','user','medicamento')->whereHas('consulta.afiliado', function ($q) use ($data) {
    //         $q->where('afiliados.id', $data->afiliado);
    //     })->whereNotNULL('antecedentes_farmacologicos.medicamento_id')->get();
    // }

    public function listarAlergiaMedicamento($data)
    {
        $alergiaMedicamentos = $this->antecedentePersonalModel::select(
            'antecedentes_farmacologicos.id',
            'antecedentes_farmacologicos.observacion_medicamento',
            'antecedentes_farmacologicos.medicamento_id',
            'antecedentes_farmacologicos.created_at',
            'consultas.afiliado_id',
            'codesumis.principio_activo as medicamento',
            'users.email as user_email',
            'users.id as user_id',
            DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as operador"),
            'principio_activos.nombre as principioAlergia'
        )
            ->join('consultas', 'antecedentes_farmacologicos.consulta_id', '=', 'consultas.id')
            ->leftJoin('medicamentos', 'antecedentes_farmacologicos.medicamento_id', 'medicamentos.id')
            ->leftJoin('codesumis', 'medicamentos.codesumi_id', 'codesumis.id')
            ->leftJoin('users', 'antecedentes_farmacologicos.medico_registra', 'users.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->leftjoin('principio_activos', 'antecedentes_farmacologicos.principio_activo_id', 'principio_activos.id')
            ->where('consultas.afiliado_id', $data->afiliado)
            ->whereNotNull('antecedentes_farmacologicos.principio_activo_id')
            ->orderBy('antecedentes_farmacologicos.id', 'desc')
            ->with('consulta')
            ->get();

        return $alergiaMedicamentos;
    }



    // public function listarAlergiaAmbiental($data)
    // {
    //     return AntecedentesFarmacologico::with('consulta', 'user')->whereHas('consulta.afiliado', function ($q) use ($data) {
    //         $q->where('afiliados.id', $data->afiliado);
    //     })->whereNotNULL('antecedentes_farmacologicos.ambiental')->get();
    // }


    public function listarAlergiaAmbiental($data)
    {
        $ambiental = $this->antecedentePersonalModel::select(
            'antecedentes_farmacologicos.observacion_ambiental',
            'antecedentes_farmacologicos.ambiental',
            'antecedentes_farmacologicos.created_at',
            'consultas.afiliado_id',
            'users.email as user_email',
            DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as operador")
        )
            ->join('consultas', 'antecedentes_farmacologicos.consulta_id', '=', 'consultas.id')
            ->leftJoin('users', 'antecedentes_farmacologicos.medico_registra', '=', 'users.id')
            ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
            ->where('consultas.afiliado_id', $data->afiliado)
            ->whereNotNull('antecedentes_farmacologicos.ambiental')
            ->with('consulta')
            ->get();

        return $ambiental;
    }

    // public function listarAlergiaAlimentos($data)
    // {
    //     return AntecedentesFarmacologico::with('consulta', 'user')->whereHas('consulta.afiliado', function ($q) use ($data) {
    //         $q->where('afiliados.id', $data->afiliado);
    //     })->whereNotNULL('antecedentes_farmacologicos.alimento')->get();
    // }

    public function listarAlergiaAlimentos($data) {
        $alimentos = $this->antecedentePersonalModel::select('antecedentes_farmacologicos.id','antecedentes_farmacologicos.alimento',
        'antecedentes_farmacologicos.observacion_alimento','antecedentes_farmacologicos.created_at', 'users.id as user_id',
        DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as operador")
        )
        ->join('consultas', 'antecedentes_farmacologicos.consulta_id', '=', 'consultas.id')
        ->leftJoin('users', 'antecedentes_farmacologicos.medico_registra', '=', 'users.id')
        ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
        ->where('consultas.afiliado_id', $data->afiliado)
        ->whereNotNull('antecedentes_farmacologicos.alimento')
        ->with('consulta')
        ->get();

        return $alimentos;
    }

    public function listarOtras($data) {
        $otras = $this->antecedentePersonalModel::select('antecedentes_farmacologicos.otras', 'antecedentes_farmacologicos.observacion_otro',
         'antecedentes_farmacologicos.created_at','users.id as user_id','antecedentes_farmacologicos.id',
        DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as operador"))
        ->join('consultas', 'antecedentes_farmacologicos.consulta_id', '=', 'consultas.id')
        ->leftJoin('users', 'antecedentes_farmacologicos.medico_registra', '=', 'users.id')
        ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
        ->where('consultas.afiliado_id', $data->afiliado)
        ->whereNotNull('antecedentes_farmacologicos.otras')
        ->with('consulta')
        ->get();

        return $otras;
    }

    // public function listarOtras($data)
    // {
    //     return AntecedentesFarmacologico::with('consulta', 'user')->whereHas('consulta.afiliado', function ($q) use ($data) {
    //         $q->where('afiliados.id', $data->afiliado);
    //     })->whereNotNULL('antecedentes_farmacologicos.otras')->get();
    // }

    //  public function eliminarAlergia($id)
    // {
    //     $resultado = $this->antecedentePersonalModel->findOrFail($id);
    //     return $resultado->delete();
    // }

    public function eliminarAlergia($id)
{
    return $this->antecedentePersonalModel->where('id', $id)->delete();
}

}
