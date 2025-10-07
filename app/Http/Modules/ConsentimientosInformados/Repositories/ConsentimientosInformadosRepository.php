<?php

namespace App\Http\Modules\ConsentimientosInformados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConsentimientosInformados\Models\ConsentimientosInformado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsentimientosInformadosRepository extends RepositoryBase
{


    public function __construct(protected ConsentimientosInformado $consentimientosInformadoModel, protected OrdenProcedimiento $ordenProcedimientoModel, protected Consulta $consultaModel)
    {
        parent::__construct($this->consentimientosInformadoModel, $this->ordenProcedimientoModel);
    }

    /**
     * listar
     *
     * @param  string $anexo
     * @return mixed
     * @author jdss
     */
    public function listarConsentimientos()
    {
        $consentimientos = $this->consentimientosInformadoModel->select(
            'nombre',
            'descripcion',
            'beneficios',
            'riesgos',
            'alternativas',
            'riesgo_no_aceptar',
            'informacion',
            'recomendaciones',
            'codigo',
            'fecha_aprobacion',
            'version',
            'estado',
            'laboratorio',
            'odontologia',
            'cup_id'
        );
        return $consentimientos->get();
    }

    public function consultarConsentimiento($datos)
    {
        $consentimiento = $this->consentimientosInformadoModel->where('cup_id', $datos['id'])->where('estado',true)->first();
        if ($consentimiento) {
            return (object)[
                'respuesta' => true,
                'consentimiento' => $consentimiento,
            ];
        } else {
            return  (object)[
                'respuesta' => false
            ];
        }
    }

    /**
     * Lista los consentimientos asociados al array de cups ids entregados
     * @param array $ids
     * @return ConsentimientosInformado[]|\Illuminate\Database\Eloquent\Collection
     */
    public function consultarConsentimientosGrupoProcedimientos(array $ids){
       return $this->consentimientosInformadoModel->select('nombre','descripcion','beneficios','riesgos','alternativas','riesgo_no_aceptar','informacion','recomendaciones','version','codigo','fecha_aprobacion','estado','cup_id','odontologia')->whereIn('cup_id',$ids)->where('laboratorio',false)->get();
    }

