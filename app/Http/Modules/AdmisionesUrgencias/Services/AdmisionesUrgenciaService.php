<?php

namespace App\Http\Modules\AdmisionesUrgencias\Services;
use App\Traits\ArchivosTrait;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class AdmisionesUrgenciaService
{
    use ArchivosTrait;
    public function __construct(
        protected AdmisionesUrgencia $admisionesUrgencia,
    ) {
    }
    /**
     * Guardar una nueva admisión de urgencia.
     *
     * @param array $data
     * @return AdmisionesUrgencia
     */

    public function guardarAdmision(array $data)
    {
        return DB::transaction(function () use ($data) {
            $ruta = 'adjuntosAdmisionTriage';

            // Crear la admisión inicialmente sin el campo adjunto
            $admision = $this->admisionesUrgencia::create($data);

            // Manejo seguro del archivo
            $archivo = $data['adjuntoDocumento'] ?? null;

            if ($archivo instanceof UploadedFile) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreOriginal, 'server37');

                // Asignar ruta del archivo subido a la admisión
                $admision->adjunto = $subirArchivo;
                $admision->save();

                // Si es FOMAG, subir también a esa ruta
                if ($data['entidad_afiliado'] == 1) {
                    $this->subirArchivoNombre($ruta, $archivo, $nombreOriginal, 'fomag');
                }
            }

            return $admision;
        });
    }


}
