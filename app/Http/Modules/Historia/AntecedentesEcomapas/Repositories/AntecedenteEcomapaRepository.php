<?php

namespace App\Http\Modules\Historia\AntecedentesEcomapas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesEcomapas\Models\AntecedenteEcomapa;

class AntecedenteEcomapaRepository extends RepositoryBase
{

    public function __construct(protected AntecedenteEcomapa $antecedentesModel)
    {
        parent::__construct($this->antecedentesModel);
    }

    public function listarAntecedentesEcomapa($data)
    {
        return $this->antecedentesModel::select([
            'antecedente_ecomapas.*'
        ])
            ->join('users', 'antecedente_ecomapas.medico_registra', 'users.id')
            ->where('antecedente_ecomapas.consulta_id', $data['consulta'])
            ->first();
    }

    public function crearEcomapa($data)
    {
        $this->antecedentesModel::updateOrCreate(['consulta_id' => $data['consulta_id']], $data);
    }

    public function obtenerDatosEcomapa($afiliadoId)
    {
        $datos = $this->antecedentesModel::select(
            'asiste_colegio',
            'comparte_amigos',
            'comparte_vecinos',
            'pertenece_club_deportivo',
            'pertenece_club_social_cultural',
            'trabaja',
            'asiste_iglesia',
            'orientacion_sex',
            'identidad_genero',
            'identidad_generotransgenero',
            'espermarquia',
            'edad_esperma',
            'menarquia',
            'edad_menarquia',
            'ciclos',
            'ciclosmnestruales',
            'inicio_sexual',
            'numero_relaciones',
            'activo_sexual',
            'dificultades_relaciones',
            'descripciondificultad',
            'uso_anticonceptivos',
            'tipo_anticonceptivos',
            'conocimiento_its',
            'sufrido_its',
            'cualits',
            'fecha_enfermedadits',
            'tratamientoits',
            'trasnmision_sexual',
            'derechos_sexuales',
            'decisionessexrep',
            'victima_identidadgenero',
            'tipo_victimagenero',
            'victima_genero',
            'tipo_victima_violencia_genero',
            'violencia',
            'presenciamutilacion',
            'matrimonioinfantil'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->latest()
            ->first();
        return $datos;
    }
}