    public function crearConsentimiento($data)
    {
        foreach ($data['cupId'] as  $cup_id) {
            // $this->cie10AfiliadoRepository->crearCie10Paciente($cie10,$consulta->id,$key);
            $this->consentimientosInformadoModel->create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'beneficios' => $data['beneficios'],
                'riesgos' => $data['riesgos'],
                'alternativas' => $data['alternativas'],
                'riesgo_no_aceptar' => $data['riesgo_no_aceptar'],
                'recomendaciones' => $data['recomendaciones'],
                'informacion' => $data['informacion'],
                'cup_id' => $cup_id,
                'fecha_aprobacion' => $data['fecha_aprobacion'],
                'version' => $data['version'],
                'codigo' => $data['codigo'],
                'laboratorio' => $data['laboratorio'],
                'odontologia' => $data['odontologia'],
            ]);
        }
    }

    public function actualizarEstadoConsentimiento($codigoFormato)
    {
        $consulta = $this->consentimientosInformadoModel->where('codigo',$codigoFormato)->update([
            'estado' => DB::raw('NOT estado')
        ]);
        return $consulta;
    }

    public function listarConsentimientosHistorico($request)
    {


        switch ($request['tipo_consentimiento']) {
            case 'telemedicina':
                $consulta =  Consulta::select([
                    'firma_consentimiento',
                    'id',
                    'afiliado_id',
                    'firma_consentimiento_time',
                    'medico_ordena_id'
                ])->with([
                    'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,edad_cumplida,numero_documento',
                    'medicoOrdena.operador'
                ])
                    ->whereNotNull('firma_consentimiento')
                    ->where('especialidad_id','<>',14)
                    ->where('consultas.estado_id', 9);
                if (!empty($request['documento'])) {
                    $consulta->whereHas('afiliado', function ($query) use ($request) {
                        $query->where('numero_documento', $request['documento']);
                    });
                }
                break;
            case 'consentimientos_anestesia':
                $consulta =  Consulta::select([
                    'firma_consentimiento',
                    'id',
                    'afiliado_id',
                    'firma_consentimiento_time',
                    'medico_ordena_id'
                ])->with([
                    'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,edad_cumplida,numero_documento',
                    'medicoOrdena.operador'
                ])
                    ->whereNotNull('aceptacion_consentimiento')
                    ->where('especialidad_id',14)
                    ->where('consultas.estado_id', 9)
                    ->orderBy('id','desc');
                if (!empty($request['documento'])) {
                    $consulta->whereHas('afiliado', function ($query) use ($request) {
                        $query->where('numero_documento', $request['documento']);
                    });
                }
                break;
                
            case 'consentimiento_de_consulta':

                $consulta =  $this->ordenProcedimientoModel
                    ->whereHas('cup.consentimientoInformado', function ($query) {
                        $query->where('laboratorio', false)
                        ->orWhereNull('laboratorio');
                    })
                    ->with([
                        'orden:id,consulta_id',
                        'orden.consulta:id,cita_id,medico_ordena_id,afiliado_id',
                        'orden.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento',
                        'orden.consulta.cita:id,nombre',
                        'orden.consulta.medicoOrdena:id',
                        'orden.consulta.medicoOrdena.operador:id,user_id,nombre,apellido',
                        'cup:id,codigo,nombre',
                    ])
                    ->whereIn('aceptacion_consentimiento',['Si','No'])
                    ->select([
                        'id',
                        'orden_id',
                        'cup_id',
                        'firma_consentimiento',
                        'firma_discentimiento',
                        'fecha_firma_discentimiento',
                        'aceptacion_consentimiento',
                        'firmante',
                        'numero_documento_representante',
                        'declaracion_a',
                        'declaracion_b',
                        'declaracion_c',
                        'nombre_profesional',
                        'nombre_representante',
                        'fecha_firma'
                    ]);


                if (!empty($request['documento'])) {
                    $consulta->whereHas('orden.consulta.afiliado', function ($query) use ($request) {
                        $query->where('numero_documento', $request['documento']);
                    });
                }

                break;
            case 'consentimientos_de_laboratorio':
                $consulta =  $this->ordenProcedimientoModel
                    ->whereHas('cup.consentimientoInformado', function ($query) {
                        $query->where('laboratorio', true);
                    })
                    ->with([
                        'orden:id,consulta_id',
                        'orden.consulta:id,cita_id,medico_ordena_id,afiliado_id',
                        'orden.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento',
                        'orden.consulta.cita:id,nombre',
                        'orden.consulta.medicoOrdena:id',
                        'orden.consulta.medicoOrdena.operador:id,user_id,nombre,apellido',
                        'cup:id,codigo,nombre',
                        'cup.consentimientoInformado:id,cup_id,laboratorio',
                    ])
                    ->whereIn('aceptacion_consentimiento',['Si','No'])
                    ->select([
                        'id',
                        'orden_id',
                        'cup_id',
                        'firma_consentimiento',
                        'firma_discentimiento',
                        'fecha_firma_discentimiento',
                        'aceptacion_consentimiento',
                        'firmante',
                        'numero_documento_representante',
                        'declaracion_a',
                        'declaracion_b',
                        'declaracion_c',
                        'nombre_profesional',
                        'nombre_representante',
                        'fecha_firma'
                    ]);

                if (!empty($request['documento'])) {
                    $consulta->whereHas('orden.consulta.afiliado', function ($query) use ($request) {
                        $query->where('numero_documento', $request['documento']);
                    });
                }
                break;
            case 'consentimientos_manuales':
                $consulta = $this->consultaModel
                ->whereHas('cargueHistoriaContingencia',function($query){
                    $query->where('tipo_archivo_id',3);
                })
                ->with('afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento',
                'cargueHistoriaContingencia.funcionarioCarga:id',
                'cargueHistoriaContingencia.funcionarioCarga.operador:id,user_id,nombre,apellido')
                ->orderBy('id','desc');
                
                if (!empty($request['documento'])) {
                    $consulta->whereHas('afiliado', function ($query) use ($request) {
                        $query->where('numero_documento', $request['documento']);
                    });
                }
                break;
        }

        return $consulta->paginate($request['cantidad']);
    }

    public function guardarFirma(int $id, array $data)
    {
        $ordenProcedimiento = $this->ordenProcedimientoModel->find($id);
        $now = now();
        return $ordenProcedimiento->update([
            'firma_discentimiento' => $data['firma'],
            'fecha_firma_discentimiento' => $now,
            'nombre_profesional' => $data['nombre_profesional'],
        ]);
    }

    /**
     * Lista los consentimientos que esten relacionados con un laboratorio
     * @return mixed 
     */
    public function listarConsentimientosLaboratorio()
    {
        return $this->consentimientosInformadoModel->where('laboratorio', true)->get();
    }

    /**
     * Obtiene consentimiento informado por id
     * @param int $id
     * @return ConsentimientosInformado|ConsentimientosInformado[]|Model|\Illuminate\Database\Eloquent\Collection|null
     */
    public function obtenerConsentimiento(int $id)
    {
        return $this->consentimientosInformadoModel->find($id);
    }

    /**
     * Obtiene los consentimientos asociados segun el codigo del formato del consentimiento informado asociado
     * @param mixed $codigoConsentimiento
     * @return ConsentimientosInformado[]|\Illuminate\Database\Eloquent\Collection
     * @author AlejoSR
     */
    public function obtenerConsentimientoCodigo($codigoConsentimiento)
    {
        return $this->consentimientosInformadoModel->where('codigo',$codigoConsentimiento)->get();
    }


    /**
     * Actualiza los datos asociados a un formato de consentimiento informado a excepcion del CUP
     * @param mixed $codigo
     * @param mixed $data
     * @return 
     */
    public function actualizarFormato($codigo,$data)
    {
        return $this->consentimientosInformadoModel->where('codigo',$codigo)->update(
            [
                'nombre'=>$data['nombre'],
                'descripcion'=>$data['descripcion'],
                'beneficios'=>$data['beneficios'],
                'riesgos'=>$data['riesgos'],
                'alternativas'=>$data['alternativas'],
                'riesgo_no_aceptar'=>$data['riesgo_no_aceptar'],
                'informacion'=>$data['informacion'],
                'recomendaciones'=>$data['recomendaciones'],
                'version'=>$data['version'],
                'fecha_aprobacion'=>$data['fecha_aprobacion'],
                'estado'=>$data['estado'],
                'laboratorio'=>$data['laboratorio'],
                'odontologia'=>$data['odontologia'],
            ]);
    }

    /**
     * Consulta el registro de cups asociados a un consentimiento informado segun el codigo del formato
     * @param mixed $codigoFormato
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function consultarCupFormato($codigoFormato)
    {
        return $this->consentimientosInformadoModel->select('cup_id')->with(['cup:id,codigo,nombre'])->where('codigo',$codigoFormato);
    }

    /**
     * Elimina el registro de un consentimiento informado segun el cup id
     * @param mixed $cupId
     * @return bool|null
     */
    public function eliminarCup($cupId)
    {
        return $this->consentimientosInformadoModel->where('cup_id',$cupId)->delete();
    }

}
