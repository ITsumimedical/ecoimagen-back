<?php

namespace App\Http\Modules\Reps\Services;

use App\Http\Modules\ImagenesContratoSedes\Services\ImagenesContratoSedesService;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Reps\Repositories\RepsRepository;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Support\Str;
use App\Traits\ArchivosTrait;

class RepsService
{
    use ArchivosTrait;

    public function __construct(protected RepsRepository $repsRepository, protected ImagenesContratoSedesService $imagenesContratoSedesService) {}

    public function cambioEstado($sede, $data)
    {
        $tarifas = Tarifa::where('rep_id', $sede->id)->get();
        $sede->update([
            'activo' => $data['activo']
        ]);
        if ($tarifas) {
            foreach ($tarifas as $tarifa) {
                $tarifa->update([
                    'activo' => $data['activo']
                ]);
            }
        }

        return true;
    }

    public function crear($data)
    {
        $crearRep = Rep::create(
            [
                'codigo_habilitacion' => $data['codigo_habilitacion'],
                'numero_sede' => $data['numero_sede'],
                'nombre' => $data['nombre'],
                'tipo_zona' => $data['tipo_zona'],
                'nivel_atencion' => $data['nivel_atencion'],
                'correo1' => $data['correo1'],
                'correo2' => $data['correo2'],
                'telefono1' => $data['telefono1'],
                'telefono2' => $data['telefono2'],
                'direccion' => $data['direccion'],
                'propia' => $data['propia'],
                'codigo' => $data['codigo'],
                'sede_principal' => $data['sede_principal'],
                'prestador_id' => $data['prestador_id'],
                'municipio_id' => $data['municipio_id'],
                'ips_primaria' => $data['ips_primaria'],
            ]
        );

        if (isset($data['imagenes'])) {
            $ruta = 'ImagenesPrestadores';
            $imagenes = $data['imagenes'];
            if ($imagenes && is_array($imagenes)) {
                foreach ($imagenes as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $uuid = Str::uuid();
                    $nombreUnicoAdjunto = $uuid . '.' . $nombre;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreUnicoAdjunto, 'server37');

                    $imagenes = $this->imagenesContratoSedesService->subirImagen([
                        'nombre' => $nombre,
                        'url_imagen' => $subirArchivo,
                        'rep_id' => $crearRep->id
                    ]);
                }

                return (object)[
                    'rep_id' => $crearRep,
                    'imagen' => $imagenes
                ];
            }
        }
    }

    public function actualizarRep(array $data, int $id)
    {
        $actualizarRep = $this->repsRepository->buscarPorId($id);
        $actualizarRep->update([
            'codigo_habilitacion' => $data['codigo_habilitacion'],
            'numero_sede' => $data['numero_sede'],
            'nombre' => $data['nombre'],
            'tipo_zona' => $data['tipo_zona'],
            'nivel_atencion' => $data['nivel_atencion'],
            'correo1' => $data['correo1'],
            'correo2' => $data['correo2'],
            'telefono1' => $data['telefono1'],
            'telefono2' => $data['telefono2'],
            'direccion' => $data['direccion'],
            'propia' => $data['propia'],
            'codigo' => $data['codigo'],
            'sede_principal' => $data['sede_principal'],
            'prestador_id' => $data['prestador_id'],
            'municipio_id' => $data['municipio_id'],
            'ips_primaria' => $data['ips_primaria'],
        ]);

        if (isset($data['imagenes'])) {
            $ruta = 'ImagenesPrestadores';
            $imagenes = $data['imagenes'];
            if ($imagenes && is_array($imagenes)) {
                foreach ($imagenes as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $uuid = Str::uuid();
                    $nombreUnicoAdjunto = $uuid . '.' . $nombre;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreUnicoAdjunto, 'server37');

                    $imagenes = $this->imagenesContratoSedesService->actualizarImagen([
                        'nombre' => $nombre,
                        'url_imagen' => $subirArchivo,
                        'rep_id' => $actualizarRep->id
                    ], $actualizarRep->id);
                }

                return (object)[
                    'rep_id' => $actualizarRep,
                    'imagen' => $imagenes
                ];
            }
        }
    }
}
