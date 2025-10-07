<?php

namespace App\Http\Modules\Cie10\Models;

use App\Http\Modules\Epidemiologia\Models\CabeceraSivigila;
use App\Http\Modules\Epidemiologia\Models\EventoSivigila;
use App\Http\Modules\Epidemiologia\Models\RegistroSivigila;
use App\http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\Teleapoyo\Models\Teleapoyo;
use App\Http\Modules\TiposCancer\Model\TipoCancer;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cie10 extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = [
        'Codigo_Nombre'
    ];

    public function teleapoyo()
    {
        return $this->belongsToMany(Teleapoyo::class);
    }

    public function referencia()
    {
        return $this->belongsToMany(Referencia::class, 'cie10_referencia')->withTimestamps();
    }

    public function transcripcion()
    {
        return $this->belongsToMany(Transcripcione::class, 'cie10_transcripciones');
    }

    public function eventoSivigila(){
        return $this->belongsTo(EventoSivigila::class, 'evento_id');
    }

    public function resgistroSivigila(){
        return $this->hasMany(RegistroSivigila::class, 'cie10_id');
    }

    /**
     * Concatena el codigo con el nombre
     * @return string
     */
    public function getCodigoNombreAttribute()
    {
        return "{$this->codigo_cie10} - {$this->nombre} ";
    }


    public function scopeBuscarCie10($query, $data)
    {
        return $query->where(function ($q) use ($data) {
            $q->where('nombre', 'ILIKE', "%{$data}%")
              ->orWhere('codigo_cie10', 'ILIKE', "%{$data}%");
        });
    }

    public function tipoCancer()
    {
        return $this->belongsToMany(TipoCancer::class, 'diagnosticos_tipo_cancer', 'cie10_id', 'tipo_cancer_id')->withTimestamps();
    }

}
