<?php

namespace App\Http\Modules\Historia\Odontograma\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Odontograma\Models\Odontograma;
use Illuminate\Database\Eloquent\Collection;

class OdontogramaRepository extends RepositoryBase {

    public function __construct(protected Odontograma $odontograma)
	{
		parent::__construct($this->odontograma);
	}


	/**
	 * Obtiene la última consulta del afiliado que tenga un odontograma cargado.
	 */
	public function obtenerConsultaConOdontograma(int $afiliadoId): ?Consulta
	{
		return Consulta::where('afiliado_id', $afiliadoId)
			->whereHas('odontogramaNuevo')
			->orderByDesc('id')
			->first();
	}


	/**
	 * Obtiene todos los registros del odontograma para una consulta específica,
	 * incluyendo su parametrización.
	 */
	public function obtenerOdontogramasPorConsulta(int $consultaId): Collection
	{
		return $this->odontograma::with('parametrizacion')
			->where('consulta_id', $consultaId)
			->orderBy('id')
			->get();
	}
}
