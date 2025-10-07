<?php

namespace App\Http\Modules\LogsKeiron\models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsKeiron extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealId',
        'status',
        'email',
        'nombre_afiliado',
        'consulta_id',
        'transition_id',
        'fecha_consulta',
        'errores',
        'log_payload'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}


