<?php

namespace App\Http\Modules\TipoRCVCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRCVCaracterizacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_rcv_caracterizacions';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_rcv', 'tipo_rcv_id', 'caracterizacion_id');
    }
}
