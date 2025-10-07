<?php

namespace App\Http\Modules\Aseguradores\Services;

use App\Http\Modules\Aseguradores\Repositories\AseguradorRepository;
use Illuminate\Support\Facades\Auth;

class AseguradorService {

        protected $Reposotory;

        public function __construct(){
            $this->Reposotory = new AseguradorRepository();
        }

        public function prepararData($data) {
            $data['user_id'] = Auth::id();
            return $data;
         
        }
}
