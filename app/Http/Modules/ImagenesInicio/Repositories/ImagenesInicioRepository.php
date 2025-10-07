<?php

namespace App\Http\Modules\ImagenesInicio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ImagenesInicio\Models\ImagenesInicio;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ImagenesInicioRepository extends RepositoryBase {

    use ArchivosTrait;

    public function __construct(protected ImagenesInicio $imagenesModel)
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
