<?php

namespace App\Http\Modules\ClienteMesaAyuda\Services;

use App\Http\Modules\ClienteMesaAyuda\Models\Clientemesaayuda;
use App\Http\Modules\ClienteMesaAyuda\Repositories\ClienteMesaAyudaRepository;

class ClientesMesaAyudaService
{
    protected $clienteMesaAyudaRepository;

    public function __construct(ClienteMesaAyudaRepository $clienteMesaAyudaRepository)
    {
        $this->clienteMesaAyudaRepository = $clienteMesaAyudaRepository;
    }

    /**
     * crea un registro de cliente de mesa de ayuda
     *
     */
    public function crear(array $request)
    {
        $buscar = $this->clienteMesaAyudaRepository->buscarPorNombre($request['nombre']);

        if (!$buscar) {
            return Clientemesaayuda::create($request);
        }

        throw new \Exception('Ya existe un cliente registrado con este nombre', 422);

    }

    public function editar(array $data, int $id)
    {

        return Clientemesaayuda::where('id', $id)->update($data);
    }
}
