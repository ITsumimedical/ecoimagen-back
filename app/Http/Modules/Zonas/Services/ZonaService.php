<?php

namespace App\Http\Modules\Zonas\Services;

use App\Http\Modules\Zonas\Models\Zonas;
use App\Http\Modules\Zonas\Repositories\ZonaRepository;

class ZonaService
{
    public function __construct(private ZonaRepository $zonaRepository) {}

    /**
     * Crar un cliente
     * @param array $data
     * @return Zonas
     * @author jose vasquez
     */

    public function crearZona(array $data)
    {
        return Zonas::create($data);
    }


    /**
     * actualiza un cliente
     * @param array $data
     * @return TipoRuta
     * @author jose vasquez
     */

    public function actualizarZona(array $data)
    {

        $consulta = Zonas::where('id', $data['id'])->first();
        $consulta->update([
            'nombre' => $data['nombre']
        ]);
        return $consulta;
    }

    /**
     * cambiar estado un cliente
     * @param int $id
     * @return boolean
     * @author jose vasquez
     */

    public function cambiarEstado(int $id)
    {
        $zona = Zonas::findOrFail($id);
        $nuevoEstado = $zona->estado === false ? true : false;
        $zona->estado = $nuevoEstado;
        $zona->save();

        return $zona;
    }
}
