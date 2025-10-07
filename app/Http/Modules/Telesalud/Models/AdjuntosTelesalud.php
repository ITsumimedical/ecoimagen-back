<?php

namespace App\Http\Modules\Telesalud\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosTelesalud extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ruta',
        'gestion_telesalud_id',
    ];
}
