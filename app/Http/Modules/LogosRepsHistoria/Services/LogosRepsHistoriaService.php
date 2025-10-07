<?php

namespace App\Http\Modules\LogosRepsHistoria\Services;

use App\Http\Modules\Adjuntos\Controller\AdjuntoController;
use App\Http\Modules\LogosRepsHistoria\Model\LogosRepsHistoria;
use App\Http\Modules\Reps\Models\Rep;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;

class LogosRepsHistoriaService
{
	use ArchivosTrait;

	public function __construct(
		protected AdjuntoController $adjuntoController,
	) {}

	/**
	 * crearLogoRepsHistoria
	 * Crea o actualiza un logo para un rep.
	 *
	 * @param  mixed $data
	 * @return void
	 */
	public function crearLogoRepsHistoria(array $data)
	{
		DB::beginTransaction();
		try {
			$nombreArchivo = $data['nombre_logo'];
			$ruta = 'logosRepsHistoria';

			$logo = LogosRepsHistoria::updateOrCreate(
				['rep_id' => $data['rep_id']],
				[
					'nombre_logo' => $nombreArchivo,
					'ruta' => "$ruta/$nombreArchivo"
				]
			);

			// Generar URL temporal
			$urlTemporal = $this->generarUrlTemporalSubirArchivo($nombreArchivo, $ruta, 'server37', 10);

			DB::commit();
			return ([
				'nombre_logo' => $nombreArchivo,
				'ruta' => $logo->ruta,
				'url' => $urlTemporal,
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}


	/**
	 * subirLogoVariosReps
	 * Se sube un logo para varios reps asociados a un prestador.
	 *
	 * @param  mixed $data
	 * @return void
	 */
	public function subirLogoVariosReps(array $data)
	{
		DB::beginTransaction();
		try {
			$nombreArchivo = $data['nombre_logo'];
			$ruta = 'logosRepsHistoria';

			// Obtener todos los reps asociados al prestador_id
			$reps = Rep::where('prestador_id', $data['prestador_id'])->get();

			if ($reps->isEmpty()) {
				throw new \Exception('No se encontraron reps para este prestador');
			}

			// Construir datos
			$valores = $reps->map(function ($rep) use ($nombreArchivo, $ruta) {
				return [
					'rep_id' => $rep->id,
					'nombre_logo' => $nombreArchivo,
					'ruta' => "$ruta/$nombreArchivo",
				];
			})->toArray();


			LogosRepsHistoria::upsert(
				$valores,
				['rep_id'],
				['nombre_logo', 'ruta']
			);

			// Generar una sola URL temporal para subir el archivo
			$urlTemporal = $this->generarUrlTemporalSubirArchivo($nombreArchivo, $ruta, 'server37', 10);

			DB::commit();
			return [
				'nombre_logo' => $nombreArchivo,
				'ruta' => "$ruta/$nombreArchivo",
				'url' => $urlTemporal,
				'reps_afectados' => $reps->pluck('id'),
			];
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}


	/**
	 * obtenerLogoPorRepId
	 * Obtiene el logo de un rep por su ID.
	 *
	 * @param  mixed $repId
	 * @return void
	 */
	public function obtenerLogoPorRepId(int $repId)
	{
		$logo = LogosRepsHistoria::where('rep_id', $repId)->firstOrFail();
		$urlTemporal = $this->adjuntoController->generarUrlTemporalDescargarArchivo([
			'nombre_archivo' => $logo['nombre_logo'],
			'nombre_carpeta' => 'logosRepsHistoria',
			'disco' => 'server37',
			'tiempo' => 10,
		]);
		return [
			'url' => $urlTemporal,
		];
	}
}
