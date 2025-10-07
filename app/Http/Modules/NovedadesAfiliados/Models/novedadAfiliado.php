<?php

namespace App\Http\Modules\NovedadesAfiliados\Models;

use App\Http\Modules\TiposNovedadAfiliados\Controllers\TipoNovedadAfiliadosController;
use App\Http\Modules\TiposNovedadAfiliados\Models\tipoNovedadAfiliados;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\PortabilidadEntrada\Models\portabilidadEntrada;
use App\Http\Modules\PortabilidadSalida\Models\portabilidadSalida;
use App\Http\Modules\TiposNovedades\Models\tipoNovedad;

class novedadAfiliado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fecha_novedad',
        'motivo',
        'afiliado_id',
        'user_id',
        'tipo_novedad_afiliados_id',
        'portabilidad_entrada_id',
        'portabilidad_salida_id',
        'estado'
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function tipoNovedad()
    {
        return $this->belongsTo(tipoNovedadAfiliados::class, 'tipo_novedad_afiliados_id');
    }

    public function portabilidadSalida()
    {
        return $this->belongsTo(portabilidadSalida::class, 'portabilidad_salida_id');
    }

    public function portabilidadEntrada()
    {
        return $this->belongsTo(portabilidadEntrada::class, 'portabilidad_entrada_id');
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntosNovedadAfiliados::class, 'novedad_afiliado_id');
    }
}
