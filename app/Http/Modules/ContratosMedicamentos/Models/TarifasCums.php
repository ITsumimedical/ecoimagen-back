<?php

namespace App\Http\Modules\ContratosMedicamentos\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifasCums extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tarifa_id',
        'cum_validacion',
        'precio',
        'creado_por',
    ];

    public function creado_por(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
