<?php

namespace App\Http\Modules\Usuarios\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use League\Uri\UriTemplate\Operator;
use Illuminate\Support\Facades\Cache;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use Illuminate\Support\Facades\Redis;

class UsuarioRepository extends RepositoryBase
{

    private $usuarioModel;

    public function __construct(User $usuarioModel)
    {

        parent::__construct($usuarioModel);
        $this->usuarioModel = $usuarioModel;
    }

    public function usuarioLogeado(): object
    {
        $usuario = $this->usuarioModel->where('id', Auth::id())->first();
        $permisos = $usuario->getAllPermissions();
        return (object) [
            'permissions' => $permisos->pluck('name'),
            'roles' => $usuario->roles,
            'entidad' => $usuario->entidad,
            'id' => $usuario->id,
            'email' => $usuario->email,
            'tipo_usuario' => $usuario->tipo_usuario_id,
            'datosUsuarioLogueado' => $usuario->empleado,
            'operador' => $usuario->operador,
            'datosAfiliado' => $usuario->afiliado
        ];
    }

    public function buscarUsuario($data)
    {
        $consulta = $this->usuarioModel->with([
            'operador.cargo',
            'operador.rep',
            'tipoUsuario'
        ])->select('id', 'email', 'reps_id', 'tipo_usuario_id', "activo");

        if ($data->correo) {
            $consulta->where('users.email', $data->correo);
        }

        if ($data->documento) {
            $operador = Operadore::where('documento', $data->documento)->first();
            $consulta->where('id', $operador->user_id);
        }

        if ($data->nombre) {
            $consulta->whereHas('operador', function ($query) use ($data) {
                $query->where('nombre', 'ILIKE', '%' . $data->nombre . '%');
            });
        }

        if ($data->enfermeria) {
            $consulta->whereHas('operador', function ($query) use ($data) {
                $query->where('nombre', 'ILIKE', '%' . $data->nombre . '%')
                    ->whereIn('cargo_id', [128, 249]);
            });
        }

        return $data->page ? $consulta->paginate($data->cant) : $consulta->get();
    }

    /**
     * buscar los roles de un usuarios
     *
     * @param  mixed $request
     * @return void
     */
    public function buscarRolUsuario($user_id)
    {
        $consulta = $this->usuarioModel->with(['roles', 'permissions', 'entidad', 'especialidades'])->where('id', $user_id);
        return $consulta->get();
    }

    /**
     * Crear usuario segun el tipo
     *
     * @param  mixed $request
     * @return void
     */
    public function crearUsuario($request)
    {
        return $this->usuarioModel->create($request);
    }

    public function especialidad($data)
    {
        $usuario = $this->usuarioModel::find($data['user_id']);
        $usuario->especialidades()->sync($data['especialidad_id']);
    }

    public function listarConfiltro($request)
    {
        return Operadore::join('users', 'operadores.user_id', '=', 'users.id')
            ->where('users.activo', true)
            ->where(function ($query) use ($request) {
                $query->where('operadores.nombre', 'ILIKE', '%' . $request->funcionario . '%')
                    ->orWhere('operadores.apellido', 'ILIKE', '%' . $request->funcionario . '%');
            })
            ->select('operadores.nombre', 'operadores.apellido', 'operadores.id', 'operadores.documento', 'operadores.user_id')
            ->get();
    }

    public function validarInformacion($datos)
    {
        $usuario = $this->usuarioModel
            ->where('email', $datos->email)
            ->where('activo', true)
            ->leftJoin('operadores', 'users.id', '=', 'operadores.user_id')
            ->where('operadores.documento', $datos->documento)
            ->select('users.*', 'operadores.documento')
            ->first();

        if (!$usuario) {
            return null;
        }

        $token = Str::random(60);

        $usuario->remember_token = $token;
        $usuario->token_created_at = now();
        $usuario->save();

        $enlace = "https://horus-health.com/cambioContrasena?token=" . $token . "&user_id=" . $usuario->id;

        $subject = 'HORUS-HEALTH: SOLICITUD CAMBIO DE CONTRASEÑA';

        $viewData = [
            'email' => $datos->email,
            'enlace' => $enlace,
        ];

        Mail::send('email_cambio_contrasena', $viewData, function ($message) use ($datos, $subject) {
            $message->to($datos->email)
                ->subject($subject);
        });

        return $usuario;
    }

    public function consultarFirmaUsuario(array $data, int $id)
    {
        $consultarRutaFirma = $this->usuarioModel->where('id', $id)->get();

        if ($consultarRutaFirma[0]['firma']) {
            $firma = $consultarRutaFirma[0]['firma'];
            $relativePath = str_replace('storage/', '', $firma);
            $filePath = storage_path($relativePath);
            $imageData = base64_encode(file_get_contents($filePath));
            return $imageData;
        }
        return $consultarRutaFirma;
    }


    public function me(): array
    {
        $usuario = User::where('email', Auth::user()->email)->with(['afiliado.medico.operador', 'afiliado.ips.prestadores', 'operador.cargo:id,nombre'])->first();
        return [
            'permissions' => $usuario->getAllPermissions()->pluck('name'),
            'roles' => $usuario->roles->pluck('name'),
            'entidad' => $usuario->entidad,
            'id' => $usuario->id,
            'email' => $usuario->email,
            'tipo_usuario' => $usuario->tipo_usuario_id,
            'datosUsuarioLogueado' => $usuario->empleado,
            'operador' => $usuario->operador,
            'cargo' => $usuario->operador->cargo,
            'datosAfiliado' => $usuario->afiliado,
            'password_changed_at' => $usuario->password_changed_at,
        ];
    }

    /**
     * returna los usuarios activos
     * @author David Peláez
     * @return int
     */
    public function getUsuariosActivos()
    {
        $keys = Redis::keys('laravel_cache_:usuarios-activos:*');
        return count($keys);
    }

    /**
     * busca el funcionario por el correo y el documento ingresado
     * @param string $email
     * @param string $documento
     * @throws \Exception
     * @return Model|null
     * @author jose vasquez
     */
    public function buscarFuncionario(string $email, string $documento): ?Model
    {
        $usuario = $this->usuarioModel
            ->select('users.*')
            ->join('operadores', 'users.id', 'operadores.user_id')
            ->where('operadores.documento', $documento)
            ->where('operadores.email_recuperacion', $email)
            ->first();

        if (!$usuario) {
            throw new Exception('El funcionario no se encuentra registrado en la base de datos', 422);
        }

        return $usuario;

    }

}
