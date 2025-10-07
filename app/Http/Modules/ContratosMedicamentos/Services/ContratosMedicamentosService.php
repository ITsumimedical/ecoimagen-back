<?php

namespace App\Http\Modules\ContratosMedicamentos\Services;

use App\Http\Modules\ContratosMedicamentos\Repositories\AdjuntosContratosMedicamentosRepository;
use App\Http\Modules\ContratosMedicamentos\Repositories\ContratosMedicamentosRepository;
use App\Http\Modules\ContratosMedicamentos\Repositories\NovedadesContratosMedicamentosRepository;
use App\Traits\ArchivosTrait;
use Auth;
use DB;
use Exception;

class ContratosMedicamentosService
{
    use ArchivosTrait;

    public function __construct(
        private readonly ContratosMedicamentosRepository          $contratosMedicamentosRepository,
        private readonly NovedadesContratosMedicamentosRepository $novedadesContratosMedicamentosRepository,
        private readonly AdjuntosContratosMedicamentosRepository  $adjuntosContratosMedicamentosRepository
    ) {}

    public function crearContrato(array $data): array
    {
        try {
            DB::beginTransaction();

            // Crear el contrato
            $datosContrato = $data + [
                'estado_id' => 1,
                'creado_por' => Auth::id()
            ];
            $contrato = $this->contratosMedicamentosRepository->crear($datosContrato);

            // Crear la novedad
            $datosNovedad = [
                'contrato_medicamentos_id' => $contrato->id,
                'tipo_id' => 48,
                'observaciones' => 'Creación de contrato',
                'user_id' => Auth::id()
            ];
            $novedad = $this->novedadesContratosMedicamentosRepository->crear($datosNovedad);

            // Generar las URL para subir los adjuntos desde el frontend
            $archivos = $data['adjuntos'] ?? [];
            $ruta = 'adjuntosContratosMedicamentos';

            //Inicializar el array de URLs
            $urls = [];
            if (count($archivos) > 0) {
                foreach ($archivos as $archivo) {
                    $nombreArchivo = $novedad->id . '_' . $archivo['nombre'];

                    $urlTemporal = $this->generarUrlTemporalSubirArchivo($nombreArchivo, $ruta, 'server37', 10);

                    // Agregar la URL al array
                    $urls[] = [
                        'uuid' => $archivo['uuid'],
                        'nombreArchivo' => $nombreArchivo,
                        'url' => $urlTemporal
                    ];
                }
            }

            DB::commit();

            return [
                'contrato' => $contrato->id,
                'novedad' => $novedad->id,
                'mensaje' => 'Contrato registrado con éxito.',
                'urls' => $urls
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Guarda la información de los archivos subidos
     * @param array $request
     * @return string[]
     * @throws Exception
     * @author Thomas
     */
    public function guardarInformacionAdjuntos(array $request): array
    {
        try {
            DB::beginTransaction();
            foreach ($request['adjuntos'] as $adjunto) {
                $this->adjuntosContratosMedicamentosRepository->crear([
                    'novedad_contrato_medicamentos_id' => $adjunto['novedad_contrato_medicamentos_id'],
                    'nombre' => $adjunto['nombreArchivo'],
                    'ruta' => $adjunto['rutaArchivo'],
                ]);
            }
            DB::commit();

            return [
                'message' => 'Adjuntos guardados correctamente'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Edita un contrato
     * @param int $contratoId
     * @param array $data
     * @return array
     * @throws Exception
     * @author Thomas
     */
    public function editarContrato(int $contratoId, array $data): array
    {
        try {
            DB::beginTransaction();
            // Actualizar el contrato
            $this->contratosMedicamentosRepository->editarContrato($contratoId, $data);

            // Crear la novedad
            $datosNovedad = [
                'contrato_medicamentos_id' => $contratoId,
                'tipo_id' => 49,
                'observaciones' => 'Edición de contrato',
                'user_id' => Auth::id()
            ];
            $novedad = $this->novedadesContratosMedicamentosRepository->crear($datosNovedad);

            // Generar las URL para subir los adjuntos desde el frontend
            $archivos = $data['adjuntos'] ?? [];
            $ruta = 'adjuntosContratosMedicamentos';

            //Inicializar el array de URLs
            $urls = [];
            if (count($archivos) > 0) {
                foreach ($archivos as $archivo) {
                    $nombreArchivo = $novedad->id . '_' . $archivo['nombre'];

                    $urlTemporal = $this->generarUrlTemporalSubirArchivo($nombreArchivo, $ruta, 'server37', 10);

                    // Agregar la URL al array
                    $urls[] = [
                        'uuid' => $archivo['uuid'],
                        'nombreArchivo' => $nombreArchivo,
                        'url' => $urlTemporal
                    ];
                }
            }

            DB::commit();

            return [
                'message' => 'Contrato editado correctamente',
                'contrato' => $contratoId,
                'novedad' => $novedad->id,
                'urls' => $urls
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cambia el estado de un contrato, si se inactiva se inactivan las tarifas asociadas
     * @param int $contratoId
     * @return array
     * @throws Exception
     * @author Thomas
     */
    public function cambiarEstadoContrato(int $contratoId): array
    {
        try {
            DB::beginTransaction();

            // Cambiar el estado del contrato
            $this->contratosMedicamentosRepository->cambiarEstadoContrato($contratoId, null);

            // Buscar el contrato con sus tarifas
            $contrato = $this->contratosMedicamentosRepository->buscar($contratoId);

            if ($contrato && $contrato->estado_id == 2) {
                // Actualizar todas las tarifas asociadas al contrato
                $contrato->tarifas()->update(['estado_id' => 2]); // ✅ CORRECTO
            }

            DB::commit();

            return [
                'message' => 'Estado del contrato cambiado correctamente',
                'contrato' => $contrato
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
