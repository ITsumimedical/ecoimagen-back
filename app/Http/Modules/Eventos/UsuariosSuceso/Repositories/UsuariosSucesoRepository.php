<?php

namespace App\Http\Modules\Eventos\UsuariosSuceso\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\UsuariosSuceso\Models\UsuariosSuceso;
use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UsuariosSucesoRepository extends RepositoryBase
{

    public function __construct(private UsuariosSuceso $usuariosSuceso) {}

    /**
     * Asigna un usuario a un suceso si no está asignado
     * @param  $data ['suceso_id', 'user_id']
     * @return UsuariosSuceso model
     * @author AlejoSR
     */
    public function asignarUsuarioSuceso(array $datos): UsuariosSuceso
    {
            return $this->usuariosSuceso->create($datos);
    }

    /**
     * Retorna el registro que coincida con el usuario y suceso dado
     * @param int $suceso_id
     * @param int $user_id
     * @return object|UsuariosSuceso|\Illuminate\Database\Eloquent\Model|null
     */
    public function obtenerUsuarioSuceso(int $suceso_id, int $user_id){
        return $this->usuariosSuceso->where('suceso_id', $suceso_id)
            ->where('user_id', $user_id)
            ->first();
    }

    /**
     * Regresa todos los usuarios y sucesos asociados que no son por defecto
     * @return 
     * @author AlejoSR
     */
    public function obtenerSucesosUsuarios(){
        return $this->usuariosSuceso->where('usuario_defecto',false)->get();
    }
    

    /**
     * Lista los usuarios que estan asociados a un suceso y los agrupa por suceso y los regresa en formato json
     * @return 
     * @author AlejoSR
     */
    public function listarUsuarioSuceso()
    {

            return $this->usuariosSuceso
            ->select(
                'sucesos.id as suceso_id',
                'sucesos.nombre as suceso_nombre',
                DB::raw("json_agg(json_build_object('id', users.id, 'suceso_id', sucesos.id, 'nombre', CONCAT(operadores.nombre,' ',operadores.apellido))) as usuarios")
            )
            ->from('usuarios_sucesos')
            ->join('users', 'usuarios_sucesos.user_id', '=', 'users.id')
            ->join('operadores','users.id','=','operadores.user_id')
            ->join('sucesos', 'usuarios_sucesos.suceso_id', '=', 'sucesos.id')
            ->where('usuario_defecto', false)
            ->groupBy('sucesos.id', 'sucesos.nombre')
            ->get();

    }

    /**
     * Elimina el registro en la tabla segun el modelo que se le pase
     * @param UsuariosSuceso $model
     * @return bool|null
     * @author AlejoSR
     */
    public function eliminarRegistroSuceso(UsuariosSuceso $usuarioSuceso): bool|null
    {
            return $usuarioSuceso->delete();
    }

    /**
     * Elimina todos los usuarios asignados a un suceso
     * @param int $suceso_id
     * @return bool|string
     */
    public function eliminarSuceso(int $suceso_id): bool|string
    {

            return $this->usuariosSuceso->where('suceso_id', $suceso_id)->delete();
         
    }

    /**
     * Devuelve los id de los usuarios asignados a un suceso
     * @param int $suceso_id
     * @return array
     * @author AlejoSR
     */
    public function listarUsuariosPorSuceso(int $suceso_id): array
    {
        
            return $this->usuariosSuceso->select(['id', 'user_id'])->where('usuario_defecto', false)
                ->where('suceso_id', $suceso_id)->pluck('user_id')->toArray();
            
    }

    /**
     * Lista todos los usuarios que estén asociados por defecto (columna usuario_defecto true)
     * @return Collection|UsuariosSuceso[]
     */
    public function obtenerUsuariosDefecto(): array|Collection{
        return $this->usuariosSuceso->where('usuario_defecto',true)->get();
    }

    /**
     * Crea un usuario por defecto para asignar a todos los sucesos
     * @param array $data [suceso_id = null, user_id , usuario_defecto = true]
     * @return bool|string
     */
    public function asignarUsuarioDefecto(array $data)
    {

            return $this->usuariosSuceso->create($data);

    }


    /**
     * Lista los usuarios que se asignaron por defecto a los sucesos trayendo id, user_id, usuario
     * @return array|Collection
     * @author AlejoSR
     */
    public function listarUsuarioDefecto(): array|Collection
    {
    
            return $this->usuariosSuceso->select(['id', 'user_id'])->with(['usuario:id', 'usuario.operador:id,user_id,nombre,apellido'])
                ->where('usuario_defecto', true)
                ->get();
    }


    /**
     * Devuelve los id de los usuarios asignados por defecto
     * @return array
     * @author AlejoSR
     */
    public function usuariosPorDefecto()
    {
        return $this->usuariosSuceso->where('usuario_defecto', true)->pluck('user_id')->toArray();
    }
}
