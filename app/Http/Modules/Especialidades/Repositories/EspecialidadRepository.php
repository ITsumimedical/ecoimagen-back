<?php

namespace App\Http\Modules\Especialidades\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Especialidades\Models\Especialidade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EspecialidadRepository extends RepositoryBase
{
    protected $especialidadModel;

    public function __construct()
    {
        $this->especialidadModel = new Especialidade();
        parent::__construct($this->especialidadModel);
    }

    public function listarEspecialidadesConMedicos($user_id)
    {
        $entidadesUsuario = DB::table('entidad_users')
            ->where('user_id', $user_id)
            ->pluck('entidad_id');
        return $this->especialidadModel->select([
            'especialidades.id',
            'especialidades.nombre',
            'especialidades.estado'
        ])
            ->whereNotIn('especialidades.id', [83, 84, 85, 86])
            ->with([
                'medicos' => function ($query) use ($entidadesUsuario) {
                    $query->join('operadores', 'users.id', 'operadores.user_id')
                        ->join('entidad_users', 'entidad_users.user_id', 'users.id')
                        ->whereIn('entidad_users.entidad_id', $entidadesUsuario)
                        ->whereNotNull('operadores.cargo_id')
                        ->select([
                            'users.*',
                            'entidad_users.entidad_id'
                        ]);
                },
                'citas' => function ($query) use ($entidadesUsuario) {
                    $query->where('estado_id', 1)
                        ->whereIn('entidad_id', $entidadesUsuario)
                        ->with('cups');
                },
            ])->get();
    }

    public function listarEspecialidades($request)
    {
        $consulta = $this->model->select([
            'especialidades.id',
            'especialidades.nombre',
            'especialidades.estado',
        ])->where('estado', true);
        if ($request->nombre) {
            $consulta->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function listarTodas($request)
    {
        $consulta = $this->model->select([
            'especialidades.id',
            'especialidades.nombre',
            'especialidades.estado',
            'especialidades.requiere_telesalud',
            'especialidades.cup_id'
        ])->with(['cups']);
        // ->leftjoin('cups','cups.id','especialidades.cup_id');
        if ($request->nombre) {
            $consulta->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->orderBy('id', 'ASC')->get();
    }

    public function especialidadEmpleados($request)
    {
        $consulta = $this->model->select([
            'especialidades.id',
            'especialidades.nombre',
            'especialidades.estado',
        ])->whereNotIn('especialidades.id', [60, 61, 62, 63, 64, 69, 70]);
        if ($request->nombre) {
            $consulta->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function eliminarEspecialidad($request)
    {
        $id = $request->input('id');

        // Eliminar el registro de la base de datos
        DB::table('especialidade_user')->where('id', $id)->delete();

        return response()->json(['message' => 'Registro eliminado con éxito']);
    }

    public function especialidadMedico($especialidad_id, $user_id)
    {
        $entidadesUsuario = DB::table('entidad_users')
            ->where('user_id', $user_id)
            ->pluck('entidad_id');
        return $this->model::select('operadores.nombre', 'operadores.apellido', 'users.id', 'operadores.documento')
            ->join('especialidade_user', 'especialidade_user.especialidade_id', 'especialidades.id')
            ->join('users', 'users.id', 'especialidade_user.user_id')
            ->join('operadores', 'operadores.user_id', 'users.id')
            ->join('entidad_users', 'entidad_users.user_id', 'users.id')
            ->where('especialidade_user.especialidade_id', $especialidad_id)
            ->whereIn('entidad_users.entidad_id', $entidadesUsuario)
            ->get();
    }

    public function especialidadCita($especialidad_id, $user_id)
    {
        $entidadesUsuario = DB::table('entidad_users')
            ->where('user_id', $user_id)
            ->pluck('entidad_id');
        return $this->model::select('citas.nombre', 'citas.tiempo_consulta', 'citas.id', 'citas.tipo_cita_id', 'citas.cantidad_paciente', 'citas.procedimiento_no_especifico')
            ->join('citas', 'citas.especialidade_id', 'especialidades.id')
            ->where('citas.especialidade_id', $especialidad_id)
            ->where('citas.estado_id', 1)
            ->whereIn('citas.entidad_id', $entidadesUsuario)
            ->get();
    }

    public function listarMedicosYAuxiliares($especialidad_id)
    {
        return $this->model::select('operadores.nombre', 'operadores.apellido', 'users.id', 'operadores.documento')
            ->join('especialidade_user', 'especialidade_user.especialidade_id', 'especialidades.id')
            ->join('users', 'users.id', 'especialidade_user.user_id')
            ->join('operadores', 'operadores.user_id', 'users.id')
            ->whereIn('especialidade_user.especialidade_id', [$especialidad_id, 48, 53])
            ->get();
    }

    public function listarEspecialidadesPorMedico($user_id)
    {
        return $this->model::select('especialidades.id', 'especialidades.nombre')
            ->join('especialidade_user', 'especialidade_user.especialidade_id', 'especialidades.id')
            ->where('especialidade_user.user_id', $user_id)
            ->get();
    }

    public function cambiarMarca($data, int $id)
    {

        return $this->model::find($id)->update([
            'requiere_telesalud' => $data['requiere_telesalud']
        ]);
    }

    public function listarEspecialidadesTelesalud()
    {

        return $this->model->select([
            'especialidades.id',
            'especialidades.nombre',
        ])->where('estado', true)->where('requiere_telesalud', true)
            ->get();
    }

    public function guardarCup($data)
    {
        return $this->model::find($data['especialidad'])->update(['cup_id' => $data['cup_id']]);
    }

    public function buscarId($id)
    {
        return $this->model::find($id);
    }
    public function obtenerEspecialidadPorNombre($nombre)
    {
        return $this->model->select([
            'especialidades.id'
        ])->where('nombre', $nombre)->first();
    }

    /**
     * Agrega grupos a una especialidad
     * @param array $data
     * @return array
     * @author Thomas
     */
    public function agregarGrupos(array $data): array
    {
        $especialidad = $this->especialidadModel->findOrFail($data['especialidad_id']);
        return $especialidad->grupos()->syncWithoutDetaching($data['grupos']);
    }

    /**
     * Obtiene los grupos de una especialidad
     * @param int $especialidad_id
     * @return Collection
     * @author Thomas
     */
    public function listarGruposEspecialidad(int $especialidad_id): Collection
    {
        return $this->especialidadModel->findOrFail($especialidad_id)->grupos()->get();
    }

    /**
     * Elimina grupos de una especialidad
     * @param array $data
     * @return int
     * @author Thomas
     */
    public function eliminarGrupos(array $data): int
    {
        $especialidad = $this->especialidadModel->findOrFail($data['especialidad_id']);
        return $especialidad->grupos()->detach($data['grupos']);
    }
}
