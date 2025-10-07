<?php

namespace App\Http\Modules\Georeferenciacion\Repositories;

use App\Http\Modules\Georeferenciacion\Models\Georeferenciacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;

class GeoreferenciaRepository extends RepositoryBase
{
    protected $georeferenciaModel;

    public function __construct(Georeferenciacion $georeferenciaModel){
        parent::__construct($georeferenciaModel);
        $this->georeferenciaModel = $georeferenciaModel;
    }

    public function listarGeoreferencia($request){
        $consulta = $this->georeferenciaModel->select(
            'georeferenciacions.zona_id',
            'georeferenciacions.entidad_id',
            'georeferenciacions.municipio_id',
            'georeferenciacions.id as geo_id',
            'zonas.nombre as zonas',
            'entidades.nombre as entidad',
            'municipios.nombre as municipio',
            'departamentos.nombre as departamento'
        )
            ->join('zonas', 'georeferenciacions.zona_id', 'zonas.id')
            ->join('municipios','municipios.id','georeferenciacions.municipio_id')
            ->join('departamentos','departamentos.id','municipios.departamento_id')
            ->join('entidades','entidades.id','georeferenciacions.entidad_id')
            ->selectRaw("CONCAT(georeferenciacions.zona_id,' (',entidades.nombre,'/',municipios.nombre,'-',departamentos.nombre,')') as nombre_georeferencia")
            ->orderBy('georeferenciacions.id', 'desc');

        return $consulta->get();
    }

    public function crearGeoreferencia($datos)
    {
        $datos['user_id'] = Auth::id();
        $crearGeoreferencia = Georeferenciacion::create([
            'zona_id' => $datos['zona_id'],
            'entidad_id' => $datos['entidad_id'],
            'municipio_id' => $datos['municipio_id'],
            'user_id'=> $datos['user_id'],
        ]);
        return $crearGeoreferencia;
    }

    public function actualizarGeorreferenciacion(array $data)
    {
        $consulta = Georeferenciacion::where('id', $data['geo_id'])->first();
        return $consulta->update($data);
    }

}
