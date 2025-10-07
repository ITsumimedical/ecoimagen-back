<?php

namespace App\Http\Modules\Caracterizacion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaCaracterizacion extends Model
{
    protected $fillable = [
        'user_id',
        'caracterizacion_id',
        'cambios_anteriores',
    ];

}
