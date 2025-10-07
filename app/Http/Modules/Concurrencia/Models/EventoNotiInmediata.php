<?php

namespace App\Http\Modules\Concurrencia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoNotiInmediata extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['evento', 'descripciones', 'ingreso_concurrencia_id'];
}
