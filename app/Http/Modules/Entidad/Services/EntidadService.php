<?php
namespace App\Http\Modules\Entidad\Services;

use App\Http\Modules\Entidad\Repositories\EntidadRepository;
use Illuminate\Support\Facades\Auth;

class EntidadService
{

    protected $Reposotory;

        public function __construct(){
            $this->Reposotory = new EntidadRepository();
        }

        public function prepararData($data) {
            $data['user_id'] = Auth::id();
            return $data;
         
        }

}