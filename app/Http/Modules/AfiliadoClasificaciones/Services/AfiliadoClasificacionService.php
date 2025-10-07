<?php

namespace App\Http\Modules\AfiliadoClasificaciones\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\AfiliadoClasificaciones\Models\AfiliadoClasificacion;
use App\Http\Modules\AfiliadoClasificaciones\Repositories\AfiliadoClasificacionRepository;

class AfiliadoClasificacionService
{
    protected $afiliadoClasificacionRepository;
    public function __construct()
    {
        $this->afiliadoClasificacionRepository = new AfiliadoClasificacionRepository();
    }
    function eliminarClasificacionAfiliado($request) {
        try {
           DB::beginTransaction();
            $clasificacionEliminada = AfiliadoClasificacion::find($request->id);
            if (!$clasificacionEliminada) {
                throw new \Exception("No se encontró la clasificación.");
            }

            $clasificacionEliminada->delete();

            novedadAfiliado::create([
                'fecha_novedad' => Carbon::now(),
                'motivo' => $request['descripcionClasificacion'],
                'tipo_novedad_afiliados_id' => 4,
                'user_id' => auth()->user()->id,
                'afiliado_id' => $request->afiliado_id
            ]);
            DB::commit();
       } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
       }
    }

     /**
     * Actualiza el estado de una afiliación-clasificación
     *
     * @param int $id
     * @param bool $estado
     * @return void
     *
     */
    public function actualizarEstado(int $id, bool $estado)
    {
        $registro = AfiliadoClasificacion::where('id', $id)->update(['estado' => $estado]);

		return $registro;
    }


}
