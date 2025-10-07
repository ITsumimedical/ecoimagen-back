<?php

namespace App\Http\Modules\Historia\Vacunacion\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacuna extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacuna', 'dosis', 'laboratorio', 'fecha_dosis', 'medico_registra', 'consulta_id','otra', 'no_tiene_antecedente'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'medico_registra');
    }
}
