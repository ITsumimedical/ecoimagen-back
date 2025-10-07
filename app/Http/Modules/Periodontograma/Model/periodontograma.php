<?php

namespace App\Http\Modules\Periodontograma\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periodontograma extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id','diente','diente_tipo','oclusal','mesial','distal','vestibular','palatino','requiere_endodoncia','requiere_sellante','endodocia_presente'];
}


