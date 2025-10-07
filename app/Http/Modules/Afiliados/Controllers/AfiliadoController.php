<?php

namespace App\Http\Modules\Afiliados\Controllers;

use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;
use App\Jobs\NotificacionSmsAfiliado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Afiliados\Requests\ActualizarAdmisionRequest;
use App\Http\Modules\Afiliados\Requests\ActualizarAfiliadoHistoriaRequest;
use App\Http\Modules\Afiliados\Requests\ActualizarAfiliadoRequest;
use App\Http\Modules\Afiliados\Requests\ActualizarDatosContactoRequest;
use App\Http\Modules\Afiliados\Requests\CrearAfiliadoAdmisionRequest;
use App\Http\Modules\Afiliados\Requests\CrearAfiliadoAseguramientoRequest;
use App\Http\Modules\Afiliados\Requests\CrearAfiliadoRequest;
use App\Http\Modules\Afiliados\Requests\ValidacionRedVitalRequest;
use App\Http\Modules\Afiliados\Services\AfiliadoService;
use App\Http\Requests\ValidarParentescoRequest;
use App\Http\Requests\VerificarAfiliadoRequest;
use Illuminate\Support\Arr;
use Rap2hpoutre\FastExcel\FastExcel;

class AfiliadoController extends Controller
{
    protected $afiliadorepository;
    protected $afiliadoService;

    public function __construct(AfiliadoRepository $afiliadorepository, AfiliadoService $afiliadoService, private NovedadAfiliadoRepository $novedadAfiliadorepository)
    {
        $this->afiliadorepository = $afiliadorepository;
        $this->afiliadoService = $afiliadoService;
    }

