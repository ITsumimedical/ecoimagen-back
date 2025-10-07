<?php

namespace App\Http\Modules\Usuarios\Controllers;

use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Usuarios\Requests\ActualizarContrasenaUsuarioRequest;
use App\Http\Modules\Usuarios\Requests\GenerarCodigoRecuperacionRequest;
use App\Http\Modules\Usuarios\Requests\ValidarCodigoOperadorRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\Notificaciones;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Usuarios\Services\UsuarioService;
use App\Http\Modules\Usuarios\Requests\CrearUsuarioRequest;
use App\Http\Modules\Empleados\Requests\CrearEmpleadoRequest;
use App\Http\Modules\Usuarios\Repositories\UsuarioRepository;
use App\Http\Modules\Usuarios\Requests\ActualizarUsuarioRequest;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{

    protected $usuarioRepository;
    protected $usuarioService;

    public function __construct(UsuarioRepository $usuarioRepository, UsuarioService $usuarioService)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->usuarioService = $usuarioService;
    }

    /**
     * listar - lista los usuarios
     *
     * @param  mixed $request
     * @return void
     */
    public function listar(Request $request)
    {
        try {
            $usuarios = $this->usuarioRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $usuarios
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearUsuarioRequest $request)
    {
        try {
            $usuario = $this->usuarioService->guardar($request->validated());
            broadcast(new Notificaciones('usuario creado con exito'));
            return response()->json([
                $usuario,
                'mensaje' => 'usuario creado'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar crear el usuario!',
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * actualizar - actualiza un usuario segun su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function actualizar(ActualizarUsuarioRequest $request, int $id)
    {
        try {
            $usuario = $this->usuarioRepository->buscar($id);
            $userUpdate = $this->usuarioService->actualizar($usuario, $request);
            return response()->json([
                'res' => true,
                'data' => $userUpdate,
                'mensaje' => 'El usuario fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function usuarioLogeado()
    {
        try {
            $user = $this->usuarioRepository->usuarioLogeado();
            return response()->json($user, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Error al consultar el usuario autenticado!'
            ]);
        }
    }

    /**
     * agregarPermiso - agrega permisos a un usuario
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function agregarPermiso(Request $request, User $id)
    {
        try {
            $nuevosPermisos = $request->input('permissions', []);

            if (!is_array($nuevosPermisos)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El formato de los permisos es inválido.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $validPermissions = Permission::whereIn('id', $nuevosPermisos)->pluck('name')->toArray();

            if (empty($validPermissions)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Permisos no válidos.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $permisosPrevios = $id->permissions->pluck('name')->toArray();
            $permisosDuplicados = array_intersect($permisosPrevios, $validPermissions);

            if (!empty($permisosDuplicados)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El permiso con el nombre: ' . implode(', ', $permisosDuplicados) . ' ya está asignado.'
                ], Response::HTTP_BAD_REQUEST);
            }

            $id->givePermissionTo($validPermissions);
            $this->usuarioService->eliminarCacheUsuario($id->id);

            return response()->json([
                'res' => true,
                'data' => $id->permissions,
                'mensaje' => 'Permisos asignados al usuario con éxito!',
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al asignar permisos al usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * agregarRol - agrega roles a un usuario
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function agregarRol(Request $request, User $id)
    {
        try {
            // Asegurarnos de que 'roles' es un array plano de IDs
            $roles = $request->input('roles', []);

            if (!is_array($roles)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El formato de los roles es inválido.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Validar que los roles existan y sean un array plano
            $validRoles = Role::whereIn('id', $roles)->pluck('name')->toArray();

            if (empty($validRoles)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Roles no válidos.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Asignar roles al usuario sin eliminar los existentes
            foreach ($validRoles as $role) {
                if (!$id->hasRole($role)) {
                    $id->assignRole($role);
                }
            }

            return response()->json([
                'res' => true,
                'data' => $id->roles,
                'mensaje' => 'Roles asignados al usuario con éxito!',
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al asignar roles al usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerRol(Request $request, User $id)
    {
        try {
            $roles = $request->input('roles', []);

            if (!is_array($roles)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El formato de los roles es inválido.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $validRoles = Role::whereIn('id', $roles)->pluck('name')->toArray();

            if (empty($validRoles)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Roles no válidos.',
                ], Response::HTTP_BAD_REQUEST);
            }

            foreach ($validRoles as $role) {
                if ($id->hasRole($role)) {
                    $id->removeRole($role);
                }
            }

            return response()->json([
                'res' => true,
                'data' => $id->roles,
                'mensaje' => 'Roles removidos del usuario con éxito!',
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al remover roles del usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * removerPermiso - remueve permisos de un usuario
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function removerPermiso(Request $request, User $id)
    {
        try {
            $permisos = $request->input('permissions', []);

            if (!is_array($permisos)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'El formato de los permisos es inválido.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $validPermissions = Permission::whereIn('id', $permisos)->pluck('name')->toArray();

            if (empty($validPermissions)) {
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Permisos no válidos.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $id->revokePermissionTo($validPermissions);
            $this->usuarioService->eliminarCacheUsuario($id->id);

            return response()->json([
                'res' => true,
                'data' => $id->permissions,
                'mensaje' => 'Permisos removidos del usuario con éxito!',
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al remover permisos del usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agendaMedico(Request $request, $user)
    {

        $fecha = new Carbon($request->fecha);
        $year = $fecha->format('Y');
        $mes = $fecha->format('m');

        //dd($year);

        return Agenda::select(
            'agendas.id',
            'agendas.fecha_inicio',
            'agendas.fecha_fin',
            'agendas.estado_id',
            'citas.nombre as cita_nombre'
        )
            ->with([
                'consultas' => function ($query) {
                    $query->withTrashed();
                },
                'consultorio.rep'
            ])
            ->join('agenda_user', 'agendas.id', 'agenda_user.agenda_id')
            ->join('citas', 'agendas.cita_id', 'citas.id')
            ->where('agendas.estado_id', '!=', 2)
            ->where('agenda_user.user_id', $user)
            ->whereMonth('agendas.fecha_inicio', $mes)
            ->whereYear('agendas.fecha_inicio', $year)
            ->get();


        return Agenda::select('agendas.*')
            ->with([
                'consultas' => function ($query) {
                    $query->withTrashed();
                },
                'consultorio.rep'
            ])
            ->join('agenda_user as au', 'agendas.id', 'au.agenda_id')
            ->where('agendas.estado_id', '!=', 2)
            ->where('au.user_id', $user)

            ->whereMonth('fecha_inicio', $mes)
            ->whereYear('fecha_inicio', $year)
            //->orderby('agendas.id','DESC')
            //->take(100)
            ->get();
    }

    public function agendaMedicoCompleta(Request $request, $user)
    {
        $fecha = new Carbon($request->fecha);

        return Agenda::select(
            'agendas.id',
            'agendas.fecha_inicio',
            'agendas.fecha_fin',
            'agendas.estado_id',
            'agendas.consultorio_id',
            'citas.nombre as cita_nombre'
        )
            ->with(['consultas', 'consultorio.rep'])
            ->join('agenda_user', 'agendas.id', 'agenda_user.agenda_id')
            ->join('citas', 'agendas.cita_id', 'citas.id')
            ->where('agendas.estado_id', '!=', 2)
            ->where('agenda_user.user_id', $user)
            ->where('agendas.fecha_inicio', '>=', $fecha)
            ->get();
    }


    public function medicosActivos()
    {
        try {
            $funcionarios = User::select(['users.id', 'users.activo', 'e.nombre as especialidad'])->join('especialidade_user as eu', 'eu.user_id', 'users.id')->join('especialidades as e', 'e.id', 'eu.especialidade_id')
                ->join('operadores', 'operadores.user_id', 'users.id')->where('users.activo', 1)
                ->with('operador')->get();

            return response()->json([
                'res' => true,
                'data' => $funcionarios,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarUsuario(Request $request)
    {
        try {
            $usuario = $this->usuarioRepository->buscarUsuario($request);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function buscarRolesUsuario(int $user_id)
    {
        try {
            $usuario = $this->usuarioRepository->buscarRolUsuario($user_id);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar los roles.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function cambioContrasena(Request $request)
    {
        try {
            $this->usuarioService->cambioContrasenia($request);
            return response()->json([
                'mensaje' => 'Contraseña del usuario cambiada con exito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al cambiar contraseña del usuario.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizacionContrasena(Request $request)
    {
        try {
            $this->usuarioService->actualizacionContrasena($request);
            return response()->json([
                'mensaje' => 'Contraseña del usuario actualizada con exito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar contraseña del usuario.',
                'error' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function validarInformacion(Request $request)
    {
        try {
            $usuario = $this->usuarioRepository->validarInformacion($request);

            if (!$usuario) {
                return response()->json(['error' => 'Los datos ingresados no coinciden con un usuario registrado!'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($usuario);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agregarEntidad(Request $request, User $id)
    {
        try {
            $usuario = $this->usuarioService->agregarEntidad($request, $id);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al agregar la entidad al usuario!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerEntidad(Request $request, User $id)
    {
        try {
            $usuario = $this->usuarioService->removerEntidad($request, $id);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al remover la entidad del usuario!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function especialidad(Request $request)
    {
        try {
            $usuario = $this->usuarioRepository->especialidad($request);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al remover la entidad del usuario!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarConfiltro(Request $request)
    {
        try {
            $sede = $this->usuarioRepository->listarConfiltro($request);
            return response()->json($sede, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * lista la cantidad de usuarios logueados
     * @param Request $request
     * @author David Peláez
     */
    public function usuariosOn(Request $request)
    {
        try {
            $consulta = User::usuariosOn();
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function agregarEspecialidad(Request $request, User $id)
    {
        try {
            $usuario = $this->usuarioService->agregarEspecialidad($request, $id);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al remover la entidad del usuario!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerEspecialidad(Request $request, User $id)
    {
        try {
            $usuario = $this->usuarioService->removerEspecialidad($request, $id);
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al remover la entidad del usuario!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $cambiarEstado = $this->usuarioService->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al cambiar el estado del usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarOperadoresActivos(Request $request)
    {
        try {
            $operadores = $this->usuarioService->listarOperadoresActivos();
            return response()->json($operadores, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al listar los operadores activos!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editarInfoPerfil(Request $request)
    {
        try {
            $datosUsuario = $this->usuarioService->editarInfoPerfil($request);
            return response()->json($datosUsuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al editar la informacion del usuario!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarFirmaUsuario(Request $request, $id)
    {
        try {
            $firmaUsuario = $this->usuarioRepository->consultarFirmaUsuario($request->all(), $id);
            return response()->json($firmaUsuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un Error al Buscar la Firma'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function medicosCirujanos(Request $request)
    {
        $cirujanos = Operadore::select('operadores.*', 'eu.especialidade_id')->join('especialidade_user as eu', 'eu.user_id', 'operadores.user_id')
            ->where('eu.cirugia', 1)
            ->get();
        $especialidadCirugia = Especialidade::select(
            'especialidades.id',
            'especialidades.nombre',
        )->join('especialidade_user as eu', 'eu.especialidade_id', 'especialidades.id')
            ->where('eu.cirugia', 1)
            ->distinct()
            ->get();
        $registro = [
            'cirujanos' => $cirujanos,
            'especialidades' => $especialidadCirugia,
        ];
        return response()->json($registro);
    }

    /**
     * Actualizar la contraseña de un usuario
     * @param int $userId
     * @param ActualizarContrasenaUsuarioRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function actualizarContrasenaUsuario(int $userId, ActualizarContrasenaUsuarioRequest $request): JsonResponse
    {
        try {
            $response = $this->usuarioService->actualizarContrasenaUsuario($userId, $request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Se genera el codigo de recuperacion para el funcionario 
     * @param GenerarCodigoRecuperacionRequest $request
     * @return JsonResponse
     * @author jose vas
     */
    public function codigoRecuperacionFuncionario(GenerarCodigoRecuperacionRequest $request): JsonResponse
    {
        try {
            $codigo = $this->usuarioService->codigoRecuperacionFuncionario($request->validated());
            return response()->json($codigo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'ha ocurrido un error al generar el codigo de recuperacion'
            ], $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Valida el codigo ingresado por el operador al momento de recuperar su contrasena
     * @param ValidarCodigoOperadorRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author jose vasquez
     */
    public function validarCodigoRecuperacion(ValidarCodigoOperadorRequest $request): JsonResponse
    {
        try {
            $validacion = $this->usuarioService->validarCodigoRecuperacion($request->validated());
            return response()->json($validacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al validar el codigo de recuperacion'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
