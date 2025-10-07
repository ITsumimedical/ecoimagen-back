<?php

namespace App\Http\Modules\Prestadores\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Prestadores\Models\Prestador;
use Illuminate\Support\Facades\Cache;

class PrestadorRepository extends RepositoryBase
{

    private $prestadorModel;

    public function __construct()
    {
        $this->prestadorModel = new Prestador();
        parent::__construct($this->prestadorModel);
    }

    /**
     * Se modifico la Funcion para mejorar el rendimiento y la optimizacion
     * de busqueda en el modulo cuentasMedicas/facturas cacheando la consulta
     * generando una clave unica por consulta con un tiempo de espera en la cache
     * de (1 Hora = 3600 segundos), donde por este lapzo de tiempo se cargara la consulta
     * guardad en cache, pasado el tiempo la primera consulta despues
     * del vencimiento de tiempo si hace consulta en la BD.
     */
    public function listarPrestadores($request)
    {
        $key = 'prestadores:listar:' . md5(json_encode($request->all()));

        return Cache::store('redis')->remember($key, 3600, function () use ($request) {

            $consulta = $this->prestadorModel
                ->with('municipio')
                ->WhereNombre($request->nombre)
                ->WhereNit($request->nit)
                ->wherePrestadorId($request->prestador_id)
                ->WhereCodigoHabilitacion($request->codigo_habilitacion)
                ->whereCodigoNombre($request->prestador)
                ->whereNombreNit($request->nombreNit);

            return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
        });
    }

    public function buscarPrestador($clave)
    {
        $clave = strtolower($clave);

        $key = 'prestadores:' . $clave;

        return Cache::store('redis')->remember($key, 1000, function () use ($clave) {
            return $this->prestadorModel
                ->where('nombre_prestador', 'ILIKE', '%' . $clave . '%')
                ->orWhere('nit', 'ILIKE', '%' . $clave . '%')
                ->get();
        });
    }


