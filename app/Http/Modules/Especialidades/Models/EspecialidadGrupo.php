<?php

namespace App\Http\Modules\Especialidades\Models;

use App\Http\Modules\Grupos\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EspecialidadGrupo extends Model
{
    use HasFactory;

    protected $table = 'especialidad_grupos';

    protected $fillable = [
        'especialidad_id',
        'grupo_id',
    ];

    public function especialidad(): BelongsTo
    {
        return $this->belongsTo(Especialidade::class, 'especialidad_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
