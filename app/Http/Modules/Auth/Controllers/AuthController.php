<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Auth\Request\AuthLoginRequest;
use App\Http\Modules\LoguinSession\Models\login_session;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Usuarios\Repositories\UsuarioRepository;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(
        private UsuarioRepository $usuarioRepository,
    ) {
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            /** realizamos la autenticacion */
            if (!Auth::guard('web')->attempt($request->only(['email', 'password']))) {
                throw new Error('El email o contraseña incorrecta!', 422);
            }
            /** consultamos y validamos que el usuario este activo */
            $usuario = User::where('email', $request->email)
                ->with([
                    'afiliado.medico.operador',
                    'afiliado.ips.prestadores',
                    'operador',
                ])
                ->first();

            if (!$usuario->activo) {
                throw new Error('El usuario no se encuentra activo!', 403);
            }
            /** generamos el token */
            $tokenResult = Auth::guard('web')->user()->createToken('TokenHorusHealth2022');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addDays(1);
            $token->save();
            /** Obtenemos los permisos y generamos el esquema(data) del usuario autenticado */
            $user = [
                'permissions' => $usuario->getAllPermissions()->pluck('name'),
                'roles' => $usuario->roles->pluck('name'),
                'entidad' => $usuario->entidad,
                'id' => $usuario->id,
                'email' => $usuario->email,
                'tipo_usuario' => $usuario->tipo_usuario_id,
                'datosUsuarioLogueado' => $usuario->empleado,
                'operador' => $usuario->operador,
                // 'cargo' => $usuario->operador->cargo,
                'datosAfiliado' => $usuario->afiliado,
                'password_changed_at' => $usuario->password_changed_at,
            ];

            return response()->json([
                'token_type' => 'Bearer',
                'token' => $tokenResult->accessToken,
                'usuario' => $user,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * logout (cerrar sesion)
     * Autor: Calvarez
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'La sesión fue cerrada con exito!'
        ]);
    }

    /**
     * Retorna el usuario logueado
     * @author Manuela
     * @return json
     */
    public function me()
    {
        try {
            $usuario = $this->usuarioRepository->me();
            return response()->json($usuario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener el usuario autenticado',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * obtienes los usuarios activos
     * @return JsonResponse
     * @author David Peláez
     */
    public function getUsuariosActivos()
    {
        try {
            $usuariosCount = $this->usuarioRepository->getUsuariosActivos();
            return response()->json($usuariosCount);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Error al obtener los usuarios activos',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
