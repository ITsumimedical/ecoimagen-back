<?php

namespace App\Http\Modules\Cups\Models;

use App\Http\Modules\Entidad\Models\Entidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CupEntidad extends Model
{
    use HasFactory;

    protected $table = 'cup_entidad';

    protected $fillable = [
        'cup_id',
        'entidad_id',
        'diagnostico_requerido',
        'nivel_ordenamiento',
        'nivel_portabilidad',
        'requiere_auditoria',
        'periodicidad',
        'cantidad_max_ordenamiento',
        'copago',
        'moderadora'
    ];

    public function cup(): BelongsTo
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }

    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }
}
