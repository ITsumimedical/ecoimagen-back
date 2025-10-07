<?php

namespace App\Http\Modules\RepresentanteLegal\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RepresentanteLegal\Models\RepresentanteLegal;

class RepresentanteLegalRepository extends RepositoryBase {

    public function __construct(protected RepresentanteLegal $representanteLegalModel) {
        parent::__construct($this->representanteLegalModel);
    }



}
