<?php

namespace App\Http\Modules\Cac\Services;

use App\Http\Modules\Cac\Factories\ArchivoCacStrategyFactory;
use App\Http\Modules\Cac\Models\PatologiasCac;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Mail\ArchivoCacGenerado;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CacService
{
    public function generarArchivoCac(array $data)
    {
        $especialidadIds = PatologiasCac::find($data['patologia_id'])
                ?->especialidades()
            ->pluck('especialidades.id')
            ->toArray();

        if (empty($especialidadIds)) {
            throw new Exception('No hay especialidades asociadas a esta patología.');
        }

        $historias = HistoriaClinica::with(['consulta.afiliado', 'consulta.resultadoLaboratorios'])
            ->whereHas('consulta', function ($q) use ($data, $especialidadIds) {
                $q->whereBetween('created_at', [$data['fecha_inicio'], $data['fecha_fin']])
                    ->whereIn('especialidad_id', $especialidadIds);
            })
            ->get()
            ->sortByDesc('consulta.created_at')
            ->unique(fn($hc) => $hc->consulta->afiliado_id)
            ->values()
            ->all();

        $strategy = ArchivoCacStrategyFactory::make($data['patologia_id']);
        $lineas = $strategy->generar($historias);

        $contenido = implode("\n", $lineas);
        $archivoNombre = 'cac_' . now()->format('Ymd_His') . '.txt';

        // Asegurar que el directorio temp exista
        Storage::disk('local')->makeDirectory('temp');

        // Guardar archivo temporalmente
        $relativePath = "temp/$archivoNombre";
        $tempPath = storage_path("app/$relativePath");
        Storage::disk('local')->put($relativePath, $contenido);

        // Validar correo destino
        if (empty($data['correo'])) {
            throw new Exception('No se especificó un correo destino para el archivo.');
        }

        // Enviar el correo
        Mail::to($data['correo'])->send(new ArchivoCacGenerado($tempPath));

        // Eliminar archivo temporalmente después del envío
        if (Storage::disk('local')->exists($relativePath)) {
            Storage::disk('local')->delete($relativePath);
        }

        return [
            'mensaje' => 'Archivo enviado por correo exitosamente',
            'cantidad' => count($lineas),
        ];
    }
}
