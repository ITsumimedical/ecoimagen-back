<?php

namespace App\Http\Modules\ActuacionTutelas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExclusionActuacionTutela extends Model
{
    use HasFactory;
    protected $fillable = [
        'actuacion_tutela_id',
        'user_id',
        'exclusion'
    ];

    protected $table = 'exclusion_actuacion_tutela';
}
