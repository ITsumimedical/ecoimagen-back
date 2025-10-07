<?php

namespace App\Http\Modules\TratamientoFarmacologico\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TratamientoFarmacologico\Models\TratamientoFarmacologico;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TratamientoFarmacologicoRepository extends RepositoryBase
{
	protected TratamientoFarmacologico $tratamientoFarmacologicoModel;

	public function __construct()
	{
		$this->tratamientoFarmacologicoModel = new TratamientoFarmacologico();
		parent::__construct($this->tratamientoFarmacologicoModel);
	}

	/**
	 * Lista el histórico de tratamientos farmacológicos de un afiliado
	 * @param int $afiliadoId
	 * @return Collection
	 * @author Thomas
	 */
	public function listarTratamientosAfiliado(int $afiliadoId): Collection
	{
		return $this->tratamientoFarmacologicoModel->with('viaAdministracion', 'creadoPor.operador')
			->whereHas('consulta', function ($query) use ($afiliadoId) {
				return $query->where('afiliado_id', $afiliadoId);
			})
			->get();
	}

	/**
	 * Elimina un tratamiento farmacológico
	 * @param int $id
	 * @return string
	 * @throws \Exception
	 * @author Thomas
	 */
	public function eliminarTratamiento(int $id): string
	{
		$tratamiento = $this->tratamientoFarmacologicoModel->findOrFail($id);

		// Validar si el usuario es propietario
		if ($tratamiento->creado_por != Auth::id()) {
			throw new \Exception('No tienes permiso para eliminar este tratamiento farmacológico');
		}

		$tratamiento->delete();

		return 'Tratamiento farmacológico eliminado correctamente';

	}
}
