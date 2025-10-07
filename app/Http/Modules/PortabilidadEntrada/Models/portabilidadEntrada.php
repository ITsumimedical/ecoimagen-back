<?php

namespace App\Http\Modules\PortabilidadEntrada\Models;

use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class portabilidadEntrada extends Model
{
    use SoftDeletes;

    protected $fillable = ['origen_ips','telefono_ips','correo_ips','fecha_inicio','fecha_final','estado_id','user_id', 'cantidad_dias'];

    public function novedadAfiliado() {
        return $this->hasMany(novedadAfiliado::class,'portabilidad_entrada_id');
    }

    public function scopeWhereDocumento($query, $documento){
        if($documento){
            return $query->where('numero_documento',$documento);
        }
    }

}
