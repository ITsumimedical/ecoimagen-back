<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Models\RespuestaSivigila;
use App\Http\Modules\Epidemiologia\Repositories\EpidemiologiaRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class EpidemiologiaService
{

    protected $epidemiologiaRepository;
    protected $respuestaSivigila;

    public function __construct(EpidemiologiaRepository $epidemiologiaRepository, RespuestaSivigila $respuestaSivigila)
    {
        $this->epidemiologiaRepository = $epidemiologiaRepository;
        $this->respuestaSivigila = $respuestaSivigila;
    }

    /**
     * Funcion para guardar la respuesta, y si falla no lo hace realiza un rollBack
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function guardarRespuesta(array $data)
    {
        try {
            DB::beginTransaction();
            $datosRegistro = [
                'evento_id' => $data['eventoId'],
                'consulta_id' => $data['consultaId'],
                'cie10_id' => $data['cie10Id'],
            ];
            $registroSivigila = $this->epidemiologiaRepository->crearRegistroSivigila($datosRegistro);

            $now = now();
            $datos = [];
            foreach ($data['respuestas'] as $respuesta) {
                if (is_array($respuesta['respuesta_campo'])) {
                    $respuesta['respuesta_campo'] = implode(',', $respuesta['respuesta_campo']);
                }
                $respuesta['registro_id'] = $registroSivigila['id'];
                $respuesta['created_at'] = $now;
                $respuesta['updated_at'] = $now;

                $datos[] = $respuesta;
            }
            $this->epidemiologiaRepository->guardarRespuestas($datos);

            DB::commit();
            return [
                'mensaje' => true
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Funcion para enviar a la blade del pdf la data que se consulto en el repositorio
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function generarFichaNotificacion(int $id)
    {
        $data = $this->epidemiologiaRepository->generarDatosFichaNotificacion($id);
        $pdf = Pdf::loadView('pdfs.fichaNotificacionEpidemiologia', ['data' => $data]);
        return $pdf->output();
    }

    /**
     * Funcion para actualizar la respuesta, y si falla no lo hace realiza un rollBack
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function actualizarRespuesta(array $data){

        try {
            DB::beginTransaction();

            $now = now();
            $datos = [];
            foreach ($data['respuestas'] as $respuesta) {
                if (is_array($respuesta['respuesta_campo'])) {
                    $respuesta['respuesta_campo'] = implode(',', $respuesta['respuesta_campo']);
                }

                $respuesta['updated_at'] = $now;
                $datos[] = $respuesta;
            }

            $this->epidemiologiaRepository->actualizarRespuestas($datos);

            DB::commit();
            return [
                'mensaje' => true
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
