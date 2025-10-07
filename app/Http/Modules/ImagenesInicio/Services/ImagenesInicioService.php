<?php

namespace App\Http\Modules\ImagenesInicio\Services;

use App\Http\Modules\ImagenesInicio\Models\ImagenesInicio;
use App\Http\Modules\ImagenesInicio\Repositories\ImagenesInicioRepository;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImagenesInicioService
{
    use ArchivosTrait;

    private const CACHE_KEY = 'imagenes_inicio_activas';

    public function __construct(
        private readonly ImagenesInicioRepository $imagenesRepository
    ) {}

    public function listarActivos(): Collection
    {
        // consultamos los datos estaticos de las imagenes activas
        $imagenes = Cache::rememberForever('imagenes_inicio_activas', function () {
            return $this->imagenesRepository
                ->listarActivos()
                ->map(function ($imagen) {
                    return [
                        'id'     => $imagen->id,
                        'nombre' => $imagen->nombre,
                        'path'   => ltrim($imagen->url, '/'),
                    ];
                });
        });

        // se regenera la url de cada imagen
        return collect($imagenes)->map(function ($imagen) {
            $imagen['url'] = Storage::disk('digital')->temporaryUrl(
                $imagen['path'],
                Carbon::now()->addMinutes(30)
            );
            return (object) $imagen;
        });
    }

    public function crearImagen(array $data): ImagenesInicio
    {
        $rutaCarpeta = 'adjuntosImagenesInicio';

        if (!empty($data['adjunto'])) {
            $nombreArchivo = $this->obtenerNombreArchivo($data['adjunto']);

            $this->subirArchivoNombre(
                $rutaCarpeta,
                $data['adjunto'],
                $nombreArchivo,
                'digital'
            );

            $data['url'] = $rutaCarpeta . '/' . $nombreArchivo;
        }

        $data['created_by'] = Auth::id();

        $imagen = $this->imagenesRepository->crear($data);

        Cache::forget('imagenes_inicio_activas');

        return $imagen;
    }

    public function cambiarEstadoImagen(array $data): bool
    {
        $imagen = $this->imagenesRepository->buscar((int) $data['id']);
        if (!$imagen) {
            throw new \Error('Imagen no encontrada');
        }

        $respuesta = $this->imagenesRepository->actualizar($imagen, [
            'activo'     => (bool) $data['activo'],
            'updated_by' => Auth::id(),
        ]);

        Cache::forget(self::CACHE_KEY);

        return $respuesta;
    }

    public function eliminarImagen(int $id): bool
    {
        $imagen = $this->imagenesRepository->buscar($id);

        if (!$imagen) {
            throw new \Error('Imagen no encontrada');
        }

        $imagen->updated_by = Auth::id();
        $respuesta = $imagen->delete();

        if ($respuesta && $imagen->url) {
            $nombreArchivo = basename(parse_url($imagen->url, PHP_URL_PATH));
            $path = 'adjuntosImagenesInicio/' . $nombreArchivo;

            if (Storage::disk('digital')->exists($path)) {
                Storage::disk('digital')->delete($path);
            }
        }

        Cache::forget(self::CACHE_KEY);

        return (bool) $respuesta;
    }
}
