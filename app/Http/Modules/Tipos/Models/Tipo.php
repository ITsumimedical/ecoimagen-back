<?php

namespace App\Http\Modules\Tipos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','activo'];
}
