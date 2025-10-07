<?php

namespace App\Http\Modules\Inicio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Inicio\Models\Boletines;

class BoletinesRepository extends RepositoryBase
{

    public function __construct(protected Boletines $boletinesModel)
    {
        parent::__construct($this->boletinesModel);
    }

    public function listarTodos()
    {
        return $this->boletinesModel->with(["cargadoPor.operador"])->orderBy("id", "ASC")->get();
    }

    public function crearBoletin($request)
    {
        $boletin = new Boletines();
        $boletin->nombre = $request['nombre'];
        $boletin->descripcion = $request['descripcion'];
        $boletin->url = $request['url'];
        $boletin->cargado_por = auth()->user()->id;

        $boletin->save();

        return $boletin;
    }

    public function cambiarEstadoBoletin($boletin_id)
    {
        $boletin = Boletines::find($boletin_id);
        $boletin->activo = !$boletin->activo;
        $boletin->save();
    }

    public function buscarBoletin($boletin_id)
    {
        return Boletines::find($boletin_id);
    }

    public function actualizarBoletin($boletin_id, $request)
    {
        $boletin = Boletines::find($boletin_id);

        $boletin->nombre = $request['nombre'];
        $boletin->descripcion = $request['descripcion'];
        $boletin->url = $request['url'];
        $boletin->save();
    }

    public function listarActivos()
    {
        return $this->boletinesModel->with(["cargadoPor.operador"])->where('activo', true)->orderBy("id", "ASC")->get();
    }
}
