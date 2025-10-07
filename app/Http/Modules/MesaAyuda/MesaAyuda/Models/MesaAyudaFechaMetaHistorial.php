<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MesaAyudaFechaMetaHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesa_ayuda_id',
        'fecha_anterior',
        'fecha_nueva',
        'modificado_por',
        'motivo',
    ];

    public function mesaAyuda(): BelongsTo
    {
        return $this->belongsTo(MesaAyuda::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modificado_por');
    }
}
