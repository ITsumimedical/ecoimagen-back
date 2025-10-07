<?php

namespace App\Http\Modules\Ecomapa\Services;

use App\Http\Modules\Ecomapa\Models\FiguraEcomapa;
use App\Http\Modules\Ecomapa\Repositories\FiguraEcomapaRepository;
use App\Http\Modules\Ecomapa\Request\FiguraEcomapaRequest;
use App\Http\Modules\Historia\AntecedentesEcomapas\Models\AntecedenteEcomapa;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FiguraEcomapaService
{

    use ArchivosTrait;

    protected $figuraRepository;

    public function __construct(FiguraEcomapaRepository $figuraRepository)
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
        $archivo = $data['imagen'];
        $nombre = 'ecomapa' . $data['consulta_id'] . '.jpg';
        $ruta = 'ecomapas';

        $rutaArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

        $ecomapa = new AntecedenteEcomapa();
        $ecomapa->imagen = $rutaArchivo;
        $ecomapa->consulta_id = $data['consulta_id'];
        $ecomapa->medico_registra = Auth::id();
        $ecomapa->save();

        return $ecomapa;
    }

    public function consultarImagen($data)
    {
        $consultaId = $data['consulta_id'];

        $ecomapa = AntecedenteEcomapa::where('consulta_id', $consultaId)->firstOrFail();

        return Storage::disk('server37')->temporaryUrl($ecomapa->imagen, now()->addMinutes(30));
    }


    public function obtenerFigura($data)
    {
        $consultaId = $data['consulta_id'];

        return FiguraEcomapa::where('consulta_id', $consultaId)->get();
    }


    // public function actualizarFigura($id, $data)
    // {
    //     return $this->figuraRepository->actualizar($id, $data);
    // }

    // public function eliminarFigura($id)
    // {
    //     return $this->figuraRepository->eliminar($id);
    // }
}
