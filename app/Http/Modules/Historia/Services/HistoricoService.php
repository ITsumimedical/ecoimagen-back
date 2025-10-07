<?php

namespace App\Http\Modules\Historia\Services;

use GuzzleHttp\Client;

class HistoricoService {

    public function historicoHistorias($request) {
        $cliente = new Client(['verify' => false]);
        $respuesta = $cliente->get('https://www.horus-health.com/api/historiapaciente/gethistoriaExterna?token=KMkm5PyrELKB2jnLMKyBgi8WgPwSNizSwwxJXBuY&Num_Doc=' . intval($request->Num_Doc));
        $data = json_decode($respuesta->getBody()->getContents(), true);

        // Paginación
        $pagina = $request->input('page', 1);
        $porPagina = $request->input('per_page', 10);
        $total = count($data);
        $inicio = ($pagina - 1) * $porPagina;
        $historias = array_slice($data, $inicio, $porPagina);

        return [
            'data' => $historias,
            'total' => $total,
            'pagina_actual' => $pagina,
            'per_page' => $porPagina,
        ];
    }

}
