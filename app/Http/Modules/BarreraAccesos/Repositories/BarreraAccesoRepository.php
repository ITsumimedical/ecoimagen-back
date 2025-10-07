<?php

namespace App\Http\Modules\BarreraAccesos\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Bancos\Models\Banco;
use App\Http\Modules\BarreraAccesos\Models\BarreraAcceso;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class BarreraAccesoRepository extends RepositoryBase
{

    public function __construct(protected BarreraAcceso $barreraAccesoModel, protected Afiliado $afiliadoModel)
    {
        parent::__construct($barreraAccesoModel);
    }

    // public function listarBarrera($data)
    // {
    //     if ($data->cedula_paciente) {
    //         $entidades = json_decode(Auth::user()->entidad);
    //         $arrEntidades = array_column($entidades, 'id');
    //         $consultaAfiliado = $this->afiliadoModel->where('numero_documento', $data->cedula_paciente)
    //             ->whereIn('entidad_id', $arrEntidades)
    //             ->first();
    //         if (!$consultaAfiliado) {
    //             return ['error' => true, 'mensaje' => 'Este afiliado no se encuentra en la base de datos'];
    //         } else {
    //             $consulta =  $this->barreraAccesoModel
    //                 ->whereBarrera($data->barrera)
    //                 ->whereAfiliado($consultaAfiliado->id)
    //                 ->WhereReps($data->rep_id)
    //                 ->where('activo', 1);
    //             return $data->page ? $consulta->paginate() : $consulta->get();
    //         }
    //     } else {
    //         $consulta = $this->barreraAccesoModel
    //             ->with(['userCrea.operador', 'rep', 'afiliado'])
    //             ->whereBarrera($data->barrera)
    //             ->WhereReps($data->rep_id)
    //             ->where('activo', 1);
    //         return $data->page ? $consulta->paginate() : $consulta->get();
    //     }
    // }

    // public function crearBarrera($data)
    // {
    //     $nuevaBarrera = new BarreraAcceso();
    //     $nuevaBarrera->barrera = $data['barrera'];

    //     // Verifica si 'afiliado_id' está presente en los datos antes de asignarlo
    //     if (isset($data['afiliado_id'])) {
    //         $nuevaBarrera->afiliado_id = $data['afiliado_id'];
    //     }

    //     $nuevaBarrera->observacion = $data['observacion'];
    //     $nuevaBarrera->rep_id = $data['rep_id'];
    //     $nuevaBarrera->usercrea_id = Auth::id();
    //     $nuevaBarrera->tipo_barrera_acceso_id = $data['tipo_barrera_id'];
    //     $nuevaBarrera->save();

    //     return $nuevaBarrera;
    // }

    // public function actualizarBarrera($barrera_id, $data)
    // {
    //     $consulta = BarreraAcceso::where('id', $barrera_id)->first();

    //     $userCierra = auth()->user()->id;

    //     $consulta->update([
    //         'usercierra_id' => $userCierra,
    //         'observacion_cierre'  => $data['observacion_cierre'],
    //         'activo' => 0
    //     ]);
    //     // $data['usercierra_id'] = Auth::id();

    //     return true;
    // }

    /**
     * Crear barrera
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearBarrera(array $data)
    {
        return $this->barreraAccesoModel->create($data);
    }

    /**
     * Exporta (Reporte de barreras de acceso)
     * @param $data
     */
    public function exportar($data)
    {
        $appointments = collect(DB::select('SELECT * FROM fn_export_barreraacceso(?, ?)', [$data['fecha_inicial'], $data['fecha_final']]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('BarreraAcceso.xls');
    }

    /**
     * Listar las barreras pendientes
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarPendientes(array $data)
    {
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->where('estado_id', 10)
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Listar las barreras asignadas
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarAsignadas(array $data)
    {
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'responsables.areaResponsable',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereResponsablesBarrera($data['responsable_barrera_accesos_id'])
            ->whereIn('estado_id', [6, 15])
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Listar las barreras presolucionadas
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarPresolucionadas(array $data)
    {
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'responsables.areaResponsable',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereResponsablesBarrera($data['responsable_barrera_accesos_id'])
            ->where('estado_id', 18)
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Listar las barreras solucionadas - anulas
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarSolucionadasAnuladas(array $data)
    {
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'userCierra.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'responsables.areaResponsable',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereResponsablesBarrera($data['responsable_barrera_accesos_id'])
            ->whereIn('estado_id', [17, 5])
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Buscar Barrera de acceso por su id
     * @param int $id
     * @author Sofia O
     */
    public function buscarBarreraAcceso(int $id)
    {
        return $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'userCierra.operador'
            ])
            ->findOrFail($id);
    }

    /**
     * Actualizar barrera de acceso
     * @param $data
     * @param $barrera
     * @return $barrera
     * @author Sofia O
     */
    public function actualizarBarrera($data, $barrera)
    {
        return $barrera->update($data);
    }

    /**
     * Listar las barreras registradas por el user
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarBarrerasUser(array $data)
    {
        $user_id = auth()->user()->id;
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereUserId($user_id)
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Listar las barreras asignadas al user
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarAsignadasUser(array $data)
    {
        $user_id = auth()->user()->id;
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'responsables.areaResponsable',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereUserAsignadoBarrera($user_id)
            ->whereIn('estado_id', [6, 15])
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }

    /**
     * Listar las barreras solucionadas y anulas a las cuales el user es responsable
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarSolucionadasAnuladasUser(array $data)
    {
        $user_id = auth()->user()->id;
        $consulta =  $this->barreraAccesoModel
            ->with([
                'userCrea.operador',
                'userCierra.operador',
                'rep',
                'afiliado',
                'afiliado.tipoDocumento',
                'afiliado.ips:id,nombre',
                'afiliado.entidad:id,nombre',
                'afiliado.departamento_atencion',
                'responsables.areaResponsable',
                'adjuntos:id,nombre,ruta,barrera_id'
            ])
            ->whereBarreraAccesoId($data['id'])
            ->whereBarrera($data['barrera'])
            ->whereReps($data['rep_id'])
            ->whereNumeroDocumentoAfiliado($data['documento'])
            ->whereFechas($data['fecha_inicio'], $data['fecha_fin'])
            ->whereUserAsignadoBarrera($user_id)
            ->whereIn('estado_id', [17, 5])
            ->orderBy('created_at', 'desc');

        return (!empty($data['page']) && !empty($data['cant']))
            ? $consulta->paginate($data['cant'])
            : $consulta->get();
    }
}
