<?php

namespace App\Http\Modules\Bases;

class BaseService {

    /**
     * Obtiene las relaciones
     * @param string $relaciones
     * @return Array
     * @author David Peláez
     */
    public function obtenerArrayRelaciones($relaciones){
        return explode(',', $relaciones);
    }

}
