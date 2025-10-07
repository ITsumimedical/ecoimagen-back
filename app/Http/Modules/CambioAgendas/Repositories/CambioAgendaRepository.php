<?php

namespace App\Http\Modules\CambioAgendas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CambioAgendas\Models\CambioAgenda;
use Illuminate\Support\Facades\DB;

class CambioAgendaRepository extends RepositoryBase
{

    protected $cambioAgendaModel;

    public function __construct()
    {
        $this->cambioAgendaModel = new CambioAgenda();
        parent::__construct($this->cambioAgendaModel);
    }

    public function listarCambios(int $id)
    {
        $cambios = CambioAgenda::select(
            'cambio_agendas.id',
            'cambio_agendas.agenda_id',
            'cambio_agendas.user_id',
            'cambio_agendas.motivo',
            'cambio_agendas.accion',
            DB::raw("TO_CHAR(cambio_agendas.created_at, 'YYYY-MM-DD HH24:MI:SS') as fecha_accion"),
            DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as usuario_cambia"),
            'consultorio_origen.nombre as consultorio_origen_nombre',
            'rep_origen.nombre as rep_origen_nombre',
            'rep_origen.codigo_habilitacion as rep_origen_codigo',
            'consultorio_destino.nombre as consultorio_destino_nombre',
            'rep_destino.nombre as rep_destino_nombre',
            'rep_destino.codigo_habilitacion as rep_destino_codigo'
        )
            ->leftJoin('users', 'users.id', '=', 'cambio_agendas.user_id')
            ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
            ->leftJoin('consultorios as consultorio_origen', 'consultorio_origen.id', '=', 'cambio_agendas.consultorio_origen_id')
            ->leftJoin('reps as rep_origen', 'rep_origen.id', '=', 'consultorio_origen.rep_id')
            ->leftJoin('consultorios as consultorio_destino', 'consultorio_destino.id', '=', 'cambio_agendas.consultorio_destino_id')
            ->leftJoin('reps as rep_destino', 'rep_destino.id', '=', 'consultorio_destino.rep_id')
            ->where('cambio_agendas.agenda_id', $id)
            ->orderBy('cambio_agendas.created_at', 'asc')
            ->get();

        return $cambios;
    }
}
