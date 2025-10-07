<?php

namespace App\Http\Modules\Chat\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Chat\Models\canal;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Chat\Models\mensaje;

class MensajeRepository extends RepositoryBase {

    protected $Model;

    public function __construct(){
        $this->Model = new mensaje();
        parent::__construct($this->Model);
    }

    public function guardarMensaje($data) {
        $data['user_id'] = Auth::id();
        $data['estado_id'] = 1;
        $mensaje = $this->model->create($data);

        $response = mensaje::where('id', $mensaje->id)->first();
        return $response;
    }

    public function chatsCentroRegulador($request)
    {
        $mensajes = $this->model::where('canal_id', $request->canal_id)->with('user')->get();
        return $mensajes;
    }


}
