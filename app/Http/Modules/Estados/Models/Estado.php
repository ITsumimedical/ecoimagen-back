<?php

namespace App\Http\Modules\Estados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nombre',
        'descripcion'
    ];
}
