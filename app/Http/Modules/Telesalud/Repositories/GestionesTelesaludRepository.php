<?php

namespace App\Http\Modules\Telesalud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Telesalud\Models\GestionesTelesalud;

class GestionesTelesaludRepository extends RepositoryBase
{
    protected $gestionTelesaludModel;

    public function __construct()
    {
        $this->gestionTelesaludModel = new GestionesTelesalud();
        parent::__construct($this->gestionTelesaludModel);
    }

    /**
     * Funcion para Crear un registro de la Gestion de una Telesalud
     * @param int $telesaludId
     * @param int $tipoId
     * @param string|null $prioridad
     * @param string|null $pertinencia_solicitud
     * @param string|null $observacion
     * @return GestionesTelesalud
     */
    public function guardarGestionTelesalud($telesaludId, $tipoId, $prioridad, $pertinencia_solicitud, $observacion, $finalidad = null, $causa = null)
    {
        $gestion = $this->gestionTelesaludModel->create([
            'telesalud_id' => $telesaludId,
            'tipo_id' => $tipoId,
            'funcionario_gestiona_id' => auth()->user()->id,
            'prioridad' => $prioridad ? $prioridad : null,
            'pertinencia_solicitud' => $pertinencia_solicitud ? $pertinencia_solicitud : null,
            'observacion' => $observacion ? $observacion : null,
            'finalidad_consulta_id' => $finalidad,
            'causa_externa_id' => $causa,
        ]);

        return $gestion;
    }

    public function guardarRespuestaJuntaProfesionales($telesaludId, $request)
    {

        $gestion = $this->gestionTelesaludModel->create([
            'telesalud_id' => $telesaludId,
            'tipo_id' => 47,
            'funcionario_gestiona_id' => auth()->user()->id,
            'prioridad' => $request['prioridad'],
            'pertinencia_solicitud' => $request['pertinencia_solicitud'],
            'observacion' => $request['observacion'],
            'institucion_prestadora_id' => $request['institucion_prestadora'],
            'eapb_id' => $request['eapb'],
            'evaluacion_junta' => $request['evaluacion_junta'],
            'junta_aprueba' => $request['junta_aprueba'],
            'clasificacion_prioridad' => $request['clasificacion_prioridad']
        ]);

        return $gestion;
    }
}
