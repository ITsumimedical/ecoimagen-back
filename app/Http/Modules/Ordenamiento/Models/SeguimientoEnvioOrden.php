<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoEnvioOrden extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'seguimiento_envio_ordenes';
    protected $casts = [
        'detalles' => 'array',
    ];

    public function orden(){
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function scopeWhereFiltro($query, $filtro){
        if($filtro){
            $query->where('orden_id', $filtro)
                ->orWhereHas('orden.consulta.afiliado', function($query) use ($filtro) {
                    $query->where('numero_documento', $filtro);
                });
        }
    }

    public function scopeWhereEstado($query, null|int $estado){
        if($estado){
            $query->where('estado', $estado === 1 ? true : false);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
