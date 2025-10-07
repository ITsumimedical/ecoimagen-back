<?php

namespace App\Http\Modules\Agendas\Repositories;

use App\Http\Modules\Agendas\Models\AgendamientoCirugia;
use App\Http\Modules\Consultorios\Models\Consultorio;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Sedes\Repositories\SedeRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AgendaRepository extends RepositoryBase
{
    protected $agendaModel;

    public function __construct()
    {
        $this->agendaModel = new Agenda();
        parent::__construct($this->agendaModel);
    }

    public function agendaDisponible($request)
    {
        return $this->agendaModel->select(['agendas.*'])
            ->without("medicos", "consultorio", "cita")
            //->with(['consultas' => function($query){
            //    return $query->without('afiliados');
            //}])
            ->join('consultorios as c', 'c.id', 'agendas.consultorio_id')
            ->where('agendas.cita_id', $request->cita)
            ->where('c.rep_id', $request->sede)
            ->where('agendas.estado_id', 11)
            ->get();
    }

    public function sede($request)
    {
        return $this->agendaModel->select('reps.id', 'reps.nombre', 'reps.direccion')
            ->join('consultorios as c', 'c.id', 'agendas.consultorio_id')
            ->join('reps', 'reps.id', 'c.rep_id')
            ->where('agendas.cita_id', $request)
            // ->where('c.rep_id',$request->sede)
            ->where('agendas.estado_id', 11)
            ->distinct()
            ->get();
    }

    public function medicos($request)
    {
        return $this->agendaModel->select(['agendas.*'])
            ->with(['consultas', 'medicos.operador', 'consultorio', 'cita.tipoCita'])
            ->join('consultorios as c', 'c.id', 'agendas.consultorio_id')
            ->where('agendas.cita_id', $request->cita)
            ->where('c.rep_id', $request->sede)
            ->whereBetween('agendas.fecha_inicio', [$request['fecha'] . ' 00:00:00.000', $request['fecha'] . ' 23:59:59.999'])
            ->where('agendas.estado_id', 11)
            ->get();
    }

    public function agendaDisponibleAutogestion($cita, $rep)
    {
        return $this->agendaModel->select(
            'agendas.id',
            'reps.nombre as sede',
            'agendas.consultorio_id',
            'agendas.cita_id',
            'agendas.fecha_inicio',
            'agendas.fecha_fin'
        )
            ->with(['consultas'])
            ->join('consultorios as c', 'c.id', 'agendas.consultorio_id')
            ->join('reps', 'reps.id', 'c.rep_id')
            ->join('citas', 'citas.id', 'agendas.cita_id')
            // ->with(["medicos","consultorio","cita"])
            ->where('agendas.estado_id', 11)
            ->where('citas.id', $cita)
            ->where('c.rep_id', $rep)
            ->get();
    }

    public function exportar($request)
    {
        // $procedure_uno = DB::select("exec dbo.ExportCitas ?,?", [$request['fecha_inicial'],$request['fecha_final']." 23:59:59.999"]);
        // $appointments_uno = json_decode(json_encode($procedure_uno), true);

        // return (new FastExcel($appointments_uno))->download('informe.xls');
    }

    public function exportarDemanda($request)
    {
        // $demanda = (DB::select('SET NOCOUNT ON exec dbo.SP_DemandaInsatisfecha ?,?', [$request['fecha_inicial'] . ' 00:00:00.000', $request['fecha_final'] . ' 23:59:00.000']));
        // $result = json_decode(collect($demanda), true);
        // return (new FastExcel($result))->download('informe.xls');
    }

    public function historicoAgendasCirugia($request)
    {
        $agendamiento = AgendamientoCirugia::select(['id', 'fecha', 'hora_inicio_estimada', 'hora_fin_estimada', 'color_evento', 'clase', 'tipo_anestesia', 'fecha_aval_cirugia', 'aval_cirugia', 'anestesiologo', 'cirujano', 'afiliado_id', 'reps_id', 'consultorio_id'])
            ->with(
                'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,tipo_documento,numero_documento',
                'consultorio:id,rep_id,nombre',
                'cirujano:id',
                'anestesiologo:id',
                'sede:id,nombre,codigo_habilitacion,numero_sede',
                'afiliado.tipoDocumento:id,sigla',
                'cirujano.operador:id,user_id,nombre,apellido',
                'anestesiologo.operador:id,user_id,tipo_doc,nombre,apellido',
                'cupsAgenda:id,nombre,codigo'
            )
            ->whereBetween('fecha', [$request['desde'], $request['hasta']]);
        if (isset($request['estado'])) {
            $agendamiento->where('estado_id', $request['estado']);
        }
        if (isset($request['rep_id'])) {
            $agendamiento->where('reps_id', $request['rep_id']);
        }
        if (isset($request['cirujano'])) {
            $agendamiento->where('cirujano', $request['cirujano']);
        }
        if (isset($request['quirofano'])) {
            $agendamiento->where('consultorio_id', $request['quirofano']);
        }
        return $agendamiento->get();
    }

    public function reporteCirugiasProgramadas($request)
    {
        $reporte = Collect(DB::select('select * from fn_cirujias_programadas(?,?)', [$request['desde'], $request['hasta']]));
        $array = json_decode($reporte, true);
        return $array;
    }

    public function quirofanosSede($repId)
    {
        return Consultorio::where('rep_id', $repId)->where('quirofano', 1)->get();
    }

    public function listarPorConsultorio(array $filtros): Collection
    {
        $consultorioId = $filtros['consultorio_id'];

        $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
        $fechaFin    = Carbon::parse($filtros['fecha_fin'])->endOfDay();

        return Agenda::query()
            ->join('agenda_user', 'agendas.id', '=', 'agenda_user.agenda_id')
            ->join('users', 'agenda_user.user_id', '=', 'users.id')
            ->leftJoin('operadores', 'users.id', '=', 'operadores.user_id')
            ->where('agendas.consultorio_id', $consultorioId)
            ->where('agendas.estado_id', 11)
            ->whereBetween('agendas.fecha_inicio', [$fechaInicio, $fechaFin])
            ->orderBy('agendas.fecha_inicio', 'asc')
            ->get([
                'agendas.id',
                'agendas.consultorio_id',
                'agendas.fecha_inicio',
                'agendas.fecha_fin',
                'users.id as medico_id',
                'operadores.nombre as medico_nombre',
                'operadores.apellido as medico_apellido',
                'operadores.documento as medico_documento',
            ])
            ->groupBy('id')
            ->map(function ($agendas) {
                $agenda = $agendas->first();
                return [
                    'id'           => $agenda->id,
                    'fecha_inicio' => $agenda->fecha_inicio,
                    'fecha_fin'    => $agenda->fecha_fin,
                    'medicos'      => $agendas->map(function ($a) {
                        return [
                            'id'        => $a->medico_id,
                            'nombre'    => $a->medico_nombre ?? '',
                            'apellido'  => $a->medico_apellido ?? '',
                            'documento' => $a->medico_documento ?? '',
                        ];
                    })->values(),
                ];
            })
            ->values();
    }
}
