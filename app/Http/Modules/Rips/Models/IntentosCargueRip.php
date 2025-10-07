<?php

namespace App\Http\Modules\Rips\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntentosCargueRip extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_paquete',
        'codigo',
        'user_id',
    ];
}
