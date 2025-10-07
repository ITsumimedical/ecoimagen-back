<?php

namespace App\Http\Modules\Telesalud\Services;

use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Cups\Repositories\CupRepository;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Especialidades\Repositories\EspecialidadRepository;
use App\Http\Modules\Telesalud\Models\GestionesTelesalud;
use App\Http\Modules\Telesalud\Models\Telesalud;
use App\Http\Modules\Telesalud\Repositories\AdjuntosTelesaludRepository;
use App\Http\Modules\Telesalud\Repositories\GestionesTelesaludRepository;
use App\Http\Modules\Telesalud\Repositories\TelesaludRepository;
use App\Traits\ArchivosTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class TelesaludService
{

    use ArchivosTrait;

    public function __construct(
        private TelesaludRepository $telesaludRepository,
        private ConsultaRepository $consultaRepository,
        private Cie10AfiliadoRepository $cie10AfiliadoRepository,
        private CupRepository $cupRepository,
        private GestionesTelesaludRepository $gestionesTelesaludRepository,
        private AdjuntosTelesaludRepository $adjuntosTelesaludRepository,
        private EspecialidadRepository $especialidadRepository
    ) {}

    /**
     * Funcion para Crear Telesalud con todo su proceso
     * @param array $request
     * @return Telesalud
     * @throws Exception
     * @author Thomas
     */
    public function crearTelesalud($request)
    {
        try {
            DB::beginTransaction();

            // Crear la Consulta
            $consulta = $this->consultaRepository->crearConsultaTelesalud($request['afiliado_id']);

            // Asignarle el Diagnostico Principal a la Consulta
            $this->cie10AfiliadoRepository->crearCie10AfiliadoTelesalud($request['diagnostico_principal'], $consulta->id, 0, tipo_diagnostico: 'Impresión diagnóstica');

            // Asignarle los diagnosticos secundarios a la Consulta
            if (isset($request['diagnosticos']) && sizeof($request['diagnosticos']) >= 1) {
                foreach ($request['diagnosticos'] as $diagnostico) {
                    $this->cie10AfiliadoRepository->crearCie10AfiliadoTelesalud($diagnostico, $consulta->id, 1, 'Impresión diagnóstica');
                }
            }

            // Para crear la telesalud es necesario el CupId
            $especialidad = $this->especialidadRepository->buscarId($request['especialidad_id']);
            $cup = $this->cupRepository->obtenerCupPorEspecialidad($especialidad);

            // Asignarle el Cup al payload
            $request['cup_id'] = $cup->id;

            // Asignarle la Consulta al payload
            $request['consulta_id'] = $consulta->id;

            // Crear la Telesalud
            $telesalud = $this->telesaludRepository->crearTelesalud($request);

            // Crear la Gestion
            $gestion = $this->gestionesTelesaludRepository->guardarGestionTelesalud($telesalud->id, 45, null, null, null);

            // Guardar los Adjuntos
            if (isset($request['adjuntos']) && sizeof($request['adjuntos']) >= 1) {
                $archivos = $request['adjuntos'];
                $ruta = 'adjuntosTelesalud';
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombreArchivo = $request['numero_documento'] . '/' . time() . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreArchivo, 'server37');
                    $this->adjuntosTelesaludRepository->crearAdjunto($gestion->id, $nombreArchivo, $subirArchivo);
                }
            }

            DB::commit();


            return $telesalud;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Funcion para actualizar la especialidad de una telesalud
     * @param int $telesaludId
     * @param array<int> $request especialidad_id
     * @return Telesalud
     * @author Thomas
     */
    public function actualizarEspecialidad($telesaludId, $request)
    {
        try {
            DB::beginTransaction();

            // Obtener la telesalud
            $telesalud = $this->telesaludRepository->obtenerTelesaludPorId($telesaludId);

            // Obtener la especialidad actual (anterior)
            $especialidadAnterior = $telesalud->especialidad->nombre;

            // Actualizar la especialidad
            $telesalud->especialidad_id = $request['especialidad_id'];
            $telesalud->save();

            // Obtener la nueva especialidad usando el modelo de Especialidad
            $nuevaEspecialidad = Especialidade::find($request['especialidad_id'])->nombre;

            // Crear la Gestión de tipo Actualización y se describe el cambio en la observación
            $observacion = "Cambio de especialidad de $especialidadAnterior a $nuevaEspecialidad";
            $this->gestionesTelesaludRepository->guardarGestionTelesalud($telesaludId, 46, null, null, $observacion);

            DB::commit();

            return $telesalud;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    /**
     * Funcion para responder una telesalud
     * @param int $telesaludId
     * @param array $request
     * @return GestionesTelesalud
     * @author Thomas
     */
    public function respuestaEspecialista($telesaludId, $request)
    {

        try {

            DB::beginTransaction();

            // Obtener la telesalud
            $telesalud = $this->telesaludRepository->obtenerTelesaludPorId($telesaludId);

            // Se cambia el estado de la telesalud
            $telesalud->estado_id = 9;
            $telesalud->save();

            // Se crea la Gestion de la telesalud de tipo respuesta
            $gestion = $this->gestionesTelesaludRepository->guardarGestionTelesalud($telesaludId, 47, $request['prioridad'], $request['pertinencia_solicitud'], $request['observacion'], $request['finalidad_consulta_id'], $request['causa_externa_id']);

            DB::commit();

            return $gestion;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function respuestaJunta($telesaludId, $request)
    {
        try {

            DB::beginTransaction();

            // Se obtiene la telesalud
            $telesalud = $this->telesaludRepository->obtenerTelesaludPorId($telesaludId);

            // Se ligan los integrantes a la telesalud
            $telesalud->integrantes()->sync($request['integrantes']);

            // Se cambia el estado de la telesalud
            $telesalud->estado_id = 9;
            $telesalud->save();

            $gestion = $this->gestionesTelesaludRepository->guardarRespuestaJuntaProfesionales($telesaludId, $request);

            DB::commit();

            return $gestion;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
