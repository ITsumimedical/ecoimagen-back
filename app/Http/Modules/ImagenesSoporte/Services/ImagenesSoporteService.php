<?php

namespace App\Http\Modules\ImagenesSoporte\Services;


use App\Http\Modules\ImagenesSoporte\Models\ImagenesSoporte;
use App\Http\Modules\ImagenesSoporte\Repositories\ImagenesSoporteRepository;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ImagenesSoporteService
{
    use ArchivosTrait;

    private const CACHE_KEY = 'imagenes_inicio_activas';

    public function __construct(
        private readonly ImagenesSoporteRepository $imagenesRepository
    ) {}

    public function listarActivos(): Collection
    {
        // consultamos los datos estaticos de las imagenes activas
        $imagenes = $this->imagenesRepository
                ->listarActivos()
                ->map(function ($imagen) {
                    return [
                        'id'     => $imagen->id,
                        'nombre' => $imagen->nombre,
                        'path'   => ltrim($imagen->url, '/'),
                    ];
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

    public function crearImagen(array $data): ImagenesSoporte
    {
        $rutaCarpeta = 'adjuntosImagenesSoporte';

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
            $path = 'adjuntosImagenesSoporte/' . $nombreArchivo;

            if (Storage::disk('digital')->exists($path)) {
                Storage::disk('digital')->delete($path);
            }
        }

        Cache::forget(self::CACHE_KEY);

        return (bool) $respuesta;
    }
}
