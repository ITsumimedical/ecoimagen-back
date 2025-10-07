<?php

namespace App\Http\Modules\Referencia\Repositories;

use App\Formats\Anexo2;
use Illuminate\Http\Request;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Bases\RepositoryBase;
use App\Formats\HistoriaClinicaIntegralBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Referencia\AdjuntosReferencia\Repositories\AdjuntosReferenciaRepository;

class ReferenciaRepository extends RepositoryBase
{
    use ArchivosTrait;



    public function __construct(protected AdjuntosReferenciaRepository $AdjuntosReferenciaRepository, protected Referencia $referenciaModel )
    {
        parent::__construct($this->referenciaModel);
    }

    /**
     * cambiar el estado de una referencia
     *
     * @param  mixed $request
     * @param  mixed $id->estado_id
     * @return void
     * @author Manuela
     */
    public function cambiarEstado(Request $request, $estado_id)
    {
        $estado = Referencia::find($estado_id);
        $estado['estado_id'] = $request['estado_id'];

        $estado = $estado->update();
        return $estado;
    }

    /**
     * adjuntoReferencia
     *
     * @param  mixed $referencia
     * @param  mixed $data
     * @return void
     * @author kobatime
     */
    public function adjuntoReferencia($referencia,$data)
    {

        $ruta = '/adjuntosReferencia';

        $archivo = $data['adjuntohistoria'];
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombre = $referencia['id'] .'/'.time().'_'.$nombreOriginal;
        $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
        $this->AdjuntosReferenciaRepository->crearAdjunto($subirArchivo,$nombreOriginal,$referencia['id']);

        $archivo = $data['adjuntoRemision'];
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombre = $referencia['id'] .'/'.time().'_'.$nombreOriginal;
        $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
        $this->AdjuntosReferenciaRepository->crearAdjunto($subirArchivo,$nombreOriginal,$referencia['id']);

        if (isset($data['adjuntoOtros'])){
            foreach($data['adjuntoOtros'] as $archivoOtro){
                $nombreOriginal = $archivoOtro->getClientOriginalName();
                $nombre = $referencia['id'] .'/'.time().'_'.$nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                $this->AdjuntosReferenciaRepository->crearAdjunto($subirArchivo,$nombreOriginal,$referencia['id']);
            }
        }

        return true;
    }

/**
     * adjuntoReferencia
     *
     * @param  mixed $referencia
     * @param  mixed $data
     * @return void
     * @author kobatime
     */
    public function verificarAnexo($referencia)
    {
        $referencia = Referencia::find($referencia['id']);
        if($referencia->tipo_anexo == "2"){
            //creo consulta
             $consulta = Consulta::create([
                'finalidad' => 'Anexo 2',
                'afiliado_id' => $referencia->afiliado_id,
                'medico_ordena_id' => auth()->user()->id,
                'tipo_consulta_id' => 88
            ]);

            //creo orden
            $nuevaOrden = new Orden();
            $nuevaOrden->tipo_orden_id = 2;
            $nuevaOrden->consulta_id = intval($consulta['id']);
            $nuevaOrden->user_id = auth()->user()->id;
            $nuevaOrden->paginacion = null;
            $nuevaOrden->estado_id = 1;
            $nuevaOrden->save();

            //creo detalle de la orden
            $cupOrden = Cup::where('codigo','890701')->first();
            $nuevoProcedimiento = new OrdenProcedimiento();
            $nuevoProcedimiento->orden_id = $nuevaOrden->id;
            $nuevoProcedimiento->cup_id = $cupOrden->id;
            $nuevoProcedimiento->cantidad = 1;
            $nuevoProcedimiento->fecha_vigencia = now();
            $nuevoProcedimiento->observacion = null;
            $nuevoProcedimiento->rep_id = auth()->user()->reps_id;
            $nuevoProcedimiento->estado_id = 1;
            $nuevoProcedimiento->save();

            $referencia->update([
                'fecha_cierre' => date('Y-m-d H:i:s'),
                'tipo_solicitud' => 'Codigo atencion urgencias',
                'codigo_remision' => $nuevaOrden->id,
                'estado_id' => 17
            ]);
        }
        return true;

    }


    /**
     * listar Pedientes segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarPendientes($data){
        $pendientes = $this->referenciaModel->whereListarPendientes($data['anexo'],$data['documento'],
        $data['id'],$data['departamento'],$data['fechaFin'],$data['fechaInicio']);

        $return = $data->page ? $pendientes->paginate($data->cant) : $pendientes->get();
        return $return;
    }

    /**
     * listar Pedientes segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarProcesado($data){
        $pendientes = $this->referenciaModel->whereListarProcesados($data['anexo'],
        $data['documento'],$data['id'],$data['departamento'],$data['fechaFin'],$data['fechaInicio']);
        $return = $data->page ? $pendientes->paginate($data->cant) : $pendientes->get();
        return $return;
    }

    /**
     * listar seguimiento segun anexo
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listarSeguimiento($data){
        $pendientes = $this->referenciaModel->whereListarSegumiento($data['anexo'],
        $data['documento'],$data['id'],$data['departamento'],$data['fechaFin'],$data['fechaInicio']);
        $return = $data->page ? $pendientes->paginate($data->cant) : $pendientes->get();
        return $return;
    }


    /**
     * listar
     *
     * @param  string $anexo
     * @return JsonResponse
     * @author kobatime
     */
    public function listar($datos){
        $pendientes = $this->referenciaModel->WhereRep($datos->rep_id)->WhereAfiliado($datos->afiliado_id);
        return $pendientes->get();
    }

