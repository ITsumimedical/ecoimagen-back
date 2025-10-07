<?php

namespace App\Http\Modules\Tutelas\Models;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Juzgados\Models\Juzgado;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutela extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'radicado',
        'fecha_radica',
        'dias',
        'fecha_cerrada',
        'observacion',
        'quien_creo_id',
        'afiliado_id',
        'municipio_id',
        'juzgado_id',
        'estado_id',
        'radicado_corto'
    ];

    protected $casts = [
        'municipio_id' => 'integer',
    ];

    protected $table = 'tutelas';

    public function afiliado(){
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function juzgado(){
        return $this->belongsTo(Juzgado::class, 'juzgado_id');
    }
    public function actuaciones(){
        return $this->hasMany(actuacionTutelas::class);
    }

    public function scopeWhereAfiliado($query, $afiliado_id){
        if($afiliado_id){
            return $query->where('afiliado_id', $afiliado_id);
        }
    }

    public function scopeWhereRadicado($query, $radicado){
        if($radicado){
            return $query->where('radicado', $radicado);
        }
    }

    // public function tipoServicios(){
    //     return $this->belongsTo(TipoServicioTutela::class, 'tutela_id');
    // }

    // public function exclusiones(){
    //     return $this->belongsTo(ExclusionesTutela::class, 'tutela_id');
    // }

    // public function respuesta(){
    //     return $this->hasMany(RespuestaTutela::class, 'tutela_id');
    // }

    // public function adjunto(){
    //     return $this->hasMany(AdjuntoTutela::class, 'tutela_id');
    // }

    // public function estado(){
    //     return $this->belongsTo(Estado::class, 'estado_id');
    // }

}
