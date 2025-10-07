<?php

namespace App\Http\Modules\Oncologia\Organos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Oncologia\Organos\Models\Organo;

class OrganoRepository extends RepositoryBase {

    protected $organoModel;

    public function __construct(Organo $organoModel) {
        $this->organoModel = $organoModel;
        parent::__construct($this->organoModel);
    }

}
