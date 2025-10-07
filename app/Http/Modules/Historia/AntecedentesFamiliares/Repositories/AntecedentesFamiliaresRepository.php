<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliares\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;

class AntecedentesFamiliaresRepository extends RepositoryBase
{

    public function __construct(protected AntecedenteFamiliare $antecedenteFamiliareModel)
    {
    }

    public function listarAntecedentes($data)
    {
        return $this->antecedenteFamiliareModel::with('consulta', 'cie10', 'user.operador')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })->get();


        // ::select(
        //     'antecedente_familiares.id','antecedente_familiares.parentesco','antecedente_familiares.edad',
        //     'antecedente_familiares.fallecido','antecedente_familiares.created_at', 'cie10s.nombre as cie10'
        // )
        // ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as realizado_por")
        // ->join('consultas', 'antecedente_familiares.consulta_id', 'consultas.id')
        // ->join('cie10s', 'antecedente_familiares.cie10_id', 'cie10s.id')
        // ->join('empleados', 'antecedente_familiares.medico_registra', 'empleados.user_id')
        // ->get();
    }

    public function eliminar($data)
    {
        return $this->antecedenteFamiliareModel::where('id', $data->id)->delete();
    }

    public function crear($data)
    {
        return $this->antecedenteFamiliareModel->create($data);
    }
}
