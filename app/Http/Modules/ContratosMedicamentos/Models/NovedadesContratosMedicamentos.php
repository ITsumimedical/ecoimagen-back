<?php

namespace App\Http\Modules\ContratosMedicamentos\Models;

use App\Http\Modules\Tipos\Models\Tipo;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NovedadesContratosMedicamentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_medicamentos_id',
        'tipo_id',
        'observaciones',
        'user_id'
    ];

    public function contrato(): BelongsTo
    {
        return $this->belongsTo(ContratosMedicamentos::class, 'contrato_medicamentos_id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function adjuntos(): HasMany
    {
        return $this->hasMany(AdjuntosContratosMedicamentos::class, 'novedad_contrato_medicamentos_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
