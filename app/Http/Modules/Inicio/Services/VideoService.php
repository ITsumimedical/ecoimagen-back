<?php

namespace App\Http\Modules\Inicio\Services;

use App\Http\Modules\Inicio\Models\Videos;
use App\Http\Modules\Inicio\Repositories\VideosRepository;

class VideoService
{

    protected VideosRepository $videosRepository;

    public function __construct(VideosRepository $videosRepository)
    {
        $this->videosRepository = $videosRepository;
    }

    public function crearVideo(array $datos): Videos
    {
        $video = new Videos();
        $video->nombre = $datos['nombre'];
        $video->descripcion = $datos['descripcion'];
        $video->url = $datos['url'];
        $video->cargado_por = auth()->id();

        $this->videosRepository->guardar($video);

        // Asociar tipos
        if (!empty($datos['tipos_usuario'])) {
            $video->tiposUsuarios()->sync($datos['tipos_usuario']);
        }

        return $video;
    }
}
