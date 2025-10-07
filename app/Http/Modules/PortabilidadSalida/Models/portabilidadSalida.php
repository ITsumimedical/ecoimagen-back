<?php

namespace App\Http\Modules\PortabilidadSalida\Models;

use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class portabilidadSalida extends Model
{
    use SoftDeletes;

    protected $fillable = ['fecha_inicio','fecha_final','destino_ips','motivo','departamento_receptor','municipio_receptor','estado_id','user_id', 'cantidad'];

    public function novedadAfiliado() {
        return $this->hasMany(novedadAfiliado::class,'portabilidad_salida_id');
    }

    public function scopeWhereDocumento($query, $documento){
        if($documento){
            return $query->where('numero_documento',$documento);
        }
    }


}