    public function listarPendientePrestador($request)
    {
        $pendientes = $this->referenciaModel->WhereRep(auth()->user()->reps_id,$request);
        return $request->page ? $pendientes->paginate($request->cant) : $pendientes->get();

    }

    public function listarProcesadoPrestador($request)
    {
        $pendientes = $this->referenciaModel->whereListarProcesadorPrestador($request->anexo,auth()->user()->reps_id,$request->documento);
        return $request->page ? $pendientes->paginate($request->cant) : $pendientes->get();
    }

    public function actualizarReferencia($referencia,$datos)
    {
        $consulta = $this->referenciaModel->where('id', $referencia->id)->first();
        if($consulta->estado_id == 10){

            $consulta->update([
                'tipo_solicitud' => $datos['tipo_solicitud'],
                'codigo_remision' => $datos['codigo_remision'],
                'tipo_anexo' => $datos['tipo_anexo'],
                'estado_id' => 19
            ]);
            return true;
        }
    }

    public function finalizarReferencia($referencia,$datos)
    {
        $consulta = $this->referenciaModel->where('id', $referencia->id)->first();
        $consulta->update([
            'estado_id' => 17,
            'fecha_cierre' => date('Y-m-d H:i:s')
        ]);
            return true;

    }

    public function countReferenciaPendientes()
    {
        $anexo10  = $this->referenciaModel->where('estado_id', 10)->whereIn('tipo_anexo',[10,'Contrareferencia'])->count();
        $anexo2 = $this->referenciaModel->where('estado_id', 10)->whereIn('tipo_anexo',[2,'Informe de la atención de urgencias'])->count();
        $anexo3 = $this->referenciaModel->where('estado_id', 10)->whereIn('tipo_anexo',[3,'Solicitud de autorización de servicios y tecnologías en salud'])->count();
        $anexo9 = $this->referenciaModel->where('estado_id', 10)->whereIn('tipo_anexo',[9,'Referencia'])->count();

        return [
            $anexo2,
            $anexo3,
            $anexo9,
            $anexo10
        ];
    }

    public function countReferenciaSeguimiento()
    {
        $anexo10  = $this->referenciaModel->where('estado_id', 19)->whereIn('tipo_anexo',[10,'Contrareferencia'])->count();
        $anexo2 = $this->referenciaModel->where('estado_id', 19)->whereIn('tipo_anexo',[2,'Informe de la atención de urgencias'])->count();
        $anexo3 = $this->referenciaModel->where('estado_id', 19)->whereIn('tipo_anexo',[3,'Solicitud de autorización de servicios y tecnologías en salud'])->count();
        $anexo9 = $this->referenciaModel->where('estado_id', 19)->whereIn('tipo_anexo',[9,'Referencia'])->count();

        return [
            $anexo2,
            $anexo3,
            $anexo9,
            $anexo10
        ];
    }

    public function countReferenciaProcesado() {
        $anexo10  = $this->referenciaModel->where('estado_id', 17)->whereIn('tipo_anexo',[10,'Contrareferencia'])->count();
        $anexo2 = $this->referenciaModel->where('estado_id', 17)->whereIn('tipo_anexo',[2,'Informe de la atención de urgencias'])->count();
        $anexo3 = $this->referenciaModel->where('estado_id',  17)->whereIn('tipo_anexo',[3,'Solicitud de autorización de servicios y tecnologías en salud'])->count();
        $anexo9 = $this->referenciaModel->where('estado_id', 17)->whereIn('tipo_anexo',[9,'Referencia'])->count();

        return [
            $anexo2,
            $anexo3,
            $anexo9,
            $anexo10
        ];
    }

    public function countReferenciaProcesadoPrestador() {
        $anexo10  = $this->referenciaModel->where('estado_id', 17)->where('referencias.rep_id',auth()->user()->reps_id)->whereIn('tipo_anexo',[10,'Contrareferencia'])->count();
        $anexo2 = $this->referenciaModel->where('estado_id', 17)->where('referencias.rep_id',auth()->user()->reps_id)->whereIn('tipo_anexo',[2,'Informe de la atención de urgencias'])->count();
        $anexo3 = $this->referenciaModel->where('estado_id',  17)->where('referencias.rep_id',auth()->user()->reps_id)->whereIn('tipo_anexo',[3,'Solicitud de autorización de servicios y tecnologías en salud'])->count();
        $anexo9 = $this->referenciaModel->where('estado_id', 17)->where('referencias.rep_id',auth()->user()->reps_id)->whereIn('tipo_anexo',[9,'Referencia'])->count();

        return [
            $anexo2,
            $anexo3,
            $anexo9,
            $anexo10
        ];
    }

