<?php

namespace App\Http\Modules\Farmacovigilancia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Farmacovigilancia\Models\MensajesAlerta;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class MensajesAlertaRepository extends RepositoryBase {

    protected $modelMensaje;

    public function __construct(){
        $this->modelMensaje = new MensajesAlerta();
        parent::__construct($this->modelMensaje);
    }

    public function listarMensajes($data)
    {
        $consulta = $this->modelMensaje->select('mensajes_alertas.id','mensajes_alertas.titulo', 'mensajes_alertas.mensaje', 'mensajes_alertas.usuario_id', 'mensajes_alertas.estado_id')
            ->with(['usuario.operador', 'estado'])
            ->WhereTitulo($data->titulo)
            ->whereMensaje($data->Mensaje);

        return $data->page ? $consulta->paginate($data->cant) : $consulta->get();

    }

    public function crearMensaje($data)
    {
        $consulta = $this->modelMensaje->create([
            'titulo' => $data['titulo'],
            'mensaje' => $data['mensaje'],
            'usuario_id' => Auth::id(),
            'estado_id' => 1
        ]);
        return true;
    }

    public function cambiarEstado($mensaje_id)
    {
        $consulta = $this->modelMensaje->find($mensaje_id);
        if($consulta->estado_id == 1){
            $consulta->update([
                'estado_id' => 2
            ]);
        }else{
            $consulta->update([
                'estado_id' => 1
            ]);
        }
        return true;
    }

}
