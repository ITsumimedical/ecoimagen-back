<?php

namespace App\Http\Modules\Telesalud\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEstrategiaTelesalud extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];
}