    public function crearConsulta($request)  {
        //creo consulta
        $consulta = Consulta::create([
            'finalidad' => 'referencia',
            'afiliado_id' => $request['afiliado_id'],
            'medico_ordena_id' => auth()->user()->id,
            'tipo_consulta_id' => 88
        ]);
        return $consulta;

    }

    public function crearUrgencia($data){
        $datos = DB::connection('secondary')->table('afiliados')
        ->where('numero_documento',$data['afiliado_id'])->first();

        $admision = AdmisionesUrgencia::where('id',$data['admision']);
        // return $datos;
        if(!$admision->codigo_centro_regulador){
            return DB::connection('secondary')->table('referencias')->insertGetId([
                'tipo_anexo' => $data['tipo_anexo'],
                'especialidad_remision'=> $data['especialidad_remision'],
                'descripcion'=> $data['descripcion'],
                'afiliado_id'=> $datos->id,
                'rep_id'=> $data['rep_id'],
                'estado_id'=> $data['estado_id'],
                'user_id'=> $data['user_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return false;
        }

    }

    public function adjuntoReferenciaUrgencias($referencia,$data)
    {
        $pdf = new HistoriaClinicaIntegralBase();
       $subirArchivo= $pdf->generar($data['consulta'],null,true);
       $nombre = 'historia_triage_'.$data['consulta'].'pdf';
       $this->AdjuntosReferenciaRepository->crearAdjuntoUrgencia($subirArchivo,$nombre,$referencia);


       $pdf = new Anexo2();
       $subirArchivo= $pdf->generar($data['consulta'],true);
       $nombre = 'anexo tecnico'.$data['consulta'].'pdf';
       $this->AdjuntosReferenciaRepository->crearAdjuntoUrgencia($subirArchivo,$nombre,$referencia);

        // if (isset($data['adjuntoOtros'])){
        //     foreach($data['adjuntoOtros'] as $archivoOtro){
        //         $nombreOriginal = $archivoOtro->getClientOriginalName();
        //         $nombre = $referencia .'/'.time().'_'.$nombreOriginal;
        //         $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
        //         $this->AdjuntosReferenciaRepository->crearAdjuntoUrgencia($subirArchivo,$nombreOriginal,$referencia);
        //     }
        // }

        return true;
    }

    public function verificarAnexoUrgencia($referencia){
        DB::beginTransaction();
        try {
            $referenciaAnexo2 = $this->consultarReferencia($referencia);
            //creo consulta
            $consulta = $this->crearConsultaReferencia($referenciaAnexo2);
            //creo orden
            $orden =   $this->crearOrden($consulta,$referenciaAnexo2->user_id);
             //creo detalle de la orden
            $this->crearDetalleOrden($referenciaAnexo2->user_id,$orden);
            // actualizo la referencia
           $this->actualizarReferenciaSecundaria($referenciaAnexo2->id,$orden);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function consultarReferencia($referencia){
        return DB::connection('secondary')->table('referencias')->where('id',$referencia)->whereIn('tipo_anexo',[2,'Informe de la atención de urgencias'])->first();
    }

    public function crearConsultaReferencia($referencia){
        return DB::connection('secondary')->table('consultas')->insertGetId([
            'finalidad' => 'Anexo 2',
            'afiliado_id' => $referencia->afiliado_id,
            'medico_ordena_id' => $referencia->user_id,
            'tipo_consulta_id' => 88,
            'created_at' => now(),
            'updated_at' => now(),
            ]);
    }

    public function crearOrden($consulta,$usuario){
        return DB::connection('secondary')->table('ordenes')->insertGetId([
            'tipo_orden_id' => 2,
            'consulta_id' => $consulta,
            'user_id' => $usuario,
            'paginacion' => null,
            'estado_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            ]);
    }

    public function crearDetalleOrden($usuario,$orden){
        $cupOrden = DB::connection('secondary')->table('cups')->where('codigo','890701')->first();
        $user = DB::connection('secondary')->table('users')->where('id',$usuario)->first();
        return DB::connection('secondary')->table('orden_procedimientos')->insert([
        'orden_id' => $orden,
        'cup_id' => $cupOrden->id,
        'cantidad' => 1,
        'fecha_vigencia' => now(),
        'observacion' => null,
        'rep_id' => $user->reps_id,
        'estado_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
        ]);
    }

    public function actualizarReferenciaSecundaria($referencia_id,$orden){
       return DB::connection('secondary')->table('referencias')->where('id', $referencia_id)->update([
            'fecha_cierre' => date('Y-m-d H:i:s'),
            'tipo_solicitud' => 'Codigo atencion urgencias',
            'codigo_remision' => $orden,
            'estado_id' => 17,
            'updated_at' => now(),
        ]);
    }


}

