<?php

namespace App\Http\Modules\Caracterizacion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfiliadoIntegranteFamilia extends Model
{
    use HasFactory;

    protected $fillable = [
        'afiliado_id',
        'integrante_id',
    ];
}
