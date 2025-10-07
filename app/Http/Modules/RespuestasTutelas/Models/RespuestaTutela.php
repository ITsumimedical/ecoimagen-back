<?php

namespace App\Http\Modules\RespuestasTutelas\Models;

use App\Http\Modules\Tutelas\Models\AdjuntoTutela;
use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespuestaTutela extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'respuesta','actuacion_tutela_id','user_id', 'tipo_respuesta'
    ];

    public function tutela(){
        return $this->belongsTo(Tutela::class, 'tutela_id');
    }

    public function adjuntosTutelas()
    {
        return $this->hasMany(AdjuntoTutela::class, 'respuesta_id');
    }

}
