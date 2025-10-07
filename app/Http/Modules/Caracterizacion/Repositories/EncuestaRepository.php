<?php

namespace App\Http\Modules\Caracterizacion\Repositories;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Caracterizacion\Models\Encuesta;

class EncuestaRepository extends RepositoryBase {

    public function __construct(protected Encuesta $encuestaModel)
    {
        parent::__construct($this->encuestaModel);
    }

    /**
     * Obtiene la encuesta de un afiliado o beneficiario
     * @param int $afiliado_id
     * @return Encuesta
     */
    public function obtenerCaracterizacionDeAfiliado(int $afiliado_id)
    {
        return $this->encuestaModel->where('afiliado_id', $afiliado_id)->firstOrFail();
    }

    /**
     * Actualiza la encuesta por id
     * @param int $id
     * @param array $data
     * @return Encuesta
     */

    public function actualizar($id, $data)
    {
        return $this->encuestaModel->where('id', $id)->update($data);
    }

}
