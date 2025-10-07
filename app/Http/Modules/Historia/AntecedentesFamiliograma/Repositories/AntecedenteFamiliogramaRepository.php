<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliograma\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesFamiliograma\Models\AntecedenteFamiliograma;

class AntecedenteFamiliogramaRepository extends RepositoryBase
{

    public function __construct(protected AntecedenteFamiliograma $antecedenteFamiliograma)
    {
        parent::__construct($this->antecedenteFamiliograma);
    }

    public function listarAntecedentesFamiliograma($data)
    {
        return $this->antecedenteFamiliograma::select([
            'antecedente_familiogramas.*',
        ])->join('users', 'antecedente_familiogramas.medico_registra', 'users.id')
            //   ->join('empleados', 'users.id', 'empleados.user_id')
            //   ->selectRaw("CONCAT_WS(' ', empleados.primer_nombre, COALESCE(empleados.segundo_nombre, ''), empleados.primer_apellido, empleados.segundo_apellido) as medicoRegistra")
            ->where('antecedente_familiogramas.consulta_id', $data['consulta'])
            ->first();
    }

    public function crearFamiliograma($data)
    {
        $this->antecedenteFamiliograma::updateOrCreate(['consulta_id' => $data['consulta_id']], $data);
    }

    public function obtenerDatosFamiliograma($afiliadoId)
    {
        $datosFamiliograma = $this->antecedenteFamiliograma::select(
            'vinculos',
            'relacion',
            'tipo_familia',
            'hijos_conforman',
            'responsable_ingreso',
            'problemas_de_salud',
            'cual_salud',
            'observacion_salud',
            'actividad_laboral',
            'alteraciones',
            'descripcion_actividad',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
        return $datosFamiliograma;
    }
}
