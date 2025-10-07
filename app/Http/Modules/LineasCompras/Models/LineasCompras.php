<?php

namespace App\Http\Modules\LineasCompras\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineasCompras extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado'
    ];
}
