<?php

namespace App\Http\Modules\Reps\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Support\Facades\Cache;
use App\Http\Modules\Sedes\Models\Sede;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Modules\ImagenesContratoSedes\Services\ImagenesContratoSedesService;

class RepsRepository extends RepositoryBase
{

    protected $model;

    public function __construct(protected ImagenesContratoSedesService $imagenesContratoSedesService)
    {
        $this->model = new Rep();
        parent::__construct($this->model);
    }

    /**
     * @override
     * @param Request $request
     * @return Collection
     * @author David Peláez
     */
    public function listarFiltro($request)
    {
        $consulta = $this->model
            ->with(['prestadores', 'municipio'])
            ->whereNombre($request->nombre_prestador)
            ->wherePrestador($request->prestador_id)
            ->whereMunicipio($request->municipio_id)
            ->wherePacientes($request->pacientes)
            ->wherePropias($request->propias)
            ->whereNombreNit($request->prestador)
            ->whereOperador($request->operador)
            ->whereCirugia($request->cirugia)
            ->sinRelaciones($request->relacion)
            ->orderBy('nombre', 'asc')
            ->whereNombreNitProovedor($request->proveedor);
        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    /**
     * @override
     * @param Request $request
     * @return Collection
     * @author JDSS
     */
    public function listarConfiltro($request)
    {
        return $this->model->with('municipio')
            ->where(function ($query) use ($request) {
                $query->where('codigo_habilitacion', 'ILIKE', '%' . $request->rep . '%')
                    ->orWhere('nombre', 'ILIKE', '%' . $request->rep . '%');
            })
            ->orWhereHas('municipio', function ($query) use ($request) {
                $query->where('nombre', 'ILIKE', '%' . $request->rep . '%');
            })
            ->orderBy('nombre', 'asc')
            ->get();
    }


    /**
     * listarPropias - lista los reps los reps marcados como propios y la sede de talento humano
     * @param Request $request
     * @return Collection
     * @return void
     */
    public function listarPropias()
    {
        return Sede::select('sedes.nombre as sede', 'sedes.id', 'reps.nombre as rep', 'reps.id as rep_id')
            ->join('reps', 'sedes.rep_id', 'reps.id')
            ->where('reps.propia', true)
            ->get();
    }

    /**
     * Listar REPS y cacharlos con REDIS
     *
     * @return array
     * @author Calvarez
     */
    public function listarRepsCachados()
    {
        $cacheDuration = now()->addHours(10);

        return Cache::remember('reps', $cacheDuration, function () {
            return $this->model::select('id', 'codigo_habilitacion', 'codigo', 'nombre', 'propia', 'prestador_id')
                ->where('activo', true)
                ->get()
                ->toArray();
        });
    }

    /**
     * Buscar reps por código o nombre con la lista cacheada
     *
     * @param  mixed $codigoONombre
     * @return collection resultados del filtro
     * @author Calvarez
     */
    public function buscarPorCodigoONombre(string $codigoONombre)
    {
        $reps = $this->listarRepsCachados();

        // Filtrar los datos cacheados basados en el código o nombre
        return collect($reps)->filter(function ($rep) use ($codigoONombre) {
            return stripos($rep['codigo'], $codigoONombre) !== false ||
                stripos($rep['nombre'], $codigoONombre) !== false;
        })->values();
    }

    public function listarSedesUsuario($request)
    {
        $consulta = $this->model
            ->whereOperador($request->operador)
            ->select('id', 'nombre')
            ->get()
            ->makeHidden($this->model->getAppends());

        return $consulta;
    }

    /**
     * lista las sedes segun el prestador
     * @param string $prestador_id
     */
    public function listarPorPrestador($prestador_id)
    {
        return $this->model
            ->where('prestador_id', $prestador_id)
            ->with('municipio')
            ->get();
    }

    public function listarFarmaciasSumi()
    {
        return Rep::with(['prestadores', 'municipio'])
            ->where(function ($query) {
                $query->whereIn('prestador_id', [2389, 61622])
                    ->where('nombre', 'ILIKE', '%FARMACIA%');
            })->orWhere('id', 77475)
            ->get();
    }

    public function actualizarPrestador($rep_id, $prestador_id)
    {
        $rep = $this->model->findOrFail($rep_id);
        $rep->prestador_id = $prestador_id;
        $rep->save();
        return $rep;
    }

    function listarPorEntidad($user_id)
    {
        $entidadesUsuario = DB::table('entidad_users')
            ->where('user_id', $user_id)
            ->pluck('entidad_id')
            ->toArray();
        if (empty($entidadesUsuario)) {
            return collect();
        }
        return $this->model::select('reps.id', 'reps.nombre', 'reps.entidad_id')
            ->whereIn('reps.entidad_id', $entidadesUsuario)
            ->get();
    }

    public function consultarReps(array $data, int $id)
    {
        $consultar = $this->model->where('id', $id)->with('imagenes')->get();
        $imagen = $this->imagenesContratoSedesService->consultarImagen($id);
        return ['consulta' => $consultar, 'imagen' => $imagen];
    }

    public function buscarPorId(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Lita los reps para el cambio de direccionamiento de órdenes de servicios
     * @param array $data
     * @return Collection
     * @author Thomas
     */
    public function listarRepsDireccionamientoServicios(array $data): Collection
    {
        return $this->model
            ->with('municipio', 'prestadores')
            ->whereHas('prestadores', function ($query) {
                $query->where('tipo_prestador_id', 2);
            })
            ->where('nombre', 'ILIKE', "{$data['nombre_nit']}%")
            ->orWhereHas('prestadores', function ($query) use ($data) {
                $query->where('nit', 'ILIKE', "{$data['nombre_nit']}%");
            })->get();
    }

    /**
     * Lista los reps para el direccionamiento de una orden de códigos propios
     * @param array $data
     * @return Collection
     * @author Thomas
     */
    public function listarRepsDireccionamientoCodigosPropios(array $data): Collection
    {
        return $this->model
            ->with('municipio', 'prestadores')
            ->whereHas('prestadores', function ($query) {
                $query->where('tipo_prestador_id', 2);
            })
            ->where('nombre', 'ILIKE', "{$data['nombre_nit']}%")
            ->orWhereHas('prestadores', function ($query) use ($data) {
                $query->where('nit', 'ILIKE', "{$data['nombre_nit']}%");
            })->get();
    }

    /**
     * Lista los reps para el direccionamiento de medicamentos
     * @return Collection
     * @author Thomas
     */
    public function listarRepsDireccionamientoMedicamentos(): Collection
    {
        return $this->model
            ->with('municipio', 'prestadores')
            ->whereHas('prestadores', function ($query) {
                $query->where('tipo_prestador_id', '!=', 2);
            })->get();
    }

    /**
     * Busca un Rep por su codigo de habilitacion y numero de Sede
     * @param string $codigo
     * @return Rep
     * @author Thomas
     */
    public function buscarRepPorCodigoHabilitacionSede(string $codigo): ?Rep
    {
        return $this->model->where('codigo', $codigo)->first();
    }

    /**
     * Listar solo los resp propios y activos
     * @author Sofia O
     */
    public function listarPropiosActivos()
    {
        return Cache::remember('reps_propios_activos', now()->addHours(10), function () {
            return $this->model
                ->where('propia', true)
                ->where('activo', true)
                ->get()
                ->toArray();
        });
    }
}
