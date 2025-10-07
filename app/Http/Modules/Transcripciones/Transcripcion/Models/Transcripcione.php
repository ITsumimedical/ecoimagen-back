<?php

namespace App\Http\Modules\Transcripciones\Transcripcion\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Sedes\Models\Sede;
use App\Http\Modules\Transcripciones\Adjunto\Models\AdjuntoTranscripcione;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcripcione extends Model
{
    protected $fillable = ['afiliado_id', 'ambito', 'medico_ordeno', 'finalidad', 'prestador_id', 'observaciones', 'tipo_transcripcion', 'sede_id', 'consulta_id', 'nombre_medico_ordeno', 'documento_medico_ordeno'];

    use HasFactory;

    public function cie10s()
    {
        return $this->belongsToMany(Cie10::class, 'cie10_transcripciones');
    }

    public function adjuntos()
    {
        return $this->belongsTo(AdjuntoTranscripcione::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function prestador()
    {
        return $this->belongsTo(Prestador::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
