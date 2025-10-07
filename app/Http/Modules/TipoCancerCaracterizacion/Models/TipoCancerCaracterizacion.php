<?php

namespace App\Http\Modules\TipoCancerCaracterizacion\Models;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCancerCaracterizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function caracterizacion()
    {
        return $this->belongsToMany(CaracterizacionAfiliado::class, 'caracterizacion_cancer', 'tipo_cancer_id', 'caracterizacion_id');
    }
}
