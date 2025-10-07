<?php

namespace App\Http\Modules\Historia\Antecedentes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    use HasFactory;

    protected $fillable = [
        'antecedentes', 'descripcion', 'medico_registra', 'consulta_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];
}
