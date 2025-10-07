<?php

namespace App\Http\Modules\TipoRutas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoRutas\Models\TipoRuta;

class TipoRutaRepository extends RepositoryBase
{

    protected $tipoRutaModel;

    public function __construct()
    {
        $this->tipoRutaModel = new TipoRuta();
        parent::__construct($this->tipoRutaModel);
    }


    /**
     * Crea un nuevo tipo de ruta 
     * @param array $data
     * @return TipoRuta
     * @author jose v
     */

    public function crearTipoRuta($data)
    {
        return $this->tipoRutaModel->create($data);
    }

    public function listarTodas($data)
    {
        $paginacion = $data['paginacion'];
        $rutas = $this->tipoRutaModel->orderBy('id','asc')->paginate($paginacion['cantidadRegistros'],['*'],'page',$paginacion['pagina']);
        return $rutas;
    }
    /**
     * obtiene una ruta por su ID
     * @param int $rutaId
     * @return TipoRuta
     * @author josevq
     */
    public function listarRutaPorID($rutaId){
        return $this->tipoRutaModel->findOrFail($rutaId);
    }

    public function actualizarRuta($rutaId, $data){
        $ruta = $this->tipoRutaModel->findOrFail($rutaId);
        return $ruta->update($data);
    }
}
