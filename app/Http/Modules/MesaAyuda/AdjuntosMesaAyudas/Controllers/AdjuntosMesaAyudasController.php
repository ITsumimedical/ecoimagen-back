<?php

namespace App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Models\AdjuntosMesaAyudasModel;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Repositories\AdjuntosMesaAyudasRepository;
use App\Http\Modules\MesaAyuda\AdjuntosmEsaAyudas\Requests\ActualizarAdjuntosMesaAyudas;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Requests\CreateAdjuntosMesaAyudasRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdjuntosMesaAyudasController extends Controller
{
    private $AdjuntosMesaAyudasRepository;

    public function __construct(AdjuntosMesaAyudasRepository $AdjuntosMesaAyudasRepository){
        $this->AdjuntosMesaAyudasRepository = $AdjuntosMesaAyudasRepository;

    }
    /**
     * listar-Lista los adjuntos de la mesa de ayudas
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(request $request){
        try {
            $AdjuntosMesaAyudas = $this->AdjuntosMesaAyudasRepository->listar($request);
            return response()->json($AdjuntosMesaAyudas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los adjuntos de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);

        }

    }
    /**
     * crear-Crea adjuntos en la mesa de ayudas
     *
     * @param  mixed $request
     * @return void
     */
    public function crear(CreateAdjuntosMesaAyudasRequest $request){
        try {
            $AdjuntosMesaAyudas = $this->AdjuntosMesaAyudasRepository->guardarAdjuntoMesaAyuda($request->all());
            return response()->json($AdjuntosMesaAyudas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([$th->getMessage(),
                'mensaje' => 'Error al crear los adjuntos de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);
        }

    }
    /**
     * actualizar-Actualiza adjuntos en la mesa de ayudas
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(ActualizarAdjuntosMesaAyudas $request, int $id ){
        try {
            $AdjuntosMesaAyudas = $this->AdjuntosMesaAyudasRepository->buscar($id);
            $AdjuntosMesaAyudas->fill($request->validated());
            $this->AdjuntosMesaAyudasRepository->guardar($AdjuntosMesaAyudas);
            Response()->json([
                'mensaje' => 'Adjunto de mesa de ayudas actualizada con éxitos'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al actualizar los adjuntos de mesa de ayudas'
            ], Response::HTTP_BAD_REQUEST);

        }
    }


}
