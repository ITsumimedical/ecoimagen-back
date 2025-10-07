<?php

namespace App\Http\Modules\PaqueteServicios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use ArrayObject;
use Illuminate\Support\Facades\DB;


class PaqueteServicioRepository extends RepositoryBase
{

    protected $model;

    public function __construct()
    {
        $this->model = new PaqueteServicio();
        parent::__construct($this->model);
    }

    /**
     * @override
     * @param Request $request
     * @return Collection
     * @author Kobatime
     */
    public function listar($request)
    {

        $consulta = $this->model
            ->with('cups')
            ->withCount('cupsConteo', 'propios')
            ->WhereCodigo($request->codigo_paquete)
            ->WhereNombre($request->nombre)
            ->WhereCup($request->codigo_cup)
            ->orderBy('created_at', 'desc');

        return $request->page ? $consulta->paginate() : $consulta->get();
    }

    public function listarCupsPorPaquete($request)
    {
        $consulta = Cup::join('cup_paquete', 'cup_paquete.cup_id', 'cups.id')
            ->where('cup_paquete.paquete_id', $request)
            ->select('cups.*');

        // return $request->page ? $consulta->paginate() : $consulta->get();

        return $consulta->paginate(10);
    }




    public function deleteCupPaquete($cupId, $paqueteId)
    {
        return DB::table('cup_paquete')
            ->where('cup_id', $cupId)
            ->where('paquete_id', $paqueteId)
            ->delete();
    }
    public function listarCodigosPropiosPorPaquete($paquete_id)
    {

        $consulta = CodigoPropio::join('paquete_propio', 'paquete_propio.propio_id', 'codigo_propios.id')
            ->where('paquete_propio.paquete_id', $paquete_id)
            ->select('codigo_propios.*');

        return $consulta->paginate(10);
    }
    // public function listarCodigosPropiosPorPaquete($paquete_id)
    // {

    //     $consulta = $this->model->where('id', $paquete_id)->with('propios')->get();

    //     return $consulta->pluck('propios');
    // }

    public function deleteCodigoPropioPaquete($cupId, $paqueteId)
    {
        return DB::table('paquete_propio')
            ->where('propio_id', $cupId)
            ->where('paquete_id', $paqueteId)
            ->delete();
    }

    public function buscarPaqueteServicio($nombre)
    {
        $cups = $this->model->select(['id', 'codigo', 'nombre', 'activo', 'created_at', 'cup_id', 'deleted_at', 'descripcion', 'precio', 'requiere_auditoria'])
            ->selectRaw("CONCAT(codigo,' - ',nombre) as CodigoNombre")
            ->where('nombre', 'ILIKE', "%" . $nombre . "%")
            ->orWhere('codigo', 'ILIKE', "%" . $nombre . "%")
            ->get()
            ->toArray();

        return response()->json($cups);
    }
}
