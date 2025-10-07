<?php

namespace App\Http\Modules\ParametrizacionRemisionProgramas\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametrizacionRemisionProgramas extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'edad_inicial', 'edad_final', 'sexo','estado'];
}
