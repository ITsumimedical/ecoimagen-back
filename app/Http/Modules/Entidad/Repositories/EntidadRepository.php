<?php

namespace App\Http\Modules\Entidad\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Throwable;

class EntidadRepository extends RepositoryBase
{
    protected $model;

    public function __construct()
    {
        $this->model = new Entidad();
        parent::__construct($this->model);
    }

    public function listarEntidades($request)
    {
        $entidades = json_decode(Auth::user()->entidad);
        $arrEntidades = array_column($entidades, 'id');
        $consulta = $this->model->select([
            'entidades.id',
            'entidades.nombre',
            'entidades.agendar_pacientes',
            'entidades.generar_ordenes',
            'entidades.entregar_medicamentos',
            'entidades.atender_pacientes',
            'entidades.autorizar_ordenes',
            'entidades.consultar_historicos',
            'entidades.estado',
        ])->with('imagenes')
            ->whereIn('id', $arrEntidades);
        if ($request->nombre) {
            $consulta->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function listarNotiene($request)
    {
        $usuario = User::find($request->id);
        $entidades = json_decode($usuario->entidad);
        $arrEntidades = array_column($entidades, 'id');
        $consulta = $this->model->select([
            'entidades.id',
            'entidades.nombre',
        ])
            ->whereNotIn('id', $arrEntidades);
        if ($request->nombre) {
            $consulta->where('nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function validar($entidad_id, $accion)
    {
        $mensaje = "";
        $acceso = true;
        $entidad = $this->model::find($entidad_id);
        if (!$entidad->{$accion}) {
            $mensaje = "La entidad del paciente no tiene permitido esta accion";
            $acceso = false;
        }
        return ['mensaje' => $mensaje, 'acceso' => $acceso];
    }


    public function listarEntidadesFomagFerro($request)
    {
        $consulta = $this->model->select([
            'entidades.id',
            'entidades.nombre'
        ])->whereIn('id', [1, 3]);
        return $consulta->get();
    }

    /**
     * Lista las entidades asociadas al usuario loggeado
     * @return Collection
     * @throws Throwable
     * @author Thomas
     */
    public function listarEntidadesUsuario(): Collection
    {

        $usuario = Auth::id();

        return $this->model
            ->whereHas('usuarios', function ($query) use ($usuario) {
                $query->where('user_id', $usuario);
            })
            ->get();
    }

}
