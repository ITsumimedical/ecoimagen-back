<?php

namespace App\Http\Modules\Transcripciones\Adjunto\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Transcripciones\Adjunto\Models\AdjuntoTranscripcione;

class AdjuntoTranscripcionRepository extends RepositoryBase {

    protected $adjuntoTransncripcionModel;

    public function __construct() {
        $this->adjuntoTransncripcionModel = new AdjuntoTranscripcione();
        parent::__construct($this->adjuntoTransncripcionModel);
    }

    public function buscarAdjuntos($afiliado_id){
        return $this->adjuntoTransncripcionModel->select('adjunto_transcripciones.nombre','adjunto_transcripciones.ruta','adjunto_transcripciones.created_at')
        ->join('consultas','consultas.id','adjunto_transcripciones.consulta_id')
        ->join('afiliados','afiliados.id','consultas.afiliado_id')
        ->where('afiliados.id',$afiliado_id)->get();
    }
}
