<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliares\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteFamiliare extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];


    protected $fillable = [
        'cie10_id', 'parentesco', 'edad', 'fallecido', 'medico_registra', 'consulta_id', 'no_tiene_antecedentes'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'medico_registra');
    }
}
