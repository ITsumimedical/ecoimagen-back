<?php

namespace App\Http\Modules\Roles\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use Spatie\Permission\Models\Role;

class RolRepository extends RepositoryBase
{
    private $roleModel;

    public function __construct(Role $roleModel)
    {
        parent::__construct($roleModel);
        $this->roleModel = $roleModel;
    }

    public function listar($request)
    {
         $roles =  $this->roleModel->select([
            'roles.id', 'roles.name',
            'roles.descripcion',
            'roles.estado_id',
            'estados.nombre as nombreEstado'])
            // ->with(['permissions' => function ($query) {
            //     $query->select(
            //         'permissions.id',
            //         'permissions.name',
            //         'permissions.descripcion',
            //         'permissions.estado_id',
            //         'estados.nombre as nombreEstado')
            //         ->join('estados', 'permissions.estado_id', 'estados.id');
            // }])
            ->join('estados', 'roles.estado_id', 'estados.id');

            return $request->page ? $roles->paginate($request->cant) : $roles->get();
    }

}
