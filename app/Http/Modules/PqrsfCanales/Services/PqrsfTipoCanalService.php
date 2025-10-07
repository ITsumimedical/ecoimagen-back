<?php
namespace App\Http\Modules\PqrsfCanales\Services;

use App\Http\Modules\PqrsfCanales\Repositories\PqrsfCanalRepository;
use Illuminate\Support\Facades\Auth;

class PqrsfTipoCanalService
{
    protected $tipoCanalRepository;

    public function __construct(){
        $this->tipoCanalRepository = new PqrsfCanalRepository();
    }

    public function prepararData($data){
        $data['user_id'] = Auth::id();
        return $data;
    }

}