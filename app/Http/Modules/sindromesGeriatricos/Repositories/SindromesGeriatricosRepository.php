<?php

namespace App\Http\Modules\sindromesGeriatricos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\sindromesGeriatricos\Model\SindromesGeriatricos;

class SindromesGeriatricosRepository extends RepositoryBase {


    public function __construct(protected SindromesGeriatricos $sindromesGeriatricos)
    {
        parent::__construct($this->sindromesGeriatricos);
    }

    public function actualizarOcrearSindrome(array $data)
{
    $attributes = [
        'consulta_id' => $data['consulta_id'],
    ];
    return $this->sindromesGeriatricos->updateOrCreate($attributes, $data);
}


}
