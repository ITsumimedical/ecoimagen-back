<?php

namespace App\Http\Modules\Usuarios\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Empleados\Repositories\EmpleadoRepository;
use App\Http\Modules\Empleados\Services\EmpleadoService;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Operadores\Repositories\OperadorRepository;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\AdjuntoUsuario;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Usuarios\Repositories\AdjuntoUsuarioRepository;
use App\Http\Modules\Usuarios\Repositories\UsuarioRepository;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mail;

class UsuarioService
{
    use ArchivosTrait;

    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private EmpleadoRepository $empleadoRepository,
        private AfiliadoRepository $afiliadoRepository,
        private OperadorRepository $operadorRepository,

    ) {
    }

    /**
     * Registro de usuarios en la plataforma segun tipo usuario
     *
     * @param  $request
     * @return void
     * @author calvarez
     */
    public function guardar($request)
    {

        // Encriptar la contraseña usando el documento
        $request['password'] = bcrypt($request['documento']);
        // Establecer el tipo de usuario a 3
        $request['tipo_usuario_id'] = 3;
        // Crear el nuevo usuario
        $nuevoUsuario = $this->usuarioRepository->crearUsuario($request);
        // Establecer el ID del usuario en el request
        $request['user_id'] = $nuevoUsuario['id'];
        // Crear el operador correspondiente
        $operador = $this->operadorRepository->crearOperador($request);
        // Encontrar el usuario creado
        $user = User::find($nuevoUsuario['id']);

        // Verificar si hay una firma en el request
        if (isset($request['firma']) && !empty($request['firma'])) {
            $file = $request['firma'];


            if ($file) {
                $name = $file->getClientOriginalName();
                $pathdb = '/storage/app/public/firmas/' . $request['documento'] . '/' . $name;
                $path = storage_path('app/public/firmas/' . $request['documento']);


                $file->move($path, $name);
                $user->update(['firma' => $pathdb]);
            }
        }

        // Retornar el operador creado
        return $operador;
    }


    public function cambioContrasenia(Request $request)
    {

        $request['password'] = bcrypt($request['password']);
        $usuario = User::find(auth()->id());
        $usuario->update(['password' => $request['password']]);
    }

    public function actualizacionContrasena(Request $request)
    {
        $usuario = User::find($request->user_id);

        if (!$usuario) {
            throw new Error('Usuario no encontrado', 404);
        }

        $tiempoToken = now()->diffInHours($usuario->token_created_at);

        if ($tiempoToken > 24) {
            throw new Error('Token expirado', 401);
        }

        if (trim($usuario->remember_token) !== trim($request->token)) {
            throw new Error('Token inválido', 401);
        }

        $request['nuevaContrasena'] = bcrypt($request['nuevaContrasena']);
        $usuario->update(['password' => $request['nuevaContrasena']]);

        $usuario->remember_token = null;
        $usuario->token_created_at = null;
        $usuario->save();

        return true;

    }

    public function actualizar(User $usuario, $request)
    {
        try {
            $usuario->fill($request->except('password'));

            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
            }

            // Verificar si hay una firma en el request
            if (isset($request['firma']) && !empty($request['firma'])) {
                $file = $request['firma'];

                if ($file) {
                    $name = $file->getClientOriginalName();
                    $pathdb = '/storage/app/public/firmas/' . $request['documento'] . '/' . $name;
                    $path = storage_path('app/public/firmas/' . $request['documento']);

                    // Crear el directorio si no existe
                    if (!file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    // Mover el archivo al directorio
                    $file->move($path, $name);
                    $usuario->firma = $pathdb;
                }
            }

            $this->usuarioRepository->guardar($usuario);

            $rep = Rep::where('id', $request->reps_id)->first();
            $operador = $usuario->operador;

            if ($operador) {
                $operador->fill([
                    'rep_id' => $rep->id,
                    'prestador_id' => $rep->prestador_id,
                    'nombre' => $request->input('nombre'),
                    'apellido' => $request->input('apellido'),
                    'tipo_doc' => $request->input('tipo_doc'),
                    'documento' => $request->input('documento'),
                    'registro_medico' => $request->input('registro_medico'),
                    'cargo_id' => $request['cargo_id'],
                    'email_recuperacion' => $request->input('email_recuperacion'),
                    'telefono_recuperacion' => $request->input('telefono_recuperacion'),
                ]);
                $this->operadorRepository->guardar($operador);
            } else {
                $operador = Operadore::create([
                    'user_id' => $usuario->id,
                    'rep_id' => $rep->id,
                    'prestador_id' => $rep->prestador_id,
                    'nombre' => $request->input('nombre'),
                    'apellido' => $request->input('apellido'),
                    'tipo_doc' => $request->input('tipo_doc'),
                    'documento' => $request->input('documento'),
                    'registro_medico' => $request->input('registro_medico'),
                    'cargo_id' => $request->input('cargo_id'),
                    'email_recuperacion' => $request->input('email_recuperacion'),
                    'telefono_recuperacion' => $request->input('telefono_recuperacion'),
                ]);
            }

            return $usuario;
        } catch (\Throwable $th) {
            throw new \Exception('Error al actualizar usuario y operador: ' . $th->getMessage());
        }
    }


    public function agregarEntidad(Request $request, User $id)
    {
        foreach ($request->entidad_id as $entidad) {
            $id->entidad()->attach($entidad);
        }

        return $request->entidad_id;
    }

    public function removerEntidad(Request $request, User $id)
    {
        foreach ($request->entidad_id as $entidad) {
            $id->entidad()->detach($entidad);
        }

        return $request->entidad_id;
    }

    public function agregarEspecialidad(Request $request, User $id)
    {
        foreach ($request->especialidad_id as $especialidad) {
            $id->especialidades()->attach($especialidad);
        }

        return $request->especialidad_id;
    }

    public function removerEspecialidad(Request $request, User $id)
    {
        foreach ($request->especialidad_id as $especialidad) {
            $id->especialidades()->detach($especialidad);
        }

        return $request->especialidad_id;
    }

    public function cambiarEstado($id)
    {
        $user = User::findOrFail($id);
        $user->activo = !$user->activo;
        $user->save();
    }

    public function listarOperadoresActivos()
    {
        return Operadore::join('users', 'operadores.user_id', '=', 'users.id')
            ->where('users.activo', true)
            ->select('operadores.nombre', 'operadores.apellido', 'operadores.id', 'operadores.documento', 'operadores.user_id')
            ->whereNotNull('operadores.registro_medico')
            ->get();
    }

    public function editarInfoPerfil($request)
    {
        $usuario = User::findOrFail($request->usuarioId);

        if ($usuario->tipo_usuario_id === 2) {
            // Afiliado
            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
                $usuario->save();
            }

            $afiliado = $usuario->afiliado;

            if ($request->filled('email_recuperacion')) {
                $afiliado->correo1 = $request->email_recuperacion;
            }

            if ($request->filled('telefono_recuperacion')) {
                $afiliado->celular1 = $request->telefono_recuperacion;
            }

            $afiliado->save();

            // Crear la novedad
            $novedad = new NovedadAfiliado();
            $novedad->fecha_novedad = Carbon::now();
            $novedad->motivo = 'Actualización de datos desde Perfil';
            $novedad->afiliado_id = $afiliado->id;
            $novedad->user_id = auth()->user()->id;
            $novedad->tipo_novedad_afiliados_id = 4; // Novedad de actualización de datos
            $novedad->estado = true;
            $novedad->save();
        } else {
            // Operador
            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
                $usuario->save();
            }

            $operador = Operadore::where('user_id', $request->usuarioId)->firstOrFail();

            if ($request->filled('nombre')) {
                $operador->nombre = $request->nombre;
            }

            if ($request->filled('apellido')) {
                $operador->apellido = $request->apellido;
            }

            if ($request->filled('email_recuperacion')) {
                $operador->email_recuperacion = $request->email_recuperacion;
            }

            if ($request->filled('telefono_recuperacion')) {
                $operador->telefono_recuperacion = $request->telefono_recuperacion;
            }

            $operador->save();
        }
    }

    /**
     * Actualizar la contraseña de un usuario
     * @param int $userId
     * @param array $data
     * @return bool
     * @throws ValidationException
     * @author Thomas
     */
    public function actualizarContrasenaUsuario(int $userId, array $data): bool
    {
        $usuario = $this->usuarioRepository->buscar($userId);

        if (Hash::check($data['password'], $usuario->password)) {
            throw ValidationException::withMessages([
                'password' => ['La nueva contraseña no puede ser igual a la actual.'],
            ]);
        }

        return $usuario->update([
            'password' => bcrypt($data['password']),
            'password_changed_at' => now(),
        ]);
    }

    /**
     * Elimina la cache asociada al usuario
     * @param int $id
     * @return bool
     */
    public function eliminarCacheUsuario(int $id)
    {
        return Cache::forget("usuario:$id");
    }

    /**
     * genera el codigo de recuperacion de funcionario (operador) y se guarda en cache ligado al  
     * funcionario buscado
     * @param array $request
     * @return int
     * @author jose vas
     */
    public function codigoRecuperacionFuncionario(array $request): int
    {
        $email = $request['email'];
        $documento = $request['documento'];

        $usuario = $this->usuarioRepository->buscarFuncionario($email, $documento);

        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('codigo_funcionario_' . $usuario->id, $codigo, now()->addMinutes(30));

        $mensaje = "Tu código de Recuperacion para ingresar a Horus es: {$codigo}, Usalo para completar tu proceso. No lo compartas con nadie. Este código es válido por 30 minutos.";

        $datos = [
            'mensajePrincipial' => 'Recuperacion contraseña',
            'parrafo' => $mensaje
        ];

        Mail::send('recuperacion_contrasena_funcionario', $datos, function ($message) use ($email) {
            $message->to($email)
                ->subject('Notificación - Recuperacion contraseña');
        });

        return $usuario->id;
    }

    /**
     * valida el codigo de recuperacion ingresado por el Funcionario
     * @param array $request
     * @throws \Exception
     * @return true
     * @author jose vasquez
     */
    public function validarCodigoRecuperacion(array $request): bool
    {
        $email = $request['email'];
        $documento = $request['documento'];
        $codigoIngresado = $request['codigo_ingresado'];

        $usuario = $this->usuarioRepository->buscarFuncionario($email, $documento);

        $codigoGuardado = Cache::get('codigo_funcionario_' . $usuario->id);

        if (!$codigoGuardado) {
            throw new Exception('El código ha expirado', 422);
        }

        if (intval($codigoGuardado) !== intval($codigoIngresado)) {
            throw new Exception('¡ Codigo ingresado incorrecto !', 422);
        }

        return true;
    }
}
