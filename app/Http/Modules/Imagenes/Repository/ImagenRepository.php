<?php

namespace App\Http\Modules\Imagenes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Imagenes\Models\Imagene;

class ImagenRepository extends RepositoryBase
{

    public function __construct(protected Imagene $imagenModel)
    {
        parent::__construct($this->imagenModel);
    }

    // public function listarEstadistica()
    // {
    //     return $this->imagenModel->select(
    //         'estadisticas.id',
    //         'estadisticas.titulo',
    //         'estadisticas.imagen',
    //         'estadisticas.inframe',
    //         'estadisticas.usuario_registra_id',
    //         'permissions.name as permiso'
    //     )
    //         ->join('permissions', 'estadisticas.permission_id', 'permissions.id')
    //         ->join('users', 'estadisticas.usuario_registra_id', 'users.id')
    //         ->join('empleados', 'users.id', 'empleados.user_id')
    //         ->selectRaw("CONCAT(empleados.primer_nombre, ' ', empleados.primer_apellido) as nombre_completo")
    //         ->where('estadisticas.estado_id', 1)
    //         ->get();
    // }

    // public function actualizarEstadistica($id, array $datos)
    // {
    //     try {
    //         $estadistica = $this->imagenModel->findOrFail($id);
    //         $estadistica->update($datos);

    //         return $estadistica;
    //     } catch (\Exception $e) {
    //         throw new \Exception("Error al actualizar la estadistica: " . $e->getMessage());
    //     }
    // }

    // public function eliminarEstadistica($id)
    // {
    //     return $this->estadisticaModel->findOrFail($id)->delete();
    // }


}
