<?php

namespace App\Http\Modules\Operadores\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Reps\Models\Rep;
use FontLib\TrueType\Collection;

class OperadorRepository extends RepositoryBase
{
    public function __construct(protected Operadore $operadoreModel)
    {
        parent::__construct($this->operadoreModel);
    }

    public function crearOperador($request)
    {
        $prestador = Rep::find($request['reps_id'])->first();
        $request['rep_id'] = $prestador->id;
        $request['prestador_id'] = $prestador->prestador_id;
        $this->operadoreModel->create($request);
    }

    public function listarActivos()
    {
        $operadores = Operadore::select('operadores.*')
            ->join('users', 'users.id', 'operadores.user_id')
            ->where('users.activo', 1)
            ->get();

        return $operadores;
    }

    public function listar($request)
    {
        return Operadore::select('operadores.*', 'users.email')
            ->join('users', 'operadores.user_id', 'users.id')
            ->get();
    }

    public function listarFiltro($request)
    {
        return Operadore::select('operadores.*', 'users.email')
            ->join('users', 'operadores.user_id', 'users.id')
            ->WhereNombre($request->nombre)
            ->get();
    }

    /**
     * Obtener todos los operadores activos de Sumimedical
     * @return Operadore[]
     * @author Thomas
     */
    public function listarActivosSumi()
    {
        return $this->operadoreModel->whereHas('user', function ($query) {
            $query->where('users.activo', 1);
        })->whereHas('rep', function ($query) {
            $query->whereIn('prestador_id', [2389, 41213, 56479]);
        })->get();
    }

    /**
     * lista los medicos y los auxiliares por el parametro ingresado en el request
     * @param array $request
     * @return Collection
     * @author jose vasquez
     */
    public function listarMedicosYauxiliares(array $request): Collection
    {
        return $this->operadoreModel
            ->select(
                'operadores.nombre',
                'operadores.apellido',
                'operadores.documento',
                'operadores.especialidad_id',
                'users.id as user_id',
                'especialidades.nombre as especialidad'
            )
            ->join('users', 'users.id', '=', 'operadores.user_id')
            ->join('especialidade_user', 'especialidade_user.user_id', '=', 'users.id')
            ->join('especialidades', 'especialidades.id', '=', 'especialidade_user.especialidade_id')
            ->where(function ($query) use ($request) {
                $query->where('operadores.nombre', 'ILIKE', '%' . $request['funcionario'] . '%')
                    ->orWhere('operadores.apellido', 'ILIKE', '%' . $request['funcionario'] . '%');
            })
            ->whereNotNull('operadores.especialidad_id')
            ->get();
    }
}
