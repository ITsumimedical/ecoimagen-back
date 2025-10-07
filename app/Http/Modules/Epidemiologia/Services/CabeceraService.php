<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Repositories\CabeceraRepository;

class CabeceraService
{
    public function __construct(private CabeceraRepository $cabeceraRepository) {}

    /**
     * Listar las cabeceras epidemiológicas, con o sin paginación
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarCabeceras(array $data)
    {
        $cabeceras = $this->cabeceraRepository->ConsultarCabeceras($data);

        if (isset($data['page']) && isset($data['cant'])) {
            return $cabeceras->paginate($data['cant']);
        }

        return $cabeceras->get();
    }

    /**
     * Buscar el registro de la cabecera y actualizarla
     * @param array $data
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function actualizarcabecera(array $data, int $id)
    {
        $cabecera = $this->cabeceraRepository->buscarcabeceraPorId($id);
        return $this->cabeceraRepository->actualizarcabecera($data, $cabecera);
    }

    /**
     * Buscar el registro del evento y cambiar su estado segun corresponda
     * @param int $id
     * @author Sofia O
     */
    public function actualizarEstado(int $id)
    {
        $cabecera = $this->cabeceraRepository->buscarcabeceraPorId($id);
        $estado = $cabecera->estado_id == 1 ? 2 : 1;
        return $this->cabeceraRepository->actualizarcabecera(['estado_id' => $estado], $cabecera);
    }
}
