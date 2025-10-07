<?php

namespace App\Http\Modules\TipoConsultas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','activo'];
}
