<?php

namespace App\Http\Modules\Oncologia\AdjuntosOncologicos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosOncologico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ruta',
        'toma_procedimiento_id',
    ];
}
