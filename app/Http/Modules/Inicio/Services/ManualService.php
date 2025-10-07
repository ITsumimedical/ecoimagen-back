<?php

namespace App\Http\Modules\Inicio\Services;

use App\Http\Modules\Inicio\Models\Manuales;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;

class ManualService
{
    use ArchivosTrait;

    public function crearManual(array $data): array
    {
        DB::beginTransaction();

        try {
            $manual = new Manuales();
            $manual->nombre = $data['nombre'];
            $manual->descripcion = $data['descripcion'];
            $manual->cargado_por = auth()->id();
            $manual->save();

            if (!empty($data['adjunto'])) {
                $nombre = $manual->id . '_' . $data['adjunto'];
                $ruta = 'adjuntosManuales';
                $manual->url = $ruta . '/' . $nombre;

                $urlTemporal = $this->generarUrlTemporalSubirArchivo($nombre, $ruta, 'server37');
            }

            $manual->save();

            if (!empty($data['tipos_usuario'])) {
                $this->asignarTiposUsuario($manual, $data['tipos_usuario']);
            }

            DB::commit();

            return [
                'mensaje' => 'Manual creado correctamente',
                'url' => $urlTemporal ?? null,
                'manual' => $manual->id,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function asignarTiposUsuario(Manuales $manual, array $tiposUsuarioIds): void
    {
        $manual->tiposUsuarios()->sync($tiposUsuarioIds);
    }
}
