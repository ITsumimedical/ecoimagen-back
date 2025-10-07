<?php

namespace App\Http\Modules\Cac\Models;

use App\Http\Modules\Especialidades\Models\Especialidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PatologiasCac extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'clave',
        'activo',
    ];

    public function especialidades(): BelongsToMany
    {
        return $this->belongsToMany(Especialidade::class, 'patologias_cac_especialidads', 'patologia_cac_id', 'especialidad_id');
    }
}
