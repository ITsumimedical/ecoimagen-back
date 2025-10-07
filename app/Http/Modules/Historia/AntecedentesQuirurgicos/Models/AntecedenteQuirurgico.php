<?php

namespace App\Http\Modules\Historia\AntecedentesQuirurgicos\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedenteQuirurgico extends Model
{
    use HasFactory;

    protected $fillable = [
        'cirugia', 'a_que_edad', 'medico_registra', 'consulta_id', 'no_tiene_antecedente', 'observaciones'
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
