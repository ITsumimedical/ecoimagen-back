<?php

namespace App\Http\Modules\Bases;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Bases\BaseService;

class RepositoryBase
{
    protected $model;
    protected $baseService;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->baseService = new BaseService();
    }

    public function listar($data)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'asc';
        $filas = isset($data->filas) ? $data->filas : 10;

        $consulta = $this->model
            ->orderBy('created_at', $orden);

        return  isset($data->page) ? $consulta->paginate($filas) : $consulta->get();
    }

    public function buscar(int $id)
    {
        return  $this->model->find($id);
    }

    public function guardar(Model $model)
    {
        $model->save();
        return $model;
    }

    public function crear($data)
    {
        return $this->model->create($data);
    }

    /**
     * Consulta un modelo
     * @param String $clave
     * @param $data
     * @param Array $with las relaciones que se necesitan
     * @return Model
     * @author David Peláez
     */
    public function consultar($clave, $data, $with = null, $operador = '=')
    {
        $relaciones = [];
        if ($with) {
            $relaciones = $this->baseService->obtenerArrayRelaciones($with);
        }
        return $this->model->where($clave, $operador, $data)->with($relaciones)->first();
    }

    /**
     * Actualiza un modelo
     * @param Model $model
     * @param array $data
     * @return boolean
     * @author David Peláez
     */
    public function actualizar($model, $data)
    {
        return $model->update($data);
    }


    /**
     * Consulta un modelo y traer varios registros
     * @param String $clave
     * @param $data
     * @param Array $with las relaciones que se necesitan
     * @return Model
     * @author kobatime
     */
    public function consultarLike($clave, $data, $with = null)
    {
        $relaciones = [];
        if ($with) {
            $relaciones = $this->baseService->obtenerArrayRelaciones($with);
        }
        return $this->model->where($clave, 'ILIKE', '%' . $data . '%')->with($relaciones)->get();
    }


    /**
     * eliminar registro
     * @param $data
     * @return Model
     * @author Julian
     */
    public function eliminar($modelOId)
    {
        if (!$modelOId instanceof Model) {
            // Si no es una instancia del modelo, se busca por el id
            $model = $this->model->findOrFail($modelOId);
        } else {
            // Si ya es una instancia del modelo, lo usamos directamente
            $model = $modelOId;
        }
        return $model->delete();
    }

    /**
     * Inserta registros de manera masiva
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function insertarMasivo(array $data): bool
    {
        return $this->model->insert($data);
    }

    public function normalizarTexto(string $texto): string
    {
        // Normaliza el texto eliminando espacios, convirtiendo a minúsculas y eliminando caracteres especiales
        return strtolower(trim($texto));
    }
}
