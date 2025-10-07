<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epidemiologia\Models\CabeceraSivigila;

class CabeceraRepository extends RepositoryBase
{

    public function __construct(private CabeceraSivigila $cabeceraModel) {}

    /**
     * Consulta para obtener las cabeceras sivigila, y filtar
     * @param array $data
     * @author Sofia O
     */
    public function ConsultarCabeceras(array $data)
    {
        return $this->cabeceraModel::select('id', 'nombre_cabecera', 'evento_id', 'estado_id', 'created_at')
            ->with('eventoSivigila:id,nombre_evento')
            ->whereCabeceraId($data['cabecera_id'] ?? null)
            ->whereNombreCabecera($data['cabecera'] ?? null)
            ->whereEventoCabecera($data['evento'] ?? null)
            ->orderBy('id', 'asc');
    }

    /**
     * Se crea cabecera
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearCabecera(array $data)
    {
        return $this->cabeceraModel->create($data);
    }

    /**
     * Buscar cabecera por el id, encutra o falla
     * @param int $id
     * return Model
     * @author Sofia O
     */
    public function buscarCabeceraPorId(int $id)
    {
        return $this->cabeceraModel->findOrFail($id);
    }

    /**
     * Actualizar cabecera
     * @param $data
     * @param $cabecera
     * @author Sofia O
     */
    public function actualizarCabecera($data, $cabecera)
    {
        $cabecera->update($data);
        return $cabecera;
    }

    /**
     * cambiar solo la columna de estado_id y guardar el cambio
     * @param $cabecera
     * @param $estado
     * @author Sofia O
     */
    // public function cambiarEstado($cabecera, $estado)
    // {
    //     $cabecera->estado_id = $estado;
    //     $cabecera->save();
    //     return $cabecera;
    // }
}
