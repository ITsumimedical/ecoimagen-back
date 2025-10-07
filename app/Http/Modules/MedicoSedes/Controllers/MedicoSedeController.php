<?php

namespace App\Http\Modules\MedicoSedes\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MedicoSedes\Repositories\MedicoSedeRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class MedicoSedeController extends Controller
{

    public function __construct(protected MedicoSedeRepository $medicoSedeRepository) {
    }
    /**
     * listar los medicos por sede
     * @param Request $request
     * @return Response $medicos
     * @author kobatime
     */
     public function listar(int $id)
     {
         try {
             $medico = $this->medicoSedeRepository->listarConSede($id);
             return response()->json(
                 $medico,
                 Response::HTTP_OK);
         } catch (\Throwable $th) {
             return response()->json([
                 'mensaje' => 'Error al recuperar los medicos de esta sede ',
             ], Response::HTTP_BAD_REQUEST);
         }
     }


}
