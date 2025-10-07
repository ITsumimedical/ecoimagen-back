<?php

namespace App\Http\Modules\Teleapoyo\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Teleapoyo\Models\Teleapoyo;

class TeleapoyoRepository extends RepositoryBase
{

    protected $model;

    public function __construct()
    {
        $this->model = new Teleapoyo();
        parent::__construct($this->model);
    }

    public function listarTeleapoyosPendientes($data)
    {
        $teleapoyos = $this->model
            ->with(['afiliado.ips', 'especialidad', 'tipoSolicitud', 'userCrea.operador'])
            ->where("estado_id", 10)
            ->when($data["fechaInicio"] && $data["fechaFin"], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data["fechaInicio"], $data["fechaFin"]]);
            })
            ->when($data['tipo_solicitud_id'], function ($query) use ($data) {
                $query->where('tipo_solicitudes_id', $data['tipo_solicitud_id']);
            })
            ->when($data['numeroDocumento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data['numeroDocumento']);
                });
            })
            ->when($data['ips_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('ips_id', $data['ips_id']);
                });
            });



        return $data['page'] ? $teleapoyos->paginate($data['cantidad']) : $teleapoyos->get();
    }

    public function responder($id, $data)
    {
        $teleapoyo = $this->model::find($id);
        return $teleapoyo->update([
            // 'observacion_reasignacion_girs' => $data['observacion_reasignacion_girs'],
            // 'girs_auditor' => $data['girs_auditor'],
            'pertinencia_prioridad' => $data['pertinencia_prioridad'],
            'pertinencia_evaluacion' => $data['pertinencia_evaluacion'],
            'respuesta' => $data['respuesta'],
            'user_responde_id' => auth()->user()->id,
            // 'estado_id' => ($data['girs_auditor'] ? 10 : 9)
            'estado_id' => 9
        ]);
    }

    public function listarTeleapoyosGirs($data)
    {
        $girs =   $this->model->whereListarGirs()->orderBy('teleapoyos.created_at', 'ASC');
        return $data->page ? $girs->paginate($data->cantidad) : $girs->get();
    }

    public function listarTeleapoyoJuntaProfesional($data)
    {
        $girs =   $this->model->whereListarJuntaProfesional()->orderBy('teleapoyos.created_at', 'ASC');
        return $data->page ? $girs->paginate($data->cantidad) : $girs->get();
    }

    public function listarSolucionados($data)
    {

        $busquedaAfiliado = $data['afiliado'];
        $paginacion = $data['paginacion'];
        $filtros = $data['filtros'];

        $afiliado = Afiliado::where('numero_documento', $busquedaAfiliado['numero_documento'])
            ->where('tipo_documento', $busquedaAfiliado['tipo_documento'])
            ->first();

        if (!$afiliado) {
            return [
                'message' => 'No se encontró un afiliado existente con los datos proporcionados.',
                'status' => false
            ];
        }

        $teleapoyos = $this->model->with(['afiliado.ips', 'especialidad', 'tipoSolicitud', 'userCrea.operador'])
            ->where('afiliado_id', $afiliado->id)
            ->where('estado_id', 9)
            ->when($filtros['fecha_inicio'] && $filtros['fecha_fin'], function ($query) use ($filtros) {
                $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);
            })
            ->when($filtros['tipo_solicitud_id'], function ($query) use ($filtros) {
                $query->where('tipo_solicitudes_id', $filtros['tipo_solicitud_id']);
            })
            ->when($filtros['especialidad_id'], function ($query) use ($filtros) {
                $query->where('especialidad_id', $filtros['especialidad_id']);
            })
            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

        return [
            'message' => 'Se obtuvieron ' . $teleapoyos->total() . ' resultados.',
            'status' => true,
            'teleapoyos' => $teleapoyos
        ];
    }

    public function contador()
    {
        $pendientes = $this->model::where('estado_id', 10)->count();
        $solucionadas = $this->model::where('estado_id', 9)->count();
        $total = $this->model::whereIn('estado_id', [9, 10])->count();

        return [
            'pendientes' => $pendientes,
            'solucionados' => $solucionadas,
            'total' => $total
        ];
    }

    public function reporte($data)
    {
        $appointments = Collect(DB::select("exec dbo.Export_Teleapoyo ?,?", [$data['fecha_inicial'], $data['fecha_final']]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('Teleapoyo.xls');
    }

    /**
     * Busca el registro por el id
     * @param $teleapoyoId
     * @return object Teleapoyo
     * @author Thomas Restrepo
     */
    public function buscarTeleapoyo($teleapoyoId)
    {
        $data = $this->model::where('id', $teleapoyoId)->with(['afiliado.ips', 'afiliado.tipoDocumento', 'afiliado.entidad', 'afiliado.tipo_afiliacion', 'afiliado.tipo_afiliado', 'especialidad', 'userCrea.operador', 'tipoSolicitud', 'cie10s', 'adjuntos', 'afiliado.departamento_atencion', 'afiliado.municipio_atencion', 'afiliado.EstadoAfiliado', 'afiliado.colegios', 'afiliado.medico.operador', 'afiliado.medico2.operador'])->first();
        return $data;
    }
}
