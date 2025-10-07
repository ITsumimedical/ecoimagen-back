<?php
namespace App\Http\Modules\PqrsfTipoSolicitud\Services;

use App\Http\Modules\PqrsfTipoSolicitud\Repositories\PqrsfTipoSolicitudRepository;
use Illuminate\Support\Facades\Auth;

class PqrsfTipoSolicitudService
{
    protected $tipoSolicitudRepository;

    public function __construct(){
        $this->tipoSolicitudRepository = new PqrsfTipoSolicitudRepository();
    }

    public function prepararData($data){
        $data['user_id'] = Auth::id();
        return $data;
    }

}