<?php

namespace App\Http\Modules\ImagenesSoporte\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ImagenesSoporte\Models\ImagenesSoporte;

class ImagenesSoporteRepository extends RepositoryBase {



    public function __construct(protected ImagenesSoporte $imagenesModel)
    {
        parent::__construct($this->imagenesModel);
    }

    public function listarTodos()
    {
        return $this->imagenesModel->with(["createdBy.operador"])->orderBy("id", "ASC")->get();
    }

    public function listarActivos()
    {
        return $this->imagenesModel->with(["createdBy.operador"])->where("activo", true)->orderBy("id", "ASC")->get();
    }

}
