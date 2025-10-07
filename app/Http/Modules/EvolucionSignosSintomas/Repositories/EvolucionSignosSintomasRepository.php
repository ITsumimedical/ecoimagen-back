<?php

namespace App\Http\Modules\EvolucionSignosSintomas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EvolucionSignosSintomas\Models\EvolucionSignosSintomas;

class EvolucionSignosSintomasRepository extends RepositoryBase
{
	protected EvolucionSignosSintomas $evolucionSignosSintomasModel;

	public function __construct()
	{
		$this->evolucionSignosSintomasModel = new EvolucionSignosSintomas();
		parent::__construct($this->evolucionSignosSintomasModel);
	}

	/**
	 * Agrega una nueva evolucion siempre y cuando sea diferente consulta
	 * @param array $data
	 * @return EvolucionSignosSintomas
	 * @author Thomas
	 */
	public function agregarEvolucion(array $data): EvolucionSignosSintomas
	{
		return $this->evolucionSignosSintomasModel->updateOrCreate(
			['consulta_id' => $data['consulta_id']],
			$data
		);
	}


	public function listarUltimaEvolucion($afiliadoId)
	{
        return $this->evolucionSignosSintomasModel
        ->whereHas('consulta', function ($query) use ($afiliadoId) {
            $query->where('afiliado_id', $afiliadoId);
        })
        ->latest()
        ->first();
	}
}
