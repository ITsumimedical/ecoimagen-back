<?php

namespace App\Http\Modules\NovedadesAfiliados\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\NovedadesAfiliados\Repositories\AdjuntosNovedadAfiliadosRepository;
use App\Traits\ArchivosTrait;

class NovedadAfiliadosService
{
    use ArchivosTrait;

    public function __construct(
        private AdjuntosNovedadAfiliadosRepository $adjuntosNovedadAfiliadosRepository
    ) {}

    public function crearNovedad($afiliadoId, $request)
    {
        $afiliado = Afiliado::find($afiliadoId);

        $novedadAfiliado = new novedadAfiliado();
        $novedadAfiliado->afiliado_id = $afiliadoId;
        $novedadAfiliado->fecha_novedad = $request->fecha_novedad;
        $novedadAfiliado->tipo_novedad_afiliados_id = $request->tipo_novedad_id;
        $novedadAfiliado->motivo = $request->motivo;
        $novedadAfiliado->user_id = auth()->user()->id;
        $novedadAfiliado->save();


        if (isset($request->adjuntos)) {
            $archivos = $request->adjuntos;
            $ruta = 'novedadesAfiliados';
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $afiliado->numero_documento . '/' . time() . '_' . 'adjunto' . '_' . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $this->adjuntosNovedadAfiliadosRepository->crearAdjunto($nombre, $subirArchivo, $novedadAfiliado->id);
            }
        }
    }
}
