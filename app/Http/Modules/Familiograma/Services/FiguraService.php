<?php

namespace App\Http\Modules\Familiograma\Services;

use App\Http\Modules\Familiograma\Models\Figura;
use App\Http\Modules\Familiograma\Repositories\FiguraRepository;
use App\Http\Modules\Historia\Models\Familiograma;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FiguraService
{

    use ArchivosTrait;

    protected $figuraRepository;

    public function __construct(FiguraRepository $figuraRepository)
    {
        $this->figuraRepository = $figuraRepository;
    }

    public function listarFiguras()
    {
        return $this->figuraRepository->obtenerTodas();
    }

    public function crearFigura($data)
    {
        return $this->figuraRepository->crear($data);
    }

    public function guardarImagen($data)
    {
        if (isset($data['imagen']) && !empty($data['imagen'])) {
            $archivo = $data['imagen'];

            if ($archivo) {
                $nombre = 'familiograma' . $data['consulta_id'] . '.jpg';
                $ruta = 'familiogramas';


                $rutaArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                $familiograma = new Familiograma();
                $familiograma->imagen = $rutaArchivo;
                $familiograma->consulta_id = $data['consulta_id'];
                $familiograma->save();

                return $familiograma;
            }
        }

        return null;
    }

    public function consultarImagen(Request $request)
    {
        $consultaId = $request->input('consulta_id');

        $familiograma = Familiograma::where('consulta_id', $consultaId)->first();

        $url = Storage::disk('server37')->temporaryUrl($familiograma->imagen, now()->addMinutes(30));
        return $url;
    }


    public function obtenerFigura(Request $request)
    {
        $consultaId = $request->input('consulta_id');

        $figuras = Figura::where('consulta_id', $consultaId)->get();

        return $figuras;
    }


    public function actualizarFigura($id, $data)
    {
        return $this->figuraRepository->actualizar($id, $data);
    }

    public function eliminarFigura($id)
    {
        return $this->figuraRepository->eliminar($id);
    }
}
