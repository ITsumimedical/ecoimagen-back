<?php

namespace App\Http\Modules\EstadoAnimoComportamiento\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAnimoComportamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado_animo',
        'comportamiento',
        'actividades_basicas',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
