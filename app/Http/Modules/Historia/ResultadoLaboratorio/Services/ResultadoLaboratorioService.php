<?php

namespace App\Http\Modules\Historia\ResultadoLaboratorio\Services;

use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use App\Http\Modules\Historia\ResultadoLaboratorio\Repositories\ResultadoLaboratorioRepository;
use App\Traits\ArchivosTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResultadoLaboratorioService
{
    use ArchivosTrait;

    public function __construct(private ResultadoLaboratorioRepository $resultadoLaboratorioRepository) {}

    public function guardarResultado($data)
    {
        //se crea la consulta
        $resultado = $this->resultadoLaboratorioRepository->crear($data);

        $ruta = 'adjuntosResultadosLaboratorios';
        if (isset($data['adjuntoCargado'])) {
            $archivos = $data['adjuntoCargado'];
            $nombre = $archivos->getClientOriginalName();
            $nombreCompuesto = $data['consulta_id'] . '/' . $data['laboratorio'] . $resultado->id . $nombre;
            $subirArchivo = $this->subirArchivoNombre($ruta, $archivos, $nombreCompuesto, 'server37');
            $resultado->adjunto = $subirArchivo;
            $resultado->save();
        }
        return 'ok';
    }

    public function eliminarLaboratorio($id)
    {
        $resultado = ResultadoLaboratorio::findOrFail($id);
        // Eliminar archivo adjunto si existe
        if ($resultado->adjunto) {
            $this->borrarArchivo($resultado->adjunto);
        }
        $resultado->delete();
        return 'Resultado de laboratorio eliminado correctamente.';
    }

    public function guardarMejora($data)
    {
        $id = $data['id'];
        $meta = $data['meta'];

        $resultado = ResultadoLaboratorio::find($id);

        if (!$resultado) {
            return [
                'success' => false,
                'message' => "No se encontró resultado con ID: {$id}"
            ];
        }
        $permitidos = [
            '903817 - COLESTEROL DE BAJA DENSIDAD [LDL] AUTOMATIZADO',
            '903426 - HEMOGLOBINA GLICOSILADA AUTOMATIZADA'
        ];

        if (!in_array($resultado->laboratorio, $permitidos)) {
            return [
                'message' => 'Este laboratorio no admite mejora individual'
            ];
        }
        $resultado->meta_individual = $meta;
        $resultado->save();

        return [
            'Meta guardada correctamente',
        ];
    }
}
