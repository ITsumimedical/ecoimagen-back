<?php

namespace App\Http\Modules\Transcripciones\Adjunto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoTranscripcione extends Model
{
    protected $fillable = ['nombre', 'ruta', 'consulta_id'];

    use HasFactory;
}
