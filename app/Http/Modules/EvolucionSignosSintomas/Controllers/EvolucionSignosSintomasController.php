<?php

namespace App\Http\Modules\EvolucionSignosSintomas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvolucionSignosSintomas\Repositories\EvolucionSignosSintomasRepository;
use App\Http\Modules\EvolucionSignosSintomas\Requests\AgregarEvolucionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EvolucionSignosSintomasController extends Controller
{

	public function __construct(
		private readonly EvolucionSignosSintomasRepository $evolucionSignosSintomasRepository
	)
	{
	}

	/**
	 * Agregar una evolucion siempre y cuando sea diferente consulta
	 * @param AgregarEvolucionRequest $request
	 * @return JsonResponse
	 * @throws \Throwable
	 * @author Thomas
	 *
	 */
	public function agregarEvolucion(AgregarEvolucionRequest $request): JsonResponse
	{
		try {
			$evolucion = $this->evolucionSignosSintomasRepository->agregarEvolucion($request->validated());
			return response()->json($evolucion, Response::HTTP_CREATED);
		} catch (\Throwable $th) {
			return response()->json([
				'error' => $th->getMessage(),
				'mensaje' => 'Error al crear evolución'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	/**
	 * Lista la última evolución de un afiliado
	 * @param int $afiliadoId
	 * @return JsonResponse
	 * @throws \Throwable
	 * @author Thomas
	 */
	public function listarUltimaEvolucion(int $afiliadoId): JsonResponse
	{
		try {
			$evolucion = $this->evolucionSignosSintomasRepository->listarUltimaEvolucion($afiliadoId);
			return response()->json($evolucion, Response::HTTP_OK);
		} catch (\Throwable $th) {
			return response()->json([
				'error' => $th->getMessage(),
				'mensaje' => 'Error al listar evolución'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

}
