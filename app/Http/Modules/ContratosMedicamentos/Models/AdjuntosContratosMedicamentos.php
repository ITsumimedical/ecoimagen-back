<?php

namespace App\Http\Modules\ContratosMedicamentos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdjuntosContratosMedicamentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'novedad_contrato_medicamentos_id',
        'ruta',
        'nombre',
    ];

    public function novedad(): BelongsTo
    {
        return $this->belongsTo(NovedadesContratosMedicamentos::class, 'novedad_contrato_medicamentos_id');
    }
}
