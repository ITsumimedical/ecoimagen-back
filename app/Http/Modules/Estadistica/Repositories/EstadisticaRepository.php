<?php

namespace App\Http\Modules\Estadistica\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Estadistica\Models\Estadistica;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Support\Facades\Auth;

class EstadisticaRepository extends RepositoryBase
{

    public function __construct(protected Estadistica $estadisticaModel)
    {
        parent::__construct($this->estadisticaModel);
    }

    public function listarEstadistica($userId)
    {

        $usuario = User::find($userId);
        $permisoUsuario = $usuario ? $usuario->getAllPermissions()->pluck('id') : collect();
        if ($permisoUsuario->isEmpty()) {
            return response()->json(['message' => 'Permisos del usuario no encontrados'], 404);
        }

        return $this->estadisticaModel->select(
            'estadisticas.id',
            'estadisticas.titulo',
            'estadisticas.imagen',
            'estadisticas.inframe',
            'estadisticas.usuario_registra_id',
            'permissions.name as permiso',
            'users.email as email',
        )
            ->join('permissions', 'estadisticas.permission_id', 'permissions.id')
            ->join('users', 'estadisticas.usuario_registra_id', 'users.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido ) as NombreCrea")
            ->where('estadisticas.estado_id', 1)
            ->whereIn('permissions.id', $permisoUsuario)
            ->get();
    }

    public function actualizarEstadistica($id, array $datos)
    {
        try {
            $estadistica = $this->estadisticaModel->findOrFail($id);
            $estadistica->update($datos);

            return $estadistica;
        } catch (\Exception $e) {
            throw new \Exception("Error al actualizar la estadistica: " . $e->getMessage());
        }
    }

    public function eliminarEstadistica($id)
    {
        return $this->estadisticaModel->findOrFail($id)->delete();
    }

    public function guardarImagen($file)
    {
        if ($file && $file->isValid()) {
            $file_name = time() . $file->getClientOriginalName();
            $path = '../storage/app/public/estadistica/';
            $pathDB = '/storage/estadistica/' . $file_name;
            $file->move($path, $file_name);

            return $pathDB;
        } else {
            throw new \Exception("El archivo no es válido o no se ha proporcionado.");
        }
    }
}
