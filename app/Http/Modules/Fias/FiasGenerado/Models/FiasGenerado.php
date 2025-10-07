<?php

namespace App\Http\Modules\Fias\FiasGenerado\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiasGenerado extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_fias', 'ruta', 'mes', 'anio', 'user_id'];
}
