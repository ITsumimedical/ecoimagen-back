<?php

namespace App\Http\Modules\TipoArchivo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArchivo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','activo'];
}
