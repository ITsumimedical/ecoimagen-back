<?php

namespace App\Http\Modules\Historia\AntecedentesTransfusionales\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedenteTransfusionale extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    protected $fillable = [
        'tipo_transfusion', 'fecha_transfusional', 'causa', 'medico_registra', 'consulta_id'
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
