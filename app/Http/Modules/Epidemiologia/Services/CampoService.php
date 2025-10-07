<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Repositories\CampoRepository;

class CampoService
{
    public function __construct(private CampoRepository $campoRepository) {}

    /**
     * Listar los campos epidemiológicos, con o sin paginación
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarCampos(array $data)
    {
        $campos = $this->campoRepository->buscarCampos($data);

        if (isset($data['page']) && isset($data['cant'])) {
            return $campos->paginate($data['cant']);
        }

        return $campos->get();
    }

    /**
     * Buscar el registro del campo y actualizarlo
     * @param array $data
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function actualizarCampo(array $data, int $id)
    {
        $campo = $this->campoRepository->buscarCampoPorId($id);
        return $this->campoRepository->actualizarCampo($data, $campo);
    }

    /**
     * Buscar el registro del campo y cambiar su estado segun corresponda
     * @param int $id
     * @author Sofia O
     */
    public function actualizarEstado(int $id)
    {
        $campo = $this->campoRepository->buscarCampoPorId($id);
        $estado = $campo->estado_id == 1 ? 2 : 1;
        return $this->campoRepository->actualizarCampo(['estado_id' => $estado], $campo);
    }

    /**
     * Funcion para buscar el Id del campo para luego actualizar
     * @param array $data
     * @param int $id
     * @author Sofia O
     */
    public function agregarCondicionCampo(array $data, int $id)
    {
        $campo = $this->campoRepository->buscarCampoPorId($id);
        return $this->campoRepository->agregarCondicion($data, $campo);
    }
}
