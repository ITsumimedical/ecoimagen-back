<?php

namespace App\Http\Modules\TratamientoFarmacologico\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TratamientoFarmacologico\Repositories\TratamientoFarmacologicoRepository;
use App\Http\Modules\TratamientoFarmacologico\Requests\AgregarTratamientoFarmacologicoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class TratamientoFarmacologicoController extends Controller
{
	public function __construct(
		private readonly TratamientoFarmacologicoRepository $tratamientoFarmacologicoRepository
	)
	{
	}

	/**
	 * Agrega un tratamiento farmacológico
	 * @param AgregarTratamientoFarmacologicoRequest $request
	 * @return JsonResponse
	 * @throws \Throwable
	 * @author Thomas
	 */
	public function agregarTratamiento(AgregarTratamientoFarmacologicoRequest $request): JsonResponse
	{
		try {
			$tratamiento = $this->tratamientoFarmacologicoRepository->crear($request->validated());
			return response()->json($tratamiento, Response::HTTP_CREATED);
		} catch (\Throwable $th) {
			return response()->json([
				'error' => $th->getMessage(),
				'mensaje' => 'Error al crear el tratamiento farmacológico'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	/**
	 * Lista el histórico de tratamientos farmacológicos de un afiliado
	 * @param int $afiliadoId
	 * @return JsonResponse
	 * @throws \Throwable
	 * @author Thomas
	 */
	public function listarTratamientosAfiliado(int $afiliadoId): JsonResponse
	{
		try {
			$tratamientos = $this->tratamientoFarmacologicoRepository->listarTratamientosAfiliado($afiliadoId);
			return response()->json($tratamientos, Response::HTTP_OK);
		} catch (\Throwable $th) {
			return response()->json([
				'error' => $th->getMessage(),
				'mensaje' => 'Error al listar los tratamientos farmacológicos'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	public function eliminarTratamiento(int $id): JsonResponse
	{
		try {
			$respuesta = $this->tratamientoFarmacologicoRepository->eliminarTratamiento($id);
			return response()->json($respuesta, Response::HTTP_OK);
		} catch (\Throwable $th) {
			return response()->json([
				'error' => $th->getMessage(),
				'mensaje' => 'Error al eliminar el tratamiento farmacológico'
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
}
