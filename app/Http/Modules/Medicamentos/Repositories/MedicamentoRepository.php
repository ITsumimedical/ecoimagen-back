<?php

namespace App\Http\Modules\Medicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Especialidades\Models\EspecialidadGrupo;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MedicamentoRepository extends RepositoryBase
{
    public function __construct(protected Medicamento $medicamentoModel)
    {
        parent::__construct($this->medicamentoModel);
    }

    /**
     * lista los medicamentos
     *
     * @return Collection
     */
    public function listar($data)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        $filas = isset($data->filas) ? $data->filas : 10;

        $consulta = $this->medicamentoModel
            ->with('codesumi')
            ->join('codesumis', 'medicamentos.codesumi_id', 'codesumis.id')
            ->where('codesumis.estado_id', '!=', 2)
            ->with('BodegaMedicamentos.lotes', 'BodegaMedicamentos.bodega', 'codesumi')
            ->whereBuscar($data->columna, $data->dato)
            ->whereBodega($data->bodega)
            ->whereNombreCodigo($data->nombre)
            ->whereTodos($data->todos)
            ->when(isset($data->grupo_id), function ($query) use ($data) {
                $query->where('codesumis.grupo_id', $data->grupo_id);
            })
            ->orderBy('medicamentos.created_at', $orden);

