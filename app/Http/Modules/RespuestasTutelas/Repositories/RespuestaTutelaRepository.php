<?php

namespace App\Http\Modules\RespuestasTutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RespuestasTutelas\Models\RespuestaTutela;
use App\Http\Modules\Tutelas\Models\AdjuntoTutela;
use Illuminate\Support\Facades\DB;

class RespuestaTutelaRepository extends RepositoryBase{

    protected $respuestaTutelaModel;

    function __construct(){
        $this->respuestaTutelaModel = new RespuestaTutela();
        parent::__construct($this->respuestaTutelaModel);
    }

    public function listarRespuestas($data){
        $respuestas = RespuestaTutela::select(
            'respuesta_tutelas.*',  DB::raw("TO_CHAR(respuesta_tutelas.created_at,'yyyy-MM-dd HH:MI:SSPM') as fecha_creacion")
        )->with('adjuntosTutelas')->where('actuacion_tutela_id', $data['actuacion_tutela_id'])->get();

        return $respuestas;
    }

    public function consultarAdjuntos($data){
        return AdjuntoTutela::where('respuesta_id', $data->respuesta_id)->get();
    }
}