    /**
     * @param Request $request
     * @return Collection
     * @author kobatime
     */
    public function listarConfiltro($request)
    {
        return $this->model::select('departamentos.nombre as departamento', 'prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit')
            ->join('municipios', 'municipios.id', 'prestadores.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->where('prestadores.nit', 'ILIKE', '%' . $request->prestador . '%')->orWhere('prestadores.nombre_prestador', 'ILIKE', '%' . $request->prestador . '%')->get();
    }

    public function PrestadoresContractoActivo()
    {
        $entidades = json_decode(Auth::user()->entidad);
        $arrEntidades = array_column($entidades, 'id');
        $datos = $this->prestadorModel::select(
            'departamentos.nombre as departamento',
            'prestadores.id',
            'prestadores.nombre_prestador',
            'prestadores.nit'
        )
            ->join('contratos', 'contratos.prestador_id', 'prestadores.id')
            ->join('municipios', 'municipios.id', 'prestadores.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->join('entidades', 'entidades.id', 'contratos.entidad_id')
            ->whereIn('entidades.id', $arrEntidades)
            ->where('entidades.estado', true)
            ->get();
        return $datos;
    }

    public function acumuladoPrestador(array $data)
    {
        $q = DB::table('paquete_rips')
            ->join('reps', 'reps.id', '=', 'paquete_rips.rep_id')
            ->join('prestadores', 'prestadores.id', '=', 'reps.prestador_id')
            ->join('afs', 'afs.paquete_rip_id', '=', 'paquete_rips.id')
            ->leftJoin('asignado_cuentas_medicas as acm', 'acm.af_id', '=', 'afs.id')
            ->join('estados', 'estados.id', '=', 'paquete_rips.estado_id')
            ->where('paquete_rips.estado_id', 14)
            ->whereNull('afs.estado_id')
            // ->when(($data['fecha_inicio'] ?? null), fn($q, $fi) => $q->where('afs.created_at', '>=', $fi . ' 00:00:00'))
            // ->when(($data['fecha_final'] ?? null), fn($q, $ff) => $q->where('afs.created_at', '<=', $ff . ' 23:59:59'))
            // ->when(($data['prestador_id'] ?? null), fn($q, $pid) => $q->where('prestadores.id', $pid))
            ->select([
                'paquete_rips.id as paquete_id',
                'prestadores.id as prestador_id',
                'prestadores.nombre_prestador',
                'prestadores.nit',
                'paquete_rips.estado_id as estado_paquete',
                'estados.nombre as nombre_estado',
                'paquete_rips.entidad',
                'paquete_rips.nombre as nombre_paquete',
            ])
            ->selectRaw('COUNT(afs.id)                              AS total_facturas')
            ->selectRaw('SUM(CAST(afs.valor_neto AS float))         AS total_neto')
            ->selectRaw('COUNT(acm.af_id)                           AS facturas_asignadas')
            ->selectRaw('(COUNT(acm.af_id) > 0)::boolean            AS tiene_asignacion')
            ->groupBy(
                'paquete_rips.id',
                'prestadores.id',
                'prestadores.nombre_prestador',
                'prestadores.nit',
                'paquete_rips.estado_id',
                'estados.nombre',
                'paquete_rips.entidad',
                'paquete_rips.nombre'
            )
            ->orderByDesc('paquete_rips.id');

        if (isset($data['prestador_id'])) {
            $q->where('prestadores.id', $data['prestador_id']);
        }

        if (isset($data['nit'])) {
            $q->where('prestadores.nit', $data['nit']);
        }

        if (isset($data['nombre_paquete'])) {
            $q->where('paquete_rips.nombre', $data['nombre_paquete']);
        }

        return !empty($data['page'])
            ? $q->paginate($data['cantidad'] ?? 15)
            : $q->get();
    }

    public function auditadas($data)
    {
        $auditadas = $this->prestadorModel->whereAuditadas($data);
        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }


    /**
     * lista las facturas asignadas a un prestador para el modulo de cuentas medicas
     * @return $asignadas
     * @author JDSS
     */
    public function misAsignadas($data)
    {
        $permisos = Auth::user()->permissions;
        $permiso_id = [];
        foreach ($permisos as $permiso) {
            array_push($permiso_id, $permiso->id);
        }

        $asignadas = $this->prestadorModel->whereMisAsignadas($permiso_id, $data);

        return $data->page ? $asignadas->paginate($data->cantidad) : $asignadas->get();
    }

    public function auditoriaFinal($data)
    {
        $auditadas = $this->prestadorModel->whereAuditoriaFinal($data);
        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function conciliacionAuditoriaFinal($data)
    {
        $auditadas = $this->prestadorModel->whereConciliadasAuditoriaFinal($data);
        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function conciliacionConSaldo($data)
    {

        $auditadas = $this->prestadorModel->whereConciliadasConSaldo($data);

        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function auditoriaFinalCerradas($data)
    {

        $auditadas = $this->prestadorModel->whereAuditoriaFinalCerradas($data);

        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    /**
     * listarExternos -  lista los prestadores por similitud de nombre
     * evitando los códigos de habilitación de Sumimedical
     *
     * @param mixed $request
     * @return void
     */
    public function listarExternos($request)
    {
        $prestador = Prestador::select(
            'prestadores.id',
            'prestadores.codigo_habilitacion',
            'nombre_prestador',
            'municipios.nombre as municipio',
            'departamentos.nombre as departamento'
        )
            ->join('municipios', 'prestadores.municipio_id', 'municipios.id')
            ->join('departamentos', 'prestadores.municipio_id', 'departamentos.id')
            ->where('nombre_prestador', 'ILIKE', "%{$request->nombre}%")
            ->whereNotIn('codigo_habilitacion', ['0536009022', '2700101136', '6800170352'])
            ->get();

        return $prestador;
    }

    /**
     * listarInternos lista los prestadores por similitud de nombre
     * sólo apuntando a los códigos de habilitación sumimedical
     *
     * @param mixed $request
     * @return void
     */
    public function listarInternos($request)
    {
        $prestador = Prestador::select(
            'prestadores.id',
            'prestadores.codigo_habilitacion',
            'nombre_prestador',
            'municipios.nombre as municipio'
        )
            ->join('municipios', 'prestadores.municipio_id', 'municipios.id')
            ->where('nombre_prestador', 'ILIKE', "%{$request->nombre}%")
            ->whereIn('codigo_habilitacion', ['0536009022', '2700101136', '6800170352'])
            ->get();

        return $prestador;
    }

    /**
     * listarPrestadoresContratados - lista los prestadores activos con contrato activo
     *
     * @return void
     */
    public function listarPrestadoresContratados()
    {
        return Prestador::select(
            'prestadores.id',
            'prestadores.nombre_prestador',
            'prestadores.codigo_habilitacion',
            'prestadores.activo as estado_prestador',
            'contratos.activo as estado_contrato',
            'contratos.entidad_id',
            'entidades.nombre as entidad'
        )
            ->leftjoin('contratos', 'prestadores.id', 'contratos.id')
            ->leftjoin('entidades', 'contratos.entidad_id', 'entidades.id')
            ->where('contratos.activo', 1)
            ->where('prestadores.activo', 1)
            ->get();
    }

    /**
     * lista los prestadores aplicacion un filtro de busqueda o no
     * @param string $filtro
     */
    public function listarPrestadoresConFiltro(string $filtro = null)
    {
        return Prestador::select('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit', 'prestadores.municipio_id')
            ->whereFiltro($filtro) // si llega filtro
            ->with('municipio.departamento')
            ->get();
    }

    /**
     * Lista los prestadores que tenga contratados el usuario para los contratos de medicamentos
     * @param $data
     * @return Collection
     * @author Thomas
     */
    public function listarPrestadoresContratosMedicamentos($data): Collection
    {
        return $this->prestadorModel
            ->with(['municipio.departamento'])
            ->whereNotIn('tipo_prestador_id', [2])
            ->whereNombreNit($data['prestador'])
            ->get();
    }

    /**
     * Obtner el nit del prestador asociado a un servicio facturado
     *
     * @param $id de CobroServicio
     * @author Calvarez
     */
    public function obtenerPrestadorPorServicioFacturado(int $id)
    {
        $cobro = CobroServicio::with([
            'ordenProcedimiento.rep.prestador',
            'ordenProcedimiento.cup',
            'ordenCodigoPropio.codigoPropio.cup',
            'ordenCodigoPropio',
        ])->find($id);


        if (!$cobro) {
            return null;
        }

        // Prestador
        $prestador = $cobro->ordenProcedimiento?->rep?->prestador;

        if (
            is_null($cobro->orden_procedimiento_id) &&
            is_null($cobro->orden_codigo_propio_id) &&
            !$prestador
        ) {
            $cobro->load('consulta.rep.prestador', 'consulta.cup');
            $prestador = $cobro->consulta?->rep?->prestador;
        }

        // CUP y cantidad
        $cup = null;
        $cantidad = null;

        if (!is_null($cobro->orden_procedimiento_id)) {
            $cup = $cobro->ordenProcedimiento?->cup;
            $cantidad = $cobro->ordenProcedimiento?->cantidad;
        } elseif (!is_null($cobro->orden_codigo_propio_id)) {
            $cup = $cobro->ordenCodigoPropio?->codigoPropio?->cup;
            $cantidad = $cobro->ordenCodigoPropio?->cantidad;
        } elseif (!is_null($cobro->consulta_id)) {
            $cobro->loadMissing('consulta.cup');
            $cup = $cobro->consulta?->cup;
            $cantidad = 1; // Siempre 1 en consulta
        }

        return [
            'valor' => $cobro->valor,
            'cantidad' => $cantidad,
            'nit' => $prestador?->nit,
            'cup_id' => $cup?->id,
            'cup_codigo' => $cup?->codigo,
            'cup_nombre' => $cup?->nombre,
        ];
    }
}
