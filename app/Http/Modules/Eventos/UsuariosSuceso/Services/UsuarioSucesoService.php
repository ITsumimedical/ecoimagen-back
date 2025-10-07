<?php

namespace App\Http\Modules\Eventos\UsuariosSuceso\Services;

use App\Http\Modules\Eventos\UsuariosSuceso\Repositories\UsuariosSucesoRepository;
use Error;
use Exception;
use Illuminate\Support\Collection;

class UsuarioSucesoService
{
    public function __construct(
        private UsuariosSucesoRepository $usuariosSucesoRepository
    ) {}


    /**
     * Asigna un suceso a un usuario luego de validad que no esté asignado
     * @param array $data
     * @throws \Exception
     * @return \App\Http\Modules\Eventos\UsuariosSuceso\Models\UsuariosSuceso
     * @author AlejoSR
     */
    public function asignarUsuarioSuceso(array $data)
    {
        try {
            #verificamos si el usuario ya está asignado al suceso
            $usuario = $this->usuariosSucesoRepository->obtenerUsuarioSuceso($data['suceso'], $data['usuario']);

            #si es asi, se envía excepción
            if ($usuario) {
                throw new Exception('El usuario ya está asignado a este suceso');
            }

            #de lo contrario, se crea la asignación
            $datos = [
                'suceso_id' => $data['suceso'],
                'user_id' => $data['usuario']
            ];

            return $this->usuariosSucesoRepository->asignarUsuarioSuceso($datos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Mapea la lista de usuarios asociados a un suceso para regresarlo en formato de arreglo asociativo
     * @return Collection
     * @author AlejoSR
     */
    public function listarUsuarioSuceso(): Collection
    {
        return $this->usuariosSucesoRepository->listarUsuarioSuceso()->map(function ($suceso) {
            return [
                'id' => $suceso->suceso_id,
                'nombre' => $suceso->suceso_nombre,
                'usuario' => json_decode($suceso->usuarios, true)
            ];
        });
    }

    /**
     * Elimina un usuario que está asignado a un suceso una vez verifica que si existe
     * @param int $suceso_id
     * @param int $usuario_id
     * @throws \Exception
     * @return bool|null
     */
    public function eliminarUsuarioSuceso(int $suceso_id, int $usuario_id): bool|null
    {
        try {
            #verificamos si el usuario ya está asignado al suceso
            $usuario = $this->usuariosSucesoRepository->obtenerUsuarioSuceso($suceso_id, $usuario_id);

            // dd($usuario);
            #si es asi, se envía excepción
            if (!$usuario) {
                throw new Exception('El usuario o suceso no estan asignados');
            }

            return $this->usuariosSucesoRepository->eliminarRegistroSuceso($usuario);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Crea un usuario para que se asigne por defecto
     * @param array $data
     * @throws \Exception
     * @return bool|string
     */
    public function asignarUsuarioDefecto(array $data)
    {
        try {
            #verificamos si el usuario ya está asociado por defecto
            $usuario = $this->usuariosSucesoRepository->obtenerUsuariosDefecto()
                ->where('user_id', $data['usuario'])
                ->first();

            if ($usuario) {
                throw new Exception('El usuario ya está asociado por defecto');
            }

            #si no, se asocian sus datos
            $datos = [
                'suceso_id' => null,
                'user_id' => $data['usuario'],
                'usuario_defecto' => true
            ];
            return $this->usuariosSucesoRepository->asignarUsuarioDefecto($datos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Lista los usuarios por defecto mapeados en formato id,user_id,usuario
     * @return array{id: mixed, user_id: mixed, usuario: mixed[]}
     */
    public function listarUsuarioDefecto()
    {

        #se listan los usuarios por fecto y se mapea para regresar la información requerida
        return $this->usuariosSucesoRepository->listarUsuarioDefecto()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'usuario' => $item->usuario->operador->nombre_completo
                ];
            })
            ->all();
    }


    public function eliminarUsuarioDefecto(int $id_usuario)
    {

        try {
            #obtenemos los usuarios por defecto registrados
            $usuario = $this->usuariosSucesoRepository->listarUsuarioDefecto();

            #si solo hay uno, se regresa excepción porque siempre debe haber al menos un usuario asociado por defecto
            if ($usuario->count() === 1) {
                throw new Exception('No se puede eliminar el último usuario asignado por defecto');
            }

            #se obtiene el usuario relacionado para eliminar
            $usuario = $usuario->where('user_id', $id_usuario)->first();

            if (!$usuario) {
                throw new Exception('El usuario no está asignado por defecto');
            }

            return $this->usuariosSucesoRepository->eliminarRegistroSuceso($usuario);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
