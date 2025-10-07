<?php

namespace App\Http\Modules\ContratosMedicamentos\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TarifasContratosMedicamentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_medicamentos_id',
        'rep_id',
        'manual_tarifario_id',
        'estado_id',
        'creado_por',
    ];

    public function contrato(): BelongsTo
    {
        return $this->belongsTo(ContratosMedicamentos::class, 'contrato_medicamentos_id');
    }

    public function rep(): BelongsTo
    {
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    public function manualTarifario(): BelongsTo
    {
        return $this->belongsTo(ManualTarifario::class, 'manual_tarifario_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
