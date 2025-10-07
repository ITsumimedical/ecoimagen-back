<?php

namespace App\Http\Modules\TipoAfiliaciones\Services;

use App\Http\Modules\TipoAfiliaciones\Repositories\TipoAfiliacionRepository;
use Illuminate\Support\Facades\Auth;

class TipoAfiliacionService
{
    protected $tipoAfiliacionesRepository;

    public function __construct(){
        $this->tipoAfiliacionesRepository = new TipoAfiliacionRepository();
    }

    public function prepararData($data){
        $data['user_id'] = Auth::id();
        return $data;
    }

}
