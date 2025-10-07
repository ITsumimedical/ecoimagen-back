<?php
namespace App\Http\Modules\Clasificaciones\Services;

use App\Http\Modules\Clasificaciones\Repositories\ClasificacionRepository;
use Illuminate\Support\Facades\Auth;

class ClasificacionService
{
    protected $tipoMarcacionAfiliadoRepository;

    public function __construct(){
        $this->tipoMarcacionAfiliadoRepository = new ClasificacionRepository();
    }

    public function prepararData($data){
        $data['user_id'] = Auth::id();
        return $data;
    }

}