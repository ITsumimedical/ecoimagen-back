<?php

namespace App\Http\Modules\Whooley\Services;

use App\Http\Modules\Whooley\Model\whooley;

class WhooleyService {

    public function __construct(
        protected whooley $cuestionarioWhooleyModel,
    ) {}

    public function updateOrCreate(array $campos, array $data)
{
    return Whooley::updateOrCreate($campos, $data);
}

}
