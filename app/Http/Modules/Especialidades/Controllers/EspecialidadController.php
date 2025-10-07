<?php

namespace App\Http\Modules\Especialidades\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Especialidades\Repositories\EspecialidadRepository;
use App\Http\Modules\Especialidades\Requests\ActualizarEspecialidadRequest;
use App\Http\Modules\Especialidades\Requests\AgregarCupRequest;
use App\Http\Modules\Especialidades\Requests\GestionarGruposEspecialidadRequest;
use App\Http\Modules\Especialidades\Requests\GuardarEspecialidadRequest;
use App\Http\Modules\Especialidades\Requests\MarcarEspecialidadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EspecialidadController extends Controller
{
    protected $especialidadRepository;

    public function __construct(EspecialidadRepository $especialidadRepository)
    {
        $this->especialidadRepository = $especialidadRepository;
    }

    /**
     * lista las especialidades
     *
     * @return void
     */
    public function listar(Request $request)
    {
        $especialidades = $this->especialidadRepository->listarEspecialidades($request);
        try {
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarTodas(Request $request)
    {
        $especialidades = $this->especialidadRepository->listarTodas($request);
        try {
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function especialidadesEmpleados(Request $request)
    {
        try {
            $especialidadEmpleados = $this->especialidadRepository->especialidadEmpleados($request);
            return response()->json($especialidadEmpleados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las especialidades con sus respectivos Medicos y citas filtrados deacuerdo
     * a las entidades del usuario logueado
     *
     * @return void
     * @author Manuela
     */
    public function listarEspecialidadesConMedicos()
    {
        try {
            $user_id = auth()->id();
            $especialidades = $this->especialidadRepository->listarEspecialidadesConMedicos($user_id);
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarEspecialidad(Request $request)
    {
        try {
            $especialidades = $this->especialidadRepository->eliminarEspecialidad($request);
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * guarda un especialidad
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function crear(GuardarEspecialidadRequest $request)
    {
        try {
            $nuevaEspecialidad = new Especialidade($request->all());
            $especialidad = $this->especialidadRepository->guardar($nuevaEspecialidad);
            return response()->json([
                'res' => true,
                'data' => $especialidad,
                'mensaje' => 'Especialidad creada con exito!.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las especialidades!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualiza un especialidad según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * author Calvarez
     */
    public function actualizar(ActualizarEspecialidadRequest $request, int $id)
    {
        try {
            $especialidad = $this->especialidadRepository->buscar($id);
            $especialidad->fill($request->all());
            $actualizarEspecialidad = $this->especialidadRepository->guardar($especialidad);
            return response()->json([
                'res' => true,
                'data' => $actualizarEspecialidad,
                'mensaje' => 'Se actualizo con exito la especialidad!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar especialidad!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los Medicos deacuerdo a las entidades del usuario logueado
     *
     * @return void
     * @author Manuela
     */
    public function especialidadMedico(Request $request)
    {
        try {
            $user_id = auth()->id();
            $especialidad = $this->especialidadRepository->especialidadMedico($request->especialidad_id, $user_id);
            return response()->json($especialidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista las especialidades de citas deacuerdo a las entidades del usuario logueado
     *
     * @return void
     * @author Manuela
     */
    public function especialidadCita(Request $request)
    {
        try {
            $user_id = auth()->id();
            $especialidad = $this->especialidadRepository->especialidadCita($request->especialidad_id, $user_id);
            return response()->json($especialidad, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarMedicosYAuxiliares(Request $request, $especialidad_id)
    {
        try {
            $medicos = $this->especialidadRepository->listarMedicosYauxiliares($especialidad_id);
            return response()->json($medicos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEspecialidadesPorMedico($user_id)
    {
        try {
            $especialidades = $this->especialidadRepository->listarEspecialidadesPorMedico($user_id);
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * marca de telesalud
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * author jdss
     */

    public function cambiarMarca(MarcarEspecialidadRequest $request, int $id)
    {
        try {
            $especialidades = $this->especialidadRepository->cambiarMarca($request->validated(), $id);
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista las especialidades  marca de telesalud
     *
     * @return JsonResponse
     * author jdss
     */

    public function listarEspecialidadesTelesalud()
    {
        try {
            $especialidades = $this->especialidadRepository->listarEspecialidadesTelesalud();
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un cup en la especialidad
     *
     * @return JsonResponse
     * author jdss
     */
    public function guardarCup(AgregarCupRequest $request)
    {
        try {
            $especialidades = $this->especialidadRepository->guardarCup($request->validated());
            return response()->json($especialidades, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Agrega grupos a una especialidad
     * @param GestionarGruposEspecialidadRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function agregarGrupos(GestionarGruposEspecialidadRequest $request): JsonResponse
    {
        try {
            $response = $this->especialidadRepository->agregarGrupos($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Obtiene los grupos de una especialidad
     * @param int $especialidad_id
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarGruposEspecialidad(int $especialidad_id): JsonResponse
    {
        try {
            $grupos = $this->especialidadRepository->listarGruposEspecialidad($especialidad_id);
            return response()->json($grupos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function eliminarGrupos(GestionarGruposEspecialidadRequest $request): JsonResponse
    {
        try {
            $response = $this->especialidadRepository->eliminarGrupos($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
