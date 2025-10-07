<?php
namespace App\Http\Modules\TipoAfiliados\Services;

use App\Http\Modules\TipoAfiliados\Repositories\TipoAfiliadoRepository;
use Illuminate\Support\Facades\Auth;

class TipoAfiliadoService
{
    protected $tipoAfiliadoRepository;

    public function __construct(){
        $this->tipoAfiliadoRepository = new TipoAfiliadoRepository();
    }

    public function prepararData($data){
        $data['user_id'] = Auth::id();
        return $data;
    }

}