        return $data->page ? $consulta->paginate($filas) : $consulta->get();
    }

    public function buscarMedicamentoOrdenamiento($data)
    {
        $usuario = auth()->user();
        $niveles = Cache::rememberForever("usuario:$usuario->id", function () use ($usuario) {
            return $usuario->permissions->filter(function ($permission) {
                return strpos($permission['name'], 'nivel.ordenamiento') !== false;
            })->map(function ($permission) {
                return explode('.', $permission['name'])[2];
            })->prepend(0)->toArray();
        });

        $key = 'busqueda-medicamento:' . $data->nombre;
        $medicamentoCachado =  Cache::remember($key, 7200, function () use ($data) {
            $medicamento = $this->medicamentoModel->with('codesumi')
                ->whereNombreCodigo($data->nombre)
                ->whereHas('codesumi', function ($query) {
                    $query->where('estado_id', '!=', 2);
                });

            return $medicamento->get();
        });

        // Solo agrega esta condición si el nivel no es 4
        if (!in_array(4, $niveles)) {
            $medicamentoCachado->where('nivel_ordenamiento', '!=', 4);
        }

        return $medicamentoCachado;
    }

    public function listarMedicamentosBodegas($data)
    {
        set_time_limit(-1);
        $consulta = Medicamento::with('codesumi:id,codigo,nombre', 'invima:id,titular,cum_validacion,expediente')
            ->whereHas('codesumi', function ($query) {
                $query->where('estado_id', '!=', 2);
            })->whereBodega($data['bodega']);

        return $consulta->get();
    }


    public function pendientesPorCodigoLasa()
    {
        return Codesumi::where('codigo_lasa', null)->count();
    }

    public function listarMedicamentos()
    {
        return Codesumi::with('medicamentos')->get();
    }

    public function listarTodosLosMedicamentosVademecum($data)
    {
        $consulta = $this->medicamentoModel->with(['BodegaMedicamentos', 'codesumi', 'invima', 'BodegaMedicamentos.bodega:id,nombre', 'BodegaMedicamentos.lotes']);
        if ($data->filtro) {
            $filtro = $data->filtro;
            $consulta->whereHas('invima', function ($query) use ($filtro) {
                $query->where('producto', 'ILIKE', '%' . $filtro . '%')
                    ->orWhere('cum_validacion', 'ILIKE', '%' . $filtro . '%');
            });
        };
        return $data->page ? $consulta->paginate($data->cant) : $consulta->get();
    }


    public function buscarMedicamento($nombre)
    {
        return $this->medicamentoModel::with('codesumi')
            ->whereHas('codesumi', function ($query) use ($nombre) {
                $query->where('nombre', 'ILIKE', "%{$nombre}%")
                    ->orWhere('codigo', 'ILIKE', "%{$nombre}%");
            })
            ->get();
    }

    /**
     * buscarPrincipioActivo
     *Funcion para buscar los medicamentos por medio de principio activo y agrupar aquellos que son iguales para que solo muestre uno
     * @param  mixed $principio_activo
     * @return void
     */
    public function buscarPrincipioActivo($principio_activo)
    {
        return $this->medicamentoModel::select('medicamentos.codesumi_id', 'medicamentos.id')
            ->join('codesumis', 'medicamentos.codesumi_id', '=', 'codesumis.id')
            ->where('codesumis.principio_activo', 'ILIKE', "%{$principio_activo}%")
            ->groupBy('codesumis.principio_activo', 'medicamentos.id')
            ->distinct('codesumis.principio_activo')
            ->with([
                'codesumi' => function ($query) {
                    $query->select('id', 'principio_activo');
                }
            ])
            ->get();
    }

    public function crearMedicamento($data)
    {
        // return $data;
        // return Codesumi::with('medicamentos')->get();
        $medicamento = $this->medicamentoModel::create(
            [
                'codesumi_id' => $data['codesumi_id'],
                'cum' => $data['cum'],
                'nivel_ordenamiento' => $data['nivel_ordenamiento'],
                'estado_id' => 1,
                'clasificacion_riesgo' => $data['clasificacion_riesgo'],
                'origen' => $data['origen'],
                'marca_dispositivo' => $data['marca_dispositivo'],
                'ium_primernivel' => $data['ium_primernivel'],
                'ium_segundonivel' => $data['ium_segundonivel'],
                // 'pos' => $data['pos'],
                'precio_maximo' => $data['precio_maximo'],
                'activo_horus' => $data['activo_horus'],
                'refrigerado' => $data['refrigerado'],
                'generico' => $data['generico'],
                'comercial' => $data['comercial'],
                'regulado' => $data['regulado'],
                'medicamento_vital' => $data['medicamento_vital'],
                'resolucion' => $data['resolucion'],
                'codigo_medicamento' => $data['codigo_medicamento'],
            ]

        );

        return $medicamento;
    }

    public function listarMedicamentoBodegaTraslado($data)
    {
        $consulta = Medicamento::with('codesumi:id,codigo,nombre', 'invima:id,titular,cum_validacion,expediente,producto,forma_farmaceutica')->select(
            'medicamentos.id as medicamento_id',
            'medicamentos.cum',
            'medicamentos.codesumi_id',
            'bm.cantidad_total',
            'bm.id as bodegaMedicamento'
        )->whereHas('codesumi', function ($query) {
            $query->where('estado_id', '!=', 2);
        })->join('bodega_medicamentos as bm', 'medicamentos.id', 'bm.medicamento_id')
            ->where('bm.cantidad_total', '>', 0)
            ->whereNotNull('medicamentos.cum')
            // ->where('bm.estado',1)
            ->where('bm.bodega_id', $data['bodega']);

        return $consulta->get();
    }

    public function cambiarEstadoMedicamento($data)
    {
        return $this->medicamentoModel::find($data['medicamento'])->update(['estado_id' => $data['estado_id']]);
    }

    /**
     * Listar los medicamentos marcados con codigos laza
     *
     * @author Calvarez
     */
    public function medicamentosMarcados()
    {
        return Codesumi::whereNotNull('codigo_lasa')->get();
    }

    /**
     * Lista los medicamentos para el ordenamiento intrahospitalario
     * Filtra por los medicamentos que su grupo pertenece a las especialidades del usuario
     * @param  string $nombre
     * @return Collection
     * @author Thomas
     */
    public function buscarMedicamentosOrdenamientoIntrahospitalario(string $nombre): Collection
    {
        $usuario = auth()->user();

        // Especialidades del usuario
        $idsEspecialidades = $usuario->especialidades->pluck('id')->toArray();

        // Grupos permitidos para esas especialidades
        $grupoIds = EspecialidadGrupo::whereIn('especialidad_id', $idsEspecialidades)
            ->pluck('grupo_id')
            ->toArray();

        return $this->medicamentoModel->with('codesumi.formaFarmaceutica')
            ->whereNombreCodigo($nombre)
            ->whereHas('codesumi', function ($q) use ($grupoIds) {
                $q->where('estado_id', '!=', 2)
                    ->whereIn('grupo_id', $grupoIds);
            })
            ->get();
    }

    /**
     * Obtiene los medicamentos por codesumi
     * @param int $codesumiId
     * @return Collection
     * @author Thomas
     */
    public function obtenerMedicamentosPorCodesumi(int $codesumiId): Collection
    {
        return $this->medicamentoModel->where('codesumi_id', $codesumiId)->get();
    }
}
