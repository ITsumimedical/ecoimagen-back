<?php

namespace App\Http\Modules\TipoRutas\Services;

use App\Http\Modules\TipoRutas\Models\TipoRuta;
use App\Http\Modules\TipoRutas\Repositories\TipoRutaRepository;

class TipoRutaService
{

    public function __construct(
        private TipoRutaRepository $tipoRutaRepository
    ) {}
    
    /**
     * crea un nuevo tipo de ruta
     * @param array $request
     * @return TipoRuta
     * @author jose 
     */
    public function crearTipoRuta(array $data){
        return TipoRuta::create($data);
    }

    /**
     * 
     */
    public function actualizarRuta(array $data, TipoRuta $tipoRuta){
        $tipoRuta->update($data);
        return $tipoRuta;
    }
}
