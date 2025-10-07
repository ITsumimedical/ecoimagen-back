<?php

namespace App\Http\Modules\CodigoServicio\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoServicio extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'estado_id'];
}
