<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epidemiologia\Models\CampoSivigila;

class CampoRepository extends RepositoryBase
{

    public function __construct(private CampoSivigila $campoSivigila) {}

    /**
     * Consulta para obtener los campos sivigila y filtros
     * @param array $data
     * @author Sofia O
     */
    public function buscarCampos(array $data)
    {
        return $this->campoSivigila
            ->with('cabeceraSivigila.eventoSivigila:id,nombre_evento', 'campoSivigila')
            ->whereTipoCampo($data['tipo'] ?? null)
            ->whereCampoId($data['campo_id'] ?? null)
            ->whereNombreCampo($data['campo'] ?? null)
            ->whereCabeceraId($data['cabecera_id'] ?? null)
            ->whereEventoNombre($data['evento'] ?? null)
            ->orderBy('id', 'asc');

    }

    /**
     * Se crea el campo
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearCampo(array $data)
    {
        return $this->campoSivigila->create($data);
    }

    /**
     * Buscar campo por el id, encutra o falla
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarCampoPorId(int $id)
    {
        return $this->campoSivigila->findOrFail($id);
    }

    /**
     * Actualizar campo
     * @param $data
     * @param $campo
     * @author Sofia O
     */
    public function actualizarCampo($data, $campo)
    {
        $campo->update($data);
        return $campo;
    }

    /**
     * cambiar solo la columna de estado_id y gusdar el cambio
     * @param $campo
     * @param $estado
     * @author Sofia O
     */
    // public function cambiarEstado($campo, $estado)
    // {
    //     $campo->estado_id = $estado;
    //     $campo->save();
    //     return $campo;
    // }

    /**
     * listar los campos segun el evento Id
     * @param $data
     * @author Sofia O
     */
    public function listarCamposEventoId($data)
    {
        return $this->campoSivigila
            ->with('cabeceraSivigila.eventoSivigila:id,nombre_evento')
            ->whereHas('cabeceraSivigila.eventoSivigila', function ($query) use ($data) {
                $query->where('id', $data['id']);
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Se añade la condicion se actializa el campos del campo sivigila que se condiciono
     * @param $data
     * @param $campo
     * @author Sofia O
     */
    public function agregarCondicion($data, $campo)
    {
        $campo->update([
            'condicion' => $data['condicion'],
            'comparacion' => $data['comparacion']
        ]);
        return $campo;
    }
}
