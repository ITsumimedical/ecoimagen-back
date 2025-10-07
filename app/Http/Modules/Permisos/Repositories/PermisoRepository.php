<?php

namespace App\Http\Modules\Permisos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoRepository extends RepositoryBase
{
    private $permisoModel;

    public function __construct(Permission $permisoModel)
    {
        parent::__construct($permisoModel);
        $this->permisoModel = $permisoModel;
    }

    public function listarPermisos($request)
    {
         $consulta =  $this->permisoModel->select([
            'permissions.id',
            'permissions.name',
            'permissions.descripcion',
            'permissions.guard_name',
            'permissions.estado_id',
            'estados.nombre as nombreEstado',
            ])
            ->join('estados', 'permissions.estado_id', 'estados.id');
         if($request->nombre){
             $consulta->where('name','ILIKE',"%{$request->nombre}%");
         }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();

    }

    public function getPermisosPorRol($rol_id){
        $rol = Role::where('id', $rol_id)->first();
        return $rol->permissions;
    }

}
