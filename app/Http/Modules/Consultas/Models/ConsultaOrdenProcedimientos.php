<?php

namespace App\Http\Modules\Consultas\Models;

use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultaOrdenProcedimientos extends Model
{
    use HasFactory;

    protected $fillable = ['orden_procedimiento_id', 'consulta_id', 'orden_codigo_propio_id', 'cantidad_usada', 'user_id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function ordenProcedimiento(): BelongsTo
    {
        return $this->belongsTo(OrdenProcedimiento::class, 'orden_procedimiento_id');
    }
}