    /**
     * lista los afiliados
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $afiliado = $this->afiliadorepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $afiliado
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los afiliados',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un afiliado
     * @param $request
     * @param int $id
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarAfiliadoRequest $request, Afiliado $afiliado_id)
    {
        try {
            $afiliado = $this->afiliadorepository->actualizar($afiliado_id, $request->validated());
            $this->novedadAfiliadorepository->crearNovedadAfiliado($afiliado_id->id, $request);
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un afiliado
     * @param $request
     * @param int $id
     * @return Response
     * @author Manuela
     */
    public function actualizarAfiliado(ActualizarAfiliadoRequest $request, $afiliado_id)
    {
        try {
            $consulta = $this->afiliadorepository->actualizarAfiliado($afiliado_id, $request->all());
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarHistoria(ActualizarAfiliadoHistoriaRequest $request, Afiliado $id)
    {
        try {
            $afiliado = $this->afiliadorepository->actualizar($id, $request->validated());
            $this->novedadAfiliadorepository->crearNovedadAfiliado($id->id, $request);
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado(Request $request, int $estado_id): JsonResponse
    {
        try {
            $estado = $this->afiliadorepository->cambiarEstado($request, $estado_id);
            return response()->json([
                'res' => true,
                'data' => $estado,
                'mensaje' => 'El estado del afiliado fue cambiado con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar un afiliado y traer las citas asignadas
     * @param Request $request
     * @param string $cedula
     * @return Response
     * @author Calvarez
     * @overwrite David Peláez
     */
    public function consultar($cedula, $tipoDocumento)
    {
        try {
            $afiliados = $this->afiliadorepository->consultarDatosAfiliado($cedula, $tipoDocumento);

            if ($afiliados->count() < 1) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }

            $result = $afiliados->count() === 1 ? $afiliados[0] : $afiliados;

            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarAfiliados($cedula, $tipoDocumento)
    {
        try {
            $afiliados = $this->afiliadorepository->consultarAfiliados($cedula, $tipoDocumento);

            if ($afiliados->count() < 1) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }

            $result = $afiliados->count() === 1 ? $afiliados[0] : $afiliados;

            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar los beneficiarios de un afiliado
     * @param Request $request
     * @param string $cedula
     * @return Response
     * @author kobatime
     */
    public function buscarBeneficiarios($cedula)
    {
        try {
            $afiliado = $this->afiliadorepository->consultar('numero_documento', $cedula);
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al consultar el afiliado!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para procedimientos actualizacion masiva afiliados
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function procedimientoActualizacion(Request $request)
    {
        try {
            $afiliado = $this->afiliadoService->actualizarNovedades($request);
            return response()->json($afiliado);
        } catch (\Exception $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para marcar los pacientes
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function crearMarcacion(int $id, Request $request)
    {
        $afiliado = $this->afiliadorepository->buscar($id);
        if ($afiliado->tutela == false) {
            try {
                $afiliado = $this->afiliadoService->actualizarNovedades($request);
                return response()->json($afiliado);
            } catch (\Exception $th) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Error al intentar actualizar novedades!'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'res' => false,
                'mensaje' => 'Afiliado ya se encuentra marcado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para obtner informacion del afiliado para el modulo de solicitudes
     * @param Request $request
     * @return Response
     * @author jdss
     */
    public function validacionPacienteRedVital(ValidacionRedVitalRequest $request)
    {
        try {
            $afiliado = $this->afiliadoService->validacionRedVital($request->validated());
            return response()->json($afiliado);
        } catch (\Exception $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos($cedula, $tipo_documento)
    {
        try {
            $afiliado = $this->afiliadorepository->afiliadosActivos($cedula, $tipo_documento);
            if (!$afiliado) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consulta un afiliado por documento
     * @param string $documento
     * @return Response
     * @author Manuela
     */
    public function consultarAfiliadoDocumento($documento)
    {
        try {
            $afiliado = $this->afiliadorepository->consultarAfiliadoDocumento($documento);
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se puede consultar el afiliado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Listar beneficiarios de un cotizante por numero de documento de cotizante.
     * @author Manuela
     * @param string $documento_afiliado
     * @return mixed
     */
    public function listarBeneficiariosPorDoc(string $documento_afiliado)
    {
        try {
            $beneficiarios = $this->afiliadorepository->listarBeneficiariosPorDoc($documento_afiliado);
            return response()->json($beneficiarios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cargar el grupo familiar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $cedula
     * @return Response
     * @author David Peláez
     */
    public function consultarAfiliado($cedula, $tipoDocumento)
    {
        try {
            $afiliado = $this->afiliadorepository->consultarAfiliado($cedula, $tipoDocumento);
            if (!$afiliado) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function grupoFamiliar(Request $request)
    {
        try {
            $afiliado = $this->afiliadorepository->listarGrupoFamiliar($request);
            return response()->json(
                $afiliado,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cargar el grupo familiar',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reporteRedAfiliados()
    {
        try {
            $afiliado = $this->afiliadorepository->reporteRedAfiliados();
            return (new FastExcel($afiliado))->download('file.xlsx');
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al descargar el reporte',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizacionPacientes(Request $request)
    {
        try {
            $afiliado = $this->afiliadorepository->actualizacionPacientes($request->all());
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar un afiliado por fuera del login.
     * Este método permite consultar la información de un afiliado sin necesidad de estar autenticado.
     *
     * @param Request $request La solicitud HTTP que contiene los parámetros de consulta.
     * @return Response Una respuesta JSON con los datos del afiliado o un mensaje de error si no se encuentra.
     * @author Calvarez
     * @modifiedBy kobatime 13 agosto 2024 se modificio todos los with
     */

    public function consultarWeb(Request $request)
    {
        try {
            // Se consulta la información del afiliado utilizando el repositorio correspondiente.
            $afiliado = $this->afiliadorepository->consultaWebAfiliado($request);

            // Si no se encuentra el afiliado, se devuelve una respuesta con un código 404 (No Encontrado).
            if (!$afiliado) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }

            // Si el afiliado se encuentra, se devuelve su información en formato JSON.
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            // En caso de error, se captura la excepción y se devuelve un mensaje de error con un código 400 (Solicitud Incorrecta).
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar los datos de un afiliado por fuera del login.
     * Este método permite actualizar la información de un afiliado sin necesidad de estar autenticado.
     *
     * @param Request $request La solicitud HTTP que contiene los datos a actualizar.
     * @return Response Una respuesta JSON con los datos actualizados del afiliado o un mensaje de error si no se encuentra.
     * @author Calvarez
     * @modifiedBy kobatime 13 agosto 2024 se modificio los comentarios
     */

    public function actualizarWeb(Request $request)
    {
        try {
            // Se actualiza la información del afiliado utilizando el repositorio correspondiente.
            $afiliado = $this->afiliadorepository->actualizacionPacientesWeb($request);

            // Si no se encuentra el afiliado, se devuelve una respuesta con un código 404 (No Encontrado).
            if (!$afiliado) {
                return response()->json(['error' => 'El afiliado no se encuentra registrado en la base de datos!'], Response::HTTP_NOT_FOUND);
            }

            // Si la actualización es exitosa, se devuelve la información actualizada en formato JSON.
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            // En caso de error, se captura la excepción y se devuelve un mensaje de error con un código 400 (Solicitud Incorrecta).
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearAfiliadoRequest $request)
    {
        try {
            $afiliado = $this->afiliadoService->crearAfiliado($request);
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function crearCaracterizacion(Request $request)
    {
        try {
            $caracterizacion = $this->afiliadorepository->crearOActualizarCaracterizacion($request);
            return response()->json($caracterizacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarAfiliadoCaracterizacion($numDoc, $tipoDoc)
    {
        try {
            $afiliado = $this->afiliadorepository->buscarAfiliadoCaracterizacion($numDoc, $tipoDoc);
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function registrarBeneficiario(Request $request)
    {
        try {
            $afiliadoExistente = Afiliado::where('tipo_documento', $request->beneficiario[0]['tipo_documento_id'])
                ->where('numero_documento', $request->beneficiario[0]['numero_documento'])
                ->first();

            if ($afiliadoExistente) {
                return response()->json(['res' => false, 'mensaje' => 'Ya existe un afiliado con este tipo de documento y número de documento.'], Response::HTTP_CONFLICT);
            }

            $this->afiliadorepository->registrarBeneficiario($request);
            return response()->json(['res' => true, 'mensaje' => 'Beneficiario registrado con éxito.'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Ocurrió un error al registrar el beneficiario',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los datos de contacto de un afiliado
     * @param mixed $afiliadoId
     * @param ActualizarDatosContactoRequest $request
     * @return JsonResponse|mixed
     */
    public function actualizarDatosContacto($afiliadoId, ActualizarDatosContactoRequest $request)
    {
        try {
            $afiliado = $this->afiliadorepository->actualizarDatosContacto($afiliadoId, $request->validated());
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verificar la existencia de un afiliado
     * @param mixed $numero_documento
     * @param mixed $tipo_documento
     * @return JsonResponse|mixed
     */
    public function verificarExistencia($numero_documento, $tipo_documento)
    {
        try {
            $respuesta = $this->afiliadorepository->verificarExistencia($numero_documento, $tipo_documento);

            return response()->json($respuesta);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear un nuevo afiliado, con su usuario, entidad, rol de autogestión y novedad
     * @param CrearAfiliadoAseguramientoRequest $request
     * @return JsonResponse|mixed
     */
    public function crearAfiliadoAseguramiento(CrearAfiliadoAseguramientoRequest $request)
    {
        try {
            $nuevoAfiliado = $this->afiliadorepository->crearAfiliadoAseguramiento($request->validated());
            return response()->json($nuevoAfiliado);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el afiliado',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarDireccion(Request $request, $id)
    {
        try {
            $this->afiliadoService->actualizarDireccionAfiliado($id, $request->nueva_direccion);
            return response()->json('Dirección actualizada con éxito');
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 500);
        }
    }

    /**
     * Actualizacion de un afiliado, exclusivamente los campos de urgencias
     * @param mixed $id
     * @param mixed $request
     * @return JsonResponse|mixed
     */
    public function actualizarAdmision(ActualizarAdmisionRequest $request, int $id)
    {
        try {
            $this->afiliadorepository->actualizarAdmision($id, $request->validated());
            return response()->json('Actualizada con éxito');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Creación de un afiliado, exclusivamente para la admision de una urgencia
     * @param mixed $id
     * @param mixed $request
     * @return JsonResponse|mixed
     */
    public function guardarAfiliadoAdmision(CrearAfiliadoAdmisionRequest $request)
    {
        try {
            $afiliado = $this->afiliadorepository->guardarAfiliadoAdmision($request->validated());
            return response()->json($afiliado);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista un afiliado por su id
     * @param int $afiliadoId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarAfiliadoPorId(int $afiliadoId): JsonResponse
    {
        try {
            $afiliado = $this->afiliadorepository->listarAfiliadoPorId($afiliadoId);
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al listar el afiliado'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * verificarEstado -
     * verifica si el afiliado cotizante que se intenta relacionar a un
     * beneficiario posee un estado de afiliación adecuado
     *
     * @param  string $cedula
     * @param  string $tipo_documento
     * @return void
     */
    public function verificarEstado(string $cedula, string $tipo_documento)
    {
        try {
            $afiliado = $this->afiliadorepository->verificarEstado($cedula, $tipo_documento);
            return response()->json($afiliado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se encontró el cotizante relacionado',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verificar existencia de afiliado por nombre y fecha de nacimiento
     * @param VerificarAfiliadoRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function verificarExistenciaPorNombreFecha(VerificarAfiliadoRequest $request): JsonResponse
    {
        try {
            $afiliado = $this->afiliadorepository->buscarPorNombreYFecha(
                $request->primer_nombre,
                $request->segundo_nombre,
                $request->primer_apellido,
                $request->segundo_apellido,
                $request->fecha_nacimiento
            );

            if ($afiliado) {
                throw new \Exception('Ya existe un afiliado con estos datos', 409);
            }

            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontró afiliado con estos datos'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error en la validación: Debe ingresar los nombres para validar si el afiliado existe'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * validarParentesco -
     * Valida que el cotizante no tenga ya un beneficiario con el mismo parentesco para evitar duplicados.
     * Realiza las siguientes validaciones:
     * - Verifica si el parentesco es "conyugue" o "companero". Si es así, valida que no haya otro beneficiario con el mismo parentesco.
     * - Verifica si el parentesco es "padre" o "madre". Si es así, valida que el cotizante no tenga ya dos beneficiarios con estos parentescos.
     *
     * @param  mixed $request
     * @return void
     */
    public function validarParentesco(ValidarParentescoRequest $request): JsonResponse
    {
        try {
            $this->afiliadoService->validarParentesco(
                $request->parentesco,
                $request->numero_documento_cotizante
            );

            return response()->json(['existe' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'existe' => true,
                'mensaje' => $e->getMessage()
            ], 422);
        }
    }

    public function buscarArchivos(int $id)
    {
        try {
            $archivos = $this->afiliadoService->adjuntosPorAfiliado($id);
            return response()->json($archivos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'ha ocurrido un error al buscar los archivos del Afiliado'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * le envia al afiliado un codigo de verificacion que tambien lo guarda en un campo llamado
     * notificacion_sms para ser validado, dispara un job
     * @param int $tipoDocumento
     * @param int $numeroDocumento
     * @return JsonResponse
     * @throws \Throwable
     * @author Jose vas
     */
    public function codigoAfiliadoHistorias(int $tipoDocumento, int $numeroDocumento): JsonResponse
    {
        try {
            NotificacionSmsAfiliado::dispatch($tipoDocumento, $numeroDocumento);
            return response()->json([
                'mensaje' => 'Se ha realizado el proceso de notificacion , Por favor espere su pensaje'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al enviar el codigo al Afiliado'
            ], Respose::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
