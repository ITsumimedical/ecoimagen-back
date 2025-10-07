<?php

namespace App\Http\Modules\Zonas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado'
    ];

}
