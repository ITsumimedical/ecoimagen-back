<?php

namespace App\Http\Modules\Pqrsf\Derechos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Pqrsf\Derechos\Models\Derechos;
use Illuminate\Database\Eloquent\Collection;

class DerechosRepository extends RepositoryBase
{
    private $derechosModel;

    public function __construct()
    {
        $this->derechosModel = new Derechos();
        parent::__construct($this->derechosModel);
    }

    /**
     * Funcion para crear un derecho
     * @param mixed $request
     * @return array
     * @author Thomas
     */
    public function crearDerecho($request)
    {
        $derecho = $this->derechosModel::create([
            "descripcion" => $request['descripcion'],
        ]);

        return [
            'derecho' => $derecho,
            'mensaje' => 'Derecho creado exitosamente.'
        ];
    }

    /**
     * Funcion para obtener todos los Derechos
     * @return Derechos[]| Collection
     * @author Thomas
     */
    public function listarDerechos()
    {
        return $this->derechosModel->get();
    }

    /**
     * Funcion para activar/inactivar un derecho
     * @param int $derechoId
     * @return array 
     * @author Thomas
     */
    public function cambiarEstadoDerecho($derechoId)
    {
        $derecho = $this->derechosModel::findOrFail($derechoId);

        $derecho->activo = !$derecho->activo;

        $derecho->save();

        return [
            'derecho' => $derecho,
            'mensaje' => $derecho->activo ? 'Derecho activado exitosamente.' : 'Derecho inactivado exitosamente.'
        ];
    }

    /**
     * Funcion para obtener un Derecho por su id
     * @param int $derechoId 
     * @return Derechos
     * @author Thomas
     */
    public function listarDerechoPorId($derechoId)
    {
        return $this->derechosModel->findOrFail($derechoId);
    }


    /**
     * Funcion para editar un Derecho
     * @param mixed $derechoId
     * @param mixed $request
     * @return array
     * @author Thomas
     */
    public function editarDerecho($derechoId, $request)
    {

        $derecho = $this->derechosModel::findOrFail($derechoId);
        $derecho->update([
            "descripcion" => $request['descripcion'],
        ]);
        return [
            'derecho' => $derecho,
            'mensaje' => 'Derecho actualizado exitosamente.'
        ];
    }

    /**
     * Funcion para obtener todos los Derechos activos
     * @return Collection|Derechos[]
     * @author Thomas
     */
    public function listarActivos()
    {
        return $this->derechosModel->where('activo', true)->get();
    }
}
