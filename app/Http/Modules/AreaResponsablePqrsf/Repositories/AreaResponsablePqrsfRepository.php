<?php

namespace App\Http\Modules\AreaResponsablePqrsf\Repositories;

use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Database\Eloquent\Collection;

class AreaResponsablePqrsfRepository extends RepositoryBase
{



    public function __construct(private AreaResponsablePqrsf $responsablePqrsfModel)
    {
        parent::__construct($this->responsablePqrsfModel);
    }

    public function listarReponsable($request)
    {
        $consulta =  $this->responsablePqrsfModel->with('responsable')->where('activo', true);

        return $request->page ? $consulta->paginate() : $consulta->get();
    }
    public function listarTodo($request)
    {
        $consulta =  $this->responsablePqrsfModel->with('responsable');
        return $request->page ? $consulta->paginate() : $consulta->get();
    }

    public function cambiarEstado($id)
    {
        $responsable = $this->responsablePqrsfModel->find($id);

        if ($responsable) {
            $responsable->activo = !$responsable->activo;
            $responsable->save();
            return $responsable;
        }

        return null;
    }

    /**
     * Obtiene las areas del usuario autenticado
     * @return Collection
     * @author Thomas
     */
    public function listarAreasUsuario()
    {
        $userId = auth()->user()->id;

        $areas = AreaResponsablePqrsf::whereHas('responsable.user', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->get();

        // dd($areas);

        return $areas;
    }
}
