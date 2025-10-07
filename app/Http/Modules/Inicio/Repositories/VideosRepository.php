<?php

namespace App\Http\Modules\Inicio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Inicio\Models\Videos;

class VideosRepository extends RepositoryBase
{
    public function __construct(protected Videos $videosModel)
    {
        parent::__construct($this->videosModel);
    }

    public function listarTodos()
    {
        return $this->videosModel->with(["cargadoPor.operador", 'tiposUsuarios'])->orderBy("id", "ASC")->get();
    }

    public function crearVideo($request)
    {
        $video = new Videos();
        $video->nombre = $request['nombre'];
        $video->descripcion = $request['descripcion'];
        $video->url = $request['url'];
        $video->cargado_por = auth()->user()->id;

        $video->save();

        return $video;
    }

    public function cambiarEstadoVideo($video_id)
    {
        $video = Videos::find($video_id);
        $video->activo = !$video->activo;
        $video->save();
    }

    public function buscarVideo($video_id)
    {
        return Videos::find($video_id);
    }

    public function actualizarVideo($video_id, array $request): void
    {
        $video = Videos::findOrFail($video_id);

        $video->update([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'url' => $request['url'],
        ]);

        if (isset($request['tipos_usuario']) && is_array($request['tipos_usuario'])) {
            $video->tiposUsuarios()->sync($request['tipos_usuario']);
        }
    }


    public function listarActivos()
    {
        $query = $this->videosModel
            ->with(['cargadoPor.operador'])
            ->where('activo', true)
            ->orderBy('id', 'ASC');

        if (auth()->check() && auth()->user()->tipo_usuario_id) {
            $tipoUsuarioId = auth()->user()->tipo_usuario_id;

            $query->whereHas('tiposUsuarios', function ($q) use ($tipoUsuarioId) {
                $q->where('tipo_usuario_id', $tipoUsuarioId);
            });
        }

        return $query->get();
    }
}
