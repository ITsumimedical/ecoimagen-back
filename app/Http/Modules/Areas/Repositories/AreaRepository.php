<?php

namespace App\Http\Modules\Areas\Repositories;

use App\Http\Modules\Areas\Models\Area;
use App\Http\Modules\Base\RepositoryBase;

class AreaRepository extends RepositoryBase
{
    protected $areaModel;

    public function __construct(){
        $this->areaModel = new Area();
        parent::__construct($this->areaModel);
    }


}
