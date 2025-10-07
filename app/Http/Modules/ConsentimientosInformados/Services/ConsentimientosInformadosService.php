<?php

namespace App\Http\Modules\ConsentimientosInformados\Services;

use App\Http\Modules\ConsentimientosInformados\Repositories\ConsentimientosInformadosRepository;

use Exception;
use function PHPSTORM_META\type;

class ConsentimientosInformadosService
{
    public function __construct(
        private ConsentimientosInformadosRepository $consentimientosInformadosRepository,
    ) {}


    /**
     * Crea un consentimiento informado despues de validar si no es de laboratorio
     * @param mixed $data
     * @throws \Exception
     * @author AlejoSR
     */
    public function crearConsentimiento($data)
    {
        try {
            #verificamos si desean que el consentimiento sea de laboratorio
            if ($data['laboratorio']) {

                #verificamos si ya hay un consentimiento asignado como laboratorio
                $esLaboratorio = $this->consentimientosInformadosRepository->listarConsentimientosLaboratorio();

                $codigoLaboratorio = $esLaboratorio->pluck('codigo')->unique()->toArray();

                #si el codigo que llega es diferente al que ya existe, se arroja error
                if($codigoLaboratorio[0] !== $data['codigo']){
                    throw new Exception('Los laboratorios ya están asignados a un consentimiento informado, por favor desmarque el actual y cree otro nuevamente');

                }

    
            }

            return $this->consentimientosInformadosRepository->crearConsentimiento($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Cambia el estado del consentimiento informado relacionado con laboratorio
     * @param array $data consentimiento
     * @throws \Exception
     * @return bool|mixed
     * @author AlejoSR
     */
    // public function actualizarEstadoLaboratorio(array $data)
    // {

    //     try {
    //         #obtenemos el o los consentimientos asociados a laboratorios
    //         $consentimientosLaboratorio = $this->consentimientosInformadosRepository->listarConsentimientosLaboratorio();


    //         #obtenemos el consentimiento especifico asociado al id que se desea cambiar
    //         $consentimientoLaboratorio = $consentimientosLaboratorio?->firstWhere('id', $data['id']);

    //         #si exisiten consentimientos asignados a laboratorio y el consentimiento ya existe como laboratorio, se actualiza
    //         if ($consentimientosLaboratorio->count() != 0 && $consentimientoLaboratorio) {

    //             return $consentimientoLaboratorio->update([
    //                 'laboratorio' => !$consentimientoLaboratorio->laboratorio
    //             ]);
    //         }


    //         #verificamos que el consentimiento que se quiere cambiar sea asociado al codigo del consentimiento de laboratorio
    //         if ($consentimientosLaboratorio->count() != 0 && $data['codigo'] !== $consentimientosLaboratorio->first()?->codigo) {
    //             throw new Exception('El consentimiento debe ser unico o estar asociado al mismo codigo del que existe actualmente como laboratorio');
    //         }

    //         #si no hay ninguno asignado, se consulta el consentimiento y se asigna
    //         $consentimiento = $this->consentimientosInformadosRepository->obtenerConsentimiento($data['id']);
    //         return $consentimiento->update([
    //             'laboratorio' => !$consentimiento->laboratorio
    //         ]);
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    /**
     * Consulta y regresa agrupados los consentimientos asociados a un arreglo de id de cups que tengan parametrizado consentimiento.
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function consultarConsentimientosGrupo(array $ids)
    {
        try {
            #traemos todos los consentimientos asociados a los cups_ids que se le pasan
            $consentimientos = $this->consentimientosInformadosRepository->consultarConsentimientosGrupoProcedimientos($ids['ids']);

            #se agrupan los consentimientos que esten activos por codigo
            $agrupados = $consentimientos->where('estado', true)->groupBy('codigo')->map(function ($itemsPorCodigo) {

                #se toma el primero relacionado para obtener los datos en comun
                $primero = $itemsPorCodigo->first();

                #Se agrupan los consentimientos por codigo y se agrupan los cup_id relacionados
                return [
                    'nombre' => $primero->nombre,
                    'descripcion' => $primero->descripcion,
                    'beneficios' => $primero->beneficios,
                    'riesgos' => $primero->riesgos,
                    'alternativas' => $primero->alternativas,
                    'riesgo_no_aceptar' => $primero->riesgo_no_aceptar,
                    'informacion' => $primero->informacion,
                    'recomendaciones' => $primero->recomendaciones,
                    'codigo' => $primero->codigo,
                    'version' => $primero->version,
                    'fecha_aprobacion' => $primero->fecha_aprobacion,
                    'estado' => $primero->estado,
                    'odontologia' => $primero->odontologia,
                    'cup_id' => $itemsPorCodigo->pluck('cup_id')->unique()->values()
                ];
            })->values();

            return $agrupados;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Lista los consentimientos informados agrupandolos segun el codigo del formato de consentimiento y agrupando los cups_id asociados a ese formato
     * @param mixed $datos
     * @return mixed
     * @author AlejoSR
     */
    public function listar()
    {
        try {
            #se listan los consentimientos unicos segun su codigo de formato
            $consentimientos =  $this->consentimientosInformadosRepository->listarConsentimientos()->unique('codigo')->toArray();
            return array_values($consentimientos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * Actualiza los registros en la tabla consentimiento informado segun la data que llegue y un array de cup_id asociados a la data
     * @param array $data
     * @return bool
     * @author AlejoSR
     */
    public function actualizar(array $data)
    {
        try {
            #se obtienen los consentimientos existentes segun el codigo
            $consentimientosExistentes = $this->consentimientosInformadosRepository->obtenerConsentimientoCodigo($data['codigo']);

            #se obtienen los consentimientos asociados a laboratorio
            $consentimientosLaboratorio = $this->consentimientosInformadosRepository->listarConsentimientosLaboratorio();

            #se extrae el codigo del consentimiento asociado a laboratorio
            $codigoConsentimientoLaboratorio = $consentimientosLaboratorio->pluck('codigo')->unique()->toArray();
            
            
            #si el codigo del formato que se desea actualizar no está asociado a un laboratorio y si está cambiando el estado de asignación de laboratorio, se genera un error
            if(!in_array($data['codigo'],$codigoConsentimientoLaboratorio) && !empty($codigoConsentimientoLaboratorio)){

                $laboratorioEstadoNuevo = $data['laboratorio'];
                $estadoActualLaboratorioConsentimiento = $consentimientosExistentes->pluck('laboratorio')->unique()->first();
                if(!$laboratorioEstadoNuevo===$estadoActualLaboratorioConsentimiento){
                    throw new Exception('Solo se puede asociar un unico formato de consentimiento a laboratorio');
                }
            }

            #para los demás, se actualizan en caso de que venga informacion a actualizar o se crea con la información si viene un CUPS nuevo
            $this->consentimientosInformadosRepository->actualizarFormato($data['codigo'], $data);
            
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Consulta los cups asociados a un consentimiento informado segun el codigo del formato
     * @param mixed $datos
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function consultarCupFormato($datos)
    {
        try{
            $cups = $this->consentimientosInformadosRepository->consultarCupFormato($datos['codigo']);

            return $cups->paginate($datos['cant'],['*'],'page',$datos['page']);
        }catch(\Throwable $th){
            throw $th;
        }
    }

    /**
     * Elimina el registro del consentimiento informado por segun el cup id pasado
     * @param mixed $cupId
     * @return bool|null
     */
    public function eliminarCup($cupId)
    {
        try{
            return $this->consentimientosInformadosRepository->eliminarCup($cupId);
        }catch(\Throwable $th){
            throw $th;
        }
    }
}
