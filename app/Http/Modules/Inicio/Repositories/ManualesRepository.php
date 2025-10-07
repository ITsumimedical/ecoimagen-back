<?php

namespace App\Http\Modules\Inicio\Repositories;

use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Inicio\Models\Manuales;
use Error;
use Illuminate\Support\Collection;

class ManualesRepository extends RepositoryBase
{

    use ArchivosTrait;

    public function __construct(protected Manuales $manualesModel)
    {
        parent::__construct($this->manualesModel);
    }

    public function listarTodos()
    {
        return $this->manualesModel->with(["cargadoPor.operador", 'tiposUsuarios'])->orderBy("id", "ASC")->get();
    }

    public function cambiarEstadoManual($manual_id)
    {
        $manual = Manuales::find($manual_id);
        $manual->activo = !$manual->activo;
        $manual->save();
    }

    public function buscarManual($manual_id)
    {
        return Manuales::find($manual_id);
    }


    public function actualizarManual($manual_id, $request)
    {
        $manual = Manuales::find($manual_id);

        $manual->nombre = $request['nombre'];
        $manual->descripcion = $request['descripcion'];

        // Verifica si se ha enviado un nuevo archivo adjunto
        $archivo = $request['adjunto'];
        if ($archivo != "null") {
            $ruta = 'adjuntosManuales';

            if ($manual->url) {
                $this->borrarArchivo($manual->url, 'server37');
            }

            $nombre = $archivo->getClientOriginalName();
            $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
            $manual->url = $ruta . '/' . $nombre;
        }

        $manual->save();

        if (!empty($request['tipos_usuarios'])) {
            $manual->tiposUsuarios()->sync($request['tipos_usuarios']);
        }

        return $manual;
    }

    public function listarActivos(): Collection
    {
        $tipoUsuarioId = auth()->user()->tipo_usuario_id;

        return $this->manualesModel
            ->where('activo', true)
            ->whereHas('tiposUsuarios', function ($query) use ($tipoUsuarioId) {
                $query->where('tipo_usuario_id', $tipoUsuarioId);
            })
            ->with(['cargadoPor.operador'])
            ->orderBy('id', 'ASC')
            ->get();
    }
}
