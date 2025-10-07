<?php

namespace App\Http\Modules\Ordenamiento\Repositories;


use App\Http\Modules\Consultas\Models\Consulta;
use Carbon\Carbon;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Movimientos\Models\Movimiento;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrdenArticuloRepository extends RepositoryBase
{

    public function __construct(
        protected OrdenArticulo $ordenModel,
        protected Consulta $consulta,
        protected Codesumi $codesumi,
        protected HistoriaClinica $historiaClinica,
        protected Cie10Afiliado $cie10Afiliado,
        protected Cie10 $cie10,
        protected ConsultaRepository $consultaRepository,
        protected Municipio $municipio,
        protected Rep $rep,
        protected Transcripcione $transcripcion,
        protected Orden $orden,
        protected Movimiento $movimiento,
    ) {
        parent::__construct($this->ordenModel);
    }


    public function calcularFecha($id)
    {
        $orden = $this->ordenModel->join('ordenes', 'orden_articulos.orden_id', 'ordenes.id')->where('orden_articulos.id', $id)->first();
        $fecha = Carbon::now();
        if ($orden->paginacion) {
            $paginacion = explode('/', $orden->paginacion);
            for ($i = intval($paginacion[0]); $i <= intval($paginacion[1]); $i++) {
                $anterior = $this->ordenModel->join('ordenes', 'orden_articulos.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', ($i - 1) . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                $o  =  $this->ordenModel->join('ordenes', 'orden_articulos.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', $i . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                if ($anterior) {
                    $fechaAnterior = Carbon::parse($anterior->fecha_vigencia);
                    $o->update([
                        'fecha_vigencia' => $fechaAnterior->addDays(28)
                    ]);
                } else {
                    $o->update([
                        'fecha_vigencia' => $fecha->addDays(0)
                    ]);
                }
            }
        } else {
            $orden->update(['fecha_vigencia' => $fecha->toDateTimeString()]);
        }
    }

    public function imprimirMedicamento($data)
    {
        return $this->ordenModel->select(
            'orden_articulos.orden_id',
            'orden_articulos.codesumi_id',
            'orden_articulos.estado_id',
            'orden_articulos.dosis',
            'orden_articulos.frecuencia',
            'orden_articulos.unidad_tiempo',
            'orden_articulos.duracion',
            'orden_articulos.meses',
            'orden_articulos.cantidad_mensual',
            'orden_articulos.cantidad_mensual_disponible',
            'orden_articulos.cantidad_medico',
            'orden_articulos.observacion',
            'orden_articulos.fecha_vigencia',
            'orden_articulos.autorizacion',
            'orden_articulos.created_at',
            'orden_articulos.updated_at',
            'orden_articulos.mipres'
        )
            ->where('orden_articulos.orden_id', $data['orden_id'])
            ->whereIn('orden_articulos.estado_id', [1, 14])->get();
    }

    public function obtenerOrden($orden_id)
    {

        return $this->ordenModel->select('orden_articulos.codesumi_id', 'orden_articulos.fecha_vigencia', 'ordenes.estado_id')
            ->join('ordenes', 'ordenes.id', 'orden_articulos.orden_id')
            ->where('orden_articulos.orden_id', $orden_id)->first();
    }

    public function historicoMedicamentos($data)
    {
        $sumarMeses = strtotime('+6 months', strtotime(date('Y-m')));
        $fecha6Despues = date('Y-m-d', $sumarMeses);
        $restaMeses = strtotime('-6 months', strtotime(date('Y-m')));
        $fechaHace6 = date('Y-m-t', $restaMeses);

        $consulta = $this->consultaRepository->consulta($data['consulta_id']);

        return $this->ordenModel::select(
            'c.afiliado_id',
            'orden_articulos.id',
            'orden_articulos.codesumi_id'
        )
            ->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados', 'afiliados.id', 'c.afiliado_id')
            ->distinct()
            ->where('o.tipo_orden_id', 1)
            ->where('c.afiliado_id', $consulta->afiliado_id)
            ->whereBetween('orden_articulos.fecha_vigencia', [$fechaHace6, $fecha6Despues])
            ->get();
    }

    public function MedicamentosCronicos6meses($data)
    {
        $fechaActual = new \DateTime();
        //        $fecha6Despues = (clone $fechaActual)->modify('+6 months')->format('Y-m-d');
        $fechaHace90 = (clone $fechaActual)->modify('-90 days')->format('Y-m-d');

        $consulta = $this->consultaRepository->consulta($data['consulta_id']);

        return $this->ordenModel::select(
            'c.afiliado_id',
            'orden_articulos.codesumi_id',
            'orden_articulos.meses',
            DB::raw("operadores.nombre || ' ' || operadores.apellido as operador_nombre_completo")
        )
            ->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados', 'afiliados.id', 'c.afiliado_id')
            ->join('operadores', 'operadores.user_id', '=', 'o.user_id')
            ->distinct()
            ->where('o.tipo_orden_id', 1)
            ->where('orden_articulos.meses', '>', 1)
            ->where('c.afiliado_id', $consulta->afiliado_id)
            ->where('orden_articulos.fecha_vigencia', '>=', $fechaHace90)
            ->get();
    }

    public function historicoOrden6meses($data)
    {
        $sumarMeses = strtotime('+6 months', strtotime(date('Y-m')));
        $fecha6Despues = date('Y-m-d', $sumarMeses);
        $restaMeses = strtotime('-6 months', strtotime(date('Y-m')));
        $fechaHace6 = date('Y-m-t', $restaMeses);
        $consulta = Consulta::find($data['consulta']);

        return $this->ordenModel::select(
            'o.id as orden',
            'orden_articulos.id as ordenArticulo',
            'o.paginacion',
            'c.id as consulta',
            'orden_articulos.codesumi_id',
            'c.tipo_consulta_id',
            'orden_articulos.dosis',
            'orden_articulos.frecuencia',
            'orden_articulos.unidad_tiempo',
            'orden_articulos.fecha_vigencia',
            'c.afiliado_id',
            'c.fecha_hora_inicio',
            'orden_articulos.duracion',
            'orden_articulos.observacion',
            'orden_articulos.cantidad_medico',
            'orden_articulos.estado_id',
            'orden_articulos.unidad_tiempo',
            'orden_articulos.meses',
            'orden_articulos.rep_id',
            'e.nombre as estado'
        )->with(['codesumi.medicamentos'])
            ->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados', 'afiliados.id', 'c.afiliado_id')
            ->join('estados as e', 'e.id', 'orden_articulos.estado_id')
            ->where('o.tipo_orden_id', 1)
            //            ->where('orden_articulos.codesumi_id', $data['codesumi_id'])
            ->where('c.afiliado_id', $consulta->afiliado_id)
            ->whereBetween('orden_articulos.fecha_vigencia', [$fechaHace6, $fecha6Despues])
            ->orderBy('o.id', 'desc')
            ->get();
    }

    public function actualizarRep($data)
    {
        if (is_array($data->id)) {
            foreach ($data->id as $id) {
                $this->ordenModel::find($id)->update(['rep_id' => $data['rep_id']]);

                CambiosOrdene::create([
                    'orden_articulo_id' => $id,
                    'observacion' => 'Se realiza actualización de direccionamiento',
                    'accion' => 'Actualización de direccionamiento',
                    'user_id' => Auth::id(),
                ]);
            }
            return true;
        } else {
            return $this->ordenModel::find($data['id'])->update(['rep_id' => $data['rep_id']]);

            CambiosOrdene::create([
                'orden_articulo_id' => $data['id'],
                'observacion' => 'Se realiza actualización de direccionamiento',
                'accion' => 'Actualización de direccionamiento',
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function listarSuspension($ordenArticuloId)
    {
        return $this->ordenModel::with('funcionarioSuspende.operador')->findOrFail(intval($ordenArticuloId));
    }

    public function parametrizarDomicilio($ordenArticuloId, $request): OrdenArticulo
    {
        $ordenArticulo = $this->ordenModel::find($ordenArticuloId);

        $ordenArticulo->update([
            'domicilio' => $request['domicilio'],
            'tipo_domicilio' => $request['tipo_domicilio'],
        ]);
        $ordenArticulo->save();

        return $ordenArticulo;
    }

    /**
     * buscarOrdenArticulo
     * listar las ordenes que tienen estado 45, es decir que estan marcadas como mipres desde el 1 de enero
     * de 2025 en adelante
     * @param  mixed $data,
     * @return void
     * @author Serna
     */
    public function buscarOrdenArticulo($data)
    {
        $ordenArticulo = $this->ordenModel::with([
            'orden.consulta.afiliado:id,primer_nombre,primer_apellido,segundo_nombre,segundo_apellido,tipo_documento,numero_documento,departamento_afiliacion_id,ips_id,entidad_id',
            'orden.consulta.afiliado.departamento_afiliacion:id,nombre',
            'orden.consulta.afiliado.tipoDocumento:id,nombre',
            'orden.consulta.afiliado.entidad:id,nombre',
            'estado:id,nombre',
            'orden.consulta.afiliado.ips:id,nombre',
            'orden.funcionario.operador:user_id,nombre,apellido',
        ])
        ->whereIn('orden_articulos.estado_id', $data['estado'])
        ->where('orden_articulos.created_at', '>=', '2025-01-01 00:00:00')
        ->orderBy('id','desc')
        ->when($data['entidad_id'], function ($query) use ($data) {
            $query->whereHas('orden.consulta.afiliado', function ($q) use ($data) {
                $q->where('entidad_id', $data['entidad_id']);
            });
        });

        $ordenArticulo->when(isset($data['orden_id']), function ($query) use ($data) {
            $query->where('orden_articulos.orden_id', $data['orden_id']);
        })
        ->when(isset($data['articulo']), function ($query) use ($data) {
            $query->where('orden_articulos.codesumi_id', $data['articulo']);
        })
        ->when(isset($data['operadorNombre']), function ($query) use ($data) {
            $query->whereHas('orden', function ($q) use ($data) {
                $q->where('user_id', $data['operadorNombre']);
            });
        })
        ->when(isset($data['mes']), function ($query) use ($data) {
            $mesInicio = $data['mes'] . '-01 00:00:00.000';
            $mesFin = date('Y-m-t 23:59:59.999', strtotime($mesInicio));
            $query->whereBetween('orden_articulos.created_at', [$mesInicio, $mesFin]);
        })
        ->when(isset($data['ips']), function ($query) use ($data) {
            $query->whereHas('orden.consulta.afiliado.ips', function ($q) use ($data) {
                $q->where('id', $data['ips']);
            });
        })
        ->when(isset($data['departamento']), function ($query) use ($data) {
            $query->whereHas('orden.consulta.afiliado.departamento_afiliacion', function ($q) use ($data) {
                $q->where('id', $data['departamento']);
            });
        })
        ->when(isset($data['numero_documento']), function ($query) use ($data) {
            $query->whereHas('orden.consulta.afiliado', function ($q) use ($data) {
                $q->where('numero_documento', $data['numero_documento']);
            });
        });


        return $ordenArticulo->paginate($data["cantidad"]);
    }

    public function anexo3medicamentos($request)
    {
        $ordenArticulo = $this->ordenModel->where('id', $request['ordenamiento_id'])->first();

        $afiliado = $ordenArticulo->orden->consulta->afiliado;

        $consulta = $this->consulta->where('id', $ordenArticulo->orden->consulta->id)->first();

        $codesumi = $this->codesumi->where('id', $ordenArticulo->codesumi_id)->first();

        $historiaClinica = $this->historiaClinica->where('consulta_id', $consulta->id)->first();

        $cie10DiagnosticoPpal = $this->cie10Afiliado->where('consulta_id', $consulta->id)
            ->where('esprimario', true)
            ->first();

        $cie10 = $cie10DiagnosticoPpal ? $this->cie10->find($cie10DiagnosticoPpal->cie10_id) : null;

        $cie10DiagnosticoRelacionado = $this->cie10Afiliado->where('consulta_id', $consulta->id)
            ->where('esprimario', false)
            ->first();

        $cie10Relacionado = $cie10DiagnosticoRelacionado ? $this->cie10->find($cie10DiagnosticoRelacionado->cie10_id) : null;


        return (object)[
            'ordenArticulo' => $ordenArticulo,
            'afiliado' => $afiliado,
            'consulta' => $consulta,
            'codesumi' => $codesumi,
            'historiaClinica' => $historiaClinica,
            'cie10DiagnosticoPpal' => $cie10DiagnosticoPpal,
            'cie10' => $cie10,
            'cie10DiagnosticoRelacionado' => $cie10DiagnosticoRelacionado,
            'cie10Relacionado' => $cie10Relacionado,
        ];
    }

    public function formatoNegacion($detalle)
    {
        $ordenArticulo = $this->ordenModel->with('rep')->where('id', $detalle['id'])->first();
        return $ordenArticulo;
    }

    public function medicamentoPendiente($orden_id)
    {
        $orden = $this->orden->with(
            'consulta',
            'consulta.afiliado',
            'consulta.afiliado.departamento_atencion',
            'consulta.afiliado.municipio_atencion',
            'consulta.afiliado.ips',
            'consulta.medicoOrdena.operador',
            'funcionario.operador',
        )->where('id', $orden_id)->first();

        $ordenesArticulos = $this->ordenModel->where('orden_articulos.orden_id', $orden->id)
            ->whereIn('estado_id', [10, 18])
            ->get();

        $cie10s = $this->cie10Afiliado->select('cie10s.codigo_cie10')
            ->join('cie10s', 'cie10s.id', 'cie10_afiliados.cie10_id')
            ->where('cie10_afiliados.consulta_id', $orden->consulta->id)
            ->get()->toArray();

        $proveedor = null;
        $municipioPrestador = null;

        if (!empty($orden->rep_id)) {
            $proveedor = $this->rep->where('id', $orden->rep_id)->first();
            if (isset($proveedor)) {
                $municipioPrestador = $this->municipio->select('municipios.nombre as mNombre', 'departamentos.nombre as dNombre')->join('departamentos', 'departamentos.id', 'municipios.departamento_id')->where('municipios.id', $proveedor->municipio_id)->first();
            }
        }

        $transcripcion = null;
        if ($orden->consulta->tipo_consulta_id === 1) {
            $transcripcion = $this->transcripcion->with('prestador')->where('consulta_id', $orden->consulta->id)->first();
        }

        return (object)[
            'orden' => $orden,
            'cie10s' => $cie10s,
            'proveedor' => $proveedor,
            'municipioPrestador' => $municipioPrestador,
            'ordenesArticulos' => $ordenesArticulos,
            'transcripcion' => $transcripcion,
        ];
    }

    public function medicamentoDispensado($request)
    {

        $ordenArticulo = $this->ordenModel->with(
            'orden',
            'orden.consulta',
            'orden.consulta.afiliado',
            'orden.consulta.afiliado.departamento_atencion',
            'orden.consulta.afiliado.municipio_atencion',
            'orden.consulta.afiliado.ips',
            'codesumi',
        )
            ->where('id', $request->detalles['id'])->first();

        $cie10s = $this->cie10Afiliado->select('cie10s.codigo_cie10')->join('cie10s', 'cie10s.id', 'cie10_afiliados.cie10_id')->where('cie10_afiliados.consulta_id', $ordenArticulo->orden->consulta->id)->get()->toArray();

        $medico = $ordenArticulo->orden->funcionario->operador;

        /*
            - Las variables proveedor y municipioPrestador se definen nulas ya que si no entran a la condicion no van a tener data de las consultas
        */
        $proveedor = null;

        $municipioPrestador = null;

        if ($ordenArticulo->rep_id) {
            $proveedor = $ordenArticulo->rep;
            if ($proveedor) {
                $municipioPrestador = $this->municipio->select('municipios.nombre as mNombre', 'departamentos.nombre as dNombre')->join('departamentos', 'departamentos.id', 'municipios.departamento_id')->where('municipios.id', $proveedor->municipio_id)->first();
            }
        }

        $repId = null;

        /*
            - Se conculta tambien directamente al modelo consultas para no tener ir desde ordenArticulo
        */

        $consulta = $this->consulta->where('id', $ordenArticulo->orden->consulta->id)->first();

        $afiliado = $consulta->afiliado;

        $transcripcion = $this->transcripcion->where('consulta_id', $consulta->id)->first();

        /*
            - Tipo de consulta entra a una transcripcion
            - En rep id se condiciona si trae el nombre de la sede
            - Entra a traer el nombre del rep pero desde consultas hasta el consultorio
        */

        if ($consulta->tipo_consulta_id == 1) {
            $transcripcion = $consulta->transcripcion;
            if ($transcripcion && $transcripcion->sede) {
                $repId = $transcripcion->sede->nombre;
            } elseif ($consulta->tipo_consulta_id == 2 && $consulta->rep && $consulta->rep->nombre) {
                $repId = $consulta->rep->nombre;
                dd($repId);
            } elseif ($consulta->tipo_consulta_id == 8 && $consulta->agenda && $consulta->agenda->consultorio && $consulta->agenda->consultorio->rep) {
                $repId = $consulta->agenda->consultorio->rep->nombre;
            }
        }

        /*
           - Movimientos del dia buscado directamente desde la consulta de movimientos ($movimiento)

        */

        $movimiento = $this->movimiento->with(['detalleMovimientos', 'ordenArticulo.codesumi'])->where('id', $request->detalles['movimiento'])->first();

        $movimientosDia = $movimiento->whereDate('created_at', $movimiento->created_at)->where('orden_id', $ordenArticulo->orden->id)->get();

        return (object)[
            'ordenArticulo' => $ordenArticulo,
            'cie10s' => $cie10s,
            'medico' => $medico,
            'proveedor' => $proveedor,
            'consulta' => $consulta,
            'repId' => $repId,
            'transcripcion' => $transcripcion,
            'movimiento' => $movimiento,
            'afiliado' => $afiliado,
            'municipioPrestador' => $municipioPrestador,
            'movimientosDia' => $movimientosDia,
        ];
    }
    /**
     * verificarMipresCodesumi
     * Se verifica si un medicamento esta marcado como mipres para una entidad especifica
     * @param  mixed $request
     * @return void
     * @author Serna
     */
    public function verificarMipresCodesumi($request){

        return CodesumiEntidad::select('requiere_mipres')
        ->where('codesumi_id', $request->codesumi_id)
        ->where('entidad_id', $request->entidad_afiliado)
        ->first();
    }

    /**
     * Lista los articulos de una orden
     * @param int $ordenId
     * @return Collection
     * @author Thomas
     */
    public function listarArticulosPorAuditar(int $ordenId): Collection
    {
        return $this->ordenModel
            ->with(['codesumi','rep'])
            ->where('orden_id', $ordenId)
            ->where('estado_id', 3)
            ->get();
    }

    /**
     * Busca un articulo por su id de interoperabilidad
     * @param mixed $ordenArticuloInteroperabilidadId
     * @return OrdenArticulo
     * @author Thomas
     */
    public function buscarArticuloInteroperabilidad($ordenArticuloInteroperabilidadId):?OrdenArticulo
    {
        return $this->ordenModel->where('orden_articulo_id_interoperabilidad', $ordenArticuloInteroperabilidadId)->first();
    }
}
